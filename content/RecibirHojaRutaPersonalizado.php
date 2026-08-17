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
body {
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     background-color: #0f172a !important;
     color: #cbd5e1 !important;
     margin: 20px !important;
     padding: 0 !important;
}

/* Titles and Headers */
.titulos {
     background-color: #1e3a8a !important;
     color: #ffffff !important;
     font-weight: 700 !important;
     font-size: 13px !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     padding: 10px 14px !important;
     border: 1px solid rgba(255, 255, 255, 0.1) !important;
     border-radius: 6px 6px 0 0 !important;
}

/* Celeste container details table */
.celeste {
     width: 100% !important;
     background-color: #1e293b !important;
     border: 1px solid rgba(255, 255, 255, 0.1) !important;
     border-radius: 8px !important;
     overflow: hidden !important;
     margin-bottom: 20px !important;
     box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2) !important;
}

.celeste td {
     padding: 10px 14px !important;
     font-size: 12px !important;
     color: #cbd5e1 !important;
     border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
}

.celeste td[bgcolor="#FFFFFF"] {
     background-color: rgba(15, 23, 42, 0.4) !important;
     color: #ffffff !important;
     font-weight: 600 !important;
}

.celeste tr:last-child td {
     border-bottom: none !important;
}

/* Action button style */
input[type="submit"], input[type="button"] {
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     color: #ffffff !important;
     background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
     border: none !important;
     border-radius: 4px !important;
     height: 28px !important;
     padding: 0 14px !important;
     cursor: pointer !important;
     box-shadow: 0 2px 4px rgba(29, 78, 216, 0.2) !important;
     transition: transform 0.1s, box-shadow 0.2s !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
}

input[type="submit"]:hover, input[type="button"]:hover {
     box-shadow: 0 4px 8px rgba(29, 78, 216, 0.3) !important;
}

input[type="submit"]:active, input[type="button"]:active {
     transform: scale(0.97) !important;
}

/* "SALIR" button style override */
#button4 {
     background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
     box-shadow: 0 2px 4px rgba(220, 38, 38, 0.2) !important;
}

#button4:hover {
     box-shadow: 0 4px 8px rgba(220, 38, 38, 0.3) !important;
}

/* Table grid for Destinatarios */
table {
     border-collapse: collapse !important;
     width: 100% !important;
}

.botones {
     background-color: #1e3a8a !important;
     color: #ffffff !important;
     font-weight: 700 !important;
     font-size: 11px !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     border: none !important;
}

.botones td {
     padding: 10px 14px !important;
     border: none !important;
}

.celdas {
     background-color: #1e293b !important;
     color: #cbd5e1 !important;
     border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
}

.celdas td {
     padding: 10px 14px !important;
     font-size: 12px !important;
     color: #cbd5e1 !important;
     border: none !important;
}

.celdas p {
     margin: 0 !important;
     line-height: 1.4 !important;
}

.celdas td a {
     color: #3b82f6 !important;
     text-decoration: none !important;
     font-weight: 700 !important;
}

.celdas td a:hover {
     text-decoration: underline !important;
}

/* Styling for nested forms and buttons in table cells */
.celdas form {
     margin: 0 !important;
     display: inline-block !important;
     vertical-align: middle !important;
}

.celdas input[type="button"] {
     background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
     box-shadow: 0 2px 4px rgba(5, 150, 105, 0.2) !important;
     height: 24px !important;
     font-size: 10px !important;
}

.celdas input[type="button"]:hover {
     box-shadow: 0 4px 8px rgba(5, 150, 105, 0.3) !important;
}
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
          <td><svg class="header-icon" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display: inline-block; vertical-align: middle; margin-right: 6px; width: 16px; height: 16px;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg> ¦- - -&nbsp;Destinatarios </td>
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
            <td><svg class="status-icon success" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#10b981" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="display: inline-block; vertical-align: middle; margin-right: 4px; width: 16px; height: 16px; color: #10b981;"><polyline points="20 6 9 17 4 12"></polyline></svg> Ok.</td>
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
              <td><?php if ($row_listar_destinos['entradas_id']>0){ ?><svg class="status-icon success" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#10b981" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="display: inline-block; vertical-align: middle; margin-right: 4px; width: 16px; height: 16px; color: #10b981;"><polyline points="20 6 9 17 4 12"></polyline></svg>
                Ok.              <?php }else{?><svg class="status-icon warning" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#f59e0b" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display: inline-block; vertical-align: middle; margin-right: 4px; width: 16px; height: 16px; color: #f59e0b;"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                <form id="form1" name="form1" method="post" action="">
                  <input name="button" type="button" id="button" onclick="MM_openBrWindow('confirmarRecepHR.php?id=<?php echo $row_listar_destinos['id']; ?>&hojaruta=<?php echo $row_listar_destinos['hojaruta_cod']; ?>','','width=650,height=480,left=200,top=150')" value="Recibir" />
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
