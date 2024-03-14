<?php require_once('../Connections/snet.php'); ?><?php 
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

$currentPage = $_SERVER["PHP_SELF"];


$hoy_Record_internos = date("Y-m-d");

$colname_Record_internos = "-1";
if (isset($_SESSION['cod_dep'])) {
  $colname_Record_internos = $_SESSION['cod_dep'];
}

$maxRows_Record_internos = 10;
$pageNum_Record_internos = 0;
if (isset($_GET['pageNum_Record_internos'])) {
  $pageNum_Record_internos = $_GET['pageNum_Record_internos'];
}
$startRow_Record_internos = $pageNum_Record_internos * $maxRows_Record_internos;


mysql_select_db($database_snet, $snet);
$query_Record_internos = sprintf("SELECT * FROM entradas, einterna WHERE entradas.id=einterna.entradas_id AND entradas.cod_deprecibido=%s  AND entradas.fecha_recibido>=%s", GetSQLValueString($colname_Record_internos, "text"),GetSQLValueString($hoy_Record_internos, "date"));
$query_limit_Record_internos = sprintf("%s LIMIT %d, %d", $query_Record_internos, $startRow_Record_internos, $maxRows_Record_internos);
$Record_internos = mysql_query($query_limit_Record_internos, $snet) or die(mysql_error());
$row_Record_internos = mysql_fetch_assoc($Record_internos);

if (isset($_GET['totalRows_Record_internos'])) {
  $totalRows_Record_internos = $_GET['totalRows_Record_internos'];
} else {
  $all_Record_internos = mysql_query($query_Record_internos);
  $totalRows_Record_internos = mysql_num_rows($all_Record_internos);
}
$totalPages_Record_internos = ceil($totalRows_Record_internos/$maxRows_Record_internos)-1;

$queryString_Record_internos = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Record_internos") == false && 
        stristr($param, "totalRows_Record_internos") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Record_internos = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Record_internos = sprintf("&totalRows_Record_internos=%d%s", $totalRows_Record_internos, $queryString_Record_internos);



?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.Estilo1 {font-size: 10px}
.Estilo2 {font-size: 12px}
.Estilo4 {font-size: 12px; font-weight: bold; }
-->
</style>
</head>

<body>
<table width="100%" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="2" cellpadding="1">
      <tr>
        <td bgcolor="#F2F2F2"><div align="center"><span class="Estilo4">Ingreso</span></div></td>
        <td bgcolor="#F2F2F2"><div align="center"><span class="Estilo4">Documento</span></div></td>
        <td bgcolor="#F2F2F2"><div align="center"><span class="Estilo4">Hojas</span></div></td>
        <td bgcolor="#F2F2F2"><div align="center"><span class="Estilo4">Anexos</span></div></td>
        <td bgcolor="#F2F2F2"><div align="center"><span class="Estilo4">Procedencia</span></div></td>
        <td bgcolor="#F2F2F2"><div align="center"><span class="Estilo4">Obs. Mensaje</span></div></td>
      </tr>
      <?php do { ?>
        <tr>
          <td><span class="Estilo1"><?php echo $row_Record_internos['fecha_recibido']; ?><br />
&nbsp;<?php echo $row_Record_internos['fun_recibido']; ?></span></td>
          <td><span class="Estilo2"><?php echo $row_Record_internos['cite']; ?><br />
          </span><span class="Estilo2"><?php echo $row_Record_internos['ref']; ?></span></td>
          <td><span class="Estilo2"><?php echo $row_Record_internos['nhojas']; ?></span></td>
          <td><span class="Estilo2"><?php echo $row_Record_internos['anexos']; ?></span></td>
          <td><span class="Estilo2"><?php echo $row_Record_internos['dep_remite']; ?></span></td>
          <td><span class="Estilo2"><?php echo $row_Record_internos['adjuntos']; ?></span></td>
        </tr>
        <?php } while ($row_Record_internos = mysql_fetch_assoc($Record_internos)); ?>

    </table></td>
  </tr>
  <tr>
    <td>&nbsp;
      <table border="0" align="center">
        <tr>
          <td><?php if ($pageNum_Record_internos > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_Record_internos=%d%s", $currentPage, 0, $queryString_Record_internos); ?>">Primero</a>
                <?php } // Show if not first page ?>
          </td>
          <td><?php if ($pageNum_Record_internos > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_Record_internos=%d%s", $currentPage, max(0, $pageNum_Record_internos - 1), $queryString_Record_internos); ?>">Anterior</a>
                <?php } // Show if not first page ?>
          </td>
          <td><?php if ($pageNum_Record_internos < $totalPages_Record_internos) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_Record_internos=%d%s", $currentPage, min($totalPages_Record_internos, $pageNum_Record_internos + 1), $queryString_Record_internos); ?>">Siguiente</a>
                <?php } // Show if not last page ?>
          </td>
          <td><?php if ($pageNum_Record_internos < $totalPages_Record_internos) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_Record_internos=%d%s", $currentPage, $totalPages_Record_internos, $queryString_Record_internos); ?>">&Uacute;ltimo</a>
                <?php } // Show if not last page ?>
          </td>
        </tr>
      </table></td>
  </tr>
</table>

</body>
</html>
<?php


mysql_free_result($Record_internos);
?>
