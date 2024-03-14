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

$texto_listar_fun_remite = "-1";
if (isset($_POST['nombre'])) {
  $texto_listar_fun_remite = $_POST['nombre'];
}
mysql_select_db($database_snet, $snet);
$query_listar_fun_remite = sprintf("SELECT DISTINCT einterna.fun_remite FROM einterna WHERE einterna.fun_remite LIKE %s ORDER BY einterna.fun_remite LIMIT 0,10", GetSQLValueString($texto_listar_fun_remite."%", "text"));
$listar_fun_remite = mysql_query($query_listar_fun_remite, $snet) or die(mysql_error());
$row_listar_fun_remite = mysql_fetch_assoc($listar_fun_remite);
$totalRows_listar_fun_remite = mysql_num_rows($listar_fun_remite);
?>
  
  <ul><?php if ($totalRows_listar_fun_remite>0) {?>
<?php do { ?>
    <li><?php echo $row_listar_fun_remite['fun_remite']; ?></li>
  <?php } while ($row_listar_fun_remite = mysql_fetch_assoc($listar_fun_remite)); ?>
   <?php } ?>
   </ul>
<?php
mysql_free_result($listar_fun_remite);
?>
