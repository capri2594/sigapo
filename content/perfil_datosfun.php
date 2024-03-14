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
<title>Perfil de Usuario</title>
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
-->
</style>
<script language="jscript" type="text/javascript">
<!-- 
function carga(){
	//alert(self.location.href);
	self.location.href="perfil_datosfun_modificar.php"
}
-->
</script>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="100" height="100"><div align="center"><img src="../perfiles/fotos/<?php echo $_SESSION['user'];?>.jpg" alt="sin/foto:<?php echo $_SESSION['user'];?>" longdesc="<?php echo $_SESSION['user'];?>" /></div></td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          </tr>
		  <!--MODIFICADO PARA NO MOSTRAR CONTROL...-->
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
              <td bgcolor="#CCCCFF"><span class="Estilo14">Faltas c/L</span></td>
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
                <td><div align="right" class="Estilo1">Nombre:&nbsp;</div></td>
                <td><span class="Estilo2"><?php echo $row_mis_datos['nombre']; ?></span></td>
              </tr>
              <tr>
                <td><div align="right" class="Estilo2"><strong>Cargo:&nbsp;</strong></div></td>
                <td><span class="Estilo2"><?php echo $row_mis_datos['cargo']; ?></span></td>
              </tr>
              <tr>
                <td><div align="right" class="Estilo2"><strong>C.I.:&nbsp;</strong></div></td>
                <td><span class="Estilo2"><?php echo $row_mis_datos['ci']; ?></span></td>
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
                <td><div align="left"><span class="Estilo6">CELULAR:&nbsp;</span></div></td>
                <td><span class="Estilo2"><?php echo $row_mis_datos['celular']; ?></span></td>
              </tr>
              <tr>
                <td><div align="left"><span class="Estilo6">TELEFONO:&nbsp;</span></div></td>
                <td><span class="Estilo2"><?php echo $row_mis_datos['telefono']; ?></span></td>
              </tr>
              <tr>
                <td><div align="left"><span class="Estilo6">CORREO:&nbsp;</span></div></td>
                <td><span class="Estilo2"><?php echo $row_mis_datos['email']; ?></span></td>
              </tr>
          </table></td>
          <td>&nbsp;</td>
        </tr>
      </table></td>
      <td width="100" bgcolor="#CCCCCC"><table width="100%" border="0" cellspacing="1" cellpadding="10">
        <tr>
          <td><input type="button" name="Button" value="Modificar" onclick="carga();"/></td>
        </tr>
        <!--<tr>
          <td><input type="button" name="Button2" value="Cambiar FOTO" /></td>
        </tr>-->
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table></td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
mysql_free_result($mis_datos);
?>
