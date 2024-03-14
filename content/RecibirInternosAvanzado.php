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

-->
</style>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>

<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo2 {color: #000066; }

-->
</style>

<script type="text/javascript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
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
              <td><input name="button3" type="button" id="button3" onclick="if(confirm('¿Esta seguro de cancelar la operacion, \n se perderan todos los datos?')){MM_goToURL('self','RecibirInternos2.php');return document.MM_returnValue;}" value="cancelar" /></td>
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
        <td width="43%">&nbsp;</td>
      </tr>
      <tr>
        <td>de:</td>
        <td><span id="sprytextfield4">
          <input name="fun_remite" type="text" id="fun_remite" size="40" />
          <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
        <td><div align="left"><span id="sprytextfield5">
          <input name="dep_remite" type="text" id="dep_remite" size="30" />
          <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></div></td>
        <td align="left"><div align="left"><a href="javascript:void(0);">Examinar</a></div></td>
      </tr>
      <tr>
        <td>para:</td>
        <td><span id="sprytextfield6">
          <input name="text6" type="text" id="text6" size="40" />
          <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
        <td><span id="sprytextfield7">
        <input name="text7" type="text" id="text7" size="30" />
        <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
    </div></td>
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
            <td><div align="right" class="Estilo2">Hoja de Ruta:&nbsp;</div></td>
            <td><span id="sprytextfield11">
              <input type="text" name="hoja_ruta" id="hoja_ruta" />
              <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
          </tr>
          <tr>
            <td><div align="right" class="Estilo2">Fecha:&nbsp;</div></td>
            <td><span id="sprytextfield1"><span id="sprytextfield8">
              <input type="text" name="fecha" id="fecha" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span><span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
          </tr>
          <tr>
            <td><div align="right" class="Estilo2">Cite:&nbsp;</div></td>
            <td><span id="sprytextfield2"><span id="sprytextfield9">
              <input type="text" name="cite" id="cite" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span><span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
          </tr>
          <tr>
            <td><div align="right" class="Estilo2">Referencia:&nbsp;</div></td>
            <td><span id="sprytextfield3"><span id="sprytextfield10">
              <input name="ref" type="text" id="ref" size="80" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span><span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
          </tr>
          <tr>
            <td><div align="right" class="Estilo2">numero de Hojas:&nbsp;</div></td>
            <td><span id="sprytextfield12">
              <input type="text" name="nhojas" id="nhojas" />
              <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
          </tr>
          <tr>
            <td><div align="right" class="Estilo2">Anexos:&nbsp;</div></td>
            <td><span id="sprytextarea1">
              <textarea name="anexos" id="anexos" cols="45" rows="5"></textarea>
              <span class="textareaRequiredMsg">Se necesita un valor.</span></span></td>
          </tr>
      </table>
    </div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><table width="300" border="0" cellspacing="5" cellpadding="0">
          <tr>
            <td><input name="button" type="submit" class="boton" id="button" value="Registrar" /></td>
            <td><input type="submit" name="button2" id="button2" value="Vista Impresion" /></td>
            <td><input type="button" name="button4" id="button4" onclick="if(confirm('¿Esta seguro de cancelar la operacion?')){MM_goToURL('self','RecibirInternos2.php');return document.MM_returnValue;}" value="cancelar" /></td>
          </tr>
      </table></td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
<script type="text/javascript">
<!--
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6");
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7");
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8");
var sprytextfield9 = new Spry.Widget.ValidationTextField("sprytextfield9");
var sprytextfield10 = new Spry.Widget.ValidationTextField("sprytextfield10");
var sprytextfield11 = new Spry.Widget.ValidationTextField("sprytextfield11");
var sprytextfield12 = new Spry.Widget.ValidationTextField("sprytextfield12");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
//-->
</script>
</body>
</html>
