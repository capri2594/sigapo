<?php require_once('../Connections/snet.php'); ?>
<?php
// Load the common classes
require_once('../includes/common/KT_common.php');

// Load the common classes
require_once('../includes/jaxon/widgets/dtable/dtable.php');

// Make unified connection variable
$conn_snet = new KT_connection($snet, $database_snet); 

$dtable_DWAjaxTable1 = new dtable($conn_snet, 'FunDestino', 'dtable_DWAjaxTable1', 'funcionario');
$dtable_DWAjaxTable1->setUrl(KT_getFullUri());
$dtable_DWAjaxTable1->setMaxRows(10);
$dtable_DWAjaxTable1->addColumn("nombre", "STRING_TYPE", "nombre", "%");
$dtable_DWAjaxTable1->addColumn("cargo", "STRING_TYPE", "cargo", "%");
$dtable_DWAjaxTable1->addColumn("nombredep", "STRING_TYPE", "nombredep", "%");
$dtable_DWAjaxTable1->setPK("nombre", "STRING_TYPE");
$dtable_DWAjaxTable1->setDefaultSortColumn('nombre', 'ASC');
$dtable_DWAjaxTable1->Execute();

$dtable_DWAjaxTable1_filter_sql = $dtable_DWAjaxTable1->getFilter();
$dtable_DWAjaxTable1_order_sql = $dtable_DWAjaxTable1->getSorter();

//NeXTenesio3 Special List Recordset
$maxRows_FunDestino = $dtable_DWAjaxTable1->getMaxRows();
$pageNum_FunDestino = 0;
if (isset($_GET['pageNum_FunDestino'])) {
  $pageNum_FunDestino = $_GET['pageNum_FunDestino'];
}
$startRow_FunDestino = $pageNum_FunDestino * $maxRows_FunDestino;

$NXTFilter_FunDestino = "1=1";
if (isset($dtable_DWAjaxTable1_filter_sql)) {
  $NXTFilter_FunDestino = $dtable_DWAjaxTable1_filter_sql;
}
$NXTSort_FunDestino = "nombre";
if (isset($dtable_DWAjaxTable1_order_sql)) {
  $NXTSort_FunDestino = $dtable_DWAjaxTable1_order_sql;
}
mysql_select_db($database_snet, $snet);

$query_FunDestino = sprintf("SELECT nombre, cargo, dependencia.nombredep, funcionario.dependencia_cod FROM funcionario, dependencia WHERE funcionario.dependencia_cod=dependencia.cod AND  %s  ORDER BY  %s ", $NXTFilter_FunDestino,$NXTSort_FunDestino);
$query_limit_FunDestino = sprintf("%s LIMIT %d, %d", $query_FunDestino, $startRow_FunDestino, $maxRows_FunDestino);
$FunDestino = mysql_query($query_limit_FunDestino, $snet) or die(mysql_error());
$row_FunDestino = mysql_fetch_assoc($FunDestino);

if (isset($_GET['totalRows_FunDestino'])) {
  $totalRows_FunDestino = $_GET['totalRows_FunDestino'];
} else {
  $all_FunDestino = mysql_query($query_FunDestino);
  $totalRows_FunDestino = mysql_num_rows($all_FunDestino);
}
$totalPages_FunDestino = ceil($totalRows_FunDestino/$maxRows_FunDestino)-1;
//End NeXTenesio3 Special List Recordset

// AJAX Dynamic Table statistics
$dtable_DWAjaxTable1->setStartRow($startRow_FunDestino);
$dtable_DWAjaxTable1->setPageNum($pageNum_FunDestino);
$dtable_DWAjaxTable1->setTotalRows($totalRows_FunDestino);
$dtable_DWAjaxTable1->setTotalPages($totalPages_FunDestino);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="../includes/jaxon/widgets/dtable/css/dtable.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.over{
 background-color:
 cursor:hand;
	background-color: #B8BDE4;
	cursor: hand;
 }
body {
	font-size: 12px;
	padding: 0px;
	margin: 0px;
}
.normal{
  background-color:#FFFFFF;
}
</style>
<script type="text/javascript" src="../includes/kore/kore.js"></script>
<script type="text/javascript" src="../includes/jaxon/widgets/dtable/js/dtable.js"></script>
<script type="text/javascript">
function JJ_insertar(nomX,depX) { //v9.0
   //alert('nomX'+nomX);
   //alert('document.getElementById(nomX)='+document.getElementById(nomX));
   //alert('eval (nomX):'+eval(nomX));
   //nom=eval(nomX);
   //alert('innerHTML:'+document.getElementById(nom).innerHTML);
    with (document) 
	if (getElementById && ((objnom=getElementById(nomX))!=null)&& ((objdep=getElementById(depX))!=null)) 
	{ 
      //alert('nom='+objnom.innerHTML+' '+'dep='+objdep.innerHTML);
	  //alert(window.opener.parent.document.title);
	  //alert(window.opener.parent.document.getElementById('tr_nom').value);
	  //alert("que vamos a hacer");
	  //alert(top.document.formEInterno.getElementById('tr_nom').value);
	  //rescatar valores de la variables del formulario de esta pagina.
	  //Insertando valores.... a la ventana padre.
	  //alert('title parent:'+window.opener.parent.document.title);
	  //alert('title top:'+window.opener.top.document.title);
	  //alert('title self:'+window.opener.self.document.title);
	  //alert('title self:'+window.opener.self.document.getElementById('tr_nom').value);
	  /*window.opener.parent.document.getElementById('tr_nom').value=objnom.innerHTML;
	  window.opener.parent.document.getElementById('tr_dep').value=objdep.innerHTML;*/
	  //alert(window.opener.self.document.getElementById('fun_remite').innerHTML);
	  //alert(objnom.innerHTML);
	  window.opener.self.document.getElementById('fun_destino').innerHTML=objnom.innerHTML;
	  window.opener.self.document.getElementById('dep_destino').innerHTML=objdep.innerHTML;
	  //alert("se ha insertado correctamente....");
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
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('nombredep'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('nombredep'); ?>">Unidad/Dependencia</a></th>
            <th>&nbsp;</th>
          </tr>
          <?php 
  // Show IF Conditional region3
?>
          <tr class="filter">
            <th><input type="text" name="dtable_DWAjaxTable1_nombre" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('nombre')); ?>" size="30" maxlength="20" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_cargo" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('cargo')); ?>" size="20" maxlength="20" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_nombredep" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('nombredep')); ?>" size="30" maxlength="20" /></th>
            <th><input class="filterButton" type="submit" name="dtable_DWAjaxTable1" value="Buscar"/></th>
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
          <?php if ($totalRows_FunDestino == 0) { ?>
          <tr>
            <td colspan="5">No se encontraron datos que mostrar.<br />
              Vuelva a intentarlo. </td>
          </tr>
          <?PHP } ?>
          <?php if ($totalRows_FunDestino > 0) { $num=0;?>
          <?php do { ?>
            <tr onmousemove="this.className='over';" onmouseout="this.className='normal';" onclick="JJ_insertar('nom<?php echo $num?>','dep<?php echo $num?>');">
              <td id="nom<?php echo $num?>"><?php echo KT_FormatForList($row_FunDestino['nombre'], 30); ?></td>
              <td><?php echo KT_FormatForList($row_FunDestino['cargo'], 20); ?></td>
              <td id="dep<?php echo $num?>"><?php echo KT_FormatForList($row_FunDestino['nombredep'], 30); ?></td>
              <td><a href="javascript:void(0);" onclick="JJ_insertar('nom<?php echo $num?>','dep<?php echo $num?>');">SELECCIONAR</a></td>
            </tr>
            <?php $num=$num+1;} while ($row_FunDestino = mysql_fetch_assoc($FunDestino)); ?>
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
mysql_free_result($FunDestino);
?>
