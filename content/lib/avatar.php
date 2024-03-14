<? 
include_once('thumb.php'); 
$mythumb = new thumb(); 
$mythumb->loadImage('http://192.168.128.31/sirc_11/perfiles/fotos/jaranibar.jpg'); 
// Como el rostro del personaje está a la derecha le especifico el parámetro $pos en "right" 
// Si este valor es obviado el crop se hará del centro de la imagen 
//$mythumb->crop(70, 70, 'right'); 
//resize
$mythumb->resize(100, 'width'); 
$mythumb->resize(100, 'height'); 
$mythumb->show(); 

/*
// Lee la imagen desde la ruta especificada 
loadImage($name:string) 
 
// Guarda la imagen en la ruta especificada y con una calidad de 0 a 100 definida por el usuario (máxima calidad por defecto) 
save($name:string, $quality:int = 100) 
 
// Muestra la imagen en la página sin guardarla previamente 
show() 
 
// Redimensiona la imagen en ancho o alto manteniendo sus proporciones 
// $prop puede tomar los valores de "width" o "height" 
resize($value:int, $prop:string) 
 
// Crea un thumbnail de la imagen con las medidas especificadas y manteniendo las proporciones visuales de la imagen intactas 
// $pos puede tomar los valores de "left", "top", "right", "bottom" o "center" 
crop($cwidth:int, $cheight:int, $pos:string) 
*/
?>
 
