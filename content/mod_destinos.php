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
<link href="css/theme_variables.css?v=15" rel="stylesheet" type="text/css" />
<script src="js/theme_switcher.js?v=12" type="text/javascript"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Modificar Destinatario</title>
<style type="text/css">
html, body {
     background-color: #1a080c !important;
     color: #e2e8f0 !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     margin: 0 !important;
     padding: 14px 16px !important;
     box-sizing: border-box !important;
}

form[name="form"] table,
form[name="form"] tr,
form[name="form"] td {
     background-color: transparent !important;
     border-color: transparent !important;
}

form[name="form"] tr.titulos td,
.titulos {
     background: linear-gradient(135deg, #50000e 0%, #780016 100%) !important;
     color: #ffffff !important;
     font-size: 13px !important;
     font-weight: 800 !important;
     text-transform: uppercase !important;
     letter-spacing: 0.6px !important;
     border: 1px solid rgba(180, 138, 40, 0.45) !important;
     border-bottom: 2px solid #b48a28 !important;
     border-radius: 8px !important;
     padding: 11px 16px !important;
     box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3) !important;
}

form[name="form"] table.celdas {
     background-color: #280d14 !important;
     border: 1px solid rgba(180, 138, 40, 0.35) !important;
     border-radius: 8px !important;
     box-shadow: 0 6px 18px rgba(0, 0, 0, 0.4) !important;
     padding: 10px 16px !important;
     width: 100% !important;
     box-sizing: border-box !important;
     border-collapse: separate !important;
     border-spacing: 0 !important;
     margin-top: 8px !important;
}

form[name="form"] table.celdas > tbody > tr > td,
form[name="form"] table.celdas > tr > td {
     padding: 8px 10px !important;
     border-bottom: 1px solid rgba(255, 255, 255, 0.06) !important;
     color: #e2e8f0 !important;
     font-size: 12px !important;
     font-weight: 700 !important;
     vertical-align: middle !important;
}

form[name="form"] table.celdas > tbody > tr:last-child > td,
form[name="form"] table.celdas > tr:last-child > td {
     border-bottom: none !important;
}

form[name="form"] table.celdas > tbody > tr > td:first-child,
form[name="form"] table.celdas > tr > td:first-child {
     width: 155px !important;
     text-transform: uppercase !important;
     font-size: 11px !important;
     letter-spacing: 0.5px !important;
}

form[name="form"] input[type="text"],
form[name="form"] select,
form[name="form"] textarea {
     background-color: #140508 !important;
     border: 1px solid rgba(180, 138, 40, 0.32) !important;
     border-radius: 6px !important;
     color: #ffffff !important;
     padding: 7px 11px !important;
     font-size: 13px !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     outline: none !important;
     box-sizing: border-box !important;
}

form[name="form"] tr.botones > td {
     background-color: #280d14 !important;
     border: 1px solid rgba(180, 138, 40, 0.32) !important;
     border-radius: 8px !important;
     padding: 10px 14px !important;
}

.aviso {
     background-color: rgba(180, 138, 40, 0.14) !important;
     border: 1px solid rgba(180, 138, 40, 0.38) !important;
     border-radius: 6px !important;
     padding: 8px 12px !important;
     color: #f8fafc !important;
     font-size: 11px !important;
     font-weight: 700 !important;
}

.botones1 {
     background: linear-gradient(135deg, #780016 0%, #a81c33 100%) !important;
     color: #ffffff !important;
     border: 1px solid rgba(180, 138, 40, 0.45) !important;
     border-radius: 6px !important;
     padding: 6px 12px !important;
     font-weight: 700 !important;
     font-size: 11px !important;
     cursor: pointer !important;
     height: auto !important;
}

form[name="form"] input#button2 {
     background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
     color: #ffffff !important;
     border: none !important;
     border-radius: 6px !important;
     padding: 8px 14px !important;
     font-weight: 800 !important;
     font-size: 11px !important;
     text-transform: uppercase !important;
     cursor: pointer !important;
}

form[name="form"] input#button {
     background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
     color: #ffffff !important;
     border: none !important;
     border-radius: 6px !important;
     padding: 8px 14px !important;
     font-weight: 800 !important;
     font-size: 11px !important;
     text-transform: uppercase !important;
     cursor: pointer !important;
}

.dep_destino {
     text-transform: uppercase;
}

/* MODO CLARO */
html[data-theme="light"],
html[data-theme="light"] body,
:root:not([data-theme="dark"]),
:root:not([data-theme="dark"]) body {
     background-color: #f1f5f9 !important;
     color: #1e293b !important;
}

html[data-theme="light"] form[name="form"] table td,
:root:not([data-theme="dark"]) form[name="form"] table td {
     background-color: transparent !important;
}

html[data-theme="light"] form[name="form"] tr.titulos td,
:root:not([data-theme="dark"]) form[name="form"] tr.titulos td {
     background: linear-gradient(135deg, #50000e 0%, #780016 100%) !important;
     color: #ffffff !important;
}

html[data-theme="light"] form[name="form"] table.celdas,
html[data-theme="light"] form[name="form"] tr.botones > td,
:root:not([data-theme="dark"]) form[name="form"] table.celdas,
:root:not([data-theme="dark"]) form[name="form"] tr.botones > td {
     background-color: #ffffff !important;
     border: 1px solid rgba(104, 0, 20, 0.22) !important;
     box-shadow: 0 6px 20px rgba(80, 0, 14, 0.07) !important;
}

html[data-theme="light"] form[name="form"] table.celdas td,
:root:not([data-theme="dark"]) form[name="form"] table.celdas td {
     color: #1e293b !important;
     border-bottom: 1px solid #e2e8f0 !important;
}

html[data-theme="light"] form[name="form"] table.celdas > tbody > tr > td:first-child,
:root:not([data-theme="dark"]) form[name="form"] table.celdas > tbody > tr > td:first-child {
     color: #50000e !important;
     font-weight: 800 !important;
}

html[data-theme="light"] form[name="form"] input[type="text"],
html[data-theme="light"] form[name="form"] select,
html[data-theme="light"] form[name="form"] textarea,
:root:not([data-theme="dark"]) form[name="form"] input[type="text"],
:root:not([data-theme="dark"]) form[name="form"] select,
:root:not([data-theme="dark"]) form[name="form"] textarea {
     background-color: #f8fafc !important;
     border: 1.5px solid #cbd5e1 !important;
     color: #0f172a !important;
     font-weight: 600 !important;
}

html[data-theme="light"] .aviso,
:root:not([data-theme="dark"]) .aviso {
     background-color: #fffbeb !important;
     border: 1px solid #f59e0b !important;
     color: #78350f !important;
}
</style>
<script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0 - Centrado Automatico SIGAPO
  var featStr = (typeof features === 'string' && features.length > 0) ? features : 'menubar=yes,scrollbars=yes,resizable=yes,width=850,height=550';
  var wMatch = featStr.match(/width\s*=\s*(\d+)/i);
  var hMatch = featStr.match(/height\s*=\s*(\d+)/i);
  var w = wMatch ? parseInt(wMatch[1], 10) : 850;
  var h = hMatch ? parseInt(hMatch[1], 10) : 550;
  var availW = (window.screen && (window.screen.availWidth || window.screen.width)) || 1366;
  var availH = (window.screen && (window.screen.availHeight || window.screen.height)) || 768;
  var left = Math.max(0, Math.round((availW - w) / 2));
  var top  = Math.max(0, Math.round((availH - h) / 2));
  var parts = featStr.split(',');
  var clean = [];
  for (var i = 0; i < parts.length; i++) {
    var p = parts[i].replace(/^\s+|\s+$/g, '');
    if (!p || /^(left|top|screenX|screenY)\s*=/i.test(p)) continue;
    clean.push(p);
  }
  clean.push('left=' + left);
  clean.push('top=' + top);
  var win = window.open(theURL, winName || '', clean.join(','));
  if (win) { try { win.moveTo(left, top); win.focus(); } catch(e) {} }
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
