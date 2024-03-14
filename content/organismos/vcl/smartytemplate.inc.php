<?php
/**
*  This file is part of the VCL for PHP project
*
*  Copyright (c) 2004-2007 qadram software <support@qadram.com>
*
*  Checkout AUTHORS file for more information on the developers
*
*  This library is free software; you can redistribute it and/or
*  modify it under the terms of the GNU Lesser General Public
*  License as published by the Free Software Foundation; either
*  version 2.1 of the License, or (at your option) any later version.
*
*  This library is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
*  Lesser General Public License for more details.
*
*  You should have received a copy of the GNU Lesser General Public
*  License along with this library; if not, write to the Free Software
*  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
*  USA
*
*/

/**
 * SmartyTemplate
 *
 */
class SmartyTemplate extends PageTemplate
{
        public $_smarty=null;

        function initialize()
        {
                require_once("smarty/libs/Smarty.class.php");

                $this->_smarty = new Smarty;

                $this->_smarty->template_dir = '';
                $this->_smarty->compile_dir = '/tmp';
        }

        function assignComponents()
        {
                $form=$this->owner;
                $this->_smarty->assign('HeaderCode', $form->dumpChildrenHeaderCode(true).$form->dumpHeaderJavascript(true));
                $this->_smarty->assign('StartForm', $form->readStartForm());
                $this->_smarty->assign('EndForm', $form->readEndForm());                                

                reset($form->controls->items);
                while (list($k,$v)=each($form->controls->items))
                {
                        if ($v->Visible)
                        {
                            $this->_smarty->assign($v->Name, $v->show(true));
                        }
                }
        }

        function dumpTemplate()
        {
                $this->_smarty->display($this->FileName);
        }
}

//Template registration
global $TemplateManager;
$TemplateManager->registerTemplate('SmartyTemplate','smartytemplate.inc.php');

?>
