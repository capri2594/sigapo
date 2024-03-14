<?php 
function permanencia ($fecha1, $fecha2){

ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})", $fecha1, $fini);
ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})", $fecha2, $ffin);
// 0 es la fecha del que quiere calcularse
//1 es el año, 2 es el mes, 3 es el dia...........4 es la hora, 5 el min, 6 el segundo..
//echo $fini[0]." =[0]".$fini[1]." =[1]".$fini[2]." =[2]".$fini[3]." =[3]"."<br>";
//echo $fini[4]." =[4]".$fini[5]." =[5]".$fini[6]." =[6]"."<br>";

//calculo timestam de las dos fechas
//$timestamp1 = mktime(0,0,0,$fini[2],$fini[3],$fini[1]);
//$timestamp2 = mktime(0,0,0,$ffin[2],$ffin[3],$ffin[1]);

$timestamp1 = mktime($fini[4],$fini[5],$fini[6],$fini[2],$fini[3],$fini[1]);
$timestamp2 = mktime($ffin[4],$ffin[5],$ffin[6],$ffin[2],$ffin[3],$ffin[1]);


//resto a una fecha la otra
$segundos_diferencia = $timestamp1 - $timestamp2;
//echo $segundos_diferencia;

//convierto segundos en días
$dias_diferencia = $segundos_diferencia / (60 * 60 * 24);

//obtengo el valor absoulto de los días (quito el posible signo negativo)
$dias_diferencia = abs($dias_diferencia);

//quito los decimales a los días de diferencia
//$dias_diferencia = floor($dias_diferencia);
$dias_diferencia = round($dias_diferencia);

  return $dias_diferencia;
}

//echo permanencia ('2010-07-01 14:33:25','2010-07-26 10:33:25') 
?>
