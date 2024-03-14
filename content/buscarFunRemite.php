<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>buscar Funcionario</title>
<script type="text/javascript">
<!--
function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}

function JJ_insertar() { //v9.0
  
    with (document) 
	if (getElementById && ((objnom=getElementById('nom'))!=null)&& ((objdep=getElementById('dep'))!=null)) 
	{ 
      //alert('nom='+objnom.value+' '+'dep='+objdep.value);
	  //alert(window.opener.parent.document.title);
	  //alert(window.opener.parent.document.getElementById('tr_nom').value);
	  //alert("que vamos a hacer");
	  //alert(top.document.formEInterno.getElementById('tr_nom').value);
	  //rescatar valores de la variables del formulario de esta pagina.
	  //Insertando valores.... a la ventana padre.
	  window.opener.parent.document.getElementById('tr_nom').value=objnom.value;
	  window.opener.parent.document.getElementById('tr_dep').value=objdep.value;
	  alert("se ha insertado correctamente....");
	  window.top.close();
	}else
	alert("SIRC error: al insertar registro");
}
//-->
</script>
</head>

<body>
<p>Colcar las siguientes variables</p>
<p>
  nombre
  <input type="text" name="nom" id="nom" />
</p>
<p>Unidad 
  <input type="text" name="dep" id="dep" />
</p>
<p>
  <input name="insertar" type="submit" id="insertar" onclick="JJ_insertar();" value="Insertar" />
  <input name="cerrar" type="submit" id="cerrar" onclick="MM_callJS('close();')" value="Cerrar" />
</p>
</body>
</html>
