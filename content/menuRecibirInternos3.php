<?php 
header('Content-type: text/html; charset=utf-8');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="../includes/jaxon/widgets/tabset/css/tabset.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../includes/kore/kore.js"></script>
<script type="text/javascript" src="../includes/jaxon/widgets/tabset/js/tabset.js"></script>
<link href="../includes/jaxon/widgets/dialog/css/dialog.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../includes/jaxon/widgets/dialog/js/dialog.js"></script>
<script type="text/javascript" src="js/prototype.js"></script>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>
<script type="text/javascript">
var IE = navigator.appName.toLowerCase().indexOf("microsoft") > -1;
	var Mozilla = navigator.appName.toLowerCase().indexOf("netscape") > -1;

	var textoAnt = "";
	var posicionListaFilling = 0;

	var datos = new Array();
	

	function ajaxobj() {
		try {
			_ajaxobj = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try {
				_ajaxobj = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (E) {
				_ajaxobj = false;
			}
		}
	   
		if (!_ajaxobj && typeof XMLHttpRequest!='undefined') {
			_ajaxobj = new XMLHttpRequest();
		}
		
		return _ajaxobj;
	}
	
	function cargaLista(evt, obj, txt) {
		ajax = ajaxobj();
		ajax.open("GET", "autocompletado/DerivarHR.php?texto="+txt, true);
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				var datos = ajax.responseXML;
				var paises = datos.getElementsByTagName("hojaruta");
				
				var listaPaises = new Array();
				if (paises) {
					for (var i=0; i<paises.length; i++) {
						listaPaises[listaPaises.length] = paises[i].firstChild.data;
					}
				}
				escribeLista(obj, listaPaises);
			}
		}
		ajax.send(null);
	}
	
	function escribeLista(obj, lista) {
		var html = "";
		var fill = document.getElementById('lista');
		
		if (lista.length == 0) {
			// Si la lista es vacia no la mostramos
			fill.style.display = "none";
		} else {
			// Creamos una tabla con 
			// todos los elementos encontrados
			fill.style.display = "block";
			var html='<table cellspacing="0" '+
				'cellpadding="0" border="0" width="100%">';
			for (var i=0; i<lista.length; i++) {
				html += '<tr id="tr'+obj.id+i+
					'" '+(posicionListaFilling == i? 
						' class="fill" ': '')+
					' onmouseover="seleccionaFilling(\'tr'+
					obj.id+'\', '+i+
					')" onmousedown="seleccionaTextoFilling(\'tr'+
					obj.id+'\', '+i+')">';
				html += '<td>'+lista[i]+'</td></tr>';
			}
			html += '</table>';
		}

		// Escribimos la lista
		fill.innerHTML = html;
	}

	// Muestra las coincidencias en la lista
	function inputFilling(evt, obj) {
		var fill = document.getElementById('lista');

		var elems = datos;
		
		var tecla = "";
		var lista = new Array();
		var res = obj.value;
		var borrar = false;
		
		// Almaceno la tecla pulsada
		if (!IE) {
		  tecla = evt.which;
		} else {
		  tecla = evt.keyCode;
		}
		
		var texto;
		// Si la tecla que pulso es una
		// letra o un espacio, o el intro
		// o la tecla borrar, almaceno lo 
		// que debo buscar
		if (!String.fromCharCode(tecla).match(/(\w|\s)/) && 
				tecla != 8 && 
				tecla != 13) {
			texto = textoAnt;
		} else {
			texto = obj.value;
		}
		
		textoAnt = texto;
		
		// Si el texto es distinto de vacio
		// o se pulsa ARRIBA o ABAJO
		// hago llamada AJAX para que 
		// me devuelva la lista de palabras
		// que coinciden con lo que hay
		// escrito en la caja
		if ((texto != null && texto != "") 
			|| (tecla == 40 || tecla == 38)) {
			cargaLista(evt, obj, texto);
		}
		
		
		// Según la letra que se pulse
		if (tecla == 37) { // Izquierda
			// No hago nada
		} else if (tecla == 38) { // Arriba
			// Subo la posicion en la
			// lista desplegable una posición
			if (posicionListaFilling > 0) {
				posicionListaFilling--;
			}
			// Corrijo la posición del scroll
			fill.scrollTop = posicionListaFilling*14;
		} else if (tecla == 39) { // Derecha
			// No hago nada
		} else if (tecla == 40) { // Abajo
			if (obj.value != "") {
				// Si no es la última palabra
				// de la lista
				if (posicionListaFilling < lista.length-1) { 
					// Corrijo el scroll
					fill.scrollTop = posicionListaFilling*14;
					// Bajo la posición de la lista
					posicionListaFilling++;
				} 
			}
		} else if (tecla == 8) { // Borrar <-
			// Se sube la lista del todo
			posicionListaFilling = 0;
			// Se permite borrar
			borrar = true;
		} else if (tecla == 13) { // Intro
			// Deseleccionamos el texto
			if (obj.createTextRange) {
				var r = obj.createTextRange();
				r.moveStart("character", 
					obj.value.length+1);
				r.moveEnd("character", 
					obj.value.length+1);
				r.select();
			} else if (obj.setSelectionRange) {
				obj.setSelectionRange(
					obj.value.length+1, 
					obj.value.length+1);
			}
			// Ocultamos la lista
			fill.style.display = "none";
			// Ponemos el puntero de 
			// la lista arriba del todo
			posicionListaFilling = 0;
			// Controlamos el scroll
			fill.scrollTop = 0;
			return true;
		} else {
			// En otro caso que siga
			// escribiendo
			posicionListaFilling = 0;
			fill.scrollTop = 0;
		}	
		
		// Si no se ha borrado
		if (!borrar) {
			if (lista.length != 0) {
				// Seleccionamos la parte del texto
				// que corresponde a lo que aparece
				// en la primera posición de la lista
				// menos el texto que realmente hemos
				// escrito
				obj.value = lista[posicionListaFilling];
				if (obj.createTextRange) {
					var r = obj.createTextRange();
					r.moveStart("character", 
						texto.length);
					r.moveEnd("character", 
						lista[posicionListaFilling].length);
					r.select();
				} else if (obj.setSelectionRange) {
					obj.setSelectionRange(
						texto.length, 
						lista[posicionListaFilling].length);
				}
			}
		}
		return true;
	}
  
  
	// Introduce el texto seleccionado
	function setInput(obj, fill) {
	    //alert(obj.value);
		obj.value = textoAnt;
		fill.style.display = "none";
		posicionListaFilling = 0;
	}

  
	// Cambia el estilo de
	// la palabra seleccionada
	// de la lista
	function seleccionaFilling(id, n) {
		document.getElementById(id + 
			n).className = "fill";
		document.getElementById(id + 
			posicionListaFilling).className = "";  	
		posicionListaFilling = n;
	}
  
	// Pasa el texto del filling a la caja
	function seleccionaTextoFilling (id, n) {
		textoAnt = document.getElementById(id + 
			n).firstChild.innerHTML;
		posicionListaFilling = 0;
	}
  	
 
	// Cambia la imagen cuando se pone 
	// encima el raton (nombre.ext 
	// por _nombre.ext)
	function cambiarImagen(obj, ok) {
		var marcada = obj.src.indexOf("/_") > 0;
		
		if (ok) {
			if (!marcada) {
			  var ruta = obj.src.substring(
				0, 
				obj.src.lastIndexOf("/")+1)+
				"_"+obj.src.substring(
					obj.src.lastIndexOf("/")+1);
			  obj.src = ruta;
			}
		} else {
			if (marcada) {
				var ruta = ""+obj.src.substring(
					0, obj.src.lastIndexOf("_"))+
					obj.src.substring(
						obj.src.lastIndexOf("/")+2);
				obj.src = ruta;
			}
		}
	
	}
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>
<style>
	div.contenedor {
		position: relative;
		width: 100px;
	}
	
	.finput {
	font-family: Arial;
	color: #535F97;
	font-size: 8pt;
	border: 1px solid #535F97;
	padding-left: 3px;
	width: 130px;
	}

	div.fill {
	font-family: Arial;
	font-size: 8pt;
	display: none;
	width: 128px;
	position:absolute;
	color: #535F97;
	background-color: #E0EBEB;
	border: 1px solid #008585;
	overflow: auto;
	height: 100px;
	top: -1px;
	}

	tr.fill {
	font-family: Arial;
	font-size: 8pt;
	color: #E0EBEB;
	background-color: #535F97;
	border: 1px solid #008585;
	}

	tr.normal{
	font-family: Arial;
	font-size: 8pt;
	background-color: #E0EBEB;
	color: #535F97;
	border: 1px solid #E0EBEB;
	}
</style>
</head>

<body>
<div id="tabsetMenuRecibidos" class="tabset htmlrendering" style="width:708px;height:445px; background-color:#535F97">
  <ul class="tabset_tabs">
    <li id="tabsetMenuRecibidostab0-tab" class="tab selected"><a href="#">Correspondencia</a></li>
    <li id="tabsetMenuRecibidostab1-tab" class="tab"><a href="#">Hoja de Ruta</a></li>
  </ul>
  <div id="tabsetMenuRecibidostab0-body" class="tabBody body_active">
    <div class="tabContent"> 
	                  <form action="RecibirInternos1.php" method="post" name="formCITE" target="_self" id="formCITE">
                    <p>&nbsp;</p>
					
                    <table  border="1" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td><iframe src="hora_servidor/hora_servidor2.html" name="hora" width="150px" height="55px" marginwidth="0" marginheight="0" align="middle" scrolling="no" frameborder="0"></iframe></td>
                      </tr>
                    </table>
                    <p>&nbsp;</p>
                    <table width="320" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td>&nbsp;</td>
                        <td height="30" valign="middle" bgcolor="#535F97"><div align="left"><span class="style3 style1">&nbsp; Ingrese el numero de CITE del documento&nbsp;:</span></div></td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td><div align="center">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="15%">&nbsp;</td>
                                <td width="79%">&nbsp;</td>
                                <td width="6%"><a href="tooltip_recibir.php" onClick="new Widgets.Dialog('Ingrese el cod. CITE de la correspondencia', 'tooltip_recibir.php', { click_outside: true, width: 300, height: 200 }); return false;">ayuda</a></td>
                              </tr>
                              <tr>
                                <td valign="middle"><div align="right">CITE&nbsp;:&nbsp; </div></td>
                                <td><input name="cite" type="text" id="cite" size="35" /></td>
                                <td><div align="right">
                                    
                                    <input type="submit" name="Submit" value="(?) Verificar" />
                                    </div></td>
                                
                              </tr>
                              
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td> <div align="right">
                                    <input name="nuevo" type="button" onclick="MM_openBrWindow('nueva_entrada_menu.php','','left=50,top=50,width=800,height=550')" value="(+) Nuevo" />
                                    </div></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;
                                </td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;
                                </td>
                                <td>&nbsp;</td>
                              </tr>
                          </table>
                            </div>
                        </td> 
                            <td>&nbsp;</td> 
                      </tr>
                       </table>    
                 </form>     
	</div>
  </div>
  <div id="tabsetMenuRecibidostab1-body" class="tabBody">
    <div class="tabContent">
      <form action="RecibirHojaRuta.php" method="post" name="formCITE" target="_self" id="formCITE">
        <p>&nbsp;</p>
        <p align="center">
          <iframe src="hora_servidor/hora_servidor.html" name="hora" width="180px" marginwidth="0" height="195px" marginheight="0" align="middle" scrolling="No" frameborder="0" id="hora"></iframe>
        </p>
        <table width="320" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td>&nbsp;</td>
            <td height="30" valign="middle" bgcolor="#535F97"><div align="left"><span class="style3">&nbsp; <span class="style1">Ingrese el codigo de Hoja de Ruta &nbsp;:</span></span></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div align="center">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="15%">&nbsp;</td>
                    <td width="79%">&nbsp;</td>
                    <td width="6%"><a href="tooltip_recibir.php" onclick="new Widgets.Dialog('Ingrese el cod. CITE de la correspondencia', 'tooltip_recibir.php', { click_outside: true, width: 300, height: 200 }); return false;">ayuda</a></td>
                  </tr>
                  <tr>
                    <td valign="middle"><div align="right">COD&nbsp;:&nbsp; </div></td>
                    <td><input class="finput" name="cod" type="text" id="cod" size="30"  autocomplete="off" 
		onkeyup="inputFilling(event, this)" 
		onblur="setInput(this, document.getElementById('lista'))"/>
                     <img src="autocompletado/abajo.gif" border="0" onmouseover="cambiarImagen(this, true)" 
		     onmouseout="cambiarImagen(this, false)" class="boton" 
			 onclick="cargaLista(event, document.getElementById('cod'), '')" alt="Mostrar" />
<div class="contenedor"><div id="lista" class="fill"></div></div>                    </td>
                    <td><input type="submit" name="Submit2" value="(?) Verificar" /></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><input name="Submit2" style="visibility:hidden" type="button" onclick="MM_openBrWindow('forzar_recib_hr.php?cod='+$F('cod'),'','width=700,height=400')" value="(Forzar)Recib" /></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td><div align="right"></div></td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
            </div></td>
            <td>&nbsp;</td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">
	var tabsetMenuRecibidos = new Widgets.Tabset('tabsetMenuRecibidos', null);
</script>
</body>
</html>
