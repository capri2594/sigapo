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
$currentPage = $_SERVER["PHP_SELF"];
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
if ($_GET['pag']==1) { 
     $n=0;
  }else{
    $n=$_GET['pag']+2*($_GET['pag']-1)-1;
	
  }
$i=$n+2;
$saltos=3;
mysql_select_db($database_snet, $snet);
$query_listar_destinos = sprintf("SELECT * FROM derivacion WHERE derivacion.hojaruta_cod=%s ORDER BY derivacion.nro_destino ASC", GetSQLValueString($codigo_listar_destinos, "text"));
$query_limit_listar_destinos = sprintf("%s LIMIT %d, %d", $query_listar_destinos, $n, $saltos);
$listar_destinos = mysql_query($query_limit_listar_destinos, $snet) or die(mysql_error());
$row_listar_destinos = mysql_fetch_assoc($listar_destinos);
$totalRows_listar_destinos = mysql_num_rows($listar_destinos);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pagina <?php echo $_GET['pag']; ?></title>
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
	width: auto;
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
body {
	margin: 0px;
	padding: 0px;
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
.Estilo12 {font-size: 12px}
.Estilo19 {font-size: 9px}
.Estilo29 {	font-family: Arial, Helvetica, sans-serif;
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
.PROVEIDO1 {font-family: Arial, Helvetica, sans-serif;
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
.cuadroInstruccion1 {	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	width: auto;
	border: 1px solid #BBDDFF;
	height: 151px;
	margin-top: 0px;
	margin-right: 5px;
	margin-bottom: 0px;
	margin-left: 0px;
	padding: 0px;
}
.destinatarios1 {	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #000000;
	border: 1px solid #000000;
}
.fechabox {	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	margin: 0px;
	padding: 0px;
	width: 180px;
	height: 25px;
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: solid;
	border-left-style: solid;
	border-top-color: #000000;
	border-right-color: #000000;
	border-bottom-color: #000000;
	border-left-color: #000000;
}
.firmabox {	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	margin: 0px;
	padding: 0px;
	width: 200px;
	height: 25px;
	border-top-width: 0px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: solid;
	border-left-style: solid;
	border-top-color: #000000;
	border-right-color: #000000;
	border-bottom-color: #000000;
	border-left-color: #000000;
}
.horabox {	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	margin: 0px;
	padding: 0px;
	width: 80px;
	height: 25px;
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: solid;
	border-left-style: solid;
	border-top-color: #000000;
	border-right-color: #000000;
	border-bottom-color: #000000;
	border-left-color: #000000;
}
.n_destinatario1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 24px;
	color: #000000;
	background-image: url(../arco-8.gif);
	height: 26px;
	width: 23px;
	background-repeat: no-repeat;
	background-position: left top;
	margin: 0px;
	padding: 0px;
}
.objeto1 {	font-family: Arial, Helvetica, sans-serif;
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
.recibido {	border-top-width: 1px;
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
.txtobj {	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
}
.cuadroEncab {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	margin: 0px;
	padding: 0px;
	width: 100%;
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
}
.cuadroPag {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	margin: 0px;
	padding: 0px;
	width: 50px;
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: solid;
	border-left-style: solid;
	border-top-color: #000000;
	border-right-color: #000000;
	border-bottom-color: #000000;
	border-left-color: #000000;
}
.cuadroHR {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	margin: 0px;
	padding: 0px;
	width: 150px;
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: solid;
	border-top-color: #000000;
	border-right-color: #000000;
	border-bottom-color: #000000;
	border-left-color: #000000;
}
.cuadroPagHead {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	width: 50px;
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
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	margin-left: 5px;
	padding-top: 0px;
	padding-right: 0px;
	padding-bottom: 0px;
	padding-left: 2px;
}
.objeto2 {	font-family: Arial, Helvetica, sans-serif;
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
	width: auto;
	vertical-align: bottom;
	font-size: 10px;
}
-->
</style>
</head>

<body>
<table width="100%" border="0">
  <tr>
    <td style="width:100%;"><table width="100%" border="0" class="destinatarios">
      <tr>
        <td colspan="5" style="width:100%;"><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td><table width="100%" border="0" bgcolor="#FBFDFF" class="cuadroEncab">
                <tr>
                  <td><img src="../../imagen/escudo_oruro001 copia.jpg" alt="ESCUDO" width="52" height="55" longdesc="BOLIVIA" /></td>
                  <td><table width="100%" border="0">
                      <tr>
                        <td height="10"><div align="center" class="Estilo22">GOBIERNO AUTONOMO DEPARTAMENTAL  DE ORURO</div></td>
                      </tr>
                      <tr>
                        <td height="10"><div align="center" class="Estilo6 Estilo23"><?php echo $_SESSION['dep']; ?></div></td>
                      </tr>
                      <tr>
                        <td height="10"><div align="center" class="Estilo12"><strong>H&nbsp;O&nbsp;J&nbsp;A &nbsp;&nbsp;&nbsp;&nbsp;D&nbsp;E &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;R&nbsp;U&nbsp;T&nbsp;A</strong></div></td>
                      </tr>
                  </table></td>
                  <td width="150" class="cuadroHR"><table width="100%" border="0" style="height:60px;">
                    <tr>
                      <td><span class="Estilo12 Estilo18">CODIGO Nº :</span></td>
                    </tr>
                    <tr>
                      <td><span class="CollapsiblePanelTabHover Estilo38" style="font-size:16px; font-weight:bold;"><?php echo $_GET['cod']; ?></span></td>
                    </tr>
                    <tr style="height:12px;">
                      <td><span class="Estilo19">Use el codigo para  seguimiento</span></td>
                    </tr>
                  </table></td>
                </tr>
            </table></td>
            <td width="60" valign="top" class="cuadroPag"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="height:60px;">
                <tr>
                  <td class="cuadroPagHead"><span class="Estilo12 Estilo18">Pagina</span></td>
                </tr>
                <tr>
                  <td><div align="center"><span style="font-size:23px; font-weight:bold;"><strong><?php echo $_GET['pag']; ?></strong></span></div></td>
                </tr>

            </table></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td width="180"><div align="right">Remitente:&nbsp;</div></td>
        <td><div align="left" class="objeto Estilo28">
          <?php $Texto=$row_obtener_hr['procedencia'];if (strlen($Texto) > 50){
  echo substr($Texto,0,48).'...';
}else{
  echo substr($Texto,0,50);
} ?>
        </div></td>
        <td width="10">&nbsp;</td>
        <td width="70"><div align="right">hojas:&nbsp;</div></td>
        <td width="130"><div align="left" class="hojas"><?php echo $row_obtener_hr['nhojas']; ?></div></td>
      </tr>
      <tr>
        <td width="180"><div align="right">asunto/referencia:&nbsp;</div></td>
        <td><div align="left" class="Estilo27">
          <?php $Texto=$row_obtener_hr['ref'];
		if (strlen($Texto) > 120){
  echo substr($Texto,0,120).'...';
}else{
  echo substr($Texto,0,120);
}?>
        </div></td>
        <td width="10">&nbsp;</td>
        <td width="70"><div align="right">anexos:&nbsp;</div></td>
        <td width="130"><div align="left" class="hojas"><?php echo $row_obtener_hr['nanexos']; ?></div></td>
      </tr>

    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="destinatarios1">
      <tr>
        <td><table width="100%" border="0">
            <tr>
              <td><table width="100%" border="0" >
                  <tr>
                    <td width="34" align="left"><div class="n_destinatario1">
                      <?php echo $i++;//$row_listar_destinos['nro_destino'];?>
                    </div></td>
                    <td width="132"><strong>DESTINATARIO: </strong></td>
                    <td width="100%"><div align="left" class="objeto Estilo28"><?php echo $row_listar_destinos['fun_destino']; ?></div></td>
                    <td width="70">&nbsp;</td>
                    <td width="70"><div align="right">hojas:&nbsp;</div></td>
                    <td width="130"><div align="left" class="hojas"><?php echo $row_listar_destinos['nhojas']; ?></div></td>
                  </tr>
                  <tr>
                    <td width="130"></td>
                    <td align="right" valign="top"><strong>LUGAR:&nbsp;</strong></td>
                    <td valign="top"><div align="left"><span style="width:97%;"><span align="left" class="Estilo29" style="font-weight:bold">
                      <?php if ($row_listar_destinos['dep_destino']!="") {?>
                      (<?php echo $row_listar_destinos['dep_destino']; ?>)
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
              <td valign="top"><table width="100%" border="0" cellspacing="4" cellpadding="0" style="width:100px;">
                <tr>
                  <td><div class="cuadrillas">
                    <?php if (strtoupper($row_listar_destinos['proveido'])=='URGENTE'){?>
                    <img src="../../imagen/botones/checkbox_on.png" width="14" height="14" />
                    <?php }?>
                  </div></td>
                  <td><div align="right" class="txtobj">
                      <div align="left">URGENTE&nbsp;&nbsp;</div>
                  </div></td>
                </tr>
                <tr>
                  <td><div class="cuadrillas">
                    <?php if (strtoupper($row_listar_destinos['proveido'])=='PARA SU CONOCIMIENTO'){?>
                    <img src="../../imagen/botones/checkbox_on.png" width="14" height="14" />
                    <?php }?>
                  </div></td>
                  <td><div align="right" class="txtobj">
                      <div align="left">Para su conocimiento&nbsp;&nbsp;</div>
                  </div></td>
                </tr>
                <tr>
                  <td><div class="cuadrillas">
                    <?php if (strcmp(strtoupper($row_listar_destinos['proveido']),'PREPARAR RESPUESTA')==0){?>
                    <img src="../../imagen/botones/checkbox_on.png" width="14" height="14" />
                    <?php }?>
                  </div></td>
                  <td><span class="txtobj">Preparar Respuesta</span></td>
                </tr>
                <tr>
                  <td><div class="cuadrillas">
                    <?php if (strcmp(strtoupper($row_listar_destinos['proveido']),'PROCESAR')==0){?>
                    <img src="../../imagen/botones/checkbox_on.png" width="14" height="14" />
                    <?php }?>
                  </div></td>
                  <td><span class="txtobj">Procesar</span></td>
                </tr>
                <tr>
                  <td><div class="cuadrillas">
                    <?php if (strcmp(strtoupper($row_listar_destinos['proveido']),'PREPARAR INFORME')==0){?>
                    <img src="../../imagen/botones/checkbox_on.png" width="14" height="14" />
                    <?php }?>
                  </div></td>
                  <td><span class="txtobj">Preparar Informe</span></td>
                </tr>
                <tr>
                  <td><div class="cuadrillas">
                    <?php if (strcmp(strtoupper($row_listar_destinos['proveido']),'ARCHIVO')==0){?>
                    <img src="../../imagen/botones/checkbox_on.png" width="14" height="14" />
                    <?php }?>
                  </div></td>
                  <td><span class="txtobj">Archivo</span></td>
                </tr>
              </table></td>
              <td><table width="100%" height="209" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td></td>
                  </tr>
                  <tr>
                    <td style="margin-top:0px; padding-top:0px; margin-bottom:0px; padding-bottom:0px;"><div class="cuadroInstruccion1"><span class="Estilo12" style="margin-left:10px;">Instruccion Adicional: </span>
                            <div align="left" style="margin-left:10px;"><?php echo $row_listar_destinos['mensaje']; ?></div>
                    </div></td>
                  </tr>
                  <tr>
                    <td style="margin-top:0px; padding-top:0px;"><table width="100%" border="0" cellpadding="0">
                        <tr>
                          <td width="150" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td class="fechabox"><?php 
					$derivacion=explode(" ",$row_listar_destinos['fecha_derivacion']);
					$fecha=explode("-",$derivacion[0]);
					$hora=explode(":",$derivacion[1]);
					?>
                                    <?php
					if ($fecha[2]!="")
					echo $fecha[2]."-".$fecha[1]."-".$fecha[0]; 
					?>                                </td>
                              </tr>
                              <tr>
                                <td><div align="left"><span class="Estilo19" style="font-size:9px">FECHA</span> (DD-MM-AA) </div></td>
                              </tr>
                          </table></td>
                          <td align="left" valign="top" style="width:80px;"><div align="left">
                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td class="horabox" ><?php /*echo $hora[0]." h:".$hora[1]." m:".$hora[2]." s"; */
					if ($hora[0]!="")
					echo $hora[0].":".$hora[1];
					
					?>                                  </td>
                                </tr>
                                <tr>
                                  <td><div align="left" class="Estilo19" style="font-size:9px">HORA (HH:MM) </div></td>
                                </tr>
                              </table>
                          </div></td>
                          <td width="250" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:0px; padding:0px;">
                              <tr>
                                <td style="margin:0px; padding:0px;"><div class="firmabox" style="width:auto;"></div></td>
                              </tr>
                              <tr style="margin:0px; padding:0px;">
                                <td style="margin:0px; padding:0px;"><div align="center" style="font-size:9px">Firma/Nombre/Cargo</div></td>
                              </tr>
                          </table></td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
              <td width="210" valign="top" class="recibido" ><table width="100%" height="175" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td height="27">Recibido/Sello/Firma</td>
                  </tr>
                  <tr valign="top" style="height:50px;" height="100%">
                    <td><table width="100%" height="183" border="1" cellpadding="0" cellspacing="0" class="PROVEIDO1">
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
    <?php $row_listar_destinos = mysql_fetch_assoc($listar_destinos)?></td>
  </tr>
 
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="destinatarios1">
      <tr>
        <td><table width="100%" border="0">
            <tr>
              <td><table width="100%" border="0" >
                  <tr>
                    <td width="34" align="left"><div class="n_destinatario1"><?php echo $i++;?></div></td>
                    <td width="132"><strong>DESTINATARIO: </strong></td>
                    <td width="100%"><div align="left" class="objeto Estilo28"><?php echo $row_listar_destinos['fun_destino']; ?></div></td>
                    <td width="70">&nbsp;</td>
                    <td width="70"><div align="right">hojas:&nbsp;</div></td>
                    <td width="130"><div align="left" class="hojas"><?php echo $row_listar_destinos['nhojas']; ?></div></td>
                  </tr>
                  <tr>
                    <td width="130"></td>
                    <td align="right" valign="top"><strong>LUGAR:&nbsp;</strong></td>
                    <td valign="top"><div align="left"><span style="width:97%;"><span align="left" class="Estilo29" style="font-weight:bold">
                      <?php if ($row_listar_destinos['dep_destino']!="") {?>
                      (<?php echo $row_listar_destinos['dep_destino']; ?>)
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
              <td valign="top"><table width="100%" border="0" cellspacing="4" cellpadding="0" style="width:100px;">
                <tr>
                  <td><div class="cuadrillas">
                    <?php if (strtoupper($row_listar_destinos['proveido'])=='URGENTE'){?>
                    <img src="../../imagen/botones/checkbox_on.png" width="14" height="14" />
                    <?php }?>
                  </div></td>
                  <td><div align="right" class="txtobj">
                      <div align="left">URGENTE&nbsp;&nbsp;</div>
                  </div></td>
                </tr>
                <tr>
                  <td><div class="cuadrillas">
                    <?php if (strtoupper($row_listar_destinos['proveido'])=='PARA SU CONOCIMIENTO'){?>
                    <img src="../../imagen/botones/checkbox_on.png" width="14" height="14" />
                    <?php }?>
                  </div></td>
                  <td><div align="right" class="txtobj">
                      <div align="left">Para su conocimiento&nbsp;&nbsp;</div>
                  </div></td>
                </tr>
                <tr>
                  <td><div class="cuadrillas">
                    <?php if (strcmp(strtoupper($row_listar_destinos['proveido']),'PREPARAR RESPUESTA')==0){?>
                    <img src="../../imagen/botones/checkbox_on.png" width="14" height="14" />
                    <?php }?>
                  </div></td>
                  <td><span class="txtobj">Preparar Respuesta</span></td>
                </tr>
                <tr>
                  <td><div class="cuadrillas">
                    <?php if (strcmp(strtoupper($row_listar_destinos['proveido']),'PROCESAR')==0){?>
                    <img src="../../imagen/botones/checkbox_on.png" width="14" height="14" />
                    <?php }?>
                  </div></td>
                  <td><span class="txtobj">Procesar</span></td>
                </tr>
                <tr>
                  <td><div class="cuadrillas">
                    <?php if (strcmp(strtoupper($row_listar_destinos['proveido']),'PREPARAR INFORME')==0){?>
                    <img src="../../imagen/botones/checkbox_on.png" width="14" height="14" />
                    <?php }?>
                  </div></td>
                  <td><span class="txtobj">Preparar Informe</span></td>
                </tr>
                <tr>
                  <td><div class="cuadrillas">
                    <?php if (strcmp(strtoupper($row_listar_destinos['proveido']),'ARCHIVO')==0){?>
                    <img src="../../imagen/botones/checkbox_on.png" width="14" height="14" />
                    <?php }?>
                  </div></td>
                  <td><span class="txtobj">Archivo</span></td>
                </tr>
              </table></td>
              <td><table width="100%" height="209" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td></td>
                  </tr>
                  <tr>
                    <td style="margin-top:0px; padding-top:0px; margin-bottom:0px; padding-bottom:0px;"><div class="cuadroInstruccion1"><span class="Estilo12" style="margin-left:10px;">Instruccion Adicional: </span>
                            <div align="left" style="margin-left:10px;"><?php echo $row_listar_destinos['mensaje']; ?></div>
                    </div></td>
                  </tr>
                  <tr>
                    <td style="margin-top:0px; padding-top:0px;"><table width="100%" border="0" cellpadding="0">
                        <tr>
                          <td width="150" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td class="fechabox"><?php 
					$derivacion=explode(" ",$row_listar_destinos['fecha_derivacion']);
					$fecha=explode("-",$derivacion[0]);
					$hora=explode(":",$derivacion[1]);
					?>
                                    <?php
					if ($fecha[2]!="")
					echo $fecha[2]."-".$fecha[1]."-".$fecha[0]; 
					?>                                </td>
                              </tr>
                              <tr>
                                <td><div align="left"><span class="Estilo19" style="font-size:9px">FECHA</span> (DD-MM-AA) </div></td>
                              </tr>
                          </table></td>
                          <td align="left" valign="top" style="width:80px;"><div align="left">
                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td class="horabox" ><?php /*echo $hora[0]." h:".$hora[1]." m:".$hora[2]." s"; */
					if ($hora[0]!="")
					echo $hora[0].":".$hora[1];
					
					?>                                  </td>
                                </tr>
                                <tr>
                                  <td><div align="left" class="Estilo19" style="font-size:9px">HORA (HH:MM) </div></td>
                                </tr>
                              </table>
                          </div></td>
                          <td width="250" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:0px; padding:0px;">
                              <tr>
                                <td style="margin:0px; padding:0px;"><div class="firmabox" style="width:auto;"></div></td>
                              </tr>
                              <tr style="margin:0px; padding:0px;">
                                <td style="margin:0px; padding:0px;"><div align="center" style="font-size:9px">Firma/Nombre/Cargo</div></td>
                              </tr>
                          </table></td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
              <td width="210" valign="top" class="recibido" ><table width="100%" height="175" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td height="27">Recibido/Sello/Firma</td>
                  </tr>
                  <tr valign="top" style="height:50px;" height="100%">
                    <td><table width="100%" height="183" border="1" cellpadding="0" cellspacing="0" class="PROVEIDO1">
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
    <?php $row_listar_destinos = mysql_fetch_assoc($listar_destinos)?></td>
  </tr>
    <tr>
      <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="destinatarios1">
        <tr>
          <td><table width="100%" border="0">
              <tr>
                <td><table width="100%" border="0" >
                    <tr>
                      <td width="34" align="left"><div class="n_destinatario1">
                        <?php echo $i++;?>
                      </div></td>
                      <td width="132"><strong>DESTINATARIO: </strong></td>
                      <td width="100%"><div align="left" class="objeto Estilo28"><?php echo $row_listar_destinos['fun_destino']; ?></div></td>
                      <td width="70">&nbsp;</td>
                      <td width="70"><div align="right">hojas:&nbsp;</div></td>
                      <td width="130"><div align="left" class="hojas"><?php echo $row_listar_destinos['nhojas']; ?></div></td>
                    </tr>
                    <tr>
                      <td width="130"></td>
                      <td align="right" valign="top"><strong>LUGAR:&nbsp;</strong></td>
                      <td valign="top"><div align="left"><span style="width:97%;"><span align="left" class="Estilo29" style="font-weight:bold">
                        <?php if ($row_listar_destinos['dep_destino']!="") {?>
                        (<?php echo $row_listar_destinos['dep_destino']; ?>)
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
                <td valign="top"><table width="100%" border="0" cellspacing="4" cellpadding="0" style="width:100px;">
                  <tr>
                    <td><div class="cuadrillas">
                      <?php if (strtoupper($row_listar_destinos['proveido'])=='URGENTE'){?>
                      <img src="../../imagen/botones/checkbox_on.png" width="14" height="14" />
                      <?php }?>
                    </div></td>
                    <td><div align="right" class="txtobj">
                        <div align="left">URGENTE&nbsp;&nbsp;</div>
                    </div></td>
                  </tr>
                  <tr>
                    <td><div class="cuadrillas">
                      <?php if (strtoupper($row_listar_destinos['proveido'])=='PARA SU CONOCIMIENTO'){?>
                      <img src="../../imagen/botones/checkbox_on.png" width="14" height="14" />
                      <?php }?>
                    </div></td>
                    <td><div align="right" class="txtobj">
                        <div align="left">Para su conocimiento&nbsp;&nbsp;</div>
                    </div></td>
                  </tr>
                  <tr>
                    <td><div class="cuadrillas">
                      <?php if (strcmp(strtoupper($row_listar_destinos['proveido']),'PREPARAR RESPUESTA')==0){?>
                      <img src="../../imagen/botones/checkbox_on.png" width="14" height="14" />
                      <?php }?>
                    </div></td>
                    <td><span class="txtobj">Preparar Respuesta</span></td>
                  </tr>
                  <tr>
                    <td><div class="cuadrillas">
                      <?php if (strcmp(strtoupper($row_listar_destinos['proveido']),'PROCESAR')==0){?>
                      <img src="../../imagen/botones/checkbox_on.png" width="14" height="14" />
                      <?php }?>
                    </div></td>
                    <td><span class="txtobj">Procesar</span></td>
                  </tr>
                  <tr>
                    <td><div class="cuadrillas">
                      <?php if (strcmp(strtoupper($row_listar_destinos['proveido']),'PREPARAR INFORME')==0){?>
                      <img src="../../imagen/botones/checkbox_on.png" width="14" height="14" />
                      <?php }?>
                    </div></td>
                    <td><span class="txtobj">Preparar Informe</span></td>
                  </tr>
                  <tr>
                    <td><div class="cuadrillas">
                      <?php if (strcmp(strtoupper($row_listar_destinos['proveido']),'ARCHIVO')==0){?>
                      <img src="../../imagen/botones/checkbox_on.png" width="14" height="14" />
                      <?php }?>
                    </div></td>
                    <td><span class="txtobj">Archivo</span></td>
                  </tr>
                </table></td>
                <td><table width="100%" height="209" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td></td>
                    </tr>
                    <tr>
                      <td style="margin-top:0px; padding-top:0px; margin-bottom:0px; padding-bottom:0px;"><div class="cuadroInstruccion1"><span class="Estilo12" style="margin-left:10px;">Instruccion Adicional: </span>
                              <div align="left" style="margin-left:10px;"><?php echo $row_listar_destinos['mensaje']; ?></div>
                      </div></td>
                    </tr>
                    <tr>
                      <td style="margin-top:0px; padding-top:0px;"><table width="100%" border="0" cellpadding="0">
                          <tr>
                            <td width="150" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td class="fechabox"><?php 
					$derivacion=explode(" ",$row_listar_destinos['fecha_derivacion']);
					$fecha=explode("-",$derivacion[0]);
					$hora=explode(":",$derivacion[1]);
					?>
                                      <?php
					if ($fecha[2]!="")
					echo $fecha[2]."-".$fecha[1]."-".$fecha[0]; 
					?>                                  </td>
                                </tr>
                                <tr>
                                  <td><div align="left"><span class="Estilo19" style="font-size:9px">FECHA</span> (DD-MM-AA) </div></td>
                                </tr>
                            </table></td>
                            <td align="left" valign="top" style="width:80px;"><div align="left">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td class="horabox" ><?php /*echo $hora[0]." h:".$hora[1]." m:".$hora[2]." s"; */
					if ($hora[0]!="")
					echo $hora[0].":".$hora[1];
					
					?>                                    </td>
                                  </tr>
                                  <tr>
                                    <td><div align="left" class="Estilo19" style="font-size:9px">HORA (HH:MM) </div></td>
                                  </tr>
                                </table>
                            </div></td>
                            <td width="250" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:0px; padding:0px;">
                                <tr>
                                  <td style="margin:0px; padding:0px;"><div class="firmabox" style="width:auto;"></div></td>
                                </tr>
                                <tr style="margin:0px; padding:0px;">
                                  <td style="margin:0px; padding:0px;"><div align="center" style="font-size:9px">Firma/Nombre/Cargo</div></td>
                                </tr>
                            </table></td>
                          </tr>
                      </table></td>
                    </tr>
                </table></td>
                <td width="210" valign="top" class="recibido" ><table width="100%" height="175" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td height="27">Recibido/Sello/Firma</td>
                    </tr>
                    <tr valign="top" style="height:50px;" height="100%">
                      <td><table width="100%" height="183" border="1" cellpadding="0" cellspacing="0" class="PROVEIDO1">
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
</table>
</body>
</html>
<?php
mysql_free_result($obtener_hr);

mysql_free_result($listar_destinos);
?>
