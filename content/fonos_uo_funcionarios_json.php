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

$txtcod_lista_uo_fun = "-1";
if (isset($_GET['id'])) {
  $txtcod_lista_uo_fun = $_GET['id'];
}
mysql_select_db($database_snet, $snet);
$query_lista_uo_fun = sprintf("SELECT * FROM funcionario WHERE funcionario.dependencia_cod=%s", GetSQLValueString($txtcod_lista_uo_fun, "text"));
$lista_uo_fun = mysql_query($query_lista_uo_fun, $snet) or die(mysql_error());
$row_lista_uo_fun = mysql_fetch_assoc($lista_uo_fun);
$totalRows_lista_uo_fun = mysql_num_rows($lista_uo_fun);
?>
<?php 

require_once("lib/json.php");
$json = new Services_JSON;
do{
     $empleados[]=$row_lista_uo_fun;
 }while ($row_lista_uo_fun = mysql_fetch_assoc($lista_uo_fun));
   
$retValue = array(
    'total' => $totalRows_lista_uo_fun,
    'data' =>$empleados
	  );
echo json_encode($retValue);

?>
<?php
mysql_free_result($lista_uo_fun);
?>
