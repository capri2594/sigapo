<?php 
if(isset($_GET["r_cuenta"]) && ($_GET["r_cuenta"]=="si")){
//es que estoy recibiendo un estilo nuevo, lo tengo que meter en las cookies
   $usuario = $_GET["uid"];
   //meto el estilo en una cookie
   setcookie("recordar_cuenta", $usuario, time() + (60 * 60 * 24 * 90));
} 
?>
