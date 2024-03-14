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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_verEInternos = 10;
$pageNum_verEInternos = 0;
if (isset($_GET['pageNum_verEInternos'])) {
  $pageNum_verEInternos = $_GET['pageNum_verEInternos'];
}
$startRow_verEInternos = $pageNum_verEInternos * $maxRows_verEInternos;

mysql_select_db($database_snet, $snet);
$query_verEInternos = "SELECT * FROM salidas, salinternas WHERE salidas.cite=salinternas.salidas_cite ORDER BY salidas.fecha_envio DESC";
$query_limit_verEInternos = sprintf("%s LIMIT %d, %d", $query_verEInternos, $startRow_verEInternos, $maxRows_verEInternos);
$verEInternos = mysql_query($query_limit_verEInternos, $snet) or die(mysql_error());
$row_verEInternos = mysql_fetch_assoc($verEInternos);

if (isset($_GET['totalRows_verEInternos'])) {
  $totalRows_verEInternos = $_GET['totalRows_verEInternos'];
} else {
  $all_verEInternos = mysql_query($query_verEInternos);
  $totalRows_verEInternos = mysql_num_rows($all_verEInternos);
}
$totalPages_verEInternos = ceil($totalRows_verEInternos/$maxRows_verEInternos)-1;

$queryString_verEInternos = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_verEInternos") == false && 
        stristr($param, "totalRows_verEInternos") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_verEInternos = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_verEInternos = sprintf("&totalRows_verEInternos=%d%s", $totalRows_verEInternos, $queryString_verEInternos);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<table width="100%" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td colspan="3">&nbsp;
      <div align="center">Registros <?php echo ($startRow_verEInternos + 1) ?> a <?php echo min($startRow_verEInternos + $maxRows_verEInternos, $totalRows_verEInternos) ?> de <?php echo $totalRows_verEInternos ?> </div></td>
  </tr>
  <tr bgcolor="#CCCCCC">
    <td bordercolor="#CCCCCC">Datos del Documento</td>
    <td bordercolor="#CCCCCC">otros datos</td>
    <td bordercolor="#CCCCCC">Acciones</td>
  </tr>
  <?php do { ?>
    <tr bgcolor="#D9F2E6">
      <td bordercolor="#CCCCCC"><p>cite:&nbsp;<?php echo $row_verEInternos['cite']; ?>&nbsp;ref.:<?php echo $row_verEInternos['ref']; ?>&nbsp;tipo:<?php echo $row_verEInternos['tipo_clase']; ?> &nbsp;Destinatario: <?php echo $row_verEInternos['funcionario']; ?>&nbsp;&nbsp;Dependencia:&nbsp;<?php echo $row_verEInternos['dependencia']; ?></p></td>
      <td bordercolor="#CCCCCC">hojas:<?php echo $row_verEInternos['nhojas']; ?><br />
        adjuntos:<?php echo $row_verEInternos['ladjuntos']; ?><br />
        anexos:<?php echo $row_verEInternos['danexos']; ?><br />
        fecha de proveido:<?php echo $row_verEInternos['fecha_proveido']; ?></td>
      <td bordercolor="#CCCCCC"><table width="100%" border="0" cellspacing="1" cellpadding="0">
          <tr>
            <td>Detalles</td>
            <td>Modificar</td>
            <td>Eliminar</td>
          </tr>
            </table></td>
    </tr>
    <?php } while ($row_verEInternos = mysql_fetch_assoc($verEInternos)); ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;
      <div align="center">
        <table border="0">
          <tr>
            <td><?php if ($pageNum_verEInternos > 0) { // Show if not first page ?>
                  <a href="<?php printf("%s?pageNum_verEInternos=%d%s", $currentPage, 0, $queryString_verEInternos); ?>"><img src="First.gif" border="0" /></a>
                  <?php } // Show if not first page ?>            </td>
            <td><?php if ($pageNum_verEInternos > 0) { // Show if not first page ?>
                  <a href="<?php printf("%s?pageNum_verEInternos=%d%s", $currentPage, max(0, $pageNum_verEInternos - 1), $queryString_verEInternos); ?>"><img src="Previous.gif" border="0" /></a>
                  <?php } // Show if not first page ?>            </td>
            <td><?php if ($pageNum_verEInternos < $totalPages_verEInternos) { // Show if not last page ?>
                  <a href="<?php printf("%s?pageNum_verEInternos=%d%s", $currentPage, min($totalPages_verEInternos, $pageNum_verEInternos + 1), $queryString_verEInternos); ?>"><img src="Next.gif" border="0" /></a>
                  <?php } // Show if not last page ?>            </td>
            <td><?php if ($pageNum_verEInternos < $totalPages_verEInternos) { // Show if not last page ?>
                  <a href="<?php printf("%s?pageNum_verEInternos=%d%s", $currentPage, $totalPages_verEInternos, $queryString_verEInternos); ?>"><img src="Last.gif" border="0" /></a>
                  <?php } // Show if not last page ?>            </td>
          </tr>
              </table>
      </div></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($verEInternos);
?>
