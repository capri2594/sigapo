<?php 
$cryptinstall="../../crypt/cryptographp.fct.php";
include $cryptinstall; 
?>
<?php
  if (chk_crypt($_POST['code'])) 
    {
     echo "ok." ;
     $_SESSION['cod']=1;
	} 
     else 
	{
	 echo "error." ;
     $_SESSION['cod']=0;
	 }
?>

