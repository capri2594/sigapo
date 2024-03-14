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


include ("../lib/jpgraph-2.3/src/jpgraph.php");
include ("../lib/jpgraph-2.3/src/jpgraph_line.php");

$datay1 = array(4,26,12,18,8,22);
$datay2 = array(12,9,42,8,20,19);

// Setup the graph
$graph = new Graph(300,200);
$graph->SetMarginColor('white');
$graph->SetScale("textlin",0,50);
$graph->SetMargin(30,50,30,30);

// We must have the frame enabled to get the gradient
// However, we don't want the frame line so we set it to
// white color which makes it invisible.
$graph->SetFrame(true,'white');

// Setup a background gradient image
$graph->SetBackgroundGradient('blue','navy:0.5',GRAD_HOR,BGRAD_PLOT);

// Setup the tab title
$graph->tabtitle->Set(' 3rd Division ' );
$graph->tabtitle->SetFont(FF_ARIAL,FS_BOLD,13);

// Setup x,Y grid
$graph->xgrid->Show();
$graph->xgrid->SetColor('gray@0.5');
$graph->xaxis->SetTickLabels($gDateLocale->GetShortMonth());
$graph->ygrid->SetColor('gray@0.5');

// Setup color for axis and labels on axis
$graph->xaxis->SetColor('orange','black');
$graph->yaxis->SetColor('orange','black');

// Ticks on the outsid
$graph->xaxis->SetTickSide(SIDE_DOWN);
$graph->yaxis->SetTickSide(SIDE_LEFT);

// Setup the legend box colors and font
$graph->legend->SetColor('white','navy');
$graph->legend->SetFillColor('navy@0.25');
$graph->legend->SetFont(FF_ARIAL,FS_BOLD,8);
$graph->legend->SetShadow('darkgray@0.4',3);
$graph->legend->SetPos(0.05,0.05,'right','top');

// Create the first line
$p1 = new LinePlot($datay1);
$p1->SetColor("red");
$p1->SetWeight(2);
$p1->SetLegend('2002');
$graph->Add($p1);

// Create the second line
$p2 = new LinePlot($datay2);
$p2->SetColor("lightyellow");
$p2->SetLegend('2001');
$p2->SetWeight(2);
$graph->Add($p2);

// Output line
$graph->Stroke();
$graph-> footer->left->Set ("(C) 2008");
$graph->footer-> center->Set("Unidad de Sistemas Informaticos" );
$graph->footer-> center-> SetColor("navy");
$graph->footer-> center-> SetFont( FF_FONT2, FS_BOLD);
$graph->footer-> right->Set($hoyA );
$graph->Stroke();
?>