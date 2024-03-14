<?php 
session_name("LoginSIRC");
session_start();
$cod_dep=$_SESSION['cod_dep'];
?>

<?php require_once('../Connections/snet.php'); ?>
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

$colname_list_hr = "-1";
if (isset($_POST['codHR'])) {
  $colname_list_hr = $_POST['codHR'];
}
mysql_select_db($database_snet, $snet);
$query_list_hr = sprintf("SELECT * FROM hojaruta WHERE cod = %s", GetSQLValueString($colname_list_hr, "text"));
$list_hr = mysql_query($query_list_hr, $snet) or die(mysql_error());
$row_list_hr = mysql_fetch_assoc($list_hr);
$totalRows_list_hr = mysql_num_rows($list_hr);

mysql_select_db($database_snet, $snet);
$query_list_destinos = "SELECT * FROM dependencia WHERE pd = 1 ORDER BY prioridad ASC";
$list_destinos = mysql_query($query_list_destinos, $snet) or die(mysql_error());
$row_list_destinos = mysql_fetch_assoc($list_destinos);
$totalRows_list_destinos = mysql_num_rows($list_destinos);
$ok=0;
if (($_POST['comprobar'])&&($totalRows_list_hr == 0)&&(isset($_POST['codHR']))) {$ok=1;}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Enviar Hoja de Ruta</title>
<style type="text/css">
<!--
.cuadro {
	color: #7A7A7A;
	background-color: #EFF5F1;
	margin: 5px;
	padding: 7px;
	border: 1px solid #D2D2D2;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	width: 550px;
}
.boton {
	background-color: #EFF5F1;
	border: 1px solid #9B9B9B;
	color: #666666;
	font-weight: bold;
	font-size: 11px;
	font-family: Arial, Helvetica, sans-serif;
}
.paso_normal {
	background-color: #EBF1E4;
	border: 1px solid #CCCCCC;
	margin: 0px;
	padding: 12px;
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 14px;
	width: 75px;
}
.pasotitulo {
	background-color: #DCF0B3;
	border: 1px solid #CCCCCC;
	padding: 12px;
	font-size: 14px;
	font-weight: bold;
	color: #00376F;
	font-family: Albertus, sans-serif, Modern;
}
.paso_over {
	background-color: #DCF0B3;
	border: 1px solid #CCCCCC;
	padding: 12px;
	font-size: 14px;
	font-weight: bold;
	color: #00376F;
	font-family: Albertus, sans-serif, Modern;
}
.subrayado {
	border-bottom-width: thin;
	border-bottom-style: double;
	border-bottom-color: #C3C3C3;
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #666666;
	font-weight: bold;
}
.subrayadoCampo {
	width: 50px;
	border-bottom-width: 1px;
	border-bottom-style: solid;
	border-top-color: #000000;
	border-right-color: #000000;
	border-bottom-color: #000000;
	border-left-color: #000000;
	color: #000000;
}
-->
</style>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo4 {
	color: #FF0000;
	font-weight: bold;
}
.Estilo6 {color: #FF0000}
.Estilo9 {
	color: #339933;
	font-weight: bold;
}
.Estilo11 {color: #000000}
.Estilo12 {
	font-size: 12px;
	font-family: Albertus, sans-serif, Modern;
}
.Estilo13 {
	font-family: Arial, Helvetica, sans-serif
}
.Estilo17 {font-size: 9}
-->
</style>
<script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>

<body>
<form action="" method="post" name="formHR" id="formHR">
  <table width="100%" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td width="75" valign="top"><table width="100" border="0" align="left" cellpadding="0" cellspacing="1">
      <tr>
        <td><div class="pasotitulo">Enviar HOJA DE RUTA </div></td>
      </tr>
      <tr>
        <td><div class="paso_normal">Paso 1</div></td>
      </tr>
      <tr>
        <td><div class="paso_normal">Paso 2</div></td>
      </tr>
      <tr>
        <td><div class="paso_normal">Paso 3</div></td>
      </tr>
    </table></td>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td><p align="center" class="Estilo13"><img src="../img/iconos/insertar.gif" width="40" height="40" />&nbsp;Ingresar el codigo de la hoja de ruta.</p>
          <table width="100%" border="0" cellspacing="1" cellpadding="0">
            
            <tr>
              <td width="24%" align="right" valign="middle"><span class="paso_normal"><?php echo $_SESSION['cod_dep']; ?>
                <input name="cod_dep" type="hidden" id="cod_dep" value="<?php echo $_SESSION['cod_dep']; ?>" />
              </span>&nbsp;&nbsp;</td>
              <td width="52%" valign="middle"><span id="sprytextfield1">
              <input type="text" name="codHR" id="codHR" />
              <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Ingrese numero.</span></span></td>
              <td width="24%" valign="middle"><div align="right">
                <input name="comprobar" type="submit" class="boton" id="comprobar" value="Comprobar Otra Vez" />
              </div></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td><div align="right">
                <input name="siguiente" type="submit" class="boton" id="siguiente" value="Siguiente &gt;&gt;" />
              </div></td>
            </tr>
          </table>          </td>
      </tr>
      
      <tr>
        <td><table width="100%" border="0" cellspacing="1" cellpadding="2">
        <?php if ($totalRows_list_hr == 0) { // Show if recordset empty ?>
        <?php if ($ok==1) { // Show if recordset empty ?>
          <tr>
            <td><div class="subrayado">Hoja de Ruta</div></td>
            </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="1" cellpadding="7">
              <tr>
                <td><div class="cuadro">Codigo :&nbsp;<span class="Estilo11"><?php echo $_SESSION['cod_dep']; ?>.<?php echo $_POST['codHR']; ?></span><br />
                  Comprobacion: <span class="Estilo9">OK</span><br />
                </div></td>
              </tr>

            </table></td>
          </tr>
          <tr>
            <td><div class="subrayado">Datos de la Correspondencia</div></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="1" cellpadding="7">
              <tr>
                <td><div class="cuadro">
                  <table width="100%" border="0" cellspacing="1" cellpadding="0">
                    <tr>
                      <td><div align="right">Fecha<span id="sprytextfield9">
                        <input name="dd" type="text" id="dd" value="<?php echo date("d");?>" size="3" maxlength="2" />
                        <span class="textfieldRequiredMsg">Se necesita un valor.</span></span><span id="sprytextfield10">
                        <input name="mm" type="text" id="mm" value="<?php echo date("m");?>"size="3" maxlength="2" />
                        <span class="textfieldRequiredMsg">Se necesita un valor.</span></span><span id="sprytextfield11">
                        <input name="aaaa" type="text" id="aaaa" value="<?php echo date("Y");?>"size="5" maxlength="4" />
                        <span class="textfieldRequiredMsg">Se necesita un valor.</span></span>
                        <input name="fecha_creacion" type="hidden" id="fecha_creacion" value="<?php echo date("Y-m-d H:i:s");?>" />
                      </div></td>
                      <td><div align="right">Hora:&nbsp;<span id="sprytextfield3">
                        <input name="hora" type="text" id="hora" value="<?php echo date("h:s");?>" size="5" maxlength="5" />
                        <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></div></td>
                      <td><div align="right">No. de Hojas
                          <span id="sprytextfield7">
                          <input name="nhojas" type="text" id="nhojas" size="8" />
                          <span class="textfieldRequiredMsg">Se necesita un valor.</span></span>                      </div></td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td><div align="right">No. de Anexos                        <span id="sprytextfield8">
                        <input name="nhojas2" type="text" id="nhojas2" size="8" />
                        <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></div></td>
                      </tr>
                  </table>
                  Remitente:&nbsp;<span id="sprytextfield6"><span class="textfieldRequiredMsg">Se necesita un valor</span></span><span class="subrayadoCampo"><?php echo $_SESSION['fun']; ?>&nbsp;&nbsp;&lt;<em><?php echo $_SESSION['dep']; ?></em>&gt;</span>
                  <input name="fun_remite" type="hidden" id="fun_remite" value="<?php echo $_SESSION['fun']; ?>" />
                  <input name="dep_remite" type="hidden" id="dep_remite" value="<?php echo $_SESSION['dep']; ?>" />
                  <br />
                  <br />
                  ref.<span id="sprytextfield2"><span id="sprytextfield12">
                  <input name="ref" type="text" id="ref" size="50" />
                  <span class="textfieldRequiredMsg">Se necesita un valor.</span></span><span class="textfieldRequiredMsg">Se necesita un valor.</span></span>
                  <input name="examinar2" type="button" id="examinar2" onclick="MM_openBrWindow('fun_Destino_value.php','Destinatario','status=yes,width=550,height=250')" value="..." />
                  <br />
                  <br />
                  <span class="Estilo12">PRIMER DESTINATARIO</span><br />
                  <span id="sprytextfield4">
                  <input name="fun_destino" type="text" id="fun_destino" size="40" readonly="readonly" />
                  <span class="textfieldRequiredMsg">Se necesita un valor.</span></span>
                  <input name="examinar" type="button" id="examinar" onclick="MM_openBrWindow('fun_Destino_value.php','Destinatario','status=yes,width=550,height=250')" value="..." />
                  <input type="hidden" name="dep_destino" id="dep_destino" />
                  <br />
                  <table width="200">
                    <tr>
                      <td><table width="550" >
                       <?php for($f=1;$f<=4;$f++) {?>
                        <tr>
                          <?php for($c=1;$c<=3;$c++) { ?>
                            <td>
                                <span class="Estilo17">
                                <input type="radio" name="GrupoOpciones1" value="opción" id="GrupoOpciones1_0" />
                                <label class="Estilo12">
                                <?php echo $row_list_destinos['nombredep']; ?></label>
                                </span></td>
                            <?php  $row_list_destinos = mysql_fetch_assoc($list_destinos);} ?></tr>
                       <?php }?>     
                      </table></td>
                      <td><label></label></td>
                    </tr>
                  </table>
                  <br />
                  <br />
                </div></td>
              </tr>

            </table></td>
          </tr>
     <?php } // fin comprobar ?>
     <?php } // Show if recordset empty ?>
          <?php if ($totalRows_list_hr > 0) { // Show if recordset not empty ?>
          <tr>
            <td><div class="subrayado">Resultado de la comprobacion</div></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="1" cellpadding="7">
              <tr>
                <td>&nbsp;</td>
                <td><div class="cuadro">Codigo de Hoja de Ruta:&nbsp;<span class="Estilo6"><?php echo $_SESSION['cod_dep']; ?>-<?php echo $_POST['codHR']; ?></span><br />
                  Comprobacion: <span class="Estilo4">ERROR</span> <span class="Estilo6">el codigo ya existe no puede ingresar duplicar datos</span><br />
                </div></td>
              </tr>
            </table></td>
          </tr>
          <?php } // Show if recordset not empty ?>
        </table></td>
        </tr>
    </table></td>
  </tr>
</table></form>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {validateOn:["blur"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7");
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8");
var sprytextfield9 = new Spry.Widget.ValidationTextField("sprytextfield9");
var sprytextfield10 = new Spry.Widget.ValidationTextField("sprytextfield10");
var sprytextfield11 = new Spry.Widget.ValidationTextField("sprytextfield11");
var sprytextfield12 = new Spry.Widget.ValidationTextField("sprytextfield12");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
//-->
</script>
</body>
</html>
<?php
mysql_free_result($list_hr);

mysql_free_result($list_destinos);
?>
