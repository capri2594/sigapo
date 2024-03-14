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
$query_listar_destinos = sprintf("SELECT * FROM derivacion WHERE derivacion.hojaruta_cod=%s ORDER BY derivacion.nro_destino ASC", GetSQLValueString($codigo_listar_destinos, "text"));
$listar_destinos = mysql_query($query_listar_destinos, $snet) or die(mysql_error());
$row_listar_destinos = mysql_fetch_assoc($listar_destinos);
$totalRows_listar_destinos = mysql_num_rows($listar_destinos);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
	background-image: url(imagen/nuevos.png);
	background-repeat: no-repeat;
	background-position: left center;
	margin-left: 0px;
	padding-left: 25px;
}
.Estilo5 {background-color: #9AE7B3; height: 15px; width: 100px; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; color: #000000; }
.b_imprimir {
	background-image: url(imagen/printer.gif);
	background-repeat: no-repeat;
	background-position: left center;
	margin-left: 0px;
	padding-left: 25px;
}
.b_salir {
	background-image: url(imagen/IconoSalir.gif);
	background-repeat: no-repeat;
	background-position: left center;
	padding-left: 25px;
}
.actualizar {
	background-image: url(imagen/icon_time.gif);
	padding-left: 25px;
	background-repeat: no-repeat;
	background-position: left center;
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
-->
</style>
<script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<script type="text/javascript" src="js/ventanas/prototype.js"></script>
<script type="text/javascript" src="js/ventanas/window.js"> </script> 
<script type="text/javascript" src="js/ventanas/window_ext.js"> </script> 
<script type="text/javascript" src="js/ventanas/effects.js"> </script> 
<script type="text/javascript" src="js/ventanas/debug.js"> </script> 
<link href="js/ventanas/default.css" rel="stylesheet" type="text/css"> 
<!-- Add this to have a specific theme--> 

<link href="js/ventanas/themes/alphacube.css" rel="stylesheet" type="text/css"> 
<!-- links para cuadro de dialogo--> 
<link href="../includes/jaxon/widgets/dialog/css/dialog.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../includes/jaxon/widgets/dialog/js/dialog.js"></script>
<script type="text/javascript" src="../includes/kore/kore.js"></script>

</head>

<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <?php if ($totalRows_obtener_hr > 0) { // Show if recordset not empty ?>
   <tr class="titulos">
     <td>.:: Hoja de Ruta</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" class="celeste">
        <tr>
          <td width="270"><div align="right">Codigo Hoja de Ruta:&nbsp;&nbsp; </div></td>
          <td bgcolor="#FFFFFF"><?php echo $row_obtener_hr['cod']; ?></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td width="270"><div align="right">Remitente:&nbsp;&nbsp;</div></td>
          <td bgcolor="#FFFFFF"><?php echo $row_obtener_hr['procedencia']; ?></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td width="270"><div align="right">Asunto/ref.:&nbsp;&nbsp;</div></td>
          <td bgcolor="#FFFFFF"><?php echo $row_obtener_hr['ref']; ?></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td width="270"><div align="right">hojas:&nbsp;&nbsp;</div></td>
          <td bgcolor="#FFFFFF"><?php echo $row_obtener_hr['nhojas']; ?></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td width="270"><div align="right">Anexos:&nbsp;&nbsp;</div></td>
          <td bgcolor="#FFFFFF"><?php echo $row_obtener_hr['nanexos']; ?></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="right">Estado:&nbsp;&nbsp;</div></td>
          <td bgcolor="#FFFFFF"><?php 
			  if ($row_obtener_hr['estado']!=NULL){ ?>
            
            <div align="center" class="Estilo5">EN PROCESO</div>
            <?php
			    } else { // fin si es mayor a uno
				?>
            <div align="center" class="pendiente">NO REVISADO</div>
            <?php
			       }//fin Si es mayor a 1...			       }			   
			  ?></td>
          <td>&nbsp;</td>
        </tr>
      </table></td>
  </tr>
  <tr class="titulos">
    <td><table width="100%" border="0">
        <tr>
          <td><img src="imagen/destino.gif" alt="destino" width="16" height="16" longdesc="destino" /> ¦- - -&nbsp;Destinatarios </td>
          <td width="80"><label>
            <input name="button2" type="button" class="actualizar" id="button2" onclick="window.location.reload()" value="Actualizar" />
          </label></td>
          <td width="100"><input name="button9" type="button" class="b_imprimir" id="button9" onclick="MM_openBrWindow('imprimir/hoja_ruta/pagina5_5.php?cod=<?php echo $_GET['cod'];?>','pag1','menubar=yes,scrollbars=yes,resizable=yes,width=900,height=700')" value="Pagina (5)" /></td>
          <td width="100"><input name="button8" type="button" class="b_imprimir" id="button8" onclick="MM_openBrWindow('imprimir/hoja_ruta/pagina4_5.php?cod=<?php echo $_GET['cod'];?>','pag1','menubar=yes,scrollbars=yes,resizable=yes,width=900,height=700')" value="Pagina (4)" /></td>
          <td width="100"><input name="button7" type="button" class="b_imprimir" id="button7" onclick="MM_openBrWindow('imprimir/hoja_ruta/pagina3_5.php?cod=<?php echo $_GET['cod'];?>','pag1','menubar=yes,scrollbars=yes,resizable=yes,width=900,height=700')" value="Pagina (3)" /></td>
          <td width="100"><input name="button6" type="button" class="b_imprimir" id="button6" onclick="MM_openBrWindow('imprimir/hoja_ruta/pagina2_5.php?cod=<?php echo $_GET['cod'];?>','pag1','menubar=yes,scrollbars=yes,resizable=yes,width=900,height=700')" value="Pagina (2)" /></td>
          <td width="100">
            <div align="right">
              <input name="button5" type="button" class="b_imprimir" id="button5" onclick="MM_openBrWindow('imprimir/hoja_ruta/pagina1_5.php?cod=<?php echo $_GET['cod'];?>','pag1','menubar=yes,scrollbars=yes,resizable=yes,width=900,height=700'); dialog();" value="Imprimir (Pag 1)" />
              </div>          </td>
          <td width="150"><div align="right">
          <script type="text/javascript">

function dialog() {
  Dialog.alert("You can close this panel with escape key or by clicking on the close button below.", 
               {windowParameters: {className: "alphacube", width:300, height:100}, okLabel: "Cerrar", 
                ok:function(win) {debug("validate alert panel"); return true;}, cancel:function(win) {debug("validate cancel panel"); return true;}});
}
function abrir(){
new Window({url: "nuevo_destinatarioHR.php?cod=<?php echo $_GET['cod']?>", className: "alphacube", width:600, height:400, left:100, top:100}).show()
WindowCloseKey.init();
}
function abrir2(){
new Widgets.Dialog('Ingrese el cod. CITE de la correspondencia', 'nuevo_destinatarioHR.php?cod=<?php echo $_GET['cod']?>', { click_outside: true, width: 600, height: 400 });return false;
}
  function openAjaxConfirm() {
      Dialog.confirm({url: "nuevo_destinatarioHR.php?cod=<?php echo $_GET['cod']?>", options: {method: 'get'}}, 
                     {top: 10, width:600, className: "alphacube", okLabel: "Yes", cancelLabel:"No"})    
  }
  
    function outsideWindow() {
    var win = new Window("win2", {className: "alphacube", top:40, left:0, width:200, height:100, title:"Outside Window",
                          maximizable: false, minimizable: false});
    win.setDestroyOnClose();
    win.show();
  }
    function openDialog3(html) {
    var effect = new PopupEffect(html, {className: "popup_effect1"});
    Dialog.confirm("Do you like this effect?",{className:"alphacube", width: 400, height:null, showEffect:effect.show.bind(effect), hideEffect:effect.hide.bind(effect)})
  }     
  
</script>
            <input name="button3" type="button" class="new_destino" id="button3"  onclick="abrir();" value="Nuevo Destinatario"/>
          </div></td>
          <td width="100">
            <div align="right">
              <input name="button4" type="button" class="b_salir" id="button4"  onclick="function openDialog3(nuevo_destinatarioHR.php?cod=<?php echo $_GET['cod']?>);" value="Finalizar"/>
              </div>          </td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="3">
      <tr class="botones">
        <td height="25">No</td>
        <td height="25">Destino</td>
        <td height="25">Objeto de HR</td>
        <td height="25">Instrucciones adicionales</td>
        <td height="25">Responsable Derivacion</td>
        <td height="25">Fech.Deriv</td>
        <td height="25" onclick="abrir2();">Acciones</td>
        <td width="90" height="25">Recepcionado</td>
      </tr>
    
          <tr class="celdas">
            <td bgcolor="#EDEFF3">1</td>
            <td><p><?php echo $row_obtener_hr['primerfun_destino']; ?><br />
                <span class="Estilo7"><?php echo $row_obtener_hr['primer_destino']; ?></span></p></td>
            <td><div align="center">- - - - -</div></td>
            <td><div align="center">- - - - -</div></td>
            <td><div align="center"><?php echo $row_obtener_hr['usuario_creador']; ?></div></td>
            <td><?php echo $row_obtener_hr['fecha_creacion']; ?></td>
            <td>&nbsp;</td>
            <td><img src="imagen/conformidad_accept.gif" alt="si" width="16" height="16" longdesc="si" /> <span class="Estilo4">Ok.</span></td>
        </tr>
          <?php if ($totalRows_listar_destinos > 0) { // Show if recordset not empty ?>
            <?php do { ?>    
            <tr class="celdas">
              <td bgcolor="#EDEFF3"><?php echo $row_listar_destinos['nro_destino']; ?></td>
              <td><?php echo $row_listar_destinos['fun_destino']; ?><br />
                <span class="Estilo7"><?php echo $row_listar_destinos['dep_destino']; ?></span><br /></td>
              <td><?php echo $row_listar_destinos['proveido']; ?></td>
              <td><?php echo $row_listar_destinos['mensaje']; ?></td>
              <td><?php echo $row_listar_destinos['fun_derivador']; ?></td>
              <td><?php echo $row_listar_destinos['fecha_derivacion']; ?></td>
              <td><table width="100%" border="0">
                  <tr>
                    <td>
                     
                        <?php if (($row_listar_destinos['entradas_id']<=0)){ ?>
                        <input name="Modificar" type="button" id="Modificar" onclick="MM_openBrWindow('mod_destinos.php?id=<?php echo $row_listar_destinos['id']; ?>&cod=<?php echo $row_listar_destinos['hojaruta_cod']; ?>','vmoddest','width=600,height=400,left=150,top=130')" value="Modificar" />
                        <?php }?>                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>

                            </table></td>
              <td><?php if ($row_listar_destinos['entradas_id']>0){ ?><img src="imagen/conformidad_accept.gif" alt="si" width="16" height="16" longdesc="si" />
                <span class="Estilo4">Ok.              </span>
                <?php }else{?><img src="imagen/conformidad_error.gif" alt="no" width="16" height="16" longdesc="no" /> <span class="pendiente">PARA ENVIO
                </span>
                <form id="form1" name="form1" method="post" action="">
                  <input name="button" type="button" id="button" onclick="MM_openBrWindow('confirmarRecepHR.php?id=<?php echo $row_listar_destinos['id']; ?>&hojaruta=<?php echo $row_listar_destinos['hojaruta_cod']; ?>','','width=500,height=300')" value="Recibir" style="visibility:hidden" />
                  <input name="id" type="hidden" id="id" value="<?php echo $row_listar_destinos['id']; ?>" />
                  <input name="hojaruta_cod" type="hidden" id="hojaruta_cod" value="<?php echo $row_listar_destinos['hojaruta_cod']; ?>" />
                </form>
              <?php }?>          </td>
            </tr>
            <?php } while ($row_listar_destinos = mysql_fetch_assoc($listar_destinos)); ?>
            <?php } // Show if recordset not empty ?>

        <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>

</tr>
   <?php } // Show if recordset not empty ?>
<?php if ($totalRows_obtener_hr == 0) { // Show if recordset empty ?>
     <tr class="titulos">
       <td>Lo siento la HOJA DE RUTA no existe, verifique e intente nuevamente</td>
    </tr>
     <?php } // Show if recordset empty ?>
</table>
</body>
</html>
<?php
mysql_free_result($obtener_hr);

mysql_free_result($listar_destinos);
?>
