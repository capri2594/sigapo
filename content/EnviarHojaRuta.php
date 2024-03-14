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

$colname_list_hr = "-1";
if (isset($_POST['codHR'])) {
  $colname_list_hr = $_POST['codHR'];
}
mysql_select_db($database_snet, $snet);
$query_list_hr = sprintf("SELECT * FROM hojaruta WHERE cod = %s", GetSQLValueString($colname_list_hr, "text"));
$list_hr = mysql_query($query_list_hr, $snet) or die(mysql_error());
$row_list_hr = mysql_fetch_assoc($list_hr);
$totalRows_list_hr = mysql_num_rows($list_hr);
$ok=0;
if (($_POST['comprobar'])&&($totalRows_list_hr == 0)&&(isset($_POST['codHR']))) {$ok=1;}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Enviar Hoja de Ruta</title>
<style type="text/css">
<!--
.cuadro {
	color: #7A7A7A;
	background-color: #EFF5F1;
	margin: 5px;
	padding: 13px;
	border: 1px solid #D2D2D2;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.boton {
	background-color: #EFF5F1;
	border: 1px solid #9B9B9B;
	color: #666666;
	font-weight: bold;
	font-size: 11px;
	font-family: Arial, Helvetica, sans-serif;
}
.paso_normal {
	background-color: #EBF1E4;
	border: 1px solid #CCCCCC;
	margin: 0px;
	padding: 12px;
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 14px;
	width: 100px;
}
.pasotitulo {
	background-color: #DCF0B3;
	border: 1px solid #CCCCCC;
	padding: 12px;
	font-size: 14px;
	font-weight: bold;
	color: #00376F;
	font-family: Albertus, sans-serif, Modern;
}
.paso_over {
	background-color: #DCF0B3;
	border: 1px solid #CCCCCC;
	padding: 12px;
	font-size: 14px;
	font-weight: bold;
	color: #00376F;
	font-family: Albertus, sans-serif, Modern;
}
.subrayado {
	border-bottom-width: thin;
	border-bottom-style: double;
	border-bottom-color: #C3C3C3;
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #666666;
	font-weight: bold;
}
-->
</style>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo3 {
	font-size: 11px;
	font-family: Geneva, Arial, Helvetica, sans-serif;
}
.Estilo4 {
	color: #FF0000;
	font-weight: bold;
}
.Estilo6 {color: #FF0000}
.Estilo9 {
	color: #339933;
	font-weight: bold;
}
.Estilo11 {color: #000000}
-->
</style>
</head>

<body>
<form action="" method="post" name="formHR" id="formHR">
  <table width="100%" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td width="140" valign="top"><table width="100" border="0" align="left" cellpadding="0" cellspacing="1">
      <tr>
        <td><div class="pasotitulo">Enviar HOJA DE RUTA </div></td>
      </tr>
      <tr>
        <td><div class="paso_normal">Paso 1</div></td>
      </tr>
      <tr>
        <td><div class="paso_normal">Paso 2</div></td>
      </tr>
      <tr>
        <td><div class="paso_normal">Paso 3</div></td>
      </tr>
    </table></td>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td><p>Ingrese el codigo de Hoja de Ruta:</p>
          <table width="100%" border="0" cellspacing="1" cellpadding="0">
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td><div align="left"><span class="Estilo3">Insertar codigo de&nbsp;HOJA DE RUTA&nbsp;</span></div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td width="2%">&nbsp;</td>
              <td width="26%" align="right" valign="middle"><?php echo $_SESSION['cod_dep']; ?>&nbsp;.&nbsp;</td>
              <td width="49%" valign="middle"><span id="sprytextfield1">
              <input type="text" name="codHR" id="codHR" />
              <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Ingrese numero.</span></span></td>
              <td width="23%" valign="middle"><div align="right">
                <input name="comprobar" type="submit" class="boton" id="comprobar" value="Comprobar Otra Vez" />
              </div></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td><div align="right">
                <input name="siguiente" type="submit" class="boton" id="siguiente" value="Siguiente &gt;&gt;" />
              </div></td>
            </tr>
          </table>          
          </td>
      </tr>
      
      <tr>
        <td><table width="100%" border="0" cellspacing="1" cellpadding="7">
        <?php if ($totalRows_list_hr == 0) { // Show if recordset empty ?>
        <?php if ($ok==1) { // Show if recordset empty ?>
          <tr>
            <td><div class="subrayado">Hoja de Ruta</div></td>
            </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="1" cellpadding="7">
              <tr>
                <td>&nbsp;</td>
                <td><div class="cuadro">Codigo :&nbsp;<span class="Estilo11"><?php echo $_SESSION['cod_dep']; ?>.<?php echo $_POST['codHR']; ?></span><br />
                  Comprobacion: <span class="Estilo9">OK</span><br />
                </div></td>
              </tr>

            </table></td>
          </tr>
          <tr>
            <td><div class="subrayado">Datos de la Correspondencia</div></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="1" cellpadding="7">
              <tr>
                <td>&nbsp;</td>
                <td><div class="cuadro">ref.<span id="sprytextfield2">
                    <input name="text" type="text" id="text" size="50" />
                    <span class="textfieldRequiredMsg">Se necesita un valor.</span></span><br />
                </div></td>
              </tr>

            </table></td>
          </tr>
     <?php } // fin comprobar ?>
     <?php } // Show if recordset empty ?>
          <?php if ($totalRows_list_hr > 0) { // Show if recordset not empty ?>
          <tr>
            <td><div class="subrayado">Resultado de la comprobacion</div></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="1" cellpadding="7">
              <tr>
                <td>&nbsp;</td>
                <td><div class="cuadro">Codigo de Hoja de Ruta:&nbsp;<span class="Estilo6"><?php echo $_SESSION['cod_dep']; ?>-<?php echo $_POST['codHR']; ?></span><br />
                  Comprobacion: <span class="Estilo4">ERROR</span> <span class="Estilo6">el codigo ya existe no puede ingresar duplicar datos</span><br />
                </div></td>
              </tr>
            </table></td>
          </tr>
          <?php } // Show if recordset not empty ?>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table></td>
        </tr>
    </table></td>
  </tr>
</table></form>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {validateOn:["blur"]});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($list_hr);
?>
