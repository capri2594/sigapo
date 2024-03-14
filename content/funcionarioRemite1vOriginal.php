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

// Load the common classes
require_once('../includes/common/KT_common.php');

// Load the common classes
require_once('../includes/jaxon/widgets/dtable/dtable.php');

// Make unified connection variable
$conn_snet = new KT_connection($snet, $database_snet); 

$dtable_DWAjaxTable1 = new dtable($conn_snet, 'funRemitentes', 'dtable_DWAjaxTable1', 'dependencia');
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
$maxRows_funRemitentes = $dtable_DWAjaxTable1->getMaxRows();
$pageNum_funRemitentes = 0;
if (isset($_GET['pageNum_funRemitentes'])) {
  $pageNum_funRemitentes = $_GET['pageNum_funRemitentes'];
}
$startRow_funRemitentes = $pageNum_funRemitentes * $maxRows_funRemitentes;

$NXTFilter_funRemitentes = "1=1";
if (isset($dtable_DWAjaxTable1_filter_sql)) {
  $NXTFilter_funRemitentes = $dtable_DWAjaxTable1_filter_sql;
}
$NXTSort_funRemitentes = "nombre";
if (isset($dtable_DWAjaxTable1_order_sql)) {
  $NXTSort_funRemitentes = $dtable_DWAjaxTable1_order_sql;
}
mysql_select_db($database_snet, $snet);

$query_funRemitentes = sprintf("SELECT funcionario.nombre, funcionario.cargo, dependencia.nombredep FROM funcionario, dependencia WHERE funcionario.dependencia_cod=dependencia.cod AND  %s  ORDER BY  %s ", $NXTFilter_funRemitentes,$NXTSort_funRemitentes);
$query_limit_funRemitentes = sprintf("%s LIMIT %d, %d", $query_funRemitentes, $startRow_funRemitentes, $maxRows_funRemitentes);
$funRemitentes = mysql_query($query_limit_funRemitentes, $snet) or die(mysql_error());
$row_funRemitentes = mysql_fetch_assoc($funRemitentes);

if (isset($_GET['totalRows_funRemitentes'])) {
  $totalRows_funRemitentes = $_GET['totalRows_funRemitentes'];
} else {
  $all_funRemitentes = mysql_query($query_funRemitentes);
  $totalRows_funRemitentes = mysql_num_rows($all_funRemitentes);
}
$totalPages_funRemitentes = ceil($totalRows_funRemitentes/$maxRows_funRemitentes)-1;
//End NeXTenesio3 Special List Recordset

mysql_select_db($database_snet, $snet);
$query_funremite = "SELECT funcionario.nombre, funcionario.cargo FROM funcionario";
$funremite = mysql_query($query_funremite, $snet) or die(mysql_error());
$row_funremite = mysql_fetch_assoc($funremite);
$totalRows_funremite = mysql_num_rows($funremite);

// AJAX Dynamic Table statistics
$dtable_DWAjaxTable1->setStartRow($startRow_funRemitentes);
$dtable_DWAjaxTable1->setPageNum($pageNum_funRemitentes);
$dtable_DWAjaxTable1->setTotalRows($totalRows_funRemitentes);
$dtable_DWAjaxTable1->setTotalPages($totalPages_funRemitentes);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Buscando Funcionarios</title>
<script type="text/javascript" src="../includes/kore/kore.js"></script>
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
	  window.opener.self.document.getElementById('tr_nom').value=objnom.innerHTML;
	  window.opener.self.document.getElementById('tr_dep').value=objdep.innerHTML;
	  //alert("se ha insertado correctamente....");
	  window.top.close();
	}else
	alert("SIRC error: al insertar registro");
}
//-->
</script>
<link href="../includes/jaxon/widgets/dtable/css/dtable.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../includes/jaxon/widgets/dtable/js/dtable.js"></script>
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
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('nombre'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('nombre'); ?>">Nombre y Apellidos</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('cargo'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('cargo'); ?>">Cargo</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('nombredep'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('nombredep'); ?>">Dependencia</a></th>
            <th>&nbsp;</th>
          </tr>
          <?php 
  // Show IF Conditional region3
?>
          <tr class="filter">
            <th><input type="text" name="dtable_DWAjaxTable1_nombre" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('nombre')); ?>" size="20" maxlength="20" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_cargo" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('cargo')); ?>" size="20" maxlength="20" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_nombredep" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('nombredep')); ?>" size="20" maxlength="20" /></th>
            <th><input class="filterButton" type="submit" name="dtable_DWAjaxTable1" value="Filtrar"/></th>
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
          <?php if ($totalRows_funRemitentes == 0) { ?>
          <tr>
            <td colspan="5">No se encontraron registros para mostrar.</td>
          </tr>
          <?PHP } ?>
          <?php if ($totalRows_funRemitentes > 0) { $num=0; ?>
<?php do { ?>
            <tr>
              <td id="nom<?php echo $num?>"><?php echo KT_FormatForList($row_funRemitentes['nombre'], 20); ?></td>
              <td><?php echo KT_FormatForList($row_funRemitentes['cargo'], 20); ?></td>
              <td id="dep<?php echo $num?>"><?php echo KT_FormatForList($row_funRemitentes['nombredep'], 20); ?></td>
              <td><input type="checkbox" name="checkbox" id="checkbox" value="checkbox"  onclick="JJ_insertar('nom<?php echo $num?>','dep<?php echo $num?>');"/>
                <a href="javascript:void(0);" onclick="JJ_insertar('nom<?php echo $num?>','dep<?php echo $num?>');">seleccionar</a></td>
            </tr>
            <?php $num=$num+1;
			} while ($row_funRemitentes = mysql_fetch_assoc($funRemitentes)); ?>
          
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
mysql_free_result($funRemitentes);

mysql_free_result($funremite);
?>

