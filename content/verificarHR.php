
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

$colname_list_HR = "-1";
if (isset($_GET['codHR'])) {
  $colname_list_HR = $_GET['codHR'];
}
mysql_select_db($database_snet, $snet);
$query_list_HR = sprintf("SELECT * FROM hojaruta WHERE cod = %s ORDER BY cod ASC", GetSQLValueString($colname_list_HR, "text"));
$list_HR = mysql_query($query_list_HR, $snet) or die(mysql_error());
$row_list_HR = mysql_fetch_assoc($list_HR);
$totalRows_list_HR = mysql_num_rows($list_HR);

mysql_free_result($list_HR);
?>
<style type="text/css">
<!--
.Estilo4 {	color: #FF0000;
	font-weight: bold;
}
.Estilo6 {color: #FF0000}
.cuadro {	color: #7A7A7A;
	background-color: #EFF5F1;
	margin: 5px;
	padding: 7px;
	border: 1px solid #D2D2D2;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	width: 630px;
}
.Estilo2 {color: #0033FF}
-->
</style>      
<?php 
	  $trozos = explode("-",$_GET['codHR']);
?>
<table width="500" border="0" cellspacing="3" cellpadding="2">
<?php if ($totalRows_list_HR == 0) { // Show if recordset empty ?>
      <?php if ($trozos[1]!="") {?> 
    <tr>
      <td width="40"><img src="imagen/iconos/bien.gif" width="35" height="32" /></td>
      <td bgcolor="#F5FDF4">El CODIGO puede ser usado</td>
      <td>&nbsp;</td>
    </tr>
       <?php }else { ?>
    <tr>  
  <td><img src="imagen/iconos/informacion.gif" width="31" height="34"></td>
    
      <td>



         <span class="Estilo2">Introduzca un numero de HOJA DE RUTA para el codigo.</span></td>
      <td>&nbsp;</td>
</tr>     <?php }?>
<?php } // Show if recordset empty ?>
  <?php if ($totalRows_list_HR > 0) { // Show if recordset not empty ?>
      <tr>
        <td><img src="imagen/iconos/error.gif" width="30" height="29"></td>
        <td bgcolor="#FFE1E1"><strong>Hoja de Ruta:</strong>&nbsp;<span class="Estilo6"><?php echo $_GET['codHR']; ?></span><br>
          <span class="Estilo4">ERROR:</span> <span class="Estilo6">el codigo existe, no puede utilizarse otra vez.</span></td>
        <td>&nbsp;</td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>fecha de uso de la Hoja de Ruta: <?php echo $row_list_HR['fecha_creacion']; ?></td>
      <td>&nbsp;</td>
    </tr>
    <?php } // Show if recordset not empty ?>
</table>
