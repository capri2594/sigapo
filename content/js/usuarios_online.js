// JavaScript Document
function usuarios_online(){
     var url = 'content/ajax/usuarios_online.php';
	 var myRand = parseInt(Math.random()*999999999999999);  
	 var pars = "rand="+myRand;
     var target = 'mostrar_usuarios_online';
     var miAjax = new Ajax.Updater(target, url, {method: 'get', parameters: pars, onComplete: showResponse});
	 
	// alert(miAjax);
	setTimeout("usuarios_online()",20000);// 1 min= 1min*60seg= 60 milisegundos
}
	function showResponse(originalRequest)
	{
		//put returned XML in the textarea
		//$('hr').value = originalRequest.responseText;
		//vaciando el componente text.
		$('mostrar_usuarios_online').innerHTML=originalRequest.responseText;
		//recuperando el valor

}
