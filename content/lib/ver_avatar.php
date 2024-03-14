<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<?php /*
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
*/?>
Imagen
<?php echo '<img src="http://www.elkikinet.110mb.com/image_width_100.php"/>'; ?>
<br />
<?php echo '<img src="avatar.php"/>'; ?>
</body>
</html>
