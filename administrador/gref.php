<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>

<!--<script type="text/javascript" src="scriptaculous/scriptaculous.js"></script>-->
<script type="text/javascript" src="scriptaculous/prototype.js"></script>

<script type="text/javascript">
function buscar(){
if(!$('edit1').value.blank())
{	
 url = 'gphpref.php';
 pars = 'opcion=1'
 pars += '&nom='+$('edit1').value;
 target = 'resultado';	
 var miAjax = new Ajax.Updater(target,url,{method:'post',parameters:pars})
 //$('resultado').innerHTML = pars;
}
}
/****/
function ListarArea(){
 url = 'gphpref.php';
 pars = 'opcion=2'
 //pars += '&nom='+$('edit1').value;
 target = 'area';	
 var miAjax = new Ajax.Updater(target,url,{method:'post',parameters:pars})
 //$('resultado').innerHTML = pars;
}
/****/
function IngresarFuncionario(){
 if(confirm('Esta Ud. seguro de \nIngresar el Funcionario')){	
  url = 'gphpref.php';
  pars = 'opcion=3'
  pars += '&nombre='+$('nombre').value;
  pars += '&cuenta='+$('cuenta').value;
  pars += '&area='+$('harea').value;
  pars += '&ci='+$('ci').value;
  pars += '&local='+$('local').value;
 	 sx = document.getElementsByName('sexo');
 	 if(sx[0].checked) s = sx[0];
 	 else s = sx[1];
  pars += '&sexo='+s;
  pars += '&cargo='+$('cargo').value;
  pars += '&fonotrab='+$('fonotrab').value;
  pars += '&email='+$('email').value;

  target = 'rIngFun';	
  //var miAjax = new Ajax.Updater(target,url,{method:'post',parameters:pars});
  var miAjax = new Ajax.Request(url,{method:'post',parameters:pars,
									 onSuccess:function(transport){
										    $('rIngFun').style.display = 'block';
											$('FormularioIngreso').style.display = 'none';
											if(transport.responseText == 'exito')
												$('rIngFun').innerHTML = 'Se introdujeron los datos correctamente <a href="#" onclick="volverBusqueda();"><span>&larr;Volver a Busqueda</span></a>';
											else
												$('rIngFun').innerHTML = 'No se Registraron los datos <a href="#" onclick="MostrarFormIng();"><span>&larr;Volver al Formulario</span></a>';
											}
									}
								);
  //$('resultado').innerHTML = pars;
 }
 else
  return false;
}
/******/

function ActualizarFuncionario(){
 if(confirm('Esta Ud. seguro de \nActualizar el Funcionario')){	
  url = 'gphpref.php';
  pars = 'opcion=5'
  pars += '&nombre='+$('nombre').value;
  pars += '&cuenta='+$('cuenta').value;
  pars += '&area='+$('harea').value;
  pars += '&ci='+$('ci').value;
  pars += '&local='+$('local').value;
 	 sx = document.getElementsByName('sexo');
 	 if(sx[0].checked) s = sx[0];
 	 else s = sx[1];
  pars += '&sexo='+s;
  pars += '&cargo='+$('cargo').value;
  pars += '&fonotrab='+$('fonotrab').value;
  pars += '&email='+$('email').value;
  
  pars += '&n='+$('n').value;
  pars += '&c='+$('c').value;
  pars += '&a='+$('a').value;
  
  target = 'rIngFun';	
  //var miAjax = new Ajax.Updater(target,url,{method:'post',parameters:pars});
  var miAjax = new Ajax.Request(url,{method:'post',parameters:pars,
									 onSuccess:function(transport){
										    $('rIngFun').style.display = 'block';
											$('FormularioIngreso').style.display = 'none';
											if(transport.responseText == 'exito')
											$('rIngFun').innerHTML = 'Se Actualizaron los datos correctamente <a href="#" onclick="volverBusqueda();"><span>&larr;Volver a Busqueda</span></a>';
											else
											$('rIngFun').innerHTML = 'No se Actualizaron los datos <a href="#" onclick="MostrarFormIng();"><span>&larr;Volver al Formulario</span></a>';
											}
									}
								);
  //$('resultado').innerHTML = pars;
 }
 else
  return false;
}
/*****/
function IngresarUsuario(){
 if(confirm('Esta Ud. seguro de \nIngresar el Usuario')){	
  url = 'gphpref.php';
  pars = 'opcion=6'
  pars += '&nombre='+$('unombre').value;
  pars += '&cuenta='+$('ucuenta').value;
  pars += '&correo='+$('ucorreo').value;
  pars += '&clave='+$('uclave').value;
  pars += '&tipo='+$('utipo').value;
 
  var miAjax = new Ajax.Request(url,{method:'post',parameters:pars,
									 onSuccess:function(transport){
										    $('rIngFun').style.display = 'block';
											$('FormularioUsuario').style.display = 'none';
											if(transport.responseText == 'exito')
												$('rIngFun').innerHTML = 'Se introdujeron los datos de Usuario correctamente <a href="#" onclick="volverBusqueda();"><span>&larr;Volver a Busqueda</span></a>';
											else
												$('rIngFun').innerHTML = 'No se Registraron los datos de Usuario <a href="#" onclick="MostrarFormUser();"><span>&larr;Volver al Formulario</span></a>';
											}
									}
								);
  //$('resultado').innerHTML = pars;
 }
 else
  return false;
}
/****/
function darArea(valor){
 $('harea').value = valor;
}
/**/
function MostrarFormIng(){
 $('rIngFun').setStyle({display : 'none'});	
 $('busqueda').style.display = 'none';
 $('opciones').style.display = 'none';
 $('FormularioIngreso').style.display = 'block';
 
 /**/
 $('botonIngresar').style.display = 'block';
 $('botonActualizar').style.display = 'none';
 
}
/***/
function MostrarFormUser(){
 $('rIngFun').setStyle({display : 'none'});	
 $('busqueda').style.display = 'none';
 $('opciones').style.display = 'none';
 $('FormularioUsuario').style.display = 'block';

}
/***/
function MostrarOpciones(datos){
 $('rIngFun').setStyle({display : 'none'});	
 $('busqueda').style.display = 'none';
 $('opciones').style.display = 'block';
 $('datos').value = datos;
 //$('FormularioUsuario').style.display = 'block';

}

/**/
function volverBusqueda(){
 $('rIngFun').setStyle({display : 'none'});	
 $('busqueda').style.display = 'block';
 $('FormularioIngreso').style.display = 'none';
 $('FormularioUsuario').style.display = 'none';
}
/****/
function RecuperarDatos(datos){
// $('r').innerHTML = datos;
 d = datos.split('--',4)
 $('n').value = d[0];
 $('c').value = d[1];
 $('a').value = d[2];
//alert('un dato nombre '+d[0]+' otro dato cuenta '+d[1]+' tercer dato area'+d[2]);
 url = 'gphpref.php';
 pars = 'opcion=4'
 pars += '&nombre='+d[0];
 pars += '&cuenta='+d[1];
 pars += '&area='+d[2];
 //target = 'rIngFun';	
  //var miAjax = new Ajax.Updater(target,url,{method:'post',parameters:pars});
 var miAjax = new Ajax.Request(url,{method:'post',parameters:pars,
									 onSuccess:function(transport){
										    d = transport.responseText.split('--',9);
											/**/
											$('botonIngresar').style.display = 'none';
 											$('botonActualizar').style.display = 'block';

											/**/
											$('nombre').value = d[0];
											$('cuenta').value = d[1];
											$('ci').value = d[3];		
											//$('sexo').value = d[5];
											$('cargo').value = d[6];
											$('fonotrab').value = d[7];
											$('email').value = d[8];
 											$('busqueda').style.display = 'none';		
  											$('FormularioIngreso').style.display = 'block';

											}
									}
								);
}
/****/
function MostrarFormAct(datos){
 d = transport.responseText.split('--',9);
											
 $('nombre').value = d[0];
 $('cuenta').value = d[1];
 $('ci').value = d[3];
 //$('sexo').value = d[5];
 $('cargo').value = d[6];
 $('fonotrab').value = d[7];
 $('email').value = d[8];
 $('busqueda').style.display = 'none';
 $('FormularioIngreso').style.display = 'block';
}
/***/
function RecuperarDatosUser(datos){
// $('r').innerHTML = datos;
 d = datos.split('--',4)
 $('unombre').value = d[0];
 $('ucuenta').value = d[1];
 $('ucorreo').value = d[3];
 
 $('sunombre').innerHTML = $('unombre').value;
 $('sucorreo').innerHTML = $('ucorreo').value;
 MostrarFormUser();
}
/****/
function IrAOpcion(){
 $('opciones').style.display = 'none';	
 opcion = document.getElementsByName('op');
 if(opcion[0].checked){
	 
 	RecuperarDatos($('datos').value);
	}
 else{
	 RecuperarDatosUser($('datos').value)
	 //MostrarFormUser();
	 }
}
/***/
function verificar(){
 if(!$('ucuenta').value.blank()){	
 url = 'gphpref.php';
 pars = 'opcion=7'
 pars += '&cuenta='+$('ucuenta').value;
 //target = 'resultado';	
 var miAjax = new Ajax.Request(url,{method:'post',parameters:pars,
									 onSuccess:function(transport){
										    //d = transport.responseText.split('--',9);
											/**/
											if(transport.responseText=='NO')
												$('ucuenta').style.backgroundColor = '#FCF';
												//$('r').innerHTML = transport.responseText;
 											else
												$('ucuenta').style.backgroundColor = '#FFF';
											}
									}
								);
 }
}
</script>
<style type="text/css">
td a div{
 color:#069;
 font-family:Tahoma, Geneva, sans-serif;
 font-size:11px;
}
td a:hover div{
 color:#F36;
 /*font-weight:bold;*/
 }
div{
 font-family:Century Gothic;
 color:#666;
 font-size:12px;
}
.rotulo td{
 background-color:#FF0000;
 color:#CCC;
 font-family:Arial;
 font-size:13px;
 font-weight:bold;
 text-align:center
}
input {
 font-family:"Lucida Sans Unicode", "Lucida Grande", sans-serif; 
 font-size:11px;
 
 }
legend{
 border-color:#000;
 border-style:solid;
 border-width:1px;
 padding:3px 3px 3px 3px;
 font-size:12px;
 font-weight:bold;
}
/**/
.form td{
 /*background-color:#FFEBD7;*/
 color:#069;
 font-family:"Lucida Sans Unicode", "Lucida Grande", sans-serif;
}
.form td input{
 /*background-color:#FFEBD7;*/
 color:#069;
 border-color:#06C;
 border-style:solid;
 border-width:1px;
 font-family:"Lucida Sans Unicode", "Lucida Grande", sans-serif;
}

a span{
 font-weight:bold;
 color:#06C;
 text-decoration:none;
 padding:6px 6px 6px 6px;
 margin:4px 4px 4px 4px;
 border-color:#06C;
 border-width:1px;
 border-style:solid;
}
a:hover span{
 font-weight:bolder;
 color:#93F;
}

</style>
</head>

<body onload="ListarArea();">
 <div id="busqueda">
  <fieldset>
   <legend>Buscar por Referencia de una nota</legend>
   Buscar
   <input type="text" id="edit1" onkeyup="buscar();"/>
   <!--<input type="button"  value="Buscar" onclick="buscar();"/>-->
  </fieldset>
  <div id="resultado"></div>
 </div> 
 <!---->
 <div id="opciones" style="display:none;">
  <input type="hidden" id="datos" />
  <fieldset>
   <legend>Elija una Opcion</legend>
   <input type="radio" name="op" value="MOD" checked="checked"/>&nbsp;Modificar Datos<br />
   <input type="radio" name="op" value="USR"/>&nbsp;Agregar Usuario<br />
   <input type="button" id="" value="Aceptar" onclick="IrAOpcion();"/>
  </fieldset>
 </div>
 <div id="FormularioIngreso" style="display:none;">
  <a href="#" onclick="volverBusqueda();"><span>&larr;Atras</span></a>
  <fieldset>
  <legend>Datos Funcionario</legend>
  <table border="0" cellspacing="1" class="form">
   <tr>
    <td>Nombre</td>
    <td><input type="text" size="50" id="nombre" /></td>
   </tr>
   <tr>
    <td>Cuenta</td>
    <td><input type="text" size="30" id="cuenta"/></td>
   </tr>
   <tr>
    <td>Area / Unidad</td>
    <td>
     <input type="hidden" id="harea" value="0"/>
     <span id="area"></span>     
    </td>
   </tr>
   <tr>
    <td>C.I.</td>
    <td><input type="text" size="20" id="ci"/></td>
   </tr>
   <tr>
    <td>Localidad</td>
    <td>
     <select id="local">
      <option value="LPZ">La Paz</option>
      <option value="ORU">Oruro</option>
      <option value="PTS">Potosi</option>
      <option value="CBB">Cochabamba</option>
      <option value="SCR">Sucre</option>
      <option value="TRJ">Tarija</option>
      <option value="PND">Pando</option>
      <option value="BEN">Beni</option>
      <option value="STC">Santa Cruz</option>
     </select>
    </td>
   </tr>
   <tr>
    <td>Sexo</td>
    <td>
     <input type="radio" name="sexo" value="F" checked="checked"/>Femenino
     <input type="radio" name="sexo" value="M" />Masculino
    </td>
   </tr>
   <tr>
    <td>Cargo</td>
    <td><input type="text" size="30" id="cargo"/></td>
   </tr>
   <tr>
    <td>Telefono Trabajo</td>
    <td><input type="text" size="20" id="fonotrab"/></td>
   </tr>
   <tr>
    <td>E-Mail</td>
    <td><input type="text" size="30" id="email"/></td>
   </tr>
   <tr>
    <td colspan="2">
     <input type="button" id="botonIngresar" value="Aceptar" onclick="IngresarFuncionario();" style="display:none"/>
     <!---->
     <input type="hidden" id="n"/>
     <input type="hidden" id="c"/>
     <input type="hidden" id="a"/>
     <input type="button" id="botonActualizar" value="Actualizar" onclick="ActualizarFuncionario();" style="display:none"/>
     <input type="button" value="Cancelar" onclick="volverBusqueda();"/>
    </td>
   </tr>
  </table>
 </fieldset> 
 </div>
 <span id="rIngFun" style="display:none;">hallo</span>
 <!-- -->
 <div id="FormularioUsuario" style="display:none;">
 <a href="#" onclick="volverBusqueda();"><span>&larr;Atras</span></a>
  <table>
   <tr>
    <td>Nombre</td>
    <td>
     <span id="sunombre"></span>
     <input type="hidden" id="unombre"/>
    </td>
   </tr>
   <tr>
    <td>Correo</td>
    <td>
     <span id="sucorreo"></span>
     <input type="hidden" id="ucorreo"/>
    </td>
   </tr>
   <tr>
    <td>Cuenta</td>
    <td><input type="text" id="ucuenta"  onkeyup="verificar();"/></td>
   </tr>
   <tr>
    <td>Clave</td>
    <td><input type="text" id="uclave"/></td>
   </tr>
   <tr>
    <td>Tipo Usuario</td>
    <td>
     <select id="utipo">
      <option value="jefe">Jefe</option>
      <option value="recepcion">Recepcion</option>
     </select>
    </td>
   </tr>
    <tr>
    <td colspan="2">
     <input type="button" value="Aceptar" onclick="IngresarUsuario();"/>
     <input type="button" value="Cancelar" onclick="volverBusqueda();"/>
    </td>
   </tr>
  </table>
 </div>
 <span id="r" style="display:block;"></span>
</body>
</html>