<?php 
header("Content-Type: text/html; charset=utf-8");
session_name("LoginSIRC");
session_start();
?>
<?php require_once('../Connections/snet.php'); ?>
<?php
// Load the common classes
require_once('../includes/common/KT_common.php');

// Load the common classes
require_once('../includes/jaxon/widgets/dtable/dtable.php');

// Make unified connection variable
$conn_snet = new KT_connection($snet, $database_snet); 

$dtable_DWAjaxTable1 = new dtable($conn_snet, 'entradas_hr', 'dtable_DWAjaxTable1', 'derivacion');
$dtable_DWAjaxTable1->setUrl(KT_getFullUri());
$dtable_DWAjaxTable1->setMaxRows(10);
$dtable_DWAjaxTable1->addColumn("fecha_recibido", "DATE_TYPE", "fecha_recibido", "=");
$dtable_DWAjaxTable1->addColumn("hojaruta_cod", "STRING_TYPE", "hojaruta_cod", "%");
$dtable_DWAjaxTable1->addColumn("nro_destino", "NUMERIC_TYPE", "nro_destino", "=");
$dtable_DWAjaxTable1->addColumn("fun_destino", "STRING_TYPE", "fun_destino", "%");
$dtable_DWAjaxTable1->addColumn("fun_recibidoHR", "STRING_TYPE", "fun_recibidoHR", "%");
$dtable_DWAjaxTable1->setPK("id", "NUMERIC_TYPE");
$dtable_DWAjaxTable1->setDefaultSortColumn('fecha_recibido', 'DESC');
$dtable_DWAjaxTable1->Execute();

$dtable_DWAjaxTable1_filter_sql = $dtable_DWAjaxTable1->getFilter();
$dtable_DWAjaxTable1_order_sql = $dtable_DWAjaxTable1->getSorter();

//NeXTenesio3 Special List Recordset
$maxRows_entradas_hr = $dtable_DWAjaxTable1->getMaxRows();
$pageNum_entradas_hr = 0;
if (isset($_GET['pageNum_entradas_hr'])) {
  $pageNum_entradas_hr = $_GET['pageNum_entradas_hr'];
}
$startRow_entradas_hr = $pageNum_entradas_hr * $maxRows_entradas_hr;

$coddep_entradas_hr = "-1";
if (isset($_SESSION['cod_dep'])) {
  $coddep_entradas_hr = $_SESSION['cod_dep'];
}
$NXTFilter_entradas_hr = "1=1";
if (isset($dtable_DWAjaxTable1_filter_sql)) {
  $NXTFilter_entradas_hr = $dtable_DWAjaxTable1_filter_sql;
}
$NXTSort_entradas_hr = "fecha_recibido DESC";
if (isset($dtable_DWAjaxTable1_order_sql)) {
  $NXTSort_entradas_hr = $dtable_DWAjaxTable1_order_sql;
}
mysql_select_db($database_snet, $snet);

$query_entradas_hr = sprintf("SELECT entradas.id,entradas.fecha_recibido, derivacion.hojaruta_cod, derivacion.nro_destino, derivacion.fun_destino, entradas.fun_recibido FROM entradas, derivacion WHERE entradas.cod_deprecibido = '%s' AND entradas.id=derivacion.entradas_id  AND  %s ORDER BY %s ", $coddep_entradas_hr,$NXTFilter_entradas_hr,$NXTSort_entradas_hr);
$query_limit_entradas_hr = sprintf("%s LIMIT %d, %d", $query_entradas_hr, $startRow_entradas_hr, $maxRows_entradas_hr);
$entradas_hr = mysql_query($query_limit_entradas_hr, $snet) or die(mysql_error());
$row_entradas_hr = mysql_fetch_assoc($entradas_hr);

if (isset($_GET['totalRows_entradas_hr'])) {
  $totalRows_entradas_hr = $_GET['totalRows_entradas_hr'];
} else {
  $all_entradas_hr = mysql_query($query_entradas_hr);
  $totalRows_entradas_hr = mysql_num_rows($all_entradas_hr);
}
$totalPages_entradas_hr = ceil($totalRows_entradas_hr/$maxRows_entradas_hr)-1;
//End NeXTenesio3 Special List Recordset

// AJAX Dynamic Table statistics
$dtable_DWAjaxTable1->setStartRow($startRow_entradas_hr);
$dtable_DWAjaxTable1->setPageNum($pageNum_entradas_hr);
$dtable_DWAjaxTable1->setTotalRows($totalRows_entradas_hr);
$dtable_DWAjaxTable1->setTotalPages($totalPages_entradas_hr);
 
header("Content-Type: text/html; charset=utf-8");
session_name("LoginSIRC");
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="../includes/jaxon/widgets/dtable/css/dtable.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../includes/kore/kore.js"></script>
<script type="text/javascript" src="../includes/jaxon/widgets/dtable/js/dtable.js"></script>
<style type="text/css">
body {
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     background-color: transparent !important;
     color: #cbd5e1 !important;
     margin: 0 !important;
     padding: 0 !important;
}

/* --- DTable style overrides --- */
form.dtable table {
     width: 100% !important;
     border-collapse: collapse !important;
     background-color: #1e293b !important;
     border: 1px solid rgba(255, 255, 255, 0.1) !important;
     border-radius: 8px !important;
     overflow: hidden !important;
}

form.dtable caption {
     color: #94a3b8 !important;
     font-size: 11px !important;
     font-weight: 600 !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     margin-bottom: 10px !important;
     text-align: right !important;
     padding: 0 5px !important;
}

form.dtable th {
     background-color: #1e3a8a !important;
     color: #ffffff !important;
     font-weight: 700 !important;
     font-size: 11px !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     padding: 10px 12px !important;
     border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
     text-align: left !important;
}

form.dtable th a {
     color: #ffffff !important;
     text-decoration: none !important;
}

form.dtable th a:hover {
     text-decoration: underline !important;
}

form.dtable tr.filter th {
     background-color: #1e293b !important;
     padding: 8px 10px !important;
}

form.dtable tr.filter input[type="text"] {
     width: 100% !important;
     background-color: rgba(15, 23, 42, 0.6) !important;
     border: 1px solid rgba(255, 255, 255, 0.1) !important;
     border-radius: 4px !important;
     color: #ffffff !important;
     padding: 6px 10px !important;
     font-size: 11px !important;
     outline: none !important;
     box-sizing: border-box !important; }

form.dtable tr.filter input[type="text"]:focus {
     border-color: #2563eb !important;
}

form.dtable input.filterButton {
     width: 100% !important;
     height: 28px !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     color: #ffffff !important;
     background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important;
     border: none !important;
     border-radius: 4px !important;
     cursor: pointer !important;
}

form.dtable tbody.data tr {
     background-color: #1e293b !important;
     border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
}

form.dtable tbody.data tr:nth-child(even) {
     background-color: rgba(255, 255, 255, 0.01) !important;
}

form.dtable tbody.data td {
     padding: 10px 12px !important;
     color: #cbd5e1 !important;
     font-size: 11px !important;
}

form.dtable tbody.data tr:hover {
     background-color: rgba(255, 255, 255, 0.04) !important;
}

form.dtable tbody.data tr:hover td {
     color: #ffffff !important;
}

form.dtable tbody.data td a {
     display: inline-block !important;
     padding: 4px 10px !important;
     background-color: rgba(37, 99, 235, 0.1) !important;
     border: 1px solid rgba(37, 99, 235, 0.25) !important;
     color: #3b82f6 !important;
     text-decoration: none !important;
     font-weight: 700 !important;
     font-size: 10px !important;
     border-radius: 4px !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
}

form.dtable tbody.data td a:hover {
     background-color: #2563eb !important;
     color: #ffffff !important;
     border-color: #2563eb !important;
}

/* Footer Navigation */
form.dtable tfoot td {
     background-color: #1e293b !important;
     padding: 12px 14px !important;
     border-top: 1px solid rgba(255, 255, 255, 0.1) !important;
     color: #94a3b8 !important;
     font-size: 11px !important;
}

form.dtable tfoot td table {
     margin: 0 auto !important;
     background: transparent !important;
     box-shadow: none !important;
     border: none !important;
     width: auto !important;
}

form.dtable tfoot td table td {
     padding: 0 5px !important;
     border: none !important;
}

form.dtable tfoot td a {
     color: #3b82f6 !important;
     text-decoration: none !important;
     font-weight: bold !important;
}

form.dtable tfoot td a:hover {
     text-decoration: underline !important;
}
</style>
</head>

<body>
<form class="dtable" id="<?php echo $dtable_DWAjaxTable1->listName; ?>" action="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterUri()); ?>" method="get">
  <div> <?php echo $dtable_DWAjaxTable1->beginList(); ?>
      <table border="0" cellpadding="0" cellspacing="0">
        <caption>
        <?php
					$dtable = &$dtable_DWAjaxTable1;
				?>
        <?php require("../includes/jaxon/widgets/dtable/nav/NAV_Text_Statistics.inc.php");?>
        </caption>
        <thead>
          <tr>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('fecha_recibido'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('fecha_recibido'); ?>">Fech.Recib.</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('hojaruta_cod'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('hojaruta_cod'); ?>">Hojaruta</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('nro_destino'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('nro_destino'); ?>">Nro.</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('fun_destino'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('fun_destino'); ?>">Destinatario</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('fun_recibido'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('fun_recibido'); ?>">Recibido</a></th>
            <th>&nbsp;</th>
          </tr>
          <?php 
  // Show IF Conditional region3
?>
          <tr class="filter">
            <th><input type="text" name="dtable_DWAjaxTable1_fecha_recibido" value="<?php echo $dtable_DWAjaxTable1->getFilterValue('fecha_recibido'); ?>" size="16" maxlength="20" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_hojaruta_cod" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('hojaruta_cod')); ?>" size="20" maxlength="50" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_nro_destino" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('nro_destino')); ?>" size="5" maxlength="10" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_fun_destino" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('fun_destino')); ?>" size="20" maxlength="50" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_fun_recibidoHR" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('fun_recibido')); ?>" size="20" maxlength="50" /></th>
            <th><input class="filterButton" type="submit" name="dtable_DWAjaxTable1" value="Buscar"/></th>
          </tr>
          <?php 
  // endif Conditional region3
?>
        </thead>
        <tfoot>
          <tr>
            <td colspan="7"><?php $dtable = &$dtable_DWAjaxTable1; ?>
                <?php require("../includes/jaxon/widgets/dtable/nav/NAV_Text_Navigation.inc.php");?>
            </td>
          </tr>
        </tfoot>
        <tbody class="data">
          <?php if ($totalRows_entradas_hr == 0) { ?>
          <tr>
            <td colspan="7">No se encuentran datos .</td>
          </tr>
          <?PHP } ?>
          <?php if ($totalRows_entradas_hr > 0) { ?>
          <?php do { ?>
            <tr>
              <td><?php echo KT_FormatForList($row_entradas_hr['fecha_recibido'], 10); ?></td>
              <td><?php echo KT_FormatForList($row_entradas_hr['hojaruta_cod'], 20); ?></td>
              <td><?php echo KT_FormatForList($row_entradas_hr['nro_destino'], 5); ?></td>
              <td><?php echo KT_FormatForList($row_entradas_hr['fun_destino'], 80); ?></td>
              <td><?php echo KT_FormatForList($row_entradas_hr['fun_recibido'], 20); ?></td>
              <td><a href="../content/reporte_hr.php?cod=<?php echo $row_entradas_hr['hojaruta_cod']; ?>" target="_blank">Detalles</a></td>
            </tr>
            <?php } while ($row_entradas_hr = mysql_fetch_assoc($entradas_hr)); ?>
          <?php }?>
        </tbody>
      </table>
    <script type="text/javascript">
		new Widgets.DataTable("<?php echo $dtable_DWAjaxTable1->listName; ?>");
	</script>
      <?php echo $dtable_DWAjaxTable1->endList(); ?> </div>
</form>
</body>
</html>
<?php
mysql_free_result($entradas_hr);
?>
