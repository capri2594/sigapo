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


$colname_corresp = "-1";
if (isset($_SESSION['cod_dep'])) {
  $colname_corresp = $_SESSION['cod_dep'];
}
mysql_select_db($database_snet, $snet);
$query_corresp = sprintf("SELECT * FROM entradas, einterna WHERE entradas.id=einterna.entradas_id AND entradas.cod_deprecibido=%s ", GetSQLValueString($colname_corresp, "text"));
$corresp = mysql_query($query_corresp, $snet) or die(mysql_error());
$row_corresp = mysql_fetch_assoc($corresp);
$totalRows_corresp = mysql_num_rows($corresp);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
.cuadro {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #0033FF;
	background-color: #F8FAC6;
	border: 1px solid #0033FF;
	width: 98%;
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
.campo {
	background-color: #FFFFCC;
	border: 1px solid #D6D5D9;
	font-size: 10px;
}
body {
	margin-top: 2px;
	background-color: #F0F0F0;
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
.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #666666;
}
.style2 {color: #000000}
.style3 {background-color: #F8F8F8; border: 1px solid #A7A6AA; height: 20px; font-weight: normal;}
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
	  //alert(document.getElementById('showref').innerHTML);
	  //alert(window.opener.self.document.getElementById('remitente').value);
	  //window.opener.self.document.getElementById('fecha_doc').value=document.getElementById('showfechadoc').value;

	  window.opener.self.document.getElementById('nhojas').value=document.getElementById('showhojas').value;
	  window.opener.self.document.getElementById('nanexos').value=document.getElementById('showanexos').value;
	  //datos remitente....
	  window.opener.self.document.getElementById('fun_remite').value=document.getElementById('showFunRemite').value;
	  window.opener.self.document.getElementById('dep_remite').value=document.getElementById('showDepRemite').value;
	  //mostrar los datos del remitente

 window.opener.self.document.getElementById('remitente').value=document.getElementById('showFunRemite').value;

	 
window.opener.self.document.getElementById('origen').innerHTML=document.getElementById('showDepRemite').value;

/*	  
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
      */
	  //Destinatario
	  window.opener.self.document.getElementById('fun_dest').value=document.getElementById('showFunDest').value;
	  window.opener.self.document.getElementById('dep_dest').value=document.getElementById('showDepDest').value;
	  window.opener.self.document.getElementById('destinatario').innerHTML=document.getElementById('showFunDest').value+" &#8249;&#8249;"+document.getElementById('showDepDest').value+"&#8250;&#8250;";
  //copiando la fecha del documento.
  
 //     alert(document.getElementById('showfechadoc').value);
 
   window.opener.self.document.getElementById('fecha_doc').value=document.getElementById('showfechadoc').value;
	  
	  fechatime=document.getElementById('showfechadoc').value;
	  //alert(fechatime);
	  //trozos=fechatime.split(' ');
      //alert(trozos);
	  // trozos[0]=fecha  y trozos[1]=hora
	  //rescatando la fecha aaaa-mm-dd
	  //fecha=trozos[0].split('-');
	  //insertando en el formulario la fecha
	  fecha=fechatime.split('-');
	  window.opener.self.document.getElementById('aaaa').value=fecha[0];
	  window.opener.self.document.getElementById('mm').value=fecha[1];
	  window.opener.self.document.getElementById('dd').value=fecha[2];
	  
	  //rescatando la hora del doc.
	  /*hora=trozos[1].split(':');
	  window.opener.self.document.getElementById('hora').value=hora[0]+':'+hora[1];
	  */
	  
	  window.opener.self.document.getElementById('einterna_id').value=document.getElementById('show_idinterna').value;
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
			// document.getElementById('showfechadoc').innerHTML=document.getElementById('fecha_doc'+i).value;
			 
			 document.getElementById('showhojas').value=document.getElementById('hojas'+i).value;
			 document.getElementById('showanexos').value=document.getElementById('anexos'+i).value;
			 document.getElementById('showFunRemite').value=document.getElementById('FunRemite'+i).value;
			 document.getElementById('showDepRemite').value=document.getElementById('DepRemite'+i).value;
		document.getElementById('showFunDest').value=document.getElementById('FunDest'+i).value;
			 document.getElementById('showDepDest').value=document.getElementById('DepDest'+i).value;	
		document.getElementById('showfechadoc').value=document.getElementById('fechadoc'+i).value;		  document.getElementById('show_idinterna').value=document.getElementById('id_interna'+i).value;		  
			}
 
		}
	
}
//-->
</script>

</head>

<body>
<form action="" method="post" name="form1" class="style2" id="form1">
  <table width="100%" border="0" cellpadding="0" cellspacing="1" class="contenido">
      <tr>
        <td align="left" valign="middle"><div class="cuadro">
          <table width="98%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="40"><img src="imagen/iconos/info.jpg" width="33" height="29" longdesc="informacion" /></td>
              <td>Seleccione un campo, en la tabla de abajo. Luego presione el Boton APLICAR para seleccionar. Seleccione NUEVO para agregar correspondencia, si no encuentra el documento que busca. </td>
            </tr>
          </table>
          </div></td>
      </tr>
      <tr>
      <td valign="middle"><div align="right">
<table width="121" border="0" cellspacing="1" cellpadding="0">
          <tr >
            
            <td width="100" bordercolor="#F4F4F4" bgcolor="#F0F0F0"><table width="100" border="0" cellpadding="0" cellspacing="1" onclick="location.href='insert_correspondenciaRecibidas3.php';" onmouseover="className='b_over'" onmouseout="className='b_normal'" class="style3">
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
          <td width="200" height="35"><div class="campo" id="remite"></div></td>
          <td width="30"><div align="right">Cite&nbsp;</div></td>
          <td><div class="campo" id="showcite"></div></td>
        </tr>
        <tr>
          <td>para:</td>
          <td height="35"><div class="campo" id="destino"></div></td>
          <td><div align="right">Ref.&nbsp;</div></td>
          <td><div class="campo" id="showref"></div></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><input type="hidden" name="showhojas" id="showhojas" />
            <input type="hidden" name="showFunRemite" id="showFunRemite" />
            <input type="hidden" name="showDepRemite" id="showDepRemite" />
            <input type="hidden" name="showFunDest" id="showFunDest" />
            <input type="hidden" name="showDepDest" id="showDepDest" />
            <input name="showanexos" type="hidden" id="showanexos" />
            <input name="showfechadoc" type="hidden" id="showfechadoc" />
            <input name="show_idinterna" type="hidden" id="show_idinterna" /></td>
        </tr>
      </table></td>
    </tr>
    <tr bgcolor="#F0F0F0">
      <td><div>
        <table width="700" border="1" cellpadding="1" cellspacing="0" bordercolor="#DFE0E1" bgcolor="#CFCFCF">
          <tr>
            <td width="100" bgcolor="#F0F0F0"><div align="center">Cite</div></td>
            <td width="250" bgcolor="#F0F0F0"><div align="center">Referencia</div></td>
            <td width="150" bgcolor="#F0F0F0"><div align="center">Destino</div></td>
            <td width="150" bgcolor="#F0F0F0"><div align="center">Remite</div></td>
            <td width="50" bgcolor="#F0F0F0"><div align="center">&nbsp;&nbsp;</div></td>
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
              <td width="100" >&nbsp;
                  <?php echo $row_corresp['cite']; ?>
                  <input type="hidden" name="cite" id="cite<?php echo $i; ?>"  value="<?php echo $row_corresp['cite']; ?>"/></td>
              <td width="250">&nbsp;<?php echo $row_corresp['ref']; ?>&nbsp;&nbsp;<em>(<?php /*echo $row_corresp['fecha_recibido']; */?><?php $fch=explode("-",$row_corresp['fecha_recibido']); 
			  $dia=explode(" ",$fch[2]);
			  $hora=explode(":",$dia[1]);
			  echo $dia[0]."/".$fch[1]."/".$fch[0]."&nbsp;".$hora[0].":".$hora[1];?>)</em>
                <input type="hidden" name="dia" id="dia" value="<?php  echo $fch[2];?>"/>
                <input type="hidden" name="mes" id="mes" value="<?php  echo $fch[1];?>"/>
                <input type="hidden" name="anio" id="anio" value="<?php  echo $fch[0];?>"/>
                  <input name="ref<?php echo $i; ?>" type="hidden" id="ref<?php echo $i; ?>" value="<?php echo $row_corresp['ref']; ?>" />
                  <input name="id_interna<?php echo $i; ?>" type="hidden" id="id_interna<?php echo $i; ?>" value="<?php echo $row_corresp['id_interna']; ?>" /></td>
              <td width="150" id="destino<?php echo $i; ?>"><?php echo $row_corresp['fun_destino']; ?><br />
                &lt;<?php echo $row_corresp['dep_destino']; ?>&gt;
                <input type="hidden" name="FunDest<?php echo $i; ?>" id="FunDest<?php echo $i; ?>" value="<?php echo $row_corresp['fun_destino']; ?>"/>
                <input type="hidden" name="DepDest<?php echo $i; ?>" id="DepDest<?php echo $i; ?>"  value="<?php echo $row_corresp['dep_destino']; ?>"/>
                <br /></td>
              <td width="150" id="remite<?php echo $i; ?>"><?php echo $row_corresp['fun_remite']; ?><br />
                &lt;<?php echo $row_corresp['dep_remite']; ?>&gt;
                <input type="hidden" name="FunRemite<?php echo $i; ?>" id="FunRemite<?php echo $i; ?>"  value="<?php echo $row_corresp['fun_remite']; ?>"/>
                <input type="hidden" name="DepRemite<?php echo $i; ?>" id="DepRemite<?php echo $i; ?>"  value="<?php echo $row_corresp['dep_remite']; ?>"/></td>
              <td width="50"><input type="checkbox" name="checkbox<?php echo $i?>" id="checkbox<?php echo $i?>" tabindex="1"  value="<?php echo $i;?>" onclick="checkear('checkbox<?php echo $i?>',<?php echo $totalRows_corresp;?>);" />
                  <input type="hidden" name="hojas<?php echo $i; ?>" id="hojas<?php echo $i; ?>" value="<?php echo $row_corresp['nhojas']; ?>" />
                  <input name="anexos<?php echo $i; ?>" type="hidden" id="anexos<?php echo $i; ?>" value="<?php echo $row_corresp['anexos']; ?>" />
                  <input name="fechadoc<?php echo $i; ?>" type="hidden" id="fechadoc<?php echo $i; ?>" value="<?php echo $row_corresp['fecha_doc']; ?>" />
                  <br /></td>
            </tr>
            <?php } // Show if recordset not empty ?>

          <?php } while ($row_corresp = mysql_fetch_assoc($corresp)); ?>
        </table>
      </div></td>
    </tr>

    <tr>
      <td>
      <table width="100%" border="0" align="right" cellpadding="0" cellspacing="0" bgcolor="#F0F0F0">
      <tr>
              <td width="100"><input type="button" name="button4" id="button4" value="Examinar Correspondencia Externa Recibida" &#8218;/></td>
              <td width="100">&nbsp;</td>
              <td width="100" bgcolor="#F8FCFC">&nbsp;</td>
              <td width="100"><table width="100%" border="0" cellspacing="1" cellpadding="0">

                  <tr>
                    <td><input name="button" type="submit" id="button" onclick="MM_openBrWindow('RecibirInternos1.php','vInsertarNuevo','width=650,height=545')" value="Nuevo" /></td>
                    <td><input type="button" name="button3" id="button3" value="Aplicar" onclick="aplicar();" /></td>
                    <td><input type="button" name="button2" id="button2" value="Cerrar" onclick="self.window.close();" /></td>
                  </tr>
                </table></td>
            </tr>
      </table>

</td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
mysql_free_result($corresp);
?>
