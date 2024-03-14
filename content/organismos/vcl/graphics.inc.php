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

define('taNone','taNone');
define('taLeft','taLeft');
define('taCenter','taCenter');
define('taRight','taRight');
define('taJustify','taJustify');

define('fsNormal','fsNormal');
define('fsItalic','fsItalic');
define('fsOblique','fsOblique');

define('caCapitalize','caCapitalize');
define('caUpperCase','caUpperCase');
define('caLowerCase','caLowerCase');
define('caNone','caNone');

define('vaNormal','vaNormal');
define('vaSmallCaps','vaSmallCaps');

define('psDash', 'psDash');
define('psDashDot', 'psDashDot');
define('psDashDotDot', 'psDashDotDot');
define('psDot', 'psDot');
define('psSolid', 'psSolid');

define('FLOW_LAYOUT','FLOW_LAYOUT');
define('XY_LAYOUT','XY_LAYOUT');
define('ABS_XY_LAYOUT','ABS_XY_LAYOUT');
define('GRIDBAG_LAYOUT','GRIDBAG_LAYOUT');
define('ROW_LAYOUT','ROW_LAYOUT');
define('COL_LAYOUT','COL_LAYOUT');


/**
 * Layout encapsulation to allow any component to hold
 * controls and render them in very different ways
 *
 */
class Layout extends Persistent
{
            public $_control=null;

            private $_type=ABS_XY_LAYOUT;

            function getType() { return $this->_type; }
            function setType($value) { $this->_type=$value; }
            function defaultType() { return ABS_XY_LAYOUT; }

            protected $_rows=5;

            function getRows() { return $this->_rows; }
            function setRows($value) { $this->_rows=$value; }
            function defaultRows() { return 5; }

            protected $_cols=5;

            function getCols() { return $this->_cols; }
            function setCols($value) { $this->_cols=$value; }
            function defaultCols() { return 5; }

            function dumpABSLayout($exclude=array())
            {
                if ($this->_control!=null)
                {
                        reset($this->_control->controls->items);
                        while (list($k,$v)=each($this->_control->controls->items))
                        {
                                if (!empty($exclude))
                                {
                                        if (in_array($v->classname(),$exclude))
                                        {
                                                continue;
                                        }
                                }
                                $dump=false;

                                if (($v->Visible) && (!$v->IsLayer) && (($this->_control->methodExists('getActiveLayer')) && (string)$v->Layer==(string)$this->_control->Activelayer)) $dump=true;
                                else if (($v->Visible) && (!$v->IsLayer)) $dump=true;
//                                if (($v->Visible) && (!$v->IsLayer) && ((string)$v->Layer==(string)$this->_control->Activelayer))
                                if ($dump)
                                {
                                        $left=$v->Left;
                                        $top=$v->Top;
                                        $aw=$v->Width;
                                        $ah=$v->Height;

                                        $style="Z-INDEX: $k; LEFT: ".$left."px; WIDTH: ".$aw."px; POSITION: absolute; TOP: ".$top."px; HEIGHT: ".$ah."px";

                                        echo "<div id=\"".$v->Name."_outer\" style=\"$style\">\n";
                                        $v->show();
                                        echo "\n</div>\n";
                                }
                        }
                }
            }

            function dumpXYLayout($exclude=array())
            {
                        $x=array();
                        $y=array();
                        $pos=array();
                        //Iterates through controls calling show for all of them

                        reset($this->_control->controls->items);
                        while (list($k,$v)=each($this->_control->controls->items))
                        {
                                $dump=false;

                                if (($v->Visible) && (!$v->IsLayer) && (($this->_control->methodExists('getActiveLayer')) && (string)$v->Layer==(string)$this->_control->Activelayer)) $dump=true;
                                else if (($v->Visible) && (!$v->IsLayer)) $dump=true;
                                if ($dump)
                                {
                                        $left=$v->Left;
                                        $top=$v->Top;
                                        $aw=$v->Width;
                                        $ah=$v->Height;

                                        $x[]=$left;
                                        $x[]=$left+$aw;
                                        $y[]=$top;
                                        $y[]=$top+$ah;

                                        $pos[$left][$top]=$v;
                                }
                        }

                        $width=$this->_control->Width;
                        $height=$this->_control->Height;

                        $x[]=$width;
                        $y[]=$height;

                        sort($x);
                        sort($y);


                                //Dumps the inner controls
                                if ($this->_control->controls->count()>=1)
                                {
                                        $widths=array();
                                        reset($x);
                                        if ($x[0]!=0) $widths[]=$x[0];
                                        while (list($k,$v)=each($x))
                                        {
                                                if ($k<count($x)-1)
                                                {
                                                        if ($x[$k+1]-$v!=0) $widths[]=$x[$k+1]-$v;
                                                }
                                                else $widths[]="";
                                        }

                                        $heights=array();
                                        reset($y);
                                        if ($y[0]!=0) $heights[]=$y[0];
                                        while (list($k,$v)=each($y))
                                        {
                                                if ($k<count($y)-1)
                                                {
                                                        if ($y[$k+1]-$v!=0) $heights[]=$y[$k+1]-$v;
                                                }
                                                else $heights[]="";
                                        }


                                        $y=0;
                                        reset($heights);

                                        while (list($hk,$hv)=each($heights))
                                        {
                                                        if ($hv!="")
                                                        {

                                                        }
                                                        else continue;


                                                $rspan=false;

                                                $x=0;
                                                reset($widths);

                                                ob_start();
                                                while (list($k,$v)=each($widths))
                                                {
                                                        $cs=1;
                                                        $rs=1;


                                                        if (isset($pos[$x][$y]))
                                                        {
                                                                if ((!is_object($pos[$x][$y]))  && ($pos[$x][$y]==-1))
                                                                {
                                                                        $x+=$v;
                                                                        continue;
                                                                }
                                                        }

                                                        if (isset($pos[$x][$y]))
                                                        {
                                                                $control=$pos[$x][$y];
                                                        }
                                                        else $control=null;

                                                        $w=0;

                                                        if (is_object($control))
                                                        {
                                                                $w=$control->Width;
                                                                $h=$control->Height;

                                                                $tv=0;
                                                                $th=0;

                                                                $also=array();

                                                                for ($kkk=$hk;$kkk<count($heights);$kkk++)
                                                                {
                                                                        if ($heights[$kkk]!='')
                                                                        {
                                                                                $tv+=$heights[$kkk];
                                                                                if ($h>$tv)
                                                                                {
                                                                                        $rs++;
                                                                                        $pos[$x][$y+$tv]=-1;
                                                                                        $also[]=$y+$tv;
                                                                                }
                                                                                else break;
                                                                        }
                                                                }

                                                                for ($ppp=$k;$ppp<count($widths);$ppp++)
                                                                {
                                                                        if ($widths[$ppp]!='')
                                                                        {
                                                                                $th+=$widths[$ppp];

                                                                                if ($w>$th)
                                                                                {
                                                                                        $cs++;
                                                                                        $pos[$x+$th][$y]=-1;

                                                                                        reset($also);
                                                                                        while(list($ak,$av)=each($also))
                                                                                        {
                                                                                                $pos[$x+$th][$av]=-1;
                                                                                        }
                                                                                }
                                                                                else break;
                                                                        }
                                                                }
                                                        }


                                                        $width="";
                                                        if ($v!="")
                                                        {
                                                                $zv=round(($v*100)/$this->_control->Width,2);
                                                                $zv.="%";
                                                                $width=" width=\"$v\" ";
                                                        }

                                                        if ($rs!=1)
                                                        {
                                                                $rspan=true;
                                                                $rs=" rowspan=\"$rs\" ";
                                                        }
                                                        else $rs="";

                                                        if ($cs!=1)
                                                        {
                                                                $cs=" colspan=\"$cs\" ";
                                                                $width="";
                                                        }
                                                        else $cs="";

                                                        $hh="";

                                                        echo "<td $width $hh $rs $cs valign=\"top\">";

                                                        if (is_object($control)) $control->show();
                                                        else
                                                        {

                                                                echo "<img src=\"vcl/images/pixel_trans.gif\" width=\"1\" height=\"1\">";
                                                        }

                                                        echo "</td>\n";
                                                        $x+=$v;
                                                }
                                                $trow=ob_get_contents();
                                                ob_end_clean();
                                                if ($hv!="")
                                                {
                                                        $zhv=round(($hv*100)/$this->_control->Height,2);
                                                        $zhv.="%";
                                                        echo "<tr height=\"$hv\">";
                                                }
                                                echo $trow;
                                                echo "</tr>\n";
                                                $y+=$hv;
                                        }
                                }
                                else
                                {
                                        echo "<tr><td>";
                                        echo "<img src=\"vcl/images/pixel_trans.gif\" width=\"1\" height=\"1\">";
                                        echo "</td></tr>";
                                }

                        reset($this->_control->controls->items);
                        while (list($k,$v)=each($this->_control->controls->items))
                        {
                                if (($v->Visible) && ($v->IsLayer))
                                {
                                        $v->show();
                                }
                        }
            }

            function dumpFlowLayout($exclude=array())
            {
            }

            function dumpLayoutContents($exclude=array())
            {
                switch($this->_type)
                {
                        case COL_LAYOUT: $this->dumpColLayout($exclude); break;
                        case ROW_LAYOUT: $this->dumpRowLayout($exclude); break;
                        case GRIDBAG_LAYOUT: $this->dumpGridBagLayout($exclude); break;
                        case ABS_XY_LAYOUT: $this->dumpABSLayout($exclude); break;
                        case XY_LAYOUT: $this->dumpXYLayout($exclude); break;
                        case FLOW_LAYOUT: $this->dumpFlowLayout($exclude); break;
                }
            }

            function dumpGridBagLayout($exclude=array())
            {
                    $this->dumpGrid($exclude, $this->_cols, $this->_rows, "100%");
            }

            function dumpRowLayout($exclude=array())
            {
                    $this->dumpGrid($exclude, $this->_cols, 1, "100%");
            }

            function dumpColLayout($exclude=array())
            {
                    $this->dumpGrid($exclude, 1, $this->_rows, "100%");
            }

            function dumpGrid($exclude=array(),$cols,$rows,$width)
            {
                    $pwidth=$this->_control->Width;
                    $pheight=$this->_control->Height;

                    $cwidth = round($pwidth / $cols,0);
                    $cheight = round($pheight / $rows,0);

                    $controls=array();
                        reset($this->_control->controls->items);
                        while (list($k,$v)=each($this->_control->controls->items))
                        {
                            $col=round($v->Left / $cwidth,0);
                            $row=round($v->Top / $cheight,0);

                            $controls[$col][$row]=$v;
                        }

                    echo "<table width=\"$width\" height=\"$pheight\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
                    for($y=0;$y<=$rows-1;$y++)
                    {
                        echo "<tr>\n";
                        for($x=0;$x<=$cols-1;$x++)
                        {
                            if (isset($controls[$x][$y]))
                            {
                                $v=$controls[$x][$y];
                                if (is_object($v))
                                {
                                    $v->AdjustToLayout=true;

                                    $cspan="";
                                    $rspan="";

                                    $cspan = round(($v->Width / $cwidth),0);
                                    if ($cspan > 1)
                                    {
                                        //for ($xx=$x+1;$xx<=$x+$cspan;$xx++)  $controls[$xx][$y]=-1;
                                    }

                                    $rspan = round(($v->Height / $cheight),0);
                                    if ($rspan > 1)
                                    {
                                        //for ($yy=$y+1;$yy<=$y+$rspan;$yy++)  $controls[$x][$yy]=-1;
                                    }


                                    for ($xx=$x;$xx<$x+$cspan;$xx++)
                                    {
                                        for ($yy=$y;$yy<$y+$rspan;$yy++)
                                        {
                                            $controls[$xx][$yy]=-1;
                                        }
                                    }


                                    if ($cspan>1) $cspan=" colspan=\"$cspan\" ";
                                    else $cspan="";

                                    if ($rspan>1) $rspan=" rowspan=\"$rspan\" ";
                                    else $rspan="";

                                    $pw=round((100*$v->Width)/$pwidth);
                                    $pw=" width=\"$pw%\" ";

                                    $ph=round((100*$v->Height)/$pheight);
                                    $ph=" height=\"$ph%\" ";

                                    echo "<td valign=\"top\" $pw $ph $cspan $rspan>\n";
                                    $v->show();
                                    echo "\n</td>\n";
                                }
                            }
                            else
                            {
                                echo "<td>&nbsp;\n";
                                echo "</td>\n";
                            }
                        }
                        echo "</tr>\n";
                    }
                    echo "</table>\n";
            }
}

/**
 * Font encapsulation
 *
 */
class Font extends Persistent
{
        protected $_family="Verdana";
        protected $_size="10px";
        protected $_color="";
        protected $_weight="";
        protected $_align="taNone";
        protected $_style="";
        protected $_case="";
        protected $_variant="";
        protected $_lineheight="";

        public $_control=null;

        private $_updatecounter = 0;

        /**
        * Assign Font object to another Font object.
        * @param object $dest Destination, where the new font settings are assigned to.
        */
        function assignTo($dest)
        {
                // make sure modified() is not always called while assigning new values
                $dest->startUpdate();

                $dest->setFamily($this->getFamily());
                $dest->setSize($this->getSize());
                $dest->setColor($this->getColor());
                $dest->setAlign($this->getAlign());
                $dest->setStyle($this->getStyle());
                $dest->setCase($this->getCase());
                $dest->setLineHeight($this->getLineHeight());
                $dest->setVariant($this->getVariant());
                $dest->setWeight($this->getWeight());

                $dest->endUpdate();
        }

        /**
        * Call startUpdate() when multiple properties of the Font are updated at
        * the same time. Once finished updating, call endUpdate().
        * It prevents the updating of the control where the Font is assigned to
        * until the endUpdate() function is called.
        */
        function startUpdate()
        {
                $this->_updatecounter++;
        }

        /**
        * Re-enables the notification mechanism to the control.
        * Note: endUpdate() has to be called as many times as startUpdate() was
        *       called on the same Font object.
        */
        function endUpdate()
        {
                $this->_updatecounter--;
                // let's just make sure that if the endUpdate() is called too many times
                // that the $this->_updatecounter is valid and the font is updated
                if ($this->_updatecounter < 0)
                {
                        $this->_updatecounter = 0;
                }
                // when finished updating call the modified() function to notify the control.
                if ($this->_updatecounter == 0)
                {
                        $this->modified();
                }
        }

        /**
        * Indicates if the Font object is in update mode. If true, the control
        * where the Font is assigned to will not be notified when a property changes.
        * @return bool
        */
        function isUpdating()
        {
                return $this->_updatecounter != 0;
        }

        /**
         * Check if the font has been modified to set to false the parentfont
         * property of the control, if any
         */
        function modified()
        {
                if (!$this->isUpdating() && $this->_control!=null  && ($this->_control->ControlState & csLoading) != csLoading && $this->_control->Name != "")
                {
                        $f=new Font();
                        $fstring=$f->readFontString();

                        $tstring=$this->readFontString();


                        if ($this->_control->ParentFont)
                        {
                                $parent=$this->_control->Parent;
                                if ($parent!=null) $fstring=$parent->Font->readFontString();
                        }

                        // check if font changed and if the ParentFont can be reset
                        if ($fstring!=$tstring && $this->_control->DoParentReset)
                        {
                                $c=$this->_control;
                                $c->ParentFont = 0;
                        }
                                             
                        if ($this->_control->methodExists("updateChildrenFonts"))
                        {
                                $this->_control->updateChildrenFonts();
                        }
                }
        }


        //Family property
        function getFamily() { return $this->_family;   }
        function setFamily($value) { $this->_family=$value; $this->modified(); }
        function defaultFamily() { return "Verdana";   }

        //Size property
        function getSize() { return $this->_size;       }
        function setSize($value) { $this->_size=$value; $this->modified(); }
        function defaultSize() { return "10px";       }

        //LineHeight property
        function getLineHeight() { return $this->_lineheight;       }
        function setLineHeight($value) { $this->_lineheight=$value; $this->modified(); }
        function defaultLineHeight() { return "";       }

        //Style property
        function getStyle() { return $this->_style;       }
        function setStyle($value) { $this->_style=$value; $this->modified(); }
        function defaultStyle() { return "";       }

        //Case property
        function getCase() { return $this->_case;       }
        function setCase($value) { $this->_case=$value; $this->modified(); }
        function defaultCase() { return "";       }

        //Variant property
        function getVariant() { return $this->_variant;       }
        function setVariant($value) { $this->_variant=$value; $this->modified(); }
        function defaultVariant() { return "";       }

        //Color property
        function getColor() { return $this->_color;       }
        function setColor($value) { $this->_color=$value; $this->modified(); }
        function defaultColor() { return "";       }

        //Align property
        function getAlign() { return $this->_align;       }
        function setAlign($value) { $this->_align=$value; $this->modified(); }
        function defaultAlign() { return taNone;       }

        //Weight property
        function getWeight() { return $this->_weight;   }
        function setWeight($value) { $this->_weight=$value; $this->modified(); }
        function defaultWeight() { return "";       }

        /**
         * Returns an style string to be asigned to the tag
         *
         * @return strgin
         */
        function readFontString()
        {
                /*
                if ($this->_control!=null)
                {
                        if ($this->_control->ParentFont)
                        {
                                $parent=$this->_control->Parent;
                                if ($parent!=null) return($parent->Font->readFontString());
                        }
                }
                */

                $textalign="";
                switch($this->_align)
                {
                        case taLeft: $textalign="text-align: left;"; break;
                        case taRight: $textalign="text-align: right;"; break;
                        case taCenter: $textalign="text-align: center;"; break;
                        case taJustify: $textalign="text-align: justify;"; break;
                }

                $fontstyle="";
                switch($this->_style)
                {
                        case fsNormal: $fontstyle="font-style: normal;"; break;
                        case fsItalic: $fontstyle="font-style: italic;"; break;
                        case fsOblique: $fontstyle="font-style: oblique;"; break;
                }

                $fontvariant="";
                switch($this->_variant)
                {
                        case vaNormal: $fontstyle="font-variant: normal;"; break;
                        case vaSmallCaps: $fontstyle="font-variant: small-caps;"; break;
                }

                $texttransform="";
                switch($this->_case)
                {
                        case caCapitalize: $texttransform="text-transform: capitalize;"; break;
                        case caUpperCase: $texttransform="text-transform: uppercase;"; break;
                        case caLowerCase: $texttransform="text-transform: lowercase;"; break;
                        case caNone: $texttransform="text-transform: none;"; break;
                }

                $color="";
                if ($this->_color!="") $color="color: $this->_color;";

                $lineheight="";
                if ($this->_lineheight!="") $lineheight="line-height: $this->_lineheight;";

                $fontweight="";
                if ($this->_weight!="") $fontweight="font-weight: $this->_weight;";


                $result=" font-family: $this->_family; font-size: $this->_size; $color$fontweight$textalign$fontstyle$lineheight$fontvariant$texttransform ";
                return($result);
        }
}

/**
 * Pen encapsulation
 *
 */
class Pen extends Persistent
{
        protected $_color="#000000";
        protected $_width="1";
//        protected $_style=psSolid;
        protected $_modified=0;

        function assignTo($dest)
        {
                $dest->Color=$this->Color;
                $dest->Width=$this->Width;
//                $dest->Style=$this->Style;
        }

        function modified()             { $this->_modified=1; }
        function isModified()           { return $this->_modified; }
        function resetModified()        { $this->_modified = 0; }

        //Color property
        function getColor()             { return $this->_color; }
        function setColor($value)       { $this->_color=$value; $this->modified(); }
        function defaultColor()         { return "#000000"; }

        //Width property
        function getWidth()             { return $this->_width; }
        function setWidth($value)       { $this->_width=$value; $this->modified(); }
        function defaultWidth()         { return "1"; }

        //Style property
//        function getStyle()             { return $this->_style; }
//        function setStyle($value)       { $this->_style=$value; }
//        function defaultStyle()         { return psSolid; $this->modified(); }
}

/**
 * Brush class
 *
 */
class Brush extends Persistent
{
        protected $_color="#FFFFFF";
        protected $_modified=0;

        function assignTo($dest)
        {
                $dest->Color=$this->Color;
        }

        function modified()             { $this->_modified=1; }
        function isModified()           { return $this->_modified; }
        function resetModified()        { $this->_modified = 0; }

        //Color property
        function getColor()             { return $this->_color; }
        function setColor($value)       { $this->_color=$value; $this->modified(); }
        function defaultColor() { return "";       }
}

/**
 * Create color based on HEX RGB mask
 * mask can be prefixed with #
 *
 */
function ColorFromHex($img, $hexColor)
{
        while (strlen($hexColor) > 6) { $hexColor = substr($hexColor, 1);  };
        sscanf($hexColor, "%2x%2x%2x", $red, $green, $blue);
        return ImageColorAllocate($img, $red, $green, $blue);
}

/**
 * Create Pen based on PenStyle
 *
 */
function CreatePenStyle($img, $penStyle, $baseColor, $bgColor)
{
        $b  = ColorFromHex($img, $bgColor);
        $w  = ColorFromHex($img, $baseColor);

        switch ($penStyle)
        {
                case psDash:
                        return array($w, $w, $w, $w, $b, $b, $b, $b);
                        break;
                case psDashDot:
                        return array($w, $w, $w, $w, $b, $b, $w, $b, $b);
                        break;
                case psDot:
                        return array($w, $b, $b, $w, $b, $b);
                        break;
                case psDashDotDot:
                        return array($w, $w, $w, $w, $b, $w, $b, $w, $b);
                        break;
                default:
                  //psSolid
                        return array($w);
                        break;
        }
}

/**
 * Canvas class
 *
 * @package Graphics
 */
class Canvas extends Persistent
{
        protected $_pen=null;
        protected $_brush=null;
        protected $_font=null;
        protected $_canvas="";
        protected $_object="";
        protected $_owner=null;

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->_pen=new Pen();
                $this->_pen->Width=1;
                $this->_brush=new Brush();
                $this->_font=new Font();
                $this->_owner=$aowner;
        }

        protected function forceBrush()
        {
                if ($this->_brush->isModified())
                {
                        echo "$this->_canvas.setColor(\"" . $this->_brush->Color . "\");\n";
                        $this->_brush->resetModified();
                        $this->_pen->modified();
                }
        }
        protected function forcePen()
        {
                if ($this->_pen->isModified())
                {
                        echo "$this->_canvas.setStroke(" . $this->_pen->Width . ");\n";
                        echo "$this->_canvas.setColor(\"" . $this->_pen->Color . "\");\n";
                        $this->_pen->resetModified();
                        $this->_brush->modified();
                }
        }
        protected function forceFont()
        {
                echo "$this->_canvas.setFont(\"" . $this->_font->Family . "\", \"" . $this->_font->Size . "\", \"" . $this->_font->Style . "\");\n";
                echo "$this->_canvas.setColor(\"" . $this->_font->Color . "\");\n";
        }

        function InitLibrary()
        {

                if (!defined('JSCANVAS'))
                {
                        echo "<script type=\"text/javascript\" src=\"" . VCL_HTTP_PATH . "/walterzorn/wz_jsgraphics.js\"></script>\n";
                        define('JSCANVAS', 1);
                }

                if (is_object($this->_owner))
                {
                        $this->SetCanvasProperties($this->_owner->Name);
                }
        }
        function SetCanvasProperties($Name)
        {
                $this->_canvas= $Name . "_Canvas";
                $this->_object= $Name . "_outer";
        }
        /**
         * Begins draw cycle. Establishes internal Canvas object.
         * Should be followed by EndDraw to push drawing to the page canvas
         */
        function BeginDraw()
        {
                echo "<script type=\"text/javascript\">\n";
                echo "  var $this->_canvas = new jsGraphics(\"$this->_object\");\n";
                $this->_canvas= "  " . $this->_canvas;
        }
        /**
         * Ends draw cycle. Used to finish drawing and push it to
         * the page canvas
         */
        function EndDraw()
        {
                echo "$this->_canvas.paint();\n";
                echo "</script>\n";
        }
        /**
         * Draws an arc on the image along the perimeter of the ellipse bounded
         * by the specified rectangle.
         */
        function Arc($x1, $y1, $x2, $y2, $x3, $y3, $x4, $y4)
        {
                $this->forcePen();
                //echo "$this->_canvas.drawArc($x1, $y1, $r * 2, $r * 2, 180, 270);\n";
        }
        /**
         * Draws the ellipse defined by a bounding rectangle on the canvas.
         * @param x1, y1 - The top left point at pixel coordinates
         * @param x2, y2 - The bottom right point
         */
        function Ellipse($x1, $y1, $x2, $y2)
        {
                $this->forceBrush();
                echo "$this->_canvas.fillEllipse($x1 + 1, $y1+ 1, $x2-$x1+1, $y2-$y1+1);\n";
                $this->forcePen();
                echo "$this->_canvas.drawEllipse($x1, $y1, $x2-$x1+1, $y2-$y1+1);\n";
        }
        /**
         * Fills the specified rectangle on the canvas using the current brush.
         * The region is filled including the top and left sides of the rectangle,
         * but excluding the bottom and right edges.
         * @param x1, y1 - The top left point at pixel coordinates
         * @param x2, y2 - The bottom right point
         */
        function FillRect($x1, $y1, $x2, $y2)
        {
                $this->forceBrush();
                echo "$this->_canvas.fillRect($x1, $y1, $x2 - $x1, $y2 - $y1);\n";
        }
        /**
         * Draws a rectangle using the Brush of the canvas to draw the border.
         */
        function FrameRect($x1, $y1, $x2, $y2)
        {
                $this->forcePen();
                $this->forceBrush();
                echo "$this->_canvas.drawRect($x1, $y1, $x2-$x1+1, $y2-$y1+1);\n";
        }
        /**
         * Draws a line on the canvas using specified coordinates
         * @param x1, y1 - The starting point
         * @param x2, y2 - The ending point
         */
        function Line($x1, $y1, $x2, $y2)
        {
                $this->forcePen();
                echo "$this->_canvas.drawLine($x1, $y1, $x2, $y1);\n";
        }
        function Polygon($points)
        {
                $this->forceBrush();
                // here need to put logic to draw filled polygon
                // fillPolygon(Xpoints, Ypoints);
                // var Xpoints = new Array(x1,x2,x3,x4,x5);
                // var Ypoints = new Array(y1,y2,y3,y4,y5);
                $this->Polyline($points);
        }
        function Polyline($points)
        {
                $this->forcePen();
                // here need to put logic to draw polyline
                // drawPolygon(Xpoints, Ypoints);
                // var Xpoints = new Array(x1,x2,x3,x4,x5);
                // var Ypoints = new Array(y1,y2,y3,y4,y5);
        }
        /**
         * Draws a rectangle on the canvas using Pen and fill it with Brush
         */
        function Rectangle($x1, $y1, $x2, $y2)
        {
                $this->forceBrush();
                echo "$this->_canvas.fillRect($x1, $y1, $x2 - $x1 + 1, $y2 - $y1 + 1);\n";
                $this->forcePen();
                echo "$this->_canvas.drawRect($x1, $y1, $x2 - $x1 + 1, $y2 - $y1 + 1);\n";
        }
        /**
         * Draws a rectangle with rounded corners on the canvas.
         */
        function RoundRect($x1, $y1, $x2, $y2, $w, $h)
        {
                $cx = $w/2;
                $cy = $h/2;
                $rw = $x2 - $x1 + 1;
                $rh = $y2 - $y1 + 1;
                $wp = $this->_pen->Width;
                // draw shape
                $this->forceBrush();
                echo "$this->_canvas.fillRect($x1 + $cx, $y1, $rw - $w, $rh);\n";
                echo "$this->_canvas.fillRect($x1, $y1 + $cy, $rw, $rh - $h);\n";
                // draw border
                $this->forcePen();
                echo "$this->_canvas.drawLine($x1 + $cx, $y1, $x2 - $cx, $y1);\n";
                echo "$this->_canvas.drawLine($x1 + $cx, $y2, $x2 - $cx, $y2);\n";
                echo "$this->_canvas.drawLine($x1, $y1 + $cy, $x1, $y2 - $cy);\n";
                echo "$this->_canvas.drawLine($x2, $y1 + $cy, $x2, $y2 - $cy);\n";

                $this->forcePen();
                echo "$this->_canvas.fillArc($x1, $y1, $w, $h, 90, 180);\n";
                echo "$this->_canvas.fillArc($x2 - $w + $wp, $y1, $w, $h + $wp, 0, 90);\n";
                echo "$this->_canvas.fillArc($x1, $y2 - $h + $wp, $w, $h, 180, 270);\n";
                echo "$this->_canvas.fillArc($x2 - $w + $wp, $y2 - $h + $wp, $w, $h, 270, 360);\n";

                $this->forceBrush();
                echo "$this->_canvas.fillArc($x1 + $wp, $y1 + $wp, $w - $wp, $h - $wp, 90, 180);\n";
                echo "$this->_canvas.fillArc($x2 - $w + $wp, $y1 + $wp, $w - $wp, $h - $wp, 0, 90);\n";
                echo "$this->_canvas.fillArc($x1 + $wp, $y2 - $h, $w, $h, 180, 270);\n";
                echo "$this->_canvas.fillArc($x2 - $w, $y2 - $h, $w, $h, 270, 360);\n";


                //echo "$this->_canvas.drawArc($x2 - $r * 2, $y1, $r * 2, $r * 2, 270, 360);\n";
                //echo "$this->_canvas.drawArc($x1, $y2 - $r * 2, $r * 2, $r * 2, 90, 180);\n";
                //echo "$this->_canvas.drawArc($x2 - $r * 2, $y2 - $r * 2, $r * 2, $r * 2, 360, 90);\n";
        }
        /**
         * Draws the graphic specified by the @image parameter in the rectangle
         * specified by the Rect coordinates.
         */
        function StretchDraw($x1, $y1, $x2, $y2, $image)
        {
                echo "$this->_canvas.drawImage(\"$image\", $x1, $y1, $x2-$x1+1, $y2-$y1+1);\n";
        }
        /**
         * Writes a string on the canvas, starting at the point (X,Y)
         */
        function TextOut($x, $y, $text)
        {
                $this->forceFont();
                echo "$this->_canvas.drawString(\"$text\", $x, $y);\n";
        }
        /**
         * Draw Bevel-like rectangle using specified colors
         */
        function BevelRect($x1, $y1, $x2, $y2, $color1, $color2)
        {
                $this->forcePen();
                echo "$this->_canvas.setColor(\"" . $color1 . "\");\n";
                echo "$this->_canvas.drawLine($x1, $y2, $x1, $y1);\n";
                echo "$this->_canvas.drawLine($x1, $y1, $x2, $y1);\n";
                echo "$this->_canvas.setColor(\"" . $color2 . "\");\n";
                echo "$this->_canvas.drawLine($x2, $y1, $x2, $y2);\n";
                echo "$this->_canvas.drawLine($x2, $y2, $x1, $y2);\n";
        }
        /**
         * Draw the line using specified color
         */
        function BevelLine($color, $x1, $y1, $x2, $y2)
        {
                $this->forcePen();
                echo "$this->_canvas.setColor(\"" . $color . "\");\n";
                echo "$this->_canvas.drawLine($x1, $y1, $x2, $y2);\n";
        }

        //Font property
        protected function readFont()           { return $this->_font; }
        protected function writeFont($value)    { if (is_object($value)) $this->_font=$value; }

        // properties
        function getBrush()                     { return $this->_brush; }
        function setBrush($value)               { if (is_object($value)) $this->_brush=$value; }
        function getFont()                      { return $this->readFont(); }
        function setFont($value)                { $this->_font->writeFont($value); }
        function getPen()                       { return $this->_pen; }
        function setPen($value)                 { if (is_object($value)) $this->_pen=$value; }
}

?>
