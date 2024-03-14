<?php 
session_name("LoginSIRC");
session_start();
header("Content-Type: text/html; charset=utf-8");
//echo  "dep:".$_SESSION['dep']
//$cod_dep=$_SESSION['cod_dep'];
//echo  "dep:".$cod_dep;
?>
<?php require_once('../Connections/snet.php'); ?>
<?php
date_default_timezone_set("America/La_Paz"); 
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

//$gestion=date("Y");
$partes=split(" ",$_POST['fech_recib']);
$pfecha=split("-",$partes[0]); //fecha en partes
$gestion=$pfecha[0];

if(isset($_POST['hr']))
{ 
   if ($_POST['hr']!="")
   $hoja_ruta=$_POST['cod_deprecib']."-".$_POST['hr']."/".$gestion;
  else
    $hoja_ruta="";
}


$repetido_verificarHR =$hoja_ruta;

mysql_select_db($database_snet, $snet);
$query_verificarHR = sprintf("SELECT einterna.HR FROM einterna WHERE einterna.HR=%s", GetSQLValueString($repetido_verificarHR, "text"));
$verificarHR = mysql_query($query_verificarHR, $snet) or die(mysql_error());
$row_verificarHR = mysql_fetch_assoc($verificarHR);
$totalRows_verificarHR = mysql_num_rows($verificarHR);
 
if($totalRows_verificarHR>0){
   $error_repetido="Hoja de Ruta duplicada";
}
else{   

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO entradas (tema_titulo, usuario_cuenta, fecha_recibido, fun_recibido, dep_recibido, cod_deprecibido) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['tema'], "text"),
                       GetSQLValueString($_POST['usuario'], "text"),
                       GetSQLValueString($_POST['fech_recib'], "date"),
                       GetSQLValueString($_POST['fun_recib'], "text"),
                       GetSQLValueString($_POST['dep_recibido'], "text"),
                       GetSQLValueString($_POST['cod_deprecib'], "text"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($insertSQL, $snet) or die(mysql_error());
  $entrada_id=mysql_insert_id();
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO einterna (nhojas, anexos, entradas_id, entradas_tema_titulo, entradas_usuario_cuenta, cite, `ref`, dep_remite, fun_remite, hojaruta_codigo, fun_destino, dep_destino, fecha_doc, adjuntos, HR) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nhojas'], "int"),
                       GetSQLValueString($_POST['anexos'], "text"),
                       GetSQLValueString($entrada_id, "int"),
                       GetSQLValueString($_POST['tema'], "text"),
                       GetSQLValueString($_POST['usuario'], "text"),
                       GetSQLValueString($_POST['cite'], "text"),
                       GetSQLValueString($_POST['ref'], "text"),
                       GetSQLValueString($_POST['seg_d_destino'], "text"),
                       GetSQLValueString($_POST['seg_f_destino'], "text"),
                       GetSQLValueString($hoja_ruta, "text"),
                       GetSQLValueString($_POST['fun_destino'], "text"),
                       GetSQLValueString($_POST['dep_destino'], "text"),
                       GetSQLValueString($_POST['fecha_doc'], "date"),
                       GetSQLValueString($_POST['obs'], "text"),
                       GetSQLValueString($hoja_ruta, "text"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($insertSQL, $snet) or die(mysql_error());
  $einterna_id=mysql_insert_id();
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")&&($hoja_ruta!="")) {
  $insertSQL = sprintf("INSERT INTO hojaruta (cod, einterna_id, fecha_creacion, procedencia, `ref`, primer_destino, primerfun_destino, nhojas, nanexos, usuario_creador, cod_depcreador, cont_destinos, gestion) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($hoja_ruta, "text"),
                       GetSQLValueString($einterna_id, "int"),
                       GetSQLValueString($_POST['fech_recib'], "date"),
                       GetSQLValueString($_POST['seg_d_destino']." (".$_POST['seg_f_destino'].")", "text"),
                       GetSQLValueString($_POST['ref'], "text"),
                       GetSQLValueString($_POST['dep_destino'], "text"),
                       GetSQLValueString($_POST['fun_destino'], "text"),
                       GetSQLValueString($_POST['nhojas'], "int"),
                       GetSQLValueString($_POST['anexos'], "text"),
                       GetSQLValueString($_POST['usuario'], "text"),
                       GetSQLValueString($_POST['cod_deprecib'], "text"),
                       GetSQLValueString("1", "int"),
					   GetSQLValueString($gestion, "text"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($insertSQL, $snet) or die(mysql_error());
}

//eligiendo el mayor numero de HOJA DE RUTA
//1º verificando si El numero ingresado es mayor al del FOLIO.

if (GetSQLValueString($_POST['hr'], "int")>GetSQLValueString($_POST['ult_num'], "int"))
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1") && ($Result1)) {
  $updateSQL = sprintf("UPDATE dependencia SET cont_HR=%s WHERE cod=%s",
                       GetSQLValueString($_POST['hr'], "int"),
                       GetSQLValueString($_POST['cod_deprecib'], "text"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($updateSQL, $snet) or die(mysql_error());
}

}

$colname_cumpas = "-1";
if (isset($_SESSION['cod_dep'])) {
  $colname_cumpas = $_SESSION['cod_dep'];
}
mysql_select_db($database_snet, $snet);
$query_cumpas = sprintf("SELECT nombre FROM funcionario WHERE dependencia_cod = %s and habilitado = 1 ORDER BY cargo ASC", GetSQLValueString($colname_cumpas, "text"));
$cumpas = mysql_query($query_cumpas, $snet) or die(mysql_error());
$row_cumpas = mysql_fetch_assoc($cumpas);
$totalRows_cumpas = mysql_num_rows($cumpas);


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Registro ENTRADA::INTERNA</title>

<script src="js/calendario.js" type="text/javascript"></script>
<link href="js/calendario.css" rel="stylesheet" type="text/css" />
<script src="js/prototype.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script type="text/javascript" src="js/scriptaculous/prototype.js"></script>
<script type="text/javascript" src="js/scriptaculous/scriptaculous.js"></script>
<script type="text/javascript" src="js/scriptaculous/effects.js"></script>
<script type="text/javascript" src="../includes/kore/kore.js"></script>
<script type="text/javascript" src="../includes/jaxon/widgets/dialog/js/dialog.js"></script>
<link href="../includes/jaxon/widgets/dialog/css/dialog.css" rel="stylesheet" type="text/css" />

<script language="javascript">
 function mensaje(){
     new Widgets.Dialog('Intento de Hoja de ruta DUPLICADA', 'tooltip_hr_repetido.php', { click_outside: true, width: 300, height: 185 });
	 
 }
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
	 function ultimoHR(){
     var url = 'ajax/ultimoHR.php';
	 var myRand = parseInt(Math.random()*999999999999999);  
	 var pars = "rand="+myRand;
     var target = 'ultimo_hr';
     var miAjax = new Ajax.Updater(target, url, {method: 'get', parameters: pars});
	// alert(miAjax);
}

	 function colocarHR(){
     //ultimoHR();
	 
	 var codigo=$('ultimo_hr').innerHTML;
	 var numero=codigo.split("-");
	 //alert(numero[1]);
	 $('hr').value=parseInt(numero[1])+1;
}

	function ultimoHR1(){
     var url = 'ajax/ultimoHR.php';
	 var myRand = parseInt(Math.random()*999999999999999);  
	 var pars = "rand="+myRand;
     var target = 'ultimo_hr';
     var miAjax = new Ajax.Updater(target, url, {method: 'get', parameters: pars, onComplete: showResponse});
	 //alert(miAjax);
}
	function showResponse(originalRequest)
	{
		//put returned XML in the textarea
		//$('hr').value = originalRequest.responseText;
		//vaciando el componente text.
		$('hr').value="";
		//recuperando el valor
		var codigo=originalRequest.responseText;
		//separando campos
	    var numero=codigo.split("-");
	   //alert(numero[1]);
	   //insertando en el campo "hr" el ultimo valor disponible...
	   $('hr').value=parseInt(numero[1])+1;
}
	function foliador(){
     var url = 'ajax/folio_HR.php';
	 var myRand = parseInt(Math.random()*999999999999999);  
	 var pars = "rand="+myRand;
     var target = 'ultimo_hr';
     var miAjax = new Ajax.Updater(target, url, {method: 'get', parameters: pars, onComplete: MostrarCodHR});
	 //alert(miAjax);
}
	function MostrarCodHR(originalRequest)
	{
		//put returned XML in the textarea
		//$('hr').value = originalRequest.responseText;
		//vaciando el componente text.
		$('hr').value="";
		//recuperando el valor
		var numero=originalRequest.responseText;
		
		//$('ult_num').value=numero;
	   //separando campos    
	   //alert(numero[1]);
	   //insertando en el campo "hr" el ultimo valor disponible...
	   //alert(numero+' '+parseInt(numero));
	   //alert('tempHR='+$F('tempHr')+' o'+$('tempHr').value);
	   //almacenando ultimo valor del contador de Hojas de ruta
	   $('tempHr').value=parseInt(numero);
	   //alert($('tempHr').value);
	   //Insertando nuevo valor disponible de HR en Formulario.
	   $('hr').value=parseInt(numero)+1;
}

     function inicio(){
		$('seg_f_destino').select();
		$('seg_f_destino').focus();
}
		</script>
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
function presionarENTER(obj){
if (ord(form1.obj.value)==13) {document.form1.submit()}
}

//-->
</script>
<style type="text/css">
<!--
.botoncitos {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: 100;
	color: #FFFFFF;
	background-color: #0033CC;
	height: 20px;
}
.cuadro_superior {
	font-family: Arial, Helvetica, sans-serif;
	background-color: #EAF4FF;
	border: 1px solid #CAE9FF;
	font-size: 12px;
}
.botoncitos2 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: 100;
	color: #FFFFFF;
	background-color: #3366CC;
	height: 20px;
	border: 2px solid #4B4B4B;
}
.buscar {
	background-image: url(imagen/icono_buscar0.gif);
	padding-left: 25px;
	background-repeat: no-repeat;
	background-position: left center;
}
.ultimohr {
	background-image: url(imagen/foliador001.gif);
	background-repeat: no-repeat;
	background-position: left center;
	margin-left: 0px;
	padding-left: 30px;
}
.botones {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: 100;
	color: #000033;
	background-color: #C8E6FB;
	height: 22px;
	border: 2px solid #A4BAE8;

}
.botones1 {	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	height: 20px;
}
.cuadro_blanco {
	font-family: Arial, Helvetica, sans-serif;
	background-color: #FFFEFB;
	border: 2px solid #FFF8D5;
	font-size: 12px;
}
.botoneslive {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: 100;
	color: #000033;
	background-color: #D6EAFE;
	height: 22px;
	border: 2px solid #A4BAE8;
}
.fechatime {
	background-image: url(imagen/icon_date.gif);
	background-repeat: no-repeat;
	background-position: left center;
	margin-left: 0px;
	padding-left: 20px;
}
.funcionario {
	background-image: url(imagen/uno.png);
	padding-left: 20px;
	background-repeat: no-repeat;
}
.anexos {
	background-image: url(imagen/clip.gif);
	background-repeat:  no-repeat;
	background-position: left top;
	background-color: #FFFFFF;
	padding-left: 35px;
}
.obs {
	background-image: url(imagen/postdatedi4.gif);
	background-repeat:  no-repeat;
	background-position: left top;
	background-color: #DBFDE2;
	padding-left: 35px;
	color: #003366;
}
.guardar {
	background-image: url(imagen/page_save.gif);
	background-repeat: no-repeat;
	background-position: left center;
	padding-left: 25px;
}
.ref {
	text-transform: uppercase;
}
-->
        </style>
        <link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />

        <link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<style type="text/css">
div.autocomplete {
  position:absolute;
  width:250px;
  background-color:white;
  border:1px solid #888;
  margin:0px;
  padding:0px;
}
div.autocomplete ul {
  list-style-type:none;
  margin:0px;
  padding:0px;
}
div.autocomplete ul li.selected { background-color: #ffb;}
div.autocomplete ul li {
  list-style-type:none;
  display:block;
  margin:0;
  padding:2px;
  height:32px;
  cursor:pointer;
}
.Estilo1 {
	color: #000033;
	font-size: 10px;
	background-color:#CBDFFE;
}
body {
	margin: 0px;
	padding: 0px;
	border:0px;
}
.error {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #000033;
	background-color: #FFFFF0;
	border: 1px solid #FFFFCC;
}
</style>


</head>

<body onload="inicio();" style="background-color:#CFF">
<form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
  <table width="100%" border="0">
    <tr>
      <td>  <?php if ($error_repetido){ ?>
       	<script type="text/javascript">		      
			  //alert('Error: no se puede crear el registro porque ya existe la hoja de ruta');
			  mensaje();
		</script>
	  <?php }?>
      <div style="margin:10px; padding:1px;"></div>
      <!--<div align="right">      
        <input name="button2" type="submit" id="button2" value="Guardar Registro de Correspondencia" />
      </div>--></td>
    </tr>
    <tr>
      <td bgcolor="#CBDFFE"><table width="100%" border="0">
        <tr class="cuadro_superior">
          <td><fieldset>
            <legend>Origen-Destino</legend>
            <table width="100%" border="0">
              <tr>
                <td width="30" height="30">De:</td>
                <td width="220" height="30" ><span id="sprytextfield1">
                  <input name="seg_f_destino" type="text" id="seg_f_destino" size="30" value="<?php if ($error_repetido){ echo $_POST['seg_f_destino']; }?>"/>
                  <div id="lista_opciones" class="autocomplete"></div>
                  <span class="textfieldRequiredMsg">X</span></span>
                  <span id="preload" style="display: none">
  <img src="imagen/loading.gif" alt="Cargando..." /><span class="Estilo1">Cargando...</span>
</span>
<div id="lista_opciones" class="autocomplete" style="display:none;border:1px solid black;background-color:white;position:relative;"></div>
                  <script type="text/javascript">
					new Ajax.Autocompleter("seg_f_destino", "lista_opciones", 		"ajax/fun_remitente.php", {
method: "post",
paramName: "nombre"});

    			</script>
                </td>
                <td height="30">
                  
                  <table width="100%" border="0">
                    <tr>
                      <td width="250"><span id="sprytextfield2"><label>
                  <input name="seg_d_destino" type="text" id="seg_d_destino" size="35" value="<?php if ($error_repetido){ echo $_POST['seg_d_destino']; }?>"/></label>
                  <span class="textfieldRequiredMsg">X</span></span>
                  <script type="text/javascript">
					new Ajax.Autocompleter("seg_d_destino", "lista_opciones", 		"ajax/dep_remitente.php", {
method: "post",
paramName: "nombre"});
                    
    			</script></td>
                      <td><input name="button5" type="button" class="buscar" id="button5" onclick="MM_openBrWindow('insert_fun_Destino3.php','','width=620,height=315')" value="BUSCAR" /></td>
                      </tr>
                  </table></td>
                </tr>
              <tr>
                <td>Para:</td>
                <td><span id="spryselect1">
                  <select name="fun_destino" id="fun_destino">
                    <option value="Todos">Todos</option>
                    <?php
do {  
?>
                    <option value="<?php echo htmlentities($row_cumpas['nombre'])?>"><?php echo htmlentities($row_cumpas['nombre'])?></option>
                    <?php
} while ($row_cumpas = mysql_fetch_assoc($cumpas));
  $rows = mysql_num_rows($cumpas);
  if($rows > 0) {
      mysql_data_seek($cumpas, 0);
	  $row_cumpas = mysql_fetch_assoc($cumpas);
  }
?>
                  </select>
                  <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
                <td><input name="dep_destino" type="text" id="dep_destino" value="<?php echo $_SESSION['dep']; ?>" size="35" readonly="READONLY" /></td>
                </tr>
              </table>
          </fieldset>          </td>
          <td><fieldset>
            <legend>Hoja de Ruta</legend>
            <table width="100%" border="0">

              <tr>
                <td>Nro:</td>
                <td><span id="sprytextfield3">
                <input name="hr" type="text" id="hr" size="10" value="<?php if ($error_repetido){ echo "DUPLICADO"; }?>" readonly="READONLY"/>
                <span class="textfieldInvalidFormatMsg">x.</span> <span class="textfieldRequiredMsg">esta vacio.</span></span><span class="botoncitos2">
                <input name="tempHr" type="hidden" id="tempHr" value="0" />
                </span></td>
                </tr>
              <tr>
                <td><div class="botoncitos2" id="ultimo_hr"></div></td>
                <td><label>
                  <input name="codigo" type="button" class="ultimohr" id="codigo" onclick="foliador();" value="Foliador" />
                </label></td>
                </tr>
              </table>
          </fieldset>          </td>
          </tr>

      </table></td>
    </tr>
    <tr>
      <td><table width="100%" border="0" class="cuadro_blanco">
        <tr>
          <td width="750"><fieldset>
            <legend>Datos de la Correspondencia</legend>
            <table width="100%" border="0">
              <tr>
                <td>Fech.Doc</td>
                <td><span id="sprytextfield8">
                  <input name="fecha_doc" type="text" id="fecha_doc" size="10" readonly="READONLY"title="YYYY-MM-DD" onclick="displayCalendarFor('fecha_doc');" value="<?php if ($error_repetido){ echo $_POST['fecha_doc']; }?>"/>
                  <span class="textfieldRequiredMsg">X.</span></span>
                  <img src="imagen/icon_calendar_choose.png" alt="calendario" width="13" height="17" longdesc="calendario" onclick="displayCalendarFor('fecha_doc');" /></td>
                </tr>
              <tr>
                <td>Cite</td>
                <td><span id="sprytextfield4">
                  <input name="cite" type="text" id="cite" size="60" value="<?php if ($error_repetido){ echo $_POST['cite']; }?>"/>
                  <span class="textfieldRequiredMsg">X.</span></span></td>
                </tr>
              <tr>
                <td>Ref.</td>
                <td><span id="sprytextfield5">
                <script language=""="JavaScript">
    function conMayusculas(field) {
            field.value = field.value.toUpperCase()
}
</script>
                <input name="ref" type="text" id="ref" size="60" onChange="conMayusculas(this)" value="<?php if ($error_repetido){ echo $_POST['ref']; }?>"/>
                <span class="textfieldRequiredMsg">X.</span><span class="textfieldMinCharsMsg">(+)caracter..</span></span></td>
                </tr>
              <tr>
                <td>Hojas</td>
                <td><span id="sprytextfield6">
                <input name="nhojas" type="text" id="nhojas" size="60" maxlength="5" value="<?php if ($error_repetido){ echo $_POST['nhojas']; }?>"/>
                <span class="textfieldRequiredMsg">X.</span><span class="textfieldInvalidFormatMsg">incorrecto.</span></span></td>
              </tr>
              <tr>
                <td>Anexos</td>
                <td><textarea name="anexos" cols="35" rows="3" class="anexos" id="anexos" ><?php if ($error_repetido){ echo $_POST['anexos']; }else{?>-
-<?php }?></textarea></td>
              </tr>
              <tr>
                <td>Obs.</td>
                <td><textarea name="obs" cols="35" rows="5" class="obs" id="obs"><?php if ($error_repetido){ echo $_POST['obs']; }else{?>N.A.<?php }?></textarea></td>
              </tr>
              </table>
          </fieldset>          </td>
          <td><table width="100%" border="0">
            <tr>
              <td><fieldset>
                <legend>Clasificacion</legend>
                <table width="100%" border="0">
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><input name="button3" type="button" class="botoncitos2" id="button3" value="" />
                      Tema</td>
                    <td><span id="spryselect2" style="width:70px;">
                      <div id="spry_tema">
                        <select name="tema" id="tema" style="width:70px;">
                          <option value="no tiene tema." selected="selected">no tiene tema.</option>
                        </select>
</div>
                      <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
                    </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td><input name="refresh_tema" type="button" class="botoncitos2" id="refresh_tema"  onclick="temas();" value="Actualizar Temas"/></td>
                  </tr>
                  <tr>
                    <td><input name="button4" type="button" class="botoncitos2" id="button4" value="" />
                      Tipo.doc                      <br /></td>
                    <td><span id="spry_tipo">
                      <select name="tipo" id="tipo">
                        <option value="no definido.">no definido.</option>
                      </select>
                      <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
                    </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td><input name="refresh_tipo" type="button" class="botoncitos2" id="refresh_tipo"  onclick="tipos();" value="Actualizar Tipos."/></td>
                  </tr>
                    </table>
              </fieldset>              </td>
              </tr>
            <tr bgcolor="#CBDFFE">
              <td class="cuadro_superior"><fieldset>
                <legend style="font-weight:bold;">Recibido</legend>
                <table width="100%" border="0">
                  <tr>
                    <td>                      Fech.Recib.</td>
                    <td><span id="sprytextfield7">
                      <input name="fech_recib" type="text" class="fechatime" id="fech_recib" value="<?php echo date("Y-m-d H:i:s"); ?>" size="20" readonly="READONLY"/>
                      <span class="textfieldRequiredMsg">X.</span></span></td>
                    </tr>
                  <tr>
                    <td>Nom. Recib.</td>
                    <td><input name="fun_recib" type="text" id="fun_recib" value="<?php echo htmlentities($_SESSION['fun']); ?>" size="25" readonly="READONLY" />
                      <input name="dep_recibido" type="hidden" id="dep_recibido" value="<?php echo $_SESSION['dep']; ?>" />
                      <input name="cod_deprecib" type="hidden" id="cod_deprecib" value="<?php echo $_SESSION['cod_dep']; ?>" />
                      <input name="usuario" type="hidden" id="usuario" value="<?php echo $_SESSION['user']; ?>" /></td>
                    </tr>
                    </table>
              </fieldset>              </td>
              </tr>

          </table></td>
          </tr>

      </table></td>
    </tr>
    <tr>
      <td><label><div align="center">
        <input name="button" type="submit" class="guardar" id="button" value="Guardar Registro de Correspondencia" style=" margin:20px; width:300px; height:30px; border: groove; font-weight:bold;"/></div>
      </label></td>
    </tr>
  </table>

<input type="hidden" name="MM_insert" value="form1" />
<input type="hidden" name="MM_update" value="form1" />
</form>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "integer", {validateOn:["blur", "change"], isRequired:false});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "none", {minChars:3});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "none", {validateOn:["blur"]});
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "integer");
var spryselect2 = new Spry.Widget.ValidationSelect("spry_tema", {validateOn:["blur", "change"]});
var spryselect3 = new Spry.Widget.ValidationSelect("spry_tipo", {validateOn:["blur", "change"]});
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8", "none", {validateOn:["blur"]});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($cumpas);

mysql_free_result($verificarHR);
?>
