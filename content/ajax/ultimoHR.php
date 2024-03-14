<?php 
session_name("LoginSIRC");
session_start();
//header("Content-Type: text/html; charset=utf-8");
//echo  "dep:".$_SESSION['dep']
//$cod_dep=$_SESSION['cod_dep'];
//echo  "dep:".$cod_dep;
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

$colname_obtener_ultimoHR = "-1";
if (isset($_SESSION['cod_dep'])) {
  $colname_obtener_ultimoHR = $_SESSION['cod_dep'];
}
mysql_select_db($database_snet, $snet);
$query_obtener_ultimoHR = sprintf("SELECT cod FROM hojaruta WHERE cod LIKE %s ORDER BY cod DESC", GetSQLValueString($colname_obtener_ultimoHR."%", "text"));
$obtener_ultimoHR = mysql_query($query_obtener_ultimoHR, $snet) or die(mysql_error());
$row_obtener_ultimoHR = mysql_fetch_assoc($obtener_ultimoHR);
$totalRows_obtener_ultimoHR = mysql_num_rows($obtener_ultimoHR);
?>
<?php echo $row_obtener_ultimoHR['cod']; ?>

<?php
mysql_free_result($obtener_ultimoHR);
?>
