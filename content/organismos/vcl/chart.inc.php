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
use_unit('libchart/libchart/libchart.php');

//ChartTypes
define('ctHorizontalChart','ctHorizontalChart');
define('ctLineChart','ctLineChart');
define('ctPieChart','ctPieChart');
define('ctVerticalChart','ctVerticalChart');

/**
 * SimpleChart class
 *
 * A class to generate chart graphics.
 * The chart data currently can only be modified through code at run-time.
 *
 * The image is dynamically generated on each request.
 */
class SimpleChart extends GraphicControl
{
        protected $_onclick = null;

        protected $_chart = null;
        protected $_charttype = ctVerticalChart;

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width = 400;
                $this->Height = 250;

                // Make sure the framework knows that this component dumps binary image data
                $this->ControlStyle="csImageContent=1";

                $this->ControlStyle="csRenderOwner=1";
                $this->ControlStyle="csRenderAlso=StyleSheet";

                // Create the chart
                $this->createChart();
        }

        /**
        * Creates a new chart with the defined ChartType and updates the protected chart variable.
        * @return object Chart object.
        */
        function createChart()
        {
                switch($this->_charttype)
                {
                        case ctHorizontalChart: $this->_chart = new HorizontalChart($this->Width, $this->Height); break;
                        case ctLineChart: $this->_chart = new LineChart($this->Width, $this->Height); break;
                        case ctPieChart: $this->_chart = new PieChart($this->Width, $this->Height); break;
                        case ctVerticalChart: $this->_chart = new VerticalChart($this->Width, $this->Height); break;
                }

                return $this->_chart;
        }

        /**
        * Call fillDummyValues() to fill the chart with some dummy values.
        * Only fill dummy values at design time.
        */
        function fillDummyValues()
        {
                if (($this->ControlState & csDesigning) == csDesigning)
                {
                        $this->_chart->setTitle("Preferred Web Language");

                        $this->_chart->addPoint(new Point("Perl", 50));
                        $this->_chart->addPoint(new Point("PHP", 75));
                        $this->_chart->addPoint(new Point("Java", 30));
                }
        }

        /**
        * Clear all data of the chart (including titles, points, axes, ..)
        */
        function clearChart()
        {
                // just call the reset function
                $this->_chart->reset();
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
                }
        }

        function dumpHeaderCode()
        {
                parent::dumpHeaderCode();
                // only dump the header if not in design mode
                if (($this->ControlState & csDesigning) != csDesigning)
                {
                        // try to make the browser not to cache the image
                        echo "<META HTTP-EQUIV=\"Pragma\" CONTENT=\"no-cache\" />\n";
                }
        }

        /**
         * Dump the chart graphic.
         */
        function dumpGraphic()
        {
                // It's a graphic component that dumps binary data
                header("Content-type: image/png");

                // try to make the browser not to cache the image
                header("Pragma: no-cache");
                header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
                header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past

                $this->_chart->height = $this->Height;
                $this->_chart->width = $this->Width;

                $this->_chart->render();
        }

        function serialize()
        {
                parent::serialize();

                // serialize the chart manually; there is no support for serialization
                // by the libchart; so it's done externally
                $owner = $this->readOwner();
                if ($owner != null)
                {
                        $prefix = $owner->readNamePath().".".$this->_name.".Chart.";

                        if (is_object($this->_chart->text))
                        {
                                $_SESSION[$prefix."Text"] = $this->_chart->text;
                        }
                        if (is_array($this->_chart->point))
                        {
                                $_SESSION[$prefix."Points"] = $this->_chart->point;
                        }

                        $_SESSION[$prefix."Title"] = $this->_chart->title;
                        $_SESSION[$prefix."LogoFileName"] = $this->_chart->logoFileName;
                        $_SESSION[$prefix."Margin"] = $this->_chart->margin;
                        $_SESSION[$prefix."LowerBound"] = $this->_chart->lowerBound;
                        $_SESSION[$prefix."LabelMarginLeft"] = $this->_chart->labelMarginLeft;
                        $_SESSION[$prefix."LabelMarginRight"] = $this->_chart->labelMarginRight;
                        $_SESSION[$prefix."LabelMarginTop"] = $this->_chart->labelMarginTop;
                        $_SESSION[$prefix."LabelMarginBottom"] = $this->_chart->labelMarginBottom;
                }
        }

        function unserialize()
        {
                parent::unserialize();

                // first manually unserialize the chart
                $owner = $this->readOwner();
                if ($this->_chart != null && $owner != null)
                {
                        $prefix = $owner->readNamePath().".".$this->_name.".Chart.";

                        if (is_object($_SESSION[$prefix."Text"]))
                                $this->_chart->text = $_SESSION[$prefix."Text"];
                        if(is_array($_SESSION[$prefix."Points"]))
                                $this->_chart->point = $_SESSION[$prefix."Points"];

                        if (isset($_SESSION[$prefix."Title"]))
                                $this->_chart->title = $_SESSION[$prefix."Title"];
                        if (isset($_SESSION[$prefix."LogoFileName"]))
                                $this->_chart->logoFileName = $_SESSION[$prefix."LogoFileName"];
                        if (isset($_SESSION[$prefix."Margin"]))
                                $this->_chart->margin = $_SESSION[$prefix."Margin"];
                        if (isset($_SESSION[$prefix."LowerBound"]))
                                $this->_chart->lowerBound = $_SESSION[$prefix."LowerBound"];
                        if (isset($_SESSION[$prefix."LabelMarginLeft"]))
                                $this->_chart->labelMarginLeft = $_SESSION[$prefix."LabelMarginLeft"];
                        if (isset($_SESSION[$prefix."LabelMarginRight"]))
                                $this->_chart->labelMarginRight = $_SESSION[$prefix."LabelMarginRight"];
                        if (isset($_SESSION[$prefix."LabelMarginTop"]))
                                $this->_chart->labelMarginTop = $_SESSION[$prefix."LabelMarginTop"];
                        if (isset($_SESSION[$prefix."LabelMarginBottom"]))
                                $this->_chart->labelMarginBottom = $_SESSION[$prefix."LabelMarginBottom"];
                }

                $key = md5($this->owner->Name.$this->Name.$this->Left.$this->Top.$this->Width.$this->Height);
                $bchart = $this->input->bchart;

                // check if the request is for this chart
                if ((is_object($bchart)) && ($bchart->asString() == $key))
                {
                        $this->dumpGraphic();
                }
        }

        function dumpContents()
        {
                if (($this->ControlState & csDesigning) == csDesigning)
                {
                        $this->fillDummyValues();
                        $this->dumpGraphic();
                }
                else
                {
                        $events = $this->readJsEvents();
                        // add or replace the JS events with the wrappers if necessary
                        $this->addJSWrapperToEvents($events, $this->_onclick,    $this->_jsonclick,    "onclick");

                        $hint = $this->getHintAttribute();
                        $alt = htmlspecialchars($this->_chart->title);
                        $style = "";
                        if ($this->Style=="")
                        {
                                // add the cursor to the style
                                if ($this->_cursor != "")
                                {
                                        $cr = strtolower(substr($this->_cursor, 2));
                                        $style .= "cursor: $cr;";
                                }
                        }

                        $class = ($this->Style != "") ? "class=\"$this->StyleClass\"" : "";

                        if ($style != "") $style = "style=\"$style\"";

                        if ($this->_onshow != null)
                        {
                                $this->callEvent('onshow', array());
                        }

                        $key = md5($this->owner->Name.$this->Name.$this->Left.$this->Top.$this->Width.$this->Height);
                        $url = $GLOBALS['PHP_SELF'];
                        // Output an image generated by an URL that request to this script
                        echo "<img src=\"$url?bchart=$key\" width=\"$this->Width\" height=\"$this->Height\" id=\"$this->_name\" name=\"$this->_name\" alt=\"$alt\" $hint $style $class $events />";

                        // add a hidden field so we can determine which event for the chart was fired
                        if ($this->_onclick != null)
                        {
                                $hiddenwrapperfield = $this->getJSWrapperHiddenFieldName();
                                echo "<input type=\"hidden\" id=\"$hiddenwrapperfield\" name=\"$hiddenwrapperfield\" value=\"\" />";
                        }
                }
        }

        /**
        * Write the Javascript section to the header
        */
        function dumpJavascript()
        {
                parent::dumpJavascript();

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

        /*
        * Publish the events for the component
        */

        /**
        * Occurs when the user clicks the control.
        * @return mixed Returns the event handler or null if no handler is set.
        */
        function getOnClick                     () { return $this->_onclick; }
        /**
        * Occurs when the user clicks the control.
        * @param mixed $value Event handler or null to unset.
        */
        function setOnClick                     ($value) { $this->_onclick=$value; }
        function defaultOnClick                 () { return null; }


        /*
        * Publish the JS events for the Chart component
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
        * Publish the properties for the component
        */

        /**
        * Chart object
        * Please have a look at the libchart class in order to understand the functionallity
        * of the chart object.
        */
        function readChart() { return $this->_chart; }

        /**
        * The type of chart to show
        * @return enum (ctHorizontalChart, ctLineChart, ctPieChart, ctVerticalChart)
        */
        function getChartType() { return $this->_charttype; }
        /**
        * The type of chart to show.
        * Note: Each time the chart type is changed the chart object has to be recreated.
        * @param enum (ctHorizontalChart, ctLineChart, ctPieChart, ctVerticalChart)
        */
        function setChartType($value)
        {
                if ($value != $this->_charttype)
                {
                        $this->_charttype = $value;
                        // since the chart type changed the chart has to be recreated
                        $this->createChart();
                }
        }
        function defaultChartType() { return ctVerticalChart; }

        function getHint() { return $this->_hint; }
        function setHint($value) { $this->_hint=$value; }

        function getParentShowHint() { return $this->readParentShowHint(); }
        function setParentShowHint($value) { $this->writeParentShowHint($value); }

        function getShowHint() { return $this->readShowHint(); }
        function setShowHint($value) { $this->writeShowHint($value); }

        function getStyle()             { return $this->readstyle(); }
        function setStyle($value)       { $this->writestyle($value); }

        function getVisible() { return $this->readVisible(); }
        function setVisible($value) { $this->writeVisible($value); }

}

?>
