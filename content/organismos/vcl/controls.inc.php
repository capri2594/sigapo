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
use_unit("graphics.inc.php");

define('alNone','alNone');
define('alTop','alTop');
define('alBottom','alBottom');
define('alLeft','alLeft');
define('alRight','alRight');
define('alClient','alClient');
define('alCustom','alCustom');

define('agNone','agNone');
define('agLeft','agLeft');
define('agCenter','agCenter');
define('agRight','agRight');

define('crPointer','crPointer');
define('crCrossHair','crCrossHair');
define('crText','crText');
define('crWait','crWait');
define('crDefault','crDefault');
define('crHelp','crHelp');
define('crEResize','crE-Resize');
define('crNEResize','crNE-Resize');
define('crNResize','crN-Resize');
define('crNWResize','crNW-Resize');
define('crWResize','crW-Resize');
define('crSWResize','crSW-Resize');
define('crSResize','crS-Resize');
define('crSEResize','crSE-Resize');
define('crAuto','crAuto');

/**
 * Control class
 *
 * Base class for all controls
 */
class Control extends Component
{
        protected $_caption="";
        protected $_parent=null;
        protected $_popupmenu=null;
        protected $_controlstyle=array();
        protected $_left=0;
        protected $_visible=1;
        protected $_top=0;
        protected $_width=null;
        protected $_height=null;
        protected $_color="";
        protected $_parentcolor=1;
        protected $_enabled=1;
        protected $_hint="";
        protected $_designcolor="";
        protected $_align=alNone;
        protected $_alignment=agNone;
        protected $_onbeforeshow=null;
        protected $_onaftershow=null;
        protected $_onshow=null;
        protected $_cursor="";
        protected $_showhint=0;
        protected $_parentshowhint=1;

        protected $_font=null;

        protected $_islayer=0;
        protected $_parentfont=1;

        private $_doparentreset = true;

        protected $_jsonactivate=null;
        protected $_jsondeactivate=null;
        protected $_jsonbeforecopy=null;
        protected $_jsonbeforecut=null;
        protected $_jsonbeforedeactivate=null;
        protected $_jsonbeforeeditfocus=null;
        protected $_jsonbeforepaste=null;
        protected $_jsonblur=null;
        protected $_jsonchange=null;
        protected $_jsonclick=null;
        protected $_jsoncontextmenu=null;
        protected $_jsoncontrolselect=null;
        protected $_jsoncopy=null;
        protected $_jsoncut=null;
        protected $_jsondblclick=null;
        protected $_jsondrag=null;
        protected $_jsondragenter=null;
        protected $_jsondragleave=null;
        protected $_jsondragover=null;
        protected $_jsondragstart=null;
        protected $_jsondrop=null;
        protected $_jsonfilterchange=null;
        protected $_jsonfocus=null;
        protected $_jsonhelp=null;
        protected $_jsonkeydown=null;
        protected $_jsonkeypress=null;
        protected $_jsonkeyup=null;
        protected $_jsonlosecapture=null;
        protected $_jsonmousedown=null;
        protected $_jsonmouseup=null;
        protected $_jsonmouseenter=null;
        protected $_jsonmouseleave=null;
        protected $_jsonmousemove=null;
        protected $_jsonmouseout=null;
        protected $_jsonmouseover=null;
        protected $_jsonpaste=null;
        protected $_jsonpropertychange=null;
        protected $_jsonreadystatechange=null;
        protected $_jsonresize=null;
        protected $_jsonresizeend=null;
        protected $_jsonresizestart=null;
        protected $_jsonselectstart=null;

        protected function readjsOnActivate                () { return $this->_jsonactivate; }
        protected function readjsOnDeactivate              () { return $this->_jsondeactivate; }
        protected function readjsOnBeforeCopy              () { return $this->_jsonbeforecopy; }
        protected function readjsOnBeforeCut               () { return $this->_jsonbeforecut; }
        protected function readjsOnBeforeDeactivate        () { return $this->_jsonbeforedeactivate; }
        protected function readjsOnBeforeEditfocus         () { return $this->_jsonbeforeeditfocus; }
        protected function readjsOnBeforePaste             () { return $this->_jsonbeforepaste; }
        protected function readjsOnBlur                    () { return $this->_jsonblur; }
        protected function readjsOnChange                  () { return $this->_jsonchange; }
        protected function readjsOnClick                   () { return $this->_jsonclick; }
        protected function readjsOnContextMenu             () { return $this->_jsoncontextmenu; }
        protected function readjsOnControlSelect           () { return $this->_jsoncontrolselect; }
        protected function readjsOnCopy                    () { return $this->_jsoncopy; }
        protected function readjsOnCut                     () { return $this->_jsoncut; }
        protected function readjsOnDblClick                () { return $this->_jsondblclick; }
        protected function readjsOnDrag                    () { return $this->_jsondrag; }
        protected function readjsOnDragEnter               () { return $this->_jsondragenter; }
        protected function readjsOnDragLeave               () { return $this->_jsondragleave; }
        protected function readjsOnDragOver                () { return $this->_jsondragover; }
        protected function readjsOnDragStart               () { return $this->_jsondragstart; }
        protected function readjsOnDrop                    () { return $this->_jsondrop; }
        protected function readjsOnFilterChange            () { return $this->_jsonfilterchange; }
        protected function readjsOnFocus                   () { return $this->_jsonfocus; }
        protected function readjsOnHelp                    () { return $this->_jsonhelp; }
        protected function readjsOnKeyDown                 () { return $this->_jsonkeydown; }
        protected function readjsOnKeyPress                () { return $this->_jsonkeypress; }
        protected function readjsOnKeyUp                   () { return $this->_jsonkeyup; }
        protected function readjsOnLoseCapture             () { return $this->_jsonlosecapture; }
        protected function readjsOnMouseDown               () { return $this->_jsonmousedown; }
        protected function readjsOnMouseUp                 () { return $this->_jsonmouseup; }
        protected function readjsOnMouseEnter              () { return $this->_jsonmouseenter; }
        protected function readjsOnMouseLeave              () { return $this->_jsonmouseleave; }
        protected function readjsOnMouseMove               () { return $this->_jsonmousemove; }
        protected function readjsOnMouseOut                () { return $this->_jsonmouseout; }
        protected function readjsOnMouseOver               () { return $this->_jsonmouseover; }
        protected function readjsOnPaste                   () { return $this->_jsonpaste; }
        protected function readjsOnPropertyChange          () { return $this->_jsonpropertychange; }
        protected function readjsOnReadyStateChange        () { return $this->_jsonreadystatechange; }
        protected function readjsOnResize                  () { return $this->_jsonresize; }
        protected function readjsOnResizeEnd               () { return $this->_jsonresizeend; }
        protected function readjsOnResizeStart             () { return $this->_jsonresizestart; }
        protected function readjsOnSelectStart             () { return $this->_jsonselectstart; }

        protected function writejsOnActivate($value)                { $this->_jsonactivate=$value; }
        protected function writejsOnDeactivate($value)              { $this->_jsondeactivate=$value; }
        protected function writejsOnBeforeCopy($value)              { $this->_jsonbeforecopy=$value; }
        protected function writejsOnBeforeCut($value)               { $this->_jsonbeforecut=$value; }
        protected function writejsOnBeforeDeactivate($value)        { $this->_jsonbeforedeactivate=$value; }
        protected function writejsOnBeforeEditfocus($value)         { $this->_jsonbeforeeditfocus=$value; }
        protected function writejsOnBeforePaste($value)             { $this->_jsonbeforepaste=$value; }
        protected function writejsOnBlur($value)                    { $this->_jsonblur=$value; }
        protected function writejsOnChange($value)                  { $this->_jsonchange=$value; }
        protected function writejsOnClick($value)                   { $this->_jsonclick=$value; }
        protected function writejsOnContextMenu($value)             { $this->_jsoncontextmenu=$value; }
        protected function writejsOnControlSelect($value)           { $this->_jsoncontrolselect=$value; }
        protected function writejsOnCopy($value)                    { $this->_jsoncopy=$value; }
        protected function writejsOnCut($value)                     { $this->_jsoncut=$value; }
        protected function writejsOnDblClick($value)                { $this->_jsondblclick=$value; }
        protected function writejsOnDrag($value)                    { $this->_jsondrag=$value; }
        protected function writejsOnDragEnter($value)               { $this->_jsondragenter=$value; }
        protected function writejsOnDragLeave($value)               { $this->_jsondragleave=$value; }
        protected function writejsOnDragOver($value)                { $this->_jsondragover=$value; }
        protected function writejsOnDragStart($value)               { $this->_jsondragstart=$value; }
        protected function writejsOnDrop($value)                    { $this->_jsondrop=$value; }
        protected function writejsOnFilterChange($value)            { $this->_jsonfilterchange=$value; }
        protected function writejsOnFocus($value)                   { $this->_jsonfocus=$value; }
        protected function writejsOnHelp($value)                    { $this->_jsonhelp=$value; }
        protected function writejsOnKeyDown($value)                 { $this->_jsonkeydown=$value; }
        protected function writejsOnKeyPress($value)                { $this->_jsonkeypress=$value; }
        protected function writejsOnKeyUp($value)                   { $this->_jsonkeyup=$value; }
        protected function writejsOnLoseCapture($value)             { $this->_jsonlosecapture=$value; }
        protected function writejsOnMouseDown($value)               { $this->_jsonmousedown=$value; }
        protected function writejsOnMouseUp($value)                 { $this->_jsonmouseup=$value; }
        protected function writejsOnMouseEnter($value)              { $this->_jsonmouseenter=$value; }
        protected function writejsOnMouseLeave($value)              { $this->_jsonmouseleave=$value; }
        protected function writejsOnMouseMove($value)               { $this->_jsonmousemove=$value; }
        protected function writejsOnMouseOut($value)                { $this->_jsonmouseout=$value; }
        protected function writejsOnMouseOver($value)               { $this->_jsonmouseover=$value; }
        protected function writejsOnPaste($value)                   { $this->_jsonpaste=$value; }
        protected function writejsOnPropertyChange($value)          { $this->_jsonpropertychange=$value; }
        protected function writejsOnReadyStateChange($value)        { $this->_jsonreadystatechange=$value; }
        protected function writejsOnResize($value)                  { $this->_jsonresize=$value; }
        protected function writejsOnResizeEnd($value)               { $this->_jsonresizeend=$value; }
        protected function writejsOnResizeStart($value)             { $this->_jsonresizestart=$value; }
        protected function writejsOnSelectStart($value)             { $this->_jsonselectstart=$value; }

        function defaultjsOnActivate                () { return null; }
        function defaultjsOnDeactivate              () { return null; }
        function defaultjsOnBeforeCopy              () { return null; }
        function defaultjsOnBeforeCut               () { return null; }
        function defaultjsOnBeforeDeactivate        () { return null; }
        function defaultjsOnBeforeEditfocus         () { return null; }
        function defaultjsOnBeforePaste             () { return null; }
        function defaultjsOnBlur                    () { return null; }
        function defaultjsOnChange                  () { return null; }
        function defaultjsOnClick                   () { return null; }
        function defaultjsOnContextMenu             () { return null; }
        function defaultjsOnControlSelect           () { return null; }
        function defaultjsOnCopy                    () { return null; }
        function defaultjsOnCut                     () { return null; }
        function defaultjsOnDblClick                () { return null; }
        function defaultjsOnDrag                    () { return null; }
        function defaultjsOnDragEnter               () { return null; }
        function defaultjsOnDragLeave               () { return null; }
        function defaultjsOnDragOver                () { return null; }
        function defaultjsOnDragStart               () { return null; }
        function defaultjsOnDrop                    () { return null; }
        function defaultjsOnFilterChange            () { return null; }
        function defaultjsOnFocus                   () { return null; }
        function defaultjsOnHelp                    () { return null; }
        function defaultjsOnKeyDown                 () { return null; }
        function defaultjsOnKeyPress                () { return null; }
        function defaultjsOnKeyUp                   () { return null; }
        function defaultjsOnLoseCapture             () { return null; }
        function defaultjsOnMouseDown               () { return null; }
        function defaultjsOnMouseUp                 () { return null; }
        function defaultjsOnMouseEnter              () { return null; }
        function defaultjsOnMouseLeave              () { return null; }
        function defaultjsOnMouseMove               () { return null; }
        function defaultjsOnMouseOut                () { return null; }
        function defaultjsOnMouseOver               () { return null; }
        function defaultjsOnPaste                   () { return null; }
        function defaultjsOnPropertyChange          () { return null; }
        function defaultjsOnReadyStateChange        () { return null; }
        function defaultjsOnResize                  () { return null; }
        function defaultjsOnResizeEnd               () { return null; }
        function defaultjsOnResizeStart             () { return null; }
        function defaultjsOnSelectStart             () { return null; }

        protected $_style="";

        function readStyle() { return $this->_style; }
        function writeStyle($value) { $this->_style=$value; }
        function defaultStyle() { return ""; }

        protected $_adjusttolayout="0";

        function readAdjustToLayout() { return $this->_adjusttolayout; }
        function writeAdjustToLayout($value) { $this->_adjusttolayout=$value; }
        function defaultAdjustToLayout() { return "0"; }

        function readStyleClass()
        {
            if ($this->_style!="")
            {
                $res=$this->_style;
                if ($res[0]=='.') $res=substr($res,1);
                return($res);
            }
            else return("");
        }



        /**
         * Constructor for the class
         *
         * @param $aowner The owner component for this class
         *
         * @return          An instance of this class
         */
        function __construct($aowner=null)
        {
                $this->_font=new Font();
                $this->_font->_control=$this;

                //Calls inherited constructor
                parent::__construct($aowner);
        }

        function loaded()
        {
                parent::loaded();
                $this->writePopupMenu($this->_popupmenu);
        }

        /**
         * Determines whether a control can be shown or not
         *
         *
         * @return          <code>true</code> if the control can be shown
         *                  <code>false</code> otherwise.
         */
        function canShow()
        {
                if ($this->_parent!=null)
                {
                        if ($this->_parent->inheritsFrom('CustomPanel'))
                        {
                                return(($this->_visible) && ($this->_parent->canShow()) && ((string)$this->_layer==(string)$this->_parent->ActiveLayer));
                        }
                        else
                        {
                                return(($this->_visible) && ($this->_parent->canShow()));
                        }
                }
                else return($this->_visible);
        }

        /**
         * Return assigned javascript events as attributes for the tag
         *
         * @return string
         */
        function readJsEvents()
        {
                $result="";

                if ($this->_jsonactivate!=null)  { $event=$this->_jsonactivate;  $result.=" onactivate=\"return $event(event)\" "; }
                if ($this->_jsondeactivate!=null)  { $event=$this->_jsondeactivate;  $result.=" ondeactivate=\"return $event(event)\" "; }
                if ($this->_jsonbeforecopy!=null)  { $event=$this->_jsonbeforecopy;  $result.=" onbeforecopy=\"return $event(event)\" "; }
                if ($this->_jsonbeforecut!=null)  { $event=$this->_jsonbeforecut;  $result.=" onbeforecut=\"return $event(event)\" "; }
                if ($this->_jsonbeforedeactivate!=null)  { $event=$this->_jsonbeforedeactivate;  $result.=" onbeforedeactivate=\"return $event(event)\" "; }
                if ($this->_jsonbeforeeditfocus!=null)  { $event=$this->_jsonbeforeeditfocus;  $result.=" onbeforeeditfocus=\"return $event(event)\" "; }
                if ($this->_jsonbeforepaste!=null)  { $event=$this->_jsonbeforepaste;  $result.=" onbeforepaste=\"return $event(event)\" "; }
                if ($this->_jsonblur!=null)  { $event=$this->_jsonblur;  $result.=" onblur=\"return $event(event)\" "; }
                if ($this->_jsonchange!=null)  { $event=$this->_jsonchange;  $result.=" onchange=\"return $event(event)\" "; }
                if ($this->_jsonclick!=null)  { $event=$this->_jsonclick;  $result.=" onclick=\"return $event(event)\" "; }
                if ($this->_jsoncontextmenu!=null)  { $event=$this->_jsoncontextmenu;  $result.=" oncontextmenu=\"return $event(event)\" "; }
                if ($this->_jsoncontrolselect!=null)  { $event=$this->_jsoncontrolselect;  $result.=" oncontrolselect=\"return $event(event)\" "; }
                if ($this->_jsoncopy!=null)  { $event=$this->_jsoncopy;  $result.=" oncopy=\"return $event(event)\" "; }
                if ($this->_jsoncut!=null)  { $event=$this->_jsoncut;  $result.=" oncut=\"return $event(event)\" "; }
                if ($this->_jsondblclick!=null)  { $event=$this->_jsondblclick;  $result.=" ondblclick=\"return $event(event)\" "; }
                if ($this->_jsondrag!=null)  { $event=$this->_jsondrag;  $result.=" ondrag=\"return $event(event)\" "; }
                if ($this->_jsondragenter!=null)  { $event=$this->_jsondragenter;  $result.=" ondragenter=\"return $event(event)\" "; }
                if ($this->_jsondragleave!=null)  { $event=$this->_jsondragleave;  $result.=" ondragleave=\"return $event(event)\" "; }
                if ($this->_jsondragover!=null)  { $event=$this->_jsondragover;  $result.=" ondragover=\"return $event(event)\" "; }
                if ($this->_jsondragstart!=null)  { $event=$this->_jsondragstart;  $result.=" ondragstart=\"return $event(event)\" "; }
                if ($this->_jsondrop!=null)  { $event=$this->_jsondrop;  $result.=" ondrop=\"return $event(event)\" "; }
                if ($this->_jsonfilterchange!=null)  { $event=$this->_jsonfilterchange;  $result.=" onfilterchange=\"return $event(event)\" "; }
                if ($this->_jsonfocus!=null)  { $event=$this->_jsonfocus;  $result.=" onfocus=\"return $event(event)\" "; }
                if ($this->_jsonhelp!=null)  { $event=$this->_jsonhelp;  $result.=" onhelp=\"return $event(event)\" "; }
                if ($this->_jsonkeydown!=null)  { $event=$this->_jsonkeydown;  $result.=" onkeydown=\"return $event(event)\" "; }
                if ($this->_jsonkeypress!=null)  { $event=$this->_jsonkeypress;  $result.=" onkeypress=\"return $event(event)\" "; }
                if ($this->_jsonkeyup!=null)  { $event=$this->_jsonkeyup;  $result.=" onkeyup=\"return $event(event)\" "; }
                if ($this->_jsonlosecapture!=null)  { $event=$this->_jsonlosecapture;  $result.=" onlosecapture=\"return $event(event)\" "; }
                if ($this->_jsonmousedown!=null)  { $event=$this->_jsonmousedown;  $result.=" onmousedown=\"return $event(event)\" "; }
                // add the popup mouse up handler (the real mouseup event is wrapped by this event)
                if ($this->_enabled == 1 && $this->_popupmenu != null && !$this->inheritsFrom("QWidget"))
                {
                        $event="{$this->_name}Popup";  $result.=" onmouseup=\"return $event(event)\" ";
                }
                else
                {
                        if ($this->_jsonmouseup!=null)  { $event=$this->_jsonmouseup;  $result.=" onmouseup=\"return $event(event)\" "; }
                }
                if ($this->_jsonmouseenter!=null)  { $event=$this->_jsonmouseenter;  $result.=" onmouseenter=\"return $event(event)\" "; }
                if ($this->_jsonmouseleave!=null)  { $event=$this->_jsonmouseleave;  $result.=" onmouseleave=\"return $event(event)\" "; }
                if ($this->_jsonmousemove!=null)  { $event=$this->_jsonmousemove;  $result.=" onmousemove=\"return $event(event)\" "; }
                if ($this->_jsonmouseout!=null)  { $event=$this->_jsonmouseout;  $result.=" onmouseout=\"return $event(event)\" "; }
                if ($this->_jsonmouseover!=null)  { $event=$this->_jsonmouseover;  $result.=" onmouseover=\"return $event(event)\" "; }
                if ($this->_jsonpaste!=null)  { $event=$this->_jsonpaste;  $result.=" onpaste=\"return $event(event)\" "; }
                if ($this->_jsonpropertychange!=null)  { $event=$this->_jsonpropertychange;  $result.=" onpropertychange=\"return $event(event)\" "; }
                if ($this->_jsonreadystatechange!=null)  { $event=$this->_jsonreadystatechange;  $result.=" onreadystatechange=\"return $event(event)\" "; }
                if ($this->_jsonresize!=null)  { $event=$this->_jsonresize;  $result.=" onresize=\"return $event(event)\" "; }
                if ($this->_jsonresizeend!=null)  { $event=$this->_jsonresizeend;  $result.=" onresizeend=\"return $event(event)\" "; }
                if ($this->_jsonresizestart!=null)  { $event=$this->_jsonresizestart;  $result.=" onresizestart=\"return $event(event)\" "; }
                if ($this->_jsonselectstart!=null)  { $event=$this->_jsonselectstart;  $result.=" onselectstart=\"return $event(event)\" "; }

                return($result);
        }

        /**
         * Dumps a javascript named $event
         *
         * @param string $event
         */
        function dumpJSEvent($event)
        {
                if ($event!=null)
                {
                        echo "function $event(event)\n";
                        echo "{\n\n";
                        echo "var event = event || window.event;\n";            //To get the right event object
                        echo "var params=null;\n";                               //For Ajax calls

                        if ($this->inheritsFrom('CustomPage'))
                        {
                            $this->$event($this, array());
                        }
                        else
                        {
                            if ($this->owner!=null) $this->owner->$event($this, array());
                        }
                        echo "\n}\n";
                        echo "\n";
                }
        }

        /**
         * Dump Javascript events
         *
         */
        function dumpJsEvents()
        {
                $this->dumpJSEvent($this->_jsonactivate);
                $this->dumpJSEvent($this->_jsondeactivate);
                $this->dumpJSEvent($this->_jsonbeforecopy);
                $this->dumpJSEvent($this->_jsonbeforecut);
                $this->dumpJSEvent($this->_jsonbeforedeactivate);
                $this->dumpJSEvent($this->_jsonbeforeeditfocus);
                $this->dumpJSEvent($this->_jsonbeforepaste);
                $this->dumpJSEvent($this->_jsonblur);
                $this->dumpJSEvent($this->_jsonchange);
                $this->dumpJSEvent($this->_jsonclick);
                $this->dumpJSEvent($this->_jsoncontextmenu);
                $this->dumpJSEvent($this->_jsoncontrolselect);
                $this->dumpJSEvent($this->_jsoncopy);
                $this->dumpJSEvent($this->_jsoncut);
                $this->dumpJSEvent($this->_jsondblclick);
                $this->dumpJSEvent($this->_jsondrag);
                $this->dumpJSEvent($this->_jsondragenter);
                $this->dumpJSEvent($this->_jsondragleave);
                $this->dumpJSEvent($this->_jsondragover);
                $this->dumpJSEvent($this->_jsondragstart);
                $this->dumpJSEvent($this->_jsondrop);
                $this->dumpJSEvent($this->_jsonfilterchange);
                $this->dumpJSEvent($this->_jsonfocus);
                $this->dumpJSEvent($this->_jsonhelp);
                $this->dumpJSEvent($this->_jsonkeydown);
                $this->dumpJSEvent($this->_jsonkeypress);
                $this->dumpJSEvent($this->_jsonkeyup);
                $this->dumpJSEvent($this->_jsonlosecapture);
                $this->dumpJSEvent($this->_jsonmousedown);
                $this->dumpJSEvent($this->_jsonmouseup);
                $this->dumpJSEvent($this->_jsonmouseenter);
                $this->dumpJSEvent($this->_jsonmouseleave);
                $this->dumpJSEvent($this->_jsonmousemove);
                $this->dumpJSEvent($this->_jsonmouseout);
                $this->dumpJSEvent($this->_jsonmouseover);
                $this->dumpJSEvent($this->_jsonpaste);
                $this->dumpJSEvent($this->_jsonpropertychange);
                $this->dumpJSEvent($this->_jsonreadystatechange);
                $this->dumpJSEvent($this->_jsonresize);
                $this->dumpJSEvent($this->_jsonresizeend);
                $this->dumpJSEvent($this->_jsonresizestart);
                $this->dumpJSEvent($this->_jsonselectstart);
        }

        /**
         * Dump Javascript code required for this component to work
         *
         */
        function dumpJavascript()
        {
                $this->dumpJsEvents();

                if ($this->_enabled == 1 && $this->_popupmenu != null && !$this->inheritsFrom("QWidget"))
                {
                        echo "function {$this->_name}Popup(event)\n";
                        echo "{\n";
                        // add wrapper so the mouseup event still gets called
                        if ($this->_jsonmouseup != null)
                        {
                                // just to be sure it really exists...
                                echo "  if (typeof($this->_jsonmouseup) == 'function') $this->_jsonmouseup(event);\n";
                        }
                        echo "  var rightclick;\n";
                        echo "  if (!event) var event = window.event;\n";
                        echo "  if (event.which) rightclick = (event.which == 3);\n";
                        echo "  else if (event.button) rightclick = (event.button == 2);\n";

                        echo "  if (rightclick)\n";
                        echo "  {\n";
                        echo "     Show{$this->_popupmenu->Name}(event, 0);\n";
                        echo "  }\n";

                        // allow the event be handled by others
                        echo "  return true;\n";
                        echo "}\n";
                }
        }

        function dumpHeaderCode()
        {
                parent::dumpHeaderCode();

                // only dump the style sheet at design-time and if the style sheet is used by the sub-classed control
                if (($this->ControlState & csDesigning) == csDesigning && isset($this->_controlstyle['csRenderAlso']) && $this->_controlstyle['csRenderAlso'] == 'StyleSheet')
                {
                        if ($this->owner!=null)
                        {
                                $components=$this->owner->components->items;
                                reset($components);
                                while (list($k,$v)=each($components))
                                {
                                        if ($v->inheritsFrom('StyleSheet'))
                                        {
                                            $v->dumpHeaderCode();
                                        }
                                }
                        }
                }
        }

        /**
        * This function returns the attribute for the hint that can be included
        * in any tag. The attribute's name is "title".
        *
        * @return string If the hint is defined and can be shown a string with
        *                the attribute, otherwise an empty string.
        */
        protected function getHintAttribute()
        {
                $hint = "";
                if ($this->_hint != "")
                {
                        $hintspecial = htmlspecialchars($this->_hint, ENT_QUOTES);
                        if ($this->_showhint)
                        {
                                $hint = "title=\"$hintspecial\"";
                        }
                }
                return $hint;
        }
        

        /**
         * Show control contents
         *
         * @param boolean $return_contents return contents as string or dump to output
         * @return string
         */
        function show($return_contents=false)
        {
                global $output_enabled;

                if ($output_enabled)
                {
                        $this->callEvent('onbeforeshow',array());
                        //A call to show, will dump out control code
                        if ($return_contents) ob_start();
                        $this->dumpContents();
                        if ($return_contents)
                        {
                                $contents=ob_get_contents();
                                ob_end_clean();
                        }
                        $this->callEvent('onaftershow',array());

                        if ($return_contents)
                        {
                                return($contents);
                        }
                }
        }

        /**
         * Dump all children components
         *
         */
        function dumpChildren()
        {

        }

        /**
         * Dump the control contents, inherit and fill this method with the code
         * your control must generate
         *
         */
        function dumpContents()
        {
                //Inherit and fill this method to show up your control
        }

        
        /**
        * Add or replace the JS event attribute with the wrapper.
        * The wrapper is used to notify the PHP script that a event occured. The
        * script then may fire an event itself (for example OnClick of a button).
        *
        * @param string $events A string that is empty or contains already
        *                       existing JS event-handlers. This string passed
        *                       by reference.
        * @param string $event String representation of the event (ex. $this->_onclick;)
        * @param string $jsEvent String representation of the JS event (ex. $this->_jsonclick;)
        * @param string $jsEventAttr Name of attribute for the JS event (ex. "onclick")
        */
        protected function addJSWrapperToEvents(&$events, $event, $jsEvent, $jsEventAttr)
        {
                if ($event != null)
                {
                        $wrapperEvent = $this->getJSWrapperFunctionName($event);
                        $submitEventValue = $this->getJSWrapperSubmitEventValue($event);
                        $hiddenfield = $this->getJSWrapperHiddenFieldName();
                        $hiddenfield = ($this->owner != null) ? "document.forms[0].$hiddenfield" : "null";
                        if ($jsEvent != null)
                        {
                                $events = str_replace("$jsEventAttr=\"return $jsEvent(event)\"",
                                                      "$jsEventAttr=\"return $wrapperEvent(event, $hiddenfield, '$submitEventValue', $jsEvent)\"",
                                                      $events);
                        }
                        else
                        {
                                $events .= " $jsEventAttr=\"return $wrapperEvent(event, $hiddenfield, '$submitEventValue')\" ";
                        }
                }
        }

        /**
        * Get the function name of a JS event wrapper.
        *
        * @param string $event String representation of the event (ex. $this->_onclick;)
        * @return string Name of the function
        */
        protected function getJSWrapperFunctionName($event)
        {
                $res = ($event != null) ? $event."Wrapper" : "";
                return $res;
        }

        /**
        * JS wrapper function that forwards a JS event to the PHP script by
        * submitting the HTML form.
        * It is the responsiblity of the component to add this function to the
        * <javascript> section in the HTML header. Usually this is done in the
        * dumpJavascript() function of the component.
        *
        * @param string $event String representation of the event (ex. $this->_onclick;)
        * @return string Returns the whole JS wrapper function for the $event.
        */
        protected function getJSWrapperFunction($event)
        {
                $res = "";
                if ($event != null)
                {
                        $funcName = $this->getJSWrapperFunctionName($event);

                        $res .= "function $funcName(event, hiddenfield, submitvalue, wrappedfunc)\n";
                        $res .= "{\n\n";
                        $res .= "var event = event || window.event;\n";

                        $res .= "submit1=true;\n";
                        $res .= "submit2=true;\n";

                        // call the user defined JS function first, if it exists
                        $res .= "if (typeof(wrappedfunc) == 'function') submit1=wrappedfunc(event);\n";

                        // set the hidden field value so we later know which event was fired
                        $res .= "hiddenfield.value = submitvalue;\n";

                        // submit the form
                        $res .= "if ((hiddenfield.form.onsubmit) && (typeof(hiddenfield.form.onsubmit) == 'function')) submit2=hiddenfield.form.onsubmit();\n";
                        $res .= "if ((submit1) && (submit2)) hiddenfield.form.submit();\n";

                        // make sure the event handler of element does not handle
                        // the JS event again (this might happen with a submit button)
                        $res .= "return false;\n";

                        $res .= "\n}\n";
                        $res .= "\n";
                }
                return $res;
        }

        /**
        * Get the name of the hidden field used to submit the value which event
        * was fired.
        * There is should one hidden field for each component that can forward
        * JS event to the PHP script. It is the responsiblity of the component to
        * add this field.
        *
        * @return string Name of the hidden field
        */
        protected function getJSWrapperHiddenFieldName()
        {
                return "{$this->_name}SubmitEvent";
        }

        /**
        * Value set to the hidden field when the specific JS event was fired and
        * the wrapper function was called.
        * Have a look at getJSWrapperFunction(), that is where the value gets set
        * to the hidden field.
        * It is also used in the component to check if the defined $event has been
        * fired on the page. This should be done in the init() function of the
        * component.
        *
        * @param string $event String representation of the event (ex. $this->_onclick;)
        * @return string The value that will be set in the hidden input.
        */
        protected function getJSWrapperSubmitEventValue($event)
        {
                return "{$this->_name}_$event";
        }

        //Protected properties

        /*
        function setName($value)
        {
                $oldname=$this->_name;
                parent::setName($value);

                //Sets the caption if not already changed
                if (!$this->_caption==$oldname)
                {
                        $this->_caption=$this->_name;
                }
        }
        */

        function readDoParentReset() { return $this->_doparentreset; }

        /**
         * Returns the caption property
         * @return string
         */
        protected function readCaption() { return $this->_caption; }
        protected function writeCaption($value) { $this->_caption=$value; }
        function defaultCaption() { return ""; }

        /**
         * Returns the color property
         * @return string
         */
        protected function readColor() { return $this->_color;     }
        protected function writeColor($value)
        {
                if ($this->_color!=$value)
                {
                        $this->_color=$value;

                        if (($this->ControlState & csLoading) != csLoading)
                        {
                                // update the children
                                if ($this->methodExists("updateChildrenColors"))
                                {
                                        $this->updateChildrenColors();
                                }

                                // check if the ParentColor property cn be reset
                                if ($this->_doparentreset)
                                {
                                        $this->_parentcolor=0;
                                }
                        }
                }
        }
        function defaultColor() { return "";     }

        //Enabled property
        protected function readEnabled() { return $this->_enabled; }
        protected function writeEnabled($value) { $this->_enabled=$value; }
        function defaultEnabled() { return 1; }

        //PopupMenu property
        protected function readPopupMenu() { return $this->_popupmenu; }
        protected function writePopupMenu($value) { $this->_popupmenu= $this->fixupProperty($value); }
        function defaultPopupmenu() { return null; }

        /**
        * Determines where a control looks for its color information.
        *
        * To have a control use the same color as its parent control,
        * set ParentColor to true. If ParentColor is false,
        * the control uses its own Color property.
        */
        protected function readParentColor() { return $this->_parentcolor; }
        protected function writeParentColor($value)
        {
                if ($this->_parentcolor!=$value && $this->_doparentreset)
                {
                        $this->_parentcolor=$value;
                        // only change the color if parentcolor is set to true;
                        // otherwise leave it as it is
                        if ($this->_parentcolor == 1)
                        {
                                if ($this->_parent!=null)
                                {
                                        // set the color through writeColor() so child controls are updated too
                                        $this->writeColor($this->_parent->_color);
                                }
                                else
                                {
                                        $this->_color="";
                                }
                        }
                }
        }
        function defaultParentColor() { return true;     }

        //Font property
        protected function readFont() { return $this->_font;       }
        protected function writeFont($value)
        {
                if (is_object($value))
                {
                        $this->_font=$value;

                        if (($this->ControlState & csLoading) != csLoading)
                        {
                                // update the children
                                if ($this->methodExists("updateChildrenFonts"))
                                {
                                        $this->updateChildrenFonts();
                                }

                                // check if the ParentFont property cn be reset
                                if ($this->_doparentreset)
                                {
                                        $this->_parentfont=0;
                                }
                        }
                }
        }

        //IsLayer property
        protected function readIsLayer() { return $this->_islayer; }
        protected function writeIsLayer($value) { $this->_islayer=$value; }
        function defaultIsLayer() { return 0; }

        /**
        * Determines where a control looks for its font information.
        *
        * To have a control use the same font as its parent control,
        * set ParentFont to true. If ParentFont is false,
        * the control uses its own Font property.
        */
        protected function readParentFont() { return $this->_parentfont; }
        protected function writeParentFont($value)
        {
                if ($this->_parentfont!=$value && $this->_doparentreset)
                {
                        $this->_parentfont=$value;

                        // only change the font if parentfont is set to true;
                        // otherwise leave it as it is
                        if ($this->_parentfont == 1)
                        {
                                if ($this->_parent!=null)
                                {
                                        // do not allow to update ParentFont while assigning
                                        // the parent font to this control, otherwise the
                                        // Font::modified() function will try to set $this->ParentFont to false
                                        // because the font has changed.
                                        $this->_doparentreset = false;

                                        $this->Parent->Font->assignTo($this->Font);

                                        $this->_parentfont = 1;
                                        $this->_doparentreset = true;
                                }
                                else
                                {
                                        $this->_font=null;
                                }
                        }
                }
        }
        function defaultParentFont() { return 1; }



        //Public properties

        protected $_layer=0;

        function getLayer() { return $this->_layer; }
        function setLayer($value) { $this->_layer=$value; }
        function defaultLayer() { return 0; }



        //Align property
        function readAlign() { return $this->_align;     }
        function writeAlign($value) { $this->_align=$value; }
        function defaultAlign() { return alNone;     }

        //TODO: Check if alignment,color and designcolor must be here or not
        //Alignment property
        function readAlignment() { return $this->_alignment;     }
        function writeAlignment($value) { $this->_alignment=$value; }
        function defaultAlignment() { return agNone;     }


        //DesignColor property
        function readDesignColor() { return $this->_designcolor;     }
        function writeDesignColor($value) { $this->_designcolor=$value; }
        function defaultDesignColor() { return "";     }

        /**
        * Determines whether the control displays a Help Hint
        * when the mouse pointer rests momentarily on the control.
        */
        function readShowHint() { return $this->_showhint;     }
        function writeShowHint($value)
        {
                if ($value!=$this->_showhint)
                {
                        $this->_showhint=$value;

                        if (($this->ControlState & csLoading) != csLoading)
                        {
                                // update the children
                                if ($this->methodExists("updateChildrenShowHints"))
                                {
                                        $this->updateChildrenShowHints();
                                }

                                if ($this->_doparentreset)
                                {
                                        $this->_parentshowhint=0;
                                }
                        }
                }

        }
        function defaultShowHint() { return 0;     }

        /**
        * Determines where a control looks to find out if its Help Hint
        * should be shown.
        *
        * Use ParentShowHint to ensure that all the controls on a form
        * either uniformly show their Help Hints or uniformly do not show them.
        *
        * If ParentShowHint is true, the control uses the ShowHint property
        * value of its parent. If ParentShowHint is false, the control uses
        * the value of its own ShowHint property.
        *
        * To provide Help Hints for only selected controls on a form,
        * set the ShowHint property for those controls that should have
        * Help Hints to true, and ParentShowHint becomes false automatically.
        *
        * Note:   Enable or disable all Help Hints for the entire application
        *         using the ShowHint property of the application object.
        */
        function readParentShowHint() { return $this->_parentshowhint;     }
        function writeParentShowHint($value)
        {
                if ($this->_parentshowhint!=$value && $this->_doparentreset)
                {
                        $this->_parentshowhint=$value;
                        // only change the showhint if parentshowhint is set to true;
                        // otherwise leave it as it is
                        if ($this->_parentshowhint == 1)
                        {
                                if ($this->_parent!=null)
                                {
                                        //$this->_showhint=$this->_parent->_showhint;
                                        $this->writeShowHint($this->_parent->_showhint);
                                }
                                else
                                {
                                        $this->_showhint=0;
                                }
                        }
                }
        }
        function defaultParentShowHint() { return 1; }

        /**
        * Updates all properties that use the parent property as source.
        * These include ShowHint, Color and Font.
        */
        function updateParentProperties()
        {
                $this->updateParentFont();
                $this->updateParentColor();
                $this->updateParentShowHint();
        }

        /**
        * If ParentFont == true the parent's font is assigned to this control.
        */
        function updateParentFont()
        {
                if ($this->_parent!=null)
                {
                        if (is_object($this->_parent))
                        {
                                $this->_doparentreset = false;
                                if ($this->_parentfont)
                                {
                                    $this->_parent->_font->assignTo($this->Font);
                                }
                                $this->_doparentreset = true;
                        }
                }
        }

        /**
        * If ParentColor == true the parent's color is assigned to this control.
        */
        function updateParentColor()
        {
                if ($this->_parent!=null)
                {
                        if (is_object($this->_parent))
                        {
                                $this->_doparentreset = false;
                                if ($this->_parentcolor)    $this->writeColor($this->_parent->_color);
                                $this->_doparentreset = true;
                        }
                }
        }

        /**
        * If ParentShowHint == true the parent's showhint is assigned to this control.
        */
        function updateParentShowHint()
        {
                if ($this->_parent!=null)
                {
                        if (is_object($this->_parent))
                        {
                                $this->_doparentreset = false;
                                if ($this->_parentshowhint) $this->writeShowHint($this->_parent->_showhint);
                                $this->_doparentreset = true;
                        }
                }
        }


        //Visible property
        function readVisible() { return $this->_visible; }
        function writeVisible($value) { $this->_visible=$value; }
        function defaultVisible() { return 1; }

        //Parent property
        function readParent() { return $this->_parent; }
        function writeParent($value)
        {
                //Remove component from the previous parent, if any
                if (is_object($this->_parent)) $this->_parent->controls->remove($this);

                //Store
                $this->_parent=$value;

                //Adds this component to the parent's control list
                if (is_object($this->_parent))
                {
                        $this->_parent->controls->add($this);
                }
        }

        //ControlStyle property
        function readControlStyle() { return($this->_controlstyle); }
        function writeControlStyle($value)
        {
                $pieces=split("=",$value);
                $this->_controlstyle[$pieces[0]]=$pieces[1];
        }

        function writeControlState($value)
        {
                $oldstate = $this->_controlstate;
                parent::writeControlState($value);

                // Detect when the state changes after loading has finished
                // ($oldvalue has csLoading, $value does not have it)
                if (($oldstate & csLoading) == csLoading && ($value & csLoading) != csLoading)
                {
                        // Update the parent properties after the loading to ensure all properties
                        // were read from the stream and set.
                        // At the moment of writeParent() the control does not have
                        // the properties initialized because it's the first property set.

                        // Update all controls that accept controls inside itself, but do not update the
                        // root (usually Page) control.
                        if ((isset($this->_controlstyle["csAcceptsControls"])) && ($this->_controlstyle["csAcceptsControls"] == "1" && $this->_parent != null))
                        {
                                // check if the parent control will not update this container;
                                // if $this->_parentcolor == 1 then it will be updated by the parent
                                // (and also all children of this control)
                                if ($this->_parentcolor == 0)
                                {
                                        if ($this->methodExists("updateChildrenColors"))
                                        {
                                                // check if there are any children that have $this->_parentcolor == 1
                                                // if there are, update them
                                                $this->updateChildrenColors();
                                        }
                                }
                                // same comment as $this->_parentcolor
                                if ($this->_parentfont == 0)
                                {
                                        if ($this->methodExists("updateChildrenFonts"))
                                        {
                                                $this->updateChildrenFonts();
                                        }
                                }
                                // same comment as $this->_parentcolor
                                if ($this->_parentshowhint == 0)
                                {
                                        if ($this->methodExists("updateChildrenShowHints"))
                                        {
                                                $this->updateChildrenShowHints();
                                        }
                                }
                        }
                        // put the Page (parent == null) to the end of the if-statement because it's called only once
                        else if ($this->_parent == null && $this->methodExists("updateChildrenParentProperties"))
                        {
                                $this->updateChildrenParentProperties();
                        }
                }
        }


        //Published

        //Left property
        function getLeft() { return $this->_left; }
        function setLeft($value) { $this->_left=$value; }
        function defaultLeft() { return 0; }        

        //Top property
        function getTop() { return $this->_top; }
        function setTop($value) { $this->_top=$value; }
        function defaultTop() { return 0; }

        //Width property
        function getWidth() { return $this->_width; }
        function setWidth($value) { $this->_width=$value; }
        function defaultWidth() { return 0; }

        //Height property
        function getHeight() { return $this->_height; }
        function setHeight($value) { $this->_height=$value; }
        function defaultHeight() { return 0; }

        //Cursor property
        function getCursor() { return $this->_cursor; }
        function setCursor($value) { $this->_cursor=$value; }
        function defaultCursor() { return ""; }

        //Hint property
        function getHint() { return $this->_hint; }
        function setHint($value) { $this->_hint=$value; }
        function defaultHint() { return ""; }


        //Events

        //OnBeforeShow event
        function getOnBeforeShow() { return $this->_onbeforeshow; }
        function setOnBeforeShow($value) { $this->_onbeforeshow=$value; }
        function defaultOnBeforeShow() { return null; }

        //OnAfterShow event
        function getOnAfterShow() { return $this->_onaftershow; }
        function setOnAfterShow($value) { $this->_onaftershow=$value; }
        function defaultOnAfterShow() { return null; }

        //OnShow event
        function getOnShow() { return $this->_onshow; }
        function setOnShow($value) { $this->_onshow=$value; }
        function defaultOnShow() { return null; }
}

/**
 * FocusControl class
 *
 * Base class for controls with input focus
 */
class FocusControl extends Control
{
        protected $_layout=null;

        public    $controls;

        /**
        * If this control has any children that have ParentFont==true then
        * this function will assign the Font property to all children Font properties.
        * Note: This must be in FocusControl, not in Control, as it's here where the controls property is defined
        */
        function updateChildrenFonts()
        {
                //Iterates through all child controls and assign the new font
                //to all that have ParentFont=true
                reset($this->controls->items);
                while (list($k,$v) = each($this->controls->items))
                {
                        if ($v->ParentFont)
                        {
                                $v->updateParentFont();
                        }
                }
        }

        function updateChildrenColors()
        {
                //Iterates through all child controls and assign the new color
                //to all that have ParentColor=true
                reset($this->controls->items);
                while (list($k,$v) = each($this->controls->items))
                {
                        if ($v->ParentColor)
                        {
                                $v->updateParentColor();
                        }
                }
        }

        function updateChildrenShowHints()
        {
                //Iterates through all child controls and assign the new showhint
                //to all that have ParentShowHint=true
                reset($this->controls->items);
                while (list($k,$v) = each($this->controls->items))
                {
                        if ($v->ParentShowHint)
                        {
                                $v->updateParentShowHint();
                        }
                }
        }

        /**
        * If this control has any children that use a property's value from the parent then
        * this function will update all necessary properties.
        * Note: This must be in FocusControl, not in Control, as it's here where the controls property is defined
        */
        function updateChildrenParentProperties()
        {
                //Iterates through all child controls and assign the new font
                //to all that have ParentFont=true
                reset($this->controls->items);
                while (list($k,$v) = each($this->controls->items))
                {
                        // first check if it is really necessary to update the parent properties
                        if ($v->ParentColor || $v->ParentFont || $v->ParentShowHint)
                        {
                                $v->updateParentProperties();
                        }
                }
        }


        function __construct($aowner=null)
        {
                //Creates the controls list
                $this->controls=new Collection();

                //Calls inherited constructor
                parent::__construct($aowner);

                $this->_layout=new Layout();
                $this->_layout->_control=$this;
        }

        function readControlCount() { return $this->controls->count(); }

        //Layout property
        function readLayout() { return $this->_layout; }
        function writeLayout($value) { if (is_object($value)) $this->_layout=$value; }


        function dumpChildren()
        {
                //Iterates through controls calling show for all of them
                reset($this->controls->items);
                while (list($k,$v)=each($this->controls->items))
                {
                        $v->show();
                }

        }
}

/**
 * CustomControl class
 *
 * Base class for custom control
 */
class CustomControl extends FocusControl
{
}

/**
 * GraphicControl class
 *
 * Base class for controls with graphic capabilities
 */
class GraphicControl extends CustomControl
{
}

/**
* CustomListControl
*
* CustomListControl is the base class for controls that display a list of items.
*/
abstract class CustomListControl extends FocusControl
{
        protected $_itemindex = -1;

        /**
        * Returns the number of items in the list.
        * @return integer Number of items in the list.
        */
        abstract function readCount();

        /**
        * Returns the value of the ItemIndex property.
        * @return mixed Return the ItemIndex of the list.
        */
        abstract function readItemIndex();

        /**
        * Set new ItemIndex value.
        * @param mixed $value Value of the new ItemIndex.
        */
        abstract function writeItemIndex($value);

        /**
        * Return default ItemIndex.
        * @return mixed Returns default ItemIndex.
        */
        abstract function defaultItemIndex();

        /**
        * Adds an item to the list control.
        * @param mixed $item Value of item to add.
        * @param mixed $object Object to assign to the $item. is_object() is used to
        *                      test if $object is an object.
        * @param mixed $itemkey Key of the item in the array. Default key is used if null.
        * @return integer Return the number of items in the list.
        */
        abstract function AddItem($item, $object = null, $itemkey = null);

        /**
        * Deletes all of the items from the list control.
        */
        abstract function Clear();

        /**
        * Removes the selection, leaving all items unselected.
        */
        abstract function ClearSelection();
        //abstract function CopySelection($destination);
        //abstract function DeleteSelection();
        //abstract function MoveSelection($destination);

        /**
        * Selects all items or all text in the selected item.
        */
        abstract function SelectAll();
}

abstract class CustomMultiSelectListControl extends CustomListControl
{
        protected $_multiselect = 0;

        /**
        * Returns how many items are selected in the list.
        * @return integer Returns how many items are selected in the list.
        */
        abstract function readSelCount();

        /**
        * Reads the value of the MultiSelect property.
        * @return bool Returns if the list is MultiSelect or not.
        */
        abstract function readMultiSelect();

        /**
        * Sets the value of the MultiSelect property.
        * @param bool $value Set MultiSelect to true or false.
        */
        abstract function writeMultiSelect($value);

        /**
        * Return default MultiSelect value.
        * @return bool Returns default MultiSelect value.
        */
        abstract function defaultMultiSelect();
}

?>
