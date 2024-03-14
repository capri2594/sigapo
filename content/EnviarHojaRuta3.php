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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formHR")&&(($_POST['siguiente']))) {
  $insertSQL = sprintf("INSERT INTO hojaruta (cod, salinternas_salidas_cite, fecha_creacion, dep_remite, fun_remite, `ref`, dep_destino, fun_destino, fecha_envio, nhojas, nanexos) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['codigoHR'], "text"),
                       GetSQLValueString($_POST['cite'], "text"),
                       GetSQLValueString($_POST['fecha_creacion'], "date"),
                       GetSQLValueString($_POST['dep_remite'], "text"),
                       GetSQLValueString($_POST['fun_remite'], "text"),
                       GetSQLValueString($_POST['ref'], "text"),
                       GetSQLValueString($_POST['dep_dest'], "text"),
                       GetSQLValueString($_POST['fun_dest'], "text"),
                       GetSQLValueString($_POST['fecha_creacion'], "date"),
                       GetSQLValueString($_POST['nhojas'], "int"),
                       GetSQLValueString($_POST['nanexos'], "int"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($insertSQL, $snet) or die(mysql_error());
}

$colname_list_hr = "-1";
if (isset($_POST['codHR'])) {
  $colname_list_hr = $_SESSION['cod_dep']."-".$_POST['codHR'];
}
mysql_select_db($database_snet, $snet);
$query_list_hr = sprintf("SELECT * FROM hojaruta WHERE cod = %s", GetSQLValueString($colname_list_hr, "text"));
$list_hr = mysql_query($query_list_hr, $snet) or die(mysql_error());
$row_list_hr = mysql_fetch_assoc($list_hr);
$totalRows_list_hr = mysql_num_rows($list_hr);

mysql_select_db($database_snet, $snet);
$query_list_destinos = "SELECT * FROM dependencia WHERE pd = 1 ORDER BY prioridad ASC";
$list_destinos = mysql_query($query_list_destinos, $snet) or die(mysql_error());
$row_list_destinos = mysql_fetch_assoc($list_destinos);
$totalRows_list_destinos = mysql_num_rows($list_destinos);

$colname_list_remite = "-1";
if (isset($_SESSION['cod_dep'])) {
  $colname_list_remite = $_SESSION['cod_dep'];
}
mysql_select_db($database_snet, $snet);
$query_list_remite = sprintf("SELECT nombre, dependencia_cod FROM funcionario WHERE dependencia_cod = %s ORDER BY cargo ASC", GetSQLValueString($colname_list_remite, "text"));
$list_remite = mysql_query($query_list_remite, $snet) or die(mysql_error());
$row_list_remite = mysql_fetch_assoc($list_remite);
$totalRows_list_remite = mysql_num_rows($list_remite);

mysql_select_db($database_snet, $snet);
$query_RecordOtrosDep = "SELECT cod, nombredep FROM dependencia WHERE pd = 0 ORDER BY nombredep ASC";
$RecordOtrosDep = mysql_query($query_RecordOtrosDep, $snet) or die(mysql_error());
$row_RecordOtrosDep = mysql_fetch_assoc($RecordOtrosDep);
$totalRows_RecordOtrosDep = mysql_num_rows($RecordOtrosDep);
$ok=0;
if (($_POST['comprobar'])&&($totalRows_list_hr == 0)&&(isset($_POST['codHR']))) {$ok=1;}
if (($_POST['comprobar'])&&($totalRows_list_hr > 0)&&(isset($_POST['codHR']))) {$ok=2;}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Enviar Hoja de Ruta</title>
<style type="text/css">
<!--
.cuadro {
	color: #7A7A7A;
	background-color: #EFF5F1;
	margin: 5px;
	padding: 7px;
	border: 1px solid #D2D2D2;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	width: 630px;
}
.boton {
	background-color: #EFF5F1;
	border: 1px solid #9B9B9B;
	color: #666666;
	font-weight: bold;
	font-size: 11px;
	font-family: Arial, Helvetica, sans-serif;
}
.paso_normal {
	background-color: #EBF1E4;
	border: 1px solid #CCCCCC;
	margin: 0px;
	padding: 12px;
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 14px;
	width: 75px;
}
.pasotitulo {
	background-color: #DCF0B3;
	border: 1px solid #CCCCCC;
	padding: 12px;
	font-size: 14px;
	font-weight: bold;
	color: #00376F;
	font-family: Albertus, sans-serif, Modern;
}
.paso_over {
	background-color: #DCF0B3;
	border: 1px solid #CCCCCC;
	padding: 12px;
	font-size: 14px;
	font-weight: bold;
	color: #00376F;
	font-family: Albertus, sans-serif, Modern;
}
.subrayado {
	border-bottom-width: thin;
	border-bottom-style: double;
	border-bottom-color: #C3C3C3;
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #666666;
	font-weight: bold;
}
.subrayadoCampo {
	width: 50px;
	border-bottom-width: 1px;
	border-bottom-style: solid;
	border-top-color: #000000;
	border-right-color: #000000;
	border-bottom-color: #000000;
	border-left-color: #000000;
	color: #000000;
}
.agregar_cite {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #3366FF;
	text-decoration: underline;
	width: 100px;
}
-->
</style>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo4 {
	color: #FF0000;
	font-weight: bold;
}
.Estilo6 {color: #FF0000}
.Estilo9 {
	color: #339933;
	font-weight: bold;
}
.Estilo12 {
	font-size: 12px;
	font-family: Albertus, sans-serif, Modern;
}
.Estilo13 {
	font-family: Arial, Helvetica, sans-serif
}
-->
</style>
<script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

function MM_showHideLayers() { //v9.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) 
  with (document) if (getElementById && ((obj=getElementById(args[i]))!=null)) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}

function destinos(obj){
  //alert("valor="+obj.value);
   if (obj.value!="-1")
   {
       document.getElementById('dep_dest').value=obj.value;
	   document.getElementById('fun_dest').value="A quien Corresponda";
	   document.getElementById('destinatario').innerHTML=obj.value;
	   
   }
   else
    alert("ERROR: 404 destinatario no asignado correctamente.");
   //alert("valor asignado="+document.getElementById('fun_dest').value);
}
//-->

function confirmar()
{
   if (confirm('Esta seguro, de Registrar la Hoja de Ruta con los datos ingresados?'))
        document.getElementById('formHR').submit();
	//else
	    //document.formHR.submit()='False';	
   
}
</script>
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.mensaje {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #FFFFFF;
	background-color: #FF3366;
}
.Estilo19 {font-size: 10px}
-->
</style>
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo23 {font-size: 9px; font-weight: bold; }
.Estilo25 {font-size: 9}
-->
</style>
</head>

<body onload=" document.getElementById('codHR').focus();">
<form action="<?php echo $editFormAction; ?>" method="POST" name="formHR" id="formHR">
  <table width="100%" border="0" cellspacing="1" cellpadding="7">
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td><table width="100%" border="0" cellspacing="1" cellpadding="2">
             <?php if (($ok==2)||($ok==0)) { // Show if recordset not empty ?>
            <tr>
              <td align="right" valign="middle"> <span class="mensaje" id="mensaje">
              <?php if($Result1) echo "Hoja de Ruta :: registrada correstamente";?></span></td>
              <td valign="middle"><span class="Estilo13"><img src="../img/iconos/insertar.gif" width="40" height="40" />&nbsp;Ingresar numero de Hoja de Ruta.</span></td>
              <td valign="middle">&nbsp;</td>
            </tr>
            <tr>
              <td width="24%" align="right" valign="middle"><span class="paso_normal"><?php echo $_SESSION['cod_dep']; ?>
                <input name="cod_dep" type="hidden" id="cod_dep" value="<?php echo $_SESSION['cod_dep']; ?>" />
              </span>&nbsp;&nbsp;</td>
              <td width="52%" valign="middle"><span id="sprytextfield1"><span id="sprytextfield4">
              <input type="text" name="codHR" id="codHR" tabindex="0"/>
              <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span><span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
              <td width="24%" valign="middle"><div align="right">
                <input name="comprobar" type="submit" class="boton" id="comprobar" value="Comprobar Codigo" />
              </div></td>
            </tr>
            
            <?php if ($ok==1) {?>
            <?php }?>
            <?php } // Show if recordset not empty ?>
          </table>          </td>
      </tr>
      
      <tr>
        <td>
       
        <table width="100%" border="0" cellspacing="1" cellpadding="2">
        <?php if ($totalRows_list_hr == 0) { // Show if recordset empty ?>
        <?php if ($ok==1) { // Show if recordset empty ?>
          <tr>
            <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
              <tr>
                <td width="250"><div align="left">HOJA DE RUTA :&nbsp;<span class="Estilo13"><?php echo $_SESSION['cod_dep']; ?>-<?php echo $_POST['codHR']; ?> &nbsp;</span>&nbsp;
                      <input type="hidden" name="codigoHR" id="codigoHR" value="<?php echo $_SESSION['cod_dep']; ?>-<?php echo $_POST['codHR']; ?>"/>
                </div></td>
                <td><span class="Estilo19">[<span class="Estilo9">OK</span>]</span></td>
                <td><div align="right">
                  <input name="siguiente2" type="submit" class="boton" id="siguiente2" value="REGISTRAR &gt;&gt;" />
                </div></td>
              </tr>

            </table>
            </td>
          </tr>
          
          <tr>
            <td>
            
            <table width="100%" border="0" cellspacing="1" cellpadding="3">
              <tr>
                <td><div class="subrayado">DATOS DE LA CORRESPONDENCIA</div></td>
              </tr>
              <tr>
                <td><div class="cuadro">
                  <table width="100%" border="0" cellspacing="1" cellpadding="0">
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
                        <input name="hora" type="text" id="hora" value="<?php echo date("H:i");?>" size="5" maxlength="5" />
                        <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></div></td>
                      <td><div align="right"><span id="sprytextfield7"><span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span> No. de Hojas 
                        <input name="nhojas" type="text" id="nhojas" size="8" />
                      </div></td>
                      </tr>
                    <tr>
                      <td>&nbsp;&nbsp;
                        <div class="agregar_cite" id="showcite"></div></td>
                      <td><input name="cite" type="hidden" id="cite" value="sin cite" /></td>
                      <td><div align="right"><span id="sprytextfield8"><span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span>No. de Anexos
                          <textarea name="nanexos" cols="25" rows="1" id="nanexos"></textarea>
                      </div></td>
                      </tr>
                  </table>
                  <p>Remitente:
                    <span id="sprytextfield13">
                    <input name="remitente" type="text" id="remitente" size="35" />
                    <span class="textfieldRequiredMsg">x</span></span>                    &nbsp;<span class="subrayadoCampo">&nbsp;&nbsp;&lt;<em ><span id="origen">&nbsp;</span></em>&gt;</span>
                    <input name="fun_remite" type="hidden" id="fun_remite" value="<?php echo $_SESSION['fun']; ?>" />
                    <input name="dep_remite" type="hidden" id="dep_remite" value="<?php echo $_SESSION['dep']; ?>" />
                    <br />
                    <br />
                    Referencia:<span id="sprytextfield2"><span id="sprytextfield14">
                    <input name="ref" type="text" id="ref" size="70" />
                    <span class="textfieldRequiredMsg">x</span></span><span class="textfieldRequiredMsg">Se necesita un valor.</span></span> &nbsp;&nbsp;
                    <input name="examinar2" type="button" id="examinar2" onclick="MM_openBrWindow('insert_correspondenciaRecibidas3.php','Destinatario','left=150,top=150,status=yes,width=730,height=350')" value="BUSCAR" />
                  </p>
                  </div>                </td>
              </tr>
              <tr>
                <td><div class="subrayado">PRIMER DESTINATARIO</div></td>
              </tr>
              <tr>
                <td><div class="cuadro"><span class="Estilo12">PARA:&nbsp;</span> <span class="subrayadoCampo" id="destinatario">&nbsp;</span>
                    <input type="hidden" name="fun_dest" id="fun_dest" />
                  <input name="dep_dest" type="hidden" id="dep_dest" />
</div></td>
              </tr>
              <tr>
                <td><div class="subrayado">SEGUNDO DESTINATARIO</div></td>
              </tr>
              <tr>
                <td><div class="cuadro">
                  <table width="100%" border="0" cellpadding="3" cellspacing="2">
                    <tr>
                      <td><span class="Estilo23">PARA </span></td>
                      <td><span id="sprytextfield6">
                        <input name="seg_f_destino" type="text" id="seg_f_destino" size="35" />
                        <span class="textfieldRequiredMsg">x</span>&lt;&lt; </span><span id="sprytextfield12">
                        <input type="text" name="seg_d_destino" id="seg_d_destino" readonly="readonly"/>
&gt;&gt; <span class="textfieldRequiredMsg">Se necesita un valor.</span></span>&nbsp;
<input name="button" type="button" id="button" onclick="MM_openBrWindow('insert_fun_Destino3.php','','left=240,top=140,width=620,height=315')" value="BUSCAR" /></td>
                    </tr>
                    
                    <tr>
                      <td><span class="Estilo23">PROVEIDO</span></td>
                      <td><span id="sprytextfield5">
                        <input name="tmotivo" type="text" id="tmotivo" size="35" />
                        <span class="textfieldRequiredMsg">x</span></span>&nbsp;
                        <input name="Elegir" type="button" id="Elegir" onclick="MM_openBrWindow('eMotivos.php','proveidos','left=320,top=190,width=240,height=330')" value="SELECCIONAR" />
                        &nbsp;<span class="Estilo23">&nbsp;&nbsp;&nbsp;FECHA:</span><span class="Estilo25">&nbsp;</span>
                        <input name="hora_reg" type="text" id="hora_reg" size="15"  value="<?php echo date("d-m-Y H:i"); ?>" readonly="readonly" /></td>
                    </tr>
                    <tr>
                      <td><span class="Estilo23">Nota</span></td>
                      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          
                          <tr>
                            <td><span id="sprytextarea1">
                            <textarea name="mensaje" cols="64" rows="3" id="mensaje"></textarea>
                            <span id="countsprytextarea1">&nbsp;</span> <span class="textareaMaxCharsMsg">x</span></span></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                  </table>
                </div></td>
              </tr>
            </table>
          
            </td>
          </tr>
     <?php } // fin comprobar ?>
     <?php } // Show if recordset empty ?>
          <?php if ($totalRows_list_hr > 0) { // Show if recordset not empty ?>
          <tr>
            <td><div class="subrayado">Resultado de la comprobacion</div></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="1" cellpadding="7">
              <tr>
                <td><div class="cuadro">Codigo de Hoja de Ruta:&nbsp;<span class="Estilo6"><?php echo $_SESSION['cod_dep']; ?>-<?php echo $_POST['codHR']; ?></span><br />
                  Comprobacion: <span class="Estilo4">ERROR</span> <span class="Estilo6">el codigo ya existe no puede duplicar datos</span><br />
                </div></td>
              </tr>
            </table>
            
            </td>
          </tr>
          <?php } // Show if recordset not empty ?>
        </table></td>
        </tr>
    </table></td>
  </tr>
</table>
  <input type="hidden" name="MM_insert" value="formHR" />
</form>

<script type="text/javascript">
<!--
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "integer", {validateOn:["blur"]});
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {counterId:"countsprytextarea1", counterType:"chars_remaining", maxChars:500, isRequired:false});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "none", {validateOn:["blur", "change"]});
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "none", {validateOn:["blur", "change"]});
var sprytextfield12 = new Spry.Widget.ValidationTextField("sprytextfield12");
var sprytextfield13 = new Spry.Widget.ValidationTextField("sprytextfield13", "none", {validateOn:["blur"]});
var sprytextfield14 = new Spry.Widget.ValidationTextField("sprytextfield14", "none", {validateOn:["blur"]});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($list_hr);

mysql_free_result($list_destinos);

mysql_free_result($list_remite);

mysql_free_result($RecordOtrosDep);
?>
