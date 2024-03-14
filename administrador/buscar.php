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

div{
 font-family:Century Gothic;
 color:#3333FF;
 font-size:12px;
}
.rotulo td{
 background-color:#3399FF;
 color:#000099;
 font-family:"Times New Roman", Times, serif;
 font-size:15px;
 font-weight:bold;
 text-align:center
}
legend{
 border-color:#000;
 padding:3px 3px 3px 3px;
 font-size:13px;
 font-weight:bold;
}
/**/

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