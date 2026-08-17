<?php 
session_name("LoginSIRC");
session_start();
header("Content-Type: text/html; charset=utf-8");
date_default_timezone_set("America/La_Paz"); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
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
     background-color: #0f172a;
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
     background-color: #0f172a !important;
     width: 100% !important;
}

.TabbedPanelsTabGroup {
     background-color: #0f172a !important;
     border-bottom: 2px solid #1e293b !important;
     padding: 10px 15px 0 15px !important;
     margin: 0 !important;
     display: flex !important;
     gap: 5px !important;
     list-style: none;
}

.TabbedPanelsTab {
     background-color: #1e293b !important;
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
     background-color: #2563eb !important;
     border-color: #2563eb !important;
     color: #ffffff !important;
}

.TabbedPanelsContentGroup {
     background-color: #0f172a !important;
     border: none !important;
     padding: 15px !important;
}

.TabbedPanelsContent {
     background-color: #0f172a !important;
     border: none !important;
     margin: 0 !important;
     padding: 0 !important;
}

/* Tarjeta de Búsqueda (Seguimiento de Hojas de Ruta) */
.tracking-card {
     background-color: #1e293b;
     border: 1px solid rgba(255, 255, 255, 0.1);
     border-radius: 8px;
     max-width: 450px;
     margin: 40px auto;
     box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);
     overflow: hidden;
}

.tracking-header {
     background-color: #1e3a8a;
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
     background: rgba(15, 23, 42, 0.3);
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
     background: rgba(15, 23, 42, 0.6);
     border: 1px solid rgba(255, 255, 255, 0.1);
     border-radius: 6px;
     color: #ffffff;
     font-size: 13px;
     outline: none;
     transition: border-color 0.2s, box-shadow 0.2s;
     box-sizing: border-box;
}

.form-control-track:focus {
     border-color: #2563eb;
     box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.25);
}

.btn-track {
     width: 100%;
     padding: 12px;
     background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
     border: none;
     border-radius: 6px;
     color: white;
     font-size: 13px;
     font-weight: 600;
     cursor: pointer;
     transition: transform 0.1s, box-shadow 0.2s;
     box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2);
     margin-top: 15px;
}

.btn-track:hover {
     box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3);
}

.btn-track:active {
     transform: scale(0.98);
}

/* Autocomplete list styling */
div.autocomplete {
     position: absolute !important;
     width: 100% !important;
     background-color: #1e293b !important;
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
     background-color: #2563eb !important;
     color: #ffffff !important;
}

.textfieldRequiredMsg {
     color: #ef4444;
     font-size: 11px;
     font-weight: 600;
     display: block;
     margin-top: 5px;
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
                              <input type="text" name="cod" id="cod" class="form-control-track" placeholder="Código de Hoja de Ruta..." />
                              <div id="lista_opciones" class="autocomplete" ></div>
                         </div>
                         <span class="textfieldRequiredMsg">Ingrese un valor</span>
                    </span>
                    
                    <span id="preload" style="display: none; margin-left: 10px; vertical-align: middle;" >
                         <img src="imagen/loading.gif" alt="Cargando..." />
                         <span style="color:#ffffff; font-size: 11px; margin-left: 5px;">Cargando...</span>
                    </span>

                    <script type="text/javascript">
                         new Ajax.Autocompleter("cod", "lista_opciones", "ajax/h_rutas.php", {
                              method: "post",
                              paramName: "cod",
                              indicator: "preload"
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
