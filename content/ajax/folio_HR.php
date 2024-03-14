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

$colname_obtener_foliador = "-1";
if (isset($_SESSION['cod_dep'])) {
  $colname_obtener_foliador = $_SESSION['cod_dep'];
}
mysql_select_db($database_snet, $snet);
$query_obtener_foliador = sprintf("SELECT cont_HR FROM dependencia WHERE cod = %s", GetSQLValueString($colname_obtener_foliador, "text"));
$obtener_foliador = mysql_query($query_obtener_foliador, $snet) or die(mysql_error());
$row_obtener_foliador = mysql_fetch_assoc($obtener_foliador);
$totalRows_obtener_foliador = mysql_num_rows($obtener_foliador);
 
?>

<?php echo $row_obtener_foliador['cont_HR']; ?>

<?php
mysql_free_result($obtener_foliador);
?>
