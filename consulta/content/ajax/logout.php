<?php 
session_name("consulta");
session_start();
unset($_SESSION['pin'],$_SESSION['code'],$_SESSION['sid']);
session_unset();
session_destroy(); 
print_r($_SESSION);
echo "ok."
?>