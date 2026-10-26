<?php
if (!isset($_SESSION)) {
    session_name("LoginSIRC");
    session_start();
}
header("Content-Type: application/json; charset=utf-8");

require_once(dirname(__FILE__) . '/../../Connections/snet.php');

if (!isset($_SESSION['user'])) {
    echo json_encode(array(
        "status" => "unauthenticated", 
        "total" => 0, 
        "normal" => 0, 
        "alerta" => 0, 
        "mora" => 0, 
        "items" => array()
    ));
    exit;
}

$fun = isset($_SESSION['fun']) ? trim($_SESSION['fun']) : '';
$dep = isset($_SESSION['dep']) ? trim($_SESSION['dep']) : '';
$cod_dep = isset($_SESSION['cod_dep']) ? trim($_SESSION['cod_dep']) : '';

mysql_select_db($database_snet, $snet);

// Sanitización de parámetros
$fun_esc = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($fun) : addslashes($fun);
$dep_esc = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($dep) : addslashes($dep);
$cod_dep_esc = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($cod_dep) : addslashes($cod_dep);

// 1. Condiciones de destinatario para el usuario o su área
$condDestino = " (
    (d.fun_destino != '' AND d.fun_destino IS NOT NULL AND TRIM(d.fun_destino) = '$fun_esc')
    OR (TRIM(d.fun_destino) = 'Todos' AND (d.dep_destino = '$dep_esc' OR d.dep_destino LIKE '%$dep_esc%' OR d.cod_depderivador = '$cod_dep_esc'))
    OR (d.dep_destino = '$dep_esc' AND (d.fun_destino = '' OR d.fun_destino IS NULL OR d.fun_destino = 'A quien Corresponda'))
) ";

// 2. Exclusión de trámites concluidos o enviados a "Archivo" / "Atendida"
$condExcluirArchivados = " (
    d.proveido NOT LIKE '%archiv%' 
    AND (d.mensaje IS NULL OR d.mensaje NOT LIKE '%archiv%') 
    AND d.proveido NOT LIKE '%atend%' 
    AND (d.mensaje IS NULL OR d.mensaje NOT LIKE '%atend%')
) ";

// 3. Condición de ÚLTIMO DESTINO VIGENTE (el documento no ha sido derivado/soltado a un nro_destino posterior)
$condUltimoDestino = " NOT EXISTS (
    SELECT 1 FROM derivacion d_sig 
    WHERE d_sig.hojaruta_cod = d.hojaruta_cod 
      AND d_sig.nro_destino > d.nro_destino
) ";

$whereBase = " (d.entradas_id = 0 OR d.fecha_recibidoHR IS NULL OR d.fecha_recibidoHR = '' OR d.fecha_recibidoHR = '0000-00-00 00:00:00') 
               AND $condDestino 
               AND $condExcluirArchivados 
               AND $condUltimoDestino ";

// 4. Conteo total con desglose del Semáforo de Mora
$sqlCount = "SELECT 
    COUNT(*) as total,
    SUM(CASE WHEN DATEDIFF(NOW(), d.fecha_derivacion) <= 2 THEN 1 ELSE 0 END) as normal,
    SUM(CASE WHEN DATEDIFF(NOW(), d.fecha_derivacion) BETWEEN 3 AND 5 THEN 1 ELSE 0 END) as alerta,
    SUM(CASE WHEN DATEDIFF(NOW(), d.fecha_derivacion) > 5 THEN 1 ELSE 0 END) as mora
FROM derivacion d 
WHERE $whereBase";

$resCount = mysql_query($sqlCount, $snet);
$total = 0;
$normal = 0;
$alerta = 0;
$mora = 0;

if ($resCount && ($rowCount = mysql_fetch_assoc($resCount))) {
    $total = intval($rowCount['total']);
    $normal = intval($rowCount['normal']);
    $alerta = intval($rowCount['alerta']);
    $mora = intval($rowCount['mora']);
}

// 5. Últimos 5 pendientes vigentes para el desplegable
$sqlList = "SELECT d.id, d.hojaruta_cod, d.nro_destino, d.fun_destino, d.dep_destino, d.fun_derivador, d.cod_depderivador, d.proveido, d.fecha_derivacion 
            FROM derivacion d 
            WHERE $whereBase 
            ORDER BY d.id DESC LIMIT 50";
$resList = mysql_query($sqlList, $snet);
$items = array();

$now = time();
if ($resList) {
    while($r = mysql_fetch_assoc($resList)) {
        $ts = strtotime($r['fecha_derivacion']);
        $diff = max(0, $now - $ts);
        $diff_dias = floor($diff / 86400);

        // Reglas del Semáforo
        if ($diff_dias <= 2) {
            $estado_semaforo = "normal";
            $color_semaforo = "#10b981"; // Verde
            $badge_semaforo = "En Plazo";
        } elseif ($diff_dias <= 5) {
            $estado_semaforo = "alerta";
            $color_semaforo = "#f59e0b"; // Amarillo
            $badge_semaforo = "Prioritario";
        } else {
            $estado_semaforo = "mora";
            $color_semaforo = "#ef4444"; // Rojo
            $badge_semaforo = "En Mora";
        }
        
        // Formateo de tiempo amigable
        if ($diff < 60) {
            $tiempo = "Hace instantes";
        } elseif ($diff < 3600) {
            $m = floor($diff / 60);
            $tiempo = "Hace $m min";
        } elseif ($diff < 86400) {
            $h = floor($diff / 3600);
            $tiempo = "Hace $h hr" . ($h > 1 ? "s" : "");
        } else {
            $d = $diff_dias;
            $tiempo = "Hace $d día" . ($d > 1 ? "s" : "");
        }
        
        $remitente = trim($r['fun_derivador']);
        if (!empty($r['cod_depderivador'])) {
            $remitente .= " (" . trim($r['cod_depderivador']) . ")";
        }
        
        $items[] = array(
            "id" => intval($r['id']),
            "hr" => $r['hojaruta_cod'],
            "nro_destino" => intval($r['nro_destino']),
            "remitente" => $remitente,
            "proveido" => !empty($r['proveido']) ? $r['proveido'] : "Derivación",
            "fecha" => $r['fecha_derivacion'],
            "tiempo" => $tiempo,
            "dias" => intval($diff_dias),
            "estado_semaforo" => $estado_semaforo,
            "color_semaforo" => $color_semaforo,
            "badge_semaforo" => $badge_semaforo
        );
    }
}

echo json_encode(array(
    "status" => "ok",
    "total" => $total,
    "normal" => $normal,
    "alerta" => $alerta,
    "mora" => $mora,
    "items" => $items
));
