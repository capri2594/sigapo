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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if (isset($_GET['id_destino'])) {
  $deleteSQL = sprintf("DELETE FROM derivacion WHERE id=%s",
                       GetSQLValueString($_GET['id_destino'], "int"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($deleteSQL, $snet) or die(mysql_error());
}

if ((isset($_GET['cont'])) && (isset($_GET['cod']))) {
  $updateSQL = sprintf("UPDATE hojaruta SET cont_destinos=%s WHERE cod=%s",
                       GetSQLValueString($_GET['cont']-1, "int"),
                       GetSQLValueString($_GET['cod'], "text"));

  mysql_select_db($database_snet, $snet);
  $Result2 = mysql_query($updateSQL, $snet) or die(mysql_error());
}
if ($Result2) echo "ok";
?>

