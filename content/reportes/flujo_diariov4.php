<?php 
session_name("LoginSIRC");
session_start();
?>
<?php require_once('../../Connections/snet.php'); ?>
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

$colname_entradas = "-1";
//if (isset($_GET['fecha_recibido'])) {
  $colname_entradas =date("Y-m-d 00:00:00"); //$_GET['fecha_recibido'];
//}
$hoyA= date("Y-m-d 00:00:00");
$hoyB= date("Y-m-d 23:59:50");

//$hoyA_entradas = "-1";
//if (isset($hoy)) {
  $hoyA_entradas = $hoyA;
//}
//$hoyB_entradas = "-1";
//if (isset($hoyB)) {
  $hoyB_entradas = $hoyB;
//}
$coddep_entradas = "-1";
if (isset($_SESSION[cod_dep])) {
  $coddep_entradas = $_SESSION[cod_dep];
}
mysql_select_db($database_snet, $snet);
$query_entradas = sprintf("SELECT * FROM entradas WHERE fecha_recibido >= %s AND fecha_recibido<=%s  AND entradas.cod_deprecibido LIKE %s", GetSQLValueString($hoyA_entradas, "date"),GetSQLValueString($hoyB_entradas, "date"),GetSQLValueString($coddep_entradas, "text"));
$entradas = mysql_query($query_entradas, $snet) or die(mysql_error());
$row_entradas = mysql_fetch_assoc($entradas);
$totalRows_entradas = mysql_num_rows($entradas);

$hoy=date("Y-m-d 00:00:00");
//$hoyA_salidas_derivadas = "-1";
//if (isset($hoy)) {
  $hoyA_salidas_derivadas = date("Y-m-d 00:00:00");
//}
//$hoyB_salidas_derivadas = "-1";
//if (isset($hoy)) {
  $hoyB_salidas_derivadas = date("Y-m-d 23:59:50");
//}
/*
$hoyA_salidas_derivadas = "-1";
if (isset($hoyA)) {
  $hoyA_salidas_derivadas = $hoyA;
}
$hoyB_salidas_derivadas = "-1";
if (isset($hoyB)) {
  $hoyB_salidas_derivadas = $hoyB;
}
*/
$coddep_salidas_derivadas = "-1";
if (isset($_SESSION['cod_dep'])) {
  $coddep_salidas_derivadas = $_SESSION['cod_dep'];
}
mysql_select_db($database_snet, $snet);
$query_salidas_derivadas = sprintf("SELECT * FROM salidas, derivacion WHERE derivacion.salidas_id=salidas.id AND derivacion.proveido!='Archivo' AND salidas.fecha_envio>=%s AND salidas.fecha_envio<=%s AND derivacion.cod_depderivador=%s", GetSQLValueString($hoyA_salidas_derivadas, "date"),GetSQLValueString($hoyB_salidas_derivadas, "date"),GetSQLValueString($coddep_salidas_derivadas, "text"));
$salidas_derivadas = mysql_query($query_salidas_derivadas, $snet) or die(mysql_error());
$row_salidas_derivadas = mysql_fetch_assoc($salidas_derivadas);
$totalRows_salidas_derivadas = mysql_num_rows($salidas_derivadas);

/*
  $hoyA_num_en_arch =date("Y-m-d 00:00:00");//date("Y-m-d");//$hoyA;


  $hoyB_num_en_arch =date("Y-m-d 23:59:50"); //$hoyB;

mysql_select_db($database_snet, $snet);
$query_num_en_arch = sprintf("SELECT count(entradas.id) FROM derivacion, entradas WHERE derivacion.entradas_id=entradas.id AND derivacion.proveido='Archivo' AND derivacion.cod_depderivador='".$_SESSION['cod_dep']."' AND (entradas.fecha_recibido>=%s AND entradas.fecha_recibido<=%s)", GetSQLValueString($hoyA_num_en_arch, "date"),GetSQLValueString($hoyB_num_en_arch, "date"));
$num_en_arch = mysql_query($query_num_en_arch, $snet) or die(mysql_error());
$row_num_en_arch = mysql_fetch_assoc($num_en_arch);
$totalRows_num_en_arch = mysql_num_rows($num_en_arch);
*/

  $hoyA_num_en_arch =date("Y-m-d 00:00:00");//$hoyA;


  $hoyB_num_en_arch =date("Y-m-d 23:59:50"); //$hoyB;
mysql_select_db($database_snet, $snet);
$query_num_en_arch = sprintf("SELECT * FROM derivacion, entradas WHERE derivacion.entradas_id=entradas.id AND derivacion.proveido='Archivo' AND derivacion.cod_depderivador='".$_SESSION['cod_dep']."'  AND (entradas.fecha_recibido>='".$hoyA_num_en_arch ."' AND entradas.fecha_recibido<='".$hoyB_num_en_arch ."')");
$num_en_arch = mysql_query($query_num_en_arch, $snet) or die(mysql_error());
$row_num_en_arch = mysql_fetch_assoc($num_en_arch);
$totalRows_num_en_arch = mysql_num_rows($num_en_arch);

?>
<?php
include ("../lib/jpgraph-2.3/src/jpgraph.php");
include ("../lib/jpgraph-2.3/src/jpgraph_bar.php");

//$datay=array(12,8,19,3,10,5);
$datay=array($totalRows_entradas,$totalRows_salidas_derivadas,($totalRows_entradas-$totalRows_salidas_derivadas-$totalRows_num_en_arch),$totalRows_num_en_arch);

// Create the graph. These two calls are always required
$graph = new Graph(600,400,"auto");    
//$graph->SetMarginColor('#F5F5F5');
$graph->SetMarginColor('#CAD2DB');
$graph->SetScale("textlin");
$graph->yaxis->scale->SetGrace(20);

//$graph->SetBackgroundGradient('blue','navy:0.5',GRAD_HOR,BGRAD_PLOT);
// Add a drop shadow
$graph->SetShadow();

// Adjust the margin a bit to make more room for titles
$graph->img->SetMargin(40,30,20,40);

// Create a bar pot
$bplot = new BarPlot($datay);

// Adjust fill color
//$bplot->SetFillColor('orange');
$bplot->SetFillColor(array('#FFFFCC','#CCFFCC', '#FFCC99', '#CEF5FF'));
$bplot->value->Show();
$graph->Add($bplot);

// Setup the titles
$graph->title->Set("Barra de Control de Flujo Diario \"".$_SESSION[cod_dep]."\"");
$graph->xaxis->title->Set("Estado");
//$graph->tabtitle->SetColor('navy','lightyellow','navy'); 
$labels=array("Entradas","Salidas","Pendientes","Archivados");
$graph->xaxis->SetTickLabels($labels);
$graph->yaxis->title->Set("Registros");

$graph->title->SetFont(FF_FONT1,FS_BOLD);
$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);

// Display the graph
$graph->Stroke();
?>
<?php
mysql_free_result($entradas);

mysql_free_result($salidas_derivadas);

mysql_free_result($num_en_arch);
?>