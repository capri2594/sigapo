<?php 
session_name("LoginSIRC");
session_start();
header('Content-Type: text/html; charset=UTF-8');
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE funcionario SET ci=%s, cargo=%s, celular=%s, telefono=%s, email=%s WHERE nombre=%s AND usuario_cuenta=%s AND dependencia_cod=%s",
                       GetSQLValueString($_POST['ci'], "text"),
                       GetSQLValueString($_POST['cargo'], "text"),
                       GetSQLValueString($_POST['celular'], "text"),
                       GetSQLValueString($_POST['telefono'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['usuario_cuenta'], "text"),
                       GetSQLValueString($_POST['dependencia_cod'], "text"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($updateSQL, $snet) or die(mysql_error());

  $updateGoTo = "perfil_datosfun.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$usuario_mis_datos = "-1";
if (isset($_SESSION['user'])) {
  $usuario_mis_datos = $_SESSION['user'];
}
mysql_select_db($database_snet, $snet);
$query_mis_datos = sprintf("SELECT * FROM funcionario WHERE funcionario.usuario_cuenta=%s", GetSQLValueString($usuario_mis_datos, "text"));
$mis_datos = mysql_query($query_mis_datos, $snet) or die(mysql_error());
$row_mis_datos = mysql_fetch_assoc($mis_datos);
$totalRows_mis_datos = mysql_num_rows($mis_datos);

// Resolve avatar path fallback
$avatar = "../perfiles/fotos/" . $_SESSION['user'] . ".jpg";
$real_path = $_SERVER['DOCUMENT_ROOT'] . "/sirc_11/perfiles/fotos/" . $_SESSION['user'] . ".jpg";
if (!file_exists($real_path)) {
     $avatar = "../perfiles/fotos/default_avatar013.jpg";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="css/theme_variables.css" rel="stylesheet" type="text/css" />
<script src="js/theme_switcher.js" type="text/javascript"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Modificar Datos de Usuario</title>
<style type="text/css">
html, body,
html[data-theme="dark"], html[data-theme="dark"] body,
html[data-theme="light"], html[data-theme="light"] body,
:root:not([data-theme="dark"]), :root:not([data-theme="dark"]) body {
     background-color: transparent !important;
     background-image: none !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     margin: 5px !important;
     padding: 0 !important;
}

/* Main outer layout card */
table.main-layout {
     background-color: #1c1a1e !important;
     border: 1px solid rgba(245, 158, 11, 0.28) !important;
     border-radius: 12px !important;
     box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5) !important;
     overflow: hidden !important;
     width: 100% !important;
     border-collapse: collapse !important;
     box-sizing: border-box !important;
}

/* Avatar side panel */
td.avatar-panel {
     width: 130px !important;
     padding: 24px !important;
     vertical-align: top !important;
     background-color: rgba(20, 18, 20, 0.45) !important;
     border-right: 1px solid rgba(255, 255, 255, 0.06) !important;
     text-align: center !important;
}

td.avatar-panel img {
     width: 90px !important;
     height: 90px !important;
     border-radius: 50% !important;
     border: 3px solid #f59e0b !important;
     box-shadow: 0 0 15px rgba(245, 158, 11, 0.35) !important;
     object-fit: cover !important;
     background-color: #121316 !important;
}

/* Center details panel */
td.details-panel {
     padding: 24px !important;
     vertical-align: top !important;
     background-color: transparent !important;
}

td.details-panel table,
td.details-panel tr,
td.details-panel td:not(.section-header) {
     background-color: transparent !important;
}

/* Sub-headers */
td.section-header {
     background: linear-gradient(135deg, #4d000d 0%, #680014 100%) !important;
     border-bottom: 2px solid #f59e0b !important;
     border-radius: 6px !important;
     padding: 8px 12px !important;
}

td.section-header span {
     color: #fde047 !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
}

/* Row Labels */
div.info-label {
     color: #94a3b8 !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     padding-right: 10px !important;
}

/* Form Inputs styling */
.datos {
     background-color: rgba(20, 18, 20, 0.85) !important;
     border: 1px solid rgba(255, 255, 255, 0.14) !important;
     border-radius: 6px !important;
     color: #ffffff !important;
     padding: 6px 10px !important;
     font-size: 13px !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     width: 90% !important;
     outline: none !important;
     box-sizing: border-box !important;
     transition: all 0.2s !important;
}

.datos:focus {
     border-color: #f59e0b !important;
     box-shadow: 0 0 0 2px rgba(245, 158, 11, 0.25) !important;
}

.datos[readonly="readonly"] {
     background-color: rgba(20, 18, 20, 0.45) !important;
     color: #94a3b8 !important;
     border-color: rgba(255, 255, 255, 0.06) !important;
     cursor: not-allowed !important;
}

/* Right sidebar */
td.actions-panel {
     width: 120px !important;
     background-color: rgba(20, 18, 20, 0.45) !important;
     border-left: 1px solid rgba(255, 255, 255, 0.06) !important;
     padding: 24px 16px !important;
     vertical-align: top !important;
     text-align: center !important;
}

/* Sidebar Title label */
td.sidebar-title {
     background: linear-gradient(135deg, #4d000d 0%, #680014 100%) !important;
     border-bottom: 2px solid #f59e0b !important;
     color: #ffffff !important;
     border-radius: 6px !important;
     padding: 10px !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     margin-bottom: 15px !important;
     display: block !important;
     text-align: center !important;
}

/* Action inputs style overrides */
input#aceptar {
     background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
     color: #ffffff !important;
     border: none !important;
     border-radius: 6px !important;
     padding: 8px 16px !important;
     font-weight: 700 !important;
     cursor: pointer !important;
     font-size: 11px !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3) !important;
     transition: all 0.2s !important;
     width: 100% !important;
     margin-bottom: 8px !important;
}

input#aceptar:hover {
     box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4) !important;
     transform: translateY(-1px) !important;
}

input#cancelar {
     background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%) !important;
     color: #ffffff !important;
     border: none !important;
     border-radius: 6px !important;
     padding: 8px 16px !important;
     font-weight: 700 !important;
     cursor: pointer !important;
     font-size: 11px !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     box-shadow: 0 2px 8px rgba(107, 114, 128, 0.3) !important;
     transition: all 0.2s !important;
     width: 100% !important;
}

input#cancelar:hover {
     box-shadow: 0 4px 12px rgba(107, 114, 128, 0.4) !important;
     transform: translateY(-1px) !important;
}

/* Hide default validation alert borders in Spry */
.textfieldRequiredMsg, .textfieldInvalidFormatMsg {
     display: none !important;
}

/* ========================================================
   MODO CLARO (Light Mode Overrides)
   ======================================================== */
html[data-theme="light"] table.main-layout,
:root:not([data-theme="dark"]) table.main-layout {
     background-color: #ffffff !important;
     border: 1px solid rgba(104, 0, 20, 0.2) !important;
     box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08) !important;
}

html[data-theme="light"] td.avatar-panel,
:root:not([data-theme="dark"]) td.avatar-panel {
     background-color: #f8fafc !important;
     border-right: 1px solid #e2e8f0 !important;
}

html[data-theme="light"] td.avatar-panel table,
html[data-theme="light"] td.avatar-panel td,
:root:not([data-theme="dark"]) td.avatar-panel table,
:root:not([data-theme="dark"]) td.avatar-panel td {
     background-color: transparent !important;
}

html[data-theme="light"] td.avatar-panel img,
:root:not([data-theme="dark"]) td.avatar-panel img {
     background-color: #ffffff !important;
     border-color: #680014 !important;
     box-shadow: 0 0 12px rgba(104, 0, 20, 0.2) !important;
}

html[data-theme="light"] td.section-header,
:root:not([data-theme="dark"]) td.section-header {
     background: linear-gradient(135deg, #4d000d 0%, #680014 100%) !important;
     border-bottom: 2px solid #f59e0b !important;
}

html[data-theme="light"] td.section-header span,
:root:not([data-theme="dark"]) td.section-header span {
     color: #ffffff !important;
}

html[data-theme="light"] div.info-label,
:root:not([data-theme="dark"]) div.info-label {
     color: #50000e !important;
}

html[data-theme="light"] .datos,
:root:not([data-theme="dark"]) .datos {
     background-color: #ffffff !important;
     border: 1px solid #cbd5e1 !important;
     color: #18181b !important;
}

html[data-theme="light"] .datos[readonly="readonly"],
:root:not([data-theme="dark"]) .datos[readonly="readonly"] {
     background-color: #f1f5f9 !important;
     border-color: #e2e8f0 !important;
     color: #475569 !important;
}

html[data-theme="light"] td.actions-panel,
:root:not([data-theme="dark"]) td.actions-panel {
     background-color: #f8fafc !important;
     border-left: 1px solid #e2e8f0 !important;
}

html[data-theme="light"] td.actions-panel table,
html[data-theme="light"] td.actions-panel td:not(.sidebar-title),
:root:not([data-theme="dark"]) td.actions-panel table,
:root:not([data-theme="dark"]) td.actions-panel td:not(.sidebar-title) {
     background-color: transparent !important;
}
</style>
<script language="javascript" type="text/javascript">
function carga(){
	self.location.href="perfil_datosfun.php";
}
</script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table class="main-layout" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <!-- Left Avatar Column -->
      <td class="avatar-panel">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>
              <img src="<?php echo $avatar; ?>" alt="Foto de perfil" />
            </td>
          </tr>
        </table>
      </td>
      
      <!-- Central Details Column (Form fields) -->
      <td class="details-panel">
        <table width="100%" border="0" cellspacing="0" cellpadding="3">
          <!-- Section: Datos del Funcionario -->
          <tr>
            <td class="section-header"><span>Datos del Funcionario</span></td>
          </tr>
          <tr>
            <td>
              <table width="100%" border="0" cellspacing="2" cellpadding="5">
                <tr>
                  <td width="100"><div align="right" class="info-label">Nombre:</div></td>
                  <td>
                    <span id="sprytextfield6">
                      <input name="nombre" type="text" class="datos" id="nombre" value="<?php echo htmlentities($row_mis_datos['nombre']); ?>" readonly="readonly" />
                      <span class="textfieldRequiredMsg">Se necesita un valor.</span>
                    </span>
                    <input name="dependencia_cod" type="hidden" id="dependencia_cod" value="<?php echo $_SESSION['cod_dep']; ?>" />
                    <input name="usuario_cuenta" type="hidden" id="usuario_cuenta" value="<?php echo $_SESSION['user']; ?>" />
                  </td>
                </tr>
                <tr>
                  <td width="100"><div align="right" class="info-label">Cargo:</div></td>
                  <td>
                    <span id="sprytextfield5">
                      <input name="cargo" type="text" class="datos" id="cargo" value="<?php echo htmlentities($row_mis_datos['cargo']); ?>" />
                      <span class="textfieldRequiredMsg">Se necesita un valor.</span>
                    </span>
                  </td>
                </tr>
                <tr>
                  <td width="100"><div align="right" class="info-label">C.I.:</div></td>
                  <td>
                    <span id="spryci">
                      <input name="ci" type="text" class="datos" id="ci" value="<?php echo htmlentities($row_mis_datos['ci']); ?>" maxlength="10"/>
                      <span class="textfieldRequiredMsg">Se necesita un valor.</span>
                    </span>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          
          <!-- Spacer -->
          <tr><td>&nbsp;</td></tr>
          
          <!-- Section: Datos de Contacto -->
          <tr>
            <td class="section-header"><span>Datos de Contacto</span></td>
          </tr>
          <tr>
            <td>
              <table width="100%" border="0" cellspacing="2" cellpadding="5">
                <tr>
                  <td width="100"><div align="right" class="info-label">Celular:</div></td>
                  <td>
                    <span id="sprycelular">
                      <input name="celular" type="text" class="datos" id="celular" value="<?php echo htmlentities($row_mis_datos['celular']); ?>" maxlength="8" />
                    </span>
                  </td>
                </tr>
                <tr>
                  <td width="100"><div align="right" class="info-label">Teléfono:</div></td>
                  <td>
                    <span id="sprytelefono">
                      <input name="telefono" type="text" class="datos" id="telefono" value="<?php echo htmlentities($row_mis_datos['telefono']); ?>" maxlength="7"/>
                    </span>
                  </td>
                </tr>
                <tr>
                  <td width="100"><div align="right" class="info-label">Correo:</div></td>
                  <td>
                    <span id="sprycorreo">
                      <input name="email" type="text" class="datos" id="email" value="<?php echo htmlentities($row_mis_datos['email']); ?>"/>
                      <span class="textfieldInvalidFormatMsg">Formato no válido.</span>
                    </span>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
      
      <!-- Right Sidebar Column -->
      <td class="actions-panel">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="sidebar-title">Modificar</td>
          </tr>
          <tr>
            <td>
              <input name="aceptar" type="submit" id="aceptar" value="Aceptar" />
            </td>
          </tr>
          <tr>
            <td>
              <input name="cancelar" type="button" id="cancelar" onclick="carga();" value="Cancelar"/>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
</form>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("spryci", "none", {isRequired:false, validateOn:["blur", "change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprycelular", "none", {validateOn:["blur", "change"], isRequired:false});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytelefono", "none", {isRequired:false, validateOn:["blur", "change"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprycorreo", "email", {validateOn:["blur", "change"], isRequired:false});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "none", {validateOn:["blur"]});
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "none", {validateOn:["blur"]});
</script>
</body>
</html>
<?php
mysql_free_result($mis_datos);
?>
