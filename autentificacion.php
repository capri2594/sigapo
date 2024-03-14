<?php
if ($_SERVER['PHP_AUTH_USER'] != "user"
   or $_SERVER['PHP_AUTH_PW'] != "pass"):
 // Bad or no username/password.
 // Send HTTP 401 error to make the
 // browser prompt the user.
 header("WWW-Authenticate: " .
        "Basic realm=\”Protected Page: " .
        "Enter your username and password " .
        "for access.\"");
 header("HTTP/1.0 401 Unauthorized");
 // Display message if user cancels dialog
 ?>
 <HTML>
 <HEAD><TITLE>Authorization Failed</TITLE></HEAD>
 <BODY>
 <H1>Authorization Failed</H1>
 
 <P>Without a valid username and password,
    access to this page cannot be granted.
    Please click ‘reload’ and enter a
    username and password when prompted.
 </P>
 <?php echo  '$PHP_AUTH_USER'."<p>";?>
 <?php echo  $PHP_AUTH_USER;?>
 </BODY>
 </HTML>
<?php else: ?>
 ...page contents here...
<?php endif; ?>