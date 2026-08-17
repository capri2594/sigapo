<?php 
session_name("LoginSIRC");
session_start();
$cod_dep=$_SESSION['cod_dep'];
$_SESSION["control_vacio"]=0;
?>
<?php require_once('../Connections/snet.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
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
$dia_actual=date("Y-m-d");
$codigo_obtener_hr = "-1";
if (isset($_GET['cod'])) {
  $codigo_obtener_hr = $_GET['cod'];
}
mysql_select_db($database_snet, $snet);
$query_obtener_hr = sprintf("SELECT * FROM hojaruta WHERE hojaruta.cod=%s", GetSQLValueString($codigo_obtener_hr, "text"));
$obtener_hr = mysql_query($query_obtener_hr, $snet) or die(mysql_error());
$row_obtener_hr = mysql_fetch_assoc($obtener_hr);
$totalRows_obtener_hr = mysql_num_rows($obtener_hr);

$codigo_listar_destinos = "-1";
if (isset($_GET['cod'])) {
  $codigo_listar_destinos = $_GET['cod'];
}
mysql_select_db($database_snet, $snet);
$query_listar_destinos = sprintf("SELECT id, hojaruta_cod, nro_destino, fun_destino, dep_destino, fecha_derivacion, DATE(fecha_derivacion) AS fecha_activa, proveido, mensaje, fecha_recibidoHR, nhojas, anexos, fun_derivador, cod_depderivador, usuario_derivador, salidas_id, entradas_id FROM derivacion WHERE derivacion.hojaruta_cod=%s ORDER BY derivacion.nro_destino ASC", GetSQLValueString($codigo_listar_destinos, "text")); //modificar 2023
//$query_listar_destinos = sprintf("SELECT * FROM derivacion WHERE derivacion.hojaruta_cod=%s ORDER BY derivacion.nro_destino ASC", GetSQLValueString($codigo_listar_destinos, "text"));
$listar_destinos = mysql_query($query_listar_destinos, $snet) or die(mysql_error());
$row_listar_destinos = mysql_fetch_assoc($listar_destinos);
$totalRows_listar_destinos = mysql_num_rows($listar_destinos);
?>
<?php 
require_once("include/convertir_fechas.php");
require_once("include/calcular_permanencia.php");
?>
<?php
date_default_timezone_set("America/La_Paz"); 
$printDateTime = date('d-m-Y H:i:s'); 
$usuario_mis_datos = "-1";
if (isset($_SESSION['user'])) {
  $usuario_mis_datos = $_SESSION['user'];
}

mysql_select_db($database_snet, $snet);
$query_mis_datos = sprintf("SELECT * FROM funcionario WHERE funcionario.usuario_cuenta=%s", GetSQLValueString($usuario_mis_datos, "text"));
$mis_datos = mysql_query($query_mis_datos, $snet) or die(mysql_error());
$row_mis_datos = mysql_fetch_assoc($mis_datos);
// Obtener la IP del cliente
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
if(count($row_mis_datos) > 0){
    $data = $row_mis_datos['usuario_cuenta'].' - '.$row_mis_datos['dependencia_cod'].' - '.$printDateTime.' - '.$ip;
    $encodedData = urlencode($data);
} else {
    $encodedData = "No se pudo obtener la IP del usuario";
}
?>
<?php
// Incluir la biblioteca PHP QR Code
require_once('include/phpqrcode/qrlib.php');
$qrFile = 'qr_code.png';

// Nivel de corrección de errores: L (bajo), M, Q, H (alto)
$ecc = QR_ECLEVEL_L;

// Tamaño del pixel del QR (escala)
$size = 4;

// Margen mínimo recomendado es 1 (por estándar QR)
$margin = 1;

QRcode::png($data, $qrFile, $ecc, $size, $margin);

// Mostrar la imagen generada en el navegador
//echo "<img src='$qrFile' alt='QR Code'>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo  $_GET['cod']; ?></title>
<style type="text/css">
body {
     background-color: #0f172a !important;
     color: #cbd5e1 !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     margin: 20px !important;
     padding: 0 !important;
}

/* Outer layout tables */
table {
     border-collapse: collapse !important;
     width: 100% !important;
}

/* Metadata Card Container (Top Card) */
table.celeste2 {
     background-color: #1e293b !important;
     border: 1px solid rgba(255, 255, 255, 0.1) !important;
     border-radius: 8px !important;
     padding: 20px !important;
     box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3) !important;
     box-sizing: border-box !important;
}

/* Header strip */
td.td-border-style-2 {
     background-color: #1e293b !important;
     border: 1px solid rgba(255, 255, 255, 0.1) !important;
     border-radius: 8px !important;
     padding: 12px !important;
}

/* Card Header label */
td[bgcolor="#6B7A9D"] {
     background-color: #1e3a8a !important;
     border-radius: 6px 6px 0 0 !important;
     padding: 10px 14px !important;
}

/* Remove side shade image */
td[width="5"] img[src="imagen/sombra_pestaña.png"] {
     display: none !important;
}

/* Card Labels */
table.celeste2 td div[align="right"] {
     color: #94a3b8 !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     padding-right: 10px !important;
}

/* Card values text containers */
table.celeste2 td[bgcolor="#FFFFFF"],
table.celeste2 td.celeste2[bgcolor="#FFFFFF"] {
     background-color: rgba(15, 23, 42, 0.5) !important;
     color: #ffffff !important;
     border: 1px solid rgba(255, 255, 255, 0.05) !important;
     border-radius: 6px !important;
     padding: 8px 12px !important;
     font-size: 13px !important;
}

/* QR Code padding box */
td[rowspan="8"] img {
     background-color: #ffffff !important;
     padding: 8px !important;
     border-radius: 6px !important;
     box-shadow: 0 4px 10px rgba(0,0,0,0.5) !important;
}

/* Footer user label metadata */
td[colspan="4"][style*="font-size: 10px"] {
     color: #64748b !important;
     font-size: 11px !important;
     padding-top: 12px !important;
     border-top: 1px solid rgba(255, 255, 255, 0.05) !important;
}

/* Action Button: Editar */
input.editarHR {
     background: linear-gradient(135deg, #4b5563 0%, #374151 100%) !important;
     color: #ffffff !important;
     border: none !important;
     border-radius: 4px !important;
     padding: 5px 10px !important;
     font-size: 10px !important;
     font-weight: 700 !important;
     cursor: pointer !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     box-shadow: 0 2px 4px rgba(0,0,0,0.2) !important;
     transition: all 0.2s !important;
     background-image: none !important;
     width: auto !important;
     height: auto !important;
}

input.editarHR:hover {
     box-shadow: 0 4px 8px rgba(0,0,0,0.3) !important;
     transform: translateY(-1px) !important;
}

/* Toolbar controls styling */
tr.titulos {
     background-color: transparent !important;
}

tr.titulos > td {
     background-color: #1e293b !important;
     border: 1px solid rgba(255, 255, 255, 0.1) !important;
     border-radius: 8px !important;
     padding: 10px 14px !important;
}

tr.titulos td.barra, 
tr.titulos td.barra_espacio {
     background-image: none !important;
     background-color: transparent !important;
     border: none !important;
     color: #cbd5e1 !important;
}

/* Reload button style override */
div.actualizar {
     background-image: none !important;
     background-color: rgba(255, 255, 255, 0.05) !important;
     border: 1px solid rgba(255, 255, 255, 0.1) !important;
     border-radius: 4px !important;
     width: 28px !important;
     height: 28px !important;
     display: flex !important;
     align-items: center !important;
     justify-content: center !important;
     cursor: pointer !important;
     transition: all 0.2s !important;
}

div.actualizar:hover {
     background-color: rgba(59, 130, 246, 0.15) !important;
     border-color: #2563eb !important;
}

/* Action: Nuevo Destinatario Button */
div.new_destino1 {
     background-image: none !important;
     background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
     color: #ffffff !important;
     border-radius: 6px !important;
     padding: 6px 14px !important;
     font-weight: 700 !important;
     cursor: pointer !important;
     box-shadow: 0 2px 8px rgba(37, 99, 235, 0.3) !important;
     display: inline-flex !important;
     align-items: center !important;
     transition: all 0.2s !important;
     border: none !important;
}

div.new_destino1:hover {
     box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4) !important;
     transform: translateY(-1px) !important;
}

div.new_destino1 span.Estilo17 {
     color: #ffffff !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
}

/* Action: Finalizar Button */
div.b_salir1 {
     background-image: none !important;
     background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
     color: #ffffff !important;
     border-radius: 6px !important;
     padding: 6px 14px !important;
     font-weight: 700 !important;
     cursor: pointer !important;
     box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3) !important;
     display: inline-flex !important;
     align-items: center !important;
     transition: all 0.2s !important;
     border: none !important;
}

div.b_salir1:hover {
     box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4) !important;
     transform: translateY(-1px) !important;
}

div.b_salir1 span.Estilo17 {
     color: #ffffff !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
}

/* Imprimir links */
div.b_imprimir21 {
     background-image: none !important;
     background-color: rgba(255, 255, 255, 0.05) !important;
     border: 1px solid rgba(255, 255, 255, 0.1) !important;
     border-radius: 4px !important;
     padding: 6px 12px !important;
     color: #3b82f6 !important;
     cursor: pointer !important;
     transition: all 0.2s !important;
     display: inline-block !important;
     font-weight: 700 !important;
}

div.b_imprimir21:hover {
     background-color: rgba(37, 99, 235, 0.1) !important;
     border-color: #2563eb !important;
     color: #3b82f6 !important;
}

div.b_imprimir21 span.Estilo17 {
     color: #3b82f6 !important;
     font-size: 11px !important;
     font-weight: 700 !important;
}

/* Text Input Page */
#npag {
     background-color: rgba(15, 23, 42, 0.6) !important;
     border: 1px solid rgba(255, 255, 255, 0.1) !important;
     border-radius: 4px !important;
     color: #ffffff !important;
     padding: 5px 8px !important;
     font-size: 12px !important;
     text-align: center !important;
     outline: none !important;
     box-sizing: border-box !important;
}

#npag:focus {
     border-color: #2563eb !important;
}

/* Destinations History Grid Table */
table[cellpadding="3"] {
     background-color: #1e293b !important;
     border: 1px solid rgba(255, 255, 255, 0.1) !important;
     border-radius: 8px !important;
     overflow: hidden !important;
     margin-top: 15px !important;
}

/* Grid Headers */
tr[bgcolor="#EDEFF3"] {
     background-color: #1e3a8a !important;
}

tr[bgcolor="#EDEFF3"] td {
     color: #ffffff !important;
     font-weight: 700 !important;
     font-size: 11px !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     padding: 12px 14px !important;
     border-bottom: 2px solid rgba(255, 255, 255, 0.1) !important;
}

/* Grid data rows */
tr.celdas {
     background-color: #1e293b !important;
     transition: background-color 0.2s !important;
}

tr.celdas:nth-child(even) {
     background-color: rgba(255, 255, 255, 0.01) !important;
}

tr.celdas:hover {
     background-color: rgba(255, 255, 255, 0.03) !important;
}

tr.celdas td {
     padding: 12px 14px !important;
     color: #cbd5e1 !important;
     font-size: 13px !important;
     border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
}

/* Step index number column */
tr.celdas td[bgcolor="#EDEFF3"] {
     background-color: rgba(37, 99, 235, 0.08) !important;
     color: #3b82f6 !important;
     font-weight: 700 !important;
     font-size: 13px !important;
     text-align: center !important;
     border-right: 1px solid rgba(255, 255, 255, 0.05) !important;
}

/* Destination Name & dependence */
td span.Estilo7 {
     color: #94a3b8 !important;
     font-size: 11px !important;
     font-weight: 600 !important;
     display: block !important;
     margin-top: 4px !important;
}

/* Proveido status badges */
.titulo_proveido {
     background-color: rgba(245, 158, 11, 0.1) !important;
     color: #f59e0b !important;
     border: 1px solid rgba(245, 158, 11, 0.25) !important;
     border-radius: 4px !important;
     padding: 3px 8px !important;
     font-size: 10px !important;
     font-weight: 700 !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     display: inline-block !important;
     margin-bottom: 6px !important;
}

.proveido {
     color: #ffffff !important;
     font-size: 12px !important;
     line-height: 1.5 !important;
}

.firma_proveido {
     color: #94a3b8 !important;
     font-size: 10px !important;
}

/* Status Badges */
.fech_entrega {
     background-color: rgba(16, 185, 129, 0.08) !important;
     color: #10b981 !important;
     border: 1px solid rgba(16, 185, 129, 0.25) !important;
     border-radius: 4px !important;
     padding: 6px 10px !important;
     font-size: 11px !important;
     font-weight: 600 !important;
     display: inline-block !important;
     width: auto !important;
     height: auto !important;
     text-align: center !important;
}

.fech_salida {
     background-color: rgba(245, 158, 11, 0.08) !important;
     color: #f59e0b !important;
     border: 1px solid rgba(245, 158, 11, 0.25) !important;
     border-radius: 4px !important;
     padding: 6px 10px !important;
     font-size: 11px !important;
     font-weight: 600 !important;
     display: inline-block !important;
     width: auto !important;
     height: auto !important;
     text-align: center !important;
}

.noreportado {
     background-color: rgba(239, 68, 68, 0.05) !important;
     color: #ef4444 !important;
     border: 1px solid rgba(239, 68, 68, 0.25) !important;
     border-radius: 4px !important;
     padding: 6px 10px !important;
     font-size: 10px !important;
     font-weight: 600 !important;
     display: inline-block !important;
     text-align: center !important;
     line-height: 1.3 !important;
}

/* Action Buttons (Grid cells) */
.modificar, .desactivar, .eliminar {
     border: none !important;
     border-radius: 4px !important;
     width: 22px !important;
     height: 22px !important;
     cursor: pointer !important;
     transition: all 0.2s !important;
     display: inline-block !important;
}

.modificar {
     background-color: rgba(59, 130, 246, 0.1) !important;
     border: 1px solid rgba(59, 130, 246, 0.3) !important;
     background-image: url(imagen/botones/edit_on.png) !important;
}
.modificar:hover {
     background-color: rgba(59, 130, 246, 0.25) !important;
     transform: scale(1.1) !important;
}

.desactivar {
     background-color: rgba(245, 158, 11, 0.1) !important;
     border: 1px solid rgba(245, 158, 11, 0.3) !important;
     background-image: url(imagen/botones/vaciar_off.png) !important;
}
.desactivar:hover {
     background-color: rgba(245, 158, 11, 0.25) !important;
     transform: scale(1.1) !important;
}

.eliminar {
     background-color: rgba(239, 68, 68, 0.1) !important;
     border: 1px solid rgba(239, 68, 68, 0.3) !important;
     background-image: url(imagen/botones/eliminar_todo.png) !important;
}
.eliminar:hover {
     background-color: rgba(239, 68, 68, 0.25) !important;
     transform: scale(1.1) !important;
}

/* State Labels */
.text-green-label {
     color: #10b981 !important;
     font-weight: 700 !important;
     font-size: 11px !important;
}

.text-red-label {
     color: #ef4444 !important;
     font-weight: 700 !important;
     font-size: 11px !important;
}

.text-orange-label {
     color: #f59e0b !important;
     font-weight: 700 !important;
     font-size: 11px !important;
}

.text-blue-label {
     color: #3b82f6 !important;
     font-weight: 700 !important;
     font-size: 11px !important;
}

/* State top badges */
.Estilo5 {
     background-color: rgba(16, 185, 129, 0.1) !important;
     color: #10b981 !important;
     border: 1px solid rgba(16, 185, 129, 0.25) !important;
     border-radius: 4px !important;
     padding: 4px 8px !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     display: inline-block !important;
     width: auto !important;
     height: auto !important;
}

.pendiente {
     background-color: rgba(239, 68, 68, 0.1) !important;
     color: #ef4444 !important;
     border: 1px solid rgba(239, 68, 68, 0.25) !important;
     border-radius: 4px !important;
     padding: 4px 8px !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     display: inline-block !important;
     width: auto !important;
     height: auto !important;
}

/* Action table subcells */
tr[bgcolor="#CAD2DB"] {
     background-color: transparent !important;
}

tr[bgcolor="#CAD2DB"] td {
     border: none !important;
     padding: 2px !important;
}
/* Custom print page button styling */
.btn-print-page {
     background-image: none !important;
     background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
     border: none !important;
     border-radius: 4px !important;
     color: #ffffff !important;
     cursor: pointer !important;
     display: inline-flex !important;
     align-items: center !important;
     justify-content: center !important;
     padding: 5px 12px !important;
     height: 28px !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     transition: all 0.2s !important;
     box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2) !important;
     vertical-align: middle !important;
}

.btn-print-page:hover {
     box-shadow: 0 4px 8px rgba(37, 99, 235, 0.3) !important;
     transform: translateY(-1px) !important;
}

.btn-print-page:active {
     transform: translateY(1px) !important;
}
/* Custom print page button (button3) styling */
.button3 {
     background-image: none !important;
     background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
     border: none !important;
     border-radius: 4px !important;
     color: #ffffff !important;
     cursor: pointer !important;
     display: inline-flex !important;
     align-items: center !important;
     justify-content: center !important;
     padding: 6px 14px !important;
     height: 28px !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     transition: all 0.2s !important;
     box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2) !important;
     vertical-align: middle !important;
}

.button3:hover {
     box-shadow: 0 4px 8px rgba(37, 99, 235, 0.3) !important;
     transform: translateY(-1px) !important;
}

.button3:active {
     transform: translateY(1px) !important;
}
/* Action button hover styles */
.btn-action {
     transition: all 0.2s ease-in-out !important;
}
.btn-edit:hover {
     background-color: #3b82f6 !important;
}
.btn-edit:hover svg {
     stroke: #ffffff !important;
}
.btn-disable:hover {
     background-color: #ef4444 !important;
}
.btn-disable:hover svg {
     stroke: #ffffff !important;
}
.btn-delete:hover {
     background-color: #ef4444 !important;
}
.btn-delete:hover svg {
     stroke: #ffffff !important;
}
</style>

<script type="text/javascript" src="js/scriptaculous/prototype.js"></script>
<script type="text/javascript" src="js/scriptaculous/scriptaculous.js"></script>
<script type="text/javascript" src="js/scriptaculous/effects.js"></script>
<script type="text/javascript" src="js/scriptaculous/controls.js"></script>
<script type="text/javascript" src="js/scriptaculous/unittest.js"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>

<script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
function ndestino(theURL,winName,features) { //v2.0
  vdestino=window.open(theURL,winName,features);
  vdestino.window.focus();
}

function desactivar01(iddestino,codpropio,panel){
    //alert('desactivando destino');
	//alert('desactivado');
	confirmar=confirm('Esta seguro?. El sistema Desactivara este destino.');
	if (confirmar==true)
	{
	 
     var url = 'ajax/desactivar_destino.php';
	 var myRand = parseInt(Math.random()*999999999999999);  
	 var pars = "rand="+myRand;
	 if (codpropio=='') {alert('Lo siento Destino ya esta desactivado.');exit(0); };
	 pars+='&cod_propietario='+escape(codpropio)+'*D';
	 pars+='&id_derivacion='+escape(iddestino);
	 //alert(pars);
     var target = panel;
     var miAjax = new Ajax.Updater(target, url, {method: 'get', parameters: pars, onComplete: showResponse});
	 //alert(miAjax);

    }//fin if
	function showResponse(originalRequest)
	{
		//put returned XML in the textarea
		//$('inactivo4').innerHTML = originalRequest.responseText;
		
}

	 
}

function eliminar(iddestino,codhr,contador){
    //alert('desactivando destino');
	//alert('desactivado');

	confirmar=confirm('Eliminar este destino \nEsta seguro?.');
	if (confirmar==true)
	{
	 
     var url = 'ajax/eliminar_destino.php';
	 var myRand = parseInt(Math.random()*999999999999999);  
	 var pars = "rand="+myRand;
	 //if (codpropio=='') {alert('Lo siento Destino ya esta desactivado.');exit(0); };
	 pars+='&id_destino='+escape(iddestino);
	 pars+='&cod='+escape(codhr);
	 pars+='&cont='+escape(contador);
	 //alert(pars);
     var target = 'inactivo'+(parseInt(contador)-1);
     var miAjax = new Ajax.Updater(target, url, {method: 'get', parameters: pars, onComplete: showResponse});
	 //alert(miAjax);

    }//fin if
	function showResponse(originalRequest)
	{
		//put returned XML in the textarea
		//$('inactivo4').innerHTML = originalRequest.responseText;
		var resultado=originalRequest.responseText;
		if (resultado=="ok") alert('Elminacion correcta.');
		alert('Elminacion correcta.');
		window.location.reload();
		
    }
	
}

function entrega(iddestino){
 //alert('desactivando destino');
     var url = 'ajax/xml_destinos_entrega.php';
	 var myRand = parseInt(Math.random()*999999999999999);  
	 var pars = "rand="+myRand;
	 //if (codpropio=='') {alert('Lo siento Destino ya esta desactivado.');exit(0); };
	 pars+='&iden='+escape(iddestino);
	 //alert(pars);
     var target = '';
     var miAjax = new Ajax.Updater(target, url, {method: 'get', parameters: pars, onComplete: showResponse});
	 //alert(miAjax);

 }
 function showResponse(responseXMLCli)
 {

        //var xml  = responseXMLCli.responseXML.documentElement;
		var xml  = responseXMLCli.responseXML.getElementsByTagName('recibido');

        // Accedemos al DIV
        // Iteramos cada cliente
		//alert(xml.length);
        for (i = 0; i < xml.length; i++)
        {
            // Accedemos al objeto XML cliente
			//alert(i);
            var id = xml[0].getElementsByTagName('id')[0].firstChild.nodeValue;
            // Recojemos el id del cliente
            // Mostramos el enlace
			//alert(id);
       }
	   
       var miDiv = document.getElementById('div_recib'+id);
	   //alert(id);
	   //alert(xml[0].getElementsByTagName('fecha')[0].firstChild.nodeValue);
        // Vaciamos el DIV
       miDiv.innerHTML = xml[0].getElementsByTagName('fecha')[0].firstChild.nodeValue;
	   
//miDiv.innerHTML = EstructuraHTML+'</ul>\n'; 
}		

//definiendo variable de fechas...
lista= new Array();//salidas...
function mostrar_salidas(){
//alert('mostrando');
//alert(lista[0]);
for(i=0;i<lista.length;i++){
//alert(lista[i]);
//$('sal'+i).innerHTML=lista[i];
//alert('div: '+$('sal'+i).innerHTML);
$('sal'+i).innerHTML=lista[i];
}
}

estadia= new Array();//salidas...
function estadias(){
//alert('mostrando');
//alert(lista[0]);
for(i=0;i<estadia.length;i++){
//alert(lista[i]);
//$('sal'+i).innerHTML=lista[i];
//alert('div: '+$('sal'+i).innerHTML);
$('esta'+i).innerHTML=estadia[i];
}
}

//-->
</script>

<script language="Javascript">
<!--# Begin
document.oncontextmenu = function(){return false}

// End -->
</script> 

<link href="css/main.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body {
     background-color: #0f172a !important;
     color: #cbd5e1 !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     margin: 20px !important;
     padding: 0 !important;
}

/* Outer layout tables */
table {
     border-collapse: collapse !important;
     width: 100% !important;
}

/* Metadata Card Container (Top Card) */
table.celeste2 {
     background-color: #1e293b !important;
     border: 1px solid rgba(255, 255, 255, 0.1) !important;
     border-radius: 8px !important;
     padding: 20px !important;
     box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3) !important;
     box-sizing: border-box !important;
}

/* Header strip */
td.td-border-style-2 {
     background-color: #1e293b !important;
     border: 1px solid rgba(255, 255, 255, 0.1) !important;
     border-radius: 8px !important;
     padding: 12px !important;
}

/* Card Header label */
td[bgcolor="#6B7A9D"] {
     background-color: #1e3a8a !important;
     border-radius: 6px 6px 0 0 !important;
     padding: 10px 14px !important;
}

/* Remove side shade image */
td[width="5"] img[src="imagen/sombra_pestaña.png"] {
     display: none !important;
}

/* Card Labels */
table.celeste2 td div[align="right"] {
     color: #94a3b8 !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     padding-right: 10px !important;
}

/* Card values text containers */
table.celeste2 td[bgcolor="#FFFFFF"],
table.celeste2 td.celeste2[bgcolor="#FFFFFF"] {
     background-color: rgba(15, 23, 42, 0.5) !important;
     color: #ffffff !important;
     border: 1px solid rgba(255, 255, 255, 0.05) !important;
     border-radius: 6px !important;
     padding: 8px 12px !important;
     font-size: 13px !important;
}

/* QR Code padding box */
td[rowspan="8"] img {
     background-color: #ffffff !important;
     padding: 8px !important;
     border-radius: 6px !important;
     box-shadow: 0 4px 10px rgba(0,0,0,0.5) !important;
}

/* Footer user label metadata */
td[colspan="4"][style*="font-size: 10px"] {
     color: #64748b !important;
     font-size: 11px !important;
     padding-top: 12px !important;
     border-top: 1px solid rgba(255, 255, 255, 0.05) !important;
}

/* Action Button: Editar */
input.editarHR {
     background: linear-gradient(135deg, #4b5563 0%, #374151 100%) !important;
     color: #ffffff !important;
     border: none !important;
     border-radius: 4px !important;
     padding: 5px 10px !important;
     font-size: 10px !important;
     font-weight: 700 !important;
     cursor: pointer !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     box-shadow: 0 2px 4px rgba(0,0,0,0.2) !important;
     transition: all 0.2s !important;
     background-image: none !important;
     width: auto !important;
     height: auto !important;
}

input.editarHR:hover {
     box-shadow: 0 4px 8px rgba(0,0,0,0.3) !important;
     transform: translateY(-1px) !important;
}

/* Toolbar controls styling */
tr.titulos {
     background-color: transparent !important;
}

tr.titulos > td {
     background-color: #1e293b !important;
     border: 1px solid rgba(255, 255, 255, 0.1) !important;
     border-radius: 8px !important;
     padding: 10px 14px !important;
}

tr.titulos td.barra, 
tr.titulos td.barra_espacio {
     background-image: none !important;
     background-color: transparent !important;
     border: none !important;
     color: #cbd5e1 !important;
}

/* Reload button style override */
div.actualizar {
     background-image: none !important;
     background-color: rgba(255, 255, 255, 0.05) !important;
     border: 1px solid rgba(255, 255, 255, 0.1) !important;
     border-radius: 4px !important;
     width: 28px !important;
     height: 28px !important;
     display: flex !important;
     align-items: center !important;
     justify-content: center !important;
     cursor: pointer !important;
     transition: all 0.2s !important;
}

div.actualizar:hover {
     background-color: rgba(59, 130, 246, 0.15) !important;
     border-color: #2563eb !important;
}

/* Action: Nuevo Destinatario Button */
div.new_destino1 {
     background-image: none !important;
     background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
     color: #ffffff !important;
     border-radius: 6px !important;
     padding: 6px 14px !important;
     font-weight: 700 !important;
     cursor: pointer !important;
     box-shadow: 0 2px 8px rgba(37, 99, 235, 0.3) !important;
     display: inline-flex !important;
     align-items: center !important;
     transition: all 0.2s !important;
     border: none !important;
}

div.new_destino1:hover {
     box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4) !important;
     transform: translateY(-1px) !important;
}

div.new_destino1 span.Estilo17 {
     color: #ffffff !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
}

/* Action: Finalizar Button */
div.b_salir1 {
     background-image: none !important;
     background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
     color: #ffffff !important;
     border-radius: 6px !important;
     padding: 6px 14px !important;
     font-weight: 700 !important;
     cursor: pointer !important;
     box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3) !important;
     display: inline-flex !important;
     align-items: center !important;
     transition: all 0.2s !important;
     border: none !important;
}

div.b_salir1:hover {
     box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4) !important;
     transform: translateY(-1px) !important;
}

div.b_salir1 span.Estilo17 {
     color: #ffffff !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
}

/* Imprimir links */
div.b_imprimir21 {
     background-image: none !important;
     background-color: rgba(255, 255, 255, 0.05) !important;
     border: 1px solid rgba(255, 255, 255, 0.1) !important;
     border-radius: 4px !important;
     padding: 6px 12px !important;
     color: #3b82f6 !important;
     cursor: pointer !important;
     transition: all 0.2s !important;
     display: inline-block !important;
     font-weight: 700 !important;
}

div.b_imprimir21:hover {
     background-color: rgba(37, 99, 235, 0.1) !important;
     border-color: #2563eb !important;
     color: #3b82f6 !important;
}

div.b_imprimir21 span.Estilo17 {
     color: #3b82f6 !important;
     font-size: 11px !important;
     font-weight: 700 !important;
}

/* Text Input Page */
#npag {
     background-color: rgba(15, 23, 42, 0.6) !important;
     border: 1px solid rgba(255, 255, 255, 0.1) !important;
     border-radius: 4px !important;
     color: #ffffff !important;
     padding: 5px 8px !important;
     font-size: 12px !important;
     text-align: center !important;
     outline: none !important;
     box-sizing: border-box !important;
}

#npag:focus {
     border-color: #2563eb !important;
}

/* Destinations History Grid Table */
table[cellpadding="3"] {
     background-color: #1e293b !important;
     border: 1px solid rgba(255, 255, 255, 0.1) !important;
     border-radius: 8px !important;
     overflow: hidden !important;
     margin-top: 15px !important;
}

/* Grid Headers */
tr[bgcolor="#EDEFF3"] {
     background-color: #1e3a8a !important;
}

tr[bgcolor="#EDEFF3"] td {
     color: #ffffff !important;
     font-weight: 700 !important;
     font-size: 11px !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     padding: 12px 14px !important;
     border-bottom: 2px solid rgba(255, 255, 255, 0.1) !important;
}

/* Grid data rows */
tr.celdas {
     background-color: #1e293b !important;
     transition: background-color 0.2s !important;
}

tr.celdas:nth-child(even) {
     background-color: rgba(255, 255, 255, 0.01) !important;
}

tr.celdas:hover {
     background-color: rgba(255, 255, 255, 0.03) !important;
}

tr.celdas td {
     padding: 12px 14px !important;
     color: #cbd5e1 !important;
     font-size: 13px !important;
     border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
}

/* Step index number column */
tr.celdas td[bgcolor="#EDEFF3"] {
     background-color: rgba(37, 99, 235, 0.08) !important;
     color: #3b82f6 !important;
     font-weight: 700 !important;
     font-size: 13px !important;
     text-align: center !important;
     border-right: 1px solid rgba(255, 255, 255, 0.05) !important;
}

/* Destination Name & dependence */
td span.Estilo7 {
     color: #94a3b8 !important;
     font-size: 11px !important;
     font-weight: 600 !important;
     display: block !important;
     margin-top: 4px !important;
}

/* Proveido status badges */
.titulo_proveido {
     background-color: rgba(245, 158, 11, 0.1) !important;
     color: #f59e0b !important;
     border: 1px solid rgba(245, 158, 11, 0.25) !important;
     border-radius: 4px !important;
     padding: 3px 8px !important;
     font-size: 10px !important;
     font-weight: 700 !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     display: inline-block !important;
     margin-bottom: 6px !important;
}

.proveido {
     color: #ffffff !important;
     font-size: 12px !important;
     line-height: 1.5 !important;
}

.firma_proveido {
     color: #94a3b8 !important;
     font-size: 10px !important;
}

/* Status Badges */
.fech_entrega {
     background-color: rgba(16, 185, 129, 0.08) !important;
     color: #10b981 !important;
     border: 1px solid rgba(16, 185, 129, 0.25) !important;
     border-radius: 4px !important;
     padding: 6px 10px !important;
     font-size: 11px !important;
     font-weight: 600 !important;
     display: inline-block !important;
     width: auto !important;
     height: auto !important;
     text-align: center !important;
}

.fech_salida {
     background-color: rgba(245, 158, 11, 0.08) !important;
     color: #f59e0b !important;
     border: 1px solid rgba(245, 158, 11, 0.25) !important;
     border-radius: 4px !important;
     padding: 6px 10px !important;
     font-size: 11px !important;
     font-weight: 600 !important;
     display: inline-block !important;
     width: auto !important;
     height: auto !important;
     text-align: center !important;
}

.noreportado {
     background-color: rgba(239, 68, 68, 0.05) !important;
     color: #ef4444 !important;
     border: 1px solid rgba(239, 68, 68, 0.25) !important;
     border-radius: 4px !important;
     padding: 6px 10px !important;
     font-size: 10px !important;
     font-weight: 600 !important;
     display: inline-block !important;
     text-align: center !important;
     line-height: 1.3 !important;
}

/* Action Buttons (Grid cells) */
.modificar, .desactivar, .eliminar {
     border: none !important;
     border-radius: 4px !important;
     width: 22px !important;
     height: 22px !important;
     cursor: pointer !important;
     transition: all 0.2s !important;
     display: inline-block !important;
}

.modificar {
     background-color: rgba(59, 130, 246, 0.1) !important;
     border: 1px solid rgba(59, 130, 246, 0.3) !important;
     background-image: url(imagen/botones/edit_on.png) !important;
}
.modificar:hover {
     background-color: rgba(59, 130, 246, 0.25) !important;
     transform: scale(1.1) !important;
}

.desactivar {
     background-color: rgba(245, 158, 11, 0.1) !important;
     border: 1px solid rgba(245, 158, 11, 0.3) !important;
     background-image: url(imagen/botones/vaciar_off.png) !important;
}
.desactivar:hover {
     background-color: rgba(245, 158, 11, 0.25) !important;
     transform: scale(1.1) !important;
}

.eliminar {
     background-color: rgba(239, 68, 68, 0.1) !important;
     border: 1px solid rgba(239, 68, 68, 0.3) !important;
     background-image: url(imagen/botones/eliminar_todo.png) !important;
}
.eliminar:hover {
     background-color: rgba(239, 68, 68, 0.25) !important;
     transform: scale(1.1) !important;
}

/* State Labels */
.text-green-label {
     color: #10b981 !important;
     font-weight: 700 !important;
     font-size: 11px !important;
}

.text-red-label {
     color: #ef4444 !important;
     font-weight: 700 !important;
     font-size: 11px !important;
}

.text-orange-label {
     color: #f59e0b !important;
     font-weight: 700 !important;
     font-size: 11px !important;
}

.text-blue-label {
     color: #3b82f6 !important;
     font-weight: 700 !important;
     font-size: 11px !important;
}

/* State top badges */
.Estilo5 {
     background-color: rgba(16, 185, 129, 0.1) !important;
     color: #10b981 !important;
     border: 1px solid rgba(16, 185, 129, 0.25) !important;
     border-radius: 4px !important;
     padding: 4px 8px !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     display: inline-block !important;
     width: auto !important;
     height: auto !important;
}

.pendiente {
     background-color: rgba(239, 68, 68, 0.1) !important;
     color: #ef4444 !important;
     border: 1px solid rgba(239, 68, 68, 0.25) !important;
     border-radius: 4px !important;
     padding: 4px 8px !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     display: inline-block !important;
     width: auto !important;
     height: auto !important;
}

/* Action table subcells */
tr[bgcolor="#CAD2DB"] {
     background-color: transparent !important;
}

tr[bgcolor="#CAD2DB"] td {
     border: none !important;
     padding: 2px !important;
}
/* Custom print page button styling */
.btn-print-page {
     background-image: none !important;
     background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
     border: none !important;
     border-radius: 4px !important;
     color: #ffffff !important;
     cursor: pointer !important;
     display: inline-flex !important;
     align-items: center !important;
     justify-content: center !important;
     padding: 5px 12px !important;
     height: 28px !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     transition: all 0.2s !important;
     box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2) !important;
     vertical-align: middle !important;
}

.btn-print-page:hover {
     box-shadow: 0 4px 8px rgba(37, 99, 235, 0.3) !important;
     transform: translateY(-1px) !important;
}

.btn-print-page:active {
     transform: translateY(1px) !important;
}
/* Custom print page button (button3) styling */
.button3 {
     background-image: none !important;
     background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
     border: none !important;
     border-radius: 4px !important;
     color: #ffffff !important;
     cursor: pointer !important;
     display: inline-flex !important;
     align-items: center !important;
     justify-content: center !important;
     padding: 6px 14px !important;
     height: 28px !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     transition: all 0.2s !important;
     box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2) !important;
     vertical-align: middle !important;
}

.button3:hover {
     box-shadow: 0 4px 8px rgba(37, 99, 235, 0.3) !important;
     transform: translateY(-1px) !important;
}

.button3:active {
     transform: translateY(1px) !important;
}
/* Action button hover styles */
.btn-action {
     transition: all 0.2s ease-in-out !important;
}
.btn-edit:hover {
     background-color: #3b82f6 !important;
}
.btn-edit:hover svg {
     stroke: #ffffff !important;
}
.btn-disable:hover {
     background-color: #ef4444 !important;
}
.btn-disable:hover svg {
     stroke: #ffffff !important;
}
.btn-delete:hover {
     background-color: #ef4444 !important;
}
.btn-delete:hover svg {
     stroke: #ffffff !important;
}
</style>
</head>

<body >

<table width="100%" border="0">
  <tr>
    <td class="td-border-style-4" style="border:0px; padding:5px;"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <?php if ($totalRows_obtener_hr > 0) { // Show if recordset not empty ?>
      <tr bgcolor="#E5ECF7">
        <td class="td-border-style-2" style="border:0px; padding:10px;  padding-top: 2px; 
  padding-bottom: 2px;
  padding-left: 3px; 
  padding-right: 3px;
  border-top-color: #f9f9f7; 
  border-left-color: #f9f9f7;
  border-right-color: #828282;   
  border-bottom-color: #828282; 
  border-style: solid;
  border-width: 1px;"><table width="100%" border="0" cellspacing="0">
          <tr>
            <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td bgcolor="#6B7A9D"><span class="Estilo21" style="color: #ffffff !important; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important; font-weight: 700 !important; font-size: 13px !important; text-transform: uppercase !important; letter-spacing: 0.5px !important; padding-left: 10px !important;">Hoja de Ruta</span></td>
                <td width="5"><img src="imagen/sombra_pestaña.png" alt="" width="7" height="30" /></td>
                <td width="50">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellpadding="0" cellspacing="2" class="celeste2" style="padding:0px;">
              <tr>
                <td width="60" rowspan="8" align="center" valign="middle">    
                <?php echo "<img src='$qrFile' width='60' height='60' alt='QR Code'>";?>
                </td>
                <td width="170"><div align="right">Codigo Hoja de Ruta:&nbsp;&nbsp; </div></td>
                <td bgcolor="#FFFFFF"><table width="100%" border="0">
                  <tr>
                                        <td><strong id="�?�codhr�?�" style="font-size: 16px !important; color: #ffffff !important; font-weight: 800 !important; letter-spacing: 0.5px !important; text-shadow: 0 0 8px rgba(255,255,255,0.1) !important;"><?php echo $row_obtener_hr['cod']; ?></strong></td>
                    <td width="60"><label>
                      <input name="button10" type="button" class="editarHR" id="button10" value="Editar" title="Esta habilitado Editar Referencia"/>
                      </label>                    </td>
                  </tr>
                </table></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td width="170"><div align="right">Remitente:&nbsp;&nbsp;</div></td>
                <td bgcolor="#FFFFFF"><div
id="procedencia"><?php echo $row_obtener_hr['procedencia']; ?></div></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td width="170"><div align="right">Asunto/ref.:&nbsp;&nbsp;</div></td>
                <td bgcolor="#FFFFFF"><div
id="refe"><?php echo $row_obtener_hr['ref']; ?></div>
                          <?php if ($row_obtener_hr['cod_depcreador']==$_SESSION['cod_dep']){ ?>
                          <script>
new Ajax.InPlaceEditor($('refe'), 'ajax/cambiar_ref.php?cod=<?php echo $row_obtener_hr['cod']; ?>&idinterna=<?php echo $row_obtener_hr['einterna_id']; ?>&idexterna=<?php echo $row_obtener_hr['eexterna_id']; ?>', {
        submitOnBlur: true, okButton: false, cancelLink: false,
        ajaxOptions: {method: 'get'} //override so we can use a static for the result
        });
             </script>
                          <?php }?>                </td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td width="170"><div align="right">hojas:&nbsp;&nbsp;</div></td>
                <td bgcolor="#FFFFFF"><?php echo $row_obtener_hr['nhojas']; ?></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td width="170"><div align="right">Anexos:&nbsp;&nbsp;</div></td>
                <td bgcolor="#FFFFFF"><?php echo $row_obtener_hr['nanexos']; ?></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td width="170"><div align="right">Estado:&nbsp;&nbsp;</div></td>
                <td bgcolor="#FFFFFF"><?php 
			  if ($row_obtener_hr['estado']!=NULL){ ?>
                          <div align="center" class="Estilo5">EN PROCESO</div>
                  <?php
			    } else { // fin si es mayor a uno
				?>
                          <div align="center" class="pendiente">NO REVISADO</div>
                  <?php
			       }//fin Si es mayor a 1...			       }			   
			  ?>                </td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><div align="right">Permanencia Total:&nbsp;&nbsp;</div></td>
                <td bgcolor="#FFFFFF">&nbsp;<?php echo permanencia($row_obtener_hr['fecha_creacion'],date("Y-m-d H:i:s")). "  [dias]  hasta hoy."; ?></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
              <td style="font-size: 10px; white-space: nowrap;" colspan="4"> usuario: 
        <?php echo $row_mis_datos['usuario_cuenta']; ?> dependencia: <?php echo $row_mis_datos['dependencia_cod']; ?> fecha y hora de impresión: <?php  echo $printDateTime; ?> - IP: <?php echo $ip; ?>
    </td>
            </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr class="titulos">
        <td class="td-border-style-4"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-style:solid;border-width:0px; margin:0px; padding:0px; border:0px; height:30px; width:100%; ">
          <tr style="height:30px;">
            <td width="9" height="30" class="barra_espacio">&nbsp;</td>
            <td width="40" height="30" class="barra"><div class="actualizar" id="button2" onclick="window.location.reload()" style="height:30px; display:flex; align-items:center; justify-content:center; cursor:pointer;" title="Actualizar"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67"/></svg></div></td>
            <td width="9" height="30" class="barra_espacio">&nbsp;</td>
            <td width="15" height="30" class="barra">&nbsp;</td>
            <td width="40" height="30" class="barra"><span class="Estilo19">Pag</span></td>
            <td width="280" height="30" class="barra" style="width:250px;"><span id="sprytextfield1"><span class="barra" style="width:250px;">
              <input name="npag" type="text" id="npag"  maxlength="2" style="width:30px; padding-left:5px;" onkeypress="if(event.keyCode == Event. KEY_RETURN) if(sprytextfield1.validate()){MM_openBrWindow('imprimir/hoja_ruta/paginaN_5.php?pag='+$F('npag')+'&cod=<?php echo $_GET['cod'];?>','pagN','menubar=yes,scrollbars=yes,resizable=yes,width=900,height=700')}else{alert('Error, ingreso número de página e intente nuevamente.')};"/>
            </span><span class="Estilo19">/33</span> <span class="textfieldRequiredMsg">Número de página</span><span class="textfieldMaxValueMsg" style="z-index:3; position:relative;">No permitido.</span><span class="textfieldMaxCharsMsg">solo 2 digitos.</span><span class="textfieldMinCharsMsg">Número de página</span><span class="textfieldInvalidFormatMsg">Formato no válido. </span><span class="textfieldMinValueMsg">NO permitido.</span></span></td>
                                                <td width="35" height="30" class="barra_imprimir1" onclick="if(sprytextfield1.validate()){MM_openBrWindow('imprimir/hoja_ruta/paginaN_5.php?pag='+$F('npag')+'&cod=<?php echo $_GET['cod'];?>','pag1','menubar=yes,scrollbars=yes,resizable=yes,width=900,height=700')}else{alert('Error, ingreso número de página e intente nuevamente.')}"><button class="button3"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>IMPRIMIR</button></td>
            <td class="barra">&nbsp;</td>
            <!--Modificado para la hoja 12-->
            
            <td width="77" height="30" class="barra"><div class="b_imprimir21" id="button7" onclick="MM_openBrWindow('imprimir/hoja_ruta/paginaN_5.php?pag=3&cod=<?php echo $_GET['cod'];?>','pag1','menubar=yes,scrollbars=yes,resizable=yes,width=900,height=700')" title="Ver IMPRIMIR Pag. 3" ><span class="Estilo17">Pag. 3</span></div></td>
            <td width="77" height="30" class="barra"><div class="b_imprimir21" id="button2" onclick="MM_openBrWindow('imprimir/hoja_ruta/paginaN_5.php?pag=2&cod=<?php echo $_GET['cod'];?>','pag1','menubar=yes,scrollbars=yes,resizable=yes,width=900,height=700')" title="Ver IMPRIMIR Pag. 2"> <span class="Estilo17" style="vertical-align:middle;">Pag. 2</span></div></td>
            <td width="77" height="30" class="barra"><div class="b_imprimir21" id="button5" onclick="MM_openBrWindow('imprimir/hoja_ruta/pagina1_5.php?cod=<?php echo $_GET['cod'];?>','pag1','menubar=yes,scrollbars=yes,resizable=yes,width=900,height=700')" title="Ver IMPRIMIR Pag. 1"><span class="Estilo17">Pag. 1</span></div></td>
            <td height="30" class="barra">&nbsp;</td>
            <td width="9" height="30" class="barra_espacio">&nbsp;</td>
            <td width="15" height="30" class="barra">&nbsp;</td>
            <td width="100" height="30" class="barra"><div class="new_destino1" id="button3" onclick="ndestino('nuevo_destinatarioHR.php?cod=<?php echo $_GET['cod']?>','nuevoDestinatario','width=600,height=400,left=180,top=130')" style="height:30px; display:flex; align-items:center; cursor:pointer;" title="AGREGAR NUEVO DESTINO"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg><span class="Estilo17">Nuevo Destinatario</span></div></td>
            <td width="15" height="30" class="barra">&nbsp;</td>
            <td width="9" height="30" class="barra_espacio">&nbsp;</td>
            <td width="15" height="30" class="barra">&nbsp;</td>
            <td width="90" height="30" class="barra"><div class="b_salir1" id="button2" style="height:30px; display:flex; align-items:center; cursor:pointer;" onclick="window.close();" title="SALIR de la Hoja de Ruta"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg><span class="Estilo17">Finalizar</span></div></td>
            <td width="10" height="30" class="barra">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellpadding="3">
          <tr bgcolor="#EDEFF3">
            <td width="25" height="25">Nro.</td>
            <td width="150" height="25">Destino</td>
            <td height="25">Tarea o Instruccion</td>
            <td width="70"> Fecha Recepcion<br />
              Destino</td>
            <td width="100" height="25">Fecha de Salida<br />
              Destino<br />
              Mensajero</td>
            <td width="40">Perma<br />
              nencia</td>
            <td width="100" height="25">Acciones</td>
            <td width="95" height="25">Estado</td>
          </tr>
          <tr class="celdas">
            <td width="25" bgcolor="#EDEFF3">1</td>
            <td width="150"><p><?php echo $row_obtener_hr['primerfun_destino']; ?><br />
                        <span class="Estilo7"><?php echo $row_obtener_hr['primer_destino']; ?></span></p></td>
            <td><div align="center">- - - - -<br />
            </div>
                    <br />
              Registrado por: <?php echo $row_obtener_hr['usuario_creador']; ?></td>
            <td width="70"><div align="left" class="fech_entrega"><?php echo cambiar_a_normal_letra_con_hora($row_obtener_hr['fecha_creacion']);?>
                        <?php $fecha1=$row_obtener_hr['fecha_creacion']; $listafechas[0]=$row_obtener_hr['fecha_creacion'];?>
            </div>
                    <script>
			    // alert('iniciando');
				<?php if($row_obtener_hr['cont_destinos']>=2){?>
				   lista[0]="<?php echo cambiar_a_normal_letra_con_hora($row_obtener_hr['fecha_creacion']); ?>";
				  // alert('lista'+lista[0]);	
				  <?php }; ?>			   
			</script>
              </td>
            <td width="100" align="left"><div align="left" id="sal0" class="fech_salida"></div></td>
            <td width="40"><?php //echo "0 dias" ?>
                    <?php $t_anterior=0; $tiempos[0]=0?>
              &nbsp;<div id="esta0"></div></td>
            <td width="100">&nbsp;</td>
            <td width="95"><?php if($row_obtener_hr['cont_destinos']>=2){?>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:middle; margin-right:4px;"><polyline points="13 17 18 12 13 7"></polyline><polyline points="6 17 11 12 6 7"></polyline></svg><span class="text-blue-label">Trasladado</span>
                    <?php }else { ?>                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:middle; margin-right:4px;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg><span class="text-orange-label">En espera</span>
                    <?php }?></td>
          </tr>
          <?php if ($totalRows_listar_destinos > 0) { // Show if recordset not empty ?>
          <?php $i=1; //indice de fechas.... por destinos?>
          <?php do { ?>
          <?php 
			
			$listafechas[$i]=$row_listar_destinos['fecha_derivacion']; //colocando las fechas;
			//print_r($listafechas);
			//calculando tiempo del primer destino...
			//echo permanencia($listafechas[$i],$listafechas[$i-1]);
			?>
          <tr class="celdas">
            <td width="25" bgcolor="#EDEFF3"><?php echo $row_listar_destinos['nro_destino']; ?></td>
            <td width="150"><?php echo $row_listar_destinos['fun_destino']; ?><br />
                    <span class="Estilo7"><?php echo $row_listar_destinos['dep_destino']; ?></span><br />            </td>
            <td valign="top"><span class="titulo_proveido"><?php echo $row_listar_destinos['proveido']; ?></span><span class="celeste"><br />
              </span>
                    <div align="left" class="proveido"><?php echo $row_listar_destinos['mensaje']; ?></div>
              <br />
                    <div class="firma_proveido" style="width:100%;"> atte.&nbsp;&nbsp;<?php echo $row_listar_destinos['fun_derivador']; ?></div>
              <span class="firma_proveido"><?php echo cambiar_a_normal_letra_con_hora($row_listar_destinos['fecha_derivacion']); ?></span></td>
            <td width="70"><?php if ($row_listar_destinos['entradas_id']>0){ ?>
                    <script>
				   entrega(<?php echo $row_listar_destinos['entradas_id']; ?>);				   
				</script>
                    <div class="fech_entrega" id="div_recib<?php echo $row_listar_destinos['entradas_id']; ?>"></div>
              <div align="center">
                      <?php }else{?>
                      <span class="noreportado"> NO CONFIRMADO por<br />
                      <b><?php echo $row_listar_destinos['dep_destino']; ?></b></span> <br />
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:block; margin:6px auto 0 auto;"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg></div>
              <?php }?></td>
            <td width="100"><div align="left" class="fech_salida" id="sal<?php echo $i; ?>">
              <?php //echo cambiar_a_normal_letra_con_hora($row_listar_destinos['fecha_derivacion']); ?>
              <?php //cambiar_a_normal_letra_con_hora($listafechas[$i-1]); ?>
              <?php if($i==$totalRows_listar_destinos){?>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:block; margin:6px auto 0 auto;"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
              <?php }?>
            </div>
                    <script>
				   lista[<?php echo $i; ?>-1]="<?php echo cambiar_a_normal_letra_con_hora($row_listar_destinos['fecha_derivacion']); ?>";	
				   //colocando permanencia...
				   estadia.push('<?php echo permanencia($listafechas[$i],$listafechas[$i-1])." dias" ?>');			   
				</script>            </td>
            <td width="100"><?php $per=permanencia($fecha1,$row_listar_destinos['fecha_derivacion']);?>
              <?php //echo permanencia($listafechas[$i],$listafechas[$i-1])." dias" ?>
              <div id="esta<?php echo $i; ?>"></div>
              <?php $fecha1=$row_listar_destinos['fecha_derivacion'];?></td>
            <td width="100"><table width="100%" border="0">
              <tr bgcolor="#CAD2DB">
                <td width="30"><?php  if($cod_dep==$row_listar_destinos['cod_depderivador']&&($row_listar_destinos['fecha_activa']==$dia_actual)){ //modificar 2023?><?php if (($row_listar_destinos['entradas_id']<=0)){ ?>
                          <button name="Modificar" type="button" class="btn-action btn-edit" onclick="MM_openBrWindow('mod_destinos.php?id=<?php echo $row_listar_destinos['id']; ?>&amp;cod=<?php echo $row_listar_destinos['hojaruta_cod']; ?>','vmoddest','width=600,height=400');" title="Editar o Modificar" style="background: rgba(59, 130, 246, 0.1) !important; border: 1px solid rgba(59, 130, 246, 0.3) !important; border-radius: 4px !important; width: 32px !important; height: 32px !important; cursor: pointer !important; display: inline-flex !important; align-items: center !important; justify-content: center !important; transition: all 0.2s !important;">
                               <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 20h9"></path>
                                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                               </svg>
                          </button>
                          <?php }?>               <?php  }?> </td>
                <td width="30"><?php if (($row_listar_destinos['entradas_id']<=0)){ ?>
                          <button name="bdesactivar" type="button" class="btn-action btn-disable" onclick="desactivar01('<?php echo $row_listar_destinos['id']; ?>','<?php echo $row_listar_destinos['cod_depderivador']; ?>','inactivo<?php echo $row_listar_destinos['nro_destino']; ?>');" title="Desactivar Destino" style="background: rgba(239, 68, 68, 0.1) !important; border: 1px solid rgba(239, 68, 68, 0.3) !important; border-radius: 4px !important; width: 32px !important; height: 32px !important; cursor: pointer !important; display: inline-flex !important; align-items: center !important; justify-content: center !important; transition: all 0.2s !important;">
                               <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                </svg>
                          </button>
                          <?php }?>                </td>
                <td width="30"><?php if (($row_listar_destinos['entradas_id']<=0)&&($row_listar_destinos['nro_destino']==$row_obtener_hr['cont_destinos'])&&($row_listar_destinos['fecha_activa']==$dia_actual)){ //modificar 2023?>
                          <button name="eliminar" type="button" class="btn-action btn-delete" onclick="eliminar('<?php echo $row_listar_destinos['id']; ?>','<?php echo $row_obtener_hr['cod']; ?>','<?php echo $row_obtener_hr['cont_destinos']; ?>');" title="Eliminar Destino" style="background: rgba(239, 68, 68, 0.1) !important; border: 1px solid rgba(239, 68, 68, 0.3) !important; border-radius: 4px !important; width: 32px !important; height: 32px !important; cursor: pointer !important; display: inline-flex !important; align-items: center !important; justify-content: center !important; transition: all 0.2s !important;">
                               <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                               </svg>
                          </button>
                          <?php }?></td>
              </tr>
              <tr>
                <td width="30">&nbsp;</td>
                <td width="30">&nbsp;</td>
                <td width="30">&nbsp;</td>
              </tr>
            </table></td>
            <td width="95"><?php if ($row_listar_destinos['entradas_id']>0){ ?>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:middle; margin-right:4px;"><polyline points="20 6 9 17 4 12"></polyline></svg><span class="text-green-label">Entregado</span>
                    <?php }else{?>
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:middle; margin-right:4px;"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg><span class="text-red-label">No Entregado</span>
              <?php }?>
                    <br />
                    <?php if($row_obtener_hr['cont_destinos']==$row_listar_destinos['nro_destino']){?>
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:middle; margin-right:4px;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg><span class="text-orange-label">Procesando</span>
                    <?php }else { ?>
              <?php if($row_listar_destinos['nro_destino']<$row_obtener_hr['cont_destinos']){?>
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:middle; margin-right:4px;"><polyline points="13 17 18 12 13 7"></polyline><polyline points="6 17 11 12 6 7"></polyline></svg><span class="text-blue-label">Trasladado</span>
              <?php }?>
                    <?php }?>
                    <div id="inactivo<?php echo $row_listar_destinos['nro_destino']; ?>">&nbsp;</div></td>
          </tr>
          <?php $i++;?>
          <?php } while ($row_listar_destinos = mysql_fetch_assoc($listar_destinos)); ?>
          <?php } // Show if recordset not empty ?>
          <tr>
            <td width="25">&nbsp;</td>
            <td width="150">&nbsp;</td>
            <td>&nbsp;</td>
            <td width="70">&nbsp;</td>
            <td width="100">&nbsp;</td>
            <td width="100">&nbsp;</td>
            <td width="100">&nbsp;</td>
            <td width="95">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <?php } // Show if recordset not empty ?>
      <?php if ($totalRows_obtener_hr == 0) { // Show if recordset empty ?>
      <tr class="titulos">
        <td>Lo siento la HOJA DE RUTA no existe, verifique e intente nuevamente</td>
      </tr>
      <?php } // Show if recordset empty ?>
    </table></td>
  </tr>
</table>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {validateOn:["blur", "change"], maxChars:2, minChars:1, hint:"4", minValue:4, maxValue:33, useCharacterMasking:true});
//-->
mostrar_salidas();
estadias();
</script>
</body>
</html>
<?php
mysql_free_result($obtener_hr);

mysql_free_result($listar_destinos);
?>