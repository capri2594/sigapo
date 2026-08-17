<?php
// HEAD content
?>
<?php
// Begin HTML content
?>
<style type="text/css">
body {
     margin: 0 !important;
     padding: 0 !important;
     background-color: transparent !important;
}
.panel__content {
     padding: 10px !important;
     box-sizing: border-box !important;
}
iframe {
     border: none !important;
     background: transparent !important;
     display: block !important;
}
</style>

<div class="panel__content">
     <div>
          <!-- Fixed source typo (.php".php) and increased height to 520px for the new ranking view -->
          <iframe src="content/reportes/Flujo_entradas.php" name="recibir_internos" width="100%" height="520px" scrolling="yes" frameborder="0" id="recibir_externos" allowtransparency="true" title="Ranking de Entradas"></iframe>
     </div>
</div>
<?php
// End HTML content
?>