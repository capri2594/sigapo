<?php 
session_name("LoginSIRC");
session_start();
?>
<?php require_once('Connections/snet.php'); ?>
<?php
// Load the common classes
require_once('includes/common/KT_common.php');

// Load the common classes
require_once('includes/jaxon/widgets/dtable/dtable.php');

// Make unified connection variable
$conn_snet = new KT_connection($snet, $database_snet); 

$dtable_DWAjaxTable1 = new dtable($conn_snet, 'entradas_internas', 'dtable_DWAjaxTable1', 'entradas');
$dtable_DWAjaxTable1->setUrl(KT_getFullUri());
$dtable_DWAjaxTable1->setMaxRows(6);
$dtable_DWAjaxTable1->addColumn("cite", "STRING_TYPE", "cite", "%");
$dtable_DWAjaxTable1->addColumn("ref", "STRING_TYPE", "ref", "%");
$dtable_DWAjaxTable1->addColumn("dep_remite", "STRING_TYPE", "dep_remite", "%");
$dtable_DWAjaxTable1->addColumn("fecha_doc", "DATE_TYPE", "fecha_doc", "=");
$dtable_DWAjaxTable1->setPK("cod_deprecibido", "STRING_TYPE");
$dtable_DWAjaxTable1->setDefaultSortColumn('fecha_doc', 'DESC');
$dtable_DWAjaxTable1->Execute();

$dtable_DWAjaxTable1_filter_sql = $dtable_DWAjaxTable1->getFilter();
$dtable_DWAjaxTable1_order_sql = $dtable_DWAjaxTable1->getSorter();

//NeXTenesio3 Special List Recordset
$maxRows_entradas_internas = $dtable_DWAjaxTable1->getMaxRows();
$pageNum_entradas_internas = 0;
if (isset($_GET['pageNum_entradas_internas'])) {
  $pageNum_entradas_internas = $_GET['pageNum_entradas_internas'];
}
$startRow_entradas_internas = $pageNum_entradas_internas * $maxRows_entradas_internas;

$coddep_entradas_internas = "-1";
if (isset($_SESSION['cod_dep'])) {
  $coddep_entradas_internas = $_SESSION['cod_dep'];
}
$NXTFilter_entradas_internas = "1=1";
if (isset($dtable_DWAjaxTable1_filter_sql)) {
  $NXTFilter_entradas_internas = $dtable_DWAjaxTable1_filter_sql;
}
$NXTSort_entradas_internas = "fecha_doc DESC";
if (isset($dtable_DWAjaxTable1_order_sql)) {
  $NXTSort_entradas_internas = $dtable_DWAjaxTable1_order_sql;
}
mysql_select_db($database_snet, $snet);

$query_entradas_internas = sprintf("SELECT cite, `ref`, einterna.dep_remite, einterna.fecha_doc, einterna.id_interna,einterna.HR FROM entradas, einterna WHERE entradas.id=einterna.entradas_id  AND entradas.cod_deprecibido = '%s' AND  %s ORDER BY %s ", $coddep_entradas_internas,$NXTFilter_entradas_internas,$NXTSort_entradas_internas);
$query_limit_entradas_internas = sprintf("%s LIMIT %d, %d", $query_entradas_internas, $startRow_entradas_internas, $maxRows_entradas_internas);
$entradas_internas = mysql_query($query_limit_entradas_internas, $snet) or die(mysql_error());
$row_entradas_internas = mysql_fetch_assoc($entradas_internas);

if (isset($_GET['totalRows_entradas_internas'])) {
  $totalRows_entradas_internas = $_GET['totalRows_entradas_internas'];
} else {
  $all_entradas_internas = mysql_query($query_entradas_internas);
  $totalRows_entradas_internas = mysql_num_rows($all_entradas_internas);
}
$totalPages_entradas_internas = ceil($totalRows_entradas_internas/$maxRows_entradas_internas)-1;
//End NeXTenesio3 Special List Recordset

mysql_select_db($database_snet, $snet);
$query_entradas_ex = "SELECT entradas.fecha_recibido, eexterna.cite, eexterna.`ref`, eexterna.org_remitente, eexterna.fecha_doc FROM entradas, eexterna WHERE entradas.id=eexterna.entradas_id AND entradas.cod_deprecibido = 'coddep'";
$entradas_ex = mysql_query($query_entradas_ex, $snet) or die(mysql_error());
$row_entradas_ex = mysql_fetch_assoc($entradas_ex);
$totalRows_entradas_ex = mysql_num_rows($entradas_ex);

// AJAX Dynamic Table statistics
$dtable_DWAjaxTable1->setStartRow($startRow_entradas_internas);
$dtable_DWAjaxTable1->setPageNum($pageNum_entradas_internas);
$dtable_DWAjaxTable1->setTotalRows($totalRows_entradas_internas);
$dtable_DWAjaxTable1->setTotalPages($totalPages_entradas_internas);
?><?php
// HEAD content
?>
<link href="includes/jaxon/widgets/tabset/css/tabset.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="includes/jaxon/widgets/tabset/js/tabset.js"></script>
<style type="text/css">
body {
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     background-color: #0f172a !important;
     color: #cbd5e1 !important;
     margin: 15px !important;
     padding: 0 !important;
}

/* Tabset Container */
#tabset_Buscar_entradas {
     width: 100% !important;
     max-width: 750px !important;
     margin: 0 auto !important;
     height: auto !important;
     background: transparent !important;
     border: none !important;
}

/* Tabs list bar */
div.tabset ul.tabset_tabs {
     display: flex !important;
     background-color: #1e293b !important;
     padding: 6px !important;
     border-radius: 8px 8px 0 0 !important;
     margin: 0 !important;
     list-style: none !important;
     border-bottom: 2px solid #2563eb !important;
     height: 38px !important;
     box-sizing: border-box !important;
     float: none !important;
}

/* Tab button list item */
div.tabset ul.tabset_tabs li.tab {
     background-image: none !important;
     background-color: transparent !important;
     border: none !important;
     margin: 0 4px 0 0 !important;
     padding: 0 !important;
     float: none !important;
     display: block !important;
     height: auto !important;
     top: 0 !important;
     margin-bottom: 0 !important;
}

/* Tab link */
div.tabset ul.tabset_tabs li.tab a {
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     background-image: none !important;
     background-color: transparent !important;
     border: none !important;
     color: #94a3b8 !important;
     line-height: normal !important;
     padding: 6px 14px !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     border-radius: 6px !important;
     margin: 0 !important;
     transition: background-color 0.2s, color 0.2s !important;
     float: none !important;
     display: block !important;
     outline: none !important;
}

div.tabset ul.tabset_tabs li.tab a:hover {
     color: #ffffff !important;
     background-color: rgba(255, 255, 255, 0.05) !important;
     text-decoration: none !important;
}

/* Selected Tab state override */
div.tabset ul.tabset_tabs li.selected {
     background-image: none !important;
     background-color: #2563eb !important;
     border: none !important;
     border-radius: 6px !important;
     top: 0 !important;
     margin-bottom: 0 !important;
     box-shadow: 0 2px 8px rgba(37, 99, 235, 0.4) !important;
     float: none !important;
     display: block !important;
     height: auto !important;
}

div.tabset ul.tabset_tabs li.selected a {
     background-image: none !important;
     background-color: transparent !important;
     color: #ffffff !important;
     line-height: normal !important;
     padding: 6px 14px !important;
     border-radius: 6px !important;
     margin: 0 !important;
     float: none !important;
     display: block !important;
}

/* Tab Content container wrapper */
div.tabset div.tabBody {
     background-color: #1e293b !important;
     border: 1px solid rgba(255, 255, 255, 0.1) !important;
     border-top: none !important;
     border-radius: 0 0 8px 8px !important;
     padding: 15px !important;
     height: auto !important;
     box-shadow: 0 4px 10px rgba(0,0,0,0.3) !important;
}

div.tabset div.tabBody div.tabContent {
     margin: 0 !important;
}

/* Iframe transparency and sizing */
iframe {
     border: none !important;
     background-color: transparent !important;
     width: 100% !important;
     height: 380px !important;
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
     box-sizing: border-box !important;
}

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
<link href="includes/jaxon/widgets/dtable/css/dtable.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="includes/jaxon/widgets/dtable/js/dtable.js"></script>

<?php
// Begin HTML content
?>
<div class="panel__content">
              <script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
    </script>
              <div class="panel__content">
                <div id="tabset_Buscar_entradas" class="tabset htmlrendering">
                  <ul class="tabset_tabs">
                    <li id="tabset_Buscar_entradastab0-tab" class="tab selected" ><a href="#">Correspondencias INTERNAS</a></li>
                    <li id="tabset_Buscar_entradastab1-tab" class="tab"><a href="#">Correspondencias EXTERNAS</a></li>
                    <li id="tabset_Buscar_entradastab2-tab" class="tab"><a href="#">HOJAS DE RUTA</a></li>
                  </ul>
                  <div id="tabset_Buscar_entradastab0-body" class="tabBody body_active">
                    <div class="tabContent" style="height:350px;"><br />
                        <form class="dtable" id="<?php echo $dtable_DWAjaxTable1->listName; ?>" action="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterUri()); ?>" method="get">
                          <div> <?php echo $dtable_DWAjaxTable1->beginList(); ?>
                              <table border="0" cellpadding="0" cellspacing="0">
                                <caption>
                                <?php
					$dtable = &$dtable_DWAjaxTable1;
				?>
                                <?php require("includes/jaxon/widgets/dtable/nav/NAV_Text_Statistics.inc.php");?>
                                </caption>
                                <thead>
                                  <tr>
                                    <th>&nbsp;</th>
                                    <th height="25" class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('cite'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('cite'); ?>">Cite</a></th>
                                    <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('ref'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('ref'); ?>">Referencia</a></th>
                                    <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('dep_remite'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('dep_remite'); ?>">Procedencia</a></th>
                                    <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('fecha_doc'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('fecha_doc'); ?>">Fech.Doc.</a></th>
                                  </tr>
                                  <?php 
  // Show IF Conditional region3
?>
                                  <tr class="filter">
                                    <th><input class="filterButton" type="submit" name="dtable_DWAjaxTable1" value="Buscar"/></th>
                                    <th width="50px"><input type="text" name="dtable_DWAjaxTable1_cite" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('cite')); ?>" size="16" maxlength="30" /></th>
                                    <th><input type="text" name="dtable_DWAjaxTable1_ref" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('ref')); ?>" size="45" maxlength="100" /></th>
                                    <th><input type="text" name="dtable_DWAjaxTable1_dep_remite" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('dep_remite')); ?>" size="20" maxlength="50" /></th>
                                    <th><input type="text" name="dtable_DWAjaxTable1_fecha_doc" value="<?php echo $dtable_DWAjaxTable1->getFilterValue('fecha_doc'); ?>" size="10" maxlength="10" /></th>
                                  </tr>
                                  <?php 
  // endif Conditional region3
?>
                                </thead>
                                <tfoot>
                                  <tr>
                                    <td colspan="6"><?php $dtable = &$dtable_DWAjaxTable1; ?>
                                        <?php require("includes/jaxon/widgets/dtable/nav/NAV_Text_Navigation.inc.php");?>
                                    </td>
                                  </tr>
                                </tfoot>
                                <tbody class="data">
                                  <?php if ($totalRows_entradas_internas == 0) { ?>
                                  <tr>
                                    <td colspan="6">No se encontraron registros que mostrar. Verifique e intente nuevamente. </td>
                                  </tr>
                                  <?PHP } ?>
                                  <?php if ($totalRows_entradas_internas > 0) { ?>
                                  <?php do { ?>
                                    <tr>
                                      <td><?php if ($row_entradas_internas['HR']!="") {?>
                                          <a id="<?php echo $ctrl->link_id() ?>" href="<?php
$ctrl->setParamValue("cod", $row_entradas_internas['HR']);
$ctrl->tooltip("Content", "detalles_entradas_in", "250", "180");
echo $ctrl->link("Content", "detalle_corresp_interna");
?>">Detalles</a>
                                          <?php } else {?>
                                        Sin HojaRuta<br />
                                        <img src="content/imagen/referencia.gif" alt="crear HR" longdesc="crear Hoja de Ruta"  onclick="MM_openBrWindow('content/CrearHOJARUTA(forzado).php?id=<?php echo $row_entradas_internas['id_interna']  ?>','hojaruta','scrollbars=yes,resizable=yes,width=850,height=450')"/>
                                        <?php } ?>
                                      </td>
                                      <td><?php echo KT_FormatForList($row_entradas_internas['cite'], 20); ?></td>
                                      <td><?php echo KT_FormatForList($row_entradas_internas['ref'], 60); ?></td>
                                      <td><?php echo KT_FormatForList($row_entradas_internas['dep_remite'], 50); ?></td>
                                      <td><?php echo KT_FormatForList($row_entradas_internas['fecha_doc'], 10); ?></td>
                                    </tr>
                                    <?php } while ($row_entradas_internas = mysql_fetch_assoc($entradas_internas)); ?>
                                  <?php }?>
                                </tbody>
                              </table>
                            <script type="text/javascript">
		new Widgets.DataTable("<?php echo $dtable_DWAjaxTable1->listName; ?>");
	            </script>
                              <?php echo $dtable_DWAjaxTable1->endList(); ?> </div>
                        </form>
                      <br />
                        <br />
                    </div>
                  </div>
                  <div id="tabset_Buscar_entradastab1-body" class="tabBody">
                    <div class="tabContent">
                      <iframe src="content/buscar_entradas_ex.php" name="ver_entradas_ex" width="100%" marginwidth="0" height="360px" marginheight="0" scrolling="no" frameborder="0"></iframe>
                    </div>
                  </div>
                  <div id="tabset_Buscar_entradastab2-body" class="tabBody">
                    <div class="tabContent">
                      <iframe src="content/buscar_entradas_hr.php" name="ver_entradas_ex" width="100%" marginwidth="0" height="360px" marginheight="0" scrolling="no" frameborder="0"></iframe>
                    </div>
                  </div>
                </div>
                <script type="text/javascript">
	var tabset_Buscar_entradas = new Widgets.Tabset('tabset_Buscar_entradas', null);
            </script>
                </p>
              </div>
          
</div>
<?php
// End HTML content
?>
<?php
mysql_free_result($entradas_internas);

mysql_free_result($entradas_ex);
?>