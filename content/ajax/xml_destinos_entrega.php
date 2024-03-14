<?php 
header ("content-type: text/xml");
//header("Cache-Control: no-cache");
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
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

$identrada_entrega = "-1";
if (isset($_GET['iden'])) {
  $identrada_entrega = $_GET['iden'];
}
mysql_select_db($database_snet, $snet);
$query_entrega = sprintf("SELECT * FROM entradas WHERE entradas.id=%s", GetSQLValueString($identrada_entrega, "int"));
$entrega = mysql_query($query_entrega, $snet) or die(mysql_error());
$row_entrega = mysql_fetch_assoc($entrega);
$totalRows_entrega = mysql_num_rows($entrega);
 
 //header("Cache-Control: no-cache");
// header('Content-Type: text/html; charset=UTF-8');
// session_name("LoginSIRC"); 
// session_start();
 ?> 
 <?php 
 require_once("../include/convertir_fechas.php");
 ?>
<recibido>
 <id><?php echo $row_entrega['id']; ?></id>
 <nombre><?php echo $row_entrega['fun_recibido']; ?>
 </nombre>
 <usuario><?php echo $row_entrega['usuario_cuenta']; ?>
 </usuario>
 <lugar><?php echo $row_entrega['dep_recibido']; ?>
 </lugar>
 <fecha><?php echo cambiar_a_normal_letra_con_hora($row_entrega['fecha_recibido']); ?></fecha>
 </recibido>
<?php
mysql_free_result($entrega);
?>