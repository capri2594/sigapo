<?php 
session_name("LoginSIRC");
session_start();
$cod_dep=$_SESSION['cod_dep'];
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

mysql_select_db($database_snet, $snet);
$query_list_destinos = "SELECT nombredep, prioridad FROM dependencia WHERE pd = 1 ORDER BY prioridad ASC";
$list_destinos = mysql_query($query_list_destinos, $snet) or die(mysql_error());
$row_list_destinos = mysql_fetch_assoc($list_destinos);
$totalRows_list_destinos = mysql_num_rows($list_destinos);

$colname_list_remite = "-1";
if (isset($_SESSION['cod_dep'])) {
  $colname_list_remite = $_SESSION['cod_dep'];
}
mysql_select_db($database_snet, $snet);
$query_list_remite = sprintf("SELECT nombre FROM funcionario WHERE dependencia_cod = %s ORDER BY cargo ASC", GetSQLValueString($colname_list_remite, "text"));
$list_remite = mysql_query($query_list_remite, $snet) or die(mysql_error());
$row_list_remite = mysql_fetch_assoc($list_remite);
$totalRows_list_remite = mysql_num_rows($list_remite);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.Estilo12 {	font-size: 12px;
	font-family: Albertus, sans-serif, Modern;
}
.Estilo13 {	font-family: Arial, Helvetica, sans-serif
}
.Estilo17 {font-size: 9}
.Estilo9 {	color: #339933;
	font-weight: bold;
}
.cuadro {	color: #7A7A7A;
	background-color: #EFF5F1;
	margin: 5px;
	padding: 7px;
	border: 1px solid #D2D2D2;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	width: 630px;
}
.subrayadoCampo {	width: 50px;
	border-bottom-width: 1px;
	border-bottom-style: solid;
	border-top-color: #000000;
	border-right-color: #000000;
	border-bottom-color: #000000;
	border-left-color: #000000;
	color: #000000;
}
.edit {
	background-color: #FFFFFF;
	width: 230px;
	margin: 0px;
	padding: 0px;
	clear: none;
	float: none;
	border: 0px none #FFFFFF;
}
-->
</style>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td><div class="cuadro">
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td><div align="left">Codigo :&nbsp;<span class="Estilo13"><?php echo $_SESSION['cod_dep']; ?>.<?php echo $_POST['codHR']; ?> &nbsp;</span>&nbsp;</div></td>
          <td>[<span class="Estilo9">OK</span>]</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="right">Fecha<span id="sprytextfield9">
            <input name="dd" type="text" id="dd" value="<?php echo date("d");?>" size="3" maxlength="2" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span><span id="sprytextfield10">
            <input name="mm" type="text" id="mm" value="<?php echo date("m");?>"size="3" maxlength="2" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span><span id="sprytextfield11">
                <input name="aaaa" type="text" id="aaaa" value="<?php echo date("Y");?>"size="5" maxlength="4" />
                <span class="textfieldRequiredMsg">Se necesita un valor.</span></span>
            <input name="fecha_creacion" type="hidden" id="fecha_creacion" value="<?php echo date("Y-m-d H:i:s");?>" />
          </div></td>
          <td><div align="right">Hora:&nbsp;<span id="sprytextfield3">
            <input name="hora" type="text" id="hora" value="<?php echo date("h:s");?>" size="5" maxlength="5" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></div></td>
          <td><div align="right">No. de Hojas <span id="sprytextfield7">
            <input name="nhojas" type="text" id="nhojas" size="8" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span> </div></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><div align="right">No. de Anexos <span id="sprytextfield8">
            <input name="nhojas2" type="text" id="nhojas2" size="8" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></div></td>
        </tr>
      </table>
      Remitente:&nbsp;<span class="subrayadoCampo"><span id="spryselect1">
<select name="select1" class="edit" id="select1" style="width:230px;">
  <?php
do {  
?>
  <option value="<?php echo $row_list_remite['nombre']?>"><?php echo $row_list_remite['nombre']?></option>
  <?php
} while ($row_list_remite = mysql_fetch_assoc($list_remite));
  $rows = mysql_num_rows($list_remite);
  if($rows > 0) {
      mysql_data_seek($list_remite, 0);
	  $row_list_remite = mysql_fetch_assoc($list_remite);
  }
?>
</select>
<span class="selectRequiredMsg">Seleccione un elemento.</span></span>&nbsp;&nbsp;&lt;<em><?php echo $_SESSION['dep']; ?></em>&gt;</span>
      <input name="fun_remite" type="hidden" id="fun_remite" value="<?php echo $_SESSION['fun']; ?>" />
      <input name="dep_remite" type="hidden" id="dep_remite" value="<?php echo $_SESSION['dep']; ?>" />
      <br />
      <br />
      ref.<span id="sprytextfield1">
      <input name="text1" type="text" id="text1" size="70" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span>
      <input name="examinar2" type="button" id="examinar2" onclick="MM_openBrWindow('fun_Destino_value.php','Destinatario','status=yes,width=550,height=250')" value="..." />
      <br />
      <br />
      <span class="Estilo12">PRIMER DESTINATARIO</span><br />
      <br />
      <span id="sprytextfield4"><span class="textfieldRequiredMsg">Se necesita un valor.</span></span>
      <table width="200">
        <tr>
          <td><table width="620" border="0" cellpadding="0" cellspacing="0" >
            <?php for($f=1;$f<=4;$f++) {?>
            <tr>
              <?php for($c=1;$c<=3;$c++) { ?>
              <td><span class="Estilo17">
                <input type="radio" name="GrupoOpciones1" value="opción" id="GrupoOpciones1_0" />
                <label class="Estilo13"> <?php echo $row_list_destinos['nombredep']; ?></label>
                
              </span></td>
              <?php  $row_list_destinos = mysql_fetch_assoc($list_destinos);} ?>
            </tr>
            <?php }?>
          </table></td>
          <td><label></label></td>
        </tr>
      </table>
      <br />
      <br />
    </div></td>
  </tr>
</table>
<script type="text/javascript">
<!--
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
//-->
</script>
</body>
</html>
<?php
mysql_free_result($list_destinos);

mysql_free_result($list_remite);
?>
