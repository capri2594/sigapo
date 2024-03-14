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
if (isset($_POST['cod'])) {
  $colname_buscarHR = $_POST['cod'];
}
mysql_select_db($database_snet, $snet);
$query_buscarHR = sprintf("SELECT cod FROM hojaruta WHERE cod LIKE %s ORDER BY cod ASC", GetSQLValueString($colname_buscarHR."%", "text"));
$buscarHR = mysql_query($query_buscarHR, $snet) or die(mysql_error());
$row_buscarHR = mysql_fetch_assoc($buscarHR);
$totalRows_buscarHR = mysql_num_rows($buscarHR);
?><ul><?php $i=1;?>
  <?php do { ?>
    <li><?php echo $row_buscarHR['cod'] ?></li><?php $i++;?>
    <?php } while (($row_buscarHR = mysql_fetch_assoc($buscarHR))&& ($i<=10)); ?></ul>
<?php
mysql_free_result($buscarHR);
?>
