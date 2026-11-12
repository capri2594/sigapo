<?php
if (!isset($_SESSION)) {
     session_name("LoginSIRC");
     @session_start();
}
if (!isset($_SESSION['user']) || trim($_SESSION['user']) === '') {
     echo '<script type="text/javascript">window.top.location.href="index.php";</script>';
     exit;
}
// HEAD content
?>
<?php
// Begin HTML content
?>
<div class="panel__content" style="padding: 0 !important; margin: 0 !important; border: none !important;">
     <div>
          <iframe src="content/derivarHojaRuta2_1.php" name="recibir_internos" width="100%" marginwidth="0" height="620px" align="left" scrolling="auto" frameborder="0" id="recibir_externos" title="SIRC::Derivacion" allowtransparency="true" style="border: none !important; background: transparent !important; display: block !important; width: 100% !important; min-height: 620px !important;"></iframe>
     </div>
</div>
<?php
// End HTML content
?>