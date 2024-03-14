<?php
// Gantt example
include ("../lib/jpgraph-2.3/src/jpgraph.php");
include ("../lib/jpgraph-2.3/src/jpgraph_gantt.php");

// 
// The data for the graphs
//
$data = array(
  array(0,ACTYPE_GROUP,    "DESTINATARIOS",        "2008-05-23","2008-07-2",''),
  array(1,ACTYPE_NORMAL,   "  1.-GABINETE",      "2008-05-26","2008-06-18",'Maribel Pinaya'),
  array(2,ACTYPE_NORMAL,   "  2.-JURIDICA",      "2008-05-26","2008-06-16",'Nils'),
  array(3,ACTYPE_NORMAL,   "  3.-RRHH.",      "2008-06-20","2008-06-22",'Fernando'),
  array(4,ACTYPE_NORMAL,   "  4.-GABINETE",      "2008-06-23","2008-06-30",'PREFECTO'),
  array(5,ACTYPE_MILESTONE,"  ", "2008-06-31",'') );

// The constrains between the activities
$constrains = array(array(1,2,CONSTRAIN_ENDSTART),
            array(1,3,CONSTRAIN_STARTSTART),
			array(3,4,CONSTRAIN_STARTSTART),
            array(4,5,CONSTRAIN_STARTSTART));

$progress = array(array(1,0.4));

// Create the basic graph
$graph = new GanttGraph();
$graph->SetMarginColor('blue:1.7');
$graph->SetBackgroundGradient('white','navy',GRAD_HOR,BGRAD_MARGIN);
$graph->title->Set("HOJA DE RUTA: GABP-3450");
$graph->title->SetFont(FF_ARIAL,FS_BOLD,12);
$graph->subtitle->Set("H.R.: GABP-3450");
//$graph->subtitle->Set("Org.: BANCO MERCANTIL");
$graph->subtitle->Set("ref.: SOLICITUD DE BOLETA DE REMISION");

// Setup scale
$graph->ShowHeaders(GANTT_HYEAR | GANTT_HMONTH | GANTT_HDAY | GANTT_HWEEK);
$graph->scale->month->SetStyle(MONTHSTYLE_SHORTNAMEYEAR2);
$graph->scale->month->SetFontColor("white");
$graph->scale->month->SetBackgroundColor("blue");

$graph->scale->week->SetStyle(WEEKSTYLE_FIRSTDAYWNBR);
/*
$graph->scale->hour->SetIntervall(4);

$graph->scale->hour->SetStyle(HOURSTYLE_HM24);
$graph->scale->day->SetStyle(DAYSTYLE_SHORTDAYDATE3);
*/

// Add the specified activities
$graph->CreateSimple($data,$constrains,$progress);

// .. and stroke the graph
$graph->Stroke();

?>