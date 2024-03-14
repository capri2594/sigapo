<?php require_once('../Connections/snet.php'); ?><?php 
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
<title>Recibir (<?php echo $_GET['cod']?>)</title>
<style type="text/css">
<!--
.titulos {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #FFFFFF;
	background-color: #6B7A9D;
	border: 1px solid #FFFFFF;
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
<table width="100%" border="0">
  <tr class="titulos">
    <td>Datos de la Hoja de Ruta</td>
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
      </table></td>
  </tr>
  <tr class="titulos">
    <td><table width="100%" border="0">
        <tr>
          <td><img src="imagen/destino.gif" alt="destino" width="16" height="16" longdesc="destino" /> ¦- - -&nbsp;Destinatarios </td>
          <td width="80"><label>
            <input type="submit" name="button2" id="button2" value="Actualizar" onclick="window.location.reload()" />
          </label></td>
          <td width="150"><input type="submit" name="button3" id="button3" value="Forzar Destinatario"  onclick="alert('El sistema ha deshablitado, esta opcion para no crear inconsistencias.');"/></td>
          <td width="80">&nbsp;
          <input type="button" name="button4" id="button4" value="SALIR"  onclick="window.close();;"/></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr class="botones">
        <td>No</td>
        <td>Destino</td>
        <td>Objeto de HR</td>
        <td>Instrucciones adicionales</td>
        <td>Responsable Derivacion</td>
        <td>Fech.Deriv</td>
        <td>Acciones</td>
        <td width="90">Recepcionado</td>
      </tr>
    
          <tr class="celdas">
            <td>1</td>
            <td><p><?php echo $row_obtener_hr['primerfun_destino']; ?><br />
              <?php echo $row_obtener_hr['primer_destino']; ?></p></td>
            <td><div align="center">- - - - -</div></td>
            <td><div align="center">- - - - -</div></td>
            <td><div align="center"><?php echo $row_obtener_hr['usuario_creador']; ?></div></td>
            <td><?php echo $row_obtener_hr['fecha_creacion']; ?></td>
            <td>&nbsp;</td>
            <td><img src="imagen/conformidad_accept.gif" alt="si" width="16" height="16" longdesc="si" /> Ok.</td>
          </tr>
          <?php if ($totalRows_listar_destinos > 0) { // Show if recordset not empty ?>
            <?php do { ?>    
            <tr class="celdas">
              <td><?php echo $row_listar_destinos['nro_destino']; ?></td>
              <td><?php echo $row_listar_destinos['fun_destino']; ?><br />
                <?php echo $row_listar_destinos['dep_destino']; ?><br /></td>
              <td><?php echo $row_listar_destinos['proveido']; ?></td>
              <td><?php echo $row_listar_destinos['mensaje']; ?></td>
              <td><?php echo $row_listar_destinos['fun_derivador']; ?></td>
              <td><?php echo $row_listar_destinos['fecha_derivacion']; ?></td>
              <td><table width="100%" border="0">
                  <tr>
                    <td>&nbsp;</td>
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
                Ok.              <?php }else{?><img src="imagen/conformidad_error.gif" alt="no" width="16" height="16" longdesc="no" />
                <form id="form1" name="form1" method="post" action="">
                  <input name="button" type="button" id="button" onclick="MM_openBrWindow('confirmarRecepHR.php?id=<?php echo $row_listar_destinos['id']; ?>&hojaruta=<?php echo $row_listar_destinos['hojaruta_cod']; ?>','','width=500,height=410,left=250,top=180')" value="Recibir" />
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
</table>
</body>
</html>
<?php
mysql_free_result($obtener_hr);

mysql_free_result($listar_destinos);
?>
