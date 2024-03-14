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
/*
echo "idinterna=".$_GET['idinterna']."</br> ";
echo "idexterna=".$_GET['idexterna']."</br> ";
echo "cod=".$_GET['cod']."</br> ";
echo "ref=".$_GET['ref']."</br> ";
echo "refe=".$_GET['refe']."</br> ";
echo "refvalue=".$_GET['value']."*****</br>";

$numero = count($_GET);
$tags = array_keys($_GET);
$valores = array_values($_GET);
for($i=0;$i<$numero;$i++){
  echo $tags[$i]."=".$valores[$i]."</br>";
}
*/
if ((isset($_GET['value']))&&($_GET['value']=="")){
  $_GET['value']="vacio";
  }
    
if ((isset($_GET['idinterna'])) && ($_GET['idinterna']>0)) {
  $updateSQL = sprintf("UPDATE einterna SET `ref`=%s WHERE id_interna=%s AND HR=%s",
                       GetSQLValueString($_GET['value'], "text"),
                       GetSQLValueString($_GET['idinterna'], "int"),
                       GetSQLValueString($_GET['cod'], "text"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($updateSQL, $snet) or die(mysql_error());
}

if ((isset($_GET['idexterna'])) && ($_GET['idexterna']>0)) {
  $updateSQL = sprintf("UPDATE eexterna SET `ref`=%s WHERE id_externa=%s AND HR=%s",
                       GetSQLValueString($_GET['value'], "text"),
                       GetSQLValueString($_GET['idexterna'], "int"),
                       GetSQLValueString($_GET['cod'], "text"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($updateSQL, $snet) or die(mysql_error());
}
if ($Result1) {
  $updateSQL = sprintf("UPDATE hojaruta SET `ref`=%s WHERE cod=%s",
                       GetSQLValueString($_GET['value'], "text"),
                       GetSQLValueString($_GET['cod'], "text"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($updateSQL, $snet) or die(mysql_error());
} 
if ($Result1) { echo $_GET['value'];}
else{ echo "Error: se desconoce la relacion de datos. Avise al administrador del Sistema";}

?>
