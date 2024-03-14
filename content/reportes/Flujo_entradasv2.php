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
include ("../lib/jpgraph-2.3/src/jpgraph_bar.php");

//$datay=array(2,3,5,8,12,6,3);
//$datax=array("Jan","Feb","Mar","Apr","May","Jun","Jul");
$datax=$cod;
$width=600;  //antes 400
$height=1000;

// Set the basic parameters of the graph 
//$graph = new Graph($width,$height,'auto');
$graph = new Graph($width,$height);
$graph->SetScale("textlin",0,50);
//$graph->SetScale("textlin");

$top = 80;
$bottom = 30;
$left = 180;//era 50
$right = 30;
$graph->Set90AndMargin($left,$right,$top,$bottom);
/*$graph = new Graph(600,1000);
$graph->SetMarginColor('white');
$graph->SetScale("textlin",0,50);*/

//$graph->SetMargin(30,50,30,30);
//$graph->SetColor('darkblue');
//$graph->SetAxisStyle(AXSTYLE_BOXOUT);
//$graph->SetBackgroundImage("blueblack400x300grad.png",1);
//$graph->SetBackgroundImage("blueblack400x300grad.png");
$graph->SetFrame(true,'white');
$graph->SetBackgroundGradient('blue','navy:0.5',GRAD_HOR,BGRAD_PLOT);
$graph->tabtitle->Set(' 3rd Division del asdfasdfasdfasdfasdfsdfsdf ' );
$graph->tabtitle->SetFont(FF_ARIAL,FS_BOLD,13);
// Nice shadow
$graph->SetShadow();

// Setup title
$graph->title->Set("Flujo de Entradas x Unidades de la Prefectura");
$graph->title->SetFont(FF_VERDANA,FS_BOLD,13);
//$graph->subtitle->Set("(Quien trabajo mas? ...es SDAF Cmartinez ".$hoyA."-to-".$hoyB);
$graph->subtitle->Set("Fecha de Reporte: ".$hoyA);

// Setup X-axis
$graph->xaxis->SetTickLabels($datax);
$graph->xaxis->SetFont(FF_VERDANA,FS_NORMAL,11);

// Some extra margin looks nicer
$graph->xaxis->SetLabelMargin(15);

// Label align for X-axis
$graph->xaxis->SetLabelAlign('right','center');

// Add some grace to y-axis so the bars doesn't go
// all the way to the end of the plot area
$graph->yaxis->scale->SetGrace(40);//era 20
$graph->yaxis->SetLabelAlign('center','bottom');
$graph->yaxis->SetLabelAngle(45);
$graph->yaxis->SetLabelFormat('%d');
$graph->yaxis->SetFont(FF_VERDANA,FS_NORMAL,11);

// We don't want to display Y-axis
//$graph->yaxis->Hide();

// Now create a bar pot
$bplot = new BarPlot($datay);
$bplot->SetFillColor("orange");
//$bplot->SetFillGradient("lightsteelblue","navy",GRAD_HOR);
//$bplot->SetFillGradient("orange","yellow",GRAD_HOR);
$bplot->SetShadow();

//You can change the width of the bars if you like
//$bplot->SetWidth(0.5);

// We want to display the value of each bar at the top
$bplot->value->Show();
$bplot->value->SetFont(FF_ARIAL,FS_BOLD,12);
$bplot->value->SetAlign('left','center');
//$bplot->value->SetColor("black","");
$bplot->value->SetColor("black","darkred");
$bplot->value->SetFormat('%.0f reg.');

// Add the bar to the graph
$graph->Add($bplot);
$graph-> footer->left->Set ("(C) 2008");
$graph->footer-> center->Set("Unidad de Sistemas Informaticos" );
$graph->footer-> center-> SetColor("navy");
$graph->footer-> center-> SetFont( FF_FONT2, FS_BOLD);
$graph->footer-> right->Set($hoyA );
$graph->Stroke();
?>
