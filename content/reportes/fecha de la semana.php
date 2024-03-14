<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<p><?php echo date('W', mktime(0, 0, 0, 8, 7, 2007))."<br/>"; 
echo date("M-d-Y", mktime(0, 0, 0, 12, 32, 1997))."<br/>";
echo date("M-d-Y", mktime(0, 0, 0, 13, 1, 1997))."<br/>";
echo date("M-d-Y", mktime(0, 0, 0, 1, 1, 1998))."<br/>";
echo date("M-d-Y", mktime(0, 0, 0, 1, 1, 98))."<br/>"
?>
  <?php
$ultimodia = mktime(0, 0, 0, 8, 0, 2008);
echo strftime("El ultimo día en Agosto 2008 es: %d", $ultimodia);
$ultimodia = mktime(0, 0, 0, 9, -31, 2000);
echo strftime("El ultimo día en Agosto 2008 es: %d", $ultimodia);
?>
</p>

<?php
echo mktime(0,0,0,10,29,2006) - mktime(0,0,0,10,30,2006); // -90 000
?> <p>&nbsp; </p>
<?php

// January 1, 2005
print date ("F j, Y", mktime (0,0,0,13,1,2004));

// December 1, 2003
print date ("F j, Y", mktime (0,0,0,0,1,2004));

// February 1, 2005
print date ("F j, Y", mktime (0,0,0,14,1,2004));

// November 1, 2003
print date ("F j, Y", mktime (0,0,0,-1,1,2004));

?> 
<?php 
function calcula_numero_dia_semana($dia,$mes,$ano){ 
    $numerodiasemana = date('w', mktime(0,0,0,$mes,$dia,$ano)); 
    if ($numerodiasemana == 0) 
       $numerodiasemana = 6; 
    else 
       $numerodiasemana--; 
    return $numerodiasemana; 
} 

function ultimoDia($mes,$ano){ 
    $ultimo_dia=28; 
    while (checkdate($mes,$ultimo_dia + 1,$ano)){ 
       $ultimo_dia++; 
    } 
    return $ultimo_dia; 
} 


function dame_nombre_mes($mes){ 

$meses = array("1" => "Enero", "2" => "Febrero", "3" => "Marzo", "4" => "Abril", "5" => "Mayo", "6" => "Junio", "7" => "Julio", "8" => "Agosto", "9" => "Septiembre", "10" => "Octubre", "11" => "Noviembre", "12" => "Diciembre",); 

return $meses[$mes]; 
} 

//Variable para llevar la cuenta del dia actual 
$dia_actual = 1; 

//calculo el numero del dia de la semana del primer dia 
$numero_dia = calcula_numero_dia_semana(1,$mes,$ano); 

//calculo el último dia del mes 
$ultimo_dia = ultimoDia($mes,$ano); 

//escribo la primera fila de la semana 
echo "<table>";
echo "<tr>"; 
for ($i=0;$i<7;$i++){ 
    if ($i < $numero_dia){ 
       //si el dia de la semana i es menor que el numero del primer dia de la semana 
       //no pongo nada en la celda 
       echo "<td></td>"; 
    } else { 
       //pongo el número de día del mes en la celda 
       echo "<td align=center>$dia_actual</td>"; 
       $dia_actual++; 
    } 
} 
echo "</tr>"; 


//recorro todos los demás días hasta el final del mes 
$numero_dia = 0; 
while ($dia_actual <= $ultimo_dia){ 
    //si estamos a principio de la semana escribo el <TR> 
    if ($numero_dia == 0) 
       echo "<tr>"; 
    echo "<td align=center>$dia_actual</td>"; 
    $dia_actual++; 
    $numero_dia++; 
    //si es el ultimo de la semana, pongo al principio de la semana y escribo el </tr> 
    if ($numero_dia == 7){ 
       $numero_dia = 0; 
       echo "</tr>"; 
    } 
} 


//compruebo que celdas me faltan por escribir vacías de la última semana del mes 
for ($i=$numero_dia;$i<7;$i++){ 
    echo "<td></td>"; 
} 

echo "</tr>"; 
echo "</table>"; 



?>
</body>
</html>
