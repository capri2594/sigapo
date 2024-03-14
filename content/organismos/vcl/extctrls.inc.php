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
use_unit("graphics.inc.php");
use_unit("imglist.inc.php");


/**
 * Shape.ShapeType
 */
define('stRectangle', 'stRectangle');
define('stSquare', 'stSquare');
define('stRoundRect', 'stRoundRect');
define('stRoundSquare', 'stRoundSquare');
define('stEllipse', 'stEllipse');
define('stCircle', 'stCircle');

/**
 * Bevel.Shape
 */
define('bsBox', 'bsBox');
define('bsFrame', 'bsFrame');
define('bsTopLine', 'bsTopLine');
define('bsBottomLine', 'bsBottomLine');
define('bsLeftLine', 'bsLeftLine');
define('bsRightLine', 'bsRightLine');
define('bsSpacer', 'bsSpacer');

/**
 * Bevel.Style
 */
define('bsLowered', 'bsLowered');
define('bsRaised', 'bsRaised');

/**
 * Image class
 *
 * A class to encapsulate and display an image.
 *
 * @package ExtCtrls
 */
class Image extends GraphicControl
{
        protected $_onclick = null;
        protected $_oncustomize = null;

        protected $_autosize=0;
        protected $_border=0;
        protected $_bordercolor="";
        protected $_center=0;
        protected $_datafield="";
        protected $_datasource=null;
        protected $_imagesource;
        protected $_link;
        protected $_linktarget;
        protected $_proportional=0;


        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width=105;
                $this->Height=105;

                //For mapshapes
                $this->ControlStyle="csAcceptsControls=1";

                $this->ControlStyle="csRenderOwner=1";
                $this->ControlStyle="csRenderAlso=StyleSheet";
        }


        /**
        * Returns the absolute image path.
        * @return string
        */
        private function getImageSourcePath()
        {
                // check if relative
                if (substr($this->_imagesource, 0, 2) == ".." || $this->_imagesource{0} == ".")
                {
                        return dirname($_SERVER['SCRIPT_FILENAME']).'/'.$this->_imagesource;
                }
                else
                {
                        return $this->_imagesource;
                }
        }

        function loaded()
        {
                parent::loaded();

                $this->setDataSource($this->_datasource);

                if ($this->_autosize)
                {
                        if ($this->_imagesource!="")
                        {
                                $result = getimagesize($this->getImageSourcePath());

                                if (is_array($result))
                                {
                                        $bordersize = ($this->_border == 1) ? 2*1 : 0;

                                        list($width, $height, $type, $attr) = $result;
                                        $this->Width = $width + $bordersize;
                                        $this->Height = $height + $bordersize;
                                }
                        }
                }

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

        function dumpContents()
        {
                if ($this->_onshow!=null)
                {
                        $this->callEvent('onshow',array());
                }
                else
                {
                        $map="";
                        if ($this->controls->count()>0)
                        {
                                $map = "usemap=\"#map$this->_name\"";
                        }

                        $events = $this->readJsEvents();
                        // add or replace the JS events with the wrappers if necessary
                        $this->addJSWrapperToEvents($events, $this->_onclick,    $this->_jsonclick,    "onclick");

                        $imgwidth = $this->Width;
                        $imgheight = $this->Height;
                        // first let's get the image size
                        if ($this->_imagesource != "")
                        {
                                $result = getimagesize($this->getImageSourcePath());

                                if (is_array($result))
                                {
                                        list($imgwidth, $imgheight, $type, $attr) = $result;
                                }
                        }

                        $attr = "";
                        $divstyle = "";
                        $imgstyle = "";

                        $divstyle .= " width: $this->_width; ";
                        $divstyle .= " height: $this->_height; ";
                        if (($this->ControlState & csDesigning) == csDesigning)
                        {
                                $divstyle .= "border:1px dashed gray;";
                        }

                        // add the cursor to the style
                        if ($this->_cursor != "" && $this->Style=="")
                        {
                                $cr = strtolower(substr($this->_cursor, 2));
                                $divstyle .= "cursor: $cr;";
                        }

                        $w = $imgwidth;
                        $h = $imgheight;
                        $bordersize = ($this->_border == 1) ? 2*1 : 0;

                        if ($this->_proportional == 1)
                        {
                                // actual image is smaller than the area where it should be displayed
                                if (intval($this->_width) > $imgwidth && intval($this->_height) > $imgheight)
                                {
                                        // no resizing necessary
                                        $attr .= " width=\"$imgwidth\" ";
                                        $attr .= " height=\"$imgheight\" ";
                                }
                                else
                                {
                                        // only height of image is bigger
                                        if (intval($this->_width) > $imgwidth && intval($this->_height) < $imgheight)
                                        {
                                                $h = intval($this->_height) - $bordersize;
                                                $w = floor(($imgwidth * $h) / $imgheight);
                                        }
                                        // only width of image is bigger
                                        else if (intval($this->_width) < $imgwidth && intval($this->_height) > $imgheight)
                                        {
                                                $w = intval($this->_width) - $bordersize;
                                                $h = floor(($imgheight * $w) / $imgwidth);
                                        }
                                        // both sides of the image are bigger
                                        else
                                        {
                                                // Check which side is bigger
                                                if (intval($this->_width) > intval($this->_height))
                                                {
                                                        $h = intval($this->_height) - $bordersize;
                                                        $w = floor(($imgwidth * $h) / $imgheight);
                                                }
                                                else
                                                {
                                                        $w = intval($this->_width) - $bordersize;
                                                        $h = floor(($imgheight * $w) / $imgwidth);
                                                }
                                        }
                                        $attr .= " width=\"$w\" ";
                                        $attr .= " height=\"$h\" ";
                                }
                        }
                        else
                        {
                                $divstyle .= "overflow: hidden;";

                                $attr .= " width=\"$imgwidth\" ";
                                $attr .= " height=\"$imgheight\" ";
                        }

                        if ($this->_center == 1)
                        {
                                $divstyle .= "text-align: center;";
                                $margin = floor(($this->_height - $h) / 2);
                                $imgstyle .= "margin-top: $margin;";
                        }

                        $hint = $this->getHintAttribute();
                        $hint .= ($hint != "") ? " alt=\"".(htmlspecialchars($this->_hint, ENT_QUOTES))."\"" : "";

                        if ($this->Style=="")
                        {
                                $attr .= " border=\"$this->_border\" ";

                                if ($this->_bordercolor!="") $attr .= " style=\" border-color: $this->_bordercolor \" ";
                        }

                        $class = ($this->Style != "") ? "class=\"$this->StyleClass\"" : "";


                        echo "<div id=\"{$this->_name}_container\" style=\"$divstyle\" $class>";

                        if ($this->_link != "")
                        {
                                echo "<A HREF=\"".$this->_link."\" $hint ";
                                if ($this->_linktarget!="") echo " target=\"".$this->_linktarget."\"";
                                echo ">";
                        }

                        if ($imgstyle != "") $imgstyle = "style=\"$imgstyle\"";

                        if (($this->ControlState & csDesigning) != csDesigning)
                        {
                                if ($this->hasValidDataField())
                                {
                                        $this->_imagesource = $this->readDataFieldValue();
                                        // no hidden field to dump since it's a read-only control
                                }
                        }

                        $this->callEvent('oncustomize', array());

                        echo "<img id=\"$this->_name\" src=\"$this->_imagesource\" $attr $imgstyle $class $hint $map $events />";

                        // add a hidden field so we can determine which event for the label was fired
                        if ($this->_onclick != null)
                        {
                                $hiddenwrapperfield = $this->getJSWrapperHiddenFieldName();
                                echo "<input type=\"hidden\" id=\"$hiddenwrapperfield\" name=\"$hiddenwrapperfield\" value=\"\" />";
                        }

                        if ($this->_link != "") echo "</A>";
                        echo "</div>";

                        if ($this->controls->count()>0)
                        {
                                echo "<map name=\"map$this->_name\">\n";
                                reset($this->controls->items);
                                while (list($k,$v)=each($this->controls->items))
                                {
                                        if ($v->Visible)
                                        {
                                                $v->show();
                                        }
                                }
                                echo "</map>";
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

        /**
        * Occurs before the image tag is written to the stream sent to the client.
        * Use this event to modifiy the image source.
        * @return mixed Event handler or null to unset.
        */
        function getOnCustomize                 () { return $this->_oncustomize; }
        /**
        * Occurs before the image tag is written to the stream sent to the client.
        * Use this event to modifiy the image source.
        * @param mixed $value Event handler or null to unset.
        */
        function setOnCustomize                 ($value) { $this->_oncustomize=$value; }
        function defaultOnCustomize             () { return null; }


        /*
        * Publish the JS events for the component
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
        * If Autosize is true the control takes over the size of the image.
        * This way the image is displayed 100%.
        * @return bool
        */
        function getAutosize() { return $this->_autosize; }
        /**
        * If Autosize is true the control takes over the size of the image.
        * This way the image is displayed 100%.
        * @param bool $value
        */
        function setAutosize($value)  { $this->_autosize=$value; }

        /**
        * Adds a border around the image if true.
        * @return bool
        */
        function getBorder() { return $this->_border; }
        /**
        * Adds a border around the image if true.
        * @param bool $value
        */
        function setBorder($value) { $this->_border=$value; }

        /**
        * Color of the border, only has an affect if Border is set to true.
        * Use the HTML hex color format. e.g. #FF0000 for red.
        * @return string
        */
        function getBorderColor() { return $this->_bordercolor; }
        /**
        * Color of the border, only has an affect if Border is set to true.
        * Use the HTML hex color format. e.g. #FF0000 for red.
        * @param string $value
        */
        function setBorderColor($value) { $this->_bordercolor=$value; }
        function defaultBorderColor() { return ""; }

        /**
        * Indicates whether the image is centered in the image control.
        * When the image does not fit perfectly within the image control,
        * use Center to specify how the image is positioned.
        * When Center is true, the image is centered in the control.
        * When Center is false, the upper left corner of the image is positioned
        * at the upper left corner of the control.
        *
        * Note: Center has no effect if the AutoSize property is true.
        *
        * @return bool
        */
        function getCenter() { return $this->_center; }
        /**
        * Indicates whether the image is centered in the image control.
        * When the image does not fit perfectly within the image control,
        * use Center to specify how the image is positioned.
        * When Center is true, the image is centered in the control.
        * When Center is false, the upper left corner of the image is positioned
        * at the upper left corner of the control.
        *
        * Note: Center has no effect if the AutoSize property is true.
        *
        * @return bool
        */
        function setCenter($value) { $this->_center=$value; }
        function defaultCenter() { return 0; }

        function getDataField() { return $this->_datafield; }
        function setDataField($value) { $this->_datafield=$value; }
        function defaultDataField() { return ""; }

        function getDataSource() { return $this->_datasource; }
        function setDataSource($value) { $this->_datasource=$this->fixupProperty($value); }
        function defaultDataSource() { return ""; }

        /**
        * Source of the image denotes a path where the image is located.
        * This path can be relative to the script or absolute.
        * @return string
        */
        function getImageSource() { return $this->_imagesource; }
        /**
        * Source of the image denotes a path where the image is located.
        * This path can be relative to the script or absolute.
        * @param string $value
        */
        function setImageSource($value) { $this->_imagesource=$value; }

        /**
        * If Link is set the Caption is rendered as a link.
        * @return string Link, if empty string the link is not used.
        */
        function getLink() { return $this->_link; }
        /**
        * If Link is set the Caption is rendered as a link.
        * @value string $value Link, if empty string the link is not used.
        */
        function setLink($value) { $this->_link=$value; }

        /**
        * Target attribute when the label acts as a link.
        * @link http://www.w3.org/TR/html4/present/frames.html#adef-target
        * @return string The link target as defined by the HTML specs.
        */
        function getLinkTarget() { return $this->_linktarget; }
        /**
        * Target attribute when the label acts as a link.
        * @link http://www.w3.org/TR/html4/present/frames.html#adef-target
        * @param string $value The link target as defined by the HTML specs.
        */
        function setLinkTarget($value) { $this->_linktarget=$value; }

        function getParentShowHint() { return $this->readParentShowHint(); }
        function setParentShowHint($value) { $this->writeParentShowHint($value); }

        function getPopupMenu() { return $this->readPopupMenu(); }
        function setPopupMenu($value) { $this->writePopupMenu($value); }

        /**
        * Indicates whether the image should be changed, without distortion,
        * so that it fits the bounds of the image control.
        *
        * Set Proportional to true to ensure that the image can be fully displayed
        * in the image control without any distortion. When Proportional is true,
        * images that are too large to fit in the image control are scaled down
        * (while maintaining the same aspect ratio) until they fit in the image control.
        * Images that are too small are displayed normally. That is,
        * Proportional can reduce the magnification of the image, but does not increase it.
        *
        * Note: The filesize is equal even the image is scaled down.
        *
        * @return bool
        */
        function getProportional() { return $this->_proportional; }
        /**
        * Indicates whether the image should be changed, without distortion,
        * so that it fits the bounds of the image control.
        *
        * Set Proportional to true to ensure that the image can be fully displayed
        * in the image control without any distortion. When Proportional is true,
        * images that are too large to fit in the image control are scaled down
        * (while maintaining the same aspect ratio) until they fit in the image control.
        * Images that are too small are displayed normally. That is,
        * Proportional can reduce the magnification of the image, but does not increase it.
        *
        * Note: The filesize is equal even the image is scaled down.
        *
        * @param bool $value
        */
        function setProportional($value) { $this->_proportional=$value; }
        function defaultProportional() { return 0; }

        function getShowHint() { return $this->readShowHint(); }
        function setShowHint($value) { $this->writeShowHint($value); }

        function getStyle()             { return $this->readstyle(); }
        function setStyle($value)       { $this->writestyle($value); }

        function getVisible() { return $this->readVisible(); }
        function setVisible($value) { $this->writeVisible($value); }
}

/**
 * FlashObject class
 *
 * A class to encapsulate a FlashObject.
 * This control may be use to include a flash animation into a page.
 *
 * @package ExtCtrls
 */
class FlashObject extends GraphicControl
{
        protected $_swffile;

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width=105;
                $this->Height=105;

        }


        function getVisible() { return $this->readVisible(); }
        function setVisible($value) { $this->writeVisible($value); }

        /**
        * Location of the Flash file (*.swf).
        * Path can be relative to the script or absolute.
        * @return string
        */
        function getSwfFile() { return $this->_swffile; }
        /**
        * Location of the Flash file (*.swf).
        * Path can be relative to the script or absolute.
        * @param string $value
        */
        function setSwfFile($value) { $this->_swffile=$value; }

        function dumpContents()
        {
                if (($this->ControlState & csDesigning)==csDesigning)
                {
                        $attr="";
                        if ($this->_width!="") $attr.=" width=\"$this->_width\" ";
                        if ($this->_height!="") $attr.=" height=\"$this->_height\" ";

                        $font = ($this->_parent != null) ? $this->_parent->Font->FontString : "";

                        $bstyle=" style=\"border: 1px dotted #000000; text-align: center; $font\" ";
                        echo "<table $attr $bstyle><tr><td>".basename($this->_swffile)."</td></tr></table>\n";
                }
                else
                {
                        $this->callEvent('onshow',array());

                        echo "<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0\" id=\"$this->_name\" width=\"$this->_width\" height=\"$this->_height\">\n";
                        echo "<param name=\"movie\" value=\"$this->_swffile\" />\n";
                        echo "<param name=\"quality\" value=\"high\" />\n";
                        echo "<embed src=\"$this->_swffile\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" width=\"$this->_width\" height=\"$this->_height\"></embed>\n";
                        echo "</object>\n";
                }

        }
}

/*
class ImageMap extends GraphicControl
{
        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);
                $this->ControlStyle="csAcceptsControls=1";
        }

        function dumpContents()
        {

                if (($this->ControlState & csDesigning)==csDesigning)
                {
                        $attr="";
                        if ($this->_width!="") $attr.=" width=\"$this->_width\" ";
                        if ($this->_height!="") $attr.=" height=\"$this->_height\" ";

                        $bstyle=" style=\"border: 1px dotted #000000\" ";
                        echo "<table $attr $bstyle><tr><td>\n";
                }

                echo "<map name=\"$this->_name\">\n";
                echo "</map>\n";

                if (($this->ControlState & csDesigning)==csDesigning)
                {
                        echo "</table>\n";
                }
        }
}
*/

/**
 * Encapsulates a shape for images
 *
 * @package ExtCtrls
 */
class MapShape extends Control
{
        //Inherited properties
        function getjsOnMouseOut() { return $this->readjsOnMouseOut(); }
        function setjsOnMouseOut($value) { $this->writejsOnMouseOut($value); }

        function getjsOnMouseOver() { return $this->readjsOnMouseOver(); }
        function setjsOnMouseOver($value) { $this->writejsOnMouseOver($value); }


        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width=20;
                $this->Height=20;

        }

        function dumpContents()
        {

                if (($this->ControlState & csDesigning)==csDesigning)
                {
                        $attr="";
                        if ($this->_width!="") $attr.=" width=\"$this->_width\" ";
                        if ($this->_height!="") $attr.=" height=\"$this->_height\" ";

                        $bstyle=" style=\"border: 1px dotted #000000\" ";
                        echo "<table $attr $bstyle><tr><td>\n";
                }

                $l=$this->_left;
                $t=$this->_top;
                $w=$this->_left+$this->_width;
                $h=$this->_top+$this->_height;

                $events=$this->readJsEvents();

                echo "<area id=\"$this->_name\" shape=\"rect\" coords=\"$l,$t,$w,$h\" href=\"#\" $events />\n";

                if (($this->ControlState & csDesigning)==csDesigning)
                {
                        echo "</table>\n";
                }
        }
}

/**
 * ImageFade, to encapsulate an Image with transitions
 *
 */
 //Removed due licensing issues
 /*
class ImageFade extends Image
{
        protected $_delay=3000;
        protected $_fadedegree=10;

        function getDelay() { return $this->_delay; }
        function setDelay($value) { $this->_delay=$value; }
        function defaultDelay() { return 3000; }

        function getFadeDegree() { return $this->_fadedegree; }
        function setFadeDegree($value) { $this->_fadedegree=$value; }
        function defaultFadeDegree() { return 10; }


        function dumpHeaderCode()
        {
                echo "<script type=\"text/javascript\" src=\"".VCL_HTTP_PATH."/fadeimage/fadeimage.js\"></script>\n";
        }


        protected $_images=null;

        function getImages() { return $this->_images;   }
        function setImages($value) { $this->_images=$this->fixupProperty($value); }
        function defaultImages() { return "";   }

        function loaded()
        {
                parent::loaded();
                $this->setImages($this->_images);
        }

        function dumpContents()
        {
                if (($this->ControlState & csDesigning)==csDesigning)
                {
                        $attr="";
                        if ($this->_width!="") $attr.=" width=\"$this->_width\" ";
                        if ($this->_height!="") $attr.=" height=\"$this->_height\" ";

                        $bstyle=" style=\"border: 1px dotted #000000\" ";
                        echo "<table $attr $bstyle><tr><td>&nbsp</td></tr></table>\n";
                }
                else if ($this->_images!=null)
                {
?>
<script type="text/javascript">

var fadeimages=new Array()
        <?php
                $images=$this->_images->Images;
                reset($images);
                $c=0;
                while (list($k,$v)=each($images))
                {
                        echo "fadeimages[$c]=[\"$v\", \"\", \"\"]\n";
                        $c++;
                }
        ?>

var fadebgcolor="white"

new fadeshow(fadeimages, <?php echo $this->_width; ?>, <?php echo $this->_height; ?>, <?php echo $this->_border; ?>, <?php echo $this->_delay; ?>, 0, "R",<?php echo $this->_fadedegree; ?>)

</script>
<?php
                }
        }
}
*/



/**
 * CustomPanel class
 *
 * Base class for panels
 *
 * @package ExtCtrls
 */
class CustomPanel extends CustomControl
{
//        protected $_layout=XY_LAYOUT;

        protected $_include="";
        protected $_dynamic=false;

        protected $_background="";
        protected $_borderwidth=0;
        protected $_bordercolor="";
        protected $_backgroundrepeat="";
        protected $_backgroundposition="";

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);
                $this->ControlStyle="csAcceptsControls=1";

                $this->ControlStyle="csRenderOwner=1";
                $this->ControlStyle="csRenderAlso=StyleSheet";
        }

        protected $_activelayer=0;

        function getActiveLayer() { return $this->_activelayer; }
        function setActiveLayer($value) { $this->_activelayer=$value; }
        function defaultActiveLayer() { return 0; }

        //Background property
        function readBackground() { return $this->_background; }
        function writeBackground($value) { $this->_background=$value; }
        function defaultBackground() { return ""; }

        //Background property
        function readBackgroundRepeat() { return $this->_backgroundrepeat; }
        function writeBackgroundRepeat($value) { $this->_backgroundrepeat=$value; }
        function defaultBackgroundRepeat() { return ""; }

        //Background property
        function readBackgroundPosition() { return $this->_backgroundposition; }
        function writeBackgroundPosition($value) { $this->_backgroundposition=$value; }
        function defaultBackgroundPosition() { return ""; }

        //BorderWidth property
        function readBorderWidth() { return $this->_borderwidth; }
        function writeBorderWidth($value) { $this->_borderwidth=$value; }
        function defaultBorderWidth() { return 0; }

        //BorderColor property
        function readBorderColor() { return $this->_bordercolor; }
        function writeBorderColor($value) { $this->_bordercolor=$value; }
        function defaultBorderColor() { return ""; }

        //Include property
        function readInclude() { return $this->_include; }
        function writeInclude($value) { $this->_include=$value; }
        function defaultInclude() { return ""; }

        //IsLayer property
        /*
        function readIsLayer() { return $this->readIsLayer(); }
        function writeIsLayer($value) { $this->writeIsLayer($value); }
        function defaultIsLayer() { return 0; }
        */

        //Dynamic property
        function readDynamic() { return $this->_dynamic; }
        function writeDynamic($value) { $this->_dynamic=$value; }
        function defaultDynamic() { return 0; }

        function dumpContents()
        {
                if (($this->ControlState & csDesigning)!=csDesigning)
                {
                    //if (!$this->Visible) return;
                }
                $alignment="";
                $background="";
                $width="";
                $height="";
                $color="";
                $style="";

                switch ($this->_alignment)
                {
                        case agNone: $alignment=""; break;
                        case agLeft: $alignment=" align=\"Left\" "; break;
                        case agCenter: $alignment=" align=\"Center\" "; break;
                        case agRight: $alignment=" align=\"Right\" "; break;

                }

                if ($this->Style=="")
                {
                        if ($this->Color!="") $color=" bgcolor=\"$this->Color\" ";
                        if ($this->Background!="") $background=" background=\"$this->Background\" ";

                        $style.=" border: ".$this->_borderwidth."px solid $this->_bordercolor; ";

                        if ($this->BackgroundRepeat!="") $style.=" background-repeat: $this->BackgroundRepeat; ";
                        if ($this->BackgroundPosition!="") $style.=" background-position: $this->BackgroundPosition; ";
                }

                if ($style!='') $style=" style=\"$style\" ";

                $class = ($this->Style != "") ? "class=\"$this->StyleClass\"" : "";

                if ($this->Width!="") $width=" width=\"$this->Width\" ";
                if ($this->Height!="") $height=" height=\"$this->Height\" ";

                $bstyle="";

                if (($this->ControlState & csDesigning)==csDesigning)
                {
                        if (count($this->controls->items==0))
                        {
                                if ($this->_include=='')
                                {
                                        if (($this->_borderwidth!="") && ($this->_borderwidth!="0px") && ($this->_bordercolor!=""))
                                        {
                                        }
                                        else
                                        {
                                                $bstyle=" style=\"border: 1px dotted #000000\" ";
                                        }
                                }
                        }
                }

                $hint = $this->getHintAttribute();

                if ($this->_islayer)
                {
                        echo "<div id=\"$this->_name\" style=\"top: ".$this->_top."px; left: ".$this->_left."px; position: absolute; width: ".$this->_width."px; height: ".$this->_height."px; visibility: hidden\" $hint >\n";
                }

                if ($this->_adjusttolayout)
                {
                    $width=" width=\"100%\" ";
                    $height=" height=\"100%\" ";
                }
                if ($this->_include!="")
                {
                    include($this->_include);
                }
                else
                {
                    echo "<table id=\"{$this->_name}_table\" $width $height border=\"0\" $bstyle cellpadding=\"0\" cellspacing=\"0\" $alignment $color $background $style $class $hint>\n";
                echo "<tr>\n";
                if ((($this->ControlState & csDesigning)==csDesigning) || ($this->controls->count()==0))
                {
                        $spanstyle = ($this->Style=="") ? "style=\"".$this->Font->FontString."\"" : "class=\"$this->StyleClass\"";
                        echo "<td align=\"center\"><span $spanstyle>$this->Caption</span>\n";
                }
                else
                {
                echo "<td valign=\"top\">\n";
                }
                if (($this->ControlState & csDesigning) != csDesigning)
                {
                        $this->callEvent('onshow',array());
                        $this->Layout->dumpLayoutContents();
                }
                echo "</td>\n";
                echo "</tr>\n";
                echo "</table>\n";
                }

        }


}


/**
 * Panel class
 *
 * A component to group another controls
 *
 * @package ExtCtrls
 */
class Panel extends CustomPanel
{
        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);
        }

        function getFont() { return $this->readFont(); }
        function setFont($value) { $this->writeFont($value); }

        function getParentFont() { return $this->readParentFont(); }
        function setParentFont($value) { $this->writeParentFont($value); }
        
        function getParentColor() { return $this->readParentColor(); }
        function setParentColor($value) { $this->writeParentColor($value); }

        function getParentShowHint() { return $this->readParentShowHint(); }
        function setParentShowHint($value) { $this->writeParentShowHint($value); }

        function getShowHint() { return $this->readShowHint(); }
        function setShowHint($value) { $this->writeShowHint($value); }
        

        function getAlignment() { return $this->readAlignment(); }
        function setAlignment($value) { $this->writeAlignment($value); }

        function getCaption() { return $this->readCaption(); }
        function setCaption($value) { $this->writeCaption($value); }

        function getColor() { return $this->readColor(); }
        function setColor($value) { $this->writeColor($value); }

        function getVisible() { return $this->readVisible(); }
        function setVisible($value) { $this->writeVisible($value); }

        function getBackground() { return $this->readBackground(); }
        function setBackground($value) { $this->writeBackground($value); }

        function getBackgroundRepeat() { return $this->readBackgroundRepeat(); }
        function setBackgroundRepeat($value) { $this->writeBackgroundRepeat($value); }

        function getBackgroundPosition() { return $this->readBackgroundPosition(); }
        function setBackgroundPosition($value) { $this->writeBackgroundPosition($value); }

        function getBorderWidth() { return $this->readBorderWidth(); }
        function setBorderWidth($value) { $this->writeBorderWidth($value); }

        function getBorderColor() { return $this->readBorderColor(); }
        function setBorderColor($value) { $this->writeBorderColor($value); }

        function getLayout() { return $this->readLayout(); }
        function setLayout($value) { $this->writeLayout($value); }

        function getInclude() { return $this->readInclude(); }
        function setInclude($value) { $this->writeInclude($value); }

        function getIsLayer() { return $this->readIsLayer(); }
        function setIsLayer($value) { $this->writeIsLayer($value); }

        function getDynamic() { return $this->readDynamic(); }
        function setDynamic($value) { $this->writeDynamic($value); }

        function getStyle()             { return $this->readstyle(); }
        function setStyle($value)       { $this->writestyle($value); }

}

/**
 * Control to group another controls inside a frame
 *
 * @package ExtCtrls
 */
class GroupBox extends QWidget
{
        function dumpContents()
        {
                $this->dumpCommonContentsTop();
                echo "        var ".$this->Name."    = new qx.ui.groupbox.GroupBox(\"$this->Caption\");\n";
                echo "        $this->Name.setLeft(0);\n";
                echo "        $this->Name.setTop(0);\n";
                echo "        $this->Name.setWidth($this->Width);\n";
                echo "        $this->Name.setHeight($this->Height);\n";
                if ($this->Color != "")
                {
                        echo "        $this->Name.setBackgroundColor(new qx.renderer.color.Color(\"$this->Color\"));\n";
                        // set background color the the groupbox caption  
                        echo "        var obj = $this->Name.getLegendObject();\n";
                        echo "        if (obj) obj.setBackgroundColor(new qx.renderer.color.Color(\"$this->Color\"));\n";
                }
                $this->dumpChildrenControls();
                $this->dumpCommonContentsBottom();

        }

        //Publish some properties
        function getFont() { return $this->readFont(); }
        function setFont($value) { $this->writeFont($value); }

        function getParentFont() { return $this->readParentFont(); }
        function setParentFont($value) { $this->writeParentFont($value); }

        function getParentColor() { return $this->readParentColor(); }
        function setParentColor($value) { $this->writeParentColor($value); }

        function getParentShowHint() { return $this->readParentShowHint(); }
        function setParentShowHint($value) { $this->writeParentShowHint($value); }

        function getShowHint() { return $this->readShowHint(); }
        function setShowHint($value) { $this->writeShowHint($value); }

        function getAlignment() { return $this->readAlignment(); }
        function setAlignment($value) { $this->writeAlignment($value); }

        function getCaption() { return $this->readCaption(); }
        function setCaption($value) { $this->writeCaption($value); }

        function getColor() { return $this->readColor(); }
        function setColor($value) { $this->writeColor($value); }

        function getVisible() { return $this->readVisible(); }
        function setVisible($value) { $this->writeVisible($value); }

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width=200;
                $this->Height=200;

                //This control can hold another controls
                $this->ControlStyle="csAcceptsControls=1";
        }

}

define("btTop","btTop");
define("btRight","btRight");
define("btBottom","btBottom");
define("btLeft","btLeft");

/**
 * The typical apple-like tabview-replacements which could also be found
 * in more modern versions of the settings dialog in Mozilla Firefox.
 *
 * @package ExtCtrls
 */
class CustomButtonView extends QWidget
{
        protected $_position=btLeft;
        protected $_items=array();
        protected $_images = null;

        function loaded()
        {
                parent::loaded();
                $this->writeImageList($this->_images);
        }

        private function dumpButtons($name, $items)
        {
                $event=$this->jsOnClick;
                if ($event!='') $event=", $event";
                else $event=", function dummy(){}";

                if (($this->ControlState & csDesigning) == csDesigning) $event=", function dummy(){}";

                reset($items);
                if (isset($items))
                {
                        echo "\n";
                        echo "  <!-- Define Buttons - Start -->\n";
                }
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

                        if ($image === "null")
                        {
                                echo "    var $itemname = new qx.ui.pageview.buttonview.Button(\"$caption\");\n";
                        }
                        else
                        {
                                echo "    var $itemname = new qx.ui.pageview.buttonview.Button(\"$caption\", $image);\n";
                        }
                        __QLibrary_SetCursor($itemname, $this->Cursor);
//                        echo "    $itemname.addEventListener(\"execute\", " . $this->Name . "_clickwrapper);\n";
                        echo "    $itemname.tag=$tag;\n";
                        echo "    $itemname.addEventListener(\"click\"$event);\n";

                        $elements[] = $itemname;
                }

                if (isset($elements))
                {
                        echo "  <!-- Define Buttons - Start -->\n";
                        echo "\n";
                        echo "  $name.getBar().add(" . implode(",", $elements) . ");\n";
                        unset($elements);

                        echo "  $name" . "_0.setChecked(true);\n";
                }
        }

        function dumpHeaderCode()
        {
                parent::dumpHeaderCode();
                //This function is used as a common click processor for all item clicks
//                echo '<script type="text/javascript">';
//                echo "function $this->Name"."_clickwrapper(e)\n";
//                echo "{\n";
//                echo "  submit=true; \n";
//                if (($this->ControlState & csDesigning) != csDesigning)
//                {
//                        if ($this->JsOnClick!=null)
//                        {
//                                echo "  submit=".$this->JsOnClick."(e);\n";
//                        }
//                }
//                echo "  var tag=e.getTarget().tag;\n";
//                echo "  if ((tag!=0) && (submit))\n";
//                echo "  {\n";
//                echo "    var hid=findObj('$this->Name"."_state');\n";
//                echo "    if (hid) hid.value=tag;\n";
//                if (($this->ControlState & csDesigning) != csDesigning)
//                {
//                        $form = "document.".$this->owner->Name;
//                        echo "    if (($form.onsubmit) && (typeof($form.onsubmit) == 'function')) { $form.onsubmit(); }\n";
//                        echo "    $form.submit();\n";
//                }
  //              echo "    }\n";
//                echo "}\n";
//                echo '</script>';
        }

        function dumpContents()
        {
                $this->dumpCommonContentsTop();

                $position = "top";
                switch ($this->_position)
                {
                        case btRight:  $position = "right"; break;
                        case btBottom: $position = "bottom"; break;
                        case btLeft:   $position = "left"; break;
                }

                echo "  var i = new qx.ui.basic.Inline(\"$this->Name\");\n";
                echo "  i.setHeight(\"auto\");\n";
                echo "  i.setWidth(\"auto\");\n";
                echo "  var $this->Name = new qx.ui.pageview.buttonview.ButtonView;\n";

                echo "  $this->Name.setLeft(0);\n";
                echo "  $this->Name.setTop(0);\n";
                echo "  $this->Name.setWidth($this->Width);\n";
                echo "  $this->Name.setHeight($this->Height);\n";

                echo "  $this->Name.setBarPosition(\"$position\");\n";

              $this->dumpButtons($this->Name, $this->_items);

                $this->dumpCommonContentsBottom();
          }

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width=63;
                $this->Height=335;

                $this->ControlStyle="csSlowRedraw=1";
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
         * Describes the buttons.
         * Use Items to access information about the elements in the menu.
         * Item contain information about Caption, associated image and Tag.
         *
         * @return item collection
         */
        protected function readItems()          { return $this->_items; }
        protected function writeItems($value)   { $this->_items=$value; }
        /**
         * Defines a position/orientation of the ButtonView
         *
         * @return enum (btTop, btBottom, btLeft, btRight)
         */
        function readPosition()                 { return $this->_position; }
        function writePosition($value)
        {
            if ($this->_position!=$value)
            {
                /*
                $w=$this->Width;
                $h=$this->Height;

                switch ($value)
                {
                        case btTop:
                        case btBottom:
                                if (($this->_position = btLeft) || ($this->_position = btRight))
                                {
                                    $this->Height=$w; $this->Width=$h;
                                }
                                break;
                        case btLeft:
                        case btRight:
                                if (($this->_position = btTop) || ($this->_position = btBottom))
                                {
                                    $this->Height=$w; $this->Width=$h;
                                }
                                break;
                }
                */
                $this->_position=$value;
            }
        }
        function defaultPosition()              { return btLeft; }
}

class ButtonView extends CustomButtonView
{
        //Publish common properties
        function getFont()              { return $this->readFont(); }
        function setFont($value)        { $this->writeFont($value); }

        function getParentFont()        { return $this->readParentFont(); }
        function setParentFont($value)  { $this->writeParentFont($value); }

        function getAlignment()         { return $this->readAlignment(); }
        function setAlignment($value)   { $this->writeAlignment($value); }

        function getCaption()           { return $this->readCaption(); }
        function setCaption($value)     { $this->writeCaption($value); }

        function getColor()             { return $this->readColor(); }
        function setColor($value)       { $this->writeColor($value); }

        function getVisible()           { return $this->readVisible(); }
        function setVisible($value)     { $this->writeVisible($value); }

        // Common events
        function getjsOnClick()                 { return $this->readjsOnClick(); }
        function setjsOnClick($value)           { $this->writejsOnClick($value); }

        //Publish properties
        function getImageList()         { return $this->readImageList(); }
        function setImageList($value)   { $this->writeImageList($value); }

        function getItems()             { return $this->readItems(); }
        function setItems($value)       { $this->writeItems($value); }

        function getPosition()          { return $this->readPosition(); }
        function setPosition($value)    { $this->writePosition($value); }
}

define('orHorizontal', 'orHorizontal');
define('orVertical', 'orVertical');

/**
* CustomRadioGroup is the base class for radio-group components.
* When the user checks a radio button, all other radio buttons in its group become unchecked.
*
* @package ExtCtrls
*/
class CustomRadioGroup extends FocusControl
{
        protected $_onclick = null;
        protected $_onsubmit = null;

        protected $_datasource = null;
        protected $_datafield = "";
        protected $_itemindex = -1;
        protected $_items = array();
        protected $_orientation = orVertical;
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

                $style="";
                if ($this->Style=="")
                {
                        // get the Font attributes
                        $style .= $this->Font->FontString;

                        if ($this->Color != "")
                        {
                                $style  .= "background-color: " . $this->Color . ";";
                        }

                        // add the cursor to the style
                        if ($this->_cursor != "")
                        {
                                $cr = strtolower(substr($this->_cursor, 2));
                                $style .= "cursor: $cr;";
                        }
                }

                $spanstyle = $style;

                $h = $this->Height - 2;
                $w = $this->Width;

                $style .= "height:" . $h . "px;width:" . $w . "px;";

                // set enabled/disabled status
                $enabled = (!$this->_enabled) ? "disabled=\"disabled\"" : "";

                // set tab order if tab stop set to true
                $taborder = ($this->_tabstop == 1) ? "tabindex=\"$this->_taborder\"" : "";

                // get the hint attribute; returns: title="[HintText]"
                $hint = $this->getHintAttribute();

                if ($style  != "")  $style  = "style=\"$style\"";
                if ($style  != "")  $spanstyle  = "style=\"$spanstyle\"";

                // get the alignment of the Items
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

                if (($this->ControlState & csDesigning) != csDesigning)
                {
                        if ($this->hasValidDataField())
                        {
                                //check if the value of the current data-field is in the itmes array as value
                                $val = $this->readDataFieldValue();
/*
                                $ds = $this->_datasource->DataSet;
                                $df = $this->_datafield;

                                //TODO: Save the position of the current record so we can reset it after the loop
                                //$ds->memorizeCurrentRecord();

                                $ds->first();
                                // iterate through all records and add them
                                while (!$ds->EOF)
*/
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

                $class = ($this->Style != "") ? "class=\"$this->StyleClass\"" : "";

                // call the OnShow event if assigned so the Items property can be changed
                if ($this->_onshow != null)
                {
                        $this->callEvent('onshow', array());
                }


                echo "<table id=\"{$this->_name}_table\" cellpadding=\"0\" cellspacing=\"0\" $style $class>";
                if (is_array($this->_items))
                {
                        // if horizontal then only add one row
                        echo ($this->_orientation == orHorizontal) ? "<tr>" : "";
                        // $index is used to call the JS RadioGroupClick function
                        $index = 0;
                        foreach ($this->_items as $key => $item)
                        {
                                // add the checked attribut if the itemindex is the current item
                                $checked = ($this->_itemindex == $key) ? "checked=\"checked\"" : "";
                                // only allow an OnClick if enabled
                                $itemclick = ($this->_enabled == 1 && $this->Owner != null) ? "onclick=\"return RadioGroupClick(document.forms[0].$this->_name, $index);\"" : "";

                                // add a new row for every item
                                echo ($this->_orientation == orVertical) ? "<tr>\n" : "";

                                echo "<td width=\"20\">\n";
                                echo "<input type=\"radio\" id=\"{$this->_name}_{$key}\" name=\"$this->_name\" value=\"$key\" $events $checked $enabled $taborder $hint $class />\n";
                                echo "</td><td $alignment>\n";
                                echo "<span id=\"{$this->_name}_{$key}_caption\" $itemclick $hint $spanstyle $class>$item</span>\n";
                                echo "</td>\n";

                                echo ($this->_orientation == orVertical) ? "</tr>\n" : "";
                                $index++;
                        }
                        echo ($this->_orientation == orHorizontal) ? "</tr>" : "";
                }
                echo "</table>";

                // add a hidden field so we can determine which radiogroup fired the event
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
                        if (!defined('RadioGroupClick'))
                        {
                                define('RadioGroupClick', 1);

                                echo "
function RadioGroupClick(elem, index)
{
   if (!elem.disabled) {
     if (typeof(elem.length) == 'undefined') {
       elem.checked = true;
       return (typeof(elem.onclick) == 'function') ? elem.onclick() : false;
     } else {
       if (index >= 0 && index < elem.length) {
         elem[index].checked = true;
         return (typeof(elem[index].onclick) == 'function') ? elem[index].onclick() : false;
       }
     }
   }
   return false;
}
";
                        }
                }
        }


        /**
        * Return the number of itmes in the radio group.
        * @return integer
        */
        function readCount()
        {
                return count($this->_items);
        }

        /**
        * Adds an item to the radio group control.
        * @param mixed $item Value of item to add.
        * @param mixed $object Object to assign to the $item. is_object() is used to
        *                      test if $object is an object.
        * @param mixed $itemkey Key of the item in the array. Default key is used if null.
        * @return integer Return the number of items in the list.
        */
        function AddItem($item, $object = null, $itemkey = null)
        {
                if ($object != null)
                {
                        throw new Exception('Object functionallity for RadioGroup is not yet implemented.');
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


        function readDataField() { return $this->_datafield; }
        function writeDataField($value) { $this->_datafield = $value; }
        function defaultDataField() { return ""; }

        function readDataSource() { return $this->_datasource; }
        function writeDataSource($value)
        {
                $this->_datasource = $this->fixupProperty($value);
        }
        function defaultDataSource() { return null; }

        /**
        * Returns the value of the ItemIndex property.
        * @return mixed Return the ItemIndex of the list.
        */
        function readItemIndex() { return $this->_itemindex; }
        /**
        * Set new ItemIndex value.
        * @param mixed $value Value of the new ItemIndex.
        */
        function writeItemIndex($value) { $this->_itemindex = $value; }
        function defaultItemIndex() { return -1; }

        /**
        * Contains the strings that appear in the radio group.
        * @return array
        */
        function readItems() { return $this->_items; }
        /**
        * Contains the strings that appear in the radio group.
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
        }
        function defaultItems() { return array(); }

        /**
        * Orientation of the radio button within the group.
        * @return enum (orHorizontal, orVertical)
        */
        function readOrientation() { return $this->_orientation; }
        /**
        * Orientation of the radio button within the group.
        * @param enum (orHorizontal, orVertical)
        */
        function writeOrientation($value) { $this->_orientation=$value; }
        function defaultOrientation() { return orVertical; }

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
* RadioGroup represents a group of radio buttons that function together.
*
* @package ExtCtrls
*/
class RadioGroup extends CustomRadioGroup
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


        function getItemIndex()
        {
                return $this->readItemIndex();
        }
        function setItemIndex($value)
        {
                $this->writeItemIndex($value);
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

        function getOrientation()
        {
                return $this->readOrientation();
        }
        function setOrientation($value)
        {
                $this->writeOrientation($value);
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
 * Shape Class
 *
 * A component to show simple shapes
 *
 * @package ExtCtrls
 */
class Shape extends Control
{
        protected $_shape=stRectangle;
        protected $_pen=null;
        protected $_brush=null;
        protected $_canvas=null;

        function dumpHeaderCode()
        {
                $this->_canvas->InitLibrary();
                if (( $this->ControlState & csDesigning ) == csDesigning )
                {
                        echo "<div id=\"" . $this->Name . "_outer\" style=\"Z-INDEX: 2; WIDTH: "
                            . $this->Width . "px; HEIGHT: " . $this->Height . "px\">";
                }
        }

        function dumpContents()
        {
                $this->_canvas->BeginDraw();

                $penwidth = max($this->Pen->Width, 1);
                switch ($this->_shape)
                {
                        case stCircle:
                        case stSquare:
                        case stRoundSquare:
                                // need to center the shape
                                $size = min($this->Width, $this->Height) / 2 - $penwidth * 4;
                                $xc= $this->Width / 2;
                                $yc= $this->Height / 2;
                                $x1 = $xc - $size;
                                $y1 = $yc - $size;
                                $x2= $xc + $size;
                                $y2= $yc + $size;
                                break;
                        default:
                                $x1=$penwidth;
                                $y1=$penwidth;
                                $x2=max($this->Width, 2) - $penwidth * 2;
                                $y2=max($this->Height, 2) - $penwidth * 2;
                                $size=max($x2, $y2);
                                break;
                };

                $w = max($this->Width, 1);
                $h = max($this->Height, 1);

                $this->_canvas->Pen->Color = $this->Pen->Color;
//                $this->_canvas->Pen->Style = $this->Pen->Style;
                $this->_canvas->Pen->Width = $this->Pen->Width;
                $this->_canvas->Brush->Color = $this->Brush->Color;

                switch ($this->_shape)
                {
                        case stRectangle:
                        case stSquare:
                                $this->_canvas->FillRect($x1, $y1, $x2, $y2);
                                $this->_canvas->Rectangle($x1, $y1, $x2, $y2);
                                break;
                        case stRoundRect:
                        case stRoundSquare:
                                if ($w < $h) $s = $w;
                                else $s = $h;
                                $this->_canvas->RoundRect($x1, $y1, $x2, $y2, $s / 4, $s / 4);
                                break;
                        case stCircle:
                                $this->_canvas->Ellipse($x1, $y1, $x2 - 1, $y2 - 1);
                                break;
                        case stEllipse:
                                $this->_canvas->Ellipse($x1, $y1, $x2, $y2);
                                break;
                }

                $this->_canvas->EndDraw();
        }

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width=65;
                $this->Height=65;
                $this->_pen=new Pen();
                $this->_brush=new Brush();
                $this->_canvas = new Canvas($this);
        }

        /**
         * Specifies the shape of the control.
         *
         * @return enum (stRectangle, stSquare, stRoundRect, stRoundSquare, stEllipse, stCircle)
         */
        function readShape()                    { return $this->_shape; }
        function writeShape($value)             { $this->_shape=$value; }
        function defaultShape()                 { return stRectangle; }
        /**
         * Specifies the pen used to outline the shape control.
         *
         * @return Pen object
         */
        protected function readPen()            { return $this->_pen;       }
        protected function writePen($value)     { if (is_object($value)) $this->_pen=$value; }
        /**
         * Specifies the color and pattern used for filling the shape control.
         *
         * @return Brush object
         */
        protected function readBrush()          { return $this->_brush;       }
        protected function writeBrush($value)   { if (is_object($value)) $this->_brush=$value; }

        // Published common properties
        function getHint()              { return $this->_hint; }
        function setHint($value)        { $this->_hint=$value; }

        function getVisible()           { return $this->readVisible(); }
        function setVisible($value)     { $this->writeVisible($value); }

        // Published properties
        function getShape()             { return $this->readShape(); }
        function setShape($value)       { $this->writeShape($value); }

        function getPen()               { return $this->readPen(); }
        function setPen($value)         { $this->writePen($value); }

        function getBrush()             { return $this->readBrush(); }
        function setBrush($value)       { $this->writeBrush($value); }
}

/**
 * Bevel Class
 *
 * A component to show beveled graphics
 *
 * @package ExtCtrls
 */
class Bevel extends GraphicControl
{
        protected $_shape=bsBox;
        protected $_bevelstyle=bsLowered;
        protected $_canvas=null;

        function dumpHeaderCode()
        {
                $this->_canvas->InitLibrary();
                if (( $this->ControlState & csDesigning ) == csDesigning )
                {
                        echo "<div id=\"" . $this->Name . "_outer\" style=\"Z-INDEX: 2; WIDTH: "
                            . $this->Width . "px; HEIGHT: " . $this->Height . "px\">";
                }
        }

        function dumpContents()
        {
                $this->_canvas->BeginDraw();
                $w = max($this->Width, 1);
                $h = max($this->Height, 1);

                if (( $this->ControlState & csDesigning ) == csDesigning )
                {
                        $this->_canvas->Pen->Color = "#000000";
                        if ($this->_shape == bsSpacer)
                        {
//                                $this->_canvas->Pen->Style = psDot;
                                $this->_canvas->Rectangle(0, 0, $w, $h);
                        }
                        else
                        {
//                                $this->_canvas->Pen->Style = psSolid;
                        }
                }

                if ($this->_bevelstyle == bsLowered)
                {
                        $color1 = "#000000";
                        $color2 = "#EEEEEE";
                }
                else
                {
                        $color1 = "#EEEEEE";
                        $color2 = "#000000";
                };

                switch ($this->_shape)
                {
                        case bsFrame:
                                $temp = $color1;
                                $color1 = $color2;
                                $this->_canvas->BevelRect(1, 1, $w - 1, $h - 1, $color1, $color2);
                                $color2 = $temp;
                                $color1 = $temp;
                                $this->_canvas->BevelRect(0, 0, $w - 2, $h - 2, $color1, $color2);
                                break;
                        case bsTopLine:
                                $this->_canvas->BevelLine($color1, 0, 0, $w, 0);
                                $this->_canvas->BevelLine($color2, 0, 1, $w, 1);
                                break;
                        case bsBottomLine:
                                $this->_canvas->BevelLine($color1, 0, $h - 2, $w, $h - 2);
                                $this->_canvas->BevelLine($color2, 0, $h - 1, $w, $h - 1);
                                break;
                        case bsLeftLine:
                                $this->_canvas->BevelLine($color1, 0, 0, 0, $h);
                                $this->_canvas->BevelLine($color2, 1, 0, 1, $h);
                                break;
                        case bsRightLine:
                                $this->_canvas->BevelLine($color1, $w - 2, 0, $w - 2, $h);
                                $this->_canvas->BevelLine($color2, $w - 1, 0, $w - 1, $h);
                                break;
                        case bsSpacer:
                                break;
                        default:        // bsBox
                                $this->_canvas->BevelRect(0, 0, $w - 1, $h - 1, $color1, $color2);
                                break;
                }
                $this->_canvas->EndDraw();
        }

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);
                $this->_canvas = new Canvas($this);
        }

        //Shape property
        function readShape()            { return $this->_shape; }
        function writeShape($value)     { $this->_shape=$value; }
        function defaultShape()         { return bsBox; }

        //Style property
        function readBevelStyle()       { return $this->_bevelstyle; }
        function writeBevelStyle($value){ $this->_bevelstyle=$value; }
        function defaultBevelStyle()    { return bsLowered; }

        // Published properties - inherited
        function getHint()              { return $this->_hint; }
        function setHint($value)        { $this->_hint=$value; }

        function getVisible()           { return $this->readVisible(); }
        function setVisible($value)     { $this->writeVisible($value); }

        // Published properties
        function getShape()             { return $this->readShape(); }
        function setShape($value)       { $this->writeShape($value); }

        function getBevelStyle()        { return $this->readBevelStyle(); }
        function setBevelStyle($value)  { $this->writeBevelStyle($value); }
}

/**
 * Timer Class
 *
 * A component to generate events at specified intervals
 *
 * @package ExtCtrls
 */
class Timer extends Component
{
        protected $_interval = 1000;
        protected $_enabled = true;
        //protected $_ontimer = null;
        protected $_jsontimer = null;

        function dumpJSEvent($event)
        {
                if ($event!=null)
                {
                        echo "function $event(event)\n";
                        echo "{\n\n";
                        echo "var event = event || window.event;\n";
//                        echo "if (!event) var event = window.event;\n";
                        if ($this->owner!=null) $this->owner->$event($this, array());
                        echo "\n}\n";
                        echo "\n";
                }
        }

        function dumpJavascript()
        {
                parent::dumpJavascript();

                if (($this->ControlState & csDesigning) == csDesigning) Break;

                if (($this->_enabled) && ($this->_jsontimer != null))
                {
                        $this->dumpJSEvent($this->_jsontimer);

                        echo "  var " . $this->Name . "_TimerID = null;\n";
                        echo "  var " . $this->Name . "_OnLoad = null;\n";
                        echo "\n\n";

                        echo "  function addEvent(obj, evType, fn)\n";
                        echo "  { if (obj.addEventListener)\n";
                        echo "    { obj.addEventListener(evType, fn, false);\n";
                        echo "      return true;\n";
                        echo "    }\n";
                        echo "    else if (obj.attachEvent)\n";
                        echo "    { var r = obj.attachEvent(\"on\"+evType, fn);\n";
                        echo "      return r;\n";
                        echo "    } else {\n";
                        echo "      return false;\n";
                        echo "    }\n";
                        echo "  }\n\n";

                        echo "  function " . $this->Name . "_InitTimer()\n";
                        echo "  {  if (" . $this->Name . "_OnLoad != null) " . $this->Name . "_OnLoad();\n";
                        echo "     " . $this->Name . "_DisableTimer();\n";
                        echo "     " . $this->Name . "_EnableTimer();\n";
                        echo "  }\n\n";

                        echo "  function " . $this->Name . "_DisableTimer()\n";
                        echo "  {  if (" . $this->Name . "_TimerID)\n";
                        echo "     { clearTimeout(" . $this->Name . "_TimerID); \n";
                        echo "       " . $this->Name . "_TimerID  = null;\n";
                        echo "     }\n";
                        echo "  }\n\n";

                        echo "  function " . $this->Name . "_Event()\n";
                        echo "  { \n";
                        echo "  var event = event || window.event; \n";
                        echo "  if (" . $this->Name . "_TimerID)\n";
                        echo "    {  " . $this->Name . "_DisableTimer();\n";
                        echo "       " . $this->_jsontimer . "(event);\n";
                        echo "       " . $this->Name . "_EnableTimer();\n";
                        echo "    }\n";
                        echo "  }\n\n";

                        echo "  function " . $this->Name . "_EnableTimer()\n";
                        echo "  { " . $this->Name . "_TimerID = self.setTimeout(\"" . $this->Name . "_Event()\", $this->_interval);\n";
                        echo "  }\n\n";

                        echo "  if (window.onload) " . $this->Name . "_OnLoad=window.onload;\n";
                        echo "  addEvent(window, 'load', " . $this->Name . "_InitTimer);\n";
                }
        }

        /**
         * Controls whether the timer generates OnTimer events periodically.
         *
         * @return boolean
         */
        protected function readEnabled()        { return $this->_enabled; }
        protected function writeEnabled($value) { $this->_enabled=$value; }
        protected function defaultEnabled()     { return true; }
        /**
         * Determines the amount of time, in milliseconds, that passes before
         * the timer component initiates another OnTimer event.
         *
         * @return integer
         */
        protected function readInterval()       { return $this->_interval; }
        protected function writeInterval($value) { $this->_interval=$value; }
        protected function defaultInterval()    { return 1000; }
        //protected function readOnTimer()        { return $this->_ontimer; }
        //protected function writeOnTimer($value) { $this->_ontimer=$value; }
        //protected function defaultOnTimer()     { return null; }
        /**
         * Occurs when a specified amount of time, determined by the Interval
         * property, has passed. (JS event)
         */
        protected function readjsOnTimer()      { return $this->_jsontimer; }
        protected function writejsOnTimer($value) { $this->_jsontimer=$value; }
        protected function defaultjsOnTimer()   { return null; }

        // publish properties
        function getEnabled()                   { return $this->readEnabled(); }
        function setEnabled($value)             { $this->writeEnabled($value); }

        function getInterval()                   { return $this->readInterval(); }
        function setInterval($value)             { $this->writeInterval($value); }

        //function getOnTimer()                   { return $this->readOnTimer(); }
        //function setOnTimer($value)             { $this->writeOnTimer($value); }

        function getjsOnTimer()                 { return $this->readjsOnTimer(); }
        function setjsOnTimer($value)           { $this->writejsOnTimer($value); }
}

/**
 * PaintBox Class
 *
 * A component to paint
 */
class PaintBox extends Control
{
        protected $_canvas = null;
        protected $_onpaint = null;

        function dumpHeaderCode()
        {
                if (($this->ControlState & csDesigning)!==csDesigning)
                {
                        $this->_canvas->InitLibrary();
                }
        }

        function dumpContents()
        {
                if (($this->ControlState & csDesigning)==csDesigning)
                {
                        echo "<table width=\"$this->Width\" height=\"$this->Height\" border=\"0\" style=\"border: 1px dotted #000000\" cellpadding=\"0\" cellspacing=\"0\">\n";
                        echo "<tr>\n";
                        echo "<td align=\"center\">$this->Name</td>\n";
                        echo "</tr>\n";
                        echo "</table>\n";
                }
                else
                {
                        if (($this->ControlState & csDesigning) != csDesigning)
                        {
                                $style="";

                                // set height and width to the style attribute
                                if (!$this->_adjusttolayout)
                                {
                                    $style .= "height:" . $this->Height . "px;width:" . $this->Width . "px;";
                                }
                                else
                                {
                                    $style .= "height:100%;width:100%;";
                                }
                                $events = $this->readJsEvents();
                                echo "<div id=\"$this->_name\" style=\"$style\" $events >";
                                $this->_canvas->BeginDraw();
                                $this->callEvent('onpaint', $this->_canvas);
                                $this->_canvas->EndDraw();
                                echo "</div>";
                        }
                }
        }

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);
                $this->_canvas = new Canvas($this);
                $this->Width = 100;
                $this->Height = 100;
        }

        function getPopupMenu() { return $this->readPopupMenu(); }
        function setPopupMenu($value) { $this->writePopupMenu($value); }        

        protected function readOnPaint()        { return $this->_onpaint; }
        protected function writeOnPaint($value) { $this->_onpaint=$value; }

        // Publish events
        function getOnPaint()                   { return $this->readOnPaint(); }
        function setOnPaint($value)             { $this->writeOnPaint($value); }
}

?>
