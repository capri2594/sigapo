<?php require_once('../../Connections/snet.php'); ?>
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

$texto_listar_cod_dep = "-1";
if (isset($_POST['nombre'])) {
  $texto_listar_cod_dep = $_POST['nombre'];
}
mysql_select_db($database_snet, $snet);
$query_listar_cod_dep = sprintf("SELECT dependencia.cod FROM dependencia WHERE dependencia.cod LIKE %s ORDER BY dependencia.cod ASC LIMIT 0,50", GetSQLValueString($texto_listar_cod_dep."%", "text"));
$listar_cod_dep = mysql_query($query_listar_cod_dep, $snet) or die(mysql_error());
$row_listar_cod_dep = mysql_fetch_assoc($listar_cod_dep);
$totalRows_listar_cod_dep = mysql_num_rows($listar_cod_dep);
?>
  <ul><?php if ($totalRows_listar_cod_dep>0){ ?>
    <?php do { ?>
      <li><?php echo $row_listar_cod_dep['cod']; ?></li>
      <?php } while ($row_listar_cod_dep = mysql_fetch_assoc($listar_cod_dep)); ?>
      <?php }?>
  </ul>
<?php
mysql_free_result($listar_cod_dep);
?>
