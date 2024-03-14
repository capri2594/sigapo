<?php 
session_name("LoginSIRC");
session_start();
header('Content-Type: text/html; charset=UTF-8');
?><?php
// HEAD content
?>
<link href="includes/jaxon/widgets/tabset/css/tabset.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="includes/jaxon/widgets/tabset/js/tabset.js"></script>
<style type="text/css">
<!--
.style1 {font-weight: bold}
.style6 {
	color: #FF6600;
	font-size: 14;
}
-->
</style>

<?php
// Begin HTML content
?>
<div class="panel__content">
              <p><br />
              <div id="tab_perfil" align="center" class="tabset htmlrendering" style="width:700px;height:415px;">
                <ul class="tabset_tabs">
                  <li id="tab_perfiltab0-tab" class="tab selected"><a href="#">Datos Personales</a></li>
                  <li id="tab_perfiltab1-tab" class="tab"><a href="#">Cambiar Contraseña</a></li>
                  <!--MODIFICADO PARA NO MOSTRAR LISTA DE COMPAÑEROS-->
				  <!--<li id="tab_perfiltab2-tab" class="tab"><a href="#">Lista de Compañeros</a></li>-->
                </ul>
                <div id="tab_perfiltab0-body" class="tabBody body_active">
                  <div class="tabContent">
                    <iframe src="content/perfil_datosfun.php" width="100%" height="250px"  frameborder="0" marginheight="0" marginwidth="0" scrolling="no" ></iframe>
                  </div>
                </div>
                <div id="tab_perfiltab1-body" class="tabBody">
                  <div class="tabContent style6">
                    <iframe src="content/password.php" width="100%" height="310px"  frameborder="0" marginheight="0" marginwidth="0" scrolling="no" ></iframe>
                  </div>
                </div>
                <div id="tab_perfiltab2-body" class="tabBody">
                  <div class="tabContent">
                    <iframe src="content/datagrid/view.php?cod_dep=<?php echo $_SESSION['cod_dep']; ?>" width="100%" height="280px"  frameborder="0" marginheight="0" marginwidth="0" scrolling="no" ></iframe>
                  </div>
                </div>
              </div>
            <script type="text/javascript">
	var tab_perfil = new Widgets.Tabset('tab_perfil', null);
              </script>
              <br />
              </p>
            
</div>
<?php
// End HTML content
?>