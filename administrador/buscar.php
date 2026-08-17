<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Buscador por Referencia</title>

<!--<script type="text/javascript" src="scriptaculous/scriptaculous.js"></script>-->
<script type="text/javascript" src="scriptaculous/prototype.js"></script>

<script type="text/javascript">
function buscar(){
if(!$('edit1').value.blank())
{	
 url = 'buscarphp.php';
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
     background-color: #0f172a !important;
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
     background-color: #1e293b !important;
     border: 1px solid rgba(255, 255, 255, 0.1) !important;
     border-radius: 8px !important;
     padding: 20px !important;
     box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15) !important;
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
     background-color: #1e3a8a !important;
     padding: 4px 12px !important;
     border-radius: 6px !important;
     border: 1px solid rgba(255, 255, 255, 0.1) !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
}

/* Input textbox */
#edit1 {
     background-color: rgba(15, 23, 42, 0.6) !important;
     border: 1px solid rgba(255, 255, 255, 0.1) !important;
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
     border-color: #2563eb !important;
     box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2) !important;
}

/* Sigla info badge style */
.info-badge {
     display: inline-block !important;
     font-size: 11px !important;
     font-weight: 600 !important;
     color: #3b82f6 !important;
     background-color: rgba(37, 99, 235, 0.1) !important;
     border-left: 3px solid #2563eb !important;
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
     background-color: #1e293b !important;
     border: 1px solid rgba(255, 255, 255, 0.1) !important;
     border-radius: 8px !important;
     overflow: hidden !important;
     box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3) !important;
}

#resultado tr.rotulo td {
     background-color: #1e3a8a !important;
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
     background-color: rgba(255, 255, 255, 0.04) !important;
     color: #ffffff !important;
}
</style>

</head>

<body >
 <div id="busqueda">
  <fieldset>
   <legend>Buscar una nota por Referencia o Glosa</legend>
   Buscar:
   <input type="text" id="edit1" onkeyup="buscar();" size="50"/>
   
   </fieldset>
  <div id="resultado"></div>
 </div> 
 <span id="r" style="display:block;"></span>
</body>
</html>