<?php 
session_name("LoginSIRC");
session_start();
header("Content-Type: text/html; charset=utf-8");
//echo  "dep:".$_SESSION['dep']
//$cod_dep=$_SESSION['cod_dep'];
//echo  "dep:".$cod_dep;
?>
<?php require_once('../Connections/snet.php'); ?>
<?php
date_default_timezone_set("America/La_Paz"); 
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

//$gestion=date("Y");
$partes=split(" ",$_POST['fech_recib']);
$pfecha=split("-",$partes[0]); //fecha en partes
$gestion=$pfecha[0];

if(isset($_POST['hr']))
{ 
   if ($_POST['hr']!="")
   $hoja_ruta=$_POST['cod_deprecib']."-".$_POST['hr']."/".$gestion;
  else
    $hoja_ruta="";
}


$repetido_verificarHR =$hoja_ruta;

mysql_select_db($database_snet, $snet);
$query_verificarHR = sprintf("SELECT einterna.HR FROM einterna WHERE einterna.HR=%s", GetSQLValueString($repetido_verificarHR, "text"));
$verificarHR = mysql_query($query_verificarHR, $snet) or die(mysql_error());
$row_verificarHR = mysql_fetch_assoc($verificarHR);
$totalRows_verificarHR = mysql_num_rows($verificarHR);
 
if($totalRows_verificarHR>0){
   $error_repetido="Hoja de Ruta duplicada";
}
else{   

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO entradas (tema_titulo, usuario_cuenta, fecha_recibido, fun_recibido, dep_recibido, cod_deprecibido) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['tema'], "text"),
                       GetSQLValueString($_POST['usuario'], "text"),
                       GetSQLValueString($_POST['fech_recib'], "date"),
                       GetSQLValueString($_POST['fun_recib'], "text"),
                       GetSQLValueString($_POST['dep_recibido'], "text"),
                       GetSQLValueString($_POST['cod_deprecib'], "text"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($insertSQL, $snet) or die(mysql_error());
  $entrada_id=mysql_insert_id();
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO einterna (nhojas, anexos, entradas_id, entradas_tema_titulo, entradas_usuario_cuenta, cite, `ref`, dep_remite, fun_remite, hojaruta_codigo, fun_destino, dep_destino, fecha_doc, adjuntos, HR) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nhojas'], "int"),
                       GetSQLValueString($_POST['anexos'], "text"),
                       GetSQLValueString($entrada_id, "int"),
                       GetSQLValueString($_POST['tema'], "text"),
                       GetSQLValueString($_POST['usuario'], "text"),
                       GetSQLValueString($_POST['cite'], "text"),
                       GetSQLValueString($_POST['ref'], "text"),
                       GetSQLValueString($_POST['seg_d_destino'], "text"),
                       GetSQLValueString($_POST['seg_f_destino'], "text"),
                       GetSQLValueString($hoja_ruta, "text"),
                       GetSQLValueString($_POST['fun_destino'], "text"),
                       GetSQLValueString($_POST['dep_destino'], "text"),
                       GetSQLValueString($_POST['fecha_doc'], "date"),
                       GetSQLValueString($_POST['obs'], "text"),
                       GetSQLValueString($hoja_ruta, "text"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($insertSQL, $snet) or die(mysql_error());
  $einterna_id=mysql_insert_id();
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")&&($hoja_ruta!="")) {
  $insertSQL = sprintf("INSERT INTO hojaruta (cod, einterna_id, fecha_creacion, procedencia, `ref`, primer_destino, primerfun_destino, nhojas, nanexos, usuario_creador, cod_depcreador, cont_destinos, gestion) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($hoja_ruta, "text"),
                       GetSQLValueString($einterna_id, "int"),
                       GetSQLValueString($_POST['fech_recib'], "date"),
                       GetSQLValueString($_POST['seg_d_destino']." (".$_POST['seg_f_destino'].")", "text"),
                       GetSQLValueString($_POST['ref'], "text"),
                       GetSQLValueString($_POST['dep_destino'], "text"),
                       GetSQLValueString($_POST['fun_destino'], "text"),
                       GetSQLValueString($_POST['nhojas'], "int"),
                       GetSQLValueString($_POST['anexos'], "text"),
                       GetSQLValueString($_POST['usuario'], "text"),
                       GetSQLValueString($_POST['cod_deprecib'], "text"),
                       GetSQLValueString("1", "int"),
					   GetSQLValueString($gestion, "text"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($insertSQL, $snet) or die(mysql_error());
}

//eligiendo el mayor numero de HOJA DE RUTA
//1º verificando si El numero ingresado es mayor al del FOLIO.

if (GetSQLValueString($_POST['hr'], "int")>GetSQLValueString($_POST['ult_num'], "int"))
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1") && ($Result1)) {
  $updateSQL = sprintf("UPDATE dependencia SET cont_HR=%s WHERE cod=%s",
                       GetSQLValueString($_POST['hr'], "int"),
                       GetSQLValueString($_POST['cod_deprecib'], "text"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($updateSQL, $snet) or die(mysql_error());
}

}

$colname_cumpas = "-1";
if (isset($_SESSION['cod_dep'])) {
  $colname_cumpas = $_SESSION['cod_dep'];
}
mysql_select_db($database_snet, $snet);
$query_cumpas = sprintf("SELECT nombre FROM funcionario WHERE dependencia_cod = %s and habilitado = 1 ORDER BY cargo ASC", GetSQLValueString($colname_cumpas, "text"));
$cumpas = mysql_query($query_cumpas, $snet) or die(mysql_error());
$row_cumpas = mysql_fetch_assoc($cumpas);
$totalRows_cumpas = mysql_num_rows($cumpas);


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="css/theme_variables.css" rel="stylesheet" type="text/css" />
<script src="js/theme_switcher.js" type="text/javascript"></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Registro ENTRADA::INTERNA</title>

<script src="js/calendario.js" type="text/javascript"></script>
<link href="js/calendario.css?v=3" rel="stylesheet" type="text/css" />
<script src="js/prototype.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script type="text/javascript" src="js/scriptaculous/prototype.js"></script>
<script type="text/javascript" src="js/scriptaculous/scriptaculous.js"></script>
<script type="text/javascript" src="js/scriptaculous/effects.js"></script>
<script type="text/javascript" src="../includes/kore/kore.js"></script>
<script type="text/javascript" src="../includes/jaxon/widgets/dialog/js/dialog.js"></script>
<link href="../includes/jaxon/widgets/dialog/css/dialog.css" rel="stylesheet" type="text/css" />

<script language="javascript">
 function mensaje(){
     new Widgets.Dialog('Intento de Hoja de ruta DUPLICADA', 'tooltip_hr_repetido.php', { click_outside: true, width: 300, height: 185 });
}

function confirmarGuardar(){
     var form = document.getElementById('form1');
     var valid = Spry.Widget.Form.validate(form);
     if (!valid) {
          return false;
     }
     var jsCallback = "document.getElementById('form1').submit()";
     new Widgets.Dialog('Confirmar Registro', 'postales/dialog_confirmar.php?msg=' + encodeURIComponent('¿Está seguro de guardar este registro de correspondencia?') + '&ok=' + encodeURIComponent(jsCallback), { click_outside: true, width: 380, height: 220 });
     return false;
}
		function temas(){
     var url = 'selec_temas.php';
	 var myRand = parseInt(Math.random()*999999999999999);

     var pars = 'jose='+escape($F('tema'));
	 var pars = pars+"&rand="+myRand;
     var target = 'spry_tema';
     var miAjax = new Ajax.Updater(target, url, {method: 'get', parameters: pars});
}
		function tipos(){
     var url = 'selec_tipos.php';
	 var myRand = parseInt(Math.random()*999999999999999);

     var pars = 'jose='+escape($F('tema'));
	 var pars = pars+"&rand="+myRand;
     var target = 'spry_tipo';
     var miAjax = new Ajax.Updater(target, url, {method: 'get', parameters: pars});
}
	 function ultimoHR(){
     var url = 'ajax/ultimoHR.php';
	 var myRand = parseInt(Math.random()*999999999999999);  
	 var pars = "rand="+myRand;
     var target = 'ultimo_hr';
     var miAjax = new Ajax.Updater(target, url, {method: 'get', parameters: pars});
}

	 function colocarHR(){
	 var codigo=$('ultimo_hr').innerHTML;
	 var numero=codigo.split("-");
	 $('hr').value=parseInt(numero[1])+1;
}

	function ultimoHR1(){
     var url = 'ajax/ultimoHR.php';
	 var myRand = parseInt(Math.random()*999999999999999);  
	 var pars = "rand="+myRand;
     var target = 'ultimo_hr';
     var miAjax = new Ajax.Updater(target, url, {method: 'get', parameters: pars, onComplete: showResponse});
}
	function showResponse(originalRequest)
	{
		$('hr').value="";
		var codigo=originalRequest.responseText;
	    var numero=codigo.split("-");
	   $('hr').value=parseInt(numero[1])+1;
}
	function foliador(){
     var url = 'ajax/folio_HR.php';
	 var myRand = parseInt(Math.random()*999999999999999);  
	 var pars = "rand="+myRand;
     var target = 'ultimo_hr';
     var miAjax = new Ajax.Updater(target, url, {method: 'get', parameters: pars, onComplete: MostrarCodHR});
}
	function MostrarCodHR(originalRequest)
	{
		$('hr').value="";
		var numero=originalRequest.responseText;
	   $('tempHr').value=parseInt(numero);
	   $('hr').value=parseInt(numero)+1;
}

     function inicio(){
		try { temas(); tipos(); } catch(e) {}
		$('seg_f_destino').select();
		$('seg_f_destino').focus();
}
		</script>
        <script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
function MM_popupMsg(msg) { //v1.0
  alert(msg);
}
function MM_showHideLayers() { //v9.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) 
  with (document) if (getElementById && ((obj=getElementById(args[i]))!=null)) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}
function MM_effectShake(targetElement)
{
	Spry.Effect.DoShake(targetElement);
}
function MM_effectGrowShrink(targetElement, duration, from, to, toggle, referHeight, growFromCenter)
{
	Spry.Effect.DoGrow(targetElement, {duration: duration, from: from, to: to, toggle: toggle, referHeight: referHeight, growCenter: growFromCenter});
}
function MM_openBrWindow(theURL,winName,features) { //v2.0 - Centrado Automatico SIGAPO
  var featStr = (typeof features === 'string' && features.length > 0) ? features : 'menubar=yes,scrollbars=yes,resizable=yes,width=850,height=550';
  var wMatch = featStr.match(/width\s*=\s*(\d+)/i);
  var hMatch = featStr.match(/height\s*=\s*(\d+)/i);
  var w = wMatch ? parseInt(wMatch[1], 10) : 850;
  var h = hMatch ? parseInt(hMatch[1], 10) : 550;
  var availW = (window.screen && (window.screen.availWidth || window.screen.width)) || 1366;
  var availH = (window.screen && (window.screen.availHeight || window.screen.height)) || 768;
  var left = Math.max(0, Math.round((availW - w) / 2));
  var top  = Math.max(0, Math.round((availH - h) / 2));
  var parts = featStr.split(',');
  var clean = [];
  for (var i = 0; i < parts.length; i++) {
    var p = parts[i].replace(/^\s+|\s+$/g, '');
    if (!p || /^(left|top|screenX|screenY)\s*=/i.test(p)) continue;
    clean.push(p);
  }
  clean.push('left=' + left);
  clean.push('top=' + top);
  var win = window.open(theURL, winName || '', clean.join(','));
  if (win) { try { win.moveTo(left, top); win.focus(); } catch(e) {} }
}
function presionarENTER(obj){
if (ord(form1.obj.value)==13) {document.form1.submit()}
}

//-->
</script>
<style type="text/css">
body {
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     background-color: #1a080c !important;
     color: #f8fafc !important;
     margin: 6px 10px !important;
     padding: 0 !important;
     font-size: 12px !important;
}
fieldset {
     background-color: #280d14 !important;
     border: 1px solid rgba(180, 138, 40, 0.38) !important;
     border-radius: 8px !important;
     padding: 8px 12px 10px 12px !important;
     margin-bottom: 6px !important;
     box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3) !important;
}
legend {
     color: #ffffff !important;
     font-weight: 700 !important;
     font-size: 10px !important;
     text-transform: uppercase !important;
     letter-spacing: 0.6px !important;
     background: linear-gradient(135deg, #50000e 0%, #780016 100%) !important;
     border: 1px solid rgba(180, 138, 40, 0.55) !important;
     padding: 3px 10px !important;
     border-radius: 4px !important;
}
table {
     border: none !important;
     border-collapse: collapse !important;
}
table td {
     color: #f1f5f9 !important;
     padding: 4px 5px !important;
     font-size: 12px !important;
     background-color: transparent !important;
     vertical-align: middle !important;
}
table td strong, .field-label {
     color: #ffffff !important;
     font-weight: 600 !important;
     white-space: nowrap !important;
}

/* Inputs, Selects y Textareas en Modo Oscuro (Opción 1: Guindo Profundo #140508 y letras blancas) */
input[type="text"], input[type="password"], textarea, select {
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     background-color: #140508 !important;
     border: 1px solid rgba(180, 138, 40, 0.42) !important;
     border-radius: 6px !important;
     color: #ffffff !important;
     padding: 6px 10px !important;
     font-size: 12px !important;
     outline: none !important;
     transition: border-color 0.2s, box-shadow 0.2s, background-color 0.2s !important;
     box-sizing: border-box !important;
}
input[type="text"]::placeholder, textarea::placeholder {
     color: rgba(226, 232, 240, 0.45) !important;
}
select option {
     background-color: #1a080c !important;
     color: #ffffff !important;
}
input[type="text"]:focus, input[type="password"]:focus, textarea:focus, select:focus {
     border-color: #b48a28 !important;
     box-shadow: 0 0 0 3px rgba(180, 138, 40, 0.22) !important;
     background-color: #1a070b !important;
}

/* Campos de solo lectura (readonly / disabled), excepto el selector de fecha #fecha_doc */
input[readonly]:not(#fecha_doc), input[disabled] {
     background-color: rgba(20, 5, 8, 0.55) !important;
     border: 1px dashed rgba(180, 138, 40, 0.32) !important;
     color: #cbd5e1 !important;
     cursor: default !important;
}

/* Botones de acción secundarios */
.botoncitos, .botoncitos2, .botones, .botoneslive, .botones1, .buscar, .ultimohr {
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     font-size: 10px !important;
     font-weight: 700 !important;
     color: #ffffff !important;
     background: linear-gradient(135deg, #50000e 0%, #780016 100%) !important;
     border: 1px solid rgba(180, 138, 40, 0.45) !important;
     border-radius: 6px !important;
     height: 28px !important;
     padding: 0 12px !important;
     cursor: pointer !important;
     box-shadow: 0 2px 5px rgba(0, 0, 0, 0.35) !important;
     transition: transform 0.1s, box-shadow 0.2s, border-color 0.2s !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     display: inline-flex !important;
     align-items: center !important;
     justify-content: center !important;
     white-space: nowrap !important;
}
.botoncitos:hover, .botoncitos2:hover, .botones:hover, .botoneslive:hover, .buscar:hover, .ultimohr:hover {
     background: linear-gradient(135deg, #680014 0%, #8f001a 100%) !important;
     border-color: #b48a28 !important;
     box-shadow: 0 4px 10px rgba(120, 0, 22, 0.5) !important;
}
.botoncitos:active, .botoncitos2:active, .botones:active, .buscar:active, .ultimohr:active {
     transform: scale(0.97) !important;
}

/* Badge informativo del último número de HR (oculto cuando está vacío) */
.badge-ultimo-hr {
     display: inline-flex !important;
     align-items: center !important;
     justify-content: center !important;
     height: 28px !important;
     padding: 0 10px !important;
     background-color: #140508 !important;
     border: 1px solid rgba(180, 138, 40, 0.45) !important;
     border-radius: 6px !important;
     color: #ffffff !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     min-width: 44px !important;
}
.badge-ultimo-hr:empty {
     display: none !important;
}

/* Textareas de Anexos y Observaciones limpias y al 100% de ancho */
.anexos, .obs {
     width: 100% !important;
     background-image: none !important;
     padding: 6px 10px !important;
     resize: vertical !important;
     line-height: 1.4 !important;
}

.cuadro_blanco {
     background-color: #1f0a10 !important;
     border: 1px solid rgba(180, 138, 40, 0.28) !important;
     border-radius: 8px !important;
     padding: 6px 8px !important;
     color: #f8fafc !important;
}
.cuadro_superior {
     background-color: transparent !important;
     border: none !important;
}

/* Botón Principal Guardar */
.guardar {
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     background: linear-gradient(135deg, #059669 0%, #047857 100%) !important;
     border: 1px solid rgba(180, 138, 40, 0.45) !important;
     color: #ffffff !important;
     font-size: 12px !important;
     font-weight: 700 !important;
     width: auto !important;
     min-width: 280px !important;
     height: 34px !important;
     padding: 0 24px !important;
     margin: 4px 0 !important;
     border-radius: 8px !important;
     cursor: pointer !important;
     box-shadow: 0 4px 10px rgba(4, 120, 87, 0.35) !important;
     transition: transform 0.1s, box-shadow 0.2s !important;
     text-transform: uppercase !important;
     letter-spacing: 0.6px !important;
}
.guardar:hover {
     box-shadow: 0 6px 14px rgba(4, 120, 87, 0.5) !important;
     background: linear-gradient(135deg, #065f46 0%, #059669 100%) !important;
}
.guardar:active {
     transform: scale(0.98) !important;
}

/* Autocomplete desplegable */
div.autocomplete {
     position: absolute !important;
     width: 280px !important;
     background-color: #280d14 !important;
     border: 1px solid #b48a28 !important;
     border-radius: 6px !important;
     box-shadow: 0 10px 20px rgba(0, 0, 0, 0.6) !important;
     overflow-y: auto !important;
     max-height: 180px !important;
     z-index: 2000 !important;
}
div.autocomplete ul {
     list-style-type: none !important;
     margin: 0 !important;
     padding: 0 !important;
}
div.autocomplete ul li {
     padding: 8px 12px !important;
     color: #f1f5f9 !important;
     cursor: pointer !important;
     font-size: 12px !important;
     border-bottom: 1px solid rgba(180, 138, 40, 0.15) !important;
     text-align: left !important;
}
div.autocomplete ul li.selected,
div.autocomplete ul li:hover {
     background: linear-gradient(135deg, #50000e 0%, #780016 100%) !important;
     color: #ffffff !important;
}

/* Ocultar textos de validación antiguos */
.textfieldRequiredMsg, .textfieldMinCharsMsg, .textfieldMaxCharsMsg, .textfieldInvalidFormatMsg, .selectRequiredMsg {
     display: none !important;
}

/* Resaltar borde cuando falla la validación */
.textfieldRequiredState input, 
.textfieldRequiredState textarea, 
.textfieldRequiredState select,
.textfieldInvalidFormatState input,
.textfieldMinCharsState input,
.selectRequiredState select {
     border-color: #ef4444 !important;
     box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.25) !important;
}

.error {
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     font-size: 12px !important;
     color: #fecaca !important;
     background-color: rgba(120, 0, 22, 0.45) !important;
     border: 1px solid #ef4444 !important;
     padding: 8px 12px !important;
     border-radius: 6px !important;
     margin-bottom: 4px !important;
}

/* Controles de ancho y alineación */
#cite, #ref {
     width: 100% !important;
}
.inline-select-row {
     display: flex !important;
     align-items: center !important;
     gap: 6px !important;
     width: 100% !important;
}
.inline-select-row #spry_tema,
.inline-select-row #spry_tipo {
     flex: 1 1 auto !important;
     display: block !important;
}
#tema, #tipo {
     width: 100% !important;
}
#fun_recib, #fech_recib {
     width: 100% !important;
}
#fecha_doc {
     width: 125px !important;
     cursor: pointer !important;
     text-align: center !important;
     font-weight: 600 !important;
}
#nhojas {
     width: 90px !important;
     text-align: center !important;
     font-weight: 600 !important;
}
img[alt="calendario"] {
     display: none !important;
}
.right-column-fieldset {
     padding: 8px 12px !important;
}
.recibido-fieldset {
     margin-top: 6px !important;
}

/* =========================================================================
   ADAPTACIÓN MODO CLARO (PALETA INSTITUCIONAL GADOR)
   ========================================================================= */
html[data-theme="light"] body,
body[data-theme="light"],
:root:not([data-theme="dark"]) body {
     background-color: #f4f1ea !important;
     color: #1e293b !important;
}

html[data-theme="light"] fieldset,
body[data-theme="light"] fieldset,
:root:not([data-theme="dark"]) fieldset {
     background-color: #ffffff !important;
     border: 1px solid rgba(104, 0, 20, 0.22) !important;
     box-shadow: 0 4px 12px rgba(104, 0, 20, 0.06) !important;
}

html[data-theme="light"] .cuadro_blanco,
body[data-theme="light"] .cuadro_blanco,
:root:not([data-theme="dark"]) .cuadro_blanco {
     background-color: transparent !important;
     border: none !important;
     padding: 0 !important;
}

html[data-theme="light"] table td,
body[data-theme="light"] table td,
:root:not([data-theme="dark"]) table td,
html[data-theme="light"] table td strong,
body[data-theme="light"] table td strong,
:root:not([data-theme="dark"]) table td strong,
html[data-theme="light"] .field-label,
body[data-theme="light"] .field-label,
:root:not([data-theme="dark"]) .field-label {
     color: #4a000d !important;
}

html[data-theme="light"] input[type="text"],
html[data-theme="light"] input[type="password"],
html[data-theme="light"] textarea,
html[data-theme="light"] select,
body[data-theme="light"] input[type="text"],
body[data-theme="light"] input[type="password"],
body[data-theme="light"] textarea,
body[data-theme="light"] select,
:root:not([data-theme="dark"]) input[type="text"],
:root:not([data-theme="dark"]) input[type="password"],
:root:not([data-theme="dark"]) textarea,
:root:not([data-theme="dark"]) select {
     background-color: #ffffff !important;
     border: 1px solid #cbd5e1 !important;
     color: #1e293b !important;
}

html[data-theme="light"] input[type="text"]::placeholder,
html[data-theme="light"] textarea::placeholder,
:root:not([data-theme="dark"]) input[type="text"]::placeholder,
:root:not([data-theme="dark"]) textarea::placeholder {
     color: #94a3b8 !important;
}

html[data-theme="light"] select option,
:root:not([data-theme="dark"]) select option {
     background-color: #ffffff !important;
     color: #1e293b !important;
}

html[data-theme="light"] input[type="text"]:focus,
html[data-theme="light"] textarea:focus,
html[data-theme="light"] select:focus,
:root:not([data-theme="dark"]) input[type="text"]:focus,
:root:not([data-theme="dark"]) textarea:focus,
:root:not([data-theme="dark"]) select:focus {
     border-color: #680014 !important;
     box-shadow: 0 0 0 3px rgba(104, 0, 20, 0.14) !important;
     background-color: #ffffff !important;
}

html[data-theme="light"] input[readonly]:not(#fecha_doc),
html[data-theme="light"] input[disabled],
:root:not([data-theme="dark"]) input[readonly]:not(#fecha_doc),
:root:not([data-theme="dark"]) input[disabled] {
     background-color: #f4f1ea !important;
     border: 1px dashed rgba(104, 0, 20, 0.28) !important;
     color: #475569 !important;
}

html[data-theme="light"] .badge-ultimo-hr,
:root:not([data-theme="dark"]) .badge-ultimo-hr {
     background-color: #f4f1ea !important;
     border: 1px solid #b48a28 !important;
     color: #50000e !important;
}

html[data-theme="light"] div.autocomplete,
:root:not([data-theme="dark"]) div.autocomplete {
     background-color: #ffffff !important;
     border: 1px solid #b48a28 !important;
     box-shadow: 0 10px 20px rgba(80, 0, 14, 0.15) !important;
}

html[data-theme="light"] div.autocomplete ul li,
:root:not([data-theme="dark"]) div.autocomplete ul li {
     color: #1e293b !important;
}
</style>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />


</head>

 <body onload="inicio();">
<form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST" onsubmit="return confirmarGuardar();">
  <table width="100%" border="0">
    <tr>
      <td style="padding:0 !important;">  <?php if ($error_repetido){ ?>
       	<script type="text/javascript">		      
			  mensaje();
		</script>
	  <?php }?>
      </td>
    </tr>
    <tr>
      <td style="padding:0 !important;"><table width="100%" border="0">
        <tr class="cuadro_superior">
          <td style="vertical-align:top !important; padding-right:6px !important;"><fieldset>
            <legend>Origen - Destino</legend>
            <table width="100%" border="0">
              <tr>
                <td width="42" class="field-label">De:</td>
                <td width="235" style="position:relative;"><span id="sprytextfield1">
                  <input name="seg_f_destino" type="text" id="seg_f_destino" style="width:100%;" placeholder="Nombre del remitente..." value="<?php if ($error_repetido){ echo $_POST['seg_f_destino']; }?>"/>
                  <div id="lista_opciones" class="autocomplete" style="display:none;"></div>
                  <span class="textfieldRequiredMsg">X</span></span>
                  <span id="preload" style="display: none">
                    <img src="imagen/loading.gif" alt="Cargando..." /><span class="Estilo1">Cargando...</span>
                  </span>
                  <script type="text/javascript">
					new Ajax.Autocompleter("seg_f_destino", "lista_opciones", "ajax/fun_remitente.php", {
                         method: "post",
                         paramName: "nombre"
                    });
    			  </script>
                </td>
                <td>
                  <table width="100%" border="0">
                    <tr>
                      <td style="position:relative; padding-left:0 !important;"><span id="sprytextfield2"><label>
                        <input name="seg_d_destino" type="text" id="seg_d_destino" style="width:100%;" placeholder="Unidad o dependencia remitente..." value="<?php if ($error_repetido){ echo $_POST['seg_d_destino']; }?>"/></label>
                        <div id="lista_opciones_dep" class="autocomplete" style="display:none;"></div>
                        <span class="textfieldRequiredMsg">X</span></span>
                        <script type="text/javascript">
					     new Ajax.Autocompleter("seg_d_destino", "lista_opciones_dep", "ajax/dep_remitente.php", {
                              method: "post",
                              paramName: "nombre"
                         });
    			        </script>
                      </td>
                      <td width="90" style="padding-right:0 !important;"><input name="button5" type="button" class="buscar" id="button5" style="width:100%;" onclick="MM_openBrWindow('insert_fun_Destino3.php','','width=620,height=315')" value="🔍 Buscar" /></td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td class="field-label">Para:</td>
                <td><span id="spryselect1">
                  <select name="fun_destino" id="fun_destino" style="width:100%;">
                    <option value="Todos">Todos</option>
                    <?php
do {  
?>
                    <option value="<?php echo htmlentities($row_cumpas['nombre'])?>"><?php echo htmlentities($row_cumpas['nombre'])?></option>
                    <?php
} while ($row_cumpas = mysql_fetch_assoc($cumpas));
  $rows = mysql_num_rows($cumpas);
  if($rows > 0) {
      mysql_data_seek($cumpas, 0);
	  $row_cumpas = mysql_fetch_assoc($cumpas);
  }
?>
                  </select>
                  <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
                <td><input name="dep_destino" type="text" id="dep_destino" style="width:100%;" value="<?php echo $_SESSION['dep']; ?>" size="35" readonly="READONLY" title="Dependencia receptora (automático)" /></td>
              </tr>
            </table>
          </fieldset></td>
          <td width="230" style="vertical-align:top !important; padding-left:0 !important;"><fieldset>
            <legend>Hoja de Ruta</legend>
            <table width="100%" border="0">
              <tr>
                <td width="38" class="field-label">Nro:</td>
                <td><span id="sprytextfield3">
                <input name="hr" type="text" id="hr" style="width:100%; font-weight:700; text-align:center;" placeholder="Automático" value="<?php if ($error_repetido){ echo "DUPLICADO"; }?>" readonly="READONLY"/>
                <span class="textfieldInvalidFormatMsg">x.</span> <span class="textfieldRequiredMsg">esta vacio.</span></span>
                <input name="tempHr" type="hidden" id="tempHr" value="0" />
                </td>
              </tr>
              <tr>
                <td colspan="2">
                  <div style="display:flex; align-items:center; justify-content:flex-end; gap:6px;">
                    <div class="badge-ultimo-hr" id="ultimo_hr" title="Última Hoja de Ruta registrada"></div>
                    <input name="codigo" type="button" class="ultimohr" id="codigo" style="flex:1;" onclick="foliador();" value="🔢 Foliador" />
                  </div>
                </td>
              </tr>
            </table>
          </fieldset></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td style="padding:0 !important;"><table width="100%" border="0" class="cuadro_blanco">
        <tr>
          <td width="56%" style="vertical-align:top !important; padding-right:6px !important;"><fieldset>
            <legend>Datos de la Correspondencia</legend>
            <table width="100%" border="0">
              <tr>
                <td width="65" class="field-label">Fech.Doc:</td>
                <td>
                  <div style="display:flex; align-items:center; justify-content:space-between; gap:10px; width:100%;">
                    <div style="display:inline-flex; align-items:center; gap:4px;">
                      <span id="sprytextfield8">
                        <input name="fecha_doc" type="text" id="fecha_doc" size="10" readonly="READONLY" placeholder="AAAA-MM-DD" title="Haga clic para elegir fecha" onclick="displayCalendarFor('fecha_doc');" value="<?php if ($error_repetido){ echo $_POST['fecha_doc']; }?>"/>
                        <span class="textfieldRequiredMsg">X.</span>
                      </span>
                      <button type="button" onclick="displayCalendarFor('fecha_doc');" title="Seleccionar fecha" style="display:inline-flex; align-items:center; justify-content:center; height:28px; width:30px; padding:0; background:linear-gradient(135deg,#50000e 0%,#780016 100%); border:1px solid rgba(180,138,40,0.45); border-radius:6px; color:#ffffff; cursor:pointer;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg></button>
                    </div>
                    <div style="display:inline-flex; align-items:center; gap:6px;">
                      <span class="field-label">Hojas:</span>
                      <span id="sprytextfield6">
                        <input name="nhojas" type="text" id="nhojas" size="8" maxlength="5" placeholder="Ej: 1" value="<?php if ($error_repetido){ echo $_POST['nhojas']; }?>"/>
                        <span class="textfieldRequiredMsg">X.</span><span class="textfieldInvalidFormatMsg">incorrecto.</span>
                      </span>
                    </div>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="field-label">Cite:</td>
                <td><span id="sprytextfield4" style="display:block; width:100%;">
                  <input name="cite" type="text" id="cite" placeholder="Código o número de CITE del documento..." value="<?php if ($error_repetido){ echo $_POST['cite']; }?>"/>
                  <span class="textfieldRequiredMsg">X.</span></span></td>
              </tr>
              <tr>
                <td class="field-label">Ref.:</td>
                <td><span id="sprytextfield5" style="display:block; width:100%;">
                <script language="JavaScript">
    function conMayusculas(field) {
            field.value = field.value.toUpperCase()
}
</script>
                <input name="ref" type="text" id="ref" placeholder="Referencia o asunto principal del documento..." onChange="conMayusculas(this)" value="<?php if ($error_repetido){ echo $_POST['ref']; }?>"/>
                <span class="textfieldRequiredMsg">X.</span><span class="textfieldMinCharsMsg">(+)caracter..</span></span></td>
              </tr>
              <tr>
                <td class="field-label" style="vertical-align:top !important; padding-top:8px !important;">Anexos:</td>
                <td><textarea name="anexos" cols="35" rows="2" class="anexos" id="anexos"><?php if ($error_repetido){ echo $_POST['anexos']; }else{?>-
-<?php }?></textarea></td>
              </tr>
              <tr>
                <td class="field-label" style="vertical-align:top !important; padding-top:8px !important;">Obs.:</td>
                <td><textarea name="obs" cols="35" rows="3" class="obs" id="obs"><?php if ($error_repetido){ echo $_POST['obs']; }else{?>N.A.<?php }?></textarea></td>
              </tr>
            </table>
          </fieldset></td>
          <td width="44%" style="vertical-align:top !important; padding-left:0 !important;"><table width="100%" border="0">
            <tr>
              <td style="padding:0 !important;"><fieldset class="right-column-fieldset"><legend>Clasificación</legend>
                <table width="100%" border="0">
                  <tr>
                    <td width="65" class="field-label">Tema:</td>
                    <td>
                      <div class="inline-select-row">
                        <span id="spryselect2" style="flex:1;">
                          <div id="spry_tema">
                            <select name="tema" id="tema">
                              <option value="no tiene tema." selected="selected">no tiene tema.</option>
                            </select>
                          </div>
                          <span class="selectRequiredMsg">Seleccione un elemento.</span>
                        </span>
                        <input name="refresh_tema" type="button" class="botoncitos2" id="refresh_tema" title="Actualizar lista de temas" onclick="temas();" value="↻ Actualizar"/>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="field-label">Tipo.doc:</td>
                    <td>
                      <div class="inline-select-row">
                        <span id="spry_tipo" style="flex:1;">
                          <select name="tipo" id="tipo">
                            <option value="no definido.">no definido.</option>
                          </select>
                          <span class="selectRequiredMsg">Seleccione un elemento.</span>
                        </span>
                        <input name="refresh_tipo" type="button" class="botoncitos2" id="refresh_tipo" title="Actualizar tipos de documento" onclick="tipos();" value="↻ Actualizar"/>
                      </div>
                    </td>
                  </tr>
                </table>
              </fieldset></td>
            </tr>
            <tr>
              <td class="cuadro_superior" style="padding:0 !important;"><fieldset class="right-column-fieldset recibido-fieldset"><legend>Recibido</legend>
                <table width="100%" border="0">
                  <tr>
                    <td width="75" class="field-label">Fech.Recib.:</td>
                    <td><span id="sprytextfield7" style="display:block; width:100%;">
                      <input name="fech_recib" type="text" class="fechatime" id="fech_recib" value="<?php echo date("Y-m-d H:i:s"); ?>" size="20" readonly="READONLY"/>
                      <span class="textfieldRequiredMsg">X.</span></span></td>
                  </tr>
                  <tr>
                    <td class="field-label">Nom. Recib.:</td>
                    <td><input name="fun_recib" type="text" id="fun_recib" value="<?php echo htmlentities($_SESSION['fun']); ?>" size="25" readonly="READONLY" />
                      <input name="dep_recibido" type="hidden" id="dep_recibido" value="<?php echo $_SESSION['dep']; ?>" />
                      <input name="cod_deprecib" type="hidden" id="cod_deprecib" value="<?php echo $_SESSION['cod_dep']; ?>" />
                      <input name="usuario" type="hidden" id="usuario" value="<?php echo $_SESSION['user']; ?>" /></td>
                  </tr>
                </table>
              </fieldset></td>
            </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td style="padding-top:4px !important;"><div align="center">
        <input name="button" type="submit" class="guardar" id="button" value="✓ Guardar Registro de Correspondencia" />
      </div></td>
    </tr>
  </table>

<input type="hidden" name="MM_insert" value="form1" />
<input type="hidden" name="MM_update" value="form1" />
</form>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "integer", {validateOn:["blur", "change"], isRequired:false});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "none", {minChars:3});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "none", {validateOn:["blur"]});
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "integer");
var spryselect2 = new Spry.Widget.ValidationSelect("spry_tema", {validateOn:["blur", "change"]});
var spryselect3 = new Spry.Widget.ValidationSelect("spry_tipo", {validateOn:["blur", "change"]});
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8", "none", {validateOn:["blur"]});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($cumpas);

mysql_free_result($verificarHR);
?>
