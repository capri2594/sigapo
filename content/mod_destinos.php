<?php 
session_name("LoginSIRC");
session_start();
$cod_dep=$_SESSION['cod_dep'];
date_default_timezone_set("America/La_Paz");
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

if(($_POST['seg_f_destino']=="")&&($_POST['seg_d_destino']=="")&&($_POST['mensaje']=="")) 
	$_POST['cod_depderivador']="";
		
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form")) {
  $updateSQL = sprintf("UPDATE derivacion SET fun_destino=%s, dep_destino=%s, fecha_derivacion=%s, proveido=%s, mensaje=%s, nhojas=%s, anexos=%s, cod_depderivador=%s, fun_derivador=%s WHERE id=%s AND hojaruta_cod=%s",
                       GetSQLValueString($_POST['seg_f_destino'], "text"),
                       GetSQLValueString($_POST['seg_d_destino'], "text"),
                       GetSQLValueString($_POST['fecha_derivacion'], "date"),
                       GetSQLValueString($_POST['objeto'], "text"),
                       GetSQLValueString($_POST['mensaje'], "text"),
                       GetSQLValueString($_POST['hojas'], "int"),
                       GetSQLValueString($_POST['anexos'], "text"),
                       GetSQLValueString($_POST['cod_depderivador'], "text"),
					   GetSQLValueString($_POST['fun_proveido'], "text"),
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['hojaruta_cod'], "text"));

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

$colname_ver_destinatario = "-1";
if (isset($_GET['id'])) {
  $colname_ver_destinatario = $_GET['id'];
}
mysql_select_db($database_snet, $snet);
$query_ver_destinatario = sprintf("SELECT * FROM derivacion WHERE id = %s", GetSQLValueString($colname_ver_destinatario, "int"));
$ver_destinatario = mysql_query($query_ver_destinatario, $snet) or die(mysql_error());
$row_ver_destinatario = mysql_fetch_assoc($ver_destinatario);
$totalRows_ver_destinatario = mysql_num_rows($ver_destinatario);

mysql_select_db($database_snet, $snet);
$query_objetos = "SELECT * FROM motivo";
$objetos = mysql_query($query_objetos, $snet) or die(mysql_error());
$row_objetos = mysql_fetch_assoc($objetos);
$totalRows_objetos = mysql_num_rows($objetos);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Modificar Destinatario</title>
<style type="text/css">
<!--
.botones {	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #333333;
	background-color: #CAD2DB;
	border: 1px solid #FFFFFF;
}
.botones1 {font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	height: 20px;
}
.celdas {	font-family: Arial, Helvetica, sans-serif;
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
.titulos {	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #FFFFFF;
	background-color: #6B7A9D;
	border: 1px solid #FFFFFF;
}
.dep_destino {
	text-transform: uppercase;
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
<script type="text/javascript" src="js/scriptaculous/prototype.js"></script>
<script type="text/javascript" src="js/scriptaculous/scriptaculous.js"></script>
<script type="text/javascript" src="js/scriptaculous/effects.js"></script>
<link href="css/autocontempler.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form name="form" action="<?php echo $editFormAction; ?>" method="POST"><table width="100%" border="0">
  <tr class="titulos">
    <td height="30">:: Agregar Nuevo Destinatario (HOJA DE RUTA: <?php echo $row_ver_destinatario['hojaruta_cod']; ?>)
    <input name="hojaruta_cod" type="hidden" id="hojaruta_cod" value="<?php echo $_GET['cod']; ?>" />
    <input name="id" type="hidden" id="id" value="<?php echo $_GET['id']; ?>"  /></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" class="celdas">
      <tr>
        <td>No. Destinatario</td>
        <td bgcolor="#FFFFFF"><input name="ndestino" type="hidden" id="ndestino" value="<?php echo $row_ver_destinatario['nro_destino']; ?>" />
              <?php echo $row_ver_destinatario['nro_destino']; ?></td>
      </tr>
      <tr>
        <td>Para:</td>
        <td bgcolor="#FFFFFF"><span id="sprytextfield1">
          <label>
            <input name="seg_f_destino" type="text" id="seg_f_destino" value="<?php echo $row_ver_destinatario['fun_destino']; ?>" size="46" />
            <div id="lista_opciones" class="autocomplete" ></div>
          </label>
        </span>
        <script type="text/javascript">
        					new Ajax.Autocompleter("seg_f_destino", "lista_opciones", "ajax/funcionarios.php", {
method: "post",
paramName: "nombre"});

    			</script></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td bgcolor="#FFFFFF"><span id="sprytextfield2">
          <label>
            <input name="seg_d_destino" type="text" class="dep_destino" id="seg_d_destino" value="<?php echo $row_ver_destinatario['dep_destino']; ?>" size="46" />
          </label>
        </span>
           <script type="text/javascript">
					new Ajax.Autocompleter("seg_d_destino", "lista_opciones", "ajax/cod_dep.php", {
method: "post",
paramName: "nombre"});

    			</script>
              <input name="button5" type="button" class="botones1" id="button5" onClick="MM_openBrWindow('insert_fun_Destino3.php','','width=620,height=315')" value="BUSCAR" /></td>
      </tr>
      <tr>
        <td> Objeto </td>
        <td bgcolor="#FFFFFF"><label><span id="spryselect1">
          <select name="objeto" id="objeto" title="<?php echo $row_ver_destinatario['proveido']; ?>">
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
        </span></label></td>
      </tr>
      <tr>
        <td>Instruccion Adicional</td>
        <td bgcolor="#FFFFFF"><label>
          <textarea name="mensaje" id="mensaje" cols="45" rows="5"><?php echo htmlentities($row_ver_destinatario['mensaje']); ?></textarea>
        </label></td>
      </tr>
      <tr>
        <td>Firma Proveido</td>
        <td bgcolor="#FFFFFF"><table width="100%" border="0">
          <tr>
            <td><span id="sprytextfield4">
              <label>
                <input name="fun_proveido" type="text" id="fun_proveido" value="<?php echo $row_ver_destinatario['fun_derivador']; ?>" size="40" />
                </label>
            </span>
            <script type="text/javascript">
					new Ajax.Autocompleter("fun_proveido", "lista_opciones", "ajax/funcionarios.php", {
method: "post",
paramName: "nombre"});

    			</script>
            </td>
            <td>Hojas</td>
            <td><span id="sprytextfield3">
              <label>
                <input name="hojas" type="text" id="hojas" value="<?php echo $row_ver_destinatario['nhojas']; ?>" size="15" />
              </label>
            </span></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>Fecha de la derivacion:</td>
        <td bgcolor="#FFFFFF"><table width="100%" border="0">
          <tr>
            <td><span id="sprytextfield5">
              <label>
                <input name="fecha_derivacion" type="text" id="fecha_derivacion" value="<?php echo $row_ver_destinatario['fecha_derivacion']; ?>" size="25" readonly="READONLY"/>
              </label>
            </span>
                    <input name="usuario_actual" type="hidden" id="usuario_actual" value="<?php echo $_SESSION['user']; ?>" />
                    <input name="cod_depderivador" type="hidden" id="cod_depderivador" value="<?php echo $_SESSION['cod_dep']; ?>" /></td>
            <td>Anexos</td>
            <td><span id="sprytextarea1">
              <label>
                <textarea name="anexos" id="anexos" cols="20" rows="2"><?php echo $row_ver_destinatario['anexos']; ?></textarea>
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
              <div class="aviso">Fecha y Hora no se podra modificar. GRACIAS</div></td>
        <td width="150"><label>
          <input type="submit" name="button2" id="button2" value="Aceptar Cambios" />
        </label></td>
        <td width="100"><label>
          <input type="button" name="button" id="button" value="Cancelar Modificacion" onClick="window.opener.self.location.reload();window.close();"/>
        </label></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" class="celdas">
    </table></td>
  </tr>
</table>
  <input type="hidden" name="MM_update" value="form" />
</form>

</body>
</html>
<?php
mysql_free_result($ver_destinatario);

mysql_free_result($objetos);
?>
