<?php
// HEAD content
?>

<style type="text/css">
.footer-custom-panel {
     height: 35px !important;
     display: flex !important;
     align-items: center !important;
     justify-content: flex-end !important;
     padding-right: 20px !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     box-sizing: border-box !important;
     transition: all 0.3s ease !important;
}

html[data-theme="light"] .footer-custom-panel,
:root:not([data-theme="dark"]) .footer-custom-panel {
     background-color: #ffffff !important;
     border-top: 2px solid #50000e !important;
}

html[data-theme="light"] .footer-text,
:root:not([data-theme="dark"]) .footer-text {
     color: #50000e !important;
}

html[data-theme="dark"] .footer-custom-panel {
     background-color: #141214 !important;
     border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
}

html[data-theme="dark"] .footer-text {
     color: #f59e0b !important;
}

.footer-text {
     font-size: 10px !important;
     font-weight: 700 !important;
     letter-spacing: 0.5px !important;
     text-transform: uppercase !important;
}
</style>


<?php
// Begin HTML content
?>
<div class="panel__content footer-custom-panel">
     <div class="footer-text">
          Gobierno Autónomo Departamental de Oruro &copy; 2026
     </div>
</div>
<?php
// End HTML content
?>