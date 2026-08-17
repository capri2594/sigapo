<?php 
session_name("LoginSIRC");
session_start();
header('Content-Type: text/html; charset=UTF-8');
?>
<link href="includes/jaxon/widgets/tabset/css/tabset.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="includes/jaxon/widgets/tabset/js/tabset.js"></script>
<style type="text/css">
/* Override Jaxon Tabset legacy layout completely to align with SIGAPO design */
.tabset {
     background: transparent !important;
     border: none !important;
     box-shadow: none !important;
}

ul.tabset_tabs {
     display: flex !important;
     border-bottom: 2px solid rgba(255, 255, 255, 0.05) !important;
     padding: 0 0 2px 0 !important;
     margin: 0 0 20px 0 !important;
     list-style: none !important;
     background: transparent !important;
     height: auto !important;
     justify-content: flex-start !important;
}

ul.tabset_tabs li.tab {
     background-image: none !important;
     background: transparent !important;
     border: none !important;
     margin: 0 12px 0 0 !important;
     padding: 0 !important;
     height: auto !important;
     float: none !important;
}

ul.tabset_tabs li.tab a {
     display: block !important;
     padding: 10px 16px !important;
     color: #94a3b8 !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     text-transform: uppercase !important;
     letter-spacing: 0.7px !important;
     text-decoration: none !important;
     border-bottom: 2px solid transparent !important;
     transition: all 0.2s ease-in-out !important;
     background: transparent !important;
     height: auto !important;
     line-height: normal !important;
     outline: none !important;
}

ul.tabset_tabs li.tab:hover a {
     color: #3b82f6 !important;
}

ul.tabset_tabs li.tab.selected {
     background-image: none !important;
     background: transparent !important;
     border: none !important;
     float: none !important;
}

ul.tabset_tabs li.tab.selected a {
     color: #3b82f6 !important;
     border-bottom: 2px solid #3b82f6 !important;
     background: transparent !important;
}

/* Tab Bodies and contents clean-up */
.tabBody {
     border: none !important;
     background: transparent !important;
     padding: 0 !important;
     display: none !important;
     box-shadow: none !important;
     height: auto !important;
}

.tabBody.body_active {
     display: block !important;
}

.tabContent {
     background: transparent !important;
     border: none !important;
     padding: 0 !important;
}

iframe {
     border: none !important;
     background: transparent !important;
     display: block !important;
}
</style>

<div class="panel__content">
     <!-- Restored width:700px so Jaxon JS parses width correctly instead of collapsing to 100px -->
     <div id="tab_perfil" align="center" class="tabset htmlrendering" style="width:700px; height:415px; margin: 0 auto;">
          <ul class="tabset_tabs">
               <li id="tab_perfiltab0-tab" class="tab selected"><a href="#">Datos Personales</a></li>
               <li id="tab_perfiltab1-tab" class="tab"><a href="#">Cambiar Contraseña</a></li>
          </ul>
          
          <div id="tab_perfiltab0-body" class="tabBody body_active">
               <div class="tabContent">
                    <iframe src="content/perfil_datosfun.php" width="100%" height="320px" frameborder="0" scrolling="no" allowtransparency="true"></iframe>
               </div>
          </div>
          
          <div id="tab_perfiltab1-body" class="tabBody">
               <div class="tabContent">
                    <iframe src="content/password.php" width="100%" height="320px" frameborder="0" scrolling="no" allowtransparency="true"></iframe>
               </div>
          </div>
     </div>
     
     <script type="text/javascript">
          var tab_perfil = new Widgets.Tabset('tab_perfil', null);
     </script>
</div>