<?php
      include('class.ezpdf.php');
      //$pdf =& new Cezpdf('a4');
 //     $pdf->selectFont('fonts/Courier.afm');
      //$pdf->selectFont('fonts/Courier.afm');

      $pdf->ezText("Mi primer pdf en PHP", 30);

      $pdf->ezStream();

?>

