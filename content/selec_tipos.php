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

mysql_select_db($database_snet, $snet);
$query_Record_tipo = "SELECT * FROM tipo";
$Record_tipo = mysql_query($query_Record_tipo, $snet) or die(mysql_error());
$row_Record_tipo = mysql_fetch_assoc($Record_tipo);
$totalRows_Record_tipo = mysql_num_rows($Record_tipo);
?>
<select name="tipo" id="tipo">
  <?php
do {  
?>
  <option value="<?php echo $row_Record_tipo['clase']?>"><?php echo $row_Record_tipo['clase']?></option>
  <?php
} while ($row_Record_tipo = mysql_fetch_assoc($Record_tipo));
  $rows = mysql_num_rows($Record_tipo);
  if($rows > 0) {
      mysql_data_seek($Record_tipo, 0);
	  $row_Record_tipo = mysql_fetch_assoc($Record_tipo);
  }
?>
</select>
<?php
mysql_free_result($Record_tipo);
?>
