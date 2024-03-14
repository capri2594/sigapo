<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Recibir_C_ Interna</title>
<style type="text/css">
<!--
.firma {
	height: 150px;
	width: 300px;
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-style: solid;
	border-right-style: solid;
	border-bottom-style: solid;
	border-left-style: solid;
}
body {
	font-size: 12px;
	color: #000000;
	font-weight: bold;
	font-family: sans-serif, fantasy, Rockwell, "Lucida Sans";
}
.edit {
	border-top-width: 2px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 2px;
	border-top-style: solid;
	border-right-style: solid;
	border-bottom-style: solid;
	border-left-style: solid;
	border-top-color: #DFDFDF;
	border-right-color: #DFDFDF;
	border-bottom-color: #DFDFDF;
	border-left-color: #DFDFDF;
	height: 100%;
}
.edit_over {
	border-top-width: 2px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 2px;
	border-top-style: solid;
	border-right-style: solid;
	border-bottom-style: solid;
	border-left-style: solid;
	border-top-color: #C3C3C3;
	border-right-color: #DFDFDF;
	border-bottom-color: #DFDFDF;
	border-left-color: #C3C3C3;
	height: 100%;
	background-color: #FFFFCC;
	cursor: text;
}
-->
</style>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>

<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo2 {color: #000066; }
-->
</style>

</head>

<body>
<form>
<table width="100%" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
    <td>
      
        <div align="right">
          <table width="300" border="0" cellpadding="0" cellspacing="5" bgcolor="#D5EAFF">
            <tr>
              <td><input type="submit" name="button" id="button" value="Registrar" /></td>
              <td><input type="submit" name="button2" id="button2" value="Vista Impresion" /></td>
              <td><input type="submit" name="button3" id="button3" value="cancelar" /></td>
            </tr>
                  </table>
      </div></td>
    <td valign="top">&nbsp;</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div style="border-color:#98BEFE; border-style:solid; border-width:1px;">
    <table width="100%" border="0" cellpadding="0" cellspacing="5" bgcolor="#D5EAFF">
      <tr>
        <td width="7%">&nbsp;</td>
        <td width="50%">&nbsp;</td>
        <td width="43%">&nbsp;</td>
      </tr>
      <tr>
        <td height="22">de:</td>
        <td height="22" bgcolor="#FFFFFF">&nbsp;</td>
        <td height="22" bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
        <td height="22">para:</td>
        <td height="22" bgcolor="#FFFFFF"><span id="sprytextfield6"><span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
        <td height="22" bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></div></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div style="border-color:#98BEFE; border-style:solid; border-width:1px;">
    <table width="100%" border="0" cellspacing="5" cellpadding="0">
          <tr>
            <td width="17%">&nbsp;</td>
            <td width="83%">&nbsp;</td>
          </tr>
          <tr>
            <td height="22"><div align="right" class="Estilo2">Hoja de Ruta:&nbsp;</div></td>
            <td height="22">
              <div class="edit" style="width:120px;" onmouseover="this.className='edit_over';" onmouseout="this.className='edit';">&nbsp;</div></td>
          </tr>
          <tr>
            <td height="22"><div align="right" class="Estilo2">Cite:&nbsp;</div></td>
            <td height="22"><div class="edit" style="width:120px;" onmouseover="this.className='edit_over';" onmouseout="this.className='edit';">&nbsp;</div></td>
          </tr>
          <tr>
            <td height="22"><div align="right" class="Estilo2">Referencia:&nbsp;</div></td>
            <td height="22"><div class="edit" onmouseover="this.className='edit_over';" onmouseout="this.className='edit';">&nbsp;</div></td>
          </tr>
          <tr>
            <td height="22"><div align="right" class="Estilo2">Hojas:&nbsp;</div></td>
            <td height="22"><div class="edit" style="width:70px" onmouseover="this.className='edit_over';" onmouseout="this.className='edit';">&nbsp;</div></td>
          </tr>
          <tr>
            <td height="80" valign="top"><div align="right" class="Estilo2">Anexos:&nbsp;</div></td>
            <td height="90"><div class="edit" style="overflow:scroll;" onmouseover="this.className='edit_over';" onmouseout="this.className='edit';">&nbsp;</div></td>
          </tr>
      </table>
    </div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><table width="300" border="0" cellspacing="5" cellpadding="0">
          <tr>
            <td><input type="submit" name="button" id="button" value="Registrar" /></td>
            <td><input type="submit" name="button2" id="button2" value="Vista Impresion" /></td>
            <td><input type="submit" name="button3" id="button3" value="cancelar" /></td>
          </tr>
        </table></td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
<script type="text/javascript">
<!--
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6");
//-->
</script>
</body>
</html>
