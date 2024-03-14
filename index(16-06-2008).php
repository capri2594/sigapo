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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['uid'])) {
  $loginUsername=$_POST['uid'];
  $password=$_POST['pswd'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "session.php?uid=";
  $MM_redirectLoginSuccess = $MM_redirectLoginSuccess.$loginUsername;
  $MM_redirectLoginFailed = "index.php";
  $MM_redirecttoReferrer = true;
  mysql_select_db($database_snet, $snet);
  
  $LoginRS__query=sprintf("SELECT usuario_cuenta, usuario_cuenta FROM funcionario WHERE usuario_cuenta=%s AND usuario_cuenta=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $snet) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && true) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sistema de Correspondencia</title>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.franja {
	background-image: url(img/page_bg.jpg);
}
.ventana {
	background-image: url(img/window_login1.gif);
	background-repeat: no-repeat;
	background-position: top;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	margin-left: 0px;
	padding: 0px;
}
.Estilo1 {color: #FFFFFF}
.Estilo3 {color: #FFFFFF; font-weight: bold; }
-->
</style><script type="text/javascript" src="content/js/prototype.js"></script>
<script type="text/javascript" language="javascript">
     function inicio(){
		$('uid').select();
		$('uid').focus();
		}
</script>
</head>

<body onload="inicio();">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="100">&nbsp;</td>
    <td>&nbsp;</td>
    <td width="100">&nbsp;</td>
  </tr>
  <tr class="franja">
    <td>&nbsp;</td>
    <td><form id="form1" name="form1" method="POST" action="<?php echo $loginFormAction; ?>">
      <table width="400" border="0" align="center" cellpadding="0" cellspacing="1">
        <tr>
          <td><div align="right"><span class="Estilo3"><br />
          </span></div></td>
        </tr>
        <tr>
          <td><table width="400" border="0" align="center" cellpadding="7" cellspacing="1" class="ventana">
              <tr style="height:20px;">
                <td width="120" >&nbsp;</td>
                <td ><span class="Estilo3">Iniciar Session::SIRC v.2.11</span></td>
              </tr>
              <tr>
                <td width="120"><div align="right" class="Estilo1">Cuenta&nbsp;</div></td>
                <td><span id="sprytextfield1">
                  <input name="uid" type="text" id="uid" />
                  <span class="textfieldRequiredMsg"> &nbsp;vacio...! </span></span></td>
              </tr>
              <tr>
                <td width="120"><div align="right" class="Estilo1">Clave&nbsp;</div></td>
                <td><span id="sprytextfield2">
                  <input type="password" name="pswd" id="pswd" />
                  <span class="textfieldRequiredMsg">&nbsp;vacio...!</span></span><span class="textfieldRequiredMsg">! </span><span class="textfieldRequiredMsg">!</span></td>
              </tr>
              <tr>
                <td width="120">&nbsp;</td>
                <td>
                  <div align="center">
                    <input type="submit" name="button" id="button" value="Ingresar" />
                    </div></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td><div align="right"></div></td>
        </tr>
      </table>
          </form>
    </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur"]});
//-->
</script>
</body>
</html>
