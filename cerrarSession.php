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
<link href="content/css/theme_variables.css" rel="stylesheet" type="text/css" />
<script src="content/js/theme_switcher.js" type="text/javascript"></script>
<style type="text/css">
body {
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
     min-height: 100vh;
     display: flex;
     justify-content: center;
     align-items: center;
     margin: 0;
     padding: 20px;
     transition: background 0.3s ease, color 0.3s ease;
}

/* Modo Claro */
body,
body[data-theme="light"],
html[data-theme="light"] body {
     background: radial-gradient(circle at center, #ffffff 0%, #cbd5e1 100%);
     color: #18181b;
}

html[data-theme="light"] .logout-card,
body[data-theme="light"] .logout-card,
:root:not([data-theme="dark"]) .logout-card {
     background: #ffffff;
     border: 1px solid #cbd5e1;
     box-shadow: 0 20px 45px -10px rgba(0, 0, 0, 0.12), 0 0 25px rgba(80, 0, 14, 0.08);
}

html[data-theme="light"] .logout-icon,
body[data-theme="light"] .logout-icon,
:root:not([data-theme="dark"]) .logout-icon {
     background-color: #fff1f2;
     border: 1px solid rgba(180, 138, 40, 0.45);
     color: #50000e;
}

html[data-theme="light"] .spinner,
body[data-theme="light"] .spinner,
:root:not([data-theme="dark"]) .spinner {
     border: 4px solid rgba(80, 0, 14, 0.15);
     border-top-color: #50000e;
     border-right-color: #b48a28;
}

html[data-theme="light"] h1,
body[data-theme="light"] h1,
:root:not([data-theme="dark"]) h1 {
     color: #18181b;
}

html[data-theme="light"] p,
body[data-theme="light"] p,
:root:not([data-theme="dark"]) p {
     color: #475569;
}

html[data-theme="light"] .redirect-text,
body[data-theme="light"] .redirect-text,
:root:not([data-theme="dark"]) .redirect-text {
     color: #50000e;
}

/* Modo Oscuro Institucional GADOR Oruro (Opción 1: Guindo Imperial Profundo) */
body[data-theme="dark"],
html[data-theme="dark"] body {
     background: radial-gradient(circle at center, #280d14 0%, #1a080c 100%) !important;
     color: #ffffff;
}

html[data-theme="dark"] .logout-card {
     background: #280d14;
     border: 1px solid rgba(180, 138, 40, 0.38);
     box-shadow: 0 20px 50px -10px rgba(0, 0, 0, 0.8), 0 0 30px rgba(120, 0, 22, 0.35);
}

html[data-theme="dark"] .logout-icon {
     background-color: #50000e;
     border: 1px solid rgba(180, 138, 40, 0.45);
     color: #ffffff;
}

html[data-theme="dark"] .spinner {
     border: 4px solid rgba(180, 138, 40, 0.2);
     border-top-color: #ffffff;
     border-right-color: #b48a28;
}

html[data-theme="dark"] h1 {
     color: #ffffff;
}

html[data-theme="dark"] p {
     color: #cbd5e1;
}

html[data-theme="dark"] .redirect-text {
     color: #ffffff;
}

.logout-card {
     border-radius: 12px;
     padding: 40px;
     width: 100%;
     max-width: 380px;
     text-align: center;
     display: flex;
     flex-direction: column;
     align-items: center;
     gap: 16px;
     box-sizing: border-box;
     transition: all 0.3s ease;
}

.logout-icon {
     width: 64px;
     height: 64px;
     border-radius: 50%;
     display: flex;
     justify-content: center;
     align-items: center;
     margin-bottom: 8px;
     transition: all 0.3s ease;
}

.spinner {
     width: 36px;
     height: 36px;
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
}

p {
     font-size: 14px;
     margin: 0;
}

.redirect-text {
     font-size: 11px;
     font-weight: 700;
     text-transform: uppercase;
     letter-spacing: 0.8px;
     margin-top: 8px;
}
</style>
</head>

<body>
<div class="logout-card">
     <div class="logout-icon">
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
