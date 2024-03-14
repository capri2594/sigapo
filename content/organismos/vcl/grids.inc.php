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
use_unit("extctrls.inc.php");

/**
 * Column class
 *
 * This class represents a grid column
 */
class Column extends Object
{
        protected $_title;
        public $visible=1;

        //Title property
        function getTitle() { return $this->_title;     }
        function setTitle($value) { $this->_title=$value; }                     
}

/**
 * Row class
 *
 * This class represents a grid row
 */
class Row extends Object
{
        protected $_height;
        public $values;

        //Height property
        function getHeight() { return $this->_height;   }
        function setHeight($value) { $this->_height=$value; }
}

/**
 * CustomGrid class
 *
 * Base class for Grids
 */
class CustomGrid extends CustomControl
{
/*
        public $columns=null;
        public $rows=null;
        protected $_sortable=1;
        protected $_highlightrows=1;
        protected $_showrownumbers=1;

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                //Column list
                $this->columns=new Collection();
                
                //Row list
                $this->rows=new Collection();

                $this->Width=400;
                $this->Height=200;
        }

        function dumpHeaderCode()
        {
                echo "<link type=\"text/css\" rel=\"stylesheet\" href=\"".VCL_HTTP_PATH."/os3grid/os3grid.css\" />\n";
                echo "<script src=\"".VCL_HTTP_PATH."/os3grid/os3grid.js\" type=\"text/javascript\"></script>\n";
        }

        protected $_jsonrowselect=null;
        function getjsOnRowSelect               () { return $this->_jsonrowselect; }
        function setjsOnRowSelect($value)          { $this->_jsonrowselect=$value; }
        function defaultjsOnRowSelect           () { return ""; }

        protected $_jsoncoldisplay=null;
        function getjsOnColDisplay              () { return $this->_jsoncoldisplay; }
        function setjsOnColDisplay($value)          { $this->_jsoncoldisplay=$value; }
        function defaultjsOnColDisplay          () { return ""; }

        function dumpRowSelect($event)
        {
                if ($event!=null)
                {
                        echo "function $event(grid, row, selected)\n";
                        echo "{\n\n";
                        $this->owner->$event($this, array());
                        echo "\n}\n";
                        echo "\n";
                }
        }

        function dumpColDisplay($event)
        {
                if ($event!=null)
                {
                        echo "function $event(grid, col_num, value)\n";
                        echo "{\n\n";
                        $this->owner->$event($this, array());
                        echo "\n}\n";
                        echo "\n";
                }
        }

        function dumpJsEvents()
        {
                parent::dumpJSEvents();
                $this->dumpRowSelect($this->_jsonrowselect);
                $this->dumpColDisplay($this->_jsoncoldisplay);
        }

        function dumpContents()
        {
                $style="";

                $style.="height:".$this->Height."px;width:".$this->Width."px;";

                if ($style!="") $style="style=\"$style\"";



                echo "<div id=\"".$this->Name."_grid\" $style></div>\n";
                echo "<script type=\"text/javascript\">\n";
//                echo "function updatecontrol() {\n";
//                echo "alert('updatecontrol');\n";
                echo "var g = new OS3Grid ();\n";

                $headers="'column1'";
                if ($this->columns->count()>=1)
                {
                        $headers='';
                        $c=0;
                        for ($i=0;$i<=$this->columns->count()-1;$i++)
                        {
                                $column=$this->columns->items[$i];
                                if ($column->visible)
                                {
                                        if ($headers!='') $headers.=',';
                                        $text=$column->Title;
                                        $headers.="'$text'";
                                        //echo "g.set_col_editable ( $c, \"txt\" );\n";
                                        $c++;
                                }
                        }
                }
                echo "g.set_headers ( $headers );\n";
                echo "g.set_scrollbars ( true );\n";
                echo "g.start_counter = 1;\n";

                if ($this->_jsonrowselect!=null)
                {
                        $event=$this->_jsonrowselect;
                        echo "g.onrowselect = $event; \n";
                }

                if ($this->_jsoncoldisplay!=null)
                {
                        $event=$this->_jsoncoldisplay;
                        echo "g.oncoldisplay = $event; \n";
                }

//                echo "g.set_row_select ( true );\n";

                echo "g.set_border ( 1, \"solid\", \"#cccccc\" );\n";
                echo "g.set_sortable(".$this->_sortable.");\n";
//                echo "g.set_highlight(".$this->_highlightrows.");\n";
//                echo "g.show_row_num(".$this->showrownumbers.");\n";

                if ($this->rows->count()>=1)
                {
                for ($k=0;$k<=$this->rows->count()-1;$k++)
                {
                        $row=$this->rows->items[$k];
                        $rowvalues="";
                        for ($i=0;$i<=$this->columns->count()-1;$i++)
                        {
                                $column=$this->columns->items[$i];
                                if ($column->visible)
                                {
                                        if ($rowvalues!="") $rowvalues.=",";
                                        $text=$row->values[$i];
                                        $text=str_replace("\n",'\n',$text);
                                        $text=str_replace("\r",'',$text);
                                        $text=str_replace("'","\\'",$text);
                                        $rowvalues.="'$text'";
                                }
                        }
                        echo "g.add_row ( $rowvalues );\n";
                }
                }
                else
                {
                                // echo "alert('no values');\n";
                        echo "g.add_row ( 'value' );\n";
                }

                echo "g.render ( '".$this->Name."_grid' );\n";
//                echo "}\n";
//                echo "updatecontrol();\n";
                echo "</script>\n";
        }

        //Sortable property
        function getSortable() { return $this->_sortable;   }
        function setSortable($value) { $this->_sortable=$value; }

        //HighLightRows property
        function getHighLightRows() { return $this->_highlightrows;   }
        function setHighLightRows($value) { $this->_highlightrows=$value; }

        //ShowRowNumbers property
        function getShowRowNumbers() { return $this->_showrownumbers;   }
        function setShowRowNumbers($value) { $this->_showrownumbers=$value; }
*/
}


/**
 * Not working yet
 *
 */
 /*
class StringGrid extends ListView
{
}
*/

?>
