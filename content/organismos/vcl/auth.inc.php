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

use_unit("forms.inc.php");
use_unit("classes.inc.php");
use_unit("dbtables.inc.php");

/**
 * User class
 *
 * A common base class for user authentication
 */
class User extends Component
{
        protected $_logged;

         /**
         * Constructor
         * @return object
         */
        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);
        }

        /**
         * Logged property, whether the user is logged or not
         *
         * @return boolean
         */
        function readLogged() { return $this->_logged;   }
        
        /**
         * Logged property, whether the user is logged or not
         *
         * @param boolean $value
         */
        function writeLogged($value) { $this->_logged=$value; }

         /**
         * Authenticate the user inside the system
         *
         */
        function Authenticate($username, $password)
        {
        }

}

/**
 * Authenticate users against a database
 *
 */
class DatabaseUser extends User
{
        //UsersTable
        //UsernameFieldName
        //PasswordFieldName
        protected $_logged;

        protected $_drivername="";
        protected $_databasename="";
        protected $_host="";
        protected $_user="";
        protected $_password="";

        protected $_userstable="";
        protected $_usernamefieldname="";
        protected $_passwordfieldname="";

        /**
         * Table that stores the user information
         *
         * @return string
         */
        function getUsersTable() { return $this->_userstable;   }
        /**
         * Table that stores the user information
         *
         * @param string $value
         */
        function setUsersTable($value) { $this->_userstable=$value; }

        /**
         * Field name of the column that stores the user name
         *
         * @return string
         */
        function getUserNameFieldName() { return $this->_usernamefieldname;     }
        /**
         * Field name of the column that stores the user name
         *
         * @param string $value
         */
        function setUserNameFieldName($value) { $this->_usernamefieldname=$value; }

        /**
         * Field name of the column that stores the password
         *
         * @return string
         */
        function getPasswordFieldName() { return $this->_passwordfieldname;     }
        /**
         * Field name of the column that stores the password
         *
         * @param unknown_type $value
         */
        function setPasswordFieldName($value) { $this->_passwordfieldname=$value; }

        /**
         * Type of database
         *
         * @return string
         */
        function getDriverName() { return $this->_drivername;   }
        /**
         * Type of database
         *
         * @param string $value
         */
        function setDriverName($value) { $this->_drivername=$value; }

        /**
         * Database name
         *
         * @return string
         */
        function getDatabaseName() { return $this->_databasename;       }
        /**
         * Database name
         *
         * @param unknown_type $value
         */
        function setDatabaseName($value) { $this->_databasename=$value; }

        /**
         * Host of the server
         *
         * @return string
         */
        function getHost() { return $this->_host;       }
        /**
         * Host of the server
         *
         * @param unknown_type $value
         */
        function setHost($value) { $this->_host=$value; }

        /**
         * User to authentitcate
         *
         * @return string
         */
        function getUser() { return $this->_user;       }
        /**
         * User to authenticate
         *
         * @param string $value
         */
        function setUser($value) { $this->_user=$value; }

        /**
         * Password to authenticate
         *
         * @return unknown
         */
        function getPassword() { return $this->_password;       }
        /**
         * Password to authenticate
         *
         * @param unknown_type $value
         */
        function setPassword($value) { $this->_password=$value; }
      
        function Authenticate($username, $password)
        {
                $this->Logged=false;
                
                //create a database
                $db=new Database(null);
                $db->DriverName=$this->DriverName;
                $db->DatabaseName=$this->DatabaseName;
                $db->Host=$this->Host;
                $db->User=$this->User;
                $db->Password=$this->Password;

                //open it
                $db->open();

                //create a table
                $tb=new Table(null);
                $tb->Database=$db;
                $tb->Filter=" ".$this->UserNameFieldName." = '".$username."' ";
                $tb->TableName=$this->UsersTable;
                $tb->open();
               
                                $fname=$this->UserNameFieldName;
                $pname=$this->PasswordFieldName;

                //check if the user&password combination exists
                if ($tb->RowCount>0)
                {
                        if (($tb->$fname==$username) && ($tb->$pname==$password))
                        {
                                $this->Logged=true;
                        }
                }
                $this->serialize();
        }
}

/**
 * Performs authentication using basic HTTP authentication
 *
 */
class BasicAuthentication extends Component
{
        protected $_title="Login";
        protected $_errormessage="Unauthorized";
        protected $_username="";
        protected $_password="";


        /**
         * Password to request
         *
         * @return string
         */
        function getPassword() { return $this->_password;       }
        function setPassword($value) { $this->_password=$value; }
        function defaultPassword() { return "";    }

        /**
         * Username to request
         *
         * @return string
         */
        function getUsername() { return $this->_username;       }
        function setUsername($value) { $this->_username=$value; }
        function defaultUsername() { return ""; }

        function getErrorMessage() { return $this->_errormessage; }
        function setErrorMessage($value) { $this->_errormessage=$value; }
        function defaultErrorMessage() { return "Unauthorized"; }

            function getTitle() { return $this->_title; }
            function setTitle($value) { $this->_title=$value; }
            function defaultTitle() { return "Login"; }



            protected $_onauthenticate=null;

            function getOnAuthenticate() { return $this->_onauthenticate; }
            function setOnAuthenticate($value) { $this->_onauthenticate=$value; }
            function defaultOnAuthenticate() { return ""; }

        /**
         * Executes the authentication and checks if the user has been authenticated or not
         *
         */
        function Execute()
        {
                        //If not is set, requests for it
                if(!isset($_SERVER['PHP_AUTH_USER']))
                {
                        header('WWW-Authenticate: Basic realm="' . $this->_title. '"');
                        header('HTTP/1.0 401 Unauthorized');
                        die($this->_errormessage);
                }
                else
                {
                        //If not it's the right combination, request for it
                        if ($this->OnAuthenticate!=null)
                        {
                                $result=$this->callEvent('onauthenticate', array('username'=>$_SERVER['PHP_AUTH_USER'],'password'=>$_SERVER['PHP_AUTH_PW']));
                                if (!$result)
                                {
                                        header('WWW-Authenticate: Basic realm="' . $this->_title. '"');
                                        header('HTTP/1.0 401 Unauthorized');
                                        die($this->_errormessage);
                                }
                        }
                        else
                        {
                                if (($_SERVER['PHP_AUTH_USER'] != $this->_username) || ($_SERVER['PHP_AUTH_PW'] != $this->_password))
                                {
                                        header('WWW-Authenticate: Basic realm="' . $this->_title. '"');
                                        header('HTTP/1.0 401 Unauthorized');
                                        die($this->_errormessage);
                                }
                        }
                }
        }
}

?>
