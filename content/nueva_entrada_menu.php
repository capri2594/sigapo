<?php 
session_name("LoginSIRC");
session_start();
header("Content-Type: text/html; charset=utf-8");
date_default_timezone_set("America/La_Paz"); 
//echo  "dep:".$_SESSION['dep']
//$cod_dep=$_SESSION['cod_dep'];
//echo  "dep:".$cod_dep;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:: NUEVA ENTRADA</title>
<script src="../SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo1 {color: #FFFFFF}
body {
	margin: 0px;
	padding: 0px;
}
-->
</style>
<script type="text/javascript" src="js/scriptaculous/prototype.js"></script>
<script type="text/javascript" src="js/scriptaculous/scriptaculous.js"></script>
<script type="text/javascript" src="js/scriptaculous/effects.js"></script>
<link href="css/autocontempler.css" rel="stylesheet" type="text/css" />
</head>

<body onunload="window.opener.self.estado=0;">
<div id="TabbedPanels1" class="TabbedPanels">
  <ul class="TabbedPanelsTabGroup">
    <li class="TabbedPanelsTab" tabindex="0">REGISTRO DE CORRESPONDENCIA INTERNA</li>
    <li class="TabbedPanelsTab" tabindex="0">SEGUIMIENTO DE HOJA DE RUTA</li>
  </ul>
  <div class="TabbedPanelsContentGroup">
    <div class="TabbedPanelsContent" style="margin:0px; border:0px;">
      <iframe src="nuevo_Recib_interno.php" name="new_interno" width="100%" marginwidth="0" height="536px" marginheight="0" align="middle" scrolling="no" frameborder="0">Contenido 1</iframe>
    </div>
    <div class="TabbedPanelsContent">
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <table width="300" border="0" cellspacing="0" cellpadding="4" align="center" bgcolor="#DCEDED">
        <tr bgcolor="#5EAEAE">
          <td colspan="2" style="border-top:1px solid #CCCCCC; border-right:1px solid #CCCCCC; border-left:1px solid #CCCCCC; color:#FFFFFF;">.:: Seguimiento de Hojas de Ruta</td>
        </tr>
        <tr>
          <td colspan="2" style="border-right:1px solid #CCCCCC; border-left:1px solid #CCCCCC;">&nbsp;</td>
        </tr>
        <tr>
          <td width="80" align="center" style="border-left:1px solid #CCCCCC;"><img src="imagen/iconos/informacion.gif" alt="inf" width="31" height="34" longdesc="inf" /></td>
          <td width="220" style="border-right:1px solid #CCCCCC;">Introduzca el codigo de Hoja de Ruta,(debe ser uno que exista en el sistema)<br />
              <br />
            <img src="imagen/correo.gif" alt="<?php echo $_SESSION['cod_dep']; ?>" border="0" />&nbsp;       
              <span id="preload" style="display: none; position:absolute; z-index:3;" >
  <img src="imagen/loading.gif" alt="Cargando..." /><span class="Estilo1">Cargando...</span>
</span>
</td>
        </tr>
        <tr>
          <td colspan="2" style="border-right:1px solid #CCCCCC; border-left:1px solid #CCCCCC;"><form action="RecibirHojaRutaPersonalizado.php" method="get" name="form1" target="_blank" id="form1">
            <span id="sprytextfield1">
        <label>
        <input type="text" name="cod" id="cod" />
        <div id="lista_opciones" class="autocomplete" ></div>
        </label>
              <span class="textfieldRequiredMsg">Se necesita un valor.</span></span>
        
                  <script type="text/javascript">
					new Ajax.Autocompleter("cod", "lista_opciones", "ajax/h_rutas.php", {
method: "post",
paramName: "cod",
indicator: "preload"});

    			</script>
            <label>
            <input type="submit" name="Comprobar" id="Comprobar" value="Comprobar" />
            </label>
          </form>          </td>
        </tr>
        <tr>
          <td colspan="2" style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC; border-left:1px solid #CCCCCC;">&nbsp;</td>
        </tr>
      </table>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
    </div>
  </div>
</div>
<script type="text/javascript">
<!--
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
//-->
</script>
</body>
</html>
