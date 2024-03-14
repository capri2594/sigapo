<?php 
//Veo si recibo datos del formulario
if(isset($_GET["estilo"])){
//es que estoy recibiendo un estilo nuevo, lo tengo que meter en las cookies
   $estilo = $_GET["estilo"];
   //meto el estilo en una cookie
   setcookie("estilo", $estilo, time() + (60 * 60 * 24 * 90));
} 
else{
   //si no he recibido el estilo que desea el usuario en la página, miro si hay una cookie creada
   if (isset($_COOKIE["estilo"])){
      //es que tengo la cookie
      $estilo = $_COOKIE["estilo"];
   }
}

if (isset($estilo)){
   echo '<link rel="STYLESHEET" type="text/css" href="' . $estilo . '.css">';
   echo "este color es: ".$estilo;
   echo $_COOKIE["estilo"];
   echo $_COOKIE["recordar_cuenta"];   
} 
?>
