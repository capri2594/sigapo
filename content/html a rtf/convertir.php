<?
//Funcion que lee un archivo de texto y lo mete en una cadena
function leef ($fichero) {
    $texto = file($fichero);
    $tamleef= sizeof($texto);
    for ($n=0;$n<$tamleef;$n++) {$todo= $todo.$texto[$n];}
    return $todo;
}


//funcion que genera un rtf
function rtf($sql, $plantilla, $fsalida, $matequivalencias){
$pre=time();
$fsalida="/rtf/".$pre.$fsalida;
mysql_connect("localhost", "root", "3536439");
//Paso no 1.-Leo una plantilla rtf
$txtplantilla = leef($plantilla);
//Paso no.2 Saca cabecera, el cuerpo y el final
$matriz=explode("sectd", $txtplantilla);
$cabecera=$matriz[0]."sectd";
$inicio=strlen($cabecera);
$final=strrpos($txtplantilla,"}");
$largo=$final-$inicio;
$cuerpo=substr($txtplantilla, $inicio, $largo);
//Paso no.3 Escribo el fichero
$punt = fopen($fsalida, "w");
fputs($punt,$cabecera);
$result = mysql("dbsirc11", $sql);
While($row=mysql_fetch_object($result)){
      $despues=$cuerpo;
      foreach ($matequivalencias as $dato) {
      $datosql=$row->$dato[1];
      $datosql= stripslashes ($datosql);
      $datortf=$dato[0];
      $despues=str_replace($datortf,$datosql,$despues);
    }
    fputs($punt,$despues);
      $saltopag="\par \page \par";
    fputs($punt,$saltopag);
}
fputs($punt,"}");
fclose ($punt);
return $fsalida;
}

$plantilla = "plantilla.rtf";
$sql = "SELECT nombre, dependencia_cod from funcionario";
$equivalencias[0][0]="#*nombre*#";
$equivalencias[0][1]="nombre";
$equivalencias[1][0]="#*sitio*#";
$equivalencias[1][1]="dependencia_cod";
$salida = rtf($sql, $plantilla, "certificado.rtf", $equivalencias);
$salida ="<A href='$salida'>Obtener</a>";
echo "<p>$salida</p>";
?> 