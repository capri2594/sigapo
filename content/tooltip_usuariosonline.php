<?php require_once('Connections/snet.php'); ?>
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

mysql_select_db($database_snet, $snet);
$query_usuarios_online = "SELECT * FROM funcionario WHERE usuario_cuenta IN (SELECT cuenta FROM SESSION WHERE cuenta !='') ORDER by funcionario.dependencia_cod desc ";
$usuarios_online = mysql_query($query_usuarios_online, $snet) or die(mysql_error());
$row_usuarios_online = mysql_fetch_assoc($usuarios_online);
$totalRows_usuarios_online = mysql_num_rows($usuarios_online);
?><?php
// HEAD content
?>
<style type="text/css">
<!--
.style2 {color: #FFFFFF}
.style4 {
	font-size: 12px;
	font-family: Arial, Helvetica, sans-serif;
	text-transform: none;
}
.style5 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.style7 {font-size: 12px; color: #000033; }
.Estilo1 {
	font-size: 9px;
	font-style: normal;
	font-family: Arial, Helvetica, sans-serif;
	color: #333333;
	font-variant: normal;
	text-transform: uppercase;
}
-->
</style>

<?php
// Begin HTML content
?>
<div class="panel__content">
            
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td>&nbsp;</td>
                  <td><blockquote>
                    <em>(<?php echo $totalRows_usuarios_online; ?>)</em>Usuarios,  en <span class="style5" style="background-color:#66CC99;">linea</span>, trabajando en este momento. 
                  </blockquote></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td width="30">&nbsp;</td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="3">
                      <tr>
                        <td width="15" bgcolor="#5F6A9C"><span class="style2">Nro.</span></td>
                         <td width="50" bgcolor="#5F6A9C"><span class="style2">USUARIO</span></td>
                   
                        <td width="210" bgcolor="#5F6A9C"><span class="style2">FUNCIONARIO</span></td>
                       
                             <td width="50" bgcolor="#5F6A9C"><span class="style2">DEPENDENCIA</span></td>
                    </tr>
                      <?php $n=0;do { $n++;?>
                      <tr valign="bottom">
                      <td width="15" height="70" bgcolor="#5F6A9C"><div align="right"><span class="style2">&nbsp;<?php echo $n; ?></span></div></td>
                         <td width="50" height="70" bgcolor="#EAECF2"><span class="style7"><img src="perfiles/fotos/<?php $ruta="perfiles/fotos/"; $avatar=$ruta.$row_usuarios_online['usuario_cuenta'].".jpg"; if (file_exists($avatar)){ ?><?php echo $row_usuarios_online['usuario_cuenta']; ?>.jpg"<?php }else{ echo "default_avatar_femenino003.jpg\""; }?> width="60" height="60"  alt="<?php echo $avatar; ?>"/><br />
                        <?php echo $row_usuarios_online['usuario_cuenta']; ?></span></td>
                        
                        
                        <td width="210" height="70" valign="bottom"><span class="style4"><?php echo $row_usuarios_online['nombre']; ?><br />
                        <span class="Estilo1"><?php echo $row_usuarios_online['cargo']; ?></span></span></td>
                        <td width="50" height="70" valign="bottom" bgcolor="#EAECF2"><span class="style7"><span class="style4"><?php echo $row_usuarios_online['dependencia_cod']; ?></span></span></td>
                        
                    </tr>
                      <?php } while ($row_usuarios_online = mysql_fetch_assoc($usuarios_online)); ?>
                  </table></td>
                  <td width="30">&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </table>
          
</div>
<?php
// End HTML content
?>
<?php
mysql_free_result($usuarios_online);
?>