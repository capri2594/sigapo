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
$query_motivos = "SELECT * FROM motivo";
$motivos = mysql_query($query_motivos, $snet) or die(mysql_error());
$row_motivos = mysql_fetch_assoc($motivos);
$totalRows_motivos = mysql_num_rows($motivos);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Fijar un motivo Rapido</title>
<style type="text/css">
<!--
.motivos {
	font-family: Albertus, sans-serif, Modern;
	font-size: 12px;
}
-->
.over{
 background-color:#FDF19F;
 	font-family: Albertus, sans-serif, Modern;
	font-size: 12px;
}
.out{
 background-color:#FFFFFF;
 	font-family: Albertus, sans-serif, Modern;
	font-size: 12px;
}
</style>
<script type="text/javascript">
function JJ_insertar(nomX) { //v9.0
   
    with (document) 
	if (getElementById && ((objnom=getElementById(nomX))!=null)) 
	{ 
   	  //alert(objnom.value);
	  //alert(window.opener.self.document.getElementById('tmotivo').value);
	  window.opener.self.document.getElementById('tmotivo').value=objnom.value;
	  window.opener.self.document.getElementById('tmotivo').disabled=false;
	  window.top.close();
	}else
	alert("SIRC error: al insertar registro");
}
//-->
</script>


</head>

<body>
<fieldset>
<legend>Elegir</legend>
<br />
<table width="200">
  <?php $num=0; do { ?>
    <tr>
      <td class="motivos" onmouseover="this.className='over';" onmouseout="this.className='out';" onclick="JJ_insertar('Opcion<?php echo $num; ?>')"><label>
        <input type="radio" name="Opcion<?php echo $num; ?>" value="<?php echo $row_motivos['motivos']; ?>" id="Opcion<?php echo $num; ?>" onclick="JJ_insertar('Opcion<?php echo $num; ?>')" />
        <?php echo $row_motivos['motivos']; ?></label></td>
    </tr>
    <?php $num=$num+1;} while ($row_motivos = mysql_fetch_assoc($motivos)); ?>
</table>
</p>

</fieldset>
<input type="button" name="Cerrar" id="Cerrar" value="Cerrar" onclick="self.window.close();"/>
</body>
</html>
<?php
mysql_free_result($motivos);
?>
