<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Imprimir LIBRO DE REGISTRO DE ENTRADAS</title>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />

<script src="js/calendario.js" type="text/javascript"></script>
<link href="js/calendario.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body {
     background-color: #0f172a !important;
     color: #cbd5e1 !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     margin: 20px !important;
     padding: 0 !important;
}

#form1 {
     max-width: 620px;
     margin: 0 auto;
}

/* Table Form Card */
table.form {
     background-color: #1e293b !important;
     border: 1px solid rgba(255, 255, 255, 0.1) !important;
     border-radius: 8px !important;
     padding: 20px !important;
     border-collapse: separate !important;
     box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3) !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
}

table.form th {
     background-color: #1e3a8a !important;
     color: #ffffff !important;
     padding: 10px 15px !important;
     border-radius: 6px !important;
     font-size: 12px !important;
     font-weight: 700 !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     border: 1px solid rgba(255, 255, 255, 0.05) !important;
}

table.form td {
     padding: 10px 8px !important;
     color: #cbd5e1 !important;
     font-size: 13px !important;
     vertical-align: middle !important;
}

table.form td strong {
     color: #ffffff !important;
}

/* Inputs styling */
table.form input[type="text"] {
     background-color: rgba(15, 23, 42, 0.6) !important;
     border: 1px solid rgba(255, 255, 255, 0.1) !important;
     border-radius: 6px !important;
     color: #ffffff !important;
     padding: 8px 12px !important;
     font-size: 13px !important;
     outline: none !important;
     transition: border-color 0.2s, box-shadow 0.2s !important;
     box-sizing: border-box !important;
     width: 130px !important;
}

table.form input[type="text"]:focus {
     border-color: #2563eb !important;
     box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2) !important;
}

/* Calendar icon */
table.form img {
     cursor: pointer !important;
     vertical-align: middle !important;
     margin-left: 6px !important;
     transition: transform 0.2s, opacity 0.2s !important;
     opacity: 0.8 !important;
}

table.form img:hover {
     opacity: 1 !important;
     transform: scale(1.15) !important;
}

/* Submit Button */
table.form input[type="submit"] {
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     font-size: 12px !important;
     font-weight: 700 !important;
     color: #ffffff !important;
     background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
     border: none !important;
     border-radius: 6px !important;
     padding: 8px 20px !important;
     cursor: pointer !important;
     box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2) !important;
     transition: all 0.2s !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
}

table.form input[type="submit"]:hover {
     box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3) !important;
     transform: translateY(-1px) !important;
}

table.form input[type="submit"]:active {
     transform: translateY(1px) !important;
}

/* Spry validation styling override */
.textfieldRequiredMsg {
     display: none !important;
}

.textfieldRequiredState input,
.textfieldInvalidState input {
     border-color: #ef4444 !important;
     background-color: #fff5f5 !important;
     color: #1e293b !important;
}
</style>
</head>

<body>
<form action="vistasTablas/MisRecibidosInFin.php" method="post" name="form1" target="_blank" id="form1">

  <table width="100%" border="0" class="form">
    <tr><th colspan="6">CORRESPONDENCIA RECIBIDA</th></tr>
    <tr>
      <td width="150"><strong>Mostrar::Recibidos</strong></td>
      <td width="200">Fecha de Inicio</td>
      <td width="80">&nbsp;</td>
      <td width="250">Fecha de Finalizacion</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="150">Consultar desde</td>
      <td width="200"><span id="sprytextfield1">
        <label>
        <input name="inicio" type="text" id="inicio" title="YYYY-MM-DD" value="<?php echo date("Y-m-d");?>" />
        </label>
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span>
        <img src="imagen/icon_calendar_choose.png" alt="fecha" width="13" height="17" onclick="displayCalendarFor('inicio');"/>      </td>
      <td width="80">hasta </td>
      <td width="250"><span id="sprytextfield2">
        <label>
        <input type="text" name="fin" id="fin" title="YYYY-MM-DD" value="<?php echo date("Y-m-d");?>" />
        </label>
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span>
      <img src="imagen/icon_calendar_choose.png" alt="fecha" width="13" height="17" onclick="displayCalendarFor('fin');"  /></td>
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
