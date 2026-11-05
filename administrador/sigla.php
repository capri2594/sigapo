<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="../content/css/theme_variables.css" rel="stylesheet" type="text/css" />
<script src="../content/js/theme_switcher.js" type="text/javascript"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Buscador por Referencia</title>

<!--<script type="text/javascript" src="scriptaculous/scriptaculous.js"></script>-->
<script type="text/javascript" src="scriptaculous/prototype.js"></script>

<script type="text/javascript">
function buscar(){
if(!$('edit1').value.blank())
{	
 url = 'siglaphp.php';
 pars = 'opcion=1'
 pars += '&nom='+$('edit1').value;
 target = 'resultado';	
 var miAjax = new Ajax.Updater(target,url,{method:'post',parameters:pars})
 //$('resultado').innerHTML = pars;
}
}
</script>
<style type="text/css">
body {
     background-color: #121316 !important;
     color: #cbd5e1 !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     margin: 20px !important;
     padding: 0 !important;
}

#busqueda {
     max-width: 650px;
     margin: 0 auto;
}

fieldset {
     background-color: #1c1a1e !important;
     border: 1px solid rgba(245, 158, 11, 0.22) !important;
     border-radius: 8px !important;
     padding: 20px !important;
     box-shadow: 0 4px 12px rgba(0, 0, 0, 0.35) !important;
     color: #cbd5e1 !important;
     font-size: 13px !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
}

legend {
     color: #ffffff !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     background: linear-gradient(135deg, #4d000d 0%, #680014 100%) !important;
     padding: 4px 12px !important;
     border-radius: 6px !important;
     border: 1px solid rgba(245, 158, 11, 0.4) !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
}

/* Input textbox */
#edit1 {
     background-color: rgba(20, 18, 20, 0.85) !important;
     border: 1px solid rgba(255, 255, 255, 0.14) !important;
     border-radius: 6px !important;
     color: #ffffff !important;
     padding: 8px 12px !important;
     font-size: 13px !important;
     outline: none !important;
     transition: border-color 0.2s, box-shadow 0.2s !important;
     box-sizing: border-box !important;
     margin-top: 5px !important;
}

#edit1:focus {
     border-color: #f59e0b !important;
     box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.25) !important;
}

/* Sigla info badge style */
.info-badge {
     display: inline-block !important;
     font-size: 11px !important;
     font-weight: 600 !important;
     color: #fde047 !important;
     background-color: rgba(104, 0, 20, 0.25) !important;
     border-left: 3px solid #f59e0b !important;
     padding: 6px 12px !important;
     margin-left: 10px !important;
     border-radius: 0 4px 4px 0 !important;
     vertical-align: middle !important;
}

/* Results container */
#resultado {
     margin-top: 20px !important;
}

/* Results Table */
#resultado table {
     width: 100% !important;
     border-collapse: collapse !important;
     background-color: #1c1a1e !important;
     border: 1px solid rgba(245, 158, 11, 0.22) !important;
     border-radius: 8px !important;
     overflow: hidden !important;
     box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3) !important;
}

#resultado tr.rotulo td {
     background-color: #780016 !important;
     color: #ffffff !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     font-weight: 700 !important;
     font-size: 11px !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     padding: 10px 12px !important;
     border: none !important;
     border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
     text-align: left !important;
}

#resultado tr td {
     padding: 10px 12px !important;
     color: #cbd5e1 !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     font-size: 11px !important;
     background-color: transparent !important;
     border: none !important;
     border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
}

#resultado tr:nth-child(even) td {
     background-color: rgba(255, 255, 255, 0.01) !important;
}

#resultado tr:hover td {
     background-color: rgba(190, 18, 60, 0.12) !important;
     color: #ffffff !important;
}

/* Light Mode Overrides */
html[data-theme="light"] body,
:root:not([data-theme="dark"]) body {
     background-color: #f1f5f9 !important;
     color: #18181b !important;
}

html[data-theme="light"] fieldset,
:root:not([data-theme="dark"]) fieldset {
     background-color: #ffffff !important;
     border: 1px solid rgba(104, 0, 20, 0.2) !important;
     box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06) !important;
     color: #18181b !important;
}

html[data-theme="light"] #edit1,
:root:not([data-theme="dark"]) #edit1 {
     background-color: #ffffff !important;
     border: 1px solid #cbd5e1 !important;
     color: #18181b !important;
}

html[data-theme="light"] .info-badge,
:root:not([data-theme="dark"]) .info-badge {
     color: #50000e !important;
     background-color: #fff1f2 !important;
     border-left: 3px solid #680014 !important;
}

html[data-theme="light"] #resultado table,
:root:not([data-theme="dark"]) #resultado table {
     background-color: #ffffff !important;
     border: 1px solid rgba(104, 0, 20, 0.2) !important;
     box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06) !important;
}

html[data-theme="light"] #resultado tr td,
:root:not([data-theme="dark"]) #resultado tr td {
     color: #18181b !important;
     border-bottom: 1px solid #e2e8f0 !important;
}

html[data-theme="light"] #resultado tr.rotulo td,
:root:not([data-theme="dark"]) #resultado tr.rotulo td {
     background: linear-gradient(135deg, #4d000d 0%, #680014 100%) !important;
     color: #ffffff !important;
     border-bottom: 2px solid #f59e0b !important;
}

html[data-theme="light"] #resultado tr:nth-child(even) td,
:root:not([data-theme="dark"]) #resultado tr:nth-child(even) td {
     background-color: #f8fafc !important;
}

html[data-theme="light"] #resultado tr:hover td,
:root:not([data-theme="dark"]) #resultado tr:hover td {
     background-color: #fff1f2 !important;
     color: #50000e !important;
}
</style>

</head>

<body >
 <div id="busqueda">
  <fieldset>
   <legend>Buscar sigla de hoja de ruta</legend>
   Buscar:
   <input type="text" id="edit1" onkeyup="buscar();"/><span class="info-badge">Ingrese una palabra relacionada con el nombre de la dependencia</span>
   </fieldset>
  <div id="resultado"></div>
 </div> 
 <span id="r" style="display:block;"></span>
</body>
</html>