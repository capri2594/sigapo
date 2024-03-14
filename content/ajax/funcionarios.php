<?php require_once('../../Connections/snet.php'); ?>
<?php
//sleep(2);
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

$colname_listarFuncionarios = "-1";
if (isset($_POST['nombre'])) {
  $colname_listarFuncionarios = $_POST['nombre'];
}
mysql_select_db($database_snet, $snet);
$query_listarFuncionarios = sprintf("SELECT nombre FROM funcionario WHERE nombre LIKE %s ORDER BY nombre ASC LIMIT 0,15", GetSQLValueString($colname_listarFuncionarios . "%", "text"));
$listarFuncionarios = mysql_query($query_listarFuncionarios, $snet) or die(mysql_error());
$row_listarFuncionarios = mysql_fetch_assoc($listarFuncionarios);
$totalRows_listarFuncionarios = mysql_num_rows($listarFuncionarios);
?><ul>
 <?php if ($totalRows_listarFuncionarios>0){?>
  <?php do { ?>
    <li><?php echo htmlentities($row_listarFuncionarios['nombre']); ?></li>
    <?php } while ($row_listarFuncionarios = mysql_fetch_assoc($listarFuncionarios)); ?>
    <?php }?>
    </ul>
<?php
mysql_free_result($listarFuncionarios);
?>
