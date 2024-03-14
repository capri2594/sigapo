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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formHR")&&(($_POST['siguiente']))) {
  $insertSQL = sprintf("INSERT INTO hojaruta (cod, salinternas_salidas_cite, fecha_creacion, dep_remite, fun_remite, `ref`, dep_destino, fun_destino, fecha_envio, nhojas, nanexos) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['codigoHR'], "text"),
                       GetSQLValueString($_POST['cite'], "text"),
                       GetSQLValueString($_POST['fecha_creacion'], "date"),
                       GetSQLValueString($_POST['dep_remite'], "text"),
                       GetSQLValueString($_POST['fun_remite'], "text"),
                       GetSQLValueString($_POST['ref'], "text"),
                       GetSQLValueString($_POST['dep_dest'], "text"),
                       GetSQLValueString($_POST['fun_dest'], "text"),
                       GetSQLValueString($_POST['fecha_creacion'], "date"),
                       GetSQLValueString($_POST['nhojas'], "int"),
                       GetSQLValueString($_POST['nanexos'], "int"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($insertSQL, $snet) or die(mysql_error());
}

$colname_list_hr = "-1";
if (isset($_POST['codHR'])) {
  $colname_list_hr = $_SESSION['cod_dep']."-".$_POST['codHR'];
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

$colname_list_remite = "-1";
if (isset($_SESSION['cod_dep'])) {
  $colname_list_remite = $_SESSION['cod_dep'];
}
mysql_select_db($database_snet, $snet);
$query_list_remite = sprintf("SELECT nombre, dependencia_cod FROM funcionario WHERE dependencia_cod = %s ORDER BY cargo ASC", GetSQLValueString($colname_list_remite, "text"));
$list_remite = mysql_query($query_list_remite, $snet) or die(mysql_error());
$row_list_remite = mysql_fetch_assoc($list_remite);
$totalRows_list_remite = mysql_num_rows($list_remite);

mysql_select_db($database_snet, $snet);
$query_RecordOtrosDep = "SELECT cod, nombredep FROM dependencia WHERE pd = 0 ORDER BY nombredep ASC";
$RecordOtrosDep = mysql_query($query_RecordOtrosDep, $snet) or die(mysql_error());
$row_RecordOtrosDep = mysql_fetch_assoc($RecordOtrosDep);
$totalRows_RecordOtrosDep = mysql_num_rows($RecordOtrosDep);
$ok=0;
if (($_POST['comprobar'])&&($totalRows_list_hr == 0)&&(isset($_POST['codHR']))) {$ok=1;}
if (($_POST['comprobar'])&&($totalRows_list_hr > 0)&&(isset($_POST['codHR']))) {$ok=2;}
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
	width: 630px;
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
.agregar_cite {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #3366FF;
	text-decoration: underline;
	width: 100px;
}
-->
</style>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
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

function MM_showHideLayers() { //v9.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) 
  with (document) if (getElementById && ((obj=getElementById(args[i]))!=null)) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}

function destinos(obj){
  //alert("valor="+obj.value);
   if (obj.value!="-1")
   {
       document.getElementById('dep_dest').value=obj.value;
	   document.getElementById('fun_dest').value="A quien Corresponda";
	   document.getElementById('destinatario').innerHTML=obj.value;
	   
   }
   else
    alert("ERROR: 404 destinatario no asignado correctamente.");
   //alert("valor asignado="+document.getElementById('fun_dest').value);
}
//-->
</script>
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo18 {color: #000000}
.mensaje {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #FFFFFF;
	background-color: #FF3366;
}
-->
</style>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="POST" name="formHR" id="formHR">
  <table width="100%" border="0" cellspacing="1" cellpadding="7">
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td><table width="100%" border="0" cellspacing="1" cellpadding="2">
             <?php if (($ok==2)||($ok==0)) { // Show if recordset not empty ?>
            <tr>
              <td align="right" valign="middle"> <span class="mensaje" id="mensaje">
              <?php if($Result1) echo "Hoja de Ruta :: registrada correstamente";?></span></td>
              <td valign="middle"><span class="Estilo13"><img src="../img/iconos/insertar.gif" width="40" height="40" />&nbsp;Ingresar numero de Hoja de Ruta.</span></td>
              <td valign="middle">&nbsp;</td>
            </tr>
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
            
            <?php if ($ok==1) {?>
             <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
             </tr>
            <?php }?>
            <?php } // Show if recordset not empty ?>
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
        <td>
       
        <table width="100%" border="0" cellspacing="1" cellpadding="2">
        <?php if ($totalRows_list_hr == 0) { // Show if recordset empty ?>
        <?php if ($ok==1) { // Show if recordset empty ?>
          <tr>
            <td><div class="subrayado">Hoja de Ruta</div></td>
            </tr>
          
          <tr>
            <td>
            
            <table width="100%" border="0" cellspacing="1" cellpadding="3">
              <tr>
                <td><div class="cuadro">
                  <table width="100%" border="0" cellspacing="1" cellpadding="0">
                    <tr>
                      <td><div align="left">Codigo :&nbsp;<span class="Estilo13"><?php echo $_SESSION['cod_dep']; ?>-<?php echo $_POST['codHR']; ?> &nbsp;</span>&nbsp;
                        <input type="hidden" name="codigoHR" id="codigoHR" value="<?php echo $_SESSION['cod_dep']; ?>-<?php echo $_POST['codHR']; ?>"/>
                      </div></td>
                      <td>[<span class="Estilo9">OK</span>]</td>
                      <td>&nbsp;</td>
                    </tr>
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
                        <input name="hora" type="text" id="hora" value="<?php echo date("h:i");?>" size="5" maxlength="5" />
                        <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></div></td>
                      <td><div align="right">No. de Hojas
                          <span id="sprytextfield7">
                          <input name="nhojas" type="text" id="nhojas" size="8" />
                          <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span>                      </div></td>
                      </tr>
                    <tr>
                      <td>&nbsp;&nbsp;
                        <div class="agregar_cite" id="showcite"></div></td>
                      <td><input name="cite" type="hidden" id="cite" value="sin cite" /></td>
                      <td><div align="right">No. de Anexos                        <span id="sprytextfield8">
                      <input name="nanexos" type="text" id="nanexos" value="0" size="8" />
                      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></div></td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                  </table>
                     &nbsp;Remitente:&nbsp;<span id="sprytextfield6"><span class="textfieldRequiredMsg">Se necesita un valor</span></span><span class="subrayadoCampo"><span id="spryselect1">
                  <select name="remitentes" id="remitentes" style="width:230px;">
                    <?php
do {  
?>
                    <option value="<?php echo $row_list_remite['nombre']?>"><?php echo $row_list_remite['nombre']?></option>
                    <?php
} while ($row_list_remite = mysql_fetch_assoc($list_remite));
  $rows = mysql_num_rows($list_remite);
  if($rows > 0) {
      mysql_data_seek($list_remite, 0);
	  $row_list_remite = mysql_fetch_assoc($list_remite);
  }
?>
                  </select>
                  <span class="selectRequiredMsg">Seleccione un elemento.</span></span>&nbsp;&nbsp;&lt;<em><?php echo $_SESSION['dep']; ?></em>&gt;</span>
                  <input name="fun_remite" type="hidden" id="fun_remite" value="<?php echo $_SESSION['fun']; ?>" />
                  <input name="dep_remite" type="hidden" id="dep_remite" value="<?php echo $_SESSION['dep']; ?>" />
                  <br />
                  <br />
                  Referencia:<span id="sprytextfield2"><span id="sprytextfield12">&nbsp;
                  <input name="ref" type="text" id="ref" size="70" />
                  <span class="textfieldRequiredMsg">Se necesita un valor.</span></span><span class="textfieldRequiredMsg">Se necesita un valor.</span></span>
                  &nbsp;&nbsp;
                  <input name="examinar2" type="button" id="examinar2" onclick="MM_openBrWindow('insert_correspondencia.php','Destinatario','status=yes,width=730,height=285')" value="..." />
                  <br />
                  <br />
                  <span class="Estilo12">PRIMER DESTINATARIO</span>
                  <input type="hidden" name="fun_dest" id="fun_dest" />
                  <input name="dep_dest" type="hidden" id="dep_dest" />
                  <br />
                  <br />
                  <span id="sprytextfield4"><span class="textfieldRequiredMsg">Se necesita un valor.</span></span>
                  <table width="200">
                    <tr>
                      <td><table width="620" border="0" cellpadding="0" cellspacing="0" id="pdestinatarios" style="visibility:visible;">
                       <?php for($f=1;$f<=4;$f++) {?>
                        <tr>
                          <?php for($c=1;$c<=3;$c++) { ?>
						  <?php
						  if ($row_list_destinos['nombredep']==NULL){
						  ?>
						   <td>&nbsp;</td>
                          <?php } else {?>
                            <td>
                               
                                <span class="Estilo17">
                                <input type="radio" name="Opciones" value="<?php echo $row_list_destinos['nombredep']; ?>" id="Opciones" onclick="destinos(this);" <?php if ((f==1)&&(c==1)) {echo "checked";}?> />
                                <label class="Estilo13" >
                                <?php echo $row_list_destinos['nombredep']; ?></label>
                                </span></td>
                           <?php }?>     
                            <?php  $row_list_destinos = mysql_fetch_assoc($list_destinos);} ?></tr>
                       <?php }?>
                       <tr id="otros" >
                         <td><div align="right" ></div></td>
                         <td><div align="right">Otros&nbsp;</div></td>
                         <td><span id="spryselect2">
                           <select name="otrosDep" id="otrosDep" onchange="destinos(this);">
                             <option value="-1">--- Elija una opcion ----</option>
                             <?php
do {  
?><option value="<?php echo $row_RecordOtrosDep['nombredep']?>"><?php echo $row_RecordOtrosDep['nombredep']?></option>
                             <?php
} while ($row_RecordOtrosDep = mysql_fetch_assoc($RecordOtrosDep));
  $rows = mysql_num_rows($RecordOtrosDep);
  if($rows > 0) {
      mysql_data_seek($RecordOtrosDep, 0);
	  $row_RecordOtrosDep = mysql_fetch_assoc($RecordOtrosDep);
  }
?>
                           </select>
                           <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
                       </tr>     
                      </table></td>
                      <td><label></label></td>
                    </tr>
                  </table>
                  <br />Destinatario:
                  <span class="subrayadoCampo" id="destinatario">&nbsp;</span><br />
                </div>                </td>
              </tr>
            </table>
          
            </td>
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
                <td><div class="cuadro">Codigo de Hoja de Ruta:&nbsp;<span class="Estilo6"><?php echo $_SESSION['cod_dep']; ?>-<?php echo $_POST['codHR']; ?></span><br />
                  Comprobacion: <span class="Estilo4">ERROR</span> <span class="Estilo6">el codigo ya existe no puede ingresar duplicar datos</span><br />
                </div></td>
              </tr>
            </table>
            
            </td>
          </tr>
          <?php } // Show if recordset not empty ?>
        </table></td>
        </tr>
    </table></td>
  </tr>
</table>
  <input type="hidden" name="MM_insert" value="formHR" />
</form>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {validateOn:["blur"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "integer", {validateOn:["blur"]});
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8", "integer", {validateOn:["blur"]});
var sprytextfield9 = new Spry.Widget.ValidationTextField("sprytextfield9");
var sprytextfield10 = new Spry.Widget.ValidationTextField("sprytextfield10");
var sprytextfield11 = new Spry.Widget.ValidationTextField("sprytextfield11");
var sprytextfield12 = new Spry.Widget.ValidationTextField("sprytextfield12");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
//-->
</script>
</body>
</html>
<?php
mysql_free_result($list_hr);

mysql_free_result($list_destinos);

mysql_free_result($list_remite);

mysql_free_result($RecordOtrosDep);
?>
