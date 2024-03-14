<?php 
session_name("LoginSIRC");
session_start();
header("Content-type: text/xml; charset=utf-8");

$_SESSION['hoy']=date("Y-m-d");

?>
<?php 
 echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
?>

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

$colname_mis_recibidos = "-1";
if (isset($_SESSION['cod_dep'])) {
  $colname_mis_recibidos = $_SESSION['cod_dep'];
}

$hoy_mis_recibidos = "-1";
if (isset($_SESSION['hoy'])) {
  $hoy_mis_recibidos = $_SESSION['hoy'];
}

//$hoy_mis_recibidos = date("Y-m-d");

mysql_select_db($database_snet, $snet);
$query_mis_recibidos = sprintf("SELECT * FROM entradas, einterna WHERE entradas.id=einterna.entradas_id AND entradas.cod_deprecibido=%s  AND entradas.fecha_recibido>=%s", GetSQLValueString($colname_mis_recibidos, "text"),GetSQLValueString($hoy_mis_recibidos, "date"));
$mis_recibidos = mysql_query($query_mis_recibidos, $snet) or die(mysql_error());
$row_mis_recibidos = mysql_fetch_assoc($mis_recibidos);
$totalRows_mis_recibidos = mysql_num_rows($mis_recibidos);

$colname_mostrar_externos = "-1";
if (isset($_SESSION['cod_dep'])) {
  $colname_mostrar_externos = $_SESSION['cod_dep'];
}
$hoy_mostrar_externos = "-1";
if (isset($_SESSION['hoy'])) {
  $hoy_mostrar_externos = $_SESSION['hoy'];
}
mysql_select_db($database_snet, $snet);
$query_mostrar_externos = sprintf("SELECT * FROM entradas, eexterna WHERE entradas.id=eexterna.entradas_id AND entradas.cod_deprecibido=%s  AND entradas.fecha_recibido>=%s", GetSQLValueString($colname_mostrar_externos, "text"),GetSQLValueString($hoy_mostrar_externos, "date"));
$mostrar_externos = mysql_query($query_mostrar_externos, $snet) or die(mysql_error());
$row_mostrar_externos = mysql_fetch_assoc($mostrar_externos);
$totalRows_mostrar_externos = mysql_num_rows($mostrar_externos);

$colname_mis_hojasrutas = "-1";
if (isset($_SESSION['cod_dep'])) {
  $colname_mis_hojasrutas = $_SESSION['cod_dep'];
}
$hoy_mis_hojasrutas = "-1";
if (isset($_SESSION['hoy'])) {
  $hoy_mis_hojasrutas = $_SESSION['hoy'];
}
mysql_select_db($database_snet, $snet);
$query_mis_hojasrutas = sprintf("SELECT * FROM entradas, derivacion, hojaruta WHERE entradas.id=derivacion.entradas_id AND entradas.cod_deprecibido=%s  AND entradas.fecha_recibido>=%s  AND derivacion.hojaruta_cod=hojaruta.cod AND derivacion.proveido = 'URGENTE'", GetSQLValueString($colname_mis_hojasrutas, "text"),GetSQLValueString($hoy_mis_hojasrutas, "date"));
$mis_hojasrutas = mysql_query($query_mis_hojasrutas, $snet) or die(mysql_error());
$row_mis_hojasrutas = mysql_fetch_assoc($mis_hojasrutas);
$totalRows_mis_hojasrutas = mysql_num_rows($mis_hojasrutas);
 

function parsear($texto){
  $modif=str_replace("&","&amp;",utf8_encode($texto));
  return ($modif);
}

 ?>
  <datos>
    <sorttable>
      <rowname>
        <row>
          <hruta>Hoja Ruta</hruta>
          <fecha_ing>Fec.Ingreso</fecha_ing>
          <proc>Procedencia</proc>
          <!--<cite_fecha>Cite / Fecha</cite_fecha>-->
          <hojas>hoj.</hojas>
          
          <!--<anexos>Anexos</anexos>-->
          <ref>Referencia</ref>
          <recibido>Recibido</recibido>
          <!--<obs>Observ.</obs>-->
          <proveido>proveido</proveido>
        </row>
      </rowname>
      <rowset>
        <?php if ($totalRows_mis_recibidos > 0) { // Show if recordset not empty ?>
          <?php do { ?>
            <row>
              <hruta>
                <?php if ($row_mis_recibidos['HR']!="")echo $row_mis_recibidos['HR'];else echo "s/n"; ?>
              </hruta>
              <fecha_ing><?php echo $row_mis_recibidos['fecha_recibido']; ?></fecha_ing>
              <proc><?php echo parsear($row_mis_recibidos['dep_remite']); ?></proc>
              <!--<cite_fecha><?php //echo parsear($row_mis_recibidos['cite']); ?> (<?php echo $row_mis_recibidos['fecha_doc']; ?>)</cite_fecha>-->
              <hojas type="number"><?php echo $row_mis_recibidos['nhojas']; ?></hojas>
              
              <!--<anexos><?php //echo parsear($row_mis_recibidos['anexos']); ?></anexos>-->
              <ref><?php echo parsear($row_mis_recibidos['ref']); ?></ref>
              <recibido><?php echo $row_mis_recibidos['fun_recibido']; ?></recibido>
              <!--<obs><?php //echo parsear($row_mis_recibidos['adjuntos']); ?></obs>-->
              <proveido><?php echo parsear($row_mis_recibidos['proveido']); ?></proveido>
            </row>
            <?php } while ($row_mis_recibidos = mysql_fetch_assoc($mis_recibidos)); ?>
          <?php } // Show if recordset not empty ?>
        <?php if ($totalRows_mostrar_externos > 0) { // Show if recordset not empty ?>
          <?php do { ?>
            <row>
              <hruta>
                <?php if ($row_mostrar_externos['HR']!="")echo $row_mostrar_externos['HR'];else echo "s/n"; ?>
              </hruta>
              <fecha_ing><?php echo $row_mostrar_externos['fecha_recibido']; ?></fecha_ing>
              <proc><?php echo parsear($row_mostrar_externos['org_remitente']); ?></proc>
              <!--<cite_fecha><?php //echo parsear($row_mostrar_externos['cite']); ?> (<?php echo $row_mostrar_externos['fecha_doc']; ?>)</cite_fecha>-->
              <hojas type="number">s/n</hojas>
              <!--<anexos>...</anexos>-->
              <ref><?php echo parsear($row_mostrar_externos['ref']); ?></ref>
              <recibido><?php echo $row_mostrar_externos['fun_recibido']; ?></recibido>
              <!--<obs>.............</obs>-->
              <proveido><?php echo $row_mostrar_externos['proveido']; ?></proveido>
            </row>
            <?php } while ($row_mostrar_externos = mysql_fetch_assoc($mostrar_externos)); ?>
          <?php } // Show if recordset not empty ?>
        <?php if ($totalRows_mis_hojasrutas > 0) { // Show if recordset not empty ?>
        <?php do { ?>
            <row>
              <hruta><?php echo $row_mis_hojasrutas['hojaruta_cod']; ?></hruta>
              <fecha_ing><?php echo $row_mis_hojasrutas['fecha_recibido']; ?></fecha_ing>
              <proc><?php echo parsear($row_mis_hojasrutas['procedencia']); ?></proc>
              <!--<cite_fecha>s/n</cite_fecha>-->
              <hojas type="number"><?php echo $row_mis_hojasrutas['nhojas']; ?></hojas>
              
              <!--<anexos>...</anexos>-->
              <ref><?php echo parsear($row_mis_hojasrutas['ref']); ?></ref>
              <recibido><?php echo $row_mis_hojasrutas['fun_recibido']; ?></recibido>
              <!--<obs>.............</obs>-->
              <proveido><?php echo parsear($row_mis_hojasrutas['proveido']); ?></proveido>
              </row>
            <?php } while ($row_mis_hojasrutas = mysql_fetch_assoc($mis_hojasrutas)); ?>
          <?php } // Show if recordset not empty ?>
          
            <?php if (($totalRows_mis_recibidos+$totalRows_mostrar_externos+$totalRows_mis_hojasrutas)==0){ // Show if recordset empty ?>
            <row>          Sin registros hasta ahora.....              </row>
            <?php } // Show if recordset empty ?>
        
        
      </rowset>
    </sorttable>
  </datos>
  <?php
mysql_free_result($mis_recibidos);

mysql_free_result($mostrar_externos);

mysql_free_result($mis_hojasrutas);
?>
