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
     width: 169px !important;
     padding: 0px !important;
     margin: 0px !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
}

.menu-container {
     border: 1px solid rgba(37, 99, 235, 0.3) !important;
     border-radius: 6px !important;
     overflow: hidden !important;
     background-color: #1e293b !important; /* Mismo fondo de pestaña activa */
     box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.2) !important;
}

.menu-header {
     margin: 0 !important;
     padding: 12px 16px !important;
     background-color: rgba(37, 99, 235, 0.1) !important;
     color: #f59e0b !important; /* Acento dorado del header */
     font-size: 11px !important;
     font-weight: 700 !important;
     text-transform: uppercase !important;
     letter-spacing: 1px !important;
     border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
     text-align: center;
}

.menu-content {
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

/* Hover Effect */
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
