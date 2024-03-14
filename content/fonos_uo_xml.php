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
$query_lista_tel_uo = "SELECT dependencia.nombredep, dependencia.fono1, dependencia.fono2, dependencia.fax, dependencia.id_edificio FROM dependencia";
$lista_tel_uo = mysql_query($query_lista_tel_uo, $snet) or die(mysql_error());
$row_lista_tel_uo = mysql_fetch_assoc($lista_tel_uo);
$totalRows_lista_tel_uo = mysql_num_rows($lista_tel_uo);
?>
<?php header ("content-type: text/xml"); ?>
<?php echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>"; ?>
<directorio>
 <?php do { ?>
 <oficina>
 <nombre><?php echo $row_lista_tel_uo['nombredep']; ?></nombre>
 <fono1><?php echo $row_lista_tel_uo['fono1']; ?></fono1>
 <fono2><?php echo $row_lista_tel_uo['fono2']; ?></fono2>
 <fax><?php echo $row_lista_tel_uo['fax']; ?></fax> 
 </oficina>
 <?php } while ($row_lista_tel_uo = mysql_fetch_assoc($lista_tel_uo)); ?>
</directorio>
<?php
mysql_free_result($lista_tel_uo);
?>
