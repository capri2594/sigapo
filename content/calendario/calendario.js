var getCalendario = null;
var xmlCalendario = null;
var CualMes=0;

function CrearCalendario(QueMes){
	if (window.XMLHttpRequest){
		getCalendario=new XMLHttpRequest()
	}else if (window.ActiveXObject){
		getCalendario=new ActiveXObject("Microsoft.XMLHTTP")
	}
	if (getCalendario){
		var url="calendario.xml";
		getCalendario.onreadystatechange=CambioDeEstado;
		getCalendario.open("GET",url,true);
		getCalendario.send(null);
		CualMes=QueMes;
	}else{
		alert ("Tu explorador no soporta XMLHttpRequest");
	}
}

function CambioDeEstado(){
	if (getCalendario.readyState == 4){
		xmlCalendario = getCalendario.responseXML;
		xmlCalendario = xmlCalendario.getElementsByTagName('cita');
		setCal(CualMes);
	} 
} 

function bisiesto(Anio) {
	if (Anio % 4 == 0)
	return true
	return false
}

function diasPorMes(mes, Anio) {
var meses = new Array(12)
meses[1] = 31; // Enero
meses[2] = (((Anio % 4 == 0) && (Anio % 100 != 0)) || (Anio % 400 == 0)) ? 29 : 28
meses[3] = 31 // Marzo
meses[4] = 30 // Abril
meses[5] = 31 // Mayo
meses[6] = 30 // Junio
meses[7] = 31 // Julio
meses[8] = 31 // Agosto
meses[9] = 30 // Septiembre
meses[10] = 31 // Octubre
meses[11] = 30 // Noviembre
meses[12] = 31 // Diciembre
return meses[mes]
}

function getNombreDelMes(mes) {
var meses = new Array(12)
meses[1] = "Enero"
meses[2] = "Febrero"
meses[3] = "Marzo"
meses[4] = "Abril"
meses[5] = "Mayo"
meses[6] = "Junio"
meses[7] = "Julio"
meses[8] = "Agosto"
meses[9] = "Septiembre"
meses[10] = "Octubre"
meses[11] = "Noviembre"
meses[12] = "Diciembre"
return meses[mes]
}

function setCal(QueMes) {
	var now = new Date()
	var anio = now.getYear()
	if (anio < 1000) {anio+=1900}
	var mes = now.getMonth()+QueMes
	if (now.getMonth()+QueMes > 11) {mes-=12;anio++}
	if (now.getMonth()+QueMes < 0) {mes+=12;anio--}
	var fecha = now.getDate()
	var primerDia = new Date(anio, mes, 1)
	var primerDia2 = primerDia.getDay()
	primerDia = null
	var dias = diasPorMes(mes+1, anio)
	drawCal(primerDia2 + 1, dias, fecha, mes+1, anio)
}

function drawCal(firstDay, lastDate, date, Mes, Anio) {
var now = new Date()
var codigo = ""
codigo += '<table class="tabla">'
codigo += '<tr><td class="encabezado" colspan="7">'
codigo += getNombreDelMes(Mes) + ' ' + Anio 
codigo += '</td></tr>'

var diasSemana = new Array(7)
diasSemana[0] = "<acronym title=\"Domingo\">D</acronym>"
diasSemana[1] = "<acronym title=\"Lunes\">L</acronym>"
diasSemana[2] = "<acronym title=\"Martes\">M</acronym>"
diasSemana[3] = "<acronym title=\"Miercoles\">M</acronym>"
diasSemana[4] = "<acronym title=\"Jueves\">J</acronym>"
diasSemana[5] = "<acronym title=\"Viernes\">V</acronym>"
diasSemana[6] = "<acronym title=\"Sabado\">S</acronym>"

codigo += '<tr>'
for (var dayNum = 0; dayNum < 7; ++dayNum) {
codigo += '<td class="celdaDiaSemana">' + diasSemana[dayNum] + '</td>' 
}
codigo += '</tr>'

var cDia = 1
var curCell = 1

for (var row = 1; row <= Math.ceil((lastDate + firstDay - 1) / 7); ++row) {
codigo += '<tr>'
for (var col = 1; col <= 7; ++col) {
if (cDia > lastDate)
break
if (curCell < firstDay) {
codigo += '<td></td>';
curCell++
} else {
var textoCelda = cDia;
var textoTd = '<td class="celda">'

for (i=0;i<xmlCalendario.length;i++){
	var fecha = xmlCalendario[i].getAttribute('fecha');
	if (fecha == cDia+ "-" + Mes + "-" + Anio){
		var titulo = xmlCalendario[i].getAttribute('titulo');
		var descripcion = xmlCalendario[i].getAttribute('descripcion');
		textoCelda = '<a href="#" class="diacita" onclick="alert(\''+descripcion+'\');return false" title="'+titulo+'">' + cDia + '</a>';
		textoTd = '<td class="celdacita">'
	}
}

if (cDia == date && Mes == now.getMonth()+1) {
textoTd = '<td class="hoy">'
}

codigo += textoTd + textoCelda + '</td>'
cDia++
}
}
codigo += '</tr>'
}

codigo += '</table>'
document.getElementById("boxcalendario").innerHTML=codigo;
}