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

$codigo_num_destinos = "-1";
if (isset($_GET['cod'])) {
  $codigo_num_destinos = $_GET['cod'];
}
mysql_select_db($database_snet, $snet);
$query_num_destinos = sprintf("SELECT hojaruta.cont_destinos FROM hojaruta WHERE hojaruta.cod=%s", GetSQLValueString($codigo_num_destinos, "text"));
$num_destinos = mysql_query($query_num_destinos, $snet) or die(mysql_error());
$row_num_destinos = mysql_fetch_assoc($num_destinos);
$totalRows_num_destinos = mysql_num_rows($num_destinos);

mysql_select_db($database_snet, $snet);
$query_objetos = "SELECT * FROM motivo";
$objetos = mysql_query($query_objetos, $snet) or die(mysql_error());
$row_objetos = mysql_fetch_assoc($objetos);
$totalRows_objetos = mysql_num_rows($objetos);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.titulos {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #FFFFFF;
	background-color: #6B7A9D;
	border: 1px solid #FFFFFF;
}
.pendiente {
	background-color: #FFCC33;
	height: 15px;
	width: 100px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #000000;
}
.procesado {
	background-color: #9AE7B3;
	height: 15px;
	width: 100px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #000000;
}
.botones {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #333333;
	background-color: #CAD2DB;
	border: 1px solid #FFFFFF;
}
.celeste {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #003366;
	background-color: #E5ECF7;
	border: 1px solid #FFFFFF;
}
.celdas {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #003366;
	background-color: #FAFCFE;
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-style: solid;
	border-right-style: solid;
	border-bottom-style: solid;
	border-left-style: solid;
	border-top-color: #CCCCCC;
	border-right-color: #CCCCCC;
	border-bottom-color: #CCCCCC;
	border-left-color: #CCCCCC;
}
-->
</style>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.botones1 {font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	height: 20px;
}
-->
</style>
<script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="100%" border="0">
    <tr class="titulos">
      <td height="30">:: Agregar Nuevo Destinatario (HOJA DE RUTA: <?php echo $_GET['cod']; ?>)</td>
    </tr>
    <tr>
      <td><table width="100%" border="0" class="celdas">
          <tr>
            <td>No. Destinatario</td>
            <td bgcolor="#FFFFFF"><input name="ndestino" type="hidden" id="ndestino" value="<?php echo $row_num_destinos['cont_destinos']+1; ?>" />
            <?php echo $row_num_destinos['cont_destinos']+1; ?></td>
          </tr>
          <tr>
            <td>Para:</td>
            <td bgcolor="#FFFFFF"><span id="sprytextfield1">
              <label>
              <input name="seg_f_destino" type="text" id="seg_f_destino" size="46" />
              </label>
              <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td bgcolor="#FFFFFF"><span id="sprytextfield2">
              <label>
              <input name="seg_d_destino" type="text" id="seg_d_destino" size="46" />
              </label>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span>
            <input name="button5" type="button" class="botones1" id="button5" onclick="MM_openBrWindow('insert_fun_Destino3.php','','width=620,height=315')" value="BUSCAR" /></td>
          </tr>
          <tr>
            <td>            Objeto </td>
            <td bgcolor="#FFFFFF"><label><span id="spryselect1">
            <select name="objeto" id="objeto">
              <?php
do {  
?>
              <option value="<?php echo $row_objetos['motivos']?>"><?php echo $row_objetos['motivos']?></option>
              <?php
} while ($row_objetos = mysql_fetch_assoc($objetos));
  $rows = mysql_num_rows($objetos);
  if($rows > 0) {
      mysql_data_seek($objetos, 0);
	  $row_objetos = mysql_fetch_assoc($objetos);
  }
?>
            </select>
            <span class="selectRequiredMsg">Seleccione un elemento.</span></span></label></td>
          </tr>
          <tr>
            <td>Instruccion Adicional</td>
            <td bgcolor="#FFFFFF"><label>
              <textarea name="mensaje" id="mensaje" cols="45" rows="5"></textarea>
            </label></td>
          </tr>
          <tr>
            <td>Firma Proveido</td>
            <td bgcolor="#FFFFFF"><span id="sprytextfield4">
              <label>
              <input name="fun_proveido" type="text" id="fun_proveido" value="<?php echo $_SESSION['fun']; ?>" size="46" />
              </label>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
          </tr>
          <tr>
            <td>Fecha de la derivacion:</td>
            <td bgcolor="#FFFFFF"><span id="sprytextfield5">
              <label>
              <input name="fecha_derivacion" type="text" id="fecha_derivacion" value="<?php echo date("Y-m-d H:i:s");?>" size="25" />
              </label>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span>
            <input name="usuario_actual" type="hidden" id="usuario_actual" value="<?php echo $_SESSION['user']; ?>" /></td>
          </tr>
</table></td>
    </tr>
    <tr class="botones">
      <td><table width="100%" border="0">
        <tr>
          <td>&nbsp;</td>
          <td width="150"><label>
            <input type="submit" name="button2" id="button2" value="Crear Destinatario" />
          </label></td>
          <td width="100"><label>
            <input type="button" name="button" id="button" value="Cancelar" />
          </label></td>
        </tr>

      </table></td>
    </tr>
    <tr>
      <td><table width="100%" border="0" class="celdas">
      </table></td>
    </tr>
  </table>
</form>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
//-->
</script>
</body>
</html>
<?php
mysql_free_result($num_destinos);

mysql_free_result($objetos);
?>
