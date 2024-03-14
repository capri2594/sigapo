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

use_unit("grids.inc.php");
use_unit("comctrls.inc.php");

/**
 * CustomDBGrid class
 *
 * Base class for DBGrids
 */
class CustomDBGrid extends CustomGrid
{
        protected $_database;
        protected $_deletelink='';

        function getDeleteLink() { return $this->_deletelink; }
        function setDeleteLink($value) { $this->_deletelink=$value; }
        function defaultDeleteLink() { return ""; }

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width=400;
                $this->Height=200;
        }
}

/**
 * DBGrid class
 *
 * A component to show a dataset in a tabular way
 */
 /*
class DBGrid extends CustomDBGrid
{
        protected $_datasource=null;

                function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);
        }

        function dumpHeaderCode()
        {
                parent::dumpHeaderCode();
?>
<script type="text/JavaScript">
<!--
function verifydelete()
{
var agree=confirm("¿Seguro que quieres borrar este registro?");
if (agree)
        return true ;
else
        return false ;
}

//-->
</script>
<?php
        }

        //TODO: Datasource must link with controls to update their state when the dataset changes
        function updateControl()
        {
                $this->columns->clear();
                $this->rows->clear();
                                
                if ($this->_datasource!=null)
                {
                        $ds=$this->_datasource->DataSet;

                        if ($ds->Active)
                        {
                                for ($i=0;$i<=$ds->fields->count()-1;$i++)
                                {
                                        $fld=$ds->fields->items[$i];
                                        $col=new Column();
                                        $col->Title=$fld->DisplayLabel;
                                        $this->columns->add($col);
                                        //print_r($fld);
                                }

                                $col=new Column();
                                $col->Title="&nbsp;";
                                $this->columns->add($col);

                                $ds->first();

                                while (!$ds->eof())
                                {

                                        $row=new Row();
                                        $row->values=$ds->readFieldValues();
                                        $record_id=$row->values[0];
                                        $row->values[]='<A onclick="return verifydelete();" HREF="'.$this->_deletelink.'&record_id='.$record_id.'">Borrar</A>';
                                        $this->rows->add($row);
                                        $ds->next();
                                }
                        }
                }
        }

        function getFont() { return $this->readFont(); }
        function setFont($value) { $this->writeFont($value); }

        function loaded()
        {
                parent::loaded();
                $this->setDataSource($this->_datasource);
        }

        //DataSource property
        function getDataSource() { return $this->_datasource;   }
        function setDataSource($value)
        {
                $this->_datasource=$this->fixupProperty($value);
        }

        function dumpContents()
        {
                //Dump here code if any
                $this->updateControl();
                parent::dumpContents();
        }
}
*/

/**
 * DBGrid class
 *
 * A component to show a dataset in a tabular way
 */
class DBGrid extends CustomListView
{
        //Publish common properties
        function getVisible() { return $this->readVisible(); }
        function setVisible($value) { $this->writeVisible($value); }
        
        protected $_datasource=null;
        private $_latestheader=null;

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width=400;
                $this->Height=200;
                $this->ControlStyle="csSlowRedraw=1";
        }

        function init()
        {
                parent::init();

                //Include the RPC to handle any request
                use_unit("rpc/rpc.inc.php");
        }

        /**
        * To give permission to execute certain methods
        */
        function readAccessibility($method, $defaccessibility)
        {
                switch($method)
                {
                case "updateRow": return Accessibility_Domain;
                }

                return(parent::readAccessibility($method, $defaccessibility));
        }

        /**
        *  RPC method
        */
        function updateRow($params, $error)
        {
                if (count($params) != 4)
                {
                    $error->SetError(JsonRpcError_ParameterMismatch, "Expected 4 parameter; got " . count($params));
                    return $error;
                }
                else
                {
                        $fieldnames=$params[0];
                        $fieldvalues=$params[1];
                        $origvalues=$params[2];
                        $dbgridrow=$params[3];

                        reset($fieldnames);
                        reset($fieldvalues);

                        if ($this->_datasource!=null)
                        {
                                if ($this->_datasource->Dataset!=null)
                                {
                                        if ($this->_datasource->Dataset->Database!=null)
                                        {
                                                try
                                                {
                                                    //Get an array with the keys and fields to change
                                                    $output=array();

                                                    $keys=$this->_datasource->DataSet->_keyfields;
                                                    while (list($k,$v)=each($fieldnames))
                                                    {
                                                        if ((in_array($v,$keys)) || ($fieldvalues[$k]!=$origvalues[$k]))
                                                        {
                                                            $output[$v]=$fieldvalues[$k];
                                                        }
                                                    }
                                                    $this->_datasource->DataSet->edit();
                                                    $this->_datasource->DataSet->fieldbuffer=$output;
                                                    $this->_datasource->DataSet->Post();
                                                }
                                                catch (Exception $e)
                                                {
                                                        $error->SetError(-104, 'Caught exception: '.$e->getMessage());
                                                        return $error;
                                                }
                                                return $dbgridrow;
                                        }
                                        else
                                        {
                                            $error->SetError(-103, "Datasource->Dataset->Database not assigned");
                                            return $error;
                                        }
                                }
                                else
                                {
                                    $error->SetError(-102, "Datasource->Dataset not assigned");
                                    return $error;
                                }
                        }
                        else
                        {
                            $error->SetError(-101, "Datasource not assigned");
                            return $error;
                        }
                }

                return -1;

        }

        function dumpRPC()
        {
            if (($this->ControlState & csDesigning)!=csDesigning)
            {
?>
                function <?php echo $this->Name; ?>_rpcdatachanged(event)
                {

<?php
                        if (($this->_jsondatachanged!="") && ($this->_jsondatachanged!=null))
                        {
                                echo $this->_jsondatachanged."(event);\n";
                        }
?>
                        var obj;
                        obj=this;
                        data=event.getData();
                        modifiedRow=data.firstRow;

                        row=this.getRowData(modifiedRow);
                        orow=this.originalData[modifiedRow];

                        qx.Settings.setCustomOfClass("qx.io.Json", "enableDebug", true);

                        var rpc = new qx.io.remote.Rpc();
                        rpc.setTimeout(10000);
                        var mycall = null;
                        rpc.setUrl("<?php echo $_SERVER['PHP_SELF']; ?>");
                        rpc.setServiceName("<?php echo $this->owner->Name; ?>.<?php echo $this->Name; ?>");
                        rpc.setCrossDomain(false);

                        mycall = rpc.callAsync
                        (
                                function(result, ex, id)
                                {
                                    mycall = null;
                                    event=new Object();
                                    event.result=result;
                                    event.ex=ex;
                                    event.id=id;

                                    if (result>=0)
                                    {
                                        if (obj)
                                        {
                                            row=obj.getRowData(result);
                                            if (row)
                                            {
                                                obj.originalData[result]=row.slice();
                                            }
                                        }
                                    }
<?php
                                        if (($this->_jsonrowsaved!="") && ($this->_jsonrowsaved!=null))
                                        {
                                                echo $this->_jsonrowsaved."(event);";
                                        }
?>
                                    send.setEnabled(true);
                                    abort.setEnabled(false);
                                }
                        , "updateRow", this.ColumnNames, row, orow, modifiedRow
                        );
                }
<?php
            }
        }

        function createTableModel()
        {
?>
            // table model
            var <?php echo $this->Name; ?>_tableModel = new qx.ui.table.SimpleTableModel();
<?php
        }
        //TODO: Datasource must link with controls to update their state when the dataset changes
        function updateControl()
        {
            if (($this->ControlState & csDesigning)!=csDesigning)
            {
                //Ensure there is a valid datasource
                $this->setDataSource($this->_datasource);

                if (is_object($this->_datasource))
                {
                        $ds=$this->_datasource->DataSet;

                        if ($ds->Active)
                        {
                            $ds->first();
                            $fields=$ds->Fields;

//        $this->createTableModel();
?>
        <?php echo $this->Name; ?>_tableModel.setColumns([
<?php
        if (is_array($fields))
        {
        reset($fields);
        $i=0;
        while(list($fname, $value)=each($fields))
        {
                $props=$this->_datasource->DataSet->readFieldProperties($fname);
                $dlabel=$fname;

                if ($props)
                {
                        if (array_key_exists('displaylabel',$props))
                        {
                                $dlabel=$props['displaylabel'][0];
                        }
                }

                if ($i>0) echo ",";
                echo '"'.$dlabel.'"';
                $i++;
        }
        }
?>
 ]);


        <?php echo $this->Name; ?>_tableModel.ColumnNames=new Array(
<?php
        $cnames=$ds->Fields;
        if (is_array($cnames))
        {
        reset($cnames);
        $i=0;
        while(list($fname, $value)=each($cnames))
        {
                if ($i>0) echo ",";
                echo '"'.$fname.'"';
                $i++;
        }
        }
?>
);



        var rowData = [];
        var oData = [];
<?php

                                $ds->first();
                                while (!$ds->EOF)
                                {
                                        $rvalues=$ds->Fields;
?>
                        rowData.push([
                        <?php
                                        reset($rvalues);
                                        $i=0;
                                        while (list($k,$v)=each($rvalues))
                                        {
                                                $v=str_replace("\n\r",'\n',$v);
                                                $v=str_replace("\n",'\n',$v);
                                                $v=str_replace("\r",'',$v);
                                                $v=str_replace('"','\"',$v);
                                                $v=str_replace('<','\<',$v);
                                                $v=str_replace('>','\>',$v);
//                                                $v=htmlentities($v);
                                                if ($i>0) echo ",";
                                                echo '"'.$v.'"';
                                                $i++;

                                        }
                        ?>
                        ]);
                        oData.push([
                        <?php
                                        reset($rvalues);
                                        $i=0;
                                        while (list($k,$v)=each($rvalues))
                                        {
                                                $v=str_replace("\n\r",'\n',$v);
                                                $v=str_replace("\n",'\n',$v);
                                                $v=str_replace("\r",'',$v);
                                                $v=str_replace('"','\"',$v);
                                                $v=str_replace('<','\<',$v);
                                                $v=str_replace('>','\>',$v);
//                                                $v=htmlentities($v);
                                                if ($i>0) echo ",";
                                                echo '"'.$v.'"';
                                                $i++;

                                        }
                        ?>
                        ]);
                        <?php
                                        $ds->next();
                                }

?>
        <?php echo $this->Name; ?>_tableModel.originalData=oData;
        <?php echo $this->Name; ?>_tableModel.setData(rowData);
<?php
        $this->_latestheader=$fields;
        if (is_array($fields))
        {
            reset($fields);
            $i=0;
            while(list($fname, $value)=each($fields))
            {
?>
            <?php echo $this->Name; ?>_tableModel.setColumnEditable(<?php echo $i; ?>, true);
<?php
            $i++;
            }


        }
                      }
                }
            }
        }

        function getFont() { return $this->readFont(); }
        function setFont($value) { $this->writeFont($value); }

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

            protected $_jsondatachanged=null;

            function getjsOnDataChanged() { return $this->_jsondatachanged; }
            function setjsOnDataChanged($value) { $this->_jsondatachanged=$value; }
            function defaultjsOnDataChanged() { return ""; }

            protected $_jsonrowsaved=null;

            function getjsOnRowSaved() { return $this->_jsonrowsaved; }
            function setjsOnRowSaved($value) { $this->_jsonrowsaved=$value; }
            function defaultjsOnOnRowSaved() { return ""; }

            protected $_jsonrowchanged=null;

            function getjsOnRowChanged() { return $this->_jsonrowchanged; }
            function setjsOnRowChanged($value) { $this->_jsonrowchanged=$value; }
            function defaultjsOnOnRowChanged() { return ""; }

        function getjsOnClick                   () { return $this->readjsOnClick(); }
        function setjsOnClick                   ($value) { $this->writejsOnClick($value); }

        function getjsOnDblClick                () { return $this->readjsOnDblClick(); }
        function setjsOnDblClick                ($value) { $this->writejsOnDblClick($value); }

          /**
         * Dump Javascript events
         *
         */
        function dumpJsEvents()
        {
                parent::dumpJsEvents();
                $this->dumpJSEvent($this->_jsondatachanged);
                $this->dumpJSEvent($this->_jsonrowsaved);
                $this->dumpJSEvent($this->_jsonrowchanged);
        }


        function commonScript()
        {
                echo "        ".$this->Name.".setBorder(qx.renderer.border.BorderPresets.getInstance().shadow);\n";
                echo "        ".$this->Name.".setBackgroundColor(\"white\");\n";
                echo "        $this->Name.setLeft(0);\n";
                echo "        $this->Name.setTop(0);\n";
//                echo "        $this->Name.setOverflow(\"auto\");\n";
                echo "        $this->Name.setWidth($this->Width);\n";
                echo "        $this->Name.setHeight($this->Height);\n";
                echo "        $this->Name.getSelectionModel().setSelectionMode(qx.ui.table.SelectionModel.MULTIPLE_INTERVAL_SELECTION);\n";


            $fields=$this->_latestheader;

            if (is_array($fields))
            {
                reset($fields);
                $i=0;
                while(list($fname, $value)=each($fields))
                {
                    $props=$this->_datasource->DataSet->readFieldProperties($fname);
                    $dwidth=100;

                    if ($props)
                    {
                            if (array_key_exists('displaywidth',$props))
                            {
                                    $dwidth=$props['displaywidth'][0];
                            }
                    }

                    echo "        $this->Name.getTableColumnModel().setColumnWidth($i,$dwidth);\n";
                $i++;
                }
            }
        }

        function dumpContents()
        {
                $this->dumpCommonContentsTop();
                $this->createTableModel();
                $this->updateControl();
                echo "        var ".$this->Name."    = new qx.ui.table.Table(".$this->Name."_tableModel);\n";
                $this->commonScript();
                $this->callEvent('onshow', array());

                if (($this->ControlState & csDesigning)!=csDesigning)
                {
                        $this->dumpRPC();

                        echo "        ".$this->Name."_tableModel.addEventListener(\"dataChanged\", ".$this->Name."_rpcdatachanged, ".$this->Name."_tableModel);\n";

                        if (($this->_jsonclick!="") && ($this->_jsonclick!=null))
                        {
                                echo "        $this->Name.addEventListener(\"click\", $this->_jsonclick);\n";
                        }

                        if (($this->_jsonrowchanged!="") && ($this->_jsonrowchanged!=null))
                        {
                                echo "        $this->Name.getSelectionModel().addEventListener(\"changeSelection\", $this->_jsonrowchanged);\n";
                        }

                        if (($this->_jsondblclick!="") && ($this->_jsondblclick!=null))
                        {
                                echo "        $this->Name.addEventListener(\"dblclick\", $this->_jsondblclick);\n";
                        }
                }

                $this->dumpCommonContentsBottom();
        }

        //If the component must be updated for Ajax, which script do we need to execute?
        function dumpForAjax()
        {
                $this->updateControl();
                $this->commonScript();
        }
}

?>
