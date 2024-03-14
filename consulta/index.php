<?php 
header('Expires: -1');
header("Cache-control: no-store, no-cache, must-revalidate");
header("Cache-control: post-ckeck=0, pre-check=0", false);
header("Pragma: no-cache");

session_name("consulta");
session_start();
$_SESSION['sid']=session_id();

$cryptinstall="crypt/cryptographp.fct.php";
include $cryptinstall; 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Consulta en linea</title>
<script language="Javascript">
<!--# Begin
document.oncontextmenu = function(){return false}
// End -->
</script> 
<script type="text/javascript" src="../content/js/prototype.js"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<style type="text/css">
<!--
.titulo {
	font-family: Georgia, "Times New Roman", Times, serif;
	font-size: 14px;
	color: #FFFFFF;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
	background-image: url(../img/gradient_tab_blue.gif);
	font-weight: bold;
	height: 30px;
	vertical-align: middle;
	margin-left: 5px;
	padding-left: 10px;
	font-style: oblique;
}
.titulo_campo {
	font-family: Arial, Helvetica, sans-serif;
	font-size: small;
	color: #444D75;
	font-weight: bold;
}
.campo_edit {
	font-family: Georgia, "Times New Roman", Times, serif;
	font-size: large;
	color: #464F7A;
	background-color: #F5F7FA;
}
body {
	background-image: url(../img/bac.png);
	background-repeat: repeat;
}
.Estilo18 {font-size: x-small}
.Estilo21 {font-family: Arial, Helvetica, sans-serif; font-size: large; color: #444D75; font-weight: bold; }
.Estilo23 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: medium;
	color: #444D75;
	font-weight: bold;
}
-->
</style>

<script type="text/javascript">
<!--
	function check_c(){
	
	 var url = 'content/ajax/verificar_code.php';
	 //alert(url);
	 var myRand = parseInt(Math.random()*999999999999999);  
	 
	 var code= $F('txtcodigo');
	 var pars = "rand="+myRand;
	 var pars =pars+"&code="+code;
	 var target = '';
//	 alert(pars);
	 
     var miAjax = new Ajax.Updater(target, url, {method: 'post', parameters: pars, onComplete: verRespuesta});


}
	function verRespuesta(originalRequest)
	{
		//put returned XML in the textarea
		//$('hr').value = originalRequest.responseText;
		//vaciando el componente text.
		
		//recuperando el valor
		//alert(originalRequest.responseText);
		resp=originalRequest.responseText;
		r=resp.split(".");
		if (r[0]=="ok") {
		//alert('correcto');
		//sessionc=r[0];
		}else{		   
		   document.images.cryptogram.src='crypt/cryptographp.php?cfg=0&&'+Math.round(Math.random(0)*1000)+1;
		   alert(originalRequest.responseText+'\n'+'Codigo no es igual al mostrado en la figura');//$('txtcode').value=""; 

		   //alert('cambiado');
		};
}

function check_p()
 {
	
    var url = 'content/ajax/verificar_pin.php';
	 //alert(url);
	 var myRand = parseInt(Math.random()*999999999999999);  
	 
	 var code= $F('txtpin');
	 var pars = "rand="+myRand;
	 var pars =pars+"&pin="+code;
	 var target = '';
	// alert(pars);
	 
     var miAjax = new Ajax.Updater(target, url, {method: 'post', parameters: pars, onComplete: verPin});
	 
 }
 
	function verPin(originalRequest)
    {
		//put returned XML in the textarea
		//$('hr').value = originalRequest.responseText;
		//vaciando el componente text.
		
		//recuperando el valor
		//alert(originalRequest.responseText);
		resp=originalRequest.responseText;
		r=resp.split(".");
		if (r[0]=="ok") {
		  //alert('correcto');
		  //sessionp=resp;
		}else{		   
		   alert(originalRequest.responseText+'\n'+'PIN incorrecto.'); 
		};
     }

function autentificar()
 {
	
    var url = 'content/ajax/verificar_acceso.php';
	 //alert(url);
	 var myRand = parseInt(Math.random()*999999999999999);  
	 var pars = "rand="+myRand;
	 var target = '';
	// alert(pars);
	 
     var miAjax = new Ajax.Updater(target, url, {method: 'post', parameters: pars, onComplete: verAcceso});
	 
 }
 
	function verAcceso(originalRequest)
    {
		//recuperando el valor
		//alert(originalRequest.responseText);
		resp=originalRequest.responseText;
		r=resp.split(".");
		if (r[0]=="ok") {
         ingreso();
		}else{		   
		   alert(originalRequest.responseText+'\n'+'Revise e intente nuevamente.'); 
		};
     }
	 
function ingreso(){
  theURL="content/seleccionarHR.php";
  /////alert(theURL);
  winName="_self";
  features="";
  var myRand = parseInt(Math.random()*999999999999999);  
  var pars = "rand="+myRand;
  var pars =pars+"&sid=<?php echo $_SESSION['sid']; ?>";
  //////alert(pars);
  theURL=theURL+"?"+pars;
  window.open(theURL,winName,features);
}	 
function check()
 {
	
	if((sprytextfield1.validate())&&(sprytextfield2.validate())){
	 check_p();
	 check_c();	 
	 autentificar();
	 /*	 
  theURL="content/seleccionarHR.php";
  /////alert(theURL);
  winName="_self";
  features="";
  var myRand = parseInt(Math.random()*999999999999999);  
  var pars = "rand="+myRand;
  var pars =pars+"&sid=<?php echo $_SESSION['sid']; ?>";
  //////alert(pars);
  theURL=theURL+"?"+pars;
   //var miAjax = new Ajax.Updater('pantallas', theURL, {method: 'get', parameters: pars});

	 ///alert(theURL);
	 		///alert(sessionp);
		///alert(sessionc);
        r1=sessionp.split(".");
		r2=sessionc.split(".");
		///alert(sessionp);
		///alert(sessionc);
		if ((r1[0]=="ok")&&(r2[0]=="ok")) {
		  //alert('correcto');
		    window.open(theURL,winName,features);
		}
		
		*/
		
		
     }else{ 
	 	 alert('Para ingresar, antes debe llenar los datos por favor.');
	 };
 }
 
 
function inicio(){
document.images.cryptogram.src='crypt/cryptographp.php?cfg=0&&'+Math.round(Math.random(0)*1000)+1;
		$('txtpin').select();
		$('txtpin').focus();
}
//-->
</script>


<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>


<body onload="inicio();">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="50">&nbsp;</td>
    <td height="50" valign="middle">&nbsp;</td>
    <td height="50">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="400" valign="middle" class="titulo">.:: Consulta en linea</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><table width="100%" border="0" cellpadding="3" cellspacing="5" bgcolor="#FFFFFF">
        <tr valign="bottom">
          <td width="140" height="60"><div align="right" class="Estilo21">PIN</div></td>
          <td height="60"><span id="sprytextfield1">
          <label>
          <input name="txtpin" type="password" id="txtpin" style="font-size:24px; width:150px;"  onkeypress="if(event.keyCode == Event.KEY_RETURN) check();"/>
          </label>
          <span class="textfieldRequiredMsg">Ingr. su PIN.</span><span class="textfieldMinCharsMsg">Min. 5 digitos.</span></span></td>
        </tr>
        <tr>
          <td width="140"><div align="right" class="Estilo23"><span class="Estilo18"></span></div></td>
          <td><?php dsp_crypt(0,1); ?></td>
        </tr>
        <tr>
          <td width="140" height="21"><div align="right" class="Estilo23">CODIGO</div></td>
          <td><span id="sprytextfield2">
          <input name="txtcodigo" type="text" id="txtcodigo" value="" style="font-size:24px; width:150px;" onkeypress="if(event.keyCode == Event.KEY_RETURN) check();"/>
          <span class="textfieldRequiredMsg">Copie las  letras de arriba.</span><span class="textfieldMinCharsMsg">Ingr. los 5 digitos.</span><span class="textfieldMaxCharsMsg">Ingrese 5 digitos.</span><span class="textfieldInvalidFormatMsg">Falta letras.</span></span></td>
        </tr>
        <tr>
          <td width="140" height="50"><div align="right"><img src="../img/arrow_right.gif" width="15" height="12" /></div></td>
          <td height="50"><label>
            <input type="button" name="btingresar" id="btingresar" value="Ingresar"  style="height:35px; width:150px;" onclick="check();"/>
          </label></td>
        </tr>
      </table></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><label></label></td>
    <td>&nbsp;</td>
  </tr>
</table>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {minChars:5, validateOn:["blur", "change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "custom", {hint:"Copie.", useCharacterMasking:true, pattern:"AAAAA", validateOn:["blur", "change"]});
//-->
</script>
</body>
</html>
