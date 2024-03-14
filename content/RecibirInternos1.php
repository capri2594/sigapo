<?php 
session_name("LoginSIRC");
session_start();
header('Content-type: text/html; charset=utf-8');
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "recibirInternos")) {
  $insertSQL = sprintf("INSERT INTO entradas (tema_titulo, usuario_cuenta, fecha_recibido, fun_recibido, dep_recibido, cod_deprecibido) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['tema'], "text"),
                       GetSQLValueString($_POST['usuario'], "text"),
                       GetSQLValueString($_POST['fecha_recibido2'], "date"),
                       GetSQLValueString($_POST['fun_recibido'], "text"),
                       GetSQLValueString($_POST['dep_recibido'], "text"),
                       GetSQLValueString($_POST['cod_deprecibido'], "text"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($insertSQL, $snet) or die(mysql_error());

}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "recibirInternos")) {
  $updateSQL = sprintf("UPDATE salidas SET `ref`=%s, fecha_recibido=%s, fun_recibido=%s, dep_recibido=%s WHERE cite=%s",
                       GetSQLValueString($_POST['ref'], "text"),
                       GetSQLValueString($_POST['fecha_recibido2'], "date"),
                       GetSQLValueString($_POST['fun_recibido'], "text"),
                       GetSQLValueString($_POST['dep_recibido'], "text"),
                       GetSQLValueString($_POST['cite'], "text"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($updateSQL, $snet) or die(mysql_error());

}

//consulta del id

$colname_id_entrada = "-1";
if (isset($_POST['fecha_recibido2'])) {
  $colname_id_entrada = $_POST['fecha_recibido2'];
}
mysql_select_db($database_snet, $snet);
$query_id_entrada = sprintf("SELECT id FROM entradas WHERE fecha_recibido = %s", GetSQLValueString($colname_id_entrada, "date"));
$id_entrada = mysql_query($query_id_entrada, $snet) or die(mysql_error());
$row_id_entrada = mysql_fetch_assoc($id_entrada);
$totalRows_id_entrada = mysql_num_rows($id_entrada);
$id_entrada=$row_id_entrada['id'];
// fin de la consulta


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "recibirInternos")) {
  $insertSQL = sprintf("INSERT INTO einterna (entradas_id,nhojas, anexos, entradas_tema_titulo, entradas_usuario_cuenta, cite, `ref`, dep_remite, fun_remite, fun_destino, dep_destino, fecha_doc, adjuntos) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($id_entrada, "int"),
					   GetSQLValueString($_POST['nhojas'], "int"),
                       GetSQLValueString($_POST['anexos'], "text"),
                       GetSQLValueString($_POST['tema'], "text"),
                       GetSQLValueString($_POST['usuario'], "text"),
                       GetSQLValueString($_POST['cite'], "text"),
                       GetSQLValueString($_POST['ref'], "text"),
                       GetSQLValueString($_POST['dep_remite'], "text"),
                       GetSQLValueString($_POST['fun_remite'], "text"),
                       GetSQLValueString($_POST['fun_destino'], "text"),
                       GetSQLValueString($_POST['dep_destino'], "text"),
                       GetSQLValueString($_POST['fecha_doc'], "date"),
                       GetSQLValueString($_POST['adjuntos'], "text"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($insertSQL, $snet) or die(mysql_error());
  $msgExito="Correspondencia recibida Correctamente....";
    
  $insertGoTo = "RecibirInternos1_paso2.php?cite=".$_POST['cite'];
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
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

<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
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
.Estilo11 {font-size: 10px; color: #000066; }
-->
</style>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" name="recibirInternos" id="recibirInternos" method="POST">
<table width="100%" border="0" cellspacing="1" cellpadding="0">
      <?php if ($totalRows_reg_Internos > 0) { // Show if recordset not empty ?>
  <tr>

<td>&nbsp;</td>
    <td><?php if ($msgExito){?>
        <div style="background-color:#FF0033; color:#FFFFFF; width:200px;"><?php echo $msgExito;?></div><?php }?>
        <div align="right">
          <table width="300" border="0" cellpadding="0" cellspacing="5" bgcolor="#D5EAFF">
            <tr>
            <SCRIPT language="javascript"> 
function imprimir()
{ if ((navigator.appName == "Netscape")) { window.print() ; 
} 
else
{ var WebBrowser = '<OBJECT ID="WebBrowser1" WIDTH=0 HEIGHT=0 CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>'; 
document.body.insertAdjacentHTML('beforeEnd', WebBrowser); WebBrowser1.ExecWB(6, -1); WebBrowser1.outerHTML = "";
}
}
</SCRIPT> 

              <td><input type="submit" name="button" id="button" value="RegistrarCorrespondencia" /></td>
              <td><input type="button" name="button2" id="button2" value="Imprimir Boleta" onclick="imprimir();" /></td>
              <td><input name="button3" type="button" id="button3" onclick="if(confirm('¿Esta seguro de cancelar la operacion, \n se perderan todos los datos?')){MM_goToURL('self','menuRecibirInternos3.php');return document.MM_returnValue;}" value="cancelar" /></td>
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
        <input name="dep_destino" type="hidden" id="dep_destino" value="<?php echo $row_reg_Internos['dep_destino']; ?>" size="30" />
        &lt;<span class="Estilo6"><?php echo $row_reg_Internos['dep_destino']; ?>&gt;</span></td>
        <td><div class="Estilo2 Estilo6"><span class="Estilo9">Fecha de&nbsp;Recepcion:</span>&nbsp;<?php echo date("Y-m-d H:i:s");?>
            <input name="fecha_recibido2" type="hidden" id="fecha_recibido2" value="<?php echo date("Y-m-d H:i:s");?>" />
            <input name="usuario" type="hidden" id="usuario" value="<?php echo $_SESSION['user'];?>" />
            <input name="cod_deprecibido" type="hidden" id="cod_deprecibido" value="<?php echo $_SESSION['cod_dep'];?>" />
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
            <td><div align="right" class="Estilo2 Estilo4" style="visibility:visible"><span class="Estilo5">Fecha del doc.:</span>&nbsp;</div></td>
            <td><input name="fecha_doc" type="hidden" id="fecha_doc" style="visibility:visible" value="<?php echo $row_reg_Internos['fecha_doc']; ?>"  />
              <input name="fechadoc" type="text" id="fechadoc" style="visibility:visible" value="<?php $fecha=explode("-",$row_reg_Internos['fecha_doc']); echo $fecha[2]."/".$fecha[1]."/".$fecha[0];?>"  readonly="readonly"/>            </td>
            <td><div align="right" class="Estilo2 Estilo4"><span class="Estilo5">numero de Hojas:</span>&nbsp;</div></td>
            <td><input name="nhojas" type="text" id="nhojas" value="<?php echo $row_reg_Internos['nhojas']; ?>" size="10" /></td>
          </tr>
          
          <tr>
            <td height="30"><div align="right" class="Estilo2 Estilo4"><span class="Estilo5">Cite:</span>&nbsp;</div></td>
            <td height="30"><input name="cite" type="hidden" id="cite" value="<?php echo $row_reg_Internos['cite']; ?>" />
                <span class="Estilo10"><?php echo $row_reg_Internos['cite']; ?></span></td>
            <td height="30"><div align="right"><span class="Estilo11">tema:</span><br />
                <span class="Estilo11">tipo de doc.</span></div></td>
            <td height="30"><span class="Estilo5">
              <input name="tema" type="hidden" id="tema" value="<?php echo $row_reg_Internos['tema_titulo']; ?>" />
              <?php echo $row_reg_Internos['tema_titulo']; ?></span><br />
              <span class="Estilo5">
              <input name="tipo" type="hidden" id="tipo" value="<?php echo $row_reg_Internos['tipo_clase']; ?>" />
              <?php echo $row_reg_Internos['tipo_clase']; ?></span><br /></td>
          </tr>
          <tr>
            <td height="30"><div align="right" class="Estilo2 Estilo5">Referencia:&nbsp;</div></td>
            <td height="30"><input name="ref" type="hidden" id="ref" value="<?php echo $row_reg_Internos['ref']; ?>" size="80" />
                <span class="Estilo10"><?php echo $row_reg_Internos['ref']; ?></span></td>
            <td height="30" colspan="2" valign="bottom"><div align="center">RECIBIDO</div></td>
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
                  <td><div align="center" class="Estilo10"><?php echo $_SESSION['fun']; ?>
                    <input name="fun_recibido" type="hidden" id="fun_recibido" value="<?php echo $_SESSION['fun']; ?>" />
                  </div></td>
                </tr>
                <tr>
                  <td><div align="center" class="Estilo5"><?php echo $_SESSION['cargo']; ?>
                    <input name="cargo_recibido" type="hidden" id="cargo_recibido" value="<?php echo $_SESSION['cargo']; ?>" />
                  </div></td>
                </tr>
                <tr>
                  <td><div align="center" class="Estilo5"><?php echo $_SESSION['dep']; ?>
                    <input name="dep_recibido" type="hidden" id="dep_recibido" value="<?php echo $_SESSION['dep']; ?>" />
                  </div></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
              </table></td>
            </tr>
          <tr>
            <td><div align="right" class="Estilo2 Estilo4"><span class="Estilo5">Anexos:</span>&nbsp;</div></td>
            <td><span id="sprytextarea1">
              <textarea name="anexos" cols="45" rows="5" class="cajatxt" id="anexos"><?php echo $row_reg_Internos['danexos']; ?></textarea>
              <span class="textareaRequiredMsg">Se necesita un valor.</span></span></td>
            </tr>
          <tr>
            <td><div align="right" class="Estilo2 Estilo4"><span class="Estilo5">Mensaje/Observacion:</span>&nbsp;</div></td>
            <td><span id="sprytextarea3">
              <textarea name="adjuntos" cols="45" rows="5" class="cajatxt" id="adjuntos"><?php echo $row_reg_Internos['ladjuntos']; ?></textarea>
              <span class="textareaRequiredMsg">x.</span></span></td>
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
            <td><input name="button" type="submit" class="boton" id="button" value="RegistrarCorrespondencia" /></td>
            <td><input type="button" name="button2" id="button2" value="Imprimir Boleta" onclick="imprimir();"/></td>
            <td><input type="button" name="button4" id="button4" onclick="if(confirm('¿Esta seguro de cancelar la operacion?')){MM_goToURL('self','menuRecibirInternos3.php');return document.MM_returnValue;}" value="cancelar" /></td>
          </tr>
      </table></td>
    <td>&nbsp;</td>
  

</tr>   
   <?php } // Show if recordset not empty ?>
 <?php if ($totalRows_reg_Internos == 0) { // Show if recordset empty ?>
   <tr>
     <td>&nbsp;</td>
     <td>Lo siento, no es posible encontrar la correspondencia con CITE: <?php echo $_POST['cite']; ?>. Revise e intente nuevamente.</td>
     <td>&nbsp;</td>
   </tr>

 <?php } // Show if recordset empty ?>   
</table>
<input type="hidden" name="MM_insert" value="recibirInternos" />
<input type="hidden" name="MM_update" value="recibirInternos" />
</form>

<script type="text/javascript">
<!--
var sprytextarea3 = new Spry.Widget.ValidationTextarea("sprytextarea3", {validateOn:["blur"]});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($reg_Internos);

//mysql_free_result($id_entrada);
?>
