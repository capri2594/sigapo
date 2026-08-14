<?php 
 header('Expires: -1');
 header("Cache-control: no-store, no-cache, must-revalidate");
 header("Cache-control: post-ckeck=0, pre-check=0", false);
 header("Pragma: no-cache");
 header('Content-Type: text/html; charset=UTF-8');
 ?>
<?php
date_default_timezone_set("America/La_Paz"); 
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
 if (strcmp(ObtenerNavegador($_SERVER['HTTP_USER_AGENT']),'Mozilla Firefox')==0){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.::SIGAPO-Correspondencia 2026</title>
<link href="content/css/login_modern.css" rel="stylesheet" type="text/css" />
<link href="includes/jaxon/widgets/dialog/css/dialog.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="includes/kore/kore.js"></script>
<script type="text/javascript" src="includes/jaxon/js/panels.js"></script>
<script type="text/javascript" src="includes/jaxon/widgets/dialog/js/dialog.js"></script>
<script src="content/js/prototype.js" type="text/javascript"></script>
<script type="text/javascript" src="Scripts/AC_RunActiveContent.js"></script>

<script type="text/javascript" language="javascript">
function recordar_cuenta(){
     var url = 'autenticar_usuario.php';
     var myRand = parseInt(Math.random()*999999999999999);
     var pars = pars+"&rand="+myRand;
     var pars = pars+'&uid='+escape($F('uid'));
     if ($('r_cuenta').checked == true) {resp="si";}else{resp="no";}
     var pars = pars+'&r_cuenta='+resp;
     var target = 'dialogo';
     var miAjax = new Ajax.Updater(target, url, {method: 'get', parameters: pars});
}

function iniciarsession(){
     var url = 'autenticar_usuario.php';
     var myRand = parseInt(Math.random()*999999999999999);
     var pars = pars+"&rand="+myRand;
     var pars = pars+'&uid='+escape($F('uid'));
     var pars = pars+'&upwd='+escape($F('upwd'));
     if ($('r_cuenta').checked == true) {resp="si";}else{resp="no";}
     var pars = pars+'&r_cuenta='+resp;
     var target = '';
     var miAjax = new Ajax.Updater(target, url, {method: 'get', parameters: pars, onComplete: showResponse});
}

function showResponse(originalRequest) {
     var resultado=originalRequest.responseText;
     var resp=resultado.split(",");
     if(resp[0]=="400"){
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
     }else{
          $('uid').readonly='none';
     }
}

function anunderi(){
     new Widgets.Dialog('COMUNICADO', 'content/postales/anuncioderivaciones.php', { click_outside: true, width: 600, height: 480 });
}
</script>
</head>

<body onload="inicio();anunderi();">
<div id="dialogo" name="dialogo"></div>

<main class="login-container">
     <!-- Panel Izquierdo: Formulario de Login -->
     <section class="login-left">
          <?php 
          if (isset($_COOKIE["recordar_cuenta"])){
               $foto = $_COOKIE["recordar_cuenta"].".jpg";
               if(!file_exists("perfiles/fotos/".$foto)){
                    $foto = "default_avatar020.jpg";
               }
          }else{
               $foto = "sinfoto.png";
          }
          ?>
          <div class="avatar-wrapper">
               <img src="perfiles/fotos/<?php echo $foto; ?>" alt="foto de usuario" class="avatar-img" />
          </div>

          <div class="form-group">
               <label for="uid">Nombre de usuario</label>
               <input type="text" name="uid" id="uid" class="form-control" value="<?php 
                    if (isset($_COOKIE["recordar_cuenta"])){
                         echo $_COOKIE["recordar_cuenta"];
                    }
               ?>" onKeyPress="if(event.keyCode == Event.KEY_RETURN) iniciarsession();"/>
          </div>

          <div class="form-group">
               <label for="upwd">Clave de acceso</label>
               <input type="password" name="upwd" id="upwd" class="form-control" onKeyPress="if(event.keyCode == Event.KEY_RETURN) iniciarsession();"/>
          </div>

          <div class="form-group">
               <label class="checkbox-label">
                    <input type="checkbox" id="r_cuenta" name="r_cuenta" value="si" <?php 
                         if (isset($_COOKIE["recordar_cuenta"])){
                              echo "checked=\"checked\"";
                         } 
                    ?> onclick="verbloqueo();"/>
                    Recordar cuenta
               </label>
          </div>

          <div style="margin-top: 10px;">
               <form id="form1" name="form1" method="post" action="">
                    <input type="button" name="iniciar" id="iniciar" value="Iniciar Sesión" class="btn-primary" onclick="iniciarsession();" />
               </form>
          </div>

          <div class="update-banner">
               ACTUALIZACIÓN DE FUNCIONARIOS SIGAPO 2026<br />
               <span style="font-weight: normal; opacity: 0.9;">Presentar Reporte Impreso hasta 12 de Enero 2026</span><br />
               <a href="../registro_sigapo/index.php" target="_new">Registrar y Habilitar Usuarios SIGAPO 2025</a>
          </div>
     </section>

     <!-- Panel Derecho: Logotipo e Identidad Institucional -->
     <section class="login-right">
          <img src="img/ESCUDO_ORURO_SIN_FONDO.png" alt="Escudo Departamental de Oruro" class="logo-escudo" />
          <h1>Gobierno Autónomo Departamental de Oruro</h1>
          <div class="subtitle">Área de Tecnología de la Información</div>
          <h2 class="gestion-titulo">Gestión: 2026</h2>

          <div class="queries-container">
               <div class="queries-title">Consultas de Gestión</div>
               <div class="queries-list">
                    <a href="../sirc_2020" target="_new">Gestión 2020</a>
                    <a href="../sirc_2021" target="_new">Gestión 2021</a>
                    <a href="../sirc_2022" target="_new">Gestión 2022</a>
                    <a href="../sirc_2023" target="_new">Gestión 2023</a>
                    <a href="../sirc_2024" target="_new">Gestión 2024</a>
                    <a href="../sirc_2025" target="_new">Gestión 2025</a>
               </div>
          </div>
     </section>
</main>
</body>
</html>
<?php 
} else {
     echo "ACCESO PROHIBIDO";
}
?>
