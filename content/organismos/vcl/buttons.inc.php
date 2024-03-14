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

use_unit("extctrls.inc.php");


define('blImageBottom', 'blImageBottom');
define('blImageLeft', 'blImageLeft');
define('blImageRight', 'blImageRight');
define('blImageTop', 'blImageTop');

/**
 * BitBtn is a dynamic button with bitmap.
 *
 * @package Buttons
 */
class BitBtn extends QWidget
{
        protected $_onclick = null;

        protected $_imagesource = "";
        protected $_buttonlayout = blImageLeft;


        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width=75;
                $this->Height=25;
        }

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

        function init()
        {
                parent::init();

                $submitEventValue = $this->input->{$this->getJSWrapperHiddenFieldName()};

                if (is_object($submitEventValue) && $this->_enabled == 1)
                {
                        // check if the a click event has been fired
                        if ($this->_onclick != null && $submitEventValue->asString() == $this->getJSWrapperSubmitEventValue($this->_onclick))
                        {
                                $this->callEvent('onclick', array());
                        }
                }
        }

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
                }

                if (!defined('updateButtonTheme') && $this->classNameIs("BitBtn"))
                {
                        define('updateButtonTheme', 1);

                        echo "
function updateButtonTheme() {
  var theme =  qx.manager.object.AppearanceManager.getInstance().getAppearanceTheme();
  var apar = theme.getAppearance('button');
  if (!apar) {
     return;
  }
  var oldState = apar.state;
  apar.state = function(vTheme, vStates) {
    var res = oldState ? oldState.apply(this, arguments):{};

    if (typeof(res) != 'undefined' && typeof(res.backgroundColor) != 'undefined')
      delete res.backgroundColor;

    return res;
  }
}
";
                }
        }

        //If the component must be updated for Ajax, which script do we need to execute?
        function dumpForAjax()
        {
                $this->commonScript();
        }

        function dumpContents()
        {
                if (($this->ControlState & csDesigning) != csDesigning)
                {
                        echo "<script type=\"text/javascript\">updateButtonTheme();</script>\n";
                }

                $this->dumpCommonContentsTop();

                $imgwidth = 0;
                $imgheight = 0;
                // first let's get the image size
                if ($this->_imagesource != "")
                {
                        $result = getimagesize($this->getImageSourcePath());

                        if (is_array($result))
                        {
                                list($imgwidth, $imgheight, $type, $attr) = $result;
                        }
                }

                $btnimage = "";
                if ($imgwidth > 0 && $imgheight > 0)
                {
                        $btnimage = ",\"$this->_imagesource\",$imgwidth,$imgheight";
                }

                // set teh general properties of the button
                echo "        var ".$this->Name." = new qx.ui.form.Button(\"$this->Caption\"$btnimage);\n";
                $this->commonScript();
                if (($this->ControlState & csDesigning) != csDesigning)
                {
                        // add the onclick wrapper to the event listener
                        if ($this->_onclick != null && $this->Owner != null)
                        {
                                $wrapperEvent = $this->getJSWrapperFunctionName($this->_onclick);
                                $submitEventValue = $this->getJSWrapperSubmitEventValue($this->_onclick);
                                $hiddenfield = $this->getJSWrapperHiddenFieldName();
                                $hiddenfield = "document.forms[0].$hiddenfield";
                                echo "        $this->Name.addEventListener(\"execute\", function(){ var event = event || window.event; return $wrapperEvent(event, $hiddenfield, '$submitEventValue', null) } );\n";
                        }

                        // add the common JS events to the QWidget (0 = no JS OnChange event added)
                        $this->dumpCommonQWidgetJSEvents($this->Name, 0);
                }

                // Call the OnShow event handler after all settings of the BitBtn
                // have been outputted so it is possible to reset them in the OnShow event.
                $this->callEvent('onshow', array());                
                $this->dumpCommonContentsBottom();

                // add a hidden field so we can determine which event for the button was fired
                if ($this->_onclick != null)
                {
                        $hiddenwrapperfield = $this->getJSWrapperHiddenFieldName();
                        echo "<input type=\"hidden\" id=\"$hiddenwrapperfield\" name=\"$hiddenwrapperfield\" value=\"\" />";
                }
                }

                function CommonScript()
                {
                echo "        $this->Name.setLeft(0);\n";
                echo "        $this->Name.setTop(0);\n";
                echo "        $this->Name.setWidth($this->Width);\n";
                echo "        $this->Name.setHeight($this->Height);\n";

                // adds Enabled, Visible, Font and Color property
                $this->dumpCommonQWidgetProperties($this->Name, 0);

                // set font the the button's label
                echo "        var lblobj = $this->Name.getLabelObject();\n";
                echo "        if (lblobj) lblobj.setFont(\"{$this->Font->Size} '{$this->Font->Family}' {$this->Font->Weight}\");\n";
                // set the font color
                if ($this->Font->Color != "")
                        echo "        $this->Name.setColor(new qx.renderer.color.Color('{$this->Font->Color}'));\n";

                // set the layout
                if ($this->_buttonlayout != blImageLeft)
                {
                        $iconPos = "";
                        switch ($this->_buttonlayout)
                        {
                                case blImageBottom: $iconPos = "bottom"; break;
                                case blImageRight:  $iconPos = "right"; break;
                                case blImageTop:    $iconPos = "top"; break;
                        }
                        echo "        $this->Name.setIconPosition('$iconPos');\n";
                }

                // set hint
                $hint = $this->getHintAttribute();
                if ($hint != "")
                        echo "        $this->Name.setHtmlAttribute('title', '$this->Hint');\n";

                // set cursor
                if ($this->Cursor != "")
                        echo "        $this->Name.setStyleProperty('cursor', '".strtolower(substr($this->Cursor, 2))."');\n";

                // set background color
                if ($this->Color != "")
                        echo "        ".$this->Name.".setBackgroundColor(new qx.renderer.color.Color('$this->Color'));\n";
                else
                        echo "        ".$this->Name.".setBackgroundColor(new qx.renderer.color.ColorObject('buttonface'));\n";
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
        * @param mixed Event handler or null if no handler is set.
        */
        function setOnClick                     ($value) { $this->_onclick=$value; }
        function defaultOnClick                 () { return null; }

        /*
        * Publish the JS events for the component
        */
        function getjsOnBlur                    () { return $this->readjsOnBlur(); }
        function setjsOnBlur                    ($value) { $this->writejsOnBlur($value); }

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
        * Publish the properties for the component
        */
        function getCaption() { return $this->readCaption(); }
        function setCaption($value) { $this->writeCaption($value); }

        function getColor() { return $this->readColor(); }
        function setColor($value) { $this->writeColor($value); }

        function getFont() { return $this->readFont(); }
        function setFont($value) { $this->writeFont($value); }

        function getEnabled() { return $this->readEnabled(); }
        function setEnabled($value) { return $this->writeEnabled($value); }

        /**
        * Source of the image that appears on the button.
        * If empty no image is rendered on the button.
        * @return string
        */
        function getImageSource() { return $this->_imagesource; }
        /**
        * Source of the image that appears on the button.
        * If empty no image is rendered on the button.
        * @param string $value
        */
        function setImageSource($value) { $this->_imagesource = $value; }
        function defaultImageSource() { return ""; }

        /**
        * Specifies where the image appears on the bitmap button.
        * @return enum (blImageBottom, blImageLeft, blImageRight, blImageTop)
        */
        function getButtonLayout() { return $this->_buttonlayout; }
        /**
        * Specifies where the image appears on the bitmap button.
        * @param enum (blImageBottom, blImageLeft, blImageRight, blImageTop)
        */
        function setButtonLayout($value) { $this->_buttonlayout=$value; }
        function defaultButtonLayout() { return blImageLeft; }

        function getParentFont() { return $this->readParentFont(); }
        function setParentFont($value) { $this->writeParentFont($value); }

        function getParentShowHint() { return $this->readParentShowHint(); }
        function setParentShowHint($value) { $this->writeParentShowHint($value); }

        function getPopupMenu() { return $this->readPopupMenu(); }
        function setPopupMenu($value) { $this->writePopupMenu($value); }

        function getShowHint() { return $this->readShowHint(); }
        function setShowHint($value) { $this->writeShowHint($value); }

        function getVisible() { return $this->readVisible(); }
        function setVisible($value) { $this->writeVisible($value); }
}

/**
 * SpeedButton Class
 *
 * SpeedButton is a button that is used to execute commands or set modes.
 *
 * Use TSpeedButton to add a button to a group of buttons in a form. SpeedButton
 * also introduces properties that allow speed buttons to work together as a group.
 * Speed buttons are commonly grouped in panels to create specialized tool bars
 * and tool palettes.
 */
class SpeedButton extends BitBtn
{
        private $_updating = 0;

        protected $_allowallup=0;
        protected $_down=0;
        protected $_flat=0;
        protected $_groupindex=0;


        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width  = 25;
                $this->Height = 25;

                $this->ControlStyle = "csRenderOwner=1";
                $this->ControlStyle = "csRenderAlso=SpeedButton";
        }

        function loaded()
        {
                parent::loaded();

                $submitteddown = $this->input->{"{$this->Name}Down"};
                if (is_object($submitteddown) && $submitteddown->asString() != "")
                {
                        $this->Down = ($submitteddown->asString() == "1") ? 1 : 0;
                }
        }

        function dumpContents()
        {
                $down = ($this->Down) ? 1 : 0;
                echo "<input type=\"hidden\" name=\"{$this->Name}Down\" id=\"{$this->Name}Down\" value=\"$down\" />";

                $this->dumpCommonContentsTop();

                $btnimage = ($this->_imagesource != "") ? ",\"$this->_imagesource\"" : "";

                // set teh general properties of the button
                echo "        var $this->Name = new qx.ui.toolbar.RadioButton(\"$this->Caption\"$btnimage);\n";
                echo "        $this->Name.setAppearance('$this->Name');\n";
                echo "        $this->Name.setLeft(0);\n";
                echo "        $this->Name.setTop(0);\n";
                echo "        $this->Name.setWidth($this->Width);\n";
                echo "        $this->Name.setHeight($this->Height);\n";

                // add an changeChecked event listener so the hidden field can be updated
                $hiddenfield = ($this->owner != null) ? "document.forms[0].{$this->Name}Down" : "";
                if ($hiddenfield != "")
                {
                        echo "        $this->Name.addEventListener(\"changeChecked\", function() { $hiddenfield.value = (this && this.getChecked()) ? 1 : 0; }, $this->Name);\n";
                }



                // user cannot unselect a selected button
                if ($this->_allowallup == 0 && $this->_groupindex > 0)
                {
                        echo "        $this->Name.setDisableUncheck(true);\n";
                }

                // add radio manager only if group index is greater than 0 and the radio manager was not already outputted
                if ($this->_groupindex > 0)
                {
                        if (!defined("sbmanager_$this->_groupindex"))
                        {
                                define("sbmanager_$this->_groupindex", 1);
                                // Radio Mananger
                                echo "        var sbmanager_$this->_groupindex = new qx.manager.selection.RadioManager(null, [$this->Name]);\n";
                        }
                        else
                        {
                                echo "        sbmanager_$this->_groupindex.add($this->Name);\n";
                        }

                        if ($this->_down == 1)
                        {
                                echo "        $this->Name.setChecked(true);\n";
                        }
                }


                // if not in a group then always uncheck it after a click
                if ($this->_groupindex == 0)
                {
                        if ($this->_enabled == 1)
                        {
                                echo "        $this->Name.addEventListener(\"execute\", function() { this.setChecked(false); }, $this->Name);\n";
                        }
                }


                // adds Enabled, Visible, Font and Color property
                $this->dumpCommonQWidgetProperties($this->Name, 0);

                // set font the the button's label
                echo "        var lblobj = $this->Name.getLabelObject();\n";
                echo "        if (lblobj) lblobj.setFont(\"{$this->Font->Size} '{$this->Font->Family}' {$this->Font->Weight}\");\n";
                // set the font color
                if ($this->Font->Color != "")
                        echo "        $this->Name.setColor(new qx.renderer.color.Color('{$this->Font->Color}'));\n";

                // set the layout
                if ($this->_buttonlayout != blImageLeft)
                {
                        $iconPos = "";
                        switch ($this->_buttonlayout)
                        {
                                case blImageBottom: $iconPos = "bottom"; break;
                                case blImageRight:  $iconPos = "right"; break;
                                case blImageTop:    $iconPos = "top"; break;
                        }
                        echo "        $this->Name.setIconPosition('$iconPos');\n";
                }

                // set hint
                $hint = $this->getHintAttribute();
                if ($hint != "")
                        echo "        $this->Name.setHtmlAttribute('title', '$this->Hint');\n";

                // set cursor
                if ($this->Cursor != "")
                        //echo "        $this->Name.setStyleProperty('cursor', '$this->Cursor');\n";
                        echo "        $this->Name.setStyleProperty('cursor', '".strtolower(substr($this->Cursor, 2))."');\n";

                // set background color
                if ($this->Color != "")
                        echo "        ".$this->Name.".setBackgroundColor(new qx.renderer.color.Color('$this->Color'));\n";
                else
                        echo "        ".$this->Name.".setBackgroundColor(new qx.renderer.color.ColorObject('buttonface'));\n";


                if (($this->ControlState & csDesigning) != csDesigning)
                {
                        // add the onclick wrapper to the event listener
                        if ($this->_onclick != null && $this->Owner != null)
                        {
                                $wrapperEvent = $this->getJSWrapperFunctionName($this->_onclick);
                                $submitEventValue = $this->getJSWrapperSubmitEventValue($this->_onclick);
                                $hiddenfield = $this->getJSWrapperHiddenFieldName();
                                $hiddenfield = "document.forms[0].$hiddenfield";
                                echo "        $this->Name.addEventListener(\"execute\", function(){ var event = event || window.event; return $wrapperEvent(event, $hiddenfield, '$submitEventValue', null) } );\n";
                        }

                        // add the common JS events to the QWidget (0 = no JS OnChange event added)
                        $this->dumpCommonQWidgetJSEvents($this->Name, 0);
                }

                // Call the OnShow event handler after all settings of the BitBtn
                // have been outputted so it is possible to reset them in the OnShow event.
                $this->callEvent('onshow', array());

                $this->dumpCommonContentsBottom();

                // add a hidden field so we can determine which event for the button was fired
                if ($this->_onclick != null)
                {
                        $hiddenwrapperfield = $this->getJSWrapperHiddenFieldName();
                        echo "<input type=\"hidden\" id=\"$hiddenwrapperfield\" name=\"$hiddenwrapperfield\" value=\"\" />";
                }
        }

        function dumpHeaderCode()
        {
                parent::dumpHeaderCode();

                if (!defined("appr $this->Name"))
                {
                        define("appr $this->Name", 1);

                        $color = "this.bgcolor_default = ";
                        $color .= ($this->Color == "") ? "new qx.renderer.color.ColorObject(\"buttonface\");" : "new qx.renderer.color.Color('$this->Color');";

                        $border = "      this.border_pressed = qx.renderer.border.BorderPresets.getInstance().".($this->Flat ? "thinInset" : "inset").";\n"
                                . "      this.border_over = qx.renderer.border.BorderPresets.getInstance().".($this->Flat ? "thinOutset" : "outset").";\n"
                                . "      this.border_default = qx.renderer.border.BorderPresets.getInstance().".($this->Flat ? "none" : "outset").";\n";

                        echo "
<script type=\"text/javascript\">
  var theme = qx.manager.object.AppearanceManager.getInstance().getAppearanceTheme();
  theme.registerAppearance('$this->Name',
  {
    setup : function()
    {
      $color
      this.bgcolor_left = new qx.renderer.color.Color(\"#FFF0C9\");
      $border
      this.checked_background = \"static/image/dotted_white.gif\";
    },

    initial : function(vTheme)
    {
      var ret = vTheme.initialFrom(\"toolbar-button\");
    },

    state : function(vTheme, vStates)
    {
      var vReturn = vTheme.stateFrom(\"toolbar-button\", vStates);
      vReturn.backgroundColor = vStates.abandoned ? this.bgcolor_left : this.bgcolor_default;
      vReturn.backgroundImage = vStates.checked && !vStates.over ? this.checked_background : null;

      if (vStates.pressed || vStates.checked || vStates.abandoned) {
        vReturn.border = this.border_pressed;
      } else if (vStates.over) {
        vReturn.border = this.border_over;
      } else {
        vReturn.border = this.border_default;
      }

      return vReturn;
    }
  });
  theme.setupAppearance(theme.getAppearance('$this->Name'));
</script>
";
                }
        }

        function beginUpdateProperties()
        {
                $this->_updating++;
        }

        function endUpdateProperties()
        {
                $this->_updating--;
        }

        protected function updateExclusive()
        {
                // this prevents a recursive endless-loop (only one speed button can update the others at a time)
                if ($this->_updating == 0 && $this->GroupIndex > 0)
                {
                        if ($this->Owner != null && $this->Name != "")
                        {
                                foreach ($this->Owner->components->items as $k => $v)
                                {
                                        // only update SpeedButtons which are in the same group, don't update itself
                                        if ($v->Name != $this->Name && $v->className() == "SpeedButton" && $v->GroupIndex == $this->_groupindex)
                                        {
                                                $v->beginUpdateProperties();

                                                if ($this->_down == 1)
                                                {
                                                        $v->Down = 0;
                                                }
                                                $v->AllowAllUp = $this->_allowallup;

                                                $v->endUpdateProperties();
                                        }
                                }
                        }
                }
        }

        /**
        * Specifies whether all speed buttons in the group that contains this
        * speed button can be unselected at the same time.
        * @return bool
        */
        function getAllowAllUp() { return $this->_allowallup; }
        /**
        * Specifies whether all speed buttons in the group that contains this
        * speed button can be unselected at the same time.
        * @param bool $value
        */
        function setAllowAllUp($value)
        {
                if ($value != $this->_allowallup)
                {
                        $this->_allowallup = $value;
                        $this->updateExclusive();
                }
        }
        function defaultAllowAllUp() { return 0; }

        /**
        * Specifies whether the button is selected (down) or unselected (up).
        * @return bool
        */
        function getDown() { return $this->_down; }
        /**
        * Specifies whether the button is selected (down) or unselected (up).
        * @param bool $value
        */
        function setDown($value)
        {
                if ($this->_groupindex == 0)
                {
                        $this->_down = 0;
                }
                else if ($value != $this->_down)
                {
                        if (!($this->_down == 1 && $this->_allowallup == 0))
                        {
                                $this->_down = $value;

                                if ($value == 1)
                                {
                                        $this->updateExclusive();
                                }
                        }
                }
        }
        function defaultDown() { return 0; }

        /**
        * Determines whether the button has a 3D border that provides a raised
        * or lowered look.
        * @return bool
        */
        function getFlat() { return $this->_flat; }
        /**
        * Determines whether the button has a 3D border that provides a raised
        * or lowered look.
        * @param bool $value
        */
        function setFlat($value) { $this->_flat=$value; }
        function defaultFlat() { return 0; }

        /**
        * Allows speed buttons to work together as a group.
        * When GroupIndex is 0, the button behaves independently of all
        * other buttons on the form. When the user clicks such a speed button,
        * the button appears pressed (in its clicked state) and then returns to
        * its normal up state when the user releases the mouse button.
        * @return integer
        */
        function getGroupIndex() { return $this->_groupindex; }
        /**
        * Allows speed buttons to work together as a group.
        * When GroupIndex is 0, the button behaves independently of all
        * other buttons on the form. When the user clicks such a speed button,
        * the button appears pressed (in its clicked state) and then returns to
        * its normal up state when the user releases the mouse button.
        * @param integer $value
        */
        function setGroupIndex($value)
        {
                if ($value != $this->_groupindex)
                {
                        $this->_groupindex=$value;
                        $this->updateExclusive();
                }
        }
        function defaultGroupIndex() { return 0; }


}

?>
