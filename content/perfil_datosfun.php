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
<title>Perfil de Usuario</title>
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

/* Main outer layout card (Dark Mode) */
table.main-layout {
     background-color: #280d14 !important;
     border: 1px solid rgba(180, 138, 40, 0.28) !important;
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
     background-color: #140508 !important;
     border-right: 1px solid rgba(255, 255, 255, 0.06) !important;
     text-align: center !important;
}

td.avatar-panel img {
     width: 90px !important;
     height: 90px !important;
     border-radius: 50% !important;
     border: 3px solid #b48a28 !important;
     box-shadow: 0 0 15px rgba(180, 138, 40, 0.35) !important;
     object-fit: cover !important;
     background-color: #1a080c !important;
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
     border-bottom: 2px solid #b48a28 !important;
     border-radius: 6px !important;
     padding: 8px 12px !important;
}

td.section-header span {
     color: #ffffff !important;
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

/* Row Values */
span.info-value {
     color: #ffffff !important;
     font-size: 13px !important;
     font-weight: 600 !important;
}

/* Right sidebar */
td.actions-panel {
     width: 110px !important;
     background-color: #140508 !important;
     border-left: 1px solid rgba(255, 255, 255, 0.06) !important;
     padding: 24px 16px !important;
     vertical-align: top !important;
     text-align: center !important;
}

/* Premium Modify Button */
input.btn-modify {
     background: linear-gradient(135deg, #4d000d 0%, #680014 100%) !important;
     color: #ffffff !important;
     border: 1px solid rgba(180, 138, 40, 0.45) !important;
     border-radius: 6px !important;
     padding: 8px 16px !important;
     font-weight: 700 !important;
     cursor: pointer !important;
     font-size: 11px !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     box-shadow: 0 2px 8px rgba(104, 0, 20, 0.35) !important;
     transition: all 0.2s !important;
     width: 100% !important;
}

input.btn-modify:hover {
     box-shadow: 0 4px 12px rgba(180, 138, 40, 0.3) !important;
     border-color: #ffffff !important;
     color: #ffffff !important;
     transform: translateY(-1px) !important;
}

input.btn-modify:active {
     transform: translateY(1px) !important;
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
     border-bottom: 2px solid #b48a28 !important;
}

html[data-theme="light"] td.section-header span,
:root:not([data-theme="dark"]) td.section-header span {
     color: #ffffff !important;
}

html[data-theme="light"] div.info-label,
:root:not([data-theme="dark"]) div.info-label {
     color: #50000e !important;
}

html[data-theme="light"] span.info-value,
:root:not([data-theme="dark"]) span.info-value {
     color: #18181b !important;
}

html[data-theme="light"] td.actions-panel,
:root:not([data-theme="dark"]) td.actions-panel {
     background-color: #f8fafc !important;
     border-left: 1px solid #e2e8f0 !important;
}

html[data-theme="light"] td.actions-panel table,
html[data-theme="light"] td.actions-panel td,
:root:not([data-theme="dark"]) td.actions-panel table,
:root:not([data-theme="dark"]) td.actions-panel td {
     background-color: transparent !important;
}
</style>
<script language="javascript" type="text/javascript">
function carga(){
	self.location.href="perfil_datosfun_modificar.php";
}
</script>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
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
      
      <!-- Central Details Column -->
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
                  <td><span class="info-value"><?php echo htmlentities($row_mis_datos['nombre']); ?></span></td>
                </tr>
                <tr>
                  <td width="100"><div align="right" class="info-label">Cargo:</div></td>
                  <td><span class="info-value"><?php echo htmlentities($row_mis_datos['cargo']); ?></span></td>
                </tr>
                <tr>
                  <td width="100"><div align="right" class="info-label">C.I.:</div></td>
                  <td><span class="info-value"><?php echo htmlentities($row_mis_datos['ci']); ?></span></td>
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
                  <td><span class="info-value"><?php echo htmlentities($row_mis_datos['celular']); ?></span></td>
                </tr>
                <tr>
                  <td width="100"><div align="right" class="info-label">Teléfono:</div></td>
                  <td><span class="info-value"><?php echo htmlentities($row_mis_datos['telefono']); ?></span></td>
                </tr>
                <tr>
                  <td width="100"><div align="right" class="info-label">Correo:</div></td>
                  <td><span class="info-value"><?php echo htmlentities($row_mis_datos['email']); ?></span></td>
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
            <td>
              <input type="button" name="Button" class="btn-modify" value="Modificar" onclick="carga();"/>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
mysql_free_result($mis_datos);
?>
