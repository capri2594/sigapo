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

$codigo_obtener_hr = "-1";
if (isset($_POST['cod'])) {
  $codigo_obtener_hr = $_POST['cod'];
}
mysql_select_db($database_snet, $snet);
$query_obtener_hr = sprintf("SELECT * FROM hojaruta WHERE hojaruta.cod=%s", GetSQLValueString($codigo_obtener_hr, "text"));
$obtener_hr = mysql_query($query_obtener_hr, $snet) or die(mysql_error());
$row_obtener_hr = mysql_fetch_assoc($obtener_hr);
$totalRows_obtener_hr = mysql_num_rows($obtener_hr);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.barras {	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
	background-color: #CAD2DB;
}
.cabecera {	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #FFFFFF;
	background-color: #6B7A9D;
	height: 30px;
}
.superior {	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
	background-color: #E5ECF7;
}
-->
</style>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="100%" border="0">
    <tr class="cabecera">
      <td><table width="100%" border="0">
          <tr>
            <td>REINGRESO de la HOJA DE RUTA: <?php echo $_GET['cod']?> </td>
            <td><label>
              <div align="right">
                <input type="button" name="Consultar otro" id="Consultar otro" value="Consultar otro" onclick="window.history.back();"/>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="button" name="cerrar" id="cerrar" value="Cerrar" onclick="window.close();"/>
                </div>
              </label></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td><table width="100%" border="0">
          <tr>
            <td>Destinatario(numero)</td>
            <td><span id="sprytextfield1">
              <label>
              <input type="text" name="num" id="num" />
              </label>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Nombre</td>
            <td><span id="spryselect1">
              <label>
              <select name="select1" id="select1">
              </select>
              </label>
            <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Proveido</td>
            <td><span id="sprytextarea1">
              <label>
              <textarea name="proveido" id="proveido" cols="45" rows="5"></textarea>
              </label>
            <span class="textareaRequiredMsg">Se necesita un valor.</span></span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Hojas</td>
            <td><span id="sprytextfield2">
              <label>
              <input type="text" name="hojas" id="hojas" />
              </label>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Anexos</td>
            <td><span id="sprytextfield3">
              <label>
              <input type="text" name="anexos" id="anexos" />
              </label>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td><table width="100%" border="0">
          <tr class="barras">
            <td><strong>Nro</strong></td>
            <td><strong>Reingreso </strong></td>
            <td><strong>Fecha de registro</strong></td>
          </tr>
          <tr>
            <td width="10" class="barras">1</td>
            <td class="superior"><br />
                <br /></td>
            <td>&nbsp;</td>
          </tr>
          <?php do { ?>
          <tr>
            <td class="barras">&nbsp;</td>
            <td class="superior"><br /></td>
            <td>&nbsp;</td>
          </tr>
          <?php } while ($row_obtener_hr = mysql_fetch_assoc($obtener_hr)); ?>
      </table></td>
    </tr>
  </table>
</form>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
//-->
</script>
</body>
</html>
<?php
mysql_free_result($obtener_hr);
?>
