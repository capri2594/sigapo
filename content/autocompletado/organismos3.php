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

$texto_obtener_org = "-1";
if (isset($_GET['texto'])) {
  $texto_obtener_org = $_GET['texto'];
}
mysql_select_db($database_snet, $snet);
$query_obtener_org = sprintf("SELECT organismo_nombre FROM organizacion  WHERE organizacion.organismo_nombre LIKE %s", GetSQLValueString($texto_obtener_org."%", "text"));
$obtener_org = mysql_query($query_obtener_org, $snet) or die(mysql_error());
$row_obtener_org = mysql_fetch_assoc($obtener_org);
$totalRows_obtener_org = mysql_num_rows($obtener_org);
?>
<datos>
  <?php do { ?>
     <pais><?php echo $row_obtener_org['organismo_nombre']; ?></pais>
<?php
    } while ($row_obtener_org = mysql_fetch_assoc($obtener_org));
?>	
</datos>
<?php
mysql_free_result($obtener_org);
?>
