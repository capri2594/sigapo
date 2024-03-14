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
<!--
.form {
	background-color: #DBDBDB;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}
-->
</style>
</head>

<body>
<form action="vistasTablas/MisRecibidosInFin.php" method="post" name="form1" target="_blank" id="form1">

  <table width="100%" border="0" bgcolor="#B9E3FF" class="form">
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
