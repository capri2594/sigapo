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
use_unit("db.inc.php");

/**
 *
 * Base class for DynAPI widgets
 *
 * @package StdCtrls
 */
class DWidget extends FocusControl
{
        protected $_DWidgetClassName="";

        function readDWidgetClassName()         { return $this->_DWidgetClassName; }
        function writeDWidgetClassName($value)  { $this->_DWidgetClassName=$value; }

        function dumpHeaderCode()
        {
                if (!defined('DYNAPI'))
                {
                        echo "<script type=\"text/javascript\" src=\""
                           . VCL_HTTP_PATH . "/dynapi/src/dynapi.js\"></script>\n"
                           . "<script type=\"text/javascript\">\n"
                           . "  dynapi.library.setPath('" . VCL_HTTP_PATH . "/dynapi/src/');\n"
                           . "  dynapi.library.include('dynapi.api');\n"
                           . "</script>\n";
                        define('DYNAPI', 1);
                }

                if (!defined('DYNAPI_' . strtoupper($this->className())))
                {
                        echo "<script type=\"text/javascript\">\n"
                             . "  dynapi.library.include('" . $this->DWidgetClassName . "');\n"
                             . "</script>\n";
                        define('DYNAPI_'.strtoupper($this->className()),1);
                }
        }

        function dumpContents()
        {
                echo "<script type=\"text/javascript\">\n"
                   . "  dynapi.document.insertChild(" . $this->Name . ");\n"
                   . "</script>\n";
        }

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);
                $this->ControlStyle="csSlowRedraw=1";
        }
}

function __QLibrary_InitLib()
{
        if (!defined('QOOXDOO'))
        {
                echo "<script type=\"text/javascript\" src=\"" . VCL_HTTP_PATH . "/qooxdoo/framework/script/qx.js\"></script>\n"
                   . "<script type=\"text/javascript\">\n"
                   . "  qx.log.Logger.ROOT_LOGGER.setMinLevel(qx.log.Logger.LEVEL_FATAL);\n"
                   . "  qx.manager.object.AliasManager.getInstance().add(\"static\", \"" . VCL_HTTP_PATH . "/qooxdoo/framework/resource/static/\");\n"
                   . "  qx.manager.object.AliasManager.getInstance().add(\"widget\", \"" . VCL_HTTP_PATH . "/qooxdoo/framework/resource/widget/windows/\");\n"
                   . "  qx.manager.object.AliasManager.getInstance().add(\"icon\", \"" . VCL_HTTP_PATH . "/qooxdoo/framework/resource/icon/VistaInspirate/\");\n"
                   . "</script>\n";

                define('QOOXDOO',1);
        }
}

function __QLibrary_SetCursor($Name, $Cursor)
{
        if ($Cursor !== "")
        {
                switch ($Cursor)
                {
                        case "crPointer":   $cursor="pointer"; break;
                        case "crHand":      $cursor="pointer"; break;
                        case "crCrossHair": $cursor="crosshair"; break;
                        case "crHelp":      $cursor="help"; break;
                        case "crText":      $cursor="text"; break;
                        case "crWait":      $cursor="wait"; break;
                        case "crE-Resize":  $cursor="e-resize"; break;
                        case "crNE-Resize": $cursor="ne-resize"; break;
                        case "crN-Resize":  $cursor="n-resize"; break;
                        case "crNW-Resize": $cursor="nw-resize"; break;
                        case "crW-Resize":  $cursor="w-resize"; break;
                        case "crSW-Resize": $cursor="sw-resize"; break;
                        case "crS-Resize":  $cursor="s-resize"; break;
                        case "crSE-Resize": $cursor="se-resize"; break;
                        case "crAuto":      $cursor="move"; break;
                        default:            $cursor="default"; break;
                }
                echo "  $Name.setCursor(\"$cursor\");\n";
        }
}

/**
 * Base class for qooxdoo widgets
 *
 * @package StdCtrls
 */
class QWidget extends FocusControl
{
        function dumpCommonQWidgetProperties($Name, $FontSupport = 1)
        {
                __QLibrary_SetCursor($Name, $this->Cursor);
                if ($this->Enabled) { $enabled="true"; }
                else                { $enabled="false"; }

                echo "  $Name.setEnabled($enabled);\n";
                if ($FontSupport)
                {
                echo "  $Name.setFont(\"{$this->Font->Size} '{$this->Font->Family}' {$this->Font->Weight}\");\n";
                if ($this->Font->Color != "")
                { echo "  $Name.setColor(new qx.renderer.color.Color('{$this->Font->Color}'));\n"; }
                }

                if (($this->Visible) || (($this->ControlState & csDesigning)==csDesigning))
                { $visible="true"; }
                else
                { $visible="false"; }
                echo "  $Name.setVisibility($visible);\n";
        }

        protected function PrepareQWJSEvent($Name, $event, $eventname)
        {
                if ($event != null)
                {
                        echo "  $Name.addEventListener('$eventname', function(e) { $event(e); });\n";
                }
                }

        function dumpCommonQWidgetJSEvents($Name, $UseOnChangeEvent)
                {
                if (($this->ControlState & csDesigning)!=csDesigning)
                {
                        $this->PrepareQWJSEvent($Name, $this->jsOnActivate, "focusin");
                        $this->PrepareQWJSEvent($Name, $this->jsOnDeActivate, "focusout");
                        $this->PrepareQWJSEvent($Name, $this->jsOnBlur, "blur");
                        $this->PrepareQWJSEvent($Name, $this->jsOnClick, "click");
                        //$this->PrepareQWJSEvent($Name, $this->readjsOnShow, "appear");
                        //$this->PrepareQWJSEvent($Name, $this->jsOnHide, "disappear");
                        $this->PrepareQWJSEvent($Name, $this->jsOnDblClick, "dblclick");
                        $this->PrepareQWJSEvent($Name, $this->jsOnFocus, "focus");
                        $this->PrepareQWJSEvent($Name, $this->jsOnKeyDown, "keydown");
                        $this->PrepareQWJSEvent($Name, $this->jsOnKeyPress, "keypress");
                        $this->PrepareQWJSEvent($Name, $this->jsOnKeyUp, "keyup");
                        $this->PrepareQWJSEvent($Name, $this->jsOnMouseDown, "mousedown");
                        $this->PrepareQWJSEvent($Name, $this->jsOnMouseUp, "mouseup");
                        $this->PrepareQWJSEvent($Name, $this->jsOnMouseMove, "mousemove");
                        $this->PrepareQWJSEvent($Name, $this->jsOnMouseOut, "mouseout");
                        $this->PrepareQWJSEvent($Name, $this->jsOnMouseOver, "mouseover");

                        // Special events
                        if (($this->jsOnContextMenu != null) || ($this->PopupMenu != null))
                        {
                                echo "  $Name.addEventListener('contextmenu', function(e) {";
                                if ($this->jsOnContextMenu != null) echo " $this->jsOnContextMenu(e);";
                                if ($this->PopupMenu != null)       echo " Show" . $this->PopupMenu->Name . "(e, 1);";
                                echo " });\n";
                }
                        if ($this->jsOnChange != null)
                {
                                switch ($UseOnChangeEvent)
                                {
                                        case 1:
                                                $event = "keyup";
                                                break;
                                        case 2:
                                                $event = "change";
                                                break;
                                        default:
                                                $event = "";
                                                break;
                                }
                                if ($event !== "")
                                {
                                        echo "  $Name.addEventListener('$event', function(e) { $this->jsOnChange(e); });\n";
                                }
                        }
                }
        }

        function dumpHeaderCode()
        {
                if (($this->ControlState & csDesigning)==csDesigning)
                { echo "<html>\n<head>\n"; }
                __QLibrary_InitLib();
                if (($this->ControlState & csDesigning)==csDesigning)
                { echo "</head>\n"; }
        }

        /**
         * Dump the common qooxdoo initialization code
         *
         */
        function dumpCommonContentsTop()
        {
                //In design mode, this component needs a body
                if (($this->ControlState & csDesigning)==csDesigning)
                {
                        echo '<body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" >';
                }

                echo "<input type=\"hidden\" id=\"$this->Name"."_state\" name=\"$this->Name"."_state\" value=\"\" />\n";

                if ((($this->ControlState & csDesigning)==csDesigning) || (($this->Parent!=null) && (!$this->Parent->inheritsFrom("QWidget"))))
                {
                        //Creates the div
                        echo "<div id=\"$this->Name\"></div>\n"
                           . "<script type=\"text/javascript\">\n"
                           . "  var d = qx.ui.core.ClientDocument.getInstance();\n"
                           . "  var inline_div = new qx.ui.basic.Inline(\"$this->Name\");\n"
                           . "  inline_div.setHeight(\"auto\");\n"
                           . "  inline_div.setWidth(\"auto\");\n\n";
                        //   . "  d.setOverflow(\"scrollY\");\n"
                        //   . "  d.setBackgroundColor(null);\n"
                }
                else
                {
                        echo "<script type=\"text/javascript\">\n";
                }
        }

        /**
         * Dump common qooxdoo finalization code
         *
         */
        function dumpCommonContentsBottom()
        {
                if ((($this->ControlState & csDesigning)==csDesigning) || (($this->Parent!=null) && (!$this->Parent->inheritsFrom("QWidget"))))
                {
                echo "  d.add(inline_div);\n"
                   . "  inline_div.add($this->Name);\n"
                   . "</script>\n";
                }
                else
                {
                        echo "</script>\n";
                }

                if (($this->ControlState & csDesigning)==csDesigning)
                {
                        echo "</body>\n";
                        echo "</html>\n";
                }
        }

        /**
        * Code to dump when the Widget accepts children controls.
        */
        function dumpChildrenControls($topoffset=0, $leftoffset=0, $ownername="", $layer="")
        {
                $aowner=$this->Name;
                if ($ownername!="") $aowner=$ownername;

                $js="";
                reset($this->controls->items);
                while (list($k,$v)=each($this->controls->items))
                {
                                if ($v->Layer==$layer)
                                {
                                if ($v->inheritsFrom("QWidget"))
                                {
                                        echo "</script>";
                                        $v->show();
                                        echo "<script type=\"text/javascript\">\n";
                                echo "  $v->Name.setLeft(".($v->Left+$leftoffset).");\n";
                                echo "  $v->Name.setTop(".($v->Top+$topoffset).");\n";
                                echo "  $aowner.add($v->Name);\n";
                                }
                                else
                                {
                                echo "  var container = new qx.ui.basic.Atom(\"";
                                ob_start();
                                $v->show();
                                $c=ob_get_contents();
                                $c=extractjscript($c);
                                $js.=$c[0];
                                $html=$c[1];
                                ob_end_clean();

                                echo str_replace("\r",'',str_replace("\n",'',str_replace('"','\"', $html)));
                                echo "\");\n";
                                echo "  container.setLeft(".($v->Left+$leftoffset).");\n";
                                echo "  container.setTop(".($v->Top+$topoffset).");\n";
                                echo "  container.setWidth($v->Width);\n";
                                echo "  container.setHeight($v->Height);\n";
                                echo "  $aowner.add(container);\n";
                                }
                                }
                }
                return($js);
        }

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

               //For mapshapes
                $this->ControlStyle="csTopOffset=1";
                $this->ControlStyle="csLeftOffset=1";
                $this->ControlStyle="csSlowRedraw=1";
        }

}

/**
 * CustomLabel class
 *
 * CustomLabel is the base class for controls that display text on a form.
 * The Caption of the CustomLabel may contain HTML formatted text.
 *
 * @package StdCtrls
 */
class CustomLabel extends GraphicControl
{
        protected $_datasource = null;
        protected $_datafield = "";
        protected $_link = "";
        protected $_linktarget = "";
        protected $_wordwrap = 1;

        protected $_onclick = null;
        protected $_ondblclick = null;


        function __construct($aowner = null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width = 75;
                $this->Height = 13;
                $this->ControlStyle="csRenderOwner=1";
                $this->ControlStyle="csRenderAlso=StyleSheet";
        }

        function init()
        {
                parent::init();

                $submitEventValue = $this->input->{$this->getJSWrapperHiddenFieldName()};

                if (is_object($submitEventValue))
                {
                        // check if the a click event has been fired
                        if ($this->_onclick != null && $submitEventValue->asString() == $this->getJSWrapperSubmitEventValue($this->_onclick))
                        {
                                $this->callEvent('onclick', array());
                        }
                        // check if the a double-click event has been fired
                        if ($this->_ondblclick != null && $submitEventValue->asString() == $this->getJSWrapperSubmitEventValue($this->_ondblclick))
                        {
                                $this->callEvent('ondblclick', array());
                        }
                }
        }

        function loaded()
        {
                parent::loaded();
                // call writeDataSource() since setDataSource() might not be implemented by the sub-class
                $this->writeDataSource($this->_datasource);
        }

        function dumpContents()
        {
                // get the string for the JS Events
                $events = $this->readJsEvents();

                // add or replace the JS events with the wrappers if necessary
                $this->addJSWrapperToEvents($events, $this->_onclick,    $this->_jsonclick,    "onclick");
                $this->addJSWrapperToEvents($events, $this->_ondblclick, $this->_jsondblclick, "ondblclick");

                $style="";
                if ($this->Style=="")
                {
                    // get the Font attributes
                    $style = $this->Font->FontString;

                    if ((($this->ControlState & csDesigning) == csDesigning) && ($this->_designcolor != ""))
                    {
                            $style .= "background-color: " . $this->_designcolor . ";";
                    }
                    else
                    {
                            $color = $this->_color;
                            if ($color != "")
                            {
                                    $style .= "background-color: " . $color . ";";
                            }
                    }

                    // add the cursor to the style
                    if ($this->_cursor != "")
                    {
                            $cr = strtolower(substr($this->_cursor, 2));
                            $style .= "cursor: $cr;";
                    }
                }

                // set height and width to the style attribute
                if (!$this->_adjusttolayout)
                {
                    $style .= "height:" . $this->Height . "px;width:" . $this->Width . "px;";
                }
                else
                {
                    $style .= "height:100%;width:100%;";
                }

                if (!$this->_wordwrap)
                {
                        $style .= "white-space: nowrap; ";
                }

                if ($style != "")  $style = "style=\"$style\"";

                // get the alignment of the Caption inside the <div>
                $alignment = "";
                switch ($this->_alignment)
                {
                        case agNone :
                                $alignment = "";
                                break;
                        case agLeft :
                                $alignment = " align=\"Left\" ";
                                break;
                        case agCenter :
                                $alignment = " align=\"Center\" ";
                                break;
                        case agRight :
                                $alignment = " align=\"Right\" ";
                                break;
                }

                // get the hint attribute; returns: title="[HintText]"
                $hint = $this->getHintAttribute();

                $target="";
                if (trim($this->LinkTarget)!="") $target="target=\"$this->LinkTarget\"";

                $class = ($this->Style != "") ? "class=\"$this->StyleClass\"" : "";

                echo "<div id=\"$this->_name\" $style $alignment $hint $class";

                if ($this->_link=="") echo "$events";

                echo ">";

                if ($this->_link != "")  echo "<A HREF=\"$this->_link\" $target $events>";

                if (($this->ControlState & csDesigning) != csDesigning)
                {
                        if ($this->hasValidDataField())
                        {
                                //The value to show on the field is the one from the table
                                $this->Caption = $this->readDataFieldValue();
                                // dump no hidden fields since the label is read-only
                        }
                }


                if ($this->_onshow != null)
                {
                        $this->callEvent('onshow', array());
                }
                else
                {
                        $caption = $this->_caption;
                        // If a link is defined strip all other links defined in the caption
                        // Reason: Nested links are illegal
                        if ($this->_link != "")
                        {
                                $caption = $this->strip_selected_tags($caption, array("a"));
                        }

                        echo $caption;
                }

                if ($this->_link != "")  echo "</A>";

                // add a hidden field so we can determine which event for the label was fired
                if ($this->_onclick != null || $this->_ondblclick != null)
                {
                        $hiddenwrapperfield = $this->getJSWrapperHiddenFieldName();
                        echo "<input type=\"hidden\" id=\"$hiddenwrapperfield\" name=\"$hiddenwrapperfield\" value=\"\" />";
                }

                echo "</div>";
        }

        function dumpJavascript()
        {
                parent::dumpJavascript();

                if ($this->_onclick != null && !defined($this->_onclick))
                {
                        // only output the same function once;
                        // otherwise if for example two labels use the same
                        // OnClick event handler it would be outputted twice.
                        $def=$this->_onclick;
                        define($def,1);

                        // output the wrapper function
                        echo $this->getJSWrapperFunction($this->_onclick);
                }

                if ($this->_ondblclick != null && !defined($this->_ondblclick))
                {
                        $def=$this->_ondblclick;
                        define($def,1);

                        // output the wrapper function
                        echo $this->getJSWrapperFunction($this->_ondblclick);
                }
        }



        /**
        * Helper function to strip selected tags.
        * This function will also replace self-closing tags (XHTML <br /> <hr />)
        * and will work if the text contains line breaks.
        *
        * @autor Bermi Ferrer @ http://www.php.net/manual/en/function.strip-tags.php
        *
        * @param string $text Text that may contain the tags to strip.
        * @param array $tags All tags that should be stripped from $text.
        * @return string Returns $text without the defined $tags.
        */
        protected function strip_selected_tags($text, $tags = array())
        {
                $args = func_get_args();
                $text = array_shift($args);
                $tags = func_num_args() > 2 ? array_diff($args,array($text))  : (array)$tags;
                foreach ($tags as $tag){
                        if( preg_match_all( '/<'.$tag.'[^>]*>([^<]*)<\/'.$tag.'>/iu', $text, $found) ){
                                $text = str_replace($found[0],$found[1],$text);
                        }
                }

                return preg_replace( '/(<('.join('|',$tags).')(\\n|\\r|.)*\/>)/iu', '', $text);
        }

        /**
        * Occurs when the user clicks the control.
        * @return mixed Returns the event handler or null if no handler is set.
        */
        function readOnClick()
        {
                return $this->_onclick;
        }
        /**
        * Occurs when the user clicks the control.
        * @param mixed $value Event handler or null to unset.
        */
        function writeOnClick($value)
        {
                $this->_onclick = $value;
        }
        function defaultOnClick()
        {
                return null;
        }

        /**
        * Occurs when the user double clicks the control.
        * @return mixed Returns the event handler or null if no handler is set.
        */
        function readOnDblClick()
        {
                return $this->_ondblclick;
        }
        /**
        * Occurs when the user double clicks the control.
        * @param mixed $value Event handler or null to unset.
        */
        function writeOnDblClick($value)
        {
                $this->_ondblclick = $value;
        }
        function defaultOnDblClick()
        {
                return null;
        }

        /**
        * DataField indicates which field of the DataSource is used to fill in
        * the Caption.
        * @return string Returns the data field.
        */
        function readDataField()
        {
                return $this->_datafield;
        }
        /**
        * DataField indicates which field of the DataSource is used to fill in
        * the Caption.
        * @param string $value Data field
        */
        function writeDataField($value)
        {
                $this->_datafield = $value;
        }
        function defaultDataField()
        {
                return "";
        }

        /**
        * DataSource indicates the source where the Caption is read from.
        * The label is read-only meaning it does not update any data in the data source.
        * @return mixed Data source object or null if not used.
        */
        function readDataSource()
        {
                return $this->_datasource;
        }
        /**
        * DataSource indicates the source where the Caption is read from.
        * The label is read-only meaning it does not update any data in the data source.
        * @param mixed $value Data source object or null if not used.
        */
        function writeDataSource($value)
        {
                $this->_datasource=$this->fixupProperty($value);
        }
        function defaultDataSource()
        {
                return null;
        }

        /**
        * If Link is set the Caption is rendered as a link.
        * @return string Link, if empty string the link is not used.
        */
        function readLink()
        {
                return $this->_link;
        }
        /**
        * If Link is set the Caption is rendered as a link.
        * @value string $value Link, if empty string the link is not used.
        */
        function writeLink($value)
        {
                $this->_link = $value;
        }
        function defaultLink()
        {
                return "";
        }

        /**
        * Target attribute when the label acts as a link.
        * @link http://www.w3.org/TR/html4/present/frames.html#adef-target
        * @return string The link target as defined by the HTML specs.
        */
        function readLinkTarget() { return $this->_linktarget; }
        /**
        * Target attribute when the label acts as a link.
        * @link http://www.w3.org/TR/html4/present/frames.html#adef-target
        * @param string $value The link target as defined by the HTML specs.
        */
        function writeLinkTarget($value) { $this->_linktarget=$value; }
        function defaultLinkTarget() { return ""; }

        /**
        * Specifies whether the label text wraps when it is too long
        * for the width of the label.
        * @return bool True if word wrap is enabled, false otherwise.
        */
        function readWordWrap()
        {
                return $this->_wordwrap;
        }
        /**
        * Specifies whether the label text wraps when it is too long
        * for the width of the label.
        *
        * Note: white-space: nowrap; is applied to the <div> of the label.
        *
        * @param bool $value True if word wrap is enabled, false otherwise.
        */
        function writeWordWrap($value)
        {
                $this->_wordwrap = $value;
        }
        function defaultWordWrap()
        {
                return 1;
        }
}


/**
* Label class derived from CustomLabel.
*
* @package StdCtrls
*/
class Label extends CustomLabel
{
        /*
        * Publish the events for the Label component
        */
        function getOnClick                     () { return $this->readOnClick(); }
        function setOnClick                     ($value) { $this->writeOnClick($value); }

        function getOnDblClick                  () { return $this->readOnDblClick(); }
        function setOnDblClick                  ($value) { $this->writeOnDblClick($value); }

        /*
        * Publish the JS events for the Label component
        */
        function getjsOnClick                   () { return $this->readjsOnClick(); }
        function setjsOnClick                   ($value) { $this->writejsOnClick($value); }

        function getjsOnDblClick                () { return $this->readjsOnDblClick(); }
        function setjsOnDblClick                ($value) { $this->writejsOnDblClick($value); }

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


        /*
        * Publish the properties for the Label component
        */

        function getAlignment()
        {
                return $this->readAlignment();
        }
        function setAlignment($value)
        {
                $this->writeAlignment($value);
        }

        function getCaption()
        {
                return $this->readCaption();
        }
        function setCaption($value)
        {
                $this->writeCaption($value);
        }

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

        function getDesignColor()
        {
                return $this->readDesignColor();
        }
        function setDesignColor($value)
        {
                $this->writeDesignColor($value);
        }

        function getFont()
        {
                return $this->readFont();
        }
        function setFont($value)
        {
                $this->writeFont($value);
        }

        function getLink()
        {
                return $this->readLink();
        }
        function setLink($value)
        {
                $this->writeLink($value);
        }

        function getLinkTarget()
        {
                return $this->readLinkTarget();
        }
        function setLinkTarget($value)
        {
                $this->writeLinkTarget($value);
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

        function getStyle()             { return $this->readstyle(); }
        function setStyle($value)       { $this->writestyle($value); }

        function getVisible()
        {
                return $this->readVisible();
        }
        function setVisible($value)
        {
                $this->writeVisible($value);
        }

        function getWordWrap()
        {
                return $this->readWordWrap();
        }
        function setWordWrap($value)
        {
                $this->writeWordWrap($value);
        }
}


// BorderStyles
define('bsNone', 'bsNone');
define('bsSingle', 'bsSingle');

// CharCase
define('ecLowerCase', 'ecLowerCase');
define('ecNormal', 'ecNormal');
define('ecUpperCase', 'ecUpperCase');

/**
 * CustomEdit class
 *
 * Base class for Edit controls.
 * It allows to enter text in a single-line.
 * The Edit control only accepts plain text. All HTML tags are stripped.
 *
 * @package StdCtrls
 */
class CustomEdit extends FocusControl
{
        protected $_onclick = null;
        protected $_ondblclick = null;
        protected $_onsubmit=null;

        protected $_jsonselect=null;

        protected $_borderstyle=bsSingle;
        protected $_datasource = null;
        protected $_datafield = "";
        protected $_charcase=ecNormal;
        protected $_ispassword = 0;
        protected $_maxlength=0;
        protected $_taborder=0;
        protected $_tabstop=1;
        protected $_text="";
        protected $_readonly=0;


        function __construct($aowner = null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width = 121;
                $this->Height = 21;
                $this->ControlStyle="csRenderOwner=1";
                $this->ControlStyle="csRenderAlso=StyleSheet";
        }

        function loaded()
        {
                parent::loaded();
                // use writeDataSource() since setDataSource() might be implemented in the sub-component
                $this->writeDataSource($this->_datasource);
        }

        function preinit()
        {
                //If there is something posted
                $submitted = $this->input->{$this->Name};
                if (is_object($submitted))
                {
                        //Get the value and set the text field
                        $this->_text = $submitted->asString();

                        //If there is any valid DataField attached, update it
                        $this->updateDataField($this->_text);
                }
        }

        function init()
        {
                parent::init();

                $submitted = $this->input->{$this->Name};

                // Allow the OnSubmit event to be fired because it is not
                // a mouse or keyboard event.
                if ($this->_onsubmit != null && is_object($submitted))
                {
                        $this->callEvent('onsubmit', array());
                }

                $submitEvent = $this->input->{$this->getJSWrapperHiddenFieldName()};

                if (is_object($submitEvent) && $this->_enabled == 1)
                {
                        // check if the a click event has been fired
                        if ($this->_onclick != null && $submitEvent->asString() == $this->getJSWrapperSubmitEventValue($this->_onclick))
                        {
                                $this->callEvent('onclick', array());
                        }
                        // check if the a double-click event has been fired
                        if ($this->_ondblclick != null && $submitEvent->asString() == $this->getJSWrapperSubmitEventValue($this->_ondblclick))
                        {
                                $this->callEvent('ondblclick', array());
                        }
                }
        }

        /**
        * Get the common HTML tag attributes of a Edit control.
        * @return string Returns a string with the attributes.
        */
        protected function getCommonAttributes()
        {
                $events = "";
                if ($this->_enabled == 1)
                {
                        // get the string for the JS Events
                        $events = $this->readJsEvents();

                        // add the OnSelect JS-Event
                        if ($this->_jsonselect != null)
                        {
                                $events .= " onselect=\"return $this->_jsonselect(event)\" ";
                        }

                        // add or replace the JS events with the wrappers if necessary
                        $this->addJSWrapperToEvents($events, $this->_onclick,    $this->_jsonclick,    "onclick");
                        $this->addJSWrapperToEvents($events, $this->_ondblclick, $this->_jsondblclick, "ondblclick");
                }

                // set enabled/disabled status
                $disabled = (!$this->_enabled) ? "disabled" : "";

                // set maxlength if bigger than 0
                $maxlength = ($this->_maxlength > 0) ? "maxlength=$this->_maxlength" : "";

                // set readonly attribute if true
                $readonly = ($this->_readonly == 1) ? "readonly" : "";

                // set tab order if tab stop set to true
                $taborder = ($this->_tabstop == 1) ? "tabindex=\"$this->_taborder\"" : "";

                $class = ($this->Style != "") ? "class=\"$this->StyleClass\"" : "";

                // get the hint attribute; returns: title="[HintText]"
                $hint = $this->getHintAttribute();

                return "$disabled $maxlength $readonly $taborder $hint $events $class";
        }

        /**
        * Get the common styles of a Edit control.
        * @return string Returns a string with the common styles. It is not wrapped
        *                in the style="" attribute.
        */
        protected function getCommonStyles()
        {
                $style = "";
                if ($this->Style=="")
                {
                        $style .= $this->Font->FontString;

                        // set the no border style
                        if ($this->_borderstyle == bsNone)
                        {
                                $style .= "border-width: 0px; border-style: none;";
                        }

                        if ($this->Color != "")
                        {
                                $style .= "background-color: " . $this->Color . ";";
                        }

                        // add the cursor to the style
                        if ($this->_cursor != "")
                        {
                                $cr = strtolower(substr($this->_cursor, 2));
                                $style .= "cursor: $cr;";
                        }

                        // set the char case if not normal
                        if ($this->_charcase != ecNormal)
                        {
                                if ($this->_charcase == ecLowerCase)
                                {
                                        $style .= "text-transform: lowercase;";
                                }
                                else if ($this->_charcase == ecUpperCase)
                                {
                                        $style .= "text-transform: uppercase;";
                                }
                        }
                }

                $h = $this->Height - 1;
                $w = $this->Width;

                $style .= "height:" . $h . "px;width:" . $w . "px;";

                return $style;
        }

        function dumpContents()
        {
                // set type depending on $_ispassword
                $type = ($this->_ispassword) ? 'password' : 'text';

                $attributes = $this->getCommonAttributes();
                $style = $this->getCommonStyles();

                if ($style != "")  $style = "style=\"$style\"";

                if (($this->ControlState & csDesigning) != csDesigning)
                {
                        if ($this->hasValidDataField())
                        {
                                //The value to show on the field is the one from the table
                                $this->_text = $this->readDataFieldValue();

                                //Dumps hidden fields to know which is the record to update
                                $this->dumpHiddenKeyFields();
                        }
                }

                // call the OnShow event if assigned so the Text property can be changed
                if ($this->_onshow != null)
                {
                        $this->callEvent('onshow', array());
                }

                echo "<input type=\"$type\" id=\"$this->_name\" name=\"$this->_name\" value=\"$this->_text\" $style $attributes />";

                // add a hidden field so we can determine which event for the edit was fired
                if ($this->_onclick != null || $this->_ondblclick != null)
                {
                        $hiddenwrapperfield = $this->getJSWrapperHiddenFieldName();
                        echo "<input type=\"hidden\" id=\"$hiddenwrapperfield\" name=\"$hiddenwrapperfield\" value=\"\" />";
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
                                // otherwise if for example two edits use the same
                                // OnClick event handler it would be outputted twice.
                                $def=$this->_onclick;
                                define($def,1);

                                // output the wrapper function
                                echo $this->getJSWrapperFunction($this->_onclick);
                        }

                        if ($this->_ondblclick != null && !defined($this->_ondblclick))
                        {
                                $def=$this->_ondblclick;
                                define($def,1);

                                // output the wrapper function
                                echo $this->getJSWrapperFunction($this->_ondblclick);
                        }

                        if ($this->_jsonselect != null)
                        {
                                $this->dumpJSEvent($this->_jsonselect);
                        }
                }
        }



        /**
        * Occurs when the user clicks the control.
        * @return mixed Returns the event handler or null if no handler is set.
        */
        function readOnClick()
        {
                return $this->_onclick;
        }
        /**
        * Occurs when the user clicks the control.
        * @param mixed Event handler or null if no handler is set.
        */
        function writeOnClick($value)
        {
                $this->_onclick = $value;
        }
        function defaultOnClick()
        {
                return null;
        }

        /**
        * Occurs when the user double-clicks the control.
        * @return mixed Returns the event handler or null if no handler is set.
        */
        function readOnDblClick()
        {
                return $this->_ondblclick;
        }
        /**
        * Occurs when the user double-clicks the control.
        * @param mixed Event handler or null if no handler is set.
        */
        function writeOnDblClick($value)
        {
                $this->_ondblclick = $value;
        }
        function defaultOnDblClick()
        {
                return null;
        }

        /**
        * Occurs when the form containing the control was submitted.
        * @return mixed Returns the event handler or null if no handler is set.
        */
        function readOnSubmit() { return $this->_onsubmit; }
        /**
        * Occurs when the form containing the control was submitted.
        * @param mixed Event handler or null if no handler is set.
        */
        function writeOnSubmit($value) { $this->_onsubmit=$value; }
        function defaultOnSubmit() { return null; }


        /**
        * JS Event occurs when text in the control was selected.
        * @return mixed Returns the event handler or null if no handler is set.
        */
        function readjsOnSelect() { return $this->_jsonselect; }
        /**
        * JS Event occurs when text in the control was selected.
        * @param mixed Event handler or null if no handler is set.
        */
        function writejsOnSelect($value) { $this->_jsonselect=$value; }
        function defaultjsOnSelect() { return null; }


        /**
        * Determines whether the edit control has a single line border around the client area.
        * @return enum (bsNone, bsSingle)
        */
        function readBorderStyle() { return $this->_borderstyle; }
        /**
        * Determines whether the edit control has a single line border around the client area.
        * @param enum $value (bsNone, bsSingle)
        */
        function writeBorderStyle($value) { $this->_borderstyle=$value; }
        function defaultBorderStyle() { return bsSingle; }

        /**
        * DataField indicates which field of the DataSource is used to fill in
        * the Text.
        */
        function readDataField() { return $this->_datafield; }
        /**
        * DataField indicates which field of the DataSource is used to fill in
        * the Text.
        */
        function writeDataField($value) { $this->_datafield = $value; }
        function defaultDataField() { return ""; }

        /**
        * DataSource indicates the source where the Text is read from.
        */
        function readDataSource() { return $this->_datasource; }
        /**
        * DataSource indicates the source where the Text is read from.
        */
        function writeDataSource($value)
        {
                $this->_datasource = $this->fixupProperty($value);
        }
        function defaultDataSource() { return null; }

        /**
        * Determines the case of the text within the edit control.
        * Note: When CharCase is set to ecLowerCase or ecUpperCase,
        *       the case of characters is converted as the user types them
        *       into the edit control. Changing the CharCase property to
        *       ecLowerCase or ecUpperCase changes the actual contents
        *       of the text, not just the appearance. Any case information
        *       is lost and can’t be recaptured by changing CharCase to ecNormal.
        * @return enum (ecLowerCase, ecNormal, ecUpperCase)
        */
        function readCharCase() { return $this->_charcase; }
        /**
        * Determines the case of the text within the edit control.
        * Note: When CharCase is set to ecLowerCase or ecUpperCase,
        *       the case of characters is converted as the user types them
        *       into the edit control. Changing the CharCase property to
        *       ecLowerCase or ecUpperCase changes the actual contents
        *       of the text, not just the appearance. Any case information
        *       is lost and can’t be recaptured by changing CharCase to ecNormal.
        * @value enum $value (ecLowerCase, ecNormal, ecUpperCase)
        */
        function writeCharCase($value)
        {
                $this->_charcase=$value;
                if ($this->_charcase == ecUpperCase)
                {
                        $this->_text = strtoupper($this->_text);
                }
                else if ($this->_charcase == ecUpperCase)
                {
                        $this->_text = strtolower($this->_text);
                }
        }
        function defaultCharCase() { return ecNormal; }

        /**
        * If IsPassword is true then all characters are displayed with a password
        * character defined by the browser.
        * Note: The text is still in readable text in the HTML page!
        * @return bool
        */
        function readIsPassword() { return $this->_ispassword; }
        /**
        * If IsPassword is true then all characters are displayed with a password
        * character defined by the browser.
        * Note: The text is still in readable text in the HTML page!
        * @param bool $value
        */
        function writeIsPassword($value) { $this->_ispassword = $value; }
        function defaultIsPassword() { return 0; }

        /**
        * Specifies the maximum number of characters the user can enter into
        * the edit control. A value of 0 indicates that there is no
        * application-defined limit on the length.
        * @return integer
        */
        function readMaxLength() { return $this->_maxlength; }
        /**
        * Specifies the maximum number of characters the user can enter into
        * the edit control. A value of 0 indicates that there is no
        * application-defined limit on the length.
        * @param integer $value
        */
        function writeMaxLength($value) { $this->_maxlength=$value; }
        function defaultMaxLength() { return 0; }

        /**
        * Set the control to read-only mode. That way the user cannot enter
        * or change the text of the edit control.
        * @return bool
        */
        function readReadOnly() { return $this->_readonly; }
        /**
        * Set the control to read-only mode. That way the user cannot enter
        * or change the text of the edit control.
        * @param bool $value
        */
        function writeReadOnly($value) { $this->_readonly=$value; }
        function defaultReadOnly() { return 0; }

        /**
        * TabOrder indicates in which order controls are access when using
        * the Tab key.
        * The value of the TabOrder can be between 0 and 32767.
        * @return integer
        */
        function readTabOrder() { return $this->_taborder; }
        /**
        * TabOrder indicates in which order controls are access when using
        * the Tab key.
        * The value of the TabOrder can be between 0 and 32767.
        * @param integer $value
        */
        function writeTabOrder($value) { $this->_taborder=$value; }
        function defaultTabOrder() { return 0; }

        /**
        * Enable or disable the TabOrder property. The browser may still assign
        * a TabOrder by itself internally. This cannot be controlled by HTML.
        * @return bool
        */
        function readTabStop() { return $this->_tabstop; }
        /**
        * Enable or disable the TabOrder property. The browser may still assign
        * a TabOrder by itself internally. This cannot be controlled by HTML.
        * @param bool $value
        */
        function writeTabStop($value) { $this->_tabstop=$value; }
        function defaultTabStop() { return 1; }

        /**
        * Contains the text string associated with the control.
        * Only plain text is accepted, all tags are stripped.
        * @return string
        */
        function readText() { return $this->_text; }
        /**
        * Contains the text string associated with the control.
        * Only plain text is accepted, all tags are stripped.
        * @param string $value
        */
        function writeText($value) { $this->_text=$value; }
        function defaultText() { return ""; }

}

/**
 * Edit class
 *
 * Edit publishes many of the properties inherited from CustomEdit,
 * but does not introduce any new behavior. For specialized edit controls,
 * use other descendant classes of CustomEdit or derive from it.
 *
 * @package StdCtrls
 */
class Edit extends CustomEdit
{
        /*
        * Publish the events for the Edit component
        */
        function getOnClick                     () { return $this->readOnClick(); }
        function setOnClick                     ($value) { $this->writeOnClick($value); }

        function getOnDblClick                  () { return $this->readOnDblClick(); }
        function setOnDblClick                  ($value) { $this->writeOnDblClick($value); }

        function getOnSubmit                    () { return $this->readOnSubmit(); }
        function setOnSubmit                    ($value) { $this->writeOnSubmit($value); }

        /*
        * Publish the JS events for the Edit component
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
        function getBorderStyle()
        {
                return $this->readBorderStyle();
        }
        function setBorderStyle($value)
        {
                $this->writeBorderStyle($value);
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

        function getCharCase()
        {
                return $this->readCharCase();
        }
        function setCharCase($value)
        {
                $this->writeCharCase($value);
        }

        function getColor()
        {
                return $this->readColor();
        }
        function setColor($value)
        {
                $this->writeColor($value);
        }

        function getEnabled()
        {
                return $this->readEnabled();
        }
        function setEnabled($value)
        {
                $this->writeEnabled($value);
        }

        function getFont()
        {
                return $this->readFont();
        }
        function setFont($value)
        {
                $this->writeFont($value);
        }

        function getIsPassword()
        {
                return $this->readIsPassword();
        }
        function setIsPassword($value)
        {
                $this->writeIsPassword($value);
        }

        function getMaxLength()
        {
                return $this->readMaxLength();
        }
        function setMaxLength($value)
        {
                $this->writeMaxLength($value);
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

        function getReadOnly()
        {
                return $this->readReadOnly();
        }
        function setReadOnly($value)
        {
                $this->writeReadOnly($value);
        }

        function getShowHint()
        {
                return $this->readShowHint();
        }
        function setShowHint($value)
        {
                $this->writeShowHint($value);
        }

        function getStyle()             { return $this->readstyle(); }
        function setStyle($value)       { $this->writestyle($value); }

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

        function getText()
        {
                return $this->readText();
        }
        function setText($value)
        {
                $this->writeText($value);
        }

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
 * CustomMemo class
 *
 * CustomMemo is the base class for memo components, which are multiline edit boxes,
 * including Memo.
 *
 * It is inherited from CustomEdit and introduces following new properties:
 * Lines, LineSeparator, Text and WordWrap
 *
 * @package StdCtrls
 */
class CustomMemo extends CustomEdit
{
        public $_lines = array();
        // The $_lineseparator variable should always be double quoted!!!
        protected $_lineseparator = "\n";
        protected $_wordwrap = 1;
        // The richeditor property is here since it is used in the loaded() function.
        // loaded() needs to know how to treat the input data.
        // Note: Do not publish this variable!
        protected $_richeditor = 0;


        function __construct($aowner = null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width = 185;
                $this->Height = 89;
        }

        function preinit()
        {
                //If there is something posted
                $submitted = $this->input->{$this->Name};
                if (is_object($submitted))
                {
                        // Escape the posted string if sent from a richeditor;
                        // otherwise all tags are stripped and plain text is written to Text
                        $this->Text = ($this->_richeditor) ? $submitted->asSpecialChars() : $submitted->asString();

                        //If there is any valid DataField attached, update it
                        $this->updateDataField($this->Text);
                }
        }

        function dumpContents()
        {
                // get the common attributes from the CustomEdit
                $attributes = $this->getCommonAttributes();

                // add the word wrap attribute if set
                $attributes .= ($this->_wordwrap == 1) ? " wrap=\"virtual\"" : " wrap=\"off\"";

                // maxlength has to be check with some JS; it's not supported by HTML 4.0
                if ($this->_enabled && $this->_maxlength > 0)
                {
                        if ($this->_jsonkeyup != null)
                        {
                                $attributes = str_replace("onkeyup=\"return $this->_jsonkeyup(event)\"",
                                                  "onkeyup=\"return checkMaxLength(this, event, $this->_jsonkeyup)\"",
                                                  $attributes);
                        }
                        else
                        {
                                $attributes .= " onkeyup=\"return checkMaxLength(this, event, null)\"";
                        }
                }

                // get the common styles from the CustomEdit
                $style = $this->getCommonStyles();

                if ($style != "")  $style = "style=\"$style\"";

                // if a datasource is set then get the data from there
                if (($this->ControlState & csDesigning) != csDesigning)
                {
                        if ($this->hasValidDataField())
                        {
                                //The value to show on the field is the one from the table
                                $this->Text = $this->readDataFieldValue();
                                //Dumps hidden fields to know which is the record to update
                                $this->dumpHiddenKeyFields();
                        }
                }

                // call the OnShow event if assigned so the Lines property can be changed
                if ($this->_onshow != null)
                {
                        $this->callEvent('onshow', array());
                }

                $lines = $this->Text;

                echo "<textarea id=\"$this->_name\" name=\"$this->_name\" $style $attributes>$lines</textarea>";

                // add a hidden field so we can determine which event for the memo was fired
                if ($this->_onclick != null || $this->_ondblclick != null)
                {
                        $hiddenwrapperfield = $this->getJSWrapperHiddenFieldName();
                        echo "<input type=\"hidden\" id=\"$hiddenwrapperfield\" name=\"$hiddenwrapperfield\" value=\"\" />";
                }
        }

        function dumpJavascript()
        {
                parent::dumpJavascript();

                // only add this function once
                if (!defined('checkMaxLength') && $this->_enabled && $this->_maxlength > 0)
                {
                        define('checkMaxLength', 1);

                        echo "
function checkMaxLength(obj, event, onKeyUpFunc){
  var maxlength = obj.getAttribute ? parseInt(obj.getAttribute(\"maxlength\")) : \"\";
  if (obj.getAttribute && obj.value.length > maxlength)
    obj.value = obj.value.substring(0, maxlength);
  if (onKeyUpFunc != null)
    onKeyUpFunc(event);
}
";
                }
        }

        /**
        * Add a new line to the Memo. Calls AddLine().
        * @param $line string The content of the new line.
        * @return integer Returns the number of lines defined.
        */
        function Add($line)
        {
                return $this->AddLine($line);
        }
        /**
        * Add a new line to the Memo
        * @param $line string The content of the new line.
        * @return integer Returns the number of lines defined.
        */
        function AddLine($line)
        {
                $this->_lines[] = $line;
                return count($this->_lines);
        }

        /**
        * Deletes all text (lines) from the memo control.
        */
        function Clear()
        {
                $this->_lines = array();
        }

        /**
        * Converts the text of the Lines property into way which can be used
        * in the HTML output.
        * Please have a look at the PHP function nl2br.
        * @return string Returns the Text property with '<br />'
        *                inserted before all newlines.
        */
        function LinesAsHTML()
        {
                return nl2br($this->Text);
        }

        /**
        * LineSeparator is used in the Text property to convert a string into
        * an array and back.
        * Note: Escaped character need to be in a double-quoted string.
        *       e.g. "\n"
        *       See <a href="http://www.php.net/manual/en/language.types.string.php">http://www.php.net/manual/en/language.types.string.php</a>
        * @link http://www.php.net/manual/en/language.types.string.php
        * @return string
        */
        function readLineSeparator() { return $this->_lineseparator; }
        /**
        * LineSeparator is used in the Text property to convert a string into
        * an array and back.
        * Note: Escaped character need to be in a double-quoted string.
        *       e.g. "\n"
        *       See <a href="http://www.php.net/manual/en/language.types.string.php">http://www.php.net/manual/en/language.types.string.php</a>
        * @link http://www.php.net/manual/en/language.types.string.php
        * @param string $value
        */
        function writeLineSeparator($value) { $this->_lineseparator = $value; }

        /**
        * Contains the individual lines of text in the memo control.
        * Lines is an array, so the PHP array manipulation functions may be used.
        *
        * Note: Do not manipulate the Lines property like this:
        *       $this->Memo1->Lines[] = "add new line";
        *       Various versions of PHP implement the behavior of this differently.
        *       Use following code:
        *       $lines = $this->Memo1->Lines;
        *       $lines[] = "new line";          // more lines may be added
        *       $this->Memo1->Lines = $lines;
        * @return array
        */
        function readLines() { return $this->_lines; }
        /**
        * Contains the individual lines of text in the memo control.
        * Lines is an array, so the PHP array manipulation functions may be used.
        *
        * Note: Do not manipulate the Lines property like this:
        *       $this->Memo1->Lines[] = "add new line";
        *       Various versions of PHP implement the behavior of this differently.
        *       Use following code:
        *       $lines = $this->Memo1->Lines;
        *       $lines[] = "new line";          // more lines may be added
        *       $this->Memo1->Lines = $lines;
        * @param array $value
        */
        function writeLines($value)
        {
                if (is_array($value))
                {
                        $this->_lines = $value;
                }
                else
                {
                        $this->_lines = (empty($value)) ? array() : array($value);
                }
        }
        function defaultLines() { return array(); }

        /**
        * Text property allows read and write the contents of Lines in a string
        * separated by LineSeparator.
        * @return string
        */
        function readText()
        {
                return implode("$this->_lineseparator", $this->Lines);
        }
        /**
        * Text property allows read and write the contents of Lines in a string
        * separated by LineSeparator.
        * @param string $value
        */
        function writeText($value)
        {
                if (empty($value))
                {
                        $this->Clear();
                }
                else
                {
                        $lines = explode("$this->_lineseparator", $value);
                        if (is_array($lines))
                        {
                                $this->Lines = $lines;
                        }
                        else
                        {
                                $this->Lines = array($value);
                        }
                }
        }

        /**
        * Determines whether the edit control inserts soft carriage returns
        * so text wraps at the right margin.
        * Note: This may work with the browsers Firefox and Internet Explorer only.
        * @return bool
        */
        function readWordWrap() { return $this->_wordwrap; }
        /**
        * Determines whether the edit control inserts soft carriage returns
        * so text wraps at the right margin.
        * Note: This may work with the browsers Firefox and Internet Explorer only.
        * @param bool $value
        */
        function writeWordWrap($value) { $this->_wordwrap=$value; }
        function defaultWordWrap() { return 1; }
}


/**
 * Memo class
 *
 * Memo publishes many of the properties inherited from CustomMemo,
 * but does not introduce any new behavior. For specialized memo controls,
 * use other descendant classes of CustomMemo (e.g. RichEdit) or derive from it.
 *
 * @package StdCtrls
 */
class Memo extends CustomMemo
{
        /*
        * Publish the events for the Memo component
        */
        function getOnClick                     () { return $this->readOnClick(); }
        function setOnClick                     ($value) { $this->writeOnClick($value); }

        function getOnDblClick                  () { return $this->readOnDblClick(); }
        function setOnDblClick                  ($value) { $this->writeOnDblClick($value); }

        function getOnSubmit                    () { return $this->readOnSubmit(); }
        function setOnSubmit                    ($value) { $this->writeOnSubmit($value); }

        /*
        * Publish the JS events for the Memo component
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
        * Publish the properties for the Memo component
        */
        function getBorderStyle()
        {
                return $this->readBorderStyle();
        }
        function setBorderStyle($value)
        {
                $this->writeBorderStyle($value);
        }

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

        function getEnabled()
        {
                return $this->readEnabled();
        }
        function setEnabled($value)
        {
                $this->writeEnabled($value);
        }

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

        function getMaxLength()
        {
                return $this->readMaxLength();
        }
        function setMaxLength($value)
        {
                $this->writeMaxLength($value);
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

        function getReadOnly()
        {
                return $this->readReadOnly();
        }
        function setReadOnly($value)
        {
                $this->writeReadOnly($value);
        }

        function getShowHint()
        {
                return $this->readShowHint();
        }
        function setShowHint($value)
        {
                $this->writeShowHint($value);
        }

        function getStyle()             { return $this->readstyle(); }
        function setStyle($value)       { $this->writestyle($value); }

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

        function getVisible()
        {
                return $this->readVisible();
        }
        function setVisible($value)
        {
                $this->writeVisible($value);
        }

        function getWordWrap()
        {
                return $this->readWordWrap();
        }
        function setWordWrap($value)
        {
                $this->writeWordWrap($value);
        }
}

/**
 * CustomListBox class
 *
 * Base class for Listbox controls, such as ListBox and ComboBox.
 * ListBox displays a collection of items in a scrollable list.
 *
 * @package StdCtrls
 */
class CustomListBox extends CustomMultiSelectListControl
{
        public $_items = array();
        protected $_selitems = array();

        protected $_onchange = null;
        protected $_onclick = null;
        protected $_ondblclick = null;
        protected $_onsubmit = null;

        protected $_borderstyle = bsSingle;
        protected $_datasource = null;
        protected $_datafield = "";
        protected $_size = 4;
        protected $_sorted = 0;
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

                $this->writeDataSource($this->_datasource);
        }

        function preinit()
        {
                $submitted = $this->input->{$this->Name};

                if (is_object($submitted))
                {
                        $this->ClearSelection();
                        if ($this->_multiselect == 1)
                        {
                                $this->_selitems = $submitted->asStringArray();
                        }
                        else
                        {
                                $changed = ($this->_itemindex != $submitted->asString());
                                // the ItemIndex might be an integer or a string,
                                // so let's get a string
                                $this->_itemindex = $submitted->asString();

                                // only update the data field if the item index was changed
                                if ($changed)
                                {
                                        // following somehow does not work here:
                                        //   if (array_key_exists($this->_itemindex, $this->_items)) { $this->updateDataField($this->_items[$this->_itemindex]); }
                                        // so let's do it like this...
                                        foreach ($this->_items as $key => $item)
                                        {
                                                if ($key == $this->_itemindex)
                                                {
                                                        //If there is any valid DataField attached, update it
                                                        $this->updateDataField($item);
                                                }
                                        }
                                }
                        }
                }
        }

        function init()
        {
                parent::init();

                $submitted = $this->input->{$this->Name};

                // Allow the OnSubmit event to be fired because it is not
                // a mouse or keyboard event.
                if (is_object($submitted))
                {
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
                        // check if the a double-click event has been fired
                        if ($this->_ondblclick != null && $submitEvent->asString() == $this->getJSWrapperSubmitEventValue($this->_ondblclick))
                        {
                                $this->callEvent('ondblclick', array());
                        }
                        // check if the a change event has been fired
                        if ($this->_onchange != null && $submitEvent->asString() == $this->getJSWrapperSubmitEventValue($this->_onchange))
                        {
                                $this->callEvent('onchange', array());
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
                        $this->addJSWrapperToEvents($events, $this->_ondblclick, $this->_jsondblclick, "ondblclick");
                        $this->addJSWrapperToEvents($events, $this->_onchange,   $this->_jsonchange,   "onchange");
                }

                $style = "";
                if ($this->Style=="")
                {
                        $style .= $this->Font->FontString;

                        // set the no border style
                        if ($this->_borderstyle == bsNone)
                        {
                                $style .= "border-width: 0px; border-style: none;";
                        }

                        if ($this->Color != "")
                        {
                                $style .= "background-color: " . $this->Color . ";";
                        }

                        // add the cursor to the style
                        if ($this->_cursor != "")
                        {
                                $cr = strtolower(substr($this->_cursor, 2));
                                $style .= "cursor: $cr;";
                        }
                }

                // set enabled/disabled status
                $enabled = (!$this->_enabled) ? "disabled=\"disabled\"" : "";

                // multi-select
                $multiselect = ($this->_multiselect == 1) ? "multiple=\"multiple\"" : "";
                // if multi-select then the name needs to have [] to indicate it will send an array
                $name = ($this->_multiselect == 1) ? "$this->_name[]" : $this->_name;

                // set tab order if tab stop set to true
                $taborder = ($this->_tabstop == 1) ? "tabindex=\"$this->_taborder\"" : "";

                // get the hint attribute; returns: title="[HintText]"
                $hint = $this->getHintAttribute();


                $h = $this->Height - 2;
                $w = $this->Width;

                $style .= "height:" . $h . "px;width:" . $w . "px;";

                $class = ($this->Style != "") ? "class=\"$this->StyleClass\"" : "";

                if ($style != "")  $style = "style=\"$style\"";

                if (($this->ControlState & csDesigning) != csDesigning)
                {
                        if ($this->hasValidDataField())
                        {
                                //check if the value of the current data-field is in the itmes array as value
                                $val = $this->readDataFieldValue();
                                // get the corresponding key to the value read from the data source
                                if (($key = array_search($val, $this->_items)) !== FALSE)
                                {
                                        // if an item was found the overwrite the itemindex
                                        $this->_itemindex = $key;
                                }

                                //Dumps hidden fields to know which is the record to update
                                $this->dumpHiddenKeyFields();
                        }
                }

                // call the OnShow event if assigned so the Items property can be changed
                if ($this->_onshow != null)
                {
                        $this->callEvent('onshow', array());
                }


                echo "<select name=\"$name\" id=\"$name\" size=\"$this->_size\" $style $enabled $multiselect $taborder $hint $events $class>";
                if (is_array($this->_items))
                {
                        reset($this->_items);
                        foreach ($this->_items as $key => $item)
                        {
                                $selected = "";
                                if ($key == $this->_itemindex || ($this->_multiselect == true && in_array($key, $this->_selitems)))
                                {
                                        $selected = " selected";
                                }
                                echo "<option value=\"$key\"$selected>$item</option>";
                        }
                }
                echo "</select>";

                // add a hidden field so we can determine which listbox fired the event
                if ($this->_onclick != null || $this->_onchange != null || $this->_ondblclick != null)
                {
                        $hiddenwrapperfield = $this->getJSWrapperHiddenFieldName();
                        echo "<input type=\"hidden\" id=\"$hiddenwrapperfield\" name=\"$hiddenwrapperfield\" value=\"\" />";
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
                                // otherwise if for example two buttons use the same
                                // OnClick event handler it would be outputted twice.
                                $def=$this->_onclick;
                                define($def,1);

                                // output the wrapper function
                                echo $this->getJSWrapperFunction($this->_onclick);
                        }
                        if ($this->_ondblclick != null && !defined($this->_ondblclick))
                        {
                                $def=$this->_ondblclick;
                                define($def,1);

                                // output the wrapper function
                                echo $this->getJSWrapperFunction($this->_ondblclick);
                        }
                        if ($this->_onchange != null && !defined($this->_onchange))
                        {
                                $def=$this->_onchange;
                                define($def,1);

                                // output the wrapper function
                                echo $this->getJSWrapperFunction($this->_onchange);
                        }
                }
        }

        

        /*
        * <Implementation of functions from super-class; docu can be found there as well>
        */

        function readCount()
        {
                return count($this->_items);
        }
        function readItemIndex()
        {
                // Return the first item of the selitems only if
                // the itemindex is -1 and multiselect is enabled and there
                // are some values selected.
                if ($this->_itemindex == -1 && $this->_multiselect == 1 && $this->SelCount > 0)
                {
                        reset($this->_selitems);
                        return key($this->_selitems);
                }
                else
                {
                        return $this->_itemindex;
                }
        }
        function writeItemIndex($value)
        {
                $this->_itemindex = $value;
                // if multi-select then also add it to the selected array
                if ($this->_multiselect == 1)
                {
                        $this->writeSelected($value, true);
                }
        }
        function defaultItemIndex()
        {
                return -1;
        }

        function AddItem($item, $object = null, $itemkey = null)
        {
                if ($object != null)
                {
                        throw new Exception('Object functionallity for ListBox is not yet implemented.');
                }

                //Set the array to the end
                end($this->_items);

                //Adds the item as the last one
                if ($itemkey != null)
                {
                        $this->_items[$itemkey] = $item;
                }
                else
                {
                        $this->_items[] = $item;
                }

                if ($this->_sorted == 1)
                {
                        $this->sortItems();
                }

                return($this->Count);
        }

        function Clear()
        {
                $this->_items = array();
                $this->_selitems = array();
        }

        function ClearSelection()
        {
                if ($this->_multiselect == 1)
                {
                        $this->_selitems = array();
                }
                $this->_itemindex = -1;
        }
        function SelectAll()
        {
                if ($this->_multiselect == 1)
                {
                        $this->_selitems = array_keys($this->_items);
                }
        }

        function readSelCount()
        {
                if ($this->_mulitselect == 1)
                {
                        return count($this->_selitems);
                }
                else
                {
                        return ($this->_itemindex != -1) ? 1 : 0;
                }
        }
        /**
        * Determines whether the user can select more than one element at a time.
        * Note: MultiSelect does not work if a data source is assigned.
        * @return bool
        */
        function readMultiSelect()
        {
                return $this->_multiselect;
        }
        /**
        * Determines whether the user can select more than one element at a time.
        * Note: MultiSelect does not work if a data source is assigned.
        * @param bool $value
        */
        function writeMultiSelect($value)
        {
                if ($this->_multiselect == 1 && $value == false)
                {
                        $this->ClearSelection();
                }
                $this->_multiselect = $value;

                if ($this->_multiselect == 1)
                {
                        // unset data source if multi select is enabled
                        $this->writeDataSource(null);
                }
        }
        function defaultMultiSelect()
        {
                return 0;
        }
        /*
        * </Implementation of functions from super-class>
        */

        /**
        * Checks if $index is selected.
        * @param mixed $index Index to be checked.
        * @return bool Returns true if $index is selected.
        */
        function readSelected($index)
        {
                if ($this->_multiselect)
                {
                        return in_array($index, $this->_selitems);
                }
                else
                {
                        return $index == $this->_itemindex;
                }
        }
        /**
        * Select or unselect a specific item.
        * @param mixed $index Key or index of the item to select.
        * @param bool $value True if selected, otherwise false.
        */
        function writeSelected($index, $value)
        {
                if ($this->_multiselect == 1)
                {
                        // add it to the selitems
                        if ($value)
                        {
                                // if the index does not already exist
                                if (!in_array($index, $this->_selitems))
                                {
                                        $this->_selitems[] = $index;
                                }
                        }
                        // remove the index from the selitems
                        else
                        {
                                $this->_selitems = array_diff($this->_selitems, array($index));
                        }
                }
                else
                {
                        $this->_itemindex = ($value) ? $index : -1;
                }
        }

        /**
        * Sort the items array.
        */
        private function sortItems()
        {
                // keep the keys when sorting the array (sort does not keep the keys)
                asort($this->_items);
        }



        /**
        * Occurs when the user changed the item of the control.
        * @return mixed Returns the event handler or null if no handler is set.
        */
        function readOnChange() { return $this->_onchange; }
        /**
        * Occurs when the user changed the item of the control.
        * @param mixed $value Event handler or null if no handler is set.
        */
        function writeOnChange($value) { $this->_onchange = $value; }
        function defaultOnChange() { return null; }

        /**
        * Occurs when the user clicks the control.
        * @return mixed Returns the event handler or null if no handler is set.
        */
        function readOnClick() { return $this->_onclick; }
        /**
        * Occurs when the user clicks the control.
        * @param mixed Event handler or null if no handler is set.
        */
        function writeOnClick($value) { $this->_onclick = $value; }
        function defaultOnClick() { return null; }

        /**
        * Occurs when the user double clicks the control.
        * @return mixed Returns the event handler or null if no handler is set.
        */
        function readOnDblClick() { return $this->_ondblclick; }
        /**
        * Occurs when the user double clicks the control.
        * @param mixed $value Event handler or null if no handler is set.
        */
        function writeOnDblClick($value) { $this->_ondblclick = $value; }
        function defaultOnDblClick() { return null; }

        /**
        * Occurs when the control was submitted.
        * @return mixed Returns the event handler or null if no handler is set.
        */
        function readOnSubmit() { return $this->_onsubmit; }
        /**
        * Occurs when the control was submitted.
        * @param mixed Event handler or null if no handler is set.
        */
        function writeOnSubmit($value) { $this->_onsubmit=$value; }
        function defaultOnSubmit() { return null; }


        /**
        * Determines whether the listbox control has a single line border around the client area.
        * @return enum (bsNone, bsSingle)
        */
        function readBorderStyle() { return $this->_borderstyle; }
        /**
        * Determines whether the listbox control has a single line border around the client area.
        * @param enum $value (bsNone, bsSingle)
        */
        function writeBorderStyle($value) { $this->_borderstyle=$value; }
        function defaultBorderStyle() { return bsSingle; }

        function readDataField() { return $this->_datafield; }
        function writeDataField($value) { $this->_datafield = $value; }
        function defaultDataField() { return ""; }

        function readDataSource() { return $this->_datasource; }
        /**
        * If a data source is assigned multi-select cannot be used.
        */
        function writeDataSource($value)
        {
                $this->_datasource = $this->fixupProperty($value);
                // if a data source is assigned then the list box can not be multi-select
                if ($value != null)
                {
                        $this->MultiSelect = 0;
                }
        }
        function defaultDataSource() { return null; }

        /**
        * Contains the strings that appear in the list box.
        * @return array
        */
        function readItems() { return $this->_items; }
        /**
        * Contains the strings that appear in the list box.
        * @param array $value
        */
        function writeItems($value)
        {
                if (is_array($value))
                {
                        $this->_items = $value;
                }
                else
                {
                        $this->_items = (empty($value)) ? array() : array($value);
                }

                // sort the items
                if ($this->_sorted == 1)
                {
                        $this->sortItems();
                }
        }
        function defaultItems() { return array(); }

        /**
        * Size of the listbox. Size defines the number of items that are shown
        * without a need of scrolling.
        * If bigger than 1 most browsers will use Height instead. If Size equals 1
        * the listbox truns into a combobox.
        * @return integer
        */
        function readSize() { return $this->_size; }
        /**
        * Size of the listbox. Size defines the number of items that are shown
        * without a need of scrolling.
        * If bigger than 1 most browsers will use Height instead. If Size equals 1
        * the listbox truns into a combobox.
        * @param integer $value
        */
        function writeSize($value) { $this->_size=$value; }
        function defaultSize() { return 4; }

        /**
        * Specifies whether the items in a list box are arranged alphabetically.
        * @return bool
        */
        function readSorted() { return $this->_sorted; }
        /**
        * Specifies whether the items in a list box are arranged alphabetically.
        * @param bool $value
        */
        function writeSorted($value)
        {
                $this->_sorted=$value;
                if ($this->_sorted == 1)
                {
                        $this->sortItems();
                }
        }
        function defaultSorted() { return 0; }

        /**
        * TabOrder indicates in which order controls are access when using
        * the Tab key.
        * The value of the TabOrder can be between 0 and 32767.
        * @return integer
        */
        function readTabOrder() { return $this->_taborder; }
        /**
        * TabOrder indicates in which order controls are access when using
        * the Tab key.
        * The value of the TabOrder can be between 0 and 32767.
        * @param integer $value
        */
        function writeTabOrder($value) { $this->_taborder=$value; }
        function defaultTabOrder() { return 0; }

        /**
        * Enable or disable the TabOrder property. The browser may still assign
        * a TabOrder by itself internally. This cannot be controlled by HTML.
        * @return bool
        */
        function readTabStop() { return $this->_tabstop; }
        /**
        * Enable or disable the TabOrder property. The browser may still assign
        * a TabOrder by itself internally. This cannot be controlled by HTML.
        * @param bool $value
        */
        function writeTabStop($value) { $this->_tabstop=$value; }
        function defaultTabStop() { return 1; }

}


/**
 * Listbox class
 *
 * A class to encapsulate a listbox control
 *
 * @package StdCtrls
 */
class ListBox extends CustomListBox
{
        /*
        * Publish the events
        */
        function getOnClick                     () { return $this->readOnClick(); }
        function setOnClick                     ($value) { $this->writeOnClick($value); }

        function getOnDblClick                  () { return $this->readOnDblClick(); }
        function setOnDblClick                  ($value) { $this->writeOnDblClick($value); }

        function getOnSubmit                    () { return $this->readOnSubmit(); }
        function setOnSubmit                    ($value) { $this->writeOnSubmit($value); }

        /*
        * Publish the JS events
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


        /*
        * Publish the properties for the Label component
        */

        function getBorderStyle()
        {
                return $this->readBorderStyle();
        }
        function setBorderStyle($value)
        {
                $this->writeBorderStyle($value);
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

        function getColor()
        {
                return $this->readColor();
        }
        function setColor($value)
        {
                $this->writeColor($value);
        }

        function getEnabled()
        {
                return $this->readEnabled();
        }
        function setEnabled($value)
        {
                $this->writeEnabled($value);
        }

        function getFont()
        {
                return $this->readFont();
        }
        function setFont($value)
        {
                $this->writeFont($value);
        }

        function getMultiSelect()
        {
                return $this->readMultiSelect();
        }
        function setMultiSelect($value)
        {
                $this->writeMultiSelect($value);
        }

        function getItems()
        {
                return $this->readItems();
        }
        function setItems($value)
        {
                $this->writeItems($value);
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

        function getSize()
        {
                return $this->readSize();
        }
        function setSize($value)
        {
                $this->writeSize($value);
        }

        function getSorted()
        {
                return $this->readSorted();
        }
        function setSorted($value)
        {
                $this->writeSorted($value);
        }

        function getStyle()             { return $this->readstyle(); }
        function setStyle($value)       { $this->writestyle($value); }

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
 * Combobox class
 *
 * A class to encapsulate a combobox control.
 * Note: It is directly subclassed from CustomListBox since they are almost
 *       identical in HTML. The only differentce is that no MultiSelect is
 *       possible.
 *
 * @package StdCtrls
 */
class ComboBox extends CustomListBox
{
        function __construct($aowner = null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                // size is always 1 to render a ComboBox in the browser
                $this->_size = 1;
                // no MultiSelect possible
                $this->_multiselect = 0;

                $this->Width = 185;
                $this->Height = 18;
        }

        /*
        * Override the parent MultiSelect related functions; no MultiSelect possible.
        */
        function readSelCount()
        {
                // only one or zero items can be selected
                return ($this->_itemindex != -1) ? 1 : 0;
        }
        function readMultiSelect()
        {
                // always return false since MultiSelect can not be used with a ComboBox
                return 0;
        }
        function writeMultiSelect($value)
        {
                // do nothing; MultiSelect can not be used with a ComboBox
        }

        /*
        * Publish the events
        */
        function getOnChange                    () { return $this->readOnChange(); }
        function setOnChange                    ($value) { $this->writeOnChange($value); }

        function getOnDblClick                  () { return $this->readOnDblClick(); }
        function setOnDblClick                  ($value) { $this->writeOnDblClick($value); }

        function getOnSubmit                    () { return $this->readOnSubmit(); }
        function setOnSubmit                    ($value) { $this->writeOnSubmit($value); }

        /*
        * Publish the JS events
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


        /*
        * Publish the properties for the Label component
        */

        function getBorderStyle()
        {
                return $this->readBorderStyle();
        }
        function setBorderStyle($value)
        {
                $this->writeBorderStyle($value);
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

        function getColor()
        {
                return $this->readColor();
        }
        function setColor($value)
        {
                $this->writeColor($value);
        }

        function getEnabled()
        {
                return $this->readEnabled();
        }
        function setEnabled($value)
        {
                $this->writeEnabled($value);
        }

        function getFont()
        {
                return $this->readFont();
        }
        function setFont($value)
        {
                $this->writeFont($value);
        }

        function getItems()
        {
                return $this->readItems();
        }
        function setItems($value)
        {
                $this->writeItems($value);
        }

        function getItemIndex()
        {
                return $this->readItemIndex();
        }
        function setItemIndex($value)
        {
                $this->writeItemIndex($value);
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

        function getSorted()
        {
                return $this->readSorted();
        }
        function setSorted($value)
        {
                $this->writeSorted($value);
        }

        function getStyle()             { return $this->readstyle(); }
        function setStyle($value)       { $this->writestyle($value); }

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
 * ButtonControl class
 *
 * ButtonControl is the base class for objects that represent button controls,
 * such as Button, CheckBox, RadioButton.
 *
 * @package StdCtrls
 */
class ButtonControl extends FocusControl
{
        protected $_onclick = null;
        protected $_onsubmit = null;
        protected $_jsonselect = null;

        protected $_checked = 0;
        protected $_datasource = null;
        protected $_datafield = "";
        protected $_taborder = 0;
        protected $_tabstop = 1;

        // defines which property is set by the datasource
        protected $_datafieldproperty = 'Caption';


        function __construct($aowner = null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width = 75;
                $this->Height = 25;
                $this->ControlStyle="csRenderOwner=1";
                $this->ControlStyle="csRenderAlso=StyleSheet";
        }

        function loaded()
        {
                parent::loaded();
                $this->writeDataSource($this->_datasource);
        }

        function init()
        {
                $submitted = $this->input->{$this->Name};

                // Allow the OnSubmit event to be fired because it is not
                // a mouse or keyboard event.
                if ($this->_onsubmit != null && is_object($submitted))
                {
                        $this->callEvent('onsubmit', array());
                }

                $submitEventValue = $this->input->{$this->getJSWrapperHiddenFieldName()};
                if (is_object($submitEventValue) && $this->_enabled == 1)
                {
                        // check if the a click event of the current button
                        // has been fired
                        if ($this->_onclick != null && $submitEventValue->asString() == $this->getJSWrapperSubmitEventValue($this->_onclick))
                        {
                                $this->callEvent('onclick', array());
                        }
                }
        }

        /**
        * This function was introduced to be flexible with the sub-classed controls.
        * It takes all necessary info to dump the control.
        * @param string $inputType Input type such as submit, button, check, radio, etc..
        * @param string $name Name of the control
        * @param string $additionalAttributes String containing additional attributes that will be included in the <input ..> tag.
        * @param string $surroundingTags Tags that surround the <input ..> tag. Use %s to specify were the <input> tag should be placed.
        * @param bool $composite If true height and width will not be applied to the styles in this function,
        *                        they must be appied at the location where this fucntion is called.
        */
        function dumpContentsButtonControl($inputType, $name,
          $additionalAttributes = "", $surroundingTags = "%s", $composite = false)
        {
                $events = "";
                if ($this->_enabled == 1)
                {
                        // get the string for the JS Events
                        $events = $this->readJsEvents();

                        // add the OnSelect JS-Event
                        if ($this->_jsonselect != null)
                        {
                                $events .= " onselect=\"return $this->_jsonselect(event)\" ";
                        }

                        // add or replace the JS events with the wrappers if necessary
                        $this->addJSWrapperToEvents($events, $this->_onclick, $this->_jsonclick, "onclick");
                }

                $style = "";
                if ($this->Style=="")
                {
                        $style .= $this->Font->FontString;
                        if ($this->color != "")
                        {
                                $style .= "background-color: " . $this->color . ";";
                        }

                        // add the cursor to the style
                        if ($this->_cursor != "")
                        {
                                $cr = strtolower(substr($this->_cursor, 2));
                                $style .= "cursor: $cr;";
                        }
                }

                if (!$composite)
                {
                    if (!$this->_adjusttolayout)
                    {
                        $style .= "height:" . $this->Height . "px;width:" . $this->Width . "px;";
                    }
                    else
                    {
                        $style .= "height:100%;width:100%;";
                    }
                }

                // get the Caption of the button if it is data-aware
                if (($this->ControlState & csDesigning) != csDesigning)
                {
                        if ($this->hasValidDataField())
                        {
                                // depending on the sub-class there is another property to be set by the data-source (e.g. Button = Caption; CheckBox = Checked)
                                $this->{$this->_datafieldproperty} = $this->readDataFieldValue();

                                //Dumps hidden fields to know which is the record to update
                                $this->dumpHiddenKeyFields();
                        }
                }

                // set the checked status
                $checked = ($this->_checked) ? "checked=\"checked\"" : "";

                // set enabled/disabled status
                $enabled = (!$this->_enabled) ? "disabled=\"disabled\"" : "";

                // set tab order if tab stop set to true
                $taborder = ($this->_tabstop == 1) ? "tabindex=\"$this->_taborder\"" : "";

                // get the hint attribute; returns: title="[HintText]"
                $hint = $this->getHintAttribute();

                if ($style != "")  $style = "style=\"$style\"";

                $class = ($this->Style != "") ? "class=\"$this->StyleClass\"" : "";

                // call the OnShow event if assigned so the Caption property can be changed
                if ($this->_onshow != null)
                {
                        $this->callEvent('onshow', array());
                }

                // assemble the input tag
                $input = "<input type=\"$inputType\" id=\"$name\" name=\"$name\" value=\"$this->_caption\" $events $style $checked $enabled $taborder $hint $additionalAttributes $class />";
                // output the control
                printf($surroundingTags, $input);

                // add a hidden field so we can determine which button fired the OnClick event
                if ($this->_onclick != null)
                {
                        $hiddenwrapperfield = $this->getJSWrapperHiddenFieldName();
                        echo "<input type=\"hidden\" id=\"$hiddenwrapperfield\" name=\"$hiddenwrapperfield\" value=\"\" />";
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
                        if ($this->_jsonselect != null)
                        {
                                $this->dumpJSEvent($this->_jsonselect);
                        }

                        if ($this->_onclick != null && !defined($this->_onclick))
                        {
                                // only output the same function once;
                                // otherwise if for example two buttons use the same
                                // OnClick event handler it would be outputted twice.
                                $def=$this->_onclick;
                                define($def,1);

                                // output the wrapper function
                                echo $this->getJSWrapperFunction($this->_onclick);
                        }
                }
        }



        /**
        * Occurs when the user clicks the control.
        * @return mixed Returns the event handler or null if no handler is set.
        */
        function readOnClick() { return $this->_onclick; }
        /**
        * Occurs when the user clicks the control.
        * @param mixed $value Event handler or null to unset.
        */
        function writeOnClick($value) { $this->_onclick = $value; }
        function defaultOnClick() { return ""; }

        /**
        * JS event when the control gets focus.
        * @return mixed Returns the event handler or null if no handler is set.
        */
        function readjsOnSelect() { return $this->_jsonselect; }
        /**
        * JS event when the control gets focus.
        * @param mixed $value Event handler or null to unset.
        */
        function writejsOnSelect($value) { $this->_jsonselect=$value; }
        function defaultjsOnSelect() { return null; }

        /**
        * Occurs when the form containing the control was submitted.
        * @return mixed Returns the event handler or null if no handler is set.
        */
        function readOnSubmit() { return $this->_onsubmit; }
        /**
        * Occurs when the form containing the control was submitted.
        * @param mixed Event handler or null if no handler is set.
        */
        function writeOnSubmit($value) { $this->_onsubmit=$value; }
        function defaultOnSubmit() { return null; }

        /**
        * Specifies whether the button control is checked.
        * @return bool
        */
        function readChecked() { return $this->_checked; }
        /**
        * Specifies whether the button control is checked.
        * @param bool $value
        */
        function writeChecked($value) { $this->_checked=$value; }
        function defaultChecked() { return 0; }

        //DataField property
        function readDataField() { return $this->_datafield; }
        function writeDataField($value) { $this->_datafield = $value; }
        function defaultDataField() { return ""; }

        //DataSource property
        function readDataSource() { return $this->_datasource; }
        function writeDataSource($value)
        {
                $this->_datasource = $this->fixupProperty($value);
        }
        function defaultDataSource() { return null; }

        /**
        * TabOrder indicates in which order controls are access when using
        * the Tab key.
        * The value of the TabOrder can be between 0 and 32767.
        * @return integer
        */
        function readTabOrder() { return $this->_taborder; }
        /**
        * TabOrder indicates in which order controls are access when using
        * the Tab key.
        * The value of the TabOrder can be between 0 and 32767.
        * @param integer $value
        */
        function writeTabOrder($value) { $this->_taborder=$value; }
        function defaultTabOrder() { return 0; }

        /**
        * Enable or disable the TabOrder property. The browser may still assign
        * a TabOrder by itself internally. This cannot be controlled by HTML.
        * @return bool
        */
        function readTabStop() { return $this->_tabstop; }
        /**
        * Enable or disable the TabOrder property. The browser may still assign
        * a TabOrder by itself internally. This cannot be controlled by HTML.
        * @param bool $value
        */
        function writeTabStop($value) { $this->_tabstop=$value; }
        function defaultTabStop() { return 1; }
}


define('btSubmit', 'btSubmit');
define('btReset', 'btReset');
define('btNormal', 'btNormal');

/**
 * Button class
 *
 * This class controls the properties and events of a button control.
 *
 * @package StdCtrls
 */
class Button extends ButtonControl
{
        protected $_buttontype = btSubmit;
        protected $_default = 0;
        protected $_imagesource = "";

        function __construct($aowner = null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                // define which property is set by the datasource
                $this->_datafieldproperty = 'Caption';
        }

        function dumpContents()
        {
                // get the button type
                $buttontype = "submit";
                switch ($this->_buttontype)
                {
                        case btSubmit :
                                $buttontype = "submit";
                                break;
                        case btReset :
                                $buttontype = "reset";
                                break;
                        case btNormal :
                                $buttontype = "button";
                                break;
                }

                // Check if an imagesource is defined, if yes then let's make an
                // image input.
                $imagesrc = "";
                if ($this->_imagesource != "")
                {
                        $buttontype = "image";
                        $imagesrc = "src=\"$this->_imagesource\"";
                }

                // override the buttontype if Default is true
                if ($this->_default == 1)
                {
                        $buttontype = "submit";
                        $imagesrc = "";
                }

                // dump to control with all other parameters
                $this->dumpContentsButtonControl($buttontype, $this->_name, $imagesrc);
        }

        /**
        * A standard HTML button can have 3 different types:
        * - btSubmit submits the HTML form.
        * - btReset resets the HTML form back to the initial values.
        * - btNormal is a regular button, the browser does not submit the form if no OnClick event has been assigned.
        *
        * Note: If Default is true then ButtonType is always btSubmit.
        * @return enum (btSubmit, btReset, btNormal)
        */
        function readButtonType() { return $this->_buttontype; }
        /**
        * A standard HTML button can have 3 different types:
        * - btSubmit submits the HTML form.
        * - btReset resets the HTML form back to the initial values.
        * - btNormal is a regular button, the browser does not submit the form if no OnClick event has been assigned.
        *
        * Note: If Default is true then ButtonType is always btSubmit.
        * @param enum (btSubmit, btReset, btNormal)
        */
        function writeButtonType($value)
        {
                $this->_buttontype = $value;
                // if ButtonType is not submit and default is set then unset default
                if ($this->_buttontype != btSubmit && $this->_default == 1)
                {
                        $this->Default = 0;
                }
        }
        function defaultButtonType() { return btSubmit; }

        /**
        * Determines whether the button’s OnClick event handler executes when the Enter key is pressed.
        * If Default is true the button type is btSubmit.
        *
        * Note: This behavior is controlled by the browser and might vary between
        *       different browsers.
        *
        * @return bool
        */
        function readDefault() { return $this->_default; }
        /**
        * Determines whether the button’s OnClick event handler executes when the Enter key is pressed.
        * If Default is true the button type is btSubmit.
        *
        * Note: This behavior is controlled by the browser and might vary between
        *       different browsers.
        *
        * @param bool $value
        */
        function writeDefault($value)
        {
                $this->_default=$value;
                // If set to default the ButtonType has to be submit
                if ($this->_default == 1)
                {
                        $this->ButtonType = btSubmit;
                }
        }
        function defaultDefault() { return 0; }

        /**
        * An image can be used as button. This is usually done to have a nice graphical interface.
        * To avoid distortion make sure you set the images height and width to button's Height and Width.
        * If ImageSource is empty it is not used.
        * @return string
        */
        function readImageSource() { return $this->_imagesource; }
        /**
        * An image can be used as button. This is usually done to have a nice graphical interface.
        * To avoid distortion make sure you set the images height and width to button's Height and Width.
        * If ImageSource is empty it is not used.
        * @param string $value
        */
        function writeImageSource($value) { $this->_imagesource = $value; }
        function defaultImageSource() { return ""; }

        /*
        * Publish the events for the Button component
        */
        function getOnClick                   () { return $this->readOnClick(); }
        function setOnClick($value)           { $this->writeOnClick($value); }

        /*
        * Publish the JS events for the Button component
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
        * Publish the properties for the Button component
        */

        function getButtonType()
        {
                return $this->readButtonType();
        }
        function setButtonType($value)
        {
                $this->writeButtonType($value);
        }

        function getCaption()
        {
                return $this->readCaption();
        }
        function setCaption($value)
        {
                $this->writeCaption($value);
        }

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

        function getDefault()
        {
                return $this->readDefault();
        }
        function setDefault($value)
        {
                $this->writeDefault($value);
        }

        function getEnabled()
        {
                return $this->readEnabled();
        }
        function setEnabled($value)
        {
                $this->writeEnabled($value);
        }

        function getFont()
        {
                return $this->readFont();
        }
        function setFont($value)
        {
                $this->writeFont($value);
        }

        function getImageSource()
        {
                return $this->readImageSource();
        }
        function setImageSource($value)
        {
                $this->writeImageSource($value);
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

        function getStyle()             { return $this->readstyle(); }
        function setStyle($value)       { $this->writestyle($value); }

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
 * CustomCheckBox class
 *
 * Base class for Checkbox controls.
 * CheckBox represents a check box that can be on (checked) or off (unchecked).
 *
 * @package StdCtrls
 */
class CustomCheckBox extends ButtonControl
{

        function __construct($aowner = null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width = 121;
                $this->Height = 21;

                // define which property is set by the datasource
                $this->_datafieldproperty = 'Checked';
        }

        function preinit()
        {
                $submittedValue = $this->input->{$this->_name};

                // check if the CheckBox is checked (compare against the Caption
                // since it is submitted as value)
                if (is_object($submittedValue) && $submittedValue->asString() == $this->_caption)
                {
                        $this->_checked = 1;
                        //If there is any valid DataField attached, update it
                        $this->updateDataField($this->_checked);
                }
                else if (($this->ControlState & csDesigning) != csDesigning)
                {
                        $this->_checked = 0;
                        //If there is any valid DataField attached, update it
                        $this->updateDataField($this->_checked);
                }
        }

        function dumpContents()
        {
                $style = "";
                if ($this->Style=="")
                {
                        $style .= $this->Font->FontString;

                        if ($this->color != "")
                        {
                                $style .= "background-color: ".$this->color.";";
                        }

                        // add the cursor to the style
                        if ($this->_cursor != "")
                        {
                                $cr = strtolower(substr($this->_cursor, 2));
                                $style .= "cursor: $cr;";
                        }
                }

                $height = $this->Height - 1;
                $width = $this->Width;

                $style .= "height:".$height."px;width:".$width."px;";

                if ($style != "")  $style = "style=\"$style\"";

                // get the hint attribute; returns: title="[HintText]"
                $hint = $this->getHintAttribute();

                // get the alignment of the Caption
                $alignment = "";
                switch ($this->_alignment)
                {
                        case agNone :
                                $alignment = "";
                                break;
                        case agLeft :
                                $alignment = "align=\"Left\"";
                                break;
                        case agCenter :
                                $alignment = "align=\"Center\"";
                                break;
                        case agRight :
                                $alignment = "align=\"Right\"";
                                break;
                }

                $class = ($this->Style != "") ? "class=\"$this->StyleClass\"" : "";

                $surroundingTags = "<table cellpadding=\"0\" cellspacing=\"0\" id=\"{$this->_name}_table\" $style $class><tr><td width=\"20\">\n";
                $surroundingTags .= "%s\n";
                $surroundingTags .= "</td><td $alignment>\n";
                // add some JS to the Caption (OnClick)
                $surroundingTags .= ($this->Owner != null) ? "<span id=\"{$this->_name}_caption\" onclick=\"var c = document.forms[0].$this->_name; c.checked = !c.checked; return (typeof(c.onclick) == 'function') ? c.onclick() : false;\" $hint $class>" : "<span>";
                $surroundingTags .= $this->_caption;
                $surroundingTags .= "</span>\n";
                $surroundingTags .= "</td></tr></table>\n";

                $this->dumpContentsButtonControl("checkbox", $this->_name,
                  "", $surroundingTags, true);
        }
}

/**
 * CheckBox class
 *
 * A HTML checkbox.
 * CheckBox represents a check box that can be on (checked) or off (unchecked).
 *
 * @package StdCtrls
 */
class CheckBox extends CustomCheckBox
{
        /*
        * Publish the events for the CheckBox component
        */
        function getOnClick                   () { return $this->readOnClick(); }
        function setOnClick($value)           { $this->writeOnClick($value); }

        function getOnSubmit                  () { return $this->readOnSubmit(); }
        function setOnSubmit                  ($value) { $this->writeOnSubmit($value); }

        /*
        * Publish the JS events for the CheckBox component
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
        * Publish the properties for the CheckBox component
        */

        function getAlignment()
        {
                return $this->readAlignment();
        }
        function setAlignment($value)
        {
                $this->writeAlignment($value);
        }

        function getCaption()
        {
                return $this->readCaption();
        }
        function setCaption($value)
        {
                $this->writeCaption($value);
        }

        function getChecked()
        {
                return $this->readChecked();
        }
        function setChecked($value)
        {
                $this->writeChecked($value);
        }

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

        function getEnabled()
        {
                return $this->readEnabled();
        }
        function setEnabled($value)
        {
                $this->writeEnabled($value);
        }

        function getFont()
        {
                return $this->readFont();
        }
        function setFont($value)
        {
                $this->writeFont($value);
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

        function getStyle()             { return $this->readstyle(); }
        function setStyle($value)       { $this->writestyle($value); }

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
 * RadioButton class
 *
 * A HTML radiobutton.
 * Use RadioButton to add an indipendent radio button to a form.
 * Radio buttons present a set of mutually exclusive options to the user- that is,
 * only one radio button in a set can be selected at a time.
 *
 * @package StdCtrls
 */
class RadioButton extends ButtonControl
{
        protected $_group = '';

        function __construct($aowner = null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width = 121;
                $this->Height = 21;

                // define which property is set by the datasource
                $this->_datafieldproperty = 'Checked';
        }

        function preinit()
        {
                // get the group-name, if non is set then get the name of the RadioButton
                $groupname = ($this->_group != '') ? $this->_group : $this->_name;

                $submittedValue = $this->input->{$groupname};

                // check if the RadioButton is checked (compare against the Caption
                // since it is submitted as value)
                if (is_object($submittedValue) && $submittedValue->asString() == $this->_caption)
                {
                        $this->_checked = 1;
                        //If there is any valid DataField attached, update it
                        $this->updateDataField($this->_checked);
                }
                else if (($this->ControlState & csDesigning) != csDesigning)
                {
                        $this->_checked = 0;
                        //If there is any valid DataField attached, update it
                        $this->updateDataField($this->_checked);
                }
        }

        function dumpContents()
        {
                $style = "";
                if ($this->Style=="")
                {
                        $style .= $this->Font->FontString;

                        if ($this->color != "")
                        {
                                $style .= "background-color: ".$this->color.";";
                        }

                        // add the cursor to the style
                        if ($this->_cursor != "")
                        {
                                $cr = strtolower(substr($this->_cursor, 2));
                                $style .= "cursor: $cr;";
                        }
                }

                $height = $this->Height - 1;
                $width = $this->Width;

                $style .= "height:".$height."px;width:".$width."px;";

                if ($style != "")  $style = "style=\"$style\"";

                // get the hint attribute; returns: title="[HintText]"
                $hint = $this->getHintAttribute();

                // get the alignment of the Caption
                $alignment = "";
                switch ($this->_alignment)
                {
                        case agNone :
                                $alignment = "";
                                break;
                        case agLeft :
                                $alignment = "align=\"Left\"";
                                break;
                        case agCenter :
                                $alignment = "align=\"Center\"";
                                break;
                        case agRight :
                                $alignment = "align=\"Right\"";
                                break;
                }

                $class = ($this->Style != "") ? "class=\"$this->StyleClass\"" : "";

                // get the group-name, if non is set then get the name of the RadioButton
                $groupname = ($this->_group != '') ? $this->_group : $this->_name;

                $surroundingTags = "<table cellpadding=\"0\" cellspacing=\"0\" id=\"{$this->_name}_table\" $style $class><tr><td width=\"20\">\n";
                $surroundingTags .= "%s\n";
                $surroundingTags .= "</td><td $alignment>\n";
                // Add some JS to the Caption (OnClick).
                $surroundingTags .= ($this->Owner != null) ? "<span id=\"{$this->_name}_caption\" onclick=\"return RadioButtonClick(document.forms[0].$groupname, '$this->_caption');\" $hint $class>" : "<span>";
                $surroundingTags .= $this->_caption;
                $surroundingTags .= "</span>\n";
                $surroundingTags .= "</td></tr></table>\n";

                $this->dumpContentsButtonControl("radio", $groupname,
                  "", $surroundingTags, true);
        }

        /*
        * Write the Javascript section to the header
        */
        function dumpJavascript()
        {
                parent::dumpJavascript();

                // only output the function once
                if (!defined('RadioButtonClick'))
                {
                        define('RadioButtonClick', 1);
                        // Since all names are the same for the same group we
                        // have to check with the value attribute.
                        echo "
function RadioButtonClick(elem, caption)
{
   if (typeof(elem.length) == 'undefined') {
     elem.checked = true;
     return (typeof(elem.onclick) == 'function') ? elem.onclick() : false;
   } else {
     for(var i = 0; i < elem.length; i++) {
       if (elem[i].value == caption) {
         elem[i].checked = true;
         return (typeof(elem[i].onclick) == 'function') ? elem[i].onclick() : false;
       }
     }
   }
   return false;
}
";
                }
        }


        /**
        * Group where the RadioButton belongs to.
        * If group is empty the name of the RadioButton is used, but usually that is not the desired behavior.
        * @return string
        */
        function readGroup()
        {
                return $this->_group;
        }
        /**
        * Group where the RadioButton belongs to.
        * If group is empty the name of the RadioButton is used, but usually that is not the desired behavior.
        * @param string $value
        */
        function writeGroup($value)
        {
                $this->_group = $value;
        }
        function defaultGroup() { return ''; }


        /*
        * Publish the events for the CheckBox component
        */
        function getOnClick                   () { return $this->readOnClick(); }
        function setOnClick($value)           { $this->writeOnClick($value); }

        function getOnSubmit                  () { return $this->readOnSubmit(); }
        function setOnSubmit                  ($value) { $this->writeOnSubmit($value); }

        /*
        * Publish the JS events for the CheckBox component
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
        * Publish the properties for the CheckBox component
        */

        function getAlignment()
        {
                return $this->readAlignment();
        }
        function setAlignment($value)
        {
                $this->writeAlignment($value);
        }

        function getCaption()
        {
                return $this->readCaption();
        }
        function setCaption($value)
        {
                $this->writeCaption($value);
        }

        function getChecked()
        {
                return $this->readChecked();
        }
        function setChecked($value)
        {
                $this->writeChecked($value);
        }

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

        function getEnabled()
        {
                return $this->readEnabled();
        }
        function setEnabled($value)
        {
                $this->writeEnabled($value);
        }

        function getGroup()
        {
                return $this->readGroup();
        }
        function setGroup($value)
        {
                $this->writeGroup($value);
        }

        function getFont()
        {
                return $this->readFont();
        }
        function setFont($value)
        {
                $this->writeFont($value);
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

        function getStyle()             { return $this->readstyle(); }
        function setStyle($value)       { $this->writestyle($value); }

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

        function getVisible()
        {
                return $this->readVisible();
        }
        function setVisible($value)
        {
                $this->writeVisible($value);
        }
}

define ('sbHorizontal', 'sbHorizontal');
define ('sbVertical', 'sbVertical');

/**
* ScrollBar class
*
* @package StdCtrls
*/
class ScrollBar extends QWidget
{
        protected $_kind = sbHorizontal;
        protected $_min=0;
        protected $_max=500;
        protected $_smallchange=1;
        protected $_largechange=1;
        protected $_position=0;
        protected $_pagesize=0;

        function dumpContents()
        {
                $this->dumpCommonContentsTop();

                if ($this->_kind==sbHorizontal) { $horiz = "true"; }
                else                            { $horiz = "false"; }

                echo "  var " . $this->Name . " = new qx.ui.core.ScrollBar($horiz);\n"
                   . "  $this->Name.setLeft(0);\n"
                   . "  $this->Name.setTop(0);\n"
                   . "  $this->Name.setWidth($this->Width);\n"
                   . "  $this->Name.setHeight($this->Height);\n"
                   . "  $this->Name.setMaximum($this->Max);\n"
                   . "  $this->Name.setValue($this->Position);\n";

                $this->dumpCommonContentsBottom();
        }

        /**
        * Specifies whether the scroll bar is horizontal or vertical.
        * @return enum (sbHorizontal, sbVertical)
        */
        function getKind()       { return $this->_kind; }
        /**
        * Specifies whether the scroll bar is horizontal or vertical.
        * @param enum (sbHorizontal, sbVertical)
        */
        function setKind($value)
        {
                if ($value != $this->_kind)
        {
                $w = $this->Width;
                $h = $this->Height;

                        if (($value == sbHorizontal) && ($w < $h))
                        {
                                $this->Height = $w;
                                $this->Width = $h;
                        }
                        else
                        if (($value == sbVertical) && ($w > $h))
                        {
                                $this->Height = $w;
                                $this->Width = $h;
                        }

                        $this->_kind = $value;
                }
        }
        function defaultKind() { return sbHorizontal;  }

        /**
        * Specifies the minimum position represented by the scroll bar.
        * @return integer
        */
        function getMin()       { return $this->_min; }
        /**
        * Specifies the minimum position represented by the scroll bar.
        * @param integer $value
        */
        function setMin($value) { $this->_min=$value; }
        function defaultMin()   { return 0; }

        /**
        * Specifies the maximum position represented by the scroll bar.
        * @return integer
        */
        function getMax()       { return $this->_max; }
        /**
        * Specifies the maximum position represented by the scroll bar.
        * @param integer $value
        */
        function setMax($value) { $this->_max=$value; }
        function defaultMax()   { return 500; }

        /**
        * Determines how much Position changes when the user clicks the arrow buttons
        * on the scroll bar or presses the arrow keys on the keyboard.
        * Note: Not yet implemented.
        * @return integer
        */
        function getSmallChange()       { return $this->_smallchange; }
        /**
        * Determines how much Position changes when the user clicks the arrow buttons
        * on the scroll bar or presses the arrow keys on the keyboard.
        * Note: Not yet implemented.
        * @param integer $value
        */
        function setSmallChange($value) { $this->_smallchange=$value; }
        function defaultSmallChange()   { return 1; }

        /**
        * Determines how much Position changes when the user clicks the scroll bar
        * on either side of the thumb tab or presses PgUp or PgDn.
        * Note: Not yet implemented.
        * @return integer
        */
        function getLargeChange()       { return $this->_largechange; }
        /**
        * Determines how much Position changes when the user clicks the scroll bar
        * on either side of the thumb tab or presses PgUp or PgDn.
        * Note: Not yet implemented.
        * @param integer $value
        */
        function setLargeChange($value) { $this->_largechange=$value; }
        function defaultLargeChange()   { return 1; }

        /**
        * Indicates the current position of the scroll bar.
        * @return integer
        */
        function getPosition()       { return $this->_position; }
        /**
        * Indicates the current position of the scroll bar.
        * @param integer $value
        */
        function setPosition($value) { $this->_position=$value; }
        function defaultPosition()   { return 0; }

        /**
        * Specifies the size of the thumb tab.
        * Note: Not yet implemented.
        * @return integer
        */
        function getPageSize()       { return $this->_pagesize; }
        /**
        * Specifies the size of the thumb tab.
        * Note: Not yet implemented.
        * @param integer $value
        */
        function setPageSize($value) { $this->_pagesize=$value; }
        function defaultPageSize()   { return 0; }

        function __construct($aowner = null)
                {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width = 200;
                $this->Height = 17;
        }

}



?>
