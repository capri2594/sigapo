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


$hoydia_list_hr =date("Y-m-d");

mysql_select_db($database_snet, $snet);
$query_list_hr = sprintf("SELECT entradas.fecha_recibido, entradas.fun_recibido, entradas.dep_recibido, derivacion.nro_destino, derivacion.fun_destino, derivacion.dep_destino, derivacion.fecha_derivacion, hojaruta.nhojas, hojaruta.nanexos, hojaruta.cod, hojaruta.fecha_creacion, hojaruta.`ref`, hojaruta.procedencia FROM entradas, derivacion, hojaruta WHERE entradas.id=derivacion.entradas_id  AND derivacion.hojaruta_cod=hojaruta.cod AND entradas.fecha_recibido>%s ORDER BY entradas.fecha_recibido ASC", GetSQLValueString($hoydia_list_hr, "date"));
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.style6 {font-size: 11px; font-family: Arial, Helvetica, sans-serif; }
.style33 {color: #FFFFFF; font-weight: bold; font-size: 12px; font-family: Verdana, Arial, Helvetica, sans-serif; }
.Estilo5 {font-size: 12px}
.Estilo7 {font-size: 10px; font-family: Arial, Helvetica, sans-serif; }
.Estilo8 {font-size: 10px}
.Estilo9 {color: #FFFFFF; font-weight: bold; font-size: 10px; font-family: Verdana, Arial, Helvetica, sans-serif; }
-->
</style>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="70" height="20" valign="middle" bgcolor="#818BAF"><div align="left"><span class="Estilo9">HOJA <br />
    DE RUTA</span></div></td>
    <td width="112" valign="middle" bgcolor="#818BAF" class="Estilo9">FECHA <br />
    INGRESO</td>
    <td width="125" height="20" valign="middle" bgcolor="#818BAF"><div align="center"><span class="style33">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PROCEDENCIA</span></div></td>
    <td width="50" valign="middle" bgcolor="#818BAF" class="style33">CITE <br />
    Y FECHA</td>
    <td width="50" valign="middle" bgcolor="#818BAF"><div align="left"><span class="style33"> Nº <br />
          <span class="Estilo8">    HOJAS</span></span></div></td>
    <td width="200" height="20" valign="middle" bgcolor="#818BAF"><div align="center"><span class="style33">Nro y Destinatario</span></div></td>
    <td width="177" height="20" valign="middle" bgcolor="#818BAF"><span class="style33">Recibido</span></td>
  </tr>
  <?php do { ?>
  <tr>
    
      <td height="40" valign="middle"><div align="left"><span class="style6">&nbsp; <?php echo $row_list_hr['cod']; ?><br />
      </span></div></td>
      <td valign="middle"><div align="left"><span class="style6"><?php echo $row_list_hr['fecha_recibido']; ?></span></div></td>
      <td height="40" valign="middle"><div align="left"><span class="style6">&nbsp;<?php echo $row_list_hr['procedencia']; ?><br />
      </span></div></td>
      <td valign="middle" class="style6"><div align="left"></div></td>
      <td valign="middle" class="style6"><div align="left"><?php echo $row_list_hr['nhojas']; ?></div></td>
      <td valign="middle"><div align="left"><span class="Estilo7">&nbsp;<?php echo $row_list_hr['nro_destino']; ?>º.-<?php echo $row_list_hr['fun_destino']; ?><br />
        <em>(<em><em><?php echo $row_list_hr['dep_destino']; ?></em></em></em>) </span></div></td>
      <td valign="middle"><div align="left"><span class="Estilo7"><?php echo $row_list_hr['fun_recibido']; ?></span><br />
          <span class="Estilo7"><?php echo $row_list_hr['dep_recibido']; ?></span><br />
      </div></td>
    </tr>
      <?php } while ($row_list_hr = mysql_fetch_assoc($list_hr)); ?>
</table>
<br>
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
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
