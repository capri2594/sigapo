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

use_unit("classes.inc.php");

/**
 * Base class for template engines, inherit from it and override initialize(), assignComponents() and dumpTemplate()
 *
 */
class PageTemplate extends Component
{
        protected $_filename='';

        /**
         * Template filename
         *
         * @return string
         */
        function readFileName() { return $this->_filename; }
        function writeFileName($value) { $this->_filename=$value; }

        /**
         * Called to initialize the template system
         *
         */
        function initialize() {}
        
        /**
         * Called to assign component code to template holes
         *
         */
        function assignComponents() {}
        
        /**
         * Called to dump the parsed Template to the output stream
         *
         */
        function dumpTemplate() {}

        function __construct($aowner=null)
        {
                parent::__construct($aowner);
        }

}

/**
 * Template Manager to register all available template engines
 *
 */
class TemplateManager extends Component
{
        protected $_templates=null;

        function __construct($aowner=null)
        {
                parent::__construct($aowner);
                $templates=array();
        }

        /**
         * Registers a new template engine
         *
         * @param string $classname Class for the template engine
         * @param string $unitname  Unit that holds the class
         */
        function registerTemplate($classname, $unitname)
        {
                $this->_templates[$classname]=$unitname;
        }

        /**
         * Return an array of engines
         *
         * @return array
         */
        function getEngines()
        {
                $keys=array_keys($this->_templates);
                $ret=array('');
                $ret=array_merge($ret,$keys);
                return($ret);
        }
}

/**
* Global variable for the Template Manager, checkout TemplateManager::registerTemplate
*/
global $TemplateManager;

$TemplateManager=new TemplateManager(null);

//Add here all the template engines available to forms
use_unit("smartytemplate.inc.php");

?>
