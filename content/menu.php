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
              <div id="MenuIzqAcordion" class="accordion" style="width:169px; height:450px; padding:0px; margin:0px; left:0px; top:0px;">
                <div class="region selected">
                  <h3><a href="#0">ENTRADAS</a></h3>
                  <div id="MenuIzqAcordionregion0-body" class="accordionBody">
                    <div class="accordionContent">
                      <table width="100%" border="0" cellpadding="1" cellspacing="0" bordercolor="#F5F6F9">
                        <tr bgcolor="#F5F6F9" class="submenuOut" onclick="nuevo('content/nueva_entrada_menu.php','nueva_entrada','menubar=yes,scrollbars=yes,resizable=yes,width=900,height=580,left=50,top=40')" onmouseover="this.className='submenuOver';" onmouseout="this.className='submenuOut';">
                          <td><img src="img/iconos/NUEVA_ENTRADA.jpg" width="34" height="32" /></td>
                          <td ><strong>NUEVO</strong></td>
                        </tr>
                                                                     
                        <tr bgcolor="#5F6A9C" class="submenuOut" onclick="MM_openBrWindow('content/vistasTablas/MisRecibidosHoy.php','','menubar=yes,scrollbars=yes,resizable=yes,width=700,height=500')" onmouseout="this.className='submenuOut';" onmouseover="this.className='submenuOver';">
                          <td><img src="img/iconos/LIBRO_ENTRADAS.jpg" alt="LIBRO" width="34" height="32" longdesc="LIBRO DE ENTRADAS" /></td>
                          <td ><strong>LIBRO DE ENTRADAS</strong><br />
                            &brvbar;</td>
                        </tr>
                        <tr>
                          <td><img src="img/iconos/BUSCAR_ENTRADAS.jpg" alt="recibirInternos" width="34" height="32" /></td>
                          <td bgcolor="#F5F6F9" class="article" ><a id="<?php echo $ctrl->link_id() ?>" href="<?php
echo $ctrl->link("Content", "buscar_entradas");
?>">BUSCAR</a></td>
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
                        <tr bgcolor="#F5F6F9" class="submenuOut" onclick="MM_openBrWindow('content/verRecibidosFecha.php','','menubar=yes,scrollbars=yes,resizable=yes,width=650,height=250')" onmouseout="this.className='submenuOut';" onmouseover="this.className='submenuOver';" >
                          <td><img src="img/iconos/ENTRADAS_ANTERIORES.jpg" alt="ICONO" width="34" height="32" longdesc="LIBROS ANTERIORES" /></td>
                          <td> LIBROS ANTERIORES</td>
                          
                        </tr>
                        </table>
                     <!-- <a id="<?php //echo $ctrl->link_id() ?>" href="<?php
//$ctrl->tooltip("Content", "tooltip_recibir", "250", "100");
//echo $ctrl->link("Content", "");
?>">&iquest;ayuda?</a>--></div>
                  </div>
                </div>
                <div class="region">
                  <h3><a href="#0">SALIDAS </a></h3>
                  <div id="MenuIzqAcordionregion1-body" class="accordionBody">
                    <div class="accordionContent">
                      <table width="100%" border="0" cellspacing="0" cellpadding="1">
                        <tr>
                          <td>&nbsp;</td>
                          <td >&nbsp;</td>
                        </tr>
                        <tr class="submenuOut"onclick="MM_openBrWindow('content/verSalidasHR.php','','menubar=yes,scrollbars=yes,resizable=yes,width=700,height=500')" onmouseout="this.className='submenuOut';" onmouseover="this.className='submenuOver';" >
                          <td><img src="img/iconos/enviarExternos1.gif" alt="ok" width="35" height="35" /></td>
                          <td>LIBRO DE SALIDAS</td>
                        </tr>
                        <!--<tr class="submenuOut" onmouseout="this.className='submenuOut';" onmouseover="this.className='submenuOver';" onclick="alert('Deshabilitado, pNNr construccion.');">
                          <td><img src="img/iconos/BUSCAR_LIBRO.jpg" alt="internos" width="34" height="32" /></td>
                          <td >BUSCAR</td>
                        </tr>-->
                        <tr class="submenuOut"onclick="MM_openBrWindow('content/verSalidasFecha.php','','menubar=yes,scrollbars=yes,resizable=yes,width=700,height=250')" onmouseout="this.className='submenuOut';" onmouseover="this.className='submenuOver';" >
                          <td><img src="img/iconos/ENTRADAS_ANTERIORES.jpg" width="34" height="32" /></td>
                          <td>LIBROS ANTERIORES</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <!--<td><a id="<?php //echo $ctrl->link_id() ?>" href="<?php
//$ctrl->tooltip("Content", "tooltip_enviar", "300", "100");
//echo $ctrl->link("Content", "");
?>">&iquest;ayuda? </a></td>-->
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="region">
                  <h3><a href="#0">DERIVACIONES</a></h3>
                  <div id="MenuIzqAcordionregion2-body" class="accordionBody">
                    <div class="accordionContent">
                      <table width="100%" border="0" cellpadding="1" cellspacing="2">
                        <tr class="submenuOut">
                          <td height="40">&nbsp;</td>
                          <td height="40"><table width="100%" border="0" cellspacing="0" cellpadding="1">
                              <tr>
                                
                                <td><img src="img/iconos/ENTRADAS_ANTERIORES.jpg" width="34" height="32" /></td>
                                <td class="article"><a id="<?php echo $ctrl->link_id() ?>" href="<?php
echo $ctrl->link("Content", "hr_forma2");
?>" style="font-size:15px;">Hoja de Ruta</a></td>
                              </tr>
                          </table></td>
                        </tr>
                      </table>
                      <p>&nbsp;</p>
                    </div>
                  </div>
                </div>
                
                <!--publicaciones-->
                           
                <div class="region">
                  <h3><a href="#0">OPCIONES</a></h3>
                  <div id="MenuIzqAcordionregion3-body" class="accordionBody">
                    <div class="accordionContent">
                    <table>
                    <tr><td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td></tr>
                    <tr>
                    <td><img src="img/iconos/pusuario.jpg" width="34" height="32" /></td>
                    <td><a id="<?php  echo $ctrl->link_id() ?>" href="<?php
echo $ctrl->link("Content", "Prefil_Usuario");
?>">Perfil de Usuario</a></td>
                      </tr>
                      </table>
                    </div>
                  </div>
                </div>
                
                <!--fin de publicaciones-->
                  <div class="region">
                  <h3><a href="#0">REPORTES</a></h3>
                  <div id="MenuIzqAcordionregion4-body" class="accordionBody">
                    <div class="accordionContent">
                      <ul style="padding:0px; margin:0px; font-size:12px;">
                        <li>
                          <table width="100%" border="0" cellspacing="1" cellpadding="2">
                            <tr>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td width="1" height="2"><img src="img/iconos/estadis.jpg" alt="internos" width="34" height="32"/></td>
                              <td><a id="<?php echo $ctrl->link_id() ?>" href="<?php
echo $ctrl->link("Content", "rep_flujo_diario");
?>">Flujo Diario</a></td></tr>
<tr><td>&nbsp;</td></tr>
<tr>
<td width="1" height="2"><img src="img/iconos/estadistica.jpg" alt="internos" width="34" height="32"/></td>
<td><a id="<?php echo $ctrl->link_id() ?>" href="<?php
echo $ctrl->link("Content", "rep_in_gral");
?>">Rankig de Entradas </a></td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>

                            <!--  <td class="submenuOut" onmouseout="this.className='submenuOut';" onmouseover="this.className='submenuOver';" onclick="MM_openBrWindow('content/add_funcionario.php','adicionar','width=700,height=450')">Agregar Funcionarios </td>-->
                         <!--   </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
							  <!--MODIFICADO PARA NO MOSTRAR CONVERSAR EN LINEA-->
                              <!--<td onclick="MM_openBrWindow('content/conversar/index.php','chat','width=700,height=450')" class="submenuOut" onmouseout="this.className='submenuOut';" onmouseover="this.className='submenuOver';" >Conversar EN-LINEA </td>-->
                            </tr>
                          </table>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <!--<div class="region">
                  <h3><a href="#0">REPORTES</a></h3>
                  <div id="MenuIzqAcordionregion5-body" class="accordionBody">
                    <div class="accordionContent">
                      <ul style=" padding:0px; margin-left:20px;">
                        <a id="<?php //echo $ctrl->link_id() ?>" href="<?php
//echo $ctrl->link("Content", "rep_flujo_diario");
?>">Flujo Diario</a>
                        </li>-->
                    <!--<li><a id="<?php //echo $ctrl->link_id() ?>" href="<?php
//echo $ctrl->link("Content", "rep_in_gral");
?>">Rankig de Entradas </a></li>
                      </ul>
                    </div>
                  </div>
                </div>-->
              </div>
            <script type="text/javascript">
	var MenuIzqAcordion = new Widgets.Accordion('MenuIzqAcordion', null, {});
              </script>
            
</div>
<?php
// End HTML content
?>