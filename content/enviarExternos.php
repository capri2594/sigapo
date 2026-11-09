<?php 
session_name("LoginSIRC");
session_start();
//controlar si existe la session

//si no existe entonces bloquear sitio.

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Enviar Externos</title><?php
// HEAD content
?>
<style type="text/css">
<!--
.Estilo2 {font-size: small}
-->
</style>
<script src="../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
<!--
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
//-->
</script>
</head>

<body>
<?php
// Begin HTML content
?>
<div class="panel__content">
<div>
  <form id="formEInterno" name="formEInterno" method="post" action="">
    <table width="100%" border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td>&nbsp;</td>
        <td><span class="Estilo2">fecha de envio:</span>&nbsp; <span style="background-color:#DBFDE2; border-color: #CCCCCC;">&nbsp;
            <?php 
		$t=date("Y-m-d H:i:s");
		print ($t);?>
&nbsp;&nbsp; </span>
          <input name="fecha_envio" type="hidden" value="<?php echo $t;?>" /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
          <tr>
            <td>fecha del documento</td>
            <td><select name="select" size="1" id="select">
              <option selected="selected">1</option>
              <option>2</option>
              <option>3</option>
              <option>4</option>
              <option>5</option>
              <option>6</option>
              <option>7</option>
              <option>8</option>
              <option>9</option>
              <option>10</option>
              <option>11</option>
              <option>12</option>
              <option>13</option>
              <option>14</option>
              <option>15</option>
              <option>16</option>
              <option>17</option>
              <option>18</option>
              <option>19</option>
              <option>20</option>
              <option>21</option>
              <option>22</option>
              <option>23</option>
              <option>24</option>
              <option>25</option>
              <option>26</option>
              <option>27</option>
              <option>28</option>
              <option>29</option>
              <option>29</option>
              <option>30</option>
              <option>31</option>
            </select>
&nbsp;
<select name="jumpMenu" id="jumpMenu" size="1">
  <option selected="selected">Enero</option>
  <option>Febrero</option>
  <option>Marzo</option>
  <option>Abril</option>
  <option>Mayo</option>
  <option>Junio</option>
  <option>Julio</option>
  <option>Agosto</option>
  <option>Septiembre</option>
  <option>Octubre</option>
  <option>Noviembre</option>
  <option>Diciembre</option>
</select>
&nbsp;
<select name="jumpMenu2" id="jumpMenu2"  size="1">
  <option selected="selected">2007</option>
  <option>2007</option>
  <option>2008</option>
  <option>2009</option>
  <option>2010</option>
</select></td>
          </tr>
          <tr>
            <td>cite</td>
            <td><span id="sprytextfield3">
              <input type="text" name="cite" id="cite" />
              <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
          </tr>
          <tr>
            <td>referencia</td>
            <td><span id="sprytextfield4">
              <input type="text" name="ref" id="ref" />
              <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
          </tr>
          <tr>
            <td>tema</td>
            <td><span id="spryselect1">
              <select name="stema" id="stema">
                            </select>
              <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
          </tr>
          <tr>
            <td>tipo</td>
            <td><span id="spryselect2">
              <select name="stipo" id="stipo">
                            </select>
              <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
          </tr>
          <tr>
            <td>Organismo</td>
            <td><span id="sprytextfield5">
              <input type="text" name="tdest_org" id="tdest_org" />
              <span class="textfieldRequiredMsg">Se necesita un valor.</span></span>
              <input name="buscar" type="button" id="buscar" onclick="MM_openBrWindow('buscarOrg.php','vbuscarOrg','width=550,height=200')" value="Examinar ..." /></td>
          </tr>
          <tr>
            <td>Nombre</td>
            <td><span id="sprytextfield6">
              <input type="text" name="tdest_nom" id="tdest_nom" />
              <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
          </tr>
        </table></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
          <tr>
            <td><div id="CollapsiblePanel1" class="CollapsiblePanel">
              <div class="CollapsiblePanelTab" tabindex="0">Dirijo a:</div>
              <div class="CollapsiblePanelContent">Contenido</div>
            </div></td>
            </tr>
          <tr>
            <td><div id="CollapsiblePanel2" class="CollapsiblePanel">
              <div class="CollapsiblePanelTab" tabindex="0">de:</div>
              <div class="CollapsiblePanelContent">Funcionario de la Prefectura
                <table width="100%" border="0" cellspacing="1" cellpadding="0">
                  <tr>
                    <td>Nombre</td>
                    <td><span id="sprytextfield1">
                      <input type="text" name="tr_nom" id="tr_nom" />
                      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span>
                      <input name="cambiar" type="button" id="cambiar" onclick="MM_openBrWindow('funcionarioRemite1.php','vbuscarFunRemite','width=550,height=200')" value="Examinar ..." /></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>Dependencia</td>
                    <td><span id="sprytextfield2">
                      <input type="text" name="tr_dep" id="tr_dep" />
                      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
              </div>
            </div></td>
            </tr>
        </table>          
          <p>&nbsp;</p>
        </td>
        <td>&nbsp;</td>
      </tr>
    </table>
  </form>
  <p>&nbsp;</p>
</div>
<script type="text/javascript">
<!--
var CollapsiblePanel1 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel1");
var CollapsiblePanel2 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel2");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur", "change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur", "change"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {validateOn:["blur"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {validateOn:["blur"]});
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "none", {validateOn:["blur"]});
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "none", {validateOn:["blur"]});
//-->
</script>

</div>

<?php
// End HTML content
?></body>
</html>
