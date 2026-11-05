<?php 
session_name("LoginSIRC");
session_start();
header("Content-Type: text/html; charset=utf-8");
date_default_timezone_set("America/La_Paz"); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="css/theme_variables.css" rel="stylesheet" type="text/css" />
<script src="js/theme_switcher.js" type="text/javascript"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>NUEVA ENTRADA</title>
<script src="../SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<style type="text/css">
html, body {
     margin: 0px;
     padding: 0px;
     background-color: #121316;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     overflow: hidden !important;
     height: 100% !important;
}
.dynamic-iframe {
     width: 100% !important;
     height: calc(100vh - 65px) !important;
     border: none !important;
     margin: 0 !important;
     padding: 0 !important;
     box-sizing: border-box !important;
}

/* Rediseño de Pestañas SpryTabbedPanels */
.TabbedPanels {
     background-color: #121316 !important;
     width: 100% !important;
}

.TabbedPanelsTabGroup {
     background-color: #121316 !important;
     border-bottom: 2px solid #1c1a1e !important;
     padding: 10px 15px 0 15px !important;
     margin: 0 !important;
     display: flex !important;
     gap: 5px !important;
     list-style: none;
}

.TabbedPanelsTab {
     background-color: #1c1a1e !important;
     border: 1px solid rgba(255, 255, 255, 0.05) !important;
     border-bottom: none !important;
     border-top-left-radius: 6px !important;
     border-top-right-radius: 6px !important;
     color: #94a3b8 !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     padding: 12px 20px !important;
     margin: 0 !important;
     cursor: pointer !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     transition: background-color 0.2s, color 0.2s !important;
     outline: none;
}

.TabbedPanelsTab:hover {
     background-color: rgba(255, 255, 255, 0.02) !important;
     color: #f8fafc !important;
}

.TabbedPanelsTabSelected {
     background: linear-gradient(135deg, #780016 0%, #a81c33 100%) !important;
     border-color: #be123c !important;
     color: #ffffff !important;
}

.TabbedPanelsContentGroup {
     background-color: #121316 !important;
     border: none !important;
     padding: 4px 8px !important;
}

.TabbedPanelsContent {
     background-color: #121316 !important;
     border: none !important;
     margin: 0 !important;
     padding: 0 !important;
}

/* Tarjeta de Búsqueda (Seguimiento de Hojas de Ruta) */
.tracking-card {
     background-color: #1c1a1e;
     border: 1px solid rgba(255, 255, 255, 0.1);
     border-radius: 8px;
     max-width: 450px;
     margin: 40px auto;
     box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);
     overflow: hidden;
}

.tracking-header {
     background-color: #780016;
     padding: 12px 20px;
     color: #ffffff;
     font-size: 13px;
     font-weight: 700;
     border-bottom: 1px solid rgba(255, 255, 255, 0.05);
     text-transform: uppercase;
     letter-spacing: 0.5px;
}

.tracking-body {
     padding: 24px;
}

.tracking-info {
     display: flex;
     align-items: center;
     gap: 15px;
     margin-bottom: 24px;
     background: rgba(20, 18, 20, 0.5);
     padding: 12px;
     border-radius: 6px;
     border: 1px solid rgba(255, 255, 255, 0.02);
}

.tracking-info img {
     flex: 0 0 31px;
}

.tracking-info p {
     font-size: 12px;
     color: #cbd5e1;
     margin: 0;
     line-height: 1.4;
}

.form-control-track {
     width: 100%;
     padding: 10px 14px;
     background: rgba(20, 18, 20, 0.85);
     border: 1px solid rgba(255, 255, 255, 0.1);
     border-radius: 6px;
     color: #ffffff;
     font-size: 13px;
     outline: none;
     transition: border-color 0.2s, box-shadow 0.2s;
     box-sizing: border-box;
}

.form-control-track:focus {
     border-color: #be123c;
     box-shadow: 0 0 0 3px rgba(190, 18, 60, 0.25);
}

.btn-track {
     width: 100%;
     padding: 12px;
     background: linear-gradient(135deg, #780016 0%, #a81c33 100%);
     border: none;
     border-radius: 6px;
     color: white;
     font-size: 13px;
     font-weight: 600;
     cursor: pointer;
     transition: transform 0.1s, box-shadow 0.2s;
     box-shadow: 0 4px 6px -1px rgba(190, 18, 60, 0.2);
     margin-top: 15px;
}

.btn-track:hover {
     box-shadow: 0 10px 15px -3px rgba(190, 18, 60, 0.35);
}

.btn-track:active {
     transform: scale(0.98);
}

/* Autocomplete list styling */
div.autocomplete {
     position: absolute !important;
     width: 100% !important;
     background-color: #1c1a1e !important;
     border: 1px solid rgba(255, 255, 255, 0.15) !important;
     border-radius: 6px !important;
     margin-top: 4px !important;
     z-index: 1000 !important;
     max-height: 150px !important;
     overflow-y: auto !important;
     box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3) !important;
     box-sizing: border-box !important;
}

div.autocomplete ul {
     list-style: none !important;
     padding: 0 !important;
     margin: 0 !important;
}

div.autocomplete li {
     padding: 8px 12px !important;
     color: #e2e8f0 !important;
     cursor: pointer !important;
     font-size: 12px !important;
     transition: background-color 0.2s, color 0.2s !important;
     text-align: left !important;
     height: auto !important;
     display: block !important;
}

div.autocomplete li:hover, div.autocomplete li.selected {
     background: linear-gradient(135deg, #780016 0%, #a81c33 100%) !important;
     color: #ffffff !important;
}

.textfieldRequiredMsg {
     color: #ef4444;
     font-size: 11px;
     font-weight: 600;
     display: block;
     margin-top: 5px;
}

/* =========================================================================
   ADAPTACIÓN MODO CLARO (PALETA INSTITUCIONAL GADOR)
   ========================================================================= */
html[data-theme="light"],
html[data-theme="light"] body,
body[data-theme="light"],
:root:not([data-theme="dark"]),
:root:not([data-theme="dark"]) body {
     background-color: #f4f1ea !important;
     color: #1e293b !important;
}

html[data-theme="light"] .TabbedPanels,
html[data-theme="light"] .TabbedPanelsContentGroup,
html[data-theme="light"] .TabbedPanelsContent,
body[data-theme="light"] .TabbedPanels,
body[data-theme="light"] .TabbedPanelsContentGroup,
body[data-theme="light"] .TabbedPanelsContent,
:root:not([data-theme="dark"]) .TabbedPanels,
:root:not([data-theme="dark"]) .TabbedPanelsContentGroup,
:root:not([data-theme="dark"]) .TabbedPanelsContent {
     background-color: #f4f1ea !important;
}

html[data-theme="light"] .TabbedPanelsTabGroup,
body[data-theme="light"] .TabbedPanelsTabGroup,
:root:not([data-theme="dark"]) .TabbedPanelsTabGroup {
     background-color: #ebe6dc !important;
     border-bottom: 2px solid #b48a28 !important;
}

html[data-theme="light"] .TabbedPanelsTab,
body[data-theme="light"] .TabbedPanelsTab,
:root:not([data-theme="dark"]) .TabbedPanelsTab {
     background-color: #e2dcd0 !important;
     border: 1px solid rgba(104, 0, 20, 0.16) !important;
     border-bottom: none !important;
     color: #475569 !important;
}

html[data-theme="light"] .TabbedPanelsTab:hover,
body[data-theme="light"] .TabbedPanelsTab:hover,
:root:not([data-theme="dark"]) .TabbedPanelsTab:hover {
     background-color: #d6cfc2 !important;
     color: #680014 !important;
}

html[data-theme="light"] .TabbedPanelsTabSelected,
body[data-theme="light"] .TabbedPanelsTabSelected,
:root:not([data-theme="dark"]) .TabbedPanelsTabSelected {
     background: linear-gradient(135deg, #680014 0%, #50000e 100%) !important;
     border-color: #680014 !important;
     color: #ffffff !important;
}

html[data-theme="light"] .tracking-card,
body[data-theme="light"] .tracking-card,
:root:not([data-theme="dark"]) .tracking-card {
     background-color: #ffffff !important;
     border: 1px solid rgba(104, 0, 20, 0.18) !important;
     box-shadow: 0 10px 25px -5px rgba(104, 0, 20, 0.1) !important;
}

html[data-theme="light"] .tracking-header,
body[data-theme="light"] .tracking-header,
:root:not([data-theme="dark"]) .tracking-header {
     background: linear-gradient(135deg, #680014 0%, #50000e 100%) !important;
     border-bottom: 2px solid #b48a28 !important;
     color: #ffffff !important;
}

html[data-theme="light"] .tracking-info,
body[data-theme="light"] .tracking-info,
:root:not([data-theme="dark"]) .tracking-info {
     background: #fcfbf9 !important;
     border: 1px solid rgba(180, 138, 40, 0.35) !important;
     border-left: 4px solid #680014 !important;
}

html[data-theme="light"] .tracking-info p,
body[data-theme="light"] .tracking-info p,
:root:not([data-theme="dark"]) .tracking-info p {
     color: #334155 !important;
}

html[data-theme="light"] .form-control-track,
body[data-theme="light"] .form-control-track,
:root:not([data-theme="dark"]) .form-control-track {
     background: #ffffff !important;
     border: 1px solid #cbd5e1 !important;
     color: #1e293b !important;
}

html[data-theme="light"] .form-control-track:focus,
body[data-theme="light"] .form-control-track:focus,
:root:not([data-theme="dark"]) .form-control-track:focus {
     border-color: #680014 !important;
     box-shadow: 0 0 0 3px rgba(104, 0, 20, 0.15) !important;
}

html[data-theme="light"] div.autocomplete,
body[data-theme="light"] div.autocomplete,
:root:not([data-theme="dark"]) div.autocomplete {
     background-color: #ffffff !important;
     border: 1px solid rgba(104, 0, 20, 0.25) !important;
     box-shadow: 0 10px 20px -3px rgba(104, 0, 20, 0.15) !important;
}

html[data-theme="light"] div.autocomplete li,
body[data-theme="light"] div.autocomplete li,
:root:not([data-theme="dark"]) div.autocomplete li {
     color: #1e293b !important;
}

html[data-theme="light"] div.autocomplete li:hover,
html[data-theme="light"] div.autocomplete li.selected,
body[data-theme="light"] div.autocomplete li:hover,
body[data-theme="light"] div.autocomplete li.selected,
:root:not([data-theme="dark"]) div.autocomplete li:hover,
:root:not([data-theme="dark"]) div.autocomplete li.selected {
     background: linear-gradient(135deg, #680014 0%, #50000e 100%) !important;
     color: #ffffff !important;
}
</style>
<script type="text/javascript" src="js/scriptaculous/prototype.js"></script>
<script type="text/javascript" src="js/scriptaculous/scriptaculous.js"></script>
<script type="text/javascript" src="js/scriptaculous/effects.js"></script>
<link href="css/autocontempler.css" rel="stylesheet" type="text/css" />
</head>

<body onunload="window.opener.self.estado=0;">
<div id="TabbedPanels1" class="TabbedPanels">
  <ul class="TabbedPanelsTabGroup">
    <li class="TabbedPanelsTab" tabindex="0">REGISTRO DE CORRESPONDENCIA INTERNA</li>
    <li class="TabbedPanelsTab" tabindex="0">SEGUIMIENTO DE HOJA DE RUTA</li>
  </ul>
  <div class="TabbedPanelsContentGroup">
    <div class="TabbedPanelsContent" style="margin:0px; border:0px;">
      <iframe src="nuevo_Recib_interno.php" name="new_interno" class="dynamic-iframe" marginwidth="0" marginheight="0" align="middle" scrolling="auto" frameborder="0">Contenido 1</iframe>
    </div>
    <div class="TabbedPanelsContent">
      
      <div class="tracking-card">
          <div class="tracking-header">
               Seguimiento de Hojas de Ruta
          </div>
          <div class="tracking-body">
               <div class="tracking-info">
                    <svg class="tracking-icon" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="#f59e0b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex: 0 0 24px; color: #f59e0b; margin-right: 2px;"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                    <p>Introduzca el c&oacute;digo de Hoja de Ruta (debe ser uno que exista en el sistema).</p>
               </div>
               
               <form action="RecibirHojaRutaPersonalizado.php" method="get" name="form1" target="_blank" id="form1">
                    <span id="sprytextfield1">
                         <div style="position: relative;">
                              <input type="text" name="cod" id="cod" class="form-control-track" autocomplete="off" placeholder="Escriba número o código de Hoja de Ruta (ej. 8720)..." onkeyup="verificarSeguimientoHR();" />
                              <div id="lista_opciones" class="autocomplete" style="display:none;"></div>
                         </div>
                         <span class="textfieldRequiredMsg">Ingrese un valor</span>
                    </span>
                    
                    <span id="preload" style="display: none; margin-left: 10px; vertical-align: middle;" >
                         <img src="imagen/loading.gif" alt="Cargando..." />
                         <span style="font-size: 11px; margin-left: 5px;">Buscando coincidencias...</span>
                    </span>

                    <div id="muestra-resultado" style="margin-top: 12px;"></div>

                    <script type="text/javascript">
                         function verificarSeguimientoHR() {
                              var val = $("cod") ? $F("cod").strip() : "";
                              if (val.length < 2) {
                                   if ($("muestra-resultado")) $("muestra-resultado").innerHTML = "";
                                   return;
                              }
                              new Ajax.Updater("muestra-resultado", "verificarHRexistente.php?codHR=" + encodeURIComponent(val), {
                                   method: "get"
                              });
                         }

                         new Ajax.Autocompleter("cod", "lista_opciones", "ajax/h_rutas.php", {
                              method: "post",
                              paramName: "cod",
                              minChars: 1,
                              indicator: "preload",
                              afterUpdateElement: function(inputElement, selectedElement) {
                                   verificarSeguimientoHR();
                              }
                         });
                    </script>
                    
                    <input type="submit" name="Comprobar" id="Comprobar" value="Comprobar Código" class="btn-track" />
               </form>
          </div>
      </div>
      
    </div>
  </div>
</div>
<script type="text/javascript">
<!--
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["submit"]});
//-->
</script>
</body>
</html>
