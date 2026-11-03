<?php
// HEAD content
?>
<link href="content/css/theme_variables.css" rel="stylesheet" type="text/css" />
<script src="content/js/theme_switcher.js" type="text/javascript"></script>
<style type="text/css">
.header-custom-panel {
     background-color: #1e293b !important;
     background-image: none !important;
     border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
     padding: 0 16px !important;
     height: 52px !important;
     display: flex !important;
     justify-content: space-between !important;
     align-items: center !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     box-sizing: border-box !important;
     user-select: none;
}

.header-left {
     display: flex !important;
     align-items: center !important;
     gap: 10px !important;
     white-space: nowrap !important;
     flex-shrink: 0 !important;
}

.header-brand {
     font-size: 19px !important;
     font-weight: 800 !important;
     color: #ffffff !important;
     text-decoration: none !important;
     letter-spacing: 0.8px !important;
     display: inline-flex !important;
     align-items: center !important;
}

.header-subtitle {
     font-size: 10px !important;
     font-weight: 700 !important;
     color: #f59e0b !important;
     letter-spacing: 0.6px !important;
     text-transform: uppercase !important;
     background: rgba(245, 158, 11, 0.12) !important;
     border: 1px solid rgba(245, 158, 11, 0.3) !important;
     padding: 3px 8px !important;
     border-radius: 4px !important;
     display: inline-flex !important;
     align-items: center !important;
     white-space: nowrap !important;
     line-height: 1.2 !important;
}

.header-right {
     display: flex !important;
     align-items: center !important;
     gap: 8px !important;
     white-space: nowrap !important;
     flex-shrink: 0 !important;
}

.header-badge {
     display: inline-flex !important;
     align-items: center !important;
     justify-content: center !important;
     gap: 6px !important;
     white-space: nowrap !important;
     background-color: rgba(15, 23, 42, 0.6) !important;
     border: 1px solid rgba(255, 255, 255, 0.12) !important;
     border-radius: 5px !important;
     padding: 0 12px !important;
     color: #e2e8f0 !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     text-decoration: none !important;
     cursor: pointer !important;
     transition: all 0.2s ease !important;
     height: 32px !important;
     line-height: 32px !important;
     box-sizing: border-box !important;
     letter-spacing: 0.4px !important;
     flex-shrink: 0 !important;
}

.header-badge:hover {
     background-color: rgba(190, 18, 60, 0.25) !important;
     border-color: #be123c !important;
     color: #ffffff !important;
     transform: translateY(-1px);
}

.header-user-label {
     font-size: 11px !important;
     font-weight: 700 !important;
     color: #94a3b8 !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     white-space: nowrap !important;
     flex-shrink: 0 !important;
     margin-left: 2px;
}

/* Estilo para los contenedores AJAX de Jaxon */
#mostrar_usuario {
     background-image: url(content/imagen/my_user.png) !important;
     background-repeat: no-repeat !important;
     background-position: 10px center !important;
     padding-left: 32px !important;
     padding-right: 12px !important;
     display: inline-flex !important;
     align-items: center !important;
     justify-content: center !important;
     white-space: nowrap !important;
     background-color: rgba(15, 23, 42, 0.6) !important;
     border: 1px solid rgba(245, 158, 11, 0.35) !important;
     border-radius: 5px !important;
     color: #f59e0b !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     height: 32px !important;
     line-height: 32px !important;
     box-sizing: border-box !important;
     cursor: pointer !important;
     text-decoration: none !important;
     transition: all 0.2s ease !important;
     flex-shrink: 0 !important;
}

#mostrar_usuario:hover {
     border-color: #f59e0b !important;
     background-color: rgba(245, 158, 11, 0.15) !important;
     box-shadow: 0 0 10px rgba(245, 158, 11, 0.2) !important;
}

#mostrar_usuarios_online {
     background-image: url(content/imagen/whosonline.png) !important;
     background-repeat: no-repeat !important;
     background-position: 10px center !important;
     padding-left: 32px !important;
     padding-right: 12px !important;
     display: inline-flex !important;
     align-items: center !important;
     justify-content: center !important;
     white-space: nowrap !important;
     background-color: rgba(15, 23, 42, 0.6) !important;
     border: 1px solid rgba(16, 185, 129, 0.35) !important;
     border-radius: 5px !important;
     color: #10b981 !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     height: 32px !important;
     line-height: 32px !important;
     box-sizing: border-box !important;
     cursor: pointer !important;
     text-decoration: none !important;
     transition: all 0.2s ease !important;
     flex-shrink: 0 !important;
}

#mostrar_usuarios_online:hover {
     border-color: #10b981 !important;
     background-color: rgba(16, 185, 129, 0.15) !important;
     box-shadow: 0 0 10px rgba(16, 185, 129, 0.2) !important;
}

.btn-logout {
     background-color: #ef4444 !important;
     border: none !important;
     border-radius: 5px !important;
     color: #ffffff !important;
     padding: 0 14px !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     cursor: pointer !important;
     transition: all 0.2s ease !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     height: 32px !important;
     line-height: 32px !important;
     box-sizing: border-box !important;
     white-space: nowrap !important;
     display: inline-flex !important;
     align-items: center !important;
     justify-content: center !important;
     flex-shrink: 0 !important;
}

.btn-logout:hover {
     background-color: #dc2626 !important;
     box-shadow: 0 2px 8px rgba(239, 68, 68, 0.4) !important;
}

.btn-logout:active {
     transform: scale(0.97) !important;
}

/* =========================================================
   CAMPANITA DE NOTIFICACIONES EN VIVO (SIGAPO 2026)
   ========================================================= */
.header-notif-container {
     position: relative;
     display: flex;
     align-items: center;
}

.header-notif-bell {
     position: relative;
     display: flex;
     align-items: center;
     justify-content: center;
     width: 32px;
     height: 28px;
     background-color: rgba(15, 23, 42, 0.5);
     border: 1px solid rgba(255, 255, 255, 0.1);
     border-radius: 4px;
     color: #94a3b8;
     cursor: pointer;
     transition: all 0.2s ease;
     box-sizing: border-box;
}

.header-notif-bell:hover {
     background-color: rgba(190, 18, 60, 0.2);
     border-color: #be123c;
     color: #ffffff;
}

.header-notif-bell.has-notifs {
     color: #f59e0b;
     border-color: rgba(245, 158, 11, 0.4);
}

.header-notif-bell.has-notifs:hover {
     border-color: #f59e0b;
}

.header-notif-badge {
     position: absolute;
     top: -5px;
     right: -6px;
     background-color: #ef4444;
     color: #ffffff;
     font-size: 9px;
     font-weight: 800;
     min-width: 16px;
     height: 16px;
     border-radius: 10px;
     display: flex;
     align-items: center;
     justify-content: center;
     padding: 0 4px;
     box-sizing: border-box;
     box-shadow: 0 0 8px rgba(239, 68, 68, 0.6);
     border: 1.5px solid #0f172a;
     animation: pulseNotif 2.5s infinite;
}

@keyframes pulseNotif {
     0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
     70% { transform: scale(1.05); box-shadow: 0 0 0 6px rgba(239, 68, 68, 0); }
     100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
}

.header-notif-dropdown {
     position: absolute;
     top: 36px;
     right: 0;
     width: 330px;
     background-color: #1e293b;
     border: 1px solid rgba(255, 255, 255, 0.15);
     border-radius: 8px;
     box-shadow: 0 15px 30px -5px rgba(0, 0, 0, 0.6), 0 0 0 1px rgba(255, 255, 255, 0.05);
     z-index: 10000;
     overflow: hidden;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
     animation: fadeInDown 0.18s ease-out;
}

@keyframes fadeInDown {
     from { opacity: 0; transform: translateY(-6px); }
     to { opacity: 1; transform: translateY(0); }
}

.notif-dropdown-header {
     display: flex;
     justify-content: space-between;
     align-items: center;
     padding: 10px 14px;
     background-color: #0f172a;
     border-bottom: 1px solid rgba(255, 255, 255, 0.1);
     font-size: 11px;
     font-weight: 700;
     color: #f8fafc;
     text-transform: uppercase;
     letter-spacing: 0.5px;
}

.notif-dropdown-count {
     background-color: rgba(245, 158, 11, 0.15);
     color: #f59e0b;
     border: 1px solid rgba(245, 158, 11, 0.3);
     padding: 2px 7px;
     border-radius: 10px;
     font-size: 10px;
     font-weight: 700;
     text-transform: none;
}

.notif-dropdown-list {
     max-height: 280px;
     overflow-y: auto;
}

.notif-item {
     padding: 10px 14px;
     border-bottom: 1px solid rgba(255, 255, 255, 0.05);
     cursor: pointer;
     transition: background-color 0.15s;
     text-align: left;
}

.notif-item:last-child {
     border-bottom: none;
}

.notif-item:hover {
     background-color: rgba(190, 18, 60, 0.15);
}

.notif-item-header {
     display: flex;
     justify-content: space-between;
     align-items: center;
     margin-bottom: 4px;
}

.notif-item-hr {
     color: #f59e0b;
     font-weight: 700;
     font-size: 11px;
}

.notif-item-time {
     color: #94a3b8;
     font-size: 10px;
}

.notif-item-sender {
     color: #e2e8f0;
     font-size: 11px;
     line-height: 1.3;
     margin-bottom: 6px;
     white-space: nowrap;
     overflow: hidden;
     text-overflow: ellipsis;
}

.notif-item-proveido {
     display: flex;
     align-items: center;
}

.notif-pill {
     background-color: rgba(190, 18, 60, 0.15);
     color: #fda4af;
     border: 1px solid rgba(190, 18, 60, 0.3);
     padding: 1px 7px;
     border-radius: 4px;
     font-size: 10px;
     font-weight: 600;
}

.notif-empty-state {
     padding: 25px 15px;
     text-align: center;
     color: #94a3b8;
     font-size: 12px;
}

.notif-empty-state div {
     font-weight: 700;
     color: #cbd5e1;
     margin-bottom: 3px;
}

.notif-empty-state p {
     margin: 0;
     font-size: 11px;
     color: #64748b;
}

.notif-dropdown-footer {
     padding: 8px 12px;
     background-color: #141316;
     border-top: 1px solid rgba(255, 255, 255, 0.1);
     text-align: center;
}

.notif-dropdown-footer a {
     color: #f59e0b;
     font-size: 11px;
     font-weight: 700;
     text-decoration: none;
     transition: color 0.15s;
}

.notif-dropdown-footer a:hover {
     color: #fde047;
     text-decoration: underline;
}

/* =========================================================
   ESTILOS SEMAFORO DE MORA (SIGAPO 2026)
   ========================================================= */
.badge-mora-critica {
     animation: pulseCritica 1.5s infinite !important;
}

@keyframes pulseCritica {
     0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.9); }
     70% { transform: scale(1.1); box-shadow: 0 0 0 7px rgba(239, 68, 68, 0); }
     100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
}

.notif-semaforo-bar {
     display: flex;
     gap: 6px;
     align-items: center;
}

.semaforo-mini {
     font-size: 9px;
     font-weight: 700;
     padding: 2px 6px;
     border-radius: 10px;
     letter-spacing: 0.3px;
     display: inline-flex;
     align-items: center;
}

.semaforo-mini-normal {
     background-color: rgba(16, 185, 129, 0.15);
     color: #10b981;
     border: 1px solid rgba(16, 185, 129, 0.3);
}

.semaforo-mini-alerta {
     background-color: rgba(245, 158, 11, 0.15);
     color: #f59e0b;
     border: 1px solid rgba(245, 158, 11, 0.3);
}

.semaforo-mini-mora {
     background-color: rgba(239, 68, 68, 0.15);
     color: #ef4444;
     border: 1px solid rgba(239, 68, 68, 0.3);
}

.notif-item-normal {
     border-left: 3px solid #10b981 !important;
}

.notif-item-alerta {
     border-left: 3px solid #f59e0b !important;
}

.notif-item-mora {
     border-left: 3px solid #ef4444 !important;
     background-color: rgba(239, 68, 68, 0.03);
}

.notif-item-footer-row {
     display: flex;
     justify-content: space-between;
     align-items: center;
     margin-top: 4px;
}

.notif-semaforo-pill {
     font-size: 9px;
     font-weight: 700;
     padding: 1px 6px;
     border-radius: 4px;
     text-transform: uppercase;
     letter-spacing: 0.3px;
}

.notif-semaforo-normal {
     background-color: rgba(16, 185, 129, 0.15);
     color: #34d399;
     border: 1px solid rgba(16, 185, 129, 0.3);
}

.notif-semaforo-alerta {
     background-color: rgba(245, 158, 11, 0.15);
     color: #fbbf24;
     border: 1px solid rgba(245, 158, 11, 0.3);
}

.notif-semaforo-mora {
     background-color: rgba(239, 68, 68, 0.2);
     color: #f87171;
     border: 1px solid rgba(239, 68, 68, 0.4);
}
.notif-dropdown-list {
     max-height: 380px !important;
     overflow-y: auto !important;
}

.notif-dropdown-list::-webkit-scrollbar {
     width: 5px;
}

.notif-dropdown-list::-webkit-scrollbar-track {
     background: rgba(15, 23, 42, 0.6);
}

.notif-dropdown-list::-webkit-scrollbar-thumb {
     background: #334155;
     border-radius: 4px;
}

.notif-dropdown-list::-webkit-scrollbar-thumb:hover {
     background: #475569;
}

/* =========================================================
   ESTILOS INTERACTIVOS FILTRO SEMAFORO (SIGAPO 2026)
   ========================================================= */
.semaforo-mini {
     cursor: pointer !important;
     transition: all 0.2s ease !important;
     user-select: none !important;
}

.semaforo-mini:hover {
     transform: translateY(-2px) scale(1.05) !important;
     filter: brightness(1.2) !important;
}

.semaforo-mini.semaforo-mini-active {
     box-shadow: 0 0 0 2px #ffffff, 0 0 10px currentColor !important;
     transform: scale(1.08) !important;
     font-weight: 800 !important;
}

.notif-dropdown-count {
     cursor: pointer !important;
     user-select: none !important;
     transition: background-color 0.2s, color 0.2s !important;
}

.notif-dropdown-count:hover {
     background-color: rgba(255, 255, 255, 0.15) !important;
     color: #ffffff !important;
}

/* Dual Theme Header Styles (Plan C) */
html[data-theme="light"] .header-custom-panel,
body[data-theme="light"] .header-custom-panel,
:root:not([data-theme="dark"]) .header-custom-panel {
     background: linear-gradient(135deg, #780016 0%, #990000 100%) !important;
     border-bottom: 2px solid #580010 !important;
     box-shadow: 0 2px 8px rgba(120, 0, 22, 0.25) !important;
}

html[data-theme="light"] .header-brand,
body[data-theme="light"] .header-brand,
:root:not([data-theme="dark"]) .header-brand {
     color: #ffffff !important;
     text-shadow: 0 1px 2px rgba(0,0,0,0.3) !important;
}

html[data-theme="light"] .header-subtitle,
body[data-theme="light"] .header-subtitle,
:root:not([data-theme="dark"]) .header-subtitle {
     color: #fde047 !important;
     background-color: rgba(253, 224, 71, 0.18) !important;
     border-color: rgba(253, 224, 71, 0.45) !important;
}

html[data-theme="light"] .header-badge,
body[data-theme="light"] .header-badge,
:root:not([data-theme="dark"]) .header-badge {
     background-color: rgba(255, 255, 255, 0.18) !important;
     border-color: rgba(255, 255, 255, 0.35) !important;
     color: #ffffff !important;
}

html[data-theme="light"] .header-badge:hover,
body[data-theme="light"] .header-badge:hover,
:root:not([data-theme="dark"]) .header-badge:hover {
     background-color: #ffffff !important;
     border-color: #ffffff !important;
     color: #800020 !important;
}

html[data-theme="light"] .header-notif-bell,
body[data-theme="light"] .header-notif-bell,
:root:not([data-theme="dark"]) .header-notif-bell {
     background-color: rgba(255, 255, 255, 0.18) !important;
     border-color: rgba(255, 255, 255, 0.35) !important;
     color: #ffffff !important;
}

html[data-theme="light"] #mostrar_usuario,
body[data-theme="light"] #mostrar_usuario,
:root:not([data-theme="dark"]) #mostrar_usuario {
     background-color: rgba(255, 255, 255, 0.18) !important;
     border-color: rgba(253, 224, 71, 0.5) !important;
     color: #fde047 !important;
}

html[data-theme="light"] #mostrar_usuarios_online,
body[data-theme="light"] #mostrar_usuarios_online,
:root:not([data-theme="dark"]) #mostrar_usuarios_online {
     background-color: rgba(255, 255, 255, 0.18) !important;
     border-color: rgba(167, 243, 208, 0.5) !important;
     color: #a7f3d0 !important;
}

html[data-theme="light"] .header-user-label,
body[data-theme="light"] .header-user-label,
:root:not([data-theme="dark"]) .header-user-label {
     color: #f1f5f9 !important;
}

/* Modo Oscuro Institucional GADOR Oruro */
html[data-theme="dark"] .header-custom-panel,
body[data-theme="dark"] .header-custom-panel {
     background: #141316 !important;
     border-bottom: 2px solid #780016 !important;
     box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5) !important;
}

html[data-theme="dark"] .header-brand,
body[data-theme="dark"] .header-brand {
     color: #ffffff !important;
}

html[data-theme="dark"] .header-subtitle,
body[data-theme="dark"] .header-subtitle {
     color: #f59e0b !important;
     background-color: rgba(245, 158, 11, 0.12) !important;
     border-color: rgba(245, 158, 11, 0.3) !important;
}

html[data-theme="dark"] .header-badge,
body[data-theme="dark"] .header-badge {
     background-color: rgba(24, 22, 26, 0.8) !important;
     border-color: rgba(255, 255, 255, 0.12) !important;
     color: #e2e8f0 !important;
}

html[data-theme="dark"] .header-badge:hover,
body[data-theme="dark"] .header-badge:hover {
     background-color: rgba(120, 0, 22, 0.4) !important;
     border-color: #f59e0b !important;
     color: #ffffff !important;
}

html[data-theme="dark"] .header-notif-bell,
body[data-theme="dark"] .header-notif-bell {
     background-color: rgba(24, 22, 26, 0.8) !important;
     border-color: rgba(255, 255, 255, 0.12) !important;
     color: #94a3b8 !important;
}

html[data-theme="dark"] #mostrar_usuario,
body[data-theme="dark"] #mostrar_usuario {
     background-color: rgba(24, 22, 26, 0.8) !important;
     border-color: rgba(245, 158, 11, 0.35) !important;
     color: #f59e0b !important;
}

html[data-theme="dark"] #mostrar_usuarios_online,
body[data-theme="dark"] #mostrar_usuarios_online {
     background-color: rgba(24, 22, 26, 0.8) !important;
     border-color: rgba(16, 185, 129, 0.35) !important;
     color: #34d399 !important;
}

html[data-theme="dark"] .header-user-label,
body[data-theme="dark"] .header-user-label {
     color: #94a3b8 !important;
}

</style>

<?php
// Begin HTML content
?>
<div class="panel__content header-custom-panel">
     <div class="header-left">
          <a id="<?php echo $ctrl->link_id() ?>" href="<?php echo $ctrl->link("Content", ""); ?>" class="header-brand">SIGAPO</a>
          <span class="header-subtitle">CORRESPONDENCIA 2026</span>
     </div>

     <div class="header-right">
          <!-- BOTON CONMUTADOR TEMA CLARO / OSCURO (Plan C) -->
          <a id="btn_header_theme" href="javascript:void(0);" class="header-badge theme-toggle-header" onclick="toggleSigapoTheme();" title="Alternar Modo Claro Institucional / Modo Oscuro Institucional">
               <span id="header_theme_icon" style="font-size: 13px; line-height: 1;">☀️</span>
               <span id="header_theme_text">Modo Claro</span>
          </a>

          <!-- GUIA TEL con el tag <a> y el ID "2" original para evitar que el JS de Jaxon falle -->
          <a id="2" href="#" style="text-decoration: none; display: inline-flex; flex-shrink: 0;" onclick="window.open('content/agenda_mostrar_dep.php','vguia',''); return false;">
               <div class="header-badge">GUIA TEL.</div>
          </a>

          <!-- MANUAL con el tag <a> y el ID "2" original para evitar que el JS de Jaxon falle -->
          <a id="2" href="#" style="text-decoration: none; display: inline-flex; flex-shrink: 0;" onclick="window.open('content/leer_manual.php','vmanual',''); return false;">
               <div class="header-badge">MANUAL</div>
          </a>

          <!-- CAMPANITA DE NOTIFICACIONES (Punto 5) -->
          <div class="header-notif-container" id="notif_container">
               <div class="header-notif-bell" id="notif_bell" onclick="toggleNotifDropdown(event);" title="Correspondencia Pendiente de Recepción">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                         <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                         <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                    <span class="header-notif-badge" id="notif_badge" style="display: none;">0</span>
               </div>
               
               <div class="header-notif-dropdown" id="notif_dropdown" style="display: none;">
                    <div class="notif-dropdown-header">
                         <div style="display:flex; flex-direction:column; gap:2px;">
                              <span>Bandeja Pendiente</span>
                              <span class="notif-dropdown-count" id="notif_header_count" style="display:none;">0 pendientes</span>
                         </div>
                         <div class="notif-semaforo-bar" id="notif_semaforo_summary">
                              <!-- Mini badges semaforo inyectados via JS -->
                         </div>
                    </div>
                    <div class="notif-dropdown-list" id="notif_list">
                         <div class="notif-empty-state">
                              <div>Cargando...</div>
                         </div>
                    </div>
                    <div class="notif-dropdown-footer">
                         <a href="javascript:void(0)" onclick="abrirBandejaEntrada();">Ver Todo en Libro de Entradas &rarr;</a>
                    </div>
               </div>
          </div>

          <span class="header-user-label">Usuario:</span>

          <a id="<?php echo $ctrl->link_id() ?>" href="<?php echo $ctrl->link("Content", ""); ?>" style="text-decoration: none; display: inline-flex; flex-shrink: 0;">
               <div id="mostrar_usuario">&nbsp;</div>
          </a>

          <a id="<?php echo $ctrl->link_id() ?>" href="<?php echo $ctrl->link("Content", "tooltip_usuariosonline"); ?>" style="text-decoration: none; display: inline-flex; flex-shrink: 0;">
               <div id="mostrar_usuarios_online"></div>
          </a>

          <script language="JavaScript" type="text/javascript">
               function closeSirc(){
                    // Abre el dialogo de confirmación asincrono modernizado
                    new Widgets.Dialog('Confirmar Salida', 'content/postales/dialog_confirmar.php?msg=' + encodeURIComponent('¿Está seguro de que desea cerrar la sesión del sistema?') + '&ok=' + encodeURIComponent('window.location.href="cerrarSession.php"'), { click_outside: true, width: 380, height: 220 });
               }
          </script>
          <input type="button" class="btn-logout" value="Cerrar Sesión" onclick="closeSirc();"/>
     </div>
</div>
<?php
// End HTML content
?>
