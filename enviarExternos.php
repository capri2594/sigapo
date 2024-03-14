<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.Estilo2 {font-size: small}
-->
</style>
<script src="SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>

<body>
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
              <input type="submit" name="buscar" id="buscar" value="Buscar" /></td>
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
                      <input type="text" name="tremite" id="tremite" />
                      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span>
                      <input name="cambiar" type="submit" id="cambiar" onclick="MM_openBrWindow('content/buscarFunRemite.php','vbuscarFunRemite','width=700,height=600')" value="Cambiar" /></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>Dependencia</td>
                    <td><span id="sprytextfield2">
                      <input type="text" name="tdep_remite" id="tdep_remite" />
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
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6");
//-->
</script>
</body>
</html>
