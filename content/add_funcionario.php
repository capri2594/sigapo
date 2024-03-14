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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO funcionario (nombre, dependencia_cod, ci, cargo) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['cod_dep'], "text"),
                       GetSQLValueString($_POST['ci'], "text"),
                       GetSQLValueString($_POST['cargo'], "text"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($insertSQL, $snet) or die(mysql_error());

  $insertGoTo = "datagrid/view.php?cod_dep=".$_SESSION['cod_dep'];
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />

<style type="text/css">
<!--
.cabecera {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
	background-color: #F8F8F8;
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: solid;
	border-left-style: none;
	border-top-color: #FFF5CE;
	border-right-color: #FFF5CE;
	border-bottom-color: #FFF5CE;
	border-left-color: #FFF5CE;
	text-indent: 10px;
	height: 80px;
	margin: 1px;
	padding: 1px;
}
-->
</style>
</head>

<body><form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
<table width="100%" border="0" cellspacing="1" cellpadding="0">
  <tr class="cabecera">
    <td height="30">ADICIONAR COMPAÑERO DE TRABAJO</td>
  </tr>
  <tr>
    <td>
      <table width="100%" border="0" cellspacing="2" cellpadding="5">
        <tr>
          <td width="140">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td width="140">Nombre Completo</td>
          <td><span id="spry_nombre">
            <input name="nombre" type="text" id="nombre" size="45" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
        </tr>
        <tr>
          <td width="140">Cargo</td>
          <td><span id="spry_cargo">
            <input name="cargo" type="text" id="cargo" size="45" maxlength="20" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
        </tr>
        <tr>
          <td width="140">C.I.</td>
          <td><span id="spry_ci">
            <input type="text" name="ci" id="ci" />
            </span></td>
        </tr>
        <tr>
          <td width="140">&nbsp;</td>
          <td><input name="cod_dep" type="hidden" id="cod_dep" value="<?php echo $_SESSION['cod_dep']; ?>" /></td>
        </tr>
        <tr>
          <td width="140">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>    </td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td><input type="submit" name="button" id="button" value="Agregar Funcionario" /></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>  
<input type="hidden" name="MM_insert" value="form1" />
</form>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("spry_nombre", "none", {validateOn:["blur"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("spry_cargo", "none", {validateOn:["blur"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("spry_ci", "none", {isRequired:false});
//-->
</script>
</body>
</html>
