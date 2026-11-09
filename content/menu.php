<link href="content/css/theme_variables.css" rel="stylesheet" type="text/css" />
<script src="content/js/theme_switcher.js?v=12" type="text/javascript"></script>
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
     background: linear-gradient(135deg, #4d000d 0%, #680014 100%) !important;
     border-color: rgba(180, 138, 40, 0.4) !important;
}

html[data-theme="light"] #MenuIzqAcordion .region:hover,
:root:not([data-theme="dark"]) #MenuIzqAcordion .region:hover {
     border-color: #ffffff !important;
     box-shadow: 0 0 10px rgba(180, 138, 40, 0.25) !important;
}

html[data-theme="light"] #MenuIzqAcordion .region.selected,
:root:not([data-theme="dark"]) #MenuIzqAcordion .region.selected {
     background: linear-gradient(135deg, #3d000a 0%, #54000f 100%) !important;
     border-color: #ffffff !important;
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
     color: #ffffff !important;
     background-color: rgba(255, 255, 255, 0.08) !important;
}

html[data-theme="light"] #MenuIzqAcordion .region.selected h3 a,
:root:not([data-theme="dark"]) #MenuIzqAcordion .region.selected h3 a {
     color: #ffffff !important;
     background-color: rgba(0, 0, 0, 0.15) !important;
     background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23ffffff' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") !important;
     background-repeat: no-repeat !important;
     background-position: right 8px center !important;
     border-bottom: 1px solid rgba(180, 138, 40, 0.35) !important;
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
   MODO OSCURO (Opción 1: Guindo Imperial Profundo + Tipografía Blanca)
   ======================================================== */
html[data-theme="dark"] body {
     background-color: transparent !important;
}

html[data-theme="dark"] #MenuIzqAcordion .region {
     background-color: #1f0a10 !important;
     border-color: rgba(180, 138, 40, 0.28) !important;
}

html[data-theme="dark"] #MenuIzqAcordion .region:hover {
     border-color: rgba(180, 138, 40, 0.5) !important;
}

html[data-theme="dark"] #MenuIzqAcordion .region.selected {
     background-color: #280d14 !important;
     border-color: rgba(180, 138, 40, 0.45) !important;
}

html[data-theme="dark"] #MenuIzqAcordion h3 a {
     display: block !important;
     padding: 12px 32px 12px 16px !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     color: #e2e8f0 !important;
     text-transform: uppercase !important;
     letter-spacing: 1px !important;
     text-decoration: none !important;
     background-image: url(includes/jaxon/widgets/accordion/img/arrow_right.gif) !important;
     background-repeat: no-repeat !important;
     background-position: right 8px center !important;
     transition: color 0.2s, background-color 0.2s !important;
}

html[data-theme="dark"] #MenuIzqAcordion h3 a:hover {
     color: #ffffff !important;
     background-color: rgba(120, 0, 22, 0.3) !important;
}

html[data-theme="dark"] #MenuIzqAcordion .region.selected h3 a {
     color: #ffffff !important;
     background: linear-gradient(135deg, #50000e 0%, #780016 100%) !important;
     background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23ffffff' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E"), linear-gradient(135deg, #50000e 0%, #780016 100%) !important;
     background-repeat: no-repeat, no-repeat !important;
     background-position: right 8px center, 0 0 !important;
     border-bottom: 1px solid rgba(180, 138, 40, 0.4) !important;
}

html[data-theme="dark"] #MenuIzqAcordion .accordionBody {
     background-color: transparent !important;
}

html[data-theme="dark"] #MenuIzqAcordion .accordionContent {
     background-color: transparent !important;
}

html[data-theme="dark"] .menu-list li {
     color: #e2e8f0 !important;
     background-color: transparent !important;
}

html[data-theme="dark"] .menu-list li a {
     color: #e2e8f0 !important;
}

html[data-theme="dark"] .menu-list li::before {
     background-color: #b48a28 !important;
}

html[data-theme="dark"] .menu-list li:hover {
     background-color: rgba(120, 0, 22, 0.45) !important;
     color: #ffffff !important;
     transform: translateX(3px) !important;
}

html[data-theme="dark"] .menu-list li:hover a {
     color: #ffffff !important;
}

html[data-theme="dark"] .menu-list li:hover::before {
     background-color: #ffffff !important;
     transform: scale(1.5) !important;
}
</style>



<script type="text/JavaScript">
<!--
var ventana = null;
function calcularFeaturesCentradas(features) {
     var featStr = (typeof features === 'string' && features.length > 0) ? features : 'menubar=yes,scrollbars=yes,resizable=yes,width=900,height=580';
     var wMatch = featStr.match(/width\s*=\s*(\d+)/i);
     var hMatch = featStr.match(/height\s*=\s*(\d+)/i);
     var w = wMatch ? parseInt(wMatch[1], 10) : 900;
     var h = hMatch ? parseInt(hMatch[1], 10) : 580;
     var left, top;
     if (typeof window.getSigapoCenteredCoords === 'function') {
          var coords = window.getSigapoCenteredCoords(w, h, window);
          left = coords.left;
          top  = coords.top;
     } else {
          var s = window.screen || {};
          var availW = s.availWidth || s.width || 1920;
          var availH = s.availHeight || s.height || 1040;
          var winX = (typeof window.screenLeft === 'number') ? window.screenLeft : (window.screenX || 0);
          var winY = (typeof window.screenTop === 'number') ? window.screenTop : (window.screenY || 0);
          var winW = window.outerWidth || availW;
          var winH = window.outerHeight || availH;
          var monX = (typeof s.availLeft === 'number' && s.availLeft !== 0) ? s.availLeft : (((winX + winW / 2) >= availW || (winX + winW / 2) < 0) ? (Math.floor((winX + winW / 2) / availW) * availW) : 0);
          var monY = (typeof s.availTop === 'number' && s.availTop !== 0) ? s.availTop : (((winY + winH / 2) >= availH || (winY + winH / 2) < 0) ? (Math.floor((winY + winH / 2) / availH) * availH) : 0);
          left = Math.max(monX, Math.round(monX + (availW / 2) - ((w + 16) / 2)));
          top  = Math.max(monY, Math.round(monY + (availH / 2) - ((h + 68) / 2)));
     }
     var parts = featStr.split(',');
     var clean = [];
     for (var i = 0; i < parts.length; i++) {
          var p = parts[i].replace(/^\s+|\s+$/g, '');
          if (!p || /^(left|top|screenX|screenY)\s*=/i.test(p)) continue;
          clean.push(p);
     }
     clean.push('left=' + left);
     clean.push('top=' + top);
     clean.push('screenX=' + left);
     clean.push('screenY=' + top);
     return { str: clean.join(','), left: left, top: top };
}
function MM_openBrWindow(theURL,winName,features) { 
     var c = calcularFeaturesCentradas(features);
     var w = window.open(theURL, winName || '', c.str); 
     if (w) { try { w.moveTo(c.left, c.top); w.focus(); } catch(e) {} }
     return w;
}
function nuevo(theURL,winName,features) { 
  var c = calcularFeaturesCentradas(features);
  if (estado==0 || !ventana || ventana.closed){
      ventana=window.open(theURL,winName,c.str); 
      if (ventana) { try { ventana.moveTo(c.left, c.top); ventana.focus(); } catch(e) {} }
      estado=1;
  } else {
     try { ventana.moveTo(c.left, c.top); ventana.focus(); } catch(e) {}
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
                              <li onclick="nuevo('content/nueva_entrada_menu.php','nueva_entrada','menubar=yes,scrollbars=yes,resizable=yes,width=940,height=600')">
                                   NUEVO
                              </li>
                              <li onclick="MM_openBrWindow('content/vistasTablas/MisRecibidosHoy.php','','menubar=yes,scrollbars=yes,resizable=yes,width=980,height=600')">
                                   LIBRO DE ENTRADAS
                              </li>
                              <li>
                                   <a id="<?php echo $ctrl->link_id() ?>" href="<?php echo $ctrl->link("Content", "buscar_entradas"); ?>">
                                        BUSCAR
                                   </a>
                              </li>
                              <li onclick="MM_openBrWindow('administrador/buscar.php','','menubar=yes,scrollbars=yes,resizable=yes,width=780,height=450')">
                                   BUSCAR POR REFERENCIA
                              </li>
                              <li onclick="MM_openBrWindow('administrador/sigla.php','','menubar=yes,scrollbars=yes,resizable=yes,width=780,height=450')">
                                   BUSCAR SIGLA DE H.R.
                              </li>
                              <li onclick="MM_openBrWindow('content/busca_hr.php','','menubar=yes,scrollbars=yes,resizable=yes,width=960,height=560')">
                                   CONSULTAR (HojaRuta)
                              </li>
                              <li onclick="MM_openBrWindow('content/verRecibidosFecha.php','','menubar=yes,scrollbars=yes,resizable=yes,width=700,height=320')">
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
                              <li onclick="MM_openBrWindow('content/verSalidasHR.php','','menubar=yes,scrollbars=yes,resizable=yes,width=980,height=600')">
                                   LIBRO DE SALIDAS
                              </li>
                              <li onclick="MM_openBrWindow('content/verSalidasFecha.php','','menubar=yes,scrollbars=yes,resizable=yes,width=700,height=320')">
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



