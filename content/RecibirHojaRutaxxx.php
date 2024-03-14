<?php 
session_name("LoginSIRC");
session_start();
?>
<?php require_once('../Connections/snet.php'); ?>
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE hojaruta SET fecha_proveido=%s, fun_proveido=%s WHERE cod=%s",
                       GetSQLValueString($_POST['fecha_recibido'], "date"),
                       GetSQLValueString($_POST['fun_proveido'], "text"),
                       GetSQLValueString($_POST['codigo'], "text"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($updateSQL, $snet) or die(mysql_error());
}

$colname_Record_hr = "-1";
if (isset($_POST['cod'])) {
  $colname_Record_hr = $_POST['cod'];
}
mysql_select_db($database_snet, $snet);
$query_Record_hr = sprintf("SELECT * FROM hojaruta WHERE cod = %s  AND hojaruta.fun_proveido is NULL", GetSQLValueString($colname_Record_hr, "text"));
$Record_hr = mysql_query($query_Record_hr, $snet) or die(mysql_error());
$row_Record_hr = mysql_fetch_assoc($Record_hr);
$totalRows_Record_hr = mysql_num_rows($Record_hr);
 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.Estilo1 {
	color: #FF0000;
	font-size: 12px;
	font-family: Arial, Helvetica, sans-serif;
}
.Estilo2 {color: #000074}
-->
</style>
</head>

<body>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="700" border="0" cellspacing="1" cellpadding="5">
    <tr bgcolor="#E6E6E6">
      <td>Datos de la Hoja de Ruta</td>
    </tr>
    <?php if ($totalRows_Record_hr > 0) { // Show if recordset not empty ?>
      <tr bgcolor="#F8F8F8">
        <td><table width="700" border="0" cellspacing="1" cellpadding="5">
            <tr>
              <td width="480" valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="4">
                  <tr>
                    <td>Codigo</td>
                    <td bgcolor="#FFFFFF"><?php echo $row_Record_hr['cod']; ?>
                    <input name="codigo" type="hidden" id="codigo" value="<?php echo $_POST[cod];?>" /></td>
                  </tr>
                  <tr>
                    <td>Fecha Creacion</td>
                    <td bgcolor="#FFFFFF"><?php echo $row_Record_hr['fecha_creacion']; ?></td>
                  </tr>
                  <tr>
                    <td>Remitente</td>
                    <td bgcolor="#FFFFFF"><?php echo $row_Record_hr['fun_remite']; ?>&lt;<?php echo $row_Record_hr['dep_remite']; ?>&gt;</td>
                  </tr>
                  <tr>
                    <td>Referencia</td>
                    <td bgcolor="#FFFFFF"><?php echo $row_Record_hr['ref']; ?></td>
                  </tr>
                  <tr>
                    <td>hojas</td>
                    <td bgcolor="#FFFFFF"><?php echo $row_Record_hr['nhojas']; ?></td>
                  </tr>
                  <tr>
                    <td>anexos</td>
                    <td bgcolor="#FFFFFF"><?php echo $row_Record_hr['nanexos']; ?></td>
                  </tr>
                  <tr>
                    <td>1º Destinatario</td>
                    <td bgcolor="#FFFFFF"><?php echo $row_Record_hr['fun_destino']; ?>&lt;<?php echo $row_Record_hr['dep_destino']; ?>&gt;</td>
                  </tr>
                  </table></td>
              <td valign="bottom"><table align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td height="80" valign="bottom"><div align="center">________________________</div></td>
                  </tr>
                  <tr>
                    <td><div align="center"><span class="Estilo2 Estilo6">
                        <input name="fecha_recibido" type="hidden" id="fecha_recibido" value="<?php echo date("d-m-Y H:i:s"); ?>" />
                      <?php echo date("d-m-Y H:i:s");?></span></div></td>
                  </tr>
                  <tr>
                    <td><div align="center"> <?php echo $_SESSION['fun']; ?>
                            <input name="fun_proveido" type="hidden" id="fun_proveido" value="<?php echo $_SESSION['fun']; ?>" />
                        </div></td>
                  </tr>
                  <tr>
                    <td><div align="center"> <?php echo $_SESSION['cargo']; ?>
                            <input name="cargo_proveido" id="cargo_proveido" value="<?php echo $_SESSION['cargo']; ?>" type="hidden" />
                        </div></td>
                  </tr>
                  <tr>
                    <td><div align="center"> <?php echo $_SESSION['dep']; ?>
                            <input name="dep_proveido" id="dep_proveido" value="<?php echo $_SESSION['dep']; ?>" type="hidden" />
                        </div></td>
                  </tr>
                  <tr>
                    <td> </td>
                  </tr>
                  </table></td>
            </tr>
                </table></td>
      </tr>

        <tr bgcolor="#F8F8F8">
          <td><input type="submit" name="Registrar" id="Registrar" value="Registrar" /></td>
        </tr>
    <?php } // Show if recordset not empty ?>
    <?php if (isset($_POST['cod'])) {// Show if recordset empty ?>
    
    <?php if ($totalRows_Record_hr == 0) { // Show if recordset empty ?>
      <tr bgcolor="#F8F8F8">
        <td><div align="center" class="Estilo1">ERROR: la hoja de ruta ya fue recibida.</div></td>
      </tr>
      <?php } // Show if recordset empty ?>
      <?php } // Show if recordset empty ?>
      <?php if (!isset($_POST['cod'])) {// Show if recordset empty ?>
      <tr bgcolor="#F8F8F8">
        <td><div align="center" class="Estilo1 Estilo2">No hay datos que mostrar: <?php $_POST['cod']; ?> </div></td>
      </tr>
      <?php } // Show if recordset empty ?>
    </table>
  <input type="hidden" name="MM_update" value="form1" />
</form>
</body>
</html>
<?php
mysql_free_result($Record_hr);
?>
