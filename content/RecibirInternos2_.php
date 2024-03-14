<html>
<head>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="100%" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><form action="<?php echo $_SERVER['PHP_SELF'];?>" method="get"><table width="100%" border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><div align="center"><span id="sprytextfield1">
          <input name="text1" type="text" id="text1" size="60" />
          <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></div></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>
          
            <div align="center">
              <table width="400" align="center" cellspacing="5">
                <tr>
                  <td bgcolor="#B9E0FD">Recibir:</td>
                  <td><input type="radio" name="GrupoOpciones1" value="opción" id="b_hruta" />
                    Hoja de Ruta</td>
                    <td><label for=all>
                      <input type="radio" name="GrupoOpciones1" value="opción" id="b_cite" />
                    Cite de Correspondencia </label></td>
                  </tr>
              </table>
            </div></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><div align="center">
          <table width="300" border="0" align="center" cellpadding="0" cellspacing="7">
              <tr>
                <td>
                  <div align="center">
                    <input type="submit" name="button" id="button" value="Marcar Recibido" />
                  </div></td>
                <td><div align="center">
                  <input type="submit" name="button2" id="button2" value="Recibido Avanzado" />
                </div></td>
              </tr>
                  </table>
        </div></td>
        <td>&nbsp;</td>
      </tr>
    </table>
    </form></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
//-->
</script>

</body>
</html>