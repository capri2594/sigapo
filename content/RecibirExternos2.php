<?php 
session_name("LoginSIRC");
session_start();
?>
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

$colname_listFunUnid = "-1";
if (isset($_SESSION['dep'])) {
  $colname_listFunUnid = $_SESSION['dep'];
}
mysql_select_db($database_snet, $snet);
$query_listFunUnid = sprintf("SELECT nombre FROM funcionario WHERE dependencia_cod = %s ORDER BY nombre ASC", GetSQLValueString($colname_listFunUnid, "text"));
$listFunUnid = mysql_query($query_listFunUnid, $snet) or die(mysql_error());
$row_listFunUnid = mysql_fetch_assoc($listFunUnid);
$totalRows_listFunUnid = mysql_num_rows($listFunUnid);
 
session_name("LoginSIRC");
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Recibir_C_ Interna</title>
<style type="text/css">
<!--
.firma {
	height: 150px;
	width: 300px;
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-style: solid;
	border-right-style: solid;
	border-bottom-style: solid;
	border-left-style: solid;
}
.over {
	background-color: #FFFFC1;
	cursor: text;
}
body {
	font-size: 12px;
	color: #000000;
	font-weight: bold;
	font-family: sans-serif, fantasy, Rockwell, "Lucida Sans";
}
.out {
	background-color: #FFFFFF;
}
-->
</style>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>

<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo2 {color: #000066; }

-->
</style>

<script type="text/javascript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
function quitarFoco(obj){
  document.getElementById('ref').focus();
  document.getElementById('ref').select();
}
</script>
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form>
<table width="100%" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
    <td>
      
        <div align="right">
          <table width="300" border="0" cellpadding="0" cellspacing="5" bgcolor="#D5EAFF">
            <tr>
              <td><input type="submit" name="button" id="button" value="Registrar" /></td>
              <td><input type="submit" name="button2" id="button2" value="Vista Impresion" /></td>
              <td><input name="button3" type="button" id="button3" onclick="" value="cancelar" /></td>
            </tr>
                  </table>
      </div></td>
    <td valign="top">&nbsp;</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div style="border-color:#98BEFE; border-style:solid; border-width:1px;">
    <table width="100%" border="0" cellpadding="0" cellspacing="5" bgcolor="#D5EAFF">
      <tr>
        <td width="5%">&nbsp;</td>
        <td width="34%">&nbsp;</td>
        <td width="27%">&nbsp;</td>
        <td width="34%"><input type="hidden" name="hiddenField" id="hiddenField" value="<?php echo $_SESSION['user']; ?>"/></td>
      </tr>
      <tr>
        <td>de:</td>
        <td><span id="sprytextfield4">
          <input name="tdest_nom" type="text" id="tdest_nom" size="40" onclick="quitarFoco(this);"/>
          <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
        <td><div align="left"><span id="sprytextfield5">
          <input name="tdest_org" type="text" id="tdest_org" size="27" onclick="quitarFoco(this);"/>
          <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></div></td>
        <td align="left"><div align="left"><a href="javascript:void(0);" onclick="MM_openBrWindow('buscarOrg.php','','width=550,height=350')">Examinar</a></div></td>
      </tr>
      <tr>
        <td>para:</td>
        <td><span id="spryselect1">
          <select name="fun_destino" id="fun_destino" style="width:20.6em">
            <?php
do {  
?>
            <option value="<?php echo $row_listFunUnid['nombre']?>"><?php echo $row_listFunUnid['nombre']?></option>
            <?php
} while ($row_listFunUnid = mysql_fetch_assoc($listFunUnid));
  $rows = mysql_num_rows($listFunUnid);
  if($rows > 0) {
      mysql_data_seek($listFunUnid, 0);
	  $row_listFunUnid = mysql_fetch_assoc($listFunUnid);
  }
?>
          </select>
          <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
        <td><span id="sprytextfield7">
          <input name="dep_destino" type="text" id="dep_destino" onclick="quitarFoco(this);" value="<?php echo $_SESSION['dep']; ?>" size="27"/>
          <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
    </div></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div style="border-color:#98BEFE; border-style:solid; border-width:1px;">
    <table width="100%" border="0" cellspacing="4" cellpadding="2">
          <tr>
            <td width="17%"><div align="right" class="Estilo2">Recibido el:&nbsp;</div></td>
            <td width="83%"><span style="background-color:#DBFDE2; border-color: #CCCCCC;">&nbsp;
                <?php 
		$t=date("Y-m-d H:i:s");
		print ($t);?>
&nbsp;&nbsp; </span>
              <input name="fecha_recibido" type="hidden" id="fecha_recibido" value="<?php echo $t;?>" />
              <input name="username" type="hidden" id="username" value="<?php echo $_SESSION['user'];?>" /></td>
          </tr>
          <tr>
            <td><div align="right" class="Estilo2">Fecha emitida:&nbsp;</div></td>
            <td><span id="sprytextfield1"><span id="sprytextfield8">
            <input type="text" name="fecha_emision" id="fecha_emision" onmouseover="this.className='over';" onmouseout="this.className='out';"/>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido. Escriba: dd-mm-aa</span></span><span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
          </tr>
          <tr>
            <td><div align="right" class="Estilo2">Cite:&nbsp;</div></td>
            <td><span id="sprytextfield2"><span id="sprytextfield9">
            <input type="text" name="cite" id="cite" onmouseover="this.className='over';" onmouseout="this.className='out';"/>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span><span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
          </tr>
          <tr>
            <td><div align="right" class="Estilo2">Referencia:&nbsp;</div></td>
            <td><span id="sprytextfield3"><span id="sprytextfield10">
              <input name="ref" type="text" id="ref" size="65" onmouseover="this.className='over';" onmouseout="this.className='out';"/>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span><span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
      </table>
    </div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><table width="300" border="0" cellspacing="5" cellpadding="0">
          <tr>
            <td><input type="submit" name="button" id="button" value="Registrar" /></td>
            <td><input type="submit" name="button2" id="button2" value="Vista Impresion" /></td>
            <td><input type="button" name="button4" id="button4" value="cancelar" /></td>
          </tr>
      </table></td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
<script type="text/javascript">
<!--
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "none");
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "none");
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8", "date", {validateOn:["blur"], format:"dd-mm-yy"});
var sprytextfield9 = new Spry.Widget.ValidationTextField("sprytextfield9", "credit_card", {validateOn:["blur"]});
var sprytextfield10 = new Spry.Widget.ValidationTextField("sprytextfield10", "none", {validateOn:["blur"]});
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
//-->
</script>
</body>
</html>
<?php
mysql_free_result($listFunUnid);
?>
