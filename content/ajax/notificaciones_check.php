<?php
if (!isset($_SESSION)) {
    session_name("LoginSIRC");
    session_start();
}
header("Content-Type: application/json; charset=utf-8");

require_once(dirname(__FILE__) . '/../../Connections/snet.php');

if (!isset($_SESSION['user'])) {
    echo json_encode(array("status" => "unauthenticated", "total" => 0, "items" => array()));
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

// Construcción de condiciones del destinatario
$condDestino = " (
    (fun_destino != '' AND fun_destino IS NOT NULL AND TRIM(fun_destino) = '$fun_esc')
    OR (TRIM(fun_destino) = 'Todos' AND (dep_destino = '$dep_esc' OR dep_destino LIKE '%$dep_esc%' OR cod_depderivador = '$cod_dep_esc'))
    OR (dep_destino = '$dep_esc' AND (fun_destino = '' OR fun_destino IS NULL OR fun_destino = 'A quien Corresponda'))
) ";

$whereBase = " (entradas_id = 0 OR fecha_recibidoHR IS NULL OR fecha_recibidoHR = '' OR fecha_recibidoHR = '0000-00-00 00:00:00') AND $condDestino ";

// 1. Total pendientes
$sqlCount = "SELECT COUNT(*) as total FROM derivacion WHERE $whereBase";
$resCount = mysql_query($sqlCount, $snet);
$total = 0;
if ($resCount && ($rowCount = mysql_fetch_assoc($resCount))) {
    $total = intval($rowCount['total']);
}

// 2. Últimos 5 pendientes para el desplegable
$sqlList = "SELECT id, hojaruta_cod, fun_destino, dep_destino, fun_derivador, cod_depderivador, proveido, fecha_derivacion 
            FROM derivacion 
            WHERE $whereBase 
            ORDER BY id DESC LIMIT 5";
$resList = mysql_query($sqlList, $snet);
$items = array();

$now = time();
if ($resList) {
    while($r = mysql_fetch_assoc($resList)) {
        $ts = strtotime($r['fecha_derivacion']);
        $diff = $now - $ts;
        
        if ($diff < 60) {
            $tiempo = "Hace instantes";
        } elseif ($diff < 3600) {
            $m = floor($diff / 60);
            $tiempo = "Hace $m min";
        } elseif ($diff < 86400) {
            $h = floor($diff / 3600);
            $tiempo = "Hace $h hr" . ($h > 1 ? "s" : "");
        } else {
            $d = floor($diff / 86400);
            $tiempo = "Hace $d día" . ($d > 1 ? "s" : "");
        }
        
        $remitente = trim($r['fun_derivador']);
        if (!empty($r['cod_depderivador'])) {
            $remitente .= " (" . trim($r['cod_depderivador']) . ")";
        }
        
        $items[] = array(
            "id" => intval($r['id']),
            "hr" => $r['hojaruta_cod'],
            "remitente" => $remitente,
            "proveido" => !empty($r['proveido']) ? $r['proveido'] : "Derivación",
            "fecha" => $r['fecha_derivacion'],
            "tiempo" => $tiempo
        );
    }
}

echo json_encode(array(
    "status" => "ok",
    "total" => $total,
    "items" => $items
));
