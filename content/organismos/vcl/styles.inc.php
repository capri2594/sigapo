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

/**
 * StyleSheet Class
 * A class to allow import and use stylesheets
 *
 * @package Styles
 */
class CustomStyleSheet extends Component
{
        protected $_filename="";
        protected $_stylelist=array();
        protected $_inclstandard=0;
        protected $_inclid=0;
        protected $_incsubstyle=0;

        /**
         * Builds and returs back an array of Style names based on specified
         * parameters
         *
         * @return array of names
         */
        function BuildStyleList($FileName, $InclStandard, $InclID, $InclSubStyle)
        {
                $array=array();

                if (($FileName === "") || (!file_exists($FileName))) return $array;
                if (($file = fopen($FileName, "r")) == false) return $array;

                // Preload File, Parse out comments
                $flag = false;
                while (!feof($file))
                {
                        $line = fgets($file, 4096);
                        $line = trim($line);
                        while ($line != "")
                        {
                                if ($flag)
                                {
                                        $pos = strpos($line, "*/");
                                        if ($pos === false) $line = "";
                                        else
                                        {
                                                $line = substr($line, $pos + 3, strlen($line));
                                                $flag = false;
                                        }
                                }
                                else
                                {
                                        $pos = strpos($line, "/*");
                                        if ($pos === false)
                                        {
                                                $lines[] = $line;
                                                $line = "";
                                        }
                                        else
                                        {
                                                $flag = true;
                                                if ($pos !== 0)
                                                {
                                                        $temp = trim(substr($line, 0, $pos));
                                                        if (!$temp==="") $lines[] = $temp;
                                                }
                                                $line = substr($line, $pos + 2, strlen($line));
                                        }
                                }
                        }
                }
                fclose($file);
                // Nothing to work with
                if ((!isset($lines)) || (count($lines) == 0)) return $array;

                // Parse lines, remove CSS Definitions
                reset($lines);
                $flag = false;
                while (list($index, $line) = each($lines))
                {
                        while ($line!=="")
                        {
                                if ($flag)
                                {
                                        $pos = strpos($line, "}");
                                        if ($pos === false) $line = "";
                                        else
                                        {
                                                $line = trim(substr($line, $pos + 1, strlen($line)));
                                                $flag = false;
                                        }
                                }
                                else
                                {
                                        $pos = strpos($line, "{");
                                        if ($pos === false)
                                        {
                                                if (($line!=="") && (!in_array($line, $lines2)))
                                                        $lines2[] = $line;
                                                $line = "";
                                        }
                                        else
                                        {
                                                $flag = true;
                                                if ($pos !== 0)
                                                {
                                                        $temp = trim(substr($line, 0, $pos));
                                                        if ($temp!=="")
                                                                if ((!isset($lines2)) || (!in_array($temp, $lines2)))
                                                                        $lines2[] = $temp;
                                                }
                                                $line = trim(substr($line, $pos + 1, strlen($line)));
                                        }
                                }
                        }
                }
                // Nothing to work with
                if ((!isset($lines2)) || (count($lines2) == 0)) return $array;

                // Prepare style list
                reset($lines2);
                while (list(, $line) = each($lines2))
                {
                        $words = explode(",", $line);
                        reset($words);
                        while (list(, $word) = each($words))
                        {
                                $word = trim($word);
                                if ($word == "") continue;

                                if ($InclSubStyle == 0)
                                {
                                        $pos1 = strpos($word, '.');
                                        $pos2 = strpos($word, '#');
                                        if (($pos1 === 0) || ($pos2 === 0))
                                        {
                                                $prefix = $word{0};
                                                $word = trim(substr($word, 1, strlen($word)));
                                                $parts = split('[ .#]', $word);
                                                reset($parts);
                                                $part = $prefix . trim(current($parts));
                                        }
                                        else
                                        {
                                                $parts = split('[ .#]', $word);
                                                reset($parts);
                                                $part = trim(current($parts));
                                        }
                                }
                                else
                                        $part = $word;

                                if (trim($part) == "") continue;

                                if ((isset($array)) && (in_array($part, $array))) continue;

                                $pos1 = strpos($part, '.');
                                $pos2 = strpos($part, '#');
                                if ((($InclStandard == 1) && ($pos1 === false) && ($pos2 === false))
                                  || (($InclID == 1) && ($pos2 === 0))
                                  || ($pos1 === 0)
                                  )
                                {
                                        $array[] = $part;
                                }
                        }
                }
                return $array;
        }

        protected function ParseCSSFile()
        {
                $this->_stylelist=$this->BuildStyleList($this->FileName, $this->_inclstandard, $this->_inclid, $this->_incsubstyle);
        }

        function dumpHeaderCode()
        {
                echo("<link rel=\"stylesheet\" href=\"" . $this->_filename . "\" type=\"text/css\" />\n");
        }

        function loaded()
        {
                $this->ParseCSSFile();
        }

        /**
         * Specifies CSS File Name
         *
         * @return string
         */
        protected function readFileName()               { return $this->_filename; }
        protected function writeFileName($value)        { $this->_filename=$value; }
        function defaultFileName()                      { return ""; }
        /**
         * Specifies if Styles array should include style names for HTML tags
         *
         * @return boolean
         */
        protected function readIncludeStandard()        { return $this->_inclstandard; }
        protected function writeIncludeStandard($value) { $this->_inclstandard = $value; }
        function defaultIncludeStandard()               { return 0; }
        /**
         * Specifies if Styles array should include class IDs
         * If set to True, then to work properly IncludeSubStyle should be set to True also
         *
         * @return boolean
         */
        protected function readIncludeID()              { return $this->_inclid; }
        protected function writeIncludeID($value)       { $this->_inclid = $value; }
        function defaultIncludeID()                     { return 0; }
        /**
         * Specifies if Styles array should include Class Names only or
         * full class definitions including tag elements
         *
         * @return boolean
         */
        protected function readIncludeSubStyle()        { return $this->_incsubstyle; }
        protected function writeIncludeSubStyle($value) { $this->_incsubstyle = $value; }
        function defaultIncludeSubStyle()               { return 0; }
        /**
         * Array of Style Names from specified CSS File
         *
         * @return array
         */
        function readStyles()                           { $this->ParseCSSFile();
                                                          return $this->_stylelist; }
        function writeStyles($value)                    { $this->_stylelist = $value; }
}

/**
 * StyleSheet Class
 * A class to allow import and use stylesheets
 *
 * @package Styles
 */
class StyleSheet extends CustomStyleSheet
{
        // Publish properties
        function getFileName()                  { return $this->readFileName(); }
        function setFileName($value)            { $this->writeFileName($value); }

        function getIncludeStandard()           { return $this->readIncludeStandard(); }
        function setIncludeStandard($value)     { $this->writeIncludeStandard($value); }

        function getIncludeID()                 { return $this->readIncludeID(); }
        function setIncludeID($value)           { $this->writeIncludeID($value); }

        function getIncludeSubStyle()           { return $this->readIncludeSubStyle(); }
        function setIncludeSubStyle($value)     { $this->writeIncludeSubStyle($value); }
}

?>
