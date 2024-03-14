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

use_unit("controls.inc.php");
use_unit("extctrls.inc.php");


/**
 * qooxdoo MainMenu
 *
 * @package Menus
 */
class CustomMainMenu extends QWidget
{
        protected $_items=array();
        protected $_onclick=null;
        protected $_images=null;

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width=300;
                $this->Height=24;
        }

        function init()
        {
                //TODO: Read this from the common POST object
                if (!$this->owner->UseAjax)
                {
                        if ((isset($_POST[$this->Name."_state"])) && ($_POST[$this->Name."_state"]!=''))
                        {
                                $this->callEvent('onclick',array('tag'=>$_POST[$this->Name."_state"]));
                        }
                }
        }

        function dumpHeaderCode()
        {
                parent::dumpHeaderCode();
                //This function is used as a common click processor for all item clicks
                echo '<script type="text/javascript">';
                echo "function $this->Name"."_clickwrapper(e)\n";
                echo "{\n";
                echo " submit=true; \n";
                if (($this->ControlState & csDesigning) != csDesigning)
                {
                        if ($this->JsOnClick!=null)
                        {
                                echo "   submit=".$this->JsOnClick."(e);\n";
                        }
                }
                echo "var tag=e.getTarget().tag;\n";
                echo "if ((tag!=0) && (submit))\n";
                echo "  {\n";
                echo "  var hid=findObj('$this->Name"."_state');\n";
                echo "  if (hid) hid.value=tag;\n";
                if (($this->ControlState & csDesigning) != csDesigning)
                {
                        $form = "document.".$this->owner->Name;
                        echo "  if (($form.onsubmit) && (typeof($form.onsubmit) == 'function')) { $form.onsubmit(); }\n";
                        echo "  $form.submit();\n";
                }
                echo "  }\n";
                echo "}\n";
                echo '</script>';
        }


            function loaded()
            {
                parent::loaded();
                $this->setImages($this->_images);
            }



        /**
         * Dump all menu items
         *
         * @param array $items
         * @param integer $level
         * @param boolean $create
         * @return string
         */
        function dumpMenuItems($items,$level,$create=true)
        {
                if ($create)
                {
                        echo "  var m$level = new qx.ui.menu.Menu;\n";
                        echo "  d.add(m$level);\n";
                }
                reset($items);
                while(list($k,$v)=each($items))
                {
                        $caption=$v['Caption'];
                        $tag=$v['Tag'];
                        if ($tag=='') $tag=0;

                        if ($caption=='-')
                        {
                                echo "var mb$level"."_$k = new qx.ui.menu.Separator();\n";
                        }
                        else
                        {
                                $sub='null';
                                if ((isset($v['Items'])) && (count($v['Items'])))
                                {
                                  $sub="m".($level+1);
                                        echo "  var $sub = new qx.ui.menu.Menu;\n";
                                        echo "  d.add($sub);\n";
                                }

                        $img='null';
                if (($this->ControlState & csDesigning)!==csDesigning)
                {
                        if (isset($v['ImageIndex']))
                        {
                                $img=$v['ImageIndex'];
                                if ($img<>'')
                                {
                                        if ($this->Images!=null)
                                        {
                                                $path=$this->Images->readImage($img);
                                                if ($path===false)
                                                {
                                                        $img='null';
                                                }
                                                else
                                                {
                                                        $img='"'.$path.'"';
                                                }
                                        }
                                }
                                else $img='null';
                        }
                }

                                echo "  var mb$level" . "_$k = new qx.ui.menu.Button(\"$caption\", $img, null, $sub);\n";
                                echo "  mb$level" . "_$k.addEventListener(\"execute\", " . $this->Name . "_clickwrapper);\n";
                                echo "  mb$level" . "_$k.tag=$tag;\n";
                        }

                        echo "  m$level.add(mb$level" . "_$k);\n";

                        if ((isset($v['Items'])) && (count($v['Items'])))
                        {
                                $this->dumpMenuItems($v['Items'],$level+1, false);
                        }
                }
                return('m'.$level);
        }

        /**
         * Dump the top items
         *
         */
        function dumpTopButtons()
        {
                reset($this->_items);
                while(list($k,$v)=each($this->_items))
                {
                        echo "  <!-- Topbutton Start -->\n";
                        $caption=$v['Caption'];
                        $m='null';
                        if (isset($v['Items'])) $m=$this->dumpMenuItems($v['Items'],0);
                        echo "  var mb = new qx.ui.toolbar.MenuButton(\"$caption\",$m);\n";
                        __QLibrary_SetCursor("mb", $this->Cursor);
                        echo "  $this->Name.add(mb);\n";
                        echo "  <!-- Topbutton End -->\n";
                }

        }

        function dumpContents()
        {
                $this->dumpCommonContentsTop();
                echo "        var ".$this->Name."    = new qx.ui.toolbar.ToolBar;\n";
                echo "        $this->Name.setLeft(0);\n";
                echo "        $this->Name.setTop(0);\n";
                echo "        $this->Name.setWidth($this->Width);\n";
                echo "        $this->Name.setHeight(".($this->Height-1).");\n";

                __QLibrary_SetCursor($this->Name, $this->Cursor);

                $this->dumpTopButtons();
                $this->dumpCommonContentsBottom();
        }

        /**
         * Lists the images that can appear beside individual menu items.
         *
         * @return ImageList
         */
        function getImages() { return $this->_images; }
        function setImages($value) { $this->_images=$this->fixupProperty($value); }
        function defaultImages() { return ""; }
        /**
         * Describes the elements of the menu.
         * Use Items to access information about the elements in the menu.
         * Item contain information about Caption, associated image and Tag.
         *
         * @return item collection
         */

        function getItems()             { return $this->_items; }
        function setItems($value)       { $this->_items=$value; }
        /**
         * OnClick event
         * Occurs when the user clicks menu item.
         */
        function readOnClick()          { return $this->_onclick; }
        function writeOnClick($value)   { $this->_onclick=$value; }
        }

class MainMenu extends CustomMainMenu
{
        //Publish some properties
        function getFont() { return $this->readFont(); }
        function setFont($value) { $this->writeFont($value); }

        function getParentFont() { return $this->readParentFont(); }
        function setParentFont($value) { $this->writeParentFont($value); }

        function getAlignment() { return $this->readAlignment(); }
        function setAlignment($value) { $this->writeAlignment($value); }

        function getCaption() { return $this->readCaption(); }
        function setCaption($value) { $this->writeCaption($value); }

        function getColor() { return $this->readColor(); }
        function setColor($value) { $this->writeColor($value); }

        function getVisible() { return $this->readVisible(); }
        function setVisible($value) { $this->writeVisible($value); }

        function getOnClick()           { return $this->readOnClick(); }
        function setOnClick($value)     { $this->writeOnClick($value); }

        function getjsOnClick()         { return $this->readjsOnClick(); }
        function setjsOnClick($value)   { $this->writejsOnClick($value); }
}

/**
* PopupMenu class
*/
class CustomPopupMenu extends Component
{
        protected $_items=array();
        protected $_onclick=null;
        protected $_jsonclick=null;
        protected $_images = null;

        private function dumpMenuItems($name, $items, $level)
        {
                if (isset($elements)) unset($elements);

                reset($items);                     // $this->_items -> $k
                while(list($index, $item) = each($items))
        {
                        $caption=$item['Caption'];

                        $imageindex=$item['ImageIndex'];
                        if (($this->_images != null) && (is_object($this->_images)))
                {
                                $image = $this->_images->readImageByID($imageindex, 1);
                        }
                        else
                        {
                                $image = "null";
                }

                        $tag = $item['Tag'];
                        if ($tag == '') $tag=0;

                        $itemname = $name . "_it" . $level . "_" . $index;

                        if ($caption=='-')
                        {
                                echo "    var $itemname = new qx.ui.menu.Separator();\n";
                        }
                        else
                        {
                                $submenu = "null";
                                $subitems = $item['Items'];
                                // check if has subitems

                                if ((isset($subitems)) && (count($subitems)))
                                {
                                        $submenu = $name . "_sm" . $level . "_" . $index;
                                        $this->dumpMenuItems($submenu, $subitems, ($level + 1));

                                        echo "    var $itemname = new qx.ui.menu.Button(\"$caption\", $image, null, $submenu);\n";
                                }
                                else
                                {
                                        echo "    var " . $itemname . "Cmd = new qx.client.Command();\n"
                                           . "    " . $itemname . "Cmd.addEventListener(\"execute\", function (e) {  SubmitMenuEvent(e, $tag); });\n\n"
                                           . "    var $itemname = new qx.ui.menu.Button(\"$caption\", $image, " . $itemname . "Cmd);\n";
                                }
                        }
                        $elements[] = $itemname;
                }

                if (isset($elements))
                {
                        echo "      ";
                        if ($level != 0) echo "var ";
                        echo "$name = new qx.ui.menu.Menu();\n"
                           . "    $name.add(" . implode(",", $elements) . ");\n"
                           . "    d.add($name);\n\n";
                        unset($elements);
                }
        }

        function loaded()
        {
                parent::loaded();
                $this->writeImages($this->_images);
        }

        function dumpHeaderCode()
        {
                __QLibrary_InitLib();

                parent::dumpHeaderCode();

                if (($this->ControlState & csDesigning)!==csDesigning)
                {
                        echo "<script type=\"text/javascript\">\n"
                           . "<!--\n"
                           . "  var $this->Name;\n"
                           . "\n"
                           . "  function CreateMenu()\n"
                           . "  {\n"
                           . "    if (typeof $this->Name == 'undefined')\n"
                           . "    {\n"
                           . "      var d = qx.ui.core.ClientDocument.getInstance();\n\n"
                           . "\n";

                        $this->dumpMenuItems($this->Name, $this->_items, 0);

                        echo "    }\n"
                           . "  }\n"
                           . "\n"
                           . "  function SubmitMenuEvent(e, tag)\n"
                           . "{\n"
                           . "    submit=true;\n";

                        if (($this->ControlState & csDesigning) != csDesigning)
                        {
                                if ($this->JsOnClick!=null)
                                {
                                        echo "    submit=" . $this->JsOnClick . "(e);\n";
                                }

                                $form = "document." . $this->owner->Name;
                                echo "    if ((tag!=0) && (submit)) {\n"
                                   . "      var hid=findObj('$this->Name"."_state');\n"
                                   . "      if (hid) hid.value=tag;\n"
                                   . "      if (($form.onsubmit) && (typedef($form.onsubmit)) == 'function') { alert('here'); $form.onsubmit(); }\n"
                                   . "      $form.submit();\n"
                           . "}\n";
                        }
                        echo "  }\n\n";

                        echo "  function Show$this->Name(event, type)\n"
                           . "  {\n"
                           . "    CreateMenu();\n"
                           . "    if (type == 0) {\n"
                           . "      var tempX = 0\n"
                           . "      var tempY = 0\n"
                           . "      if(event.pageX || event.pageY){"
                           . "        tempX = event.pageX\n"
                           . "        tempY = event.pageY\n"
                           . "      } else {\n"
                           . "        tempX = event.clientX + document.body.scrollLeft - document.body.clientLeft\n"
                           . "        tempY = event.clientY + document.body.scrollTop - document.body.clientTop\n"
                           . "      }\n"
                           . "    } else {\n"
                           . "      tempX = event.getPageX()\n"
                           . "      tempY = event.getPageY()\n"
                           . "    }\n"
                           . "    if (tempX < 0){tempX = 0}\n"
                           . "    if (tempY < 0){tempY = 0}\n"
                           . "\n"
                           . "    $this->Name.setLeft(tempX);\n"
                           . "    $this->Name.setTop(tempY);\n"
                           . "    $this->Name.show();\n"
                           . "  }\n"
                           . "-->\n"
                           . "</script>\n";
                }
        }

        /**
         * Lists the images that can appear beside individual menu items.
         *
         * @return ImageList
         */
        protected function readImages()         { return $this->_images; }
        protected function writeImages($value)  { $this->_images = $this->fixupProperty($value); }
        function defaultImages()                { return null; }
        /**
         * Describes the elements of the menu.
         * Use Items to access information about the elements in the menu.
         * Item contain information about Caption, associated image and Tag.
         *
         * @return item collection
         */
        protected function readItems()          { return $this->_items; }
        protected function writeItems($value)   { $this->_items=$value; }
        /**
         * OnClick event
         * Occurs when the user clicks menu item.
         */
        protected function readOnClick()        { return $this->_onclick; }
        protected function writeOnClick($value) { $this->_onclick=$value; }
        /**
         * OnJsClick event
         * Occurs when the user clicks menu item.
         */
        protected function readjsOnClick()      { return $this->_jsonclick; }
        protected function writejsOnClick($value) { $this->_jsonclick = $value; }
}

class PopupMenu extends CustomPopupMenu
{
        // publish properties
        function getImages()                    { return $this->readImages(); }
        function setImages($value)              { $this->writeImages($value); }

        function getItems()                     { return $this->readItems(); }
        function setItems($value)               { $this->writeItems($value); }

        // publish events
        function getOnClick()                   { return $this->readOnClick(); }
        function setOnClick($value)             { $this->writeOnClick($value); }

        function getjsOnClick()                 { return $this->readjsOnClick(); }
        function setjsOnClick($value)           { $this->writejsOnClick($value); }
}

?>
