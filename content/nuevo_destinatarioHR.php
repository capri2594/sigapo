<?php 
session_name("LoginSIRC");
session_start();
$cod_dep=$_SESSION['cod_dep'];
?>
<?php require_once('../Connections/snet.php'); ?>
<?php
date_default_timezone_set("America/La_Paz"); 
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
                       GetSQLValueString($_POST['usuario_actual'], "text"),
                       GetSQLValueString($_POST['fecha_derivacion'], "date"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($insertSQL, $snet) or die(mysql_error());
  $salidas_id=mysql_insert_id();
}
if(($_POST['seg_f_destino']=="")&&($_POST['seg_d_destino']=="")&&($_POST['mensaje']=="")) 
	$_POST['cod_depderivador']="";
	
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO derivacion (hojaruta_cod, nro_destino, fun_destino, dep_destino, fecha_derivacion, proveido, mensaje, fun_derivador, cod_depderivador, usuario_derivador, salidas_id, nhojas, anexos) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['hojaruta'], "text"),
                       GetSQLValueString($_POST['ndestino'], "int"),
                       GetSQLValueString($_POST['seg_f_destino'], "text"),
                       GetSQLValueString($_POST['seg_d_destino'], "text"),
                       GetSQLValueString($_POST['fecha_derivacion'], "date"),
                       GetSQLValueString($_POST['objeto'], "text"),
                       GetSQLValueString($_POST['mensaje'], "text"),
                       GetSQLValueString($_POST['fun_proveido'], "text"),
                       GetSQLValueString($_POST['cod_depderivador'], "text"),
                       GetSQLValueString($_POST['usuario_actual'], "text"),
                       GetSQLValueString($salidas_id, "int"),
					    GetSQLValueString($_POST['hojas'], "int"),
					   GetSQLValueString($_POST['anexos'], "text")
					   );

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($insertSQL, $snet) or die(mysql_error());
}

if ($row_num_destinos['cont_destinos']>1){
		$estado="EN PROCESO";
} else {
		$estado="NO REVISADO";
}


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE hojaruta SET cont_destinos=%s, estado=%s WHERE cod=%s",
                       GetSQLValueString($_POST['ndestino'], "int"),
                       GetSQLValueString($estado, "text"),
                       GetSQLValueString($_POST['hojaruta'], "text"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($updateSQL, $snet) or die(mysql_error());
  
  //$updateGoTo = "cerrar_ventana";
  if (isset($_SERVER['QUERY_STRING'])) {
    //$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    //$updateGoTo .= $_SERVER['QUERY_STRING'];
	//header("Refresh:1; url=");
	echo "procesdo terminado exitosamente, se han realizado los cambios.";
	?>
    <script>
	window.opener.self.location.reload();
	window.close();
    </script>
	<?php
    
	exit(0);	
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$codigo_num_destinos = "-1";
if (isset($_GET['cod'])) {
  $codigo_num_destinos = $_GET['cod'];
}
mysql_select_db($database_snet, $snet);
$query_num_destinos = sprintf("SELECT hojaruta.cont_destinos, hojaruta.nhojas, hojaruta.nanexos FROM hojaruta WHERE hojaruta.cod=%s", GetSQLValueString($codigo_num_destinos, "text"));
$num_destinos = mysql_query($query_num_destinos, $snet) or die(mysql_error());
$row_num_destinos = mysql_fetch_assoc($num_destinos);
$totalRows_num_destinos = mysql_num_rows($num_destinos);

mysql_select_db($database_snet, $snet);
$query_objetos = "SELECT * FROM motivo";
$objetos = mysql_query($query_objetos, $snet) or die(mysql_error());
$row_objetos = mysql_fetch_assoc($objetos);
$totalRows_objetos = mysql_num_rows($objetos);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:: AGREGAR-destinatario ::.</title>
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
	background-color: #FFCC33;
	height: 15px;
	width: 100px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #000000;
}
.aviso {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #003366;
	border: 1px solid #000099;
	background-color: #FFFFE8;
	background-image: url(imagen/b_tipp.png);
	background-repeat: no-repeat;
	background-position: left center;
	padding-left: 25px;
}
.procesado {
	background-color: #9AE7B3;
	height: 15px;
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
.dep_destino {
	text-transform: uppercase;
}
.buscar {
	background-image: url(imagen/icono_buscar0.gif);
	padding-left: 25px;
	background-repeat: no-repeat;
	background-position: left center;
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
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.botones1 {font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	height: 20px;
}
-->
</style>
<script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/scriptaculous/prototype.js"></script>
<script type="text/javascript" src="js/scriptaculous/scriptaculous.js"></script>
<script type="text/javascript" src="js/scriptaculous/effects.js"></script>
<link href="css/autocontempler.css" rel="stylesheet" type="text/css" />
</head>

<body onUnload="window.opener.self.location.reload();">
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="100%" border="0">
    <tr class="titulos">
      <td height="30">:: Agregar Nuevo Destinatario (HOJA DE RUTA: <?php echo $_GET['cod']; ?>)
      <input name="hojaruta" type="hidden" id="hojaruta" value="<?php echo $_GET['cod']; ?>" /></td>
    </tr>
    <tr>
      <td><table width="100%" border="0" class="celdas">
          <tr>
            <td>No. Destinatario</td>
            <td bgcolor="#FFFFFF"><input name="ndestino" type="hidden" id="ndestino" value="<?php echo $row_num_destinos['cont_destinos']+1; ?>" />
            <?php echo $row_num_destinos['cont_destinos']+1; ?></td>
          </tr>
          <tr>
            <td>Para:</td>
            <td bgcolor="#FFFFFF"><span id="sprytextfield1">
              <label>
              <input name="seg_f_destino" type="text" id="seg_f_destino" size="46" />
              <div id="lista_opciones" class="autocomplete" ></div>
              </label>
              <span class="textfieldRequiredMsg">Se necesita un valor.</span></span>
                      
                  <script type="text/javascript">
					new Ajax.Autocompleter("seg_f_destino", "lista_opciones", "ajax/funcionarios.php", {
method: "post",
paramName: "nombre",
indicator: "preload"});

    			</script>
                              <span id="preload" style="display: none; position:absolute; z-index:3;" >
  <img src="imagen/loading.gif" alt="Cargando..." /><span class="Estilo1">Cargando...</span>
</span>
              </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td bgcolor="#FFFFFF"><span id="sprytextfield2">
              <label>
              <input name="seg_d_destino" type="text" class="dep_destino" id="seg_d_destino" size="46" />                  <script type="text/javascript">
					new Ajax.Autocompleter("seg_d_destino", "lista_opciones", "ajax/cod_dep.php", {
method: "post",
paramName: "nombre",
indicator: "preload"});

    			</script>
              </label>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span>
            <input name="button5" type="button" class="buscar" id="button5" onClick="MM_openBrWindow('insert_fun_Destino3.php','','width=620,height=315,left=300,top=150')" value="BUSCAR" /></td>
          </tr>
          <tr>
            <td>            Objeto </td>
            <td bgcolor="#FFFFFF"><label><span id="spryselect1">
            <select name="objeto" id="objeto">
              <?php
do {  
?>
              <option value="<?php echo $row_objetos['motivos']?>"><?php echo $row_objetos['motivos']?></option>
              <?php
} while ($row_objetos = mysql_fetch_assoc($objetos));
  $rows = mysql_num_rows($objetos);
  if($rows > 0) {
      mysql_data_seek($objetos, 0);
	  $row_objetos = mysql_fetch_assoc($objetos);
  }
?>
            </select>
            <span class="selectRequiredMsg">Seleccione un elemento.</span></span></label></td>
          </tr>
          <tr>
            <td>Instruccion Adicional</td>
            <td bgcolor="#FFFFFF"><label>
              <textarea name="mensaje" id="mensaje" cols="45" rows="5"></textarea>
            </label></td>
          </tr>
          <tr>
            <td>Firma Proveido</td>
            <td bgcolor="#FFFFFF">
              <table width="100%" border="0">
                <tr>
                  <td><span id="sprytextfield4">
                    <label>
                    <input name="fun_proveido" type="text" id="fun_proveido" value="<?php echo htmlentities($_SESSION['fun']); ?>" size="40" />
                    <script type="text/javascript">
					new Ajax.Autocompleter("fun_proveido", "lista_opciones", "ajax/funcionarios.php", {
method: "post",
paramName: "nombre",
indicator: "preload"});

    			</script>
                    </label>
                  <span class="textfieldRequiredMsg">X.</span></span></td>
                  <td>Hojas</td>
                  <td><span id="sprytextfield3">
                    <label>
                    <input name="hojas" type="text" id="hojas" value="<?php echo $row_num_destinos['nhojas']; ?>" size="15" />
                    </label>
                  <span class="textfieldRequiredMsg">X.</span></span></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td>Fecha de la derivacion:</td>
            <td bgcolor="#FFFFFF"><table width="100%" border="0">
              <tr>
                <td><span id="sprytextfield5">
                <label>
                <input name="fecha_derivacion" type="text" id="fecha_derivacion" value="<?php echo date("Y-m-d H:i:s");?>" size="25"  <?php /*if($_SESSION['cod_dep']!="ACBS"){ */?>readonly="readonly"<?php /*}*/?>/>
                </label>
                <span class="textfieldRequiredMsg">Se necesita un valor.</span></span>
                  <input name="usuario_actual" type="hidden" id="usuario_actual" value="<?php echo $_SESSION['user']; ?>" />
                  <input name="cod_depderivador" type="hidden" id="cod_depderivador" value="<?php echo $_SESSION['cod_dep']; ?>" /></td>
                <td>Anexos</td>
                <td><span id="sprytextarea1">
                  <label>
                  <textarea name="anexos" id="anexos" cols="20" rows="2"><?php echo $row_num_destinos['nanexos']; ?></textarea>
                  </label>
                  </span></td>
              </tr>

            </table></td>
          </tr>
</table></td>
    </tr>
    <tr class="botones">
      <td><table width="100%" border="0">
        <tr>
          <td><input name="estado" type="hidden" id="estado" value="NO REVISADO" />
          <input name="estado_E_P" type="hidden" id="estado_E_P" value="EN PROCESO" />
            <input name="estado_RI" type="hidden" id="estado_RI" value="REINGRESADO" />
            <div class="aviso">El Sistema marcará ahora en adelante la fecha de derivacion. GRACIAS</div></td>
          <td width="150"><label>
            <input type="submit" name="button2" id="button2" value="Crear Destinatario" />
          </label></td>
          <td width="100">
          <!--<label>
            <input type="button" name="button" id="button" value="Terminar Adicion" onClick="window.opener.self.location.reload();window.close();"/>
          </label>-->
          </td>
        </tr>

      </table></td>
    </tr>
    <tr>
      <td><table width="100%" border="0" class="celdas">
      </table></td>
    </tr>
  </table>
    <input type="hidden" name="MM_insert" value="form1" />
    <input type="hidden" name="MM_update" value="form1" />
</form>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {isRequired:false});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($num_destinos);

mysql_free_result($objetos);
?>
