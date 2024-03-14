<?php 
 header("Content-type: text/xml");
 echo "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" standalone=\"yes\"?>";
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

mysql_select_db($database_snet, $snet);
$query_obtener_org = "SELECT organismo_nombre FROM organizacion";
$obtener_org = mysql_query($query_obtener_org, $snet) or die(mysql_error());
$row_obtener_org = mysql_fetch_assoc($obtener_org);
$totalRows_obtener_org = mysql_num_rows($obtener_org);
$texto = $_GET["texto"];
?><datos>
<?php 
	do { 
//		if (strpos(strtoupper($dato), strtoupper($texto)) === 0 OR $texto == "") {
        if ((strpos($row_obtener_org['organismo_nombre'],$texto) === 0) OR ($texto == "")) {
?>
        <pais><?php echo $row_obtener_org['organismo_nombre']; ?></pais>
        <?php
		}		  
    } while ($row_obtener_org = mysql_fetch_assoc($obtener_org));
?>	
   </datos>

<?php
mysql_free_result($obtener_org);
?>
