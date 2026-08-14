<?php
// HEAD content
?>
<link href="includes/jaxon/widgets/accordion/css/accordion.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="includes/jaxon/widgets/accordion/js/accordion.js"></script>
<link href="includes/jaxon/widgets/tooltip/css/tooltip.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body {
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
}

#MenuIzqAcordion {
     background-color: transparent !important;
     width: 100% !important;
     height: auto !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
}

/* Regiones del Acordeón */
#MenuIzqAcordion .region {
     border: 1px solid rgba(255, 255, 255, 0.05) !important;
     border-radius: 6px !important;
     margin-bottom: 6px !important;
     overflow: hidden !important;
     background-color: #0f172a !important; /* Fondo oscuro azul marino */
     transition: border-color 0.2s !important;
}

#MenuIzqAcordion .region:hover {
     border-color: rgba(255, 255, 255, 0.15) !important;
}

#MenuIzqAcordion .region.selected {
     background-color: #1e293b !important; /* Fondo gris pizarra para la activa */
     border-color: rgba(37, 99, 235, 0.3) !important;
}

/* Encabezados h3 del Acordeón */
#MenuIzqAcordion h3 {
     margin: 0 !important;
     padding: 0 !important;
     background: none !important;
     border: none !important;
}

#MenuIzqAcordion h3 a {
     display: block !important;
     padding: 12px 16px !important;
     color: #94a3b8 !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     text-transform: uppercase !important;
     letter-spacing: 1px !important;
     text-decoration: none !important;
     transition: color 0.2s, background-color 0.2s !important;
}

#MenuIzqAcordion h3 a:hover {
     color: #f8fafc !important;
     background-color: rgba(255, 255, 255, 0.02) !important;
}

#MenuIzqAcordion .region.selected h3 a {
     color: #f59e0b !important; /* Acento dorado para pestaña activa */
     background-color: rgba(37, 99, 235, 0.1) !important;
     border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
}

/* Cuerpo y contenido del Acordeón */
#MenuIzqAcordion .accordionBody {
     background-color: transparent !important;
     border: none !important;
}

#MenuIzqAcordion .accordionContent {
     padding: 8px !important;
}

/* Listas Limpias del Menú */
.menu-list {
     list-style: none !important;
     padding: 0 !important;
     margin: 0 !important;
     display: flex !important;
     flex-direction: column !important;
     gap: 4px !important;
}

.menu-list li {
     padding: 10px 14px !important;
     border-radius: 4px !important;
     color: #cbd5e1 !important;
     font-size: 11px !important;
     font-weight: 600 !important;
     cursor: pointer !important;
     transition: background-color 0.2s, color 0.2s, transform 0.1s !important;
     display: flex !important;
     align-items: center !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
}

/* Indicador lateral izquierdo */
.menu-list li::before {
     content: "" !important;
     display: inline-block !important;
     width: 4px !important;
     height: 4px !important;
     background-color: #475569 !important;
     border-radius: 50% !important;
     margin-right: 10px !important;
     transition: background-color 0.2s, transform 0.2s !important;
}

/* Enlaces dentro de elementos de la lista */
.menu-list li a {
     color: inherit !important;
     text-decoration: none !important;
     display: block !important;
     width: 100% !important;
}

/* Efecto Hover Dinámico */
.menu-list li:hover {
     background-color: rgba(37, 99, 235, 0.15) !important;
     color: #60a5fa !important;
     transform: translateX(3px) !important;
}

.menu-list li:hover::before {
     background-color: #60a5fa !important;
     transform: scale(1.5) !important;
}

.menu-list li:active {
     transform: translateX(1px) !important;
}
</style>
<script type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { 
      window.open(theURL,winName,features); 
}
function nuevo(theURL,winName,features) { 
  if (estado==0){
      ventana=window.open(theURL,winName,features); 
      estado=1;
  } else {
     ventana.window.focus();  
  }
}
estado=0;
//-->
</script>

<?php
// Begin HTML content
?>
<div class="panel__content">
     <div id="MenuIzqAcordion" class="accordion" style="width:169px; height:450px; padding:0px; margin:0px; left:0px; top:0px;">
          <!-- Región: Entradas -->
          <div class="region selected">
               <h3><a href="#0">ENTRADAS</a></h3>
               <div id="MenuIzqAcordionregion0-body" class="accordionBody">
                    <div class="accordionContent">
                         <ul class="menu-list">
                              <li onclick="nuevo('content/nueva_entrada_menu.php','nueva_entrada','menubar=yes,scrollbars=yes,resizable=yes,width=900,height=580,left=50,top=40')">
                                   NUEVO
                              </li>
                              <li onclick="MM_openBrWindow('content/vistasTablas/MisRecibidosHoy.php','','menubar=yes,scrollbars=yes,resizable=yes,width=700,height=500')">
                                   LIBRO DE ENTRADAS
                              </li>
                              <li>
                                   <a id="<?php echo $ctrl->link_id() ?>" href="<?php echo $ctrl->link("Content", "buscar_entradas"); ?>">
                                        BUSCAR
                                   </a>
                              </li>
                              <li onclick="MM_openBrWindow('administrador/buscar.php','','menubar=yes,scrollbars=yes,resizable=yes,width=650,height=300')">
                                   BUSCAR POR REFERENCIA
                              </li>
                              <li onclick="MM_openBrWindow('administrador/sigla.php','','menubar=yes,scrollbars=yes,resizable=yes,width=650,height=300')">
                                   BUSCAR SIGLA DE H.R.
                              </li>
                              <li onclick="MM_openBrWindow('content/busca_hr.php','','menubar=yes,scrollbars=yes,resizable=yes,width=880,height=450')">
                                   CONSULTAR (HojaRuta)
                              </li>
                              <li onclick="MM_openBrWindow('content/verRecibidosFecha.php','','menubar=yes,scrollbars=yes,resizable=yes,width=650,height=250')">
                                   LIBROS ANTERIORES
                              </li>
                         </ul>
                    </div>
               </div>
          </div>

          <!-- Región: Salidas -->
          <div class="region">
               <h3><a href="#0">SALIDAS</a></h3>
               <div id="MenuIzqAcordionregion1-body" class="accordionBody">
                    <div class="accordionContent">
                         <ul class="menu-list">
                              <li onclick="MM_openBrWindow('content/verSalidasHR.php','','menubar=yes,scrollbars=yes,resizable=yes,width=700,height=500')">
                                   LIBRO DE SALIDAS
                              </li>
                              <li onclick="MM_openBrWindow('content/verSalidasFecha.php','','menubar=yes,scrollbars=yes,resizable=yes,width=700,height=250')">
                                   LIBROS ANTERIORES
                              </li>
                         </ul>
                    </div>
               </div>
          </div>

          <!-- Región: Derivaciones -->
          <div class="region">
               <h3><a href="#0">DERIVACIONES</a></h3>
               <div id="MenuIzqAcordionregion2-body" class="accordionBody">
                    <div class="accordionContent">
                         <ul class="menu-list">
                              <li>
                                   <a id="<?php echo $ctrl->link_id() ?>" href="<?php echo $ctrl->link("Content", "hr_forma2"); ?>">
                                        HOJA DE RUTA
                                   </a>
                              </li>
                         </ul>
                    </div>
               </div>
          </div>

          <!-- Región: Opciones -->
          <div class="region">
               <h3><a href="#0">OPCIONES</a></h3>
               <div id="MenuIzqAcordionregion3-body" class="accordionBody">
                    <div class="accordionContent">
                         <ul class="menu-list">
                              <li>
                                   <a id="<?php echo $ctrl->link_id() ?>" href="<?php echo $ctrl->link("Content", "Prefil_Usuario"); ?>">
                                        PERFIL DE USUARIO
                                   </a>
                              </li>
                         </ul>
                    </div>
               </div>
          </div>

          <!-- Región: Reportes -->
          <div class="region">
               <h3><a href="#0">REPORTES</a></h3>
               <div id="MenuIzqAcordionregion4-body" class="accordionBody">
                    <div class="accordionContent">
                         <ul class="menu-list">
                              <li>
                                   <a id="<?php echo $ctrl->link_id() ?>" href="<?php echo $ctrl->link("Content", "rep_flujo_diario"); ?>">
                                        FLUJO DIARIO
                                   </a>
                              </li>
                              <li>
                                   <a id="<?php echo $ctrl->link_id() ?>" href="<?php echo $ctrl->link("Content", "rep_in_gral"); ?>">
                                        RANKING ENTRADAS
                                   </a>
                              </li>
                         </ul>
                    </div>
               </div>
          </div>
     </div>

     <script type="text/javascript">
          var MenuIzqAcordion = new Widgets.Accordion('MenuIzqAcordion', null, {});
     </script>
</div>
<?php
// End HTML content
?>
