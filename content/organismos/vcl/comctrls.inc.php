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
use_unit("controls.inc.php");
use_unit("stdctrls.inc.php");
use_unit("extctrls.inc.php");

/**
 * ProgressBar Orientation
 */
define ('pbHorizontal', 'pbHorizontal');
define ('pbVertical', 'pbVertical');

/**
 * PageControl Tab position
 */
define ('tpTop', 'tpTop');
define ('tpBottom', 'tpBottom');

/**
 * EditLabel.LabelPosition
 */
define('lpAbove', 'lpAbove');
define('lpBelow', 'lpBelow');
//define('lpLeft',  'lpLeft');
//define('lpRight', 'lpRight');

/**
 * TreeNode class
 *
 * Class TreeNode
 */
class TreeNode extends Component
{
        protected $_caption="";
        protected $_imageindex=-1;
        protected $_items=array();
        public $_id="";

        function getCaption() { return $this->_caption; }
        function setCaption($value)
        {
                $this->_caption=$value;
                $this->owner->updateNodeProperties($this);
        }

        function getImageIndex() { return $this->_imageindex; }
        function setImageIndex($value) { $this->_imageindex=$value; }
}

/**
 * ListView control
 *
 * @package ComCtrls
 */
class CustomListView extends QWidget
{
        protected $_columns=array();
        protected $_items=array();

        function dumpContents()
        {
                $this->dumpCommonContentsTop();

                $columns = array();
                while (list(, $column) = each($this->_columns))
                {
                        if (array_key_exists('Items', $item)) $title = $item['Title'];
                        else $title = "";

                        $columns[] = "\"$title\"";
                }

                $columns = array("\"M\"", "\"A\"", "\"Subject\"", "\"From\"", "\"Date\"");

                echo "  var columnData = [" . implode(",", $columns) . "];\n";
                echo "  var rowData = [];\n\n";

                echo "  var now = new Date().getTime();\n";
                echo "  var dateRange = 400 * 24 * 60 * 60 * 1000; // 400 days\n";
                echo "  var date = new Date(now + Math.random() * dateRange - dateRange / 2);\n";
                echo "  rowData.push([true, \"\", \"Subject 0\", \"Tester\", date]);\n";
                echo "  var date = new Date(now + Math.random() * dateRange - dateRange / 2);\n";
                echo "  rowData.push([false, \"\", \"Subject 1\", \"Developer\", date]);\n\n";

                echo "  var tableModel = new qx.ui.table.SimpleTableModel();\n";
                echo "  tableModel.setColumns(columnData);\n";
                echo "  var $this->Name = new qx.ui.table.Table(tableModel);\n";

                echo "  $this->Name.getTableColumnModel().setDataCellRenderer(0, new qx.ui.table.BooleanDataCellRenderer());\n";
//                echo "  $this->Name.getTableColumnModel().setDataCellRenderer(1, new qx.ui.table.IconDataCellRenderer());\n";
                echo "  $this->Name.getTableColumnModel().setColumnWidth(0, 20);\n";
                echo "  $this->Name.getTableColumnModel().setColumnWidth(1, 20);\n";

                echo "  tableModel.setData(rowData);\n";

                echo "  $this->Name.setBorder(qx.renderer.border.BorderPresets.getInstance().shadow);\n";
                echo "  $this->Name.setBackgroundColor(\"white\");\n";
                echo "  $this->Name.setLeft(0);\n";
                echo "  $this->Name.setTop(0);\n";
                echo "  $this->Name.setWidth($this->Width);\n";
                echo "  $this->Name.setHeight($this->Height);\n";

                __QLibrary_SetCursor($this->Name, $this->Cursor);

                $this->dumpCommonContentsBottom();
        }

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width=557;
                $this->Height=314;
        }

        /**
         * Describes the properties of the columns in the list view.
         *
         * @return array of column settings (Title, Width, Type)
         */
        protected function readColumns()        { return $this->_columns; }
        protected function writeColumns($value) { $this->_columns=$value; }
        function defaultColumns()               { return null; }
        /**
         * Contains the list of items displayed by the list view.
         *
         * @return array of items
         */
        protected function readItems()          { return $this->_items; }
        protected function writeItems($value)   { $this->_items=$value; }
        function defaultItems()                 { return null; }
}

class ListView extends CustomListView
{
        //Publish common properties
        function getVisible() { return $this->readVisible(); }
        function setVisible($value) { $this->writeVisible($value); }

        // Publish properties
        function getColumns()                   { return $this->readColumns(); }
        function setColumns($value)             { $this->writeColumns($value); }

        function getItems()                     { return $this->readItems(); }
        function setItems($value)               { $this->writeItems($value); }

        //function getColor() { return $this->readColor(); }
        //function setColor($value) { $this->writeColor($value); }

        //function getFont() { return $this->readFont(); }
        //function setFont($value) { $this->writeFont($value); }

        //function getParentFont() { return $this->readParentFont(); }
        //function setParentFont($value) { $this->writeParentFont($value); }
}

/**
 * PageControl component
 *
 * @package ComCtrls
 */
class CustomPageControl extends QWidget
{
        protected $_tabs = array();
        protected $_tabindex = -1;
        protected $_tabposition = tpTop;

        function getActiveLayer()
        {
            $result="";

            if (($this->_tabindex>=0) && ($this->_tabindex<=count($this->_tabs)))
            {
                $result=$this->_tabs[$this->_tabindex];
            }
            else
            {
                if (count($this->_tabs)>=1)
                {
                    $result=$this->_tabs[0];
                }
            }
            return($result);
        }

        function setActiveLayer($value)
        {
            $key = array_search($value, $this->_tabs);
            if ($key===false)
            {
            }
            else
            {
                $this->_tabindex=$key;
            }
        }

        function dumpContents()
        {
                $this->dumpCommonContentsTop();

                if ($this->_tabposition==tpTop) { $position="true"; }
                else                            { $position="false"; };

                echo "  var $this->Name = new qx.ui.pageview.tabview.TabView;\n";
                echo "  $this->Name.setLeft(0);\n";
                echo "  $this->Name.setTop(0);\n";
                echo "  $this->Name.setWidth($this->Width);\n";
                echo "  $this->Name.setHeight($this->Height);\n";
                echo "  $this->Name.setPlaceBarOnTop($position);\n";

                if ($this->_tabs != null)
                {

                        //$tabs = split("[\n]", $this->_tabs);
                        $i = 0;
                        $tablist = "";
                        $pagelist = "";
                        $pageblock = "";
                        $selectedtab= "tab" . $this->Name . "_1";
                        $pages=array();
                        $names=array();
                        while (list(, $name) = each($this->_tabs))
                        {
                                if ($name == "") continue;

                                $i++;
                                $tabname = "tab" . $this->Name . "_" . $i;
                                $pagename = "page" . $this->Name . "_" . $i;

                                echo "  var $tabname = new qx.ui.pageview.tabview.Button(\"$name\");\n";
                                if ((($this->ControlState & csDesigning)!=csDesigning) && ($this->jsOnChange != null))
                                {
                                        echo "  $tabname.addEventListener('click', function(e) { $this->jsOnChange(e); });\n";
                                }
                                $pageblock .= "  var $pagename = new qx.ui.pageview.tabview.Page($tabname);\n";
                                $pages[]=$pagename;
                                $names[]=$name;

                                if ($tablist != "") { $tablist .= ","; };
                                $tablist .= $tabname;

                                if ($pagelist != "") { $pagelist .= ","; };
                                $pagelist .= $pagename;

                                if (($i - 1) == $this->_tabindex) { $selectedtab = $tabname; };
                        }
                        if ($i >= 1)
                        {
                                echo "  $selectedtab.setChecked(true);\n";
                                echo "  $this->Name.getBar().add($tablist);\n";
                                echo $pageblock;

                                echo "  $this->Name.getPane().add($pagelist);\n";

                                reset($pages);
                                while(list($key, $val)=each($pages))
                                {
                                    $this->dumpChildrenControls(-31,-11,$val, $names[$key]);
                                }

                        }
                }

                if (($this->Visible) || (($this->ControlState & csDesigning)==csDesigning))
                      { $visible="true"; }
                else  { $visible="false"; };

                echo "  $this->Name.setVisibility($visible);\n";

                $this->dumpCommonQWidgetJSEvents($this->Name, -1);
                $this->dumpCommonContentsBottom();
        }


        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->ControlStyle="csAcceptsControls=1";

                $this->Width=300;
                $this->Height=400;
        }

        /**
         * Contains the list of text strings that label the tabs of the tab control.
         *
         * @return string list
         */
        protected function readTabs()                   { return $this->_tabs; }
        protected function writeTabs($value)            { $this->_tabs=$value; }
        function defaultTabs()   { return null; }
        /**
         * Identifies the selected tab on a tab control.
         *
         * @return integer
         */
        protected function readTabIndex()               { return $this->_tabindex; }
        protected function writeTabIndex($value)        { $this->_tabindex=$value; }
        function defaultTabIndex()   { return -1;               }
        /**
         * Determines whether tabs appear at the top or bottom.
         *
         * @return enum (tpTop, tpBottom)
         */
        protected function readTabPosition()            { return $this->_tabposition; }
        protected function writeTabPosition($value)     { $this->_tabposition=$value; }
        function defaultTabPosition()   { return tpTop;               }
}

class PageControl extends CustomPageControl
{
        //Publish Standard Properties
        function getEnabled()                   { return $this->readEnabled(); }
        function setEnabled($value)             { $this->writeEnabled($value); }

        function getPopupMenu()                 { return $this->readPopupMenu(); }
        function setPopupMenu($value)           { $this->writePopupMenu($value); }

        function getVisible()           { return $this->readVisible(); }
        function setVisible($value)     { $this->writeVisible($value); }

        // Common events
        function getjsOnActivate()              { return $this->readjsOnActivate(); }
        function setjsOnActivate($value)        { $this->writejsOnActivate($value); }

        function getjsOnDeActivate()            { return $this->readjsOnDeActivate(); }
        function setjsOnDeActivate($value)      { $this->writejsOnDeActivate($value); }

        function getjsOnBlur()                  { return $this->readjsOnBlur(); }
        function setjsOnBlur($value)            { $this->writejsOnBlur($value); }

        function getjsOnChange()                { return $this->readjsOnChange(); }
        function setjsOnChange($value)          { $this->writejsOnChange($value); }

        function getjsOnClick()                 { return $this->readjsOnClick(); }
        function setjsOnClick($value)           { $this->writejsOnClick($value); }

        function getjsOnContextMenu()           { return $this->readjsOnContextMenu(); }
        function setjsOnContextMenu($value)     { $this->writejsOnContextMenu($value); }

        function getjsOnDblClick()              { return $this->readjsOnDblClick(); }
        function setjsOnDblClick($value)        { $this->writejsOnDblClick($value); }

        function getjsOnFocus()                 { return $this->readjsOnFocus(); }
        function setjsOnFocus($value)           { $this->writejsOnFocus($value); }

        function getjsOnKeyDown()               { return $this->readjsOnKeyDown(); }
        function setjsOnKeyDown($value)         { $this->writejsOnKeyDown($value); }

        function getjsOnKeyPress()              { return $this->readjsOnKeyPress(); }
        function setjsOnKeyPress($value)        { $this->writejsOnKeyPress($value); }

        function getjsOnKeyUp()                 { return $this->readjsOnKeyUp(); }
        function setjsOnKeyUp($value)           { $this->writejsOnKeyUp($value); }

        function getjsOnMouseDown()             { return $this->readjsOnMouseDown(); }
        function setjsOnMouseDown($value)       { $this->writejsOnMouseDown($value); }

        function getjsOnMouseUp()               { return $this->readjsOnMouseUp(); }
        function setjsOnMouseUp($value)         { $this->writejsOnMouseUp($value); }

        function getjsOnMouseMove()             { return $this->readjsOnMouseMove(); }
        function setjsOnMouseMove($value)       { $this->writejsOnMouseMove($value); }

        function getjsOnMouseOut()              { return $this->readjsOnMouseOut(); }
        function setjsOnMouseOut($value)        { $this->writejsOnMouseOut($value); }

        function getjsOnMouseOver()             { return $this->readjsOnMouseOver(); }
        function setjsOnMouseOver($value)       { $this->writejsOnMouseOver($value); }

        //Publish Properties
        function getTabs()                      { return $this->readTabs(); }
        function setTabs($value)                { $this->writeTabs($value); }

        function getTabIndex()                  { return $this->readTabIndex(); }
        function setTabIndex($value)            { $this->writeTabIndex($value); }

        function getTabPosition()               { return $this->readTabPosition(); }
        function setTabPosition($value)         { $this->writeTabPosition($value); }
}

/**
 * TreeView control
 *
 */
class CustomTreeView extends QWidget
{
        protected $_jsonchangeselected=null;
        protected $_items=array();
        protected $_images = null;
        protected $_showlines = 1;
        protected $_showroot = 0;

        protected function dumpRow($item, $level)
        {
                if (array_key_exists('Caption', $item)) $caption=$item['Caption'];
                else $caption="";

                $image = "null";
                if (array_key_exists('ImageIndex', $item))
                {
                        $imageindex=$item['ImageIndex'];
                        if (($this->_images != null) && (is_object($this->_images)))
                        {
                                $image = $this->_images->readImageByID($imageindex, 1);
                        }
                }

                if ($image != "null") $image = ", $image, $image";
                else $image = "";

                echo "  trs = qx.ui.treefullcontrol.TreeRowStructure.getInstance().standard(\"$caption\"" . $image . ");\n";
        }

        protected function dumpItem($item, $parent, $level)
        {
                $c='p_'.$level;
                $trsname = $this->dumpRow($item, $level);

                if (array_key_exists('Items', $item)) $items = $item['Items'];
                else $items=array();

                if (count($items) == 0)
                {
                        echo "  var $c = new qx.ui.treefullcontrol.TreeFile(trs);\n";
                }
                else
                {
                        echo "  var $c = new qx.ui.treefullcontrol.TreeFolder(trs);\n";
                }

                if (array_key_exists('Tag', $item)) $tag=$item['Tag'];
                else $tag=0;

                __QLibrary_SetCursor($c, $this->Cursor);

                echo "  $c.tag=$tag;\n";
                echo "  $parent.add($c);\n\n";

                if (count($items) != 0)
                {
                        $i = 0;
                        while (list($k, $child)=each($items))
                        {
                                $this->dumpItem($child, $c, ($level + 1));
                        }
                }
        }

        function dumpContents()
        {
                $this->dumpCommonContentsTop();

                echo "  var trsroot = qx.ui.treefullcontrol.TreeRowStructure.getInstance().standard(\"Items\");\n";
                echo "  var $this->Name = new qx.ui.treefullcontrol.Tree(trsroot);\n\n";

                if ((is_array($this->_items)) && (count($this->_items) != 0))
                {
                        echo "  var trs = null;\n";
                        reset($this->_items);
                        while (list($k, $item)=each($this->_items))
                        {
                                $this->dumpItem($item, $this->Name, 0);
                        }
                }

                echo "  $this->Name.setUseDoubleClick(true);\n";
                if ($this->_showlines == 1) echo "  $this->Name.setUseTreeLines(true);\n";
                else echo "  $this->Name.setUseTreeLines(false);\n";
                if ($this->_showroot == 1) echo "  $this->Name.setHideNode(false);\n";
                else echo "  $this->Name.setHideNode(true);\n";
                echo "  $this->Name.setBorder(qx.renderer.border.BorderPresets.getInstance().inset);\n";
                echo "  $this->Name.setBackgroundColor(\"white\");\n";
                echo "        $this->Name.setLeft(0);\n";
                echo "        $this->Name.setTop(0);\n";
                echo "  $this->Name.setOpen(1);\n";
                echo "        $this->Name.setOverflow(\"scroll\");\n";
                echo "        $this->Name.setWidth($this->Width);\n";
                echo "  $this->Name.setHeight(" . ($this->Height-1) . ");\n\n";

                if (($this->ControlState & csDesigning)!=csDesigning)
                {
                        if (($this->_jsonchangeselected!="") && ($this->_jsonchangeselected!=null))
                        {
                                echo "        $this->Name.getManager().addEventListener(\"changeSelection\", $this->_jsonchangeselected);\n";
                        }
                }
                $this->dumpCommonQWidgetProperties($this->Name, 0);
                $this->dumpCommonQWidgetJSEvents($this->Name, 1);
                $this->dumpCommonContentsBottom();
        }

        function dumpJsEvents()
        {
                parent::dumpJsEvents();

                $this->dumpJSEvent($this->_jsonchangeselected);
        }

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);
                $this->ControlStyle="csSlowRedraw=1";
                $this->Width=300;
                $this->Height=321;
        }

        function loaded()
        {
                parent::loaded();
                $this->setImageList($this->_images);
        }

        /**
         * Lists the images that can appear beside individual menu items.
         *
         * @return ImageList
         */
        protected function readImageList()      { return $this->_images; }
        protected function writeImageList($value) { $this->_images=$this->fixupProperty($value); }
        function defaultImageList()             { return ""; }
        /**
         * List of Items associated with the Tree
         *
         * @return Item array
         */
        protected function readItems()          { return $this->_items; }
        protected function writeItems($value)   { $this->_items=$value; }
        /**
         * Specifies whether to display the lines that link child nodes to their
         * corresponding parent nodes.
         *
         * @return boolean
         */
        protected function readShowLines()      { return $this->_showlines; }
        protected function writeShowLines($value) { $this->_showlines=$value; }
        function defaultShowLines()             { return 1; }
        /**
         * Specifies whether lines connecting top-level nodes are displayed.
         *
         * @return boolean
         */
        protected function readShowRoot()       { return $this->_showroot; }
        protected function writeShowRoot($value){ $this->_showroot=$value; }
        function defaultShowRoot()              { return 0; }

        /**
         * Triggered when Current selected item is changed
         *
         * @return event
         */
        protected function readjsOnChangeSelected()
                                        { return $this->_jsonchangeselected; }
        protected function writejsOnChangeSelected($value)
                                        { $this->_jsonchangeselected=$value; }
}

class TreeView extends CustomTreeView
{
        //Publish common properties

        function getEnabled()                   { return $this->readEnabled(); }
        function setEnabled($value)             { $this->writeEnabled($value); }

        function getPopupMenu()                 { return $this->readPopupMenu(); }
        function setPopupMenu($value)           { $this->writePopupMenu($value); }

        function getVisible() { return $this->readVisible(); }
        function setVisible($value) { $this->writeVisible($value); }

        // Common events
        function getjsOnActivate()              { return $this->readjsOnActivate(); }
        function setjsOnActivate($value)        { $this->writejsOnActivate($value); }

        function getjsOnDeActivate()            { return $this->readjsOnDeActivate(); }
        function setjsOnDeActivate($value)      { $this->writejsOnDeActivate($value); }

        function getjsOnBlur()                  { return $this->readjsOnBlur(); }
        function setjsOnBlur($value)            { $this->writejsOnBlur($value); }

        function getjsOnChange()                { return $this->readjsOnChange(); }
        function setjsOnChange($value)          { $this->writejsOnChange($value); }

        function getjsOnClick()                 { return $this->readjsOnClick(); }
        function setjsOnClick($value)           { $this->writejsOnClick($value); }

        function getjsOnContextMenu()           { return $this->readjsOnContextMenu(); }
        function setjsOnContextMenu($value)     { $this->writejsOnContextMenu($value); }

        function getjsOnDblClick()              { return $this->readjsOnDblClick(); }
        function setjsOnDblClick($value)        { $this->writejsOnDblClick($value); }

        function getjsOnFocus()                 { return $this->readjsOnFocus(); }
        function setjsOnFocus($value)           { $this->writejsOnFocus($value); }

        function getjsOnKeyDown()               { return $this->readjsOnKeyDown(); }
        function setjsOnKeyDown($value)         { $this->writejsOnKeyDown($value); }

        function getjsOnKeyPress()              { return $this->readjsOnKeyPress(); }
        function setjsOnKeyPress($value)        { $this->writejsOnKeyPress($value); }

        function getjsOnKeyUp()                 { return $this->readjsOnKeyUp(); }
        function setjsOnKeyUp($value)           { $this->writejsOnKeyUp($value); }

        function getjsOnMouseDown()             { return $this->readjsOnMouseDown(); }
        function setjsOnMouseDown($value)       { $this->writejsOnMouseDown($value); }

        function getjsOnMouseUp()               { return $this->readjsOnMouseUp(); }
        function setjsOnMouseUp($value)         { $this->writejsOnMouseUp($value); }

        function getjsOnMouseMove()             { return $this->readjsOnMouseMove(); }
        function setjsOnMouseMove($value)       { $this->writejsOnMouseMove($value); }

        function getjsOnMouseOut()              { return $this->readjsOnMouseOut(); }
        function setjsOnMouseOut($value)        { $this->writejsOnMouseOut($value); }

        function getjsOnMouseOver()             { return $this->readjsOnMouseOver(); }
        function setjsOnMouseOver($value)       { $this->writejsOnMouseOver($value); }

        //Publish properties
        function getImageList()                 { return $this->readImageList(); }
        function setImageList($value)           { $this->writeImageList($value); }

        function getItems()                     { return $this->readItems(); }
        function setItems($value)               { $this->writeItems($value); }

        function getShowLines()                 { return $this->readShowLines(); }
        function setShowLines($value)           { $this->writeShowLines($value); }

        function getShowRoot()                  { return $this->readShowRoot(); }
        function setShowRoot($value)            { $this->writeShowRoot($value); }

        // Publish events
        function getjsOnChangeSelected()        { return $this->readjsOnChangeSelected(); }
        function setjsOnChangeSelected($value)  { $this->writejsOnChangeSelected($value); }
}

/**
 * TextField control
 *
 */
class CustomTextField extends QWidget
{
        protected $_borderstyle = bsSingle;
        protected $_charcase = ecNormal;
        protected $_datasource = null;
        protected $_datafield = "";
        protected $_ispassword = 0;
        protected $_maxlength = 0;
        protected $_readonly = 0;
        protected $_text = "";

        protected $_onclick = null;

        protected function AdjustText()
        {
                if ($this->_charcase == ecUpperCase)
                { $this->_text = strtoupper($this->_text); }
                else
                if ($this->_charcase == ecUpperCase)
                { $this->_text = strtolower($this->_text); }
        }

        protected function dumpExtraControlCode()
        {
                // Nothing here. See LabeledEdit for more info
        }

        protected function CalculateEditorRect()
        {
                return array(0, 0, $this->Width, $this->Height);
        }

        //Once the component has been loaded
        function unserialize()
        {
                parent::unserialize();
                $this->readProperty('Text', $this->_name);
        }

        function loaded()
        {
                parent::loaded();
                $this->writeDataSource($this->_datasource);
        }

        function init()
        {
                parent::init();

                //TODO: Read this from the common POST object
                if (!$this->owner->UseAjax)
                {
                        if ((isset($_POST[$this->Name."_state"])) && ($_POST[$this->Name."_state"]!=''))
                        {
                                $this->callEvent('onclick',array('tag'=>$_POST[$this->Name."_state"]));
                        }
                }
        }

        function dumpContents()
        {
                $this->dumpCommonContentsTop();

                if (($this->ControlState & csDesigning) != csDesigning)
                {
                        if (($this->_datasource != null) && ($this->_datafield != ""))
                        {
                                if ($this->_datasource->DataSet != null)
                                {
                                        $ds = $this->_datasource->DataSet;
                                        $df = $this->_datafield;
                                        $this->_text = $ds->$df;
                                }
                        }
                }

                if ($this->_borderstyle == bsNone)
                { $border = "none"; }
                else
                { $border = "solid"; }

                $charcase = "";
                if ($this->_charcase == ecLowerCase)
                { $charcase = "lowercase"; }
                else
                if ($this->_charcase == ecUpperCase)
                { $charcase = "uppercase"; }
                if ($this->ReadOnly) { $readonly="true"; }
                else                 { $readonly="false"; }

                // call the OnShow event if assigned so the Text property can be changed
                if ($this->_onshow != null)
                {
                        $this->callEvent('onshow', array());
                }

                $this->dumpExtraControlCode();

                list($left, $top, $width, $height) = $this->CalculateEditorRect();

                if ($this->_ispassword)
                { echo "  var $this->Name = new qx.ui.form.PasswordField();\n"; }
                else
                { echo "  var $this->Name = new qx.ui.form.TextField();\n"; }

                echo "  $this->Name.setLeft($left);\n"
                   . "  $this->Name.setTop($top);\n"
                   . "  $this->Name.setWidth($width);\n"
                   . "  $this->Name.setHeight($height);\n"
                   . "  $this->Name.setMaxLength($this->MaxLength);\n"
                   . "  $this->Name.setValue(\"$this->Text\");\n"
                   . "  $this->Name.setReadOnly($readonly);\n"
                   . "  $this->Name.setBorder(new qx.renderer.border.Border(1, '$border'));\n";
                if ($this->Color != "")
                { echo "  $this->Name.setBackgroundColor(new qx.renderer.color.Color('$this->Color'));\n"; }

                if ($charcase != "")
                { echo "  $this->Name.setStyleProperty('textTransform', '$charcase');\n";  }

                $this->dumpCommonQWidgetProperties($this->Name);
                $this->dumpCommonQWidgetJSEvents($this->Name, 1);
                $this->dumpCommonContentsBottom();
        }

        function dumpJsEvents()
        {
                parent::dumpJsEvents();

                $this->dumpJSEvent($this->_jsonchange);
        }

        /**
        * Determines whether the edit control has a single line border
        * around the client area.
        *
        * @return enum (bsSingle, bsNone)
        */
        protected function readBorderStyle()        { return $this->_borderstyle; }
        protected function writeBorderStyle($value) { $this->_borderstyle=$value; }
        protected function defaultBorderStyle()     { return bsSingle; }
        /**
        * Determines the case of the text within the edit control.
        * Note: When CharCase is set to ecLowerCase or ecUpperCase,
        *       the case of characters is converted as the user types them
        *       into the edit control. Changing the CharCase property to
        *       ecLowerCase or ecUpperCase changes the actual contents
        *       of the text, not just the appearance. Any case information
        *       is lost and can’t be recaptured by changing CharCase to ecNormal.
        *
        * @return enum (ecNormal, ecLowerCase, ecUpperCase)
        */
        protected function readCharCase()           { return $this->_charcase; }
        protected function writeCharCase($value)    { $this->_charcase=$value; $this->AdjustText(); }
        protected function defaultCharCase()        { return ecNormal; }

        protected function readDataField()          { return $this->_datafield; }
        protected function writeDataField($value)   { $this->_datafield = $value; }
        protected function defaultDataField()       { return ""; }
        /**
        * DataSource points to a DataSource component if used.
        *
        * @return pointer to the DataSource
        */
        protected function readDataSource()         { return $this->_datasource; }
        protected function writeDataSource($value)  { $this->_datasource = $this->fixupProperty($value); }
        protected function defaultDataSource()      { return null; }
        /**
        * If IsPassword is true then all characters are displayed with a password
        * character defined by the browser.
        * Note: The text is still in readable text in the HTML page!
        *
        * @return boolean
        */
        protected function readIsPassword()         { return $this->_ispassword; }
        protected function writeIsPassword($value)  { $this->_ispassword = $value; }
        protected function defaultIsPassword()      { return 0; }
        /**
        * Specifies the maximum number of characters the user can enter into
        * the edit control. A value of 0 indicates that there is no
        * application-defined limit on the length.
        *
        * @return integer
        */
        protected function readMaxLength()          { return $this->_maxlength; }
        protected function writeMaxLength($value)   { $this->_maxlength=$value; }
        protected function defaultMaxLength()       { return 0; }
        /**
        * Set the control to read-only mode. That way the user cannot enter
        * or change the text of the edit control.
        *
        * @return boolean
        */
        protected function readReadOnly()           { return $this->_readonly; }
        protected function writeReadOnly($value)    { $this->_readonly=$value; }
        protected function defaultReadOnly()        { return 0; }
        /**
        * Text info associated with control.
        *
        * @return string
        */
        protected function readText()               { return $this->_text; }
        protected function writeText($value)        { $this->_text = $value; }
        protected function defaultText()            { return ""; }
        /**
         * OnClick event
         */
        protected function readOnClick()            { return $this->_onclick; }
        protected function writeOnClick($value)     { $this->_onclick = $value; }
        function defaultOnClick()                   { return null; }

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width=120;
                $this->Height=21;
        }
}

class TextField extends CustomTextField
{

        //Publish common properties

        function getFont()              { return $this->readFont(); }
        function setFont($value)        { $this->writeFont($value); }

        function getColor()             { return $this->readColor(); }
        function setColor($value)       { $this->writeColor($value); }

        function getEnabled()           { return $this->readEnabled(); }
        function setEnabled($value)     { $this->writeEnabled($value); }

        function getParentColor()       { return $this->readParentColor(); }
        function setParentColor($value) { $this->writeParentColor($value); }

        function getParentFont()        { return $this->readParentFont(); }
        function setParentFont($value)  { $this->writeParentFont($value); }

        function getParentShowHint()    { return $this->readParentShowHint(); }
        function setParentShowHint($value) { $this->writeParentShowHint($value); }

        function getPopupMenu()         { return $this->readPopupMenu(); }
        function setPopupMenu($value)   { $this->writePopupMenu($value); }

        function getShowHint()          { return $this->readShowHint(); }
        function setShowHint($value)    { $this->writeShowHint($value); }

        function getVisible()           { return $this->readVisible(); }
        function setVisible($value)     { $this->writeVisible($value); }

        // Common events
        function getjsOnActivate()      { return $this->readjsOnActivate(); }
        function setjsOnActivate($value){ $this->writejsOnActivate($value); }

        function getjsOnDeActivate()    { return $this->readjsOnDeActivate(); }
        function setjsOnDeActivate($value) { $this->writejsOnDeActivate($value); }

        function getjsOnBlur()          { return $this->readjsOnBlur(); }
        function setjsOnBlur($value)    { $this->writejsOnBlur($value); }

        function getjsOnChange()        { return $this->readjsOnChange(); }
        function setjsOnChange($value)  { $this->writejsOnChange($value); }

        function getjsOnClick()         { return $this->readjsOnClick(); }
        function setjsOnClick($value)   { $this->writejsOnClick($value); }

        function getjsOnContextMenu()   { return $this->readjsOnContextMenu(); }
        function setjsOnContextMenu($value) { $this->writejsOnContextMenu($value); }

        function getjsOnDblClick()      { return $this->readjsOnDblClick(); }
        function setjsOnDblClick($value){ $this->writejsOnDblClick($value); }

        function getjsOnFocus()         { return $this->readjsOnFocus(); }
        function setjsOnFocus($value)   { $this->writejsOnFocus($value); }

        function getjsOnKeyDown()       { return $this->readjsOnKeyDown(); }
        function setjsOnKeyDown($value) { $this->writejsOnKeyDown($value); }

        function getjsOnKeyPress()      { return $this->readjsOnKeyPress(); }
        function setjsOnKeyPress($value){ $this->writejsOnKeyPress($value); }

        function getjsOnKeyUp()         { return $this->readjsOnKeyUp(); }
        function setjsOnKeyUp($value)   { $this->writejsOnKeyUp($value); }

        function getjsOnMouseDown()      { return $this->readjsOnMouseDown(); }
        function setjsOnMouseDown($value){ $this->writejsOnMouseDown($value); }

        function getjsOnMouseUp()       { return $this->readjsOnMouseUp(); }
        function setjsOnMouseUp($value) { $this->writejsOnMouseUp($value); }

        function getjsOnMouseMove()     { return $this->readjsOnMouseMove(); }
        function setjsOnMouseMove($value) { $this->writejsOnMouseMove($value); }

        function getjsOnMouseOut()      { return $this->readjsOnMouseOut(); }
        function setjsOnMouseOut($value) { $this->writejsOnMouseOut($value); }

        function getjsOnMouseOver()     { return $this->readjsOnMouseOver(); }
        function setjsOnMouseOver($value) { $this->writejsOnMouseOver($value); }

        //Publish new properties
        function getBorderStyle()       { return $this->readBorderStyle();  }
        function setBorderStyle($value) { $this->writeBorderStyle($value);  }

        function getCharCase()          { return $this->readCharCase(); }
        function setCharCase($value)    { $this->writeCharCase($value); }

        function getDataField()         { return $this->readDataField(); }
        function setDataField($value)   { $this->writeDataField($value); }

        function getDataSource()        { return $this->readDataSource(); }
        function setDataSource($value)  { $this->writeDataSource($value); }

        function getIsPassword()        { return $this->readIsPassword(); }
        function setIsPassword($value)  { $this->writeIsPassword($value); }

        function getMaxLength()         { return $this->readMaxLength(); }
        function setMaxLength($value)   { $this->writeMaxLength($value); }

        function getReadOnly()          { return $this->readReadOnly(); }
        function setReadOnly($value)    { $this->writeReadOnly($value); }

        function getText()              { return $this->readText(); }
        function setText($value)        { $this->writeText($value); }

        // publish events
        //function getOnClick()           { return $this->readOnClick(); }
        //function setOnClick($value)     { $this->writeOnClick($value); }
}

/**
 * Calendar class
 *
 */
class MonthCalendar extends FocusControl
{
        public $_calendar=null;

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                use_unit('jscalendar/calendar.php');

                $this->_calendar = new DHTML_Calendar(VCL_HTTP_PATH."/jscalendar/", "en", 'calendar-win2k-2', false);

                $this->Width=200;
                $this->Height=200;
        }

        function dumpHeaderCode()
        {
                $this->_calendar->load_files();
        }

        function dumpContents()
        {
                echo "<div id=\"".$this->Name."_container\">\n";
                echo $this->_calendar->_make_calendar(
                array(
                'flat'=>$this->Name."_container",
//                'flatCallback'=>'dateChanged',
//                'dateStatusFunc'=>'ourDateStatusFunc',
                'firstDay'       => 1, // show Monday first
                 'showsTime'      => true,
                 'width'      => $this->Width,
                 'height'      => $this->Height,
                 'showOthers'     => true,
                 'ifFormat'       => '%d/%m/%Y %H:%i:%s %P',
                 'timeFormat'     => '12'
                ), $this->Name) . "\n";
                echo "</div>\n";
                echo "<script type=\"text/javascript\">\n";
                echo "  $this->Name.table.width='".($this->Width-3)."px';\n";
                echo "  $this->Name.table.height='".($this->Height-3)."px';\n";
                echo "</script>";
        }

}

/**
 * DateTimePicker control
 *
 */
class DateTimePicker extends FocusControl
{
        public $_calendar=null;

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                date_default_timezone_set($this->TimeZone);

                use_unit('jscalendar/calendar.php');

                $this->_text=strftime('%Y-%m-%d %I:%M', strtotime('now'));
                $this->_calendar = new DHTML_Calendar(VCL_HTTP_PATH."/jscalendar/", "en", 'calendar-win2k-2', false);

                $this->Width=200;
                $this->Height=17;
        }

        private $_timezone="UTC";

        function getTimeZone() { return $this->_timezone; }
        function setTimeZone($value) { $this->_timezone=$value; }
        function defaultTimeZone() { return "UTC"; }

        function dumpHeaderCode()
        {
                $this->_calendar->load_files();
        }

        function dumpContents()
        {
                $style=$this->Font->FontString;

                //TODO: ColorToString and StringToColor
                if ($this->color!="")
                {
                        $style.="background-color: ".$this->color.";";
                }

                $h=$this->Height-1;
                $w=$this->Width;

                $style.="height:".$h."px;width:".($w-15)."px;";

                date_default_timezone_set($this->TimeZone);

                $this->_calendar->make_input_field
                (
                   // calendar options go here; see the documentation and/or calendar-setup.js
                   array('firstDay'       => 1, // show Monday first
                         'showsTime'      => true,
                         'showOthers'     => true,
                         'ifFormat'       => '%Y-%m-%d %I:%M',
                         'timeFormat'     => '24'),
                   // field attributes go here
                   array('style'       => $style,
                         'name'        => $this->Name,
                         'value'       => $this->_text)
                );
        }

        function getFont() { return $this->readFont(); }
        function setFont($value) { $this->writeFont($value); }

        function getParentFont() { return $this->readParentFont(); }
        function setParentFont($value) { $this->writeParentFont($value); }

        function getCaption() { return $this->readCaption(); }
        function setCaption($value) { $this->writeCaption($value); }

        function preinit()
        {
                //If there is something posted
                $submitted = $this->input->{$this->Name};
                if (is_object($submitted))
                {
                        //Get the value and set the text field
                        $this->_text = $submitted->asString();

                        //If there is any valid DataField attached, update it
                        //$this->updateDataField($this->_text);
                }
        }

        protected $_text="";

        function getText() { return $this->_text; }
        function setText($value) { $this->_text=$value; }
        function defaultText() { return ""; }
}

/**
 * ProgressBar control
 *
 * ProgressBar displays a simple progress bar.
 *
 * @package ComCtrls
 */
class CustomProgressBar extends DWidget
{
        protected $_orientation=pbHorizontal;
        protected $_position=50;
        protected $_min=0;
        protected $_max=100;
        protected $_step=10;

        function dumpHeaderCode()
        {
                parent::dumpHeaderCode();

                if (($this->ControlState & csDesigning)==csDesigning)
                {
                        $left=0;
                        $top=0;
                }
                else
                {
                        $left=$this->Left;
                        $top=$this->Top;

                        if ($this->owner!=null)
                        {
                                $layout=$this->owner->Layout;

                                if ($layout->Type==ABS_XY_LAYOUT)
                                {
                                        $left=0;
                                        $top=0;
                                }

                        }
                }

                if ($this->_orientation == pbHorizontal) { $orient="horz"; }
                else                                   { $orient="vert"; };

                echo "<script type=\"text/javascript\">\n"
                   . "  var " . $this->Name . "=new ProgressBar('$orient',$left,$top,$this->Width,$this->Height,$this->Position);\n"
                   . "  " . $this->Name . ".setRange($this->Min,$this->Max);\n"
                   . "  " . $this->Name . ".setValue(" . $this->Position . ");\n"
                   . "  dynapi.document.addChild(" . $this->Name . ");\n"
                   . "</script>\n";
                /*
                echo "        ".$this->Name.".onscroll=function(e){\n";
                echo "                status=".$this->Name.".getValue()\n";
                echo "        }\n";
                echo "\n";
                */
        }

        /**
         * Specifies whether the progress bar is oriented vertically or horizontally.
         *
         * @return enum (pbHorizontal, pbVertical)
         */
        protected function readOrientation()    { return $this->_orientation; }
        protected function writeOrientation($value)
        {
                if ($value != $this->_orientation)
                {
                        $w=$this->Width;
                        $h=$this->Height;

                        if (($value==pbHorizontal) && ($w<$h))
                        {
                                $this->Height=$w;
                                $this->Width=$h;
                        }
                        else
                        if (($value==pbVertical) && ($w>$h))
                        {
                                $this->Height=$w;
                                $this->Width=$h;
                        }
                        $this->_orientation=$value;
                }
        }
        protected function defaultOrientation() { return pbHorizontal; }
        /**
         * Specifies the current position of the progress bar.
         *
         * You can read Position to determine how far the process tracked by the
         * progress bar has advanced from Min toward Max. Set Position to cause
         * the progress bar to display a position between Min and Max. For example,
         * when the process tracked by the progress bar completes, set Position to
         * Max so that it appears completely filled.
         * When a progress bar is created, Min and Max represent percentages,
         * where Min is 0 (0% complete) and Max is 100 (100% complete). If these
         * values are not changed, Position is the percentage of the process that
         * has already been completed.
         *
         * @return integer
         */
        protected function readPosition()       { return $this->_position; }
        protected function writePosition($value) { $this->_position=$value; }
        protected function defaultPosition()    { return 50; }
        /**
         * Specifies the lower limit of the range of possible positions.
         *
         * Use Max along with the Min property to establish the range of possible
         * positions a progress bar. When the process tracked by the progress bar
         * begins, the value of Position should equal Min.
         *
         * @return integer
         */
        protected function readMin()            { return $this->_min; }
        protected function writeMin($value)     { $this->_min=$value; }
        protected function defaultMin()         { return 0; }
        /**
         * Specifies the upper limit of the range of possible positions.
         *
         * Use Max along with the Min property to establish the range of possible
         * positions a progress bar. When the process tracked by the progress bar
         * is complete, the value of Position should equal Max.
         *
         * @return integer
         */
        protected function readMax()            { return $this->_max; }
        protected function writeMax($value)     { $this->_max=$value; }
        protected function defaultMax()         { return 100; }
        /**
         * Specifies the amount that Position increases when the StepIt method is called.
         *
         * @return integer
         */
        protected function readStep()           { return $this->_step; }
        protected function writeStep($value)    { $this->_step=$value; }
        protected function defaultStep()        { return 10; }

        /**
         * Advances the Position of the progress bar by a specified amount.
         *
         * @param integer   increase the value of Position by the given value.
         */
        function StepBy($value)
        {
                $p = $this->Position;
                $p += $value;
                if ($p > $this->Max)    { $p = $this->Max; };
                $this->Position = $p;
        }

        /**
         * Advances Position by the amount specified in the Step property.
         *
         * @see Step
         */
        function StepIt()               { $this->StepBy($this->Step); }

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->ControlStyle="csSlowRedraw=1";                
                $this->writeDWidgetClassName("ProgressBar");
                $this->Width=200;
                $this->Height=17;
        }
}

class ProgressBar extends CustomProgressBar
{
        // publish new properties
        function getOrientation()       { return $this->readOrientation(); }
        function setOrientation($value) { $this->writeOrientation($value); }

        function getPosition()          { return $this->readPosition(); }
        function setPosition($value)    { $this->writePosition($value); }

        function getMin()               { return $this->readMin(); }
        function setMin($value)         { $this->writeMin($value); }

        function getMax()               { return $this->readMax(); }
        function setMax($value)         { $this->writeMax($value); }

        function getStep()              { return $this->readStep(); }
        function setStep($value)        { $this->writeStep($value); }
}

define('moHorizontal',0);
define('moVertical',1);

/**
 * GraphicMainMenu class
 *
 * MainMenu with graphic capabilities
 */
class GraphicMainMenu extends Control
{
        protected $_menuobject;
        protected $_menuitems=array();
        private $_itemcount=0;
        private $_menuwidth=60;
        private $_menuheight=49;
        private $_submenuoffset=0;
        private $_backcolor="#F0F0F0";
        private $_selectedbackcolor="#C1D2EE";
        private $_borderwidth="1px";
        private $_borderstyle="solid";
        private $_bordercolor="#CCCCCC";

        private $_orientation=moHorizontal;

        function getOrientation() { return $this->_orientation; }
        function setOrientation($value) { $this->_orientation=$value; }
        function defaultOrientation() { return moHorizontal; }

        function readParentFont()
        {
                return(0);
        }

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);
                $this->ControlStyle="csSlowRedraw=1";
        }

        function dumpHeaderCode()
        {
                if (!defined('DYNAPI'))
                {
                        echo "<script type=\"text/javascript\" src=\"".VCL_HTTP_PATH."/dynapi/src/dynapi.js\"></script>\n";
                        define('DYNAPI', 1);
                }

                if (!defined('DYNAPI_'.strtoupper($this->className())))
                {
                        echo "<script type=\"text/javascript\">\n";
                        if (!defined('DYNAPI'))
                        {
                                echo "dynapi.library.setPath('".VCL_HTTP_PATH."/dynapi/src/');\n";
                                echo "dynapi.library.include('dynapi.api');\n";
                                define('DYNAPI',1);
                        }
                        echo "dynapi.library.include('HTMLMenu');\n";
                        echo "dynapi.library.include('Image');\n";
                        echo "</script>\n";

                        define('DYNAPI_'.strtoupper($this->className()),1);
                }
        }

        /**
         * Dumps a menu item, recursively
         *
         * @param array $item
         * @param string $parent
         */
        function dumpItem($item,$parent)
        {
                $caption="'".$item['Caption']."'";
                $itemc="item".$this->_itemcount;
                $this->_itemcount++;

                $w='null';
                if (array_key_exists('Width',$item)) $w=$item['Width'];

                $css='null';
                if (array_key_exists('CSS',$item)) $css="'".$item['CSS']."'";

                $backcol='null';
                if (array_key_exists('BackColor',$item)) $backcol="'".$item['BackColor']."'";

                $backimage='null';
                if (array_key_exists('BackImage',$item)) $backimage=$item['BackImage'];

                $overimage='null';
                if (array_key_exists('OverImage',$item)) $overimage=$item['OverImage'];

                $selectedimage='null';
                if (array_key_exists('SelectedImage',$item)) $selectedimage=$item['SelectedImage'];

                $img="";

                if ($backimage!='null')
                {
                        $modifiers='null';
                        if ($overimage!='null')
                        {
                                $modifiers="{oversrc:'$overimage'}";
                        }

                        $img="var i1 = dynapi.functions.getImage('$backimage', $w, $this->_menuheight, $modifiers);";
                        $caption="{image:i1,text:$caption}";
                }

                if (($this->ControlState & csDesigning) != csDesigning)
                {
                if ($selectedimage!='null')
                {
                        $cond='null';
                        if (array_key_exists('SelectedCondition',$item)) $cond=$item['SelectedCondition'];
                        if ($cond!='null')
                        {
                                $code="if ($cond) return(1); else return(0);";
                                $ret=eval($code);
                                if ($ret)
                                {
                                        $modifiers='null';
                                        $img="var i1 = dynapi.functions.getImage('$selectedimage', $w, $this->_menuheight, $modifiers);";
                                        $caption="{image:i1,text:'".$item['Caption']."'}";
                                }
                        }
                }
                }

                echo $img;

                $link='null';
                if (array_key_exists('Link',$item)) $link="'document.location=\'".$item['Link']."\';'";

                echo "$parent.addItem($css,$caption,'$itemc',$link,$w,null,$backcol);\n";

                if (array_key_exists('Items',$item))
                {
                        $subitems=$item['Items'];

                        $w='60';

                        if (array_key_exists('SubMenuWidth',$item)) $w=$item['SubMenuWidth'];

                        reset($subitems);
                        echo $itemc."mbar = ".$this->Name.".createMenuBar('$itemc',$w);\n";
                        while (list($k,$v)=each($subitems))
                        {
                        $this->dumpItem($v,$itemc."mbar");
                        }
                }
        }

        function dumpContents()
        {
                $style=$this->Font->FontString;

                $cr='default';
                if ($this->_cursor!="")
                {
                        $cr=strtolower(substr($this->_cursor,2));
                }

                echo "<script type=\"text/javascript\">\n";
                echo "\n";
                echo "// Write Style to browser\n";
//                echo "HTMLComponent.writeStyle({\n";
//                echo "        MNUItm:                 'cursor: default;border: ".$this->_borderwidth." ".$this->_borderstyle." ".$this->_bordercolor.";',\n";
//                echo "        MNUItmText:     'cursor: $cr; $style'\n";
//                echo "});\n";
                echo "\n";
                echo "var  p ={align:\"top\"}\n";
                echo "\n";

                $orientation="horz";
                if ($this->_orientation==moVertical) $orientation="vert";

                echo "var ".$this->Name." = dynapi.document.addChild(new HTMLMenu('','$orientation'),'".$this->Name."');\n";
                echo $this->Name.".backCol = \"".$this->_backcolor."\"\n";
                echo $this->Name.".selBgCol = '".$this->_selectedbackcolor."';\n";
                echo $this->Name.".cssMenu = 'MNU';\n";
                echo $this->Name.".cssMenuText = 'MNUItmText';\n";
                echo $this->Name.".cssMenuItem = 'MNUItm';\n";
                echo "\n";
                echo "var ".$this->Name."mbar;\n";


                $this->_itemcount=0;
                $items=$this->_menuitems;

                if ((!is_array($items))  || (empty($items)))
                {
                        $items=array();
                        $items[]=array
                        (
                                'Caption'=>'MainMenu'
                         );
                }
                echo $this->Name."mbar = ".$this->Name.".createMenuBar('".$this->Name."main',".$this->_menuwidth.",".$this->_menuheight.",".$this->_submenuoffset.",0);\n";
                reset($items);

                while (list($k,$v)=each($items))
                {
                        $item=$v;
                        $this->dumpItem($item,$this->Name."mbar");
                }


                echo "</script>\n";
                echo "<script type=\"text/javascript\">\n";
                echo "dynapi.document.insertChild(".$this->Name.");\n";
                echo "</script>\n";
        }

        function getFont() { return $this->readFont(); }
        function setFont($value) { $this->writeFont($value); }

        function getMenuItems() { return $this->_menuitems; }
        function setMenuItems($value) { $this->_menuitems=$value; }

        function getMenuWidth() { return $this->_menuwidth; }
        function setMenuWidth($value) { $this->_menuwidth=$value; }

        function getMenuHeight() { return $this->_menuheight; }
        function setMenuHeight($value) { $this->_menuheight=$value; }

        function getSubmenuOffset() { return $this->_submenuoffset; }
        function setSubmenuOffset($value) { $this->_submenuoffset=$value; }

        function getBackColor() { return $this->_backcolor; }
        function setBackColor($value) { $this->_backcolor=$value; }

        function getBorderColor() { return $this->_bordercolor; }
        function setBorderColor($value) { $this->_bordercolor=$value; }

        function getBorderStyle() { return $this->_borderstyle; }
        function setBorderStyle($value) { $this->_borderstyle=$value; }


        function getBorderWidth() { return $this->_borderwidth; }
        function setBorderWidth($value) { $this->_borderwidth=$value; }

        function getSelectedBackColor() { return $this->_selectedbackcolor; }
        function setSelectedBackColor($value) { $this->_selectedbackcolor=$value; }

}

/**
 * CustomRichEdit class
 *
 * Base class for RichEdit controls.
 * This control uses the Xinha as WYSIWYG HTML editor.
 * @see http://xinha.python-hosting.com/
 *
 * Note: Be aware that after a webpage with a CustomRichEdit has been submitted
 *       the Lines and Text properties are strings containing any HTML that are
 *       allowed by the Xinha editor.
 */
class CustomRichEdit extends CustomMemo
{
        /**
        * This time is used for to work around a problem in the Xinha editor. The
        * editor JS object is not yet initialized while the page is loading.
        * The time must be set each time CustomRichEdit gets shown (not persistent),
        * so the place to change its value would be OnBeforeShow();.
        *
        * A current problem in Xinha is that it does not save the contents of the editor
        * back to the textarea when a form.submit(); has been called via JS. By
        * adding a JS mouseout event to the editor we can fix that.
        *
        * Default value $loadjstime is set to 3000 milliseconds.
        */
        public $loadjstime = 5000;

        function __construct($aowner = null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width = 400;
                $this->Height = 270;

                $this->_richeditor = 1;
        }

        protected function readRichEditJSEvent($event, $eventname)
        {
                $result = "";
                if ($event != null)
                {
                        $result  = "        HTMLArea._addEvent(html_editor._htmlArea, \"$eventname\", $event);\n";
                        $result .= "        HTMLArea._addEvent(html_editor._doc, \"$eventname\", $event);\n";
                }
                return $result;
        }

        protected function readRichEditJSEvents()
        {
                $result  = "";
                $result .= $this->readRichEditJSEvent($this->readjsOnBlur(),      "blur");
                $result .= $this->readRichEditJSEvent($this->readjsOnChange(),    "change");
                $result .= $this->readRichEditJSEvent($this->readjsOnClick(),     "click");
                $result .= $this->readRichEditJSEvent($this->readjsOnDblClick(),  "dblclick");
                $result .= $this->readRichEditJSEvent($this->readjsOnFocus(),     "focus");
                $result .= $this->readRichEditJSEvent($this->readjsOnMouseDown(), "mousedown");
                $result .= $this->readRichEditJSEvent($this->readjsOnMouseUp(),   "mouseup");
                $result .= $this->readRichEditJSEvent($this->readjsOnMouseOver(), "mouseover");
                $result .= $this->readRichEditJSEvent($this->readjsOnMouseMove(), "mousemove");
                $result .= $this->readRichEditJSEvent($this->readjsOnMouseOut(),  "mouseout");
                $result .= $this->readRichEditJSEvent($this->readjsOnKeyPress(),  "keypress");
                $result .= $this->readRichEditJSEvent($this->readjsOnKeyDown(),   "keydown");
                $result .= $this->readRichEditJSEvent($this->readjsOnKeyUp(),     "keyup");
                $result .= $this->readRichEditJSEvent($this->readjsOnSelect(),    "select");

                return $result;
        }


        function dumpHeaderCode()
        {
                if ($this->canShow())
                {
                        if ($this->_richeditor)
                        {
                                $pref = strtolower($this->_name);

                                $style = $this->Font->FontString;

                                if ($this->color != "")
                                {
                                        $style .= "background-color: " . $this->color . ";";
                                }

                                if (!defined('XINHA'))
                                {
                                        //define('XINHA', 1);

?>
  <script type="text/javascript">
  _editor_url  = "<?php echo VCL_HTTP_PATH;      ?>/resources/xinha/";
  _editor_lang = "en";      // And the language we need to use in the editor.
  </script>

  <script type="text/javascript" src="<?php echo VCL_HTTP_PATH; ?>/resources/xinha/htmlarea.js"></script>
<?php
                                }
?>

  <script type="text/javascript">
  var <?php echo $this->_name; ?>_previous_load = null;
  var <?php echo $this->_name; ?>_html_editor = null;
  xinha_init    = null;

  // This contains the names of textareas we will make into Xinha editors
  xinha_init = xinha_init ? xinha_init : function()
  {
        xinha_editors = null;
        xinha_config  = null;
        xinha_plugins = null;

        xinha_plugins = xinha_plugins ? xinha_plugins : [];

        if(!HTMLArea.loadPlugins(xinha_plugins, xinha_init)) return;
        xinha_editors = xinha_editors ? xinha_editors : ['<?php echo $this->_name;     ?>'];
        xinha_config = xinha_config ? xinha_config : new HTMLArea.Config();

        xinha_config.pageStyle = 'body { <?php echo $style;     ?> }';

        xinha_editors   = HTMLArea.makeEditors(xinha_editors, xinha_config, xinha_plugins);
        <?php echo $this->_name; ?>_html_editor = xinha_editors['<?php echo $this->_name; ?>'];

        //      xinha_editors.<?php echo $this->_name;     ?>.config.width  = <?php echo $this->_width;     ?>;
        //      xinha_editors.<?php echo $this->_name;     ?>.config.height = <?php echo $this->_height;     ?>;

        HTMLArea.startEditors(xinha_editors);

        if (<?php echo $this->_name;     ?>_previous_load!=null) <?php echo $this->_name;     ?>_previous_load();
  }
  <?php echo $this->_name;     ?>_previous_load=window.onload;

  window.onload   = xinha_init;

  function updateEditor_<?php echo $this->_name; ?>()
  {
        var html_editor = <?php echo $this->_name; ?>_html_editor;

        <?php
                //TODO: Find a way to disable the xinha control in JS.
                //echo ($this->Enabled) ? "" : "html_editor._doc.body.contentEditable = false;\n";
                echo $this->readRichEditJSEvents();

        
        // This is a work around so the data in the rich edit gets saved when another control calls form.submit();
        // The function needs to be called by a timer since _textArea is not initialized on load.
        ?>
        HTMLArea._addEvent(html_editor._htmlArea, "mouseout", function () {
          html_editor._textArea.value = html_editor.getHTML();
        });
  }
  // allow enough time to load the page; see public variable to change the time
  setTimeout("updateEditor_<?php echo $this->_name; ?>()", <?php echo $this->loadjstime; ?>);
  </script>
<?php
                        }
                }
        }
}


/**
 * RichEdit class
 *
 * A class to encapsulate a wysiwyg editor
 */
class RichEdit extends CustomRichEdit
{
        /*
        * Publish the events for the component
        */
        function getOnSubmit                    () { return $this->readOnSubmit(); }
        function setOnSubmit                    ($value) { $this->writeOnSubmit($value); }

        /*
        * Publish the JS events for the component
        */
        function getjsOnBlur                    () { return $this->readjsOnBlur(); }
        function setjsOnBlur                    ($value) { $this->writejsOnBlur($value); }

        function getjsOnChange                  () { return $this->readjsOnChange(); }
        function setjsOnChange                  ($value) { $this->writejsOnChange($value); }

        function getjsOnClick                   () { return $this->readjsOnClick(); }
        function setjsOnClick                   ($value) { $this->writejsOnClick($value); }

        function getjsOnDblClick                () { return $this->readjsOnDblClick(); }
        function setjsOnDblClick                ($value) { $this->writejsOnDblClick($value); }

        function getjsOnFocus                   () { return $this->readjsOnFocus(); }
        function setjsOnFocus                   ($value) { $this->writejsOnFocus($value); }

        function getjsOnMouseDown               () { return $this->readjsOnMouseDown(); }
        function setjsOnMouseDown               ($value) { $this->writejsOnMouseDown($value); }

        function getjsOnMouseUp                 () { return $this->readjsOnMouseUp(); }
        function setjsOnMouseUp                 ($value) { $this->writejsOnMouseUp($value); }

        function getjsOnMouseOver               () { return $this->readjsOnMouseOver(); }
        function setjsOnMouseOver               ($value) { $this->writejsOnMouseOver($value); }

        function getjsOnMouseMove               () { return $this->readjsOnMouseMove(); }
        function setjsOnMouseMove               ($value) { $this->writejsOnMouseMove($value); }

        function getjsOnMouseOut                () { return $this->readjsOnMouseOut(); }
        function setjsOnMouseOut                ($value) { $this->writejsOnMouseOut($value); }

        function getjsOnKeyPress                () { return $this->readjsOnKeyPress(); }
        function setjsOnKeyPress                ($value) { $this->writejsOnKeyPress($value); }

        function getjsOnKeyDown                 () { return $this->readjsOnKeyDown(); }
        function setjsOnKeyDown                 ($value) { $this->writejsOnKeyDown($value); }

        function getjsOnKeyUp                   () { return $this->readjsOnKeyUp(); }
        function setjsOnKeyUp                   ($value) { $this->writejsOnKeyUp($value); }

        function getjsOnSelect                  () { return $this->readjsOnSelect(); }
        function setjsOnSelect                  ($value) { $this->writejsOnSelect($value); }


        /*
        * Publish the properties for the component
        */
        function getColor()
        {
                return $this->readColor();
        }
        function setColor($value)
        {
                $this->writeColor($value);
        }

        function getDataField()
        {
                return $this->readDataField();
        }
        function setDataField($value)
        {
                $this->writeDataField($value);
        }

        function getDataSource()
        {
                return $this->readDataSource();
        }
        function setDataSource($value)
        {
                $this->writeDataSource($value);
        }

        /*
        //TODO: Find a way to disable the xinha control in JS.
        function getEnabled()
        {
                return $this->readEnabled();
        }
        function setEnabled($value)
        {
                $this->writeEnabled($value);
        }
        */

        function getFont()
        {
                return $this->readFont();
        }
        function setFont($value)
        {
                $this->writeFont($value);
        }

        function getLines()
        {
                return $this->readLines();
        }
        function setLines($value)
        {
                $this->writeLines($value);
        }

        function getParentColor()
        {
                return $this->readParentColor();
        }
        function setParentColor($value)
        {
                $this->writeParentColor($value);
        }

        function getParentFont()
        {
                return $this->readParentFont();
        }
        function setParentFont($value)
        {
                $this->writeParentFont($value);
        }

        function getParentShowHint()
        {
                return $this->readParentShowHint();
        }
        function setParentShowHint($value)
        {
                $this->writeParentShowHint($value);
        }

        function getPopupMenu()
        {
                return $this->readPopupMenu();
        }
        function setPopupMenu($value)
        {
                $this->writePopupMenu($value);
        }

        function getShowHint()
        {
                return $this->readShowHint();
        }
        function setShowHint($value)
        {
                $this->writeShowHint($value);
        }

        /*
        //TODO: Investigate if tabindex can be set on the xinha control.
        function getTabOrder()
        {
                return $this->readTabOrder();
        }
        function setTabOrder($value)
        {
                $this->writeTabOrder($value);
        }

        function getTabStop()
        {
                return $this->readTabStop();
        }
        function setTabStop($value)
        {
                $this->writeTabStop($value);
        }
        */

        function getVisible()
        {
                return $this->readVisible();
        }
        function setVisible($value)
        {
                $this->writeVisible($value);
        }
}

/**
 * TrackBar Class
 *
 * A class to show a trackbar
 */
class TrackBar extends Control
{
        protected $_position = 0;
        protected $_maxposition = 10;

        function dumpJsEvents()
        {
                $this->dumpJSEvent($this->jsOnChange);
        }

        function dumpHeaderCode()
        {
                if (!defined('DSJSSLIDERBAR'))
                {
                        echo "<script type=\"text/javascript\" src=\"" . VCL_HTTP_PATH . "/jssliderbar/ds_jssliderbar.js\"></script>\n";
                        define('DSJSSLIDERBAR', 1);
                }

                if ((($this->ControlState & csDesigning)!=csDesigning) && ($this->jsOnChange != null))
                     $event = $this->jsOnChange;
                else $event = "null";

                echo "<script type=\"text/javascript\">\n";
                echo "<!--\n";
                echo "function " . $this->Name . "_Handler(event)\n";
                echo "{\n";
                echo "  var event = event || window.event;\n";
                echo "  dsSliderMouseDown(event, '" . $this->Name . "', $this->_maxposition, $event);\n";
                echo "}\n";
                echo "-->\n";
                echo "</script>\n";
        }

        function dumpContents()
        {
                $left = $this->Position * $this->Width / $this->MaxPosition - 4;
                if ($left < 0) $left = 0;
                else
                if ($left + 9 > $this->Width) $left = $this->Width - 9;

                echo "  <div id=\"" . $this->Name . "_Container\" style=\"position:absolute;top:0px;left:0px;width:"
                        . $this->Width . "px;height:30px; background-image: url('"
                        . VCL_HTTP_PATH . "/jssliderbar/ruller.gif'); background-repeat: repeat\">\n";
                echo "  <input type=\"hidden\" id=\"" . $this->Name . "_Position\" value=\"0\" />\n";
                echo "    <div id=\"" . $this->Name . "_Head\" style=\"position:absolute;top:5px;left:" . $left . "px;width:9px;height:17px;cursor:pointer;cursor:hand\""
                        . " onmousedown=\"return " . $this->Name . "_Handler(event);\"><img src=\""
                        . VCL_HTTP_PATH . "/jssliderbar/head.gif\" style=\"height:17px;width:9px;border:0\"/></div>\n";
                echo "  </div>\n";
        }

        /**
         * Specifies the maximum Position of a TTrackBar.
         * @return integer
         */
        protected function readMaxPosition()        { return $this->_maxposition; }
        protected function writeMaxPosition($value) { $this->_maxposition = $value; }
        function defaultMaxPosition()               { return 10; }
        /**
         * Contains the current position of the slider of a TTrackBar.
         * @return integer
         */
        protected function readPosition()           { return $this->_position; }
        protected function writePosition($value)    { $this->_position = $value; }
        function defaultPosition()                  { return 0; }

        function getMaxPosition()        { return $this->readMaxPosition(); }
        function setMaxPosition($value)  { $this->writeMaxPosition($value); }

        function getPosition()           { return $this->readPosition(); }
        function setPosition($value)     { $this->writePosition($value); }

        function getjsOnChange()        { return $this->readjsOnChange(); }
        function setjsOnChange($value)  { $this->writejsOnChange($value); }
}

/**
 * Numerical editor
 *
 */
class CustomUpDown extends QWidget
{
        protected $_borderstyle = bsSingle;
        protected $_datasource = null;
        protected $_datafield = "";

        protected $_increment = 1;
        protected $_min=0;
        protected $_max=100;
        protected $_position=0;

        function dumpContents()
        {
                $this->dumpCommonContentsTop();

                if (($this->ControlState & csDesigning) != csDesigning)
                {
                        if (($this->_datasource != null) && ($this->_datafield != ""))
                        {
                                if ($this->_datasource->DataSet != null)
                                {
                                        $ds = $this->_datasource->DataSet;
                                        $df = $this->_datafield;
                                        $this->_position = $ds->$df;
                                }
                        }
                }

                if ($this->_borderstyle == bsNone)
                { $border = "none"; }
                else
                { $border = "solid"; }

                // call the OnShow event if assigned so the Text property can be changed
                if ($this->_onshow != null)
                {
                        $this->callEvent('onshow', array());
                }

                echo "  var $this->Name = new qx.ui.form.Spinner($this->Min,$this->Position,$this->Max);\n"
                   . "  $this->Name.setLeft(0);\n"
                   . "  $this->Name.setTop(0);\n"
                   . "  $this->Name.setWidth($this->Width);\n"
                   . "  $this->Name.setHeight($this->Height);\n"
                   . "  $this->Name.setIncrementAmount($this->Increment);\n"
                   . "  $this->Name.setBorder(new qx.renderer.border.Border(1, '$border'));\n";

                echo "  $this->Name.addEventListener('change', function(e) { hid=findObj(\"".$this->Name."_state\"); hid.value=$this->Name.getValue(); });\n";

                $this->dumpCommonQWidgetProperties($this->Name, 0);
                $this->dumpCommonQWidgetJSEvents($this->Name, 2);

                $this->dumpCommonContentsBottom();
        }

        function loaded()
        {
                parent::loaded();
                $this->writeDataSource($this->_datasource);
        }

        function init()
        {
            parent::init();
            $this->readProperty('Position',$this->Name.'_state');
        }

        protected function CheckPosition()
        {
                if ($this->Min > $this->Max)
                { $this->Max = $this->Min; }

                if ($this->Position > $this->Max)
                { $this->Position = $this->Max; }
                else
                if ($this->Position < $this->Min)
                { $this->Position = $this->Min; }
        }

        // Properties
        /**
        * Determines whether the edit control has a single line border
        * around the client area.
        *
        * @return enum (bsSingle, bsNone)
        */
        protected function readBorderStyle()        { return $this->_borderstyle; }
        protected function writeBorderStyle($value) { $this->_borderstyle=$value; }
        protected function defaultBorderStyle()     { return bsSingle; }

        protected function readDataField()          { return $this->_datafield; }
        protected function writeDataField($value)   { $this->_datafield = $value; }
        protected function defaultDataField()       { return ""; }
        /**
        * DataSource points to a DataSource component if used.
        *
        * @return pointer to the DataSource
        */
        protected function readDataSource()         { return $this->_datasource; }
        protected function writeDataSource($value)  { $this->_datasource = $this->fixupProperty($value); }
        protected function defaultDataSource()      { return null; }
        /**
         * Specifies the amount the Position value changes each time the up
         * or down button is pressed.
         *
         * @return integer
         */
        protected function readIncrement()          { return $this->_increment; }
        protected function writeIncrement($value)   { $this->_increment=$value; }
        protected function defaultIncrement()        { return 1; }
        /**
         * Specifies the minimum value of the Position property.
         *
         * @return integer
         */
        protected function readMin()                { return $this->_min; }
        protected function writeMin($value)         { $this->_min=$value; $this->CheckPosition(); }
        protected function defaultMin()             { return 0; }
        /**
         * Specifies the maximum value of the Position property.
         *
         * @return integer
         */
        protected function readMax()                { return $this->_max; }
        protected function writeMax($value)         { $this->_max=$value; $this->CheckPosition(); }
        protected function defaultMax()             { return 100; }
        /**
         * Specifies the current value represented by the up-down control.
         *
         * @return integer
         */
        protected function readPosition()           { return $this->_position; }
        protected function writePosition($value)    { $this->_position=$value; $this->CheckPosition(); }
        protected function defaultPosition()        { return 0; }

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width=120;
                $this->Height=21;
        }
}

class UpDown extends CustomUpDown
{
        // Publish inherited
        //function getFont()              { return $this->readFont(); }
        //function setFont($value)        { $this->writeFont($value); }

        //function getParentFont()        { return $this->readParentFont(); }
        //function setParentFont($value)  { $this->writeParentFont($value); }

        function getAlignment() { return $this->readAlignment(); }
        function setAlignment($value) { $this->writeAlignment($value); }

        function getParentShowHint()    { return $this->readParentShowHint(); }
        function setParentShowHint($value) { $this->writeParentShowHint($value); }

        function getShowHint()          { return $this->readShowHint(); }
        function setShowHint($value)    { $this->writeShowHint($value); }

        function getVisible() { return $this->readVisible(); }
        function setVisible($value) { $this->writeVisible($value); }

        // Publish new properties
        function getBorderStyle()       { return $this->readBorderStyle();  }
        function setBorderStyle($value) { $this->writeBorderStyle($value);  }

        function getDataField()         { return $this->readDataField(); }
        function setDataField($value)   { $this->writeDataField($value); }

        function getDataSource()        { return $this->readDataSource(); }
        function setDataSource($value)  { $this->writeDataSource($value); }

        function getIncrement()         { return $this->readIncrement(); }
        function setIncrement($value)   { $this->writeIncrement($value); }

        function getMin()               { return $this->readMin(); }
        function setMin($value)         { $this->writeMin($value); }

        function getMax()               { return $this->readMax(); }
        function setMax($value)         { $this->writeMax($value); }

        function getPosition()          { return $this->readPosition(); }
        function setPosition($value)    { $this->writePosition($value); }

        // Common events
        function getjsOnActivate()      { return $this->readjsOnActivate(); }
        function setjsOnActivate($value){ $this->writejsOnActivate($value); }

        function getjsOnDeActivate()    { return $this->readjsOnDeActivate(); }
        function setjsOnDeActivate($value) { $this->writejsOnDeActivate($value); }

        function getjsOnBlur()          { return $this->readjsOnBlur(); }
        function setjsOnBlur($value)    { $this->writejsOnBlur($value); }

        function getjsOnChange()        { return $this->readjsOnChange(); }
        function setjsOnChange($value)  { $this->writejsOnChange($value); }

        function getjsOnClick()         { return $this->readjsOnClick(); }
        function setjsOnClick($value)   { $this->writejsOnClick($value); }

        function getjsOnContextMenu()   { return $this->readjsOnContextMenu(); }
        function setjsOnContextMenu($value) { $this->writejsOnContextMenu($value); }

        function getjsOnDblClick()      { return $this->readjsOnDblClick(); }
        function setjsOnDblClick($value){ $this->writejsOnDblClick($value); }

        function getjsOnFocus()         { return $this->readjsOnFocus(); }
        function setjsOnFocus($value)   { $this->writejsOnFocus($value); }

        function getjsOnKeyDown()       { return $this->readjsOnKeyDown(); }
        function setjsOnKeyDown($value) { $this->writejsOnKeyDown($value); }

        function getjsOnKeyPress()      { return $this->readjsOnKeyPress(); }
        function setjsOnKeyPress($value){ $this->writejsOnKeyPress($value); }

        function getjsOnKeyUp()         { return $this->readjsOnKeyUp(); }
        function setjsOnKeyUp($value)   { $this->writejsOnKeyUp($value); }

        function getjsOnMouseDown()      { return $this->readjsOnMouseDown(); }
        function setjsOnMouseDown($value){ $this->writejsOnMouseDown($value); }

        function getjsOnMouseUp()       { return $this->readjsOnMouseUp(); }
        function setjsOnMouseUp($value) { $this->writejsOnMouseUp($value); }

        function getjsOnMouseMove()     { return $this->readjsOnMouseMove(); }
        function setjsOnMouseMove($value) { $this->writejsOnMouseMove($value); }

        function getjsOnMouseOut()      { return $this->readjsOnMouseOut(); }
        function setjsOnMouseOut($value) { $this->writejsOnMouseOut($value); }

        function getjsOnMouseOver()     { return $this->readjsOnMouseOver(); }
        function setjsOnMouseOver($value) { $this->writejsOnMouseOver($value); }
}

/**
 * Color selection widget
 *
 */
class ColorSelector extends QWidget
{
   //     protected $_jsonchange=null;

        function dumpContents()
        {
                $this->Width=557;
                $this->Height=314;

                $this->dumpCommonContentsTop();

                $value=$this->Color;
                if ($value!='')
                {
                        if ($value[0]=='#') $value=substr($value,1);
                        $r=hexdec(substr($value,0,2));
                        $g=hexdec(substr($value,2,2));
                        $b=hexdec(substr($value,4,2));
                        $value="$r,$g,$b";
                }

//                echo "  d.setBackgroundColor('#EBE9ED');\n";
                echo "  var $this->Name = new qx.ui.component.ColorSelector($value);\n";
                echo "        $this->Name.setLeft(0);\n";
                echo "        $this->Name.setTop(0);\n";
                echo "        $this->Name.setWidth($this->Width);\n";
                echo "        $this->Name.setHeight($this->Height);\n";
                echo "  $this->Name.setBackgroundColor('#EBE9ED');\n";

                if (($this->Visible) || (($this->ControlState & csDesigning)==csDesigning))
                      { $visible="true"; }
                else  { $visible="false"; };

                echo "  $this->Name.setVisibility($visible);\n";

                if (($this->ControlState & csDesigning)!=csDesigning)
                {
                        if (($this->_jsonchange!="") && ($this->_jsonchange!=null))
                        {
                                echo "  $this->Name.addEventListener(\"dialogok\", $this->_jsonchange);\n";
                        }
                }

                $this->dumpCommonContentsBottom();
        }

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width=557;
                $this->Height=314;
                $this->ControlStyle="csSlowRedraw=1";
        }

        //Publish common properties
        function getColor() { return $this->readColor(); }
        function setColor($value) { $this->writeColor($value); }

        function getVisible() { return $this->readVisible(); }
        function setVisible($value) { $this->writeVisible($value); }

        function getjsOnChange()                { return $this->readjsOnChange(); }
        function setjsOnChange($value)          { $this->writejsOnChange($value); }
}

/**
 * LabeledEdit Class
 *
 * LabeledEdit is an edit control that has an associated label.
 */

class SubLabel extends Persistent
{
        protected $_caption = "";

        function assignTo($dest)        { $dest->_caption=$this->_caption; }

        /**
         * Specifies the caption used in the label
         *
         * @return string
         */
        protected function readCaption()           { return $this->_caption; }
        protected function writeCaption($value)    { $this->_caption=$value; }
        function defaultCaption()                  { return ""; }

        // publish properties
        function getCaption()           { return $this->readCaption(); }
        function setCaption($value)     { $this->writeCaption($value); }
}

class CustomLabeledEdit extends CustomTextField
{
        protected $_lblname = "";

        protected $_edtlabel=null;
        protected $_lblspacing = 3;
        protected $_lblposition = lpAbove;
        protected $_text = "";

        protected function CalculateEditorRect()
        {
                switch ($this->_lblposition)
                {
                        case lpBelow:
                                $y = 0;
                                break;
                        default: // lpAbove:
                                $y = 14 + $this->_lblspacing;
                                break;
                }
                return array(0, $y, $this->Width, $this->Height - 14 - $this->_lblspacing);
        }

        protected function dumpExtraControlCode()
        {
                $eh = $this->Height - 14 - $this->_lblspacing;
                switch ($this->_lblposition)
                {
                        case lpBelow:
                                $y = $eh;
                                break;
                        default: // lpAbove:
                                $y = 0;
                                break;
                }

                $this->_lblname = $this->Name . "_Lbl";

                echo "  var $this->_lblname = new qx.ui.basic.Atom(\"" . $this->_edtlabel->Caption . "\");\n"
                   . "  $this->_lblname.setLeft(0);\n"
                   . "  $this->_lblname.setTop($y);\n"
                   . "  $this->_lblname.setWidth($this->Width);\n"
                   . "  $this->_lblname.setHorizontalChildrenAlign(\"left\");\n";

                if (($this->Visible) || (($this->ControlState & csDesigning)==csDesigning))
                      { $visible="true"; }
                else  { $visible="false"; };
                echo "  $this->_lblname.setVisibility($visible);\n"
                   . "  inline_div.add($this->_lblname);\n";
        }

        function __construct($aowner = null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->_edtlabel = new SubLabel();
                $this->Width = 121;
                $this->Height = 34;
        }

        function setName($value)
        {
                $oldname=$this->_name;
                parent::setName($value);

                //Sets the caption if not already changed
                if ($this->_edtlabel->Caption == $oldname)
                {
                        $this->_edtlabel->Caption = $this->Name;
                }
        }

        /**
         * Use EditLabel to work with the label that is associated with this
         * labeled edit control. Use this label’s properties to specify the
         * caption that appears on the label.
         */
        protected function readEditLabel()              { return $this->_edtlabel; }
        protected function writeEditLabel($value)       { if (is_object($value)) $this->_edtlabel=$value; }
        /**
         * Specifies the position of the label relative to the edit control.
         *
         * @return enum (lpAbove, lpBelow)
         */
        protected function readLabelPosition()          { return $this->_lblposition; }
        protected function writeLabelPosition($value)   { $this->_lblposition=$value; }
        function defaultLabelPosition()     { return lpAbove; }
        /**
         * Specifies the distance, in pixels, between the label and the edit region.
         *
         * @return integer
         */
        protected function readLabelSpacing()           { return $this->_lblspacing; }
        protected function writeLabelSpacing($value)    { $this->_lblspacing=$value; }
        function defaultLabelSpacing()      { return 3; }
}

class LabeledEdit extends CustomLabeledEdit
{
        //Publish common properties
        //function getFont()              { return $this->readFont(); }
        //function setFont($value)        { $this->writeFont($value); }

        function getColor()             { return $this->readColor(); }
        function setColor($value)       { $this->writeColor($value); }

        function getEnabled()           { return $this->readEnabled(); }
        function setEnabled($value)     { $this->writeEnabled($value); }

        function getParentColor()       { return $this->readParentColor(); }
        function setParentColor($value) { $this->writeParentColor($value); }

        function getParentFont()        { return $this->readParentFont(); }
        function setParentFont($value)  { $this->writeParentFont($value); }

        function getParentShowHint()    { return $this->readParentShowHint(); }
        function setParentShowHint($value) { $this->writeParentShowHint($value); }

        function getPopupMenu()         { return $this->readPopupMenu(); }
        function setPopupMenu($value)   { $this->writePopupMenu($value); }

        function getShowHint()          { return $this->readShowHint(); }
        function setShowHint($value)    { $this->writeShowHint($value); }

        function getVisible()           { return $this->readVisible(); }
        function setVisible($value)     { $this->writeVisible($value); }

        //Publish Edit control properties
        function getBorderStyle()       { return $this->readBorderStyle();  }
        function setBorderStyle($value) { $this->writeBorderStyle($value);  }

        function getCharCase()          { return $this->readCharCase(); }
        function setCharCase($value)    { $this->writeCharCase($value); }

        function getDataField()         { return $this->readDataField(); }
        function setDataField($value)   { $this->writeDataField($value); }

        function getDataSource()        { return $this->readDataSource(); }
        function setDataSource($value)  { $this->writeDataSource($value); }

        function getIsPassword()        { return $this->readIsPassword(); }
        function setIsPassword($value)  { $this->writeIsPassword($value); }

        function getMaxLength()         { return $this->readMaxLength(); }
        function setMaxLength($value)   { $this->writeMaxLength($value); }

        function getReadOnly()          { return $this->readReadOnly(); }
        function setReadOnly($value)    { $this->writeReadOnly($value); }

        function getText()              { return $this->readText(); }
        function setText($value)        { $this->writeText($value); }

        // publish Common Events
        function getjsOnActivate()      { return $this->readjsOnActivate(); }
        function setjsOnActivate($value){ $this->writejsOnActivate($value); }

        function getjsOnDeActivate()    { return $this->readjsOnDeActivate(); }
        function setjsOnDeActivate($value) { $this->writejsOnDeActivate($value); }

        function getjsOnChange()        { return $this->readjsOnChange(); }
        function setjsOnChange($value)  { $this->writejsOnChange($value); }

        function getjsOnBlur()          { return $this->readjsOnBlur(); }
        function setjsOnBlur($value)    { $this->writejsOnBlur($value); }

        function getjsOnClick()         { return $this->readjsOnClick(); }
        function setjsOnClick($value)   { $this->writejsOnClick($value); }

        function getjsOnContextMenu()   { return $this->readjsOnContextMenu(); }
        function setjsOnContextMenu($value) { $this->writejsOnContextMenu($value); }

        function getjsOnDblClick()      { return $this->readjsOnDblClick(); }
        function setjsOnDblClick($value){ $this->writejsOnDblClick($value); }

        function getjsOnFocus()         { return $this->readjsOnFocus(); }
        function setjsOnFocus($value)   { $this->writejsOnFocus($value); }

        function getjsOnKeyDown()       { return $this->readjsOnKeyDown(); }
        function setjsOnKeyDown($value) { $this->writejsOnKeyDown($value); }

        function getjsOnKeyPress()      { return $this->readjsOnKeyPress(); }
        function setjsOnKeyPress($value){ $this->writejsOnKeyPress($value); }

        function getjsOnKeyUp()         { return $this->readjsOnKeyUp(); }
        function setjsOnKeyUp($value)   { $this->writejsOnKeyUp($value); }

        function getjsOnMouseDown()      { return $this->readjsOnMouseDown(); }
        function setjsOnMouseDown($value){ $this->writejsOnMouseDown($value); }

        function getjsOnMouseUp()       { return $this->readjsOnMouseUp(); }
        function setjsOnMouseUp($value) { $this->writejsOnMouseUp($value); }

        function getjsOnMouseMove()     { return $this->readjsOnMouseMove(); }
        function setjsOnMouseMove($value) { $this->writejsOnMouseMove($value); }

        function getjsOnMouseOut()      { return $this->readjsOnMouseOut(); }
        function setjsOnMouseOut($value) { $this->writejsOnMouseOut($value); }

        function getjsOnMouseOver()     { return $this->readjsOnMouseOver(); }
        function setjsOnMouseOver($value) { $this->writejsOnMouseOver($value); }

        // publish new properties
        function getEditLabel()             { return $this->readEditLabel(); }
        function setEditLabel($value)       { $this->writeEditLabel($value); }

        function getLabelPosition()         { return $this->readLabelPosition(); }
        function setLabelPosition($value)   { $this->writeLabelPosition($value); }

        function getLabelSpacing()         { return $this->readLabelSpacing(); }
        function setLabelSpacing($value)   { $this->writeLabelSpacing($value); }
        // publish events
        //function getOnClick()           { return $this->readOnClick(); }
        //function setOnClick($value)     { $this->writeOnClick($value); }
}

/**
 * ToolBar object
 *
 * @package ComCtrls
 */
class CustomToolBar extends QWidget
{
        protected $_items=array();
        protected $_images = null;
        protected $_useparts = false;

        function loaded()
        {
                parent::loaded();
                $this->writeImages($this->_images);
        }

        function dumpHeaderCode()
        {
                parent::dumpHeaderCode();
                //This function is used as a common click processor for all item clicks
                echo '<script type="text/javascript">';
                echo "function $this->Name"."_clickwrapper(e)\n";
                echo "{\n";
                echo "  submit=true; \n";
                if (($this->ControlState & csDesigning) != csDesigning)
                {
                        if ($this->JsOnClick!=null)
                        {
                                echo "  submit=".$this->JsOnClick."(e);\n";
                        }
                }
                echo "  var tag=e.getTarget().tag;\n";
                echo "  if ((tag!=0) && (submit))\n";
                echo "  {\n";
                echo "    var hid=findObj('$this->Name"."_state');\n";
                echo "    if (hid) hid.value=tag;\n";
                if (($this->ControlState & csDesigning) != csDesigning)
                {
                        $form = "document.".$this->owner->Name;
                        echo "    if (($form.onsubmit) && (typeof($form.onsubmit) == 'function')) { $form.onsubmit(); }\n";
                        echo "    $form.submit();\n";
                }
                echo "    }\n";
                echo "}\n";
                echo '</script>';
        }

        private function dumpParts()
        {
                reset($this->_items);
                while(list($index, $item) = each($this->_items))
                {
                        echo "\n";
                        echo "  <!-- Part #$index Start -->\n";
                        echo "    var tbp = new qx.ui.toolbar.Part;\n";

                        $subitems = $item['Items'];
                        // check if has subitems
                        if ((isset($subitems)) && (count($subitems)))
                        {
                                $this->dumpButtons("tbp", $subitems);
                        }

                        echo "    $this->Name.add(tbp);\n";
                        echo "  <!-- Part $index End -->\n";
                }
        }

        private function dumpButtons($name, $items)
        {
                reset($items);
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

                        $itemname = $name . "_" . $index;

                        if ($caption=='-')
                        {
                                echo "    var $itemname = new qx.ui.toolbar.Separator();\n";
                        }
                        else
                        {
                                echo "    var $itemname = new qx.ui.toolbar.Button(\"$caption\", $image);\n";
                                __QLibrary_SetCursor($itemname, $this->Cursor);
                                echo "    $itemname.addEventListener(\"execute\", " . $this->Name . "_clickwrapper);\n";
                                echo "    $itemname.tag=$tag;\n";
                        }
                        $elements[] = $itemname;
                }

                if (isset($elements))
                {
                        echo "\n";
                        echo "    $name.add(" . implode(",", $elements) . ");\n";
                        unset($elements);
                }
        }

        function dumpContents()
        {
                $this->dumpCommonContentsTop();

                echo "\n";
                echo "  var ".$this->Name."    = new qx.ui.toolbar.ToolBar;\n";
                echo "  $this->Name.setLeft(0);\n";
                echo "  $this->Name.setTop(0);\n";
                echo "  $this->Name.setWidth($this->Width);\n";
                echo "  $this->Name.setHeight(".($this->Height-1).");\n";

                if ($this->UseParts)
                {
                        $this->dumpParts();
                }
                else
                {
                        echo "  <!-- Part Main Start -->\n";
                        echo "  var tbp = new qx.ui.toolbar.Part;\n";
                        $this->dumpButtons("tbp", $this->_items);
                        echo "  $this->Name.add(tbp);\n";
                        echo "  <!-- Part Main End -->\n";
                }
                $this->dumpCommonQWidgetProperties($this->Name, 0);
                $this->dumpCommonQWidgetJSEvents($this->Name, 2);
                $this->dumpCommonContentsBottom();
        }

        function __construct($aowner = null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width=300;
                $this->Height=30;
                $this->Align = alTop;
        }

        function defaultAlign()                 { return alTop; }

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
         * Defines how items specified are used to build toolbar elements
         * If set to True then main level in the Items tree will define Parts
         * and elements from sublevel will be used to build buttons
         * Otherwise, only elements from the main level are used and all subitems are ignored.
         *
         * @return boolean
         */
        protected function readUseParts()       { return $this->_useparts; }
        protected function writeUseParts($value){ $this->_useparts=$value; }
        function defaultUseParts()              { return false; }
}

class ToolBar extends CustomToolBar
{
        //Publish common properties
//        function getColor()                     { return $this->readColor(); }
//        function setColor($value)               { $this->writeColor($value); }

//        function getFont()                      { return $this->readFont(); }
//        function setFont($value)                { $this->writeFont($value); }

//        function getParentFont()                { return $this->readParentFont(); }
//        function setParentFont($value)          { $this->writeParentFont($value); }

        function getVisible()                   { return $this->readVisible(); }
        function setVisible($value)             { $this->writeVisible($value); }

        function getjsOnClick()                 { return $this->readjsOnClick(); }
        function setjsOnClick($value)           { $this->writejsOnClick($value); }

        // publish properties
        function getImages()                    { return $this->readImages(); }
        function setImages($value)              { $this->writeImages($value); }

        function getItems()                     { return $this->readItems(); }
        function setItems($value)               { $this->writeItems($value); }

        function getUseParts()                  { return $this->readUseParts(); }
        function setUseParts($value)            { $this->writeUseParts($value); }
}

?>
