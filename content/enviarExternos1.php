<?php 
session_name("LoginSIRC");
session_start();
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formEInterno")) {
  $insertSQL = sprintf("INSERT INTO salidas (cite, tema_titulo, tipo_clase, usuario_cuenta, dep_remitente, fun_remitente, fecha_envio, `ref`, fecha_doc) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['cite'], "text"),
                       GetSQLValueString($_POST['tema'], "text"),
                       GetSQLValueString($_POST['tipo'], "text"),
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['dep_remite'], "text"),
                       GetSQLValueString($_POST['fun_remite'], "text"),
                       GetSQLValueString($_POST['fecha_envio'], "date"),
                       GetSQLValueString($_POST['ref'], "text"),
                       GetSQLValueString($_POST['fecha_doc'], "date"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($insertSQL, $snet) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formEInterno")) {
  $insertSQL = sprintf("INSERT INTO salexternas (salidas_cite, salidas_tema_titulo, salidas_tipo_clase, salidas_usuario_cuenta, contacto, organismo) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['cite'], "text"),
                       GetSQLValueString($_POST['tema'], "text"),
                       GetSQLValueString($_POST['tipo'], "text"),
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['tdest_nom'], "text"),
                       GetSQLValueString($_POST['tdest_org'], "text"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($insertSQL, $snet) or die(mysql_error());
  echo "<span style=\"background-color:yellow;\">Los datos han sido GUARDADOS correctamente....</span>";
 
}

mysql_select_db($database_snet, $snet);
$query_listTEMAS = "SELECT * FROM tema ORDER BY titulo ASC";
$listTEMAS = mysql_query($query_listTEMAS, $snet) or die(mysql_error());
$row_listTEMAS = mysql_fetch_assoc($listTEMAS);
$totalRows_listTEMAS = mysql_num_rows($listTEMAS);

mysql_select_db($database_snet, $snet);
$query_listTIPOS = "SELECT * FROM tipo ORDER BY clase ASC";
$listTIPOS = mysql_query($query_listTIPOS, $snet) or die(mysql_error());
$row_listTIPOS = mysql_fetch_assoc($listTIPOS);
$totalRows_listTIPOS = mysql_num_rows($listTIPOS);
 
session_name("LoginSIRC");
session_start();
//controlar si existe session

//sino existe bloquear sitio.
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Enviar Externos</title><?php
// HEAD content
?>
<script src="../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>

<link href="../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />

<script src="js/calendario.js" type="text/javascript"></script>
<link href="js/calendario.css" rel="stylesheet" type="text/css" />
<script src="js/prototype.js" type="text/javascript"></script>

<script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
function display(objpanel,objnom,objorg){
   var txt=document.getElementById(objnom).value;
       txt= txt+'&nbsp;-&nbsp;'+document.getElementById(objorg).value;
	
   document.getElementById(objpanel).innerHTML=txt;
   //alert('hola como estas?');
}
//-->
</script>
<style type="text/css">
<!--
.Estilo8 {font-size: 12px; }
.Estilo9 {
	font-size: 11px;
	font-family: Arial, Helvetica, sans-serif;
}
-->
</style>
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo10 {
	font-size: 10px;
	font-weight: bold;
}
.Estilo11 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
}
.Estilo14 {color: #003366; font-weight: bold; }
.Estilo17 {color: #003366; font-weight: bold; font-size: 12px; }
-->
</style>
</head>

<body>
<?php
// Begin HTML content
?>
<div class="panel__content">
<div>
  <form id="formEInterno" name="formEInterno" method="POST" action="<?php echo $editFormAction; ?>">
    <table width="100%" border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td>&nbsp;</td>
        <td><span class="Estilo11">FORMULARIO</span><strong> 200</strong><br />
            <span class="Estilo10">Registro de Correspondencia [ ENVIO EXTERNO]<br />
            </span>
          </td>
        <td>&nbsp;</td>
      </tr>
      
      <tr>
        <td>&nbsp;</td>
        <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
          <tr>
            <td><div id="CollapsiblePanel1" class="CollapsiblePanel">
              <div class="CollapsiblePanelTab" tabindex="0" onmouseover="display('msgdestino','tdest_nom','tdest_org');">Destino:<div id="msgdestino">&nbsp;</div>
</div>
              <div class="CollapsiblePanelContent">
              <table width="100%" border="0" cellspacing="1" cellpadding="0">
                 <tr>
                  <td>&nbsp;</td>
                  <td><div align="right" class="Estilo8">
                    <div align="center">Nombre&nbsp;&nbsp;</div>
                  </div></td>
                  <td><div align="right" class="Estilo8">
                    <div align="center">Entidad/Organismo/Empresa &nbsp;</div>
                  </div></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td width="8%">&nbsp;</td>
                  <td width="36%"><span id="sprytextfield8">
                    <input name="tdest_nom" type="text" id="tdest_nom" size="45" />
                    <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
                  <td width="31%"><span id="sprytextfield7">
                  <input name="tdest_org" type="text" id="tdest_org" size="40"/>
                  <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
                  <td width="25%"><input name="buscar2" type="button" id="buscar2" onclick="MM_openBrWindow('buscarOrg.php','vbuscarOrg','left=350,top=120,width=550,height=400')" value="cambiar ..." /></td>
                </tr>
              </table>
              </div>
            </div></td>
            </tr>
          <tr>
            <td><div id="CollapsiblePanel2" class="CollapsiblePanel">
              <div class="CollapsiblePanelTab" tabindex="0" onmouseover="display('msgremite','fun_remite','dep_remite');">Origen:<div id="msgremite">&nbsp;</div></div>
              <div class="CollapsiblePanelContent">
                <table width="100%" border="0" cellspacing="1" cellpadding="0">
                  <tr>
                    <td width="8%">&nbsp;</td>
                    <td width="36%"><div align="center"><span class="Estilo8">Nombre y Apellido</span></div></td>
                    <td width="31%"><div align="center"><span class="Estilo8">Unidad/Dependencia</span></div></td>
                    <td width="25%">&nbsp;</td>
                    </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td><div align="left"><span id="sprytextfield1">
                      <input name="fun_remite" type="text" id="fun_remite" value="<?php echo $_SESSION['fun']; ?>" size="45"  readonly="true"/>
                      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></div></td>
                    <td><div align="left"><span id="sprytextfield2">
                      <input name="dep_remite" type="text" id="dep_remite" value="<?php echo $_SESSION['dep']; ?>" size="40"  readonly="readonly"/>
                      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></div></td>
                    <td><input name="cambiar" type="button" id="cambiar" onclick="MM_openBrWindow('fun_Remitente_value.php?coddep=<?php echo $_SESSION['cod_dep'];?>','vbuscarFunRemite','scrollbars=yes,left=350,top=200,,width=450,height=330')" value="cambiar ..." /></td>
                    </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><div align="center"><span class="Estilo9">PREFECTURA DE ORURO</span></div></td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
              </div>
            </div></td>
            </tr>
        </table>          </td>
        <td>&nbsp;</td>
      </tr>
      
      <tr>
        <td>&nbsp;</td>
        <td><table width="100%" border="0" cellspacing="6" cellpadding="1">
          <tr>
            <td bgcolor="#F4F4F4"><div align="right" class="Estilo14 Estilo8">Fecha de envio:&nbsp;</div></td>
            <td><span style="background-color:#DBFDE2; border-color: #CCCCCC;">&nbsp;
                  <?php 
		$t=date("Y-m-d H:i:s");
		print ($t);?>
              &nbsp;&nbsp; </span>
                <input name="fecha_envio" type="hidden" id="fecha_envio" value="<?php echo $t;?>" />
                <input name="username" type="hidden" id="username" value="<?php echo $_SESSION['user'];?>" /></td>
          </tr>
          <tr>
            <td width="17%" bgcolor="#F4F4F4"><div align="right" class="Estilo17">fecha del documento:&nbsp;</div></td>
            <td width="83%"><input size="10" id="fecha_doc" type="text" readonly="READONLY" name="fecha_doc" title="YYYY-MM-DD" value="<?php echo $_POST['fecha_doc'];?>"/>
              <input type="button" value="calendario" onclick="displayCalendarFor('fecha_doc');" /></td>
          </tr>
          <tr>
            <td bgcolor="#F4F4F4"><div align="right" class="Estilo17">cite:&nbsp;</div></td>
            <td><span id="sprytextfield3">
              <input type="text" name="cite" id="cite" />
              <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
          </tr>
          <tr>
            <td bgcolor="#F4F4F4"><div align="right" class="Estilo17">referencia:&nbsp;</div></td>
            <td><span id="sprytextfield4">
              <input name="ref" type="text" id="ref" size="65" />
              <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
          </tr>
          <tr>
            <td bgcolor="#F4F4F4"><div align="right" class="Estilo17">tema de clasificacion:&nbsp;</div></td>
            <td>
            
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
            
            <span id="spry_tema">
              <select name="tema" id="tema">
                <?php
do {  
?>
                <option value="<?php echo $row_listTEMAS['titulo']?>"><?php echo $row_listTEMAS['titulo']?></option>
                <?php
} while ($row_listTEMAS = mysql_fetch_assoc($listTEMAS));
  $rows = mysql_num_rows($listTEMAS);
  if($rows > 0) {
      mysql_data_seek($listTEMAS, 0);
	  $row_listTEMAS = mysql_fetch_assoc($listTEMAS);
  }
?>
              </select>
              <span class="selectRequiredMsg">Seleccione un elemento.</span></span>
              <input name="button2" type="submit" id="button2" onclick="MM_openBrWindow('agregar_tema.php','','left=150,top=100,width=600,height=400')" value="agregar" />
              <input type="button" name="refresh_tema" id="refresh_tema" value="Actualizar"  onclick="temas();"/></td>
          </tr>
          <tr>
            <td bgcolor="#F4F4F4"><div align="right" class="Estilo17">tipo de correspondencia:&nbsp;</div></td>
            <td><span id="spry_tipo">
              <select name="tipo" id="tipo">
                <?php
do {  
?>
                <option value="<?php echo $row_listTIPOS['clase']?>"><?php echo $row_listTIPOS['clase']?></option>
                <?php
} while ($row_listTIPOS = mysql_fetch_assoc($listTIPOS));
  $rows = mysql_num_rows($listTIPOS);
  if($rows > 0) {
      mysql_data_seek($listTIPOS, 0);
	  $row_listTIPOS = mysql_fetch_assoc($listTIPOS);
  }
?>
              </select>
              <span class="selectRequiredMsg">Seleccione un elemento.</span></span>
              <input name="button3" type="submit" id="button3" onclick="MM_openBrWindow('agregar_tipo.php','','left=150,top=100,width=600,height=400')" value="agregar" />
              <input type="button" name="refresh_tipo" id="refresh_tipo" value="Actualizar"  onclick="tipos();"/></td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
              <tr>
                <td width="24%"><input type="submit" name="button" id="button" value="Grabar" /></td>
                <td width="37%">&nbsp;</td>
                <td width="39%">&nbsp;</td>
              </tr>
              
            </table>              </td>
          </tr>

        </table></td>
        <td>&nbsp;</td>
      </tr>
    </table>
    <input type="hidden" name="MM_insert" value="formEInterno" />
</form>
  <p>&nbsp;</p>
</div>
<script type="text/javascript">
<!--
var CollapsiblePanel1 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel1");
var CollapsiblePanel2 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel2", {contentIsOpen:false});
//-->
</script>

</div>

<?php
// End HTML content
?>
<script type="text/javascript">
<!--
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8", "none", {validateOn:["blur"]});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "none", {validateOn:["blur"]});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur", "change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur", "change"]});
var spryselect2 = new Spry.Widget.ValidationSelect("spry_tipo", {validateOn:["blur"]});
var spryselect1 = new Spry.Widget.ValidationSelect("spry_tema", {validateOn:["blur"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {validateOn:["blur"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {validateOn:["blur"]});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($listTEMAS);

mysql_free_result($listTIPOS);
?>
