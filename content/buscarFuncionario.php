<?php require_once('../Connections/snet.php'); ?>
<?php
// Load the common classes
require_once('../includes/common/KT_common.php');

// Load the common classes
require_once('../includes/jaxon/widgets/dtable/dtable.php');

// Make unified connection variable
$conn_snet = new KT_connection($snet, $database_snet); 

$dtable_DWAjaxTable1 = new dtable($conn_snet, 'funcionarios', 'dtable_DWAjaxTable1', 'dependencia');
$dtable_DWAjaxTable1->setUrl(KT_getFullUri());
$dtable_DWAjaxTable1->setMaxRows(10);
$dtable_DWAjaxTable1->addColumn("nombre", "STRING_TYPE", "nombre", "%");
$dtable_DWAjaxTable1->addColumn("cargo", "STRING_TYPE", "cargo", "%");
$dtable_DWAjaxTable1->addColumn("cod", "STRING_TYPE", "cod", "%");
$dtable_DWAjaxTable1->setPK("nombre", "STRING_TYPE");
$dtable_DWAjaxTable1->setDefaultSortColumn('nombre', 'ASC');
$dtable_DWAjaxTable1->Execute();

$dtable_DWAjaxTable1_filter_sql = $dtable_DWAjaxTable1->getFilter();
$dtable_DWAjaxTable1_order_sql = $dtable_DWAjaxTable1->getSorter();

//NeXTenesio3 Special List Recordset
$maxRows_funcionarios = $dtable_DWAjaxTable1->getMaxRows();
$pageNum_funcionarios = 0;
if (isset($_GET['pageNum_funcionarios'])) {
  $pageNum_funcionarios = $_GET['pageNum_funcionarios'];
}
$startRow_funcionarios = $pageNum_funcionarios * $maxRows_funcionarios;

$NXTFilter_funcionarios = "1=1";
if (isset($dtable_DWAjaxTable1_filter_sql)) {
  $NXTFilter_funcionarios = $dtable_DWAjaxTable1_filter_sql;
}
$NXTSort_funcionarios = "nombre";
if (isset($dtable_DWAjaxTable1_order_sql)) {
  $NXTSort_funcionarios = $dtable_DWAjaxTable1_order_sql;
}
mysql_select_db($database_snet, $snet);

$query_funcionarios = sprintf("SELECT funcionario.nombre, funcionario.cargo, dependencia.cod FROM funcionario, dependencia WHERE funcionario.dependencia_cod=dependencia.cod AND  %s  ORDER BY  %s ", $NXTFilter_funcionarios,$NXTSort_funcionarios);
$query_limit_funcionarios = sprintf("%s LIMIT %d, %d", $query_funcionarios, $startRow_funcionarios, $maxRows_funcionarios);
$funcionarios = mysql_query($query_limit_funcionarios, $snet) or die(mysql_error());
$row_funcionarios = mysql_fetch_assoc($funcionarios);

if (isset($_GET['totalRows_funcionarios'])) {
  $totalRows_funcionarios = $_GET['totalRows_funcionarios'];
} else {
  $all_funcionarios = mysql_query($query_funcionarios);
  $totalRows_funcionarios = mysql_num_rows($all_funcionarios);
}
$totalPages_funcionarios = ceil($totalRows_funcionarios/$maxRows_funcionarios)-1;
//End NeXTenesio3 Special List Recordset

// AJAX Dynamic Table statistics
$dtable_DWAjaxTable1->setStartRow($startRow_funcionarios);
$dtable_DWAjaxTable1->setPageNum($pageNum_funcionarios);
$dtable_DWAjaxTable1->setTotalRows($totalRows_funcionarios);
$dtable_DWAjaxTable1->setTotalPages($totalPages_funcionarios);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="../includes/jaxon/widgets/dtable/css/dtable.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../includes/kore/kore.js"></script>
<script type="text/javascript" src="../includes/jaxon/widgets/dtable/js/dtable.js"></script>
<script type="text/javascript">
function JJ_insertar() { //v9.0
  
    with (document) 
	if (getElementById && ((objnom=getElementById('nom'))!=null)&& ((objdep=getElementById('dep'))!=null)) 
	{ 
      alert('nom='+objnom.innerHTML+' '+'dep='+objdep.innerHTML);
	  //alert(window.opener.parent.document.title);
	  //alert(window.opener.parent.document.getElementById('tr_nom').value);
	  //alert("que vamos a hacer");
	  //alert(top.document.formEInterno.getElementById('tr_nom').value);
	  //rescatar valores de la variables del formulario de esta pagina.
	  //Insertando valores.... a la ventana padre.
	  window.opener.parent.document.getElementById('tr_nom').value=objnom.innerHTML;
	  window.opener.parent.document.getElementById('tr_dep').value=objdep.innerHTML;
	  alert("se ha insertado correctamente....");
	  window.top.close();
	}else
	alert("SIRC error: al insertar registro");
}
//-->
</script>
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
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('nombre'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('nombre'); ?>">Nombre</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('cargo'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('cargo'); ?>">Cargo</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('cod'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('cod'); ?>">Dependencia/Unidad</a></th>
            <th>&nbsp;</th>
          </tr>
          <?php 
  // Show IF Conditional region3
?>
          <tr class="filter">
            <th><input type="text" name="dtable_DWAjaxTable1_nombre" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('nombre')); ?>" size="30" maxlength="20" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_cargo" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('cargo')); ?>" size="12" maxlength="20" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_cod" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('cod')); ?>" size="20" maxlength="20" /></th>
            <th><input class="filterButton" type="submit" name="dtable_DWAjaxTable1" value="Filter"/></th>
          </tr>
          <?php 
  // endif Conditional region3
?>
        </thead>
        <tfoot>
          <tr>
            <td colspan="5"><?php $dtable = &$dtable_DWAjaxTable1; ?>
                <?php require("../includes/jaxon/widgets/dtable/nav/NAV_Text_Navigation.inc.php");?>
            </td>
          </tr>
        </tfoot>
        <tbody class="data">
          <?php if ($totalRows_funcionarios == 0) { ?>
          <tr>
            <td colspan="5">The table is empty or the filter you've selected is too restrictive.</td>
          </tr>
          <?PHP } ?>
          <?php if ($totalRows_funcionarios > 0) { ?>
          <?php do { ?>
            <tr>
              <td id="nom"><?php echo KT_FormatForList($row_funcionarios['nombre'], 30); ?></td>
              <td><?php echo KT_FormatForList($row_funcionarios['cargo'], 12); ?></td>
              <td id="dep"><?php echo KT_FormatForList($row_funcionarios['cod'], 20); ?></td>
              <td><a href="?detallle=">
                <input type="checkbox" name="checkbox" value="checkbox" onclick="JJ_insertar();"/>
              </a></td>
            </tr>
            <?php } while ($row_funcionarios = mysql_fetch_assoc($funcionarios)); ?>
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
mysql_free_result($funcionarios);
?>
