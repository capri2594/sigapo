<?php require_once('../includes/jaxon/widgets/request.php'); ?>
<?php // Widget region file. Do not remove this line. ?>
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

$maxRows_EnviadosInternos_CITE = 10;
$pageNum_EnviadosInternos_CITE = 0;
if (isset($_GET['pageNum_EnviadosInternos_CITE'])) {
  $pageNum_EnviadosInternos_CITE = $_GET['pageNum_EnviadosInternos_CITE'];
}
$startRow_EnviadosInternos_CITE = $pageNum_EnviadosInternos_CITE * $maxRows_EnviadosInternos_CITE;

$var_cite_EnviadosInternos_CITE = "-1";
if (isset($_POST['texto'])) {
  $var_cite_EnviadosInternos_CITE = $_POST['texto'];
}
mysql_select_db($database_snet, $snet);
$query_EnviadosInternos_CITE = sprintf("SELECT * FROM salinternas, salidas WHERE salidas.cite=salinternas.salidas_cite AND salidas.cite=%s", GetSQLValueString($var_cite_EnviadosInternos_CITE, "text"));
$query_limit_EnviadosInternos_CITE = sprintf("%s LIMIT %d, %d", $query_EnviadosInternos_CITE, $startRow_EnviadosInternos_CITE, $maxRows_EnviadosInternos_CITE);
$EnviadosInternos_CITE = mysql_query($query_limit_EnviadosInternos_CITE, $snet) or die(mysql_error());
$row_EnviadosInternos_CITE = mysql_fetch_assoc($EnviadosInternos_CITE);

if (isset($_GET['totalRows_EnviadosInternos_CITE'])) {
  $totalRows_EnviadosInternos_CITE = $_GET['totalRows_EnviadosInternos_CITE'];
} else {
  $all_EnviadosInternos_CITE = mysql_query($query_EnviadosInternos_CITE);
  $totalRows_EnviadosInternos_CITE = mysql_num_rows($all_EnviadosInternos_CITE);
}
$totalPages_EnviadosInternos_CITE = ceil($totalRows_EnviadosInternos_CITE/$maxRows_EnviadosInternos_CITE)-1;
?><?php
// HEAD content
?>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
<style type="text/css">
<!--
.Estilo1 {font-size: 9px}
.Estilo4 {
	font-size: 11px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
.Estilo5 {
	font-size: 12px;
	font-family: Arial, Helvetica, sans-serif;
}
.Estilo6 {font-size: 12px}
-->
</style>


<?php
// Begin HTML content
?>
<div class="panel__content">
<table width="100%" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"><table width="100%" border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><div align="center">
          <table width="400" align="center" cellspacing="5">
            <tr>
              <td bgcolor="#B9E0FD">Recibir:</td>
              <td><label>
                <input type="radio" name="GrupoOpciones1" value="hruta" id="b_hruta" checked/>
                Hoja de Ruta</label></td>
              <td><label for=all>
                <input type="radio" name="GrupoOpciones1" value="cite" id="b_cite" />
                Cite de Correspondencia </label></td>
            </tr>
          </table>
        </div></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><div align="center"><span id="sprytextfield1">
          <input name="texto" type="text" id="texto" value="<?php echo $_POST['texto']; ?>" size="60" />
          <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></div></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><div align="center">
          <table width="300" border="0" align="center" cellpadding="0" cellspacing="7">
              <tr>
                <td>
                  <div align="center">
                    <input type="submit" name="button" id="button" value="Buscar" />
                  </div></td>
                <td><div align="center">
                  <input name="button2" type="button" id="button2" onClick="MM_goToURL('self','RecibirInternosAvanzado.php');return document.MM_returnValue" value="Recibido Avanzado" />
                </div></td>
              </tr>
                  </table>
        </div></td>
        <td>&nbsp;</td>
      </tr>
    </table>
    </form></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
      <?php if ($totalRows_EnviadosInternos_CITE == 0) { // Show if recordset empty ?>
        <tr>
          <td colspan="3">El numero de CITE no se encuentra registrado. Verifique e intente nuevamente.</td>
        </tr>
        <?php } // Show if recordset empty ?>
      <?php if ($totalRows_EnviadosInternos_CITE > 0) { // Show if recordset not empty ?>
        <?php do { ?>
          <tr>
            <td><span class="Estilo5"><?php echo $row_EnviadosInternos_CITE['salidas_cite']; ?></span></td>
            <td><p class="Estilo4"><span class="Estilo6">REF.-<?php echo $row_EnviadosInternos_CITE['ref']; ?></span><br>
               enviado el&nbsp;<?php echo $row_EnviadosInternos_CITE['fecha_envio']; ?> <br>
                  de:&nbsp;<?php echo $row_EnviadosInternos_CITE['fun_remitente']; ?>&lt;<?php echo $row_EnviadosInternos_CITE['dep_remitente']; ?>&gt;&nbsp;para::<?php echo $row_EnviadosInternos_CITE['fun_destino']; ?>&lt;<?php echo $row_EnviadosInternos_CITE['dep_destino']; ?>&gt;</p>
              </td>
            <td><a href="javascript:return(0);"><div align="center" onClick="detalles.submit();"><img src="../img/iconos/guardarCorresp.gif" width="40" height="40"><span class="Estilo1"><br>
              MARCAR Recibido</span></div></a></td>
          </tr>
          <?php } while ($row_EnviadosInternos_CITE = mysql_fetch_assoc($EnviadosInternos_CITE)); ?>
        <?php } // Show if recordset not empty ?>
<tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><form action="RecibirInternos1.php" method="post" name="detalles" id="detalles">
          <span id="sprytextfield2">
            <input name="cite" type="text" id="cite" value="<?php echo $_POST['texto']; ?>">
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span>
        </form>
        </td>
      </tr>
    </table></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><iframe src="hora_servidor/hora_servidor2.html" frameborder="0" marginwidth="0" width="100%" height="300px" scrolling="no"></iframe></td>
    <td>&nbsp;</td>
  </tr>
</table>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
//-->
</script>


</div>


<?php
// End HTML content
?>
<?php
mysql_free_result($EnviadosInternos_CITE);
?>