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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "hoja_ruta")) {
  $insertSQL = sprintf("INSERT INTO hojaruta (cod, einterna_id, fecha_creacion, procedencia, `ref`, primer_destino, primerfun_destino, nhojas, nanexos, usuario_creador, cod_depcreador, cont_destinos) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['codigo'], "text"),
                       GetSQLValueString($_POST['einterna_id'], "int"),
                       GetSQLValueString($_POST['n_derivacion'], "date"),
                       GetSQLValueString($_POST['dep_remite'], "text"),
                       GetSQLValueString($_POST['ref'], "text"),
                       GetSQLValueString($_POST['dep_dest'], "text"),
                       GetSQLValueString($_POST['fun_dest'], "text"),
                       GetSQLValueString($_POST['nhojas'], "int"),
                       GetSQLValueString($_POST['nanexos'], "text"),
                       GetSQLValueString($_POST['usuario_creador'], "text"),
                       GetSQLValueString($_POST['cod_depcreador'], "text"),
                       GetSQLValueString($_POST['n_derivacion'], "int"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($insertSQL, $snet) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "hoja_ruta")) {
  $insertSQL = sprintf("INSERT INTO salidas (fecha_envio, `ref`, fecha_doc) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['fecha_derivacion'], "date"),
                       GetSQLValueString($_POST['ref'], "text"),
                       GetSQLValueString($_POST['fecha_doc'], "date"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($insertSQL, $snet) or die(mysql_error());
  $ultimo_id=mysql_insert_id(); 
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "hoja_ruta")) {
  $insertSQL = sprintf("INSERT INTO derivacion (hojaruta_cod, nro_destino, fun_destino, dep_destino, fecha_derivacion, proveido, mensaje, nhojas, anexos, fun_derivador, cod_depderivador, usuario_derivador, salidas_id) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['codigo'], "text"),
                       GetSQLValueString($_POST['n_derivacion'], "int"),
                       GetSQLValueString($_POST['seg_f_destino'], "text"),
                       GetSQLValueString($_POST['seg_d_destino'], "text"),
                       GetSQLValueString($_POST['fecha_derivacion'], "date"),
                       GetSQLValueString($_POST['tmotivo'], "text"),
                       GetSQLValueString($_POST['mensaje'], "text"),
                       GetSQLValueString($_POST['nhojas'], "int"),
                       GetSQLValueString($_POST['nanexos'], "text"),
                       GetSQLValueString($_POST['fun_derivador'], "text"),
                       GetSQLValueString($_POST['cod_depcreador'], "text"),
                       GetSQLValueString($_POST['usuario_creador'], "text"),
                       GetSQLValueString($ultimo_id, "int"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($insertSQL, $snet) or die(mysql_error());
}


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.Estilo12 {	font-size: 12px;
	font-family: Albertus, sans-serif, Modern;
}
.Estilo23 {font-size: 9px; font-weight: bold; }
.Estilo25 {font-size: 9}
.agregar_cite {	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #3366FF;
	text-decoration: underline;
	width: 100px;
}
.cuadro {
	color: #7A7A7A;
	background-color: #EFF5F1;
	margin: 5px;
	padding: 7px;
	border: 1px solid #D2D2D2;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	width: 670px;
}
.botones {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	height: 20px;
}
.cajas {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	height: 15px;
}
.subrayado {	border-bottom-width: thin;
	border-bottom-style: double;
	border-bottom-color: #C3C3C3;
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #666666;
	font-weight: bold;
}
.subrayadoCampo {	width: 50px;
	border-bottom-width: 1px;
	border-bottom-style: solid;
	border-top-color: #000000;
	border-right-color: #000000;
	border-bottom-color: #000000;
	border-left-color: #000000;
	color: #000000;
}
body {
	margin: 0px;
	padding-top: 0px;
	padding-right: 0px;
	padding-bottom: 0px;
	padding-left: 0px;
}
-->
</style>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo31 {
	font-size: 11px;
	font-family: Arial, Helvetica, sans-serif;
	color: #666666;
}
-->
</style>
</head>

<body>
<form method="POST" action="<?php echo $editFormAction; ?>" name="hoja_ruta" id="hoja_ruta">
<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="300"><span class="Estilo31"><strong>usuario</strong>:<?php echo $_SESSION['user']; ?></span></td>
          <td width="700">&nbsp;</td>
          <td width="234"><div align="right"><?php echo $_POST['cod_dep'];?>-<?php echo $_POST['codHR']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </div></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td><div class="subrayado">
      <div align="left">DATOS DE LA CORRESPONDENCIA</div>
    </div></td>
  </tr>
  <tr>
    <td><div class="cuadro">
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td><div align="right">Fecha<span id="sprytextfield9">
            <input name="dd" type="text" class="cajas" id="dd" value="<?php echo date("d");?>" size="2" maxlength="2" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span><span id="sprytextfield10">
              <input name="mm" type="text" class="cajas" id="mm" value="<?php echo date("m");?>"size="2" maxlength="2" />
              <span class="textfieldRequiredMsg">Se necesita un valor.</span></span><span id="sprytextfield11">
                <input name="aaaa" type="text" class="cajas" id="aaaa" value="<?php echo date("Y");?>"size="4" maxlength="4" />
                <span class="textfieldRequiredMsg">Se necesita un valor.</span></span>
              <input name="fecha_doc" type="hidden" id="fecha_doc" value="<?php echo date("Y-m-d H:i:s");?>" />
          </div></td>
          <td><div align="right">Hora:&nbsp;<span id="sprytextfield3">
            <input name="hora" type="text" class="cajas" id="hora" value="<?php echo date("H:i");?>" size="5" maxlength="5" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></div></td>
          <td><div align="right"><span id="sprytextfield7"><span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span> No. de Hojas
            <input name="nhojas" type="text" id="nhojas" size="8" />
          </div></td>
        </tr>
        <tr>
          <td>&nbsp;&nbsp;
                <input name="codigo" type="hidden" id="codigo" value="<?php echo $_POST['cod_dep'];?>-<?php echo $_POST['codHR']; ?>" />
            <div class="agregar_cite" id="showcite"></div></td>
          <td><input name="cite" type="hidden" id="cite" value="sin cite" /></td>
          <td><div align="right"><span id="sprytextfield8"><span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span>No. de Anexos
            <textarea name="nanexos" cols="25" rows="1" id="nanexos"></textarea>
          </div></td>
        </tr>
      </table>
      <p>Remitente: <span id="spry_remitente">
        <input name="remitente" type="text" class="cajas" id="remitente" size="35" />
        <span class="textfieldRequiredMsg">x</span></span> &nbsp;<span class="subrayadoCampo">&nbsp;&nbsp;&lt;<em ><span id="origen">&nbsp;</span></em>&gt;</span>
        <input name="fun_remite" type="hidden" id="fun_remite" value="<?php echo $_SESSION['fun']; ?>" />
        <input name="dep_remite" type="hidden" class="cajas" id="dep_remite" value="<?php echo $_SESSION['dep']; ?>" />
        <input name="cod_depcreador" type="hidden" id="cod_depcreador" value="<?php echo $_SESSION['cod_dep']; ?>" />
        <input name="einterna_id" type="text" class="cajas" id="einterna_id" size="5" />
        <input name="usuario_creador" type="hidden" class="cajas" id="usuario_creador" value="<?php echo $_SESSION['user']; ?>" size="5" />
        <br />
        <br />
 Referencia:<span id="sprytextfield2"><span id="spry_ref">
<input name="ref" type="text" class="cajas" id="ref" size="70" />
<span class="textfieldRequiredMsg">x</span></span><span class="textfieldRequiredMsg">Se necesita un valor.</span></span> &nbsp;&nbsp;
<input name="examinar2" type="button" class="botones" id="examinar2" onclick="MM_openBrWindow('insert_corresRecibExterna.php','Destinatario','status=yes,left=150,top=100,width=730,height=350')" value="BUSCAR" />
</p>
    </div></td>
  </tr>
  <tr>
    <td><div class="subrayado">
      <div align="left">PRIMER DESTINATARIO</div>
    </div></td>
  </tr>
  <tr>
    <td><div class="cuadro"><span class="Estilo12">PARA:&nbsp;</span> <span class="subrayadoCampo" id="destinatario">&nbsp;</span>
            <input type="hidden" name="fun_dest" id="fun_dest" />
            <input name="dep_dest" type="hidden" id="dep_dest" />
    </div></td>
  </tr>
  <tr>
    <td><div class="subrayado">
      <div align="left">SEGUNDO DESTINATARIO</div>
    </div></td>
  </tr>
  <tr>
    <td><div class="cuadro">
        <table width="100%" border="0" cellpadding="3" cellspacing="2">
          <tr>
            <td><span class="Estilo23">PARA </span></td>
            <td><span id="spry_seg_destinatario">
              <input name="seg_f_destino" type="text" class="cajas" id="seg_f_destino" size="35" />
              <span class="textfieldRequiredMsg">x</span>&lt;&lt; </span><span id="sprytextfield12">
              <input name="seg_d_destino" type="text" class="cajas" id="seg_d_destino" readonly="readonly"/>
&gt;&gt; <span class="textfieldRequiredMsg">Se necesita un valor.</span></span>&nbsp;
 <input name="button" type="button" class="botones" id="button" onclick="MM_openBrWindow('insert_fun_Destino3.php','','left=150,top=150,width=620,height=315')" value="BUSCAR" />
 <input name="n_derivacion" type="hidden" id="n_derivacion" value="2" />
 <input name="fun_derivador" type="hidden" id="fun_derivador" value="<?php echo $_SESSION['fun']; ?>" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><span id="spry_proveido">
              <input name="tmotivo" type="text" id="tmotivo" size="35" />
              <span class="textfieldRequiredMsg">x</span></span>&nbsp;
              <input name="Elegir" type="button" class="botones" id="Elegir" onclick="MM_openBrWindow('eMotivos.php','proveidos','left=610,top=250,width=240,height=330')" value="SELECCIONAR" />
&nbsp;<span class="Estilo23">&nbsp;FECHA:</span><span class="Estilo25">&nbsp;</span>
<input name="fecha_derivacion" type="text" class="cajas" id="fecha_derivacion"  value="<?php echo date("d-m-Y H:i"); ?>" size="15" readonly="readonly" /></td>
          </tr>
          <tr>
            <td><span class="Estilo23">PROVEIDO</span></td>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><span id="spry_mensaje">
                    <textarea name="mensaje" cols="64" rows="3" id="mensaje"></textarea>
                    <span id="countsprytextarea1">&nbsp;</span> <span class="textareaMaxCharsMsg">x</span></span></td>
                </tr>
</table></td>
          </tr>
</table>
    </div></td>
  </tr>
  <tr>
    <td><div class="cuadro">
      <table width="100%" border="0" cellpadding="3" cellspacing="2">
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
            </table>
            <div align="right">
              <input name="button2" type="submit" id="button2" value="Guardar" />
            </div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
<script type="text/javascript">
<!--
var sprytextarea1 = new Spry.Widget.ValidationTextarea("spry_mensaje", {counterId:"countsprytextarea1", counterType:"chars_remaining", maxChars:500, isRequired:false, validateOn:["blur", "change"]});
var sprytextfield5 = new Spry.Widget.ValidationTextField("spry_proveido", "none", {validateOn:["blur", "change"]});
var sprytextfield12 = new Spry.Widget.ValidationTextField("sprytextfield12");
var sprytextfield6 = new Spry.Widget.ValidationTextField("spry_seg_destinatario", "none", {validateOn:["blur", "change"]});
var sprytextfield14 = new Spry.Widget.ValidationTextField("spry_ref", "none", {validateOn:["blur"]});
var sprytextfield13 = new Spry.Widget.ValidationTextField("spry_remitente", "none", {validateOn:["blur"]});
//-->
</script>
<input type="hidden" name="MM_insert" value="hoja_ruta" />
</form>
</body>
</html>