<?php require_once('Connections/snet.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_name("LoginSIRC");
  session_start();
}
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_snet, $snet);
$query_usuarios_online = "SELECT f.*, d.nombredep, d.sigla 
                          FROM funcionario f 
                          LEFT JOIN dependencia d ON f.dependencia_cod = d.cod
                          WHERE f.usuario_cuenta IN (SELECT cuenta FROM session WHERE cuenta != '') 
                          ORDER BY d.nombredep ASC, f.nombre ASC";
$usuarios_online = mysql_query($query_usuarios_online, $snet) or die(mysql_error());
$row_usuarios_online = mysql_fetch_assoc($usuarios_online);
$totalRows_usuarios_online = mysql_num_rows($usuarios_online);
$miCuentaActual = isset($_SESSION['user']) ? strtolower(trim($_SESSION['user'])) : '';
?><?php
// HEAD content
?>
<style type="text/css">
.online-dir-card {
    border-radius: 10px;
    padding: 16px 20px;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    box-sizing: border-box;
}
.online-dir-topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 10px;
    padding: 12px 16px;
    border-radius: 8px;
    background: linear-gradient(135deg, #4d000d 0%, #680014 100%);
    color: #ffffff;
    border: 1px solid rgba(180, 138, 40, 0.45);
    margin-bottom: 14px;
}
.online-dir-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 12px;
}
.online-dir-table th {
    background: linear-gradient(135deg, #4d000d 0%, #680014 100%);
    color: #ffffff;
    text-align: left;
    padding: 10px 12px;
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #b48a28;
}
.online-dir-table td {
    padding: 10px 12px;
    vertical-align: middle;
    border-bottom: 1px solid rgba(180, 138, 40, 0.22);
}
.online-chat-btn {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 6px 12px;
    border-radius: 6px;
    background: linear-gradient(135deg, #54000f 0%, #780016 100%);
    color: #ffffff !important;
    border: 1px solid rgba(180, 138, 40, 0.5);
    font-size: 11px;
    font-weight: 700;
    text-decoration: none !important;
    cursor: pointer;
}
.online-chat-btn:hover {
    background: linear-gradient(135deg, #680014 0%, #8f001b 100%);
    border-color: #b48a28;
}
html[data-theme="light"] .online-dir-card,
:root:not([data-theme="dark"]) .online-dir-card {
    background-color: #ffffff;
    color: #1e293b;
    border: 1px solid #cbd5e1;
}
html[data-theme="dark"] .online-dir-card,
body[data-theme="dark"] .online-dir-card {
    background-color: #280d14;
    color: #ffffff;
    border: 1px solid rgba(180, 138, 40, 0.4);
}
</style>

<?php
// Begin HTML content
?>
<div class="panel__content">
  <div class="online-dir-card">
    <div class="online-dir-topbar">
      <div style="display:flex; align-items:center; gap:10px;">
        <span style="display:inline-block; width:10px; height:10px; border-radius:50%; background:#10b981; box-shadow:0 0 8px #10b981;"></span>
        <div>
          <div style="font-size:14px; font-weight:800; letter-spacing:0.4px; text-transform:uppercase;">
            Funcionarios en Línea (<?php echo intval($totalRows_usuarios_online); ?> conectados)
          </div>
          <div style="font-size:11px; opacity:0.85;">
            Directorio de presencia activa y mensajería instantánea interna SIGAPO Spark
          </div>
        </div>
      </div>
      <div style="display:flex; gap:8px;">
        <button type="button" class="online-chat-btn" onclick="if(window.toggleSigapoSpark){window.toggleSigapoSpark(true);}">
          💬 Abrir Directorio Completo Spark
        </button>
        <button type="button" class="online-chat-btn" style="background:linear-gradient(135deg, #059669 0%, #10b981 100%);" onclick="if(window.openSparkBroadcastComposer){window.openSparkBroadcastComposer();}">
          📢 Emitir Comunicado en Masa
        </button>
      </div>
    </div>

    <?php if ($totalRows_usuarios_online > 0) { ?>
    <table class="online-dir-table">
      <thead>
        <tr>
          <th width="40">#</th>
          <th width="160">Usuario</th>
          <th>Funcionario / Cargo</th>
          <th>Unidad / Dependencia</th>
          <th width="140" style="text-align:center;">Acción Spark</th>
        </tr>
      </thead>
      <tbody>
        <?php $n = 0; do { $n++; 
          $ctaRow = trim($row_usuarios_online['usuario_cuenta']);
          $ruta = "perfiles/fotos/";
          $avatar = $ruta . $ctaRow . ".jpg";
          if (!file_exists($avatar)) {
            $avatar = $ruta . "default_avatar013.jpg";
          }
          $depTexto = !empty($row_usuarios_online['nombredep']) 
            ? $row_usuarios_online['nombredep'] 
            : ("Unidad #" . $row_usuarios_online['dependencia_cod']);
        ?>
        <tr>
          <td style="font-weight:800;"><?php echo $n; ?></td>
          <td>
            <div style="display:flex; align-items:center; gap:9px;">
              <div style="position:relative; width:38px; height:38px; flex-shrink:0;">
                <img src="<?php echo htmlspecialchars($avatar); ?>" width="38" height="38" style="border-radius:50%; object-fit:cover; border:1px solid #b48a28;" alt="" />
                <span style="position:absolute; bottom:0; right:0; width:10px; height:10px; border-radius:50%; background:#10b981; border:2px solid #1a080c;"></span>
              </div>
              <span style="font-weight:700;"><?php echo htmlspecialchars($ctaRow); ?></span>
            </div>
          </td>
          <td>
            <div style="font-weight:700; font-size:12px;"><?php echo htmlspecialchars($row_usuarios_online['nombre']); ?></div>
            <div style="font-size:10px; opacity:0.8; text-transform:uppercase;"><?php echo htmlspecialchars($row_usuarios_online['cargo']); ?></div>
          </td>
          <td>
            <span style="font-weight:600;"><?php echo htmlspecialchars($depTexto); ?></span>
          </td>
          <td style="text-align:center;">
            <?php if (strtolower($ctaRow) !== $miCuentaActual) { ?>
              <button type="button" class="online-chat-btn" onclick="if(window.openSparkChatWith){window.openSparkChatWith('<?php echo htmlspecialchars(addslashes($ctaRow)); ?>');}">
                💬 Chatear
              </button>
            <?php } else { ?>
              <span style="font-size:10px; font-weight:700; color:#10b981;">● Tu sesión activa</span>
            <?php } ?>
          </td>
        </tr>
        <?php } while ($row_usuarios_online = mysql_fetch_assoc($usuarios_online)); ?>
      </tbody>
    </table>
    <?php } else { ?>
      <div style="padding:24px; text-align:center; opacity:0.8;">No hay otros usuarios en línea en este momento.</div>
    <?php } ?>
  </div>
</div>
<?php
// End HTML content
?>
<?php
mysql_free_result($usuarios_online);
?>
