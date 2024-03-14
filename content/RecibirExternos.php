<?php 
session_name("LoginSIRC");
session_start();
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "recibirExternos")) {
  $insertSQL = sprintf("INSERT INTO entradas (tema_titulo, usuario_cuenta, fecha_recibido, fun_recibido, dep_recibido, cod_deprecibido) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['tema'], "text"),
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['fecha_recibido'], "date"),
                       GetSQLValueString($_POST['fun_recibido'], "text"),
                       GetSQLValueString($_POST['dep_recibido'], "text"),
                       GetSQLValueString($_POST['cod_deprecibido'], "text"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($insertSQL, $snet) or die(mysql_error());
}
$colname_idEntrada = "-1";
if (isset($_POST['fecha_recibido'])) {
  $colname_idEntrada = $_POST['fecha_recibido'];
}
mysql_select_db($database_snet, $snet);
$query_idEntrada = sprintf("SELECT id FROM entradas WHERE fecha_recibido = %s", GetSQLValueString($colname_idEntrada, "date"));
$idEntrada = mysql_query($query_idEntrada, $snet) or die(mysql_error());
$row_idEntrada = mysql_fetch_assoc($idEntrada);
$totalRows_idEntrada = mysql_num_rows($idEntrada);
$id_entrada=$row_idEntrada['id'];

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "recibirExternos")) {
  $insertSQL = sprintf("INSERT INTO eexterna (entradas_id, entradas_tema_titulo, entradas_usuario_cuenta, cite, `ref`, remitente, org_remitente, fecha_doc, fun_destino, dep_destino) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($id_entrada, "int"),
					   GetSQLValueString($_POST['tema'], "text"),
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['cite'], "text"),
                       GetSQLValueString($_POST['ref'], "text"),
                       GetSQLValueString($_POST['tdest_nom'], "text"),
                       GetSQLValueString($_POST['tdest_org'], "text"),
					   GetSQLValueString($_POST['fecha_doc'], "text"),
					   GetSQLValueString($_POST['fun_destino'], "text"),
                       GetSQLValueString($_POST['dep_destino'], "text"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($insertSQL, $snet) or die(mysql_error());



}

$colname_listFunUnid = "-1";
if (isset($_SESSION['cod_dep'])) {
  $colname_listFunUnid = $_SESSION['cod_dep'];
}
mysql_select_db($database_snet, $snet);
$query_listFunUnid = sprintf("SELECT nombre FROM funcionario WHERE dependencia_cod = %s ORDER BY nombre ASC", GetSQLValueString($colname_listFunUnid, "text"));
$listFunUnid = mysql_query($query_listFunUnid, $snet) or die(mysql_error());
$row_listFunUnid = mysql_fetch_assoc($listFunUnid);
$totalRows_listFunUnid = mysql_num_rows($listFunUnid);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Recibir_C_ Interna</title>
<style type="text/css">
<!--
.firma {
	height: 150px;
	width: 300px;
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-style: solid;
	border-right-style: solid;
	border-bottom-style: solid;
	border-left-style: solid;
}
.over {
	background-color: #FFFFC1;
	cursor: text;
}
body {
	font-size: 12px;
	color: #000000;
	font-weight: bold;
	font-family: sans-serif, fantasy, Rockwell, "Lucida Sans";
}
.out {
	background-color: #FFFFFF;
}
-->
</style>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>

<script src="js/calendario.js" type="text/javascript"></script>
<link href="js/calendario.css" rel="stylesheet" type="text/css" />
<script src="js/prototype.js" type="text/javascript"></script>


<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo2 {color: #000066; }

-->
</style>

<script type="text/javascript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
function quitarFoco(obj){
  document.getElementById('ref').focus();
  document.getElementById('ref').select();
}
</script>
        <script language="javascript">
		function temas(){
     var url = 'selec_temas.php';
	 var myRand = parseInt(Math.random()*999999999999999);

     var pars = 'jose='+escape($F('tema'));
	 var pars = pars+"&rand="+myRand;
     var target = 'spry_tema';
     var miAjax = new Ajax.Updater(target, url, {method: 'get', parameters: pars});
}
		</script>
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo5 {font-size: 12px}
.Estilo6 {color: #000085}
-->
</style>
</head>

<body onload="temas();">
<form method="POST" action="<?php echo $editFormAction; ?>" name="recibirExternos" id="recibirExternos">
<table width="100%" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
    <td>
      <?php if($Result1)  echo "<span style=\"background-color:yellow;\">Los datos han sido GUARDADOS correctamente....</span>"; ?>
        <div align="right">
          <table width="300" border="0" cellpadding="0" cellspacing="5" bgcolor="#D5EAFF">
            <tr>
              <td><input type="submit" name="button" id="button" value="Registrar" /></td>
              <td><input type="button" name="imprimir1" id="imprimir1" value="Vista Impresion" /></td>
              <td><input name="cancelar1" type="button" id="cancelar1" onclick="" value="cancelar" /></td>
            </tr>
          </table>
      </div></td>
    <td valign="top">&nbsp;</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div style="border-color:#98BEFE; border-style:solid; border-width:1px;">
    <table width="100%" border="0" cellpadding="0" cellspacing="5" bgcolor="#D5EAFF">
      <tr>
        <td width="5%">&nbsp;</td>
        <td width="34%">&nbsp;</td>
        <td width="27%">&nbsp;</td>
        <td width="34%"><input type="hidden" name="hiddenField" id="hiddenField" value="<?php echo $_SESSION['user']; ?>"/></td>
      </tr>
      <tr>
        <td><span class="Estilo5">de:</span></td>
        <td><span id="sprytextfield4">
          <input name="tdest_nom" type="text" id="tdest_nom" size="40" onclick="quitarFoco(this);"/>
          <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
        <td><div align="left"><span id="sprytextfield5">
          <input name="tdest_org" type="text" id="tdest_org" size="27" onclick="quitarFoco(this);"/>
          <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></div></td>
        <td align="left"><div align="left"><a href="javascript:void(0);" onclick="MM_openBrWindow('buscarOrg.php','','width=550,height=350')">Examinar</a></div></td>
      </tr>
      <tr>
        <td><span class="Estilo5">para:</span></td>
        <td><span id="spryselect1">
          <select name="fun_destino" id="fun_destino" style="width:20.6em">
            <?php
do {  
?>
            <option value="<?php echo $row_listFunUnid['nombre']?>"><?php echo $row_listFunUnid['nombre']?></option>
            <?php
} while ($row_listFunUnid = mysql_fetch_assoc($listFunUnid));
  $rows = mysql_num_rows($listFunUnid);
  if($rows > 0) {
      mysql_data_seek($listFunUnid, 0);
	  $row_listFunUnid = mysql_fetch_assoc($listFunUnid);
  }
?>
          </select>
          <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
        <td><span id="sprytextfield7">
          <input name="dep_destino" type="text" id="dep_destino" onclick="quitarFoco(this);" value="<?php echo $_SESSION['dep']; ?>" size="27"/>
          <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
    </div></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div style="border-color:#98BEFE; border-style:solid; border-width:1px;">
    <table width="100%" border="0" cellspacing="4" cellpadding="2">
          <tr>
            <td width="17%"><div align="right" class="Estilo2 Estilo5">Recibido el:&nbsp;</div></td>
            <td width="83%"><span style="background-color:#DBFDE2; border-color: #CCCCCC;">&nbsp;
                <?php 
		$t=date("Y-m-d H:i:s");
		print ($t);?>
&nbsp;&nbsp; </span>
              <input name="fecha_recibido" type="hidden" id="fecha_recibido" value="<?php echo $t;?>" />
              <input name="username" type="hidden" id="username" value="<?php echo $_SESSION['user'];?>" /></td>
          </tr>
          <tr>
            <td><div align="right" class="Estilo2 Estilo5">Fecha del documento:&nbsp;</div></td>
            <td><span id="sprytextfield1"><span id="sprytextfield8">
              <input type="text" name="fecha_doc" id="fecha_doc" title="YYYY-MM-DD" onmouseover="this.className='over';" onmouseout="this.className='out';"/>
              <span class="textfieldRequiredMsg">X</span></span><span class="textfieldRequiredMsg">Se necesita un valor.</span>
              <input type="button" value="calendario" onclick="displayCalendarFor('fecha_doc');" />
            </span></td>
          </tr>
          <tr>
            <td><div align="right" class="Estilo2 Estilo5">Cite:&nbsp;</div></td>
            <td><span id="sprytextfield2"><span id="sprytextfield9">
            <input type="text" name="cite" id="cite" onmouseover="this.className='over';" onmouseout="this.className='out';"/>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span><span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
          </tr>
          <tr>
            <td><div align="right" class="Estilo2 Estilo5">Referencia:&nbsp;</div></td>
            <td><span id="sprytextfield3"><span id="sprytextfield10">
              <input name="ref" type="text" id="ref" size="65" onmouseover="this.className='over';" onmouseout="this.className='out';"/>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span><span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
          </tr>
          <tr>
            <td><div align="right" class="Estilo6">clasificacion-tema:</div></td>
            <td><span id="spry_tema"> 
                <select name="tema" id="tema">
                  <?php
do {  
?>
                  <option value="<?php echo $row_listTEMAS['titulo']?>"><?php echo $row_listTEMAS['titulo']?></option>
                  <?php
} while ($row_listTEMAS = mysql_fetch_assoc($listTEMAS));
  $rows = mysql_num_rows($listTEMAS);
  if($rows > 0) {
      mysql_data_seek($listTEMAS, 0);
	  $row_listTEMAS = mysql_fetch_assoc($listTEMAS);
  }
?>
                </select>
                <span class="selectRequiredMsg">Seleccione un elemento.</span></span>
                <input name="button2" type="button" id="button2" onclick="MM_openBrWindow('agregar_tema.php','','width=600,height=400')" value="agregar" />
                <input type="button" name="refresh_tema" id="refresh_tema" value="Actualizar"  onclick="temas();"/></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input name="fun_recibido" type="hidden" id="fun_recibido" value="<?php echo $_SESSION['fun']; ?>" />              <input name="dep_recibido" type="hidden" id="dep_recibido" value="<?php echo $_SESSION['dep']; ?>" />
              <input name="cod_deprecibido" type="hidden" id="cod_deprecibido" value="<?php echo $_SESSION['cod_dep']; ?>" /></td>
          </tr>
      </table>
    </div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><table width="300" border="0" cellspacing="5" cellpadding="0">
          <tr>
            <td><input type="submit" name="button" id="button" value="Registrar" /></td>
            <td><input type="button" name="imprimir2" id="imprimir2" value="Vista Impresion" /></td>
            <td><input type="button" name="cancelar2" id="cancelar2" value="cancelar" /></td>
          </tr>
      </table></td>
    <td>&nbsp;</td>
  </tr>
</table>
<input type="hidden" name="MM_insert" value="recibirExternos" />
</form>
<script type="text/javascript">
<!--
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "none");
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "none");
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8", "none", {validateOn:["blur"]});
var sprytextfield9 = new Spry.Widget.ValidationTextField("sprytextfield9", "none", {validateOn:["blur"]});
var sprytextfield10 = new Spry.Widget.ValidationTextField("sprytextfield10", "none", {validateOn:["blur"]});
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
//-->
</script>
</body>
</html>
<?php
mysql_free_result($listFunUnid);

mysql_free_result($idEntrada);
?>
