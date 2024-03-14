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

/**
* Major version of the VCL
*/
define('VCL_VERSION_MAJOR',1);
/**
* Minor version of the VCL
*/
define('VCL_VERSION_MINOR',0);

/**
* Version of the VCL, use this define to make work your components between VCL versions
*/
define('VCL_VERSION',VCL_VERSION_MAJOR.'.'.VCL_VERSION_MINOR);


        $scriptfilename='';

        if (isset($_SERVER['SCRIPT_FILENAME'])) $scriptfilename= $_SERVER['SCRIPT_FILENAME'];
        else
        {
                        global $HTTP_SERVER_VARS;

                        $scriptfilename=$HTTP_SERVER_VARS["SCRIPT_NAME"];
        }

        //Defines the PATH where the VCL resides
        $fs_path=relativePath(realpath(dirname(__FILE__)),dirname(realpath($scriptfilename)));
        $http_path=$fs_path;

        //If the vcl folder is not a subfolder of the VCL, then it uses vcl-bin as an alias to find the assets
        if (substr($fs_path,0,2)=='..')
        {
            if (!array_key_exists('FOR_PREVIEW',$_SERVER)) $http_path='vcl-bin';
        }

        /**
         * Filesystem path to the VCL
         *
         */
        define('VCL_FS_PATH',$fs_path);

        /**
         * Webserver path to the VCL
         *
         */
        define('VCL_HTTP_PATH',$http_path);

        /**
         * Returns a relative path
         *
         * @param string $path
         * @param string $root
         * @param string $separator
         * @return string
         */
        function relativePath($path, $root, $separator = '/')
        {
                $path=strtolower(str_replace('\\','/',$path));
                $root=strtolower(str_replace('\\','/',$root));

                $dirs = explode($separator, $path);
                $comp = explode($separator, $root);

                foreach ($comp as $i => $part)
                {
                        if (isset($dirs[$i]) && $part == $dirs[$i])
                        {
                                unset($dirs[$i], $comp[$i]);
                        }
                        else
                        {
                                //TODO: Check this with UNC
                                //TODO: If the .php file to be executed resides on a UNC, the webserver it doesn't start,
                                //fix or warn users about the correct usage of the library and the location
                                if ((strpos($part,':')) && (strpos($dirs[$i],':')))
                                {
                                        //This fixes the problem with having the code to be run
                                        //and the library in different drives, but it only works with IE
                                        //FF throws a security warning
                                        //TODO: Must fix another way
                                        $result='file:///'.$path;
                                        return($result);
                                }
                                break;
                        }
                }

                                $result=str_repeat('..' . $separator, count($comp)) . implode($separator, $dirs);

                return($result);
        }

        /**
         * Includes an VCL unit
         *
         * @param string $path Relative to VCL root path
         */
        function use_unit($path)
        {
                $apath=VCL_FS_PATH;
                if ($apath!="") $apath.="/";
                require_once($apath.$path);
        }
?>
