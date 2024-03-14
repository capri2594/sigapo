<?php require_once('../Connections/snet.php'); ?>
<?php
// Load the common classes
require_once('../includes/common/KT_common.php');

// Load the common classes
require_once('../includes/jaxon/widgets/dtable/dtable.php');

// Make unified connection variable
$conn_snet = new KT_connection($snet, $database_snet); 

$dtable_DWAjaxTable1 = new dtable($conn_snet, 'Recordrecibidos', 'dtable_DWAjaxTable1', 'einterna');
$dtable_DWAjaxTable1->setUrl(KT_getFullUri());
$dtable_DWAjaxTable1->setMaxRows(10);
$dtable_DWAjaxTable1->addColumn("fecha_recibido", "DATE_TYPE", "fecha_recibido", "=");
$dtable_DWAjaxTable1->addColumn("cite", "STRING_TYPE", "cite", "%");
$dtable_DWAjaxTable1->addColumn("funcionario", "STRING_TYPE", "funcionario", "%");
$dtable_DWAjaxTable1->addColumn("dependencia", "STRING_TYPE", "dependencia", "%");
$dtable_DWAjaxTable1->addColumn("ref", "STRING_TYPE", "ref", "%");
$dtable_DWAjaxTable1->addColumn("tema_titulo", "STRING_TYPE", "tema_titulo", "%");
$dtable_DWAjaxTable1->addColumn("fun_dest", "STRING_TYPE", "fun_dest", "%");
$dtable_DWAjaxTable1->addColumn("dep_dest", "STRING_TYPE", "dep_dest", "%");
$dtable_DWAjaxTable1->addColumn("fecha_proveido", "DATE_TYPE", "fecha_proveido", "=");
$dtable_DWAjaxTable1->addColumn("fun_proveido", "STRING_TYPE", "fun_proveido", "%");
$dtable_DWAjaxTable1->addColumn("nhojas", "NUMERIC_TYPE", "nhojas", "=");
$dtable_DWAjaxTable1->addColumn("adjuntos", "STRING_TYPE", "adjuntos", "%");
$dtable_DWAjaxTable1->addColumn("anexos", "STRING_TYPE", "anexos", "%");
$dtable_DWAjaxTable1->setPK("id", "NUMERIC_TYPE");
$dtable_DWAjaxTable1->setDefaultSortColumn('funcionario', 'DESC');
$dtable_DWAjaxTable1->Execute();

$dtable_DWAjaxTable1_filter_sql = $dtable_DWAjaxTable1->getFilter();
$dtable_DWAjaxTable1_order_sql = $dtable_DWAjaxTable1->getSorter();

//NeXTenesio3 Special List Recordset
$maxRows_Recordrecibidos = $dtable_DWAjaxTable1->getMaxRows();
$pageNum_Recordrecibidos = 0;
if (isset($_GET['pageNum_Recordrecibidos'])) {
  $pageNum_Recordrecibidos = $_GET['pageNum_Recordrecibidos'];
}
$startRow_Recordrecibidos = $pageNum_Recordrecibidos * $maxRows_Recordrecibidos;

$NXTFilter_Recordrecibidos = "1=1";
if (isset($dtable_DWAjaxTable1_filter_sql)) {
  $NXTFilter_Recordrecibidos = $dtable_DWAjaxTable1_filter_sql;
}
$NXTSort_Recordrecibidos = "funcionario DESC";
if (isset($dtable_DWAjaxTable1_order_sql)) {
  $NXTSort_Recordrecibidos = $dtable_DWAjaxTable1_order_sql;
}
mysql_select_db($database_snet, $snet);

$query_Recordrecibidos = sprintf("SELECT * FROM entradas, einterna WHERE entradas.id=einterna.id AND  %s  ORDER BY  %s ", $NXTFilter_Recordrecibidos,$NXTSort_Recordrecibidos);
$query_limit_Recordrecibidos = sprintf("%s LIMIT %d, %d", $query_Recordrecibidos, $startRow_Recordrecibidos, $maxRows_Recordrecibidos);
$Recordrecibidos = mysql_query($query_limit_Recordrecibidos, $snet) or die(mysql_error());
$row_Recordrecibidos = mysql_fetch_assoc($Recordrecibidos);

if (isset($_GET['totalRows_Recordrecibidos'])) {
  $totalRows_Recordrecibidos = $_GET['totalRows_Recordrecibidos'];
} else {
  $all_Recordrecibidos = mysql_query($query_Recordrecibidos);
  $totalRows_Recordrecibidos = mysql_num_rows($all_Recordrecibidos);
}
$totalPages_Recordrecibidos = ceil($totalRows_Recordrecibidos/$maxRows_Recordrecibidos)-1;
//End NeXTenesio3 Special List Recordset

// AJAX Dynamic Table statistics
$dtable_DWAjaxTable1->setStartRow($startRow_Recordrecibidos);
$dtable_DWAjaxTable1->setPageNum($pageNum_Recordrecibidos);
$dtable_DWAjaxTable1->setTotalRows($totalRows_Recordrecibidos);
$dtable_DWAjaxTable1->setTotalPages($totalPages_Recordrecibidos);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Recibidos Totales</title>
<link href="../includes/jaxon/widgets/dtable/css/dtable.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../includes/kore/kore.js"></script>
<script type="text/javascript" src="../includes/jaxon/widgets/dtable/js/dtable.js"></script>
<style type="text/css">
<!--
.style2 {font-size: 9; }
.style3 {font-size: 10px; }
-->
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
            <th bgcolor="#444D6A" class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('fecha_recibido'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('fecha_recibido'); ?>" class="style2">FECHA DE INGRESO</a></th>
            <th bgcolor="#444D6A" class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('cite'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('cite'); ?>" class="style2">CITE</a></th>
            <th bgcolor="#444D6A" class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('funcionario'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('funcionario'); ?>" class="style2">REMITE</a></th>
            <th bgcolor="#444D6A" class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('dependencia'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('dependencia'); ?>" class="style2">PROCEDENCIA</a></th>
            <th bgcolor="#444D6A" class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('ref'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('ref'); ?>" class="style2">REFERENCIA</a></th>
            <th bgcolor="#444D6A" class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('tema_titulo'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('tema_titulo'); ?>" class="style2">TEMA</a></th>
            <th bgcolor="#444D6A" class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('fun_dest'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('fun_dest'); ?>" class="style2">PARA</a></th>
            <th bgcolor="#444D6A" class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('dep_dest'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('dep_dest'); ?>" class="style2">DESTINO</a></th>
            <th bgcolor="#444D6A" class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('fecha_proveido'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('fecha_proveido'); ?>" class="style3">FECHA RECIBIDO</a></th>
            <th bgcolor="#444D6A" class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('fun_proveido'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('fun_proveido'); ?>" class="style2">PROVEIDO</a></th>
            <th bgcolor="#444D6A" class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('nhojas'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('nhojas'); ?>" class="style2">HOJAS</a></th>
            <th bgcolor="#444D6A" class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('adjuntos'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('adjuntos'); ?>" class="style2">ADJUNTOS</a></th>
            <th bgcolor="#444D6A" class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('anexos'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('anexos'); ?>" class="style2">ANEXOS</a></th>
            <th bgcolor="#444D6A">&nbsp;</th>
          </tr>
          <?php 
  // Show IF Conditional region3
?>
          <tr class="filter">
            <th><input type="text" name="dtable_DWAjaxTable1_fecha_recibido" value="<?php echo $dtable_DWAjaxTable1->getFilterValue('fecha_recibido'); ?>" size="10" maxlength="22" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_cite" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('cite')); ?>" size="20" maxlength="20" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_funcionario" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('funcionario')); ?>" size="20" maxlength="20" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_dependencia" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('dependencia')); ?>" size="20" maxlength="20" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_ref" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('ref')); ?>" size="30" maxlength="20" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_tema_titulo" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('tema_titulo')); ?>" size="20" maxlength="20" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_fun_dest" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('fun_dest')); ?>" size="20" maxlength="20" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_dep_dest" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('dep_dest')); ?>" size="20" maxlength="20" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_fecha_proveido" value="<?php echo $dtable_DWAjaxTable1->getFilterValue('fecha_proveido'); ?>" size="10" maxlength="22" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_fun_proveido" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('fun_proveido')); ?>" size="20" maxlength="20" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_nhojas" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('nhojas')); ?>" size="5" maxlength="100" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_adjuntos" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('adjuntos')); ?>" size="20" maxlength="20" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_anexos" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('anexos')); ?>" size="20" maxlength="20" /></th>
            <th><input class="filterButton" type="submit" name="dtable_DWAjaxTable1" value="Filter"/></th>
          </tr>
          <?php 
  // endif Conditional region3
?>
        </thead>
        <tfoot>
          <tr>
            <td colspan="15"><?php $dtable = &$dtable_DWAjaxTable1; ?>
                <?php require("../includes/jaxon/widgets/dtable/nav/NAV_Text_Navigation.inc.php");?>            </td>
          </tr>
        </tfoot>
        <tbody class="data">
          <?php if ($totalRows_Recordrecibidos == 0) { ?>
          <tr>
            <td colspan="15"><div align="left">No hay datos que mostrar.</div></td>
          </tr>
          <?PHP } ?>
          <?php if ($totalRows_Recordrecibidos > 0) { ?>
          <?php do { ?>
            <tr>
              <td><?php echo KT_FormatForList($row_Recordrecibidos['fecha_recibido'], 10); ?></td>
              <td><?php echo KT_FormatForList($row_Recordrecibidos['cite'], 20); ?></td>
              <td><?php echo KT_FormatForList($row_Recordrecibidos['funcionario'], 20); ?></td>
              <td><?php echo KT_FormatForList($row_Recordrecibidos['dependencia'], 20); ?></td>
              <td><?php echo KT_FormatForList($row_Recordrecibidos['ref'], 30); ?></td>
              <td><?php echo KT_FormatForList($row_Recordrecibidos['tema_titulo'], 20); ?></td>
              <td><?php echo KT_FormatForList($row_Recordrecibidos['fun_dest'], 20); ?></td>
              <td><?php echo KT_FormatForList($row_Recordrecibidos['dep_dest'], 20); ?></td>
              <td><?php echo KT_FormatForList($row_Recordrecibidos['fecha_proveido'], 10); ?></td>
              <td><?php echo KT_FormatForList($row_Recordrecibidos['fun_proveido'], 20); ?></td>
              <td><?php echo KT_FormatForList($row_Recordrecibidos['nhojas'], 5); ?></td>
              <td><?php echo KT_FormatForList($row_Recordrecibidos['adjuntos'], 20); ?></td>
              <td><?php echo KT_FormatForList($row_Recordrecibidos['anexos'], 20); ?></td>
              <td>&nbsp;</td>
            </tr>
            <?php } while ($row_Recordrecibidos = mysql_fetch_assoc($Recordrecibidos)); ?>
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
mysql_free_result($Recordrecibidos);
?>
