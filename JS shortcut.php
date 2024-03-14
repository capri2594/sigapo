<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<script type="text/javascript" src="content/js/shortcuts.js"></script>

<SCRIPT>
function init()
{
/*
alert('iniciado');
shortcut("f4",function()
{
alert('Has pulsado Control+S');
});
shortcut("Alt+z",function()
{
alert('Has pulsado Alt+E');
});


shortcut.add("Ctrl+x",function() {
alert("test");
return false;
},{
'type':'keydown',
'propagate':false,
'target':document
});

shortcut.add("Ctrl+S",
function(evt) { alert('it works'); },
{'type':'keypress','propagate':false,'target':document}
);
}

//addEvent(window,’load’,init);
*/
//Presionando F1... en el sistema
shortcut.add
('F1', function()
{
alert('F1: Pago de Sueldo a PERSONAL a CONTRATO');
return;
}
,
{
'type':'keypress',
'propagate':false,
'target':document
}
); 

//Presionando F2.. en el sistema.
shortcut.add
('F2', function()
{
alert('F2: contratos Modulo Pago a contratos');
return;
}
,
{
'type':'keypress',
'propagate':false,
'target':document
}
); 

//Presionando F3.. en el sistema
shortcut.add
('F3', function()
{
alert('F3: Modulo de Cheques');
return;
}
,
{
'type':'keypress',
'propagate':false,
'target':document
}
); 



}
</SCRIPT>
</head>

<body onload="init();">
PRESIONE F4 O Ctrl+s
</body>
</html>
