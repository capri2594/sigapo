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
use_unit("rtl.inc.php");
use_unit("templateplugins.inc.php");

define('dtNone','(none)');
define('dtXHTML_1_0_Strict'     ,'XHTML 1.0 Strict');
define('dtXHTML_1_0_Transitional' ,'XHTML 1.0 Transitional');
define('dtXHTML_1_0_Frameset'     ,'XHTML 1.0 Frameset');
define('dtHTML_4_01_Strict'       ,'HTML 4.01 Strict');
define('dtHTML_4_01_Transitional' ,'HTML 4.01 Transitional');
define('dtHTML_4_01_Frameset'     ,'HTML 4.01 Frameset');
define('dtXHTML_1_1'              ,'XHTML 1.1');

/**
 * Shutdown function, the right moment to serialize all components
 *
 */
function VCLShutdown()
{
        global $application;

        //This is the moment to store all properties in the session to retrieve them later
        $application->serializeChildren();

        //Uncomment this to get what is stored on the session at the last step of your scripts
        /*
        echo "<pre>";
        print_r($_SESSION);
        echo "<pre>";
        */
}

register_shutdown_function("VCLShutdown");


/**
 * Component class
 *
 * Application class
 */
class Application extends Component
{
        protected $_language;

        function getLanguage() { return $this->_language; }
        function setLanguage($value) { $this->_language=$value; }

        function __construct($aowner=null)
        {
                parent::__construct($aowner);
                session_start();
                if (isset($_GET['restore_session']))
                {
                        $_SESSION = array();
                        session_destroy();
                }

                reset($_GET);
                while (list($k,$v)=each($_GET))
                {
                        if (strpos($k,'.')===false) $_SESSION[$k]=$v;
                }
        }

        function autoDetectLanguage()
        {
                use_unit("language/php_language_detection.php");
                $lang=get_languages('data');
                reset($lang);
                while (list($k,$v)=each($lang))
                {
                        if (array_key_exists(2,$v))
                        {
                                $this->Language=$v[2];
                                break;
                        }
                }
        }


}

global $application;

/**
 * Global $application variable
 */
$application=new Application(null);


/**
 * ScrollingControl class
 *
 * Base class for controls with scrolling area
 */
class ScrollingControl extends FocusControl
{
}

/**
 * CustomPage class
 *
 * Base class for Page component
 */
class CustomPage extends ScrollingControl
{
        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);
                $this->ControlStyle="csAcceptsControls=1";
        }
}

/**
 * DataModule class, basically a non visible holder for direct Component descendants
 *
 */
class DataModule extends CustomPage
{

}

/**
 * Function responsible to dispatch ajax requests to the right events
 *
 * @param string $owner
 * @param string $sender
 * @param mixed $params
 * @param string $event
 * @param array $postvars
 * @return string
 */
        function ajaxProcess($owner, $sender, $params, $event, $postvars)
        {
                global $$owner;

                $_POST=$postvars;

                $$owner->loaded();
                $$owner->loadedChildren();

                $$owner->$event($$owner->$sender, $params);

                $objResponse = new xajaxResponse();


                reset($$owner->controls->items);

                while (list($k,$v)=each($$owner->controls->items))
                {
                        if ($v->methodExists("dumpForAjax"))
                        {
                            ob_start();
                            $v->dumpForAjax();
                            $ccontents=ob_get_contents();
                            ob_end_clean();

                            $ccontents=utf8_encode($ccontents);
                            $objResponse->addScript($ccontents);
                        }
                        else
                        {
                            ob_start();
                            $v->show();
                            $ccontents=ob_get_contents();
                            ob_end_clean();

                            $ccontents=utf8_encode($ccontents);
                            $objResponse->addAssign($v->Name."_outer","innerHTML",$ccontents);
                            $js=extractjscript($ccontents);
                            $js[0]=utf8_encode($js[0]);                            
                            $objResponse->addScript($js[0]);
                        }
                }


                $$owner->serialize();
                $$owner->serializeChildren();

                $response=$objResponse->getXML();

                return $response;
        }


define('rmFrame','frame');
define('rmOpaque','opaque');
define('rmLazyOpaque','lazyopaque');
define('rmTranslucent','translucent');

define('mmFrame','frame');
define('mmOpaque','opaque');
define('mmTranslucent','translucent');

/**
 * Window class
 *
 * A class to encapsulate a window living on the browser
 */
class Window extends QWidget
{
        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);
                $this->ControlStyle="csAcceptsControls=1";
                $this->ControlStyle="csSlowRedraw=1";                
        }

            protected $_modal=0;

            function getModal() { return $this->_modal; }
            function setModal($value) { $this->_modal=$value; }
            function defaultModal() { return 0; }

            protected $_isvisible=true;

            function getIsVisible() { return $this->_isvisible; }
            function setIsVisible($value) { $this->_isvisible=$value; }
            function defaultIsVisible() { return true; }

            function getCaption() { return $this->readCaption(); }
            function setCaption($value) { $this->writeCaption($value); }

            protected $_resizeable=1;

            function getResizeable() { return $this->_resizeable; }
            function setResizeable($value) { $this->_resizeable=$value; }
            function defaultResizeable() { return 1; }

            protected $_moveable=1;

            function getMoveable() { return $this->_moveable; }
            function setMoveable($value) { $this->_moveable=$value; }
            function defaultMoveable() { return 1; }

            protected $_showminimize=1;

            function getShowMinimize() { return $this->_showminimize; }
            function setShowMinimize($value) { $this->_showminimize=$value; }
            function defaultShowMinimize() { return 1; }

            protected $_showmaximize=1;

            function getShowMaximize() { return $this->_showmaximize; }
            function setShowMaximize($value) { $this->_showmaximize=$value; }
            function defaultShowMaximize() { return 1; }

            protected $_showclose=1;

            function getShowClose() { return $this->_showclose; }
            function setShowClose($value) { $this->_showclose=$value; }
            function defaultShowClose() { return 1; }

            protected $_showicon=1;

            function getShowIcon() { return $this->_showicon; }
            function setShowIcon($value) { $this->_showicon=$value; }
            function defaultShowIcon() { return 1; }

            protected $_showcaption=1;

            function getShowCaption() { return $this->_showcaption; }
            function setShowCaption($value) { $this->_showcaption=$value; }
            function defaultShowCaption() { return 1; }

            protected $_movemethod="mmOpaque";

            function getMoveMethod() { return $this->_movemethod; }
            function setMoveMethod($value) { $this->_movemethod=$value; }
            function defaultMoveMethod() { return "mmOpaque"; }

            protected $_resizemethod="rmFrame";

            function getResizeMethod() { return $this->_resizemethod; }
            function setResizeMethod($value) { $this->_resizemethod=$value; }
            function defaultResizeMethod() { return "rmFrame"; }

            protected $_showstatusbar=0;

            function getShowStatusBar() { return $this->_showstatusbar; }
            function setShowStatusBar($value) { $this->_showstatusbar=$value; }
            function defaultShowStatusBar() { return 0; }






        function dumpContents()
        {
                echo "<script type=\"text/javascript\">";
                echo "var d = qx.ui.core.ClientDocument.getInstance();\n";

                echo "  var $this->Name = new qx.ui.window.Window(\"$this->Caption\", \"icon/16/apps/accessories-disk-usage.png\");\n";

                if (($this->ControlState & csDesigning) != csDesigning)
                {
                        echo " $this->Name.setLocation($this->Left, $this->Top);\n";
                        if ($this->Modal) echo "  $this->Name.setModal(true);\n";
                        else echo "  $this->Name.setModal(false);\n";

                        if ($this->Resizeable) echo "  $this->Name.setResizeable(true);\n";
                        else echo "  $this->Name.setResizeable(false);\n";

                        if ($this->Moveable) echo "  $this->Name.setMoveable(true);\n";
                        else echo "  $this->Name.setMoveable(false);\n";

                        echo "  $this->Name.setMoveMethod(\"".constant($this->MoveMethod)."\");\n";
                        echo "  $this->Name.setResizeMethod(\"".constant($this->ResizeMethod)."\");\n";

                }
                else
                {
                        echo " $this->Name.setLocation(0,0);\n";
                }

                        if ($this->ShowClose) echo "  $this->Name.setShowClose(true);\n";
                        else echo "  $this->Name.setShowClose(false);\n";

                        if ($this->ShowMinimize) echo "  $this->Name.setShowMinimize(true);\n";
                        else echo "  $this->Name.setShowMinimize(false);\n";

                        if ($this->ShowMaximize) echo "  $this->Name.setShowMaximize(true);\n";
                        else echo "  $this->Name.setShowMaximize(false);\n";

                        if ($this->ShowIcon) echo "  $this->Name.setShowIcon(true);\n";
                        else echo "  $this->Name.setShowIcon(false);\n";

                        if ($this->ShowCaption) echo "  $this->Name.setShowCaption(true);\n";
                        else echo "  $this->Name.setShowCaption(false);\n";

                        if ($this->ShowStatusBar) echo "  $this->Name.setShowStatusbar(true);\n";
                        else echo "  $this->Name.setShowStatusbar(false);\n";

                echo " $this->Name.setWidth($this->Width);\n";
                echo " $this->Name.setHeight($this->Height);\n";
                $js=$this->dumpChildrenControls(-22,-3);

               echo " d.add($this->Name)\n";

                if (($this->ControlState & csDesigning) != csDesigning)
                {
               if ($this->IsVisible)
               {
                        if (!$this->Modal)
                        {
                                echo " $this->Name.open();\n";
                        }
               }
               }
               else
               {
                                echo " $this->Name.open();\n";
               }
               echo $js;
                echo "</script>";
        }
}

/**
 * Page class
 *
 * A class to encapsulate a web page
 */
class Page extends CustomPage
{
    protected $_showheader=1;
    protected $_showfooter=1;
    protected $_ismaster="0";
    protected $_marginwidth="0";
    protected $_marginheight="0";
    protected $_leftmargin="0";
    protected $_topmargin="0";
    protected $_rightmargin="0";
    protected $_bottommargin="0";
    protected $_useajax=0;
    protected $_dynamic=false;
    protected $_templateengine="";
    protected $_templatefilename="";

    protected $_onbeforeshowheader=null;
    protected $_onstartbody=null;
    protected $_onshowheader=null;
    protected $_onaftershowfooter=null;
    protected $_oncreate=null;

    protected $_isform=true;
    protected $_action="";

    protected $_background="";
    protected $_language="(default)";

    protected $_jsonload=null;
    protected $_jsonunload=null;


        /**
        * The javascript OnLoad event is called after all nested framesets and
        * frames are finished with loading their content.
        * @return mixed
        */
        function getjsOnLoad() { return $this->_jsonload; }
        /**
        * The javascript OnLoad event is called after all nested framesets and
        * frames are finished with loading their content.
        * @param mixed $value
        */
        function setjsOnLoad($value) { $this->_jsonload=$value; }
        function defaultjsOnLoad() { return null; }

        /**
        * The javascript OnUnload event is called after all nested framesets and
        * frames are finished with unloading their content.
        * @return mixed
        */
        function getjsOnUnload() { return $this->_jsonunload; }
        /**
        * The javascript OnUnload event is called after all nested framesets and
        * frames are finished with unloading their content.
        * @param mixed $value
        */
        function setjsOnUnload($value) { $this->_jsonunload=$value; }
        function defaultjsOnUnload() { return null; }


        function getLayout() { return $this->readLayout(); }
        function setLayout($value) { $this->writeLayout($value); }

        protected $_framespacing=0;
        protected $_frameborder=fbNo;
        protected $_borderwidth=0;
        protected $_border="";

        /*
        * Sets or retrieves the amount of additional space between the frames.
        */
        function getFrameSpacing() { return $this->_framespacing;       }
        function setFrameSpacing($value) { $this->_framespacing=$value; }
        function defaultFrameSpacing() { return 0; }

        /*
        * String that specifies or receives one of the following values.
        * fbDefault Inset border is drawn.
        * fbNo       No border is drawn.
        * fbYes     Inset border is drawn.
        */
        function getFrameBorder() { return $this->_frameborder; }
        function setFrameBorder($value) { $this->_frameborder=$value; }
        function defaultFrameBorder() { return fbNo; }

        /*
        * Sets or retrieves the width of the left, right, top, and bottom borders of the object.
        */
        function getBorderWidth() { return $this->_borderwidth; }
        function setBorderWidth($value) { $this->_borderwidth=$value; }
        function defaultBorderWidth() { return 0; }


    protected $_encoding='Western European (ISO)     |iso-8859-1';

    function getEncoding() { return $this->_encoding; }
    function setEncoding($value) { $this->_encoding=$value; }
    function defaultEncoding() { return "Western European (ISO)     |iso-8859-1"; }

    protected $_doctype="dtNone";

    function getDocType() { return $this->_doctype; }
    function setDocType($value) { $this->_doctype=$value; }
    function defaultDocType() { return dtNone; }


    protected $_formencoding="";

    function readFormEncoding() { return $this->_formencoding; }
    function writeFormEncoding($value) { $this->_formencoding=$value; }
    function defaultFormEncoding() { return ""; }



        function getAlignment() { return $this->readAlignment(); }
        function setAlignment($value) { $this->writeAlignment($value); }

        function getColor() { return $this->readColor(); }
        function setColor($value) { $this->writeColor($value); }

        function getShowHint() { return $this->readShowHint(); }
        function setShowHint($value) { $this->writeShowHint($value); }

        function getVisible() { return $this->readVisible(); }
        function setVisible($value) { $this->writeVisible($value); }

        function getCaption() { return $this->readCaption(); }
        function setCaption($value) { $this->writeCaption($value); }

        function getFont() { return $this->readFont(); }
        function setFont($value) { $this->writeFont($value); }

    //Background property
        function getBackground() { return $this->_background; }
        function setBackground($value) { $this->_background=$value; }

    //TemplateEngine property
        function getTemplateEngine() { return $this->_templateengine; }
        function setTemplateEngine($value) { $this->_templateengine=$value; }
        function defaultTemplateEngine() { return ""; }

    //Action property
        function getAction() { return $this->_action; }
        function setAction($value) { $this->_action=$value; }
        function defaultAction() { return ""; }

    //TemplateFilename property
        function getTemplateFilename() { return $this->_templatefilename; }
        function setTemplateFilename($value) { $this->_templatefilename=$value; }
        function defaultTemplateFilename() { return ""; }

    //Ajax property
        function getUseAjax() { return $this->_useajax; }
        function setUseAjax($value) { $this->_useajax=$value; }
        function defaultUseAjax() { return 0; }

        //Language property
        function getLanguage() { return $this->_language; }
        function setLanguage($value)
        {
                if ($value!=$this->_language)
                {
                        $this->_language=$value;
                        if ((($this->ControlState & csDesigning) != csDesigning) && (($this->ControlState & csLoading) != csLoading))
                        {
                                $resourcename=$this->lastresourceread;
                                if ($value=='(default)') $l="";
                                else $l=".".$value;

                                $resourcename=str_replace('.php',$l.'.xml.php',$resourcename);

                                //This is to allow gettext usage
                                if ($value=='(default)') $l='';
                                else $l=$value;

                                putenv ("LANG=$l");
                                $domain="messages";
                                bindtextdomain($domain, "./locale");
                                textdomain($domain);

                                if (file_exists($resourcename))
                                {
                                        $this->readFromResource($resourcename, false, false);
                                }
                        }
                }
        }
        function defaultLanguage() { return "(default)"; }

    //Constructor
    function __construct($aowner=null)
    {
                        //Inherited constructor
                        parent::__construct($aowner);

    }

    function loaded()
    {
        //Once the component has been loaded, calls the oncreate event, if assigned
        $this->callEvent('oncreate',array());
    }

    protected $_jsonsubmit=null;

    function getjsOnSubmit() { return $this->_jsonsubmit; }
    function setjsOnSubmit($value) { $this->_jsonsubmit=$value; }
    function defaultjsOnSubmit() { return null; }

    protected $_jsonreset=null;

    function getjsOnReset() { return $this->_jsonreset; }
    function setjsOnReset($value) { $this->_jsonreset=$value; }
    function defaultjsOnReset() { return null; }

        function dumpJsEvents()
        {
                parent::dumpJsEvents();

                $this->dumpJSEvent($this->_jsonsubmit);
                $this->dumpJSEvent($this->_jsonreset);
                $this->dumpJSEvent($this->_jsonload);
                $this->dumpJSEvent($this->_jsonunload);
        }

    function readStartForm()
    {
        $result="";
        if (($this->_isform) && ($this->_showheader))
        {
                $action="";
                if (isset($_SERVER['PHP_SELF'])) $action=$_SERVER['PHP_SELF'];

                   if ($this->_action!='') $action=$this->_action;

                   $formevents='';

                   if ($this->_jsonsubmit!="")
                   {
                        $formevents.=" onsubmit=\"return $this->_jsonsubmit();\" ";
                   }

                   if ($this->_jsonreset!="")
                   {
                        $formevents.=" onreset=\"return $this->_jsonreset();\" ";
                   }

                   $enctype = "";
                   if ($this->_formencoding != "")
                   {
                        $enctype = " enctype=\"$this->_formencoding\"";
                   }

               $result='<form style="margin-bottom: 0" id="'.$this->name.'" name="'.$this->name.'" method="post" '.$formevents.' action="'.$action.'"'.$enctype.'>';
        }
        return($result);
    }

    function readEndForm()
    {
        return("</form>");
    }

/**
 * Dump the page using a template, it doesn't generate an HTML page
 *
 */
    function dumpUsingTemplate()
    {
        //Check here for templateengine and templatefilename
        if (($this->ControlState & csDesigning) != csDesigning)
        {
                $tclassname=$this->_templateengine;

                $template=new $tclassname($this);
                $template->FileName=$this->_templatefilename;
                $template->initialize();
                $this->callEvent("ontemplate",array("template"=>$template));
                $template->assignComponents();
                $template->dumpTemplate();
        }
    }

    protected $_ontemplate=null;

    function getOnTemplate() { return $this->_ontemplate; }
    function setOnTemplate($value) { $this->_ontemplate=$value; }
    function defaultOnTemplate() { return ""; }



    public $hasframes=false;

    function dumpHeaderJavascript($return_contents=false)
    {
        global $output_enabled;

        if ($output_enabled)
        {
                ob_start();
                $this->dumpChildrenJavascript();
                $js=ob_get_contents();
                ob_end_clean();
                $sp='';
                if (trim($js)!="")
                {
                        $sp="<script type=\"text/javascript\">\n";
                        $sp.="<!--\n";
                        $sp.=$js;
                        $sp.="-->\n";
                        $sp.="</script>\n";
                }

                if ($return_contents)
                {
                    return($sp);
                }
                else echo $sp;
        }
    }

    function dumpContents()
    {
        //TODO: XHTML support
        //TODO: Isolate all elements of a page into properties
        //Calls beforeshowheader event, if any
        $this->callEvent('onshow',array());

        if ($this->_templateengine!="")
        {
                $this->dumpUsingTemplate();
                return;
        }

        if ($this->_ismaster) return;


        if ($this->_useajax)
        {
                if (($this->ControlState & csDesigning) != csDesigning)
                {
                use_unit("xajax/xajax.inc.php");
                //AJAX support
                global $xajax;

                // Instantiate the xajax object.  No parameters defaults requestURI to this page, method to POST, and debug to off
                $xajax = new xajax();

                // $xajax->debugOn(); // Uncomment this line to turn debugging on

                // Specify the PHP functions to wrap. The JavaScript wrappers will be named xajax_functionname
                $xajax->registerFunction("ajaxProcess");

                // Process any requests.  Because our requestURI is the same as our html page,
                // this must be called before any headers or HTML output have been sent
                $xajax->processRequests();
                //AJAX support
                }
        }

        $dtd="";
        $extra="";

        switch (constant($this->_doctype))
        {
            case dtNone: $dtd=""; $extra=""; break;

            case dtXHTML_1_0_Strict: $dtd='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'; $extra='xmlns="http://www.w3.org/1999/xhtml"'; break;
            case dtXHTML_1_0_Transitional: $dtd='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'; $extra='xmlns="http://www.w3.org/1999/xhtml"'; break;
            case dtXHTML_1_0_Frameset: $dtd='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">'; $extra='xmlns="http://www.w3.org/1999/xhtml"'; break;

            case dtHTML_4_01_Strict: $dtd='<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">'; break;
            case dtHTML_4_01_Transitional: $dtd='<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">'; break;
            case dtHTML_4_01_Frameset: $dtd='<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">'; break;

            case dtXHTML_1_1: $dtd='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">'; $extra='xmlns="http://www.w3.org/1999/xhtml"'; break;

        }


        $this->hasframes=false;

        //Iterates through controls to get the frames
        reset($this->controls->items);
        while (list($k,$v)=each($this->controls->items))
        {
                if (($v->inheritsFrom('Frame')) || ($v->inheritsFrom('Frameset')))
                {
                        $this->hasframes=true;
                }
        }

        //Calls beforeshowheader event, if any
        $this->callEvent('onbeforeshowheader',array());

        echo "<!-- $this->name begin -->\n";
        //If must dump the header
        if ($this->_showheader)
        {
                echo "$dtd\n";
                echo "<html $extra>\n";
                echo "<head>\n";

                echo "<script type=\"text/javascript\" src=\"".VCL_HTTP_PATH."/js/common.js\"></script>\n";


                $this->callEvent('onshowheader',array());

                if ($this->_useajax)
                {
                if (($this->ControlState & csDesigning) != csDesigning)
                {
                        global $xajax;

                        $xajax->printJavascript("",VCL_HTTP_PATH."/xajax/xajax_js/xajax.js");
                }
                }

                $title=$this->Caption;
                echo "<title>$title</title>\n";

                $cs=explode('|',$this->_encoding);
                echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=$cs[1]\" ";
                if (($this->DocType!='dtHTML_4_01_Strict') && ($this->DocType!='dtHTML_4_01_Transitional'))
                {
                    echo "/";
                }
                echo ">\n";

                $this->dumpHeaderJavascript();

                $this->dumpChildrenHeaderCode();

                echo "</head>\n";
                echo "\n";

                $attr="";

                $st="";


                if ($this->_leftmargin!="") $st.=" margin-left: ".$this->_leftmargin."px; ";
                if ($this->_topmargin!="") $st.=" margin-top: ".$this->_topmargin."px; ";
                if ($this->_rightmargin!="") $st.=" margin-right: ".$this->_rightmargin."px; ";
                if ($this->_bottommargin!="") $st.=" margin-bottom: ".$this->_bottommargin."px; ";

                if ($st!="") $st=" style=\"$st\" ";

                if ($this->color!="") $attr.=" bgcolor=\"$this->color\" ";
                if ($this->Background!="") $attr.=" background=\"$this->Background\" ";

                // add the defined JS events to the body
                if ($this->_jsonload!=null) $attr.=" onload=\"return $this->_jsonload(event)\" ";
                if ($this->_jsonunload!=null) $attr.=" onunload=\"return $this->_jsonunload(event)\" ";

            if (!$this->hasframes)
            {
                        echo "<body $st $attr>\n";
            }
        }
        else
        {
                echo "<script type=\"text/JavaScript\">\n";
                echo "<!--\n";
                $this->dumpChildrenJavascript();
                echo "-->\n";
                echo "</script>\n";

                        $this->dumpChildrenHeaderCode();
        }


        if (!$this->hasframes) echo $this->readStartForm();

        $this->callEvent('onstartbody',array());


        //Dump children controls
        if (!$this->hasframes) $this->dumpChildren();
        else $this->dumpFrames();

        if (($this->_isform) && ($this->_showfooter))
        {
               if (!$this->hasframes) echo $this->readEndForm();
        }

        $this->callEvent('onaftershowfooter',array());

        //If must dump the footer
        if (!$this->hasframes)
        {
                if ($this->_showfooter)
                {
                        echo "</body>\n";
                        echo "</html>\n";
                }
        }

        if ($this->hasframes)
        {
                echo "<noframes><body>\n";
                echo $this->readStartForm();
                //Dump children controls
                $this->dumpChildren();
                echo $this->readEndForm();
                echo "</body></noframes>\n";
        }

        echo "<!-- $this->name end -->\n";

    }

    /**
     * Dump al children controls
     *
     */
    function dumpChildren()
    {
        $width="";
        $height="";
        $color="";

        $alignment="";

        // fixup to allow initialization of visual stuff in case
        // if non-visual Q lib classes are used

        if (defined('QOOXDOO'))
        {
                echo "\n"
                   . "<script type=\"text/javascript\">\n"
                   . "    var d = qx.ui.core.ClientDocument.getInstance();\n"
                   . "    d.setOverflow(\"scrollY\");\n"
                   . "    d.setBackgroundColor(null);\n"
                   . "</script>\n";
        }

        switch ($this->_alignment)
        {
                case agNone: $alignment=""; break;
                case agLeft: $alignment=" align=\"Left\" "; break;
                case agCenter: $alignment=" align=\"Center\" "; break;
                case agRight: $alignment=" align=\"Right\" "; break;
        }

        if ($this->Color!="") $color=" bgcolor=\"$this->Color\" ";
        if ($this->Background!="") $background=" background=\"$this->Background\" ";
        if ($this->Width!="") $width=" width=\"$this->Width\" ";
        if ($this->Height!="") $height=" style=\"height:".$this->Height."px\" ";

        if (($this->ControlState & csDesigning) != csDesigning)
        {
            if (($this->Layout->Type==GRIDBAG_LAYOUT) || ($this->Layout->Type==ROW_LAYOUT) || ($this->Layout->Type==COL_LAYOUT))
            {
                $width=" width=\"100%\" ";
//                $height="";
            }
        }

        echo "\n<table $width $height border=\"0\" cellpadding=\"0\" cellspacing=\"0\" $color $alignment><tr><td valign=\"top\">\n";

        if (($this->ControlState & csDesigning) != csDesigning)
        {
                $this->Layout->dumpLayoutContents(array('Frame', 'Frameset'));
        }

        echo "</td></tr></table>\n";

        reset($this->controls->items);
        while (list($k,$v)=each($this->controls->items))
        {
                if (($v->Visible) && ($v->IsLayer))
                {
                        $v->show();
                }
        }

    }

    function dumpFrames()
    {
          $frameset=new Frameset(null);
          $frameset->Align=alClient;
          $frameset->FrameSpacing=$this->FrameSpacing;
          $frameset->FrameBorder=$this->FrameBorder;
          $frameset->BorderWidth=$this->BorderWidth;
          $frameset->controls=$this->controls;
          $frameset->show();
    }

    //TopMargin property
    function getTopMargin() { return $this->_topmargin; }
    function setTopMargin($value) { $this->_topmargin=$value; }
    function defaultTopMargin() { return 0; }

    //LeftMargin property
    function getLeftMargin() { return $this->_leftmargin; }
    function setLeftMargin($value) { $this->_leftmargin=$value; }
    function defaultLeftMargin() { return 0; }

    //BottomMargin property
    function getBottomMargin() { return $this->_bottommargin; }
    function setBottomMargin($value) { $this->_bottommargin=$value; }
    function defaultBottomMargin() { return 0; }

    //RightMargin property
    function getRightMargin() { return $this->_rightmargin; }
    function setRightMargin($value) { $this->_rightmargin=$value; }
    function defaultRightMargin() { return 0; }

    //ShowHeader property
    function getShowHeader() { return $this->_showheader; }
    function setShowHeader($value) { $this->_showheader=$value; }
    function defaultShowHeader() { return 1; }

    //IsForm property
    function getIsForm() { return $this->_isform; }
    function setIsForm($value) { $this->_isform=$value; }
    function defaultIsForm() { return 1; }

    //IsMaster property
    function getIsMaster() { return $this->_ismaster; }
    function setIsMaster($value) { $this->_ismaster=$value; }

    //ShowFooter property
    function getShowFooter() { return $this->_showfooter; }
    function setShowFooter($value) { $this->_showfooter=$value; }
    function defaultShowFooter() { return 1; }

    //OnBeforeShowHeader event
    function getOnBeforeShowHeader() { return $this->_onbeforeshowheader; }
    function setOnBeforeShowHeader($value) { $this->_onbeforeshowheader=$value; }
    function defaultOnBeforeShowHeader() { return ""; }

    //OnAfterShowFooter event
    function getOnAfterShowFooter() { return $this->_onaftershowfooter; }
    function setOnAfterShowFooter($value) { $this->_onaftershowfooter=$value; }
    function defaultOnAfterShowFooter() { return ""; }

    //OnShowHeader event
    function getOnShowHeader() { return $this->_onshowheader; }
    function setOnShowHeader($value) { $this->_onshowheader=$value; }
    function defaultOnShowHeader() { return ""; }

    //OnStartBody event
    function getOnStartBody() { return $this->_onstartbody; }
    function setOnStartBody($value) { $this->_onstartbody=$value; }
    function defaultOnStartBody() { return ""; }

    //OnCreate event
    function getOnCreate() { return $this->_oncreate; }
    function setOnCreate($value) { $this->_oncreate=$value; }
    function defaultOnCreate() { return ""; }

}

/**
 * HiddenField
 *
 * A component to generate an html hidden field, useful to send information
 * to another script, set the value for it on the Value property.
 * The component is only visible at design time.
 */
class HiddenField extends Control
{
        protected $_onsubmit = null;

        protected $_value = "";

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width=200;
                $this->Height=18;
        }

        function preinit()
        {
                parent::preinit();
                
                //If there is something posted
                $submitted = $this->input->{$this->Name};
                if (is_object($submitted))
                {
                        //Set the value
                        $this->_value = $submitted->asString();
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
        }

        function dumpContents()
        {
                if (($this->ControlState & csDesigning) != csDesigning)
                {
                        if ($this->_onshow != null)
                        {
                                $this->callEvent('onshow', array());
                        }
                        else
                        {
                                echo "<input type=\"hidden\" id=\"$this->Name\" name=\"$this->Name\" value=\"$this->Value\" />";
                        }
                }
                else
                {
                        echo "<table width=\"$this->width\" cellpadding=\"0\" cellspacing=\"0\" height=\"$this->height\"><tr><td style=\"background-color: #FFFF99; border: 1px solid #666666; font-size:10px; font-family:verdana,tahoma,arial\" align=\"center\">$this->Name=$this->Value</td></tr></table>";
                }
        }

        /*
        * Publish the events for the component
        */

        /**
        * Occurs when the form containing the control was submitted.
        * @return mixed Returns the event handler or null if no handler is set.
        */
        function getOnSubmit() { return $this->_onsubmit; }
        /**
        * Occurs when the form containing the control was submitted.
        * @param mixed Event handler or null if no handler is set.
        */
        function setOnSubmit($value) { $this->_onsubmit=$value; }
        function defaultOnSubmit() { return null; }


        /*
        * Publish the JS events for the component
        */

        function getjsOnChange                  () { return $this->readjsOnChange(); }
        function setjsOnChange                  ($value) { $this->writejsOnChange($value); }


        /*
        * Publish the properties for the component
        */

        /*
        * Specified the value for the HTML hidden field, and you will be able to
        * read this value on the script that receives the information.
        * @return string
        */
        function getValue() { return $this->_value; }
        /*
        * Specified the value for the HTML hidden field, and you will be able to
        * read this value on the script that receives the information.
        * @param string $value
        */
        function setValue($value) { $this->_value=$value; }
        function defaultValue() { return ""; }
}


define('fbNo','fbNo');
define('fbYes','fbYes');
define('fbDefault','fbDefault');

/**
 * Frameset class
 *
 * A class to encapsulate a frame set and generate frames
 * This class is also used in the Page component to generate a frameset.
 *
 * For further information about HTML framesets and frames please visit following link:
 * @link http://www.w3.org/TR/html401/present/frames.html
 */
class Frameset extends ScrollingControl
{
        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);
                $this->ControlStyle="csAcceptsControls=1";
        }

        protected $_align=alClient;
        protected $_borderwidth=0;
        protected $_border="";
        protected $_framespacing=0;
        protected $_frameborder=fbNo;

        protected $_jsonload=null;
        protected $_jsonunload=null;


        /**
        * The javascript OnLoad event is called after all nested framesets and
        * frames are finished with loading their content.
        * @return mixed
        */
        function getjsOnLoad() { return $this->_jsonload; }
        /**
        * The javascript OnLoad event is called after all nested framesets and
        * frames are finished with loading their content.
        * @param mixed $value
        */
        function setjsOnLoad($value) { $this->_jsonload=$value; }
        function defaultjsOnLoad() { return null; }

        /**
        * The javascript OnUnload event is called after all nested framesets and
        * frames are finished with unloading their content.
        * @return mixed
        */
        function getjsOnUnload() { return $this->_jsonunload; }
        /**
        * The javascript OnUnload event is called after all nested framesets and
        * frames are finished with unloading their content.
        * @param mixed $value
        */
        function setjsOnUnload($value) { $this->_jsonunload=$value; }
        function defaultjsOnUnload() { return null; }


        function getAlign() { return $this->_align; }
        function setAlign($value) { $this->_align=$value; }
        function defaultAlign() { return alClient; }

        /**
        * Sets or retrieves the amount of additional space between the frames.
        * @return integer
        */
        function getFrameSpacing() { return $this->_framespacing;       }
        /**
        * Sets or retrieves the amount of additional space between the frames.
        * @param integer $value
        */
        function setFrameSpacing($value) { $this->_framespacing=$value; }
        function defaultFrameSpacing() { return 0; }

        /**
        * String that specifies or receives one of the following values.
        * fbDefault Inset border is drawn.
        * fbNo       No border is drawn.
        * fbYes     Inset border is drawn.
        */
        function getFrameBorder() { return $this->_frameborder; }
        /**
        * String that specifies or receives one of the following values.
        * fbDefault Inset border is drawn.
        * fbNo       No border is drawn.
        * fbYes     Inset border is drawn.
        */
        function setFrameBorder($value) { $this->_frameborder=$value; }
        function defaultFrameBorder() { return fbNo; }

        /**
        * Width of the left, right, top, and bottom borders of the object.
        * @return integer
        */
        function getBorderWidth() { return $this->_borderwidth; }
        /**
        * Width of the left, right, top, and bottom borders of the object.
        * @param integer $value
        */
        function setBorderWidth($value) { $this->_borderwidth=$value; }
        function defaultBorderWidth() { return 0; }


    /**
    * Returns the defined JS events for the frameset.
    * @return string If empty no JS events are set.
    */
    function readFramesetJSEvents()
    {
        $result = "";

        if ($this->_jsonload!=null)  { $event=$this->_jsonload;  $result.=" onload=\"return $event(event)\" "; }
        if ($this->_jsonunload!=null)  { $event=$this->_jsonunload;  $result.=" onunload=\"return $event(event)\" "; }

        return $result;
    }

    function dumpJavascript()
    {
        parent::dumpJavascript();

        $this->dumpJSEvent($this->_jsonload);
        $this->dumpJSEvent($this->_jsonunload);
    }

    /**
    * Dump the frames inside the frameset that are aligned to alClient
    */
    function dumpClientFrames()
    {
        $fakeframe=true;
        reset($this->controls->items);
        while (list($k,$v)=each($this->controls->items))
        {
                if (($v->inheritsFrom('Frame')) || ($v->inheritsFrom('Frameset')))
                {
                        if ($v->Align==alClient)
                        {
                                $v->show();
                                $fakeframe=false;
                        }
                }
        }

        if ($fakeframe)
        {
                echo "<frame />";
        }
    }

    /**
    * Dump the frames inside the frameset that are aligned to alLeft or alRight
    */
    function dumpHorizontalFrames($hframes, $outputevents)
    {
                if (count($hframes)!=0)
                {
                        reset($hframes);
                        $leftwidths="";
                        $rightwidths="";
                        while(list($key, $val)=each($hframes))
                        {
                          if ($val->Align==alLeft) $leftwidths.=$val->Width.",";
                          if ($val->Align==alRight) $rightwidths.=",".$val->Width;
                        }

                        // only output events when they have an affect
                        // (only the most outer frameset will receive the onload event)
                        $events = ($outputevents) ? $this->readFramesetJSEvents() : "";

                        $frameborder = "";  // fbDefault
                        switch ($this->FrameBorder)
                        {
                                case fbNo: $frameborder = "no"; break;
                                case fbYes: $frameborder = "yes"; break;
                        }

                        echo "<frameset cols=\"$leftwidths*$rightwidths\" rows=\"*\" frameborder=\"$frameborder\" border=\"$this->BorderWidth\" framespacing=\"$this->FrameSpacing\" $events>\n";
                        reset($hframes);
                        while(list($key, $val)=each($hframes))
                        {
                          if ($val->Align==alLeft) $val->show();
                        }
                        //Dump here the alClient frames
                        $this->dumpClientFrames();

                        reset($hframes);
                        while(list($key, $val)=each($hframes))
                        {
                          if ($val->Align==alRight) $val->show();
                        }
                        echo "</frameset>\n";
                }
                else
                {
                        $this->dumpClientFrames();
                }
    }

    /**
    * Dump the whole frameset, with the alignment algorithm
    */
    function dumpContents()
    {
                if (($this->ControlState & csDesigning)==csDesigning)
                {
                        $msg=$this->Name;
                        $msg="$this->Name<br>place Frames inside this Frameset";

                        $bstyle=" style=\"border: 1px dotted #000000;font-size:10px; font-family:verdana,tahoma,arial\" ";
                        echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"$this->width\" height=\"$this->height\"><tr><td $bstyle align=\"center\">$msg</td></tr></table>";
                }
                else
                {
        reset($this->controls->items);
        $vframes=array();
        $hframes=array();
        while (list($k,$v)=each($this->controls->items))
        {
                if (($v->inheritsFrom('Frame')) || ($v->inheritsFrom('Frameset')))
                {
                        if (($v->Align==alTop) || ($v->Align==alBottom))
                        {
                                $vframes[$v->Top]=$v;
                        }
                        if (($v->Align==alLeft) || ($v->Align==alRight))
                        {
                                $hframes[$v->Left]=$v;
                        }
                }
        }

        ksort($vframes,SORT_NUMERIC);
        ksort($hframes,SORT_NUMERIC);

        //Dump rows
        if (count($vframes)!=0)
        {
                reset($vframes);
                $topheights="";
                $bottomheights="";
                while(list($key, $val)=each($vframes))
                {
                  if ($val->Align==alTop) $topheights.=$val->Height.",";
                  if ($val->Align==alBottom) $bottomheights.=",".$val->Height;
                }

                $events = $this->readFramesetJSEvents();

                echo "<frameset rows=\"$topheights*$bottomheights\" cols=\"*\" frameborder=\"$this->FrameBorder\" border=\"$this->BorderWidth\" framespacing=\"$this->FrameSpacing\" $events>\n";
                reset($vframes);
                while(list($key, $val)=each($vframes))
                {
                  if ($val->Align==alTop) $val->show();
                }
                //Dump here the horizontal frameset
                //**********************************
                $this->dumpHorizontalFrames($hframes, false);
                //**********************************
                reset($vframes);
                while(list($key, $val)=each($vframes))
                {
                  if ($val->Align==alBottom) $val->show();
                }
                echo "</frameset>\n";
        }
        else
        {
                $this->dumpHorizontalFrames($hframes, true);
        }
        }

    }

}

define('fsAuto','fsAuto');
define('fsYes','fsYes');
define('fsNo','fsNo');
/**
 * Frame control
 *
 * A frame is a sub-component of a Frameset. It should only be used within a
 * Frameset control.
 * For further information about HTML frames please visit following link:
 * @link http://www.w3.org/TR/html401/present/frames.html
 */
class Frame extends ScrollingControl
{
        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);
                $this->ControlStyle="csAcceptsControls=1";
        }

        protected $_source="";

        /**
        * Defines the URL of the file to show in the frame.
        * @return string
        */
        function getSource() { return $this->_source; }
        /**
        * Defines the URL of the file to show in the frame.
        * @param string $value
        */
        function setSource($value) { $this->_source=$value; }
        function defaultSource() { return ""; }

        protected $_borders=1;

        /**
        * Specifies whether or not to display border around the frame. This
        * value should be 0 or 1.
        * @return integer
        */
        function getBorders() { return $this->_borders; }
        /**
        * Specifies whether or not to display border around the frame. This
        * value should be 0 or 1.
        * @param integer $value
        */
        function setBorders($value) { $this->_borders=$value; }
        function defaultBorders() { return 1; }

        protected $_align=alLeft;

        function getAlign() { return $this->_align; }
        function setAlign($value) { $this->_align=$value; }
        function defaultAlign() { return alLeft; }

        protected $_marginwidth=0;

       /**
       * Defines the left and right margins in the frame.
       * @return integer
       */
        function getMarginWidth() { return $this->_marginwidth; }
        /**
       * Defines the left and right margins in the frame.
       * @param integer $value
       */
        function setMarginWidth($value) { $this->_marginwidth=$value; }
        function defaultMarginWidth() { return 0; }

        protected $_marginheight=0;

        /**
        * Defines the top and bottom margins in the frame.
        * @return integer
        */
        function getMarginHeight() { return $this->_marginheight; }
        /**
        * Defines the top and bottom margins in the frame.
        * @param integer $value
        */
        function setMarginHeight($value) { $this->_marginheight=$value; }
        function defaultMarginHeight() { return 0; }

        protected $_resizeable=1;

        /**
        * When set to false the user cannot resize the frame.
        * @return bool
        */
        function getResizeable() { return $this->_resizeable; }
        /**
        * When set to false the user cannot resize the frame.
        * @param bool $value
        */
        function setResizeable($value) { $this->_resizeable=$value; }
        function defaultResizeable() { return 1; }

        protected $_scrolling=fsAuto;

        /**
        * Determines scrollbar action.
        * @retun enum (fsAuot, fsYes, fsNo)
        */
        function getScrolling() { return $this->_scrolling; }
        /**
        * Determines scrollbar action.
        * @param enum (fsAuot, fsYes, fsNo)
        */
        function setScrolling($value) { $this->_scrolling=$value; }
        function defaultScrolling() { return fsAuto; }


        protected $_jsonload=null;

        /**
        * The javascript OnLoad event is called after all nested framesets and
        * frames are finished with loading their content.
        * @return mixed
        */
        function getjsOnLoad() { return $this->_jsonload; }
        /**
        * The javascript OnLoad event is called after all nested framesets and
        * frames are finished with loading their content.
        * @param mixed $value
        */
        function setjsOnLoad($value) { $this->_jsonload=$value; }
        function defaultjsOnLoad() { return null; }

        /**
        * Returns the defined JS events for the frame.
        * @return string If empty no JS events are set.
        */
        function readFrameJSEvents()
        {
            $result = "";

            if ($this->_jsonload!=null)  { $event=$this->_jsonload;  $result.=" onload=\"return $event(event)\" "; }

            return $result;
        }

        function dumpJavascript()
        {
            parent::dumpJavascript();

            $this->dumpJSEvent($this->_jsonload);
        }

        function dumpContents()
        {
                if (($this->ControlState & csDesigning)==csDesigning)
                {
                        $msg=$this->Name;
                        if (trim($this->Source)=='')
                        {
                                $msg="Fill Source property with the URL you want to show on this Frame";
                        }

                        $bstyle=" style=\"border: 1px dotted #000000;font-size:10px; font-family:verdana,tahoma,arial\" ";
                        echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"$this->width\" height=\"$this->height\"><tr><td $bstyle align=\"center\">$msg</td></tr></table>";
                }
                else
                {
                        $resizeable="";

                        if ($this->Resizeable!=1)
                        {
                                $resizeable="noresize";
                        }

                        if (($this->ControlState & csDesigning)==csDesigning)
                        {
                                echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Frameset//EN\" \"http://www.w3.org/TR/html4/frameset.dtd\">\n";
                                echo "<HTML>\n";
                                echo "<HEAD>\n";
                                echo "</HEAD>\n";
                                echo "<FRAMESET cols=\"$this->Width\">\n";
                        }

                        $scrolling = "auto";    //fsAuto
                        switch ($this->Scrolling)
                        {
                                case fsYes: $scrolling = "yes"; break;
                                case fsNo: $scrolling = "no"; break;
                        }

                        $events = $this->readFrameJSEvents();

                        echo "<frame src=\"".$this->Source."\" name=\"".$this->name."\" scrolling=\"$scrolling\" $resizeable marginwidth=\"$this->MarginWidth\" marginheight=\"$this->MarginHeight\" frameborder=\"$this->Borders\" $events>\n";

                        if (($this->ControlState & csDesigning)==csDesigning)
                        {
                                echo "</FRAMESET>\n";
                                echo "</HTML>\n";
                        }
                }

        }
}



?>
