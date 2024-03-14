<?php
 // Load the common classes
 require_once('includes/common/KT_common.php');
 // Load panels classes
 require_once('includes/jaxon/panels/panels.inc.php');

/**
 * This contains the entire panels configuration
 */
$ctrl = new PanelController();

// Begin panels section
// Begin panel - Content
$panel_Content = & $ctrl->createPanel("Content");
$panel_Content->setStyle("rounded");
$panel_Content->setUpdateEffect("");
$panel_Content->addState("", "content/hoy.php", "Mostrar Hoy", "", "");
$panel_Content->addState("enviar", "content/enviar.php", "Enviar", "", "");
$panel_Content->addState("recibir", "content/recibir.php", "Recibir", "", "");
$panel_Content->addState("ei_nuevo", "content/ei_nuevo.php", "Enviar nuevo interno", "", "");
$panel_Content->addState("Enviarnuevo", "content/enviarnuevo.php", "Enviar nuevo externo", "", "");
$panel_Content->addState("tooltip_enviar", "content/tooltip_enviar.php", "Tooltip Enviar", "", "");
$panel_Content->addState("nuevob", "content/nuevob.php", "Nuevoblanco", "", "");
$panel_Content->addState("tooltip_recibir", "content/tooltip_recibir.php", "Tooltip Recibir", "", "");
$panel_Content->addState("enviarExt", "enviarExt.php", "Enviar Ext", "", "");
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
$panel_Menu = & $ctrl->createPanel("Menu");
$panel_Menu->setStyle("rounded");
$panel_Menu->setUpdateEffect("");
$panel_Menu->addState("", "content/menu.php", "", "", "");
// End panel - Menu

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
<link href="includes/jaxon/css/panels.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="includes/kore/kore.js"></script>
<script type="text/javascript" src="includes/jaxon/js/panels.js"></script>
<script type="text/javascript">
<?php echo $ctrl->serializeConfigToJs(); ?>
</script>
</head>
<body>
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
?>
