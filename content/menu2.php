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

/* Dimensiones compartidas e idénticas en ambos modos (Cero desfasaje) */
#MenuIzqAcordion {
     background-color: transparent !important;
     width: 100% !important;
     height: auto !important;
     padding: 0px !important;
     margin: 0px !important;
     border: none !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
}

#MenuIzqAcordion .region {
     border-radius: 6px !important;
     margin-bottom: 6px !important;
     overflow: hidden !important;
     border-width: 1px !important;
     border-style: solid !important;
     transition: border-color 0.2s, background-color 0.2s !important;
}

#MenuIzqAcordion h3 {
     margin: 0 !important;
     padding: 0 !important;
     background: none !important;
     border: none !important;
}

#MenuIzqAcordion h3 a {
     display: block !important;
     padding: 12px 32px 12px 16px !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     text-transform: uppercase !important;
     letter-spacing: 1px !important;
     text-decoration: none !important;
     background-image: url(includes/jaxon/widgets/accordion/img/arrow_right.gif) !important;
     background-repeat: no-repeat !important;
     background-position: right 8px center !important;
     transition: color 0.2s, background-color 0.2s !important;
}

#MenuIzqAcordion .accordionBody {
     border: none !important;
}

#MenuIzqAcordion .accordionContent {
     padding: 8px !important;
}

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
     font-size: 11px !important;
     font-weight: 700 !important;
     cursor: pointer !important;
     transition: background-color 0.2s, color 0.2s, transform 0.1s !important;
     display: flex !important;
     align-items: center !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
}

.menu-list li::before {
     content: "" !important;
     display: inline-block !important;
     width: 4px !important;
     height: 4px !important;
     border-radius: 50% !important;
     margin-right: 10px !important;
     transition: background-color 0.2s, transform 0.2s !important;
}

.menu-list li a {
     color: inherit !important;
     text-decoration: none !important;
     display: block !important;
     width: 100% !important;
}

/* ========================================================
   MODO CLARO (Fondo Guindo en región + Opciones Color Guindo)
   ======================================================== */
html[data-theme="light"] body,
:root:not([data-theme="dark"]) body {
     background-color: transparent !important;
}

html[data-theme="light"] #MenuIzqAcordion .region,
:root:not([data-theme="dark"]) #MenuIzqAcordion .region {
     background-color: #780016 !important;
     border-color: #580010 !important;
}

html[data-theme="light"] #MenuIzqAcordion .region:hover,
:root:not([data-theme="dark"]) #MenuIzqAcordion .region:hover {
     border-color: rgba(255, 255, 255, 0.25) !important;
}

html[data-theme="light"] #MenuIzqAcordion .region.selected,
:root:not([data-theme="dark"]) #MenuIzqAcordion .region.selected {
     background-color: #5c0012 !important;
     border-color: #881337 !important;
}

html[data-theme="light"] #MenuIzqAcordion h3 a,
:root:not([data-theme="dark"]) #MenuIzqAcordion h3 a {
     display: block !important;
     padding: 12px 32px 12px 16px !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     text-transform: uppercase !important;
     letter-spacing: 1px !important;
     text-decoration: none !important;
     background-image: url(includes/jaxon/widgets/accordion/img/arrow_right.gif) !important;
     background-repeat: no-repeat !important;
     background-position: right 8px center !important;
     transition: color 0.2s, background-color 0.2s !important;
}

html[data-theme="light"] #MenuIzqAcordion h3 a:hover,
:root:not([data-theme="dark"]) #MenuIzqAcordion h3 a:hover {
     color: #fde047 !important;
     background-color: rgba(255, 255, 255, 0.05) !important;
}

html[data-theme="light"] #MenuIzqAcordion .region.selected h3 a,
:root:not([data-theme="dark"]) #MenuIzqAcordion .region.selected h3 a {
     color: #fde047 !important;
     background-color: rgba(0, 0, 0, 0.15) !important;
     background-image: url(includes/jaxon/widgets/accordion/img/blue_arrow_down.gif) !important;
     background-repeat: no-repeat !important;
     background-position: right 8px center !important;
     border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
}

html[data-theme="light"] #MenuIzqAcordion .accordionBody,
:root:not([data-theme="dark"]) #MenuIzqAcordion .accordionBody {
     background-color: #ffffff !important;
}

html[data-theme="light"] #MenuIzqAcordion .accordionContent,
:root:not([data-theme="dark"]) #MenuIzqAcordion .accordionContent {
     background-color: #ffffff !important;
}

html[data-theme="light"] .menu-list li,
:root:not([data-theme="dark"]) .menu-list li {
     color: #800020 !important;
     background-color: transparent !important;
}

html[data-theme="light"] .menu-list li a,
:root:not([data-theme="dark"]) .menu-list li a {
     color: #800020 !important;
}

html[data-theme="light"] .menu-list li::before,
:root:not([data-theme="dark"]) .menu-list li::before {
     background-color: #800020 !important;
}

html[data-theme="light"] .menu-list li:hover,
:root:not([data-theme="dark"]) .menu-list li:hover {
     background-color: #fff1f2 !important;
     color: #be123c !important;
     transform: translateX(3px) !important;
}

html[data-theme="light"] .menu-list li:hover a,
:root:not([data-theme="dark"]) .menu-list li:hover a {
     color: #be123c !important;
}

html[data-theme="light"] .menu-list li:hover::before,
:root:not([data-theme="dark"]) .menu-list li:hover::before {
     background-color: #be123c !important;
     transform: scale(1.5) !important;
}

/* ========================================================
   MODO OSCURO (Azul Zafiro / Slate)
   ======================================================== */
html[data-theme="dark"] body {
     background-color: transparent !important;
}

html[data-theme="dark"] #MenuIzqAcordion .region {
     background-color: #0f172a !important;
     border-color: rgba(255, 255, 255, 0.05) !important;
}

html[data-theme="dark"] #MenuIzqAcordion .region:hover {
     border-color: rgba(255, 255, 255, 0.15) !important;
}

html[data-theme="dark"] #MenuIzqAcordion .region.selected {
     background-color: #1e293b !important;
     border-color: rgba(190, 18, 60, 0.35) !important;
}

html[data-theme="dark"] #MenuIzqAcordion h3 a {
     display: block !important;
     padding: 12px 32px 12px 16px !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     text-transform: uppercase !important;
     letter-spacing: 1px !important;
     text-decoration: none !important;
     background-image: url(includes/jaxon/widgets/accordion/img/arrow_right.gif) !important;
     background-repeat: no-repeat !important;
     background-position: right 8px center !important;
     transition: color 0.2s, background-color 0.2s !important;
}

html[data-theme="dark"] #MenuIzqAcordion h3 a:hover {
     color: #f8fafc !important;
     background-color: rgba(255, 255, 255, 0.02) !important;
}

html[data-theme="dark"] #MenuIzqAcordion .region.selected h3 a {
     color: #f59e0b !important;
     background-color: rgba(190, 18, 60, 0.12) !important;
     background-image: url(includes/jaxon/widgets/accordion/img/blue_arrow_down.gif) !important;
     background-repeat: no-repeat !important;
     background-position: right 8px center !important;
     border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
}

html[data-theme="dark"] #MenuIzqAcordion .accordionBody {
     background-color: transparent !important;
}

html[data-theme="dark"] #MenuIzqAcordion .accordionContent {
     background-color: transparent !important;
}

html[data-theme="dark"] .menu-list li {
     color: #cbd5e1 !important;
     background-color: transparent !important;
}

html[data-theme="dark"] .menu-list li a {
     color: #cbd5e1 !important;
}

html[data-theme="dark"] .menu-list li::before {
     background-color: #475569 !important;
}

html[data-theme="dark"] .menu-list li:hover {
     background-color: rgba(190, 18, 60, 0.2) !important;
     color: #fda4af !important;
     transform: translateX(3px) !important;
}

html[data-theme="dark"] .menu-list li:hover a {
     color: #fda4af !important;
}

html[data-theme="dark"] .menu-list li:hover::before {
     background-color: #fda4af !important;
     transform: scale(1.5) !important;
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
     <div id="MenuIzqAcordion">
          <div class="menu-container">
               <h3 class="menu-header">CONSULTAS</h3>
               
               <div class="menu-content">
                    <ul class="menu-list">
                         <li onclick="nuevo('content/consulta_hoja_ruta.php','nueva_entrada','menubar=yes,scrollbars=yes,resizable=yes,width=900,height=580,left=50,top=40')">
                              CONSULTAR HOJA DE RUTA
                         </li>
                         <li onclick="MM_openBrWindow('content/vistasTablas/MisRecibidosHoy.php','','menubar=yes,scrollbars=yes,resizable=yes,width=700,height=500')">
                              LIBRO DE ENTRADAS
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
                         <li onclick="MM_openBrWindow('content/verRecibidosFecha.php','','menubar=yes,scrollbars=yes,resizable=yes,width=650,height=300')">
                              LIBROS ANTERIORES
                         </li>
                    </ul>
               </div>
          </div>
     </div>
</div>
<?php
// End HTML content
?>
