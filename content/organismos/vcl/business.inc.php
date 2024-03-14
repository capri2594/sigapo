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
use_unit("db.inc.php");

/**
 * BusinessObject Class
 *
 * A base class for business objects, not finished yet
 */
class BusinessObject extends Component
{
        protected $_database=null;
        protected $_tablename="";       

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);
        }
        
        //Database property
        function getDatabase() { return $this->_database;       }
        function setDatabase($value) 
        {
                $this->_database=$this->fixupProperty($value);
        }

        function loaded()
        {
                parent::loaded();
                $this->setDatabase($this->_database);
        }
        
        //Tablename property
        function getTableName() { return $this->_tablename;     }
        function setTableName($value) { $this->_tablename=$value; }                             
        
        
        function dumpContents()
        {
                //Dump here connection code if any
        }
}

?>