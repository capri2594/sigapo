<?php 
 //header("Cache-Control: no-cache");
 header('Content-Type: text/html; charset=UTF-8');
 session_name("LoginSIRC"); 
 session_start();

 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>cambiar password</title>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="css/main.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo1 {
	color: #FFFFFF;
	font-size: 11pt;
}
.msg_sis {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #003366;
	background-color: #FFFFEC;
	border: 1px solid #FFCC00;
	padding: 5px;
}
-->
</style>
<script type="text/javascript" src="js/scriptaculous/prototype.js"></script>
<script type="text/javascript">
	function cpswd(){
     var url = 'ajax/cambiar_pswd.php';
	 //alert(url);
	 var myRand = parseInt(Math.random()*999999999999999);  
	 var pars = "rand="+myRand;
	     pars = pars+"&cuenta=<?php echo $_SESSION['user']; ?>";
	     pars = pars+"&old_pswd="+escape($F('pswd'));
	     pars = pars+"&new_pswd="+escape($F('npswd'));
		 pars = pars+"&repeat_new_pswd="+escape($F('rnpswd'));
     var target = 'msg_sistema';
	 //alert(pars);
     var miAjax = new Ajax.Updater(target, url, {method: 'get', parameters: pars, onComplete: showResponse});
	 //alert(miAjax);
}//fin cambio de password.... 
	function showResponse(originalRequest)
	{
		//put returned XML in the textarea
		var resultado=originalRequest.responseText;
		//separando campos
	    var ok=resultado.split(":");
	   //alert(numero[1]);
	   //insertando en el campo "hr" el ultimo valor disponible...
	   if (ok[0]=='(ok-correcto)'){
	             //alert('vaciar formulario');
				 $('pswd').value="";
				 $('npswd').value="";
				 $('rnpswd').value="";
	   }		 
	   
 }
   
	
 function enviar(){
 
 confirmar=confirm('Esta seguro?. Desea cambiar la contraseña.');
	if (confirmar==true)
	{
	   if(($F('pswd')=="")||($F('npswd')=="")||($F('rnpswd')=="")||($F('cuenta')=="")){
	   alert('[error-formulario]: No se permiten campos vacios');
	   exit(0);
	   }else{cpswd();}
	}
	
}	
</script>
</head>

<body>
  <table width="400" border="0" align="center" cellspacing="0">
    <tr>
      <td class="msg_sis"><table width="100%" border="0">
        <tr>
          <td width="50" align="center"><img src="imagen/s_notice.png" alt="informacion" width="16" height="16" longdesc="informacion" /></td>
          <td><div id="msg_sistema" name="msg_sistema">Favor, llenar el siguiente formulario.</div></td>
          </tr>

      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="40" bgcolor="#54617E" class="td-border-style-9 Estilo1">Cambio de Contraseña
      <input name="cuenta" type="hidden" id="cuenta" value="<?php echo $_SESSION['user']; ?>" /></td>
    </tr>
    <tr>
      <td><table width="100%" border="0" cellpadding="0" cellspacing="6" bgcolor="#F3F9FE" class="td-border-style-6">
          <tr>
            <td height="30">Password Actual:</td>
            <td height="30"><span id="sprytextfield1">
              <label>
              <input type="password" name="pswd" id="pswd" />
              </label>
            <span class="textfieldRequiredMsg">x</span></span></td>
            <td height="30">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Nuevo Password:</td>
            <td><span id="sprytextfield2">
              <label>
              <input type="password" name="npswd" id="npswd" />
              </label>
            <span class="textfieldRequiredMsg">x</span></span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Repetir el Nuevo Password:</td>
            <td><span id="sprytextfield3">
              <label>
              <input type="password" name="rnpswd" id="rnpswd" />
              </label>
            <span class="textfieldRequiredMsg">x</span></span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td height="60"><label>
        <div align="center">
          <input name="button" type="submit" id="button" value="Guardar" onclick="enviar();"/>
        </div>
      </label></td>
    </tr>
  </table>

<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {validateOn:["blur"]});
//-->
</script>
</body>
</html>
