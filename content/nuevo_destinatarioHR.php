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
  
  if (isset($_SERVER['QUERY_STRING'])) {
	echo "proceso terminado exitosamente, se han realizado los cambios.";
	?>
    <script>
	window.opener.self.location.reload();
	window.close();
    </script>
	<?php
	exit(0);	
  }
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:: AGREGAR-destinatario ::.</title>
<style type="text/css">
body {
     background-color: #0f172a !important;
     color: #cbd5e1 !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     margin: 15px !important;
     padding: 0 !important;
}

/* Header style override */
.titulos {
     background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%) !important;
     color: #ffffff !important;
     font-size: 13px !important;
     font-weight: 700 !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     border-radius: 6px !important;
     padding: 10px 14px !important;
     box-shadow: 0 4px 10px rgba(0,0,0,0.3) !important;
     display: block !important;
     margin-bottom: 12px !important;
}

/* Card layout wrapper */
.celdas {
     background-color: #1e293b !important;
     border: 1px solid rgba(255, 255, 255, 0.1) !important;
     border-radius: 8px !important;
     box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4) !important;
     padding: 15px !important;
     width: 100% !important;
     box-sizing: border-box !important;
     border-collapse: separate !important;
     border-spacing: 0 8px !important;
}

/* Row labels */
.celdas td:first-child {
     color: #94a3b8 !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     width: 150px !important;
     vertical-align: middle !important;
}

.celdas td {
     padding: 4px 8px !important;
}

/* Inputs, Textareas and Dropdowns styling */
input[type="text"], select, textarea {
     background-color: rgba(15, 23, 42, 0.6) !important;
     border: 1px solid rgba(255, 255, 255, 0.1) !important;
     border-radius: 6px !important;
     color: #ffffff !important;
     padding: 6px 10px !important;
     font-size: 13px !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     outline: none !important;
     box-sizing: border-box !important;
     transition: all 0.2s !important;
}

input[type="text"]:focus, select:focus, textarea:focus {
     border-color: #2563eb !important;
     box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2) !important;
}

input[readonly="readonly"] {
     background-color: rgba(15, 23, 42, 0.3) !important;
     color: #94a3b8 !important;
     border-color: rgba(255, 255, 255, 0.05) !important;
     cursor: not-allowed !important;
}

/* Unique ID/No Destinatario design */
span.n-destino {
     font-size: 15px !important;
     font-weight: 800 !important;
     color: #ffffff !important;
     font-family: monospace, sans-serif !important;
}

/* Search Button */
input.buscar {
     background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
     color: #ffffff !important;
     border: none !important;
     border-radius: 4px !important;
     padding: 6px 14px !important;
     font-weight: 700 !important;
     cursor: pointer !important;
     font-size: 10px !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     box-shadow: 0 2px 6px rgba(37, 99, 235, 0.3) !important;
     transition: all 0.2s !important;
     margin-left: 8px !important;
}

input.buscar:hover {
     box-shadow: 0 4px 10px rgba(37, 99, 235, 0.4) !important;
     transform: translateY(-1px) !important;
}

/* Notice Banner */
.aviso-container {
     background-color: rgba(245, 158, 11, 0.1) !important;
     border: 1px solid rgba(245, 158, 11, 0.25) !important;
     border-radius: 6px !important;
     padding: 10px 14px !important;
     display: flex !important;
     align-items: center !important;
}

.aviso-text {
     color: #f59e0b !important;
     font-size: 11px !important;
     font-weight: 600 !important;
     margin-left: 8px !important;
}

/* Submit row wrapper */
.footer-row {
     background-color: rgba(15, 23, 42, 0.3) !important;
     border: 1px solid rgba(255, 255, 255, 0.05) !important;
     border-radius: 8px !important;
     padding: 15px !important;
     margin-top: 15px !important;
     box-sizing: border-box !important;
}

/* Create Button */
input#button2 {
     background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
     color: #ffffff !important;
     border: none !important;
     border-radius: 6px !important;
     padding: 8px 18px !important;
     font-weight: 700 !important;
     cursor: pointer !important;
     font-size: 11px !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3) !important;
     transition: all 0.2s !important;
}

input#button2:hover {
     box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4) !important;
     transform: translateY(-1px) !important;
}

/* Spry error hidden classes */
.textfieldRequiredMsg, .selectRequiredMsg {
     display: none !important;
}

/* Autocomplete list styling */
div.autocomplete {
     position: absolute;
     width: 320px !important;
     background-color: #1e293b !important;
     border: 1px solid rgba(255, 255, 255, 0.1) !important;
     border-radius: 6px !important;
     box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5) !important;
     margin: 0px !important;
     padding: 0px !important;
     list-style-type: none !important;
     z-index: 100 !important;
}

div.autocomplete ul {
     list-style-type: none !important;
     margin: 0 !important;
     padding: 0 !important;
}

div.autocomplete li {
     list-style-type: none !important;
     display: block !important;
     margin: 0 !important;
     padding: 6px 12px !important;
     cursor: pointer !important;
     color: #cbd5e1 !important;
     font-size: 12px !important;
     border-bottom: 1px solid rgba(255, 255, 255, 0.02) !important;
}

div.autocomplete li.selected {
     background-color: #2563eb !important;
     color: #ffffff !important;
}
</style>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function MM_openBrWindow(theURL,winName,features) { 
  window.open(theURL,winName,features);
}
</script>
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/scriptaculous/prototype.js"></script>
<script type="text/javascript" src="js/scriptaculous/scriptaculous.js"></script>
<script type="text/javascript" src="js/scriptaculous/effects.js"></script>
<link href="css/autocontempler.css" rel="stylesheet" type="text/css" />
</head>

<body onUnload="window.opener.self.location.reload();">
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="titulos">
        :: Agregar Nuevo Destinatario (HOJA DE RUTA: <?php echo htmlentities($_GET['cod']); ?>)
        <input name="hojaruta" type="hidden" id="hojaruta" value="<?php echo $_GET['cod']; ?>" />
      </td>
    </tr>
    <tr>
      <td>
        <table class="celdas" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>No. Destinatario</td>
            <td>
              <input name="ndestino" type="hidden" id="ndestino" value="<?php echo $row_num_destinos['cont_destinos']+1; ?>" />
              <span class="n-destino"><?php echo $row_num_destinos['cont_destinos']+1; ?></span>
            </td>
          </tr>
          <tr>
            <td>Para:</td>
            <td>
              <span id="sprytextfield1">
                <input name="seg_f_destino" type="text" id="seg_f_destino" style="width: 320px;" placeholder="Escribe el nombre del funcionario..." />
                <div id="lista_opciones" class="autocomplete"></div>
                <span class="textfieldRequiredMsg">Se necesita un valor.</span>
              </span>
              <script type="text/javascript">
                new Ajax.Autocompleter("seg_f_destino", "lista_opciones", "ajax/funcionarios.php", {
                  method: "post",
                  paramName: "nombre",
                  indicator: "preload"
                });
              </script>
              <span id="preload" style="display: none; position:absolute; z-index:3;" >
                <img src="imagen/loading.gif" alt="Cargando..." /><span style="color:#3b82f6; font-size:11px; margin-left:5px;">Cargando...</span>
              </span>
            </td>
          </tr>
          <tr>
            <td>Sigla Destino:</td>
            <td>
              <span id="sprytextfield2">
                <input name="seg_d_destino" type="text" class="dep_destino" id="seg_d_destino" style="width: 320px;" placeholder="Escribe la sigla del destino..." />
                <script type="text/javascript">
                  new Ajax.Autocompleter("seg_d_destino", "lista_opciones", "ajax/cod_dep.php", {
                    method: "post",
                    paramName: "nombre",
                    indicator: "preload"
                  });
                </script>
                <span class="textfieldRequiredMsg">Se necesita un valor.</span>
              </span>
              <input name="button5" type="button" class="buscar" id="button5" onClick="MM_openBrWindow('insert_fun_Destino3.php','','width=620,height=315,left=300,top=150')" value="BUSCAR" />
            </td>
          </tr>
          <tr>
            <td>Objeto:</td>
            <td>
              <span id="spryselect1">
                <select name="objeto" id="objeto" style="width: 320px;">
                  <?php do { ?>
                    <option value="<?php echo $row_objetos['motivos']?>"><?php echo $row_objetos['motivos']?></option>
                  <?php } while ($row_objetos = mysql_fetch_assoc($objetos));
                    $rows = mysql_num_rows($objetos);
                    if($rows > 0) {
                        mysql_data_seek($objetos, 0);
                        $row_objetos = mysql_fetch_assoc($objetos);
                    }
                  ?>
                </select>
                <span class="selectRequiredMsg">Seleccione un elemento.</span>
              </span>
            </td>
          </tr>
          <tr>
            <td>Instrucción Adicional:</td>
            <td>
              <textarea name="mensaje" id="mensaje" style="width: 100%; max-width: 500px;" rows="4" placeholder="Escribe instrucciones adicionales..."></textarea>
            </td>
          </tr>
          <tr>
            <td>Firma Proveído:</td>
            <td>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td>
                    <span id="sprytextfield4">
                      <input name="fun_proveido" type="text" id="fun_proveido" value="<?php echo htmlentities($_SESSION['fun']); ?>" style="width: 250px;" />
                      <script type="text/javascript">
                        new Ajax.Autocompleter("fun_proveido", "lista_opciones", "ajax/funcionarios.php", {
                          method: "post",
                          paramName: "nombre",
                          indicator: "preload"
                        });
                      </script>
                      <span class="textfieldRequiredMsg">X.</span>
                    </span>
                  </td>
                  <td width="60" style="color: #94a3b8 !important; font-size: 10px !important; font-weight: 700 !important; text-transform: uppercase !important; letter-spacing: 0.5px !important; text-align: center;">Hojas:</td>
                  <td>
                    <span id="sprytextfield3">
                      <input name="hojas" type="text" id="hojas" value="<?php echo $row_num_destinos['nhojas']; ?>" style="width: 80px; text-align: center;" />
                      <span class="textfieldRequiredMsg">X.</span>
                    </span>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td>Fecha Derivación:</td>
            <td>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td>
                    <span id="sprytextfield5">
                      <input name="fecha_derivacion" type="text" id="fecha_derivacion" value="<?php echo date("Y-m-d H:i:s");?>" style="width: 250px;" readonly="readonly" />
                      <span class="textfieldRequiredMsg">Se necesita un valor.</span>
                    </span>
                    <input name="usuario_actual" type="hidden" id="usuario_actual" value="<?php echo $_SESSION['user']; ?>" />
                    <input name="cod_depderivador" type="hidden" id="cod_depderivador" value="<?php echo $_SESSION['cod_dep']; ?>" />
                  </td>
                  <td width="60" style="color: #94a3b8 !important; font-size: 10px !important; font-weight: 700 !important; text-transform: uppercase !important; letter-spacing: 0.5px !important; text-align: center;">Anexos:</td>
                  <td>
                    <span id="sprytextarea1">
                      <textarea name="anexos" id="anexos" style="width: 100%;" rows="2"><?php echo htmlentities($row_num_destinos['nanexos']); ?></textarea>
                    </span>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    
    <!-- Footer / Button row -->
    <tr>
      <td>
        <table class="footer-row" width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>
              <input name="estado" type="hidden" id="estado" value="NO REVISADO" />
              <input name="estado_E_P" type="hidden" id="estado_E_P" value="EN PROCESO" />
              <input name="estado_RI" type="hidden" id="estado_RI" value="REINGRESADO" />
              <div class="aviso-container">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                     <circle cx="12" cy="12" r="10"></circle>
                     <line x1="12" y1="8" x2="12" y2="12"></line>
                     <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
                <div class="aviso-text">El sistema registrará automáticamente la fecha y hora de derivación.</div>
              </div>
            </td>
            <td width="160" style="text-align: right;">
              <input type="submit" name="button2" id="button2" value="Crear Destinatario" />
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
  <input type="hidden" name="MM_update" value="form1" />
</form>

<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {isRequired:false});
</script>
</body>
</html>
<?php
mysql_free_result($num_destinos);
mysql_free_result($objetos);
?>
