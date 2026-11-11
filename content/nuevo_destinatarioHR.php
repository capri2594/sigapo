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
<link href="css/theme_variables.css?v=15" rel="stylesheet" type="text/css" />
<script src="js/theme_switcher.js?v=12" type="text/javascript"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Agregar destinatario</title>
<style type="text/css">
/* ==========================================================================
   ESTILOS BASE Y MODO OSCURO (OPCIÓN 1: GUINDO IMPERIAL PROFUNDO)
   ========================================================================== */
html, body {
     background-color: #1a080c !important;
     color: #e2e8f0 !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     margin: 0 !important;
     padding: 14px 16px !important;
     box-sizing: border-box !important;
}

/* Neutralizar fondos y bordes heredados de theme_variables.css sobre tablas de maquetación */
form#form1 table,
form#form1 tr,
form#form1 td {
     background-color: transparent !important;
     border-color: transparent !important;
}

/* Encabezado Institucional */
form#form1 td.titulos,
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
     display: block !important;
     margin-bottom: 12px !important;
}

/* Tarjeta Principal del Formulario */
form#form1 table.celdas {
     background-color: #280d14 !important;
     border: 1px solid rgba(180, 138, 40, 0.35) !important;
     border-radius: 8px !important;
     box-shadow: 0 6px 18px rgba(0, 0, 0, 0.4) !important;
     padding: 10px 16px !important;
     width: 100% !important;
     box-sizing: border-box !important;
     border-collapse: separate !important;
     border-spacing: 0 !important;
}

form#form1 table.celdas > tbody > tr > td,
form#form1 table.celdas > tr > td {
     padding: 8px 10px !important;
     border-bottom: 1px solid rgba(255, 255, 255, 0.06) !important;
     vertical-align: middle !important;
}

form#form1 table.celdas > tbody > tr:last-child > td,
form#form1 table.celdas > tr:last-child > td {
     border-bottom: none !important;
}

/* Etiquetas de fila */
form#form1 table.celdas > tbody > tr > td:first-child,
form#form1 table.celdas > tr > td:first-child {
     color: #e2e8f0 !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     width: 155px !important;
}

.sub-label-inline {
     color: #cbd5e1 !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     text-align: right !important;
     padding: 0 10px !important;
     white-space: nowrap !important;
}

/* Campos de texto, selectores y áreas de texto */
form#form1 input[type="text"],
form#form1 select,
form#form1 textarea {
     background-color: #140508 !important;
     border: 1px solid rgba(180, 138, 40, 0.32) !important;
     border-radius: 6px !important;
     color: #ffffff !important;
     padding: 7px 11px !important;
     font-size: 13px !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     outline: none !important;
     box-sizing: border-box !important;
     transition: border-color 0.2s, box-shadow 0.2s !important;
}

form#form1 input[type="text"]::placeholder,
form#form1 textarea::placeholder {
     color: #94a3b8 !important;
}

form#form1 input[type="text"]:focus,
form#form1 select:focus,
form#form1 textarea:focus {
     border-color: #b48a28 !important;
     box-shadow: 0 0 0 3px rgba(180, 138, 40, 0.22) !important;
}

form#form1 input[readonly="readonly"] {
     background-color: #19070b !important;
     color: #cbd5e1 !important;
     border-color: rgba(255, 255, 255, 0.12) !important;
     cursor: default !important;
}

/* Insignia No. Destinatario */
span.n-destino {
     display: inline-flex !important;
     align-items: center !important;
     justify-content: center !important;
     min-width: 32px !important;
     padding: 3px 10px !important;
     font-size: 14px !important;
     font-weight: 800 !important;
     color: #ffffff !important;
     background: linear-gradient(135deg, #780016 0%, #a81c33 100%) !important;
     border: 1px solid rgba(180, 138, 40, 0.5) !important;
     border-radius: 6px !important;
     font-family: monospace, sans-serif !important;
}

/* Botón Buscar */
form#form1 input.buscar {
     background: linear-gradient(135deg, #780016 0%, #a81c33 100%) !important;
     color: #ffffff !important;
     border: 1px solid rgba(180, 138, 40, 0.45) !important;
     border-radius: 6px !important;
     padding: 7px 14px !important;
     font-weight: 700 !important;
     cursor: pointer !important;
     font-size: 11px !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     box-shadow: 0 2px 6px rgba(120, 0, 22, 0.35) !important;
     transition: all 0.2s !important;
     margin-left: 8px !important;
}

form#form1 input.buscar:hover {
     background: linear-gradient(135deg, #8f001b 0%, #be123c 100%) !important;
     box-shadow: 0 4px 10px rgba(190, 18, 60, 0.45) !important;
     transform: translateY(-1px) !important;
}

/* Barra Inferior (Aviso + Botón Crear) */
form#form1 table.footer-row {
     background-color: #280d14 !important;
     border: 1px solid rgba(180, 138, 40, 0.32) !important;
     border-radius: 8px !important;
     padding: 10px 14px !important;
     margin-top: 12px !important;
     box-sizing: border-box !important;
     border-collapse: separate !important;
}

.aviso-container {
     background-color: rgba(180, 138, 40, 0.14) !important;
     border: 1px solid rgba(180, 138, 40, 0.38) !important;
     border-radius: 6px !important;
     padding: 9px 14px !important;
     display: flex !important;
     align-items: center !important;
}

.aviso-text {
     color: #f8fafc !important;
     font-size: 12px !important;
     font-weight: 600 !important;
     margin-left: 8px !important;
}

/* Botón Crear Destinatario */
form#form1 input#button2 {
     background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
     color: #ffffff !important;
     border: 1px solid rgba(255, 255, 255, 0.2) !important;
     border-radius: 6px !important;
     padding: 9px 18px !important;
     font-weight: 800 !important;
     cursor: pointer !important;
     font-size: 11px !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     box-shadow: 0 3px 10px rgba(16, 185, 129, 0.35) !important;
     transition: all 0.2s !important;
}

form#form1 input#button2:hover {
     background: linear-gradient(135deg, #059669 0%, #047857 100%) !important;
     box-shadow: 0 5px 14px rgba(16, 185, 129, 0.45) !important;
     transform: translateY(-1px) !important;
}

/* Ocultar mensajes Spry por defecto */
.textfieldRequiredMsg, .selectRequiredMsg {
     display: none !important;
}

/* Lista Autocompletar */
div.autocomplete {
     position: absolute;
     width: 320px !important;
     background-color: #280d14 !important;
     border: 1px solid #b48a28 !important;
     border-radius: 6px !important;
     box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5) !important;
     margin: 2px 0 0 0 !important;
     padding: 0px !important;
     list-style-type: none !important;
     z-index: 1000 !important;
     max-height: 220px !important;
     overflow-y: auto !important;
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
     padding: 7px 12px !important;
     cursor: pointer !important;
     color: #f1f5f9 !important;
     font-size: 12px !important;
     font-weight: 600 !important;
     border-bottom: 1px solid rgba(255, 255, 255, 0.06) !important;
}

div.autocomplete li.selected,
div.autocomplete li:hover {
     background: linear-gradient(135deg, #780016 0%, #a81c33 100%) !important;
     color: #ffffff !important;
}

/* ==========================================================================
   MODO CLARO INSTITUCIONAL (GADOR PLATINO / BLANCO Y GUINDO)
   ========================================================================== */
html[data-theme="light"],
html[data-theme="light"] body,
body[data-theme="light"],
:root:not([data-theme="dark"]),
:root:not([data-theme="dark"]) body {
     background-color: #f1f5f9 !important;
     color: #1e293b !important;
}

/* Evitar que la regla global de theme_variables.css pinte celdas sueltas o cambie el texto del título */
html[data-theme="light"] form#form1 table td:not(.titulos),
:root:not([data-theme="dark"]) form#form1 table td:not(.titulos) {
     background-color: transparent !important;
}

html[data-theme="light"] form#form1 td.titulos,
:root:not([data-theme="dark"]) form#form1 td.titulos {
     background: linear-gradient(135deg, #50000e 0%, #780016 100%) !important;
     color: #ffffff !important;
     border: 1px solid #50000e !important;
     border-bottom: 3px solid #b48a28 !important;
     box-shadow: 0 4px 12px rgba(80, 0, 14, 0.18) !important;
}

html[data-theme="light"] form#form1 table.celdas,
:root:not([data-theme="dark"]) form#form1 table.celdas {
     background-color: #ffffff !important;
     border: 1px solid rgba(104, 0, 20, 0.22) !important;
     box-shadow: 0 6px 20px rgba(80, 0, 14, 0.07) !important;
}

html[data-theme="light"] form#form1 table.celdas > tbody > tr > td,
html[data-theme="light"] form#form1 table.celdas > tr > td,
:root:not([data-theme="dark"]) form#form1 table.celdas > tbody > tr > td,
:root:not([data-theme="dark"]) form#form1 table.celdas > tr > td {
     border-bottom: 1px solid #e2e8f0 !important;
     color: #1e293b !important;
}

html[data-theme="light"] form#form1 table.celdas > tbody > tr:last-child > td,
html[data-theme="light"] form#form1 table.celdas > tr:last-child > td,
:root:not([data-theme="dark"]) form#form1 table.celdas > tbody > tr:last-child > td,
:root:not([data-theme="dark"]) form#form1 table.celdas > tr:last-child > td {
     border-bottom: none !important;
}

html[data-theme="light"] form#form1 table.celdas > tbody > tr > td:first-child,
html[data-theme="light"] form#form1 table.celdas > tr > td:first-child,
html[data-theme="light"] .sub-label-inline,
:root:not([data-theme="dark"]) form#form1 table.celdas > tbody > tr > td:first-child,
:root:not([data-theme="dark"]) form#form1 table.celdas > tr > td:first-child,
:root:not([data-theme="dark"]) .sub-label-inline {
     color: #50000e !important;
     font-weight: 800 !important;
}

html[data-theme="light"] span.n-destino,
:root:not([data-theme="dark"]) span.n-destino {
     background: #fff1f2 !important;
     color: #680014 !important;
     border: 1.5px solid rgba(104, 0, 20, 0.35) !important;
}

html[data-theme="light"] form#form1 input[type="text"],
html[data-theme="light"] form#form1 select,
html[data-theme="light"] form#form1 textarea,
:root:not([data-theme="dark"]) form#form1 input[type="text"],
:root:not([data-theme="dark"]) form#form1 select,
:root:not([data-theme="dark"]) form#form1 textarea {
     background-color: #f8fafc !important;
     border: 1.5px solid #cbd5e1 !important;
     color: #0f172a !important;
     font-weight: 600 !important;
}

html[data-theme="light"] form#form1 input[type="text"]::placeholder,
html[data-theme="light"] form#form1 textarea::placeholder,
:root:not([data-theme="dark"]) form#form1 input[type="text"]::placeholder,
:root:not([data-theme="dark"]) form#form1 textarea::placeholder {
     color: #64748b !important;
     font-weight: 400 !important;
}

html[data-theme="light"] form#form1 input[type="text"]:focus,
html[data-theme="light"] form#form1 select:focus,
html[data-theme="light"] form#form1 textarea:focus,
:root:not([data-theme="dark"]) form#form1 input[type="text"]:focus,
:root:not([data-theme="dark"]) form#form1 select:focus,
:root:not([data-theme="dark"]) form#form1 textarea:focus {
     background-color: #ffffff !important;
     border-color: #680014 !important;
     box-shadow: 0 0 0 3px rgba(104, 0, 20, 0.14) !important;
}

html[data-theme="light"] form#form1 input[readonly="readonly"],
:root:not([data-theme="dark"]) form#form1 input[readonly="readonly"] {
     background-color: #f1f5f9 !important;
     color: #334155 !important;
     border-color: #cbd5e1 !important;
}

html[data-theme="light"] form#form1 table.footer-row,
:root:not([data-theme="dark"]) form#form1 table.footer-row {
     background-color: #ffffff !important;
     border: 1px solid rgba(104, 0, 20, 0.22) !important;
     box-shadow: 0 4px 14px rgba(80, 0, 14, 0.06) !important;
}

html[data-theme="light"] .aviso-container,
:root:not([data-theme="dark"]) .aviso-container {
     background-color: #fffbeb !important;
     border: 1px solid #f59e0b !important;
}

html[data-theme="light"] .aviso-text,
:root:not([data-theme="dark"]) .aviso-text {
     color: #78350f !important;
     font-weight: 700 !important;
}

html[data-theme="light"] form#form1 input#button2,
:root:not([data-theme="dark"]) form#form1 input#button2 {
     background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
     color: #ffffff !important;
     border: 1px solid #059669 !important;
}

html[data-theme="light"] div.autocomplete,
:root:not([data-theme="dark"]) div.autocomplete {
     background-color: #ffffff !important;
     border: 1px solid rgba(104, 0, 20, 0.35) !important;
     box-shadow: 0 10px 24px rgba(80, 0, 14, 0.15) !important;
}

html[data-theme="light"] div.autocomplete li,
:root:not([data-theme="dark"]) div.autocomplete li {
     color: #1e293b !important;
     border-bottom: 1px solid #f1f5f9 !important;
}

html[data-theme="light"] div.autocomplete li.selected,
html[data-theme="light"] div.autocomplete li:hover,
:root:not([data-theme="dark"]) div.autocomplete li.selected,
:root:not([data-theme="dark"]) div.autocomplete li:hover {
     background: linear-gradient(135deg, #50000e 0%, #780016 100%) !important;
     color: #ffffff !important;
}
</style>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function MM_openBrWindow(theURL,winName,features) { //v3.0 - Centrado Punto Medio SIGAPO
  var featStr = (typeof features === 'string' && features.length > 0) ? features : 'menubar=yes,scrollbars=yes,resizable=yes,width=850,height=550';
  var wMatch = featStr.match(/width\s*=\s*(\d+)/i);
  var hMatch = featStr.match(/height\s*=\s*(\d+)/i);
  var w = wMatch ? parseInt(wMatch[1], 10) : 850;
  var h = hMatch ? parseInt(hMatch[1], 10) : 550;
  var left, top;
  if (typeof window.getSigapoCenteredCoords === 'function') {
    var coords = window.getSigapoCenteredCoords(w, h, window);
    left = coords.left;
    top  = coords.top;
  } else {
    var scr = window.screen || {};
    var availW = scr.availWidth || scr.width || 1366;
    var availH = scr.availHeight || scr.height || 768;
    var monX = (typeof scr.availLeft === 'number') ? scr.availLeft : 0;
    var monY = (typeof scr.availTop === 'number') ? scr.availTop : 0;
    left = Math.round(monX + (availW / 2) - ((w + 16) / 2));
    top  = Math.round(monY + (availH / 2) - ((h + 68) / 2));
  }
  var parts = featStr.split(',');
  var clean = [];
  for (var i = 0; i < parts.length; i++) {
    var p = parts[i].replace(/^\s+|\s+$/g, '');
    if (!p || /^(left|top|screenX|screenY)\s*=/i.test(p)) continue;
    clean.push(p);
  }
  clean.push('left=' + left);
  clean.push('top=' + top);
  clean.push('screenX=' + left);
  clean.push('screenY=' + top);
  var win = window.open(theURL, winName || '', clean.join(','));
  if (win) { try { win.moveTo(left, top); win.focus(); } catch(e) {} }
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
                <img src="imagen/loading.gif" alt="Cargando..." /><span style="color:#fda4af; font-size:11px; margin-left:5px;">Cargando...</span>
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
                  <td width="60" class="sub-label-inline">Hojas:</td>
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
                  <td width="60" class="sub-label-inline">Anexos:</td>
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
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#b48a28" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
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
