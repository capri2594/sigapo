<?php
      include('class.ezpdf.php');
      $pdf =& new Cezpdf('a4');
     $pdf->selectFont('fonts/Courier.afm');
      //$pdf->selectFont('fonts/Courier.afm');

      $pdf->ezText("Mi primer pdf en PHP\n\n ",30);
	  
	  $pdf->ezText("<b>Ejemplo de PDF en PHP</b>\n",20);
      $pdf->ezText("Esta es una prueba de pdf\n",12);

      $pdf->ezStream();

?>

