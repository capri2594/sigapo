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

$usuario_buscar_usuario = "-1";
if (isset($_GET['cuenta'])) {
  $usuario_buscar_usuario = $_GET['cuenta'];
}
$password_buscar_usuario = "-1";
if (isset($_GET['clave'])) {
  $password_buscar_usuario = md5($_GET['clave']);
}
mysql_select_db($database_snet, $snet);
$query_buscar_usuario = sprintf("SELECT %s.cuenta, %s.clave FROM %s WHERE %s.cuenta=%s AND %s.clave=%s", GetSQLValueString($usuario_buscar_usuario, "text"),GetSQLValueString($usuario_buscar_usuario, "text"),GetSQLValueString($usuario_buscar_usuario, "text"),GetSQLValueString($usuario_buscar_usuario, "text"),GetSQLValueString($usuario_buscar_usuario, "text"),GetSQLValueString($usuario_buscar_usuario, "text"),GetSQLValueString($password_buscar_usuario, "text"));
$buscar_usuario = mysql_query($query_buscar_usuario, $snet) or die(mysql_error());
$row_buscar_usuario = mysql_fetch_assoc($buscar_usuario);
$totalRows_buscar_usuario = mysql_num_rows($buscar_usuario);

if ($totalRows_buscar_usuario){
//usuario del sistema..
  header('Content-Type: text/html; charset=UTF-8');
  session_name("LoginSIRC"); 
  session_start();
  
  header("Location: "."index.php")
}else{
// usuario desconocido..
}

?>

<?php
mysql_free_result($buscar_usuario);
?>
