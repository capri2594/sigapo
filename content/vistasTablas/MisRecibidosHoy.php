<?php 
session_name("LoginSIRC");
session_start();
$_SESSION['hoy']=date("Y-m-d");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>.::LIBRO DE RECEPCION</title>
		<style type="text/css">
			@import "default.css";
		.Estilo1 {font-size: 9px}
        .cabecera {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
        </style>
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/jquery.gridxml.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#mitabla").gridxml({
					xml: "recibidos.php",
					xsl: "grid.xsl",
					sortOrder: "ascending",//"descending",
					sortColumn: "fecha_ing"
				});
				$("#mitabla2").gridxml({
					xml: "grid.xml",
					xsl: "grid.xsl",
					sortOrder: "descending",
					sortColumn: "fecha_emision",
					type: "date"
				});
			});
		</script>
                    <SCRIPT language="javascript"> 
function imprimir()
{ if ((navigator.appName == "Netscape")) { window.print() ; 
} 
else
{ var WebBrowser = '<OBJECT ID="WebBrowser1" WIDTH=0 HEIGHT=0 CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>'; 
document.body.insertAdjacentHTML('beforeEnd', WebBrowser); WebBrowser1.ExecWB(6, -1); WebBrowser1.outerHTML = "";
}
}
</SCRIPT> 
</head>
	<body>
<h1 align="center"><?php echo $_SESSION['dep']; ?></h1>
<div class="NINGUNO"><div align="center">
  <table width="100%" border="0" class="cabecera">
    <tr>
      <td>&nbsp;</td>
      <td>LIBRO DE REGISTRO DE CORRESPONDENCIA </td>
      <td width="55"><table width="100%" border="0" onClick="imprimir();">
        <tr>
          <td><div align="center"><img src="../../img/icono_imprimir.jpg" alt="imprimir" width="26" height="29"></div></td>
          </tr>
        <tr>
          <td><span class="Estilo1">
            <label>
            <input type="submit" name="button" id="button" value="Imprimir">
            </label>
          </span></td>
          </tr>

      </table>        </td>
    </tr>
  </table>
</div>
</div>
<div id="mitabla"> Cargando tabla... </div>
<h1>&nbsp;</h1>

</body>
</html>
