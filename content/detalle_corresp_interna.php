<?php require_once('Connections/snet.php'); ?>
<?php
/*function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

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
*/
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "formCorresp")) {
  $updateSQL = sprintf("UPDATE einterna SET cite=%s, `ref`=%s, dep_remite=%s, fun_remite=%s, HR=%s WHERE id_interna=%s",
                       GetSQLValueString($_POST['cite'], "text"),
                       GetSQLValueString($_POST['ref'], "text"),
                       GetSQLValueString($_POST['dep_remite'], "text"),
                       GetSQLValueString($_POST['fun_remite'], "text"),
                       GetSQLValueString($_POST['HR'], "text"),
                       GetSQLValueString($_POST['id_interna'], "int"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($updateSQL, $snet) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "formCorresp")) {
  $updateSQL = sprintf("UPDATE hojaruta SET procedencia=%s WHERE cod=%s",
                       GetSQLValueString($_POST['dep_remite'], "text"),
                       GetSQLValueString($_POST['HR'], "text"));

  mysql_select_db($database_snet, $snet);
  $Result1 = mysql_query($updateSQL, $snet) or die(mysql_error());
}

$hr_corresp_interna = "-1";
if (isset($_GET['cod'])) {
  $hr_corresp_interna = $_GET['cod'];
}
mysql_select_db($database_snet, $snet);
$query_corresp_interna = sprintf("SELECT * FROM einterna, hojaruta WHERE einterna.HR=hojaruta.cod AND einterna.HR='%s'",$hr_corresp_interna);
$corresp_interna = mysql_query($query_corresp_interna, $snet) or die(mysql_error());
$row_corresp_interna = mysql_fetch_assoc($corresp_interna);
$totalRows_corresp_interna = mysql_num_rows($corresp_interna);
?><?php
// HEAD content
?>
<?php
// Begin HTML content
?>
<div class="panel__content">
              
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>Detalle de la Correspondencia <?php echo $_GET['cod']; ?> </td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><form id="formCorresp" name="formCorresp" method="POST" action="<?php echo $editFormAction; ?>">
                    <fieldset>
                    <legend>Datos registrados </legend>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td>de:</td>
                              <td><input name="fun_remite" type="text" id="fun_remite" value="<?php echo $row_corresp_interna['fun_remite']; ?>" size="35" />
                                &laquo;
                                <input name="dep_remite" type="text" id="dep_remite" value="<?php echo $row_corresp_interna['dep_remite']; ?>" size="45" />
                              &raquo; </td></tr>
                            <tr>
                              <td>para:</td>
                              <td><?php echo $row_corresp_interna['fun_destino']; ?> &laquo;<?php echo $row_corresp_interna['dep_destino']; ?>&raquo;</td>
                            </tr>
                            <tr>
                              <td>fech.doc</td>
                              <td><?php echo $row_corresp_interna['fecha_doc']; ?></td>
                            </tr>
                            <tr>
                              <td>cite</td>
                              <td><?php echo $row_corresp_interna['cite']; ?>
                                  <input name="cite" type="hidden" id="cite"  value="<?php echo $row_corresp_interna['cite']; ?>"/></td>
                            </tr>
                            <tr>
                              <td>ref.</td>
                              <td><?php echo $row_corresp_interna['ref']; ?>
                                  <input name="ref" type="hidden" id="ref"  value="<?php echo $row_corresp_interna['ref']; ?>"/></td>
                            </tr>
                            <tr>
                              <td>tema</td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td>hojas</td>
                              <td><?php echo $row_corresp_interna['nhojas']; ?><?php echo $row_corresp_interna['entradas_tema_titulo']; ?></td>
                            </tr>
                            <tr>
                              <td>anexos</td>
                              <td><?php echo $row_corresp_interna['anexos']; ?></td>
                            </tr>
                            <tr>
                              <td>Observacion</td>
                              <td><?php echo $row_corresp_interna['adjuntos']; ?>
                                  <input name="HR" type="hidden" id="HR"  value="<?php echo $row_corresp_interna['HR']; ?>"/></td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td><input type="hidden" name="id_interna" value="<?php echo $row_corresp_interna['id_interna']; ?>" /></td>
                            </tr>
                            <tr>
                              <td>Recibido por:</td>
                              <td><?php echo $row_corresp_interna['entradas_usuario_cuenta']; ?></td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                            </tr>
                        </table>
                        </td>
                        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
                            <tr>
                              <td><input type="submit" name="Submit" value="Modificar" /></td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                            </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                    </table>
                    </fieldset>
                    <input type="hidden" name="MM_update" value="formCorresp">
                  </form></td>
                </tr>
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td><fieldset>
                          <legend>Hoja de Ruta</legend>
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td>Codigo</td>
                              <td><?php echo $row_corresp_interna['cod']; ?></td>
                            </tr>
                            <tr>
                              <td>Ussuario.Derivador</td>
                              <td><?php echo $row_corresp_interna['usuario_creador']; ?></td>
                            </tr>
                            <tr>
                              <td>c/hojas</td>
                              <td><?php echo $row_corresp_interna['nhojas']; ?></td>
                            </tr>
                            <tr>
                              <td>c/anexos</td>
                              <td><?php echo $row_corresp_interna['nanexos']; ?></td>
                            </tr>
                            <tr>
                              <td># derivaciones </td>
                              <td><?php echo $row_corresp_interna['cont_destinos']; ?></td>
                            </tr>
                          </table>
                        </fieldset></td>
                        <td>&nbsp;</td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><form id="formHr" name="formHr" method="post" action="">
                  </form></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
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
mysql_free_result($corresp_interna);
?>