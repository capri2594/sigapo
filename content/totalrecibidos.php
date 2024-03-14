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

$colname_Record_recibidos = "-1";
if (isset($_SESSION['cod_dep'])) {
  $colname_Record_recibidos = $_SESSION['cod_dep'];
}

$hoydia_Record_recibidos = date("Y-m-d");



mysql_select_db($database_snet, $snet);
$query_Record_recibidos = sprintf("SELECT id FROM entradas WHERE cod_deprecibido = %s and entradas.dep_recibido>=%s ORDER BY fecha_recibido DESC", GetSQLValueString($colname_Record_recibidos, "text"),GetSQLValueString($hoydia_Record_recibidos, "date"));
$Record_recibidos = mysql_query($query_Record_recibidos, $snet) or die(mysql_error());
$row_Record_recibidos = mysql_fetch_assoc($Record_recibidos);
$totalRows_Record_recibidos = mysql_num_rows($Record_recibidos);

$colname_Record_internos = "-1";
if (isset($_SESSION['cod_dep'])) {
  $colname_Record_internos = $_SESSION['cod_dep'];
}


$hoy_Record_internos = date("Y-m-d");

mysql_select_db($database_snet, $snet);
$query_Record_internos = sprintf("SELECT entradas.id FROM entradas, einterna WHERE entradas.id=einterna.entradas_id AND entradas.cod_deprecibido=%s  AND entradas.fecha_recibido>=%s", GetSQLValueString($colname_Record_internos, "int"),GetSQLValueString($hoy_Record_internos, "date"));
$Record_internos = mysql_query($query_Record_internos, $snet) or die(mysql_error());
$row_Record_internos = mysql_fetch_assoc($Record_internos);
$totalRows_Record_internos = mysql_num_rows($Record_internos);


$colname_Recordset_externos = "-1";
if (isset($_SESSION['cod_dep'])) {
  $colname_Recordset_externos = $_SESSION['cod_dep'];
}

$hoy_Recordset_externos = date("Y-m-d");

mysql_select_db($database_snet, $snet);
$query_Recordset_externos = sprintf("SELECT entradas.id FROM entradas, eexterna WHERE entradas.id=eexterna.entradas_id AND entradas.cod_deprecibido=%s  AND entradas.fecha_recibido>=%s", GetSQLValueString($colname_Recordset_externos, "text"),GetSQLValueString($hoy_Recordset_externos, "date"));
$Recordset_externos = mysql_query($query_Recordset_externos, $snet) or die(mysql_error());
$row_Recordset_externos = mysql_fetch_assoc($Recordset_externos);
$totalRows_Recordset_externos = mysql_num_rows($Recordset_externos);
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<table width="300" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td>Correspondencia Interna</td>
    <td><?php echo $totalRows_Record_internos ?>&nbsp;</td>
  </tr>
  <tr>
    <td>Correspondencia Externa</td>
    <td><?php echo  $totalRows_Recordset_externos;?>&nbsp;</td>
  </tr>
  <tr>
    <td>Hojas de ruta</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Total</td>
    <td><?php echo $totalRows_Record_recibidos; ?>&nbsp;</td>
  </tr>
</table>


</body>
</html>
<?php
mysql_free_result($Record_recibidos);

mysql_free_result($Record_internos);

mysql_free_result($Recordset_externos);
?>
