<?php 
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

$maxRows_salidas_hr = 10;
$pageNum_salidas_hr = 0;
if (isset($_GET['pageNum_salidas_hr'])) {
  $pageNum_salidas_hr = $_GET['pageNum_salidas_hr'];
}
$startRow_salidas_hr = $pageNum_salidas_hr * $maxRows_salidas_hr;

$midep_salidas_hr = "-1";
if (isset($_SESSION['cod_dep'])) {
  $midep_salidas_hr = $_SESSION['cod_dep'];
}
$hoy_salidas_hr = "2008-01-01";

$hoy_salidas_hr = date("Y-m-d");

mysql_select_db($database_snet, $snet);
$query_salidas_hr = sprintf("SELECT derivacion.hojaruta_cod, derivacion.fun_destino, derivacion.dep_destino, salidas.fecha_envio, derivacion.nhojas, derivacion.anexos, hojaruta.procedencia, hojaruta.ref, derivacion.proveido, derivacion.mensaje FROM derivacion, hojaruta, salidas WHERE derivacion.hojaruta_cod= hojaruta.cod  AND salidas.id=derivacion.salidas_id AND derivacion.cod_depderivador=%s  AND salidas.fecha_envio>%s ORDER BY salidas.fecha_envio", GetSQLValueString($midep_salidas_hr, "date"),GetSQLValueString($hoy_salidas_hr, "date"));
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
.instruccion {
	height: 30px;
	width: auto;
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
	padding: 0px;
	margin-top: 1px;
	margin-right: 1px;
	margin-bottom: 1px;
	margin-left: 15px;
}
.Estilo4 {font-family: Arial, Helvetica, sans-serif; font-size: 9px; margin: 1px; padding: 1px; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; border-top-style: none; border-right-style: none; border-bottom-style: dotted; border-left-style: none; border-top-color: #333333; border-right-color: #333333; border-bottom-color: #333333; border-left-color: #333333; font-weight: bold; }
.ref {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
}
.seleccionado {
	background-color: #FFFFCC;
	border: 1px solid #4B4B4B;
}
.no_selec {
	background-color: #FFFFFF;
	border: 0px none #4B4B4B;
}
.Estilo5 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14px; }
.style1 {font-size: 9px}
-->
</style>
<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript">
function ocultar(objeto){
  //ocultando titulos
  $('titulos').style.visibility='hidden';
  $('paginacion').style.visibility='hidden';
  $('cabecera').style.visibility='hidden';
  //ocultando el elemento:
  $(objeto).style.visibility='hidden';
}
</script>

</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="3" cellpadding="1" id="titulos">
        <tr>
          <td><div align="center" class="Estilo1"><?php echo $_SESSION['dep']; ?></div></td>
        </tr>
        <tr>
          <td><div align="center" class="Estilo2">REGISTRO DE SALIDA (Mensajero)</div></td>
        </tr>
      </table></td>
  </tr>   
 <?php if ($totalRows_salidas_hr > 0) { // Show if recordset not empty ?> 
  <tr>
  <td>
    <table width="100%" border="0" id="paginacion" style="visibility:visible;">
       <tr>
        <td>
         <table width="100%" border="0">
             <tr>
                   <td><div align="right">Pág &nbsp;</div></td><?php for($i=0;$i<=$totalPages_salidas_hr;$i++){?>
          <td width="20px;" align="center" <?php if ($pageNum_salidas_hr-$i){ echo "class=\"no_selec\""; }else{ echo "class=\"seleccionado\""; }; ?> > <a href="<?php printf("%s?pageNum_salidas_hr=%d%s", $currentPage, $i, $queryString_salidas_hr); ?>" class="navegacion">
               <?php  echo ($i+1);?>
              </a></td> 
			  <?php };?>
             </tr>
        </table>
      </td>
      </tr>
	
      <tr>
      <td><table border="0" align="right">

      <tr height="20">
        <td><?php if ($pageNum_salidas_hr > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_salidas_hr=%d%s", $currentPage, 0, $queryString_salidas_hr); ?>" class="Estilo5">&laquo;</a>
            <?php } // Show if not first page ?>        </td>
        <td><?php if ($pageNum_salidas_hr > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_salidas_hr=%d%s", $currentPage, max(0, $pageNum_salidas_hr - 1), $queryString_salidas_hr); ?>" class="navegacion">Anterior</a>
            <?php } // Show if not first page ?>        </td>
        <td><?php if ($pageNum_salidas_hr < $totalPages_salidas_hr) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_salidas_hr=%d%s", $currentPage, min($totalPages_salidas_hr, $pageNum_salidas_hr + 1), $queryString_salidas_hr); ?>" class="navegacion">Siguiente</a>
            <?php } // Show if not last page ?>        </td>
        <td><?php if ($pageNum_salidas_hr < $totalPages_salidas_hr) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_salidas_hr=%d%s", $currentPage, $totalPages_salidas_hr, $queryString_salidas_hr); ?>" class="Estilo5">&raquo;</a>
            <?php } // Show if not last page ?>        </td>
      </tr>
    </table></td>
    </tr>
</table>
</td>
</tr>
  

  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr class="titulos" id="cabecera" style="visibility:visible;">
        <td width="50" class="titulos">Nº HOJA<br />
          DE RUTA</td>
        <td width="65" class="titulos">FECHA<br />
          HORA<br />
          SALIDA</td>
        <td class="titulos">PROCEDENCIA (ORG/NOM/CARGO)<br />
REFERENCIA</td>
        <td width="40" class="titulos">Nº DE<br />
          HOJAS</td>
        <td width="90" class="titulos">DERIVADO A:</td>
        <td width="140" class="titulos">OBJETO<br />
          INSTRUCCION</td>
        <td width="160" class="titulos">ENTREGADO A:</td>
      </tr><?php $reg=1;?>
      <?php do { ?>
        <tr class="datos" id="datos<?php echo $reg ?>" style="visibility:visible; height:85px;" onclick="ocultar(this);">
            <td width="50" height="85" class="fecha"><?php echo $row_salidas_hr['hojaruta_cod']; ?></td>
          <td width="65" height="85" class="fecha"><?php echo $row_salidas_hr['fecha_envio']; ?></td>
          <td height="85"><table width="100%" border="0" cellspacing="3" cellpadding="0">
                <tr>
                  <td class="Estilo4"><?php echo $row_salidas_hr['procedencia']; ?></td>
                </tr>
                <tr>
                  <td class="ref"><strong>ref.&nbsp;</strong><?php echo substr($row_salidas_hr['ref'],0,80);?><?php if (strlen($row_salidas_hr['ref'])>80) {?> ...<?php }?> </td>
            </tr>
                    </table></td>
          <td width="40" height="85"><table width="100%" border="0" cellspacing="3" cellpadding="0">
                <tr>
                  <td class="fila_subrayado"><?php echo $row_salidas_hr['nhojas']; ?></td>
                </tr>
                <tr>
                  <td><span class="style1"><?php echo $row_salidas_hr['anexos']; ?></span></td>
                </tr>
            </table></td>
          <td width="90" height="85"><table width="100%" border="0" cellspacing="3" cellpadding="0">
                <tr>
                  <td class="fila_subrayado"><?php echo $row_salidas_hr['fun_destino']; ?></td>
                </tr>
                <tr>
                  <td><strong><?php echo $row_salidas_hr['dep_destino']; ?></strong></td>
                </tr>
            </table></td>
          <td width="140" height="85" valign="top"><table width="100%" border="0" cellspacing="3" cellpadding="0">

            <tr>
              <td class="Estilo4"><span class="datos"><?php echo $row_salidas_hr['proveido']; ?></span></td>
            </tr>
            <tr>
              <td><div class="instruccion"><?php echo substr($row_salidas_hr['mensaje'],0,105); ?>
                <?php if (strlen($row_salidas_hr['mensaje'])>105) {?>
                ...<?php }?></div></td>
            </tr>
          </table></td>
          <td width="160" height="85" valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="0">
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
        </tr><?php $reg++;?>
        <?php } while ($row_salidas_hr = mysql_fetch_assoc($salidas_hr)); ?>
      <tr class="datos">
        <td width="50">&nbsp;</td>
        <td width="65">&nbsp;</td>
        <td>&nbsp;</td>
        <td width="65">&nbsp;</td>
        <td width="90">&nbsp;</td>
        <td width="140">&nbsp;</td>
        <td width="160">&nbsp;</td>
      </tr>
    </table></td>
  
  
</tr>  
<?php } // Show if recordset not empty ?>

<?php if ($totalRows_salidas_hr == 0) { // Show if recordset empty ?>
  <tr>

      <td class="datos">No se han registrado salidas de HOJAS DE RUTA, hasta el momento.</td>
     
</tr>    
 <?php } // Show if recordset empty ?>

</table>
</body>
</html>
<?php
mysql_free_result($salidas_hr);
?>
