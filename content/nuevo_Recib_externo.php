<?php 
session_name("LoginSIRC");
session_start();
header("Content-Type: text/html; charset=utf-8");
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

if(isset($_POST['hr']))
{ 
   if ($_POST['hr']!="")
   $hoja_ruta=$_POST['cod_deprecib']."-".$_POST['hr'];
  else
    $hoja_ruta="";
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO eexterna (entradas_id, entradas_tema_titulo, entradas_usuario_cuenta, cite, `ref`, remitente, org_remitente, fecha_doc, fun_destino, dep_destino, HR) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($entrada_id, "int"),
                       GetSQLValueString($_POST['tema'], "text"),
                       GetSQLValueString($_POST['usuario'], "text"),
                       GetSQLValueString($_POST['cite'], "text"),
                       GetSQLValueString($_POST['ref'], "text"),
                       GetSQLValueString($_POST['tdest_nom'], "text"),
                       GetSQLValueString($_POST['tdest_org'], "text"),
                       GetSQLValueString($_POST['fecha_doc'], "text"),
                       GetSQLValueString($_POST['fun_destino'], "text"),
                       GetSQLValueString($_POST['dep_destino'], "text"),
                       GetSQLValueString($hoja_ruta, "text"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($insertSQL, $snet) or die(mysql_error());
  $eexterna_id=mysql_insert_id();  
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")&&($hoja_ruta!="")) {
  $insertSQL = sprintf("INSERT INTO hojaruta (cod, eexterna_id, fecha_creacion, procedencia, `ref`, primer_destino, primerfun_destino, nhojas, nanexos, usuario_creador, cod_depcreador, cont_destinos) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($hoja_ruta, "text"),
                       GetSQLValueString($eexterna_id, "int"),
                       GetSQLValueString($_POST['fech_recib'], "date"),
                       GetSQLValueString($_POST['tdest_org'], "text"),
                       GetSQLValueString($_POST['ref'], "text"),
                       GetSQLValueString($_POST['dep_destino'], "text"),
                       GetSQLValueString($_POST['fun_destino'], "text"),
                       GetSQLValueString($_POST['nhojas'], "int"),
                       GetSQLValueString($_POST['anexos'], "text"),
                       GetSQLValueString($_POST['usuario'], "text"),
                       GetSQLValueString($_POST['cod_deprecib'], "text"),
                       GetSQLValueString("1", "int"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($insertSQL, $snet) or die(mysql_error());
}

 
$colname_cumpas = "-1";
if (isset($_SESSION['cod_dep'])) {
  $colname_cumpas = $_SESSION['cod_dep'];
}
mysql_select_db($database_snet, $snet);
$query_cumpas = sprintf("SELECT nombre FROM funcionario WHERE dependencia_cod = %s ORDER BY cargo ASC", GetSQLValueString($colname_cumpas, "text"));
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
<title>Registro ENTRADA::EXTERNA</title>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />

<script src="js/calendario.js" type="text/javascript"></script>
<link href="js/calendario.css?v=3" rel="stylesheet" type="text/css" />
<link href="../includes/jaxon/widgets/dialog/css/dialog.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../includes/kore/kore.js"></script>
<script type="text/javascript" src="../includes/jaxon/widgets/dialog/js/dialog.js"></script>
<script src="js/prototype.js" type="text/javascript"></script>
<script language="javascript">
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
input[type="text"]:focus, textarea:focus, select:focus {
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

.barra {
     background: transparent !important;
     border: none !important;
}
.botoncitos, .botoncitos2, .botoncitos3, .botoncitos4, .botones {
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
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     display: inline-flex !important;
     align-items: center !important;
     justify-content: center !important;
     white-space: nowrap !important;
     box-shadow: 0 2px 5px rgba(0, 0, 0, 0.35) !important;
}
.botoncitos:hover, .botoncitos2:hover, .botoncitos3:hover, .botoncitos4:hover, .botones:hover {
     background: linear-gradient(135deg, #680014 0%, #8f001a 100%) !important;
     border-color: #b48a28 !important;
}
.guardar-ext {
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     background: linear-gradient(135deg, #059669 0%, #047857 100%) !important;
     border: 1px solid rgba(180, 138, 40, 0.45) !important;
     color: #ffffff !important;
     font-size: 12px !important;
     font-weight: 700 !important;
     min-width: 280px !important;
     height: 34px !important;
     padding: 0 24px !important;
     border-radius: 8px !important;
     cursor: pointer !important;
     box-shadow: 0 4px 10px rgba(4, 120, 87, 0.35) !important;
     text-transform: uppercase !important;
     letter-spacing: 0.6px !important;
}
.guardar-ext:hover {
     background: linear-gradient(135deg, #065f46 0%, #059669 100%) !important;
}
.cuadro_superior, .cuadro_inferior {
     background-color: transparent !important;
     border: none !important;
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
#tema, #tipo, #cite, #ref, #anexos, #obs, #fech_recib, #fun_recib {
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
.textfieldRequiredMsg, .textfieldInvalidFormatMsg, .selectRequiredMsg {
     display: none !important;
}
.textfieldRequiredState input, .textfieldRequiredState textarea, .textfieldRequiredState select, .textfieldInvalidFormatState input, .selectRequiredState select {
     border-color: #ef4444 !important;
     box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.25) !important;
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
html[data-theme="light"] table td,
body[data-theme="light"] table td,
:root:not([data-theme="dark"]) table td,
html[data-theme="light"] .field-label,
:root:not([data-theme="dark"]) .field-label {
     color: #4a000d !important;
}
html[data-theme="light"] input[type="text"],
html[data-theme="light"] input[type="password"],
html[data-theme="light"] textarea,
html[data-theme="light"] select,
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
html[data-theme="light"] input[readonly]:not(#fecha_doc),
html[data-theme="light"] input[disabled],
:root:not([data-theme="dark"]) input[readonly]:not(#fecha_doc),
:root:not([data-theme="dark"]) input[disabled] {
     background-color: #f4f1ea !important;
     border: 1px dashed rgba(104, 0, 20, 0.28) !important;
     color: #475569 !important;
}
</style>
</head>

<body onload="try{temas();tipos();}catch(e){}">
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>" onsubmit="return confirmarGuardar();">
  <table width="100%" border="0">
    <tr>
      <td style="padding:0 0 4px 0 !important;"><div align="justify" class="botoncitos2" style="width:100%; justify-content:space-between; padding: 6px 14px; height: auto; box-sizing:border-box;">
        <strong>FORM. 2b.- Registro de correspondencia de fuentes EXTERNAS a la Gobernaci&oacute;n</strong>
      </div></td>
    </tr>
    <tr>
      <td style="padding:0 !important;"><table width="100%" border="0" class="cuadro_superior">
        <tr>
          <td style="vertical-align:top !important; padding-right:6px !important;"><fieldset>
            <legend>Origen - Destino</legend>
            <table width="100%" border="0">
              <tr>
                <td width="45"><input name="de" type="button" class="botoncitos3" id="de" value="De:" title="Seleccionar organización remitente" onclick="MM_openBrWindow('buscarOrg.php','','left=150,top=130,width=550,height=380')"/></td>
                <td width="230"><span id="spry_funremitente" style="display:block; width:100%;">
                  <input name="tdest_nom" type="text" id="tdest_nom" style="width:100%;" placeholder="Nombre del remitente externo..." />
                  <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
                <td><span id="spry_depremitente" style="display:block; width:100%;">
                  <input name="tdest_org" type="text" id="tdest_org" style="width:100%;" placeholder="Institución u organización externa..." />
                  <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
                <td width="90" style="padding-right:0 !important;">
                  <input type="button" class="botoncitos2" style="width:100%;" value="🔍 Buscar" onclick="MM_openBrWindow('buscarOrg.php','','toolbar=no,status=no,width=550,height=380')" /></td>
              </tr>
              <tr>
                <td class="field-label">Para:</td>
                <td><span id="spryselect3" style="display:block; width:100%;">
                  <select name="fun_destino" id="fun_destino" style="width:100%;">
                    <option value="Todos">Todos</option>
                    <?php
do {  
?>
                    <option value="<?php echo $row_cumpas['nombre']?>"><?php echo $row_cumpas['nombre']?></option>
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
                <td colspan="2"><span id="spry_depdestino" style="display:block; width:100%;">
                  <input name="dep_destino" type="text" id="dep_destino" style="width:100%;" value="<?php echo $_SESSION['dep']; ?>" size="35" readonly="READONLY" />
                  <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
              </tr>
            </table>
          </fieldset></td>
          <td width="230" style="vertical-align:top !important; padding-left:0 !important;"><fieldset>
            <legend>Hoja de Ruta</legend>
            <table width="100%" border="0">
              <tr>
                <td width="38" class="field-label">Nro:</td>
                <td><span id="sprytext_hr">
                  <input name="hr" type="text" id="hr" style="width:100%; text-align:center; font-weight:700;" placeholder="Opcional" disabled="disabled" />
                  <span class="textfieldRequiredMsg">vacio.</span>
                </span></td>
              </tr>
              <tr>
                <td colspan="2">
                  <label style="display:inline-flex; align-items:center; gap:6px; cursor:pointer; font-size:11px;">
<script language="javascript">
function activar(id){
  if($('micheckbox').checked){
    $(id).disabled = false;
    $(id).focus();
  } else {
    $(id).value="";
    $(id).disabled = true;
  }
}
</script>
                    <input name="micheckbox" type="checkbox" id="micheckbox" value="1" onchange="activar($('hr'));"/>
                    Habilitar Nro. Hoja de Ruta
                  </label>
                </td>
              </tr>
            </table>
          </fieldset></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td style="padding:0 !important;"><table width="100%" border="0" class="cuadro_inferior">
        <tr>
          <td width="56%" style="vertical-align:top !important; padding-right:6px !important;"><fieldset>
            <legend>Datos de la Correspondencia</legend>
            <table width="100%" border="0">
              <tr>
                <td width="65" class="field-label">Fech.Doc:</td>
                <td>
                  <div style="display:flex; align-items:center; justify-content:space-between; gap:10px; width:100%;">
                    <div style="display:inline-flex; align-items:center; gap:4px;">
                      <span id="sprytex_fech_doc">
                        <input name="fecha_doc" type="text" id="fecha_doc" size="10" placeholder="AAAA-MM-DD" title="YYYY-MM-DD" onclick="displayCalendarFor('fecha_doc');" style="cursor:pointer;"/>
                        <span class="textfieldRequiredMsg"> esta vacio.</span>
                      </span>
                      <button type="button" onclick="displayCalendarFor('fecha_doc');" title="Seleccionar fecha" style="display:inline-flex; align-items:center; justify-content:center; height:28px; width:30px; padding:0; background:linear-gradient(135deg,#50000e 0%,#780016 100%); border:1px solid rgba(180,138,40,0.45); border-radius:6px; color:#ffffff; cursor:pointer;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg></button>
                    </div>
                    <div style="display:inline-flex; align-items:center; gap:6px;">
                      <span class="field-label">Hojas:</span>
                      <span id="sprytext_hojas">
                        <input name="nhojas" type="text" id="nhojas" size="8" placeholder="Ej: 1" />
                        <span class="textfieldRequiredMsg">X.</span><span class="textfieldInvalidFormatMsg">X. [0..9]</span>
                      </span>
                    </div>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="field-label">Cite:</td>
                <td><span id="sprytext_cite" style="display:block; width:100%;">
                  <input name="cite" type="text" id="cite" placeholder="Código o número de CITE del documento..." />
                  <span class="textfieldRequiredMsg">X.</span></span></td>
              </tr>
              <tr>
                <td class="field-label">Ref.:</td>
                <td><span id="sprytext_ref" style="display:block; width:100%;">
                  <input name="ref" type="text" id="ref" placeholder="Referencia o asunto principal del documento..." />
                  <span class="textfieldRequiredMsg">X.</span></span></td>
              </tr>
              <tr>
                <td class="field-label" style="vertical-align:top !important; padding-top:8px !important;">Anexos:</td>
                <td><textarea name="anexos" id="anexos" cols="35" rows="2">-
-</textarea></td>
              </tr>
              <tr>
                <td class="field-label" style="vertical-align:top !important; padding-top:8px !important;">Obs.:</td>
                <td><textarea name="obs" id="obs" cols="35" rows="3">N.A.</textarea></td>
              </tr>
            </table>
          </fieldset></td>
          <td width="44%" style="vertical-align:top !important; padding-left:0 !important;"><table width="100%" border="0">
            <tr>
              <td style="padding:0 !important;"><fieldset>
                <legend>Clasificación</legend>
                <table width="100%" border="0">
                  <tr>
                    <td width="95" class="field-label"><input name="button3" type="button" class="botoncitos2" id="button3" style="height:22px !important; padding:0 6px !important; margin-right:4px;" onclick="MM_openBrWindow('agregar_tema.php','','width=600,height=350')" value="+" title="Agregar nuevo tema" />Tema:</td>
                    <td>
                      <div class="inline-select-row">
                        <span id="spry_tema" style="flex:1;">
                          <select name="tema" id="tema">
                            <option value="no tiene tema." selected="selected">no tiene tema.</option>
                          </select>
                          <span class="selectRequiredMsg">X.</span>
                        </span>
                        <input name="refresh_tema" type="button" class="botoncitos3" id="refresh_tema" onclick="temas();" value="↻ Actualizar"/>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="field-label"><input name="button4" type="button" class="botoncitos2" id="button4" style="height:22px !important; padding:0 6px !important; margin-right:4px;" onclick="MM_openBrWindow('agregar_tipo.php','','width=600,height=380')" value="+" title="Agregar nuevo tipo de documento" />Tipo.doc:</td>
                    <td>
                      <div class="inline-select-row">
                        <span id="spry_tipo" style="flex:1;">
                          <select name="tipo" id="tipo">
                            <option value="no definido.">no definido.</option>
                          </select>
                          <span class="selectRequiredMsg">X.</span>
                        </span>
                        <input name="refresh_tipo" type="button" class="botoncitos3" id="refresh_tipo" onclick="tipos();" value="↻ Actualizar"/>
                      </div>
                    </td>
                  </tr>
                </table>
              </fieldset></td>
            </tr>
            <tr>
              <td style="padding:0 !important;"><fieldset style="margin-top:6px !important;">
                <legend>Recibido</legend>
                <table width="100%" border="0">
                  <tr>
                    <td width="75" class="field-label">Fech.Recib.:</td>
                    <td><span id="sprytext_fech_recibido" style="display:block; width:100%;">
                      <input name="fech_recib" type="text" id="fech_recib" size="16" value="<?php echo date("Y-m-d H:i:s"); ?>" readonly="READONLY" />
                      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
                  </tr>
                  <tr>
                    <td class="field-label">Nom. Recib.:</td>
                    <td><span id="sprytext_fun_recib" style="display:block; width:100%;">
                      <input name="fun_recib" type="text" id="fun_recib" value="<?php echo $_SESSION['fun']; ?>" size="25" readonly="READONLY"/>
                      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span>
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
        <input name="button" type="submit" class="guardar-ext" id="button" value="✓ Guardar Registro de Correspondencia" />
      </div></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("spry_funremitente");
var sprytextfield4 = new Spry.Widget.ValidationTextField("spry_depdestino");
var sprytextfield3 = new Spry.Widget.ValidationTextField("spry_depremitente");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytext_hr", "none", {validateOn:["change"]});
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytex_fech_doc", "none", {validateOn:["blur", "change"]});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytext_cite", "none", {validateOn:["blur"]});
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytext_ref", "none", {validateOn:["blur"]});
var sprytextfield9 = new Spry.Widget.ValidationTextField("sprytext_hojas", "integer", {validateOn:["blur"]});
var spryselect1 = new Spry.Widget.ValidationSelect("spry_tema", {validateOn:["blur"]});
var spryselect2 = new Spry.Widget.ValidationSelect("spry_tipo", {validateOn:["blur"]});
var sprytextfield10 = new Spry.Widget.ValidationTextField("sprytext_fech_recibido");
var sprytextfield11 = new Spry.Widget.ValidationTextField("sprytext_fun_recib");
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");
//-->
</script>
</body>
</html>
<?php
mysql_free_result($cumpas);
?>
