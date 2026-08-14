<?php
// HEAD content
?>
<style type="text/css">
.header-custom-panel {
     background-color: #1e293b !important;
     background-image: none !important;
     border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
     padding: 8px 20px !important;
     height: 52px !important;
     display: flex !important;
     justify-content: space-between !important;
     align-items: center !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     box-sizing: border-box !important;
}

.header-left {
     display: flex;
     align-items: center;
     gap: 8px;
}

.header-left a {
     font-size: 18px;
     font-weight: 800;
     color: #ffffff !important;
     text-decoration: none !important;
     letter-spacing: 0.5px;
}

.header-left span {
     font-size: 11px;
     color: #f59e0b;
     font-weight: 700;
     text-transform: uppercase;
     letter-spacing: 0.5px;
}

.header-right {
     display: flex;
     align-items: center;
     gap: 12px;
}

.header-badge {
     display: flex;
     align-items: center;
     background-color: rgba(15, 23, 42, 0.5);
     border: 1px solid rgba(255, 255, 255, 0.1);
     border-radius: 4px;
     padding: 6px 12px;
     color: #e2e8f0 !important;
     font-size: 10px;
     font-weight: 700;
     text-decoration: none !important;
     cursor: pointer;
     transition: background-color 0.2s, border-color 0.2s;
     height: 28px;
     box-sizing: border-box;
     letter-spacing: 0.5px;
}

.header-badge:hover {
     background-color: rgba(37, 99, 235, 0.2);
     border-color: #2563eb;
     color: #ffffff !important;
}

.header-user-label {
     font-size: 10px;
     font-weight: 700;
     color: #94a3b8;
     text-transform: uppercase;
     letter-spacing: 0.5px;
}

/* Estilo para los contenedores AJAX de Jaxon */
#mostrar_usuario {
     background-image: url(content/imagen/my_user.png);
     background-repeat: no-repeat;
     background-position: 8px center;
     padding-left: 28px !important;
     display: flex;
     align-items: center;
     background-color: rgba(15, 23, 42, 0.5) !important;
     border: 1px solid rgba(255, 255, 255, 0.1) !important;
     border-radius: 4px;
     color: #f59e0b !important;
     font-size: 11px;
     font-weight: 600;
     height: 28px;
     padding-right: 10px;
     box-sizing: border-box;
     cursor: pointer;
     text-decoration: none;
     transition: border-color 0.2s;
}

#mostrar_usuario:hover {
     border-color: #f59e0b !important;
}

#mostrar_usuarios_online {
     background-image: url(content/imagen/whosonline.png);
     background-repeat: no-repeat;
     background-position: 8px center;
     padding-left: 28px !important;
     display: flex;
     align-items: center;
     background-color: rgba(15, 23, 42, 0.5) !important;
     border: 1px solid rgba(255, 255, 255, 0.1) !important;
     border-radius: 4px;
     color: #10b981 !important;
     font-size: 11px;
     font-weight: 600;
     height: 28px;
     padding-right: 10px;
     box-sizing: border-box;
     cursor: pointer;
     text-decoration: none;
}

.btn-logout {
     background-color: #ef4444;
     border: none;
     border-radius: 4px;
     color: white;
     padding: 6px 12px;
     font-size: 10px;
     font-weight: 700;
     cursor: pointer;
     transition: background-color 0.2s, transform 0.1s;
     text-transform: uppercase;
     letter-spacing: 0.5px;
     height: 28px;
     box-sizing: border-box;
}

.btn-logout:hover {
     background-color: #dc2626;
}

.btn-logout:active {
     transform: scale(0.97);
}
</style>

<?php
// Begin HTML content
?>
<div class="panel__content header-custom-panel">
     <div class="header-left">
          <a id="<?php echo $ctrl->link_id() ?>" href="<?php echo $ctrl->link("Content", ""); ?>">SIGAPO</a>
          <span>- Correspondencia 2026</span>
     </div>

     <div class="header-right">
          <!-- GUIA TEL con el tag <a> y el ID "2" original para evitar que el JS de Jaxon falle -->
          <a id="2" href="#" style="text-decoration: none;" onclick="window.open('content/agenda_mostrar_dep.php','vguia','')">
               <div class="header-badge">GUIA TEL.</div>
          </a>

          <!-- MANUAL con el tag <a> y el ID "2" original para evitar que el JS de Jaxon falle -->
          <a id="2" href="#" style="text-decoration: none;" onclick="window.open('content/leer_manual.php','vmanual','')">
               <div class="header-badge">MANUAL</div>
          </a>

          <span class="header-user-label">Usuario:</span>

          <a id="<?php echo $ctrl->link_id() ?>" href="<?php echo $ctrl->link("Content", ""); ?>" style="text-decoration: none;">
               <div id="mostrar_usuario">&nbsp;</div>
          </a>

          <a id="<?php echo $ctrl->link_id() ?>" href="<?php echo $ctrl->link("Content", "tooltip_usuariosonline"); ?>" style="text-decoration: none;">
               <div id="mostrar_usuarios_online"></div>
          </a>

          <script language="JavaScript" type="text/javascript">
               function closeSirc(){
                    resp=confirm('Seguro?');
                    if (resp==true) {document.location.href="cerrarSession.php";};
               }
          </script>
          <input type="button" class="btn-logout" value="Cerrar Sesión" onclick="closeSirc();"/>
     </div>
</div>
<?php
// End HTML content
?>
