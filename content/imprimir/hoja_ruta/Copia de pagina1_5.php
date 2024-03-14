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
$query_listar_destinos = sprintf("SELECT * FROM derivacion WHERE derivacion.hojaruta_cod=%s ORDER BY derivacion.nro_destino ASC", GetSQLValueString($codigo_listar_destinos, "text"));
$listar_destinos = mysql_query($query_listar_destinos, $snet) or die(mysql_error());
$row_listar_destinos = mysql_fetch_assoc($listar_destinos);
$totalRows_listar_destinos = mysql_num_rows($listar_destinos);
 
session_name("LoginSIRC");
session_start();
$cod_dep=$_SESSION['cod_dep'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pagina1</title>
<style type="text/css">
<!--
.Estilo12 {font-size: 12px}
.Estilo18 {	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
}
.Estilo22 {	font-family: "Courier New", Courier, monospace;
	font-weight: bold;
	font-size: 14px;
}
.Estilo23 {font-size: 10px}
.Estilo6 {font-size: 10px; font-family: Arial, Helvetica, sans-serif; }
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
	border-bottom-style: solid;
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
.objeto2 {
	font-family: Arial, Helvetica, sans-serif;
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: solid;
	border-left-style: none;
	border-top-color: #666666;
	border-right-color: #666666;
	border-bottom-color: #666666;
	border-left-color: #666666;
	height: 20px;
	width: 60px;
	vertical-align: bottom;
	font-size: 10px;
}
.recibido {
	border-top-width: 1px;
	border-left-width: 1px;
	border-top-style: solid;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: solid;
	border-top-color: #333333;
	border-right-color: #333333;
	border-bottom-color: #333333;
	border-left-color: #333333;
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
	width: 100%;
	margin: 1px;
	padding: 1px;
	border: 1px solid #BBDDFF;
	text-align: justify;
	color: #003366;
	font-variant: normal;
	text-transform: none;
	background-color: #FFFFEA;
}
.cuadro {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	margin: 1px;
	padding: 1px;
	width: 100%;
	border: 1px solid #BBDDFF;
	height: 60px;
}
.checkbox {
	height: 50px;
	width: 50px;
}
.destinatarios {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #000000;
	border: 1px solid #000000;
}
.cuadroInstruccion {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	width: 95%;
	border: 1px solid #BBDDFF;
	height: 149px;
	margin-top: 0px;
	margin-right: 5px;
	margin-bottom: 0px;
	margin-left: 5px;
	padding-top: 0px;
	padding-right: 2px;
	padding-bottom: 0px;
	padding-left: 2px;
}
.txtobj {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
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
.Estilo24 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 13px;
}
.Estilo26 {
	font-size: 13px
}
.ref {
	font-family: Arial, Helvetica, sans-serif;
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: solid;
	border-left-style: none;
	border-top-color: #000000;
	border-right-color: #000000;
	border-bottom-color: #000000;
	border-left-color: #000000;
	height: auto;
	width: auto;
	vertical-align: baseline;
	font-size: 13px;
	margin: 1px;
	padding: 0px;
}
.Estilo28 {font-size: 13px}
.Estilo29 {
	font-family: Arial, Helvetica, sans-serif;
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
.n_destinatario {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 24px;
	color: #000000;
	background-image: url(../arco-8.gif);
	height: 26px;
	width: 23px;
	background-repeat: no-repeat;
	background-position: left top;
	margin: 0px;
	padding-top: 0px;
	padding-right: 0px;
	padding-bottom: 0px;
	padding-left: 6px;
}
.Estilo36 {font-size: 8px}
.Estilo38 {
	font-size: 16px
}
.Estilo39 {font-size: 14px; }
body {
	margin: 0px;
	padding: 0px;
}
.Estilo19 {font-size: 9px}
-->
</style>
</head>

<body>
<table width="100%" border="0">
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">

      <tr>
        <td><table width="100%" border="0" bgcolor="#FBFDFF" class="cuadro">
            <tr>
              <td><img src="../../imagen/escudo_oruro001 copia.jpg" alt="ESCUDO" width="52" height="55" longdesc="BOLIVIA" /></td>
              <td><table width="100%" border="0">
                  <tr>
                    <td height="10"><div align="center" class="Estilo22">GOBIERNO DEPARTAMENTAL AUTONOMO DE ORURO</div></td>
                  </tr>
                  <tr>
                    <td height="10"><div align="center" class="Estilo6 Estilo23"><?php echo $_SESSION['dep']; ?></div></td>
                  </tr>
                  <tr>
                    <td height="10"><div align="center" class="Estilo12"><strong>H&nbsp;O&nbsp;J&nbsp;A &nbsp;&nbsp;&nbsp;&nbsp;D&nbsp;E &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;R&nbsp;U&nbsp;T&nbsp;A</strong></div></td>
                  </tr>
              </table></td>
              <td>&nbsp;</td>
            </tr>
        </table></td>
        <td width="150"><table width="100%" border="0" class="PROVEIDO" style="height:60px;">
          <tr>
            <td><span class="Estilo12 Estilo18">CODIGO Nº :</span></td>
          </tr>
          <tr>
            <td><span class="CollapsiblePanelTabHover Estilo38"><?php echo $_GET['cod']; ?></span></td>
          </tr>
          <tr style="height:12px;">
            <td><span class="Estilo19">Use el codigo para  seguimiento</span></td>
          </tr>
        </table></td>
      </tr>


    </table></td>
  </tr>

  <tr class="destinatarios">
    <td><table width="100%" border="0" class="destinatarios" >
      <tr>
        <td width="130"><div align="right" class="Estilo39"><span class="Estilo12">Remitente:</span>&nbsp;</div></td>
        <td><div align="left" class="objeto Estilo28"><?php echo $row_obtener_hr['procedencia']; ?></div></td>
        <td width="70">&nbsp;</td>
        <td width="70"><div align="right">hojas:&nbsp;</div></td>
        <td width="130"><div align="left" class="hojas"><?php echo $row_obtener_hr['nhojas']; ?></div></td>
      </tr>
      <tr>
        <td width="130"><div align="right"><span class="Estilo12">asunto/referencia:</span>&nbsp;</div></td>
        <td valign="top"><div align="left"><?php echo $row_obtener_hr['ref']; ?></div></td>
        <td width="70">&nbsp;</td>
        <td width="70"><div align="right">anexos:&nbsp;</div></td>
        <td width="130"><div align="left" class="hojas"><?php echo $row_obtener_hr['nanexos']; ?></div></td>
      </tr>

    </table></td>
  </tr>
  <tr class="destinatarios" height="35" style="height:30px;">
    <td height="35" class="destinatarios"><table width="100%" border="0">
      <tr>
        <td width="34"><div class="n_destinatario">1</div></td>
        <td width="132"><strong>DESTINATARIO:</strong> </td>
        <td><span class="Estilo24"><?php echo $row_obtener_hr['primerfun_destino']; ?>
            <?php if ($row_obtener_hr['primer_destino']!="") {?>
&nbsp;(<?php echo $row_obtener_hr['primer_destino']; ?>)
<?php }?>
        </span></td>
        <td width="120"><div align="right"><span class="Estilo23">FECHA RECEPCION: &nbsp;</span></div></td>
        <td width="150"><span class="Estilo23"><?php echo $row_obtener_hr['fecha_creacion']; ?></span></td>
      </tr>
    </table>
    </td>
  </tr>
  
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="destinatarios">
      <tr>
        <td><table width="100%" border="0">
          <tr>
            <td><table width="100%" border="0" >
              <tr>
                <td width="34"><div class="n_destinatario">2</div></td>
                <td width="132"><strong>DESTINATARIO: </strong></td>
                <td width="100%"><div align="left" class="objeto Estilo28"><span class="objeto" style="width:97%;"><span align="left" class="Estilo29"><?php echo $row_listar_destinos['fun_destino']; ?></span></span></div></td>
                <td width="70">&nbsp;</td>
                <td width="70"><div align="right">hojas:&nbsp;</div></td>
                <td width="130"><div align="left" class="hojas"><?php echo $row_listar_destinos['nhojas']; ?></div></td>
              </tr>
              <tr>
                <td width="130"></td>
                <td valign="top">&nbsp;</td>
                <td valign="top"><div align="left"><span class="objeto" style="width:97%;"><span align="left" class="Estilo29">
                  <?php if ($row_listar_destinos['dep_destino']!="") {?>
&nbsp;&nbsp;(<?php echo $row_listar_destinos['dep_destino']; ?>)
<?php }?>
                </span></span></div></td>
                <td width="70">&nbsp;</td>
                <td width="70"><div align="right">anexos:&nbsp;</div></td>
                <td width="130"><div align="left" class="hojas"><?php echo $row_listar_destinos['anexos']; ?></div></td>
              </tr>
            </table></td>
          </tr>

        </table></td>
        </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="4" cellpadding="0" style="width:100px;">
              <tr>
                <td><div class="cuadrillas"></div></td>
                <td><div align="right" class="txtobj">
                    <div align="left">URGENTE&nbsp;&nbsp;</div>
                </div></td>
              </tr>
              <tr>
                <td><div class="cuadrillas"></div></td>
                <td><div align="right" class="txtobj">
                    <div align="left">Para su conocimiento&nbsp;&nbsp;</div>
                </div></td>
              </tr>
              <tr>
                <td><div class="cuadrillas"></div></td>
                <td><span class="txtobj">Preparar Respuesta</span></td>
              </tr>
              <tr>
                <td><div class="cuadrillas"></div></td>
                <td><span class="txtobj">Procesar</span></td>
              </tr>
              <tr>
                <td><div class="cuadrillas"></div></td>
                <td><span class="txtobj">Preparar Informe</span></td>
              </tr>
              <tr>
                <td><div class="cuadrillas"></div></td>
                <td><span class="txtobj">Archivo</span></td>
              </tr>
            </table></td>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><span class="Estilo12" style="margin-left:10px;">Instruccion Adicional: </span></td>
              </tr>
              <tr>
                <td><div class="cuadroInstruccion">
                      <div align="left"><?php echo $row_listar_destinos['mensaje']; ?></div>
                    </div></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><table width="100%" border="0">
          <tr>
            <td><div align="right">FECHA:&nbsp; </div></td>
            <td width="150"><div class="hojas" style="width:150px;">                      <?php 
					$derivacion=explode(" ",$row_listar_destinos['fecha_derivacion']);
					$fecha=explode("-",$derivacion[0]);
					$hora=explode(":",$derivacion[1]);
					?>
                      <?php
					if ($fecha[2]!="")
					echo $fecha[2]."-".$fecha[1]."-".$fecha[0]; 
					?></div></td>
            <td width="50"><div align="right">HORA  &nbsp;</div></td>
            <td width="150"><div class="hojas" style="width:50px;"> <?php /*echo $hora[0]." h:".$hora[1]." m:".$hora[2]." s"; */
					if ($hora[0]!="")
					echo $hora[0].":".$hora[1];
					
					?></div></td>
            <td width="250">FIRMA :.............................................</td>
          </tr>

        </table></td>
              </tr>
            </table></td>
            <td width="210" valign="top" class="recibido" ><table width="100%" height="213" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td height="27">Recibido/Sello/Firma</td>
              </tr>
              <tr valign="top" style="height:50px;" height="100%">
                <td><table width="100%" height="183" border="1" cellpadding="0" cellspacing="0" class="PROVEIDO">
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      
      <tr>
        <td></td>
      </tr>
    </table></td>
  </tr>
  <?php $row_listar_destinos = mysql_fetch_assoc($listar_destinos)?>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="destinatarios">
      <tr>
        <td><table width="100%" border="0">
          <tr>
            <td><table width="100%" border="0" >
              <tr>
                <td width="34"><div class="n_destinatario">3</div></td>
                <td width="132"><strong>DESTINATARIO: </strong></td>
                <td width="100%"><div align="left" class="objeto Estilo28"><span class="objeto" style="width:97%;"><span align="left" class="Estilo29"><?php echo $row_listar_destinos['fun_destino']; ?></span></span></div></td>
                <td width="70">&nbsp;</td>
                <td width="70"><div align="right">hojas:&nbsp;</div></td>
                <td width="130"><div align="left" class="hojas"><?php echo $row_listar_destinos['nhojas']; ?></div></td>
              </tr>
              <tr>
                <td width="130"></td>
                <td valign="top">&nbsp;</td>
                <td valign="top"><div align="left"><span class="objeto" style="width:97%;"><span align="left" class="Estilo29">
                  <?php if ($row_listar_destinos['dep_destino']!="") {?>
&nbsp;&nbsp;(<?php echo $row_listar_destinos['dep_destino']; ?>)
<?php }?>
                </span></span></div></td>
                <td width="70">&nbsp;</td>
                <td width="70"><div align="right">anexos:&nbsp;</div></td>
                <td width="130"><div align="left" class="hojas"><?php echo $row_listar_destinos['anexos']; ?></div></td>
              </tr>
            </table></td>
          </tr>

        </table></td>
        </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="4" cellpadding="0" style="width:100px;">
                <tr>
                  <td><div class="cuadrillas"></div></td>
                  <td><div align="right" class="txtobj">
                    <div align="left">URGENTE&nbsp;&nbsp;</div>
                  </div></td>
                </tr>
                <tr>
                  <td><div class="cuadrillas"></div></td>
                  <td><div align="right" class="txtobj">
                    <div align="left">Para su conocimiento&nbsp;&nbsp;</div>
                  </div></td>
                </tr>
                <tr>
                  <td><div class="cuadrillas"></div></td>
                  <td><span class="txtobj">Preparar Respuesta</span></td>
                </tr>
                <tr>
                  <td><div class="cuadrillas"></div></td>
                  <td><span class="txtobj">Procesar</span></td>
                </tr>
                <tr>
                  <td><div class="cuadrillas"></div></td>
                  <td><span class="txtobj">Preparar Informe</span></td>
                </tr>
                <tr>
                  <td><div class="cuadrillas"></div></td>
                  <td><span class="txtobj">Archivo</span></td>
                </tr>
              </table></td>
            <td><table width="100%" height="170" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td><span class="Estilo12" style="margin-left:10px;">Instruccion Adicional: </span></td>
              </tr>
              <tr>
                <td><div class="cuadroInstruccion">
                      <div align="left"><?php echo $row_listar_destinos['mensaje']; ?></div>
                    </div></td>
              </tr>              
              <tr>
                <td><table width="100%" border="0">
          <tr>
            <td><div align="right">FECHA:&nbsp; </div></td>
            <td width="150"><div class="hojas" style="width:150px;">                      <?php 
					$derivacion=explode(" ",$row_listar_destinos['fecha_derivacion']);
					$fecha=explode("-",$derivacion[0]);
					$hora=explode(":",$derivacion[1]);
					?>
                      <?php
					if ($fecha[2]!="")
					echo $fecha[2]."-".$fecha[1]."-".$fecha[0]; 
					?></div></td>
            <td width="50"><div align="right">HORA  &nbsp;</div></td>
            <td width="150"><div class="hojas" style="width:50px;"> <?php /*echo $hora[0]." h:".$hora[1]." m:".$hora[2]." s"; */
					if ($hora[0]!="")
					echo $hora[0].":".$hora[1];
					
					?></div></td>
            <td width="250">FIRMA :.............................................</td>
          </tr>

        </table></td>
              </tr>
            </table></td>
            <td width="210" valign="top" class="recibido" ><table width="100%" height="175" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td height="27">Recibido/Sello/Firma</td>
              </tr>
              <tr valign="top" style="height:50px;" height="100%">
                <td><table width="100%" height="183" border="1" cellpadding="0" cellspacing="0" class="PROVEIDO">
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      
      <tr>
        <td></td>
      </tr>
    </table></td>
  </tr>
   <?php $row_listar_destinos = mysql_fetch_assoc($listar_destinos)?>
    <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="destinatarios">
      <tr>
        <td><table width="100%" border="0">
          <tr>
            <td><table width="100%" border="0" >
              <tr>
                <td width="34"><div class="n_destinatario">4</div></td>
                <td width="132"><strong>DESTINATARIO: </strong></td>
                <td width="100%"><div align="left" class="objeto Estilo28"><span class="objeto" style="width:97%;"><span align="left" class="Estilo29"><?php echo $row_listar_destinos['fun_destino']; ?></span></span></div></td>
                <td width="70">&nbsp;</td>
                <td width="70"><div align="right">hojas:&nbsp;</div></td>
                <td width="130"><div align="left" class="hojas"><?php echo $row_listar_destinos['nhojas']; ?></div></td>
              </tr>
              <tr>
                <td width="130"></td>
                <td valign="top">&nbsp;</td>
                <td valign="top"><div align="left"><span class="objeto" style="width:97%;"><span align="left" class="Estilo29">
                  <?php if ($row_listar_destinos['dep_destino']!="") {?>
&nbsp;&nbsp;(<?php echo $row_listar_destinos['dep_destino']; ?>)
<?php }?>
                </span></span></div></td>
                <td width="70">&nbsp;</td>
                <td width="70"><div align="right">anexos:&nbsp;</div></td>
                <td width="130"><div align="left" class="hojas"><?php echo $row_listar_destinos['anexos']; ?></div></td>
              </tr>
            </table></td>
          </tr>

        </table></td>
        </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="4" cellpadding="0" style="width:100px;">
                <tr>
                  <td><div class="cuadrillas"></div></td>
                  <td><div align="right" class="txtobj">
                    <div align="left">URGENTE&nbsp;&nbsp;</div>
                  </div></td>
                </tr>
                <tr>
                  <td><div class="cuadrillas"></div></td>
                  <td><div align="right" class="txtobj">
                    <div align="left">Para su conocimiento&nbsp;&nbsp;</div>
                  </div></td>
                </tr>
                <tr>
                  <td><div class="cuadrillas"></div></td>
                  <td><span class="txtobj">Preparar Respuesta</span></td>
                </tr>
                <tr>
                  <td><div class="cuadrillas"></div></td>
                  <td><span class="txtobj">Procesar</span></td>
                </tr>
                <tr>
                  <td><div class="cuadrillas"></div></td>
                  <td><span class="txtobj">Preparar Informe</span></td>
                </tr>
                <tr>
                  <td><div class="cuadrillas"></div></td>
                  <td><span class="txtobj">Archivo</span></td>
                </tr>
              </table></td>
            <td><table width="100%" height="170" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td><span class="Estilo12" style="margin-left:10px;">Instruccion Adicional: </span></td>
              </tr>
              <tr>
                <td><div class="cuadroInstruccion">
                      <div align="left"><?php echo $row_listar_destinos['mensaje']; ?></div>
                    </div></td>
              </tr>              
              <tr>
                <td><table width="100%" border="0">
          <tr>
            <td><div align="right">FECHA:&nbsp; </div></td>
            <td width="150"><div class="hojas" style="width:150px;">                      <?php 
					$derivacion=explode(" ",$row_listar_destinos['fecha_derivacion']);
					$fecha=explode("-",$derivacion[0]);
					$hora=explode(":",$derivacion[1]);
					?>
                      <?php
					if ($fecha[2]!="")
					echo $fecha[2]."-".$fecha[1]."-".$fecha[0]; 
					?></div></td>
            <td width="50"><div align="right">HORA  &nbsp;</div></td>
            <td width="150"><div class="hojas" style="width:50px;"> <?php /*echo $hora[0]." h:".$hora[1]." m:".$hora[2]." s"; */
					if ($hora[0]!="")
					echo $hora[0].":".$hora[1];
					
					?></div></td>
            <td width="250">FIRMA :.............................................</td>
          </tr>

        </table></td>
              </tr>
            </table></td>
            <td width="210" valign="top" class="recibido" ><table width="100%" height="175" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td height="27">Recibido/Sello/Firma</td>
              </tr>
              <tr valign="top" style="height:50px;" height="100%">
                <td><table width="100%" height="183" border="1" cellpadding="0" cellspacing="0" class="PROVEIDO">
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      
      <tr>
        <td></td>
      </tr>
    </table>
	</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($obtener_hr);

mysql_free_result($listar_destinos);
?>
