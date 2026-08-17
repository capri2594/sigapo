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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO entradas (usuario_cuenta, fecha_recibido, fun_recibido, dep_recibido, cod_deprecibido) VALUES (%s, %s, %s, %s, %s)",
                       
                       GetSQLValueString($_POST['user_recibido'], "text"),
                       GetSQLValueString($_POST['fecha_recibido'], "date"),
                       GetSQLValueString($_POST['fun_recibido'], "text"),
                       GetSQLValueString($_POST['dep_recibido'], "text"),
                       GetSQLValueString($_POST['cod_deprecibido'], "text"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($insertSQL, $snet) or die(mysql_error());
  $entrada_id=mysql_insert_id();
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE derivacion SET entradas_id=%s WHERE id=%s AND hojaruta_cod=%s",
                       GetSQLValueString($entrada_id, "int"),
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['hojaruta_cod'], "text"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($updateSQL, $snet) or die(mysql_error());
}

$clave_obtener_derivacion = "-1";
if (isset($_GET['id'])) {
  $clave_obtener_derivacion = $_GET['id'];
}
$codigo_obtener_derivacion = "-1";
if (isset($_GET['hojaruta'])) {
  $codigo_obtener_derivacion = $_GET['hojaruta'];
}
mysql_select_db($database_snet, $snet);
$query_obtener_derivacion = sprintf("SELECT * FROM derivacion WHERE derivacion.id=%s AND derivacion.hojaruta_cod=%s", GetSQLValueString($clave_obtener_derivacion, "text"),GetSQLValueString($codigo_obtener_derivacion, "text"));
$obtener_derivacion = mysql_query($query_obtener_derivacion, $snet) or die(mysql_error());
$row_obtener_derivacion = mysql_fetch_assoc($obtener_derivacion);
$totalRows_obtener_derivacion = mysql_num_rows($obtener_derivacion);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Confirmar Recepci&oacute;n de Hoja de Ruta</title>
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

.titulos div[align="right"] {
     text-align: left !important; /* Align to left to match title */
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
     color: #94a3b8 !important;
     border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
}

/* Limit label column width to give more space to the dynamic value column */
.celeste td.celeste {
     width: 140px !important;
     font-weight: 600 !important;
     color: #94a3b8 !important;
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
     border: none !important;
     border-radius: 4px !important;
     height: 28px !important;
     padding: 0 16px !important;
     cursor: pointer !important;
     transition: transform 0.1s, box-shadow 0.2s !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
}

/* Aceptar button: emerald gradient */
#aceptar {
     background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
     box-shadow: 0 2px 4px rgba(5, 150, 105, 0.2) !important;
}

#aceptar:hover {
     box-shadow: 0 4px 8px rgba(5, 150, 105, 0.3) !important;
}

/* Cancelar button: red gradient */
#button {
     background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
     box-shadow: 0 2px 4px rgba(220, 38, 38, 0.2) !important;
}

#button:hover {
     box-shadow: 0 4px 8px rgba(220, 38, 38, 0.3) !important;
}

input[type="submit"]:active, input[type="button"]:active {
     transform: scale(0.97) !important;
}

/* Table grid for reception */
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
     vertical-align: middle !important;
}

/* Date input formatting */
#fecha_recibido {
     background-color: #ffffff !important;
     border: 1px solid #cbd5e1 !important;
     border-radius: 4px !important;
     color: #0f172a !important;
     padding: 6px 10px !important;
     font-size: 12px !important;
     outline: none !important;
     width: 150px !important;
}
</style>
<script type="text/javascript">
 <?php if (($Result1)&&($_POST["MM_update"] == "form1")) {?>
   //alert('datos ya se han actualizado');
   window.close();
   window.opener.self.alert('Hoja de Ruta\t\t\t\t: <?php echo $_POST['hojaruta_cod']; ?>\n \nRecepcionado correctamente. \nY adicionado en el LIBRO DE ENTRADAS de\n\n FECHA \t\t\t\t\t:<?php echo $_POST['fecha_recibido']; ?> ');
 <?php } else { ?>	
   //window.close();
   <?php }?>
</script>

</head>

<body  onunload="window.opener.self.location.reload();">
<?php if ($Result1)  ?>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
<table width="100%" border="0">
  <tr class="titulos">
    <td>Revise los siguientes datos, por favor: </td>
  </tr>
  <tr>
    <td><table width="100%" border="0" class="celeste">
      <tr>
        <td width="200" class="celeste">Codigo de Hoja de Ruta</td>
        <td bgcolor="#FFFFFF"><?php echo $row_obtener_derivacion['hojaruta_cod']; ?>
          <input name="id" type="hidden" id="id" value="<?php echo $_GET['id']; ?>" />
          <input name="hojaruta_cod" type="hidden" id="hojaruta_cod" value="<?php echo $_GET['hojaruta']; ?>" /></td>
        </tr>
      <tr>
        <td width="200" class="celeste">Destinatario</td>
        <td bgcolor="#FFFFFF"><?php echo $row_obtener_derivacion['nro_destino']; ?></td>
        </tr>
      <tr>
        <td width="200" class="celeste">Nombre y dependencia</td>
        <td bgcolor="#FFFFFF"><?php echo $row_obtener_derivacion['fun_destino']; ?> de <?php echo $row_obtener_derivacion['dep_destino']; ?></td>
        </tr>
      <tr>
        <td width="200" class="celeste">Objeto</td>
        <td bgcolor="#FFFFFF"><?php echo $row_obtener_derivacion['proveido']; ?></td>
        </tr>
      <tr>
        <td width="200" height="80" class="celeste">Instruccion Adicional</td>
        <td height="80" bgcolor="#FFFFFF"><?php echo $row_obtener_derivacion['mensaje']; ?></td>
        </tr>
      <tr>
        <td width="200" class="celeste">Hojas</td>
        <td bgcolor="#FFFFFF"><?php echo $row_obtener_derivacion['nhojas']; ?></td>
        </tr>
      <tr>
        <td width="200" class="celeste">Anexos</td>
        <td bgcolor="#FFFFFF"><?php echo $row_obtener_derivacion['anexos']; ?></td>
        </tr>
    </table></td>
  </tr>
  <tr class="titulos">
    <td><div align="right">Si le corresponde registre la recepcion</div></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">

        <tr class="botones">
          <td>Funcionario</td>
          <td>Dependencia</td>
          <td>Fecha Recepcion</td>
          <td>Accion</td>
        </tr>
        <tr class="celdas">
          <td><?php echo $_SESSION['fun']; ?>
            <input name="fun_recibido" type="hidden" id="fun_recibido" value="<?php echo $_SESSION['fun']; ?>" /></td>
          <td><?php echo $_SESSION['dep']; ?>
            <input name="dep_recibido" type="hidden" id="dep_recibido" value="<?php echo $_SESSION['dep']; ?>" /></td>
          <td>&nbsp;
            <input name="fecha_recibido" type="text" id="fecha_recibido" value="<?php echo date("Y-m-d H:i:s");?>" readonly="READONLY"/>
            <input name="cod_deprecibido" type="hidden" id="cod_deprecibido" value="<?php echo $_SESSION['cod_dep']; ?>" />
            <input name="user_recibido" type="hidden" id="user_recibido" value="<?php echo $_SESSION['user']; ?>" /></td>
          <td>
            <label>
              <input type="submit" name="aceptar" id="aceptar" value="Aceptar" />
              </label>
         
            <label>
            <input type="button" name="button" id="button" value="Cancelar" onclick="window.close();" />
            </label></td>
        </tr>
      </table></td>
  </tr>
</table>
<input type="hidden" name="MM_update" value="form1" />
<input type="hidden" name="MM_insert" value="form1" />
</form>


</body>
</html>
<?php
mysql_free_result($obtener_derivacion);
?>
