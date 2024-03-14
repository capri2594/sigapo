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

use_unit("system.inc.php");

global $exceptions_enabled;

$exceptions_enabled=true;

global $output_enabled;

$output_enabled=true;

/**
 * Component it's being loaded
 *
 */
define('csLoading',1);

/**
 * Component it's being edited on the IDE designer
 *
 */
define('csDesigning',2);


/**
 * Common exception handler
 *
 * @param Exception $exception
 */
function exception_handler($exception)
{
        echo "<pre>";
        $tolog="";
        $stacktrace="";
        $stacktrace.="Application raised an exception class <b>".get_class($exception)."</b> with message <b>'".$exception->getMessage()."'</b>\n";
        $msg=strip_tags($stacktrace)."|";
        $stack=array_reverse($exception->getTrace());
        reset($stack);
        $tab="";
        $c="";
        while (list($k,$v)=each($stack))
        {
                $stacktrace.=$tab.$c."Callstack #$k File: <b>".$v['file']."</b> Line: <b>".$v['line']."</b>\n";
                $tolog.=$v['line']."@".$v['file'].'@'.$msg;
                $tab.="  ";
                $c="|_";
        }
        echo $stacktrace;
        echo "</pre>";
        error_log($tolog);
}

set_exception_handler('exception_handler');

//TODO: Set a common method to throw errors
//TODO: Set a common method for debugging purposes

/**
 * EResNotFound exception
 *
 * Exception thrown when a resource is not found on an xml stream
 */
class EResNotFound extends Exception
{
        function __construct($message = null, $code = 0)
        {
                $message=sprintf("Resource not found [%s]", $message);

       // make sure everything is assigned properly
       parent::__construct($message, $code);
        }
}

/**
 * ENameDuplicated exception
 *
 * Exception thrown when a component has the same name on the same owner
 */
class ENameDuplicated extends Exception
{
        function __construct($message = null, $code = 0)
        {
                $message=sprintf("A component named %s already exists", $message);

       // make sure everything is assigned properly
       parent::__construct($message, $code);
        }
}

/**
 * EAssignError exception
 *
 * Exception thrown when trying to assign an object to another
 */
class EAssignError extends Exception
{
        function __construct($sourcename, $classname)
        {
                $message=sprintf("Cannot assign a %s to a %s", $sourcename, $classname);

               // make sure everything is assigned properly
               parent::__construct($message, 0);
        }
}

/**
 * ECollectionError exception
 *
 * Exception thrown for Collection errors
 */
class ECollectionError extends Exception
{
        function __construct($message = null, $code = 0)
        {
                $message=sprintf("List index out of bounds (%s)", $message);

       // make sure everything is assigned properly
       parent::__construct($message, $code);
        }
}

/**
 * Filer class
 *
 * A base class to read/write components from/to an xml stream
 */
class Filer extends Object
{
        protected $_xmlparser;
        protected $_root;
        protected $_lastread;
        protected $_parents;
        protected $_properties;
        protected $_lastproperty;
        protected $_rootvars;
        public $createobjects=true;


        /**
         * Initializes the object by setting up a list of parents and the xml parser used to read/write components
         * @param xmlparser $xmlparser xml parser to read/write components
         */
        function __construct($xmlparser)
        {
                //List of parents to provide a stack
                $this->_parents=new Collection();

                //TODO: Develop a TStringList class
                $this->_properties=array();

                //Root members, to initialize them with the right components
                $this->_rootvars=array();

                //Last component read
                $this->_lastread=null;


                //Last property read
                $this->_lastproperty=null;

                //The xml parser
                $this->_xmlparser=$xmlparser;
                xml_set_object($this->_xmlparser, $this);
                xml_set_element_handler($this->_xmlparser, "tagOpen", "tagClose");
                xml_set_character_data_handler($this->_xmlparser, "cData");
   }

        /**
         * Processed the opening tags to select which action to take
         * @param xmlparser $parser xml parser in use
         * @param string    $tag    opening tag
         * @param array     $attributes attributes of the opening tag
         */
        function tagOpen($parser, $tag, $attributes)
        {
                switch ($tag)
                {
                        case 'OBJECT': //Read object parameters
                        $new=true;

                        //Class and name for that component
                        $class=$attributes['CLASS'];
                        $name=$attributes['NAME'];

                        //If there is a root component and it has not been read yet
                        if ((is_object($this->_root)) && (!is_object($this->_lastread)))
                        {
                                //And the class we are reading matches
                                if (($this->_root->classNameIs($class)) || ($this->_root->inheritsFrom($class)))
                                {
                                        //We must read root properties, so set the lastread to the root
                                        $new=false;
                                        $this->_lastread=$this->_root;
                                        $this->_lastread->Name=$name;

                                }
                        }

                        //We must create a new object of the class just read
                        if ($new)
                        {
                                //If that class has been declared somewhere
                                if (class_exists($class))
                                {
                                        $this->_lastread=null;

                                        //Creates a new instance of that class
                                        if ($this->createobjects)
                                        {
                                                $this->_lastread=new $class($this->_root);

                                                //This is a kind of a hack to get the right reference to the newly created component
                                                $this->_lastread=$this->_root->components->items[count($this->_root->components->items)-1];
                                        }
                                        else
                                        {
                                                if (array_key_exists($name,$this->_rootvars))
                                                {
                                                        $this->_lastread=$this->_rootvars[$name];
                                                }
                                                else
                                                {
                                                        echo "Error reading language resource file, object ($name) not found";
                                                }
                                        }

                                        $this->_lastread->ControlState=csLoading;
                                        $this->_lastread->Name=$name;


                                        //We find the member of the root object and we set the reference
                                        if (array_key_exists($name,$this->_rootvars))
                                        {
                                                $this->_root->$name=$this->_lastread;
                                        }
                                        //TODO: Decide to dump here an error or not

                                        //Set the parent
                                        if ($this->_lastread->inheritsfrom("Control"))
                                        {
                                                $this->_lastread->Parent=$this->_parents->items[count($this->_parents->items)-1];
                                        }

                                        //Push it onto the stack
                                        $this->_parents->add($this->_lastread);
                                }
                                else
                                {
                                        //TODO: Change this by an exception when possible, there's a bug in PHP 5, because the exception is raised inside an xml reader
                                        echo "Error reading resource file, class ($class) doesn't exists";
                                        //throw new EResNotFound("Error reading resource file, class ($class) doesn't exists");
                                }
                        }
                        break;

                        case 'PROPERTY':
                        $new=true;
                        $name=$attributes['NAME'];

                        //If we are reading a property, must be inside an object
                        if (!is_object($this->_lastread))
                        {
                                echo "Error reading resource file, property ($name) doesn't have an object to assign to";
                        }
                        else
                        {
                                $this->_lastproperty=$name;
                                $this->_properties[]=$name;
                        }
                        break;

                        default: echo "Error reading resource file, tag ($tag) not recognized"; break;
                }
        }

        /**
         * Processed the data for tags
         * @param xmlparser $parser xml parser in use
         * @param string $cdata data to be processed
         */
        function cData($parser, $cdata)
        {
                $cdata=html_entity_decode($cdata);

                //If we have an object and a property
                if ((is_object($this->_lastread)) && ($this->_lastproperty!=null))
                {
                        $aroot=$this->_lastread;
                        $aproperty=$this->_lastproperty;

                        if (count($this->_properties)>1)
                        {
                                reset($this->_properties);

                                while (list($k,$v)=each($this->_properties))
                                {
                                        if ($v==$this->_lastproperty)
                                        {
                                                $aproperty=$v;
                                                break;
                                        }
                                        else
                                        {

                                                $am="get$v";
                                                $aroot=$aroot->$v;
                                        }
                                }
                        }

                                                $isarray=false;
                        //Getter
                        $method='get'.$aproperty;
                        //If there is a getter
                        if ($aroot->methodExists($method))
                        {
                                        $value=$aroot->$method();
                                        $isarray=is_array($value);

                        }

                        //Setter
                        $method='set'.$aproperty;


                        //If there is a setter
                        if ($aroot->methodExists($method))
                        {
                                //Set the property
                                $value=$cdata;

                                if ($isarray)
                                {
                                        $value=safeunserialize($value);
                                }

                                $aroot->$method($value);

                        }
                        else
                        {
                                if (($aroot->inheritsFrom('Component')) && (!$aroot->inheritsFrom('Control')) && ($aproperty=='Left'))
                                {

                                }
                                else if (($aroot->inheritsFrom('Component')) && (!$aroot->inheritsFrom('Control')) && ($aproperty=='Top'))
                                {

                                }
                                else echo "Error setting property (".$aroot->className()."::$this->_lastproperty), doesn't exists";
                        }
                }
        }

        /**
         * Processes tag closing
         * @param xmlparser $parser xml parser in use
         * @param string $tag tag being closed
         */
        function tagClose($parser, $tag)
        {
                switch($tag)
                {
                        case 'PROPERTY': 
                            // Pop last array element
                            array_pop($this->_properties);
                            $this->_lastproperty=null; 
                            break;
                        case 'OBJECT':
                                //Pop the parent from the stack
                                $this->_parents->delete(count($this->_parents->items)-1);


                                //Call the last read component
                                //TODO: Check if the last item from the stack is the right one to call loaded

                                $this->_lastread->ControlState=0;

                                if ($this->createobjects)
                                {
                                //Unserialize
                                if (($this->_lastread->inheritsFrom('Page')) || ($this->_lastread->inheritsFrom('DataModule')))
                                {
                                        $this->_lastread->unserialize();
                                        $this->_lastread->unserializeChildren();
                                }

                                //Loaded
                                if (($this->_lastread->inheritsFrom('Page')) || ($this->_lastread->inheritsFrom('DataModule')))
                                {
                                        $this->_lastread->loadedChildren();
                                        $this->_lastread->loaded();                                        
                                }

                                //PreInit
                                if (($this->_lastread->inheritsFrom('Page')) || ($this->_lastread->inheritsFrom('DataModule')))
                                {
                                        $this->_lastread->preinit();
                                }

                                //Init
                                if (($this->_lastread->inheritsFrom('Page')) || ($this->_lastread->inheritsFrom('DataModule')))
                                {
                                        $this->_lastread->init();
                                }
                                }

                                /*
                                if ($this->_root->inheritsFrom('Page'))
                                {
                                        if (!$this->_root->UseAjax) $this->_lastread->loaded();
                                }
                                else
                                {
                                        $this->_lastread->loaded();
                                }
                                */

                                if (count($this->_parents->items)>=1) $this->_lastread=$this->_parents->items[count($this->_parents->items)-1];
                                else $this->_lastread=null;
                                break;
                }
        }

         /**
         * Root component
         * @return object
         */
        function getRoot() { return($this->_root); }

         /**
         * Root component
         * @param object $value new property value
         */
        function setRoot($value)
        {
                //TODO: Check here $value for null
                $this->_root=$value;
                //Get the vars from the root object to get the pointers for the components
                $this->_rootvars=get_object_vars($this->_root);
                
                //Clear parents list and set the root as the first parent
                $this->_parents->clear();
                $this->_parents->add($this->_root);

        }
}

/**
 * Reader class
 *
 * A class to read components from an xml stream
 */
class Reader extends Filer
{
        /**
         * Read a component and all its children from a stream
         * @param object $root Root component to read
         * @param string $stream XML stream to read from
         */
        function readRootComponent($root,$stream)
        {
                $this->Root=$root;

                xml_parse($this->_xmlparser, $stream);

                $this->_root->ControlState=0;
        }
}

/**
 * Collection class
 *
 * A class to store and manage a list of objects
 */
class Collection extends Object
{
        //Items array
        public $items;

        function __construct()
        {
                //Initialize the array
                $this->clear();
        }

         /**
         * Add an item to the list
         * @param object $item Object to add to the list
         * @return integer
         */
        function add($item)
        {
                //Set the array to the end
                end($this->items);

                //Adds the item as the last one
                $this->items[]=$item;

                return($this->count());
        }

         /**
         * Clears the list
         */
        function clear()
        {
                $this->items=array();
        }

         /**
         * Delete an item from the list by its index
         * @param integer $index Index of the item to delete
         */                                     
        function delete($index)
        {
                //Deletes the item from the array, so the rest of items are reordered
                if ($index<$this->count())
                {
                        array_splice($this->items, $index, 1);
                }
                else
                {
                        throw new ECollectionError($index);
                }
        }

                 /**
         * Finds an item into the list
         * @param object $item Item to find
         */     
        function indexof($item)
        {       
                $result=-1;
                
                reset($this->items);
                while (list($k,$v)=each($this->items))
                {
                        if ($v===$item)
                        {
                                $result=$k;
                                break;
                        }
                }
                
                return($result);
        }

                 /**
         * Remove an item from the list
         * @param object $item Item to delete from the list
         */     
        function remove($item)
        {
                //Find the pointer
                $index=$this->indexof($item);

                //Delete the index if exists
                if ($index>=0)
                {
                        $this->delete($index);
                }
        }
        
                 /**
         * Return the number of items in the list
         * @return integer
         */
        function count()
        {
                return(count($this->items));
        }

                 /**
         * Return the last element from the collection
         * @return object
         */
        function last()
        {
                if ($this->count()>=1)
                {
                        return($this->items[count($this->items)-1]);
                }
                else
                {
                        return(null);
                }
        }

}

/**
 * Persistent class
 *
 * Base class for persistent objects
 */
class Persistent extends Object
{
                /**
                 * Used to serialize/unserialize
                 *
                 * @return string
                 */
        function readNamePath()
        {
                $result=$this->className();

                if ($this->readOwner()!=null)
                {
                        $s=$this->readOwner()->readNamePath();

                        if ($s!="") $result = $s . "." . $result;

                }

                return($result);
        }

        function readOwner()
        {
                return(null);
        }

        /**
         * Assing the source properties to this object
         *
         * @param Persistent $source
         */
        function assign($source)
        {
                if ($source!=null) $source->assignTo($this);
                else $this->assignError(null);
        }

        /**
         * Assign this object to another object
         *
         * @param Persistent $dest
         */
        function assignTo($dest)
        {
                $dest->assignError($this);
        }

        /**
         * Raises an assignation error
         *
         * @param Persistent $source
         */
        function assignError($source)
        {
                if ($source!=null) $sourcename=$source->className();
                else $sourcename='null';

                throw new EAssignError($sourcename,$this->className());
        }

        /**
         * Stores this object into the session
         *
         */
        function serialize()
        {
                $owner=$this->readOwner();

        if ($owner!=null)
        {
                $refclass=new ReflectionClass($this->ClassName());
                $methods=$refclass->getMethods();

                reset($methods);

                while (list($k,$method)=each($methods))
                {
                        $methodname=$method->name;

                        if ($methodname[0] == 's' && $methodname[1] == 'e' && $methodname[2] == 't')   // fast check of: substr($methodname,0,3)=='set'
                        {
                                $propname=substr($methodname, 3);
                                $propvalue=$this->$propname;
                                if (!is_object($propvalue))
                                {
                                        $_SESSION[$owner->readNamePath().".".$this->readNamePath().".".$propname]=$propvalue;
                                }
                        }
                }

                $this->serializeChildren();
        }
        else
        {
                global $exceptions_enabled;

                if ($exceptions_enabled)
                {
                        throw new Exception('Cannot serialize a component without an owner');
                }
        }
  }


  /**
   * Read this object properties from the session
   *
   */
  function unserialize()
  {
        $owner=$this->readOwner();

        if ($owner!=null)
        {
                $refclass=new ReflectionClass($this->ClassName());
                $methods=$refclass->getMethods();

                $this->ControlState=csLoading;

                reset($methods);

                while (list($k,$method)=each($methods))
                {
                        $methodname=$method->name;

                        if ($methodname[0] == 's' && $methodname[1] == 'e' && $methodname[2] == 't')     // fast check of: substr($methodname,0,3)=='set'
                        {
                                $propname=substr($methodname, 3);

                                $fullname = $owner->readNamePath().".".$this->readNamePath().".".$propname;
                                if (isset($_SESSION[$fullname]))
                                {
                                        $this->$propname=$_SESSION[$fullname];
                                }
                        }
                }

                $this->ControlState=0;
        }
        else
        {
                global $exceptions_enabled;

                if ($exceptions_enabled)
                {
                        throw new Exception('Cannot unserialize a component without an owner');
                }
        }
  }
}


/**
 * Component class
 *
 * Base class for components
 */
class Component extends Persistent
{
        public $owner;
        public $components;
        public $_name;
        public $lastresourceread="";
        protected $_controlstate=0;

        public $_tag=0;

        /**
        * Constructor
        * @param object $aowner The owner of this component
        */
        function __construct($aowner=null)
        {
                //Calls the inherited constructor
                parent::__construct($aowner);

                //List of children
                $this->components=new Collection();

                //Initialize owner
                $this->owner=null;

                //Initialize name
                $this->_name="";

                $this->_controlstate=0;

                if ($aowner!=null)
                {
                        //If there is an owner
                        if (is_object($aowner))
                        {
                                //Store it
                                $this->owner=$aowner;

                                //Adds itself to the list of components from the owner
                                $this->owner->insertComponent($this);
                        }
                        else
                        {
                                throw new Exception("Owner must be an object");
                        }
                }

        }

        /**
        *  A virtual method to get notified when the object has been loaded from a stream
        */
        function loaded()
        {
                //TODO: Change the component state from loading to loaded
        }
        
                /**
                 * Calls childrens loaded recursively
                 *
                 */
        function loadedChildren()
        {
                //Calls childrens loaded recursively
                reset($this->components->items);
                while (list($k,$v)=each($this->components->items))
                {
                        $v->loaded();
                }
        }

        function readAccessibility($method, $defaccessibility)
        {
                return(Accessibility_Fail);
        }


        function fixupProperty($value)
        {
                if (($this->ControlState & csDesigning)!=csDesigning)
                {
                        if (!empty($value))
                        {
                                if (!is_object($value))
                                {
                                        $form=$this->owner;
                                        if (strpos($value,'.'))
                                        {
                                                $pieces=explode('.',$value);
                                                $form=$pieces[0];

                                                global $$form;

                                                $form=$$form;

                                                $value=$pieces[1];
                                        }
                                        if (is_object($form->$value))
                                        {
                                                $value=$form->$value;
                                        }
                                }
                        }
                }
                return($value);
        }

        /**
         * Unserialize all children
         *
         */
        function unserializeChildren()
        {
                reset($this->components->items);
                while (list($k,$v)=each($this->components->items))
                {
                        $v->unserialize();
                }
        }


        /**
         * Calls an server event
         *
         * @param string $event
         * @param mixed $params
         * @return mixed calling event result
         */
        function callEvent($event,$params)
        {
                $ievent="_".$event;

                if ($this->$ievent!=null)
                {
                        $event=$this->$ievent;
                        if (!$this->owner->classNameIs('application'))
                        {
                                return($this->owner->$event($this,$params));
                        }
                        else return($this->$event($this,$params));
                }
        }

        /**
         * Returns the js event attribute to call the server using ajax
         *
         * @param string $jsevent  javascript event
         * @param string $phpevent php event to call
         * @return string
         */
        function generateAjaxEvent($jsevent, $phpevent)
        {
                $result=" $jsevent=\"xajax_ajaxProcess('".$this->owner->Name."','".$this->Name."',null,'$phpevent',xajax.getFormValues('".$this->owner->Name."'))\" ";

                return($result);
        }

        /**
         * Returns the js event attribute to call the server using ajax
         *
         * @param string $jsevent  javascript event
         * @param string $phpevent php event to call
         * @return string
         */
        function ajaxCall($phpevent, $params=array())
        {

                $result=" xajax_ajaxProcess('".$this->owner->Name."','".$this->Name."',params,'$phpevent',xajax.getFormValues('".$this->owner->Name."'));\n ";

                return($result);
        }

        /**
         * To initialize a component
         */
        function preinit()
        {
                //Calls childrens init recursively
                reset($this->components->items);
                while (list($k,$v)=each($this->components->items))
                {
                        $v->preinit();
                }
        }

        /**
         * To initialize a component, the right place to process events
         */
        function init()
        {
                //Calls childrens init recursively
                reset($this->components->items);
                while (list($k,$v)=each($this->components->items))
                {
                        $v->init();
                }
        }

        /**
        * Checks if there is any datafield attached to the component
        * and sets the dataset in edit state and all the fields with
        * the appropiate values so the dataset is able to update the
        * right record
        *
        * Properties for data-aware components must be named
        * DataField
        * DataSource
        *
        * This is for basic single-field data-aware controls, for more
        * complicated controls like DBGrid, each component must create
        * its own mechanism to update information in the database
        */
        function updateDataField($value)
        {
                if ($this->_datafield!="")
                {
                        if ($this->_datasource!=null)
                        {
                                if ($this->_datasource->Dataset!=null)
                                {
                                        //Check here for the index fields
                                        $keyfields=$this->Name."_key";
                                        $keys=$this->input->$keyfields;
                                        // check if the keys were posted
                                        if (is_object($keys))
                                        {
                                                $fname=$this->DataField;

                                                //Set in Edit State
                                                $this->_datasource->Dataset->edit();


                                                $values=$keys->asStringArray();

                                                //Sets the key values
                                                reset($values);
                                                while (list($k,$v)=each($values))
                                                {
                                                        $this->_datasource->Dataset->$k=$v;
                                                }

                                                //Set the field value
                                                $this->_datasource->Dataset->$fname=$value;
                                        }
                                        else $this->_datasource->Dataset->{$this->_datafield}=$value;
                                }
                        }
                }
        }

        /**
        * This function returns true if the datafield is valid
        *
        */
        function hasValidDataField()
        {
                $result=false;

                if ($this->_datafield!="")
                {
                        if ($this->_datasource!=null)
                        {
                                if ($this->_datasource->Dataset!=null)
                                {
                                        $result=true;
                                }
                        }
                }

                return($result);
        }

        /**
        * This function returns the value of the datafield, if any
        *
        */
        function readDataFieldValue()
        {
                $result=false;
                if ($this->hasValidDataField())
                {
                        $fname=$this->DataField;
                        $value=$this->_datasource->Dataset->$fname;
                        $result=$value;
                }
                return($result);
        }

        /**
        * This function dumps out the key fields for the current row
        *
        */
        function dumpHiddenKeyFields($force=false)
        {
                if ($this->_datasource!=null)
                {
                        if ($this->_datasource->Dataset!=null)
                        {
                                if (($this->_datasource->Dataset->State!=dsInsert) || ($force))
                                {
                                    //Dump the key values for this record so I'm able to update it in the future
                                    $this->_datasource->Dataset->dumpHiddenKeyFields($this->Name."_key");
                                }
                        }
                }
        }

        /**
         * Serialize all children
         *
         */
        function serializeChildren()
        {
                //Calls childrens serialize recursively
                reset($this->components->items);
                while (list($k,$v)=each($this->components->items))
                {
                        $v->serialize();
                }
        }

        /**
         * To dump the javascript code needed by this component
         */
        function dumpJavascript()
        {
                //Do nothing yet
        }

        /**
         * To dump header code required
         */
        function dumpHeaderCode()
        {
                //Do nothing yet
        }

        /**
         * Dump the javascript code for all the children
         */
        function dumpChildrenJavascript()
        {
                //Iterates through components, dumping all javascript
                $this->dumpJavascript();
                reset($this->components->items);
                while (list($k,$v)=each($this->components->items))
                {
                        if ($v->inheritsFrom('Control'))
                        {
                                if ($v->canShow())
                                {
                                        $v->dumpJavascript();
                                }
                        }
                        else $v->dumpJavascript();
                }
        }

        /**
         * Dump the header code for all the children
         *
         * @param boolean $return_contents
         * @return string
         */
        function dumpChildrenHeaderCode($return_contents=false)
        {
                //Iterates through components, dumping all javascript
                reset($this->components->items);

                if ($return_contents) ob_start();
                while (list($k,$v)=each($this->components->items))
                {
                        if ($v->inheritsFrom('Control'))
                        {
                                if ($v->canShow())
                                {
                                        $v->dumpHeaderCode();
                                }
                        }
                        else $v->dumpHeaderCode();
                }
                if ($return_contents)
                {
                        $contents=ob_get_contents();
                        ob_end_clean();
                        return($contents);
                }
        }

        /**
         * Load this component from a string
         *
         * @param string $filename  xml file name
         * @param boolean $inherited specifies if we are going to read an inherited resource
         */
        function loadResource($filename, $inherited=false, $storelastresource=true)
        {
           global $application;

           if (!$inherited)
           {
                   if ($this->inheritsFrom('Page'))
                   {
                        if ($this->classParent()!='Page')
                        {
                                $varname=$this->classParent();
                                global $$varname;
                                $baseobject=$$varname;
                                $this->loadResource($baseobject->lastresourceread, true);
                        }
                   }
           }

           if ($storelastresource) $this->lastresourceread=$filename;
           //TODO: Check here for the path to the resource file
           //$resourcename=basename($filename);
           $resourcename=$filename;
           $l="";

           if ((($application->Language!='')) || (($this->inheritsFrom('Page')) && ($this->Language!='(default)')))
           {
                $resourcename=str_replace('.php',$l.'.xml.php',$filename);
                $this->readFromResource($resourcename);

                $l=".".$application->Language;
                $resourcename=str_replace('.php',$l.'.xml.php',$filename);
                if (file_exists($resourcename))
                {
                        $this->readFromResource($resourcename, false, false);
                }
           }
           else
           {
                   $resourcename=str_replace('.php',$l.'.xml.php',$resourcename);
                   $this->readFromResource($resourcename);
           }
        }

        /**
         * Read a component from a resource file
         * @param string $filename Filename of the resource file
         * @param boolean $createobjects Specifies if create the objects found or just read properties
         */
        function readFromResource($filename="", $createobjects=true)
        {
                //Default filename
                if ($filename=="") $filename=strtolower($this->className()).".xml.php";

                if ($filename!="")
                {
                        if (file_exists($filename))
                        {
                                //Reads the component from an xml stream
                                $xml=xml_parser_create("UTF-8");
                                $reader=new Reader($xml);
                                $filelines=file($filename);

                                array_shift($filelines);
                                array_pop($filelines);

                                $file=implode('',$filelines);

                                $reader->createobjects=$createobjects;

                                $reader->readRootComponent($this, $file);
                        }
                        else
                        {
                                global $exceptions_enabled;

                                if ($exceptions_enabled) throw new EResNotFound($filename);
                        }
                }

        }

         /**
         * Insert a component into the components collection
         * @param object $acomponent Component to insert
         */
        function insertComponent($acomponent)
        {
                //Adds a component to the components list
                $acomponent->owner=$this;
                $this->components->add($acomponent);
        }

        /**
         * Remove a component from the components collection
         * @param object $acomponent Component to remove
         */
        function removeComponent($acomponent)
        {
                //Remove a component from the components list
                $this->components->remove($acomponent);
        }


        //Properties

        // Components property
        function readComponents() { return $this->components; }
        function readComponentCount() { return $this->components->count(); }

        // ControlState property
        function readControlState() { return $this->_controlstate; }
        function writeControlState($value) { $this->_controlstate=$value; }

        // NamePath property
        function readNamePath() { return($this->_name); }

        // Owner property
        function readOwner() { return($this->owner); }

        //Published properties

        // Name property
        function getName() { return $this->_name; }
        function setName($value)
        {
                //TODO: If there is an owner, check there are no any other component with the same name
                if ($value!=$this->_name)
                {
                        if ($this->owner!=null)
                        {
                                if (!$this->owner->classNameIs('application'))
                                {
                                        $owner=$this->owner;
                                        reset($owner->components->items);
                                        while (list($k,$v)=each($owner->components->items))
                                        {
                                                if (strtolower($v->Name)==strtolower($value))
                                                {
                                                        throw new ENameDuplicated($value);
                                                }
                                        }
                                        $this->_name=$value;
                                }
                                else $this->_name=$value;
                        }
                        else $this->_name=$value;
                }
        }
        function defaultName() { return(""); }

        //Tag property
        function getTag() { return $this->_tag; }
        function setTag($value) { $this->_tag=$value; }
        function defaultTag() { return 0; }
}

?>
