<?php 
session_name("LoginSIRC");
session_start();
$cod_dep=$_SESSION['cod_dep'];
?>
<?php require_once('../../../Connections/snet.php'); ?>
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

$codigo_obtener_hr = "-1";
if (isset($_GET['cod'])) {
  $codigo_obtener_hr = $_GET['cod'];
}
mysql_select_db($database_snet, $snet);
$query_obtener_hr = sprintf("SELECT * FROM hojaruta WHERE hojaruta.cod=%s", GetSQLValueString($codigo_obtener_hr, "text"));
$obtener_hr = mysql_query($query_obtener_hr, $snet) or die(mysql_error());
$row_obtener_hr = mysql_fetch_assoc($obtener_hr);
$totalRows_obtener_hr = mysql_num_rows($obtener_hr);

$codigo_listar_destinos = "-1";
if (isset($_GET['cod'])) {
  $codigo_listar_destinos = $_GET['cod'];
}
mysql_select_db($database_snet, $snet);
$query_listar_destinos = sprintf("SELECT * FROM derivacion WHERE derivacion.hojaruta_cod=%s AND  derivacion.nro_destino>31 ORDER BY derivacion.nro_destino ASC", GetSQLValueString($codigo_listar_destinos, "text"));
$listar_destinos = mysql_query($query_listar_destinos, $snet) or die(mysql_error());
$row_listar_destinos = mysql_fetch_assoc($listar_destinos);
$totalRows_listar_destinos = mysql_num_rows($listar_destinos);
 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pagina6</title>
<style type="text/css">
<!--
.ins_adicionales {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	text-decoration: underline;
	height: 130px;
}
.objeto {
	font-family: Arial, Helvetica, sans-serif;
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: dotted;
	border-left-style: none;
	border-top-color: #666666;
	border-right-color: #666666;
	border-bottom-color: #666666;
	border-left-color: #666666;
	height: 20px;
	width: 400px;
	vertical-align: bottom;
	font-size: 10px;
}
.cuadrillas {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	height: 15px;
	width: 15px;
	border: 1px solid #000000;
}
.PROVEIDO {	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	width: 90%;
	margin: 1px;
	padding: 1px;
	border: 1px solid #BBDDFF;
	text-align: justify;
	color: #003366;
	font-variant: normal;
	text-transform: none;
	background-color: #FFFFEA;
}
.cuadro {	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	margin: 1px;
	padding: 1px;
	width: 100%;
	border: 1px solid #BBDDFF;
}
.checkbox {
	height: 50px;
	width: 50px;
}
.destinatarios {
	font-family: "Courier New", Courier, monospace;
	font-size: 12px;
	color: #000000;
	border: 1px solid #000000;
}
.cuadroInstruccion {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	margin: 10px;
	padding: 5px;
	width: 95%;
	border: 1px solid #BBDDFF;
	height: 55px;
}
.hojas {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	margin: 1px;
	padding: 1px;
	width: 200px;
	border: 1px solid #91C8FF;
	height: 25px;
}
.Estilo26 {font-size: 14px}
.Estilo27 {
	font-family: Arial, Helvetica, sans-serif;
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: dotted;
	border-left-style: none;
	border-top-color: #000000;
	border-right-color: #000000;
	border-bottom-color: #000000;
	border-left-color: #000000;
	height: 30px;
	width: 400px;
	vertical-align: 12%;
	font-size: 13px;
}
.Estilo28 {font-size: 13px}
.n_destinatario {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 18px;
	color: #000000;
	background-image: url(../arco-8.gif);
	height: 26px;
	width: 23px;
	background-repeat: no-repeat;
	background-position: left top;
	margin: 0px;
	padding: 2px;
}
.Estilo32 {font-size: 24px}
.Estilo33 {	font-family: Arial, Helvetica, sans-serif;
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
	border-top-color: #666666;
	border-right-color: #666666;
	border-bottom-color: #666666;
	border-left-color: #666666;
	height: 30px;
	width: 400px;
	vertical-align: 12%;
	font-size: 13px;
}
-->
</style>
</head>

<body>
<table width="100%" border="0">
  <tr>
    <td><table width="100%" border="0">
        <tr>
          <td width="300">&nbsp;</td>
          <td>&nbsp;</td>
          <td align="right">HOJA DE RUTA</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><div align="right"><span class="CollapsiblePanelTabHover">(Pág 11)</span></div></td>
          <td align="right"><span class="CollapsiblePanelTabHover Estilo32"><?php echo $_GET['cod']; ?></span></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" class="destinatarios">
      <tr>
        <td width="180"><div align="right">Remitente:&nbsp;</div></td>
        <td><div align="left" class="objeto Estilo28"><?php echo $row_obtener_hr['procedencia']; ?></div></td>
        <td width="70">&nbsp;</td>
        <td width="70"><div align="right">hojas:&nbsp;</div></td>
        <td width="130"><div align="left" class="hojas"><?php echo $row_obtener_hr['nhojas']; ?></div></td>
      </tr>
      <tr>
        <td width="180"><div align="right">asunto/referencia:&nbsp;</div></td>
        <td><div align="left" class="Estilo27"><?php echo $row_obtener_hr['ref']; ?></div></td>
        <td width="70">&nbsp;</td>
        <td width="70"><div align="right">anexos:&nbsp;</div></td>
        <td width="130"><div align="left" class="hojas"><?php echo $row_obtener_hr['nanexos']; ?></div></td>
      </tr>

    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="destinatarios">
      <tr>
        <td><table width="100%" border="0">
            <tr>
              <td><table width="100%" border="0">
                  <tr>
                    <td width="100">FECHA: </td>
                    <td width="100"><div class="hojas" style="width:100px;"></div></td>
                    <td width="40">HORA:</td>
                    <td width="50"><div class="hojas" style="width:50px;"></div></td>
                    <td>&nbsp;</td>
                    <td><div align="right">Nº de Hojas:&nbsp;</div></td>
                    <td><div align="left" class="hojas"><?php echo $row_listar_destinos['nhojas']; ?></div></td>
                    <td width="70"><div align="right">anexos:&nbsp;</div></td>
                    <td width="130"><div align="left" class="hojas"><?php echo $row_listar_destinos['anexos']; ?></div></td>
                  </tr>
              </table></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="0">
            <tr>
              <td width="180"><table width="100%" border="0">
                  <tr>
                    <td width="34"><div class="n_destinatario">32</div></td>
                    <td>DESTINATARIO: </td>
                  </tr>
              </table></td>
              <td><div class="objeto"><span class="Estilo33"><?php echo $row_listar_destinos['fun_destino']; ?>
                    <?php if ($row_listar_destinos['dep_destino']!="") {?>
&nbsp;&nbsp;(<?php echo $row_listar_destinos['dep_destino']; ?>)
<?php }?>
              </span></div></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="0">
            <tr>
              <td width="100" height="21">Objeto: </td>
              <td><table width="100%" border="0">
                  <tr>
                    <td height="25"><span class="Estilo26">
                      <div align="right" class="Estilo26">URGENTE&nbsp;&nbsp;</div>
                    </span></td>
                    <td height="30"><div class="cuadrillas"></div></td>
                    <td width="30">&nbsp;</td>
                    <td height="30"><div align="right" class="Estilo26">Preparar Respuesta&nbsp;</div></td>
                    <td height="30"><div class="cuadrillas"></div></td>
                    <td width="30">&nbsp;</td>
                    <td height="30"><div align="right" class="Estilo26">Preparar Informe&nbsp;&nbsp;</div></td>
                    <td><div class="cuadrillas"></div></td>
                  </tr>
                  <tr>
                    <td height="25"><div align="right" class="Estilo26">Para su conocimiento&nbsp;&nbsp;</div></td>
                    <td height="30"><div class="cuadrillas"></div></td>
                    <td width="30">&nbsp;</td>
                    <td height="30"><div align="right" class="Estilo26">Procesar&nbsp;&nbsp;&nbsp;</div></td>
                    <td height="30"><div class="cuadrillas"></div></td>
                    <td width="30">&nbsp;</td>
                    <td height="30"><div align="right" class="Estilo26">Archivo&nbsp;&nbsp;</div></td>
                    <td><div class="cuadrillas"></div></td>
                  </tr>
              </table></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="0">
            <tr>
              <td valign="top"><table width="100%" border="0">
                  <tr>
                    <td width="160">Instruccion Adicional: </td>
                    <td><div class="cuadroInstruccion"><?php echo $row_listar_destinos['mensaje']; ?></div></td>
                  </tr>
              </table></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="0">
            <tr>
              <td><div align="right">FECHA:&nbsp; </div></td>
              <td width="150"><div class="hojas" style="width:150px;">
                <?php 
					$derivacion=explode(" ",$row_listar_destinos['fecha_derivacion']);
					$fecha=explode("-",$derivacion[0]);
					$hora=explode(":",$derivacion[1]);
					?>
                <?php
					if ($fecha[2]!="")
					echo $fecha[2]."-".$fecha[1]."-".$fecha[0]; 
					?>
             </div></td>
              <td width="50"><div align="right">HORA&nbsp;:&nbsp; </div></td>
              <td width="150"><div class="hojas" style="width:50px;">
                <?php /*echo $hora[0]." h:".$hora[1]." m:".$hora[2]." s"; */
					if ($hora[0]!="")
					echo $hora[0].":".$hora[1];
					
					?>
              </div></td>
              <td width="300">FIRMA :<?php echo $row_listar_destinos['fun_derivador']; ?></td>
            </tr>
        </table></td>
      </tr>
    </table>  <?php $row_listar_destinos = mysql_fetch_assoc($listar_destinos)?></td>
  </tr>
 
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="destinatarios">

      <tr>
        <td><table width="100%" border="0">

            <tr>
              <td><table width="100%" border="0">
                <tr>
                  <td width="100">FECHA: </td>
                  <td width="100"><div class="hojas" style="width:100px;"></div></td>
                  <td width="40">HORA:</td>
                  <td width="50"><div class="hojas" style="width:50px;"></div></td>
                  <td>&nbsp;</td>
                  <td><div align="right">Nº de Hojas:&nbsp;</div></td>
                  <td><div align="left" class="hojas"><?php echo $row_listar_destinos['nhojas']; ?></div></td>
                  <td width="70"><div align="right">anexos:&nbsp;</div></td>
                  <td width="130"><div align="left" class="hojas"><?php echo $row_listar_destinos['anexos']; ?></div></td>
                </tr>
              </table></td>
              </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="0">
          <tr>
            <td width="180"><table width="100%" border="0">
              <tr>
                <td width="34"><div class="n_destinatario">33</div></td>
                <td>DESTINATARIO: </td>
              </tr>
            </table></td>
            <td><div class="objeto"><span class="Estilo33"><?php echo $row_listar_destinos['fun_destino']; ?>
                  <?php if ($row_listar_destinos['dep_destino']!="") {?>
&nbsp;&nbsp;(<?php echo $row_listar_destinos['dep_destino']; ?>)
<?php }?>
            </span></div></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="0">
          <tr>
            <td width="100" height="21">Objeto: </td>
            <td><table width="100%" border="0">
              <tr>
                <td height="25"><span class="Estilo26">
                  <div align="right" class="Estilo26">URGENTE&nbsp;&nbsp;</div>
                  
                  </span></td>
                <td height="30"><div class="cuadrillas"></div></td>
                <td width="30">&nbsp;</td>
                <td height="30"><div align="right" class="Estilo26">Preparar Respuesta&nbsp;</div></td>
                <td height="30"><div class="cuadrillas"></div></td>
                <td width="30">&nbsp;</td>
                <td height="30"><div align="right" class="Estilo26">Preparar Informe&nbsp;&nbsp;</div></td>
                <td><div class="cuadrillas"></div></td>
              </tr>
              <tr>
                <td height="25"><div align="right" class="Estilo26">Para su conocimiento&nbsp;&nbsp;</div></td>
                <td height="30"><div class="cuadrillas"></div></td>
                <td width="30">&nbsp;</td>
                <td height="30"><div align="right" class="Estilo26">Procesar&nbsp;&nbsp;&nbsp;</div></td>
                <td height="30"><div class="cuadrillas"></div></td>
                <td width="30">&nbsp;</td>
                <td height="30"><div align="right" class="Estilo26">Archivo&nbsp;&nbsp;</div></td>
                <td><div class="cuadrillas"></div></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="0">
          <tr>
            <td valign="top"><table width="100%" border="0">
              <tr>
                <td width="160">Instruccion Adicional: </td>
                <td><div class="cuadroInstruccion"><?php echo $row_listar_destinos['mensaje']; ?></div></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="0">
            <tr>
              <td><div align="right">FECHA:&nbsp; </div></td>
              <td width="150"><div class="hojas" style="width:150px;">
                <?php 
					$derivacion=explode(" ",$row_listar_destinos['fecha_derivacion']);
					$fecha=explode("-",$derivacion[0]);
					$hora=explode(":",$derivacion[1]);
					?>
                <?php
					if ($fecha[2]!="")
					echo $fecha[2]."-".$fecha[1]."-".$fecha[0]; 
					?>
              </div></td>
              <td width="50"><div align="right">HORA: &nbsp; </div></td>
              <td width="150"><div class="hojas" style="width:50px;">
                <?php /*echo $hora[0]." h:".$hora[1]." m:".$hora[2]." s"; */
					if ($hora[0]!="")
					echo $hora[0].":".$hora[1];
					
					?>
             </div></td>
              <td width="300">FIRMA :<strong><?php echo $row_listar_destinos['fun_derivador']; ?></strong></td>
            </tr>
        </table></td>
      </tr>
    </table>  <?php $row_listar_destinos = mysql_fetch_assoc($listar_destinos)?></td>
  </tr>
    <tr>
      <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="destinatarios">
        <tr>
          <td><table width="100%" border="0">
              <tr>
                <td><table width="100%" border="0">
                    <tr>
                      <td width="100">FECHA: </td>
                      <td width="100"><div class="hojas" style="width:100px;"></div></td>
                      <td width="40">HORA:</td>
                      <td width="50"><div class="hojas" style="width:50px;"></div></td>
                      <td>&nbsp;</td>
                      <td><div align="right">Nº de Hojas:&nbsp;</div></td>
                      <td><div align="left" class="hojas"></div></td>
                      <td width="70"><div align="right">anexos:&nbsp;</div></td>
                      <td width="130"><div align="left" class="hojas"></div></td>
                    </tr>
                </table></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="100%" border="0">
              <tr>
                <td width="180"><table width="100%" border="0">
                    <tr>
                      <td width="34"><div class="n_destinatario">34</div></td>
                      <td>DESTINATARIO: </td>
                    </tr>
                </table></td>
                <td><div class="objeto"><span class="Estilo33"><?php echo $row_listar_destinos['fun_destino']; ?>
                      <?php if ($row_listar_destinos['dep_destino']!="") {?>
&nbsp;&nbsp;(<?php echo $row_listar_destinos['dep_destino']; ?>)
<?php }?>
                </span></div></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="100%" border="0">
              <tr>
                <td width="100" height="21">Objeto: </td>
                <td><table width="100%" border="0">
                    <tr>
                      <td height="25"><span class="Estilo26">
                        <div align="right" class="Estilo26">URGENTE&nbsp;&nbsp;</div>
                      </span></td>
                      <td height="30"><div class="cuadrillas"></div></td>
                      <td width="30">&nbsp;</td>
                      <td height="30"><div align="right" class="Estilo26">Preparar Respuesta&nbsp;</div></td>
                      <td height="30"><div class="cuadrillas"></div></td>
                      <td width="30">&nbsp;</td>
                      <td height="30"><div align="right" class="Estilo26">Preparar Informe&nbsp;&nbsp;</div></td>
                      <td><div class="cuadrillas"></div></td>
                    </tr>
                    <tr>
                      <td height="25"><div align="right" class="Estilo26">Para su conocimiento&nbsp;&nbsp;</div></td>
                      <td height="30"><div class="cuadrillas"></div></td>
                      <td width="30">&nbsp;</td>
                      <td height="30"><div align="right" class="Estilo26">Procesar&nbsp;&nbsp;&nbsp;</div></td>
                      <td height="30"><div class="cuadrillas"></div></td>
                      <td width="30">&nbsp;</td>
                      <td height="30"><div align="right" class="Estilo26">Archivo&nbsp;&nbsp;</div></td>
                      <td><div class="cuadrillas"></div></td>
                    </tr>
                </table></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="100%" border="0">
              <tr>
                <td valign="top"><table width="100%" border="0">
                    <tr>
                      <td width="160">Instruccion Adicional: </td>
                      <td><div class="cuadroInstruccion"><?php echo $row_listar_destinos['mensaje']; ?></div></td>
                    </tr>
                </table></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="100%" border="0">
              <tr>
              <td><div align="right">FECHA:&nbsp; </div></td>
              <td width="150"><div class="hojas" style="width:150px;">
                <?php 
					$derivacion=explode(" ",$row_listar_destinos['fecha_derivacion']);
					$fecha=explode("-",$derivacion[0]);
					$hora=explode(":",$derivacion[1]);
					?>
                <?php
					if ($fecha[2]!="")
					echo $fecha[2]."-".$fecha[1]."-".$fecha[0]; 
					?>
              </div></td>
              <td width="50"><div align="right">HORA: &nbsp; </div></td>
              <td width="150"><div class="hojas" style="width:50px;">
                <?php /*echo $hora[0]." h:".$hora[1]." m:".$hora[2]." s"; */
					if ($hora[0]!="")
					echo $hora[0].":".$hora[1];
					
					?>
              </div></td>
              <td width="300">FIRMA :<strong><?php echo $row_listar_destinos['fun_derivador']; ?></strong></td>
            </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
</table>
</body>
</html>
<?php
mysql_free_result($obtener_hr);

mysql_free_result($listar_destinos);
?>
