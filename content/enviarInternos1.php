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
if (isset($_GET['dremite'])) {
  $colname_listFunc = $_GET['dremite'];
}
mysql_select_db($database_snet, $snet);
$query_listFunc = sprintf("SELECT * FROM funcionario WHERE dependencia_cod = %s", GetSQLValueString($colname_listFunc, "text"));
$listFunc = mysql_query($query_listFunc, $snet) or die(mysql_error());
$row_listFunc = mysql_fetch_assoc($listFunc);
$totalRows_listFunc = mysql_num_rows($listFunc);

mysql_select_db($database_snet, $snet);
$query_Depdestino = "SELECT * FROM dependencia";
$Depdestino = mysql_query($query_Depdestino, $snet) or die(mysql_error());
$row_Depdestino = mysql_fetch_assoc($Depdestino);
$totalRows_Depdestino = mysql_num_rows($Depdestino);

$colname_DestFun = "-1";
if (isset($_GET['ddestino'])) {
  $colname_DestFun = $_GET['ddestino'];
}
mysql_select_db($database_snet, $snet);
$query_DestFun = sprintf("SELECT * FROM funcionario WHERE dependencia_cod = %s", GetSQLValueString($colname_DestFun, "text"));
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

<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<script src="js/calendario.js" type="text/javascript"></script>
<link href="js/calendario.css" rel="stylesheet" type="text/css" />
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
//-->
</script>
<link href="../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo3 {color: #FF0000}
.Estilo6 {color: #FF0000; font-size: x-small; }
-->
</style>
</head>

<body>
<div id="capa1" >
<form id="form1" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
  <table width="100%" border="0" cellspacing="1" cellpadding="0">
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
      <td><div align="right"></div></td>
      <td>
       <table width="100%" border="0" cellspacing="1" cellpadding="0">
         <tr>
           <td >&nbsp;</td>
           <td >&nbsp;</td>
           <td ><div align="left"><input name="elegir" type="button" id="elegir" onclick="MM_showHideLayers('ddestino','','show')" value="Elegir" />&nbsp;<span id="spryselect4">
             <select name="ddestino" id="ddestino" onchange="MM_jumpMenu('self',this,0)" style="visibility:hidden">
               <option value="vacio" selected="selected">---- Seleccione una dependencia ----</option>
               <?php
do {  
?>
               <option value="<?php echo $_SERVER['PHP_SELF']."?ddestino=".$row_Depdestino['cod']?>&amp;dremite=<?php echo $_GET['dremite']?>
                "><?php echo $row_Depdestino['nombre']?></option>
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
               <legend>Remitente</legend>
             <table width="90%" border="0" cellspacing="1" cellpadding="0">
             <tr>
               <td><div align="right">Dependencia</div></td>
               <td><div align="right"><span id="spryselect7">
                   <select name="dremite2" size="1" id="dremite2" disabled="disabled">
                     <option value="<?php echo $_GET['dremite'];?>" selected="selected"><?php echo $_GET['dremite'];?></option>
                   </select>
                   <span class="selectRequiredMsg">Seleccione un elemento.</span> </span></div></td>
             </tr>
             <tr>
               <td><div align="right">Remitente</div></td>
               <td><div align="right"><span id="spryselect9">
                   <select name="fremite2" id="fremite2">
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
                   </select>
                   <span class="selectRequiredMsg">Seleccione un elemento.</span> </span> </div></td>
             </tr>
           </table>
            <br />
           </fieldset>           </td>
           <td><div style="width:30px;">&nbsp;</div></td>
           <td><div style="width:320px;"><fieldset>
                          <legend>Destinatario Interno</legend>
               <table width="90%" border="0" cellspacing="1" cellpadding="0">
             <tr>
               <td>Dependencia:</td>
               <td><span id="spryselect8"><span class="selectRequiredMsg">Seleccione un elemento.</span>
                  <input name="textfield" type="text" id="textfield" value="<?php echo $_GET['ddestino'];?>" disabled="disabled"/>
              </span></td>
             </tr>
             <tr>
               <td>Funcionario:</td>
               <td><span id="spryselect3">
                 <select name="dfun2" id="dfun2">
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
                 </select>
                 <span class="selectRequiredMsg">Seleccione un elemento.</span></span>               </td>
             </tr>
           </table>
           <br />
           </fieldset> </div></td>
         </tr>
       </table>
       <br />       </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><div align="right"><span class="Estilo3">*</span>&nbsp;fechado el</div></td>
      <td>&nbsp;
        <select name="select" size="1" id="select">
        <option selected="selected">1</option>
        <option>2</option>
        <option>3</option>
        <option>4</option>
        <option>5</option>
        <option>6</option>
        <option>7</option>
        <option>8</option>
        <option>9</option>
        <option>10</option>
        <option>11</option>
        <option>12</option>
        <option>13</option>
        <option>14</option>
        <option>15</option>
        <option>16</option>
        <option>17</option>
        <option>18</option>
        <option>19</option>
        <option>20</option>
        <option>21</option>
        <option>22</option>
        <option>23</option>
        <option>24</option>
        <option>25</option>
        <option>26</option>
        <option>27</option>
        <option>28</option>
        <option>29</option>
        <option>29</option>
        <option>30</option>
        <option>31</option>
      </select>
      &nbsp;
      <select name="jumpMenu" id="jumpMenu" size="1">
        <option selected="selected">Enero</option>
        <option>Febrero</option>
        <option>Marzo</option>
        <option>Abril</option>
        <option>Mayo</option>
        <option>Junio</option>
        <option>Julio</option>
        <option>Agosto</option>
        <option>Septiembre</option>
        <option>Octubre</option>
        <option>Noviembre</option>
        <option>Diciembre</option>
      </select>
      &nbsp;
        <select name="jumpMenu2" id="jumpMenu2"  size="1">
          <option selected="selected">2007</option>
          <option>2007</option>
          <option>2008</option>
          <option>2009</option>
          <option>2010</option>
                                                                                                          </select>     
        <input size="10" id="fc_1205278847" type="text" READONLY name="fecha_doc" title="YYYY-MM-DD" > <input type="button" value="=" onclick="displayCalendarFor('fc_1205278847');">
        </td>
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
      <td>&nbsp;<span id="spryselect2">
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
      </span></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><div align="right">tipo</div></td>
      <td>&nbsp;<span id="spryselect1">
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
      <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;<?php //echo $_SERVER['PHP_SELF']."<br>";?><?php /*foreach ($_GET as $indice => $valor){ 
echo $indice." = ".$valor."<br>"; 
} ;*/?></td>
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
      <td><div align="right"></div></td>
      <td>&nbsp;</td>
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
          <td>adjuntos:<span id="sprytextarea1">
          <textarea name="adj" id="adj" cols="30" rows="3">1.-
2.-
3.-</textarea>
          Quedan:<span id="countsprytextarea1">&nbsp;</span>&nbsp;letras<span class="textareaMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>          </span></td>
          <td>anexos: <span id="sprytextarea2">
          <textarea name="anexo" id="anexo" cols="30" rows="3">1.-
2.-
3.-</textarea>
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
  
</form>
</div>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("cite1", "none", {validateOn:["blur"], maxChars:50, minChars:3});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {maxChars:80, minChars:5, validateOn:["blur"]});
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1", {validateOn:["blur"]});
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2", {validateOn:["blur"], isRequired:false});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "integer", {validateOn:["blur"]});
var spryselect9 = new Spry.Widget.ValidationSelect("spryselect9", {validateOn:["blur"]});
var spryselect7 = new Spry.Widget.ValidationSelect("spryselect7", {validateOn:["blur"]});
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3", {validateOn:["blur"]});
var spryselect4 = new Spry.Widget.ValidationSelect("spryselect4", {validateOn:["blur"]});
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {validateOn:["blur"], isRequired:false, maxChars:200, counterId:"countsprytextarea1", counterType:"chars_remaining"});
var sprytextarea2 = new Spry.Widget.ValidationTextarea("sprytextarea2", {validateOn:["blur"], isRequired:false, counterId:"countsprytextarea2", counterType:"chars_remaining", hint:"describa Anexos", maxChars:200});
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
