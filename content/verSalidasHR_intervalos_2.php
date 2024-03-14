<?php require_once('../Connections/snet.php'); ?><?php 
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

$currentPage = $_SERVER["PHP_SELF"];

$midep_salidas_hr = "-1";
if (isset($_SESSION['cod_dep'])) {
  $midep_salidas_hr = $_SESSION['cod_dep'];
}
$inicio_salidas_hr = "-1";
if (isset($_POST['inicio'])) {
  $inicio_salidas_hr = $_POST['inicio'];
}
$fin_salidas_hr = "-1";
if (isset($_POST['fin'])) {
  $fech_fin=explode("-",$_POST['fin']);
  $fin_salidas_hr =$fech_fin[0]."-".$fech_fin[1]."-".($fech_fin[2]+1);
  //$fin_salidas_hr = $_POST['fin'];
}
$maxRows_salidas_hr = 10;
$pageNum_salidas_hr = 0;
if (isset($_GET['pageNum_salidas_hr'])) {
  $pageNum_salidas_hr = $_GET['pageNum_salidas_hr'];
}
$startRow_salidas_hr = $pageNum_salidas_hr * $maxRows_salidas_hr;

mysql_select_db($database_snet, $snet);
$query_salidas_hr = sprintf("SELECT derivacion.hojaruta_cod, derivacion.fun_destino, derivacion.dep_destino, salidas.fecha_envio, derivacion.nhojas, derivacion.anexos, hojaruta.procedencia, hojaruta.ref, derivacion.proveido, derivacion.mensaje FROM derivacion, hojaruta, salidas WHERE derivacion.hojaruta_cod= hojaruta.cod  AND salidas.id=derivacion.salidas_id AND derivacion.cod_depderivador=%s  AND (salidas.fecha_envio>=%s AND salidas.fecha_envio<=%s) ORDER BY salidas.fecha_envio", GetSQLValueString($midep_salidas_hr, "date"),GetSQLValueString($inicio_salidas_hr, "date"),GetSQLValueString($fin_salidas_hr, "date"));
$query_limit_salidas_hr = sprintf("%s LIMIT %d, %d", $query_salidas_hr, $startRow_salidas_hr, $maxRows_salidas_hr);
$salidas_hr = mysql_query($query_limit_salidas_hr, $snet) or die(mysql_error());
$row_salidas_hr = mysql_fetch_assoc($salidas_hr);

if (isset($_GET['totalRows_salidas_hr'])) {
  $totalRows_salidas_hr = $_GET['totalRows_salidas_hr'];
} else {
  $all_salidas_hr = mysql_query($query_salidas_hr);
  $totalRows_salidas_hr = mysql_num_rows($all_salidas_hr);
}
$totalPages_salidas_hr = ceil($totalRows_salidas_hr/$maxRows_salidas_hr)-1;

$queryString_salidas_hr = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_salidas_hr") == false && 
        stristr($param, "totalRows_salidas_hr") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_salidas_hr = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_salidas_hr = sprintf("&totalRows_salidas_hr=%d%s", $totalRows_salidas_hr, $queryString_salidas_hr);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:: LIBRO SALIDAS-<?php echo $_SESSION['cod_dep']; ?></title>
<style type="text/css">
<!--
.datos {	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #333333;
}
.titulos {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-style: normal;
	line-height: normal;
	font-weight: bold;
	text-transform: uppercase;
	color: #333333;
	border-top-width: 1px;
	border-right-width: thin;
	border-bottom-width: 2px;
	border-left-width: thin;
	border-top-style: solid;
	border-right-style: none;
	border-bottom-style: solid;
	border-left-style: none;
	border-top-color: #333333;
	border-right-color: #333333;
	border-bottom-color: #333333;
	border-left-color: #333333;
	margin: 0px;
	padding: 0px;
}
.entregado {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 9px;
	margin: 1px;
	padding: 1px;
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: dotted;
	border-left-style: none;
	border-top-color: #333333;
	border-right-color: #333333;
	border-bottom-color: #333333;
	border-left-color: #333333;
	font-weight: normal;
}
.datos {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #333333;
}
.fecha {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #333333;
}
.navegacion {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.Estilo1 {font-size: 14px}
.fila_subrayado {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 9px;
	margin: 1px;
	padding: 1px;
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: dotted;
	border-left-style: none;
	border-top-color: #333333;
	border-right-color: #333333;
	border-bottom-color: #333333;
	border-left-color: #333333;
	font-weight: normal;
}
.Estilo2 {
	font-size: 12px;
	font-weight: bold;
}
body {
	margin: 5px;
	padding: 0px;
}
.ref {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
}
.Estilo3 {font-family: Arial, Helvetica, sans-serif; font-size: 10px; color: #333333; font-weight: bold; }
-->
</style>
<script type="text/javascript" src="js/bloqueo.js"></script>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="3" cellpadding="1">
      <tr>
        <td><div align="center" class="Estilo1"><?php echo $_SESSION['dep']; ?></div></td>
      </tr>
      <tr>
        <td><div align="center" class="Estilo2">REGISTRO DE SALIDA (Mensajero)</div></td>
      </tr>
    </table></td>
  </tr>
  <?php if ($totalRows_salidas_hr == 0) { // Show if recordset empty ?>
    <tr>
      <td class="datos">No se han registrado salidas de HOJAS DE RUTA, hasta el momento.</td>
    </tr>
    <?php } // Show if recordset empty ?>
<tr>

<td><div align="right">
  <table border="0">
    <tr>
      <td><?php if ($pageNum_salidas_hr > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_salidas_hr=%d%s", $currentPage, 0, $queryString_salidas_hr); ?>" class="navegacion">&laquo;</a>
          <?php } // Show if not first page ?>
      </td>
      <td><?php if ($pageNum_salidas_hr > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_salidas_hr=%d%s", $currentPage, max(0, $pageNum_salidas_hr - 1), $queryString_salidas_hr); ?>" class="navegacion">Anterior</a>
          <?php } // Show if not first page ?>
      </td>
      <td><?php if ($pageNum_salidas_hr < $totalPages_salidas_hr) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_salidas_hr=%d%s", $currentPage, min($totalPages_salidas_hr, $pageNum_salidas_hr + 1), $queryString_salidas_hr); ?>" class="navegacion">Siguiente</a>
          <?php } // Show if not last page ?>
      </td>
      <td><?php if ($pageNum_salidas_hr < $totalPages_salidas_hr) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_salidas_hr=%d%s", $currentPage, $totalPages_salidas_hr, $queryString_salidas_hr); ?>" class="navegacion">&raquo;</a><a href="<?php printf("%s?pageNum_salidas_hr=%d%s", $currentPage, $totalPages_salidas_hr, $queryString_salidas_hr); ?>" class="navegacion"></a>
          <?php } // Show if not last page ?>
      </td>
    </tr>
  </table>
</div></td>
  </tr>

 <?php if ($totalRows_salidas_hr > 0) { // Show if recordset not empty ?>
<tr>
  <td><table width="100%" border="0" cellspacing="0" cellpadding="0" >
    <tr class="titulos">
      <td width="68" class="titulos">Nº HOJA<br />
        DE RUTA</td>
      <td width="68" class="titulos">FECHA<br />
        HORA<br />
        SALIDA</td>
      <td class="titulos">PROCEDENCIA<br />
        ORG/NOM/CARGO</td>
      <td width="68" class="titulos">Nº DE<br />
        HOJAS</td>
      <td width="110" class="titulos">DERIVADO A:</td>
      <td width="60" class="titulos">objeto<br />
        instruccion</td>
      <td width="170" class="titulos">ENTREGADO A:</td>
    </tr>
    <?php do { ?>
      <tr class="datos">
        <td width="68"><?php echo $row_salidas_hr['hojaruta_cod']; ?></td>
        <td width="68" class="fecha"><?php echo $row_salidas_hr['fecha_envio']; ?></td>
        <td><table width="100%" border="0" cellspacing="3" cellpadding="0">
          <tr>
            <td class="fila_subrayado" style="text-transform:uppercase;"><strong><?php echo $row_salidas_hr['procedencia']; ?></strong></td>
                </tr>
          <tr>
            <td class="ref"><strong>ref</strong>.&nbsp;<?php echo $row_salidas_hr['ref']; ?></td>
                </tr>
        </table></td>
        <td width="68"><table width="100%" border="0" cellspacing="3" cellpadding="0">
          <tr>
            <td class="fila_subrayado"><?php echo $row_salidas_hr['nhojas']; ?></td>
              </tr>
          <tr>
            <td><?php echo $row_salidas_hr['anexos']; ?></td>
              </tr>
          </table>            </td>
        <td width="110"><table width="100%" border="0" cellspacing="3" cellpadding="0">
                <tr>
                  <td class="fila_subrayado"><?php echo $row_salidas_hr['fun_destino']; ?></td>
                </tr>
                <tr>
                  <td class="Estilo3" style="text-transform:uppercase;"><?php echo $row_salidas_hr['dep_destino']; ?></td>
                </tr>
                </table></td>
        <td width="60" valign="top"><table width="100%" border="0" cellspacing="3" cellpadding="0">
          <tr valign="bottom">
            <td height="30" class="entregado"><strong><?php echo $row_salidas_hr['proveido']; ?></strong></td>
          </tr>
          <tr>
            <td class="datos"><?php echo $row_salidas_hr['mensaje']; ?></td>
          </tr>
        </table></td>
        <td width="170"><br />
              <table width="100%" border="0" cellspacing="1" cellpadding="0">
                <tr>
                  <td class="entregado">Nombre:</td>
                </tr>
                <tr>
                  <td class="entregado">Cargo:</td>
                </tr>
                <tr>
                  <td class="entregado">Fecha/Hora:</td>
                </tr>
                <tr>
                  <td class="entregado">Firma/Sello:</td>
                </tr>
              </table></td>
      </tr>
      <?php } while ($row_salidas_hr = mysql_fetch_assoc($salidas_hr)); ?>
    <tr class="datos">
      <td width="68">&nbsp;</td>
      <td width="68">&nbsp;</td>
      <td>&nbsp;</td>
      <td width="68">&nbsp;</td>
      <td width="110">&nbsp;</td>
      <td width="60">&nbsp;</td>
      <td width="170">&nbsp;</td>
    </tr>
  </table></td>
</tr>
<?php } // Show if recordset not empty ?>

</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($salidas_hr);
?>
