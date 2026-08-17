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

$colname_list_HR = "-1";
if (isset($_GET['codHR'])) {
  $colname_list_HR = $_GET['codHR'];
}
mysql_select_db($database_snet, $snet);
$query_list_HR = sprintf("SELECT * FROM hojaruta WHERE cod = %s ORDER BY cod ASC", GetSQLValueString($colname_list_HR, "text"));
$list_HR = mysql_query($query_list_HR, $snet) or die(mysql_error());
$row_list_HR = mysql_fetch_assoc($list_HR);
$totalRows_list_HR = mysql_num_rows($list_HR);

mysql_free_result($list_HR);
?>
<style type="text/css">
.alert-box {
     display: flex !important;
     align-items: center !important;
     padding: 12px 16px !important;
     border-radius: 6px !important;
     margin: 5px 0 !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     font-size: 12px !important;
     line-height: 1.5 !important;
     width: 98% !important;
     box-sizing: border-box !important;
}

.alert-icon {
     display: flex !important;
     align-items: center !important;
     justify-content: center !important;
     margin-right: 12px !important;
     flex-shrink: 0 !important;
}

.alert-content {
     flex-grow: 1 !important;
     color: #cbd5e1 !important;
}

/* 1. Error state */
.alert-error {
     background-color: rgba(239, 68, 68, 0.08) !important;
     border: 1px solid rgba(239, 68, 68, 0.25) !important;
}

.text-error {
     color: #ef4444 !important;
     font-weight: 700 !important;
}

.text-highlight {
     color: #ffffff !important;
     font-weight: 600 !important;
}

/* 2. Info state */
.alert-info {
     background-color: rgba(59, 130, 246, 0.08) !important;
     border: 1px solid rgba(59, 130, 246, 0.25) !important;
}

.alert-info .alert-content {
     color: #3b82f6 !important;
     font-weight: 600 !important;
}

/* 3. Success state */
.alert-success {
     background-color: rgba(16, 185, 129, 0.08) !important;
     border: 1px solid rgba(16, 185, 129, 0.25) !important;
}

.text-success {
     color: #10b981 !important;
     font-weight: 700 !important;
     font-size: 13px !important;
}

.text-date {
     color: #94a3b8 !important;
     font-size: 11px !important;
     margin-top: 4px !important;
}
</style>
<?php 
     $trozos = explode("-",$_GET['codHR']);
?>

<?php if ($totalRows_list_HR == 0) { // Show if recordset empty ?>
      <?php if ($trozos[1]!="") {?> 
      <div class="alert-box alert-error">
           <div class="alert-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                     <circle cx="12" cy="12" r="10"></circle>
                     <line x1="15" y1="9" x2="9" y2="15"></line>
                     <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
           </div>
           <div class="alert-content">
                <strong>Hoja de Ruta:</strong> <span class="text-highlight"><?php echo $_GET['codHR']; ?></span><br />
                <span class="text-error">ERROR:</span> el c&oacute;digo <strong>NO existe</strong>, verifique e intente nuevamente.
           </div>
      </div>
      <?php } else { ?>
      <div class="alert-box alert-info">
           <div class="alert-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                     <circle cx="12" cy="12" r="10"></circle>
                     <line x1="12" y1="16" x2="12" y2="12"></line>
                     <line x1="12" y1="8" x2="12.01" y2="8"></line>
                </svg>
           </div>
           <div class="alert-content">
                Introduzca un n&uacute;mero de HOJA DE RUTA para el c&oacute;digo.
           </div>
      </div>
      <?php }?>
<?php } // Show if recordset empty ?>

<?php if ($totalRows_list_HR > 0) { // Show if recordset not empty ?>
      <div class="alert-box alert-success">
           <div class="alert-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                     <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                     <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
           </div>
           <div class="alert-content">
                <span class="text-success">El C&Oacute;DIGO puede ser usado</span>
                <div class="text-date">Fecha de creaci&oacute;n de la Hoja de Ruta: <?php echo $row_list_HR['fecha_creacion']; ?></div>
           </div>
      </div>
<?php } // Show if recordset not empty ?>
