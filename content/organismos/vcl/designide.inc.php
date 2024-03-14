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
use_unit("js/json.php");

/**
 * Specifies to the IDE the title of this package
 *
 * @param string $packageTitle
 */
function setPackageTitle($packageTitle)
{
        echo "packageTitle=$packageTitle\n";
}

/**
 * Specifies to the IDE the path to the icons for the components contained in this package (relative to the VCL path)
 *
 * @param string $iconPath
 */
function setIconPath($iconPath)
{
        echo "iconPath=$iconPath\n";
}

/**
 * Registers components inside the IDE and places into the right palette page, it also allows the IDE to add the right unit to the source
 *
 * @param string $page
 * @param array $components
 * @param string $unit
 */
function registerComponents($page,$components,$unit)
{
   echo "page=$page\n";
   reset($components);
   while (list($k,$v)=each($components))
   {
        echo "$v=$unit\n";
   }
}

function registerAsset($components, $assets)
{
        reset($components);
        while (list($k,$v)=each($components))
        {
                echo "asset=$v\n";
                reset($assets);
                while (list($c,$asset)=each($assets))
                {
                        echo "value=".$asset."\n";
                }
        }
}

/**
 * Registers a component editor to be used by a component when right clicking on it
 *
 * @param string $classname
 * @param string $componenteditorclassname
 * @param string $unitname
 */
function registerComponentEditor($classname,$componenteditorclassname,$unitname)
{
   echo "componentclassname=$classname\n";
   echo "componenteditorname=$componenteditorclassname\n";
   echo "componenteditorunitname=$unitname\n";
}

/**
 * Registers a property editor to edit an specific property
 *
 * @param string $classname It can be an ancestor, property editors are also inherited
 * @param string $property Property Name
 * @param string $propertyclassname Property Editor class name
 * @param string $unitname Unit that holds the property editor class
 */
function registerPropertyEditor($classname,$property,$propertyclassname,$unitname)
{
   echo "classname=$classname\n";
   echo "property=$property\n";
   echo "propertyeditor=$propertyclassname\n";
   echo "propertyeditorunitname=$unitname\n";
}

/**
 * Register values to be shown for a dropdown property
 *
 * @param string $classname
 * @param string $property
 * @param array $values
 */
function registerPropertyValues($classname,$property,$values)
{
   echo "classname=$classname\n";
   echo "property=$property\n";

   reset($values);
   while (list($k,$v)=each($values))
   {
        echo "value=$v\n";
   }
}

/**
 * Registers a boolean property, so the Object Inspector offers a true/false dropdown
 *
 * @param string $classname
 * @param string $property
 */
function registerBooleanProperty($classname,$property)
{
   $values=array('false','true');

   echo "classname=$classname\n";
   echo "property=$property\n";

   reset($values);
   while (list($k,$v)=each($values))
   {
        echo "value=$v\n";
   }
}

/**
 * Registers a password property, so the Object Inspector doesn't show the value
 *
 * @param string $classname
 * @param string $property
 */
function registerPasswordProperty($classname,$property)
{
   echo "classname=$classname\n";
   echo "property=$property\n";
   echo "value=password_protected\n";
}

/**
 * Register a component to be available but not visible
 *
 * @param array $components
 * @param string $unit
 */
function registerNoVisibleComponents($components,$unit)
{
   echo "page=no\n";
   reset($components);
   while (list($k,$v)=each($components))
   {
        echo "$v=$unit\n";
   }
}

/**
 * Base class for property editors
 *
 */
class PropertyEditor extends Object
{
        public $value;

        /**
         * Return specific attributes for the OI
         *
         */
        function getAttributes()
        {
        }

        /**
         * If required, returns a path to become the document root for the webserver to call the property editor
         *
         */
        function getOutputPath()
        {

        }

        /**
         * Executes the property editor
         *
         * @param string $current_value  Current property value
         */
        function Execute($current_value)
        {

        }
}

/**
 * Base class for component editors
 *
 */
class ComponentEditor extends Object
{
        public $component=null;

        /**
         * Return here an array of items to show when right clicking a component
         *
         */
        function getVerbs()
        {

        }

        /**
         *  Depending on the verb, perform any action you want
         *
         * @param integer $verb
         */
        function executeVerb($verb)
        {

        }

}

/*
//OLD CODE - DELETE
class ColorPropertyEditor extends PropertyEditor
{
        function getAttributes()
        {
                $result="sizeable=0\n";
                $result.="width=583\n";
                $result.="height=310\n";
                $result.="caption=Color Property editor - Copyright (c) 2000-02 Michael Bystrom\n";

                return($result);
        }

        function getOutputPath()
        {
                return(dirname(__FILE__).'/resources/colorpropertyeditor/');
        }

        function Execute($current_value)
        {
                $this->value=$current_value;

                if (isset($_POST['selcolor']))
                {
                        echo "newvalue:\n";
                        echo urldecode($_POST['selcolor']);
                }
                else
                {
                        if ($this->value=="") $this->value="#FFFFFF";
                        use_unit("resources/colorpropertyeditor/colorpicker.php");
                }
        }
}
*/

/**
 * Editor for Color properties
 *
 */
class ColorPropertyEditor extends PropertyEditor
{
        function getAttributes()
        {
                $result="sizeable=0\n";
                $result.="width=557\n";
                $result.="height=314\n";
                $result.="caption=Color Property editor\n";

                return($result);
        }

        function getOutputPath()
        {
                return(dirname(__FILE__).'/resources/coloreditor/');
        }

        function Execute($current_value)
        {
                $this->value=$current_value;

                if (isset($_POST['selcolor']))
                {
                        echo "newvalue:\n";
                        echo urldecode($_POST['selcolor']);
                }
                else
                {
                        if ($this->value=="") $this->value="#FFFFFF";
                        use_unit("resources/coloreditor/coloreditor.php");
                }
        }
}

/**
 * Property Editor for StringLists
 *
 */
class StringListPropertyEditor extends PropertyEditor
{
        function getAttributes()
        {
                $result="sizeable=0\n";
                $result.="width=583\n";
                $result.="height=410\n";
                $result.="caption=StringList Editor\n";

                return($result);
        }

        function getOutputPath()
        {
                return(dirname(__FILE__).'/resources/stringlisteditor/');
                return false;
        }

        function Execute($current_value)
        {
                $this->value=$current_value;

                if (isset($_POST['listeditor']))
                {
                        echo "newvalue:\n";
                        if (trim($_POST['action'])=='OK')
                        {
                                $value=$_POST['listeditor'];
                                //Carriage returns must be converted properly
                                $value=str_replace("\r",'',$value);
                                $value=str_replace("\n",'\n',$value);
                                echo $value;
                        }
                        else
                        {
                                echo $this->value;
                        }
                }
                else
                {
                        use_unit("resources/stringlisteditor/stringlisteditor.php");
                }
        }
}

/**
 * Array editor - not finished
 *
 */
class ArrayPropertyEditor extends PropertyEditor
{
        function getAttributes()
        {
                $result="sizeable=0\n";
                $result.="height=320\n";
                $result.="width=513\n";
                $result.="caption=Array Editor\n";

                return($result);
        }

        function getOutputPath()
        {
                return(dirname(__FILE__).'/resources/arrayeditor/');
                return false;
        }

        function Execute($current_value)
        {
                global $ArrayEditor;

                $this->value=$current_value;

                if (isset($_POST['btnOk']))
                {
                        ob_start();
                        use_unit("resources/arrayeditor/arrayeditor.php");
                        ob_end_clean();

                        $items=$ArrayEditor->tvItems->Items;
                        echo "newvalue:\n".serialize($items)."\n";
                }
                elseif (isset($_POST['btnCancel']))
                {
                        echo "newvalue:\n";
                        echo $this->value;
                }
                else
                {
                        use_unit("resources/arrayeditor/arrayeditor.php");
                }
        }
}

/**
 * Items property editor, for menus and treeviews
 *
 */
class ItemsPropertyEditor extends PropertyEditor
{
        function getAttributes()
        {
                $result="sizeable=1\n";
                $result.="height=320\n";
                $result.="width=513\n";
                $result.="caption=Items Editor\n";

                return($result);
        }

        function getOutputPath()
        {
                return(dirname(__FILE__).'/resources/menuitemeditor/');
                return false;
        }

        /**
        * Converts a JS array to a PHP array
        *
        * @param array $input
        * @return string
        */
        function JSArrayToPHPArray($input)
        {
                $output=array();
                $children=array();

                reset($input);
                list($k,$props)=each($input);
                while (list($k,$child)=each($input))
                {
                        $c=$this->JSArrayToPHPArray($child[0]);
                        $children[]=$c[0];
                }

                $caption=$props[0];
                if (isset($props[1])) $tag=$props[1];
                else $tag=0;

                if (count($children)!=0)
                {
                        $output[]=array('Caption'=>$caption,'Tag'=>$tag, 'Items'=>$children);
                }
                else
                {
                        $output[]=array('Caption'=>$caption, 'Tag'=>$tag);
                }

                return($output);
        }


        function Execute($current_value)
        {
                global $MenuItemEditor;

                $this->value=$current_value;

                if (isset($_POST['items']))
                {
                        $json_string=$_POST['items'];
                        $json = new Services_JSON();

                        $array=$json->decode($json_string);
                        $phparray=$this->JSArrayToPHPArray($array[0]);
                        $finalarray=$phparray[0]['Items'];
                        echo "newvalue:\n".serialize($finalarray)."\n";
                }
                else
                {
                        use_unit("resources/menuitemeditor/menuitemeditor.php");
                }
        }
}

/**
 * HTML property editor, for captions and so on
 *
 */
class HTMLPropertyEditor extends PropertyEditor
{
        function getAttributes()
        {
                $result="sizeable=1\n";
                $result.="width=740\n";
                $result.="height=540\n";
                $result.="caption=HTML Property editor (Xinha based)\n";

                return($result);
        }

        function getOutputPath()
        {
                return(dirname(__FILE__).'/resources/xinha/');
        }

        function Execute($current_value)
        {
                $this->value=$current_value;

                if (isset($_POST['myTextArea']))
                {
                        echo "newvalue:\n";
                        echo urldecode($_POST['myTextArea']);
                }
                else
                {
                        use_unit("resources/xinha/htmlpropertyeditor.php");
                }
        }
}

/**
 * Image property editor - not finished
 *
 */

class ImagePropertyEditor extends PropertyEditor
{
        function getAttributes()
        {
//                $result="sizeable=1\n";
//                $result.="width=740\n";
//                $result.="height=540\n";
                $result.="caption=Image Property editor (Xinha based)\n";

                return($result);
        }

        function getOutputPath()
        {
                return(dirname(__FILE__).'/resources/xinha/plugins/ImageManager/');
        }

        function Execute($current_value)
        {
                $this->value=$current_value;
                
                if (isset($_POST['f_url']))
                {
                        echo "newvalue:\n";
                        echo urldecode($_POST['f_url']);
                }
                else
                {
                        use_unit("resources/xinha/plugins/ImageManager/imagepropertyeditor.php");
                }
        }
}

class DatabaseEditor extends ComponentEditor
{
        function getVerbs()
        {
                echo "Create Dictionary\n";
        }

        function executeVerb($verb)
        {
                switch($verb)
                {
                        case 0:
                                $this->component->ControlState=0;
                                $this->component->open();
                                if ($this->component->createDictionaryTable())
                                {
                                        echo "Dictionary created";
                                }
                                else
                                {
                                    echo "Error creating Dictionary. Please check the connection settings and the Dictionary property.";
                                }
                                break;
                }
        }
}

?>
