<?php
// HEAD content
?>
<link href="includes/jaxon/widgets/accordion/css/accordion.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="includes/jaxon/widgets/accordion/js/accordion.js"></script>
<link href="includes/jaxon/widgets/tooltip/css/tooltip.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #BCC1D6;
}
.style1 {font-size: 12px}
.style2 {color: #FFFFFF}
.submenu {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #FFFFFF;
	background-color: #444D75;
}
.submenuOver {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #FFFFFF;
	background-color: #444D75;
	border: 1px solid #000033;
	cursor: hand;
	height: 20px;
}
.submenuOut {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #000000;
	background-color: #FFFBEC;
	border: 1px solid #434343;
	height: 20px;
	background-position: center;
}
.Estilo4 {font-size: 13px}
-->
</style>
<script type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  //ventana.onFocus();
  //if(ventana) alert('simpson');
      window.open(theURL,winName,features); 
}
function nuevo(theURL,winName,features) { //v2.0
  //ventana.onFocus();
  //if(ventana) alert('simpson');
  if (estado==0){
      ventana=window.open(theURL,winName,features); 
	  estado=1;
	  }
 else	  
     ventana.window.focus();  
}
//-->
estado=0;
</script>

<?php
// Begin HTML content
?>
<div class="panel__content">
              
              <div id="MenuIzqAcordion" style="width:169px; height:450px; padding:0px; margin:0px; left:0px; top:0px;">
                <div>
                  <h3 style="background-color:#933; padding:5px; font-size:14px;color:#CCC;">CONSULTAS</h3>
                  <div id="MenuIzqAcordionregion0-body" class="accordionBody">
                    <div class="accordionContent">
                      <table width="100%" border="0" cellpadding="1" cellspacing="0" bordercolor="#F5F6F9">
                        <tr bgcolor="#F5F6F9" class="submenuOut" onclick="nuevo('content/consulta_hoja_ruta.php','nueva_entrada','menubar=yes,scrollbars=yes,resizable=yes,width=900,height=580,left=50,top=40')" onmouseover="this.className='submenuOver';" onmouseout="this.className='submenuOut';">
                          <td><img src="img/iconos/NUEVA_ENTRADA.jpg" width="34" height="32" /></td>
                          <td ><div style="font-weight:bold;text-align:center;">CONSULTAR HOJA DE RUTA</div></td>
                        </tr>
                        <tr bgcolor="#5F6A9C" class="submenuOut" onclick="MM_openBrWindow('content/vistasTablas/MisRecibidosHoy.php','','menubar=yes,scrollbars=yes,resizable=yes,width=700,height=500')" onmouseout="this.className='submenuOut';" onmouseover="this.className='submenuOver';">
                          <td><img src="img/iconos/LIBRO_ENTRADAS.jpg" alt="LIBRO" width="34" height="32" longdesc="LIBRO DE ENTRADAS" /></td>
                          <td ><strong>LIBRO DE ENTRADAS</strong><br />
                            &brvbar;</td>
                        </tr>
                        
                        <tr bgcolor="#F5F6F9" class="submenuOut" onclick="MM_openBrWindow('administrador/buscar.php','','menubar=yes,scrollbars=yes,resizable=yes,width=650,height=300')" onmouseout="this.className='submenuOut';" onmouseover="this.className='submenuOver';" >
                          <td><img src="img/iconos/BUSCAR_ENTRADAS.jpg" alt="ICONO" width="34" height="32" longdesc="LIBROS ANTERIORES" /></td>
                          <td><strong>BUSCAR POR REFERENCIA</strong></td>
                          
                        </tr>
                        <tr bgcolor="#F5F6F9" class="submenuOut" onclick="MM_openBrWindow('administrador/sigla.php','','menubar=yes,scrollbars=yes,resizable=yes,width=650,height=300')" onmouseout="this.className='submenuOut';" onmouseover="this.className='submenuOver';" >
                          <td><img src="img/iconos/BUSCAR_ENTRADAS.jpg" alt="ICONO" width="34" height="32" longdesc="LIBROS ANTERIORES" /></td>
                          <td><strong>BUSCAR SIGLA DE HOJA DE RUTA</strong></td>
                          
                        </tr>
                                             
                        <tr bgcolor="#F5F6F9" class="submenuOut" onclick="MM_openBrWindow('content/busca_hr.php','','menubar=yes,scrollbars=yes,resizable=yes,width=880,height=450')" onmouseout="this.className='submenuOut';" onmouseover="this.className='submenuOver';" >
                          <td><img src="img/iconos/BUSCAR_SALIDAS.jpg" alt="ICONO" width="34" height="32" longdesc="BUSCAR HOJA DE RUTA" /></td>
                          <td >CONSULTAR (HojaRuta)</td>
                        </tr>
                        <tr bgcolor="#F5F6F9" class="submenuOut" onclick="MM_openBrWindow('content/verRecibidosFecha.php','','menubar=yes,scrollbars=yes,resizable=yes,width=650,height=300')" onmouseout="this.className='submenuOut';" onmouseover="this.className='submenuOver';" >
                          <td><img src="img/iconos/ENTRADAS_ANTERIORES.jpg" alt="ICONO" width="34" height="32" longdesc="LIBROS ANTERIORES" /></td>
                          <td> LIBROS ANTERIORES</td>
                          
                        </tr>
                      </table>
                     <!-- <a id="<?php echo $ctrl->link_id() ?>" href="<?php
													$ctrl->tooltip("Content", "tooltip_recibir", "250", "100");
													echo $ctrl->link("Content", "");
													?>">&iquest;ayuda?</a>!--></div>
                  </div>
                </div>
              </div>
            
</div>
<?php
// End HTML content
?>