<?PHP 
//echo "vengo de php y la hora en el servidor es: ".date("d-m-Y");
$bd_host = "localhost"; 
$bd_usuario = "root"; 
$bd_password = "g21121976"; 
$bd_base = "dbsirc_2012"; 

$con = mysql_connect($bd_host, $bd_usuario, $bd_password); 

mysql_select_db($bd_base, $con); 
switch($_POST['opcion']){
 case 1:
 $cons = "SELECT nombre, usuario_cuenta,dependencia_cod, ci, cargo, email FROM funcionario WHERE nombre LIKE '".$_POST['nom']."%'";
 $resultado = mysql_query($cons);
 //echo $cons;
 if(!$resultado) die("fallo la consulta");
 else{
  if(!(mysql_num_rows($resultado)>0)) 
 	 echo "No existen resultado de la busqueda!<input type=\"button\" value=\"Agregar\" onclick=\"MostrarFormIng();\"/>";
  else{
	 $table = "<table border=\"1\" cellspacing=\"0\">";
	 $table .= "<tr class=\"rotulo\">";
	 $table .= "<td>NOMBRE</td>";
	 $table .= "<td>CUENTA</td>";
	 $table .= "<td>AREA</td>";
	 $table .= "<td>C.I.</td>";
	 $table .= "<td>CARGO</td>";
	 $table .= "</tr>";
 	 while($fila = mysql_fetch_array($resultado)){
	 	 //echo $fila['nombre']."<br />";
		 $datos = $fila['nombre']."--".$fila['usuario_cuenta']."--".$fila['dependencia_cod']."--".$fila['email'];
		 $table .= "<tr>";
		 $table .= "<td><a href=\"#\" onclick=\"MostrarOpciones('".$datos."');\"><div>".$fila['nombre']."</div></a></td>";
		 $table .= "<td>".$fila['usuario_cuenta']."</td>";
		 $table .= "<td>".$fila['dependencia_cod']."</td>";
		 $table .= "<td>".$fila['ci']."</td>";
		 $table .= "<td>".$fila['cargo']."</td>";
		 $table .= "</tr>";
	 	 }
	 $table .= "</table>";
	 echo $table;
  }
 }
 break;
 case 2:
 $cons = "SELECT cod,nombredep
		  FROM `dependencia` order by cod";
 $resultado = mysql_query($cons);
 //echo $cons;
 if(!$resultado) die("fallo la consulta");
 else{
  if(!(mysql_num_rows($resultado)>0)) 
 	 return false;
  else{
	 $sel = "<select id=\"area\" onchange=\"darArea(this.value);\">";
	 $sel .= "<option value=\"0\">--Seleccione Area o Unidad--</option>";
	  	 while($fila = mysql_fetch_array($resultado)){
	 	 //echo $fila['nombre']."<br />";
		 $sel .= "<option value=\"".$fila['cod']."\">".$fila['cod']." - ".$fila['nombredep']."</option>";
		 }
	 $sel .= "</select>";
	 echo $sel;
  }
 }
 break;
 case 3:
 $cons = "INSERT INTO `funcionario`(`nombre`,`usuario_cuenta`,`dependencia_cod`,`ci`,`local`,`sexo`,`cargo`,`celular`,
 									`telefono`,`fono_trab`,`email`,`habilitado`)
		  VALUES ('".$_POST['nombre']."','".$_POST['cuenta']."','".$_POST['area']."','".$_POST['ci']."',
		  		  '".$_POST['local']."','".$_POST['sexo']."','".$_POST['cargo']."','-',
 				  '-','".$_POST['fonotrab']."','".$_POST['email']."','1')";
 $resultado = mysql_query($cons);
 //echo $cons;
 if(!$resultado) die("fallo la consulta");
 else{
  if(!(mysql_affected_rows()>0)) 
 	 echo "fracaso";
	 //return false;
  else
	 echo "exito";
 }
 break;
 case 4:
 $cons = "SELECT nombre, usuario_cuenta, dependencia_cod, ci, local, sexo, cargo, fono_trab, email
		  FROM funcionario
		  WHERE nombre = '".$_POST['nombre']."'
          AND usuario_cuenta = '".$_POST['cuenta']."'
          AND dependencia_cod = '".$_POST['area']."'";
 $resultado = mysql_query($cons);
 //echo $cons;
 if(!$resultado) die("fallo la consulta");
 else{
  if(!(mysql_num_rows($resultado)>0)) 
 	 return false;
  else{
	 while($fila = mysql_fetch_array($resultado)){
	 	 //echo $fila['nombre']."<br />";
		 $datos .= $fila['nombre']."--".$fila['usuario_cuenta']."--".$fila['dependencia_cod']."--".$fila['ci']."--".$fila['local']."--".$fila['sexo']."--".$fila['cargo']."--".$fila['fono_trab']."--".$fila['email'];
		 }
	 echo $datos;
  }
 }
 break;
 case 5:
 $cons = "UPDATE `funcionario` 
 		  SET `nombre` =  '".$_POST['nombre']."',
          `usuario_cuenta` = '".$_POST['cuenta']."',
		  `dependencia_cod` = '".$_POST['area']."',
		  `ci` = '".$_POST['ci']."',
          `local` = '".$_POST['local']."',  
          `sexo` = '".$_POST['sexo']."',
		  `cargo` = '".$_POST['cargo']."',
          `fono_trab` = '".$_POST['fonotrab']."',
          `email` = '".$_POST['email']."' 
          WHERE `funcionario`.`nombre` = '".$_POST['n']."' 
		  AND `funcionario`.`usuario_cuenta` = '".$_POST['c']."' 
		  AND `funcionario`.`dependencia_cod` = '".$_POST['a']."'";
 $resultado = mysql_query($cons);
 //echo $cons;
 if(!$resultado) die("fallo la consulta");
 else{
  if(!(mysql_affected_rows()>0)) 
 	 echo "fracaso";
	 //return false;
  else
	 echo "exito";
 }
 break;
 case 6:
 $cons = "INSERT INTO `usuario`(`nombre`,`cuenta`,`correo`,`clave`,`tipo_usuario`,`fecha_registro`,`activo`)
		  VALUES ('".$_POST['nombre']."','".$_POST['cuenta']."','".$_POST['correo']."','".md5($_POST['clave'])."',
		  		  '".$_POST['tipo']."','".date("Y-m-d")."','1')";
 $resultado = mysql_query($cons);
 //echo $cons;
 if(!$resultado) die("fallo la consulta");
 else{
  if(!(mysql_affected_rows()>0)) 
 	 echo "fracaso";
	 //return false;
  else
	 echo "exito";
 }
 break;
 case 7:
 $cons = "SELECT `cuenta` , nombre
          FROM `usuario`
          WHERE cuenta = '".$_POST['cuenta']."'";
 $resultado = mysql_query($cons);
 //echo $cons;
 if(!$resultado) die("fallo la consulta");
 else{
  if(!(mysql_num_rows($resultado)>0)) 
 	 echo "SI";
	 //return false;
  else
	 echo "NO";
 }
 break;
 
 default:break;
}
?>