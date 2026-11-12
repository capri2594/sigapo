<?php
/**
 * Guardia centralizada de sesión para SIGAPO.
 * Bloquea el acceso a páginas internas o estados AJAX (#Content__state=...)
 * cuando la sesión LoginSIRC no existe o ha expirado.
 */
if (!function_exists('sigapo_require_session')) {
    function sigapo_require_session($loginUrl = 'index.php') {
        if (!isset($_SESSION)) {
            session_name("LoginSIRC");
            @session_start();
        }

        if (isset($_SESSION['user']) && trim($_SESSION['user']) !== '') {
            return;
        }

        $isAjax = (
            (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') ||
            isset($_GET['KT_ajax_request']) ||
            isset($_POST['KT_ajax_request']) ||
            isset($_GET['ajax'])
        );

        $safeUrl = htmlspecialchars($loginUrl, ENT_QUOTES, 'UTF-8');

        if ($isAjax) {
            if (!headers_sent()) {
                header('HTTP/1.1 401 Unauthorized');
                header('Content-Type: text/html; charset=utf-8');
            }
            echo '<script type="text/javascript">window.top.location.href=' . json_encode($loginUrl) . ';</script>';
            exit;
        }

        if (!headers_sent()) {
            header('Expires: -1');
            header('Cache-Control: no-store, no-cache, must-revalidate');
            header('Pragma: no-cache');
            header('Content-Type: text/html; charset=utf-8');
        }
        ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="refresh" content="4;url=<?php echo $safeUrl; ?>" />
<title>Sesión Expirada - SIGAPO</title>
<script type="text/javascript">
(function() {
    var t = 'dark';
    try {
        var saved = localStorage.getItem('sigapo_theme') || localStorage.getItem('sirc_theme');
        if (saved === 'light' || saved === 'dark') { t = saved; }
    } catch (e) {}
    document.documentElement.setAttribute('data-theme', t);
})();
</script>
<style type="text/css">
html, body {
    margin: 0;
    padding: 0;
    min-height: 100vh;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #1a080c;
    color: #e2e8f0;
}
html[data-theme="light"], html[data-theme="light"] body {
    background-color: #f1f5f9;
    color: #1e293b;
}
.guard-card {
    width: 92%;
    max-width: 440px;
    background-color: #280d14;
    border: 1px solid rgba(180, 138, 40, 0.45);
    border-radius: 12px;
    box-shadow: 0 20px 45px rgba(0, 0, 0, 0.55);
    overflow: hidden;
    text-align: center;
}
html[data-theme="light"] .guard-card {
    background-color: #ffffff;
    border: 1px solid rgba(104, 0, 20, 0.25);
    box-shadow: 0 18px 40px rgba(80, 0, 14, 0.14);
}
.guard-header {
    background: linear-gradient(135deg, #50000e 0%, #780016 100%);
    color: #ffffff;
    padding: 16px 20px;
    border-bottom: 2px solid #b48a28;
    font-size: 14px;
    font-weight: 800;
    letter-spacing: 0.6px;
    text-transform: uppercase;
}
.guard-body {
    padding: 26px 24px 24px 24px;
}
.guard-icon {
    width: 54px;
    height: 54px;
    margin: 0 auto 14px auto;
    border-radius: 50%;
    background: rgba(180, 138, 40, 0.16);
    border: 1.5px solid #b48a28;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}
.guard-title {
    font-size: 16px;
    font-weight: 800;
    margin: 0 0 8px 0;
    color: #ffffff;
}
html[data-theme="light"] .guard-title {
    color: #50000e;
}
.guard-desc {
    font-size: 13px;
    line-height: 1.55;
    margin: 0 0 20px 0;
    color: #cbd5e1;
}
html[data-theme="light"] .guard-desc {
    color: #475569;
}
.guard-btn {
    display: inline-block;
    background: linear-gradient(135deg, #50000e 0%, #780016 100%);
    color: #ffffff;
    text-decoration: none;
    padding: 10px 22px;
    border-radius: 6px;
    border: 1px solid rgba(180, 138, 40, 0.55);
    font-size: 12px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    box-shadow: 0 4px 12px rgba(80, 0, 14, 0.35);
}
.guard-btn:hover {
    background: linear-gradient(135deg, #680014 0%, #991b1b 100%);
}
.guard-timer {
    margin-top: 14px;
    font-size: 11px;
    color: #94a3b8;
}
html[data-theme="light"] .guard-timer {
    color: #64748b;
}
</style>
</head>
<body>
  <div class="guard-card">
    <div class="guard-header">SIGAPO · Acceso Protegido</div>
    <div class="guard-body">
      <div class="guard-icon">🔒</div>
      <h2 class="guard-title">Sesión expirada o no iniciada</h2>
      <p class="guard-desc">
        Para acceder a esta vista del sistema debe iniciar sesión con su cuenta de funcionario.
      </p>
      <a class="guard-btn" href="<?php echo $safeUrl; ?>" target="_top">Ir al Inicio de Sesión</a>
      <div class="guard-timer">Redirigiendo automáticamente en <span id="sigapo_sec">4</span> segundos...</div>
    </div>
  </div>
  <script type="text/javascript">
  (function() {
      var s = 4;
      var el = document.getElementById('sigapo_sec');
      var timer = setInterval(function() {
          s--;
          if (el && s >= 0) el.innerHTML = s;
          if (s <= 0) {
              clearInterval(timer);
              window.top.location.href = <?php echo json_encode($loginUrl); ?>;
          }
      }, 1000);
  })();
  </script>
</body>
</html>
        <?php
        exit;
    }
}

