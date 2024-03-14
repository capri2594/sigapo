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
  $insertSQL = sprintf("INSERT INTO hojaruta (cod, einterna_id, fecha_creacion, procedencia, `ref`, primer_destino, primerfun_destino, nhojas, nanexos, usuario_creador, cod_depcreador, cont_destinos) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($hoja_ruta, "text"),
                       GetSQLValueString($einterna_id, "int"),
                       GetSQLValueString($_POST['fech_recib'], "date"),
                       GetSQLValueString($_POST['seg_d_destino'], "text"),
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

<script src="js/calendario.js" type="text/javascript"></script>
<link href="js/calendario.css" rel="stylesheet" type="text/css" />
<script src="js/prototype.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script language="javascript">
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
function presionarENTER(obj){
if (ord(form1.obj.value)==13) {document.form1.submit()}
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
	background-color: #EAF4FF;
	border: 1px solid #CAE9FF;
	font-size: 12px;
}
.botoncitos2 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: 100;
	color: #FFFFFF;
	background-color: #3366CC;
	height: 20px;
	border: 2px solid #4B4B4B;
}
.botones {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: 100;
	color: #000033;
	background-color: #C8E6FB;
	height: 22px;
	border: 2px solid #A4BAE8;

}
.botones1 {	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	height: 20px;
}
.cuadro_blanco {
	font-family: Arial, Helvetica, sans-serif;
	background-color: #FFFEFB;
	border: 2px solid #FFF8D5;
	font-size: 12px;
}
.botoneslive {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: 100;
	color: #000033;
	background-color: #D6EAFE;
	height: 22px;
	border: 2px solid #A4BAE8;
}
-->
        </style>
        <link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />

        <link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />

</head>

<body>
<form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
  <table width="100%" border="0">
    <tr>
      <td><div align="right">
        <input name="button2" type="submit" id="button2" value="Guardar Registro de Correspondencia" />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#CBDFFE"><table width="100%" border="0">
        <tr class="cuadro_superior">
          <td><fieldset>
            <legend>Origen-Destino</legend>
            <table width="100%" border="0">
              <tr>
                <td width="30">De:</td>
                <td width="220"><span id="sprytextfield1">
                  <input name="seg_f_destino" type="text" id="seg_f_destino" size="30" />
                  <span class="textfieldRequiredMsg">X</span></span></td>
                <td><span id="sprytextfield2">
                  <input name="seg_d_destino" type="text" id="seg_d_destino" size="35" />
                  <span class="textfieldRequiredMsg">X</span></span>
                  <input name="button5" type="button" class="botones1" id="button5" onclick="MM_openBrWindow('insert_fun_Destino3.php','','left=170,top=120,width=620,height=315')" value="BUSCAR" /></td>
                </tr>
              <tr>
                <td>Para:</td>
                <td><span id="spryselect1">
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
                  <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
                <td><input name="dep_destino" type="text" id="dep_destino" value="<?php echo $_SESSION['dep']; ?>" size="35" readonly="READONLY" /></td>
                </tr>
              </table>
          </fieldset>          </td>
          <td><fieldset>
            <legend>Hoja de Ruta</legend>
            <table width="100%" border="0">

              <tr>
                <td>Nro:</td>
                <td><span id="sprytextfield3">
                <input name="hr" type="text" id="hr" size="10" />
                <span class="textfieldInvalidFormatMsg">no válido.</span> <span class="textfieldRequiredMsg">esta vacio.</span></span></td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              </table>
          </fieldset>          </td>
          </tr>

      </table></td>
    </tr>
    <tr>
      <td><table width="100%" border="0" class="cuadro_blanco">
        <tr>
          <td><fieldset>
            <legend>Datos de la Correspondencia</legend>
            <table width="100%" border="0">
              <tr>
                <td>Fech.Doc</td>
                <td><span id="sprytextfield8">
                  <input name="fecha_doc" type="text" id="fecha_doc" size="10" readonly="READONLY"title="YYYY-MM-DD" onclick="displayCalendarFor('fecha_doc');"/>
                  <span class="textfieldRequiredMsg">X.</span></span>
                  <img src="imagen/icon_calendar_choose.png" alt="calendario" width="13" height="17" longdesc="calendario" onclick="displayCalendarFor('fecha_doc');" /></td>
                </tr>
              <tr>
                <td>Cite</td>
                <td><span id="sprytextfield4">
                  <input name="cite" type="text" id="cite" size="46" />
                  <span class="textfieldRequiredMsg">X.</span></span></td>
                </tr>
              <tr>
                <td>Ref.</td>
                <td><span id="sprytextfield5">
                <input name="ref" type="text" id="ref" size="46" />
                <span class="textfieldRequiredMsg">X.</span><span class="textfieldMinCharsMsg">(+)caracter..</span></span></td>
                </tr>
              <tr>
                <td>Hojas</td>
                <td><span id="sprytextfield6">
                <input name="nhojas" type="text" id="nhojas" size="46" maxlength="5" />
                <span class="textfieldRequiredMsg">X.</span><span class="textfieldInvalidFormatMsg">incorrecto.</span></span></td>
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
                    <td><span id="spryselect2">
                      <div id="spry_tema">
                        <select name="tema" id="tema">
                          <option value="no tiene tema." selected="selected">no tiene tema.</option>
                        </select>
</div>
                      <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
                    </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td><input name="refresh_tema" type="button" class="botoncitos2" id="refresh_tema"  onclick="temas();" value="Actualizar Temas"/></td>
                  </tr>
                  <tr>
                    <td><input name="button4" type="button" class="botoncitos2" id="button4" onclick="MM_openBrWindow('agregar_tipo.php','','width=600,height=380')" value="Ad(+)" />
                      Tipo.doc                      <br /></td>
                    <td><span id="spry_tipo">
                      <select name="tipo" id="tipo">
                        <option value="no definido.">no definido.</option>
                      </select>
                      <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
                    </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td><input name="refresh_tipo" type="button" class="botoncitos2" id="refresh_tipo"  onclick="tipos();" value="Actualizar Tipos."/></td>
                  </tr>
                    </table>
              </fieldset>              </td>
              </tr>
            <tr>
              <td><fieldset>
                <legend>Recibido</legend>
                <table width="100%" border="0">
                  <tr>
                    <td>                      Fech.Recib.</td>
                    <td><span id="sprytextfield7">
                      <input name="fech_recib" type="text" id="fech_recib" size="16" value="<?php echo date("Y-m-d H:i:s"); ?>" />
                      <span class="textfieldRequiredMsg">X.</span></span></td>
                    </tr>
                  <tr>
                    <td>Nom. Recib.</td>
                    <td><input name="fun_recib" type="text" id="fun_recib" value="<?php echo $_SESSION['fun']; ?>" size="25" readonly="READONLY" />
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
        <input name="button" type="submit" id="button" value="Guardar Registro de Correspondencia" />
      </label></td>
    </tr>
  </table>

<input type="hidden" name="MM_insert" value="form1" />
</form>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "integer", {validateOn:["blur"], isRequired:false});
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
?>
