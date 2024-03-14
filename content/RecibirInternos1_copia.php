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

$cite_var_reg_Internos = "-1";
if (isset($_POST['cite'])) {
  $cite_var_reg_Internos = $_POST['cite'];
}
mysql_select_db($database_snet, $snet);
$query_reg_Internos = sprintf("SELECT * FROM salinternas, salidas WHERE salidas.cite=salinternas.salidas_cite AND salinternas.salidas_cite=%s", GetSQLValueString($cite_var_reg_Internos, "text"));
$reg_Internos = mysql_query($query_reg_Internos, $snet) or die(mysql_error());
$row_reg_Internos = mysql_fetch_assoc($reg_Internos);
$totalRows_reg_Internos = mysql_num_rows($reg_Internos);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
body {
	font-size: 12px;
	color: #000000;
	font-family: sans-serif, fantasy, Rockwell, "Lucida Sans";
}
.cajatxt {
	font-size: 10px;
	background-color: #DDFFF1;
}

-->
</style>

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
//-->
</script>
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo4 {font-size: 10}
.Estilo5 {font-size: 10px}
.Estilo6 {font-size: 11px}
.Estilo9 {font-size: 10px; font-weight: bold; }
.Estilo10 {font-size: 12px}
-->
</style>
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
              <td><input name="button3" type="button" id="button3" onclick="if(confirm('¿Esta seguro de cancelar la operacion, \n se perderan todos los datos?')){MM_goToURL('self','RecibirInternos2.php');return document.MM_returnValue;}" value="cancelar" /></td>
            </tr>
                  </table>
      </div></td>
    <td valign="top">&nbsp;</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div style="border-color:#98BEFE; border-style:solid; border-width:1px;">
    <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#D5EAFF">
      <tr>
        <td width="4%">&nbsp;</td>
        <td width="34%">&nbsp;</td>
        <td width="21%">&nbsp;</td>
        <td width="41%">&nbsp;</td>
      </tr>
      <tr>
        <td><strong>de:</strong></td>
        <td colspan="2">
          <input name="fun_remite" type="hidden" id="fun_remite" value="<?php echo $row_reg_Internos['fun_remitente']; ?>" size="40" />
          <span class="Estilo6"><?php echo $row_reg_Internos['fun_remitente']; ?></span>          
            <input name="dep_remite" type="hidden" id="dep_remite" value="<?php echo $row_reg_Internos['dep_remitente']; ?>" size="30" />
            <span class="Estilo6">&lt;<?php echo $row_reg_Internos['dep_remitente']; ?></span>&gt;</td>
        <td align="left"><span class="Estilo5"><span class="Estilo2"><strong>Fecha de&nbsp;envio:</strong></span>
          <input name="fecha2" type="hidden" id="fecha2" value="<?php echo $row_reg_Internos['fecha_envio']; ?>" />
          <?php echo $row_reg_Internos['fecha_envio']; ?></span></td>
      </tr>
      <tr>
        <td><strong>para:&nbsp;</strong></td>
        <td colspan="2">
          <input name="fun_destino" type="hidden" id="fun_destino" value="<?php echo $row_reg_Internos['fun_destino']; ?>" size="40" />
          <span class="Estilo5 Estilo4 Estilo6"><?php echo $row_reg_Internos['fun_destino']; ?></span>
        <input name="fun_destino" type="hidden" id="fun_destino" value="<?php echo $row_reg_Internos['dep_destino']; ?>" size="30" />
        &lt;<span class="Estilo6"><?php echo $row_reg_Internos['dep_destino']; ?>&gt;</span></td>
        <td><div class="Estilo2 Estilo6"><span class="Estilo9">Fecha de&nbsp;Recepcion:</span>&nbsp;<?php echo date("Y-m-d H:i:s");?>
            <input name="fecha_recibido2" type="hidden" id="fecha_recibido2" value="<?php echo date("Y-m-d H:i:s");?>" />
        </div></td>
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
    <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td><div align="right" class="Estilo2 Estilo4"><span class="Estilo5">Hoja de Ruta:</span>&nbsp;</div></td>
            <td>
              <input type="text" name="hoja_ruta" id="hoja_ruta" />
              </td>
            <td><div align="right" class="Estilo2 Estilo4"><span class="Estilo5">numero de Hojas:</span>&nbsp;</div></td>
            <td><input name="nhojas2" type="text" id="nhojas2" value="<?php echo $row_reg_Internos['nhojas']; ?>" size="10" /></td>
          </tr>
          
          <tr>
            <td height="30"><div align="right" class="Estilo2 Estilo4"><span class="Estilo5">Cite:</span>&nbsp;</div></td>
            <td height="30"><input name="cite" type="hidden" id="cite" value="<?php echo $row_reg_Internos['cite']; ?>" />
                <span class="Estilo10"><?php echo $row_reg_Internos['cite']; ?></span></td>
            <td height="30">&nbsp;</td>
            <td height="30">&nbsp;</td>
          </tr>
          <tr>
            <td height="30"><div align="right" class="Estilo2 Estilo5">Referencia:&nbsp;</div></td>
            <td height="30"><input name="ref" type="hidden" id="ref" value="<?php echo $row_reg_Internos['ref']; ?>" size="80" />
                <span class="Estilo10"><?php echo $row_reg_Internos['ref']; ?></span></td>
            <td height="30" colspan="2"><div align="center">RECIBIDO</div></td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2" rowspan="3" valign="bottom"><span id="sprytextarea1"><span class="textareaRequiredMsg">Se necesita un valor.</span></span>&nbsp;<span id="sprytextarea2"><span class="textareaRequiredMsg">Se necesita un valor.</span></span>&nbsp;
              <table width="70%" border="0" align="center" cellpadding="0" cellspacing="1">
                <tr>
                  <td><div align="center">________________________</div></td>
                </tr>
                <tr>
                  <td><div align="center"><span class="Estilo2 Estilo6"><?php echo date("d-m-Y H:i:s");?></span></div></td>
                </tr>
                <tr>
                  <td><div align="center" class="Estilo10"><?php echo $_SESSION['fun']; ?></div></td>
                </tr>
                <tr>
                  <td><div align="center" class="Estilo5"><?php echo $_SESSION['cargo']; ?></div></td>
                </tr>
                <tr>
                  <td><div align="center" class="Estilo5"><?php echo $_SESSION['dep']; ?></div></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
              </table></td>
            </tr>
          <tr>
            <td><div align="right" class="Estilo2 Estilo4"><span class="Estilo5">Ajuntos:</span>&nbsp;</div></td>
            <td><span id="sprytextarea1">
              <textarea name="adjuntos" cols="45" rows="5" class="cajatxt" id="adjuntos"><?php echo $row_reg_Internos['ladjuntos']; ?></textarea>
              <span class="textareaRequiredMsg">Se necesita un valor.</span></span></td>
            </tr>
          <tr>
            <td><div align="right" class="Estilo2 Estilo4"><span class="Estilo5">Anexos:</span>&nbsp;</div></td>
            <td><span id="sprytextarea2">
              <textarea name="anexos" cols="45" rows="5" class="cajatxt" id="anexos"><?php echo $row_reg_Internos['danexos']; ?></textarea>
              <span class="textareaRequiredMsg">Se necesita un valor.</span></span></td>
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
    <td><table width="300" border="0" cellspacing="5" cellpadding="0">
          <tr>
            <td><input name="button" type="submit" class="boton" id="button" value="Registrar" /></td>
            <td><input type="submit" name="button2" id="button2" value="Vista Impresion" /></td>
            <td><input type="button" name="button4" id="button4" onclick="if(confirm('¿Esta seguro de cancelar la operacion?')){MM_goToURL('self','RecibirInternos2.php');return document.MM_returnValue;}" value="cancelar" /></td>
          </tr>
      </table></td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>

</body>
</html>
<?php
mysql_free_result($reg_Internos);
?>
