<?php 
 session_name("LoginSIRC"); 
 session_start();
 date_default_timezone_set("America/La_Paz"); 
 session_register('fun','user','cargo','cod_dep','dep','sid');
 $_SESSION['sid']=session_id();
 // si recibe el parametro URL del nombre de usuario...
 $_SESSION['user']=$_GET['uid'];
 //en otro caso validar al usuario completarmente.
  ?> 
 <script>
  document.location="index_.php";
 </script>