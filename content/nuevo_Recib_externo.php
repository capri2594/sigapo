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
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<style type="text/css">
body {
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     background-color: #1a090d !important;
     color: #f8fafc !important;
     margin: 8px !important;
     padding: 0 !important;
     font-size: 12px !important;
}
fieldset {
     background-color: #260d13 !important;
     border: 1px solid rgba(180, 138, 40, 0.35) !important;
     border-radius: 8px !important;
     padding: 8px 12px !important;
     margin-bottom: 6px !important;
     box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25) !important;
}
legend {
     color: #ffffff !important;
     font-weight: 700 !important;
     font-size: 10px !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     background-color: #780016 !important;
     border: 1px solid rgba(180, 138, 40, 0.55) !important;
     padding: 2px 8px !important;
     border-radius: 4px !important;
}
table {
     border: none !important;
     border-collapse: collapse !important;
}
table td {
     color: #e2e8f0 !important;
     padding: 3px 5px !important;
     font-size: 12px !important;
     background-color: transparent !important;
}
input[type="text"], input[type="password"], textarea, select {
     background-color: #ffffff !important;
     border: 1px solid #cbd5e1 !important;
     border-radius: 4px !important;
     color: #18181b !important;
     padding: 4px 8px !important;
     font-size: 12px !important;
     outline: none !important;
     box-sizing: border-box !important;
}
input[type="text"]:focus, textarea:focus, select:focus {
     border-color: #780016 !important;
     box-shadow: 0 0 0 3px rgba(180, 138, 40, 0.25) !important;
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
     background: linear-gradient(135deg, #780016 0%, #a81c33 100%) !important;
     border: 1px solid rgba(180, 138, 40, 0.4) !important;
     border-radius: 4px !important;
     height: 24px !important;
     padding: 0 12px !important;
     cursor: pointer !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
}
.cuadro_superior, .cuadro_inferior {
     background-color: transparent !important;
     border: none !important;
}
.fc_main, .fc_main td, .fc_main th {
     color: #18181b !important;
     background-color: #f0f0f0 !important;
     padding: 3px 2px !important;
     font-size: 10px !important;
     font-family: Verdana, sans-serif !important;
}
.fc_main td.fc_date {
     color: #18181b !important;
     background-color: #ffffff !important;
     border: 1px solid #d4d4d8 !important;
}
.fc_main td.fc_dateHover,
.fc_main td.fc_date:hover {
     background: #780016 !important;
     background-color: #780016 !important;
     color: #ffffff !important;
     border: 1px solid #50000e !important;
     font-weight: 700 !important;
}
.fc_main td.fc_wknd {
     color: #dc2626 !important;
     font-weight: 700 !important;
}
.fc_main td.fc_head {
     background-color: #780016 !important;
     color: #ffffff !important;
     font-weight: 700 !important;
}
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
     border: 1px solid rgba(104, 0, 20, 0.2) !important;
     box-shadow: 0 4px 12px rgba(104, 0, 20, 0.06) !important;
}
html[data-theme="light"] table td,
body[data-theme="light"] table td,
:root:not([data-theme="dark"]) table td {
     color: #1e293b !important;
}
</style>
</head>

<body>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>" onsubmit="return confirmarGuardar();">
  <table width="100%" border="0">
    <tr>
      <td><table width="100%" border="0" class="barra">
        <tr>
          <td>&nbsp;</td>
          <td><div align="right">
              <input name="button2" type="submit" class="botoncitos3" id="button2" value="Guardar Registro de Correspondencia" />
          </div></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td><div align="justify" class="botoncitos2" style="padding: 6px 12px; height: auto;"> <strong>FORM. 2b.- Registro de correspondencia de fuentes EXTERNAS a la Gobernaci&oacute;n</strong></div></td>
    </tr>
    <tr>
      <td><table width="100%" border="0" class="cuadro_superior">
        <tr>
          <td><fieldset>
            <legend>Origen-Destino</legend>
            <table width="100%" border="0">
              <tr>
                <td width="35"><label>
                  <input name="de" type="button" class="botoncitos3" id="de" value="de:" onclick="MM_openBrWindow('buscarOrg.php','','left=150,top=130,width=550,height=380')"/>
                  </label></td>
                <td width="100"><span id="spry_funremitente">
                  <label>
                  <input name="tdest_nom" type="text" id="tdest_nom" size="30" />
                  </label>
                  <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
                <td width="100"><span id="spry_depremitente">
                  <label>
                  <input name="tdest_org" type="text" id="tdest_org" size="35" />
                  </label>
                  <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
                <td>
                  <input type="button" class="botoncitos2" value="Buscar" onclick="MM_openBrWindow('buscarOrg.php','','toolbar=no,status=no,width=550,height=380')" /></td>
                </tr>
              <tr>
                <td>Para:</td>
                <td><span id="spryselect3">
                  <label>
                  <select name="fun_destino" id="fun_destino">
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
                  </label>
                  <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
                <td><span id="spry_depdestino">
                  <label>
                  <input name="dep_destino" type="text" id="dep_destino" value="<?php echo $_SESSION['dep']; ?>" size="35" readonly="READONLY" />
                  </label>
                  <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
                <td>&nbsp;</td>
                </tr>
              </table>
          </fieldset>          </td>
          <td><fieldset>
            <legend>Hoja de Ruta</legend>
            <table width="100%" border="0">

              <tr>
                <td>Nro:</td>
                <td><span id="sprytext_hr">
                  <label>
                  <input name="hr" type="text" id="hr" size="10" disabled="disabled" />
                  <span class="textfieldRequiredMsg">vacio.</span>                  </label>
                  </span></td>
                  <td>
                  <label>
<script language="javascript">
function activar(id){
  if($('micheckbox').checked){
    $(id).disabled = false;
  } else {
    $(id).value="";
    $(id).disabled = true;
  }
}
</script>
  <input name="micheckbox" type="checkbox" id="micheckbox" value="1" onchange="activar($('hr'));"/>
Si/No: ?
                </label>
                  </td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              </table>
          </fieldset>          </td>
          </tr>

      </table></td>
    </tr>
    <tr>
      <td><table width="100%" border="0" class="cuadro_inferior">
        <tr>
          <td><fieldset>
            <legend>Datos de la Correspondencia</legend>
            <table width="100%" border="0">
              <tr>
                <td>Fech.Doc</td>
                <td><span id="sprytex_fech_doc">
                  <label>
                  <input name="fecha_doc" type="text" id="fecha_doc" size="10" title="YYYY-MM-DD" onclick="displayCalendarFor('fecha_doc');" style="cursor:pointer;"/>
                  </label>
                  <span class="textfieldRequiredMsg"> esta vacio.</span></span>
                  <button type="button" onclick="displayCalendarFor('fecha_doc');" title="Seleccionar fecha" style="display:inline-flex; align-items:center; justify-content:center; height:26px; padding:0 8px; margin-left:4px; background:linear-gradient(135deg,#50000e 0%,#780016 100%); border:1px solid rgba(180,138,40,0.45); border-radius:5px; color:#ffffff; cursor:pointer; vertical-align:middle;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg></button></td>
                </tr>
              <tr>
                <td>Cite</td>
                <td><span id="sprytext_cite">
                  <label>
                  <input name="cite" type="text" id="cite" size="46" />
                  </label>
                  <span class="textfieldRequiredMsg">X.</span></span></td>
                </tr>
              <tr>
                <td>Ref.</td>
                <td><span id="sprytext_ref">
                  <label>
                  <input name="ref" type="text" id="ref" size="46" />
                  </label>
                  <span class="textfieldRequiredMsg">X.</span></span></td>
                </tr>
              <tr>
                <td>Hojas</td>
                <td><span id="sprytext_hojas">
                <label>
                <input name="nhojas" type="text" id="nhojas" size="10" />
                </label>
                <span class="textfieldRequiredMsg">X.</span><span class="textfieldInvalidFormatMsg">X. [0..9]</span></span></td>
              </tr>
              <tr>
                <td>Anexos</td>
                <td><textarea name="anexos" id="anexos" cols="35" rows="3">-
-</textarea></td>
              </tr>
              <tr>
                <td>Obs.</td>
                <td><textarea name="obs" id="obs" cols="35" rows="5">N.A.</textarea></td>
              </tr>
              </table>
          </fieldset>          </td>
          <td><table width="100%" border="0">
            <tr>
              <td><fieldset>
                <legend>Clasificacion</legend>
                <table width="100%" border="0">
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><input name="button3" type="button" class="botoncitos2" id="button3" onclick="MM_openBrWindow('agregar_tema.php','','width=600,height=350')" value="Ad(+)" />
                      Tema</td>
                    <td><span id="spry_tema">
                      
                      <select name="tema" id="tema">
                        <option value="no tiene tema." selected="selected">no tiene tema.</option>
                          </select>
                      
                      <span class="selectRequiredMsg">X.</span>                                            </span></td>
                    </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td><input name="refresh_tema" type="button" class="botoncitos3" id="refresh_tema"  onclick="temas();" value="Actualizar Temas"/></td>
                  </tr>
                  <tr>
                    <td><input name="button4" type="button" class="botoncitos2" id="button4" onclick="MM_openBrWindow('agregar_tipo.php','','width=600,height=380')" value="Ad(+)" />
                      Tipo.doc                      <br /></td>
                    <td><span id="spry_tipo">
                      
                      <select name="tipo" id="tipo">
                        <option value="no definido.">no definido.</option>
                      </select>
                    
                      <span class="selectRequiredMsg">X.</span></span></td>
                    </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td><input name="refresh_tipo" type="button" class="botoncitos3" id="refresh_tipo"  onclick="tipos();" value="Actualizar Tipos."/></td>
                  </tr>
                    </table>
              </fieldset>              </td>
              </tr>
            <tr>
              <td><fieldset>
                <legend>Recibido</legend>
                <table width="100%" border="0">
                  <tr>
                    <td>Fech.Recib.</td>
                    <td><span id="sprytext_fech_recibido">
                      <label>
                      <input name="fech_recib" type="text" id="fech_recib" size="16" value="<?php echo date("Y-m-d H:i:s"); ?>" />
                      </label>
                      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
                    </tr>
                  <tr>
                    <td>Nom. Recib.</td>
                    <td><span id="sprytext_fun_recib">
                      <label>
                      <input name="fun_recib" type="text" id="fun_recib" value="<?php echo $_SESSION['fun']; ?>" size="25" readonly="READONLY"/>
                      </label>
                      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span>
                      <input name="dep_recibido" type="hidden" id="dep_recibido" value="<?php echo $_SESSION['dep']; ?>" />
                      <input name="cod_deprecib" type="hidden" id="cod_deprecib" value="<?php echo $_SESSION['cod_dep']; ?>" />
                      <input name="usuario" type="hidden" id="usuario" value="<?php echo $_SESSION['user']; ?>" /></td>
                    </tr>
                    </table>
              </fieldset>              </td>
              </tr>

          </table></td>
          </tr>

      </table></td>
    </tr>
    <tr>
      <td><label>
        <input name="button" type="submit" class="botoncitos3" id="button" value="Guardar Registro de Correspondencia" />
      </label></td>
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
