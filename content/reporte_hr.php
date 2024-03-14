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
if (isset($_GET['cod'])) {
  $codigo_obtener_hr = $_GET['cod'];
}
mysql_select_db($database_snet, $snet);
$query_obtener_hr = sprintf("SELECT * FROM hojaruta  WHERE hojaruta.cod=%s", GetSQLValueString($codigo_obtener_hr, "text"));
$obtener_hr = mysql_query($query_obtener_hr, $snet) or die(mysql_error());
$row_obtener_hr = mysql_fetch_assoc($obtener_hr);
$totalRows_obtener_hr = mysql_num_rows($obtener_hr);

$codigo_ob_derivaciones = "-1";
if (isset($_GET['cod'])) {
  $codigo_ob_derivaciones = $_GET['cod'];
}
mysql_select_db($database_snet, $snet);
$query_ob_derivaciones = sprintf("SELECT * FROM derivacion WHERE derivacion.hojaruta_cod=%s ORDER BY derivacion.nro_destino ASC", GetSQLValueString($codigo_ob_derivaciones, "text"));
$ob_derivaciones = mysql_query($query_ob_derivaciones, $snet) or die(mysql_error());
$row_ob_derivaciones = mysql_fetch_assoc($ob_derivaciones);
$totalRows_ob_derivaciones = mysql_num_rows($ob_derivaciones);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.superior {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
	background-color: #E5ECF7;
}
.cabecera {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #FFFFFF;
	background-color: #6B7A9D;
	height: 30px;
}
.barras {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
	background-color: #CAD2DB;
}
-->
</style>
</head>

<body>
<table width="100%" border="0">
  <tr class="cabecera">
    <td><table width="100%" border="0">
        <tr>
          <td>Reporte de la HOJA DE RUTA: <?php echo $_GET['cod']?> </td>
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
      <tr class="barras">
        <td><strong>DESTINATARIO</strong></td>
        <td><strong>Nombre/Unidad o dependencia</strong></td>
        <td><strong>Fecha de Derivacion</strong></td>
      </tr>
      <tr>
        <td width="10" class="barras">1</td>
        <td class="superior"><?php echo $row_obtener_hr['primerfun_destino']; ?><br />
              <strong><?php echo $row_obtener_hr['primer_destino']; ?></strong><br /></td>
        <td><?php echo $row_obtener_hr['fecha_creacion']; ?></td>
      </tr>
        <?php do { ?>      
      <tr>

          <td class="barras"><?php echo $row_ob_derivaciones['nro_destino']; ?></td>
          <td class="superior"><?php echo $row_ob_derivaciones['fun_destino']; ?><br />
              <strong><?php echo $row_ob_derivaciones['dep_destino']; ?></strong></td>
          <td><?php echo $row_ob_derivaciones['fecha_derivacion']; ?></td>
</tr>
          <?php } while ($row_ob_derivaciones = mysql_fetch_assoc($ob_derivaciones)); ?>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($obtener_hr);

mysql_free_result($ob_derivaciones);
?>
