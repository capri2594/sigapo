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

$currentPage = $_SERVER["PHP_SELF"];

$colname_Recordset_externos = "-1";
if (isset($_SESSION['cod_dep'])) {
  $colname_Recordset_externos = $_SESSION['cod_dep'];
}

$hoy_Recordset_externos = date("Y-m-d");

$maxRows_Recordset_externos = 10;
$pageNum_Recordset_externos = 0;
if (isset($_GET['pageNum_Recordset_externos'])) {
  $pageNum_Recordset_externos = $_GET['pageNum_Recordset_externos'];
}
$startRow_Recordset_externos = $pageNum_Recordset_externos * $maxRows_Recordset_externos;


$maxRows_Recordset_externos = 10;
$pageNum_Recordset_externos = 0;
if (isset($_GET['pageNum_Recordset_externos'])) {
  $pageNum_Recordset_externos = $_GET['pageNum_Recordset_externos'];
}
$startRow_Recordset_externos = $pageNum_Recordset_externos * $maxRows_Recordset_externos;


mysql_select_db($database_snet, $snet);
$query_Recordset_externos = sprintf("SELECT * FROM entradas, eexterna WHERE entradas.id=eexterna.entradas_id AND entradas.cod_deprecibido=%s  AND entradas.fecha_recibido>=%s", GetSQLValueString($colname_Recordset_externos, "text"),GetSQLValueString($hoy_Recordset_externos, "date"));
$query_limit_Recordset_externos = sprintf("%s LIMIT %d, %d", $query_Recordset_externos, $startRow_Recordset_externos, $maxRows_Recordset_externos);
$Recordset_externos = mysql_query($query_limit_Recordset_externos, $snet) or die(mysql_error());
$row_Recordset_externos = mysql_fetch_assoc($Recordset_externos);

if (isset($_GET['totalRows_Recordset_externos'])) {
  $totalRows_Recordset_externos = $_GET['totalRows_Recordset_externos'];
} else {
  $all_Recordset_externos = mysql_query($query_Recordset_externos);
  $totalRows_Recordset_externos = mysql_num_rows($all_Recordset_externos);
}
$totalPages_Recordset_externos = ceil($totalRows_Recordset_externos/$maxRows_Recordset_externos)-1;

$queryString_Recordset_externos = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset_externos") == false && 
        stristr($param, "totalRows_Recordset_externos") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset_externos = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recordset_externos = sprintf("&totalRows_Recordset_externos=%d%s", $totalRows_Recordset_externos, $queryString_Recordset_externos);
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.Estilo1 {font-size: 12px}
.Estilo3 {font-size: 12px; font-weight: bold; }
-->
</style>
</head>

<body>
<table width="100%" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td bgcolor="#EAEAEA"><div align="center"><span class="Estilo3">Datos de INGRESO</span></div></td>
        <td bgcolor="#EAEAEA"><div align="center"><span class="Estilo3">Documento</span></div></td>
        <td bgcolor="#EAEAEA"><div align="center"><span class="Estilo3">Procedencia</span></div></td>
        <td bgcolor="#EAEAEA"><div align="center"><span class="Estilo3">Destino</span></div></td>
        </tr>
      <?php do { ?>
        <tr>
            <td><span class="Estilo1"><?php echo $row_Recordset_externos['fecha_recibido']; ?></span><br />
              <span class="Estilo1"><?php echo $row_Recordset_externos['fun_recibido']; ?></span><br /></td>
          <td><span class="Estilo1"><?php echo $row_Recordset_externos['fecha_doc']; ?></span><br />
              <span class="Estilo1">cite.-<?php echo $row_Recordset_externos['cite']; ?></span><br />
              <span class="Estilo1">ref.-<?php echo $row_Recordset_externos['ref']; ?></span></td>
          <td><span class="Estilo1"><?php echo $row_Recordset_externos['org_remitente']; ?></span></td>
          <td><span class="Estilo1"><?php echo $row_Recordset_externos['fun_destino']; ?></span><br />
              <span class="Estilo1"><?php echo $row_Recordset_externos['dep_destino']; ?></span><br /></td>
        </tr>
        <?php } while ($row_Recordset_externos = mysql_fetch_assoc($Recordset_externos)); ?>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;
      <table border="0" align="center">
        <tr>
          <td><?php if ($pageNum_Recordset_externos > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_Recordset_externos=%d%s", $currentPage, 0, $queryString_Recordset_externos); ?>">Primero</a>
                <?php } // Show if not first page ?>
          </td>
          <td><?php if ($pageNum_Recordset_externos > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_Recordset_externos=%d%s", $currentPage, max(0, $pageNum_Recordset_externos - 1), $queryString_Recordset_externos); ?>">Anterior</a>
                <?php } // Show if not first page ?>
          </td>
          <td><?php if ($pageNum_Recordset_externos < $totalPages_Recordset_externos) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_Recordset_externos=%d%s", $currentPage, min($totalPages_Recordset_externos, $pageNum_Recordset_externos + 1), $queryString_Recordset_externos); ?>">Siguiente</a>
                <?php } // Show if not last page ?>
          </td>
          <td><?php if ($pageNum_Recordset_externos < $totalPages_Recordset_externos) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_Recordset_externos=%d%s", $currentPage, $totalPages_Recordset_externos, $queryString_Recordset_externos); ?>">&Uacute;ltimo</a>
                <?php } // Show if not last page ?>
          </td>
        </tr>
      </table></td>
  </tr>
</table>


</body>
</html>
<?php
mysql_free_result($Recordset_externos);
?>
