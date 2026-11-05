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

$dtable_DWAjaxTable1 = new dtable($conn_snet, 'entradas_ex', 'dtable_DWAjaxTable1', 'eexterna');
$dtable_DWAjaxTable1->setUrl(KT_getFullUri());
$dtable_DWAjaxTable1->setMaxRows(6);
$dtable_DWAjaxTable1->addColumn("fecha_recibido", "DATE_TYPE", "fecha_recibido", "=");
$dtable_DWAjaxTable1->addColumn("cite", "STRING_TYPE", "cite", "%");
$dtable_DWAjaxTable1->addColumn("ref", "STRING_TYPE", "ref", "%");
$dtable_DWAjaxTable1->addColumn("org_remitente", "STRING_TYPE", "org_remitente", "%");
$dtable_DWAjaxTable1->addColumn("fecha_doc", "DATE_TYPE", "fecha_doc", "=");
$dtable_DWAjaxTable1->setPK("id_externa", "NUMERIC_TYPE");
$dtable_DWAjaxTable1->setDefaultSortColumn('fecha_doc', 'DESC');
$dtable_DWAjaxTable1->Execute();

$dtable_DWAjaxTable1_filter_sql = $dtable_DWAjaxTable1->getFilter();
$dtable_DWAjaxTable1_order_sql = $dtable_DWAjaxTable1->getSorter();

//NeXTenesio3 Special List Recordset
$maxRows_entradas_ex = $dtable_DWAjaxTable1->getMaxRows();
$pageNum_entradas_ex = 0;
if (isset($_GET['pageNum_entradas_ex'])) {
  $pageNum_entradas_ex = $_GET['pageNum_entradas_ex'];
}
$startRow_entradas_ex = $pageNum_entradas_ex * $maxRows_entradas_ex;

$coddep_entradas_ex = "-1";
if (isset($_SESSION['cod_dep'])) {
  $coddep_entradas_ex = $_SESSION['cod_dep'];
}
$NXTFilter_entradas_ex = "1=1";
if (isset($dtable_DWAjaxTable1_filter_sql)) {
  $NXTFilter_entradas_ex = $dtable_DWAjaxTable1_filter_sql;
}
$NXTSort_entradas_ex = "fecha_doc DESC";
if (isset($dtable_DWAjaxTable1_order_sql)) {
  $NXTSort_entradas_ex = $dtable_DWAjaxTable1_order_sql;
}
mysql_select_db($database_snet, $snet);

$query_entradas_ex = sprintf("SELECT eexterna.id_externa,entradas.fecha_recibido, eexterna.cite, eexterna.`ref`, eexterna.org_remitente, eexterna.fecha_doc  FROM entradas, eexterna WHERE entradas.id=eexterna.entradas_id AND entradas.cod_deprecibido = '%s' AND  %s  ORDER BY  %s ", $coddep_entradas_ex,$NXTFilter_entradas_ex,$NXTSort_entradas_ex);
$query_limit_entradas_ex = sprintf("%s LIMIT %d, %d", $query_entradas_ex, $startRow_entradas_ex, $maxRows_entradas_ex);
$entradas_ex = mysql_query($query_limit_entradas_ex, $snet) or die(mysql_error());
$row_entradas_ex = mysql_fetch_assoc($entradas_ex);

if (isset($_GET['totalRows_entradas_ex'])) {
  $totalRows_entradas_ex = $_GET['totalRows_entradas_ex'];
} else {
  $all_entradas_ex = mysql_query($query_entradas_ex);
  $totalRows_entradas_ex = mysql_num_rows($all_entradas_ex);
}
$totalPages_entradas_ex = ceil($totalRows_entradas_ex/$maxRows_entradas_ex)-1;
//End NeXTenesio3 Special List Recordset

// AJAX Dynamic Table statistics
$dtable_DWAjaxTable1->setStartRow($startRow_entradas_ex);
$dtable_DWAjaxTable1->setPageNum($pageNum_entradas_ex);
$dtable_DWAjaxTable1->setTotalRows($totalRows_entradas_ex);
$dtable_DWAjaxTable1->setTotalPages($totalPages_entradas_ex);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="css/theme_variables.css" rel="stylesheet" type="text/css" />
<script src="js/theme_switcher.js" type="text/javascript"></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="../includes/jaxon/widgets/dtable/css/dtable.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../includes/kore/kore.js"></script>
<script type="text/javascript" src="../includes/jaxon/widgets/dtable/js/dtable.js"></script>
<style type="text/css">
html, body,
html[data-theme="dark"], html[data-theme="dark"] body,
html[data-theme="light"], html[data-theme="light"] body,
:root:not([data-theme="dark"]), :root:not([data-theme="dark"]) body {
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     background-color: transparent !important;
     background-image: none !important;
     margin: 0 !important;
     padding: 0 !important;
}

/* --- DTable style overrides (Dark Mode Default) --- */
form.dtable table {
     width: 100% !important;
     border-collapse: collapse !important;
     background-color: #1c1a1e !important;
     border: 1px solid rgba(245, 158, 11, 0.25) !important;
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
     background-image: none !important;
     background: linear-gradient(135deg, #4d000d 0%, #680014 100%) !important;
     background-color: #50000e !important;
     color: #ffffff !important;
     font-weight: 700 !important;
     font-size: 11px !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     padding: 10px 12px !important;
     border: none !important;
     border-bottom: 2px solid #f59e0b !important;
     text-align: left !important;
}

form.dtable th a {
     color: #ffffff !important;
     text-decoration: none !important;
}

form.dtable th a:hover {
     color: #fde047 !important;
     text-decoration: none !important;
}

form.dtable tr.filter th {
     background-image: none !important;
     background: #1c1a1e !important;
     background-color: #1c1a1e !important;
     padding: 8px 10px !important;
     border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
}

form.dtable tr.filter input[type="text"] {
     width: 100% !important;
     background-color: rgba(20, 18, 20, 0.85) !important;
     border: 1px solid rgba(255, 255, 255, 0.14) !important;
     border-radius: 4px !important;
     color: #ffffff !important;
     padding: 6px 10px !important;
     font-size: 11px !important;
     outline: none !important;
     box-sizing: border-box !important;
}

form.dtable tr.filter input[type="text"]:focus {
     border-color: #f59e0b !important;
     box-shadow: 0 0 0 2px rgba(245, 158, 11, 0.25) !important;
}

form.dtable input.filterButton {
     width: 100% !important;
     height: 28px !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     color: #ffffff !important;
     background: linear-gradient(135deg, #50000e 0%, #780016 100%) !important;
     border: 1px solid rgba(245, 158, 11, 0.4) !important;
     border-radius: 4px !important;
     cursor: pointer !important;
}

form.dtable tbody.data tr {
     background-color: #1c1a1e !important;
     border-bottom: 1px solid rgba(255, 255, 255, 0.06) !important;
}

form.dtable tbody.data tr:nth-child(even) {
     background-color: rgba(255, 255, 255, 0.02) !important;
}

form.dtable tbody.data td {
     padding: 10px 12px !important;
     color: #cbd5e1 !important;
     font-size: 11px !important;
     border: none !important;
     border-bottom: 1px solid rgba(255, 255, 255, 0.06) !important;
}

form.dtable tbody.data tr:hover {
     background-color: rgba(190, 18, 60, 0.12) !important;
}

form.dtable tbody.data tr:hover td {
     color: #ffffff !important;
}

form.dtable tbody.data td a {
     display: inline-block !important;
     padding: 4px 10px !important;
     background-color: rgba(190, 18, 60, 0.15) !important;
     border: 1px solid rgba(245, 158, 11, 0.35) !important;
     color: #fde047 !important;
     text-decoration: none !important;
     font-weight: 700 !important;
     font-size: 10px !important;
     border-radius: 4px !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
}

form.dtable tbody.data td a:hover {
     background: linear-gradient(135deg, #50000e 0%, #780016 100%) !important;
     color: #ffffff !important;
     border-color: #f59e0b !important;
}

/* Footer Navigation */
form.dtable tfoot td {
     background-color: #1c1a1e !important;
     padding: 12px 14px !important;
     border-top: 1px solid rgba(245, 158, 11, 0.25) !important;
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
     background: transparent !important;
}

form.dtable tfoot td a {
     color: #fde047 !important;
     text-decoration: none !important;
     font-weight: bold !important;
}

form.dtable tfoot td a:hover {
     text-decoration: underline !important;
}

/* ========================================================
   MODO CLARO (Light Mode Overrides)
   ======================================================== */
html[data-theme="light"] form.dtable table,
:root:not([data-theme="dark"]) form.dtable table {
     background-color: #ffffff !important;
     border: 1px solid rgba(104, 0, 20, 0.2) !important;
}

html[data-theme="light"] form.dtable caption,
:root:not([data-theme="dark"]) form.dtable caption {
     color: #50000e !important;
}

html[data-theme="light"] form.dtable tr.filter th,
:root:not([data-theme="dark"]) form.dtable tr.filter th {
     background: #f8fafc !important;
     background-color: #f8fafc !important;
     border-bottom: 1px solid #e2e8f0 !important;
}

html[data-theme="light"] form.dtable tr.filter input[type="text"],
:root:not([data-theme="dark"]) form.dtable tr.filter input[type="text"] {
     background-color: #ffffff !important;
     border: 1px solid #cbd5e1 !important;
     color: #18181b !important;
}

html[data-theme="light"] form.dtable tbody.data tr,
:root:not([data-theme="dark"]) form.dtable tbody.data tr {
     background-color: #ffffff !important;
     border-bottom: 1px solid #e2e8f0 !important;
}

html[data-theme="light"] form.dtable tbody.data tr:nth-child(even),
:root:not([data-theme="dark"]) form.dtable tbody.data tr:nth-child(even) {
     background-color: #f8fafc !important;
}

html[data-theme="light"] form.dtable tbody.data td,
:root:not([data-theme="dark"]) form.dtable tbody.data td {
     background-color: transparent !important;
     color: #18181b !important;
     border-bottom: 1px solid #e2e8f0 !important;
}

html[data-theme="light"] form.dtable tbody.data tr:hover,
:root:not([data-theme="dark"]) form.dtable tbody.data tr:hover {
     background-color: #fff1f2 !important;
}

html[data-theme="light"] form.dtable tbody.data tr:hover td,
:root:not([data-theme="dark"]) form.dtable tbody.data tr:hover td {
     color: #50000e !important;
}

html[data-theme="light"] form.dtable tbody.data td a,
:root:not([data-theme="dark"]) form.dtable tbody.data td a {
     background-color: #fff1f2 !important;
     border: 1px solid rgba(104, 0, 20, 0.35) !important;
     color: #50000e !important;
}

html[data-theme="light"] form.dtable tbody.data td a:hover,
:root:not([data-theme="dark"]) form.dtable tbody.data td a:hover {
     background: linear-gradient(135deg, #4d000d 0%, #680014 100%) !important;
     color: #ffffff !important;
}

html[data-theme="light"] form.dtable tfoot td,
:root:not([data-theme="dark"]) form.dtable tfoot td {
     background-color: #f8fafc !important;
     border-top: 1px solid #e2e8f0 !important;
     color: #475569 !important;
}

html[data-theme="light"] form.dtable tfoot td a,
:root:not([data-theme="dark"]) form.dtable tfoot td a {
     color: #50000e !important;
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
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('fecha_recibido'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('fecha_recibido'); ?>">Fech.Recibido</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('cite'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('cite'); ?>">Cite</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('ref'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('ref'); ?>">Referencia</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('org_remitente'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('org_remitente'); ?>">Procedencia</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('fecha_doc'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('fecha_doc'); ?>">Fech.Doc</a></th>
            <th>&nbsp;</th>
          </tr>
          <?php 
  // Show IF Conditional region3
?>
          <tr class="filter">
            <th><input type="text" name="dtable_DWAjaxTable1_fecha_recibido" value="<?php echo $dtable_DWAjaxTable1->getFilterValue('fecha_recibido'); ?>" size="10" maxlength="10" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_cite" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('cite')); ?>" size="15" maxlength="50" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_ref" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('ref')); ?>" size="30" maxlength="100" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_org_remitente" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('org_remitente')); ?>" size="19" maxlength="100" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_fecha_doc" value="<?php echo $dtable_DWAjaxTable1->getFilterValue('fecha_doc'); ?>" size="10" maxlength="10" /></th>
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
          <?php if ($totalRows_entradas_ex == 0) { ?>
          <tr>
            <td colspan="7">No hay registros que mostrar. VERIFIQUE e intente nuevamente </td>
          </tr>
          <?PHP } ?>
          <?php if ($totalRows_entradas_ex > 0) { ?>
          <?php do { ?>
            <tr>
              <td><?php echo KT_FormatForList($row_entradas_ex['fecha_recibido'], 16); ?></td>
              <td><?php echo KT_FormatForList($row_entradas_ex['cite'], 50); ?></td>
              <td><?php echo KT_FormatForList($row_entradas_ex['ref'], 80); ?></td>
              <td><?php echo KT_FormatForList($row_entradas_ex['org_remitente'], 100); ?></td>
              <td><?php echo KT_FormatForList($row_entradas_ex['fecha_doc'], 10); ?></td>
              <td><a href="javascript:return(0);" alt="../content/reporte_hr.php?cod=<?php echo $row_entradas_ex['id_externa']; ?>">Detalles</a></td>
            </tr>
            <?php } while ($row_entradas_ex = mysql_fetch_assoc($entradas_ex)); ?>
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
mysql_free_result($entradas_ex);
?>
