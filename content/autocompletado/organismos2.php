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
$query_obtener_org = "SELECT organismo_nombre FROM organizacion ORDER BY organismo_nombre ASC";
$obtener_org = mysql_query($query_obtener_org, $snet) or die(mysql_error());
$row_obtener_org = mysql_fetch_assoc($obtener_org);
$totalRows_obtener_org = mysql_num_rows($obtener_org);
?>
<?php 
//	do { 
?>
<?php
	// Organismos
//	$datos[count($datos)] =$row_obtener_org['organismo_nombre'];
?>    
	<?php
//	} while ($row_obtener_org = mysql_fetch_assoc($obtener_org));
?>	
<?php
	$datos[count($datos)] = "CCS computadoras";
	$datos[count($datos)] = "OSERMACOM computadoras";
	$datos[count($datos)] = "Import Export Copy Williams";
	$datos[count($datos)] = "AyJ computadoras";
	$datos[count($datos)] = "Globesystem";
	$datos[count($datos)] = "Otros";

	$texto = $_GET["texto"];

	// Devuelvo el XML con la palabra que mostramos (con los '_') y si hay éxito o no
	$xml  = '<?xml version="1.0" standalone="yes"?>';
	$xml .= '<datos>';
	foreach ($datos as $dato) {
		if (strpos(strtoupper($dato), strtoupper($texto)) === 0 OR $texto == "") {
			$xml .= '<pais>'.$dato.'</pais>';
		}
	}
	$xml .= '</datos>';
	header('Content-type: text/xml');
	echo $xml;		
?>
<?php
mysql_free_result($obtener_org);
?>
