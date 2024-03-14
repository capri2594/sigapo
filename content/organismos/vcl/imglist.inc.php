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

/**
 * ImageList class
 *
 * A component that holds a list of image paths
 */
class ImageList extends Component
{
        protected $_images=array();

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);
        }

        //DriverName property
        function getImages() { return $this->_images;   }
        function setImages($value) { $this->_images=$value; }
        function defaultImages() { return "";   }

        function readImage($index)
        {
                //TODO: Check this with numeric keys as it fails
                if (isset($this->_images[$index])) return($this->_images[$index]);
                else
                {
                        reset($this->_images);
                        while(list($key, $val)=each($this->_images))
                        {
                                if ($key==$index) return($val);
                        }
                        return false;
                }
        }

        function readImageByID($index, $preformat)
        {
                $image="";
                if (($index > 0) && (isset($this->_images)))
                {
                        reset($this->_images);
                        while ((list($k, $image) = each($this->_images)) && ($k !== $index))
                        {
                                $image = "";
                        }
                }

                if ($image != "")
                {
                        $image = str_replace("%VCL_HTTP_PATH%", VCL_HTTP_PATH, $image);
                }

                if ($preformat == 1)
                {
                        if (($image == "") || ($image == null))
                        { $image = "null"; }
                        else
                        { $image = "\"" . $image . "\""; }
                }

                return $image;
        }
}


?>
