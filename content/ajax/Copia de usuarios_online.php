<?php 
session_name("LoginSIRC");
session_start();
header("Content-Type: text/html; charset=utf-8");
?>
<?php 
// nos conectamos a la BD
//require_once('../conections/snet.php');
require_once('../../Connections/snet.php');
$usuario=$_SESSION["user"];
$session_id=session_id();//$_SESSION["sid"];
// Tiempo máximo de espera
$time = 1 ;//ANTES ERA 5 MIN de permiso.
// Momento que entra en línea
$date = time() ;
// Recuperamos su IP
$ip = $_SERVER['REMOTE_ADDR'];
// Tiempo Limite de espera 
$limite = $date-$time*60 ;
// si se supera el tiempo limite (5 minutos) lo borramos
mysql_query("delete from session where tiempo < $limite") ;
// tomamos todos los usuarios en linea
//$resp = mysql_query("select * from session where ip='$ip'") ;
//CONTROL POR USUARIO
$resp = mysql_query("select * from session where cuenta='$usuario'") ;
// Si son los mismo actualizamos la tabla gente_online
if(mysql_num_rows($resp) != 0) {
//mysql_query("update session set tiempo='$date' where ip='$ip'") ;
mysql_query("update session set tiempo='$date' where cuenta='$usuario'") ;
}
// de lo contrario insertamos los nuevos
else {

mysql_query("insert into session (cuenta,session_id,tiempo,ip) values ('$usuario','$session_id','$date','$ip')") ;
}
// Seleccionamos toda la tabla
$query = "SELECT * FROM session";
// Ocultamos algún mensaje de error con @
$resp = @mysql_query($query) or die(mysql_error());
// almacenamos la consulta en la variable $usuarios
$usuarios = mysql_num_rows($resp);
// Si hay 1 usuarios se muestra en singular; si hay más de uno, en plural
if($usuarios > 1 || $usuarios == 0){echo("Hay ");}else{echo("Hay ");}if($usuarios == 0){echo("no ");}else{echo($usuarios." ");}if($usuarios > 1 || $usuarios == 0){echo("usuarios en línea.");}else{echo("usuario en línea.");}

?>
