<?php

/* 
 * This program is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the 
 * Free Software Foundation; either version 2 of the License, or (at your
 * option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but 
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General
 * Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */
 
 ?>
<style type="text/css">
<!--
.mensaje {
	border: 1px solid #C6D6FF;
	color: #003366;
	height: 30px;
	background-color: #F9FDFF;
	margin: 2px;
	padding: 3px;
	vertical-align: middle;
	word-spacing: normal;
}
.boton {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	height: 30px;
	vertical-align: middle;
}
-->
</style>

 
<div id="subnav">
  <div id="users">
    <h4>Usuarios Conectados</h4>
    <ul id="userlist">
    <?php echo userList(); ?>
    </ul>
  </div>
</div>

<h4 id="windowTitle"><?php echo LACE_SITE_NAME; ?> <?php echo LACE_SITE_DESCRIPTION ? ' - '.LACE_SITE_DESCRIPTION : ''; ?></h4>
<div id="main">
  <div id="laceoutput">
    <?php echo printFileContentsHTML(); ?>
  </div>
</div>

<form name="laceform" id="laceform" action="<?php echo LACE_URL_REL; ?>" method="post">
<table>
<tbody id="lacecontrols">
<tr>
        <td class="name">
                <input type="hidden" name="name" id="name" maxlength="10" size="10" value="
				<?php echo $_SESSION['user'];//echo $name; ?>" />
        </td>
        <td>
                <input name="text" type="text" class="mensaje" id="text" size="50" maxlength="<?php echo LACE_MAX_TEXT_LENGTH; ?>"/>
                <input type="submit" name="say" id="say" value="Dice" class="boton" />
        </td>
</tr>
</tbody>
</table>
</form>
