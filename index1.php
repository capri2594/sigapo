<?php 
 session_name("LoginSIRC"); 
 session_start();
 // session_register('fun','user','cargo','dep','sid');
 $_SESSION['sid']=session_id();
 $_SESSION['user']=$_GET['uid'];
 ?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body><iframe src="index.php" scrolling="auto" width="790px" height="600px"></iframe>
</body>
</html>
