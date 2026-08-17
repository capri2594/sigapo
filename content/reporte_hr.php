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
$query_obtener_hr = sprintf("SELECT * FROM hojaruta  WHERE hojaruta.cod=%s", GetSQLValueString($codigo_obtener_hr, "text"));
$obtener_hr = mysql_query($query_obtener_hr, $snet) or die(mysql_error());
$row_obtener_hr = mysql_fetch_assoc($obtener_hr);
$totalRows_obtener_hr = mysql_num_rows($obtener_hr);

$codigo_ob_derivaciones = "-1";
if (isset($_GET['cod'])) {
  $codigo_ob_derivaciones = $_GET['cod'];
}
mysql_select_db($database_snet, $snet);
$query_ob_derivaciones = sprintf("SELECT * FROM derivacion WHERE derivacion.hojaruta_cod=%s ORDER BY derivacion.nro_destino ASC", GetSQLValueString($codigo_ob_derivaciones, "text"));
$ob_derivaciones = mysql_query($query_ob_derivaciones, $snet) or die(mysql_error());
$row_ob_derivaciones = mysql_fetch_assoc($ob_derivaciones);
$totalRows_ob_derivaciones = mysql_num_rows($ob_derivaciones);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
body {
     background-color: #0f172a !important;
     color: #cbd5e1 !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     margin: 20px !important;
     padding: 0 !important;
}

/* Outer layout tables */
table {
     border-collapse: collapse !important;
     width: 100% !important;
}

/* Header bar styling */
tr.cabecera td {
     background-color: #1e3a8a !important;
     color: #ffffff !important;
     padding: 10px 14px !important;
     border-radius: 8px 8px 0 0 !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     font-size: 13px !important;
     font-weight: 700 !important;
}

tr.cabecera td table td {
     background-color: transparent !important;
     border: none !important;
     padding: 0 !important;
     color: #ffffff !important;
}

/* Buttons styling */
input[type="button"] {
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     padding: 6px 14px !important;
     border: none !important;
     border-radius: 4px !important;
     cursor: pointer !important;
     transition: all 0.2s !important;
     box-shadow: 0 2px 4px rgba(0,0,0,0.2) !important;
}

input[name="Consultar otro"] {
     background: linear-gradient(135deg, #4b5563 0%, #374151 100%) !important;
     color: #ffffff !important;
}

input[name="Consultar otro"]:hover {
     box-shadow: 0 4px 8px rgba(0,0,0,0.3) !important;
     transform: translateY(-1px) !important;
}

input[name="cerrar"] {
     background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
     color: #ffffff !important;
     box-shadow: 0 2px 4px rgba(239, 68, 68, 0.2) !important;
}

input[name="cerrar"]:hover {
     box-shadow: 0 4px 8px rgba(239, 68, 68, 0.3) !important;
     transform: translateY(-1px) !important;
}

/* Inner Results grid table container */
tr.cabecera + tr > td > table {
     background-color: #1e293b !important;
     border: 1px solid rgba(255, 255, 255, 0.1) !important;
     border-top: none !important;
     border-radius: 0 0 8px 8px !important;
     overflow: hidden !important;
     margin-top: 0 !important;
}

/* Grid columns headers */
tr.barras td {
     background-color: #1e293b !important;
     color: #94a3b8 !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     padding: 12px 14px !important;
     border-bottom: 2px solid rgba(255,255,255,0.1) !important;
}

/* Data cells general */
tr.barras ~ tr td {
     padding: 12px 14px !important;
     border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
     font-size: 12px !important;
     background-color: transparent !important;
}

/* Destinatario number cells */
td.barras {
     color: #3b82f6 !important;
     font-weight: 700 !important;
     text-align: center !important;
     width: 40px !important;
}

/* Name and Dependence cells */
td.superior {
     color: #ffffff !important;
}

td.superior strong {
     color: #cbd5e1 !important;
     font-weight: 600 !important;
     font-size: 11px !important;
     display: block !important;
     margin-top: 4px !important;
}

/* Date cells (last cell of data rows) */
tr.barras ~ tr td:last-child {
     color: #cbd5e1 !important;
}

/* Alternate row backgrounds */
tr.barras ~ tr {
     transition: background-color 0.2s !important;
}

tr.barras ~ tr:nth-child(even) {
     background-color: rgba(255, 255, 255, 0.01) !important;
}

tr.barras ~ tr:hover {
     background-color: rgba(255, 255, 255, 0.04) !important;
}

tr.barras ~ tr:hover td {
     color: #ffffff !important;
}
</style>
</head>

<body>
<table width="100%" border="0">
  <tr class="cabecera">
    <td><table width="100%" border="0">
        <tr>
          <td>Reporte de la HOJA DE RUTA: <?php echo $_GET['cod']?> </td>
          <td><label>
            <div align="right">
              <input type="button" name="Consultar otro" id="Consultar otro" value="Consultar otro" onclick="window.history.back();"/>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="button" name="cerrar" id="cerrar" value="Cerrar" onclick="window.close();"/>
              </div>
          </label></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr class="barras">
        <td><strong>DESTINATARIO</strong></td>
        <td><strong>Nombre/Unidad o dependencia</strong></td>
        <td><strong>Fecha de Derivacion</strong></td>
      </tr>
      <tr>
        <td width="10" class="barras">1</td>
        <td class="superior"><?php echo $row_obtener_hr['primerfun_destino']; ?><br />
              <strong><?php echo $row_obtener_hr['primer_destino']; ?></strong><br /></td>
        <td><?php echo $row_obtener_hr['fecha_creacion']; ?></td>
      </tr>
        <?php do { ?>      
      <tr>

          <td class="barras"><?php echo $row_ob_derivaciones['nro_destino']; ?></td>
          <td class="superior"><?php echo $row_ob_derivaciones['fun_destino']; ?><br />
              <strong><?php echo $row_ob_derivaciones['dep_destino']; ?></strong></td>
          <td><?php echo $row_ob_derivaciones['fecha_derivacion']; ?></td>
</tr>
          <?php } while ($row_ob_derivaciones = mysql_fetch_assoc($ob_derivaciones)); ?>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($obtener_hr);

mysql_free_result($ob_derivaciones);
?>
