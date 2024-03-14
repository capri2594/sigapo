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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO salidas (usuario_cuenta, fecha_envio) VALUES (%s, %s)",
                       GetSQLValueString($_POST['usuario_derivador'], "text"),
                       GetSQLValueString($_POST['fecha_derivacion'], "date"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($insertSQL, $snet) or die(mysql_error());
  $ultimo=mysql_insert_id();
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO derivacion (hojaruta_cod, nro_destino, fun_destino, dep_destino, fecha_derivacion, mensaje, nhojas, anexos, fun_derivador, cod_depderivador, usuario_derivador, salidas_id) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['cod_hojaruta'], "text"),
                       GetSQLValueString($_POST['nro_destino'], "int"),
                       GetSQLValueString($_POST['seg_f_destino'], "text"),
                       GetSQLValueString($_POST['seg_d_destino'], "text"),
                       GetSQLValueString($_POST['fecha_derivacion'], "date"),
                       GetSQLValueString($_POST['mensaje'], "text"),
                       GetSQLValueString($_POST['hojas'], "int"),
                       GetSQLValueString($_POST['anexos'], "text"),
                       GetSQLValueString($_POST['fun_derivador'], "text"),
                       GetSQLValueString($_POST['cod_depderivador'], "text"),
                       GetSQLValueString($_POST['usuario_derivador'], "text"),
                       GetSQLValueString($ultimo, "int"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($insertSQL, $snet) or die(mysql_error());

  $insertGoTo = "EnviarDerivacionHR.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE hojaruta SET cont_destinos=%s WHERE cod=%s",
                       GetSQLValueString($_POST['nro_destino'], "int"),
                       GetSQLValueString($_POST['cod_hojaruta'], "text"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($updateSQL, $snet) or die(mysql_error());
}


$colname_Record_hr = "-1";
if (isset($_POST['codhr'])) {
  $colname_Record_hr = $_POST['codhr'];
}
mysql_select_db($database_snet, $snet);
$query_Record_hr = sprintf("SELECT * FROM hojaruta WHERE cod = %s", GetSQLValueString($colname_Record_hr, "text"));
$Record_hr = mysql_query($query_Record_hr, $snet) or die(mysql_error());
$row_Record_hr = mysql_fetch_assoc($Record_hr);
$totalRows_Record_hr = mysql_num_rows($Record_hr);

$colname_Record_derivaciones = "-1";
if (isset($_POST['codhr'])) {
  $colname_Record_derivaciones = $_POST['codhr'];
}
mysql_select_db($database_snet, $snet);
$query_Record_derivaciones = sprintf("SELECT * FROM derivacion WHERE hojaruta_cod = %s ORDER BY id ASC", GetSQLValueString($colname_Record_derivaciones, "text"));
$Record_derivaciones = mysql_query($query_Record_derivaciones, $snet) or die(mysql_error());
$row_Record_derivaciones = mysql_fetch_assoc($Record_derivaciones);
$totalRows_Record_derivaciones = mysql_num_rows($Record_derivaciones);
 
 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<script src="../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo2 {
	font-size: 12px;
	font-family: Arial, Helvetica, sans-serif;
}
.Estilo3 {font-size: 12px; font-family: Arial, Helvetica, sans-serif; font-weight: bold; }
.Estilo6 {font-size: 10px; font-family: Arial, Helvetica, sans-serif; }
.Estilo8 {font-size: 10px; font-family: Arial, Helvetica, sans-serif; font-weight: bold; }
.PROVEIDO {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	width: 90%;
	margin: 1px;
	padding: 1px;
	border: 1px solid #BBDDFF;
	text-align: justify;
	color: #003366;
	font-variant: normal;
	text-transform: none;
	background-color: #FFFFEA;
}
.cuadro {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	margin: 1px;
	padding: 1px;
	width: 100%;
	border: 1px solid #BBDDFF;
}
.Estilo9 {
	font-size: 12px;
	font-weight: bold;
}
.Estilo12 {font-size: 12px}
-->
</style>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<style type="text/css">
<!--
.Estilo15 {font-family: Verdana, Arial, Helvetica, sans-serif}
.Estilo16 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #FF6600;
}
.Estilo17 {
	font-size: 11px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
.Estilo18 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
}
.Estilo19 {font-size: 9px}
.Estilo21 {font-size: 11px}
.Estilo22 {
	font-family: "Courier New", Courier, monospace;
	font-weight: bold;
	font-size: 14px;
}
.Estilo23 {font-size: 10px}
-->
</style>
</head>

<body>
<table width="100%" border="0" cellspacing="1" cellpadding="0">
<?php if ($totalRows_Record_hr > 0) { // Show if recordset not empty ?> 
    <tr>
      <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td>
            <table width="100%" border="0" bgcolor="#FBFDFF" class="cuadro">
              <tr>
                <td><img src="imagen/Escudo-de-Bolivia.gif" alt="ESCUDO" width="49" height="38" longdesc="BOLIVIA" /></td>
                <td><table width="100%" border="0">
                  <tr>
                    <td height="10"><div align="center" class="Estilo22">PREFECTURA DE ORURO</div></td>
                  </tr>
                  <tr>
                    <td height="10"><div align="center" class="Estilo6 Estilo23"><?php echo $_SESSION['dep']; ?></div></td>
                  </tr>
                  <tr>
                    <td height="10"><div align="center" class="Estilo12"><strong>H&nbsp;O&nbsp;J&nbsp;A &nbsp;&nbsp;&nbsp;&nbsp;D&nbsp;E &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;R&nbsp;U&nbsp;T&nbsp;A</strong></div></td>
                  </tr>
                </table></td>
                <td><img src="imagen/logo2.gif" alt="PREF" width="48" height="44" longdesc="PREFECTURA" /></td>
              </tr>
            </table></td>
          <td width="150"><table width="100%" border="0" class="PROVEIDO">
            <tr>
              <td><span class="Estilo12 Estilo18">Codigo y Nº :</span></td>
              </tr>
            <tr>
              <td><span class="CollapsiblePanelTabHover"><?php echo $row_Record_hr['cod']; ?></span></td>
              </tr>
            <tr>
              <td><span class="Estilo19">Reporte Generado por SIRC</span>.</td>
              </tr>
          </table></td>
        </tr>

      </table></td>
    </tr>
  <tr>
    <td><div id="CollapsiblePanel1" class="CollapsiblePanel">
      <div class="CollapsiblePanelTab" tabindex="0">DATOS DE LA CORRESPONDENCIA</div>
      <div class="CollapsiblePanelContent">
        <table width="100%" border="0" cellspacing="2" cellpadding="5">

          <tr>
            <td><div align="right"><span class="Estilo8">REMITENTE:</span></div></td>
            <td class="PROVEIDO"><span class="Estilo6"><?php echo $row_Record_hr['procedencia']; ?></span></td>
            <td width="100">&nbsp;&nbsp;&nbsp;</td>
            <td class="cuadro"><span class="Estilo6"><strong>Hojas:&nbsp;</strong><?php echo $row_Record_hr['nhojas']; ?></span></td>
          </tr>
          <tr>
            <td><div align="right"><span class="Estilo8">REFERENCIA:</span></div></td>
            <td class="PROVEIDO"><span class="Estilo6"><?php echo $row_Record_hr['ref']; ?></span></td>
            <td width="100">&nbsp;</td>
            <td class="cuadro"><span class="Estilo6"><strong>Anexos:<?php echo $row_Record_hr['nanexos']; ?></strong></span></td>
          </tr>
        </table>
      </div>
    </div></td>
  </tr>
  <tr>
    <td><div id="CollapsiblePanel2" class="CollapsiblePanel">
      <div class="CollapsiblePanelTab" tabindex="0">DERIVACIONES (N&deg;1 a N&deg;<?php echo $row_Record_hr['cont_destinos']; ?>)</div>
      <div class="CollapsiblePanelContent">
 
          <table width="100%" border="0" cellspacing="1" cellpadding="0" style="overflow:scroll;">
              <tr>
                <td><span class="Estilo2"><strong>PRIMER DESTINATARIO:</strong>&nbsp; </span><span class="PROVEIDO"><?php echo $row_Record_hr['primer_destino']; ?></span></td>
              </tr>
              <?php if ($totalRows_Record_derivaciones > 0) { // Show if recordset not empty ?>
                <?php do { ?>            
                  <tr>
                    
                    <td><hr /></td>
                  </tr>
                  <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
                    <tr>
                      <td><table width="100%" border="0" cellspacing="1" cellpadding="0"><tr><td><table width="100%" border="0" cellspacing="1" cellpadding="0">
                        <tr>
                          <td><div align="right"><strong class="Estilo2">FECHA.DERIVACION:&nbsp;</strong></div></td>
                                  <td><div class="cuadro" style="width:180px;">
                                    <div align="left"><?php echo $row_Record_derivaciones['fecha_derivacion']; ?></div>
                                  </div></td>
                                </tr>
                        </table></td>
                                </tr>
                        </table>                  </td>
                          <td width="80"><div align="right" class="Estilo3">Nº Hojas:&nbsp;</div></td>
                          <td width="200">
                            <table width="100%" border="0" cellpadding="0" cellspacing="1">
                                  
                              <tr>
                                <td><div class="cuadro" id="hojas" style="width:120px;"><?php echo $row_Record_derivaciones['nhojas']; ?></div></td>
                              </tr>
                          </table>                    </td>
                        </tr>
                    <tr>
                      <td>&nbsp;</td>
                          <td width="80"><div align="right" class="Estilo2"><strong>Anexos:</strong>&nbsp;</div></td>
                          <td width="200"><div align="left" class="Estilo2">
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cuadro">
                                  
                                <tr>
                                  <td><?php echo $row_Record_derivaciones['anexos']; ?></td>
                                </tr>
                              </table>
                          </div></td>
                        </tr>
                  </table></td>
                  </tr><tr>
                    <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
                        <tr >
                          <td><span class="Estilo2"><strong><?php echo $row_Record_derivaciones['nro_destino']; ?>. DESTINATARIO:</strong>&nbsp; </span><span class="PROVEIDO"><span class="Estilo21"><?php echo $row_Record_derivaciones['fun_destino']; ?></span>&laquo;<span class="Estilo21"><?php echo $row_Record_derivaciones['dep_destino']; ?></span>&raquo;</span></td>
                        </tr>
                        <tr align="center">
                          <td align="center">&nbsp;</td>
                        </tr>
                        <tr align="center">
                          <td align="center">
                          <div class="PROVEIDO" id="el_proveido">  
                            <div align="center">
                            
                              <table width="100%" border="0" cellspacing="1" cellpadding="1">
                                
                                <tr>
                                  <td bgcolor="#E8F3FF"><span class="Estilo2">*****PROVEIDO******{&nbsp;<em>instruccion:&nbsp;<?php echo $row_Record_derivaciones['proveido']; ?>&nbsp;</em>}</span></td>
                                  </tr>
                                <tr>
                                  <td><span class="Estilo17"><strong>Detalle:</strong>&nbsp;</span><?php echo $row_Record_derivaciones['mensaje']; ?></td>
                                  </tr>
                                <tr>
                                  <td><div align="right"></div></td>
                                </tr>
                                <tr>
                                  <td><div align="right"><span class="Estilo9">Firma:</span><span class="Estilo12">&nbsp;<?php echo $row_Record_derivaciones['fun_derivador']; ?></span></div></td>
                                </tr>                            
                                </table>
                            </div>
                          </div></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                        </tr>
                    </table></td>
                  </tr>
                  
                  <?php } while ($row_Record_derivaciones = mysql_fetch_assoc($Record_derivaciones)); ?>
                <?php } // Show if recordset not empty ?>
          </table>
        </div>
    </div>    </td>
  </tr>
  <tr>
    <td><form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td><div id="CollapsiblePanel3" class="CollapsiblePanel">
            <div class="CollapsiblePanelTab" tabindex="0">NUEVA DERIVACION&nbsp;(Nº<strong><?php echo $row_Record_hr['cont_destinos']+1; ?></strong>)</div>
            <div class="CollapsiblePanelContent">
              <table width="100%" border="0" cellspacing="1" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
                    <tr>
                      <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
                        <tr>
                          <td width="100"><table width="100%" border="0" cellspacing="1" cellpadding="0">
                                <tr>
                                  <td><div align="right"><strong class="Estilo2">FECHA:</strong></div></td>
                                  <td><div class="cuadro" style="width:180px;">
                                      <div align="left"><?php echo date("d-m-Y H:i:s"); ?></div>
                                  </div></td>
                                </tr>
                            </table></td>
                        </tr>
                      </table></td>
                      <td width="80"><div align="right" class="Estilo3">Nº Hojas:&nbsp;</div></td>
                      <td width="200"><table width="100%" border="0" cellpadding="0" cellspacing="1">
                          <tr>
                            <td><span id="spryhojas">
                              <input name="hojas" type="text" class="cuadro" id="hojas2" size="5" />
                              <span class="textfieldRequiredMsg">X.</span><span class="textfieldInvalidFormatMsg">X</span></span></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><input name="fecha_derivacion" type="hidden" id="fecha_derivacion" value="<?php echo date("Y-m-d H:i:s");?>" />
                        <input name="cod_hojaruta" type="hidden" id="cod_hojaruta" value="<?php echo $row_Record_hr['cod']; ?>" />
                        <input name="nro_destino" type="hidden" id="nro_destino" value="<?php echo $row_Record_hr['cont_destinos']+1; ?>" /></td>
                      <td width="80"><div align="right" class="Estilo2"><strong>Anexos:</strong>&nbsp;</div></td>
                      <td width="200"><div align="left" class="Estilo2">
                          <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td><span id="sprytextarea1">
                                <textarea name="anexos" cols="20" rows="2" class="cuadro" id="anexos"></textarea>
                                <span class="textareaRequiredMsg">x</span></span></td>
                            </tr>
                          </table>
                      </div></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="100%" border="0" cellspacing="1" cellpadding="0">

                      <tr>
                        <td width="120"><span class="Estilo2"><strong><?php echo $row_Record_hr['cont_destinos']+1; ?>&nbsp;.&nbsp;DESTINATARIO:</strong></span> </td>
                        <td width="220"><span id="sprydestinatario">
                          <input name="seg_f_destino" type="text" class="cuadro" id="seg_f_destino" style="width:200px" />
                        </span></td>
                        <td><span class="textfieldRequiredMsg">Se necesita un valor.</span> &nbsp;&laquo;<span id="sprytextfield3">
                          <input name="seg_d_destino" type="text" class="cuadro" id="seg_d_destino" style="width:170px;"/>
                        <span class="textfieldRequiredMsg">X.</span></span>&raquo;
                        <input name="add_destino" type="button" id="add_destino" onclick="MM_openBrWindow('insert_fun_Destino3.php','','status=yes,scrollbars=yes,width=630,height=400')" value="Buscar Funcionarios" /></td>
                      </tr>

                    </table></td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="sprymensaje">
                    <textarea name="mensaje" id="mensaje" cols="80" rows="7"></textarea>
                    <span class="textareaRequiredMsg">X.</span></span></td>
                </tr>
                <tr>
                  <td class="Estilo12 Estilo15"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FIRMA:</strong> <?php echo $_SESSION['fun']; ?>&nbsp;(<?php echo $_SESSION['dep']; ?>)
                    <input name="fun_derivador" type="hidden" id="fun_derivador" value="<?php echo $_SESSION['fun']; ?>" />
                    <input name="cod_depderivador" type="hidden" id="cod_depderivador" value="<?php echo $_SESSION['cod_dep']; ?>" />
                    <input name="usuario_derivador" type="hidden" id="usuario_derivador" value="<?php echo $_SESSION['user']; ?>" /></td>
                </tr>
              </table>
            </div>
          </div></td>
          </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><input type="submit" name="Enviar" id="Enviar" value="Derivar HOJA DE RUTA ahora" /></td>
          </tr>
      </table>
      <input type="hidden" name="MM_insert" value="form1" />
      <input type="hidden" name="MM_update" value="form1" />
</form>    </td>
    </tr>  

<?php } // Show if recordset not empty ?>

  <?php if ($totalRows_Record_hr == 0) { // Show if recordset empty ?>
    <tr>
      <td> <div align="center" class="Estilo16">Error: NO se encuentra la HOJA de RUTA deseada..! <br />
        <br />

          <input name="regresar" type="submit" class="CollapsiblePanelTab" id="regresar" value="« CERRAR VENTANA" onclick="window.close();" />
    
        </div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <?php } // Show if recordset empty ?>
</table>
<script type="text/javascript">
<!--
var CollapsiblePanel1 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel1", {contentIsOpen:false});
var CollapsiblePanel2 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel2", {contentIsOpen:false});
var CollapsiblePanel3 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel3");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprydestinatario", "none", {validateOn:["blur", "change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("spryhojas", "integer", {validateOn:["blur"], hint:"Ingrese un numero."});
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {validateOn:["blur"], hint:"coloque (N.A.) si no hay ANEXOS"});
var sprytextarea2 = new Spry.Widget.ValidationTextarea("sprymensaje", {validateOn:["blur", "change"], hint:"Llene en proveido, con su firma digital."});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {validateOn:["blur", "change"]});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($Record_hr);

mysql_free_result($Record_derivaciones);
?>
