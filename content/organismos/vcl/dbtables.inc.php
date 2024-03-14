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
use_unit("db.inc.php");
use_unit("rtl.inc.php");
use_unit('adodb/adodb.inc.php');
use_unit('adodb/adodb-exceptions.inc.php');

/**
 * Database class
 *
 * A component that represents a database
 */

class Database extends CustomConnection
{
        public $_connection=null;
        protected $_debug=0;
        protected $_drivername="mysql";
        protected $_databasename="";
        protected $_host="";
        protected $_username="";
        protected $_userpassword="";
        protected $_connected=0;
        protected $_dictionary="";
        protected $_dictionaryproperties=false;

        function MetaFields($tablename)
        {
            $fd=$this->_connection->MetaColumns($tablename);
            $result=array();
            reset($fd);
            while(list($key, $val)=each($fd))
            {

                $result[$val->name]='';
            }
            return($result);
        }

        function BeginTrans()
        {
            $this->_connection->StartTrans();
        }

        function CompleteTrans($autocomplete=true)
        {
            $this->_connection->CompleteTrans($autocomplete);
        }

        function getOnAfterConnect() { return $this->readonafterconnect(); }
        function setOnAfterConnect($value) { $this->writeonafterconnect($value); }

        function getOnBeforeConnect() { return $this->readonbeforeconnect(); }
        function setOnBeforeConnect($value) { $this->writeonbeforeconnect($value); }

        function getOnAfterDisconnect() { return $this->readonafterdisconnect(); }
        function setOnAfterDisconnect($value) { $this->writeonafterdisconnect($value); }

        function getOnBeforeDisconnect() { return $this->readonbeforedisconnect(); }
        function setOnBeforeDisconnect($value) { $this->writeonbeforedisconnect($value); }


        function Prepare($query)
        {
            $this->_connection->Prepare($query);
        }

        function PrepareSP($query)
        {
            $this->_connection->PrepareSP($query);
        }

        function DBDate($input)
        {
            return($this->_connection->DBDate($input));
        }

        function Param($input)
        {
            return($this->_connection->Param($input));
        }

        function QuoteStr($input)
        {
            return($this->_connection->qstr($input));
        }

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);
        }

        function readConnected() { return ($this->_connection!=null); }

        function getConnected() { return $this->readconnected(); }
        function setConnected($value) { $this->writeconnected($value); }


        function getDebug() { return $this->_debug; }
        function setDebug($value) { $this->_debug=$value; }
        function defaultDebug() { return 0; }

        //DriverName property
        function getDriverName() { return $this->_drivername;   }
        function setDriverName($value) { $this->_drivername=$value; }

        //Dictionary property
        function getDictionary() { return $this->_dictionary;   }
        function setDictionary($value) { $this->_dictionary=$value; }

        //DatabaseName property
        function getDatabaseName() { return $this->_databasename;       }
        function setDatabaseName($value) { $this->_databasename=$value; }

        //Host property
        function getHost() { return $this->_host;       }
        function setHost($value) { $this->_host=$value; }

        //UserName property
        function getUserName() { return $this->_username;       }
        function setUserName($value) { $this->_username=$value; }

        //Password property
        function getUserPassword() { return $this->_userpassword;       }
        function setUserPassword($value) { $this->_userpassword=$value; }

        /**
         * Executes a query
         *
         * @param string $query
         * @return object
         */
        function execute($query,$params=array())
        {
                $this->open();
                $rs=$this->_connection->Execute($query,$params);
                if ($rs==null)
                {
                        DatabaseError("Error executing query: $query [".$this->_connection->ErrorMsg()."]");
                }
                return($rs);
        }

        /**
         * Executes a limited query
         *
         * @param string $query
         * @return object
         */
        function executelimit($query,$numrows,$offset)
        {
                $this->open();
                $rs=$this->_connection->SelectLimit($query,$numrows,$offset);
                if ($rs==null)
                {
                        DatabaseError("Error executing query: $query [".$this->_connection->ErrorMsg()."]");
                }
                return($rs);
        }

        function DoConnect()
        {
            if (($this->ControlState & csDesigning)!=csDesigning)
            {
                global $ADODB_FETCH_MODE;
                $ADODB_FETCH_MODE=ADODB_FETCH_ASSOC;

                try
                {
                    $this->_connection = ADONewConnection($this->DriverName);

                    $this->_connection->debug=$this->Debug;

                    if (($this->DriverName=='borland_ibase') || ($this->DriverName=='ibase'))
                    {
                        $result=$this->_connection->PConnect($this->DatabaseName,$this->UserName,$this->UserPassword);
                    }
                    else
                    {
                        $result=$this->_connection->Connect($this->Host,$this->UserName,$this->UserPassword,$this->DatabaseName);
                    }
                }
                catch (Exception $e)
                {
                    DatabaseError("Cannot connect to database server");
                }
            }
        }

        function DoDisconnect()
        {
                if ($this->_connection!=null)
                {
                        $this->_connection->Close();
                        $this->_connection=null;
                }
        }

        /**
         * Return properties for a field
         *
         * @param string $table
         * @param string $field
         * @return array
         */
        function readFieldDictionaryProperties($table, $field)
        {
                $table=trim($table);
                $field=trim($field);
                $result=false;
                if ($this->_connection!=null)
                {
                        if ($this->_dictionary!='')
                        {
                                global $ADODB_FETCH_MODE;
                                $ADODB_FETCH_MODE=ADODB_FETCH_ASSOC;

                                $q="select * from $this->_dictionary where dict_tablename='$table' and dict_fieldname='$field'";
                                $r=$this->execute($q);
                                $props=array();
                                while ($r->fetchInto($arow))
                                {
                                        $row=array();
                                        reset($arow);
                                        while (list($k,$v)=each($arow))
                                        {
                                                $row[strtolower($k)]=$v;
                                        }

                                        $props[$row['dict_property']]=array($row['dict_value1'],$row['dict_value2']);
                                }
                                if (!empty($props)) $result=$props;
                        }
                        else
                        {
                                if ($this->_dictionaryproperties!=false)
                                {
                                        $result=$this->_dictionaryproperties[$table][$field];
                                }
                        }
                }
                return($result);
        }


        /**
         * Return indexes for a table
         *
         * @param string $table
         * @param boolean $primary
         * @return array
         */
        function &extractIndexes($table, $primary = FALSE)
        {
                return($this->_connection->MetaIndexes($table,$primary));
        }

        function readDictionaryProperties() { return $this->_dictionaryproperties;   }
        function writeDictionaryProperties($value) { $this->_dictionaryproperties=$value; }


        /**
         * Creates the dictionary table on the database
         *
         * @return boolean
         */
        function createDictionaryTable()
        {
                $result=false;
                if ($this->_connection!=null)
                {
                        if ($this->_dictionary!='')
                        {
                                if ($this->_drivername=='borland_ibase')
                                {
                                        $q="CREATE TABLE $this->_dictionary (\n";
                                        $q.="  DICT_ID INTEGER NOT NULL,\n";
                                        $q.="  DICT_TABLENAME VARCHAR(60) CHARACTER SET NONE COLLATE NONE,\n";
                                        $q.="  DICT_FIELDNAME VARCHAR(60) CHARACTER SET NONE COLLATE NONE,\n";
                                        $q.="  DICT_PROPERTY VARCHAR(60) CHARACTER SET NONE COLLATE NONE,\n";
                                        $q.="  DICT_VALUE1 VARCHAR(60) CHARACTER SET NONE COLLATE NONE,\n";
                                        $q.="  DICT_VALUE2 VARCHAR(200) CHARACTER SET NONE COLLATE NONE);\n";
                                        $this->execute($q);

                                        $q="ALTER TABLE $this->_dictionary ADD PRIMARY KEY (DICT_ID);\n";
                                        $this->execute($q);

                                        $result=true;
                                }
                                else
                                {
                                        $q="CREATE TABLE $this->_dictionary (";
                                        $q.="  `dict_id` int(11) unsigned NOT NULL auto_increment,";
                                        $q.="  `dict_tablename` varchar(60) NULL,";
                                        $q.="  `dict_fieldname` varchar(60) NULL,";
                                        $q.="  `dict_property` varchar(60) NULL,";
                                        $q.="  `dict_value1` varchar(60) NULL,";
                                        $q.="  `dict_value2` text NULL,";
                                        $q.="  PRIMARY KEY (`dict_id`)";
                                        $q.=");";
                                        $this->execute($q);

                                        $result=true;
                                }
                        }
                }
                return($result);
        }

        /*
        private $_debug=0;

        function getDebug() { return $this->_debug; }
        function setDebug($value) { $this->_debug=$value; }
        function defaultDebug() { return 0; }

        //DriverName property
        function getDriverName() { return $this->_drivername;   }
        function setDriverName($value) { $this->_drivername=$value; }

        //Dictionary property
        function getDictionary() { return $this->_dictionary;   }
        function setDictionary($value) { $this->_dictionary=$value; }

        //DatabaseName property
        function getDatabaseName() { return $this->_databasename;       }
        function setDatabaseName($value) { $this->_databasename=$value; }

        //Host property
        function getHost() { return $this->_host;       }
        function setHost($value) { $this->_host=$value; }

        //User property
        function getUser() { return $this->_user;       }
        function setUser($value) { $this->_user=$value; }

        //Password property
        function getPassword() { return $this->_password;       }
        function setPassword($value) { $this->_password=$value; }

        //Connected property
        function getConnected() { return $this->_connected;     }
        function setConnected($value)
        {
                if ($value!=$this->_connected)
                {
                        $this->_connected=$value;

                        if (($this->ControlState & csLoading)!=csLoading)
                        {
                                if ($this->_connected) $this->open();
                                else $this->close();
                        }
          }
        }

        function loaded()
        {
                parent::loaded();

                if ($this->_connected) $this->open();
                else $this->close();
        }
        */

        /**
         * Opens the database
         *
         */
         /*
        function open()
        {
                if (($this->ControlState & csDesigning)!=csDesigning)
                {
                                global $ADODB_FETCH_MODE;
                                $ADODB_FETCH_MODE=ADODB_FETCH_ASSOC;

                        $this->_connection = ADONewConnection($this->DriverName);

                        $this->_connection->debug=$this->Debug;

                        if (($this->DriverName=='borland_ibase') || ($this->DriverName=='ibase'))
                        {
                                $result=$this->_connection->PConnect($this->DatabaseName,$this->User,$this->Password);
                        }
                        else
                        {
                                $result=$this->_connection->Connect($this->Host,$this->User,$this->Password,$this->DatabaseName);
                        }
                }
        }
        */

        /**
         * Return all the databases using the connection information
         *
         * @return array
         */
         /*
        function databases()
        {
                if ($this->_connection==null)
                {
                        $this->open();
                }

               return($this->_connection->MetaDatabases());
        }
        */

        /**
         * Return tables on this database
         *
         * @return array
         */
        function tables()
        {
                if ($this->_connection==null)
                {
                        $this->open();
                }
                return($this->_connection->MetaTables());
        }

        /**
         * Closes the database
         *
         */
         /*
        function close()
        {
                if ($this->_connection!=null)
                {
                        $this->_connection->Close();
                        $this->_connection=null;
                }
        }
        */

        /**
         * Executes a query
         *
         * @param string $query
         * @return object
         */
         /*
        function execute($query)
        {
                $this->open();
//                $this->_connection->debug=true;
                $rs=$this->_connection->Execute($query);
                if ($rs==null)
                {
                        throw new Exception("Query error: $query ".$this->_connection->ErrorMsg());
                }
                return($rs);
        }

        function dumpContents()
        {
                //Dump here connection code if any
        }
        */
}

/**
 * DBDataSet class
 *
 * Base Class for datasets linked to a database
 */
class DBDataSet extends DataSet
{
    public $_rs=null;
    protected $_database=null;
    protected $_params=array();

    function readDatabase() { return $this->_database; }
    function writeDatabase($value) { $this->_database=$this->fixupProperty($value); }
    function defaultDatabase() { return null; }

    function loaded()
    {
        $this->writeDatabase($this->_database);
        parent::loaded();
    }

    function readFields()
    {
        return($this->_rs->fields);
    }
    function readFieldCount() { return count($this->_rs->_numOfFields); }

    function readRecordCount()
    {
        if (assigned($this->_rs))
        {
            return($this->_rs->RecordCount());
        }
        else return(parent::readRecordCount());
    }

    function MoveBy($distance)
    {
        parent::MoveBy($distance);
        for($i=0;$i<=$distance-1;$i++)
        {
            if (!$this->_rs->EOF)
            {
                $this->_rs->MoveNext();
            }
        }
    }

    function readEOF()
    {
        return($this->_rs->EOF);
    }

    function CheckDatabase()
    {
        if (!is_object($this->_database)) DatabaseError(_("No Database assigned or is not an object"));
    }

    public $_keyfields=array();

    function InternalClose()
    {
        $this->_rs=null;
    }

    function InternalOpen()
    {
        if (($this->ControlState & csDesigning)!=csDesigning)
        {
            $query=$this->buildQuery();
            if (trim($query)=='') DatabaseError(_("Missing query to execute"));
            $this->CheckDatabase();

            if ((trim($this->_limitstart)=='-1') && (trim($this->_limitcount)=='-1'))
            {
                $this->_rs=$this->Database->Execute($query,$this->_params);
            }
            else
            {
                $limitstart=trim($this->_limitstart);
                if ($limitstart=='') $limitstart=-1;

                $limitcount=trim($this->_limitcount);
                if ($limitcount=='') $limitcount=-1;
                $this->_rs=$this->Database->ExecuteLimit($query,$limitcount,$limitstart);
            }

            $this->_keyfields=$this->readKeyFields();
            if (!is_array($this->_rs->fields))
            {
                if ($this->_tablename!='')
                {
                    $fd=$this->Database->MetaFields($this->_tablename);
                    $this->_rs->fields=$fd;
                }
            }
            $this->fieldbuffer=$this->_rs->fields;

        }
    }

    function InternalFirst()
    {
        $this->_rs->MoveFirst();

            if (!is_array($this->_rs->Fields))
            {
                if ($this->_tablename!='')
                {
                    $fd=$this->Database->MetaFields($this->_tablename);
                    $this->_rs->Fields=$fd;
                }
            }
    }

    function InternalLast()
    {
        $this->_rs->MoveLast();

            if (!is_array($this->_rs->Fields))
            {
                if ($this->_tablename!='')
                {
                    $fd=$this->Database->MetaFields($this->_tablename);
                    $this->_rs->Fields=$fd;
                }
            }
    }

    /**
    * Overriden to allow get field values as properties
    *
    * @param string $nm
    * @return mixed
    */
    function __get($nm)
    {
        if ($this->_rs!=null)
        {
            if ($this->Active)
            {
                if ((is_array($this->_rs->fields)) && (array_key_exists($nm,$this->_rs->fields)))
                {
                    if ($this->State==dsBrowse)
                    {
                        return ($this->_rs->fields[$nm]);
                    }
                    else if (array_key_exists($nm,$this->fieldbuffer))
                    {
                        return($this->fieldbuffer[$nm]);
                    }
                    else return('');
                }
                else if ((is_array($this->fieldbuffer)) && (array_key_exists($nm,$this->fieldbuffer)))
                {
                    return($this->fieldbuffer[$nm]);
                }
                else return(parent::__get($nm));

            }
            else
            {
                return(parent::__get($nm));
            }
         }
         else
         {
            return(parent::__get($nm));
         }
    }

    /**
    * Overriden to allow get field values as properties
    *
    * @param string $nm
    * @return mixed
    */
    function __set($nm,$val)
    {
        if ($this->_rs!=null)
        {
            if ($this->Active)
            {
                if ((is_array(($this->_rs->fields))) && (array_key_exists($nm,$this->_rs->fields)))
                {
                    $this->fieldbuffer[$nm]=$val;
                    $this->Modified=true;
                    if ($this->State==dsBrowse)
                    {
                        $this->State=dsEdit;
                    }
                }
                else parent::__set($nm, $val);
            }
            else
            {
                parent::__set($nm, $val);
            }
         }
         else
         {
            parent::__set($nm, $val);
         }
    }


}

/**
 * Table class
 *
 * A class to encapsulate a database table
 */
class CustomTable extends DBDataSet
{
        protected $_tablename="";

        function readTableName() { return $this->_tablename; }
        function writeTableName($value) { $this->_tablename=$value; }
        function defaultTableName() { return ""; }

        function InternalDelete()
        {
                $where='';
                reset($this->_keyfields);
                while(list($key, $fname)=each($this->_keyfields))
                {
                    $val=$this->fieldbuffer[$fname];
                    if (trim($val)=='') continue;
                    if ($where!='') $where.=" and ";
                    $where.=" $fname = ".$this->Database->QuoteStr($val);
                }

            if ($where!='')
            {
                $query="delete from $this->TableName where $where";
                $this->Database->Execute($query);
            }

        }

        /**
         * Get field properties
         *
         * @param string $fieldname
         * @return mixed
         */
        function readFieldProperties($fieldname)
        {
                if ($this->_database!=null)
                {
                        return($this->_database->readFieldDictionaryProperties($this->_tablename,$fieldname));
                }
                else return(false);
        }

        function InternalPost()
        {
            if ($this->State == dsEdit)
            {
                $where='';
                $buffer=$this->fieldbuffer;
                reset($this->_keyfields);
                while(list($key, $fname)=each($this->_keyfields))
                {
                    $val=$this->fieldbuffer[$fname];
                    unset($buffer[$fname]);
                    if (trim($val)=='') continue;
                    if ($where!='') $where.=" and ";
                    $where.=" $fname = ".$this->Database->QuoteStr($val);
                }


                try
                {
                    $updateSQL = $this->Database->_connection->AutoExecute($this->TableName, $buffer, 'UPDATE', $where);
                    $this->_rs->fields=array_merge($this->_rs->fields,$this->fieldbuffer);
                }
                catch (Exception $e)
                {
                    $this->_rs->fields=array_merge($this->_rs->fields,$this->fieldbuffer);
                    throw $e;
                }

                //TODO: Handle errors
            }
            else
            {
                $where='';
                if (is_array($this->_keyfields))
                {
                    reset($this->_keyfields);
                    while(list($key, $fname)=each($this->_keyfields))
                    {
                        unset($this->fieldbuffer[$fname]);
                    }
                }

                $insertSQL = $this->Database->_connection->AutoExecute($this->TableName, $this->fieldbuffer, 'INSERT');

                $this->_rs->fields=array_merge($this->_rs->fields,$this->fieldbuffer);
                //TODO: Handle errors
            }
        }


        function buildQuery()
        {
            if (($this->ControlState & csDesigning)!=csDesigning)
            {
                if (trim($this->_tablename)=='')
                {
                    if ($this->Active)
                    {
                        DatabaseError(_("Missing TableName property"));
                    }
                }
                $result="select * from $this->_tablename";
                $where="";
                if ($this->Filter!="") $where.=" $this->Filter ";
                if ($this->MasterSource!="")
                {
                    $this->writeMasterSource($this->_mastersource);
                    if (is_object($this->_mastersource))
                    {
                        if (is_array($this->_masterfields))
                        {
                            $ms="";
                            reset($this->_masterfields);

                            while(list($key, $val)=each($this->_masterfields))
                            {
                                $thisfield=$key;
                                $msfield=$val;

                                if ($ms!="") $ms.=" and ";
                                $ms.=" $thisfield=".$this->Database->QuoteStr($this->_mastersource->DataSet->$msfield)." ";
                            }

                            if ($ms!="")
                            {
                                if ($where!="") $where.=" and ";
                                $where.=" ($ms) ";
                            }
                        }
                    }
                }

                if ($where!="") $result.=" where $where ";
                return($result);
            }
            else return('');
        }

          /**
           * Return an array containg the row values
           *
           * @return array
           */
  function readAssociativeFieldValues()
  {
        $result=array();

        if ($this->Active)
        {
                return($this->_rs->fields);
        }

        return($result);
  }

        /**
        * Return an array with Key fields for the table
        */
        function readKeyFields()
        {
                //TODO: Check here for another indexes
                $result="";
                if ($this->_tablename!='')
                {
                $indexes=$this->Database->extractIndexes($this->_tablename,true);

                if (is_array($indexes))
                {
                    list(,$primary)=each($indexes);

                    $result=$primary['columns'];
                    if (is_array($result))
                    {
                        while (list($k,$v)=each($result))
                        {
                                $result[$k]=trim($v);
                        }
                    }
                }
                }
                return($result);
        }

        function dumpHiddenKeyFields($basename, $values=array())
        {
                $keyfields=$this->readKeyFields();

                if (empty($values))
                {
                        $values=$this->readAssociativeFieldValues();
                }

                if (is_array($keyfields))
                {
                    reset($keyfields);
                    while (list($k,$v)=each($keyfields))
                    {
                            echo "<input type=\"hidden\" name=\"".$basename."[$v]\" value=\"$values[$v]\" />";
                    }
                }
        }

    protected $_orderfield="";

    function readOrderField() { return $this->_orderfield; }
    function writeOrderField($value) { $this->_orderfield=$value; }
    function defaultOrderField() { return ""; }

    protected $_order="asc";

    function readOrder() { return $this->_order; }
    function writeOrder($value) { $this->_order=$value; }
    function defaultOrder() { return "asc"; }
}

/**
 * Table class
 *
 * A class to encapsulate a database table
 */
class Table extends CustomTable
{
        function getMasterSource() { return $this->readmastersource(); }
        function setMasterSource($value) { $this->writemastersource($value); }

        function getMasterFields() { return $this->readmasterfields(); }
        function setMasterFields($value) { $this->writemasterfields($value); }

        function getTableName() { return $this->readtablename(); }
        function setTableName($value) { $this->writetablename($value); }

        function getActive() { return $this->readactive(); }
        function setActive($value) { $this->writeactive($value); }

        function getDatabase() { return $this->readdatabase(); }
        function setDatabase($value) { $this->writedatabase($value); }

        function getFilter() { return $this->readfilter(); }
        function setFilter($value) { $this->writefilter($value); }

        function getOrderField() { return $this->readorderfield(); }
        function setOrderField($value) { $this->writeorderfield($value); }

        function getOrder() { return $this->readorder(); }
        function setOrder($value) { $this->writeorder($value); }


    function getOnBeforeOpen() { return $this->readonbeforeopen(); }
    function setOnBeforeOpen($value) { $this->writeonbeforeopen($value); }

    function getOnAfterOpen() { return $this->readonafteropen(); }
    function setOnAfterOpen($value) { $this->writeonafteropen($value); }

    function getOnBeforeClose() { return $this->readonbeforeclose(); }
    function setOnBeforeClose($value) { $this->writeonbeforeclose($value); }


    function getOnAfterClose() { return $this->readonafterclose(); }
    function setOnAfterClose($value) { $this->writeonafterclose($value); }

    function getOnBeforeInsert() { return $this->readonbeforeinsert(); }
    function setOnBeforeInsert($value) { $this->writeonbeforeinsert($value); }

    function getOnAfterInsert() { return $this->readonafterinsert(); }
    function setOnAfterInsert($value) { $this->writeonafterinsert($value); }

    function getOnBeforeEdit() { return $this->readonbeforeedit(); }
    function setOnBeforeEdit($value) { $this->writeonbeforeedit($value); }


    function getOnAfterEdit() { return $this->readonafteredit(); }
    function setOnAfterEdit($value) { $this->writeonafteredit($value); }

    function getOnBeforePost() { return $this->readonbeforepost(); }
    function setOnBeforePost($value) { $this->writeonbeforepost($value); }

    function getOnAfterPost() { return $this->readonafterpost(); }
    function setOnAfterPost($value) { $this->writeonafterpost($value); }

    function getOnBeforeCancel() { return $this->readonbeforecancel(); }
    function setOnBeforeCancel($value) { $this->writeonbeforecancel($value); }

    function getOnAfterCancel() { return $this->readonaftercancel(); }
    function setOnAfterCancel($value) { $this->writeonaftercancel($value); }

    function getOnBeforeDelete() { return $this->readonbeforedelete(); }
    function setOnBeforeDelete($value) { $this->writeonbeforedelete($value); }

    function getOnAfterDelete() { return $this->readonafterdelete(); }
    function setOnAfterDelete($value) { $this->writeonafterdelete($value); }

    function getOnDeleteError() { return $this->readondeleteerror(); }
    function setOnDeleteError($value) { $this->writeondeleteerror($value); }

}

/**
 * Table class
 *
 * A class to encapsulate a database table
 */
class CustomQuery extends CustomTable
{
        protected $_sql=array();

        //Query property
        function readSQL() { return $this->_sql;     }
        function writeSQL($value)
        {
                $clean=unserialize($value);
                if ($clean===false)
                {
                        $this->_sql=$value;
                }
                else
                {
                        $this->_sql=$clean;
                }
        }
        function defaultSQL() { return "";     }

        function Prepare()
        {
            $this->Database->Prepare($this->buildQuery());
        }

        function readParams() { return $this->_params; }
        function writeParams($value) { $this->_params=$value; }
        function defaultParams() { return ""; }

        function buildQuery()
        {
            if (($this->ControlState & csDesigning)!=csDesigning)
            {
                if (is_array($this->_sql))
                {
                    if (!empty($this->_sql))
                    {
                        $use_query_string=true;
                        $qu=implode(' ',$this->_sql);
                    }
                }
                else
                {
                    if ($this->_sql!="")
                    {
                        $qu=$this->_sql;
                    }
                }

                $order="";
                if ($this->_orderfield!="") $order="order by $this->_orderfield $this->_order";

                $filter="";
                if ($this->_filter!="") $filter=" where $this->_filter ";

                $result=$qu." $filter $order ";

                return($result);
            }
            else return('');
        }
}

/**
 * Table class
 *
 * A class to encapsulate a database table
 */
class Query extends CustomQuery
{
        function getSQL() { return $this->readsql(); }
        function setSQL($value) { $this->writesql($value); }

        function getParams() { return $this->readparams(); }
        function setParams($value) { $this->writeparams($value); }

        function getTableName() { return $this->readtablename(); }
        function setTableName($value) { $this->writetablename($value); }

        function getActive() { return $this->readactive(); }
        function setActive($value) { $this->writeactive($value); }

        function getDatabase() { return $this->readdatabase(); }
        function setDatabase($value) { $this->writedatabase($value); }

        function getFilter() { return $this->readfilter(); }
        function setFilter($value) { $this->writefilter($value); }

        function getOrderField() { return $this->readorderfield(); }
        function setOrderField($value) { $this->writeorderfield($value); }

        function getOrder() { return $this->readorder(); }
        function setOrder($value) { $this->writeorder($value); }
}

/**
 * StoredProc Class
 *
 * A component to call stored procedures
 */
class StoredProc extends CustomQuery
{
    protected $_storedprocname="";

    function getStoredProcName() { return $this->_storedprocname; }
    function setStoredProcName($value) { $this->_storedprocname=$value; }
    function defaultStoredProcName() { return ""; }

        function getActive() { return $this->readactive(); }
        function setActive($value) { $this->writeactive($value); }

        function getDatabase() { return $this->readdatabase(); }
        function setDatabase($value) { $this->writedatabase($value); }

        function getFilter() { return $this->readfilter(); }
        function setFilter($value) { $this->writefilter($value); }

        function getOrderField() { return $this->readorderfield(); }
        function setOrderField($value) { $this->writeorderfield($value); }

        function getOrder() { return $this->readorder(); }
        function setOrder($value) { $this->writeorder($value); }

        function getParams() { return $this->readparams(); }
        function setParams($value) { $this->writeparams($value); }

        function Prepare()
        {
            $this->Database->PrepareSP($this->buildQuery());
        }

        function buildQuery()
        {
            if (($this->ControlState & csDesigning)!=csDesigning)
            {
                    $pars="";

                    reset($this->_params);
                    while(list($key, $val)=each($this->_params))
                    {
                        if ($pars!="") $pars.=', ';
                        $pars.="'$val'";
                    }

                    if ($pars!="") $pars="($pars)";

                    $result="select * from $this->_storedprocname$pars";


                return($result);
            }
            else return('');
        }
}

?>
