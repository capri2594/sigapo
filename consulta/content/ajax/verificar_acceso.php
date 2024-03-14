<?php 
session_name("consulta");
session_start();
?>
<?php 
//
if(isset($_SESSION['pin'])&&isset($_SESSION['cod'])&&!empty($_SESSION['pin'])&&!empty($_SESSION['cod'])){
  if(($_SESSION['pin']>0)&&($_SESSION['cod']>0)){
   echo "ok."; }
  else
    { echo "error.";} 
   
}else{
   echo "error.";
}
//print_r($_SESSION);
?>
