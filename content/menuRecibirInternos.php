<?php
// HEAD content
?>
<link href="includes/jaxon/widgets/dialog/css/dialog.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="includes/jaxon/widgets/dialog/js/dialog.js"></script>
<link href="includes/jaxon/widgets/tabset/css/tabset.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="includes/jaxon/widgets/tabset/js/tabset.js"></script>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
.style3 {color: #FFFFFF; font-weight: bold; }
-->
</style>
<?php
// Begin HTML content
?>
<div class="panel__content">
              <div id="tabsetRECIBIRiternos" class="tabset htmlrendering" style="width:708px;height:354px; background-color:#535F97;">
                <ul class="tabset_tabs">
                  <li id="tabsetRECIBIRiternostab0-tab" class="tab selected"><a href="#" style="width:130px; ">Correspondencia</a></li>
                  <li id="tabsetRECIBIRiternostab1-tab" class="tab"><a href="#" style="width:130px;">Hoja de Ruta</a></li>
                </ul>
                <div id="tabsetRECIBIRiternostab0-body" class="tabBody body_active">
                  <div class="tabContent"></div>
                  <form action="content/RecibirInternos1.php" method="post" name="formCITE" target="_self" id="formCITE">
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    <table width="320" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td>&nbsp;</td>
                        <td height="30" valign="middle" bgcolor="#535F97"><div align="left"><span class="style3">&nbsp; Ingrese el numero de CITE del documento&nbsp;:</span></div></td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td><div align="center">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="15%">&nbsp;</td>
                                <td width="79%">&nbsp;</td>
                                <td width="6%">&nbsp;</td>
                              </tr>
                              <tr>
                                <td valign="middle"><div align="right">CITE&nbsp;:&nbsp; </div></td>
                                <td><input name="cite" type="text" id="cite" size="35" /></td>
                                <td><a href="content/tooltip_recibir.php" onclick="new Widgets.Dialog('Ingrese el cod. CITE de la correspondencia', 'content/tooltip_recibir.php', { click_outside: true, width: 300, height: 200 }); return false;">ayuda</a></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td><div align="right">
                                    <input type="submit" name="Submit" value="Verificar" />
                                </div></td>
                                <td valign="bottom">&nbsp;</td>
                              </tr>
                            </table>
                        </div></td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td><div align="right"></div></td>
                        <td>&nbsp;</td>
                      </tr>
                    </table>
                  </form>
                </div>
                <div id="tabsetRECIBIRiternostab1-body" class="tabBody">
                  <div class="tabContent">
                    <form id="form2" name="form2" method="post" action="">
                      <p>&nbsp;</p>
                      <p>&nbsp;</p>
                      <table width="320" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td>&nbsp;</td>
                          <td height="30" valign="middle" bgcolor="#535F97"><div align="left"><span class="style3">&nbsp; Ingrese el cod. de HOJA DE RUTA&nbsp;:</span></div></td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td><div align="center">
                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="15%">&nbsp;</td>
                                  <td width="79%">&nbsp;</td>
                                  <td width="6%">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td valign="middle"><div align="right">COD&nbsp;:&nbsp; </div></td>
                                  <td><input name="textfield2" type="text" size="35" /></td>
                                  <td><a href="content/tooltip_recibir.php" onclick="new Widgets.Dialog('Ingrese el cod. CITE de la correspondencia', 'content/tooltip_recibir.php', { click_outside: true, width: 300, height: 200 }); return false;">ayuda</a></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td><div align="right">
                                      <input type="submit" name="Submit2" value="Verificar" />
                                  </div></td>
                                  <td valign="bottom">&nbsp;</td>
                                </tr>
                              </table>
                          </div></td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td><div align="right"></div></td>
                          <td>&nbsp;</td>
                        </tr>
                      </table>
                    </form>
                  </div>
                </div>
              </div>
            <script type="text/javascript">
	var tabsetRECIBIRiternos = new Widgets.Tabset('tabsetRECIBIRiternos', null);
            </script>
            
</div>
<?php
// End HTML content
?>