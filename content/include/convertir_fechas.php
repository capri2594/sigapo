<?php 

////////////////////////////////////////////////////
//Convierte fecha de mysql a normal
////////////////////////////////////////////////////
function cambiaf_a_normal($fecha,$simbolo){
    ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
    $lafecha=$mifecha[3].$simbolo.$mifecha[2].$simbolo.$mifecha[1];
    return $lafecha;
}

////////////////////////////////////////////////////
//Convierte fecha de normal a mysql
////////////////////////////////////////////////////

function cambiaf_a_mysql($fecha,$simbolo){
    ereg( "([0-9]{1,2})".$simbolo."([0-9]{1,2})".$simbolo."([0-9]{2,4})", $fecha, $mifecha);
    $lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1];
    return $lafecha;
}

////////////////////////////////////////////////////
//Convierte fecha de mysql a normal
////////////////////////////////////////////////////
function cambiar_a_normal($fecha){
    ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
    $lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1];
    return $lafecha;
}

////////////////////////////////////////////////////
//Convierte fecha de normal a mysql
////////////////////////////////////////////////////

function cambiar_a_mysql($fecha){
    ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fecha, $mifecha);
    $lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1];
    return $lafecha;
}

//////////////
function cambiar_a_normal_letra($fecha){
    ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
	switch($mifecha[2]){
	   	case '1': $mes='ENE' ;break;
	   	case '2': $mes='FEB' ;break;
	   	case '3': $mes='MAR' ;break;
	   	case '4': $mes='ABR' ;break;
	   	case '5': $mes='MAY' ;break;
	   	case '6': $mes='JUN' ;break;
	   	case '7': $mes='JUL' ;break;
	   	case '8': $mes='AGO' ;break;
	   	case '9': $mes='SEP' ;break;
	   	case '10': $mes='OCT' ;break;
	   	case '11': $mes='NOV' ;break;
		case '12': $mes='DIC' ;break;
	}
    $lafecha=$mifecha[3]."/".$mes."/".$mifecha[1];
    return $lafecha;
}
/////////////////
//////////////
function cambiar_a_normal_letra2($fecha,$separador){
    ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
	switch($mifecha[2]){
	   	case '1': $mes='ENE' ;break;
	   	case '2': $mes='FEB' ;break;
	   	case '3': $mes='MAR' ;break;
	   	case '4': $mes='ABR' ;break;
	   	case '5': $mes='MAY' ;break;
	   	case '6': $mes='JUN' ;break;
	   	case '7': $mes='JUL' ;break;
	   	case '8': $mes='AGO' ;break;
	   	case '9': $mes='SEP' ;break;
	   	case '10': $mes='OCT' ;break;
	   	case '11': $mes='NOV' ;break;
		case '12': $mes='DIC' ;break;
	}
    $lafecha=$mifecha[3].$separador.$mes.$separador.$mifecha[1];
    return $lafecha;
}
/////////////////

///
function cambiar_a_normal_letra_con_hora($fecha){
    ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})", $fecha, $mifecha);
	switch($mifecha[2]){
	   	case '1': $mes='ENE' ;break;
	   	case '2': $mes='FEB' ;break;
	   	case '3': $mes='MAR' ;break;
	   	case '4': $mes='ABR' ;break;
	   	case '5': $mes='MAY' ;break;
	   	case '6': $mes='JUN' ;break;
	   	case '7': $mes='JUL' ;break;
	   	case '8': $mes='AGO' ;break;
	   	case '9': $mes='SEP' ;break;
	   	case '10': $mes='OCT' ;break;
	   	case '11': $mes='NOV' ;break;
		case '12': $mes='DIC' ;break;
	}
	
	if(((int)($mifecha[4]))>12){
		$hora= abs($mifecha[4]-12).":".$mifecha[5]." pm." ;
	}else{
	    $hora= $mifecha[4].":".$mifecha[5]." am." ;
    }
    $lafecha=$mifecha[3]."-".$mes."-".$mifecha[1]." ".$hora;
    return $lafecha;
}
////
function cambiar_a_normal_letra_con_hora2($fecha,$separador){
    ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})", $fecha, $mifecha);
	switch($mifecha[2]){
	   	case '1': $mes='ENE' ;break;
	   	case '2': $mes='FEB' ;break;
	   	case '3': $mes='MAR' ;break;
	   	case '4': $mes='ABR' ;break;
	   	case '5': $mes='MAY' ;break;
	   	case '6': $mes='JUN' ;break;
	   	case '7': $mes='JUL' ;break;
	   	case '8': $mes='AGO' ;break;
	   	case '9': $mes='SEP' ;break;
	   	case '10': $mes='OCT' ;break;
	   	case '11': $mes='NOV' ;break;
		case '12': $mes='DIC' ;break;
	}
	if($mifecha[4]>12){
		$hora= abs($mifecha[4]-12).":".$mifecha[5]." pm." ;
	}else{
	    $hora= $mifecha[4].":".$mifecha[5]." am." ;
    }
    $lafecha=$mifecha[3].$separador.$mes.$separador.$mifecha[1]." ".$hora;
    return $lafecha;
}
////
//echo cambiar_a_normal_letra_con_hora2('2010-06-17 15:46:06','.');
?>
