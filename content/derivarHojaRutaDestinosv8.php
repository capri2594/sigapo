<?php 
session_name("LoginSIRC");
session_start();
$cod_dep=$_SESSION['cod_dep'];
$_SESSION["control_vacio"]=0;
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
$dia_actual=date("Y-m-d");
$codigo_obtener_hr = "-1";
if (isset($_GET['cod'])) {
  $codigo_obtener_hr = $_GET['cod'];
}
mysql_select_db($database_snet, $snet);
$query_obtener_hr = sprintf("SELECT * FROM hojaruta WHERE hojaruta.cod=%s", GetSQLValueString($codigo_obtener_hr, "text"));
$obtener_hr = mysql_query($query_obtener_hr, $snet) or die(mysql_error());
$row_obtener_hr = mysql_fetch_assoc($obtener_hr);
$totalRows_obtener_hr = mysql_num_rows($obtener_hr);

$codigo_listar_destinos = "-1";
if (isset($_GET['cod'])) {
  $codigo_listar_destinos = $_GET['cod'];
}
mysql_select_db($database_snet, $snet);
$query_listar_destinos = sprintf("SELECT id, hojaruta_cod, nro_destino, fun_destino, dep_destino, fecha_derivacion, DATE(fecha_derivacion) AS fecha_activa, proveido, mensaje, fecha_recibidoHR, nhojas, anexos, fun_derivador, cod_depderivador, usuario_derivador, salidas_id, entradas_id FROM derivacion WHERE derivacion.hojaruta_cod=%s ORDER BY derivacion.nro_destino ASC", GetSQLValueString($codigo_listar_destinos, "text")); //modificar 2023
//$query_listar_destinos = sprintf("SELECT * FROM derivacion WHERE derivacion.hojaruta_cod=%s ORDER BY derivacion.nro_destino ASC", GetSQLValueString($codigo_listar_destinos, "text"));
$listar_destinos = mysql_query($query_listar_destinos, $snet) or die(mysql_error());
$row_listar_destinos = mysql_fetch_assoc($listar_destinos);
$totalRows_listar_destinos = mysql_num_rows($listar_destinos);
?>
<?php 
require_once("include/convertir_fechas.php");
require_once("include/calcular_permanencia.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo  $_GET['cod']; ?></title>
<style type="text/css">
<!--
.titulos {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #FFFFFF;
	background-color: #6B7A9D;
	border: 1px solid #FFFFFF;
}
.pendiente {
	background-color: #FCF6D8;
	height: 20px;
	width: 100px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #000000;
}
.procesado {
	background-color: #9AE7B3;
	height: 25px;
	width: 100px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #000000;
}
.botones {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #333333;
	background-color: #CAD2DB;
	border: 1px solid #FFFFFF;
}
.celeste {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #003366;
	background-color: #E5ECF7;
	border: 1px solid #FFFFFF;
}
.celeste2 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #003366;
	background-color: #E5ECF7;
	border: 0px solid;
}
.celdas {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #003366;
	background-color: #FAFCFE;
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-style: solid;
	border-right-style: solid;
	border-bottom-style: solid;
	border-left-style: solid;
	border-top-color: #CCCCCC;
	border-right-color: #CCCCCC;
	border-bottom-color: #CCCCCC;
	border-left-color: #CCCCCC;
}
.Estilo4 {font-size: 12px}
.new_destino {
    cursor:pointer; 
	cursor:hand;
	background-image: url(imagen/usuario02.png);
	background-repeat: no-repeat;
	background-position: left center;
	margin-left: 0px;
	padding-left: 30px;
}
.Estilo5 {background-color: #9AE7B3; height: 15px; width: 100px; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; color: #000000; }
.b_imprimir {
    cursor:pointer; 
	cursor:hand;
	background-image: url(imagen/hr.gif);
	background-repeat: no-repeat;
	background-position: left center;
	padding-left: 25px;
	width: 75px;
	padding-right: 0px;
	height: 30px;
	color: #000000;
	vertical-align: middle;
	margin-left: 0px;
}
.editarHR {
	font-family: Arial, Helvetica, sans-serif;
	background-image: url(imagen/botones/edit.png);
	background-repeat: no-repeat;
	background-position: left center;
	height: 20px;
	width: 70px;
	padding-left: 20px;
	margin-left: 5px;
}
.b_imprimir2 {
    cursor:pointer; 
	cursor:hand;
	background-image: url(imagen/preview.gif);
	background-repeat: no-repeat;
	background-position: left center;
	margin-left: 0px;
	padding-left: 25px;
}
.b_salir {
    cursor:pointer; 
	cursor:hand;
	background-image: url(imagen/exit.png);
	background-repeat: no-repeat;
	padding-left: 30px;
	background-position: left center;
	margin-left: 0px;
}
.actualizar {
	background-image: url(imagen/actualizar.png);
	padding-left: 25px;
	background-repeat: no-repeat;
	background-position: left center;
	color: #000000;
	height: 30px;
}
.Estilo7 {font-size: 12px; font-weight: bold; }
body {
	margin: 0px;
	padding: 3px;
	border-top-color: #CAD2DB;
	border-right-color: #CAD2DB;
	border-bottom-color: #CAD2DB;
	border-left-color: #CAD2DB;
	background-color: #FAFCFE;
}
.eliminar {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	background-image: url(imagen/botones/eliminar_todo.png);
	background-repeat: no-repeat;
	height: 20px;
	width: 20px;
}
.desactivar {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	background-image: url(imagen/botones/vaciar_off.png);
	background-repeat: no-repeat;
	height: 20px;
	width: 20px;
}
.modificar {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	background-image: url(imagen/botones/edit_on.png);
	background-repeat: no-repeat;
	height: 20px;
	width: 20px;
}
.Estilo8 {font-size: 11px}
.barra {
	background-image: url(imagen/barras/fondo_barra.jpg);
	background-repeat:   repeat-x;
	border-top-width: 0px;
	border-right-width: 0px;
	border-bottom-width: 0px;
	border-left-width: 0px;
	border-top-style: solid;
	border-right-style: solid;
	border-bottom-style: solid;
	border-left-style: solid;
	height: 30px;
}
.barra_imprimir {
    cursor:pointer; 
	cursor:hand;
	background-image: url(imagen/barras/icon_impresora.jpg);
	background-repeat:   no-repeat;
	border-top-width: 0px;
	border-right-width: 0px;
	border-bottom-width: 0px;
	border-left-width: 0px;
	border-top-style: solid;
	border-right-style: solid;
	border-bottom-style: solid;
	border-left-style: solid;
	height: 30px;
}
.barra_espacio {
	background-image: url(imagen/barras/separador.jpg);
	background-repeat:  no-repeat;
}
.tabla_barra {
	margin: 0px;
	padding: 0px;
	border-top-width: 0px;
	border-right-width: 0px;
	border-bottom-width: 0px;
	border-left-width: 0px;
	border-top-style: solid;
	border-right-style: solid;
	border-bottom-style: solid;
	border-left-style: solid;
}
.Estilo17 {
	color: #000000;
	font-size: 13px;
	font-family: sans-serif, fantasy, Rockwell, "Lucida Sans";
	letter-spacing: 0px;
}
.Estilo19 {background-image: url(imagen/barras/fondo_barra.jpg); background-repeat: repeat; border-top-width: 0px; border-right-width: 0px; border-bottom-width: 0px; border-left-width: 0px; border-top-style: solid; border-right-style: solid; border-bottom-style: solid; border-left-style: solid; color: #000000; }
.Estilo21 {color: #FFFFFF}
.fech_salida {
	background-color: #FCF6D8;
	height: 20px;
	width: 100px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #000000;
}
.fech_entrega {
	background-color: #BEE3B6;
	height: 20px;
	width: 100px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #000000;
}
.noreportado {
	height: 25px;
	width: 100px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #C1C1C1;
}
.proveido {
	height: auto;
	width: auto;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #000000;
	margin-left: 5px;
	padding-left: 3px;
	text-align: justify;
	margin-right: 2px;
	padding-right: 2px;
}
.titulo_proveido {
	height: auto;
	width: auto;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #000000;
	margin-left: 1px;
	padding-left: 0px;
	text-align: justify;
	margin-right: 2px;
	padding-right: 2px;
	font-weight: 500;
	font-variant: small-caps;
	background-color: #FCF6D8;
	margin-top: 3px;
	padding-top: 3px;
}
-->
</style>

<script type="text/javascript" src="js/scriptaculous/prototype.js"></script>
<script type="text/javascript" src="js/scriptaculous/scriptaculous.js"></script>
<script type="text/javascript" src="js/scriptaculous/effects.js"></script>
<script type="text/javascript" src="js/scriptaculous/controls.js"></script>
<script type="text/javascript" src="js/scriptaculous/unittest.js"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>

<script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
function ndestino(theURL,winName,features) { //v2.0
  vdestino=window.open(theURL,winName,features);
  vdestino.window.focus();
}

function desactivar01(iddestino,codpropio,panel){
    //alert('desactivando destino');
	//alert('desactivado');
	confirmar=confirm('Esta seguro?. El sistema Desactivara este destino.');
	if (confirmar==true)
	{
	 
     var url = 'ajax/desactivar_destino.php';
	 var myRand = parseInt(Math.random()*999999999999999);  
	 var pars = "rand="+myRand;
	 if (codpropio=='') {alert('Lo siento Destino ya esta desactivado.');exit(0); };
	 pars+='&cod_propietario='+escape(codpropio)+'*D';
	 pars+='&id_derivacion='+escape(iddestino);
	 //alert(pars);
     var target = panel;
     var miAjax = new Ajax.Updater(target, url, {method: 'get', parameters: pars, onComplete: showResponse});
	 //alert(miAjax);

    }//fin if
	function showResponse(originalRequest)
	{
		//put returned XML in the textarea
		//$('inactivo4').innerHTML = originalRequest.responseText;
		
}

	 
}

function eliminar(iddestino,codhr,contador){
    //alert('desactivando destino');
	//alert('desactivado');

	confirmar=confirm('Eliminar este destino \nEsta seguro?.');
	if (confirmar==true)
	{
	 
     var url = 'ajax/eliminar_destino.php';
	 var myRand = parseInt(Math.random()*999999999999999);  
	 var pars = "rand="+myRand;
	 //if (codpropio=='') {alert('Lo siento Destino ya esta desactivado.');exit(0); };
	 pars+='&id_destino='+escape(iddestino);
	 pars+='&cod='+escape(codhr);
	 pars+='&cont='+escape(contador);
	 //alert(pars);
     var target = 'inactivo'+(parseInt(contador)-1);
     var miAjax = new Ajax.Updater(target, url, {method: 'get', parameters: pars, onComplete: showResponse});
	 //alert(miAjax);

    }//fin if
	function showResponse(originalRequest)
	{
		//put returned XML in the textarea
		//$('inactivo4').innerHTML = originalRequest.responseText;
		var resultado=originalRequest.responseText;
		if (resultado=="ok") alert('Elminacion correcta.');
		alert('Elminacion correcta.');
		window.location.reload();
		
    }
	
}

function entrega(iddestino){
 //alert('desactivando destino');
     var url = 'ajax/xml_destinos_entrega.php';
	 var myRand = parseInt(Math.random()*999999999999999);  
	 var pars = "rand="+myRand;
	 //if (codpropio=='') {alert('Lo siento Destino ya esta desactivado.');exit(0); };
	 pars+='&iden='+escape(iddestino);
	 //alert(pars);
     var target = '';
     var miAjax = new Ajax.Updater(target, url, {method: 'get', parameters: pars, onComplete: showResponse});
	 //alert(miAjax);

 }
 function showResponse(responseXMLCli)
 {

        //var xml  = responseXMLCli.responseXML.documentElement;
		var xml  = responseXMLCli.responseXML.getElementsByTagName('recibido');

        // Accedemos al DIV
        // Iteramos cada cliente
		//alert(xml.length);
        for (i = 0; i < xml.length; i++)
        {
            // Accedemos al objeto XML cliente
			//alert(i);
            var id = xml[0].getElementsByTagName('id')[0].firstChild.nodeValue;
            // Recojemos el id del cliente
            // Mostramos el enlace
			//alert(id);
       }
	   
       var miDiv = document.getElementById('div_recib'+id);
	   //alert(id);
	   //alert(xml[0].getElementsByTagName('fecha')[0].firstChild.nodeValue);
        // Vaciamos el DIV
       miDiv.innerHTML = xml[0].getElementsByTagName('fecha')[0].firstChild.nodeValue;
	   
//miDiv.innerHTML = EstructuraHTML+'</ul>\n'; 
}		

//definiendo variable de fechas...
lista= new Array();//salidas...
function mostrar_salidas(){
//alert('mostrando');
//alert(lista[0]);
for(i=0;i<lista.length;i++){
//alert(lista[i]);
//$('sal'+i).innerHTML=lista[i];
//alert('div: '+$('sal'+i).innerHTML);
$('sal'+i).innerHTML=lista[i];
}
}

estadia= new Array();//salidas...
function estadias(){
//alert('mostrando');
//alert(lista[0]);
for(i=0;i<estadia.length;i++){
//alert(lista[i]);
//$('sal'+i).innerHTML=lista[i];
//alert('div: '+$('sal'+i).innerHTML);
$('esta'+i).innerHTML=estadia[i];
}
}

//-->
</script>

<script language="Javascript">
<!--# Begin
document.oncontextmenu = function(){return false}

// End -->
</script> 

<link href="css/main.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.b_imprimir21 {    cursor:pointer; 
	cursor:hand;
	background-image: url(imagen/preview.gif);
	background-repeat: no-repeat;
	background-position: left center;
	margin-left: 0px;
	padding-left: 25px;
}
.b_salir1 {    cursor:pointer; 
	cursor:hand;
	background-image: url(imagen/exit.png);
	background-repeat: no-repeat;
	padding-left: 30px;
	background-position: left center;
	margin-left: 0px;
}
.barra_imprimir1 {    cursor:pointer; 
	cursor:hand;
	background-image: url(imagen/barras/icon_impresora.jpg);
	background-repeat:   no-repeat;
	border-top-width: 0px;
	border-right-width: 0px;
	border-bottom-width: 0px;
	border-left-width: 0px;
	border-top-style: solid;
	border-right-style: solid;
	border-bottom-style: solid;
	border-left-style: solid;
	height: 30px;
}
.new_destino1 {    cursor:pointer; 
	cursor:hand;
	background-image: url(imagen/usuario02.png);
	background-repeat: no-repeat;
	background-position: left center;
	margin-left: 0px;
	padding-left: 30px;
}
.firma_proveido {
	height: auto;
	width: auto;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #5D5D5D;
	margin-left: 5px;
	padding-left: 3px;
	text-align: justify;
	margin-right: 2px;
	padding-right: 2px;
	vertical-align: bottom;
}
-->
</style>
</head>

<body >

<table width="100%" border="0">
  <tr>
    <td class="td-border-style-4" style="border:0px; padding:5px;"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <?php if ($totalRows_obtener_hr > 0) { // Show if recordset not empty ?>
      <tr bgcolor="#E5ECF7">
        <td class="td-border-style-2" style="border:0px; padding:10px;  padding-top: 2px; 
  padding-bottom: 2px;
  padding-left: 3px; 
  padding-right: 3px;
  border-top-color: #f9f9f7; 
  border-left-color: #f9f9f7;
  border-right-color: #828282;   
  border-bottom-color: #828282; 
  border-style: solid;
  border-width: 1px;"><table width="100%" border="0" cellspacing="0">
          <tr>
            <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td bgcolor="#6B7A9D"><span class="Estilo21">.:: Hoja de Ruta</span></td>
                <td width="5"><img src="imagen/sombra_pestaña.png" alt="" width="7" height="30" /></td>
                <td width="50">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellpadding="0" cellspacing="2" class="celeste2" style="padding:10px;">
              <tr>
                <td width="170"><div align="right">Codigo Hoja de Ruta:&nbsp;&nbsp; </div></td>
                <td bgcolor="#FFFFFF"><table width="100%" border="0">
                  <tr>
                    <td><strong
id="”codhr”"><?php echo $row_obtener_hr['cod']; ?></strong></td>
                    <td width="60"><label>
                      <input name="button10" type="button" class="editarHR" id="button10" value="Editar" title="Esta habilitado Editar Referencia"/>
                      </label>                    </td>
                  </tr>
                </table></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td width="170"><div align="right">Remitente:&nbsp;&nbsp;</div></td>
                <td bgcolor="#FFFFFF"><div
id="procedencia"><?php echo $row_obtener_hr['procedencia']; ?></div></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td width="170"><div align="right">Asunto/ref.:&nbsp;&nbsp;</div></td>
                <td bgcolor="#FFFFFF"><div
id="refe"><?php echo $row_obtener_hr['ref']; ?></div>
                          <?php if ($row_obtener_hr['cod_depcreador']==$_SESSION['cod_dep']){ ?>
                          <script>
new Ajax.InPlaceEditor($('refe'), 'ajax/cambiar_ref.php?cod=<?php echo $row_obtener_hr['cod']; ?>&idinterna=<?php echo $row_obtener_hr['einterna_id']; ?>&idexterna=<?php echo $row_obtener_hr['eexterna_id']; ?>', {
        submitOnBlur: true, okButton: false, cancelLink: false,
        ajaxOptions: {method: 'get'} //override so we can use a static for the result
        });
             </script>
                          <?php }?>                </td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td width="170"><div align="right">hojas:&nbsp;&nbsp;</div></td>
                <td bgcolor="#FFFFFF"><?php echo $row_obtener_hr['nhojas']; ?></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td width="170"><div align="right">Anexos:&nbsp;&nbsp;</div></td>
                <td bgcolor="#FFFFFF"><?php echo $row_obtener_hr['nanexos']; ?></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td width="170"><div align="right">Estado:&nbsp;&nbsp;</div></td>
                <td bgcolor="#FFFFFF"><?php 
			  if ($row_obtener_hr['estado']!=NULL){ ?>
                          <div align="center" class="Estilo5">EN PROCESO</div>
                  <?php
			    } else { // fin si es mayor a uno
				?>
                          <div align="center" class="pendiente">NO REVISADO</div>
                  <?php
			       }//fin Si es mayor a 1...			       }			   
			  ?>                </td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><div align="right">Permanencia Total:&nbsp;&nbsp;</div></td>
                <td bgcolor="#FFFFFF">&nbsp;<?php echo permanencia($row_obtener_hr['fecha_creacion'],date("Y-m-d H:i:s")). "  [dias]  hasta hoy."; ?></td>
                <td>&nbsp;</td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr class="titulos">
        <td class="td-border-style-4"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-style:solid;border-width:0px; margin:0px; padding:0px; border:0px; height:30px; width:100%; ">
          <tr style="height:30px;">
            <td width="9" height="30" class="barra_espacio">&nbsp;</td>
            <td width="40" height="30" class="barra"><div class="actualizar" id="button2" onclick="window.location.reload()" style="height:30px;" title="Actualizar"> </div></td>
            <td width="9" height="30" class="barra_espacio">&nbsp;</td>
            <td width="15" height="30" class="barra">&nbsp;</td>
            <td width="40" height="30" class="barra"><span class="Estilo19">Pag</span></td>
            <td width="280" height="30" class="barra" style="width:250px;"><span id="sprytextfield1"><span class="barra" style="width:250px;">
              <input name="npag" type="text" id="npag"  maxlength="2" style="width:30px; padding-left:5px;" onkeypress="if(event.keyCode == Event. KEY_RETURN) if(sprytextfield1.validate()){MM_openBrWindow('imprimir/hoja_ruta/paginaN_5.php?pag='+$F('npag')+'&cod=<?php echo $_GET['cod'];?>','pagN','menubar=yes,scrollbars=yes,resizable=yes,width=900,height=700')}else{alert('Error, revise e intente nuevamente.')};"/>
            </span><span class="Estilo19">/33</span> <span class="textfieldRequiredMsg">x.</span><span class="textfieldMaxValueMsg" style="z-index:3; position:relative;">No permitido.</span><span class="textfieldMaxCharsMsg">solo 2 digitos.</span><span class="textfieldMinCharsMsg">x.</span><span class="textfieldInvalidFormatMsg">Formato no válido. </span><span class="textfieldMinValueMsg">NO permitido.</span></span></td>
            <td width="35" height="30" class="barra_imprimir1" onclick="if(sprytextfield1.validate()){MM_openBrWindow('imprimir/hoja_ruta/paginaN_5.php?pag='+$F('npag')+'&cod=<?php echo $_GET['cod'];?>','pag1','menubar=yes,scrollbars=yes,resizable=yes,width=900,height=700')}else{alert('Error, revise e intente nuevamente.')}">&nbsp;</td>
            <td class="barra">&nbsp;</td>
            <!--Modificado para la hoja 12-->
            
            <td width="77" height="30" class="barra"><div class="b_imprimir21" id="button7" onclick="MM_openBrWindow('imprimir/hoja_ruta/paginaN_5.php?pag=3&cod=<?php echo $_GET['cod'];?>','pag1','menubar=yes,scrollbars=yes,resizable=yes,width=900,height=700')" title="Ver IMPRIMIR Pag. 3" ><span class="Estilo17">Pag. 3</span></div></td>
            <td width="77" height="30" class="barra"><div class="b_imprimir21" id="button2" onclick="MM_openBrWindow('imprimir/hoja_ruta/paginaN_5.php?pag=2&cod=<?php echo $_GET['cod'];?>','pag1','menubar=yes,scrollbars=yes,resizable=yes,width=900,height=700')" title="Ver IMPRIMIR Pag. 2"> <span class="Estilo17" style="vertical-align:middle;">Pag. 2</span></div></td>
            <td width="77" height="30" class="barra"><div class="b_imprimir21" id="button5" onclick="MM_openBrWindow('imprimir/hoja_ruta/pagina1_5.php?cod=<?php echo $_GET['cod'];?>','pag1','menubar=yes,scrollbars=yes,resizable=yes,width=900,height=700')" title="Ver IMPRIMIR Pag. 1"><span class="Estilo17">Pag. 1</span></div></td>
            <td height="30" class="barra">&nbsp;</td>
            <td width="9" height="30" class="barra_espacio">&nbsp;</td>
            <td width="15" height="30" class="barra">&nbsp;</td>
            <td width="100" height="30" class="barra"><div align="right" class="new_destino1" id="button3"  onclick="ndestino('nuevo_destinatarioHR.php?cod=<?php echo $_GET['cod']?>','nuevoDestinatario','width=600,height=400,left=180,top=130')" style="height:30px;" title="AGREGAR NUEVO DESTINO"><span class="Estilo17">Nuevo Destinatario</span> </div></td>
            <td width="15" height="30" class="barra">&nbsp;</td>
            <td width="9" height="30" class="barra_espacio">&nbsp;</td>
            <td width="15" height="30" class="barra">&nbsp;</td>
            <td width="90" height="30" class="barra"><div class="b_salir1"  id="button2" style="height:30px;" onclick="window.close();" title="SALIR de la Hoja de Ruta"><span class="Estilo17">Finalizar</span> </div></td>
            <td width="10" height="30" class="barra">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellpadding="3">
          <tr bgcolor="#EDEFF3">
            <td width="25" height="25">Nro.</td>
            <td width="150" height="25">Destino</td>
            <td height="25">Tarea o Instruccion</td>
            <td width="70"> Fecha Recepcion<br />
              Destino</td>
            <td width="100" height="25">Fecha de Salida<br />
              Destino<br />
              Mensajero</td>
            <td width="40">Perma<br />
              nencia</td>
            <td width="100" height="25">Acciones</td>
            <td width="95" height="25">Estado</td>
          </tr>
          <tr class="celdas">
            <td width="25" bgcolor="#EDEFF3">1</td>
            <td width="150"><p><?php echo $row_obtener_hr['primerfun_destino']; ?><br />
                        <span class="Estilo7"><?php echo $row_obtener_hr['primer_destino']; ?></span></p></td>
            <td><div align="center">- - - - -<br />
            </div>
                    <br />
              Registrado por: <?php echo $row_obtener_hr['usuario_creador']; ?></td>
            <td width="70"><div align="left" class="fech_entrega"><?php echo cambiar_a_normal_letra_con_hora($row_obtener_hr['fecha_creacion']);?>
                        <?php $fecha1=$row_obtener_hr['fecha_creacion']; $listafechas[0]=$row_obtener_hr['fecha_creacion'];?>
            </div>
                    <script>
			    // alert('iniciando');
				<?php if($row_obtener_hr['cont_destinos']>=2){?>
				   lista[0]="<?php echo cambiar_a_normal_letra_con_hora($row_obtener_hr['fecha_creacion']); ?>";
				  // alert('lista'+lista[0]);	
				  <?php }; ?>			   
			</script>
              </td>
            <td width="100" align="left"><div align="left" id="sal0" class="fech_salida"></div></td>
            <td width="40"><?php //echo "0 dias" ?>
                    <?php $t_anterior=0; $tiempos[0]=0?>
              &nbsp;<div id="esta0"></div></td>
            <td width="100">&nbsp;</td>
            <td width="95"><?php if($row_obtener_hr['cont_destinos']>=2){?>
                    <img src="imagen/stepover_co.png" alt="si" width="16" height="16" longdesc="si" /> <span class="Estilo4"><span class="Estilo8">Trasladado</span></span>
                    <?php }else { ?>                    <img src="imagen/state_wait.gif" width="16" height="16" longdesc="procesando" /> <span class="Estilo8">en espera</span>
                    <?php }?></td>
          </tr>
          <?php if ($totalRows_listar_destinos > 0) { // Show if recordset not empty ?>
          <?php $i=1; //indice de fechas.... por destinos?>
          <?php do { ?>
          <?php 
			
			$listafechas[$i]=$row_listar_destinos['fecha_derivacion']; //colocando las fechas;
			//print_r($listafechas);
			//calculando tiempo del primer destino...
			//echo permanencia($listafechas[$i],$listafechas[$i-1]);
			?>
          <tr class="celdas">
            <td width="25" bgcolor="#EDEFF3"><?php echo $row_listar_destinos['nro_destino']; ?></td>
            <td width="150"><?php echo $row_listar_destinos['fun_destino']; ?><br />
                    <span class="Estilo7"><?php echo $row_listar_destinos['dep_destino']; ?></span><br />            </td>
            <td valign="top"><span class="titulo_proveido"><?php echo $row_listar_destinos['proveido']; ?></span><span class="celeste"><br />
              </span>
                    <div align="left" class="proveido"><?php echo $row_listar_destinos['mensaje']; ?></div>
              <br />
                    <div class="firma_proveido" style="width:100%;"> atte.&nbsp;&nbsp;<?php echo $row_listar_destinos['fun_derivador']; ?></div>
              <span class="firma_proveido"><?php echo cambiar_a_normal_letra_con_hora($row_listar_destinos['fecha_derivacion']); ?></span></td>
            <td width="70"><?php if ($row_listar_destinos['entradas_id']>0){ ?>
                    <script>
				   entrega(<?php echo $row_listar_destinos['entradas_id']; ?>);				   
				</script>
                    <div class="fech_entrega" id="div_recib<?php echo $row_listar_destinos['entradas_id']; ?>"></div>
              <div align="center">
                      <?php }else{?>
                      <span class="noreportado"> NO CONFIRMADO por<br />
                      <b><?php echo $row_listar_destinos['dep_destino']; ?></b></span> <br />
                      <img src="imagen/help.png" alt="no" width="26" height="30" longdesc="no" /></div>
              <?php }?></td>
            <td width="100"><div align="left" class="fech_salida" id="sal<?php echo $i; ?>">
              <?php //echo cambiar_a_normal_letra_con_hora($row_listar_destinos['fecha_derivacion']); ?>
              <?php //cambiar_a_normal_letra_con_hora($listafechas[$i-1]); ?>
              <?php if($i==$totalRows_listar_destinos){?>
              <img src="imagen/help.png" alt="no" width="26" height="30" longdesc="no" />
              <?php }?>
            </div>
                    <script>
				   lista[<?php echo $i; ?>-1]="<?php echo cambiar_a_normal_letra_con_hora($row_listar_destinos['fecha_derivacion']); ?>";	
				   //colocando permanencia...
				   estadia.push('<?php echo permanencia($listafechas[$i],$listafechas[$i-1])." dias" ?>');			   
				</script>            </td>
            <td width="100"><?php $per=permanencia($fecha1,$row_listar_destinos['fecha_derivacion']);?>
              <?php //echo permanencia($listafechas[$i],$listafechas[$i-1])." dias" ?>
              <div id="esta<?php echo $i; ?>"></div>
              <?php $fecha1=$row_listar_destinos['fecha_derivacion'];?></td>
            <td width="100"><table width="100%" border="0">
              <tr bgcolor="#CAD2DB">
                <td width="30"><?php  if($cod_dep==$row_listar_destinos['cod_depderivador']&&($row_listar_destinos['fecha_activa']==$dia_actual)){ //modificar 2023?><?php if (($row_listar_destinos['entradas_id']<=0)){ ?>
                          <input name="Modificar" type="button" class="modificar" id="Modificar" onclick="MM_openBrWindow('mod_destinos.php?id=<?php echo $row_listar_destinos['id']; ?>&amp;cod=<?php echo $row_listar_destinos['hojaruta_cod']; ?>','vmoddest','width=600,height=400');" value="   " alt="Editar o Modificar" title="Editar o Modificar"/>
                          <?php }?>               <?php  }?> </td>
                <td width="30"><?php if (($row_listar_destinos['entradas_id']<=0)){ ?>
                          <input name="bdesactivar" type="button" class="desactivar" id="bdesactivar" value="   " alt="Desactivar" title="desactivar destino" onclick="desactivar01('<?php echo $row_listar_destinos['id']; ?>','<?php echo $row_listar_destinos['cod_depderivador']; ?>','inactivo<?php echo $row_listar_destinos['nro_destino']; ?>');"/>
                          <?php }?>                </td>
                <td width="30"><?php if (($row_listar_destinos['entradas_id']<=0)&&($row_listar_destinos['nro_destino']==$row_obtener_hr['cont_destinos'])&&($row_listar_destinos['fecha_activa']==$dia_actual)){ //modificar 2023?>
                          <input name="eliminar" type="button" class="eliminar" id="eliminar" value=" " alt="Eliminar" title="Eliminar destino" onclick="eliminar('<?php echo $row_listar_destinos['id']; ?>','<?php echo $row_obtener_hr['cod']; ?>','<?php echo $row_obtener_hr['cont_destinos']; ?>');"/>
                          <?php }?></td>
              </tr>
              <tr>
                <td width="30">&nbsp;</td>
                <td width="30">&nbsp;</td>
                <td width="30">&nbsp;</td>
              </tr>
            </table></td>
            <td width="95"><?php if ($row_listar_destinos['entradas_id']>0){ ?>
                    <img src="imagen/conformidad_accept.gif" alt="si" width="16" height="16" longdesc="si" /> <span class="Estilo4"><span class="Estilo8">Entregado</span>. </span>
                    <?php }else{?>
              <img src="imagen/conformidad_error.gif" alt="no" width="16" height="16" longdesc="no" /> <span class="pendiente"> Incorrectamente </span>
              <?php }?>
                    <br />
                    <?php if($row_obtener_hr['cont_destinos']==$row_listar_destinos['nro_destino']){?>
              <img src="imagen/state_wait.gif" alt="procesando" width="16" height="16" longdesc="procesando" /><span class="Estilo4"><span class="Estilo8">procesando</span></span>
                    <?php }else { ?>
              <?php if($row_listar_destinos['nro_destino']<$row_obtener_hr['cont_destinos']){?>
              <span class="Estilo8"><img src="imagen/stepover_co.png" alt="si" width="16" height="16" longdesc="si" />trasladado</span>
              <?php }?>
                    <?php }?>
                    <div id="inactivo<?php echo $row_listar_destinos['nro_destino']; ?>">&nbsp;</div></td>
          </tr>
          <?php $i++;?>
          <?php } while ($row_listar_destinos = mysql_fetch_assoc($listar_destinos)); ?>
          <?php } // Show if recordset not empty ?>
          <tr>
            <td width="25">&nbsp;</td>
            <td width="150">&nbsp;</td>
            <td>&nbsp;</td>
            <td width="70">&nbsp;</td>
            <td width="100">&nbsp;</td>
            <td width="100">&nbsp;</td>
            <td width="100">&nbsp;</td>
            <td width="95">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <?php } // Show if recordset not empty ?>
      <?php if ($totalRows_obtener_hr == 0) { // Show if recordset empty ?>
      <tr class="titulos">
        <td>Lo siento la HOJA DE RUTA no existe, verifique e intente nuevamente</td>
      </tr>
      <?php } // Show if recordset empty ?>
    </table></td>
  </tr>
</table>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {validateOn:["blur", "change"], maxChars:2, minChars:1, hint:"4", minValue:4, maxValue:33, useCharacterMasking:true});
//-->
mostrar_salidas();
estadias();
</script>
</body>
</html>
<?php
mysql_free_result($obtener_hr);

mysql_free_result($listar_destinos);
?>
