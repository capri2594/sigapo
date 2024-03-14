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

$maxRows_listaEnviados = 5;
$pageNum_listaEnviados = 0;
if (isset($_GET['pageNum_listaEnviados'])) {
  $pageNum_listaEnviados = $_GET['pageNum_listaEnviados'];
}
$startRow_listaEnviados = $pageNum_listaEnviados * $maxRows_listaEnviados;

//$hoy_listaEnviados = "2007-12-17 08:52:01";
$hoy_listaEnviados = date("Y-m-d");
/*if (isset(date("Y-m-d H:i:s"))) {
  $hoy_listaEnviados = date("Y-m-d H:i:s");
}*/
$maxRows_listaEnviados = 10;
$pageNum_listaEnviados = 0;
if (isset($_GET['pageNum_listaEnviados'])) {
  $pageNum_listaEnviados = $_GET['pageNum_listaEnviados'];
}
$startRow_listaEnviados = $pageNum_listaEnviados * $maxRows_listaEnviados;

mysql_select_db($database_snet, $snet);
$query_listaEnviados = "SELECT * FROM salidas ORDER BY fecha_envio DESC";
$query_limit_listaEnviados = sprintf("%s LIMIT %d, %d", $query_listaEnviados, $startRow_listaEnviados, $maxRows_listaEnviados);
$listaEnviados = mysql_query($query_limit_listaEnviados, $snet) or die(mysql_error());
$row_listaEnviados = mysql_fetch_assoc($listaEnviados);

if (isset($_GET['totalRows_listaEnviados'])) {
  $totalRows_listaEnviados = $_GET['totalRows_listaEnviados'];
} else {
  $all_listaEnviados = mysql_query($query_listaEnviados);
  $totalRows_listaEnviados = mysql_num_rows($all_listaEnviados);
}
$totalPages_listaEnviados = ceil($totalRows_listaEnviados/$maxRows_listaEnviados)-1;

$queryString_listaEnviados = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_listaEnviados") == false && 
        stristr($param, "totalRows_listaEnviados") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_listaEnviados = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_listaEnviados = sprintf("&totalRows_listaEnviados=%d%s", $totalRows_listaEnviados, $queryString_listaEnviados);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.par {
	background-color: #F2FCFD;
}
.titulo {
	background-color: #A0CFCF;
}
.impar {
	background-color: #E0E0C2;
}
body {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
}
.style2 {font-size: 13px}
.style4 {font-size: 10}
.style5 {
	font-size: 14px;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<h5 align="center">TODAS LAS CORRESPONDENCIAS <span class="style4">(<?php 

//set_locale(LC_ALL,"es_ES@euro","es_ES","esp"); 
//echo strftime("%A %d de %B del %Y");
$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$mes = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
echo $dias[date('w')].", ".date('d')." de ".$mes[date('m')-1]." de ".date("Y");
//echo date("l").",&nbsp;"; echo date(" d F Y");

?>)</span><br />
REGISTRADAS DE LA PREFECTURA </h5>
<span class="style2">Numero de documentos Registrados:</span> <span class="style5"><?php echo $totalRows_listaEnviados ?> </span> <br />
  <br />

<table width="100%" border="0" cellspacing="1" cellpadding="2">
  <tr class="titulo">
    <td width="80"><strong>CITE</strong></td>
    <td><strong>Datos de la Correspondencia</strong></td>
    <td width="150"><strong>Remitente</strong></td>
    <td width="150"><strong>Recibido por: </strong></td>
  </tr>
  <?php $i=0;do { ?>
  <?php if ($totalRows_listaEnviados == 0) { // Show if recordset empty ?>
        <tr <?php if (($i%2)==0) echo "class=\"par\""; else echo "class=\"impar\"";?>>
          <td colspan="4">No se han registrados documentos hasta ahora.</td>
        </tr>
        <?php } // Show if recordset empty ?>
  <?php if ($totalRows_listaEnviados > 0) { // Show if recordset not empty ?>
        <?php do { ?>
          <tr <?php if (($i%2)==0) echo "class=\"par\""; else echo "class=\"impar\"";?>>
            <td><?php echo $row_listaEnviados['cite']; ?></td>
            <td><p><strong>Ref.</strong> &nbsp;<?php echo $row_listaEnviados['ref']; ?>&nbsp;(enviado el <?php echo $row_listaEnviados['fecha_envio']; ?>) <strong>usuario:</strong>&nbsp;<?php echo $row_listaEnviados['usuario_cuenta']; ?><br />
                    <strong>tipo:</strong>&nbsp;<?php echo $row_listaEnviados['tipo_clase']; ?><strong>&nbsp;tema:</strong>&nbsp;<?php echo $row_listaEnviados['tema_titulo']; ?></td>
            <td><?php echo $row_listaEnviados['fun_remitente']; ?><br />
            <?php echo $row_listaEnviados['dep_remitente']; ?><br /></td>
            <td>(<?php echo $row_listaEnviados['fecha_recibido']; ?>)<br />
            <?php echo $row_listaEnviados['fun_recibido']; ?></td>
          </tr>
          <?php } while ($row_listaEnviados = mysql_fetch_assoc($listaEnviados)); ?>
        <?php } // Show if recordset not empty ?>

    <?php $i++;} while ($row_listaEnviados = mysql_fetch_assoc($listaEnviados)); ?>
</table>
<blockquote>
  <table border="0" align="center">
    <tr>
      <td><?php if ($pageNum_listaEnviados > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_listaEnviados=%d%s", $currentPage, 0, $queryString_listaEnviados); ?>">&lt;&lt;Primero</a>
          <?php } // Show if not first page ?>      </td>
      <td><?php if ($pageNum_listaEnviados > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_listaEnviados=%d%s", $currentPage, max(0, $pageNum_listaEnviados - 1), $queryString_listaEnviados); ?>">&lt;Anterior</a>
      <?php } // Show if not first page ?>      </td>
      <td><div align="center">Paginas:( <?php echo ($startRow_listaEnviados + 1) ?> a <?php echo min($startRow_listaEnviados + $maxRows_listaEnviados, $totalRows_listaEnviados) ?> / <?php echo $totalRows_listaEnviados ?>) </div></td>
      <td><?php if ($pageNum_listaEnviados < $totalPages_listaEnviados) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_listaEnviados=%d%s", $currentPage, min($totalPages_listaEnviados, $pageNum_listaEnviados + 1), $queryString_listaEnviados); ?>">Siguiente&gt;</a>
      <?php } // Show if not last page ?>      </td>
      <td><?php if ($pageNum_listaEnviados < $totalPages_listaEnviados) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_listaEnviados=%d%s", $currentPage, $totalPages_listaEnviados, $queryString_listaEnviados); ?>">&Uacute;ltimo&gt;&gt;</a>
          <?php } // Show if not last page ?></td>
    </tr>
  </table>
</blockquote>
</body>
</html>
<?php
mysql_free_result($listaEnviados);
?>
