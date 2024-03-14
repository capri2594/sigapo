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
use_unit("stdctrls.inc.php");

/**
 * CheckListBox Class
 *
 * A list with checks at the left
 */
class CustomCheckListBox extends FocusControl
{
        protected $_items = array();
        protected $_borderstyle = bsSingle;
        protected $_borderwidth="1";
        protected $_bordercolor="#CCCCCC";

        protected $_onclick = null;
        protected $_onsubmit = null;

//        protected $_datasource = null;
//        protected $_datafield = "";
        protected $_taborder=0;
        protected $_tabstop=1;

        function __construct($aowner = null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Clear();

                $this->Width = 185;
                $this->Height = 89;

                $this->ControlStyle="csRenderOwner=1";
                $this->ControlStyle="csRenderAlso=StyleSheet";
        }

        function loaded()
        {
                parent::loaded();
//                $this->writeDataSource($this->_datasource);
        }

        function preinit()
        {
                $submitted = $this->input->{$this->Name};

                if (is_object($submitted))
                {
//                        $changed = ($this->_itemindex != $submitted->asString());
//                        // the ItemIndex might be an integer or a string,
//                        // so let's get a string
//                        $this->_itemindex = $submitted->asString();
//
//                        // only update the data field if the item index was changed
//                        if ($changed)
//                        {
//                                // following somehow does not work here:
//                                //   if (array_key_exists($this->_itemindex, $this->_items)) { $this->updateDataField($this->_items[$this->_itemindex]); }
//                                // so let's do it like this...
//                                foreach ($this->_items as $key => $item)
//                                {
//                                        if ($key == $this->_itemindex)
//                                        {
//                                                //If there is any valid DataField attached, update it
//                                                $this->updateDataField($item);
//                                        }
//                                }
//                        }
                }
        }

        function init()
        {
                parent::init();

                $submitted = $this->input->{$this->Name};

                if (is_object($submitted))
                {
                        // Allow the OnSubmit event to be fired because it is not
                        // a mouse or keyboard event.
                        if ($this->_onsubmit != null)
                        {
                                $this->callEvent('onsubmit', array());
                        }
                }

                $submitEvent = $this->input->{$this->getJSWrapperHiddenFieldName()};

                if (is_object($submitEvent) && $this->_enabled == 1)
                {
                        // check if the a click event has been fired
                        if ($this->_onclick != null && $submitEvent->asString() == $this->getJSWrapperSubmitEventValue($this->_onclick))
                        {
                                $this->callEvent('onclick', array());
                        }
                }
        }


        function dumpContents()
        {
                $events = "";
                if ($this->_enabled == 1)
                {
                        // get the string for the JS Events
                        $events = $this->readJsEvents();

                        // add or replace the JS events with the wrappers if necessary
                        $this->addJSWrapperToEvents($events, $this->_onclick,    $this->_jsonclick,    "onclick");
                }

                if ($this->_borderstyle == bsNone )
                {       $border = ""; }
                else
                {       $border = "solid"; }
                if ($this->_borderwidth !=="")
                {       $border .= " " . $this->_borderwidth . "px"; }
                if ($this->_bordercolor !=="")
                {       $border .= " " . $this->_bordercolor; }
                if ($border != "")
                {       $border = "border: " . $border . ";"; }

                $class = ($this->Style != "") ? "class=\"$this->StyleClass\"" : "";

                echo "  <DIV style=\"OVERFLOW-Y:auto; WIDTH:{$this->Width}px; HEIGHT:{$this->Height}px; $border\" $class>\n";

                $style="";
                if ($this->Style=="")
                {
                        // get the Font attributes
                        $style .= $this->Font->FontString;

                        if ($this->Color != "")
                        { $style  .= "background-color: " . $this->Color . ";"; }

                        // add the cursor to the style
                        if ($this->_cursor != "")
                        {
                                $cr = strtolower(substr($this->_cursor, 2));
                                $style .= "cursor: $cr;";
                        }
                }

                $spanstyle = $style;

                // set enabled/disabled status
                $enabled = (!$this->_enabled) ? "disabled=\"disabled\"" : "";

                // set tab order if tab stop set to true
                $taborder = ($this->_tabstop == 1) ? "tabindex=\"$this->_taborder\"" : "";

                // get the hint attribute; returns: title="[HintText]"
                $hint = $this->getHintAttribute();

                if ($style != "") $style = "style=\"$style\"";
                if ($spanstyle != "") $spanstyle = "style=\"$spanstyle\"";

                // get the alignment of the Items
                switch ($this->_alignment)
                {
                        case agNone   : $alignment = ""; break;
                        case agLeft   : $alignment = "align=\"Left\""; break;
                        case agCenter : $alignment = "align=\"Center\""; break;
                        case agRight  : $alignment = "align=\"Right\""; break;
                        default       : $alignment = ""; break;
                }

//                if (($this->ControlState & csDesigning) != csDesigning)
//                {
//                        if ($this->hasValidDataField())
//                        {
//                                //check if the value of the current data-field is in the itmes array as value
//                                $val = $this->readDataFieldValue();
//
//                                //Dumps hidden fields to know which is the record to update
//                                $this->dumpHiddenKeyFields();
//                        }
//                }

                // call the OnShow event if assigned so the Items property can be changed
                if ($this->_onshow != null) $this->callEvent('onshow', array());

                echo "    <table cellpadding=\"0\" cellspacing=\"0\" $style $class>";
                if (is_array($this->_items))
                {
                        // $index is used to call the JS CheckListBox function
                        $index = 0;
                        foreach ($this->_items as $key => $item)
                        {
                                // add the checked attribut if the itemindex is the current item
//                                $checked = ($this->_itemindex == $key) ? "checked=\"checked\"" : "";
                                // only allow an OnClick if enabled
                                $itemclick = ($this->_enabled == 1 && $this->Owner != null) ? "onclick=\"return CheckListBoxClick('$this->Name" . "_" . $index . "', $index);\"" : "";

                                $element = $this->Name . "_" . $key;
                                // add a new row for every item
                                echo "    <tr>\n";
                                echo "      <td width=\"20\"><input ID=\"$element\" type=\"checkbox\" name=\"$this->Name\" value=\"$key\" $events $enabled $taborder $hint $class /></td>\n";
                                echo "      <td $alignment><span ID=\"$element\" $itemclick $hint $spanstyle $class>$item</span></td>\n";
                                echo "    </tr>\n";
                                $index++;
                        }
                }
                echo "    </table>\n";
                echo "  </DIV>";

                // add a hidden field so we can determine which radiogroup fired the event
                if ($this->_onclick != null)
                {
                        echo "\n";
                        echo "<input type=\"hidden\" name=\"".$this->getJSWrapperHiddenFieldName()."\" value=\"\" />";
                }
        }

        /*
        * Write the Javascript section to the header
        */
        function dumpJavascript()
        {
                parent::dumpJavascript();

                if ($this->_enabled == 1)
                {
                        if ($this->_onclick != null && !defined($this->_onclick))
                        {
                                // only output the same function once;
                                // otherwise if for example two radio groups use the same
                                // OnClick event handler it would be outputted twice.
                                $def=$this->_onclick;
                                define($def,1);

                                // output the wrapper function
                                echo $this->getJSWrapperFunction($this->_onclick);
                        }

                        // only output the function once
                        if (!defined('CheckListBoxClick'))
                        {
                                define('CheckListBoxClick', 1);

                                echo "function CheckListBoxClick(name, index)\n";
                                echo "{\n";
                                echo "  var event = event || window.event;\n";
                                echo "  var obj=document.getElementById(name);\n";
                                echo "  if (obj) {\n";
                                echo "    if (!obj.disabled) {\n";
                                echo "      obj.checked = !obj.checked;\n";
                                echo "      return obj.onclick();\n";
                                echo "    }\n";
                                echo "  }\n";
                                echo "  return false;\n";
                                echo "}\n";
                        }
                }
        }

        /**
        * Adds an item to the radio group control.
        * @param mixed $item Value of item to add.
        * @param mixed $itemkey Key of the item in the array. Default key is used if null.
        * @return integer Return the number of items in the list.
        */
        function AddItem($item, $itemkey = null)
        {
                end($this->_items);     //Set the array to the end
                if ($itemkey != null)   //Adds the item at specified position
                {
                        $this->_items[$itemkey] = $item;
                }
                else                    //Adds the item as the last one
                {
                        $this->_items[] = $item;
                }
                return($this->Count);
        }

        /**
        * Deletes all of the items from the list control.
        */
        function Clear()
        {
                $this->_items = array();
        }

        /**
        * Return the number of itmes in the radio group.
        * @return integer
        */
        function readCount()                    { return count($this->_items); }
        /**
         * Specifies Border width used to display a control
         * @return integer
         */
        function readBorderWidth()              { return $this->_borderwidth; }
        function writeBorderWidth($value)       { $this->_borderwidth=$value; }
        function defaultBorderWidth()           { return 1; }
        /**
         * Specifies Border color used to display a control
         * @return hex color value
         */
        function readBorderColor()              { return $this->_bordercolor; }
        function writeBorderColor($value)       { $this->_bordercolor=$value; }
        function defaultBorderColor()           { return "#CCCCCC"; }
        /**
         * Specifies Border Style used to display a control
         * @return enum (bsSingle, bsNone)
         */
        function readBorderStyle()              { return $this->_borderstyle; }
        function writeBorderStyle($value)       { $this->_borderstyle=$value; }
        function defaultBorderStyle()           { return bsSingle; }
        /**
        * Occurs when the user clicks the control.
        * @return mixed Returns the event handler or null if no handler is set.
        */
        function readOnClick()                  { return $this->_onclick; }
        /**
        * Occurs when the user clicks the control.
        * @param mixed Event handler or null if no handler is set.
        */
        function writeOnClick($value)           { $this->_onclick = $value; }
        function defaultOnClick()               { return null; }

        /**
        * Occurs when the control was submitted.
        * @return mixed Returns the event handler or null if no handler is set.
        */
        function readOnSubmit()                 { return $this->_onsubmit; }
        /**
        * Occurs when the control was submitted.
        * @param mixed Event handler or null if no handler is set.
        */
        function writeOnSubmit($value)          { $this->_onsubmit=$value; }
        function defaultOnSubmit()              { return null; }

//        function readDataField()              { return $this->_datafield; }
//        function writeDataField($value)       { $this->_datafield = $value; }
//        function defaultDataField()           { return ""; }

//        function readDataSource()             { return $this->_datasource; }
//        function writeDataSource($value)      { $this->_datasource = $this->fixupProperty($value); }
//        function defaultDataSource()          { return null; }

        /**
        * Contains the strings that appear in the radio group.
        * @return array
        */
        function readItems()                    { return $this->_items; }
        /**
        * Contains the strings that appear in the radio group.
        * @param array $value
        */
        function writeItems($value)
        {
                if (is_array($value)) { $this->_items = $value; }
                else  { $this->_items = (empty($value)) ? array() : array($value); }
        }
        function defaultItems()                 { return array(); }

        /**
        * TabOrder indicates in which order controls are access when using
        * the Tab key.
        * The value of the TabOrder can be between 0 and 32767.
        * @return integer
        */
        function readTabOrder()                 { return $this->_taborder; }
        /**
        * TabOrder indicates in which order controls are access when using
        * the Tab key.
        * The value of the TabOrder can be between 0 and 32767.
        * @param integer $value
        */
        function writeTabOrder($value)          { $this->_taborder=$value; }
        function defaultTabOrder()              { return 0; }

        /**
        * Enable or disable the TabOrder property. The browser may still assign
        * a TabOrder by itself internally. This cannot be controlled by HTML.
        * @return bool
        */
        function readTabStop()                  { return $this->_tabstop; }
        /**
        * Enable or disable the TabOrder property. The browser may still assign
        * a TabOrder by itself internally. This cannot be controlled by HTML.
        * @param bool $value
        */
        function writeTabStop($value)           { $this->_tabstop=$value; }
        function defaultTabStop()               { return 1; }
}

/**
* CheckListBox represents a group of checkboxes that function together.
*
* @package ExtCtrls
*/
class CheckListBox extends CustomCheckListBox
{
        /*
        * Publish the events for the CheckBox component
        */
        function getOnClick()                   { return $this->readOnClick(); }
        function setOnClick($value)             { $this->writeOnClick($value); }

        function getOnSubmit()                  { return $this->readOnSubmit(); }
        function setOnSubmit($value)            { $this->writeOnSubmit($value); }

        /*
        * Publish the JS events for the CheckBox component
        */
        function getjsOnBlur()                  { return $this->readjsOnBlur(); }
        function setjsOnBlur($value)            { $this->writejsOnBlur($value); }

        function getjsOnChange()                { return $this->readjsOnChange(); }
        function setjsOnChange($value)          { $this->writejsOnChange($value); }

        function getjsOnClick()                 { return $this->readjsOnClick(); }
        function setjsOnClick($value)           { $this->writejsOnClick($value); }

        function getjsOnDblClick()              { return $this->readjsOnDblClick(); }
        function setjsOnDblClick($value)        { $this->writejsOnDblClick($value); }

        function getjsOnFocus()                 { return $this->readjsOnFocus(); }
        function setjsOnFocus($value)           { $this->writejsOnFocus($value); }

        function getjsOnMouseDown()             { return $this->readjsOnMouseDown(); }
        function setjsOnMouseDown($value)       { $this->writejsOnMouseDown($value); }

        function getjsOnMouseUp()               { return $this->readjsOnMouseUp(); }
        function setjsOnMouseUp($value)         { $this->writejsOnMouseUp($value); }

        function getjsOnMouseOver()             { return $this->readjsOnMouseOver(); }
        function setjsOnMouseOver($value)       { $this->writejsOnMouseOver($value); }

        function getjsOnMouseMove()             { return $this->readjsOnMouseMove(); }
        function setjsOnMouseMove($value)       { $this->writejsOnMouseMove($value); }

        function getjsOnMouseOut()              { return $this->readjsOnMouseOut(); }
        function setjsOnMouseOut($value)        { $this->writejsOnMouseOut($value); }

        function getjsOnKeyPress()              { return $this->readjsOnKeyPress(); }
        function setjsOnKeyPress($value)        { $this->writejsOnKeyPress($value); }

        function getjsOnKeyDown()               { return $this->readjsOnKeyDown(); }
        function setjsOnKeyDown($value)         { $this->writejsOnKeyDown($value); }

        function getjsOnKeyUp()                 { return $this->readjsOnKeyUp(); }
        function setjsOnKeyUp($value)           { $this->writejsOnKeyUp($value); }

        /*
        * Publish the properties for the CheckBox component
        */

        function getAlignment()                 { return $this->readAlignment(); }
        function setAlignment($value)           { $this->writeAlignment($value); }

        function getBorderWidth()               { return $this->readBorderWidth(); }
        function setBorderWidth($value)         { $this->writeBorderWidth($value); }

        function getBorderColor()               { return $this->readBorderColor(); }
        function setBorderColor($value)         { $this->writeBorderColor($value); }

        function getBorderStyle()               { return $this->readBorderStyle(); }
        function setBorderStyle($value)         { $this->writeBorderStyle($value); }

        function getColor()                     { return $this->readColor(); }
        function setColor($value)               { $this->writeColor($value); }

//        function getDataField()                 { return $this->readDataField(); }
//        function setDataField($value)           { $this->writeDataField($value); }

//        function getDataSource()                { return $this->readDataSource(); }
//        function setDataSource($value)          { $this->writeDataSource($value); }

        function getEnabled()                   { return $this->readEnabled(); }
        function setEnabled($value)             { $this->writeEnabled($value); }

        function getFont()                      { return $this->readFont(); }
        function setFont($value)                { $this->writeFont($value); }

        function getItems()                     { return $this->readItems(); }
        function setItems($value)               { $this->writeItems($value); }

        function getParentColor()               { return $this->readParentColor(); }
        function setParentColor($value)         { $this->writeParentColor($value); }

        function getParentFont()                { return $this->readParentFont(); }
        function setParentFont($value)          { $this->writeParentFont($value); }

        function getParentShowHint()            { return $this->readParentShowHint(); }
        function setParentShowHint($value)      { $this->writeParentShowHint($value); }

        function getPopupMenu()                 { return $this->readPopupMenu(); }
        function setPopupMenu($value)           { $this->writePopupMenu($value); }

        function getShowHint()                  { return $this->readShowHint(); }
        function setShowHint($value)            { $this->writeShowHint($value); }

        function getStyle()                     { return $this->readstyle(); }
        function setStyle($value)               { $this->writestyle($value); }

        function getTabOrder()                  { return $this->readTabOrder(); }
        function setTabOrder($value)            { $this->writeTabOrder($value); }

        function getTabStop()                   { return $this->readTabStop(); }
        function setTabStop($value)             { $this->writeTabStop($value); }

        function getVisible()                   { return $this->readVisible(); }
        function setVisible($value)             { $this->writeVisible($value); }
}

?>
