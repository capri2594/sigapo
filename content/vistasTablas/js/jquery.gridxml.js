/*
 * @author  José Fco Rives. ATICA. Universidad de Murcia
 * @fileoverview Crea listas ordenadas a partir de un listado
 * XML en formato LISXML.
 * Basado en la librería grid.js de Fran Costa Cano
 */

jQuery.fn.extend({
	gridxml: function(parametros){
		/*
		 * Mezclamos con los parámetros por defecto con los parámetros
		 * de la función
		 */
		parametros = jQuery.extend({
			xml: "grid.xml",
			xsl: "grid.xsl",
			sortOrder: "ascending",
			sortColumn: "registro",
			sortType: "reg"			 
		}, parametros);
		
		//Contiene el documento XML cargado, el documento XSL y el procesador XSL
		var xmlDoc, xslDoc, xslProc;
		loadXMLandXSL(parametros.xml, parametros.xsl);
  		dispXML(this, xmlDoc, xslDoc, xslProc, parametros.sortColumn, parametros.sortOrder, parametros.sortType);
		
		/**
		 * Crea los objetos y carga la información del fichero XML y XSL
		 * @param Nombre del fichero XML con los datos.
		 * @param Nombre del fichero XSL.
		 */
		function loadXMLandXSL(xmlFile, xslFile){
		    // Codigo para IE
		  if (window.ActiveXObject){
		    xmlDoc = new ActiveXObject("Msxml2.DOMDocument");
		    xmlDoc.async = false;
		    xmlDoc.onreadystatechange = verify;
		    xmlDoc.load(xmlFile);
		    xslDoc = new ActiveXObject("Msxml2.FreeThreadedDOMDocument");
		    xslDoc.async = false;
		    xslDoc.onreadystatechange = verify;
		    xslDoc.load(xslFile);
		    xslTemplate = new ActiveXObject("Msxml2.XSLTemplate");
		    xslTemplate.stylesheet = xslDoc;
		    xslProc = xslTemplate.createProcessor();
		  }
		  // Código para Mozilla
		  else if (window.XMLHttpRequest){
		    var xmlReq = new XMLHttpRequest();
		    xmlReq.open("GET", xmlFile, false);
		    xmlReq.send(null);
		    xmlDoc = xmlReq.responseXML;
		    xmlReq.open("GET", xslFile, false);
		    xmlReq.send(null);
		    xslDoc = xmlReq.responseXML;
		    if (window.XSLTProcessor){
		      xslProc = new XSLTProcessor();
		      xslProc.importStylesheet(xslDoc);
		    }
		  }
		}
		
		function verify(){
		  if (xmlDoc.readyState != 4){
		    return false;
		  }
		}
		
		/**
		 * Muestra en el navegador el resultado de la carga de los datos con la plantilla.
		 * @param ID del elemento HTML que contiene los datos a mostrar.
		 */
		function dispXML(obj, xmlDoc, xslDoc, xslProc, sortColumn, sortOrder, sortType){
		  // Codigo para IE
		  if (window.ActiveXObject){
	      	xslProc.addParameter("sortColumn", sortColumn);
	      	xslProc.addParameter("sortOrder", sortOrder);
	      	xslProc.addParameter("sortType", sortType);
		    
		    xslProc.input = xmlDoc;
		    xslProc.transform();
		    jQuery(obj).html(xslProc.output);
			
			//Insertamos los manejadores y la información para ordenar en el div contenedor
			$(obj)[0].xmlDoc = xmlDoc;
			$(obj)[0].xslDoc = xslDoc;
			$(obj)[0].xslProc = xslProc;
			$(obj)[0].sortOrder = sortOrder;
			$(obj)[0].sortColumn = sortColumn;
			jQuery("table th",obj).click(sort).attr("parentid",$(obj).attr("id"));
		  }
		  // Si no soporta XSLTProcessor
		  else if (!window.XSLTProcessor){
		    jQuery(obj).html(
		        "<div class='errorbanner'>Lo sentimos pero su navegador no permite el uso de XSLT, necesario para mostrar la información solicitada</div>"
			);
		  }
		  // Codigo para Mozilla
		  else if (window.XMLHttpRequest){
		    xslProc.setParameter(null, "sortColumn", sortColumn);
		    xslProc.setParameter(null, "sortOrder", sortOrder);
		    xslProc.setParameter(null, "sortType", sortType);
		    
		    var fragment = xslProc.transformToFragment(xmlDoc, document);
		    jQuery(obj).html(fragment);
			
			//Insertamos los manejadores y la información para ordenar en el div contenedor
			$(obj)[0].xmlDoc = xmlDoc;
			$(obj)[0].xslDoc = xslDoc;
			$(obj)[0].xslProc = xslProc;
			$(obj)[0].sortOrder = sortOrder;
			$(obj)[0].sortColumn = sortColumn;
			jQuery("table th",obj).click(sort).attr("parentid",$(obj).attr("id"));
		  }
		  else{
		    jQuery(obj).html(
		        "<div class='errorbanner'>Lo sentimos pero su navegador no permite el uso de XSLT, necesario para mostrar la información solicitada</div>"
			);
		  }
		}

		/** 
		 * Función llamada desde el navegador cada vez que indica una nueva columna para ordenar.
		 */
		function sort(){
		  column = jQuery(this).attr("columnname");
		  type = (jQuery(this).attr("columntype"))?jQuery(this).attr("columntype"):"";
		  idPadre = jQuery(this).attr("parentid");
		  capaPadre = jQuery("#"+idPadre)[0];
		  sortColumn = capaPadre.sortColumn;
		  sortOrder = capaPadre.sortOrder;
		  
		  if (sortColumn == column){
		      sortOrder = sortOrder == 'ascending' ? 'descending' : 'ascending';
		  }else{
		      sortColumn = column;
		      sortOrder = 'ascending';
		  }
		  sortType = type;
		  dispXML(capaPadre, capaPadre.xmlDoc, capaPadre.xslDoc, capaPadre.xslProc, sortColumn, sortOrder, sortType);
		  return true;
		}
		
		return this;
	}
});