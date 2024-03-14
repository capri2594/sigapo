<?php 
 //header("Cache-Control: no-cache");
 header('Expires: -1');
 header("Cache-control: no-store, no-cache, must-revalidate");
 header("Cache-control: post-ckeck=0, pre-check=0", false);
 header("Pragma: no-cache");
 header('Content-Type: text/html; charset=UTF-8');
 ?>
<?php 
function ObtenerNavegador($user_agent) {
     $navegadores = array(
          'Opera' => 'Opera',
          'Mozilla Firefox'=> '(Firebird)|(Firefox)',
          'Galeon' => 'Galeon',
          'Mozilla'=>'Gecko',
          'MyIE'=>'MyIE',
          'Lynx' => 'Lynx',
          'Netscape' => '(Mozilla/4\.75)|(Netscape6)|(Mozilla/4\.08)|(Mozilla/4\.5)|(Mozilla/4\.6)|(Mozilla/4\.79)',
          'Konqueror'=>'Konqueror',
          'Internet Explorer 7' => '(MSIE 7\.[0-9]+)',
          'Internet Explorer 6' => '(MSIE 6\.[0-9]+)',
          'Internet Explorer 5' => '(MSIE 5\.[0-9]+)',
          'Internet Explorer 4' => '(MSIE 4\.[0-9]+)',
);
foreach($navegadores as $navegador=>$pattern){
       if (eregi($pattern, $user_agent))
       return $navegador;
    }
return 'Desconocido';
}
?>

<?php 
 //echo ObtenerNavegador($_SERVER['HTTP_USER_AGENT']);
 if (strcmp(ObtenerNavegador($_SERVER['HTTP_USER_AGENT']),'Mozilla Firefox')==0){
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.::SIGAPO-Correspondencia 2013</title>
<style type="text/css">
<!--
body {
	margin: 0px;
	padding: 0px;
	background-color: #454545;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-style: normal;
	font-weight: normal;
	color: #FFFFFF;
}
.ventana {
	background-image: url(img/ventana1.png);
	background-repeat: no-repeat;
	height: 500px;
	width: 400px;
}
#apDiv1 {
	/*position:relative;
	left:30px;
	top:80px;*/
	width:147px;
	height:137px;
	//z-index:1;
	background-image: url(img/cuadro_usuario2.png);
	background-repeat: no-repeat;
	margin: 0px;
	padding: 0px;
}
.Estilo1 {
	font-size: 18px;
	text-decoration: underline;
}
#apDiv2 {
	position:absolute;
	left:270px;
	top:454px;
	width:121px;
	height:58px;
	z-index:1;
}
-->
</style>
<script type="text/javascript" src="content/js/prototype.js"></script>
<script type="text/javascript" language="javascript">
		function recordar_cuenta(){
     var url = 'autenticar_usuario.php';
	 var myRand = parseInt(Math.random()*999999999999999);
     var pars = pars+"&rand="+myRand;
	 var pars = pars+'&uid='+escape($F('uid'));
	if ($('r_cuenta').checked == true) {resp="si";}else{resp="no";}
	//if ($('r_cuenta').ckeched==false) alert('no seleccionado');
	 var pars = pars+'&r_cuenta='+resp;
	 	 
     var target = 'dialogo';
	 //alert(pars);
     var miAjax = new Ajax.Updater(target, url, {method: 'get', parameters: pars});
}
		function iniciarsession(){
     var url = 'autenticar_usuario.php';
	 var myRand = parseInt(Math.random()*999999999999999);
     var pars = pars+"&rand="+myRand;
	 var pars = pars+'&uid='+escape($F('uid'));
	 var pars = pars+'&upwd='+escape($F('upwd'));
	if ($('r_cuenta').checked == true) {resp="si";}else{resp="no";}
	//if ($('r_cuenta').ckeched==false) alert('no seleccionado');
	 var pars = pars+'&r_cuenta='+resp;
	 //alert(pars);	 
     var target = '';
     var miAjax = new Ajax.Updater(target, url, {method: 'get', parameters: pars, onComplete: showResponse});
	 //alert(miAjax);
}
	function showResponse(originalRequest)
	{
		//recuperando el valor
		var resultado=originalRequest.responseText;
		//separando campos
		//alert(resultado);
		var resp=resultado.split(",");
		if(resp[0]=="400"){
	    //var numero=codigo.split("-");
	   //alert(numero[1]);
	   //insertando en el campo "hr" el ultimo valor disponible...
	   //alert("correcto");
	   //document.location.href="index_.php";
	   //alert(resp[2]);
	   //top.document.location.href=resp[2]+'.'+resp[3];
         //document.location.href=resp[2];//+'.'+resp[3];
         document.location.href=resp[2];

	   }else{
	        if(resp[0]=="404"){
		    alert("Usuario incorrecto. Revise e intente nuevamente");
	    	     }else{
		         if(resp[0]=="600"){
		     alert("Su cuenta esta bloqueada. \n Comuniquese con el Administrador del Sistema");
		         }
		    }
	   }
	   
	   //$('hr').value=parseInt(numero[1])+1;
}
     function inicio(){
		if ($F('uid')==""){
		verbloqueo();
		$('uid').select();
		$('uid').focus();
		}else{
		$('upwd').select();
		$('upwd').focus();
		}
		
		}
		
	 function verbloqueo(){
	 if ($('r_cuenta').checked == true){
	 $('uid').readonly='readonly';
	 }else
	 {$('uid').readonly='none';
	 }
	 
	 }
	 
</script>
</head>

<body onload="inicio();" >

<div id="dialogo" name="dialogo">	
</div>
<table width="100%" border="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td class="ventana"><table width="100%" border="0">
            <tr style="height:10px;">
              <td width="70">&nbsp;</td>
              <td width="180">&nbsp;</td>
              <td width="70">&nbsp;</td>
              </tr>
            <tr align="right">
              <td width="70" align="right">&nbsp;</td>
              <td width="180" align="right"><table width="100%" border="0">

                <tr>
                  <td>&nbsp;</td>
                  <td><div id="apDiv1" align="right">
                <div align="right">
                  <table width="100%" border="0" cellpadding="5" cellspacing="5">
                      <tr>
                        <td align="center" valign="middle"><div align="center">
		<?php 
						 if (isset($_COOKIE["recordar_cuenta"])){
      //es que tengo la cookie
	  //verificando si tiene foto... file_exists
	  
      $foto = $_COOKIE["recordar_cuenta"].".jpg";
	  if(file_exists("perfiles/fotos/".$foto)){
	                       //cargar la foto de la cuenta....
                            }else{
							$foto="default_avatar020.jpg";  //mostrar avatar_default....
							}
			//si no pidio recordar cuenta colocar icono de Messenger....				
					      }else{
							$foto="sinfoto.png";
						   }
						  
	   ?>
   
   <img src="perfiles/fotos/<?php echo $foto; ?>" alt="foto" /></div></td>
                      </tr>
                            </table>  
                </div>
              </div></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </table></td>
              <td width="70">&nbsp;</td>
              </tr>
            <tr>
              <td>&nbsp;</td>
              <td>Nombre de usuario:</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td width="70">&nbsp;</td>
              <td width="180">
              		
                <input type="text" name="uid" id="uid" value="<?php 
						 if (isset($_COOKIE["recordar_cuenta"])){
      //es que tengo la cookie
      echo $_COOKIE["recordar_cuenta"];
                            }
	   ?>" onKeyPress="if(event.keyCode == Event. KEY_RETURN) iniciarsession();"/>              </td>
              <td width="70">&nbsp;</td>
              </tr>
            <tr>
              <td width="70">&nbsp;</td>
              <td><label>Clave se acceso:</label></td>
              <td width="70">&nbsp;</td>
              </tr>
            <tr>
              <td>&nbsp;</td>
              <td><input type="password" name="upwd" id="upwd" onKeyPress="if(event.keyCode == Event. KEY_RETURN) iniciarsession();"/></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><table width="100%" border="0">
                <tr>
                  <td><label>
                    <input type="checkbox" id="r_cuenta" name="r_cuenta" value="si" "<?php 
						 if (isset($_COOKIE["recordar_cuenta"])){
      //es que tengo la cookie
      echo "checked=\"checked\"";
                            } ?>" onclick="verbloqueo();"/>
                  Recordar cuenta de usuario</label></td>
                  </tr>
                <!--<tr>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  </tr>-->
              </table></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><form id="form1" name="form1" method="post" action="">
                <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="button" name="iniciar" id="iniciar" value="Iniciar Sesion" onclick="iniciarsession();" />
                </label>
              </form>              
              </td>
              <!--aumentado-->
              <tr>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  </tr>
                  <!--aumentado-->
              <td></td>
            </tr>
            <tr>
              <td height="50">&nbsp;</td>
              <td height="50" colspan="2"><div align="right"><span class="Estilo1">GOBIERNO AUTONOMO <br />
                DPTAL. DE ORURO  </span></div></td>
              </tr>
            <tr>
              <td height="100">&nbsp;</td>
              <td height="100">
           
              <div style="color:#FFF; font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold;">CONSULTAS:<br /><br />
                          
                <a href="ftp://192.168.128.31" style="color:#0F9; font-family:Georgia, 'Times New Roman', Times, serif; font-size:12px; font-weight:bold;">Gestion Prefectura 2008-2010</a><br /><br />
                <a href="../sirc_2011" style="color:#FFFF2F; font-family:Georgia, 'Times New Roman', Times, serif; font-size:12px; font-weight:bold;">Gestion Gobierno 2010-2011</a></div><br />
                <a href="../sirc_2012" style="color:#FA8599; font-family:Georgia, 'Times New Roman', Times, serif; font-size:12px; font-weight:bold;" target="_new">Gestion Gobierno 2012</a></div><br /><br /><br />
                </td>
              <td height="100"><p><img src="img/logo_sigapo32_pequeño.png" width="75" height="69" /></br>
                  <br />
                  Gestion:<span class="Estilo1">2013</span></p>                </td>
            </tr>
          </table></td>
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
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php }
else
{
  echo "ACCESO PROHIBIDO";
}?>