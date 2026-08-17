<?php 
 //header("Cache-Control: no-cache");
 header('Content-Type: text/html; charset=UTF-8');
 session_name("LoginSIRC"); 
 session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cambiar Password</title>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body {
     background-color: transparent !important;
     color: #cbd5e1 !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     margin: 10px !important;
     padding: 0 !important;
}

/* Main outer layout card */
table.main-layout {
     background-color: #1e293b !important;
     border: 1px solid rgba(255, 255, 255, 0.1) !important;
     border-radius: 12px !important;
     box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4) !important;
     overflow: hidden !important;
     width: 100% !important;
     max-width: 480px !important;
     margin: 0 auto !important;
     border-collapse: collapse !important;
     box-sizing: border-box !important;
}

/* Notice Banner */
td.msg_sis {
     background-color: rgba(245, 158, 11, 0.1) !important;
     border: 1px solid rgba(245, 158, 11, 0.25) !important;
     border-radius: 6px !important;
     padding: 10px 14px !important;
}

#msg_sistema {
     color: #f59e0b !important;
     font-size: 11px !important;
     font-weight: 600 !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
}

/* Form Header cell */
td.form-header {
     background-color: rgba(37, 99, 235, 0.1) !important;
     border-bottom: 1px solid rgba(37, 99, 235, 0.25) !important;
     color: #3b82f6 !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     padding: 12px 16px !important;
}

/* Form body table */
table.form-body {
     background-color: transparent !important;
     width: 100% !important;
}

/* Row Labels */
td.info-label {
     color: #94a3b8 !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     padding-right: 15px !important;
     text-align: right !important;
     width: 160px !important;
}

/* Form Inputs styling */
input[type="password"] {
     background-color: rgba(15, 23, 42, 0.6) !important;
     border: 1px solid rgba(255, 255, 255, 0.1) !important;
     border-radius: 6px !important;
     color: #ffffff !important;
     padding: 6px 10px !important;
     font-size: 13px !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     width: 90% !important;
     outline: none !important;
     box-sizing: border-box !important;
     transition: all 0.2s !important;
}

input[type="password"]:focus {
     border-color: #2563eb !important;
     box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2) !important;
}

/* Premium Guardar Button */
input#button {
     background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
     color: #ffffff !important;
     border: none !important;
     border-radius: 6px !important;
     padding: 8px 24px !important;
     font-weight: 700 !important;
     cursor: pointer !important;
     font-size: 11px !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3) !important;
     transition: all 0.2s !important;
}

input#button:hover {
     box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4) !important;
     transform: translateY(-1px) !important;
}

input#button:active {
     transform: translateY(1px) !important;
}

/* Hide Spry errors */
.textfieldRequiredMsg {
     display: none !important;
}
</style>
<script type="text/javascript" src="js/scriptaculous/prototype.js"></script>
<script type="text/javascript">
function cpswd(){
     var url = 'ajax/cambiar_pswd.php';
     var myRand = parseInt(Math.random()*999999999999999);  
     var pars = "rand="+myRand;
         pars = pars+"&cuenta=<?php echo $_SESSION['user']; ?>";
         pars = pars+"&old_pswd="+escape($F('pswd'));
         pars = pars+"&new_pswd="+escape($F('npswd'));
         pars = pars+"&repeat_new_pswd="+escape($F('rnpswd'));
     var target = 'msg_sistema';
     var miAjax = new Ajax.Updater(target, url, {method: 'get', parameters: pars, onComplete: showResponse});
}

function showResponse(originalRequest) {
     var resultado=originalRequest.responseText;
     var ok=resultado.split(":");
     if (ok[0]=='(ok-correcto)'){
          $('pswd').value="";
          $('npswd').value="";
          $('rnpswd').value="";
     }
}
   
function enviar(){
     confirmar=confirm('Esta seguro?. Desea cambiar la contraseña.');
     if (confirmar==true) {
          if(($F('pswd')=="")||($F('npswd')=="")||($F('rnpswd')=="")||($F('cuenta')=="")){
               alert('[error-formulario]: No se permiten campos vacios');
          } else {
               cpswd();
          }
     }
}	
</script>
</head>

<body>
<form id="form1" name="form1" onsubmit="return false;">
  <table class="main-layout" border="0" align="center" cellspacing="0" cellpadding="0">
    <!-- Notice Banner Row -->
    <tr>
      <td style="padding: 16px;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="msg_sis">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="30" align="center" valign="middle">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                         <circle cx="12" cy="12" r="10"></circle>
                         <line x1="12" y1="8" x2="12" y2="12"></line>
                         <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                  </td>
                  <td>
                    <div id="msg_sistema">Favor, llenar el siguiente formulario.</div>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    
    <!-- Title Header Row -->
    <tr>
      <td class="form-header">
        Cambio de Contraseña
        <input name="cuenta" type="hidden" id="cuenta" value="<?php echo $_SESSION['user']; ?>" />
      </td>
    </tr>
    
    <!-- Inputs Form Fields Row -->
    <tr>
      <td style="padding: 16px;">
        <table class="form-body" border="0" cellpadding="0" cellspacing="6">
          <tr>
            <td class="info-label">Password Actual:</td>
            <td>
              <span id="sprytextfield1">
                <input type="password" name="pswd" id="pswd" />
                <span class="textfieldRequiredMsg">x</span>
              </span>
            </td>
          </tr>
          <tr>
            <td class="info-label">Nuevo Password:</td>
            <td>
              <span id="sprytextfield2">
                <input type="password" name="npswd" id="npswd" />
                <span class="textfieldRequiredMsg">x</span>
              </span>
            </td>
          </tr>
          <tr>
            <td class="info-label">Repetir Nuevo Password:</td>
            <td>
              <span id="sprytextfield3">
                <input type="password" name="rnpswd" id="rnpswd" />
                <span class="textfieldRequiredMsg">x</span>
              </span>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    
    <!-- Action Save Button Row -->
    <tr>
      <td style="padding: 16px; text-align: center; background-color: rgba(15, 23, 42, 0.2); border-top: 1px solid rgba(255,255,255,0.05);">
        <input name="button" type="button" id="button" value="Guardar" onclick="enviar();"/>
      </td>
    </tr>
  </table>
</form>

<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {validateOn:["blur"]});
</script>
</body>
</html>
