<?php 
 //header("Cache-Control: no-cache");
// header('Content-Type: text/html; charset=UTF-8');
// session_name("LoginSIRC"); 
// session_start();
 ?>
<?php require_once('../../Connections/snet.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

//$usuario_ver_usuario = "-1";
if (isset($_GET['cuenta'])) {
  $usuario_ver_usuario = $_GET['cuenta'];
}
//$pswd_ver_usuario = "-1";
if (isset($_GET['old_pswd'])) {
  $pswd_ver_usuario = $_GET['old_pswd'];
}
mysql_select_db($database_snet, $snet);
$query_ver_usuario = sprintf("SELECT cuenta, clave FROM usuario WHERE cuenta=%s AND clave=%s", GetSQLValueString($usuario_ver_usuario, "text"),GetSQLValueString(md5($pswd_ver_usuario), "text"));
$ver_usuario = mysql_query($query_ver_usuario, $snet) or die(mysql_error());
$row_ver_usuario = mysql_fetch_assoc($ver_usuario);
$totalRows_ver_usuario = mysql_num_rows($ver_usuario);
//Verificando Si el usuario existe en la Base de Datos.
//echo $totalRows_ver_usuario; 
if ($totalRows_ver_usuario) {


if (($_GET['new_pswd']==$_GET['repeat_new_pswd'])&&($_GET['new_pswd']!="")){
// modificando el registro
if (isset($_GET['cuenta'])) {
  $updateSQL = sprintf("UPDATE usuario SET clave=%s WHERE cuenta=%s AND clave=%s",
                       GetSQLValueString(md5($_GET['new_pswd']), "text"),
                       GetSQLValueString($_GET['cuenta'], "text"),
					   GetSQLValueString(md5($_GET['old_pswd']), "text"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($updateSQL, $snet) or die(mysql_error());
  echo "(ok-correcto): Se ha cambiado la contraseña correctamente, gracias."; 
}

}// fin verificacion de la contraseña nueva
else{
// ni hay la constrseña nueva no coincide.
  echo "(Error 405): La NUEVA contraseña no coincide o es vacia. Revise por favor."; 
}

}else{
// si el usuario no existe en el sistema...
  echo "(Error 404): Usuario o contraseña, incorrecto. Verifique e intente nuevamente"; 
  //exit();

}
?>
<?php
//mysql_free_result($ver_usuario);
?>
