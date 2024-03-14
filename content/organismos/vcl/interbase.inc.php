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

/**
 * IBDatabase class
 *
 * A database component for InterBase
 */
class IBDatabase extends CustomConnection
{
        public $_connection=null;
        protected $_debug=0;
        protected $_databasename="";
        protected $_host="";
        protected $_username="";
        protected $_userpassword="";
        protected $_connected="0";
        protected $_dictionary="";
        protected $_dictionaryproperties=false;

        function MetaFields($tablename)
        {
            $metaColumnsSQL = "select a.rdb\$field_name from rdb\$relation_fields a, rdb\$fields b where a.rdb\$field_source = b.rdb\$field_name and a.rdb\$relation_name = '%s' order by a.rdb\$field_position asc";

            $rs = $this->Execute(sprintf($metaColumnsSQL,strtoupper($tablename)));
            $result=array();
            while ($row=ibase_fetch_row($rs))
            {
                $result[$row[0]]='';
            }
            return($result);
        }

        function BeginTrans($args=array())
        {
            ibase_trans($args,$this->_connection);
        }

        function CompleteTrans($autocomplete=true)
        {
            if ($autocomplete)
            {
                ibase_commit($this->_connection);
            }
            else ibase_rollback($this->_connection);
        }

        function readConnected() { if ($this->_connection!=null) return("1"); else return("0"); }

        function getConnected() { return $this->readconnected(); }
        function setConnected($value) { $this->writeconnected($value); }


        function getDebug() { return $this->_debug; }
        function setDebug($value) { $this->_debug=$value; }
        function defaultDebug() { return 0; }

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

        function getOnAfterConnect() { return $this->readonafterconnect(); }
        function setOnAfterConnect($value) { $this->writeonafterconnect($value); }

        function getOnBeforeConnect() { return $this->readonbeforeconnect(); }
        function setOnBeforeConnect($value) { $this->writeonbeforeconnect($value); }

        function getOnAfterDisconnect() { return $this->readonafterdisconnect(); }
        function setOnAfterDisconnect($value) { $this->writeonafterdisconnect($value); }

        function getOnBeforeDisconnect() { return $this->readonbeforedisconnect(); }
        function setOnBeforeDisconnect($value) { $this->writeonbeforedisconnect($value); }

        protected $_dialect=3;

        function getDialect() { return $this->_dialect; }
        function setDialect($value) { $this->_dialect=$value; }
        function defaultDialect() { return 3; }

        function Prepare($query)
        {
            ibase_prepare($this->_connection, $query);
        }

        function PrepareSP($query)
        {
            ibase_prepare($this->_connection, $query);
        }

        function DBDate($input)
        {
            return(date('%Y-%m-%d',strtotime($input)));
        }

        function Param($input)
        {
            return($this->QuoteStr($input));
        }

        function QuoteStr($input)
        {
            return("'$input'");
        }

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);
        }


        /**
         * Executes a query
         *
         * @param string $query
         * @return object
         */
        function execute($query,$params=array())
        {
                $this->open();
                $rs = @ibase_query ($this->_connection, $query);
                if ($rs===false)
                {
                        DatabaseError("Error executing query: $query [".ibase_errmsg()."]");
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
                $sql=$query;

                if ($numrows > 0)
                {
                    if ($offset <= 0) $str = " ROWS $numrows ";
                    else
                    {
                        $a = $offset+1;
                        $b = $offset+$numrows;
                        $str = " ROWS $a TO $b";
                    }
                }
                else
                {
                    // ok, skip
                    $a = $offset + 1;
                    $str = " ROWS $a TO 999999999"; // 999 million
                }

                $sql .= $str;

                return($this->execute($sql));
        }

        function DoConnect()
        {
            if (($this->ControlState & csDesigning)!=csDesigning)
            {
                $this->_connection = ibase_pconnect ($this->DatabaseName, $this->UserName, $this->UserPassword,'ISO8859_1', '100', $this->Dialect);

                if (!$this->_connection)
                {
                    DatabaseError("Cannot connect to database server");
                }
            }
        }

        function DoDisconnect()
        {
                if ($this->_connection!=null)
                {
                        ibase_close ($this->_connection);
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
                if ($this->_connected)
                {
                        if ($this->_dictionary!='')
                        {
                                $q="select * from $this->_dictionary where dict_tablename='$table' and dict_fieldname='$field'";
                                $r=$this->execute($q);
                                $props=array();
                                while ($arow=ibase_fetch_assoc($r))
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
            $table = strtoupper($table);
            $sql = "SELECT * FROM RDB\$INDICES WHERE RDB\$RELATION_NAME = '".$table."'";

            if (!$primary)
            {
                $sql .= " AND RDB\$INDEX_NAME NOT LIKE 'RDB\$%'";
            }
            else
            {
                $sql .= " AND RDB\$INDEX_NAME NOT LIKE 'RDB\$FOREIGN%'";
            }

            $rs=$this->execute($sql);

            $indexes = array();
            while ($row = ibase_fetch_row($rs))
            {
                $index = $row[0];
                if (!isset($indexes[$index]))
                {
                    if (is_null($row[3]))
                    {
                        $row[3] = 0;
                    }

                    $indexes[$index] = array(
                             'unique' => ($row[3] == 1),
                             'columns' => array()
                     );
                }

                $sql = "SELECT * FROM RDB\$INDEX_SEGMENTS WHERE RDB\$INDEX_NAME = '".$index."' ORDER BY RDB\$FIELD_POSITION ASC";
                $rs1 = $this->execute($sql);

                while ($row1 = ibase_fetch_row($rs1))
                {
                    $indexes[$index]['columns'][$row1[2]] = $row1[1];
                }
            }
            return $indexes;
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
                if ($this->_connected)
                {
                        if ($this->_dictionary!='')
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
                        }
                }
                return($result);
        }

        /**
         * Return all the databases using the connection information
         *
         * @return array
         */
        function databases()
        {
            return false;
        }

        /**
         * Return tables on this database
         *
         * @return array
         */
        function tables($ttype=false,$showSchema=false,$mask=false)
        {
                $metaTablesSQL = "select rdb\$relation_name from rdb\$relations where rdb\$relation_name not like 'RDB\$%'";

                $false = false;
                if ($mask)
                {
                        return $false;
                }

                if ($metaTablesSQL)
                {
                        $rs = $this->execute($metaTablesSQL);
                        if ($rs === false) return $false;

                        $rr=array();
                        while ($arr = ibase_fetch_row($rs))
                        {
                            $rr[]=$arr[0];
                        }
                        return $rr;
                }
                return $false;
        }
}

/**
 * IBDataSet class
 *
 * Base Class for datasets linked to a database
 */
class IBDataSet extends DataSet
{
    public $_rs=null;

    protected $_eof=false;
    public $_buffer=array();

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

    function readFields() { return($this->_buffer); }
    function readFieldCount() { return count($this->_buffer); }

    function readRecordCount()
    {
        if (assigned($this->_rs))
        {
            return(-1);
        }
        else return(parent::readRecordCount());
    }

    function MoveBy($distance)
    {
        parent::MoveBy($distance);

        for($i=0;$i<=$distance-1;$i++)
        {
            $this->_eof=!($buff=ibase_fetch_assoc($this->_rs));
        }
        if (!$this->_eof) $this->_buffer=$buff;
    }

    function readEOF()
    {
        return($this->_eof);
    }

    function CheckDatabase()
    {
        if (!is_object($this->_database)) DatabaseError(_("No Database assigned or is not an object"));
    }

    public $_keyfields=array();

    function InternalOpen($lquery="")
    {
        if (($this->ControlState & csDesigning)!=csDesigning)
        {
            if ($lquery!="") $query=$lquery;
            else $query=$this->buildQuery();
            if (trim($query)=='') DatabaseError(_("Missing query to execute"));
            $this->CheckDatabase();
            $this->_eof=false;

            if ((trim($this->_limitstart)=='-1') && (trim($this->_limitcount)=='-1'))
            {
                $this->_rs=$this->Database->Execute($query,$this->_params);
                $this->_buffer=array();
                $this->MoveBy(1);
            }
            else
            {
                $limitstart=trim($this->_limitstart);
                if ($limitstart=='') $limitstart=-1;

                $limitcount=trim($this->_limitcount);
                if ($limitcount=='') $limitcount=-1;

                $this->_rs=$this->Database->ExecuteLimit($query,$limitcount,$limitstart);
                $this->_buffer=array();
                $this->MoveBy(1);
            }

            if ((!is_array($this->_buffer)) || (count($this->_buffer)==0))
            {
                if ($this->_tablename!='')
                {
                    $fd=$this->Database->MetaFields($this->_tablename);
                    $this->_buffer=$fd;
                }
            }
            $this->_keyfields=$this->readKeyFields();
            $this->fieldbuffer=$this->_buffer;
        }
    }

    function InternalFirst()
    {
        $this->InternalClose();
        $this->InternalOpen($this->_lastquery);
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
                if ((is_array($this->_buffer)) && (array_key_exists($nm,$this->_buffer)))
                {
                    if ($this->State==dsBrowse)
                    {
                        return ($this->_buffer[$nm]);
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
                if ((is_array(($this->_buffer))) && (array_key_exists($nm,$this->_buffer)))
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
 * CustomIBTable class
 *
 * A class to encapsulate a database table
 */
class CustomIBTable extends IBDataSet
{
        protected $_tablename="";
        protected $_lastquery="";

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

                $set="";
                reset($buffer);
                while(list($key, $fname)=each($buffer))
                {
                    if ($set!="") $set.=", ";
                    $set.=" $key = '$fname' ";
                }


                try
                {
                    $updateSQL="update $this->TableName set $set where $where";
                    $this->Database->execute($updateSQL);
                    $this->_buffer=array_merge($this->_buffer,$this->fieldbuffer);
                }
                catch (Exception $e)
                {
                    $this->_buffer=array_merge($this->_buffer,$this->fieldbuffer);
                    throw $e;
                }

                //TODO: Handle errors
            }
            else
            {
                $fields='';
                $values='';
                if (is_array($this->_keyfields))
                {
                    reset($this->_keyfields);
                    while(list($key, $fname)=each($this->_keyfields))
                    {
                        unset($this->fieldbuffer[$fname]);
                    }
                }

                reset($this->fieldbuffer);
                while(list($key, $val)=each($this->fieldbuffer))
                {
                        if ($fields!='') $fields.=',';
                        $fields.='$key';

                        if ($values!='') $values.=',';
                        $values.=$this->Database->QuoteStr($val);
                }

                try
                {
                    $insertSQL="insert into $this->TableName($fields) values ($values)";
                    $this->Database->execute($insertSQL);
                    $this->_buffer=array_merge($this->_buffer,$this->fieldbuffer);
                }
                catch (Exception $e)
                {
                    $this->_buffer=array_merge($this->_buffer,$this->fieldbuffer);
                    throw $e;
                }
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
                $qu="select * from $this->_tablename";

                $order="";
                if ($this->_orderfield!="") $order="order by $this->_orderfield $this->_order";

                $where="";
                if ($this->Filter!="") $where.=" $this->Filter ";

                if ($this->MasterSource!="")
                {
                    $this->writeMasterSource($this->_mastersource);
                    if (is_object($this->_mastersource))
                    {
                        if (is_array($this->_masterfields))
                        {
                            $this->_mastersource->DataSet->open();

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

                if ($where!="") $where=" where $where ";

                $result=$qu." $where $order ";

                $this->_lastquery=$result;
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
                return($this->_buffer);
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
//**************************************************************

//TODO: Abstract more this class into Dataset (i.e. active, open, etc)
/**
 * IBTable class
 *
 * A class to encapsulate an interbase table
 */
class IBTable extends CustomIBTable
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

class CustomIBQuery extends CustomIBTable
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
 * Query class
 *
 * A class to encapsulate a database table
 */
class IBQuery extends CustomIBQuery
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
 * IBStoredProc Class
 *
 * A component to call stored procedures
 */
class IBStoredProc extends CustomIBQuery
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
