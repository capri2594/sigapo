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


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


$idclave_obtener_crInterno = "-1";
if (isset($_GET['id'])) {
  $idclave_obtener_crInterno = $_GET['id'];
}
mysql_select_db($database_snet, $snet);
$query_obtener_crInterno = sprintf("SELECT * FROM einterna, entradas WHERE entradas.id=einterna.entradas_id AND einterna.id_interna=%s", GetSQLValueString($idclave_obtener_crInterno, "text"));
$obtener_crInterno = mysql_query($query_obtener_crInterno, $snet) or die(mysql_error());
$row_obtener_crInterno = mysql_fetch_assoc($obtener_crInterno);
$totalRows_obtener_crInterno = mysql_num_rows($obtener_crInterno);

//calculando la gestion a la que pertenece.
$partes=split(" ",$row_obtener_crInterno['fecha_recibido']);
$pfecha=split("-",$partes[0]); //fecha en partes
$gestion=$pfecha[0];

//actualizando el codigo de Hoja de Ruta en la Correspondencia...
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE einterna SET HR=%s WHERE id_interna=%s",
                       GetSQLValueString($_POST['cod'], "text"),
                       GetSQLValueString($_POST['id_einterna'], "int"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($updateSQL, $snet) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO hojaruta (cod, einterna_id, fecha_creacion, procedencia, `ref`, primer_destino, primerfun_destino, nhojas, nanexos, usuario_creador, cod_depcreador, gestion) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['cod'], "text"),
                       GetSQLValueString($_POST['id_einterna'], "int"),
                       GetSQLValueString($_POST['fecha_creacion'], "date"),
                       GetSQLValueString($_POST['remitente'], "text"),
                       GetSQLValueString($_POST['ref'], "text"),
                       GetSQLValueString($_POST['primer_d_destino'], "text"),
                       GetSQLValueString($_POST['primer_f_destino'], "text"),
                       GetSQLValueString($_POST['hojas'], "int"),
                       GetSQLValueString($_POST['anexos'], "text"),
                       GetSQLValueString($_POST['usuario_creador'], "text"),
                       GetSQLValueString($_POST['cod_depcreador'], "text"),
					   GetSQLValueString($gestion, "text"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($insertSQL, $snet) or die(mysql_error());

  $insertGoTo = "derivarHojaRutaDestinos.php"."?cod=".$_POST['cod'];
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.titulos {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #FFFFFF;
	background-color: #6B7A9D;
	border: 1px solid #FFFFFF;
}
.pendiente {
	background-color: #FCF6D8;
	height: 20px;
	width: 100px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}
.procesado {
	background-color: #9AE7B3;
	height: 25px;
	width: 100px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #000000;
}
.botones {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #333333;
	background-color: #CAD2DB;
	border: 1px solid #FFFFFF;
}
.celeste {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #003366;
	background-color: #E5ECF7;
	border: 1px solid #FFFFFF;
}
.celdas {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #003366;
	background-color: #FAFCFE;
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-style: solid;
	border-right-style: solid;
	border-bottom-style: solid;
	border-left-style: solid;
	border-top-color: #CCCCCC;
	border-right-color: #CCCCCC;
	border-bottom-color: #CCCCCC;
	border-left-color: #CCCCCC;
}
-->
</style>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="100%" border="0">
    <tr class="titulos">
      <td>NUEVA HOJA DE RUTA</td>
    </tr>
    <tr>
      <td><table width="100%" border="0">
          <tr>
            <td width="107">Codigo</td>
            <td><span id="sprytextfield1">
              <label>
              <input type="text" name="cod" id="cod" />
              </label>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span>
            <input name="id_einterna" type="hidden" id="id_einterna" value="<?php echo $_GET['id']; ?>" /></td>
            <td><fieldset>
            <legend>hojas</legend>
            <span id="sprytextfield6">
            <label>
            <input name="hojas" type="text" id="hojas" value="<?php echo $row_obtener_crInterno['nhojas']; ?>" />
            </label>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span>
            </fieldset>            </td>
          </tr>
          <tr>
            <td width="107">Remitente</td>
            <td><span id="sprytextfield2">
              <label>
              <input name="remitente" type="text" id="remitente" value="<?php echo $row_obtener_crInterno['dep_remite']; ?>" size="40" />
              </label>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
            <td><fieldset>
            <legend>anexos</legend>
            <span id="sprytextarea1">
            <label>
            <textarea name="anexos" id="anexos" rows="2"><?php echo $row_obtener_crInterno['anexos']; ?></textarea>
            </label>
            <span class="textareaRequiredMsg">Se necesita un valor.</span></span>
            </fieldset>            </td>
          </tr>
          <tr>
            <td width="107">Asunto/referencia</td>
            <td><span id="sprytextfield3">
              <label>
              <input name="ref" type="text" id="ref" value="<?php echo $row_obtener_crInterno['ref']; ?>" size="70" />
              </label>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
            <td rowspan="3"><fieldset>
            <legend>Creacion</legend>
            <table width="100%" border="0">
              <tr>
                <td>usuario:</td>
                <td><?php echo $_SESSION['user']; ?>
                  <input name="usuario_creador" type="hidden" id="usuario_creador" value="<?php echo $_SESSION['user']; ?>" /></td>
                </tr>
              <tr>
                <td>fecha:</td>
                <td><?php //echo date("Y-m-d H:i:s"); ?>
				<?php echo $row_obtener_crInterno['fecha_recibido']; ?>&nbsp;
                  <input name="fecha_creacion" type="hidden" id="fecha_creacion" value="<?php /*echo date("Y-m-d H:i:s"); */?><?php echo $row_obtener_crInterno['fecha_recibido']; ?>" /></td>
                </tr>
            </table>
            </fieldset>            </td>
          </tr>
          <tr>
            <td width="107">1er.  Destinatario</td>
            <td><span id="sprytextfield4">
              <label>
              <input name="primer_f_destino" type="text" id="primer_f_destino" value="<?php echo $row_obtener_crInterno['fun_destino']; ?>" size="40" />
              </label>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
          </tr>
          <tr>
            <td width="107">&nbsp;</td>
            <td><span id="sprytextfield5">
              <label>
              <input name="primer_d_destino" type="text" id="primer_d_destino" value="<?php echo $row_obtener_crInterno['dep_destino']; ?>" size="40" />
              </label>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
          </tr>
          <tr>
            <td width="107">Fecha Recibido </td>
            <td><?php echo $row_obtener_crInterno['fecha_recibido']; ?>&nbsp;</td>
            <td><input name="dep_creador" type="hidden" id="dep_creador" value="<?php echo $_SESSION['dep']; ?>" />
            <input name="cod_depcreador" type="hidden" id="cod_depcreador" value="<?php echo $_SESSION['cod_dep']; ?>" /></td>
          </tr>
      </table></td>
    </tr>
    <tr class="botones">
      <td><table width="100%" border="0">
        <tr>
          <td>&nbsp;</td>
          <td width="200">
            <div align="center">
              <input type="submit" name="button" id="button" value="Crear Hoja de Ruta" />
              </div></td>
          <td width="200">
            <div align="right">
              <input type="button" name="button2" id="button2" value="Cancelar" onclick="window.close();" />            
              
            </div></td>
        </tr>

      </table></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
  <input type="hidden" name="MM_update" value="form1" />
</form>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {hint:" ..SIGLA-NUMERO..", validateOn:["blur"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
//-->
</script>
</body>


</html>
<?php
mysql_free_result($obtener_crInterno);
?>
