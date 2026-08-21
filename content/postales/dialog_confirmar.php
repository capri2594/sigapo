<?php
header('Content-Type: text/html; charset=UTF-8');
?>
<div class="confirm-dialog-wrapper" style="padding: 12px; text-align: center; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; box-sizing: border-box; width: 100%; height: 100%; overflow: hidden;">
     <!-- Warning Icon -->
     <div style="margin-bottom: 10px;">
          <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline-block;">
               <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
               <line x1="12" y1="9" x2="12" y2="13"></line>
               <line x1="12" y1="17" x2="12.01" y2="17"></line>
          </svg>
     </div>
     
     <!-- Message -->
     <div style="font-size: 12px; color: #ffffff; font-weight: 600; margin-bottom: 15px; line-height: 1.4; text-align: center; padding: 0 10px;">
          <?php echo htmlspecialchars($_GET['msg'], ENT_QUOTES, 'UTF-8'); ?>
     </div>
     
     <!-- Buttons -->
     <div style="display: flex; justify-content: center; gap: 12px;">
          <!-- Confirm Button (Green) -->
          <button onclick="ejecutarConfirmacion();" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important; color: #ffffff !important; border: none !important; border-radius: 6px !important; padding: 8px 18px !important; font-weight: 700 !important; cursor: pointer !important; font-size: 11px !important; text-transform: uppercase !important; letter-spacing: 0.5px !important; box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3) !important; display: inline-flex !important; align-items: center !important; justify-content: center !important; height: 32px !important; transition: transform 0.2s; outline: none !important; border-style: none !important;">
               Confirmar
          </button>
          
          <!-- Cancel Button (Red) -->
          <button onclick="cerrarDialogo();" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important; color: #ffffff !important; border: none !important; border-radius: 6px !important; padding: 8px 18px !important; font-weight: 700 !important; cursor: pointer !important; font-size: 11px !important; text-transform: uppercase !important; letter-spacing: 0.5px !important; box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3) !important; display: inline-flex !important; align-items: center !important; justify-content: center !important; height: 32px !important; transition: transform 0.2s; outline: none !important; border-style: none !important;">
               Cancelar
          </button>
     </div>
</div>

<script type="text/javascript">
function ejecutarConfirmacion() {
     // Close dialog first
     cerrarDialogo();
     // Execute target JS code passed via query string
     <?php 
     // Ensure JS code is output directly for evaluation
     echo $_GET['ok']; 
     ?>;
}

function cerrarDialogo() {
     // Detect closest overlay close button (local or parent iframe scope)
     var closeBtn = document.getElementById('link__lbClose') || parent.document.getElementById('link__lbClose');
     if (closeBtn) {
          closeBtn.click();
     }
}
</script>
