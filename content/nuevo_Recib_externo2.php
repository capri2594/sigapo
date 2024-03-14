<?php 
session_name("LoginSIRC");
session_start();
header("Content-Type: text/html; charset=utf-8");
//echo  "dep:".$_SESSION['dep']
//$cod_dep=$_SESSION['cod_dep'];
//echo  "dep:".$cod_dep;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Registro ENTRADA::INTERNA</title>

<script src="js/calendario.js" type="text/javascript"></script>
<link href="js/calendario.css" rel="stylesheet" type="text/css" />
<script src="js/prototype.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
        <script language="javascript">
		function temas(){
     var url = 'selec_temas.php';
	 var myRand = parseInt(Math.random()*999999999999999);

     var pars = 'jose='+escape($F('tema'));
	 var pars = pars+"&rand="+myRand;
     var target = 'spry_tema';
     var miAjax = new Ajax.Updater(target, url, {method: 'get', parameters: pars});
}
		function tipos(){
     var url = 'selec_tipos.php';
	 var myRand = parseInt(Math.random()*999999999999999);

     var pars = 'jose='+escape($F('tema'));
	 var pars = pars+"&rand="+myRand;
     var target = 'spry_tipo';
     var miAjax = new Ajax.Updater(target, url, {method: 'get', parameters: pars});
}
		</script>
        <script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
function MM_popupMsg(msg) { //v1.0
  alert(msg);
}
function MM_showHideLayers() { //v9.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) 
  with (document) if (getElementById && ((obj=getElementById(args[i]))!=null)) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}
function MM_effectShake(targetElement)
{
	Spry.Effect.DoShake(targetElement);
}
function MM_effectGrowShrink(targetElement, duration, from, to, toggle, referHeight, growFromCenter)
{
	Spry.Effect.DoGrow(targetElement, {duration: duration, from: from, to: to, toggle: toggle, referHeight: referHeight, growCenter: growFromCenter});
}
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
        <style type="text/css">
<!--
.botoncitos {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: 100;
	color: #FFFFFF;
	background-color: #0033CC;
	height: 20px;
}
.cuadro_superior {
	font-family: Arial, Helvetica, sans-serif;
	background-color: #D6EAFE;
	border: 1px solid #CAE9FF;
	font-size: 12px;
}
.botoncitos2 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: 100;
	color: #FFFFFF;
	background-color: #3366CC;
	height: 20px;
	border: 2px solid #4B4B4B;
}
.botones {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: 100;
	color: #FFFFFF;
	background-color: #000033;
	height: 20px;
}
.botones1 {	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	height: 20px;
}
-->
        </style>
        <link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="100%" border="0">
    <tr>
      <td><div align="right">
        <input name="button2" type="submit" class="botones" id="button2" value="Guardar Registro de Correspondencia" />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#CBDFFE"><table width="100%" border="0">
        <tr class="cuadro_superior">
          <td><fieldset>
            <legend>Origen-Destino</legend>
            <table width="100%" border="0">
              <tr>
                <td width="35">De:</td>
                <td width="100"><span id="sprytextfield1">
                  <input name="seg_f_destino" type="text" id="seg_f_destino" size="30" />
                  <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
                <td width="100"><span id="sprytextfield2">
                  <input type="text" name="seg_d_destino" id="seg_d_destino" />
                  <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
                <td><input name="button5" type="button" class="botones1" id="button5" onclick="MM_openBrWindow('insert_fun_Destino3.php','','left=150,top=150,width=620,height=315')" value="BUSCAR" /></td>
                </tr>
              <tr>
                <td>Para:</td>
                <td><input name="text2" type="text" id="text2" size="30" /></td>
                <td><input name="text4" type="text" id="text4" value="<?php echo $_SESSION['dep']; ?>" /></td>
                <td>&nbsp;</td>
                </tr>
              </table>
          </fieldset>          </td>
          <td><fieldset>
            <legend>Hoja de Ruta</legend>
            <table width="100%" border="0">

              <tr>
                <td>Nro:</td>
                <td><input name="hr" type="text" id="hr" size="10" /></td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              </table>
          </fieldset>          </td>
          </tr>

      </table></td>
    </tr>
    <tr>
      <td><table width="100%" border="0">
        <tr>
          <td><fieldset>
            <legend>Datos de la Correspondencia</legend>
            <table width="100%" border="0">
              <tr>
                <td>Fech.Doc</td>
                <td><input name="fecha_doc" type="text" id="fecha_doc" size="10" readonly="READONLY"title="YYYY-MM-DD"/>
                  <input type="button" value="calendario" onclick="displayCalendarFor('fecha_doc');" />                  </td>
                </tr>
              <tr>
                <td>Cite</td>
                <td><span id="sprytextfield3">
                  <input type="text" name="cite" id="cite" />
                  <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
                </tr>
              <tr>
                <td>Ref.</td>
                <td><span id="sprytextfield4">
                  <input name="ref" type="text" id="ref" size="46" />
                  <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
                </tr>
              <tr>
                <td>Hojas</td>
                <td><span id="sprytextfield5">
                  <input type="text" name="nhojas" id="nhojas" />
                  <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
              </tr>
              <tr>
                <td>Anexos</td>
                <td><textarea name="anexos" id="anexos" cols="35" rows="3">-
-</textarea></td>
              </tr>
              <tr>
                <td>Obs.</td>
                <td><textarea name="obs" id="obs" cols="35" rows="5">N.A.</textarea></td>
              </tr>
              </table>
          </fieldset>          </td>
          <td><table width="100%" border="0">
            <tr>
              <td><fieldset>
                <legend>Clasificacion</legend>
                <table width="100%" border="0">
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><input name="button3" type="button" class="botoncitos2" id="button3" onclick="MM_openBrWindow('agregar_tema.php','','width=600,height=350')" value="Ad(+)" />
                      Tema</td>
                    <td>&nbsp;</td>
                    </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td><input name="refresh_tema" type="button" class="botoncitos2" id="refresh_tema"  onclick="temas();" value="Actualizar Temas"/></td>
                  </tr>
                  <tr>
                    <td><input name="button4" type="button" class="botoncitos2" id="button4" onclick="MM_openBrWindow('agregar_tipo.php','','width=600,height=380')" value="Ad(+)" />
                      Tipo.doc                      <br /></td>
                    <td>&nbsp;</td>
                    </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td><input name="refresh_tipo" type="button" class="botoncitos2" id="refresh_tipo"  onclick="tipos();" value="Actualizar Tipos."/></td>
                  </tr>
                    </table>
              </fieldset>              </td>
              </tr>
            <tr>
              <td><fieldset>
                <legend>Recibido</legend>
                <table width="100%" border="0">
                  <tr>
                    <td>Fech.Recib.</td>
                    <td><input name="fech.recib" type="text" id="fech.recib" size="16" value="<?php echo date("Y-m-d H:i:s"); ?>" /></td>
                    </tr>
                  <tr>
                    <td>Nom. Recib.</td>
                    <td><input name="fun_recib" type="text" id="fun_recib" value="<?php echo $_SESSION['fun']; ?>" size="25" /></td>
                    </tr>
                    </table>
              </fieldset>              </td>
              </tr>

          </table></td>
          </tr>

      </table></td>
    </tr>
    <tr>
      <td><label>
        <input name="button" type="button" class="botones" id="button" value="Guardar Registro de Correspondencia" />
        <input type="submit" name="button6" id="button6" value="Antes" />
        <input type="submit" name="button7" id="button7" value="Despues" />
      </label></td>
    </tr>
  </table>
</form>

<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
//-->
</script>
</body>
</html>
