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


/*$usuario_buscar_usuario = "-1";
if (isset($_GET['iud'])) {
  $usuario_buscar_usuario = $_GET['uid'];
}
$password_buscar_usuario = "-1";
if (isset($_GET['upwd'])) {
  $password_buscar_usuario = $_GET['upwd'];
}*/
$usuario_buscar_usuario=$_GET['uid'];
$password_buscar_usuario=$_GET['upwd'];

mysql_select_db($database_snet, $snet);
$query_buscar_usuario = sprintf("SELECT u.cuenta AS cuenta, clave, tipo_usuario, u.activo AS activo, cerrado FROM usuario u, funcionario f, actualizado a WHERE u.cuenta=f.usuario_cuenta AND f.dependencia_cod=a.cod_dependencia AND u.cuenta=%s AND u.clave=%s",GetSQLValueString($usuario_buscar_usuario, "text"),GetSQLValueString(md5($password_buscar_usuario), "text"));
$buscar_usuario = mysql_query($query_buscar_usuario, $snet) or die(mysql_error());
$row_buscar_usuario = mysql_fetch_assoc($buscar_usuario);
$totalRows_buscar_usuario = mysql_num_rows($buscar_usuario);
?>
<?php 

if(isset($_GET["r_cuenta"]) && ($_GET["r_cuenta"]=="si") && ($totalRows_buscar_usuario)){
//es que estoy recibiendo un estilo nuevo, lo tengo que meter en las cookies
   $usuario = $_GET["uid"];
   //meto el estilo en una cookie
   setcookie("recordar_cuenta", $usuario, time() + (60 * 60 * 24 * 90));
  
   //echo "Configuracion Salvada.....";
} 
if(isset($_GET["r_cuenta"]) && ($_GET["r_cuenta"]=="no") && ($totalRows_buscar_usuario)){
//es que estoy recibiendo un estilo nuevo, lo tengo que meter en las cookies
   $usuario = $_GET["uid"];
   //quitando la cookie de la variable global de PHP
   //unset($_COOKIE["recordar_cuenta"]); 
   setcookie("recordar_cuenta", $usuario, time()-60);
   //echo "Configuracion Salvada.....";
} 
?>
<?php 
//si el usuario existe en el sistema..
if ($totalRows_buscar_usuario){

  //si admin.... o tiene privilegios..
  if((($row_buscar_usuario["tipo_usuario"]=="jefe")||($row_buscar_usuario["tipo_usuario"]=="admin"))&&($row_buscar_usuario["cerrado"]=="3")){
		 //auentado 30-12-2011
		  header('Content-Type: text/html; charset=UTF-8');//aumentado
		  session_name("LoginSIRC"); //aumentado	
		  session_start();//aumentado
		  $_SESSION['user']=$_GET["uid"];//aumentado
		  
		  $_SESSION['tipo_usuario'] = $row_buscar_usuario["tipo_usuario"];//aumentado
     echo "400,ok,../sigapo/ventanas/index.php?uid=".$_GET["uid"];
	 //fin si es admin
  }else{
     //si, si es usuario bloqueado es normal
	  if(($row_buscar_usuario["activo"]==0)||($row_buscar_usuario["cerrado"]!="3")){
	  header('Content-Type: text/html; charset=UTF-8');
	  session_name("LoginSIRC"); 
	  session_start();
	  $_SESSION['user']=$_GET["uid"];
	  echo "600,ok,bloqueado";
	  //fin si
      }else{
      // fin sino. Si es usuario bloqueado
		  header('Content-Type: text/html; charset=UTF-8');
		  session_name("LoginSIRC"); 
		  session_start();
		  $_SESSION['user']=$_GET["uid"];
		  $_SESSION['tipo_usuario'] = $row_buscar_usuario["tipo_usuario"];//fila aumentada 12/12/2011
		  echo "400,ok,session.php?uid=".$_GET["uid"];
		}
       //fin sinoç
  }
  //fin sino es es admin 

}else{
// usuario desconocido..
   echo "404,error";
}
?>
<?php
mysql_free_result($buscar_usuario);
?>

