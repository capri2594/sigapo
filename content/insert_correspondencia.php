<?php 
session_name("LoginSIRC");
session_start();
$cod_dep=$_SESSION['cod_dep'];
?>
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


$depto_corresp = "-1";
if (isset($_SESSION['dep'])) {
  $depto_corresp = $_SESSION['dep'];
}
mysql_select_db($database_snet, $snet);
$query_corresp = sprintf("SELECT * FROM salinternas, salidas WHERE salinternas.salidas_cite=salidas.cite and salidas.fun_proveido is NULL and salidas.dep_remitente=%s ORDER BY salidas.fecha_envio DESC", GetSQLValueString($depto_corresp, "text"));
$corresp = mysql_query($query_corresp, $snet) or die(mysql_error());
$row_corresp = mysql_fetch_assoc($corresp);
$totalRows_corresp = mysql_num_rows($corresp);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Insertar Correspondencia</title>
<style type="text/css">
<!--
.contenido {
	font-size: 11px;
	overflow: scroll;
	height: 150px;
	width: 718px;
	margin: 0px;
	padding: 0px;
	background-color: #F8FCFC;
}
.elegido {
	background-color: #FFFFB9;
}
body {
	background-color: #FFFFFF;
}
.fila {
	background-color: #FFFFFF;
}
.filaover {
	background-color: #FFFFAE;
}
.b_over {
	background-color: #E3E9F4;
	border: 1px solid #A7A6AA;
	font-weight: normal;
	color: #003366;
	cursor: hand;
}
.b_normal {
	font-weight: normal;
	color: #000000;
	background-color: #F8F8F8;
	border: 1px solid #A7A6AA;
	height: 20px;
}
.campo {
	background-color: #FFFFCC;
	border: 1px solid #D6D5D9;
	font-size: 10px;
}
body {
	margin-top: 2px;
}
.Estilo1 {font-size: 10px}
-->
</style>
<script>
function aplicar() { 
//v9.0
	  window.opener.self.document.getElementById('showcite').innerHTML=document.getElementById('showcite').innerHTML;
	  //leer hora
	  //alert(window.opener.self.document.getElementById('cite').value);
	  //alert(document.getElementById('showcite').innerHTML);
	  window.opener.self.document.getElementById('cite').value=document.getElementById('showcite').innerHTML;
	   //alert(window.opener.self.document.getElementById('cite').value);
	  window.opener.self.document.getElementById('ref').value=document.getElementById('showref').innerHTML;
	  window.opener.self.document.getElementById('nhojas').value=document.getElementById('showhojas').value;
	  //datos remitente....
	  window.opener.self.document.getElementById('fun_remite').value=document.getElementById('showFunRemite').value;
	  window.opener.self.document.getElementById('dep_remite').value=document.getElementById('showDepRemite').value;
	  num_remitentes=window.opener.self.document.getElementById('remitentes').length;
	  //alert('n= '+num_remitentes);
	  elegido=document.getElementById('showFunRemite').value;
	  //alert(elegido);
	  for(i=0;i<num_remitentes;i++){
          items=window.opener.self.document.getElementById('remitentes').options[i].value;
		  //alert('hola='+items+"="+elegido);
		  if (items==elegido){
		    //alert ('encontrado a ='+items);
			if (window.opener.self.document.getElementById('remitentes').disabled=='disabled')
			      window.opener.self.document.getElementById('remitentes').disabled= 'enabled';
		    window.opener.self.document.getElementById('remitentes').options[i].selected = true;
			window.opener.self.document.getElementById('remitentes').disabled= 'disabled';
			
			}
			window.opener.self.document.getElementById('pdestinatarios').style.visibility= 'hidden';
	  }  
      
	  //Destinatario
	  window.opener.self.document.getElementById('fun_dest').value=document.getElementById('showFunDest').value;
	  window.opener.self.document.getElementById('dep_dest').value=document.getElementById('showDepDest').value;
	  window.opener.self.document.getElementById('destinatario').innerHTML=document.getElementById('showFunDest').value+" &#8249;&#8249;"+document.getElementById('showDepDest').value+"&#8250;&#8250;";
	
	  window.top.close();
	
}

function mostrar(nomX,depX) { 
//v9.0

    with (document) 
	if (getElementById && ((objnom=getElementById(nomX))!=null)&& ((objdep=getElementById(depX))!=null)) 
	{ 

	  window.opener.self.document.getElementById('fun_destino').value=objnom.innerHTML;
	  //leer hora
	  
	  window.opener.self.document.getElementById('dep_destino').value=objdep.innerHTML;
	  //alert("se ha insertado correctamente....");
	  window.top.close();
	}else
	alert("SIRC error: al insertar registro");
}

function checkear(check,n) { 
//v9.0
    //alert(check);
	//alert("checkeando");
	//alert(document.form1.checkbox10.value);
    with (document) 
	if (objcheck=getElementById(check))
	    for(i=1;i<=n;i++){
		   otros=getElementById('checkbox'+i);
		    if (objcheck!=otros) { 

				if (otros.checked) 
				  {   //deshabilitando la activacion 
				      otros.checked=false;				     
				  }
			    //quitando el estilo
				getElementById('fila'+i).className='fila'; 				 
				
				   
			}
			else{
			 objcheck.checked=true;
			 getElementById('fila'+i).className='elegido';
			 //motrando losdatos elegidos
			 document.getElementById('remite').innerHTML=document.getElementById('remite'+i).innerHTML;
			 document.getElementById('destino').innerHTML=document.getElementById('destino'+i).innerHTML;
			 document.getElementById('showcite').innerHTML=document.getElementById('cite'+i).value;			 
			 document.getElementById('showref').innerHTML=document.getElementById('ref'+i).value;
			 document.getElementById('showhojas').value=document.getElementById('hojas'+i).value;
			 document.getElementById('showFunRemite').value=document.getElementById('FunRemite'+i).value;
			 document.getElementById('showDepRemite').value=document.getElementById('DepRemite'+i).value;
		document.getElementById('showFunDest').value=document.getElementById('FunDest'+i).value;
			 document.getElementById('showDepDest').value=document.getElementById('DepDest'+i).value;	 
			}
 
		}
	
}
//-->
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>

</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="100%" border="0" cellpadding="0" cellspacing="1" class="contenido">
      <tr>
      <td valign="middle"><div align="right">
        <table width="121" border="0" cellspacing="1" cellpadding="0">
          <tr >
            
            <td width="100" bordercolor="#F4F4F4" bgcolor="#F0F0F0"><table width="100" border="0" cellspacing="1" cellpadding="0" onmouseover="className='b_over'" onmouseout="className='b_normal'" class="b_normal" onclick="location.href='insert_correspondencia.php';">
                <tr>
                  <td><span class="Estilo1"><img src="actualizar.gif" width="20" height="17" /></span></td>
                  <td><span class="Estilo1">ACTUALIZAR</span></td>
                </tr>
              </table></td>
            <td width="18"><div align="right"></div></td>
          </tr>
        </table>
      </div></td>
    </tr>
    <tr>
      <td><table width="700" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="30">de:</td>
          <td width="200"><div class="campo" id="remite">Ver&aacute; aqui el valor del  "campo" elegido</div></td>
          <td width="30"><div align="right">Cite&nbsp;</div></td>
          <td><div class="campo" id="showcite">Ver&aacute; aqui el valor del  &quot;campo&quot; elegido</div></td>
        </tr>
        <tr>
          <td>para:</td>
          <td><div class="campo" id="destino">Ver&aacute; aqui el valor del  &quot;campo&quot; elegido</div></td>
          <td><div align="right">Ref.&nbsp;</div></td>
          <td><div class="campo" id="showref">Ver&aacute; aqui el valor del  &quot;campo&quot; elegido</div></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><input type="hidden" name="showhojas" id="showhojas" />
            <input type="hidden" name="showFunRemite" id="showFunRemite" />
            <input type="hidden" name="showDepRemite" id="showDepRemite" />
            <input type="hidden" name="showFunDest" id="showFunDest" />
            <input type="hidden" name="showDepDest" id="showDepDest" /></td>
        </tr>
      </table></td>
    </tr>
    <tr bgcolor="#F0F0F0">
      <td><div>
        <table width="700" border="1" cellpadding="1" cellspacing="0" bordercolor="#DFE0E1" bgcolor="#F0F0F0">
          <tr>
            <td width="100"><div align="center">Cite</div></td>
            <td width="250"><div align="center">Referencia</div></td>
            <td width="150"><div align="center">Destino</div></td>
            <td width="150"><div align="center">Remite</div></td>
            <td width="50"><div align="center">&nbsp;&nbsp;</div></td>
          </tr>
        </table>
      </div></td>
    </tr>
    <tr>
      <td><div class="contenido">
        <table width="700" border="1" cellspacing="0" cellpadding="1">

            <tr  onclick="checkear('checkbox<?php echo $i?>',<?php echo $totalRows_corresp;?>);">
              <?php if ($totalRows_corresp == 0) { // Show if recordset empty ?>
                <td colspan="5" id="cite<?php echo $i; ?>2">No se encontraron correspondencias de su Unidad/dependencia o Area.</td>
                <?php } // Show if recordset empty ?>
</tr>
          <?php $i=0;?>
          <?php do { ?>
          <?php $i++;?>
          <?php if ($totalRows_corresp > 0) { // Show if recordset not empty ?>
            <tr id="fila<?php echo $i; ?>"  onclick="checkear('checkbox<?php echo $i?>',<?php echo $totalRows_corresp;?>);">
              <td width="100" >&nbsp;<?php echo $row_corresp['salidas_cite']; ?>
                  <input type="hidden" name="cite" id="cite<?php echo $i; ?>"  value="<?php echo $row_corresp['salidas_cite']; ?>"/></td>
              <td width="250">&nbsp;<?php echo $row_corresp['ref']; ?>&nbsp;&nbsp;<em>(<?php /*echo $row_corresp['fecha_envio']; */?><?php $fch=explode("-",$row_corresp['fecha_envio']); 
			  $dia=explode(" ",$fch[2]);
			  $hora=explode(":",$dia[1]);
			  echo $dia[0]."/".$fch[1]."/".$fch[0]."&nbsp;".$hora[0].":".$hora[1];?>)</em>
                  <input type="hidden" name="dia" id="dia" value="<?php  echo $fch[2];?>"/>
                  <input type="hidden" name="mes" id="mes" value="<?php  echo $fch[1];?>"/>
                  <input type="hidden" name="anio" id="anio" value="<?php  echo $fch[0];?>"/>
                  <input name="ref<?php echo $i; ?>" type="hidden" id="ref<?php echo $i; ?>" value="<?php echo $row_corresp['ref']; ?>" /></td>
              <td width="150" id="destino<?php echo $i; ?>"><?php echo $row_corresp['fun_destino']; ?><br />
                &lt;<?php echo $row_corresp['dep_destino']; ?>&gt;
                <input type="hidden" name="FunDest<?php echo $i; ?>" id="FunDest<?php echo $i; ?>" value="<?php echo $row_corresp['fun_destino']; ?>"/>
                <input type="hidden" name="DepDest<?php echo $i; ?>" id="DepDest<?php echo $i; ?>"  value="<?php echo $row_corresp['dep_destino']; ?>"/>
                <br /></td>
              <td width="150" id="remite<?php echo $i; ?>"><?php echo $row_corresp['fun_remitente']; ?><br />
                &lt;<?php echo $row_corresp['dep_remitente']; ?>&gt;
                <input type="hidden" name="FunRemite<?php echo $i; ?>" id="FunRemite<?php echo $i; ?>"  value="<?php echo $row_corresp['fun_remitente']; ?>"/>
                <input type="hidden" name="DepRemite<?php echo $i; ?>" id="DepRemite<?php echo $i; ?>"  value="<?php echo $row_corresp['dep_remitente']; ?>"/></td>
              <td width="50"><input type="checkbox" name="checkbox<?php echo $i?>" id="checkbox<?php echo $i?>" tabindex="1"  value="<?php echo $i;?>" onclick="checkear('checkbox<?php echo $i?>',<?php echo $totalRows_corresp;?>);" />
                  <input type="hidden" name="hojas<?php echo $i; ?>" id="hojas<?php echo $i; ?>" value="<?php echo $row_corresp['nhojas']; ?>" />
                  <br /></td>
            </tr>
            <?php } // Show if recordset not empty ?>

          <?php } while ($row_corresp = mysql_fetch_assoc($corresp)); ?>
        </table>
      </div></td>
    </tr>

    <tr>
      <td><table width="308" border="1" align="right" cellpadding="0" cellspacing="0" bgcolor="#F0F0F0">
            <tr>
              <td width="100"><input name="button" type="submit" id="button" onclick="MM_openBrWindow('enviarInternos.php','vInsertarNuevo','width=650,height=545')" value="Nuevo" /></td>
              <td width="100"><input type="button" name="button3" id="button3" value="Aplicar" onclick="aplicar();" /></td>
              <td width="100"><input type="button" name="button2" id="button2" value="Cerrar" onclick="self.window.close();" /></td>
            </tr>
        </table></td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
mysql_free_result($corresp);
?>
