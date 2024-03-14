<?php 
session_name("consulta");
session_start();
$cryptinstall="crypt/cryptographp.fct.php";
include $cryptinstall; 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Consulta en linea</title>
<script type="text/javascript" src="../content/js/prototype.js"></script>

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
	function autocateprog(){
	
	if(sprytextfield3.validate()){
	 var url = 'ajax/buscar_cateprog.php';
	 //alert(url);
	 var myRand = parseInt(Math.random()*999999999999999);  
	 
	 var code= $F('txtcodigo');
	 var pars = "rand="+myRand;
	 var pars =pars+"&code="+code;
	 var target = 'r_cateprog';
	 //alert(pars);
	 
     var miAjax = new Ajax.Updater(target, url, {method: 'get', parameters: pars, onComplete: verRespuesta});
	 
     }else{ 
	 	 alert('Error: Codigo de categoria programatica equivocada.');
	 };


}
	function verRespuesta(originalRequest)
	{
		//put returned XML in the textarea
		//$('hr').value = originalRequest.responseText;
		//vaciando el componente text.
		
		//recuperando el valor
		if(originalRequest.responseText=='Error: El proyecto no existe dentro de las categorias programaticas.'){
		   alert(originalRequest.responseText);$('proyecto').value=""; 
		}else{		   
		   $('proyecto').value=originalRequest.responseText; 
		};
}
function inicio(){
		$('ff').select();
		$('ff').focus();
}
//-->
</script>

</head>


<body>
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
          <td height="60"><input name="txtpin" type="password" id="txtpin" style="font-size:24px; width:150px;"/></td>
        </tr>
        <tr>
          <td width="140"><div align="right" class="Estilo23"><span class="Estilo18"></span></div></td>
          <td><?php dsp_crypt(0,1); ?></td>
        </tr>
        <tr>
          <td width="140" height="21"><div align="right" class="Estilo23">CODIGO</div></td>
          <td><input name="txtcodigo" type="text" id="txtcodigo" value="" style="font-size:24px; width:150px;"/></td>
        </tr>
        <tr>
          <td width="140" height="50"><div align="right"><img src="../img/arrow_right.gif" width="15" height="12" /></div></td>
          <td height="50"><label>
            <input type="submit" name="btingresar" id="btingresar" value="Iniciar Session"  style="height:35px; width:150px;"/>
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

</body>
</html>
