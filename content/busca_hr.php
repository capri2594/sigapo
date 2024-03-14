<?php 
session_name("LoginSIRC");
session_start();
header("Content-Type: text/html; charset=utf-8");
//echo  "dep:".$_SESSION['dep']
//$cod_dep=$_SESSION['cod_dep'];
//echo  "dep:".$cod_dep;
?>
<?php require_once('../Connections/snet.php'); ?>
<?php
// Load the common classes
require_once('../includes/common/KT_common.php');

// Load the common classes
require_once('../includes/jaxon/widgets/dtable/dtable.php');

// Make unified connection variable
$conn_snet = new KT_connection($snet, $database_snet); 

$dtable_DWAjaxTable1 = new dtable($conn_snet, 'obtener_hr', 'dtable_DWAjaxTable1', 'hojaruta');
$dtable_DWAjaxTable1->setUrl(KT_getFullUri());
$dtable_DWAjaxTable1->setMaxRows(10);
$dtable_DWAjaxTable1->addColumn("cod", "STRING_TYPE", "cod", "%");
$dtable_DWAjaxTable1->addColumn("procedencia", "STRING_TYPE", "procedencia", "%");
$dtable_DWAjaxTable1->addColumn("ref", "STRING_TYPE", "ref", "%");
$dtable_DWAjaxTable1->addColumn("nhojas", "NUMERIC_TYPE", "nhojas", "=");
$dtable_DWAjaxTable1->addColumn("nanexos", "STRING_TYPE", "nanexos", "%");
$dtable_DWAjaxTable1->addColumn("cont_destinos", "NUMERIC_TYPE", "cont_destinos", "=");
$dtable_DWAjaxTable1->setPK("cod", "NUMERIC_TYPE");
$dtable_DWAjaxTable1->setDefaultSortColumn('cod', 'DESC');
$dtable_DWAjaxTable1->Execute();

$dtable_DWAjaxTable1_filter_sql = $dtable_DWAjaxTable1->getFilter();
$dtable_DWAjaxTable1_order_sql = $dtable_DWAjaxTable1->getSorter();

//NeXTenesio3 Special List Recordset
$maxRows_obtener_hr = $dtable_DWAjaxTable1->getMaxRows();
$pageNum_obtener_hr = 0;
if (isset($_GET['pageNum_obtener_hr'])) {
  $pageNum_obtener_hr = $_GET['pageNum_obtener_hr'];
}
$startRow_obtener_hr = $pageNum_obtener_hr * $maxRows_obtener_hr;

$xcodigo_obtener_hr = "-1";
if (isset($_SESSION['cod_dep'])) {
  $xcodigo_obtener_hr = $_SESSION['cod_dep'];
}
$NXTFilter_obtener_hr = "1=1";
if (isset($dtable_DWAjaxTable1_filter_sql)) {
  $NXTFilter_obtener_hr = $dtable_DWAjaxTable1_filter_sql;
}
$NXTSort_obtener_hr = "cod DESC";
if (isset($dtable_DWAjaxTable1_order_sql)) {
  $NXTSort_obtener_hr = $dtable_DWAjaxTable1_order_sql;
}
mysql_select_db($database_snet, $snet);

$query_obtener_hr = sprintf("SELECT hojaruta.cod, hojaruta.einterna_id, hojaruta.eexterna_id, hojaruta.procedencia, hojaruta.`ref`, hojaruta.nhojas, hojaruta.nanexos, hojaruta.cont_destinos FROM hojaruta WHERE hojaruta.cod_depcreador='%s' AND  %s  ORDER BY  %s ", $xcodigo_obtener_hr,$NXTFilter_obtener_hr,$NXTSort_obtener_hr);
$query_limit_obtener_hr = sprintf("%s LIMIT %d, %d", $query_obtener_hr, $startRow_obtener_hr, $maxRows_obtener_hr);
$obtener_hr = mysql_query($query_limit_obtener_hr, $snet) or die(mysql_error());
$row_obtener_hr = mysql_fetch_assoc($obtener_hr);

if (isset($_GET['totalRows_obtener_hr'])) {
  $totalRows_obtener_hr = $_GET['totalRows_obtener_hr'];
} else {
  $all_obtener_hr = mysql_query($query_obtener_hr);
  $totalRows_obtener_hr = mysql_num_rows($all_obtener_hr);
}
$totalPages_obtener_hr = ceil($totalRows_obtener_hr/$maxRows_obtener_hr)-1;
//End NeXTenesio3 Special List Recordset

// AJAX Dynamic Table statistics
$dtable_DWAjaxTable1->setStartRow($startRow_obtener_hr);
$dtable_DWAjaxTable1->setPageNum($pageNum_obtener_hr);
$dtable_DWAjaxTable1->setTotalRows($totalRows_obtener_hr);
$dtable_DWAjaxTable1->setTotalPages($totalPages_obtener_hr);



?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Hojas de Ruta::Consulta</title>
<link href="../includes/jaxon/widgets/dtable/css/dtable.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../includes/kore/kore.js"></script>
<script type="text/javascript" src="../includes/jaxon/widgets/dtable/js/dtable.js"></script>
<style type="text/css">
<!--
.pendiente {
	background-color: #FFCC33;
	height: 15px;
	width: 80%;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #000000;
}
.procesado {
	background-color: #9AE7B3;
	height: 15px;
	width: 80%;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #000000;
}
.reingresado {
	background-color: #66FF00;
	height: 15px;
	width: 80%;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #000000;
}
-->
</style>
</head>

<body>
<form action="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterUri()); ?>" method="get" enctype="multipart/form-data" class="dtable" id="<?php echo $dtable_DWAjaxTable1->listName; ?>">
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
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('cod'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('cod'); ?>">Codigo</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('procedencia'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('procedencia'); ?>">Procedencia</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('ref'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('ref'); ?>">Referencia</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('nhojas'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('nhojas'); ?>">Hojas</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('nanexos'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('nanexos'); ?>">Anexos</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('cont_destinos'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('cont_destinos'); ?>">Estado</a></th>
            <th>&nbsp;</th>
          </tr>
          <?php 
  // Show IF Conditional region3
?>
          <tr class="filter">
            <th><input type="text" name="dtable_DWAjaxTable1_cod" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('cod')); ?>" size="10" maxlength="15" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_procedencia" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('procedencia')); ?>" size="30" maxlength="80" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_ref" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('ref')); ?>" size="40" maxlength="100" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_nhojas" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('nhojas')); ?>" size="8" maxlength="8" style="visibility:hidden"/></th>
            <th><input type="text" name="dtable_DWAjaxTable1_nanexos" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('nanexos')); ?>" size="10" maxlength="20" style="visibility:hidden"/></th>
            <th><input type="text" name="dtable_DWAjaxTable1_cont_destinos" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('cont_destinos')); ?>" size="20" maxlength="100" disabled="disabled" style="visibility:hidden"/></th>
            <th><input class="filterButton" type="submit" name="dtable_DWAjaxTable1" value="Filter" style="visibility:hidden"/></th>
          </tr>
          <?php 
  // endif Conditional region3
?>
        </thead>
        <tfoot>
          <tr>
            <td colspan="8"><?php $dtable = &$dtable_DWAjaxTable1; ?>
                <?php require("../includes/jaxon/widgets/dtable/nav/NAV_Text_Navigation.inc.php");?>
            </td>
          </tr>
        </tfoot>
        <tbody class="data">
          <?php if ($totalRows_obtener_hr == 0) { ?>
          <tr>
            <td colspan="8">No se encontraron registros .</td>
          </tr>
          <?PHP } ?>
          <?php if ($totalRows_obtener_hr > 0) { ?>
          <?php do { ?>
            <tr>
              <td><?php echo KT_FormatForList($row_obtener_hr['cod'], 20); ?></td>
              <td><?php echo KT_FormatForList($row_obtener_hr['procedencia'], 20); ?></td>
              <td><?php echo KT_FormatForList($row_obtener_hr['ref'], 20); ?></td>
              <td><?php echo KT_FormatForList($row_obtener_hr['nhojas'], 20); ?></td>
              <td><?php echo KT_FormatForList($row_obtener_hr['nanexos'], 20); ?></td>
              <td>
		        <?php 
			  if ($row_obtener_hr['cont_destinos']>1){ ?>
			  <div align="center" class="procesado">PROCESADO</div>
			  <?php
			    } else { // fin si es mayor a uno
				?>						 
			 <div align="center" class="pendiente">AUN NO SALE</div>
			 <?php
			       }//fin Si es mayor a 1...			       }			   
			  ?>
              </td>
              <td><a href="../content/reporte_hr.php?cod=<?php echo $row_obtener_hr['cod']; ?>">
              Reporte</a></td>
            </tr>
            <?php } while ($row_obtener_hr = mysql_fetch_assoc($obtener_hr)); ?>
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
mysql_free_result($obtener_hr);
?>
