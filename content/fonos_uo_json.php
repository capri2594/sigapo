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

mysql_select_db($database_snet, $snet);
$query_lista_tel_uo = "SELECT dependencia.nombredep, dependencia.fono1, dependencia.fono2, dependencia.fax, dependencia.id_edificio, dependencia.cod, dependencia.sigla FROM dependencia
order by dependencia.nombredep";
$lista_tel_uo = mysql_query($query_lista_tel_uo, $snet) or die(mysql_error());
$row_lista_tel_uo = mysql_fetch_assoc($lista_tel_uo);
$totalRows_lista_tel_uo = mysql_num_rows($lista_tel_uo);
?>
<?php 
/*require_once("lib/json.php");
$json = new Services_JSON;

do{
     $ofis[]=$row_lista_tel_uo;
 }while ($row_lista_tel_uo = mysql_fetch_assoc($lista_tel_uo));
   
$datos[0]=array("total"=>$totalRows_lista_tel_uo);
$datos[1]=array("data"=>$ofis);
echo $json->encode($datos);
*/
/*
require_once("lib/json.php");
$json = new Services_JSON;
$retValue = array(
    'total' => 4,
    'data' => array(
        array(
            'nombredep' => 1,
            'fono1' => 'Categoría 1',
            'fono2' => 'Descripción de la primera categoría',
            'fax' => '2008-10-01'
        ),
        array(
            'nombredep' => 2,
            'fono1' => 'Categoría 2',
            'fono2' => 'Descripción de la segunda categoría',
            'fax' => '2008-10-11'
        ),
        array(
            'nombredep' => 3,
            'fono1' => 'Categoría 3',
            'fono2' => 'Descripción de la tercera categoría',
            'fax' => '2008-10-20'
        ),
        array(
            'nombredep' => 4,
            'fono1' => 'Categoría 4',
            'fono2' => 'Descripción de la cuarta categoría',
            'fax' => '2008-10-21'
        )
    )
);
echo json_encode($retValue);
*/

require_once("lib/json.php");
$json = new Services_JSON;
do{
     $ofis[]=$row_lista_tel_uo;
 }while ($row_lista_tel_uo = mysql_fetch_assoc($lista_tel_uo));
   
$retValue = array(
    'total' => $totalRows_lista_tel_uo,
    'data' =>$ofis
	  );
echo json_encode($retValue);

?>
<?php
mysql_free_result($lista_tel_uo);
?>
