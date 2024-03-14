<?php require_once('Connections/snet.php'); ?>
<?php
// Load the SuggestTextBox classes
require_once('includes/jaxon/widgets/suggest/suggest.php'); 

// Load the rating classes
require_once('includes/jaxon/widgets/editinplace/editinplace.php');

$edit1 = new EditInPlace("edit1");
$edit1->setConnection("snet");
$edit1->setTable("funcionario");
$edit1->setPrimaryKey("nombre");
$edit1->setEditField("nombre", "STRING_TYPE");
$edit1->setEnabledCondition("");

$suggest1 = new Suggest("suggest1");
$suggest1->setRecordset("rsSuggest1");
$suggest1->setNumberOfSuggestions(3);
$suggest1->setSuggestField("nombredep");

$suggestParam_rsSuggest1 = "-1";
if (isset($_GET['suggest1_choice'])) {
  $suggestParam_rsSuggest1 = (get_magic_quotes_gpc()) ? $_GET['suggest1_choice'] : addslashes($_GET['suggest1_choice']);
}
mysql_select_db($database_snet, $snet);
$query_rsSuggest1 = sprintf("SELECT * FROM dependencia WHERE nombredep LIKE '%s%%'", $suggestParam_rsSuggest1);
$rsSuggest1 = mysql_query($query_rsSuggest1, $snet) or die(mysql_error());
$row_rsSuggest1 = mysql_fetch_assoc($rsSuggest1);
$totalRows_rsSuggest1 = mysql_num_rows($rsSuggest1);

$ajax_service = new AjaxService();

$ajax_service->exportMethod('edit1', 'updateValue'); 

$ajax_service->exportMethod('suggest1', 'getSuggestedEntries'); 

$ajax_service->handleAjaxRequest();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="includes/jaxon/widgets/editinplace/css/editinplace.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="includes/kore/kore.js"></script>
<script type="text/javascript" src="includes/jaxon/widgets/editinplace/js/editinplace.js"></script>
<?php
  echo $ajax_service->renderJavascriptStubs();
?>
<link href="includes/jaxon/widgets/suggest/css/suggest.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="includes/jaxon/widgets/suggest/js/suggest.js"></script>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="100%" border="1" cellspacing="0" cellpadding="0">
    <tr>
      <td>nombre </td>
      <td><input type="text" name="textfield" /></td>
    </tr>
    <tr>
      <td>curso</td>
      <td><input name="textfield2" type="text" id="textfield2" />
        <?php echo $suggest1->renderSuggestions("textfield2"); ?> </td>
    </tr>
    <tr>
      <td>gestion</td>
      <td><?php
echo $edit1->editForId("nombre", "nombre");
?></td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
mysql_free_result($rsSuggest1);
?>
