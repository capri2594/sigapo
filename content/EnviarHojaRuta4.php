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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formHR")) {
  $insertSQL = sprintf("INSERT INTO hojaruta (cod, salinternas_salidas_cite, fecha_creacion, dep_remite, fun_remite, `ref`, dep_destino, fun_destino, nhojas, nanexos) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['codigoHR'], "text"),
                       GetSQLValueString($_POST['cite'], "text"),
                       GetSQLValueString($_POST['fecha_doc'], "date"),
                       GetSQLValueString($_POST['dep_remite'], "text"),
                       GetSQLValueString($_POST['fun_remite'], "text"),
                       GetSQLValueString($_POST['ref'], "text"),
                       GetSQLValueString($_POST['dep_dest'], "text"),
                       GetSQLValueString($_POST['fun_dest'], "text"),
                       GetSQLValueString($_POST['nhojas'], "int"),
                       GetSQLValueString($_POST['nanexos'], "text"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($insertSQL, $snet) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formHR")) {
  $insertSQL = sprintf("INSERT INTO derivacion (hojaruta_cod, fun_destino, dep_destino, fecha_derivacion, proveido, mensaje) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['codigoHR'], "text"),
                       GetSQLValueString($_POST['seg_f_destino'], "text"),
                       GetSQLValueString($_POST['seg_d_destino'], "text"),
                       GetSQLValueString($_POST['hora_reg'], "date"),
                       GetSQLValueString($_POST['tmotivo'], "text"),
                       GetSQLValueString($_POST['mensaje'], "text"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($insertSQL, $snet) or die(mysql_error());
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

<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>

<style type="text/css">
<!--
.Estilo13 {
	font-family: Arial, Helvetica, sans-serif
}
-->
</style>
<script type="text/javascript">
<!--

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
-->
</style>
<script  src="js/prototype.js" language="javascript1.2"></script>
<script  src="js/ajax.js" language="javascript1.2"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo26 {font-size: 14px}
.Estilo27 {font-family: Verdana, Arial, Helvetica, sans-serif}
.Estilo28 {
	font-size: 18px;
	font-weight: bold;
	font-family: "Courier New", Courier, monospace;
}
-->
</style>
</head>

<body onload=" document.getElementById('codHR').focus();">
<form action="HojaRuta4.php" method="POST" name="formHR" id="formHR">
  <table width="100%" border="0" cellspacing="1" cellpadding="7">
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td><table width="100%" border="0" cellspacing="1" cellpadding="2">
            
            <tr>
              <td align="right" valign="middle">&nbsp;</td>
              <td valign="middle"><span class="Estilo13"><img src="../img/iconos/insertar.gif" width="40" height="40" />&nbsp;numero de Hoja de Ruta.</span></td>
              <td valign="middle">&nbsp;</td>
            </tr>
            <tr>
              <td width="24%" align="right" valign="middle"><div align="right"><span class="paso_normal"><?php echo $_SESSION['sigla']; ?>
                    <input name="cod_dep" type="hidden" id="cod_dep" value="<?php echo $_SESSION['sigla']; ?>" />
              </span><span class="Estilo28">-</span>&nbsp;&nbsp;</div></td>
              <td width="52%" valign="middle"><span id="sprytextfield1">
              <input type="text" name="codHR" id="codHR" />
              <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Invalido. Ingrese numero</span></span></td>
              <td width="24%" valign="middle"><div align="right">
                <input name="comprobar" type="submit" class="boton" id="comprobar" value="Crear Nuevo" />
              </div></td>
            </tr>
            
 
          </table>          </td>
      </tr>
      
      <tr>
        <td>
       
        <table width="100%" border="0" cellspacing="1" cellpadding="2">
 
          <tr>
            <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
                <tr>
                  <td><div class="subrayado"></div></td>
                </tr>
            </table></td>
          </tr>

<tr>
       <td><div class="subrayado">Resultado de la comprobacion</div></td>
     </tr>
     <tr>
       <td><table width="100%" border="0" cellspacing="1" cellpadding="7">
           <tr>
             <td><div class="cuadro" id="muestra-resultado"><span class="Estilo26"><img src="imagen/b_tipp.png" width="16" height="16" />&nbsp;<span class="Estilo27">Inserte un codigo de Hoja de Ruta.</span></span>(Correspondencia INTERNA de la Prefectura)<br />
             </div></td>
           </tr>
       </table></td>
     </tr>
</table></td>
        </tr>
    </table></td>
  </tr>
</table>
  
</form>

<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {validateOn:["blur", "change"]});
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
