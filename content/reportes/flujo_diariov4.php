<?php 
session_name("LoginSIRC");
session_start();
?>
<?php require_once('../../Connections/snet.php'); ?>
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

$colname_entradas = "-1";
$colname_entradas =date("Y-m-d 00:00:00");
$hoyA= date("Y-m-d 00:00:00");
$hoyB= date("Y-m-d 23:59:50");

$hoyA_entradas = $hoyA;
$hoyB_entradas = $hoyB;

$coddep_entradas = "-1";
if (isset($_SESSION['cod_dep'])) {
  $coddep_entradas = $_SESSION['cod_dep'];
}
mysql_select_db($database_snet, $snet);
$query_entradas = sprintf("SELECT * FROM entradas WHERE fecha_recibido >= %s AND fecha_recibido<=%s  AND entradas.cod_deprecibido LIKE %s", GetSQLValueString($hoyA_entradas, "date"),GetSQLValueString($hoyB_entradas, "date"),GetSQLValueString($coddep_entradas, "text"));
$entradas = mysql_query($query_entradas, $snet) or die(mysql_error());
$row_entradas = mysql_fetch_assoc($entradas);
$totalRows_entradas = mysql_num_rows($entradas);

$hoy=date("Y-m-d 00:00:00");
$hoyA_salidas_derivadas = date("Y-m-d 00:00:00");
$hoyB_salidas_derivadas = date("Y-m-d 23:59:50");

$coddep_salidas_derivadas = "-1";
if (isset($_SESSION['cod_dep'])) {
  $coddep_salidas_derivadas = $_SESSION['cod_dep'];
}
mysql_select_db($database_snet, $snet);
$query_salidas_derivadas = sprintf("SELECT * FROM salidas, derivacion WHERE derivacion.salidas_id=salidas.id AND derivacion.proveido!='Archivo' AND salidas.fecha_envio>=%s AND salidas.fecha_envio<=%s AND derivacion.cod_depderivador=%s", GetSQLValueString($hoyA_salidas_derivadas, "date"),GetSQLValueString($hoyB_salidas_derivadas, "date"),GetSQLValueString($coddep_salidas_derivadas, "text"));
$salidas_derivadas = mysql_query($query_salidas_derivadas, $snet) or die(mysql_error());
$row_salidas_derivadas = mysql_fetch_assoc($salidas_derivadas);
$totalRows_salidas_derivadas = mysql_num_rows($salidas_derivadas);

$hoyA_num_en_arch =date("Y-m-d 00:00:00");
$hoyB_num_en_arch =date("Y-m-d 23:59:50");
mysql_select_db($database_snet, $snet);
$query_num_en_arch = sprintf("SELECT * FROM derivacion, entradas WHERE derivacion.entradas_id=entradas.id AND derivacion.proveido='Archivo' AND derivacion.cod_depderivador='".$_SESSION['cod_dep']."'  AND (entradas.fecha_recibido>='".$hoyA_num_en_arch ."' AND entradas.fecha_recibido<='".$hoyB_num_en_arch ."')");
$num_en_arch = mysql_query($query_num_en_arch, $snet) or die(mysql_error());
$row_num_en_arch = mysql_fetch_assoc($num_en_arch);
$totalRows_num_en_arch = mysql_num_rows($num_en_arch);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Flujo Diario</title>
<!-- ApexCharts for modern interactive dashboard visualizations -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<style type="text/css">
body {
     background-color: transparent !important;
     color: #cbd5e1 !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     margin: 10px !important;
     padding: 0 !important;
}

/* Card container matching the dark slate design system */
.chart-card {
     background-color: #1e293b !important;
     border: 1px solid rgba(255, 255, 255, 0.1) !important;
     border-radius: 12px !important;
     box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4) !important;
     padding: 20px !important;
     max-width: 620px !important;
     margin: 0 auto !important;
     box-sizing: border-box !important;
}

.chart-header {
     margin-bottom: 20px !important;
     text-align: center !important;
}

.chart-header h3 {
     color: #ffffff !important;
     font-size: 15px !important;
     font-weight: 700 !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     margin: 0 0 6px 0 !important;
}

.chart-header p {
     color: #94a3b8 !important;
     font-size: 11px !important;
     margin: 0 !important;
}

/* Stats counter grid below the chart */
.stats-grid {
     display: grid !important;
     grid-template-columns: repeat(4, 1fr) !important;
     gap: 12px !important;
     margin-top: 15px !important;
     border-top: 1px solid rgba(255, 255, 255, 0.05) !important;
     padding-top: 15px !important;
}

.stat-item {
     text-align: center !important;
     padding: 10px !important;
     border-radius: 8px !important;
     background-color: rgba(15, 23, 42, 0.25) !important;
     border: 1px solid rgba(255, 255, 255, 0.03) !important;
}

.stat-val {
     font-size: 20px !important;
     font-weight: 800 !important;
     margin-bottom: 4px !important;
     font-family: monospace, sans-serif !important;
}

.stat-val.entradas { color: #3b82f6 !important; }
.stat-val.salidas { color: #10b981 !important; }
.stat-val.pendientes { color: #f59e0b !important; }
.stat-val.archivados { color: #06b6d4 !important; }

.stat-lbl {
     color: #94a3b8 !important;
     font-size: 10px !important;
     font-weight: 700 !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
}
</style>
</head>
<body>

<div class="chart-card">
     <div class="chart-header">
          <h3>Control de Flujo Diario</h3>
          <p>Dependencia: <?php echo htmlentities($_SESSION['cod_dep']); ?></p>
     </div>
     
     <div id="chart"></div>
     
     <div class="stats-grid">
          <div class="stat-item">
               <div class="stat-val entradas"><?php echo (int)$totalRows_entradas; ?></div>
               <div class="stat-lbl">Entradas</div>
          </div>
          <div class="stat-item">
               <div class="stat-val salidas"><?php echo (int)$totalRows_salidas_derivadas; ?></div>
               <div class="stat-lbl">Salidas</div>
          </div>
          <div class="stat-item">
               <div class="stat-val pendientes"><?php echo (int)($totalRows_entradas - $totalRows_salidas_derivadas - $totalRows_num_en_arch); ?></div>
               <div class="stat-lbl">Pendientes</div>
          </div>
          <div class="stat-item">
               <div class="stat-val archivados"><?php echo (int)$totalRows_num_en_arch; ?></div>
               <div class="stat-lbl">Archivados</div>
          </div>
     </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
     const data = [
          <?php echo (int)$totalRows_entradas; ?>,
          <?php echo (int)$totalRows_salidas_derivadas; ?>,
          <?php echo (int)($totalRows_entradas - $totalRows_salidas_derivadas - $totalRows_num_en_arch); ?>,
          <?php echo (int)$totalRows_num_en_arch; ?>
     ];
     
     const options = {
          series: [{
               name: 'Registros',
               data: data
          }],
          chart: {
               type: 'bar',
               height: 230,
               toolbar: {
                    show: false
               },
               background: 'transparent'
          },
          theme: {
               mode: 'dark'
          },
          // Custom semantical color palette matching our dark slate system
          colors: ['#3b82f6', '#10b981', '#f59e0b', '#06b6d4'],
          plotOptions: {
               bar: {
                    distributed: true,
                    borderRadius: 6,
                    columnWidth: '45%',
                    dataLabels: {
                         position: 'top'
                    }
               }
          },
          dataLabels: {
               enabled: true,
               formatter: function (val) {
                    return val;
               },
               offsetY: -20,
               style: {
                    fontSize: '11px',
                    colors: ["#ffffff"]
               }
          },
          legend: {
               show: false
          },
          grid: {
               borderColor: 'rgba(255,255,255,0.05)',
               xaxis: {
                    lines: {
                         show: false
                    }
               },
               yaxis: {
                    lines: {
                         show: true
                    }
               }
          },
          xaxis: {
               categories: ['Entradas', 'Salidas', 'Pendientes', 'Archivados'],
               labels: {
                    style: {
                         colors: ['#94a3b8', '#94a3b8', '#94a3b8', '#94a3b8'],
                         fontSize: '11px',
                         fontWeight: 700
                    }
               },
               axisBorder: {
                    show: false
               },
               axisTicks: {
                    show: false
               }
          },
          yaxis: {
               labels: {
                    style: {
                         colors: '#94a3b8',
                         fontSize: '10px'
                    }
               }
          },
          tooltip: {
               theme: 'dark',
               y: {
                    formatter: function(val) {
                         return val + " registros";
                    }
               }
          }
     };

     const chart = new ApexCharts(document.querySelector("#chart"), options);
     chart.render();
});
</script>

</body>
</html>
<?php
mysql_free_result($entradas);
mysql_free_result($salidas_derivadas);
mysql_free_result($num_en_arch);
?>