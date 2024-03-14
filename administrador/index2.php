<?php 
header("Content-Type: text/html; charset=utf-8");
?>
<html>
<head>
<link rel="stylesheet" href="templates/plomo_verdes/archivos/css/template_css.css" type="text/css" />
<link rel="stylesheet" href="templates/plomo_verdes/archivos/css/theme.css" type="text/css" />
<script language="JavaScript" src="includes/js/JSCookMenu_mini.js" type="text/javascript"></script>
<script language="JavaScript" src="includes/js/ThemeOffice/theme.js" type="text/javascript"></script>
<script language="JavaScript" src="includes/js/overlib_mini.js" type="text/javascript"></script>
<script language="JavaScript" src="includes/js/overlib_hideform_mini.js" type="text/javascript"></script>
<script language="JavaScript" src="includes/js/joomla.javascript.js" type="text/javascript"></script></head>
<body>
<table width="100%" class="menubar" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td class="menubackgr" style="padding-left:5px;">
	  <div id="myMenuID"></div>

		<script language="JavaScript" type="text/javascript">
		var myMenu =
		[
					[null,'Inicio','index2.php',null,'Panel de Control'],
			_cmSplit,
						[null,'Sistema',null,null,'Administrar contratos',
				['<img src="includes/js/ThemeOffice/config.png" />','Nuevo Contrato','index2.php?option=com_config&hidemainmenu=1',null,'Configuración'],
				['<img src="includes/js/ThemeOffice/language.png" />','Modificar Contrato',null,null,'Administrar idiomas'],
  					['<img src="includes/js/ThemeOffice/language.png" />','Eliminar Contrato','index2.php?option=com_languages',null,'Administrar idiomas01'],
   				,
				['<img src="includes/js/ThemeOffice/media.png" />','Administrador de Imágenes','index2.php?option=com_media',null,'Administrar imágenes'],
					['<img src="includes/js/ThemeOffice/preview.png" />', 'Vista Previa', null, null, 'Previo',
					['<img src="includes/js/ThemeOffice/preview.png" />','En una Nueva Ventana','http://localhost/judejut2009/index.php','_blank','http://localhost/judejut2009'],
					['<img src="includes/js/ThemeOffice/preview.png" />','En Línea','index2.php?option=com_admin&task=preview',null,'http://localhost/judejut2009'],
					['<img src="includes/js/ThemeOffice/preview.png" />','En Línea con las Posiciones','index2.php?option=com_admin&task=preview2',null,'http://localhost/judejut2009'],
				],
				['<img src="includes/js/ThemeOffice/globe1.png" />', 'Estadísticas', null, null, 'Estadísticas del Sitio',
					['<img src="includes/js/ThemeOffice/search_text.png" />', 'Ranking de ENTRADAS', 'index2.php?option=com_statistics&task=searches', null, 'Ranking de Entradas']
				],
				['<img src="includes/js/ThemeOffice/template.png" />','Administrador de Plantillas',null,null,'Cambiar la plantilla del sitio',
  					['<img src="includes/js/ThemeOffice/template.png" />','Plantillas del Sitio','index2.php?option=com_templates',null,'Cambiar la plantilla del sitio'],
  					_cmSplit,
  					['<img src="includes/js/ThemeOffice/template.png" />','Plantillas del Administrador','index2.php?option=com_templates&client=admin',null,'Cambiar plantillas de la administración'],
  					_cmSplit,
  					['<img src="includes/js/ThemeOffice/template.png" />','Posiciones de los Módulos','index2.php?option=com_templates&task=positions',null,'Plantilla de posiciones']
  				],
				['<img src="includes/js/ThemeOffice/trash.png" />','Administrador de la Papelera','index2.php?option=com_trash',null,'Administrar la papelera'],
				['<img src="includes/js/ThemeOffice/users.png" />','Administrador de Usuarios','index2.php?option=com_users&task=view',null,'Administrar usuarios'],
			],
			_cmSplit,			
			[null,'Contenido',null,null,'Administrar contenido',
				['<img src="includes/js/ThemeOffice/edit.png" />','Contenido por Sección',null,null,'Contenido por sección',
					['<img src="includes/js/ThemeOffice/document.png" />','Noticias', null, null,'Noticias',
						['<img src="includes/js/ThemeOffice/edit.png" />', 'Noticias Artículos', 'index2.php?option=com_content&sectionid=1',null,null],
						['<img src="includes/js/ThemeOffice/backup.png" />', 'Noticias Archivo','index2.php?option=com_content&task=showarchive&sectionid=1',null,null],
						['<img src="includes/js/ThemeOffice/add_section.png" />', 'Noticias Categorías', 'index2.php?option=com_categories&section=1',null, null],
					],

					['<img src="includes/js/ThemeOffice/document.png" />','Última hora', null, null,'Última hora',
						['<img src="includes/js/ThemeOffice/edit.png" />', 'Última hora Artículos', 'index2.php?option=com_content&sectionid=2',null,null],
						['<img src="includes/js/ThemeOffice/backup.png" />', 'Última hora Archivo','index2.php?option=com_content&task=showarchive&sectionid=2',null,null],
						['<img src="includes/js/ThemeOffice/add_section.png" />', 'Última hora Categorías', 'index2.php?option=com_categories&section=2',null, null],
					],

					['<img src="includes/js/ThemeOffice/document.png" />','FAQ', null, null,'FAQ',
						['<img src="includes/js/ThemeOffice/edit.png" />', 'FAQ Artículos', 'index2.php?option=com_content&sectionid=3',null,null],
						['<img src="includes/js/ThemeOffice/backup.png" />', 'FAQ Archivo','index2.php?option=com_content&task=showarchive&sectionid=3',null,null],
						['<img src="includes/js/ThemeOffice/add_section.png" />', 'FAQ Categorías', 'index2.php?option=com_categories&section=3',null, null],
					],

					['<img src="includes/js/ThemeOffice/document.png" />','Informacion', null, null,'Informacion',
						['<img src="includes/js/ThemeOffice/edit.png" />', 'Informacion Artículos', 'index2.php?option=com_content&sectionid=4',null,null],
						['<img src="includes/js/ThemeOffice/backup.png" />', 'Informacion Archivo','index2.php?option=com_content&task=showarchive&sectionid=4',null,null],
						['<img src="includes/js/ThemeOffice/add_section.png" />', 'Informacion Categorías', 'index2.php?option=com_categories&section=4',null, null],
					],

					['<img src="includes/js/ThemeOffice/document.png" />','Inscripciones', null, null,'Inscripciones',
						['<img src="includes/js/ThemeOffice/edit.png" />', 'Inscripciones Artículos', 'index2.php?option=com_content&sectionid=5',null,null],
						['<img src="includes/js/ThemeOffice/backup.png" />', 'Inscripciones Archivo','index2.php?option=com_content&task=showarchive&sectionid=5',null,null],
						['<img src="includes/js/ThemeOffice/add_section.png" />', 'Inscripciones Categorías', 'index2.php?option=com_categories&section=5',null, null],
					],

				],
				_cmSplit,
				['<img src="includes/js/ThemeOffice/edit.png" />','Todos los Artículos de Contenido','index2.php?option=com_content&sectionid=0',null,'Administar todos los artículos con contenido'],
  				['<img src="includes/js/ThemeOffice/edit.png" />','Administrador de Contenido Estático','index2.php?option=com_typedcontent',null,'Administar artículos con contenido'],
  				_cmSplit,
  				['<img src="includes/js/ThemeOffice/add_section.png" />','Administrador de Secciones','index2.php?option=com_sections&scope=content',null,'Administrar el contenido de las secciones'],
				['<img src="includes/js/ThemeOffice/add_section.png" />','Administrador de Categorías','index2.php?option=com_categories&section=content',null,'Administrar el contenido de las categorías'],
				_cmSplit,
  				['<img src="includes/js/ThemeOffice/home.png" />','Administrador de la Página de Inicio','index2.php?option=com_frontpage',null,'Administrar los artículos de la página de inicio'],
  				['<img src="includes/js/ThemeOffice/edit.png" />','Administrador del Archivo','index2.php?option=com_content&task=showarchive&sectionid=0',null,'Administrar contenidos archivados'],
  				['<img src="includes/js/ThemeOffice/globe3.png" />', 'Impresiones por Página', 'index2.php?option=com_statistics&task=pageimp', null, 'Impresiones por página'],
			],
			_cmSplit,
			[null,'Componentes',null,null,'Administrar componentes',
				['<img src="includes/js/ThemeOffice/component.png" />','Banners',null,null,'Gestión de banners',
					['<img src="includes/js/ThemeOffice/edit.png" />','Banners','index2.php?option=com_banners',null,'Banners activos'],
					['<img src="includes/js/ThemeOffice/categories.png" />','Clientes','index2.php?option=com_banners&task=listclients',null,'Administrar clientes']
				],
				['<img src="includes/js/ThemeOffice/user.png" />','Contactos',null,null,'Editar detalles de contacto',
					['<img src="includes/js/ThemeOffice/edit.png" />','Gestión de Contactos','index2.php?option=com_contact',null,'Editar detalles de contacto'],
					['<img src="includes/js/ThemeOffice/categories.png" />','Categorías','index2.php?option=categories&section=com_contact_details',null,'Administrar categorías de contactos']
				],
				['<img src="includes/js/ThemeOffice/mass_email.png" />','Correo masivo','index2.php?option=com_massmail&hidemainmenu=1',null,'Enviar correo masivo'
				],
				['<img src="includes/js/ThemeOffice/component.png" />','Encuestas','index2.php?option=com_poll',null,'Administrar encuestas'
				],
				['<img src="includes/js/ThemeOffice/globe2.png" />','Enlaces Web',null,null,'Administrar enlaces web',
					['<img src="includes/js/ThemeOffice/edit.png" />','Enlaces Web','index2.php?option=com_weblinks',null,'Ver enlaces web'],
					['<img src="includes/js/ThemeOffice/categories.png" />','Categorías','index2.php?option=categories&section=com_weblinks',null,'Administrar categorías de enlaces']
				],
				['<img src="includes/js/ThemeOffice/component.png" />','Noticias Externas',null,null,'Administrar noticias externas',
					['<img src="includes/js/ThemeOffice/edit.png" />','Noticias Externas','index2.php?option=com_newsfeeds',null,'Administrar noticias externas'],
					['<img src="includes/js/ThemeOffice/categories.png" />','Categorías','index2.php?option=com_categories&section=com_newsfeeds',null,'Administrar categorías']
				],
				['<img src="includes/js/ThemeOffice/component.png" />','Sindicación','index2.php?option=com_syndicate&hidemainmenu=1',null,'Gestión de Sindicación'
				],
			],
			_cmSplit,
			[null,'Instaladores',null,null,'Lista de instaladores',
				['<img src="includes/js/ThemeOffice/install.png" />','Soporte Remoto','index2.php?option=com_installer&element=template&client=',null,'Instalar Soporte Remoto'],
				_cmSplit,
				['<img src="includes/js/ThemeOffice/install.png" />','SIGAPO correspondencia','index2.php?option=com_installer&element=template&client=admin',null,'Instalar modulo de correspondencia'],
				['<img src="includes/js/ThemeOffice/install.png" />','SIGAPO produccion','index2.php?option=com_installer&element=language',null,'Instalar Sigapo produccion'],
						
			],
			_cmSplit,
  			[null,'Mensajes',null,null,'Gerencia de la mensajería',
  				['<img src="includes/js/ThemeOffice/messaging_inbox.png" />','Buzón de Entrada','index2.php?option=com_messages',null,'Mensajes privados'],
  				['<img src="includes/js/ThemeOffice/messaging_config.png" />','Configuración','index2.php?option=com_messages&task=config&hidemainmenu=1',null,'Configuración']
  			],
			_cmSplit,
	  			[null,'Ayuda',null,null,'Administrador del sistema',
	  				['<img src="includes/js/ThemeOffice/joomla_16x16.png" />', 'Revisar Versión', 'index2.php', null,'Revisar Versión'],
	  				['<img src="includes/js/ThemeOffice/sysinfo.png" />', 'Información del sistema', 'index2.php?option=com_admin&task=sysinfo', null,'Información del sistema'],
						['<img src="includes/js/ThemeOffice/checkin.png" />', 'Validación Global', 'index2.php?option=com_checkin', null,'Validación Global de todos los ítems'],
						[null,'Acerca de SIGAPO correspondencia','index2.php',null,'Acerca del modulo SIGAPO correspondencia']
				],
				_cmSplit,
				
		];
		cmDraw ('myMenuID', myMenu, 'hbr', cmThemeOffice, 'ThemeOffice');
		</script>    </td>
  <td align="right" class="menubackgr">
  <div id="wrapper1">
			<div><a href="index2.php?option=com_messages" style="color: black; text-decoration: none;">0 <img src="img/nomail.png" align="middle" border="0" alt="Mail" /></a></div>
	  <div>0 <img src="img/users.png" align="middle" alt="Usuarios conectados" /></div>		</div>	</td>
  <td align="right" class="menubackgr" style="padding-right:5px;">

		<a href="index2.php?option=logout" style="color: #333333; font-weight: bold">
			Salir</a><strong>: admin</strong>	</td>
  </tr>
</table>
<table width="100%" class="menubar" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td class="menudottedline" width="40%">
		<div class="pathway"><a href="http://localhost/judejut2009/administrator/index2.php"><strong>Judejut_bolivia_2009</strong></a> / com_media</div>	</td>

	<td class="menudottedline" align="right">
				<table cellpadding="0" cellspacing="0" border="0" id="toolbar">
		<tr valign="middle" align="center">
					<td>
				<a class="toolbar" href="javascript:submitbutton('upload')">
					<img src="http://localhost/judejut2009/administrator/images/upload_f2.png"  alt="Subir" name="upload" align="middle" border="0" />					<br />Subir</a>
			</td>
						<td>&nbsp;</td>

						<td>
				<a class="toolbar" href="javascript:submitbutton('newdir')">
					<img src="http://localhost/judejut2009/administrator/images/new_f2.png"  alt="Crear" name="newdir" align="middle" border="0" />					<br />Crear</a>
			</td>
						<td>&nbsp;</td>
					<td>
			<a class="toolbar" href="javascript:submitbutton('cancel');">
				<img src="http://localhost/judejut2009/administrator/images/cancel_f2.png"  alt="Cancelar" name="cancel" align="middle" border="0" />				<br />Cancelar</a>

		</td>
					<td>&nbsp;</td>
				
		<td>
			<a class="toolbar" href="#" onClick="window.open('http://localhost/judejut2009/help/screen.mediamanager.html', 'mambo_help_win', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no');">
				<img src="http://localhost/judejut2009/administrator/images/help_f2.png"  alt="Ayuda" name="help" align="middle" border="0" />				<br />Ayuda</a>
		</td>
				</tr>
		</table>

			</td>
</tr>
</table>
<table width="100%" class="menubar" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td class="menudottedline" width="40%">
		<div class="pathway"><a href="http://192.168.128.31/sirc_11/administrador/index2.php"><strong>admin.sigapo</strong></a> / com_cpanel</div>	</td>

	<td class="menudottedline" align="right">
			</td>
</tr>
</table>
<br />

<div align="center" class="centermain">
	<div class="main" id="contenido">
				<table class="adminheading" border="0">
		<tr>
			<th class="cpanel">

			Panel de Control
			</th>
		</tr>
		</table>
		<table class="adminform">
<tr>
	<td width="55%" valign="top">
	       <div id="cpanel">
                <div style="float:left;">
            <div class="icon">

                <a href="#" onClick="alert('no tiene permisos');">
                    <img src="img/news.png"  alt="Añadir un Nuevo Artículo" align="middle" border="0" />                    <span>Añadir un Nuevo Aviso</span>                </a>            </div>
        </div>
                <div style="float:left;">
            <div class="icon">
                <a href="#" onClick="alert('no tiene permisos');">

                    <img src="img/folder_red.png"  alt="Administrador de Artículos" align="middle" border="0" />                    <span>Administrador de Hojas de Ruta</span>                </a>            </div>
        </div>
                <div style="float:left;">
            <div class="icon">
                <a href="#" onClick="alert('no tiene permisos');">
                    <img src="img/folder_violet.png"  alt="Administrador de Contenido Estático" align="middle" border="0" />                    <span>Administrador de Correspondencia </span>                </a>            </div>
        </div>
                <div style="float:left;">
            <div class="icon">
                <a href="#" onClick="alert('no tiene permisos');">
                    <img src="img/frontpage.png"  alt="Administrador de la Página de Inicio " align="middle" border="0" />                    <span>Administrador de Dependencias</span>                </a>            </div>
        </div>
                <div style="float:left;">
            <div class="icon">
                <a href="#" onClick="alert('no tiene permisos');">
                    <img src="img/archivemanager.png"  alt="Administrador del Archivo" align="middle" border="0" />                    <span>Administrador del Archivo</span>                </a>            </div>
        </div>
                <div style="float:left;">
            <div class="icon">
                <a href="#" onClick="alert('no tiene permisos');">
                    <img src="img/sections.png"  alt="Administrador de Secciones" align="middle" border="0" />                    <span>Administrador Listas de Acceso</span>                </a>            </div>
        </div>

                <div style="float:left;">
            <div class="icon">
                <a href="#" onClick="alert('no tiene permisos');">
                    <img src="img/categories.png"  alt="Administrador de Categorías" align="middle" border="0" />                    <span>Administrador de Unidades</span>                </a>            </div>
        </div>
                <div style="float:left;">

            <div class="icon">
                <a href="#" onClick="alert('no tiene permisos');">
                    <img src="img/mediamanager.png"  alt="Administrador de Imágenes" align="middle" border="0" />                    <span>Administrador de Imágenes</span>                </a>            </div>
        </div>
                <div style="float:left;">
            <div class="icon">

                <a href="#" onClick="alert('no tiene permisos');">
                    <img src="img/trash.png"  alt="Administrador de la Papelera" align="middle" border="0" />                    <span>Administrador de la Papelera</span>                </a>            </div>
        </div>
                <div style="float:left;">
            <div class="icon">
                <a href="#" onClick="alert('no tiene permisos');">

                    <img src="img/menu.png"  alt="Administrador de Menús" align="middle" border="0" />                    <span>Administrador de Menús</span>                </a>            </div>
        </div>
                <div style="float:left;">
            <div class="icon">
                <a href="#" onClick="alert('no tiene permisos');">
                    <img src="img/langmanager.png"  alt="Administrador de Idiomas" align="middle" border="0" />                    <span>Administrador de Plantillas</span>                </a>            </div>
        </div>
                <div style="float:left;">
            <div class="icon">
                <a href="#" onClick="alert('no tiene permisos');">
                    <img src="img/user.png"  alt="Administrador de Usuarios" align="middle" border="0" />                    <span>Administrador de Usuarios</span>                </a>            </div>
        </div>
                <div style="float:left;">
            <div class="icon">
                <a href="#" onClick="alert('no tiene permisos');">
                    <img src="img/config.png"  alt="Configuración Global" align="middle" border="0" />                    <span>Configuración Global</span>                </a>            </div>
        </div>
                <div style="float:left;">
            <div class="icon">
                <a href="#" onClick="alert('no tiene permisos');">
                    <img src="img/install.png"  alt="Instalar Componentes" align="middle" border="0" />                    <span> Instalar SIGAPO Correspondencia</span>                </a>            </div>
        </div>

                <div style="float:left;">
            <div class="icon">
                <a href="#" onClick="alert('no tiene permisos');">
                    <img src="img/install.png"  alt="Instalar Módulos" align="middle" border="0" />                    <span>Instalar Soporte Remoto</span>                </a>            </div>
        </div>
                <div style="float:left;">

            <div class="icon">
                <a href="#" onClick="alert('no tiene permisos');">
                    <img src="img/install.png"  alt="Instalar Mambots" align="middle" border="0" />                    <span>Instalar SIGAPO Prod</span>                </a>            </div>
        </div>
        		<div style="clear: both; margin: 3px; margin-top: 10px; padding: 5px 15px; display: block; float: left; border: 1px solid #cc0000; background: #ffffcc; text-align: left; width: 88%;">
			<p style="color: #CC0000;">Acceso restringido:			</p>			
<ul style="margin: 0px; padding: 0px; padding-left: 15px; list-style: none;" >
				<li style="min-height: 25px; padding-bottom: 5px; padding-left: 25px; color: red; font-weight: bold; background-image: url(includes/js/ThemeOffice/warning.png); background-repeat: no-repeat; background-position: 0px 2px;" >
				Solo personal con criterio.</li>
                                    <li > 
							          <span style="font-weight: normal; font-style: italic; color: #666;"><strong>Contacto</strong>: joseluis.aranibar@gmail.com</span></li>
</ul>
			<p style="color: #666;">

				Por favor en caso de problemas con el sistema llamar al Cel:72489916</p>
		</div>
	      </div>
   <div style="clear:both;"> </div>     	</td>
	<td width="45%" valign="top">

		<div style="width: 100%;">
			<form action="index2.php" method="post" name="adminForm">
			<link id="luna-tab-style-sheet" type="text/css" rel="stylesheet" href="includes/js/tabs/tabpane.css" /><script type="text/javascript" src="includes/js/tabs/tabpane_mini.js"></script><div class="tab-page" id="modules-cpanel"><script type="text/javascript">
	var tabPane1 = new WebFXTabPane( document.getElementById( "modules-cpanel" ), 1 )
</script>
<div class="tab-page" id="module33"><h2 class="tab">Registro</h2><script type="text/javascript">
  tabPane1.addTabPage( document.getElementById( "module33" ) );</script><table class="adminlist">
<tr>
	<th colspan="4">
	Usuarios conectados:	</th>
</tr>
	<tr>
		<td width="5%">
		1		</td>
		<td>
		<a href="index2.php?option=com_users&task=editA&hidemainmenu=1&id=62" title="Editar Usuario">admin</a>		</td>
		<td>
		Super Administrator		</td>

					<td>
			<a href="index2.php?option=com_users&task=flogout&id=62">
			<img src="images/publish_x.png" width="12" height="12" border="0" alt="Salir" Title="Forzar la salida del usuario" />			</a>			</td>
				</tr>
	</table>
<table class="adminlist"><tr><th colspan="3">
<span class="pagenav"><< Inicio</span>

<span class="pagenav">< Previo</span>
<span class="pagenav"> 1 </span>
<span class="pagenav">Siguiente ></span>
<span class="pagenav">Fin >></span></th></tr><tr><td nowrap="true" width="48%" align="right">Ver #</td><td>
<select name="limit" class="inputbox" size="1" onChange="document.adminForm.submit();">
	<option value="5">5</option>
	<option value="10">10</option>

	<option value="15">15</option>
	<option value="20">20</option>
	<option value="25">25</option>
	<option value="30" selected="selected">30</option>
	<option value="50">50</option>
</select>

<input type="hidden" name="limitstart" value="0" /></td><td nowrap="true" width="48%" align="left">
Resultados 1 - 1 de 1</td></tr></table><input type="hidden" name="option" value="" />
</div><div class="tab-page" id="module19"><h2 class="tab">Componentes</h2><script type="text/javascript">
  tabPane1.addTabPage( document.getElementById( "module19" ) );</script><table class="adminlist">
<tr>
	<th class="title">
	   Componentes instalados:	</th>
</tr>
<tr>
	<td>
								<table width="50%" class="adminlist" border="1" style="text-align: left">

														<tr>
									<td>
										<strong>
										Banners										</strong>
										<br/>									</td>
								</tr>
																	<tr>

										<td>
											<ul style="padding: 0px 0px 0px 20px; margin: 0px;" onMouseOver="return overlib( '<table><tr><td>Archivos:</td><td>9</td></tr><tr><td>Directorios:</td><td>2</td></tr></table><br/> *Clic para abrir*', CAPTION, 'stories', BELOW, RIGHT, WIDTH, 150 );" onMouseOut="return nd();">
																									<li>
														<a href="file:///C|/xampp/htdocs/judejut2009/index2.php?option=com_banners">Banners</a><br/>													</li>
																		   						</ul>										</td>
									</tr>
																		<tr>

										<td>
											<ul style="padding: 0px 0px 0px 20px; margin: 0px;" onMouseOver="generatePopUp( '<table><tr><td>Archivos:</td><td>9</td></tr><tr><td>Directorios:</td><td>2</td></tr></table><br/> *Clic para abrir*');" onMouseOut="return nd();">
																									<li>
														<a href="file:///C|/xampp/htdocs/judejut2009/index2.php?option=com_banners&task=listclients">Clientes</a><br/>													</li>
																		   						</ul>										</td>
									</tr>
															</table>											
												<table width="50%" class="adminlist" border="1" style="text-align: left">

														<tr>
									<td>
										<strong>
										Contactos										</strong>
										<br/>									</td>
								</tr>
																	<tr>

										<td>
											<ul style="padding: 0px 0px 0px 20px; margin: 0px;">
																									<li>
														<a href="file:///C|/xampp/htdocs/judejut2009/index2.php?option=com_contact">Gestión de Contactos</a><br/>													</li>
																		   						</ul>										</td>
									</tr>
																		<tr>

										<td>
											<ul style="padding: 0px 0px 0px 20px; margin: 0px;">
																									<li>
														<a href="file:///C|/xampp/htdocs/judejut2009/index2.php?option=categories&section=com_contact_details">Categorías</a><br/>													</li>
																		   						</ul>										</td>
									</tr>
															</table>											
												<table width="50%" class="adminlist" border="1" style="text-align: left">

														<tr>
									<td>
										<a href="file:///C|/xampp/htdocs/judejut2009/index2.php?option=com_massmail&hidemainmenu=1"><strong>Correo masivo</strong></a><br/>									</td>
								</tr>
														</table>											
												<table width="50%" class="adminlist" border="1" style="text-align: left">
														<tr>
									<td>

										<a href="file:///C|/xampp/htdocs/judejut2009/index2.php?option=com_poll"><strong>Encuestas</strong></a><br/>									</td>
								</tr>
														</table>											
												<table width="50%" class="adminlist" border="1" style="text-align: left">
														<tr>
									<td>
										<strong>
										Enlaces Web										</strong>

										<br/>									</td>
								</tr>
																	<tr>
										<td>
											<ul style="padding: 0px 0px 0px 20px; margin: 0px;">
																									<li>
														<a href="file:///C|/xampp/htdocs/judejut2009/index2.php?option=com_weblinks">Enlaces Web</a><br/>													</li>
																		   						</ul>										</td>
									</tr>
																		<tr>
										<td>
											<ul style="padding: 0px 0px 0px 20px; margin: 0px;">
																									<li>
														<a href="file:///C|/xampp/htdocs/judejut2009/index2.php?option=categories&section=com_weblinks">Categorías</a><br/>													</li>
																		   						</ul>										</td>
									</tr>
															</table>											
												<table width="50%" class="adminlist" border="1" style="text-align: left">
														<tr>
									<td>
										<strong>
										Noticias Externas										</strong>

										<br/>									</td>
								</tr>
																	<tr>
										<td>
											<ul style="padding: 0px 0px 0px 20px; margin: 0px;">
																									<li>
														<a href="file:///C|/xampp/htdocs/judejut2009/index2.php?option=com_newsfeeds">Noticias Externas</a><br/>													</li>
																		   						</ul>										</td>
									</tr>
																		<tr>
										<td>
											<ul style="padding: 0px 0px 0px 20px; margin: 0px;">
																									<li>
														<a href="file:///C|/xampp/htdocs/judejut2009/index2.php?option=com_categories&section=com_newsfeeds">Categorías</a><br/>													</li>
																		   						</ul>										</td>
									</tr>
															</table>											
												<table width="50%" class="adminlist" border="1" style="text-align: left">
														<tr>
									<td>
										<a href="file:///C|/xampp/htdocs/judejut2009/index2.php?option=com_syndicate&hidemainmenu=1"><strong>Sindicación</strong></a><br/>									</td>
								</tr>
														</table>							</td>
</tr>
<tr>
	<th>	</th>
</tr>
</table></div>
<div class="tab-page" id="module20"><h2 class="tab">Popular</h2><script type="text/javascript">
  tabPane1.addTabPage( document.getElementById( "module20" ) );</script>
<table class="adminlist">
<tr>

	<th class="title">
		Lo mas leído:	</th>
	<th class="title">
		Creado	</th>
	<th class="title">
		Hits	</th>
</tr>
	<tr>

		<td>
			<a href="file:///C|/xampp/htdocs/judejut2009/index2.php?option=com_typedcontent&task=edit&hidemainmenu=1&id=5">
				Judejut 2009 en BOLIVIA</a>		</td>
		<td>
			2004-08-19 20:11:07		</td>
		<td>
			25		</td>
	</tr>
		<tr>
		<td>
			<a href="file:///C|/xampp/htdocs/judejut2009/index2.php?option=com_content&task=edit&hidemainmenu=1&id=1">
				Bienvenido</a>		</td>
		<td>
			2005-06-06 02:00:00		</td>

		<td>
			18		</td>
	</tr>
		<tr>
		<td>
			<a href="file:///C|/xampp/htdocs/judejut2009/index2.php?option=com_content&task=edit&hidemainmenu=1&id=11">
				Que disciplinas se compiten?</a>		</td>

		<td>
			2004-05-12 11:54:06		</td>
		<td>
			14		</td>
	</tr>
		<tr>
		<td>
			<a href="file:///C|/xampp/htdocs/judejut2009/index2.php?option=com_content&task=edit&hidemainmenu=1&id=3">

				Reunion el 12 de JUNIO</a>		</td>
		<td>
			2004-08-09 08:30:34		</td>
		<td>
			10		</td>
	</tr>

		<tr>
		<td>
			<a href="file:///C|/xampp/htdocs/judejut2009/index2.php?option=com_content&task=edit&hidemainmenu=1&id=10">
				Que es JUDEJUT</a>		</td>
		<td>
			2004-05-12 11:54:06		</td>
		<td>

			9		</td>
	</tr>
		<tr>
		<td>
			<a href="file:///C|/xampp/htdocs/judejut2009/index2.php?option=com_content&task=edit&hidemainmenu=1&id=2">
				Inscripciones JUDEJUT 2009</a>		</td>
		<td>

			2004-08-09 08:30:34		</td>
		<td>
			8		</td>
	</tr>
		<tr>
		<td>
			<a href="file:///C|/xampp/htdocs/judejut2009/index2.php?option=com_content&task=edit&hidemainmenu=1&id=4">
				Oruro espera el evento</a>		</td>
		<td>
			2004-08-09 08:30:34		</td>
		<td>
			6		</td>
	</tr>
		<tr>
		<td>

			<a href="file:///C|/xampp/htdocs/judejut2009/index2.php?option=com_content&task=edit&hidemainmenu=1&id=9">
				Artículo de ejemplo de noticias 4</a>		</td>
		<td>
			2004-07-07 11:54:06		</td>
		<td>
			6		</td>
	</tr>
		<tr>
		<td>
			<a href="file:///C|/xampp/htdocs/judejut2009/index2.php?option=com_content&task=edit&hidemainmenu=1&id=6">
				Artículo de ejemplo de noticias 1</a>		</td>
		<td>
			2004-07-07 11:54:06		</td>

		<td>
			4		</td>
	</tr>
		<tr>
		<td>
			<a href="file:///C|/xampp/htdocs/judejut2009/index2.php?option=com_content&task=edit&hidemainmenu=1&id=7">
				Artículo de ejemplo de noticias 2</a>		</td>

		<td>
			2004-07-07 11:54:06		</td>
		<td>
			2		</td>
	</tr>
	<tr>
	<th colspan="3">	</th>
</tr>
</table></div><div class="tab-page" id="module21"><h2 class="tab">Últimos artículos</h2><script type="text/javascript">
  tabPane1.addTabPage( document.getElementById( "module21" ) );</script>
<table class="adminlist">
<tr>
	<th colspan="3">
	Últimos artículos:	</th>
</tr>
	<tr>
		<td>
		<a href="file:///C|/xampp/htdocs/judejut2009/index2.php?option=com_content&task=edit&hidemainmenu=1&id=12">

		Registro de Participantes		</a>		</td>
		<td>
		2008-05-27 15:25:39		</td>
		<td>
		<a href="file:///C|/xampp/htdocs/judejut2009/index2.php?option=com_users&task=editA&hidemainmenu=1&id=62" title="Editar Usuario">Administrator</a>		</td>
	</tr>

		<tr>
		<td>
		<a href="file:///C|/xampp/htdocs/judejut2009/index2.php?option=com_content&task=edit&hidemainmenu=1&id=1">
		Bienvenido		</a>		</td>
		<td>
		2005-06-06 02:00:00		</td>
		<td>

		Web Master		</td>
	</tr>
		<tr>
		<td>
		<a href="file:///C|/xampp/htdocs/judejut2009/index2.php?option=com_typedcontent&task=edit&hidemainmenu=1&id=5">
		Judejut 2009 en BOLIVIA		</a>		</td>
		<td>

		2004-08-19 20:11:07		</td>
		<td>
		<a href="file:///C|/xampp/htdocs/judejut2009/index2.php?option=com_users&task=editA&hidemainmenu=1&id=62" title="Editar Usuario">Administrator</a>		</td>
	</tr>
		<tr>
		<td>
		<a href="file:///C|/xampp/htdocs/judejut2009/index2.php?option=com_content&task=edit&hidemainmenu=1&id=3">

		Reunion el 12 de JUNIO		</a>		</td>
		<td>
		2004-08-09 08:30:34		</td>
		<td>
		<a href="file:///C|/xampp/htdocs/judejut2009/index2.php?option=com_users&task=editA&hidemainmenu=1&id=62" title="Editar Usuario">Administrator</a>		</td>
	</tr>

		<tr>
		<td>
		<a href="file:///C|/xampp/htdocs/judejut2009/index2.php?option=com_content&task=edit&hidemainmenu=1&id=4">
		Oruro espera el evento		</a>		</td>
		<td>
		2004-08-09 08:30:34		</td>
		<td>

		<a href="file:///C|/xampp/htdocs/judejut2009/index2.php?option=com_users&task=editA&hidemainmenu=1&id=62" title="Editar Usuario">Administrator</a>		</td>
	</tr>
		<tr>
		<td>
		<a href="#">
		Inscripciones JUDEJUT 2009		</a>		</td>

		<td>
		2004-08-09 08:30:34		</td>
		<td>
		<a href="file:///C|/xampp/htdocs/judejut2009/index2.php?option=com_users&task=editA&hidemainmenu=1&id=62" title="Editar Usuario">Administrator</a>		</td>
	</tr>
		<tr>
		<td>

		<a href="file:///C|/xampp/htdocs/judejut2009/index2.php?option=com_content&task=edit&hidemainmenu=1&id=9">
		Artículo de ejemplo de noticias 4		</a>		</td>
		<td>
		2004-07-07 11:54:06		</td>
		<td>
		<a href="file:///C|/xampp/htdocs/judejut2009/index2.php?option=com_users&task=editA&hidemainmenu=1&id=62" title="Editar Usuario">Administrator</a>		</td>
	</tr>
		<tr>
		<td>
		<a href="file:///C|/xampp/htdocs/judejut2009/index2.php?option=com_content&task=edit&hidemainmenu=1&id=7">
		Artículo de ejemplo de noticias 2		</a>		</td>
		<td>
		2004-07-07 11:54:06		</td>

		<td>
		<a href="file:///C|/xampp/htdocs/judejut2009/index2.php?option=com_users&task=editA&hidemainmenu=1&id=62" title="Editar Usuario">Administrator</a>		</td>
	</tr>
		<tr>
		<td>
		<a href="file:///C|/xampp/htdocs/judejut2009/index2.php?option=com_content&task=edit&hidemainmenu=1&id=6">
		Artículo de ejemplo de noticias 1		</a>		</td>
		<td>
		2004-07-07 11:54:06		</td>
		<td>
		<a href="file:///C|/xampp/htdocs/judejut2009/index2.php?option=com_users&task=editA&hidemainmenu=1&id=62" title="Editar Usuario">Administrator</a>		</td>
	</tr>
		<tr>

		<td>
		<a href="#">
		Que es JUDEJUT		</a>		</td>
		<td>
		2004-05-12 11:54:06		</td>
		<td>
		<a href="#" title="Editar Usuario">Administrator</a>		</td>
	</tr>
	<tr>
	<th colspan="3">	</th>
</tr>
</table></div><div class="tab-page" id="module22"><h2 class="tab">Menú estadísticas</h2><script type="text/javascript">
  tabPane1.addTabPage( document.getElementById( "module22" ) );</script><table class="adminlist">
	<tr>
		<th class="title" width="80%">
			Menú		</th>

		<th class="title">
			# Enlaces		</th>
	</tr>
	<tr>
		<td>
			<a href="#">
				mainmenu</a>		</td>

		<td>
			9		</td>
	</tr>
	<tr>
		<td>
			<a href="#">
				othermenu</a>		</td>

		<td>
			2		</td>
	</tr>
	<tr>
		<td>
			<a href="#">
				topmenu</a>		</td>

		<td>
			4		</td>
	</tr>
	<tr>
		<td>
			<a href="#">
				usermenu</a>		</td>

		<td>
			5		</td>
	</tr>
<tr>
	<th colspan="2">	</th>
</tr>
</table></div></div>			</form>
		</div>	</td>
</tr>
</table>	
  </div>
</div>

<div align="center" class="footer">
	<table width="99%" border="0">
	<tr>
		<td align="center">
			<div align="center">SIGAPO es Software Desarrollado	en	la	PREFECTURA DE ORURO</div>

		  <div align="center" class="smallgrey">Versi&oacute;n actual: 
			  spac 0.0.1 Prueba [Beta] 05 Septiembre 2008 16:00 UTC				<br/>
		  </div>			
						
	  </td>
	</tr>
	</table>
</div>

</body>
 </html>