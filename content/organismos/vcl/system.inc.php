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
 * EPropertyNotFound exception
 *
 * Exception thrown when trying to access a property not defined
 */
class EPropertyNotFound extends Exception
{
       /**
        * Constructor
        *
        * @param string $message
        * @param integer $code
        */
        function __construct($message = null, $code = 0)
        {
                $message=sprintf("Error using a property, not defined as a member [%s]", $message);

                // make sure everything is assigned properly
                parent::__construct($message, $code);
        }
}

/**
 * Object class
 *
 * All objects must inherit from this class
 */
class Object
{
        /**
        * Global input object, easily accessible without declaring global
        */
        public $input=null;

        /**
        * Constructor
        * @return object
        */
        function __construct()
        {
                global $input;

                //Assign the global input object so it can be used from inside
                $this->input=$input;
        }

        /**
         * Returns the name of the object class
         * @return string
         */
        function className()
        {
                return(get_class($this));
        }


        /**
         * Check if the object is from a specific class
         * @param string $name Name to compare
         * @return boolean
         */
        function classNameIs($name)
        {
                return(strtolower($this->ClassName())==strtolower($name));
        }


        /**
         * Check if a method exists
         * @param string $method Method name to check
         * @return boolean
         */
        function methodExists($method)
        {
                return(method_exists($this,$method));
        }

        /**
         * Returns the parent class of the object
         * @return class
         */
        function classParent()
        {
                return(get_parent_class($this));
        }

        /**
         * Check if the object inherits from a specific class
         * @param string $class Class name to check
         * @return boolean
         */
        function inheritsFrom($class)
        {
                return(is_subclass_of($this,$class) or $this->classNameIs($class));
        }

        /**
         * Reads a property from the streams
         * @param string $propertyname Name of the property to read
         * @param string $valuename Value name to read
         * @param string $stream Stream to read from
         */
        function readProperty($propertyname,$valuename,$stream='post')
        {
                //TODO: Use also get array
                //TODO: Use the input object
                if (isset($_POST[$valuename]))
                {
                        $value=$_POST[$valuename];
                        $this->$propertyname=$value;
                }
        }


         /**
         * To virtualize properties
         * @param string $nm Property name
         * @return mixed
         */
        function __get($nm)
        {
                $method='get'.$nm;

                //Search first for get$nm
                if (method_exists($this,$method))
                {
                        return ($this->$method());
                }
                else
                {
                        $method='read'.$nm;

                        //Search for read$nm
                        if (method_exists($this,$method))
                        {
                                return ($this->$method());
                        }
                        else
                        {
                                //If not, search a component owned by it, with that name
                                if ($this->inheritsFrom('Component'))
                                {
                                        reset($this->components->items);
                                        while (list($k,$v)=each($this->components->items))
                                        {
                                                if (strtolower($v->Name)==strtolower($nm)) return($v);
                                        }
                                }
                                throw new EPropertyNotFound($this->ClassName().".".$nm);
                        }
                }
        }

  /**
  * To virtualize properties
  * @param string $nm Property name
  * @param mixed $val Property value
  */
  function __set($nm, $val)
  {
        $method='set'.$nm;

        if (method_exists($this,$method))
        {
                $this->$method($val);
        }
        else
        {
                $method='write'.$nm;

                if (method_exists($this,$method))
                {
                        $this->$method($val);
                }
                else
                {
                        throw new EPropertyNotFound($this->ClassName().".".$nm);
                }
        }
  }


}


define('sGET',0);
define('sPOST',1);
define('sREQUEST',2);
define('sCOOKIES',3);
define('sSERVER',4);

/**
* Native Input Filter, not working yet
*/
class InputFilter
{
        function process($input)
        {
                //TODO: Our own input filtering class in native PHP code
                //NOTE: Comment this line to don't raise the exception an get the unfiltered input
                throw new Exception("The Input Filter PHP extension is not setup on this PHP installation, so the contents returned by Input is *not* filtered");
                return($input);
        }
}

/**
* Represents an input parameter from the user, it doesn't inherit from Object to
* be faster and smaller. Objects of this type are returned from the Input object.
*/
class InputParam
{
        public $name='';
        public $stream;
        public $filter_extension=false;
        public $filter=null;

        /**
        * Create the object
        * @param $name   Key of the stream to look form
        * @param $stream Stream to look for
        */
        function __construct($name, $stream=SGET)
        {
                //Checkout if filter extension has been installer or not
                $this->filter_extension=function_exists('filter_data');

                //If not, creates the native filter
                if (!$this->filter_extension)
                {
                        //TODO: Use a global native filter to reduce overhead
                        $this->createNativeFilter();
                }

                $this->name=$name;

                //Set the stream to look for
                switch($stream)
                {
                        case sGET: $this->stream=&$_GET; break;
                        case sPOST: $this->stream=&$_POST; break;
                        case sREQUEST: $this->stream=&$_REQUEST; break;
                        case sCOOKIES: $this->stream=&$_COOKIES; break;
                        case sSERVER: $this->stream=&$_SERVER; break;
                }

        }

        /**
        * Creates the native Input Filter to be used when there is no available extension
        */
        function createNativeFilter()
        {
                $this->filter = new InputFilter();
        }

        //TODO: Add filtering without the filtering extension installed

        /**
        * Returns the input filtered as a string
        */
        function asString()
        {
                //Filter this out
                if ($this->filter_extension)
                {
                        return(filter_data($this->stream[$this->name],FILTER_SANITIZE_STRING));
                }
                else
                {
                        return $this->filter->process($this->stream[$this->name]);
                }
        }

        /**
        * Returns the input filtered as a string array
        */
        function asStringArray()
        {
                //Filter this out
                if ($this->filter_extension)
                {
                        $data=$this->stream[$this->name];
                        reset($data);
                        $result=array();
                        while (list($k,$v)=each($data))
                        {
                                $result[filter_data($k,FILTER_SANITIZE_STRING)]=filter_data($v,FILTER_SANITIZE_STRING);
                        }
                        return($result);
                }
                else
                {
                        //TODO: Filter using a native library
                        return $this->filter->process($this->stream[$this->name]);
                }
        }

        /**
        * Returns the input filtered as a integer
        */
        function asInteger()
        {
                if ($this->filter_extension)
                {
                        return(filter_data($this->stream[$this->name],FILTER_SANITIZE_NUMBER_INT));
                }
                else
                {
                        return $this->filter->process($this->stream[$this->name]);
                }
        }

        /**
        * Returns the input filtered as a boolean
        */
        function asBoolean()
        {
                if ($this->filter_extension)
                {
                        return(filter_data($this->stream[$this->name],FILTER_VALIDATE_BOOLEAN));
                }
                else
                {
                        return $this->filter->process($this->stream[$this->name]);
                }
        }

        /**
        * Returns the input filtered as a float
        */
        function asFloat($flags=0)
        {
                if ($this->filter_extension)
                {
                        return(filter_data($this->stream[$this->name],FILTER_SANITIZE_NUMBER_FLOAT, $flags));
                }
                else
                {
                        return $this->filter->process($this->stream[$this->name]);
                }
        }

        /**
        * Returns the input filtered as a regular expression
        */
        function asRegExp()
        {
                //Filter this out
                if ($this->filter_extension)
                {
                        return(filter_data($this->stream[$this->name],FILTER_VALIDATE_REGEXP));
                }
                else
                {
                        return $this->filter->process($this->stream[$this->name]);
                }
        }

        /**
        * Returns the input filtered as an URL
        */
        function asURL()
        {
                //Filter this out
                if ($this->filter_extension)
                {
                        return(filter_data($this->stream[$this->name],FILTER_SANITIZE_URL));
                }
                else
                {
                        return $this->filter->process($this->stream[$this->name]);
                }
        }

        /**
        * Returns the input filtered as an email address
        */
        function asEmail()
        {
                //Filter this out
                if ($this->filter_extension)
                {
                        return(filter_data($this->stream[$this->name],FILTER_SANITIZE_EMAIL));
                }
                else
                {
                        return $this->filter->process($this->stream[$this->name]);
                }
        }

        /**
        * Returns the input filtered as an IP address
        */
        function asIP()
        {
                //Filter this out
                if ($this->filter_extension)
                {
                        return(filter_data($this->stream[$this->name],FILTER_VALIDATE_IP));
                }
                else
                {
                        return $this->filter->process($this->stream[$this->name]);
                }
        }

        /**
        * Returns the input filtered as an string
        */
        function asStripped()
        {
                //Filter this out
                if ($this->filter_extension)
                {
                        return(filter_data($this->stream[$this->name],FILTER_SANITIZE_STRIPPED));
                }
                else
                {
                        return $this->filter->process($this->stream[$this->name]);
                }
        }

        /**
        * URL-encode string, optionally strip or encode special characters.
        */
        function asEncoded()
        {
                //Filter this out
                if ($this->filter_extension)
                {
                        return(filter_data($this->stream[$this->name],FILTER_SANITIZE_ENCODED));
                }
                else
                {
                        return $this->filter->process($this->stream[$this->name]);
                }
        }

        /**
        * HTML-escape '"<>& and characters with ASCII value less than 32, optionally strip or encode other special characters.
        */
        function asSpecialChars()
        {
                //Filter this out
                if ($this->filter_extension)
                {
                        return(filter_data($this->stream[$this->name],FILTER_SANITIZE_SPECIAL_CHARS));
                }
                else
                {
                        return $this->filter->process($this->stream[$this->name]);
                }
        }

        /**
        * Do nothing, optionally strip or encode special characters.
        */
        function asUnsafeRaw()
        {
                //Filter this out
                if ($this->filter_extension)
                {
                        return(filter_data($this->stream[$this->name],FILTER_SANITIZE_UNSAFE_RAW));
                }
                else
                {
                        return $this->filter->process($this->stream[$this->name]);
                }
        }
}

/**
 * Input class, offers an easy way to get filtered input from the user
 * Usage:
 * global $input;
 * $action=$input->action;
 * if (is_object($action))
 * {
 *     $toperform=$action->asString();
 * }
 */
class Input
{
        /**
         * Magic method to search for the input from the user,
         * checkout the order in which the variable is searched for:
         * $_GET, $_POST, $_REQUEST, $_COOKIES, $_SERVER
         *
         * @return InputParam object or null if it's not found
         *
         */
        function __get($nm)
        {
                if (isset($_GET[$nm]))
                {
                        return(new InputParam($nm, sGET));
                }
                else
                if (isset($_POST[$nm]))
                {
                        return(new InputParam($nm, sPOST));
                }
                else
                if (isset($_REQUEST[$nm]))
                {
                        return(new InputParam($nm, sREQUEST));
                }
                else
                if (isset($_COOKIES[$nm]))
                {
                        return(new InputParam($nm, sCOOKIES));
                }
                else
                if (isset($_SERVER[$nm]))
                {
                        return(new InputParam($nm, sSERVER));
                }
                else
                {
                        return(null);
                }
          }
}

/**
 * Global $input variable, use it to get filtered/sanitized input from the user
 */
global $input;

$input=new Input();

?>
