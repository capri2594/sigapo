<?php 
session_name("LoginSIRC");
session_start();
$dep_remite=$_SESSION['dep'];
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO salidas (cite, tema_titulo, tipo_clase, usuario_cuenta, dep_remitente, fun_remitente, fecha_envio, `ref`, fecha_doc) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['cite'], "text"),
                       GetSQLValueString($_POST['tema'], "text"),
                       GetSQLValueString($_POST['tipo'], "text"),
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['dremite2'], "text"),
                       GetSQLValueString($_POST['fremite2'], "text"),
                       GetSQLValueString($_POST['fecha_envio'], "date"),
                       GetSQLValueString($_POST['ref'], "text"),
                       GetSQLValueString($_POST['fecha_doc'], "date"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($insertSQL, $snet) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO salinternas (salidas_cite, salidas_tema_titulo, salidas_tipo_clase, salidas_usuario_cuenta, nhojas, ladjuntos, danexos, fun_destino, dep_destino) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['cite'], "text"),
                       GetSQLValueString($_POST['tema'], "text"),
                       GetSQLValueString($_POST['tipo'], "text"),
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['hojas'], "int"),
                       GetSQLValueString($_POST['adj'], "text"),
                       GetSQLValueString($_POST['anexo'], "text"),
                       GetSQLValueString($_POST['dfun2'], "text"),
                       GetSQLValueString($_POST['ddestino'], "text"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($insertSQL, $snet) or die(mysql_error());
  
  header("Refresh:4; url=enviarInternos.php");
  echo "Los datos han sido GRABADOS correctamente.<br>";

  echo "<p><span style=\"background-color:#FF0033; color:white; font-size:13px;\">REDIRECCIONANDO.....</span><p>";

  echo "<br>SID=".session_id();
  //echo "<p><a href=javascript>";
  exit(0);
}

mysql_select_db($database_snet, $snet);
$query_listTemas = "SELECT * FROM tema ORDER BY titulo ASC";
$listTemas = mysql_query($query_listTemas, $snet) or die(mysql_error());
$row_listTemas = mysql_fetch_assoc($listTemas);
$totalRows_listTemas = mysql_num_rows($listTemas);

mysql_select_db($database_snet, $snet);
$query_listTipos = "SELECT * FROM tipo ORDER BY clase ASC";
$listTipos = mysql_query($query_listTipos, $snet) or die(mysql_error());
$row_listTipos = mysql_fetch_assoc($listTipos);
$totalRows_listTipos = mysql_num_rows($listTipos);

$colname_listFunc = "-1";
if (isset($_SESSION['cod_dep'])) {
  $colname_listFunc = $_SESSION['cod_dep'];
}
mysql_select_db($database_snet, $snet);
$query_listFunc = sprintf("SELECT * FROM funcionario WHERE dependencia_cod = %s ORDER BY nombre ASC", GetSQLValueString($colname_listFunc, "text"));
$listFunc = mysql_query($query_listFunc, $snet) or die(mysql_error());
$row_listFunc = mysql_fetch_assoc($listFunc);
$totalRows_listFunc = mysql_num_rows($listFunc);

mysql_select_db($database_snet, $snet);
$query_Depdestino = "SELECT * FROM dependencia ORDER BY nombredep ASC";
$Depdestino = mysql_query($query_Depdestino, $snet) or die(mysql_error());
$row_Depdestino = mysql_fetch_assoc($Depdestino);
$totalRows_Depdestino = mysql_num_rows($Depdestino);

$colname_DestFun = "-1";
if (isset($_GET['ddestino'])) {
  $colname_DestFun = $_GET['ddestino'];
}
mysql_select_db($database_snet, $snet);
$query_DestFun = sprintf("SELECT * FROM funcionario, dependencia WHERE funcionario.dependencia_cod=dependencia.cod AND dependencia_cod = %s ORDER BY funcionario.nombre", GetSQLValueString($colname_DestFun, "text"));
$DestFun = mysql_query($query_DestFun, $snet) or die(mysql_error());
$row_DestFun = mysql_fetch_assoc($DestFun);
$totalRows_DestFun = mysql_num_rows($DestFun);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryEffects.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />

<script src="js/calendario.js" type="text/javascript"></script>
<link href="js/calendario.css" rel="stylesheet" type="text/css" />
<script src="js/prototype.js" type="text/javascript"></script>
<style type="text/css">
<!--
#apDiv1 {
	position:absolute;
	width:200px;
	height:115px;
	z-index:1;
}
#capa1 {
	background-color: #F1F2F3;
}
.Estilo2 {font-size: small}
body {
	font-family: Arial, Helvetica, sans-serif;
	font-size: small;
	color: #003366;
	border-top-width: 0px;
	border-right-width: 0px;
	border-bottom-width: 0px;
	border-left-width: 0px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
	padding:0px;
	margin:0px;
}
-->
</style>
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
function MM_popupMsg(msg) { //v1.0
  alert(msg);
}
function MM_showHideLayers() { //v9.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) 
  with (document) if (getElementById && ((obj=getElementById(args[i]))!=null)) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}
function MM_effectShake(targetElement)
{
	Spry.Effect.DoShake(targetElement);
}
function MM_effectGrowShrink(targetElement, duration, from, to, toggle, referHeight, growFromCenter)
{
	Spry.Effect.DoGrow(targetElement, {duration: duration, from: from, to: to, toggle: toggle, referHeight: referHeight, growCenter: growFromCenter});
}
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<link href="../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo3 {color: #FF0000}
.Estilo6 {color: #FF0000; font-size: x-small; }
.cajas {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #000000;
	width: auto;
	height: 20px;
}
-->
</style>
</head>

<body>
<div id="capa1" align="left">
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="100%" border="0" cellspacing="2" cellpadding="1">
    <tr>
      <td>&nbsp;</td>
      <td><div align="left"><span class="Estilo2">fecha de envio:</span>&nbsp; <span style="background-color:#DBFDE2; border-color: #CCCCCC;">&nbsp;
          <?php 
		$t=date("Y-m-d H:i:s");
		print ($t);?>
        &nbsp;&nbsp;          </span>
          <input name="fecha_envio" type="hidden" value="<?php echo $t;?>" />
            <br>
      </div></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><div align="right">&nbsp;</div></td>
      <td>
       <table width="100%" border="0" cellspacing="1" cellpadding="0">
         <tr>
           <td ><input name="username" type="hidden" id="username" value="<?php echo $_SESSION['user']?>" /></td>
           <td >&nbsp;</td>
           <td ><div align="left"><input name="elegir" type="button" id="elegir" onclick="MM_showHideLayers('ddestino','','show')" value="Elegir" />&nbsp;<span id="spryselect4">
             <select name="ddestino" class="cajas" id="ddestino" style="visibility:hidden" onchange="MM_jumpMenu('self',this,0)">
               <option value="vacio" selected="selected">---- Seleccione una dependencia ----</option>
               <?php
do {  
?>
               <option value="<?php echo $_SERVER['PHP_SELF']."?ddestino=".$row_Depdestino['cod'];?>&dremite=<?php echo $_GET['dremite'];?>
                "><?php echo $row_Depdestino['nombredep'];?></option>
               <?php
} while ($row_Depdestino = mysql_fetch_assoc($Depdestino));
  $rows = mysql_num_rows($Depdestino);
  if($rows > 0) {
      mysql_data_seek($Depdestino, 0);
	  $row_Depdestino = mysql_fetch_assoc($Depdestino);
  }
?>
             </select>
             <span class="selectRequiredMsg">Seleccione un elemento.</span></span>
               
           </div>             </td>
           </tr>
         <tr>
           <td><fieldset>
               <legend>Origen</legend>
             <table width="90%" border="0" cellspacing="3" cellpadding="0">
             <tr>
               <td><div align="right">Dependencia</div></td>
               <td><div align="right"><span id="spryselect7">
                   <select name="dremite2" size="1" class="cajas" id="dremite2" >
                     <option value="<?php /*echo $_GET['dremite'];*/ echo $dep_remite;?>" selected="selected"><?php /*echo $_GET['dremite'];*/ echo $dep_remite;?></option>
                   </select>
                   <span class="selectRequiredMsg">Seleccione un elemento.</span> </span></div></td>
             </tr>
             <tr>
               <td><div align="right">Funcionario</div></td>
               <td><div align="right"><span id="spryselect9">
                   <select name="fremite2" class="cajas" id="fremite2">

                     <?php
do {  
?>
                     <option value="<?php echo $row_listFunc['nombre']?>"><?php echo $row_listFunc['nombre']?></option>
                     <?php
} while ($row_listFunc = mysql_fetch_assoc($listFunc));
  $rows = mysql_num_rows($listFunc);
  if($rows > 0) {
      mysql_data_seek($listFunc, 0);
	  $row_listFunc = mysql_fetch_assoc($listFunc);
  }
?>
                     <option value="otro">OTRO funcionario</option>
                     <option value="todos">TODOS</option>
                   </select>
                   <span class="selectRequiredMsg">Seleccione un elemento.</span> </span> </div></td>
             </tr>
           </table>
           
           </fieldset>           </td>
           <td><div style="width:30px;">&nbsp;</div></td>
           <td><div style="width:320px;"><fieldset>
                          <legend>Destino</legend>
               <table width="90%" border="0" cellspacing="3" cellpadding="0">
             <tr>
               <td>Dependencia:</td>
               <td><span id="spryselect8"><span class="selectRequiredMsg">Seleccione un elemento.</span>
                  <input name="ddestino" type="text" class="cajas" id="ddestino" value="<?php echo $row_DestFun['nombredep']; ?>" readonly="readonly"/>
              </span></td>
             </tr>
             <tr>
               <td>Funcionario:</td>
               <td><span id="spryselect3">
               
                 <select name="dfun2" class="cajas" id="dfun2">                  
                   <?php
do {  
?>
                   <option value="<?php echo $row_DestFun['nombre']?>"><?php echo $row_DestFun['nombre']?></option>
                   <?php
} while ($row_DestFun = mysql_fetch_assoc($DestFun));
$rows = mysql_num_rows($DestFun);
  if($rows > 0) {
      mysql_data_seek($DestFun, 0);
	  $row_DestFun = mysql_fetch_assoc($DestFun);
  }
?>
                  <?php if ($totalRows_DestFun > 0) { // Show if recordset not empty ?> 
                   <option value="otro">Otro....</option>
                   <option value="todos">TODOS</option>
               
                 <?php } // Show if recordset not empty ?>
                   </select>
                   <span class="selectRequiredMsg">Seleccione un elemento.</span></span>               </td>
             </tr>
           </table>
           
           </fieldset> </div></td>
         </tr>
       </table>       </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><div align="right"><span class="Estilo3">*</span>&nbsp;fechado del documento</div></td>
      <td><div align="left">&nbsp;
        <input size="10" id="fecha_doc" type="text" readonly="READONLY" name="fecha_doc" title="YYYY-MM-DD" value="<?php echo $_POST['fecha_doc'];?>"/>
        <input type="button" value="calendario" onclick="displayCalendarFor('fecha_doc');" />
        </div>        </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><div align="right"><span class="Estilo3">*</span>&nbsp;cite</div></td>
      <td>&nbsp;<span id="cite1">
      <input name="cite" type="text" id="cite" value="<?php echo $_POST['cite'];?>" size="41" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span><span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span></span></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><div align="right"><span class="Estilo3">*</span>&nbsp;ref. </div></td>
      <td>&nbsp;<span id="sprytextfield2">
        <input name="ref" type="text" id="ref" value="<?php echo $_POST['ref'];?>" size="60" />
        <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span><span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span></span></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><div align="right">tema</div></td>
      <td>&nbsp;<span id="spry_tema">
        <select name="tema" id="tema">
          <?php
do {  
?>
          <option value="<?php echo $row_listTemas['titulo']?>"><?php echo $row_listTemas['titulo']?></option>
          <?php
} while ($row_listTemas = mysql_fetch_assoc($listTemas));
  $rows = mysql_num_rows($listTemas);
  if($rows > 0) {
      mysql_data_seek($listTemas, 0);
	  $row_listTemas = mysql_fetch_assoc($listTemas);
  }
?>
        </select>
      </span>
        <input name="button3" type="button" id="button3" onclick="MM_openBrWindow('agregar_tema.php','','left=100,top=100,width=600,height=350')" value="Agregar" />
        <script language="javascript">
		function temas(){
     var url = 'selec_temas.php';
	 var myRand = parseInt(Math.random()*999999999999999);

     var pars = 'jose='+escape($F('tema'));
	 var pars = pars+"&rand="+myRand;
     var target = 'spry_tema';
     var miAjax = new Ajax.Updater(target, url, {method: 'get', parameters: pars});
}
		function tipos(){
     var url = 'selec_tipos.php';
	 var myRand = parseInt(Math.random()*999999999999999);

     var pars = 'jose='+escape($F('tema'));
	 var pars = pars+"&rand="+myRand;
     var target = 'spry_tipo';
     var miAjax = new Ajax.Updater(target, url, {method: 'get', parameters: pars});
}
		</script>
        <input type="button" name="refresh_tema" id="refresh_tema" value="Actualizar"  onclick="temas();"/></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><div align="right">tipo</div></td>
      <td>&nbsp;<span id="spry_tipo">
        <select name="tipo" id="tipo">
          <?php
do {  
?>
          <option value="<?php echo $row_listTipos['clase']?>"><?php echo $row_listTipos['clase']?></option>
          <?php
} while ($row_listTipos = mysql_fetch_assoc($listTipos));
  $rows = mysql_num_rows($listTipos);
  if($rows > 0) {
      mysql_data_seek($listTipos, 0);
	  $row_listTipos = mysql_fetch_assoc($listTipos);
  }
?>
        </select>
      <span class="selectRequiredMsg">Seleccione un elemento.</span></span>
        <input name="button4" type="button" id="button4" onclick="MM_openBrWindow('agregar_tipo.php','','width=600,height=380')" value="Agregar" />
         <input type="button" name="refresh_tipo" id="refresh_tipo" value="Actualizar"  onclick="tipos();"/>
         <?php //echo $_SERVER['PHP_SELF']."<br>";?>
        <?php /*foreach ($_GET as $indice => $valor){ 
echo $indice." = ".$valor."<br>"; 
} ;*/?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><div align="right"><span class="Estilo3">*</span>&nbsp;Nro. Hojas</div></td>
      <td>&nbsp;<span id="sprytextfield3">
        <input type="text" name="hojas" id="hojas" />
        <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido. Introduzca un numero entero (0..99)</span></span>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    
    <tr>
      <td>&nbsp;</td>
      <td><div id="CollapsiblePanel1" class="CollapsiblePanel">
        <div class="CollapsiblePanelTab" tabindex="0">Mas Datos (complementarios)</div>
        <div class="CollapsiblePanelContent">
        <table width="100%" border="0" cellpadding="0" cellspacing="1" id="tmasdatos">
        <tr>
          <td>anexos:<span id="sprytextarea1">
          <textarea name="anexo" id="anexo" cols="30" rows="3">-
-
-</textarea>
          Quedan:<span id="countsprytextarea1">&nbsp;</span>&nbsp;letras<span class="textareaMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>          </span></td>
          <td>Obs: <span id="sprytextarea2">
          <textarea name="adj" id="adj" cols="30" rows="3"></textarea>
          <span class="textareaMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>          Quedan:<span id="countsprytextarea2">&nbsp;</span>&nbsp;Letras</span></td>
        </tr>
      </table>
        </div>
      </div>        </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><div align="right"></div></td>
      <td><span class="Estilo6">(*) LLenar todos los datos obligatorios.</span></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
          <tr>
            <td><input type="submit" name="button" id="button" value="Enviar" /></td>
            <td><input name="button2" type="reset" id="button2" onclick="MM_popupMsg('Se perdera todos los datos ingresados')" value="Cancelar" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  
  <input type="hidden" name="MM_insert" value="form1" />
</form>
</div>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("cite1", "none", {validateOn:["blur"], maxChars:50, minChars:3});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {maxChars:80, minChars:5, validateOn:["blur"]});
var spryselect1 = new Spry.Widget.ValidationSelect("spry_tipo", {validateOn:["blur"]});
var spryselect2 = new Spry.Widget.ValidationSelect("spry_tema", {validateOn:["blur"], isRequired:false});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "integer", {validateOn:["blur"]});
var spryselect9 = new Spry.Widget.ValidationSelect("spryselect9", {validateOn:["blur"]});
var spryselect7 = new Spry.Widget.ValidationSelect("spryselect7", {validateOn:["blur"]});
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3", {validateOn:["blur"]});
var spryselect4 = new Spry.Widget.ValidationSelect("spryselect4", {validateOn:["blur"]});
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {validateOn:["blur"], isRequired:false, maxChars:200, counterId:"countsprytextarea1", counterType:"chars_remaining"});
var sprytextarea2 = new Spry.Widget.ValidationTextarea("sprytextarea2", {validateOn:["blur"], isRequired:false, counterId:"countsprytextarea2", counterType:"chars_remaining", hint:"Escriba...Observacion o Mensaje que desea enviar", maxChars:200});
var CollapsiblePanel1 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel1", {contentIsOpen:false});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($listTemas);

mysql_free_result($listTipos);

mysql_free_result($listFunc);

mysql_free_result($Depdestino);

mysql_free_result($DestFun);
?>
