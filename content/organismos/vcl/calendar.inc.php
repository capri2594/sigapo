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

class Clock extends FocusControl
{
        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width=200;
                $this->Height=200;
        }

        function dumpHeaderCode()
        {
                if (!defined('DYNAPI'))
                {
                        echo "<script type=\"text/javascript\" src=\"".VCL_HTTP_PATH."/dynapi/src/dynapi.js\"></script>\n";
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
                        echo "dynapi.library.include('HTMLClock');\n";
                        echo "</script>\n";
                        define('DYNAPI_'.strtoupper($this->className()),1);
                }
        }

        function dumpContents()
        {
                $l=0;
                $t=0;

                if (($this->ControlState & csDesigning)!=csDesigning)
                {
                        $l=$this->Left;
                        $t=$this->Top;
                }

                echo "<script type=\"text/javascript\">\n";
                $o="vert";
                if ($this->_kind==sbHorizontal) $o="horz";

                echo "        ".$this->Name."=new HTMLClock()\n";
                echo "        ".$this->Name.".setSize(".$this->width.",".$this->Height.");\n";
                echo "        dynapi.document.addChild(".$this->Name.")\n";
                echo "</script>\n";
                echo "<script type=\"text/javascript\">\n";
                echo "dynapi.document.insertChild(".$this->Name.");\n";
                echo "</script>\n";
        }

}


?>
