<?php 
session_name("LoginSIRC");
session_start();
header('Content-Type: text/html; charset=UTF-8');
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE funcionario SET ci=%s, cargo=%s, celular=%s, telefono=%s, email=%s WHERE nombre=%s AND usuario_cuenta=%s AND dependencia_cod=%s",
                       GetSQLValueString($_POST['ci'], "text"),
                       GetSQLValueString($_POST['cargo'], "text"),
                       GetSQLValueString($_POST['celular'], "text"),
                       GetSQLValueString($_POST['telefono'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['usuario_cuenta'], "text"),
                       GetSQLValueString($_POST['dependencia_cod'], "text"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($updateSQL, $snet) or die(mysql_error());

  $updateGoTo = "perfil_datosfun.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$usuario_mis_datos = "-1";
if (isset($_SESSION['user'])) {
  $usuario_mis_datos = $_SESSION['user'];
}
mysql_select_db($database_snet, $snet);
$query_mis_datos = sprintf("SELECT * FROM funcionario WHERE funcionario.usuario_cuenta=%s", GetSQLValueString($usuario_mis_datos, "text"));
$mis_datos = mysql_query($query_mis_datos, $snet) or die(mysql_error());
$row_mis_datos = mysql_fetch_assoc($mis_datos);
$totalRows_mis_datos = mysql_num_rows($mis_datos);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Modificar Datos de Usuario</title>
<style type="text/css">
<!--
.style2 {	font-size: 12px;
	font-weight: bold;
}
.style5 {font-size: 12px}
.Estilo1 {
	font-size: 14px;
	font-weight: bold;
}
.Estilo2 {font-size: 14px}
.Estilo6 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; }
.Estilo10 {
	font-size: 12px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #003366;
}
.Estilo14 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
.Estilo16 {font-weight: bold; color: #003366; font-family: Verdana, Arial, Helvetica, sans-serif;}
.datos {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 13px;
	color: #000033;
	border: 1px solid #DFF1FF;
	width: 240px;
}
-->
</style>
<script language="jscript" type="text/javascript">
<!-- 
function carga(){
	
	self.location.href="perfil_datosfun.php"
}
-->
</script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td><div align="center"><img src="../perfiles/fotos/<?php echo $_SESSION['user'];?>.jpg" alt="sin/foto:<?php echo $_SESSION['user'];?>" width="100" height="100" longdesc="<?php echo $_SESSION['user'];?>" /></div></td>
          </tr>
        <!--<tr>
          <td>&nbsp;</td>
          </tr>-->
        <!--<tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="8">
            <tr>
              <td bgcolor="#F3F3F3"><span class="Estilo14">CONTROL</span></td>
              <td bgcolor="#F3F3F3"><span class="Estilo14">N&ordm;</span></td>
            </tr>
            <tr>
              <td bgcolor="#FFCC00"><span class="Estilo14">Atrasos</span></td>
              <td><span class="Estilo14">0</span></td>
            </tr>
            <tr>
              <td bgcolor="#CCCCFF"><span class="Estilo14">Faltasvvvv c/L</span></td>
              <td><span class="Estilo14">0</span></td>
            </tr>
            <tr>
              <td bgcolor="#33CCCC"><span class="Estilo14">Faltas s/L </span></td>
              <td><span class="Estilo14">0</span></td>
            </tr>
          </table></td>
        </tr>-->
      </table></td>
      <td width="10" valign="middle">&nbsp;</td>
      <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="3">
        <tr>
          <td bgcolor="#F4FAFF"><span class="style5"><span class="Estilo16">DATOS DEL FUNCIONARIO</span></span></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="100%" border="0" cellspacing="2" cellpadding="5">
              <tr>
                <td width="100"><div align="right" class="Estilo1">Nombre:&nbsp;</div></td>
                <td><span class="Estilo2"><span id="sprytextfield6">
                  <input name="nombre" type="text" class="datos" id="nombre" value="<?php echo $row_mis_datos['nombre']; ?>" readonly="readonly" />
                  <span class="textfieldRequiredMsg">Se necesita un valor.</span></span>
                  <input name="dependencia_cod" type="hidden" id="dependencia_cod" value="<?php echo $_SESSION['cod_dep']; ?>" />
                  <input name="usuario_cuenta" type="hidden" id="usuario_cuenta" value="<?php echo $_SESSION['user']; ?>" />
                </span></td>
              </tr>
              <tr>
                <td width="100"><div align="right" class="Estilo2"><strong>Cargo:&nbsp;</strong></div></td>
                <td><span id="sprytextfield5">
                  <input name="cargo" type="text" class="datos" id="cargo" value="<?php echo $row_mis_datos['cargo']; ?>" />
                  <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
              </tr>
              <tr>
                <td width="100"><div align="right" class="Estilo2"><strong>C.I.&nbsp;</strong></div></td>
                <td><span class="Estilo2"><span id="spryci">
                  
                  <input name="ci" type="text" class="datos" id="ci" value="<?php echo $row_mis_datos['ci']; ?>" maxlength="10"/>
                  </span></span></td>
              </tr>
          </table></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td bgcolor="#F4FAFF"><span class="Estilo10">DATOS DE CONTACTO</span></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="100%" border="0" cellspacing="2" cellpadding="5">
              <tr>
                <td width="100"><div align="right"><span class="Estilo6">CELULAR:&nbsp;</span></div></td>
                <td><span class="Estilo2"><span id="sprycelular">
                  <input name="celular" type="text" class="datos" id="celular" value="<?php echo $row_mis_datos['celular']; ?>" maxlength="8" />
                  </span></span></td>
              </tr>
              <tr>
                <td width="100"><div align="right"><span class="Estilo6">TELEFONO:&nbsp;</span></div></td>
                <td><span class="Estilo2"><span id="sprytelefono">
                  <input name="telefono" type="text" class="datos" id="telefono" value="<?php echo $row_mis_datos['telefono']; ?>" maxlength="7"/>
                  </span></span></td>
              </tr>
              <tr>
                <td width="100"><div align="right"><span class="Estilo6">CORREO:&nbsp;</span></div></td>
                <td><span class="Estilo2"></span><span id="sprycorreo">
                <input name="email" type="text" class="datos" id="email" value="<?php echo $row_mis_datos['email']; ?>"/>
                <span class="textfieldInvalidFormatMsg">x</span></span></td>
              </tr>
          </table></td>
          <td>&nbsp;</td>
        </tr>
      </table></td>
      <td width="100" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="10">
        <tr>
          <td bgcolor="#929292"><div align="center"><strong>MODIFICAR</strong></div></td>
        </tr>
        <tr>
          <td bgcolor="#F0F0F0"><input name="aceptar" type="submit" id="aceptar" value="ACEPTAR" /></td>
        </tr>
        <tr>
          <td bgcolor="#F0F0F0"><input name="cancelar" type="button" id="cancelar" onclick="carga();" value="CANCELAR"/></td>
        </tr>
      </table></td>
    </tr>
  </table>
    <input type="hidden" name="MM_update" value="form1" />
</form>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("spryci", "none", {isRequired:false, validateOn:["blur", "change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprycelular", "none", {validateOn:["blur", "change"], isRequired:false});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytelefono", "none", {isRequired:false, validateOn:["blur", "change"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprycorreo", "email", {validateOn:["blur", "change"], isRequired:false});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "none", {validateOn:["blur"]});
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "none", {validateOn:["blur"]});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($mis_datos);
?>
