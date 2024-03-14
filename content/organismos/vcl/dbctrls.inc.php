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

use_unit("db.inc.php");
use_unit("extctrls.inc.php");



define ('noHorizontal', 'noHorizontal');
define ('noVertical', 'noVertical');

/**
 * DBPaginator class
 *
 * A control to browse through the records of a datasource.
 */
class DBPaginator extends CustomControl
{
        protected $_datasource = null;

        protected $_onclick = null;

        protected $_captionfirst = "First";
        protected $_captionprevious = "Prev";
        protected $_captionlast = "Last";
        protected $_captionnext = "Next";
        protected $_orientation = noHorizontal;
        protected $_pagenumberformat="%d";
        protected $_showfirst = 1;
        protected $_showlast = 1;
        protected $_shownext = 1;
        protected $_showprevious = 1;
        protected $_shownrecordscount=10;

        private $_currentpos = -1;

        function __construct($aowner = null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width = 300;
                $this->Height = 30;

                $this->ControlStyle="csRenderOwner=1";
                $this->ControlStyle="csRenderAlso=StyleSheet";
        }

        function serialize()
        {
                parent::serialize();

                $owner = $this->readOwner();
                if ($owner != null)
                {
                        $prefix = $owner->readNamePath().".".$this->_name.".";
                        $_SESSION[$prefix."CurrentPos"] = $this->_currentpos;
                }
        }

        function unserialize()
        {
                parent::unserialize();

                $owner = $this->readOwner();
                if ($owner != null)
                {
                        $prefix = $owner->readNamePath().".".$this->_name.".";
                        $this->_currentpos = $_SESSION[$prefix."CurrentPos"];
                }
        }

        function loaded()
        {
                parent::loaded();
                $this->setDataSource($this->_datasource);
        }

        //TODO: can we move that to loaded()? Is the data source ready there?
        function preinit()
        {
                parent::preinit();

                // go to last position
                if ($this->_currentpos > 0)
                {
                        $this->gotoPos($this->_currentpos);
                        /*
                        $ds = $this->_datasource->DataSet;
                        for ($x = 0; $x < $this->_currentpos; $x++)
                        {
                                $ds->next();
                        }
                        */
                }

                $submittedValue = $this->input->{$this->_name};

                if (is_object($submittedValue) && $this->_datasource != null && $this->_datasource->DataSet != null)
                {
                        $value = $submittedValue->asString();
                        $this->linkClicked($value);
                }
        }

        private function gotoPos($pos)
        {
                if ($pos >= 0 /*&& $this->_datasource->Dataset->Active*/)
                {
                        $ds = $this->_datasource->DataSet;
                        $ds->First();
                        for ($x = 0; $x < $pos; $x++)
                        {
                                $ds->Next();
                        }
                }
        }

        /**
        * Execute the $action of a clicked link.
        * @param mixed $action This param defines which action should be performed.
        *                      If $action is a string then the matching operation
        *                      on the data set is performed. Currently
        *                      first, prev, next and last are supported.
        *                      If $action is a integer the data set cursor is moved
        *                      to this record.
        */
        protected function linkClicked($action)
        {
                $ds = $this->_datasource->DataSet;

                $val = "";
                // check which link was clicked
                switch ($action)
                {
                        // first
                        case "first": $ds->First(); $val = $action; $this->_currentpos = 0; break;
                        // prev
                        case "prev": /*$ds->Prior();*/ $val = $action; $this->_currentpos--; $this->gotoPos($this->_currentpos); break;
                        // next
                        case "next": $ds->Next(); $val = $action; if($this->_currentpos < $ds->RecordCount-1) $this->_currentpos++; break;
                        // last
                        case "last": $ds->Last(); $val = $action; $this->_currentpos = $ds->RecordCount-1; break;
                        default:
                        {
                                // check if it is a integer
                                if (is_numeric($action) && intval($action) == $action)
                                {
                                        $val = $action-1;
                                        $diff = $val - $this->_currentpos;

                                        if ($diff < 0)
                                        {
                                                $this->gotoPos($val);
                                        }
                                        else
                                        {
                                                for ($x = 0; $x < abs($diff); $x++)
                                                {
                                                        $ds->Next();
                                                }
                                        }

                                        // move to the clicked record number
                                        //$ds->MoveBy($val - $this->_currentpos);
                                        $this->_currentpos = $val;
                                }
                        }
                }

                $this->callEvent('onclick', array("action", $val));
        }

        /**
        * Simulates a link click on the database navigator, invoking the action of the link.
        * @param mixed $action This param defines which action should be performed.
        *                      If $action is a string then the matching operation
        *                      on the data set is performed. Currently
        *                      first, prev, next and last are supported.
        *                      If $action is a integer the data set cursor is moved
        *                      to this record.
        */
        public function linkClick($action)
        {
                $this->linkClicked($action);
        }

        /**
        * Returns an array with all record numbers to display.
        * Each record number has following properties:
        * - recordnumber => record number to display
        * - currentrecord => true if current record
        * - first => true if first
        * - last => true if last
        *
        * The returned array looks like this:
        * Array
        * (
        *     [1] => Array
        *         (
        *              [recordnumber] =>
        *              [currentrecord] =>
        *              [first] =>
        *              [last] =>
        *         )
        *     [2] => Array
        *         ( ...
        * @return array Returns an array with all record numbers to display.
        */
        protected function getArrayOfRecordNumbers()
        {
                $result = array();

                if (($this->ControlState & csDesigning) != csDesigning)
                {
                        // check if DS is set and active
                        //TODO: Check if DS is active
                        if ($this->_datasource!=null && $this->_datasource->Dataset!=null && $this->_datasource->Dataset->Active)
                        {
                                $ds = $this->_datasource->DataSet;
                                $currentRecord = $this->_currentpos; //$ds->RecNo;
                                $recordCount = $ds->RecordCount;

                                // we want to have the current record number in the center (if possible)
                                $centeroffset = round($this->_shownrecordscount/2);

                                // Calculate the range to show (0 = first; $recordCount-1 = last).
                                // The first few records (till $centeroffset) are treated differently ($end is $this->_shownrecordscount-1).
                                if ($currentRecord < $centeroffset)
                                {
                                        // check if record count is lower than $this->_shownrecordscount
                                        // if yes, then $end is $recordCount-1, otherwise $this->_shownrecordscount-1
                                        $end = min($recordCount, $this->_shownrecordscount)-1;
                                }
                                else
                                {
                                        // $end is either $recordCount-1 or the current record plus the offset ($centeroffset floored is case _shownrecordscount is odd)
                                        $end = min($recordCount-1, $currentRecord + floor($this->_shownrecordscount/2));
                                }
                                // go no lower than 0 (first) and always show as many numbers as possible
                                $start = max(0,
                                             $currentRecord - max($centeroffset - 1,
                                                                  $this->_shownrecordscount - ($end - $currentRecord) - 1
                                                                 )
                                            );

                                // add the record numbers to the result array
                                for ($x = $start; $x <= $end; $x++)
                                {
                                        // use the real record number as key
                                        $result[$x] = array("recordnumber" =>  ($x+1),                     // record index starts at 0, so add 1 to the number to print
                                                            "currentrecord" => ($x == $currentRecord),
                                                            "first" =>         ($x == 0),                  // record index starts at 0
                                                            "last" =>          ($x == $recordCount-1)
                                                           );
                                }
                        }
                }
                // only return dummy values when at design-time
                else if (($this->ControlState & csDesigning) == csDesigning)
                {
                        // let's add some dummy values for design-time
                        for ($x = 1; $x <= $this->_shownrecordscount; $x++)
                        {
                                // use the real record number (starting at 0) as key
                                $result[$x-1] = array("recordnumber" =>  $x,
                                                      "currentrecord" => ($x == 1), // first is current record
                                                      "first" =>         ($x == 1),
                                                      "last" =>          false      // last not reached
                                                     );
                        }
                }

                return $result;
        }

        /**
        * Returns a correctly formatted URL string with the given action.
        * @param string $action Action to include in the URL.
        * @return string URL including the given action. Points to the script where
        *                the DBNavigator is used.
        */
        protected function dbNavLink($action)
        {
                $script = "";
                if (isset($_SERVER['PHP_SELF']))
                {
                        $script = basename($_SERVER['PHP_SELF']);
                }
                return $script."?".urlencode($this->_name)."=".urlencode($action);
        }

        /**
        * Get the contents of one cell (of the table).
        * @param string $caption Caption of the item to add to the cell content.
        * @param string $link Link to wrap arounf the caption.
        * @param string $cellalign The cell align depends on the orientation of the DBNavigator.
        *                          If noVertical it's valign, if noHorizontal it's align.
        * @param bool $enabled Set this argument to enable/disable the link.
        * @return string Returns a string with the cell contents.
        */
        protected function cellContents($caption, $link, $cellalign, $enabled = true)
        {
                $result = "";
                if ($this->_orientation == noVertical)
                {
                        $result .= "<tr valign=\"$cellalign\">\n";
                        if ($enabled)
                        {
                                $result .= "  <td align=\"center\"><a href=\"$link\">$caption</a></td>\n";
                        }
                        else
                        {
                                $result .= "  <td align=\"center\">$caption</td>\n";
                        }

                        $result .= "</tr>\n";
                }
                else
                {
                        if ($enabled)
                        {
                                $result .= "  <td align=\"$cellalign\"><a href=\"$link\">$caption</a></td>\n";
                        }
                        else
                        {
                                $result .= "  <td align=\"$cellalign\">$caption</td>\n";
                        }
                }
                return $result;
        }

        function dumpContents()
        {
                $style="";
                if ($this->Style=="")
                {
                        // get the Font attributes
                        $style = $this->Font->FontString;

                        if ($this->_color != "")
                        {
                                $style .= "background-color: " . $this->_color . ";";
                        }

                        // add the cursor to the style
                        if ($this->_cursor != "")
                        {
                                $cr = strtolower(substr($this->_cursor, 2));
                                $style .= "cursor: $cr;";
                        }
                }

                if ($style != "")  $style = "style=\"$style\"";

                $hint = $this->getHintAttribute();

                $class = ($this->Style != "") ? "class=\"$this->StyleClass\"" : "";

                // call on show here so the output can be influenced
                $this->callEvent('onshow', array());


                // get the contents of the record numbers first
                $numbersstr = "";
                $cellalign = ($this->_orientation == noVertical) ? "middle" : "center";
                $numbers = $this->getArrayOfRecordNumbers();
                foreach ($numbers as $number)
                {

                        $numbersstr .= $this->cellContents(sprintf($this->_pagenumberformat, $number['recordnumber']),     // caption of the record number
                                                           $this->dbNavLink($number['recordnumber']),                      // create a link to the record number
                                                           $cellalign,                                                     // align of the
                                                           !(bool)$number['currentrecord']);                               // enable all numbers except the current record
                }

                $currentRecord = -1;
                if (($this->ControlState & csDesigning) != csDesigning)
                {
                        //TODO: Check if DS is active 
                        // check if DS is set and active
                        if ($this->_datasource!=null && $this->_datasource->Dataset!=null && $this->_datasource->Dataset->Active)
                        {
                                $ds = $this->_datasource->DataSet;
                                $currentRecord = $this->_currentpos; //$ds->RecNo;
                        }
                }
                else
                {
                        // show the first record at design time
                        $currentRecord = 0;
                }

                // check if the first number is shown => disable the first and previous links
                $firstshown = ($currentRecord > -1 && array_key_exists($currentRecord, $numbers) && $numbers[$currentRecord]['first']);
                // check if the last number is shown => disable the next and last links
                $lastshown  = ($currentRecord > -1 && array_key_exists($currentRecord, $numbers) && $numbers[$currentRecord]['last']);

                               //echo "first: $firstshown last: $lastshown";
                echo "<table id=\"{$this->_name}_table\" height=\"$this->_height\" width=\"$this->_width\" cellpadding=\"0\" cellspacing=\"0\" $hint $style $class>\n";
                if ($this->_orientation == noVertical)
                {
                        if ($this->_showfirst == 1)
                        {
                                echo $this->cellContents($this->_captionfirst, $this->dbNavLink("first"), "top", !$firstshown);
                        }
                        if ($this->_showprevious == 1)
                        {
                                echo $this->cellContents($this->_captionprevious, $this->dbNavLink("prev"), "top", !$firstshown);
                        }

                        if ($this->_pagenumberformat != "") {
                                // add the page numbers here...
                                echo $numbersstr;
                        }

                        if ($this->_shownext == 1)
                        {
                                echo $this->cellContents($this->_captionnext, $this->dbNavLink("next"), "bottom", !$lastshown);
                        }
                        if ($this->_showlast == 1)
                        {
                                echo $this->cellContents($this->_captionlast, $this->dbNavLink("last"), "bottom", !$lastshown);
                        }
                }
                else
                {
                        echo "<tr valign=\"middle\">\n";

                        if ($this->_showfirst == 1)
                        {
                                echo $this->cellContents($this->_captionfirst, $this->dbNavLink("first"), "left", !$firstshown);
                        }
                        if ($this->_showprevious == 1)
                        {
                                echo $this->cellContents($this->_captionprevious, $this->dbNavLink("prev"), "left", !$firstshown);
                        }

                        if ($this->_pagenumberformat != "") {
                                // add the page numbers here...
                                echo $numbersstr;
                        }

                        if ($this->_shownext == 1)
                        {
                                echo $this->cellContents($this->_captionnext, $this->dbNavLink("next"), "right", !$lastshown);
                        }
                        if ($this->_showlast == 1)
                        {
                                echo $this->cellContents($this->_captionlast, $this->dbNavLink("last"), "right", !$lastshown);
                        }

                        echo "</tr>\n";
                }
                 echo "</table>\n";
        }

        /**
        * Occurs when a link on the database navigator is clicked,
        * after the action is executed.
        * It passes the executed action as parameter to the event handler. The
        * name of the parameter is "action".
        */
        function getOnClick() { return $this->_onclick; }
        /**
        * Occurs when a link on the database navigator is clicked,
        * after the action is executed.
        * It passes the executed action as parameter to the event handler. The
        * name of the parameter is "action".
        */
        function setOnClick($value) { $this->_onclick=$value; }
        function defaultOnClick() { return null; }


        /**
        * Caption of "First" link. Clicking on this link will show the first record
        * of the datasource.
        * @return string
        */
        function getCaptionFirst() { return $this->_captionfirst; }
        function setCaptionFirst($value) { $this->_captionfirst=$value; }
        function defaultCaptionFirst() { return "First"; }

        /**
        * Caption of "Prev" link. Clicking on this link will show the previous record
        * in regard to the current record of the datasource.
        * @return string
        */
        function getCaptionPrevious() { return $this->_captionprevious; }
        function setCaptionPrevious($value) { $this->_captionprevious=$value; }
        function defaultCaptionPrevious() { return "Prev"; }

        /**
        * Caption of "Next" link. Clicking on this link will show the next record
        * in regard to the current record of the datasource.
        * @return string
        */
        function getCaptionNext() { return $this->_captionnext; }
        function setCaptionNext($value) { $this->_captionnext=$value; }
        function defaultCaptionNext() { return "Next"; }

        /**
        * Caption of "Last" link. Clicking on this link will show the last record
        * of the datasource.
        * @return string
        */
        function getCaptionLast() { return $this->_captionlast; }
        function setCaptionLast($value) { $this->_captionlast=$value; }
        function defaultCaptionLast() { return "Last"; }

        function getColor() { return $this->readColor(); }
        function setColor($value) { $this->writeColor($value); }

        //DataSource property
        function getDataSource() { return $this->_datasource;   }
        function setDataSource($value)
        {
                $this->_datasource=$this->fixupProperty($value);
        }

        function getFont() { return $this->readFont(); }
        function setFont($value) { $this->writeFont($value); }

        /**
        * Orientation of the Paginator.
        * @return enum (noHorizontal, noVertical)
        */
        function getOrientation() { return $this->_orientation; }
        function setOrientation($value) { $this->_orientation = $value; }
        function defaultOrientation() { return noHorizontal; }

        /**
        * Format of the page numbers. %d defines the location of the number.
        * @return string
        */
        function getPageNumberFormat() { return $this->_pagenumberformat; }
        function setPageNumberFormat($value) { $this->_pagenumberformat=$value; }
        function defaultPageNumberFormat() { return "%d"; }

        function getParentColor() { return $this->readParentColor(); }
        function setParentColor($value) { $this->writeParentColor($value); }

        function getParentFont() { return $this->readParentFont(); }
        function setParentFont($value) { $this->writeParentFont($value); }

        function getShowHint() { return $this->readShowHint(); }
        function setShowHint($value) { $this->writeShowHint($value); }

        /**
        * Indicates if the "First" link is shown.
        * @return bool
        */
        function getShowFirst() { return $this->_showfirst; }
        function setShowFirst($value) { $this->_showfirst=$value; }
        function defaultShowFirst() { return 1; }

        /**
        * Indicates if the "Last" link is shown.
        * @return bool
        */
        function getShowLast() { return $this->_showlast; }
        function setShowLast($value) { $this->_showlast=$value; }
        function defaultShowLast() { return 1; }

        /**
        * Indicates if the "Next" link is shown.
        * @return bool
        */
        function getShowNext() { return $this->_shownext; }
        function setShowNext($value) { $this->_shownext=$value; }
        function defaultShowNext() { return 1; }

        /**
        * Indicates if the "Prev" link is shown.
        * @return bool
        */
        function getShowPrevious() { return $this->_showprevious; }
        function setShowPrevious($value) { $this->_showprevious=$value; }
        function defaultShowPrevious() { return 1; }

        function getShownRecordsCount() { return $this->_shownrecordscount; }
        function setShownRecordsCount($value) { $this->_shownrecordscount=$value; }
        function defaultShownRecordsCount() { return 10; }

        function getStyle()             { return $this->readstyle(); }
        function setStyle($value)       { $this->writestyle($value); }

        function getVisible() { return $this->readVisible(); }
        function setVisible($value) { $this->writeVisible($value); }

}

define ('rkHorizontal', 'rkHorizontal');
define ('rkVertical', 'rkVertical');

/**
 * A class to iterate througha dataset and repeat controls inside it
 *
 */
class DBRepeater extends Panel
{
            private $_kind=rkVertical;

            function getKind() { return $this->_kind; }
            function setKind($value) { $this->_kind=$value; }
            function defaultKind() { return rkVertical; }

            private $_restartdataset=true;

            function getRestartDataset() { return $this->_restartdataset; }
            function setRestartDataset($value) { $this->_restartdataset=$value; }
            function defaultRestartDataset() { return true; }

            private $_limit=0;

            function getLimit() { return $this->_limit; }
            function setLimit($value) { $this->_limit=$value; }
            function defaultLimit() { return 0; }


        private $_datasource=null;

        //DataSource property
        function getDataSource() { return $this->_datasource;   }
        function setDataSource($value)
        {
                $this->_datasource=$this->fixupProperty($value);
        }

        function loaded()
        {
                parent::loaded();
                $this->setDataSource($this->_datasource);
        }

        function dumpContents()
        {
                if (($this->ControlState & csDesigning)==csDesigning)
                {
                        parent::dumpContents();
                }
                else
                {
                        if ($this->_datasource!=null)
                        {
                                if ($this->_datasource->DataSet!=null)
                                {
                                        $ds=$this->_datasource->DataSet;

                                        if ($this->_restartdataset) $ds->first();

                                        if (!$ds->EOF)
                                        {
                                                $class = ($this->Style != "") ? "class=\"$this->StyleClass\"" : "";

                                                echo "<table id=\"{$this->_name}_table\" width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" $class>";
                                                $render=0;

                                                if ($this->_kind==rkHorizontal) echo "<tr>";
                                                while (!$ds->EOF)
                                                {
                                                        if ($this->_kind==rkVertical) echo "<tr>";
                                                        echo "<td>";
                                                        parent::dumpContents();
                                                        echo "</td>";
                                                        if ($this->_kind==rkVertical) echo "</tr>";
                                                        $ds->next();
                                                        $render++;
                                                        if ($this->_limit!=0)
                                                        {
                                                                if ($render>=$this->_limit) break;
                                                        }
                                                }
                                                if ($this->_kind==rkHorizontal) echo "</tr>";
                                                echo "</table>";
                                        }
                                }
                        }
                }
        }

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Layout->Type=XY_LAYOUT;
        }
}

?>
