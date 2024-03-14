Event.observe(window, 'load', init, false);
function init(){
     //$('codHR').style.display = 'none';
     Event.observe('codHR', 'keyup', saludo, false);
}
function saludo(){
     var url = 'verificarHR.php';
	 var myRand = parseInt(Math.random()*999999999999999);

     var pars = 'codHR='+escape($F('cod_dep')+'-'+$F('codHR'));
	 var pars = pars+"&rand="+myRand;
     var target = 'muestra-resultado';
     var miAjax = new Ajax.Updater(target, url, {method: 'get', parameters: pars});
}