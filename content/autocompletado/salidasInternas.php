<?php 
 header("Content-type: text/xml");
 echo"<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
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

$texto_obtener_sinternas = "-1";
if (isset($_GET['texto'])) {
  $texto_obtener_sinternas = $_GET['texto'];
}
mysql_select_db($database_snet, $snet);
$query_obtener_sinternas = sprintf("SELECT organismo_nombre FROM organizacion, salidas, salinternas WHERE organizacion.organismo_nombre LIKE %s AND salidas.cite=salinternas.salidas_cite", GetSQLValueString($texto_obtener_sinternas, "text"));
$obtener_sinternas = mysql_query($query_obtener_sinternas, $snet) or die(mysql_error());
$row_obtener_sinternas = mysql_fetch_assoc($obtener_sinternas);
$totalRows_obtener_sinternas = mysql_num_rows($obtener_sinternas);
?>
<datos>
  <?php do { ?>
     <pais><?php echo $row_obtener_sinternas['organismo_nombre']; ?></pais>
<?php
    } while ($row_obtener_sinternas = mysql_fetch_assoc($obtener_sinternas));
?>	
</datos>
<?php
mysql_free_result($obtener_sinternas);
?>
