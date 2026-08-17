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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Perfil de Usuario</title>
<style type="text/css">
body {
     background-color: transparent !important;
     color: #cbd5e1 !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     margin: 10px !important;
     padding: 0 !important;
}

/* Main outer layout card */
table.main-layout {
     background-color: #1e293b !important;
     border: 1px solid rgba(255, 255, 255, 0.1) !important;
     border-radius: 12px !important;
     box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4) !important;
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
     border-right: 1px solid rgba(255, 255, 255, 0.05) !important;
     text-align: center !important;
}

td.avatar-panel img {
     width: 90px !important;
     height: 90px !important;
     border-radius: 50% !important;
     border: 3px solid #3b82f6 !important;
     box-shadow: 0 0 15px rgba(59, 130, 246, 0.4) !important;
     object-fit: cover !important;
     background-color: #0f172a !important;
}

/* Center details panel */
td.details-panel {
     padding: 24px !important;
     vertical-align: top !important;
}

/* Sub-headers */
td.section-header {
     background-color: rgba(37, 99, 235, 0.1) !important;
     border-bottom: 1px solid rgba(37, 99, 235, 0.25) !important;
     border-radius: 4px !important;
     padding: 8px 12px !important;
}

td.section-header span {
     color: #3b82f6 !important;
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
     font-weight: 500 !important;
}

/* Right sidebar */
td.actions-panel {
     width: 110px !important;
     background-color: rgba(15, 23, 42, 0.3) !important;
     border-left: 1px solid rgba(255, 255, 255, 0.05) !important;
     padding: 24px 16px !important;
     vertical-align: top !important;
     text-align: center !important;
}

/* Premium Modify Button */
input.btn-modify {
     background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
     color: #ffffff !important;
     border: none !important;
     border-radius: 6px !important;
     padding: 8px 16px !important;
     font-weight: 700 !important;
     cursor: pointer !important;
     font-size: 11px !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     box-shadow: 0 2px 8px rgba(37, 99, 235, 0.3) !important;
     transition: all 0.2s !important;
     width: 100% !important;
}

input.btn-modify:hover {
     box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4) !important;
     transform: translateY(-1px) !important;
}

input.btn-modify:active {
     transform: translateY(1px) !important;
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
