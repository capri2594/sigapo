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

$hoyA = date("Y-m-d 00:00:00");
$hoyB = date("Y-m-d 23:59:50");

mysql_select_db($database_snet, $snet);

// Optimized query: groups by department, counts entries for today, filters out zero values and orders by count descending (ranking)
$query_ranking = sprintf("SELECT cod_deprecibido as cod, COUNT(*) as total FROM entradas WHERE fecha_recibido >= %s AND fecha_recibido <= %s AND cod_deprecibido IS NOT NULL AND cod_deprecibido != '' GROUP BY cod_deprecibido ORDER BY total DESC", GetSQLValueString($hoyA, "date"), GetSQLValueString($hoyB, "date"));

$ranking_res = mysql_query($query_ranking, $snet) or die(mysql_error());

$codes = array();
$totals = array();

while ($row = mysql_fetch_assoc($ranking_res)) {
     $codes[] = $row['cod'];
     $totals[] = (int)$row['total'];
}

$has_data = count($codes) > 0;
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Ranking de Entradas</title>
<!-- ApexCharts for clean responsive data visualization -->
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
     max-width: 650px !important;
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

/* Empty state styling */
.empty-state {
     text-align: center !important;
     padding: 40px 20px !important;
     color: #94a3b8 !important;
}

.empty-state svg {
     margin-bottom: 12px !important;
     opacity: 0.5 !important;
}

.empty-state p {
     font-size: 13px !important;
     margin: 0 !important;
}

/* Table styling for the leaderboard ranking */
.ranking-table {
     width: 100% !important;
     border-collapse: collapse !important;
     margin-top: 20px !important;
     border-top: 1px solid rgba(255, 255, 255, 0.05) !important;
     box-sizing: border-box !important;
}

.ranking-table th {
     color: #94a3b8 !important;
     font-size: 10px !important;
     font-weight: 700 !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     padding: 12px 10px !important;
     text-align: left !important;
     border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
}

.ranking-table td {
     padding: 10px !important;
     font-size: 13px !important;
     color: #e2e8f0 !important;
     border-bottom: 1px solid rgba(255, 255, 255, 0.02) !important;
}

.ranking-table tr:hover td {
     background-color: rgba(255, 255, 255, 0.02) !important;
}

.badge-position {
     display: inline-flex !important;
     align-items: center !important;
     justify-content: center !important;
     width: 22px !important;
     height: 22px !important;
     border-radius: 50% !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     color: #ffffff !important;
}

.pos-1 { background-color: #f59e0b !important; box-shadow: 0 0 8px rgba(245, 158, 11, 0.4) !important; }
.pos-2 { background-color: #94a3b8 !important; }
.pos-3 { background-color: #b45309 !important; }
.pos-other { background-color: rgba(255, 255, 255, 0.1) !important; color: #94a3b8 !important; }

.text-bold {
     font-weight: 600 !important;
     color: #ffffff !important;
}
</style>
</head>
<body>

<div class="chart-card">
     <div class="chart-header">
          <h3>Ranking de Entradas por Dependencia</h3>
          <p>Flujo de recepción diario consolidado</p>
     </div>
     
     <?php if ($has_data): ?>
          <!-- ApexCharts element container -->
          <div id="chart"></div>
          
          <!-- Leaderboard Table -->
          <table class="ranking-table">
               <thead>
                    <tr>
                         <th width="80">Puesto</th>
                         <th>Dependencia</th>
                         <th style="text-align: right;">Registros Recibidos</th>
                    </tr>
               </thead>
               <tbody>
                    <?php 
                    for ($k = 0; $k < count($codes); $k++) {
                         $position = $k + 1;
                         $badgeClass = 'pos-other';
                         if ($position == 1) $badgeClass = 'pos-1';
                         elseif ($position == 2) $badgeClass = 'pos-2';
                         elseif ($position == 3) $badgeClass = 'pos-3';
                    ?>
                         <tr>
                              <td>
                                   <span class="badge-position <?php echo $badgeClass; ?>"><?php echo $position; ?></span>
                              </td>
                              <td class="text-bold"><?php echo htmlentities($codes[$k]); ?></td>
                              <td style="text-align: right; font-family: monospace;" class="text-bold"><?php echo $totals[$k]; ?> reg.</td>
                         </tr>
                    <?php } ?>
               </tbody>
          </table>
     <?php else: ?>
          <!-- Empty State -->
          <div class="empty-state">
               <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
               </svg>
               <p>No se registraron correspondencias el día de hoy.</p>
          </div>
     <?php endif; ?>
</div>

<?php if ($has_data): ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
     const categories = <?php echo json_encode($codes); ?>;
     const data = <?php echo json_encode($totals); ?>;
     
     const options = {
          series: [{
               name: 'Registros',
               data: data
          }],
          chart: {
               type: 'bar',
               height: Math.max(180, categories.length * 35), // Dynamically calculate height depending on active departments
               toolbar: {
                    show: false
               },
               background: 'transparent'
          },
          theme: {
               mode: 'dark'
          },
          // Soft blue to cyan gradient for modern horizontal bars
          colors: ['#3b82f6'],
          plotOptions: {
               bar: {
                    horizontal: true,
                    borderRadius: 4,
                    barHeight: '65%',
                    dataLabels: {
                         position: 'end'
                    }
               }
          },
          dataLabels: {
               enabled: true,
               textAnchor: 'start',
               style: {
                    colors: ['#ffffff'],
                    fontSize: '11px',
                    fontWeight: 700
               },
               formatter: function (val) {
                    return val + " reg.";
               },
               offsetX: 10
          },
          grid: {
               borderColor: 'rgba(255,255,255,0.05)',
               xaxis: {
                    lines: {
                         show: true
                    }
               },
               yaxis: {
                    lines: {
                         show: false
                    }
               }
          },
          xaxis: {
               categories: categories,
               labels: {
                    style: {
                         colors: '#94a3b8',
                         fontSize: '10px'
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
                         colors: '#cbd5e1',
                         fontSize: '11px',
                         fontWeight: 600
                    }
               }
          },
          tooltip: {
               theme: 'dark',
               y: {
                    formatter: function(val) {
                         return val + " registros recibidos";
                    }
               }
          }
     };

     const chart = new ApexCharts(document.querySelector("#chart"), options);
     chart.render();
});
</script>
<?php endif; ?>

</body>
</html>
<?php
mysql_free_result($ranking_res);
?>
