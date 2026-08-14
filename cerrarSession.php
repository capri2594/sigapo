<?php 
session_name("LoginSIRC");
session_start();
header("Content-Type: text/html; charset=utf-8");
header("Cache-Control: no-cache, must-revalidate"); 
session_destroy();
header('Expires: -1');
header("Cache-control: no-store, no-cache, must-revalidate");
header("Cache-control: post-ckeck=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cerrando Sesión...</title>
<style type="text/css">
body {
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
     background: radial-gradient(circle at center, #1e293b 0%, #0f172a 100%);
     color: #f8fafc;
     min-height: 100vh;
     display: flex;
     justify-content: center;
     align-items: center;
     margin: 0;
     padding: 20px;
}

.logout-card {
     background: rgba(30, 41, 59, 0.95);
     border: 1px solid rgba(255, 255, 255, 0.1);
     border-radius: 12px;
     box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.4), 0 8px 10px -6px rgba(0, 0, 0, 0.4);
     padding: 40px;
     width: 100%;
     max-width: 380px;
     text-align: center;
     display: flex;
     flex-direction: column;
     align-items: center;
     gap: 16px;
}

.logout-icon {
     width: 64px;
     height: 64px;
     border-radius: 50%;
     background-color: rgba(59, 130, 246, 0.1);
     color: #3b82f6;
     display: flex;
     justify-content: center;
     align-items: center;
     margin-bottom: 8px;
}

.spinner {
     width: 36px;
     height: 36px;
     border: 4px solid rgba(255, 255, 255, 0.1);
     border-left-color: #3b82f6;
     border-radius: 50%;
     animation: spin 1s linear infinite;
     margin-top: 10px;
}

@keyframes spin {
     0% { transform: rotate(0deg); }
     100% { transform: rotate(360deg); }
}

h1 {
     font-size: 20px;
     font-weight: 700;
     margin: 0;
     color: #f8fafc;
}

p {
     font-size: 14px;
     color: #94a3b8;
     margin: 0;
}

.redirect-text {
     font-size: 11px;
     color: #f59e0b;
     font-weight: 600;
     text-transform: uppercase;
     letter-spacing: 0.5px;
     margin-top: 8px;
}
</style>
</head>

<body>
<div class="logout-card">
     <div class="logout-icon">
          <!-- Icono SVG de Salida/Log-out -->
          <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
               <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
               <polyline points="16 17 21 12 16 7"></polyline>
               <line x1="21" y1="12" x2="9" y2="12"></line>
          </svg>
     </div>
     
     <h1>Gracias por usar el sistema</h1>
     <p>Su sesión ha sido cerrada correctamente.</p>
     
     <div class="spinner"></div>
     <span class="redirect-text">Espere un momento, por favor...</span>
</div>

<script type="text/javascript">
     function cambiar(){
          window.parent.document.location="index.php";
     }
     setTimeout("cambiar()", 2000);
</script>
</body>
</html>
