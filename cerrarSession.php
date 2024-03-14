<?php 
session_name("LoginSIRC");
session_start();
header("Content-Type: text/html; charset=utf-8");
header("Cache-Control: no-cache, must-revalidate"); 
session_destroy();
header('Expires: -1');
header("Cache-control: no-store, no-cache, must-revalidate");
header("Cache-control: post-ckeck=0, pre-check=0", false);
header("Pragma: no-cache");
//sleep(1);
//header('Location: index.php');
//echo  "dep:".$_SESSION['dep']
//$cod_dep=$_SESSION['cod_dep'];
//echo  "dep:".$cod_dep;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.Estilo5 {
	font-family: Modern;
	font-size: 15px;
}
.Estilo9 {
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<table width="70%" border="0" align="center" cellpadding="10" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td bgcolor="#FFFFCC"><span class="Estilo9">Gracias por Usar el Sistema.</span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><span class="Estilo5">Espere... un momento por favor.</span></td>
    <td>&nbsp;</td>
  </tr>
</table>
<script>

    /*top.document.location="../../../../";*/
	//Sleep(1);
	function cambiar(){
    window.parent.document.location="index.php";
	//window.document.location="index.php";
	}
	setTimeout("cambiar()",2000);
 </script>
</body>

</html>
