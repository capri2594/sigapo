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

$maxRows_listaRecibidos = 5;
$pageNum_listaRecibidos = 0;
if (isset($_GET['pageNum_listaRecibidos'])) {
  $pageNum_listaRecibidos = $_GET['pageNum_listaRecibidos'];
}
$startRow_listaRecibidos = $pageNum_listaRecibidos * $maxRows_listaRecibidos;

//$hoy_listaRecibidos = "2007-12-17 08:52:01";
$hoy_listaRecibidos = date("Y-m-d");
/*if (isset(date("Y-m-d H:i:s"))) {
  $hoy_listaRecibidos = date("Y-m-d H:i:s");
}*/

mysql_select_db($database_snet, $snet);
$query_listaRecibidos = sprintf("SELECT * FROM entradas, eexterna WHERE entradas.fecha_recibido>%s AND eexterna.entradas_id=entradas.id ORDER BY fecha_recibido DESC", GetSQLValueString($hoy_listaRecibidos, "date"));
$query_limit_listaRecibidos = sprintf("%s LIMIT %d, %d", $query_listaRecibidos, $startRow_listaRecibidos, $maxRows_listaRecibidos);
$listaRecibidos = mysql_query($query_limit_listaRecibidos, $snet) or die(mysql_error());
$row_listaRecibidos = mysql_fetch_assoc($listaRecibidos);

if (isset($_GET['totalRows_listaRecibidos'])) {
  $totalRows_listaRecibidos = $_GET['totalRows_listaRecibidos'];
} else {
  $all_listaRecibidos = mysql_query($query_listaRecibidos);
  $totalRows_listaRecibidos = mysql_num_rows($all_listaRecibidos);
}
$totalPages_listaRecibidos = ceil($totalRows_listaRecibidos/$maxRows_listaRecibidos)-1;

$queryString_listaRecibidos = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_listaRecibidos") == false && 
        stristr($param, "totalRows_listaRecibidos") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_listaRecibidos = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_listaRecibidos = sprintf("&totalRows_listaRecibidos=%d%s", $totalRows_listaRecibidos, $queryString_listaRecibidos);
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
.Estilo1 {font-size: 9px}
.Estilo3 {font-size: 9px; font-weight: bold; }
-->
</style>
</head>

<body>
<h3 align="center">Recibidos HOY<span class="style4">(<?php 

//set_locale(LC_ALL,"es_ES@euro","es_ES","esp"); 
//echo strftime("%A %d de %B del %Y");
$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$mes = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
echo $dias[date('w')].", ".date('d')." de ".$mes[date('m')-1]." de ".date("Y");
//echo date("l").",&nbsp;"; echo date(" d F Y");

?>)</span></h3>
<span class="style2">Numero de documentos Registrados:</span> <span class="style5"><?php echo $totalRows_listaRecibidos ?></span> <br />
  <br />

<table width="100%" border="0" cellspacing="1" cellpadding="2">
  <tr class="titulo">
    <td><strong>Hoja de Ruta</strong></td>
    <td><strong>Datos del Documento</strong></td>
    <td><strong>Detalle</strong></td>
  </tr>
  <?php $i=0;do { ?>
      <?php if ($totalRows_listaRecibidos == 0) { // Show if recordset empty ?>
        <tr <?php if (($i%2)==0) echo "class=\"par\""; else echo "class=\"impar\"";?>>
          <td colspan="3">No se han registrados documentos hasta ahora.</td>
        </tr>
        <?php } // Show if recordset empty ?>
      <?php if ($totalRows_listaRecibidos > 0) { // Show if recordset not empty ?>         
            <tr <?php if (($i%2)==0) echo "class=\"par\""; else echo "class=\"impar\"";?>>
              <td><?php echo $row_listaRecibidos['hojaruta_codigo']; ?></td>
              <td><p><strong>de:</strong><em>&nbsp;<?php echo $row_listaRecibidos['remitente']; ?></em><strong><em><span class="Estilo1">&nbsp;&lt;</span></em></strong><em><span class="Estilo3"><?php echo $row_listaRecibidos['org_remitente']; ?></span></em><strong><em><span class="Estilo1">&gt;</span></em><br />
              para</strong><em>:<?php echo $row_listaRecibidos['fun_dest']; ?></em>&nbsp;&lt;<em><?php echo $row_listaRecibidos['dep_dest']; ?></em>&nbsp;::<span class="Estilo1">PREFECTURA DE ORURO</span>&gt;<br />
                    <strong>cite:</strong><em>&nbsp;<?php echo $row_listaRecibidos['cite']; ?>&nbsp;</em><strong>referencia:</strong><em>&nbsp;<?php echo $row_listaRecibidos['ref']; ?></em>&nbsp;&nbsp;<strong>ESTADO</strong>:<br />
                Firmo el ::<strong>proveido</strong>:<em><?php echo $row_listaRecibidos['fun_proveido']; ?></em> en ::<strong>fecha</strong>:<em><?php echo $row_listaRecibidos['fecha_proveido']; ?></em> 
              </td>
              <td>&nbsp;</td>
          </tr>            
        <?php } // Show if recordset not empty ?>

    <?php $i++;} while ($row_listaRecibidos = mysql_fetch_assoc($listaRecibidos)); ?>
</table>
<blockquote>
  <table border="0" align="center">
    <tr>
      <td><?php if ($pageNum_listaRecibidos > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_listaRecibidos=%d%s", $currentPage, 0, $queryString_listaRecibidos); ?>">&lt;&lt;Primero</a>
          <?php } // Show if not first page ?>      </td>
      <td><?php if ($pageNum_listaRecibidos > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_listaRecibidos=%d%s", $currentPage, max(0, $pageNum_listaRecibidos - 1), $queryString_listaRecibidos); ?>">Anterior</a>
      <?php } // Show if not first page ?>      </td>
      <td><div align="center">Paginas:( <?php echo ($startRow_listaRecibidos + 1) ?> a <?php echo min($startRow_listaRecibidos + $maxRows_listaRecibidos, $totalRows_listaRecibidos) ?> / <?php echo $totalRows_listaRecibidos ?>) </div></td>
      <td><?php if ($pageNum_listaRecibidos < $totalPages_listaRecibidos) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_listaRecibidos=%d%s", $currentPage, min($totalPages_listaRecibidos, $pageNum_listaRecibidos + 1), $queryString_listaRecibidos); ?>">Siguiente</a>
      <?php } // Show if not last page ?>      </td>
      <td><?php if ($pageNum_listaRecibidos < $totalPages_listaRecibidos) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_listaRecibidos=%d%s", $currentPage, $totalPages_listaRecibidos, $queryString_listaRecibidos); ?>">&Uacute;ltimo&gt;&gt;</a>
          <?php } // Show if not last page ?></td>
    </tr>
  </table>
</blockquote>
</body>
</html>
<?php
mysql_free_result($listaRecibidos);
?>
