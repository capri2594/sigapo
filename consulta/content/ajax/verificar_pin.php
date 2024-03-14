<?php require_once('../../../Connections/snet.php'); ?>
<?php 
session_name("consulta");
session_start();?>
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

$idpin_buscar_pin = "-1";
if (isset($_POST['pin'])) {
  $idpin_buscar_pin = $_POST['pin'];
}
//calculo de cifrado
list( $us, $pwd ) = split( '[/__]', $idpin_buscar_pin );
$pin=$us.md5($pwd);
$idpin_buscar_pin=$pin;

mysql_select_db($database_snet, $snet);
$query_buscar_pin = sprintf("SELECT usuario.cuenta, usuario.clave, usuario.ip_acceso, usuario.tipo_usuario FROM usuario WHERE CONCAT(usuario.cuenta,usuario.clave)=%s", GetSQLValueString($idpin_buscar_pin, "text"));
$buscar_pin = mysql_query($query_buscar_pin, $snet) or die(mysql_error());
$row_buscar_pin = mysql_fetch_assoc($buscar_pin);
$totalRows_buscar_pin = mysql_num_rows($buscar_pin);
?>
<?php 
if($totalRows_buscar_pin){
   echo "ok.";
/*   echo "<br>cuenta: ".$row_buscar_pin['cuenta'];
   echo "<br>clave: ".$row_buscar_pin['clave'];
   echo "<br>cifrado:  ".$pin;
   echo "<br>cifrado:  ".md5('jaranibar3536439');  */
   $_SESSION['pin']=1;
}else{
   echo "error.";
   $_SESSION['pin']=0;
}
?>
<?php
mysql_free_result($buscar_pin);
?>
