<?php 
header("Content-Type: text/html; charset=utf-8");
session_name("LoginSIRC");
session_start();
?>
<?php require_once('Connections/snet.php'); ?>
<?php
$colname_datos_derivacion = "-1";
if (isset($_GET['cod'])) {
  $colname_datos_derivacion = (get_magic_quotes_gpc()) ? $_GET['cod'] : addslashes($_GET['cod']);
}
mysql_select_db($database_snet, $snet);
$query_datos_derivacion = sprintf("SELECT cod, fecha_creacion, procedencia, nhojas, nanexos, cont_destinos FROM hojaruta WHERE cod = '%s'", $colname_datos_derivacion);
$datos_derivacion = mysql_query($query_datos_derivacion, $snet) or die(mysql_error());
$row_datos_derivacion = mysql_fetch_assoc($datos_derivacion);
$totalRows_datos_derivacion = mysql_num_rows($datos_derivacion);
?><?php
// HEAD content
?>
<style type="text/css">
<!--
.style2 {
	color: #FFFFFF;
	font-size: 10px;
	font-weight: bold;
}
.label {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-weight: 100;
	color: #000000;
}
.style3 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
}
.style6 {
	font-size: 14px;
	font-weight: bold;
}
.style7 {font-size: 11px}
.style8 {font-size: 14px}
-->
</style>

<?php
// Begin HTML content
?>
<div class="panel__content">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr bgcolor="#211B41">
                  <td><span class="style2">DETALLES DE LA CORRESPONDENCIA </span></td>
                </tr>
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="105"><img src="content/imagen/es-corresp.jpg" width="94" height="144" /></td>
                        <td><table width="100%" border="0" cellspacing="0" cellpadding="2">

                            <tr>
                              <td><span class="style3">HOJA DE RUTA </span></td>
                            </tr>
                            <tr>
                              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td>&nbsp;</td>
                                    <td class="label">codigo: <span class="style6"><?php echo $row_datos_derivacion['cod']; ?></span></td>
                                    <td>&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td>&nbsp;</td>
                                    <td class="label">fech. derivacion: <?php echo $row_datos_derivacion['fecha_creacion']; ?></td>
                                    <td>&nbsp;</td>
                                  </tr>
                              </table></td>
                            </tr>
                            <tr>
                              <td><span class="label">Hojas: <?php echo $row_datos_derivacion['nhojas']; ?></span></td>
                            </tr>
                            <tr>
                              <td><span class="label">Anexos: <?php echo $row_datos_derivacion['nanexos']; ?></span></td>
                            </tr>

                            <tr>
                              <td><span class="style3">Recibido</span></td>
                            </tr>
                            <tr>
                              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

                                  <tr>
                                    <td><span class="style7">Derivaciones:</span> <span class="style8"><?php echo $row_datos_derivacion['cont_destinos']; ?></span></td>
                                    <td class="label">&nbsp;</td>
                                    <td>&nbsp;</td>
                                  </tr>
                              </table></td>
                            </tr>
                        </table></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
              </table>
          
</div>
<?php
// End HTML content
?>
<?php
mysql_free_result($datos_derivacion);
?>