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

$texto_listar_dep_remitente = "-1";
if (isset($_POST['nombre'])) {
  $texto_listar_dep_remitente = $_POST['nombre'];
}
mysql_select_db($database_snet, $snet);
$query_listar_dep_remitente = sprintf("SELECT DISTINCT einterna.dep_remite FROM einterna WHERE einterna.dep_remite LIKE %s ORDER BY einterna.dep_remite LIMIT 0,8", GetSQLValueString($texto_listar_dep_remitente."%", "text"));
$listar_dep_remitente = mysql_query($query_listar_dep_remitente, $snet) or die(mysql_error());
$row_listar_dep_remitente = mysql_fetch_assoc($listar_dep_remitente);
$totalRows_listar_dep_remitente = mysql_num_rows($listar_dep_remitente);
?> <ul>
   <?php if ($totalRows_listar_dep_remitente>0) {?>
<?php do { ?>
 
    <li><?php echo $row_listar_dep_remitente['dep_remite']; ?></li>
      
  <?php } while ($row_listar_dep_remitente = mysql_fetch_assoc($listar_dep_remitente)); ?>
      <?php } ?>
  </ul>
  
<?php
mysql_free_result($listar_dep_remitente);
?>
