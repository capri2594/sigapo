<?php // Sessiones y declaracion de variables

// session_name("LoginSIRC"); 
// session_start();
 session_register('fun','user','cargo','dep','sid');
/* $fun=$_SESSION['fun'];
 $user=$_SESSION['user'];
 $cargo=$_SESSION['cargo'];
 $dep=$_SESSION['dep'];
 echo $_SESSION['dep']."<br>";
 echo $_SESSION['sid']."<br>";
 echo $_SESSION['fun']."<br>";*/
 
// session_register('fun','user','cargo','dep','sid');
// $_SESSION['sid']=session_id();
 ?>
<?php
// HEAD content
?>
<style type="text/css">
<!--
.style1 {font-weight: bold}
.style2 {
	font-family: "Comic Sans MS", cursive;
	font-weight: bold;
	font-size: 14px;
	color: #000033;
}
.style8 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.style16 {color: #000040}
.style17 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #003333; }
.style22 {color: #000033; font-weight: bold; }
.style24 {font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #000033; }
#Layer1 {
	position:relative;
	left:238px;
	top:292px;
	width:110px;
	height:110px;
	z-index:5001;
}
-->
</style>

<?php
// Begin HTML content
?>
<div class="panel__content" style="background-color:#CFF" >
              <blockquote>
                <h2 align="center">Sistema de Correspondencia Gesti&oacute;n 2024</h2>
                <h1 class="style16">Bienvenido </h1>
              </blockquote>
              <div class="center_column">
                <h2>&nbsp;</h2>
              <table width="650" border="1" align="center" cellpadding="10" cellspacing="0" bordercolor="#E1E4F7">
          <tr>
                    <td width="150" height="125" align="center" valign="middle" bordercolor="#F0F0F0" bgcolor="#F0F0F0"><img src="perfiles/fotos/<?php //echo $_SESSION['user']; ?>default_avatar013.jpg" alt="sin foto" align="middle" />                    </td>
<td height="125" valign="middle"><table width="493" border="0" cellpadding="10" cellspacing="0">
                        <tr>
                          <td width="130"><span class="style2">Usuario</span></td>
                          <td width="5"><span class="style22">:</span></td>
                          <td><span class="style24"><?php echo htmlentities($_SESSION['fun']); ?></span></td>
                        </tr>
                        <tr>
                          <td><span class="style2"><strong>Cargo</strong></span></td>
                          <td width="5"><span class="style22">:</span></td>
                          <td><span class="style24"><?php echo htmlentities($_SESSION['cargo']); ?></span></td>
                        </tr>
                        <tr>
                          <td><span class="style2"><strong>Unidad</strong></span></td>
                          <td width="5"><span class="style22">:</span></td>
                          <td><span class="style24"><?php echo $_SESSION['dep']; ?></span></td>
                        </tr>
                    </table></td>
                  </tr>
                </table>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
            </div>
          
</div>
<?php
// End HTML content
?>