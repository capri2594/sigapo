<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="css/theme_variables.css" rel="stylesheet" type="text/css" />
<script src="js/theme_switcher.js" type="text/javascript"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Imprimir LIBRO DE REGISTRO DE ENTRADAS</title>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />

<script src="js/calendario.js" type="text/javascript"></script>
<link href="js/calendario.css?v=3" rel="stylesheet" type="text/css" />
<style type="text/css">
body {
     background-color: #1a090d !important;
     color: #f8fafc !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     margin: 20px !important;
     padding: 0 !important;
}

#form1 {
     max-width: 620px;
     margin: 0 auto;
}

/* Table Form Card (Dark Mode Default) */
table.form {
     background-color: #260d13 !important;
     border: 1px solid rgba(180, 138, 40, 0.35) !important;
     border-radius: 10px !important;
     padding: 20px !important;
     border-collapse: separate !important;
     border-spacing: 0 !important;
     box-shadow: 0 8px 25px rgba(0, 0, 0, 0.45) !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
}

table.form th {
     background: linear-gradient(135deg, #50000e 0%, #780016 100%) !important;
     color: #ffffff !important;
     padding: 12px 16px !important;
     border-radius: 6px !important;
     font-size: 12px !important;
     font-weight: 700 !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     border: none !important;
     border-bottom: 2px solid #b48a28 !important;
}

table.form td {
     padding: 10px 8px !important;
     color: #e2e8f0 !important;
     background-color: transparent !important;
     font-size: 13px !important;
     vertical-align: middle !important;
     border: none !important;
}

table.form td strong {
     color: #ffffff !important;
     font-weight: 700 !important;
}

/* Date input + Calendar button wrapper */
.date-field-group {
     display: inline-flex !important;
     align-items: center !important;
     gap: 6px !important;
}

/* Inputs styling */
table.form input[type="text"] {
     background-color: #16070a !important;
     border: 1px solid rgba(255, 255, 255, 0.18) !important;
     border-radius: 6px !important;
     color: #ffffff !important;
     padding: 8px 10px !important;
     font-size: 13px !important;
     font-weight: 600 !important;
     outline: none !important;
     transition: border-color 0.2s, box-shadow 0.2s !important;
     box-sizing: border-box !important;
     width: 115px !important;
     cursor: pointer !important;
}

table.form input[type="text"]:focus {
     border-color: #b48a28 !important;
     box-shadow: 0 0 0 3px rgba(180, 138, 40, 0.2) !important;
}

/* Interactive Calendar Button */
.btn-calendar-trigger {
     display: inline-flex !important;
     align-items: center !important;
     justify-content: center !important;
     gap: 4px !important;
     height: 33px !important;
     padding: 0 10px !important;
     background: linear-gradient(135deg, #50000e 0%, #780016 100%) !important;
     border: 1px solid rgba(180, 138, 40, 0.45) !important;
     border-radius: 6px !important;
     color: #ffffff !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     cursor: pointer !important;
     transition: all 0.2s ease !important;
     box-shadow: 0 2px 6px rgba(0, 0, 0, 0.25) !important;
     outline: none !important;
}

.btn-calendar-trigger:hover {
     background: linear-gradient(135deg, #680014 0%, #881337 100%) !important;
     border-color: #b48a28 !important;
     color: #ffffff !important;
     transform: translateY(-1px) !important;
     box-shadow: 0 4px 10px rgba(104, 0, 20, 0.35) !important;
}

.btn-calendar-trigger:active {
     transform: translateY(1px) !important;
}

.btn-calendar-trigger svg {
     width: 15px !important;
     height: 15px !important;
     stroke: currentColor !important;
     flex-shrink: 0 !important;
}

/* Submit Button */
table.form input[type="submit"] {
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     font-size: 12px !important;
     font-weight: 700 !important;
     color: #ffffff !important;
     background: linear-gradient(135deg, #50000e 0%, #780016 100%) !important;
     border: 1px solid rgba(180, 138, 40, 0.5) !important;
     border-radius: 6px !important;
     padding: 8px 20px !important;
     cursor: pointer !important;
     box-shadow: 0 2px 6px rgba(104, 0, 20, 0.3) !important;
     transition: all 0.2s !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
}

table.form input[type="submit"]:hover {
     background: linear-gradient(135deg, #680014 0%, #881337 100%) !important;
     box-shadow: 0 4px 10px rgba(104, 0, 20, 0.4) !important;
     transform: translateY(-1px) !important;
}

table.form input[type="submit"]:active {
     transform: translateY(1px) !important;
}

/* Unified Calendar Popup Styling (Matches Imagen 2 in both modes) */
.fc_main, .fc_main td, .fc_main th {
     color: #18181b !important;
     background-color: #f0f0f0 !important;
     padding: 3px 2px !important;
     font-size: 10px !important;
     font-family: Verdana, sans-serif !important;
}
.fc_main td.fc_date {
     color: #18181b !important;
     background-color: #ffffff !important;
     border: 1px solid #d4d4d8 !important;
}
.fc_main td.fc_dateHover,
.fc_main td.fc_date:hover {
     background: #780016 !important;
     background-color: #780016 !important;
     color: #ffffff !important;
     border: 1px solid #50000e !important;
     font-weight: 700 !important;
}
.fc_main td.fc_wk {
     color: #27272a !important;
     font-weight: 700 !important;
}
.fc_main td.fc_wknd {
     color: #dc2626 !important;
     font-weight: 700 !important;
}
.fc_main td.fc_head {
     background: linear-gradient(135deg, #50000e 0%, #780016 100%) !important;
     background-color: #780016 !important;
     color: #ffffff !important;
     font-weight: 700 !important;
     padding: 5px 8px !important;
}

/* ========================================================
   MODO CLARO (Light Mode Overrides)
   ======================================================== */
html[data-theme="light"] body,
:root:not([data-theme="dark"]) body {
     background-color: #f1f5f9 !important;
     color: #18181b !important;
}

html[data-theme="light"] table.form,
:root:not([data-theme="dark"]) table.form {
     background-color: #ffffff !important;
     border: 1px solid rgba(104, 0, 20, 0.2) !important;
     box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08) !important;
}

html[data-theme="light"] table.form td,
:root:not([data-theme="dark"]) table.form td {
     background-color: transparent !important;
     color: #18181b !important;
     border: none !important;
}

html[data-theme="light"] table.form td strong,
:root:not([data-theme="dark"]) table.form td strong {
     color: #50000e !important;
}

html[data-theme="light"] table.form input[type="text"],
:root:not([data-theme="dark"]) table.form input[type="text"] {
     background-color: #f8fafc !important;
     border: 1px solid #cbd5e1 !important;
     color: #18181b !important;
}

html[data-theme="light"] table.form input[type="text"]:focus,
:root:not([data-theme="dark"]) table.form input[type="text"]:focus {
     background-color: #ffffff !important;
     border-color: #680014 !important;
     box-shadow: 0 0 0 3px rgba(104, 0, 20, 0.15) !important;
}

html[data-theme="light"] .btn-calendar-trigger,
:root:not([data-theme="dark"]) .btn-calendar-trigger {
     color: #ffffff !important;
     border-color: #50000e !important;
}

/* Spry validation styling override */
.textfieldRequiredMsg {
     display: none !important;
}

.textfieldRequiredState input,
.textfieldInvalidState input {
     border-color: #ef4444 !important;
     background-color: #fff5f5 !important;
     color: #27272a !important;
}
</style>
</head>

<body>
<form action="verSalidasHR_intervalos.php" method="post" name="form1" target="_blank" id="form1">
  <table width="100%" border="0" class="form">
  <tr><th colspan="5">CORRESPONDENCIA DERIVADA</th></tr>
    <tr>
      <td width="150"><strong>Mostrar::Salidas</strong></td>
      <td width="200"><strong>Fecha de Inicio</strong></td>
      <td width="50">&nbsp;</td>
      <td width="220"><strong>Fecha de Finalizaci&oacute;n</strong></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="150">Consultar desde</td>
      <td width="200">
        <div class="date-field-group">
          <span id="sprytextfield1">
            <label>
              <input name="inicio" type="text" id="inicio" title="YYYY-MM-DD" value="<?php echo date("Y-m-d");?>" onclick="displayCalendarFor('inicio');" />
            </label>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span>
          </span>
          <button type="button" class="btn-calendar-trigger" onclick="displayCalendarFor('inicio');" title="Seleccionar Fecha de Inicio">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
          </button>
        </div>
      </td>
      <td width="50" align="center">hasta</td>
      <td width="220">
        <div class="date-field-group">
          <span id="sprytextfield2">
            <label>
              <input type="text" name="fin" id="fin" title="YYYY-MM-DD" value="<?php echo date("Y-m-d");?>" onclick="displayCalendarFor('fin');" />
            </label>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span>
          </span>
          <button type="button" class="btn-calendar-trigger" onclick="displayCalendarFor('fin');" title="Seleccionar Fecha de Finalización">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
          </button>
        </div>
      </td>
      <td>
      <input name="Enviar" type="submit" value="Mostrar" /></td>
    </tr>
    <tr>
      <td width="150">&nbsp;</td>
      <td width="200">&nbsp;</td>
      <td width="80">&nbsp;</td>
      <td width="250">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
//-->
</script>
</body>
</html>
