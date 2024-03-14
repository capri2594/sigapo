<?php
// Antispam example using a random string
session_name("consulta");
session_start();
require_once "src/jpgraph_antispam-digits.php"; // usa digitos numerales, 
//require_once "src/jpgraph_antispam.php"; // en literales y numericos

// Create new anti-spam challenge creator
// Note: Neither '0' (digit) or 'O' (letter) can be used to avoid confusion
$spam = new AntiSpam();
// Create a random 5 char challenge and return the string generated
//$chars = $spam->Set('4AAQS'); 

$chars = $spam->Rand(5);
$_SESSION['codigo']=$chars;
//echo $chars;
// Stroke random cahllenge

if( $spam->Stroke() === false ) {
    die('Incorrecto o no es posible graficarlo');
}

?>

