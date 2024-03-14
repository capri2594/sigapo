		function usuario(){

	 //alert('listo para mostrar datos');
	 //alert('<?php echo $_SERVER['PHP_SELF']; ?>');
     var url = 'content/mi_usuario.php';
	 var myRand = parseInt(Math.random()*999999999999999);

     var pars = 'master=joseluis';
	 var pars = pars+"&rand="+myRand;
     var target = 'mostrar_usuario';
	 //alert(pars+url);
     var miAjax = new Ajax.Updater(target, url, {method: 'get', parameters: pars});
	 //var i=1;
	 //alert('iteraccion: '+i);
	 setTimeout("usuario()",600000);
}