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

$colname_buscarHR = "-1";
if (isset($_POST['cod']) && trim($_POST['cod']) !== '') {
  $colname_buscarHR = trim($_POST['cod']);
} elseif (isset($_GET['texto']) && trim($_GET['texto']) !== '') {
  $colname_buscarHR = trim($_GET['texto']);
} elseif (isset($_REQUEST['cod']) && trim($_REQUEST['cod']) !== '') {
  $colname_buscarHR = trim($_REQUEST['cod']);
}

mysql_select_db($database_snet, $snet);
$escaped_term = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($colname_buscarHR) : mysql_escape_string($colname_buscarHR);
$query_buscarHR = sprintf("SELECT cod FROM hojaruta WHERE cod LIKE '%%%s%%' ORDER BY fecha_creacion DESC LIMIT 0, 15", $escaped_term);
$buscarHR = mysql_query($query_buscarHR, $snet) or die(mysql_error());
$row_buscarHR = mysql_fetch_assoc($buscarHR);
$totalRows_buscarHR = mysql_num_rows($buscarHR);
?><ul><?php if ($totalRows_buscarHR > 0) { $i = 1; ?>
  <?php do { ?>
    <li><?php echo $row_buscarHR['cod']; ?></li><?php $i++; ?>
  <?php } while (($row_buscarHR = mysql_fetch_assoc($buscarHR)) && ($i <= 15)); ?>
<?php } ?></ul>
<?php
mysql_free_result($buscarHR);
?>
