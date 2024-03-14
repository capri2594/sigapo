<?php
// HEAD content
?>
<style type="text/css">
<!--

.Estilo3 {
	color: #003333;
	font-family: Albertus, sans-serif, Modern;
	font-size: 13px;
}
.style2 {font-size: 10px}
-->
</style>

<?php
// Begin HTML content
?>
<div class="panel__content">
              <div class="headerContent">
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td><table width="100%" border="0">
                        <tr>
                          <td><a id="<?php echo $ctrl->link_id() ?>" href="<?php
echo $ctrl->link("Content", "");
?>">SIGAPO</a><span class="style1" style="font-size:11px; color:#FFFF00;">- Correspondencia 2024</span></td>
                          <td width="40" onclick="window.open('content/agenda_mostrar_dep.php','vguia','')" ><a id="2" href="#">
                            <div id="mostrar_usuario2" style="color:#FF9900; width:55px; background-color:#EBF0FE;margin-left:5px;color:#003333;background-image:url(content/imagen/manual2.png);padding-left:25px;background-repeat:no-repeat;height:18px;">GUIA TEL.</div>
                          </a></td>
		<!--MODIFICADO PARA BORRAR LA RADIO EN EL MENU-->
                          <!--<td width="40" onclick="window.open('http://192.168.128.31:8001/listen.pls','','')" ><a id="2" href="#">
                            <div id="mostrar_usuario2" style="color:#FF9900; width:40px; background-color:#EBF0FE;margin-left:5px;color:#003333;background-image:url(content/imagen/radio_internet2.png);padding-left:30px;background-repeat:no-repeat;height:18px;">RADIO&nbsp;</div>
                          </a></td>-->
                          <td width="90" onclick="window.open('content/leer_manual.php','vmanual','')"><a id="2" href="#">
                            <div id="mostrar_usuario2" style="color:#FF9900; width:50px; background-color:#EBF0FE;margin-left:5px;color:#003333;background-image:url(content/imagen/manual2.png);padding-left:25px;background-repeat:no-repeat;height:18px;">MANUAL&nbsp;</div>
                          </a></td>
                          <td width="40"><div align="right"><span class="Estilo3">Usuario:</span></div></td>
                          <td width="60" ><a id="<?php echo $ctrl->link_id() ?>" href="<?php
echo $ctrl->link("Content", "");
?>">
                            <div id="mostrar_usuario" style="color:#FF9900; width:80px; background-color:#EBF0FE;margin-left:5px;color:#003333;background-image:url(content/imagen/my_user.png);padding-left:30px;background-repeat:no-repeat;height:18px;">&nbsp;</div>
                          </a></td>
                          <td width="5">&nbsp;</td>
                          <td width="180"><a id="<?php echo $ctrl->link_id() ?>" href="<?php
echo $ctrl->link("Content", "tooltip_usuariosonline");
?>">
                            <div id="mostrar_usuarios_online" style="color:#FF9900; width:150px; background-color:#EBF0FE;margin-left:5px;color:#003333;background-image:url(content/imagen/whosonline.png);padding-left:30px;background-repeat:no-repeat;height:18px;"></div>
                            </a>                          </td>
                          <td width="50"><div align="right">
                              <script language="JavaScript" type="text/javascript">
							function closeSirc(){
                             resp=confirm('¿Seguro?');
							 if (resp==true) {document.location.href="cerrarSession.php";};
                            }
    </script>
                              <input type="button" value="Cerrar Session" onclick="closeSirc();"/>
                          </div></td>
                        </tr>
                    </table></td>
                  </tr>
                </table>
  </div>
          
</div>
<?php
// End HTML content
?>