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

mysql_select_db($database_snet, $snet);
$query_dep = "SELECT cod FROM dependencia";
$dep = mysql_query($query_dep, $snet) or die(mysql_error());
$row_dep = mysql_fetch_assoc($dep);
$totalRows_dep = mysql_num_rows($dep);
//obteniendo las dependencias de la Prefectura
$i=0; $hoyA=date("Y-m-d 00:00:00");
$fechahora=explode(" ",$hoyA);
$fecha=$fechahora[0];
$fechaB=explode("-",$fecha);
$hoyB= $fechaB[0]."-".$fechaB[1]."-".($fechaB[2]+1)." 00:00:00";

do { 
     $cod[$i]=$row_dep['cod']; 
	 
// fin obtener codigos...
    
mysql_select_db($database_snet, $snet);
$query_n_entradas = sprintf(" SELECT count( * ) as total FROM `entradas` WHERE ((`fecha_recibido` >= %s) AND (`fecha_recibido` <= %s)) AND `cod_deprecibido`=%s", GetSQLValueString($hoyA, "date"),GetSQLValueString($hoyB, "date"),GetSQLValueString($cod[$i], "text"));
$n_entradas = mysql_query($query_n_entradas, $snet) or die(mysql_error());
$row_n_entradas = mysql_fetch_assoc($n_entradas);
$totalRows_n_entradas = mysql_num_rows($n_entradas);

   $datay[$i]=$row_n_entradas['total'];
   $i++;

   } while ($row_dep = mysql_fetch_assoc($dep));
?>
<?php 
include ("../lib/jpgraph-2.3/src/jpgraph.php");
include ("../lib/jpgraph-2.3/src/jpgraph_bar.php");

$data1y=array(12,8,19,3,10,5);
$data2y=array(8,2,11,7,14,4);

// Create the graph. These two calls are always required
$graph = new Graph(310,200,"auto");    
$graph->SetScale("textlin");

$graph->SetShadow();
$graph->img->SetMargin(40,30,20,40);

// Create the bar plots
$b1plot = new BarPlot($data1y);
$b1plot->SetFillColor("orange");
$b2plot = new BarPlot($data2y);
$b2plot->SetFillColor("blue");

// Create the grouped bar plot
$gbplot = new GroupBarPlot(array($b1plot,$b2plot));

// ...and add it to the graPH
$graph->Add($gbplot);

$graph->title->Set("Example 21");
$graph->xaxis->title->Set("X-title");
$graph->yaxis->title->Set("Y-title");

$graph->title->SetFont(FF_FONT1,FS_BOLD);
$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);

// Display the graph
$graph->Stroke();
?>