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

$maxRows_list_hr = 10;
$pageNum_list_hr = 0;
if (isset($_GET['pageNum_list_hr'])) {
  $pageNum_list_hr = $_GET['pageNum_list_hr'];
}
$startRow_list_hr = $pageNum_list_hr * $maxRows_list_hr;

mysql_select_db($database_snet, $snet);
$query_list_hr = "SELECT * FROM hojaruta ORDER BY fecha_creacion DESC";
$query_limit_list_hr = sprintf("%s LIMIT %d, %d", $query_list_hr, $startRow_list_hr, $maxRows_list_hr);
$list_hr = mysql_query($query_limit_list_hr, $snet) or die(mysql_error());
$row_list_hr = mysql_fetch_assoc($list_hr);

if (isset($_GET['totalRows_list_hr'])) {
  $totalRows_list_hr = $_GET['totalRows_list_hr'];
} else {
  $all_list_hr = mysql_query($query_list_hr);
  $totalRows_list_hr = mysql_num_rows($all_list_hr);
}
$totalPages_list_hr = ceil($totalRows_list_hr/$maxRows_list_hr)-1;

$queryString_list_hr = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_list_hr") == false && 
        stristr($param, "totalRows_list_hr") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_list_hr = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_list_hr = sprintf("&totalRows_list_hr=%d%s", $totalRows_list_hr, $queryString_list_hr);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.style6 {font-size: 11px; font-family: Arial, Helvetica, sans-serif; }
.style33 {color: #FFFFFF; font-weight: bold; font-size: 12px; font-family: Verdana, Arial, Helvetica, sans-serif; }
-->
</style>
</head>

<body>
<table width="750" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="90" height="20" valign="middle" bgcolor="#818BAF"><span class="style33">Hoja de Ruta</span></td>
    <td width="250" height="20" valign="middle" bgcolor="#818BAF"><span class="style33">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Documento</span></td>
    <td width="120" valign="middle" bgcolor="#818BAF"><div align="center"><span class="style33"> Remitente </span></div></td>
    <td width="150" height="20" valign="middle" bgcolor="#818BAF"><div align="center"><span class="style33">
      Primer Destino</span></div></td>
    <td width="50" height="20" valign="middle" bgcolor="#818BAF"><span class="style33">Derivaciones</span></td>
  </tr>
  <?php do { ?>
  <tr>
    
      <td height="40" valign="middle"><span class="style6">&nbsp;<?php echo $row_list_hr['cod']; ?> <br />
        <br />
      </span></td>
      <td height="40" valign="middle"><span class="style6">&nbsp;Ref.: <?php echo $row_list_hr['ref']; ?></span></td>
      <td valign="middle" class="style6"><?php echo $row_list_hr['procedencia']; ?></td>
      <td valign="middle"><span class="style6">&nbsp;<?php echo $row_list_hr['primer_destino']; ?><br />
        <em>(<em><?php echo $row_list_hr['primerfun_destino']; ?></em></em>) </span></td>
      <td valign="top"><?php echo $row_list_hr['cont_destinos']; ?></td>
    </tr>
      <?php } while ($row_list_hr = mysql_fetch_assoc($list_hr)); ?>
</table>
<br>
  <table width="750" border="0" cellpadding="0" cellspacing="0">
    <tr bgcolor="#DCDFE9">
      <td><table border="0" width="50%" align="center">
          <tr>
            <td width="23%" align="center"><?php if ($pageNum_list_hr > 0) { // Show if not first page ?>
                  <a href="<?php printf("%s?pageNum_list_hr=%d%s", $currentPage, 0, $queryString_list_hr); ?>">Primero&laquo;</a>
                  <?php } // Show if not first page ?>
            </td>
            <td width="31%" align="center"><?php if ($pageNum_list_hr > 0) { // Show if not first page ?>
                  <a href="<?php printf("%s?pageNum_list_hr=%d%s", $currentPage, max(0, $pageNum_list_hr - 1), $queryString_list_hr); ?>">anterior</a>
                  <?php } // Show if not first page ?>
            </td>
            <td width="23%" align="center"><?php if ($pageNum_list_hr < $totalPages_list_hr) { // Show if not last page ?>
                  <a href="<?php printf("%s?pageNum_list_hr=%d%s", $currentPage, min($totalPages_list_hr, $pageNum_list_hr + 1), $queryString_list_hr); ?>">siguiente</a>
                  <?php } // Show if not last page ?>
            </td>
            <td width="23%" align="center"><?php if ($pageNum_list_hr < $totalPages_list_hr) { // Show if not last page ?>
                  <a href="<?php printf("%s?pageNum_list_hr=%d%s", $currentPage, $totalPages_list_hr, $queryString_list_hr); ?>">&raquo; Ultimo </a>
                  <?php } // Show if not last page ?>
            </td>
          </tr>
        </table></td>
    </tr>
</table>

</body>
</html>
<?php
mysql_free_result($list_hr);
?>
