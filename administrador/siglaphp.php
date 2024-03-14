<?PHP 
//echo "vengo de php y la hora en el servidor es: ".date("d-m-Y");
$bd_host = "192.168.128.102";
$bd_usuario = "sdafp";
$bd_password = "finanzas";
$bd_base = "dbsirc_2024"; 

$con = mysql_connect($bd_host, $bd_usuario, $bd_password); 

mysql_select_db($bd_base, $con); 
switch($_POST['opcion']){
 case 1:
 $cons = "SELECT cod, nombredep FROM dependencia WHERE nombredep LIKE '%".$_POST['nom']."%'
 AND cont_HR <>0";
 $resultado = mysql_query($cons);
 //echo $cons;
 if(!$resultado) die("fallo la consulta");
 else{
  if(!(mysql_num_rows($resultado)>0)) 
 	 echo "No existen resultado de la busqueda!";
  else{
	 $table = "<table border=\"1\" cellspacing=\"0\">";
	 $table .= "<tr class=\"rotulo\">";
	 $table .= "<td>HOJA DE RUTA</td>";
	 $table .= "<td>DEPENDENCIA</td>";
	 //$table .= "<td>REFERENCIA</td>";
	 //$table .= "<td>PRIMER DESTINATARIO</td>";
	 //$table .= "<td>FECHA</td>";
	 $table .= "</tr>";
 	 while($fila = mysql_fetch_array($resultado)){
	 	 //echo $fila['nombre']."<br />";
	//	 $datos = $fila['cod']."--".$fila['procedencia']."--".$fila['ref']."--".$fila['primerfun_destino'];
		 $table .= "<tr>";
//		 $table .= "<td><a href=\"#\" onclick=\"MostrarOpciones('".$datos."');\"><div>".$fila['cod']."</div></a></td>";
		 $table .= "<td>".$fila['cod']."</td>";
		 $table .= "<td>".$fila['nombredep']."</td>";
		// $table .= "<td>".$fila['ref']."</td>";
		 //$table .= "<td>".$fila['primerfun_destino']."</td>";
		 //$table .= "<td>".$fila['fecha_creacion']."</td>";
		 $table .= "</tr>";
	 	 }
	 $table .= "</table>";
	 echo $table;
  }
 }
 break;
 default:break;
}
?>