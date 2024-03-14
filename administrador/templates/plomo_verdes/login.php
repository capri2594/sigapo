<?php
/**
* @version $Id: login.php 5973 2006-12-11 01:26:33Z robs $
* @package Joomla
* @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
* Modificada por joomlaspanish.org. // 1-07-2006 
*/

/** ensure this file is being included by a parent file */

?>
<?php echo "<?xml version=\"1.0\"?>\r\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $mosConfig_sitename; ?> - Administración [Joomla]</title>
<meta http-equiv="Content-Type" content="text/html; <?php echo _ISO; ?>" />
<style type="text/css">
@import url(archivos/css/admin_login.css);
</style>
<script language="javascript" type="text/javascript">
	function setFocus() {
		document.loginForm.usrname.select();
		document.loginForm.usrname.focus();
	}
</script>
<link rel="shortcut icon" href="/images/favicon.ico" />
</head>
<body onload="setFocus();">
<div id="wrapper">
	<div id="header">
			<div id="joomla"><img src="archivos/images/header_text.gif" alt="SIGAPO! Logo" /></div>
	</div>
</div>
<div id="ctr" align="center">
	<?php
	// handling of mosmsg text in url
//	include_once( $mosConfig_absolute_path .'/administrator/modules/mod_mosmsg.php' ); 
	?>
	<div class="login">
	  <div class="login-form">
			<img src="archivos/images/login.gif" alt="Acceder" />
			<form action="../../index2.php" method="post" name="loginForm" id="loginForm">
			<div class="form-block">
				<div class="inputlabel">Nombre de Usuario </div>
				<div><input name="usrname" type="text" class="inputbox" size="15" /></div>
				<div class="inputlabel">Contrase&ntilde;a</div>
				<div><input name="pass" type="password" class="inputbox" size="15" /></div>
				<div align="left"><input type="submit" name="submit" class="button" value="Validarse para entrar" />
				</div>
			</div>
			</form>
	  </div>
		<div class="login-text">
			<div class="ctr"><img src="archivos/images/security.png" alt="Seguridad" /></div>
	</div>
		<div class="clr">
		</div>
	</div>
</div>
<div id="break"></div>
<noscript>
Advertencia! Debes activar el javascript para poder acceder a la administración
</noscript>
<div class="footer" align="center">
	<div align="center">
		UNIDAD DE SISTEMAS INFORMATICOS - PREFECTURA DE ORURO &copy; 2008     </div>
</div>
</body>
</html>
