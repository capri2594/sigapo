<?php require_once('../includes/jaxon/widgets/request.php'); ?>
<?php // Widget region file. Do not remove this line. ?>
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

$colname_hojaruta = "-1";
if (isset($_GET['coddep'])) {
  $colname_hojaruta = $_GET['coddep'];
}
mysql_select_db($database_snet, $snet);
$query_hojaruta = sprintf("SELECT cont_HR FROM dependencia WHERE cod = %s", GetSQLValueString($colname_hojaruta, "text"));
$hojaruta = mysql_query($query_hojaruta, $snet) or die(mysql_error());
$row_hojaruta = mysql_fetch_assoc($hojaruta);
$totalRows_hojaruta = mysql_num_rows($hojaruta);

$colname_remitentes = "-1";
if (isset($_GET['coddep'])) {
  $colname_remitentes = $_GET['coddep'];
}
mysql_select_db($database_snet, $snet);
$query_remitentes = sprintf("SELECT nombre, dependencia_cod, cargo FROM funcionario WHERE dependencia_cod = %s", GetSQLValueString($colname_remitentes, "text"));
$remitentes = mysql_query($query_remitentes, $snet) or die(mysql_error());
$row_remitentes = mysql_fetch_assoc($remitentes);
$totalRows_remitentes = mysql_num_rows($remitentes);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
// HEAD content
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<style type="text/css">
<!--
#apDiv1 {
	position:absolute;
	width:19.5cm;
	height:25.5cm;/*27.5cm;*/
	z-index:1;
	left: 13px;
	top: 11px;
}
#apDiv1 #encabezado {
	height: 2.5cm;
	width: 19.5cm;
	margin: 0 px;
	padding: 0 px;
}
.Estilo2 {
	font-size: large;
	font-family: Albertus, sans-serif, Modern;
}
#apDiv1 #contenido {
	height: 23.5cm;/*24.5cm;*/
	width: 19.5cm;
	border: 1px solid #000000;
}
.Estilo3 {
	font-family: Albertus, sans-serif, Modern;
	font-size: small;
}
.Estilo4 {
	font-size: x-small;
	text-decoration: underline;
}
#apDiv1 #encabezado #numForm {
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-color: #000000;
	border-right-color: #000000;
	border-bottom-color: #000000;
	border-left-color: #000000;
	border-style: 1px;
}
#apDiv1 #contenido #CollapsiblePanel1 .CollapsiblePanelContent #id_hruta {
}
#apDiv1 #contenido #CollapsiblePanel1 .CollapsiblePanelContent #id_hruta {
	height: 11px;
}


body, tr  {
	font-family:   ARIAL, VERDANA, HELVETICA, sans-serif;
	font-size: 13px;
}
/*
TD {
	FONT-SIZE: 10pt; FONT-FAMILY: ARIAL, VERDANA, HELVETICA, sans-serif
}

TD.menuderecha {
	FONT-WEIGHT: bold; FONT-SIZE: 10pt; COLOR: #0066cc
}
TD.subtitulo {
	FONT-WEIGHT: bold; FONT-SIZE: 14pt; COLOR: #ffffff
}
TD.texto {
	FONT-SIZE: 12pt; COLOR: #000
}

tr.par {  background-color:#CCCCCC; text-align:left;}
tr.impar { background-color:#F3F3F3;text-align:left;}

td { font-family: ARIAL, VERDANA, HELVETICA, sans-serif; font-size:10pt;}
td.menuderecha { color:#0066cc;font-size:10pt; font-weight:bold;}

td.subtitulo { color:#ffffff;font-size:14pt; font-weight:bold; }
td.texto { color:#000;font-size: 12pt; }
*/

TH {
	COLOR: #ffffff; BACKGROUND-COLOR: #006699
}
th { background-color: #006699; color:#FFFFFF;}
.style1 {
	color: #FFFFFF;
	font-weight: bold;
}
.bgc1{
	background-color: #006699
}
.bgc2{
	background-color: #f3f3f3
}
.style3 {
	FONT-WEIGHT: bold;
	COLOR: #006699;
	line-height : 5px;
}
.f1{
	font-family : "Times New Roman";
	font-size : 11pt;
	font-weight : bold;
}
.f2{
	font-family : "Times New Roman";
	font-size : 11pt;
	font-weight : bold;
	background-color : #E6E6E6;
}
.f3{
	font-family : "Times New Roman";
	font-size : 11pt;
	font-style : italic;
	font-weight : bold;
	text-align : center;
}
.f4{
	font-family : Arial;
	font-size : 9pt;
	text-align : center;	
}
.c1{
	font-family : Arial;
	font-size : 9pt;
	text-align : center;
	background-color : #E6E6E6;
	background-position: center;

}
.c2{
	background-color : #E6E6E6;
}
.c3{
	background-color : #E6E6E6;
	font-family : "Times New Roman";
	font-size : 13pt;
	font-weight : bold;
}
.f5{
	font-family : "Times New Roman";
	font-size : 16pt;
	font-weight : bolder;
	background-color : #E6E6E6;
}
.style5 {font-size: 20px}
.style6 {
}

.style11 {
	font-size: 12;
	font-family: Arial, Helvetica, sans-serif;
	font-weight: normal;
}

.style12 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 18px;
	font-weight: bold;
}
.style15 {
	font-size: 13px;
	font-family: Arial, Helvetica, sans-serif;
	color: #006699;
}
.style17 {font-size: 12}
.style18 {font-size: 16}
.style19 {font-size: 10px; }
.style20 {font-size: 10; }
.style21 {
	font-size: 12px;
	font-family: Arial, Helvetica, sans-serif;
}
.style24 {
	color: #006699;
	font-weight: bold;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 17px;
}
.style26 {font-size: 16px; font-family: Arial, Helvetica, sans-serif; font-weight: normal; }
.style29 {font-size: 12px}
.style31 {font-size: 10; color: #FFFFFF; }
.style32 {font-size: 12px; font-family: Arial, Helvetica, sans-serif; color: #FFFFFF; }
.style33 {font-size: 12; color: #FFFFFF; }
.style34 {font-size: 10; color: #000000; }
.style35 {font-size: 12; color: #000000; }
.style36 {color: #000000}
.style37 {font-size: 12px; font-weight: bold; font-family: Arial, Helvetica, sans-serif;}
.style38 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #FFFFFF; }
.stl0{
	color: Red;
}
.style39{
	font-size: 9px;
}

.table1{
	border: 2px solid #006699;
	color: #006699;
	border-left: 2px solid #006699;
	border-right: 2px solid #006699;
}
.style40 {
	color: #006699;
	font-weight: bold;
}
.style41{
	color:white;
}
.tr1{
	background-color: #006699;
	color:white;
	font-weight: bold;
	text-align : center;
	vertical-align: middle;
	height: 18px;
	font-size: 9px;
}
.tr2{
	background-color: #f3f3f3;
	text-align : center;
	
}
.tr4{
	background-color: #006699;
	color: white;
	font-weight: bold;
	text-align: left;
	vertical-align: middle;
}

.style42 {
	color: #006699;
	font-size: 14px;
	font-weight: bold;
	
}
.TextoNegro {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: normal;
	font-weight: normal;
	color: #000000;
}
.TextoBlanco {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: normal;
	font-weight: bold;
	color: #FFFFFF;
}
.TextoTitulo {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	font-style: normal;
	font-weight: bold;
	color: #006699;
}
.FondoAzul {
	background-color: #006699;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: normal;
	font-weight: bold;
	color: #FFFFFF;
}
.FondoPlomo {
	background-color: #F3F3F3;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: normal;
	font-weight: normal;
	color: #000000;
}
.TextoNegro9 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 9px;
	font-style: normal;
	font-weight: normal;
	color: #000000;
}
.TextoNegroBold {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-style: normal;
	font-weight: bold;
	color: #000000;
}
.TextoNegro11 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 8px;
	font-style: normal;
	font-weight: normal;
	color: #000000;
	background-color : #E6E6E6;
	text-align : center;
}

.TextoNegro11A {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 8px;
	font-style: normal;
	font-weight: normal;
	color: #000000;
	text-align : center;
}

.TextoNegro11bold {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 8px;
	font-style: normal;
	font-weight: bold;
	color: #000000;
	background-color : #E6E6E6;
}

.TextoNegro10 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-style: normal;
	font-weight: normal;
	color: #000000;
}
.TextoBlanco10 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-style: normal;
	font-weight: bold;
	color: #FFFFFF;
}
.FondoAzul10 {

	background-color: #006699;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-style: normal;
	font-weight: bold;
	color: #FFFFFF;
}
.FondoPlomo10 {

	background-color: #F3F3F3;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-style: normal;
	font-weight: normal;
	color: #000000;
}
.TituloAzul14 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-style: normal;
	font-weight: bold;
	color: #006699;
}

.par {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-style: normal;
	font-weight: normal;
	color: #000000;
	background-color: #CCCCCC;
}
.impar {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-style: normal;
	font-weight: normal;
	color: #000000;
	background-color: #f3f3f3;
}
TH {
	COLOR: #ffffff;
	BACKGROUND-COLOR: #006699;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-style: normal;
	font-weight: normal;
	height: 13px;
}
a {
	COLOR: #0096E3;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-style: normal;
	font-weight: normal;
}
.a1 {
	COLOR: blue;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-style: normal;
	font-weight: normal;
}
.TH1 {
	COLOR: #ffffff; BACKGROUND-COLOR: #006699
}
.textos {
	font-size: 11px;
}

-->
</style>
<script src="../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="js/tooltip.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo5 {
	font-size: 10px;
	color: #000000;
}
.Estilo6 {
	font-size: x-small
}
-->
</style>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
function NO_letra(){ 
   // funcion que impide entrada a formulario de caracteres no numericos 
   var key=window.event.keyCode;//codigo de tecla. 
      if (key < 48 || key > 57){//si no es numero 
      window.event.keyCode=0;//anula la entrada de texto. 
      } 
   } 
function NO_teclas(obj){ 
   if (document.all){
          window.event.keyCode=0;
	}	  
 else{
    
	//alert('hola firefox');
	//window.event.which=0; //no funcionar en FIREFOX no premite cambiar valor KEy
	 //obj.select;
     }    
   }//fin funcion 
  
  function pulsar(e) { 
  tecla = (document.all) ? e.keyCode : e.which; 
  if(tecla == 9 || tecla == 0) return true; 
  if(tecla == 8) return true; 
  if(window.Event){ 
      var pst = e.currentTarget.selectionStart; 
      var string_start = e.currentTarget.value.substring(0,pst); 
      var string_end = e.currentTarget.value.substring(pst ,e.currentTarget.value.length); 
      e.currentTarget.value = string_start+ String.fromCharCode(tecla).toUpperCase()+ string_end; 
      e.currentTarget.selectionStart = pst + 1; 
      e.currentTarget.selectionEnd = pst + 1; 
      e.stopPropagation(); 
      return false; 
  } 
  else { 
    te = String.fromCharCode(tecla); 
    te = te.toUpperCase(); 
    num = te.charCodeAt(0); 
    e.keyCode = num; 
  } 
} 

function anular() 
{ 
  //rescatando el texto original
  /*var txt=document.getElementById('tmotivo').value;
  var long=txt.length-1;
  torigen=txt.substr(0,long);*/
  alert("Elija una opcion de la ventana...!");
  //document.getElementById('tmotivo').value=torigen;
}
//-->
</script>
<style type="text/css">
<!--
#apDiv2 {
	position:absolute;
	left:313px;
	top:173px;
	width:254px;
	height:71px;
	z-index:2;
	background-color: #FFFFDD;
}
#apDiv3 {
	position:absolute;
	left:315px;
	top:142px;
	width:211px;
	height:77px;
	z-index:3;
}
-->
</style>

<?php
// Begin HTML content
?>
<div id="apDiv1">
  <div id="encabezado">
  <table width="100%" border="1" cellpadding="0" cellspacing="1" bordercolor="#666666" bgcolor="#F2F2F2">
    <tr>
      <td width="14%"><table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td><div align="center"><strong>FORM.</strong></div></td>
          </tr>
        <tr bgcolor="#FFFFFF">
          <td><div align="center" id="numForm">109</div></td>
          </tr>
      </table></td>
      <td width="86%"><div align="center">
       
        <table width="99%" border="0" cellspacing="1" cellpadding="0">
          <tr>
            <td width="13%" rowspan="4"><img src="imagen/Escudo-de-Bolivia.gif" width="84" height="70" longdesc="Escudo de Bolivia" /></td>
            <td width="3%">&nbsp;</td>
            <td width="65%">&nbsp;</td>
            <td width="5%">&nbsp;</td>
            <td width="14%" rowspan="4"><img src="imagen/logo2.gif" alt="logo" width="80" height="66" longdesc="prefectura" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div align="center" class="Estilo2"><img src="imagen/prefectura7.gif" alt="titulo" width="300" height="12" longdesc="PREFECTURA DEL DEPARTAMENTO" /></div></td>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div align="center" class="Estilo3">Oruro - Bolivia</div></td>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
                <tr>
                  <td width="38%"><span class="Estilo4 style39 style39"><strong>Sitio web</strong>: www.preforuro.gov.bo </span></td>
                  <td width="37%"><div align="center"><span class="Estilo4 style39 style39"><strong>email</strong>: info@preforuro.gov.bo</span></div></td>
                  <td width="25%"><div align="center"><span class="Estilo4 style19 style19 style39 style39"><strong>Fax</strong>: (2511) 2090/2091</span></div></td>
                </tr>
              </table></td>
            <td>&nbsp;</td>
            </tr>
        </table></td>
    </tr>
  </table>
   </div>
  <div id="contenido"> 
  <div id="CollapsiblePanel1" class="CollapsiblePanel">
    <div class="CollapsiblePanelTab" tabindex="0">REGISTRO DE HOJA DE RUTA</div>
      <div class="CollapsiblePanelContent">
          <table width="100%" border="1" cellpadding="0" cellspacing="0" bgcolor="#F3F3F3" id="id_hruta">
          <tr class="style40" height=11>
            <td colspan="9" class="par">1.- IDENTIFICACION</td>
          </tr>
          <tr height=11>
            <td width="5%" rowspan="2" class="par"><span class="Estilo5">Codigo:</span></td>
            <td width="22%" class="impar"><div align="center" class="Estilo4">
                <div align="left">Departamento/ unidad/ servivio/</div>
            </div></td>
            <td width="3%" class="impar">&nbsp;</td>
            <td width="8%" class="impar"><div align="center" class="style36 style19">Numero</div></td>
            <td width="32%" rowspan="2" class="par"><img src="imagen/b_tipp.png" width="16" height="16" onmouseover="pmaTooltip('Use la tecla TAB para saltar de un valor a otro, o CTRL+flechas para moverse a cualquier parte'); return false;" onmouseout="swapTooltip('default'); return false;"/><div id="TooltipContainer"  style="z-index:3; top:200px; left:400px;" onmouseover="holdTooltip();" onmouseout="swapTooltip('default');"> </div></td>
            <td width="15%" class="impar"><div align="center">Fecha de Creacion</div></td>
            <td width="2%" rowspan="2" class="par">&nbsp;</td>
            <td width="6%" class="impar"><div align="right">
                <div align="center"><strong>Hora</strong></div>
            </div></td>
            <td width="7%" rowspan="2" class="par">&nbsp;</td>
          </tr>
          <tr height=11>
            <td bgcolor="#FFFFFF"><span id="sprytextfield3">
              <input name="dep_hr" type="text" class="textos" id="dep_hr" size="25" value="<?php echo $_GET[coddep]?>" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
            <td bgcolor="#FFFFFF"><div align="center">-</div></td>
            <td bgcolor="#FFFFFF"><span id="sprytextfield4">
              <input name="num_hr" type="text" class="textos" id="num_hr" size="12" value="<?php echo $row_hojaruta['cont_HR']+1; ?>"/>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
            <td bgcolor="#FFFFFF"><div align="center"><?php echo date("d-m-Y");?>&nbsp;</div></td>
            <td bgcolor="#FFFFFF"><div align="center"><?php echo date("H:i:s");?>&nbsp;</div></td>
          </tr>
          <tr height=11>
            <td colspan="9" class="par">2.- DATOS DE LA CORRESPONDENCIA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input name="exam_corres" type="button" class="tr1" id="exam_corres" onclick="MM_openBrWindow('fun_Remitente.php','vFunRemite','scrollbars=yes,width=550,height=300')" value="Examinar..." /></td>
          </tr>
          <tr height=11>
            <td class="par">&nbsp;</td>
            <td><div align="center"><span class="style19">Cite</span></div></td>
            <td class="par">&nbsp;</td>
            <td colspan="3" class="impar"><div align="center" class="style19">Referencia</div></td>
            <td class="par">&nbsp;</td>
            <td class="impar">Hojas</td>
            <td bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
          <tr height=11>
            <td class="par">&nbsp;</td>
            <td bgcolor="#FFFFFF">&nbsp;</td>
            <td class="par">&nbsp;</td>
            <td colspan="3" bgcolor="#FFFFFF">&nbsp;</td>
            <td class="par">&nbsp;</td>
            <td class="impar">Anexos</td>
            <td bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
        </table>
    </div>
    </div>
    <div id="CollapsiblePanel2" class="CollapsiblePanel">
      <div class="CollapsiblePanelTab" tabindex="0">N.- DERIVACION</div>
      <div class="CollapsiblePanelContent">

        <table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr class="par">
            <td colspan="9" bgcolor="#999999" class="par"><p class="style19"><strong>a)</strong> INFORMACION DEL ENVIO.-</p></td>
          </tr>
          <tr>
            <td width="8%" rowspan="3" class="par"><div align="center" class="Estilo6">Remitente</div>
            
            </td>
            <td colspan="3" class="impar"><div align="center">Nombres y Apellidos&nbsp;&nbsp;&nbsp;<span >
              <input name="exam_corres4" type="button" class="tr1" id="exam_corres4" onclick="MM_openBrWindow('fun_Remitente.php?coddep=<?php echo $_GET[coddep];?>','vFunRemite','width=430,height=300')" value="..." />
            </span></div></td>
            <td width="8%" rowspan="3" class="par"><div align="center">Destinatario
                
            </div></td>
            <td colspan="3" class="impar"><div align="center">Nombres y Apellidos&nbsp;&nbsp;&nbsp;
              <input name="exam_corres5" type="button" class="tr1" id="exam_corres5" onclick="MM_openBrWindow('fun_Destino.php','vFunDestino','width=620,height=300')" value="..." />
            </div></td>
            <td width="1%" rowspan="3" class="c1">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3" bgcolor="#FFFFFF"><div align="center" id="fun_remite">&nbsp;</div>
            <div align="center"></div></td>
            <td colspan="3" bgcolor="#FFFFFF"><div align="center" id="fun_destino">&nbsp;</div></td>
          </tr>
          <tr>
            <td colspan="3" class="impar"><div align="center" id="dep_remite" style="font-weight:bold; text-transform:uppercase;"><strong><?php echo $row_remitentes['cargo']; ?>-<?php echo $row_remitentes['dependencia_cod']; ?></strong></div></td>
            <td colspan="3" class="impar"><div align="center" id="dep_destino" style="font-weight:bold; text-transform:uppercase;">{UNIDAD A LA QUE CORRESPONDE}</div></td>
          </tr>
          <tr>
            <td colspan="9" class="par">b) DATOS DEL PROCESO.-</td>
          </tr>
          <tr>
            <td class="impar">&nbsp;</td>
            <td width="1%" class="impar">&nbsp;</td>
            <td class="impar">&nbsp;</td>
            <td class="impar">&nbsp;</td>
            <td class="impar">&nbsp;</td>
            <td width="9%" class="impar">&nbsp;</td>
            <td width="10%" class="impar"><div align="center">Fecha&nbsp;Recibido</div></td>
            <td width="22%" bgcolor="#FFFFFF"><div align="center">&nbsp;</div></td>
            <td class="impar">&nbsp;</td>
          </tr>
          <tr>
            <td class="impar"><div align="right">Motivo:&nbsp;</div></td>
            <td colspan="3">            
            <div align="center" id="motivo" >
              <div align="left"><span id="sprytextfield1">
                <input name="tmotivo" type="text" id="tmotivo" size="40" value="---- haga click para elegir----" onkeypress="this.onclick();"  onkeyup="anular();" onclick="vmotivo=MM_openBrWindow('eMotivos.php','vEMotivos','scrollbars=yes,width=250,height=350')" readonly="readonly"/>
                <input name="button1" type="button" class="tr1" id="button1" value="..." onclick="MM_openBrWindow('eMotivos.php','vEMotivos','scrollbars=yes,width=250,height=350')"/>
                <br />
                  <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></div>
            </div></td>
            <td rowspan="7" class="impar"><div align="center" >Proveido</div></td>
            <td class="impar">&nbsp;</td>
            <td class="impar"><span class="style19">Hora Recibido</span></td>
            <td>&nbsp;</td>
            <td class="impar">&nbsp;</td>
          </tr>
          <tr>
            <td class="impar">&nbsp;</td>
            <td class="impar">&nbsp;</td>
            <td class="impar">&nbsp;</td>
            <td class="impar">&nbsp;</td>
            <td colspan="3" class="impar"><div align="center">Nombre Completo</div></td>
            <td class="impar">&nbsp;</td>
          </tr>
          <tr>
            <td class="impar"><div align="right">Nota:&nbsp;</div></td>
            <td colspan="3" rowspan="4" align="left" valign="top"><span id="sprytextarea1">
            <textarea name="textarea1" cols="35" rows="12" id="textarea1"></textarea><br />
            <span class="style19">Quedan:</span>&nbsp;<span id="countsprytextarea1">&nbsp;</span>
            <span class="textareaRequiredMsg style19 style29">Se necesita un valor.</span><span class="textareaMaxCharsMsg style29">Muchos caracteres.</span></span></td>
            <td colspan="3">&nbsp;</td>
            <td class="impar">&nbsp;</td>
          </tr>
          <tr>
            <td rowspan="3" class="impar">&nbsp;</td>
            <td height="18" colspan="3" class="impar"><div align="center">{cargo}</div></td>
            <td class="impar">&nbsp;</td>
          </tr>
          <tr>
            <td height="18" colspan="3" valign="top">&nbsp;</td>
            <td valign="top" class="impar">&nbsp;</td>
          </tr>
          <tr>
            <td height="124" valign="top" class="impar"><div align="right">FIRMA:&nbsp;</div></td>
            <td colspan="2" valign="top">&nbsp;</td>
            <td valign="top" class="impar">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" rowspan="2" class="impar">&nbsp;</td>
            <td width="15%" height="18" class="impar"><div align="right">Fecha de envio:&nbsp;</div></td>
            <td width="26%" bgcolor="#FFFFFF"><?php echo date("d-m-Y");?></td>
            <td colspan="3" valign="bottom" class="impar">&nbsp;</td>
            <td class="impar">&nbsp;</td>
          </tr>
          <tr>
            <td class="impar"><div align="right">hora de envio:&nbsp;</div></td>
            <td><?php echo date("H:i:s");?></td>
            <td class="impar">&nbsp;</td>
            <td colspan="3" class="impar">Aviso: &quot;El presente documento no tiene ningun valor si no esta firmada y sellada correctamente&quot;.</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        
      </div>
    </div>
   
  </div>
   
</div>


<script type="text/javascript">
<!--
var CollapsiblePanel1 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel1");
var CollapsiblePanel2 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {validateOn:["blur", "change"], maxChars:300, counterId:"countsprytextarea1", counterType:"chars_remaining"});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
//-->
</script>

<?php
// End HTML content
?>
<?php
mysql_free_result($hojaruta);

mysql_free_result($remitentes);
?>
