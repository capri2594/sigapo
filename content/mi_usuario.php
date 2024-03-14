<?php 
session_name("LoginSIRC");
session_start();
header("Content-Type: text/html; charset=utf-8");
echo $_SESSION['user'];
//$cod_dep=$_SESSION['cod_dep'];
//echo  "dep:".$cod_dep;
?>