<?php 
session_name("LoginSIRC");
session_start();
$cod_dep=$_SESSION['cod_dep'];
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formHR")) {
  $insertSQL = sprintf("INSERT INTO hojaruta (cod, salinternas_salidas_cite, fecha_creacion, dep_remite, fun_remite, `ref`, dep_destino, fun_destino, nhojas, nanexos) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['codigoHR'], "text"),
                       GetSQLValueString($_POST['cite'], "text"),
                       GetSQLValueString($_POST['fecha_doc'], "date"),
                       GetSQLValueString($_POST['dep_remite'], "text"),
                       GetSQLValueString($_POST['fun_remite'], "text"),
                       GetSQLValueString($_POST['ref'], "text"),
                       GetSQLValueString($_POST['dep_dest'], "text"),
                       GetSQLValueString($_POST['fun_dest'], "text"),
                       GetSQLValueString($_POST['nhojas'], "int"),
                       GetSQLValueString($_POST['nanexos'], "text"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($insertSQL, $snet) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formHR")) {
  $insertSQL = sprintf("INSERT INTO derivacion (hojaruta_cod, fun_destino, dep_destino, fecha_derivacion, proveido, mensaje) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['codigoHR'], "text"),
                       GetSQLValueString($_POST['seg_f_destino'], "text"),
                       GetSQLValueString($_POST['seg_d_destino'], "text"),
                       GetSQLValueString($_POST['hora_reg'], "date"),
                       GetSQLValueString($_POST['tmotivo'], "text"),
                       GetSQLValueString($_POST['mensaje'], "text"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($insertSQL, $snet) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formHR")&&(($_POST['siguiente']))) {
  $insertSQL = sprintf("INSERT INTO hojaruta (cod, salinternas_salidas_cite, fecha_creacion, dep_remite, fun_remite, `ref`, dep_destino, fun_destino, fecha_envio, nhojas, nanexos) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['codigoHR'], "text"),
                       GetSQLValueString($_POST['cite'], "text"),
                       GetSQLValueString($_POST['fecha_creacion'], "date"),
                       GetSQLValueString($_POST['dep_remite'], "text"),
                       GetSQLValueString($_POST['fun_remite'], "text"),
                       GetSQLValueString($_POST['ref'], "text"),
                       GetSQLValueString($_POST['dep_dest'], "text"),
                       GetSQLValueString($_POST['fun_dest'], "text"),
                       GetSQLValueString($_POST['fecha_creacion'], "date"),
                       GetSQLValueString($_POST['nhojas'], "int"),
                       GetSQLValueString($_POST['nanexos'], "int"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($insertSQL, $snet) or die(mysql_error());
}

$colname_list_hr = "-1";
if (isset($_POST['codHR'])) {
  $colname_list_hr = $_SESSION['cod_dep']."-".$_POST['codHR'];
}
mysql_select_db($database_snet, $snet);
$query_list_hr = sprintf("SELECT * FROM hojaruta WHERE cod = %s", GetSQLValueString($colname_list_hr, "text"));
$list_hr = mysql_query($query_list_hr, $snet) or die(mysql_error());
$row_list_hr = mysql_fetch_assoc($list_hr);
$totalRows_list_hr = mysql_num_rows($list_hr);

mysql_select_db($database_snet, $snet);
$query_list_destinos = "SELECT * FROM dependencia WHERE pd = 1 ORDER BY prioridad ASC";
$list_destinos = mysql_query($query_list_destinos, $snet) or die(mysql_error());
$row_list_destinos = mysql_fetch_assoc($list_destinos);
$totalRows_list_destinos = mysql_num_rows($list_destinos);

$colname_list_remite = "-1";
if (isset($_SESSION['cod_dep'])) {
  $colname_list_remite = $_SESSION['cod_dep'];
}
mysql_select_db($database_snet, $snet);
$query_list_remite = sprintf("SELECT nombre, dependencia_cod FROM funcionario WHERE dependencia_cod = %s ORDER BY cargo ASC", GetSQLValueString($colname_list_remite, "text"));
$list_remite = mysql_query($query_list_remite, $snet) or die(mysql_error());
$row_list_remite = mysql_fetch_assoc($list_remite);
$totalRows_list_remite = mysql_num_rows($list_remite);

mysql_select_db($database_snet, $snet);
$query_RecordOtrosDep = "SELECT cod, nombredep FROM dependencia WHERE pd = 0 ORDER BY nombredep ASC";
$RecordOtrosDep = mysql_query($query_RecordOtrosDep, $snet) or die(mysql_error());
$row_RecordOtrosDep = mysql_fetch_assoc($RecordOtrosDep);
$totalRows_RecordOtrosDep = mysql_num_rows($RecordOtrosDep);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Enviar Hoja de Ruta</title>
<style type="text/css">
body {
     background-color: transparent !important;
     color: #cbd5e1 !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     margin: 10px !important;
     padding: 0 !important;
}

/* Card Form Wrapper */
form#formHR {
     max-width: 700px;
     margin: 0 auto;
     background-color: #1e293b !important;
     border: 1px solid rgba(255, 255, 255, 0.1) !important;
     border-radius: 8px !important;
     padding: 20px !important;
     box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3) !important;
}

form#formHR table {
     width: 100% !important;
     border-collapse: collapse !important;
}

form#formHR td {
     padding: 8px 10px !important;
     color: #cbd5e1 !important;
     font-size: 13px !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
}

/* Titles */
.Estilo13 {
     color: #ffffff !important;
     font-size: 14px !important;
     font-weight: 700 !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
}

.subrayado {
     border-bottom: 2px solid rgba(255, 255, 255, 0.1) !important;
     padding-bottom: 6px !important;
     font-size: 12px !important;
     color: #3b82f6 !important;
     font-weight: 700 !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     margin-bottom: 10px !important;
}

/* Text Input CODIGO */
#cod {
     background-color: rgba(15, 23, 42, 0.6) !important;
     border: 1px solid rgba(255, 255, 255, 0.1) !important;
     border-radius: 6px !important;
     color: #ffffff !important;
     padding: 8px 12px !important;
     font-size: 13px !important;
     outline: none !important;
     transition: border-color 0.2s, box-shadow 0.2s !important;
     box-sizing: border-box !important;
     width: 180px !important;
}

#cod:focus {
     border-color: #2563eb !important;
     box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2) !important;
}

/* Llenar button styling */
input[type="submit"] {
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     color: #ffffff !important;
     background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
     border: none !important;
     border-radius: 6px !important;
     padding: 8px 16px !important;
     cursor: pointer !important;
     box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2) !important;
     transition: all 0.2s !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
}

input[type="submit"]:hover {
     box-shadow: 0 4px 8px rgba(37, 99, 235, 0.3) !important;
     transform: translateY(-1px) !important;
}

input[type="submit"]:active {
     transform: translateY(1px) !important;
}

/* Autocomplete suggestion popup dropdown list styling */
div.autocomplete {
     position: absolute !important;
     background-color: #1e293b !important;
     border: 1px solid rgba(255, 255, 255, 0.1) !important;
     border-radius: 6px !important;
     box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4) !important;
     width: 200px !important;
     margin-top: 2px !important;
     padding: 0 !important;
     list-style: none !important;
     overflow-y: auto !important;
     max-height: 200px !important;
     z-index: 9999 !important;
}

div.autocomplete ul {
     margin: 0 !important;
     padding: 0 !important;
     list-style: none !important;
}

div.autocomplete li {
     padding: 8px 12px !important;
     color: #cbd5e1 !important;
     font-size: 12px !important;
     cursor: pointer !important;
     border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
}

div.autocomplete li:last-child {
     border-bottom: none !important;
}

div.autocomplete li:hover,
div.autocomplete li.selected {
     background-color: #2563eb !important;
     color: #ffffff !important;
}

/* Spry validation styling override */
.textfieldRequiredMsg,
.textfieldInvalidFormatMsg {
     display: none !important;
}

.textfieldRequiredState input,
.textfieldInvalidFormatState input {
     border-color: #ef4444 !important;
     background-color: #fff5f5 !important;
     color: #1e293b !important;
}

/* Alert Boxes Style Overrides */
.alert-box {
     display: flex !important;
     align-items: center !important;
     padding: 12px 16px !important;
     border-radius: 6px !important;
     margin: 5px 0 !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     font-size: 12px !important;
     line-height: 1.5 !important;
     width: 98% !important;
     box-sizing: border-box !important;
}

.alert-icon {
     display: flex !important;
     align-items: center !important;
     justify-content: center !important;
     margin-right: 12px !important;
     flex-shrink: 0 !important;
}

.alert-content {
     flex-grow: 1 !important;
     color: #cbd5e1 !important;
}

.alert-info {
     background-color: rgba(59, 130, 246, 0.08) !important;
     border: 1px solid rgba(59, 130, 246, 0.25) !important;
}

.alert-info .alert-content {
     color: #3b82f6 !important;
     font-weight: 600 !important;
}

.text-highlight {
     color: #ffffff !important;
     font-weight: 600 !important;
}

.text-date {
     color: #94a3b8 !important;
     font-size: 11px !important;
     margin-top: 4px !important;
}
</style>

<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>

<script type="text/javascript">
<!--
function MM_showHideLayers() { //v9.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) 
  with (document) if (getElementById && ((obj=getElementById(args[i]))!=null)) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}

function destinos(obj){
   if (obj.value!="-1")
   {
       document.getElementById('dep_dest').value=obj.value;
	   document.getElementById('fun_dest').value="A quien Corresponda";
	   document.getElementById('destinatario').innerHTML=obj.value;
   }
   else
    alert("ERROR: 404 destinatario no asignado correctamente.");
}
//-->

function confirmar()
{
   if (confirm('Esta seguro, de Registrar la Hoja de Ruta con los datos ingresados?'))
        document.getElementById('formHR').submit();
}
</script>
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<script src="js/prototype.js" language="javascript1.2"></script>
<script src="js/msgHR.js" language="javascript1.2"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>

<script type="text/javascript" src="js/scriptaculous/prototype.js"></script>
<script type="text/javascript" src="js/scriptaculous/scriptaculous.js"></script>
<script type="text/javascript" src="js/scriptaculous/effects.js"></script>
<link href="css/autocontempler.css" rel="stylesheet" type="text/css" />
</head>

<body onload="document.getElementById('cod').focus();" style="background-color: transparent !important;">
<form action="derivarHojaRutaDestinosv8.php" method="GET" name="formHR" target="_blank" id="formHR">
  <table width="100%" border="0" cellspacing="1" cellpadding="7">
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td><table width="100%" border="0" cellspacing="1" cellpadding="2">
            <tr>
              <td align="right" valign="middle">&nbsp;</td>
              <td valign="middle"><span class="Estilo13">Ingrese el c&oacute;digo de HOJA DE RUTA</span></td>
              <td valign="middle"><label></label></td>
            </tr>
            <tr>
              <td width="24%" align="right" valign="middle"><div align="right"></div></td>
              <td width="52%" valign="middle"><span id="sprytextfield1">
              CODIGO:&nbsp;
              <input type="text" name="cod" id="cod" />
              <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Invalido. Ingrese numero</span></span>
              <div id="lista_opciones" class="autocomplete" ></div>
              <script type="text/javascript">
					new Ajax.Autocompleter("cod", "lista_opciones", "ajax/HRs.php", {
					method: "get",
					paramName: "texto"});
    			</script>
              <div class="contenedor"><div id="lista" class="fill"></div></div></td>
              <td width="24%" valign="middle"><div align="right">
                <input name="Llenar Hoja de Ruta (2)" type="submit" id="Llenar Hoja de Ruta (2)" value="Llenado de Hoja de Ruta" />
              </div>
              <label>
              <div align="right">&nbsp;</div>
              </label></td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="1" cellpadding="2">
          <tr>
            <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
                <tr>
                  <td><div class="subrayado"></div></td>
                </tr>
            </table></td>
          </tr>
		  <tr>
			<td><div class="subrayado">Resultado de la comprobacion</div></td>
		  </tr>
		  <tr>
			<td>
			 <div id="muestra-resultado">
				  <div class="alert-box alert-info">
					   <div class="alert-icon">
							<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
								 <circle cx="12" cy="12" r="10"></circle>
								 <line x1="12" y1="16" x2="12" y2="12"></line>
								 <line x1="12" y1="8" x2="12.01" y2="8"></line>
							</svg>
					   </div>
					   <div class="alert-content">
							<span class="text-highlight">Inserte un c&oacute;digo de Hoja de Ruta.</span>
							<div class="text-date" style="color: #cbd5e1 !important; margin-top: 2px;">(Correspondencia INTERNA del Gobierno Departamental)</div>
					   </div>
				  </div>
			 </div>
			 </td>
		  </tr>
		</table></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>

<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur", "change"]});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($list_hr);
mysql_free_result($list_destinos);
mysql_free_result($list_remite);
mysql_free_result($RecordOtrosDep);
?>
