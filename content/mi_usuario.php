<?php 
if (!isset($_SESSION)) {
	session_name("LoginSIRC");
	session_start();
}
header("Content-Type: text/html; charset=utf-8");
echo (isset($_SESSION['user']) && trim($_SESSION['user']) !== '') ? htmlspecialchars($_SESSION['user'], ENT_QUOTES, 'UTF-8') : 'Sin sesión';
?>