<?php require_once('../Connections/snet.php'); ?><?php 
session_name("LoginSIRC");
session_start();
$cod_dep=$_SESSION['cod_dep'];
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
  $insertSQL = sprintf("INSERT INTO entradas (usuario_cuenta, fecha_recibido, fun_recibido, dep_recibido, cod_deprecibido) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['user_recibido'], "text"),
                       GetSQLValueString($_POST['fecha_recibido'], "date"),
                       GetSQLValueString($_POST['fun_recibido'], "text"),
                       GetSQLValueString($_POST['dep_recibido'], "text"),
                       GetSQLValueString($_POST['cod_deprecibido'], "text"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($insertSQL, $snet) or die(mysql_error());
  $entrada_id=mysql_insert_id();
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO derivacion (hojaruta_cod, nro_destino, fun_destino, dep_destino, mensaje, nhojas, anexos, cod_depderivador, entradas_id) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['hojaruta_cod'], "text"),
                       GetSQLValueString($_POST['num'], "int"),
                       GetSQLValueString($_POST['fun_destino'], "text"),
                       GetSQLValueString($_POST['dep_destino'], "text"),
                       GetSQLValueString($_POST['proveido'], "text"),
                       GetSQLValueString($_POST['nhojas'], "int"),
                       GetSQLValueString($_POST['anexos'], "text"),
                       GetSQLValueString($_POST['cod_depderivador'], "text"),
                       GetSQLValueString($entrada_id, "int"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($insertSQL, $snet) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {

  $updateSQL = sprintf("UPDATE hojaruta SET nhojas=%s, cont_destinos=%s WHERE cod=%s",
                       GetSQLValueString($_POST['nhojas'], "int"),
                       GetSQLValueString($_POST['num'], "int"),
                       GetSQLValueString($_POST['hojaruta_cod'], "text"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($updateSQL, $snet) or die(mysql_error());
}

$codigo_obtener_hr = "-1";
if (isset($_GET['cod'])) {
  $codigo_obtener_hr = $_GET['cod'];
}
mysql_select_db($database_snet, $snet);
$query_obtener_hr = sprintf("SELECT * FROM hojaruta WHERE hojaruta.cod=%s", GetSQLValueString($codigo_obtener_hr, "text"));
$obtener_hr = mysql_query($query_obtener_hr, $snet) or die(mysql_error());
$row_obtener_hr = mysql_fetch_assoc($obtener_hr);
$totalRows_obtener_hr = mysql_num_rows($obtener_hr);

$coddep_cumpas = "-1";
if (isset($_SESSION['cod_dep'])) {
  $coddep_cumpas = $_SESSION['cod_dep'];
}
mysql_select_db($database_snet, $snet);
$query_cumpas = sprintf("SELECT * FROM funcionario WHERE funcionario.dependencia_cod=%s ORDER BY funcionario.cargo ASC", GetSQLValueString($coddep_cumpas, "text"));
$cumpas = mysql_query($query_cumpas, $snet) or die(mysql_error());
$row_cumpas = mysql_fetch_assoc($cumpas);
$totalRows_cumpas = mysql_num_rows($cumpas);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.barras {	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
	background-color: #CAD2DB;
}
.cabecera {	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #FFFFFF;
	background-color: #6B7A9D;
	height: 30px;
}
.superior {	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
	background-color: #E5ECF7;
}
-->
</style>
<script type="text/javascript" src="js/prototype.js"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
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
.Estilo6 {font-size: 12px; font-family: Arial, Helvetica, sans-serif; }
-->
</style>
</head>

<body>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <?php if ($totalRows_obtener_hr > 0) { // Show if recordset not empty ?>
<table width="100%" border="0">
    <tr class="cabecera">
      <td><table width="100%" border="0">
          <tr>
            <td>RECEPCION de la HOJA DE RUTA: 
              <label>
              <input name="hr" type="button" id="hr" onclick="MM_openBrWindow('reporte_hr.php?cod=<?php echo $_GET['cod'];?>','','width=600,height=300')" value="<?php echo $_GET['cod']?>"  />
            </label></td>
            <td><label>
              <div align="right">
                <input type="submit" name="Consultar otro" id="Consultar otro" value="Registrar Recepcion" onclick="window.history.back();"/>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="button" name="cerrar" id="cerrar" value="Cerrar" onclick="window.close();"/>
                </div>
              </label></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td><table width="100%" border="0">
          <tr>
            <td><span class="Estilo6">(numero)Destinatario</span></td>
            <td><span id="sprytextfield1">
              <label>
              <input type="text" name="num" id="num" />
              </label>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span>
            <input name="hojaruta_cod" type="hidden" id="hojaruta_cod" value="<?php echo $_GET['cod']; ?>" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><span class="Estilo6">Nombre</span></td>
            <td><span id="spryselect1">
              <label>
              <select name="fun_destino" id="fun_destino">
                <?php
do {  
?>
                <option value="<?php echo $row_cumpas['nombre']?>"><?php echo $row_cumpas['nombre']?></option>
                <?php
} while ($row_cumpas = mysql_fetch_assoc($cumpas));
  $rows = mysql_num_rows($cumpas);
  if($rows > 0) {
      mysql_data_seek($cumpas, 0);
	  $row_cumpas = mysql_fetch_assoc($cumpas);
  }
?>
              </select>
              </label>
            <span class="selectRequiredMsg">Seleccione un elemento.</span></span>
            <input name="dep_destino" type="hidden" id="dep_destino" value="<?php echo $_SESSION['dep']; ?>" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><span class="Estilo6">Proveido</span></td>
            <td><span id="sprytextarea1">
              <label>
              <textarea name="proveido" id="proveido" cols="45" rows="5"></textarea>
              </label>
            </span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><span class="Estilo6">Hojas</span></td>
            <td><span id="sprytextfield2">
            <label>
            <input type="text" name="nhojas" id="nhojas" />
            </label>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
            <td><span class="Estilo6">Fecha de Recepcion </span><span id="sprytextfield4">
              <input type="text" name="fecha_recibido" id="fecha_recibido" value="<?php echo date("Y-m-d H:i:s");?>"/>
              <span class="textfieldRequiredMsg">error.</span></span></td>
          </tr>
          <tr>
            <td><span class="Estilo6">Anexos</span></td>
            <td><span id="sprytextfield3">
              <label>
              <input type="text" name="anexos" id="anexos" />
              </label>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span>
              <input name="cod_depderivador" type="hidden" id="cod_depderivador" value="<?php 
			  $siglas=explode("-",$_GET['cod']);
			  echo $siglas[0]; ?>" />
              <input name="fun_recibido" type="hidden" id="fun_recibido" value="<?php echo $_SESSION['fun']; ?>" />
              <input name="dep_recibido" type="hidden" id="dep_recibido" value="<?php echo $_SESSION['dep']; ?>" />
              <input name="cod_deprecibido" type="hidden" id="cod_deprecibido" value="<?php echo $_SESSION['cod_dep']; ?>" />
              <input name="user_recibido" type="hidden" id="user_recibido" value="<?php echo $_SESSION['user']; ?>" /></td>
            <td><span class="Estilo6">Usuario:</span>
              <input name="fun_recibido2" type="text" id="fun_recibido2" value="<?php echo $_SESSION['fun']; ?>" readonly="readonly"/></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td><table width="100%" border="0">
          <tr class="barras">
            <td>&nbsp;</td>
            <td width="150"><strong>Total Reingresos</strong></td>
            <td><strong>Detalle </strong></td>
          </tr>
          <tr>
            <td width="10" class="barras">&nbsp;</td>
            <td class="superior"><?php echo $row_obtener_hr['nreingresos']; ?><br />
                <br /></td>
            <td>
			
			<?php 
			$codigo=explode("-",$_GET['cod']);
			if ($codigo[0]==$_SESSION['cod_dep'])
			{
			echo "Se ha detectado un Reingreso....Se adicionara en el registro como (1) reingreso mas.<br>" ;
			echo $row_obtener_hr['reingresos']; 
			}else
			{
			 echo "Sin novedad...";
			}
			
			?></td>
          </tr>

</table></td>
    </tr>
  </table>

<?php } // Show if recordset not empty ?>
<?php if ($totalRows_obtener_hr == 0) { // Show if recordset empty ?>
<br />
<table width="100%" border="0">
  <tr>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>No hay HOJA DE RUTA 
      <label>
      <input type="button" name="button" id="button" value="Cerrar" onclick="window.close();"/>
      </label></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    </tr>
</table>

<?php } // Show if recordset empty ?>
<input type="hidden" name="MM_insert" value="form1" />
<input type="hidden" name="MM_insert" value="form1" />
<input type="hidden" name="MM_update" value="form1" />
</form>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {isRequired:false});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "integer");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
//-->
</script>
</body>
</html>
<?php
mysql_free_result($obtener_hr);

mysql_free_result($cumpas);
?>
