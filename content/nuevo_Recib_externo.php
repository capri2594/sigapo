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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Registro ENTRADA::INTERNA</title>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>

<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />

<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />

<script src="js/calendario.js" type="text/javascript"></script>
<link href="js/calendario.css" rel="stylesheet" type="text/css" />
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
<!--
.botoncitos {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: 100;
	color: #FFFFFF;
	background-color: #0033CC;
	height: 20px;
}
.cuadro_superior {
	font-family: Arial, Helvetica, sans-serif;
	background-color: #B7C5D5;
	border: 1px solid #F4F8FD;
	font-size: 11px;
	color: #000000;
}
.botoncitos2 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: 100;
	color: #FFFFFF;
	background-color: #6B7A9D;
	height: 20px;
	border: 1px solid #FFFFFF;
}
.botones {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: 100;
	color: #FFFFFF;
	background-color: #000033;
	height: 25px;
}
.botones1 {	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	height: 20px;
}
.cuadro_inferior {
	font-family: Arial, Helvetica, sans-serif;
	background-color: #E5ECF7;
	border: 1px solid #FFFFF2;
	font-size: 12px;
}
.cuadro_tooltip {
	font-family: Arial, Helvetica, sans-serif;
	background-color: #FFFFE6;
	border: 1px solid #6699FF;
	font-size: 10px;
	color: #003366;
}
.botoncitos4 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: 100;
	color: #000033;
	background-color: #EDF0FE;
	height: 25px;
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-style: solid;
	border-right-style: solid;
	border-bottom-style: solid;
	border-left-style: solid;
	border-top-color: #E0E7F8;
	border-right-color: #999999;
	border-bottom-color: #CCCCCC;
	border-left-color: #E0E7F8;
}
.botoncitos4cc {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: 100;
	color: #0052A4;
	background-color: #E0EBFE;
	height: 25px;
	border: 2px solid #E8EFFF;
}
.botoncitos4Copia {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: 100;
	color: #0052A4;
	background-color: #E0EBFE;
	height: 25px;
	border: 2px solid #E8EFFF;
}
.botoncitos3Copia {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: 100;
	color: #000033;
	background-color: #EFEFEF;
	height: 25px;
	border: 2px solid #D7E3FF;
}
.botoncitos3 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: 100;
	color: #000033;
	background-color: #E6E6E6;
	height: 25px;
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-style: solid;
	border-right-style: solid;
	border-bottom-style: solid;
	border-left-style: solid;
	border-top-color: #FFFFFF;
	border-right-color: #CCCCCC;
	border-bottom-color: #CCCCCC;
	border-left-color: #FFFFFF;
}
.botoncitos1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: 100;
	color: #FFFFFF;
	background-color: #AAB9CD;
	height: 20px;
	border: 2px solid #000000;
}
.barra {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: 100;
	color: #000000;
	background-color: #CAD2DB;
	height: 20px;
	border: 1px solid #CCCCCC;
	
}
body {
	margin: 0px;
	padding: 0px;
	border: 0px;
}
-->
        </style>
</head>

<body  bgcolor="#CAD2DB">
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>" onsubmit="return confirmarGuardar();">
  <table width="100%" border="0">
    <tr>
      <td><table width="100%" border="0" class="barra">
        <tr>
          <td>&nbsp;</td>
          <td><div align="right">
              <input name="button2" type="submit" class="botoncitos3" id="button2" value="Guardar Registro de Correspondencia" onmouseover="className='botoncitos4';" onmouseout="className='botoncitos3';" />
          </div></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td><div align="justify" class="botoncitos2"> <strong> <img src="imagen/b_tipp.png" alt="tip" width="16" height="16" longdesc="tip" />&nbsp;FORM. 2b.- Registro de correspondencia de fuentes EXTERNAS a la Prefectura</strong></div></td>
    </tr>
    <tr>
      <td bgcolor="#CBDFFE"><table width="100%" border="0" class="cuadro_superior">
        <tr>
          <td><fieldset>
            <legend>Origen-Destino</legend>
            <table width="100%" border="0">
              <tr>
                <td width="35"><label>
                  <input name="de" type="button" class="botoncitos3" id="de" value="de:" onmouseover="className='botoncitos4';" onmouseout="className='botoncitos3';" onclick="MM_openBrWindow('buscarOrg.php','','left=150,top=130,width=550,height=380')"/>
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
                  <img src="imagen/icono_buscar.gif" alt="buscar" width="55" height="15" longdesc="buscar" onclick="MM_openBrWindow('buscarOrg.php','','toolbar=no,status=no,width=550,height=380')"/></td>
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
                  <input name="fecha_doc" type="text" id="fecha_doc" size="10" title="YYYY-MM-DD" onclick="displayCalendarFor('fecha_doc');"/>
                  </label>
                  <span class="textfieldRequiredMsg"> esta vacio.</span></span>
                  
                  <img src="imagen/icon_calendar_choose.png" alt="calendario" width="13" height="17" longdesc="calendario" onclick="displayCalendarFor('fecha_doc');" /></td>
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
                    <td><input name="refresh_tema" type="button" class="botoncitos3" id="refresh_tema"  onclick="temas();" value="Actualizar Temas" onmouseover="className='botoncitos4';" onmouseout="className='botoncitos3';"/></td>
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
                    <td><input name="refresh_tipo" type="button" class="botoncitos3" id="refresh_tipo"  onclick="tipos();" value="Actualizar Tipos." onmouseover="className='botoncitos4';" onmouseout="className='botoncitos3';"/></td>
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
        <input name="button" type="submit" class="botoncitos3" id="button" value="Guardar Registro de Correspondencia" onmouseover="className='botoncitos4';" onmouseout="className='botoncitos3';"/>
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
