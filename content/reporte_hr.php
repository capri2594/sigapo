<?php
require_once('../Connections/snet.php');

if (!function_exists("GetSQLValueString")) {
    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
        $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
        $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

        switch ($theType) {
            case "text":
                $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
                break;    
            case "long":
            case "int":
                $theValue = ($theValue != "") ? intval($theValue) : "NULL";
                break;
            case "double":
                $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
                break;
            case "date":
                $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
                break;
            case "defined":
                $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
                break;
        }
        return $theValue;
    }
}

function formatearDuracion($segundos) {
    if ($segundos < 0) return '0 min';
    if ($segundos < 60) return '< 1 min';
    
    $minutos = floor($segundos / 60);
    $horas = floor($minutos / 60);
    $dias = floor($horas / 24);
    
    $restoHoras = $horas % 24;
    $restoMinutos = $minutos % 60;
    
    if ($dias > 0) {
        if ($restoHoras > 0) return "{$dias}d {$restoHoras}h";
        return "{$dias} día" . ($dias > 1 ? 's' : '');
    }
    if ($horas > 0) {
        if ($restoMinutos > 0) return "{$horas}h {$restoMinutos}m";
        return "{$horas} hora" . ($horas > 1 ? 's' : '');
    }
    return "{$minutos} min";
}

function formatearFechaLimpia($fechaStr) {
    if (empty($fechaStr) || $fechaStr == '0000-00-00 00:00:00' || $fechaStr == '0000-00-00') {
        return 'Pendiente';
    }
    $ts = strtotime($fechaStr);
    if (!$ts) return $fechaStr;
    
    $meses = array(1=>'Ene', 2=>'Feb', 3=>'Mar', 4=>'Abr', 5=>'May', 6=>'Jun', 7=>'Jul', 8=>'Ago', 9=>'Sep', 10=>'Oct', 11=>'Nov', 12=>'Dic');
    $dia = date('d', $ts);
    $mes = $meses[(int)date('m', $ts)];
    $ano = date('Y', $ts);
    $hora = date('H:i', $ts);
    
    return "$dia $mes $ano, $hora";
}

$codigo_obtener_hr = "-1";
if (isset($_GET['cod'])) {
    $codigo_obtener_hr = trim($_GET['cod']);
}

mysql_select_db($database_snet, $snet);

// 1. Obtener datos de la Hoja de Ruta
$query_obtener_hr = sprintf("SELECT * FROM hojaruta WHERE hojaruta.cod=%s", GetSQLValueString($codigo_obtener_hr, "text"));
$obtener_hr = mysql_query($query_obtener_hr, $snet) or die(mysql_error());
$row_obtener_hr = mysql_fetch_assoc($obtener_hr);
$totalRows_obtener_hr = mysql_num_rows($obtener_hr);

// 2. Obtener todas las derivaciones históricas en orden
$query_ob_derivaciones = sprintf("SELECT * FROM derivacion WHERE derivacion.hojaruta_cod=%s ORDER BY derivacion.nro_destino ASC", GetSQLValueString($codigo_obtener_hr, "text"));
$ob_derivaciones = mysql_query($query_ob_derivaciones, $snet) or die(mysql_error());

$derivaciones = array();
while ($row = mysql_fetch_assoc($ob_derivaciones)) {
    $derivaciones[] = $row;
}
$totalDerivaciones = count($derivaciones);

// 3. Procesar Hitos del Timeline
$hitos = array();

if ($row_obtener_hr) {
    // Hito 0: Origen y Emisión
    $hitos[] = array(
        'nro' => 1,
        'tipo' => 'origen',
        'titulo' => 'Emisión de Hoja de Ruta',
        'emisor' => $row_obtener_hr['usuario_creador'],
        'procedencia' => $row_obtener_hr['procedencia'],
        'destino_fun' => $row_obtener_hr['primerfun_destino'],
        'destino_dep' => $row_obtener_hr['primer_destino'],
        'fecha' => $row_obtener_hr['fecha_creacion'],
        'proveido' => 'ORIGEN',
        'mensaje' => $row_obtener_hr['ref'],
        'permanencia' => null,
        'recibido' => true,
        'fecha_recibido' => $row_obtener_hr['fecha_creacion'],
        'fun_recibido' => $row_obtener_hr['usuario_creador'],
        'is_ultimo' => ($totalDerivaciones == 0),
        'es_archivo' => false,
        'semaforo' => 'normal',
        'dias_espera' => 0
    );

    $prevFecha = strtotime($row_obtener_hr['fecha_creacion']);

    // Hitos 1...N: Derivaciones
    foreach ($derivaciones as $idx => $d) {
        $fechaDeriv = strtotime($d['fecha_derivacion']);
        $permanenciaSeg = ($fechaDeriv && $prevFecha) ? max(0, $fechaDeriv - $prevFecha) : 0;
        
        $isUltimo = ($idx === $totalDerivaciones - 1);
        
        $proveidoLower = strtolower($d['proveido']);
        $mensajeLower = strtolower($d['mensaje']);
        $esArchivo = (strpos($proveidoLower, 'archiv') !== false || strpos($mensajeLower, 'archiv') !== false || strpos($proveidoLower, 'atend') !== false || strpos($mensajeLower, 'atend') !== false);
        
        $recibido = ($d['entradas_id'] > 0 || (!empty($d['fecha_recibidoHR']) && $d['fecha_recibidoHR'] != '0000-00-00 00:00:00'));
        
        $diasDesdeDeriv = floor((time() - $fechaDeriv) / 86400);
        $semaforo = 'normal';
        if ($diasDesdeDeriv >= 3 && $diasDesdeDeriv <= 5) $semaforo = 'alerta';
        if ($diasDesdeDeriv > 5) $semaforo = 'mora';
        
        $hitos[] = array(
            'nro' => $d['nro_destino'],
            'tipo' => $isUltimo ? ($esArchivo ? 'concluido' : 'actual') : 'intermedio',
            'titulo' => "Etapa #" . $d['nro_destino'],
            'emisor' => $d['fun_derivador'],
            'procedencia' => $d['cod_depderivador'],
            'destino_fun' => $d['fun_destino'],
            'destino_dep' => $d['dep_destino'],
            'fecha' => $d['fecha_derivacion'],
            'proveido' => !empty($d['proveido']) ? $d['proveido'] : 'Derivación',
            'mensaje' => $d['mensaje'],
            'permanencia' => formatearDuracion($permanenciaSeg),
            'recibido' => $recibido,
            'fecha_recibido' => $d['fecha_recibidoHR'],
            'fun_recibido' => $d['fun_recibidoHR'],
            'is_ultimo' => $isUltimo,
            'es_archivo' => $esArchivo,
            'semaforo' => $semaforo,
            'dias_espera' => $diasDesdeDeriv
        );
        
        $prevFecha = $fechaDeriv;
    }
}

// Métricas Globales
$tiempoTotalVida = 0;
$estadoGlobal = 'Sin Registro';
$ultimoHito = !empty($hitos) ? $hitos[count($hitos) - 1] : null;

if ($row_obtener_hr) {
    $fechaCreacionTs = strtotime($row_obtener_hr['fecha_creacion']);
    $fechaFinTs = time();
    if ($ultimoHito && $ultimoHito['es_archivo']) {
        $fechaFinTs = strtotime($ultimoHito['fecha']);
    }
    $tiempoTotalVida = formatearDuracion(max(0, $fechaFinTs - $fechaCreacionTs));
    
    if ($ultimoHito && $ultimoHito['es_archivo']) {
        $estadoGlobal = 'Archivado / Concluido';
    } else {
        $estadoGlobal = 'En Proceso Activo';
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Seguimiento Hoja de Ruta: <?php echo htmlspecialchars($codigo_obtener_hr); ?> - SIGAPO</title>
<style type="text/css">
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    background-color: #0b1120;
    color: #cbd5e1;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    font-size: 13px;
    line-height: 1.5;
    padding: 24px;
    -webkit-font-smoothing: antialiased;
}

/* TOP NAVBAR */
.top-navbar {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 12px;
    padding: 14px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
}

.top-navbar-title {
    display: flex;
    align-items: center;
    gap: 12px;
}

.top-navbar-title h1 {
    font-size: 18px;
    font-weight: 700;
    color: #ffffff;
    letter-spacing: 0.5px;
}

.top-navbar-badge {
    background: linear-gradient(135deg, #780016 0%, #a81c33 100%);
    color: #ffffff;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border: 1px solid rgba(190, 18, 60, 0.4);
}

.top-navbar-actions {
    display: flex;
    gap: 10px;
}

.btn-action {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    border: none;
    transition: all 0.2s ease;
    text-decoration: none;
}

.btn-primary {
    background: linear-gradient(135deg, #780016 0%, #a81c33 100%);
    color: #ffffff;
    box-shadow: 0 2px 8px rgba(168, 28, 51, 0.35);
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(168, 28, 51, 0.45);
}

.btn-secondary {
    background: #334155;
    color: #e2e8f0;
    border: 1px solid rgba(255, 255, 255, 0.08);
}

.btn-secondary:hover {
    background: #475569;
    color: #ffffff;
}

.btn-danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: #ffffff;
    box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
}

.btn-danger:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
}

/* HERO SUMMARY CARD */
.hero-card {
    background: #0f172a;
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 24px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
}

.hero-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 20px;
}

.hero-meta-title {
    font-size: 11px;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 4px;
}

.hero-meta-value {
    font-size: 13px;
    color: #f1f5f9;
    font-weight: 500;
    margin-bottom: 12px;
    line-height: 1.4;
}

.hero-meta-value.highlight {
    font-size: 14px;
    color: #fb7185;
    font-weight: 700;
}

.hero-kpis {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
    background: #1e293b;
    padding: 14px;
    border-radius: 10px;
    border: 1px solid rgba(255, 255, 255, 0.05);
}

.kpi-box {
    text-align: center;
    padding: 8px;
    border-radius: 6px;
    background: rgba(15, 23, 42, 0.6);
}

.kpi-label {
    font-size: 10px;
    font-weight: 700;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.kpi-val {
    font-size: 16px;
    font-weight: 800;
    color: #ffffff;
    margin-top: 4px;
}

.kpi-status-activo {
    color: #10b981;
}

.kpi-status-archivo {
    color: #f59e0b;
}

/* CONTROLS BAR: TABS & SEARCH */
.controls-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    gap: 16px;
    flex-wrap: wrap;
}

.view-tabs {
    display: inline-flex;
    background: #1e293b;
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 8px;
    padding: 3px;
}

.tab-btn {
    background: transparent;
    border: none;
    color: #94a3b8;
    padding: 8px 18px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 6px;
}

.tab-btn:hover {
    color: #ffffff;
}

.tab-btn.active {
    background: linear-gradient(135deg, #780016 0%, #a81c33 100%);
    color: #ffffff;
    box-shadow: 0 2px 8px rgba(168, 28, 51, 0.4);
}

.search-box {
    flex-grow: 1;
    max-width: 360px;
    position: relative;
}

.search-input {
    width: 100%;
    background: #1e293b;
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: #f8fafc;
    padding: 8px 14px 8px 36px;
    border-radius: 8px;
    font-size: 12px;
    outline: none;
    transition: all 0.2s;
}

.search-input:focus {
    border-color: #be123c;
    box-shadow: 0 0 0 3px rgba(190, 18, 60, 0.25);
}

.search-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #64748b;
    pointer-events: none;
}

/* =========================================================
   TIMELINE VISUAL (Línea de Tiempo)
   ========================================================= */
.timeline-container {
    position: relative;
    padding: 10px 0 30px 40px;
}

/* Main vertical line */
.timeline-container::before {
    content: '';
    position: absolute;
    left: 19px;
    top: 10px;
    bottom: 20px;
    width: 3px;
    background: linear-gradient(180deg, #be123c 0%, #10b981 60%, #64748b 100%);
    border-radius: 3px;
}

.timeline-step {
    position: relative;
    margin-bottom: 24px;
    transition: all 0.2s ease;
}

.timeline-step.hidden {
    display: none !important;
}

/* Node Icon Marker on line */
.timeline-marker {
    position: absolute;
    left: -40px;
    top: 16px;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #0f172a;
    border: 3px solid #be123c;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 13px;
    color: #ffffff;
    box-shadow: 0 0 0 4px #0b1120, 0 4px 12px rgba(0, 0, 0, 0.5);
    z-index: 2;
    transition: transform 0.2s;
}

.timeline-marker.marker-origen {
    border-color: #be123c;
    background: linear-gradient(135deg, #780016 0%, #a81c33 100%);
}

.timeline-marker.marker-intermedio {
    border-color: #10b981;
    background: linear-gradient(135deg, #065f46 0%, #047857 100%);
}

.timeline-marker.marker-actual-normal {
    border-color: #10b981;
    background: linear-gradient(135deg, #059669 0%, #10b981 100%);
    animation: markerPulseGreen 2s infinite;
}

.timeline-marker.marker-actual-alerta {
    border-color: #f59e0b;
    background: linear-gradient(135deg, #b45309 0%, #f59e0b 100%);
    animation: markerPulseYellow 2s infinite;
}

.timeline-marker.marker-actual-mora {
    border-color: #ef4444;
    background: linear-gradient(135deg, #b91c1c 0%, #ef4444 100%);
    animation: markerPulseRed 1.5s infinite;
}

.timeline-marker.marker-concluido {
    border-color: #eab308;
    background: linear-gradient(135deg, #854d0e 0%, #ca8a04 100%);
}

@keyframes markerPulseGreen {
    0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.6); }
    70% { box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); }
    100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
}

@keyframes markerPulseYellow {
    0% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.6); }
    70% { box-shadow: 0 0 0 10px rgba(245, 158, 11, 0); }
    100% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0); }
}

@keyframes markerPulseRed {
    0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.8); }
    70% { box-shadow: 0 0 0 12px rgba(239, 68, 68, 0); }
    100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
}

/* Card Content */
.timeline-card {
    background: #0f172a;
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 12px;
    padding: 16px 20px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
    position: relative;
    transition: all 0.2s ease;
}

.timeline-card:hover {
    transform: translateY(-2px);
    border-color: rgba(255, 255, 255, 0.16);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
}

.timeline-card.card-actual {
    border: 1px solid rgba(190, 18, 60, 0.4);
    background: linear-gradient(180deg, #131d35 0%, #0f172a 100%);
    box-shadow: 0 0 20px rgba(190, 18, 60, 0.2);
}

.timeline-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid rgba(255, 255, 255, 0.06);
    padding-bottom: 10px;
    margin-bottom: 12px;
    flex-wrap: wrap;
    gap: 8px;
}

.timeline-card-title {
    font-size: 14px;
    font-weight: 700;
    color: #ffffff;
    display: flex;
    align-items: center;
    gap: 8px;
}

.badge-proveido {
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.proveido-urgente {
    background: rgba(239, 68, 68, 0.2);
    color: #f87171;
    border: 1px solid rgba(239, 68, 68, 0.4);
}

.proveido-proceso {
    background: rgba(16, 185, 129, 0.2);
    color: #34d399;
    border: 1px solid rgba(16, 185, 129, 0.4);
}

.proveido-conocimiento {
    background: rgba(190, 18, 60, 0.25);
    color: #fb7185;
    border: 1px solid rgba(190, 18, 60, 0.4);
}

.proveido-archivo {
    background: rgba(245, 158, 11, 0.2);
    color: #fbbf24;
    border: 1px solid rgba(245, 158, 11, 0.4);
}

.timeline-card-date {
    font-size: 12px;
    color: #94a3b8;
    display: flex;
    align-items: center;
    gap: 6px;
}

.badge-permanencia {
    background: #1e293b;
    color: #cbd5e1;
    border: 1px solid rgba(255, 255, 255, 0.08);
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 10px;
    font-weight: 600;
}

/* Actors Row (De -> Para) */
.actors-row {
    display: grid;
    grid-template-columns: 1fr auto 1fr;
    gap: 14px;
    align-items: center;
    margin-bottom: 12px;
    background: rgba(15, 23, 42, 0.5);
    padding: 10px 14px;
    border-radius: 8px;
    border: 1px solid rgba(255, 255, 255, 0.04);
}

.actor-box {
    display: flex;
    flex-direction: column;
}

.actor-role {
    font-size: 10px;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 2px;
}

.actor-name {
    font-size: 12px;
    font-weight: 700;
    color: #ffffff;
}

.actor-dept {
    font-size: 11px;
    color: #94a3b8;
    margin-top: 1px;
}

.actor-arrow {
    color: #be123c;
    font-size: 18px;
    font-weight: 700;
}

/* Message / Instruction Quote Box */
.instruction-box {
    background: #1e293b;
    border-left: 3px solid #be123c;
    padding: 10px 14px;
    border-radius: 0 8px 8px 0;
    margin-bottom: 12px;
}

.instruction-label {
    font-size: 10px;
    font-weight: 700;
    color: #fb7185;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 2px;
}

.instruction-text {
    font-size: 12px;
    color: #f1f5f9;
    font-style: italic;
    white-space: pre-line;
}

/* Footer: Reception Status */
.timeline-card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 8px;
    border-top: 1px solid rgba(255, 255, 255, 0.04);
    font-size: 11px;
    flex-wrap: wrap;
    gap: 8px;
}

.reception-status {
    display: flex;
    align-items: center;
    gap: 6px;
    font-weight: 600;
}

.status-ok {
    color: #10b981;
}

.status-pending {
    color: #f59e0b;
}

.badge-ubicacion-actual {
    background: rgba(190, 18, 60, 0.15);
    color: #fb7185;
    border: 1px solid rgba(190, 18, 60, 0.35);
    padding: 3px 8px;
    border-radius: 4px;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

/* CLASSIC TABLE VIEW */
.classic-table-container {
    display: none;
    background: #0f172a;
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
}

.classic-table {
    width: 100%;
    border-collapse: collapse;
}

.classic-table th {
    background: #1e293b;
    color: #94a3b8;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 12px 14px;
    border-bottom: 2px solid rgba(255, 255, 255, 0.1);
    text-align: left;
}

.classic-table td {
    padding: 12px 14px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    font-size: 12px;
    color: #cbd5e1;
}

.classic-table tr:hover td {
    background: rgba(255, 255, 255, 0.02);
    color: #ffffff;
}

/* =========================================================
   PRINT STYLES (@media print)
   ========================================================= */
@media print {
    body {
        background-color: #ffffff !important;
        color: #000000 !important;
        padding: 0 !important;
    }
    
    .top-navbar-actions, .controls-bar, .search-box {
        display: none !important;
    }
    
    .top-navbar, .hero-card, .timeline-card {
        background: #ffffff !important;
        color: #000000 !important;
        border: 1px solid #cccccc !important;
        box-shadow: none !important;
    }
    
    .hero-kpis {
        background: #f1f5f9 !important;
        border: 1px solid #cccccc !important;
    }
    
    .kpi-val, .hero-meta-value, .actor-name, .instruction-text {
        color: #000000 !important;
    }
    
    .timeline-container::before {
        background: #94a3b8 !important;
    }
    
    .timeline-marker {
        background: #ffffff !important;
        color: #000000 !important;
        border: 2px solid #000000 !important;
        box-shadow: none !important;
    }
}
</style>
<script type="text/javascript">
function switchView(viewMode) {
    var timeline = document.getElementById('timeline_view');
    var classic = document.getElementById('classic_view');
    var btnTimeline = document.getElementById('tab_btn_timeline');
    var btnClassic = document.getElementById('tab_btn_classic');
    
    if (viewMode === 'timeline') {
        timeline.style.display = 'block';
        classic.style.display = 'none';
        btnTimeline.className = 'tab-btn active';
        btnClassic.className = 'tab-btn';
    } else {
        timeline.style.display = 'none';
        classic.style.display = 'block';
        btnTimeline.className = 'tab-btn';
        btnClassic.className = 'tab-btn active';
    }
}

function filtrarTimeline(query) {
    var q = query.toLowerCase().trim();
    var steps = document.querySelectorAll('.timeline-step');
    var rows = document.querySelectorAll('.classic-row');
    var matchCount = 0;
    
    // Filtro Timeline
    for (var i = 0; i < steps.length; i++) {
        var text = steps[i].innerText.toLowerCase();
        if (q === '' || text.indexOf(q) !== -1) {
            steps[i].className = 'timeline-step';
            matchCount++;
        } else {
            steps[i].className = 'timeline-step hidden';
        }
    }
    
    // Filtro Tabla Clásica
    for (var j = 0; j < rows.length; j++) {
        var rowText = rows[j].innerText.toLowerCase();
        if (q === '' || rowText.indexOf(q) !== -1) {
            rows[j].style.display = '';
        } else {
            rows[j].style.display = 'none';
        }
    }
}
</script>
</head>

<body>

<!-- 1. TOP NAVBAR -->
<div class="top-navbar">
    <div class="top-navbar-title">
        <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="#be123c" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
        </svg>
        <h1>Trazabilidad de Hoja de Ruta</h1>
        <span class="top-navbar-badge"><?php echo htmlspecialchars($codigo_obtener_hr); ?></span>
    </div>
    
    <div class="top-navbar-actions">
        <button type="button" class="btn-action btn-secondary" onclick="window.print();">
            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="6 9 6 2 18 2 18 9"></polyline>
                <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                <rect x="6" y="14" width="12" height="8"></rect>
            </svg>
            Imprimir Hoja de Vida
        </button>
        
        <button type="button" class="btn-action btn-primary" onclick="window.location.reload();">
            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="23 4 23 10 17 10"></polyline>
                <polyline points="1 20 1 14 7 14"></polyline>
                <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
            </svg>
            Actualizar
        </button>
        
        <button type="button" class="btn-action btn-danger" onclick="window.close();">
            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
            Cerrar
        </button>
    </div>
</div>

<?php if ($totalRows_obtener_hr > 0): ?>

<!-- 2. HERO SUMMARY CARD -->
<div class="hero-card">
    <div class="hero-grid">
        <div>
            <div class="hero-meta-title">Asunto / Referencia</div>
            <div class="hero-meta-value highlight"><?php echo nl2br(htmlspecialchars($row_obtener_hr['ref'])); ?></div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                <div>
                    <div class="hero-meta-title">Remitente / Procedencia</div>
                    <div class="hero-meta-value"><?php echo htmlspecialchars($row_obtener_hr['procedencia']); ?></div>
                </div>
                <div>
                    <div class="hero-meta-title">Emisión Inicial</div>
                    <div class="hero-meta-value">
                        <?php echo formatearFechaLimpia($row_obtener_hr['fecha_creacion']); ?> 
                        <span style="color:#64748b;">(por <?php echo htmlspecialchars($row_obtener_hr['usuario_creador']); ?>)</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="hero-kpis">
            <div class="kpi-box">
                <div class="kpi-label">Tiempo Total</div>
                <div class="kpi-val"><?php echo $tiempoTotalVida; ?></div>
            </div>
            
            <div class="kpi-box">
                <div class="kpi-label">Total Etapas</div>
                <div class="kpi-val"><?php echo count($hitos); ?></div>
            </div>
            
            <div class="kpi-box" style="grid-column: span 2;">
                <div class="kpi-label">Estado Actual del Trámite</div>
                <div class="kpi-val <?php echo ($ultimoHito && $ultimoHito['es_archivo']) ? 'kpi-status-archivo' : 'kpi-status-activo'; ?>">
                    <?php if ($ultimoHito && $ultimoHito['es_archivo']): ?>
                        🏁 Archivado / Concluido
                    <?php else: ?>
                        📍 En Curso: <?php echo htmlspecialchars($ultimoHito ? $ultimoHito['destino_fun'] : 'Pendiente'); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 3. CONTROLS BAR (TABS & LIVE SEARCH) -->
<div class="controls-bar">
    <div class="view-tabs">
        <button type="button" class="tab-btn active" id="tab_btn_timeline" onclick="switchView('timeline');">
            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <polyline points="12 6 12 12 16 14"></polyline>
            </svg>
            Línea de Tiempo Visual
        </button>
        <button type="button" class="tab-btn" id="tab_btn_classic" onclick="switchView('classic');">
            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="8" y1="6" x2="21" y2="6"></line>
                <line x1="8" y1="12" x2="21" y2="12"></line>
                <line x1="8" y1="18" x2="21" y2="18"></line>
                <line x1="3" y1="6" x2="3.01" y2="6"></line>
                <line x1="3" y1="12" x2="3.01" y2="12"></line>
                <line x1="3" y1="18" x2="3.01" y2="18"></line>
            </svg>
            Vista Clásica (Tabla)
        </button>
    </div>
    
    <div class="search-box">
        <svg class="search-icon" viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
        <input type="text" class="search-input" id="filtro_timeline" placeholder="Filtrar por funcionario, destino o proveído..." onkeyup="filtrarTimeline(this.value);" />
    </div>
</div>

<!-- 4. TIMELINE VIEW -->
<div id="timeline_view" class="timeline-container">
    <?php foreach ($hitos as $idx => $h): 
        $markerClass = 'marker-intermedio';
        if ($h['tipo'] === 'origen') {
            $markerClass = 'marker-origen';
        } else if ($h['is_ultimo']) {
            if ($h['es_archivo']) {
                $markerClass = 'marker-concluido';
            } else {
                $markerClass = 'marker-actual-' . $h['semaforo'];
            }
        }
        
        $proveidoLower = strtolower($h['proveido']);
        $proveidoClass = 'proveido-proceso';
        if (strpos($proveidoLower, 'urgente') !== false) $proveidoClass = 'proveido-urgente';
        else if (strpos($proveidoLower, 'conocimiento') !== false) $proveidoClass = 'proveido-conocimiento';
        else if (strpos($proveidoLower, 'archiv') !== false || strpos($proveidoLower, 'atend') !== false) $proveidoClass = 'proveido-archivo';
    ?>
    <div class="timeline-step">
        <!-- Node Marker -->
        <div class="timeline-marker <?php echo $markerClass; ?>" title="<?php echo $h['titulo']; ?>">
            <?php if ($h['tipo'] === 'origen'): ?>
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                </svg>
            <?php elseif ($h['is_ultimo'] && $h['es_archivo']): ?>
                🏁
            <?php elseif ($h['is_ultimo']): ?>
                📍
            <?php else: ?>
                <?php echo $h['nro']; ?>
            <?php endif; ?>
        </div>
        
        <!-- Step Card -->
        <div class="timeline-card <?php echo ($h['is_ultimo'] && !$h['es_archivo']) ? 'card-actual' : ''; ?>">
            <div class="timeline-card-header">
                <div class="timeline-card-title">
                    <span><?php echo $h['titulo']; ?></span>
                    <span class="badge-proveido <?php echo $proveidoClass; ?>"><?php echo htmlspecialchars($h['proveido']); ?></span>
                    <?php if ($h['is_ultimo'] && !$h['es_archivo']): ?>
                        <span class="badge-ubicacion-actual">📍 Ubicación Actual</span>
                    <?php endif; ?>
                </div>
                
                <div class="timeline-card-date">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    <span><?php echo formatearFechaLimpia($h['fecha']); ?></span>
                    <?php if (!empty($h['permanencia'])): ?>
                        <span class="badge-permanencia" title="Tiempo transcurrido en el paso anterior">⏱️ <?php echo $h['permanencia']; ?></span>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Actors: Remitente -> Destinatario -->
            <div class="actors-row">
                <div class="actor-box">
                    <span class="actor-role"><?php echo ($h['tipo'] === 'origen') ? 'Emisor del Trámite' : 'Derivado Por'; ?></span>
                    <span class="actor-name"><?php echo htmlspecialchars($h['emisor']); ?></span>
                    <span class="actor-dept"><?php echo htmlspecialchars($h['procedencia']); ?></span>
                </div>
                
                <div class="actor-arrow">&rarr;</div>
                
                <div class="actor-box">
                    <span class="actor-role">Destino</span>
                    <span class="actor-name"><?php echo htmlspecialchars($h['destino_fun']); ?></span>
                    <span class="actor-dept"><?php echo htmlspecialchars($h['destino_dep']); ?></span>
                </div>
            </div>
            
            <!-- Message / Remarks -->
            <?php if (!empty($h['mensaje'])): ?>
            <div class="instruction-box">
                <div class="instruction-label">Instrucción / Observación</div>
                <div class="instruction-text"><?php echo htmlspecialchars($h['mensaje']); ?></div>
            </div>
            <?php endif; ?>
            
            <!-- Reception Footer -->
            <div class="timeline-card-footer">
                <div class="reception-status">
                    <?php if ($h['recibido']): ?>
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#10b981" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        <span class="status-ok">Recepcionado en Despacho</span>
                        <?php if (!empty($h['fecha_recibido']) && $h['fecha_recibido'] != '0000-00-00 00:00:00'): ?>
                            <span style="color:#64748b;">(<?php echo formatearFechaLimpia($h['fecha_recibido']); ?>)</span>
                        <?php endif; ?>
                    <?php else: ?>
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#f59e0b" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        <span class="status-pending">Pendiente de Recepción Física</span>
                        <?php if ($h['is_ultimo']): ?>
                            <span style="color:#94a3b8;">&bull; Hace <?php echo $h['dias_espera']; ?> día(s)</span>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                
                <?php if ($h['tipo'] === 'origen'): ?>
                    <span style="color: #64748b;">Hojas: <?php echo htmlspecialchars($row_obtener_hr['nhojas']); ?> | Anexos: <?php echo htmlspecialchars($row_obtener_hr['nanexos']); ?></span>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- 5. CLASSIC TABLE VIEW (FALLBACK / TAB 2) -->
<div id="classic_view" class="classic-table-container">
    <table class="classic-table">
        <thead>
            <tr>
                <th width="40">Etapa</th>
                <th>Remitente / Procedencia</th>
                <th>Destino / Dependencia</th>
                <th>Proveído / Instrucción</th>
                <th>Fecha Derivación</th>
                <th width="120">Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($hitos as $h): ?>
            <tr class="classic-row">
                <td style="font-weight: 700; color: #be123c; text-align: center;"><?php echo $h['nro']; ?></td>
                <td>
                    <strong><?php echo htmlspecialchars($h['emisor']); ?></strong><br />
                    <span style="color:#94a3b8; font-size:11px;"><?php echo htmlspecialchars($h['procedencia']); ?></span>
                </td>
                <td>
                    <strong><?php echo htmlspecialchars($h['destino_fun']); ?></strong><br />
                    <span style="color:#94a3b8; font-size:11px;"><?php echo htmlspecialchars($h['destino_dep']); ?></span>
                </td>
                <td>
                    <span style="color:#fda4af; font-weight:700; font-size:11px; text-transform:uppercase;"><?php echo htmlspecialchars($h['proveido']); ?></span>
                    <?php if (!empty($h['mensaje'])): ?>
                        <p style="margin-top:2px; font-style:italic; font-size:11px; color:#cbd5e1;"><?php echo htmlspecialchars($h['mensaje']); ?></p>
                    <?php endif; ?>
                </td>
                <td><?php echo formatearFechaLimpia($h['fecha']); ?></td>
                <td>
                    <?php if ($h['recibido']): ?>
                        <span style="color:#10b981; font-weight:700;">✓ Recibido</span>
                    <?php else: ?>
                        <span style="color:#f59e0b; font-weight:700;">⏳ En Tránsito</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php else: ?>

<!-- EMPTY STATE / NOT FOUND -->
<div style="background:#0f172a; border:1px solid rgba(255,255,255,0.08); border-radius:12px; padding:40px; text-align:center;">
    <svg viewBox="0 0 24 24" width="48" height="48" fill="none" stroke="#ef4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom:14px;">
        <circle cx="12" cy="12" r="10"></circle>
        <line x1="12" y1="8" x2="12" y2="12"></line>
        <line x1="12" y1="16" x2="12.01" y2="16"></line>
    </svg>
    <h2 style="color:#ffffff; font-size:18px; font-weight:700; margin-bottom:8px;">Hoja de Ruta No Encontrada</h2>
    <p style="color:#94a3b8; font-size:13px; max-width:400px; margin:0 auto 20px auto;">
        No se encontró ningún registro para el código <strong><?php echo htmlspecialchars($codigo_obtener_hr); ?></strong> en la gestión actual.
    </p>
    <button type="button" class="btn-action btn-secondary" onclick="window.close();">Cerrar Ventana</button>
</div>

<?php endif; ?>

</body>
</html>
<?php
if ($obtener_hr) mysql_free_result($obtener_hr);
if ($ob_derivaciones) mysql_free_result($ob_derivaciones);
?>
