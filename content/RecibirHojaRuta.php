<?php 
session_name("LoginSIRC");
session_start();
?>
<?php require_once('../Connections/snet.php'); ?>
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "HojaRuta")) {
  $insertSQL = sprintf("INSERT INTO entradas (usuario_cuenta, fecha_recibido, fun_recibido, dep_recibido, cod_deprecibido) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['usuario'], "text"),
                       GetSQLValueString($_POST['Fecha_recibido'], "date"),
                       GetSQLValueString($_POST['fun_recibido'], "text"),
                       GetSQLValueString($_POST['dep_recibido'], "text"),
                       GetSQLValueString($_POST['cod_deprecibido'], "text"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($insertSQL, $snet) or die(mysql_error());
  $id_entrada=mysql_insert_id();
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "HojaRuta")) {
  $updateSQL = sprintf("UPDATE derivacion SET entradas_id=%s WHERE id=%s AND hojaruta_cod=%s",
                       GetSQLValueString($id_entrada, "int"),
                       GetSQLValueString($_POST['id_derivacion'], "int"),
                       GetSQLValueString($_POST['HojaRuta'], "text"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($updateSQL, $snet) or die(mysql_error());
}

$cod_recibido_Record_derivacion = "-1";
if (isset($_POST['cod'])) {
  $cod_recibido_Record_derivacion = $_POST['cod'];
}
mysql_select_db($database_snet, $snet);
$query_Record_derivacion = sprintf("SELECT * FROM derivacion WHERE derivacion.hojaruta_cod=%s AND derivacion.entradas_id=0 ORDER BY derivacion.nro_destino DESC", GetSQLValueString($cod_recibido_Record_derivacion, "text"));
$Record_derivacion = mysql_query($query_Record_derivacion, $snet) or die(mysql_error());
$row_Record_derivacion = mysql_fetch_assoc($Record_derivacion);
$totalRows_Record_derivacion = mysql_num_rows($Record_derivacion);

$colname_Record_hojaruta = "-1";
if (isset($_POST['cod'])) {
  $colname_Record_hojaruta = $_POST['cod'];
}
mysql_select_db($database_snet, $snet);
$query_Record_hojaruta = sprintf("SELECT * FROM hojaruta WHERE cod = %s AND hojaruta.cont_destinos>=2", GetSQLValueString($colname_Record_hojaruta, "text"));
$Record_hojaruta = mysql_query($query_Record_hojaruta, $snet) or die(mysql_error());
$row_Record_hojaruta = mysql_fetch_assoc($Record_hojaruta);
$totalRows_Record_hojaruta = mysql_num_rows($Record_hojaruta);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<script src="../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo2 {
	color: #000033;
	font-weight: bold;
	font-size: 14px;
}
.Estilo4 {
	font-size: 14px;
	font-family: Arial, Helvetica, sans-serif;
}
.Estilo6 {
	color: #333333;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.Estilo7 {
	color: #000033;
	font-size: 12px;
	font-family: Arial, Helvetica, sans-serif;
}
.Estilo8 {
	font-size: 12px;
	font-family: Arial, Helvetica, sans-serif;
}
.Estilo9 {color: #000033}
.Estilo17 {
	color: #003366;
	font-weight: bold;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 13px;
}
.Estilo20 {
	color: #666666;
	font-weight: bold;
}
.Estilo21 {
	color: #003366;
	font-weight: bold;
}
.Estilo22 {
	color: #333333;
	font-size: 14px;
}
.Estilo26 {
	color: #3333333333333333333333;
	font-size: 14px;
}
.Estilo27 {font-size: 12px}
.Estilo28 {color: #003366}
.Estilo29 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #FF6600;
}
.Estilo31 {color: #FF9900}
-->
</style>
<script type="text/javascript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="POST" name="HojaRuta" id="HojaRuta">
  <?php if ($totalRows_Record_hojaruta > 0) { // Show if recordset not empty ?>
    <table width="100%" border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td><div id="CollapsiblePanel1" class="CollapsiblePanel">
            <div class="CollapsiblePanelTab" tabindex="0">Datos de la HOJA DE RUTA</div>
          <div class="CollapsiblePanelContent">
              <table width="100%" border="0" cellspacing="1" cellpadding="2">
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
                      <tr>
                        <td><table width="100%" border="0" cellspacing="1" cellpadding="2">
                            <tr>
                              <td><span class="Estilo21">Nro.:&nbsp;</span></td>
                              <td><span class="Estilo20"><?php echo $row_Record_hojaruta['cod']; ?>
                                    <input name="HojaRuta" type="hidden" id="HojaRuta" value="<?php echo $row_Record_derivacion['hojaruta_cod']; ?>" />
                              </span></td>
                            </tr>
                            <tr>
                              <td width="70"><span class="Estilo17">Fecha doc.</span></td>
                              <td><?php echo $row_Record_hojaruta['fecha_creacion']; ?></td>
                            </tr>
                        </table></td>
                        <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
                            <tr>
                              <td bordercolor="#003366" bgcolor="#FFFFCC"><span class="Estilo28">hojas</span></td>
                              <td><?php echo $row_Record_hojaruta['nhojas']; ?></td>
                            </tr>
                            <tr>
                              <td bordercolor="#003366" bgcolor="#FFFFCC"><span class="Estilo28">anexos</span></td>
                              <td><?php echo $row_Record_hojaruta['nanexos']; ?></td>
                            </tr>
                        </table></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
                      <tr>
                        <td width="80"><span class="Estilo17">Remitente: </span></td>
                        <td><span class="Estilo22"><?php echo $row_Record_hojaruta['procedencia']; ?></span></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
                      <tr>
                        <td width="100" class="Estilo17">Referencia.- </td>
                        <td><span class="Estilo26"><?php echo $row_Record_hojaruta['ref']; ?></span></td>
                      </tr>
                      <tr>
                        <td class="Estilo17">&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                  </table></td>
                </tr>
              </table>
          </div>
        </div></td>
      </tr>
  <tr>
  
  <td><div id="CollapsiblePanel2" class="CollapsiblePanel">
    <div class="CollapsiblePanelTab" tabindex="0">Destinatario para Recepcion (VERIFIQUE SI LE CORRESPONDE, no reciba si no le corresponde).- </div>
    <div class="CollapsiblePanelContent">
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
          <?php if ($totalRows_Record_derivacion > 0) { // Show if recordset not empty ?>        <tr>

          <td><span class="Estilo2"><?php echo $row_Record_hojaruta['cont_destinos']; ?>.- DESTINATARIO:</span> <span class="Estilo4"><?php echo $row_Record_derivacion['fun_destino']; ?>&nbsp;&laquo;<span class="Estilo27"><?php echo $row_Record_derivacion['dep_destino']; ?></span>&raquo;
                  <input name="id_derivacion" type="hidden" id="id_derivacion" value="<?php echo $row_Record_derivacion['id']; ?>" />
                  <input name="id_salidas" type="hidden" id="id_salidas" value="<?php echo $row_Record_derivacion['salidas_id']; ?>" />
                </span></td>
        </tr>
        <tr>
          <td><div align="center"></div></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFCC" class="CollapsiblePanelFocused Estilo6"><div align="center">
            <table width="100%" border="0" cellspacing="1" cellpadding="0">
              <tr>
                <td>PROVEIDO</td>
                <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
                  <tr>
                    <td bgcolor="#FFFFEC"><span class="Estilo9"><?php echo $row_Record_derivacion['proveido']; ?></span></td>
                  </tr>
                  <tr>
                    <td bgcolor="#FFFFEC"><?php echo $row_Record_derivacion['mensaje']; ?></td>
                  </tr>
                </table></td>
              </tr>
            </table>
          </div></td>
        </tr>
        <tr>
          <td><div align="right">
            <table width="400" border="0" cellspacing="1" cellpadding="0">
              <tr>
                <td><div align="right"><span class="Estilo7"><?php echo $row_Record_derivacion['fun_derivador']; ?></span></div></td>
                <td width="130" bgcolor="#FFFFCC"><div align="left"><span class="Estilo28">Firma Proveedor </span></div></td>
              </tr>
              <tr>
                <td><div align="right"><span class="Estilo8"><?php echo $row_Record_derivacion['fecha_derivacion']; ?></span></div></td>
                <td bgcolor="#FFFFCC"><div align="left"><span class="Estilo28">Fecha</span></div></td>
              </tr>
            </table>
          </div></td>
        </tr>
        <tr>
          <td><input name="Fecha_recibido" type="hidden" id="Fecha_recibido" value="<?php echo date("Y-m-d H:i:s");?>" />
                <input name="fun_recibido" type="hidden" id="fun_recibido" value="<?php echo $_SESSION['fun']; ?>" />
                <input name="cod_deprecibido" type="hidden" id="cod_deprecibido" value="<?php echo $_SESSION['cod_dep']; ?>" />
                <input name="usuario" type="hidden" id="usuario" value="<?php echo $_SESSION['user']; ?>" />
                <input name="dep_recibido" type="hidden" id="dep_recibido" value="<?php echo $_SESSION['dep']; ?>" /></td>
        </tr>
        <tr>
          <td><input type="submit" name="button" id="button" value="MARCAR RECIBIDO DE LA HOJA DE RUTA" /></td>
        </tr>
        <?php } // Show if recordset not empty ?>
        <?php if ($totalRows_Record_derivacion == 0) { // Show if recordset empty ?>
          <tr>
            <td><span class="Estilo31">No hay Destinatarios habilitado para marcar Recepcion.<span class="Estilo29">
              <input type="button" name="Consultar otro2" id="Consultar otro2" value="Intentar con otro" onclick="MM_goToURL('self','menuRecibirInternos3.php');return document.MM_returnValue"/>
            </span></span></td>
          </tr>
          <?php } // Show if recordset empty ?>
      </table>
    </div>
  </div></td>
  </tr>
  
    </table>
    <?php } // Show if recordset not empty ?>
<script type="text/javascript">
<!--
var CollapsiblePanel1 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel1");
var CollapsiblePanel2 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel2");
//-->
</script>
<input type="hidden" name="MM_insert" value="HojaRuta" />
<input type="hidden" name="MM_update" value="HojaRuta" />
<?php if ($totalRows_Record_hojaruta == 0) { // Show if recordset empty ?>
  
  <table width="100%" border="0" cellspacing="1" cellpadding="0">
    <tr>
      <td>&nbsp;</td>
      </tr>
    <tr>
      <td> <div align="center" class="Estilo29">La HOJA DE RUTA <?PHP echo $_POST['cod'];?> no esta listo para envio todavia.<br />
        <br />
        Verifique o consulte con el fuente origen de la Hoja de Ruta.<br />
        <input type="button" name="Consultar otro" id="Consultar otro" value="aceptar" onclick="window.history.back();"/>
      </div></td>
      </tr>
  </table>
  <?php } // Show if recordset empty ?>
</form>
</body>
</html>
<?php
mysql_free_result($Record_derivacion);

mysql_free_result($Record_hojaruta);
?>
