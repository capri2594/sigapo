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

$texto_obtener_codHR = "-1";
if (isset($_GET['texto'])) {
  $texto_obtener_codHR = $_GET['texto'];
}
mysql_select_db($database_snet, $snet);
$query_obtener_codHR = sprintf("SELECT hojaruta.cod FROM hojaruta WHERE cod LIKE %s ORDER BY hojaruta.cod ASC LIMIT 0,50", GetSQLValueString($texto_obtener_codHR."%", "text"));
$obtener_codHR = mysql_query($query_obtener_codHR, $snet) or die(mysql_error());
$row_obtener_codHR = mysql_fetch_assoc($obtener_codHR);
$totalRows_obtener_codHR = mysql_num_rows($obtener_codHR);
?>
<ul>
 <?php do { ?>
     <li><?php echo $row_obtener_codHR['cod']; ?></li>
<?php
    } while ($row_obtener_codHR = mysql_fetch_assoc($obtener_codHR));
?>	
</ul>
<?php
mysql_free_result($obtener_codHR);
?>
