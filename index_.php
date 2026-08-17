<?php 
 // Sessiones y declaracion de variables

// header('Expires: -1');
// header("Cache-control: no-store, no-cache, must-revalidate");
// header("Cache-control: post-ckeck=0, pre-check=0", false);
// header("Pragma: no-cache");
 header('Content-Type: text/html; charset=UTF-8');
 session_name("LoginSIRC"); 
 session_start();

// session_register('fun','user','cargo','cod_dep','dep','sid');
// $_SESSION['sid']=session_id();
// $_SESSION['user']=$_GET['uid'];
 
?>
<?php require_once('Connections/snet.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

 // Load the common classes
 require_once('includes/common/KT_common.php');
 // Load panels classes
 require_once('includes/jaxon/panels/panels.inc.php');

$colname_info_user = "-1";
if (isset($_SESSION['user'])) {
  $colname_info_user = $_SESSION['user'];
}
mysql_select_db($database_snet, $snet);
$query_info_user = sprintf("SELECT nombre, dependencia_cod, cargo, dependencia.nombredep, dependencia.sigla FROM funcionario, dependencia WHERE usuario_cuenta = %s AND funcionario.dependencia_cod=dependencia.cod", GetSQLValueString($colname_info_user, "text"));
$info_user = mysql_query($query_info_user, $snet) or die(mysql_error());
$row_info_user = mysql_fetch_assoc($info_user);
$totalRows_info_user = mysql_num_rows($info_user);

//rescatando las variables a la SESSION...
 $_SESSION['fun']=$row_info_user['nombre'];
 $_SESSION['cod_dep']=$row_info_user['dependencia_cod'];
 $_SESSION['dep']=$row_info_user['nombredep'];
 $_SESSION['cargo']=$row_info_user['cargo'];
 $_SESSION['sigla']=$row_info_user['sigla'];

/**
 * This contains the entire panels configuration
 */
$ctrl = new PanelController();

// Begin panels section
// Begin panel - Content
$panel_Content = & $ctrl->createPanel("Content");
$panel_Content->setStyle("rounded");
$panel_Content->setUpdateEffect("");
$panel_Content->addState("", "content/hoy.php", ".::SIGAPO::CORRESPONDENCIA 2026", "", "");
$panel_Content->addState("enviar", "content/enviar.php", "Enviar", "", "");
$panel_Content->addState("recibir", "content/recibir.php", "Recibir", "", "");
$panel_Content->addState("ei_nuevo", "content/ei_nuevo.php", "Enviar nuevo interno", "", "");
$panel_Content->addState("Enviarnuevo", "content/enviarnuevo.php", "Enviar nuevo externo", "", "");
$panel_Content->addState("tooltip_enviar", "content/tooltip_enviar.php", "Tooltip E&nbsp;&nbsp;&nbsp;nviar", "", "");
$panel_Content->addState("nuevob", "content/nuevob.php", "Nuevoblanco", "", "");
$panel_Content->addState("tooltip_recibir", "content/tooltip_recibir.php", "Tooltip Recibir", "", "");
$panel_Content->addState("enviarExt", "enviarExt.php", "Enviar Ext", "", "");
$panel_Content->addState("recibirInternos", "recibirInternos.php", "Recibir Internos", "", "");
$panel_Content->addState("recibirExterno", "recibirExterno.php", "Recibir Externo", "", "");
$panel_Content->addState("showRecibido", "content/showRecibido.php", "Show Recibido", "", "");
$panel_Content->addState("menuRecibirInternos", "content/menuRecibirInternos.php", "Menu Recibir Internos", "", "");
$panel_Content->addState("menuRecibirInternos2", "content/menuRecibirInternos2.php", "Menu Recibir Internos2", "", "");
$panel_Content->addState("showRecibirExternos", "content/showRecibirExternos.php", "Show Recibir Externos", "", "");
$panel_Content->addState("showRecibirInternos", "content/showRecibirInternos.php", "Show Recibir Internos", "", "");
$panel_Content->addState("insert_HR", "content/insert_HR.php", "Insert HR", "", "");
$panel_Content->addState("hr_forma2", "content/hr_forma2.php", "DERIVACION", "", "");
$panel_Content->addState("hr_simple", "content/hr_simple.php", "Hr Simple", "", "");
$panel_Content->addState("tooltip_hr_form1", "content/tooltip_hr_form1.php", "Tooltip Hr Form1", "", "");
$panel_Content->addState("tooltip_hr_form2", "content/tooltip_hr_form2.php", "Tooltip Hr Form2", "", "");
$panel_Content->addState("Prefil_Usuario", "content/Prefil_de_Usuario.php", "Prefil De Usuario", "Datos del funcionario Pubico", "perfil de usuario");
$panel_Content->addState("buscar_entradas", "content/buscar_entradas.php", "Buscar Entradas", "", "");
$panel_Content->addState("detalles_entradas_in", "content/detalles_entradas_in.php", "Detalles Entradas In", "", "");
$panel_Content->addState("detalles_entradas_ex", "content/detalles_entradas_ex.php", "Detalles Entradas Ex", "", "");
$panel_Content->addState("detalle_corresp_interna", "content/detalle_corresp_interna.php", "Detalle Corresp Interna", "", "");
$panel_Content->addState("rep_flujo_diario", "content/rep_flujo_diario.php", "Rep Flujo Diario", "", "");
$panel_Content->addState("rep_in_gral", "content/rep_in_gral.php", "Rep In Gral", "", "");
$panel_Content->addState("tooltip_usuariosonline", "content/tooltip_usuariosonline.php", "Tooltip Usuariosonline", "", "");
// End panel - Content

// Begin panel - Footer
$panel_Footer = & $ctrl->createPanel("Footer");
$panel_Footer->setStyle("rounded");
$panel_Footer->setUpdateEffect("");
$panel_Footer->addState("", "content/footer.php", "", "", "");
// End panel - Footer

// Begin panel - Header
$panel_Header = & $ctrl->createPanel("Header");
$panel_Header->setStyle("gradient");
$panel_Header->setUpdateEffect("");
$panel_Header->addState("", "content/header.php", "", "", "");
// End panel - Header

// Begin panel - Menu
/*
$panel_Menu = & $ctrl->createPanel("Menu");
$panel_Menu->setStyle("rounded");
$panel_Menu->setUpdateEffect("");
$panel_Menu->addState("", "content/menu.php", "", "", "");
*/
// End panel - Menu

// Begin panel - Menu2
$panel_Menu = & $ctrl->createPanel("Menu");
$panel_Menu->setStyle("rounded");
$panel_Menu->setUpdateEffect("");
//condiconal para cargar un tipo de menu
if($_SESSION['tipo_usuario'] == "recepcion" || $_SESSION['tipo_usuario'] == "jefe")
	$panel_Menu->addState("", "content/menu.php", "", "", "");
else
	$panel_Menu->addState("", "content/menu2.php", "", "", "");
// End panel - Menu2

$ctrl->setMasterPanel("Content");
// End panels section


$ctrl->init();

// MX AJAX javascript request handling
require_once('includes/jaxon/panels/mx_ajax_request.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{{TITLE}}</title>
<meta name="description" content="{{META_DESCRIPTION}}"/>
<meta name="keywords" content="{{META_KEYWORDS}}"/>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<meta http-equiv="imagetoolbar" content="no">
<meta http-equiv="pragma" content="no-cache">
<script language="Javascript"> var TimeID; function timer() { window.clipboardData.clearData(); timeID = setTimeout("timer()", 100); } </script>
<link href="includes/jaxon/css/panels.css" rel="stylesheet" type="text/css" />
<style type="text/css">
/* Override Jaxon default panel backgrounds to remove white bands */
.white_rounded b.artop b, 
.white_rounded b.arbottom b, 
.white_rounded .rcontent,
.gradient_rounded b.artop b, 
.gradient_rounded b.arbottom b, 
.gradient_rounded .rcontent {
     background-color: #0f172a !important;
     background-image: none !important;
     border-color: rgba(255, 255, 255, 0.05) !important;
}

div.rcontent {
     background-color: #0f172a !important;
     padding: 0px !important;
}

#wrapper {
     background-color: #0f172a !important;
}

.artop, .arbottom {
     background-color: #0f172a !important;
}
</style>
<link href="content/css/dashboard_modern.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="includes/kore/kore.js"></script>
<script type="text/javascript" src="includes/jaxon/js/panels.js"></script>
<script type="text/javascript" src="includes/jaxon/widgets/dialog/js/dialog.js"></script>
<script src="content/js/prototype.js" type="text/javascript"></script>
<script language="JavaScript1.2" src="content/js/usuario_session.js" type="text/javascript"></script>
<script language="JavaScript1.2" src="content/js/usuarios_online.js" type="text/javascript"></script>
<link href="includes/jaxon/widgets/dialog/css/dialog.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="includes/jaxon/widgets/dialog/js/dialog.js"></script>
<link href="includes/jaxon/widgets/dialog/css/dialog.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="Scripts/AC_RunActiveContent.js"></script>

<script type="text/javascript">
<?php echo $ctrl->serializeConfigToJs(); ?>
function postales(){
     new Widgets.Dialog('SIGAPO 2019::', 'content/postales/pub_spot.php', { click_outside: true, width: 525, height: 475 });
	 
 }
function nit(){
     new Widgets.Dialog('LEER', 'content/postales/nit.php', { click_outside: true, width: 525, height: 440 });
	 
 }
 function anunderi(){
     new Widgets.Dialog('LEER', 'content/postales/anuncioderivaciones.php', { click_outside: true, width: 600, height: 480 });
	 
 }

 function intro(){
     new Widgets.Dialog('SIGAPO 2026:: MENSAJE', 'content/postales/intro3.php', { click_outside: true, width: 525, height: 440 });
	 
 }
window.onbeforeunload=function(){
   alert('EL sistema esta alistando el cierre del Programa.\n Se perderan los datos NO GRABADOS.');
   ventana.close();
   return false;
}

</script>
</head>
<!--Para borrar circular de adelante-->
<body onload="usuario();usuarios_online();" style="background-color: #0f172a !important; background-image: none !important;">
<!--<body onload="usuario();usuarios_online(); anunderi();" style="background:url(img/bgpanel.png);">-->

<div id="wrapper" class="twocols">
  <div id="header">
    <?php
$panel_Header->renderBegin();
require($panel_Header->getFileName());
$panel_Header->renderEnd();
?>
  </div>
  <div id="left">
    <?php
$panel_Menu->renderBegin();
require($panel_Menu->getFileName());
$panel_Menu->renderEnd();
?>
  </div>
  <div id="center">
    <?php
$panel_Content->renderBegin();
require($panel_Content->getFileName());
$panel_Content->renderEnd();
?>
  </div>
  <br style="clear: both" />
  <div id="footer">
    <?php
$panel_Footer->renderBegin();
require($panel_Footer->getFileName());
$panel_Footer->renderEnd();
?>
  </div>
</div>

<?php echo $ctrl->renderJsBindings(true); ?>
<?php require_once("includes/jaxon/loading.html"); ?></body>
</html>
<?php
$ctrl->end();

mysql_free_result($info_user);
?>
