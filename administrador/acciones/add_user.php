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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "add_user")) {
  $insertSQL = sprintf("INSERT INTO funcionario (nombre, usuario_cuenta, dependencia_cod, ci, cargo, celular, telefono, email) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['usuario'], "text"),
                       GetSQLValueString($_POST['dependencia'], "text"),
                       GetSQLValueString($_POST['ci'], "text"),
                       GetSQLValueString($_POST['cargo'], "text"),
                       GetSQLValueString($_POST['celular'], "text"),
                       GetSQLValueString($_POST['telefono'], "text"),
                       GetSQLValueString($_POST['email'], "text"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($insertSQL, $snet) or die(mysql_error());
}

mysql_select_db($database_snet, $snet);
$query_list_dep = "SELECT * FROM dependencia";
$list_dep = mysql_query($query_list_dep, $snet) or die(mysql_error());
$row_list_dep = mysql_fetch_assoc($list_dep);
$totalRows_list_dep = mysql_num_rows($list_dep);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>

<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.lateral {
	border-top-width: 0px;
	border-right-width: 0px;
	border-bottom-width: 2px;
	border-left-width: 0px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: solid;
	border-left-style: none;
	border-top-color: #666666;
	border-right-color: #666666;
	border-bottom-color: #666666;
	border-left-color: #666666;
	width: 550px;
}
.barra {
	background-color: #848484;
	height: auto;
	width: 550px;
}
-->
</style>
</head>

<body>
<form id="add_user" name="add_user" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="100%" border="0" cellspacing="1" cellpadding="0">
    <tr>
      <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td>&nbsp;</td>
          <td><div align="right"><img src="../img/logo/USIP_5.jpg" width="332" height="69" /></div></td>
        </tr>
        
      </table></td>
    </tr>
    <tr>
      <td><div class="lateral">REGISTRO DE FUNCIONARIO</div></td>
    </tr>
    <tr>
      <td><div class="barra">&nbsp;</div></td>
    </tr>
    <tr>
      <td><table width="550" border="0" align="left" cellpadding="0" cellspacing="2">
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="right">Usuario</div></td>
          <td>&nbsp;</td>
          <td><span id="sprytextfield1">
            <table width="380" border="0" cellspacing="1" cellpadding="0">
              <tr>
                <td width="100"><input type="text" name="usuario" id="usuario" /></td>
                <td width="200"><span class="textfieldRequiredMsg">Se necesita un valor.</span></td>
              </tr>
            </table>
          </span> </td>
        </tr>
        <tr>
          <td><div align="right">Contraseña</div></td>
          <td>&nbsp;</td>
          <td><span id="sprytextfield2">
            <table width="380" border="0" cellspacing="1" cellpadding="0">
              <tr>
                <td width="157"><input type="password" name="password" id="password" /></td>
                <td width="220"><span class="textfieldRequiredMsg">Se necesita un valor.</span></td>
              </tr>
            </table>
          </span> </td>
        </tr>
        <tr>
          <td><div align="right">Datos personales:</div></td>
          <td>&nbsp;</td>
          <td><span id="sprytextfield3"><span class="textfieldRequiredMsg">Se necesita un valor.</span></span>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="right">Nombres y Apellidos</div></td>
          <td>&nbsp;</td>
          <td><span id="sprytextfield4">
            <input type="text" name="nombre" id="nombre" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
        </tr>
        <tr>
          <td><div align="right">No. de Carnet</div></td>
          <td>&nbsp;</td>
          <td><span id="sprytextfield5">
            <input type="text" name="ci" id="ci" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
        </tr>
        <tr>
          <td><div align="right">Cargo</div></td>
          <td>&nbsp;</td>
          <td><span id="sprytextfield6">
            <input type="text" name="cargo" id="cargo" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
        </tr>
        <tr>
          <td><div align="right">Dependencia</div></td>
          <td>&nbsp;</td>
          <td><span id="sprytextfield7"><span class="textfieldRequiredMsg">Se necesita un valor.</span></span><span id="spryselect1">
            <select name="dependencia" id="dependencia">
              <option value="-1">-- ELEGIR --</option>
              <?php
do {  
?>
              <option value="<?php echo $row_list_dep['cod']?>"><?php echo $row_list_dep['nombredep']?></option>
              <?php
} while ($row_list_dep = mysql_fetch_assoc($list_dep));
  $rows = mysql_num_rows($list_dep);
  if($rows > 0) {
      mysql_data_seek($list_dep, 0);
	  $row_list_dep = mysql_fetch_assoc($list_dep);
  }
?>
            </select>
            <span class="selectInvalidMsg">Seleccione un elemento válido.</span>            <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
        </tr>
        <tr>
          <td><div align="right">Telefono dom.</div></td>
          <td>&nbsp;</td>
          <td><span id="sprytextfield8">
            <input type="text" name="telefono" id="telefono" />
              </span></td>
        </tr>
        <tr>
          <td><div align="right">Celular</div></td>
          <td>&nbsp;</td>
          <td><span id="sprytextfield9">
            <input type="text" name="celular" id="celular" />
              </span></td>
        </tr>
        <tr>
          <td><div align="right">email</div></td>
          <td>&nbsp;</td>
          <td><span id="sprytextfield10">
            <input type="text" name="email" id="email" />
            <span class="textfieldInvalidFormatMsg">Formato no válido.</span>            </span></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><table width="300" border="0" cellspacing="1" cellpadding="0">
              <tr>
                <td><input type="submit" name="button" id="button" value="Guardar" /></td>
                <td>&nbsp;
                  <input type="reset" name="button2" id="button2" value="Restablecer" /></td>
                <td><input type="button" name="button3" id="button3" value="cancelar" /></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        

                                                                        </table></td>
    </tr>
    <tr>
      <td><div class="barra">&nbsp;</div></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="add_user" />
</form>

<script type="text/javascript">
<!--
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1", {validateOn:["blur"], invalidValue:"-1"});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6");
var sprytextfield10 = new Spry.Widget.ValidationTextField("sprytextfield10", "email", {isRequired:false});
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8", "none", {isRequired:false});
var sprytextfield9 = new Spry.Widget.ValidationTextField("sprytextfield9", "none", {isRequired:false});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur"]});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur"]});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($list_dep);
?>
