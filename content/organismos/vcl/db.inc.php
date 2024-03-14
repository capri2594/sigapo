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
use_unit("rtl.inc.php");


/**
 * Field class
 *
 * Encapsulates a table field
 */
class Field extends Object
{
        private $_fieldname;
        private $_displaylabel;

        //Fieldname property
        function getFieldName() { return $this->_fieldname;     }
        function setFieldName($value) { $this->_fieldname=$value; }

        //DisplayLabel property
        function getDisplayLabel() { return $this->_displaylabel;       }
        function setDisplayLabel($value) { $this->_displaylabel=$value; }
}

/*
* CustomConnection, a common ancestor for all Connection objects
*/
class CustomConnection extends Component
{

    protected $_datasets=null;
    protected $_fstreamedconnected=false;

    /*
    * List of attached DataSets
    */
    function readDataSets() { return $this->_datasets; }
    function writeDataSets($value) { $this->_datasets=$value; }
    function defaultDataSets() { return null; }

    protected $_clients=null;

    function MetaFields($tablename)
    {
    }

    function BeginTrans()
    {
        //To be overriden
    }

    function CompleteTrans($autocomplete=true)
    {
        //To be overriden    
    }



    /*
    * Send a connect event to all the datasets, both for connecting and disconnecting
    * @param $connecting boolean specifies the status of the connection
    */
    function SendConnectEvent($connecting)
    {
        for($i=0;$i<=$this->_clients->count()-1;$i++)
        {
            $client=$this->_clients->items[$i];
            if ($client->inheritsFrom('DataSet'))
            {
                $client->DataEvent(deConnectChange, $connecting);
            }
        }
    }

    function DBDate($input)
    {
        return($input);
    }

    function Prepare($query)
    {

    }

    function Param($input)
    {
        return($input);
    }

    function QuoteStr($input)
    {
        return($input);
    }

    function readClients() { return $this->_clients; }
    function writeClients($value) { $this->_clients=$value; }
    function defaultClients() { return null; }

    protected $_onafterconnect=null;

    function readOnAfterConnect() { return $this->_onafterconnect; }
    function writeOnAfterConnect($value) { $this->_onafterconnect=$value; }
    function defaultOnAfterConnect() { return null; }

    protected $_onbeforeconnect=null;

    function readOnBeforeConnect() { return $this->_onbeforeconnect; }
    function writeOnBeforeConnect($value) { $this->_onbeforeconnect=$value; }
    function defaultOnBeforeConnect() { return null; }

    protected $_onafterdisconnect=null;

    function readOnAfterDisconnect() { return $this->_onafterdisconnect; }
    function writeOnAfterDisconnect($value) { $this->_onafterdisconnect=$value; }
    function defaultOnAfterDisconnect() { return null; }

    protected $_onbeforedisconnect=null;

    function readOnBeforeDisconnect() { return $this->_onbeforedisconnect; }
    function writeOnBeforeDisconnect($value) { $this->_onbeforedisconnect=$value; }
    function defaultOnBeforeDisconnect() { return null; }

    protected $_onlogin=null;

    function readOnLogin() { return $this->_onlogin; }
    function writeOnLogin($value) { $this->_onlogin=$value; }
    function defaultOnLogin() { return null; }

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->_datasets=new Collection();
                $this->_clients=new Collection();
        }

        function Open()
        {
            $this->Connected=true;
        }


        function Close()
        {
            $this->Connected=false;
        }


        function loaded()
        {
                parent::loaded();
                if ($this->_fstreamedconnected)
                {
                    $this->Connected=true;
                }
        }

        //To be overriden by connection components
        function readConnected() { return "0"; }
        function writeConnected($value)
        {
            if (($this->ControlState & csLoading)==csLoading)
            {
                $this->_fstreamedconnected=$value;
            }
            else
            {
                if ($value == $this->readConnected())
                {
                }
                else
                {
                    if ($value)
                    {
                        $this->callEvent("onbeforeconnect",array());
                        $this->DoConnect();
                        $this->SendConnectEvent(true);
                        $this->callEvent("onafterconnect",array());
                    }
                    else
                    {
                        $this->callEvent("onbeforedisconnect",array());
                        $this->SendConnectEvent(false);
                        $this->DoDisconnect();
                        $this->callEvent("onafterdisconnect",array());
                    }
                }
            }
        }
        function defaultConnected() { return "0"; }

        function DoConnect()
        {
            //Override this
        }

        function DoDisconnect()
        {
            //Override this
        }
}


/**
 * DataSet class
 *
 * Base class to encapsulate a data set
 */
/*
class DataSet extends Component
{
        public $fields=null;
        private $_limitstart='0';
        private $_limitcount='10';

        //LimitStart property
        function getLimitStart() { return $this->_limitstart;   }
        function setLimitStart($value) { $this->_limitstart=$value;     }
        function defaultLimitStart() { return "0"; }

        function getLimitCount() { return $this->_limitcount;   }
        function setLimitCount($value) { $this->_limitcount=$value; }
        function defaultLimitCount() { return "10"; }

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->fields=new Collection();
        }

        function dumpContents()
        {
                //Dump here code if any
        }

        function readFields()
        {
        }

        function readFieldValues()
        {
        }

        function first()
        {
        }

        function next()
        {
        }
        
        function eof()
        {
        }
        
        function __get($nm)
  {
  }
  
  function __set($nm, $val)
  {
  }

}
*/

define('deFieldChange',1);
define('deRecordChange',2);
define('deDataSetChange',3);
define('deDataSetScroll',4);
define('deLayoutChange',5);
define('deUpdateRecord',6);
define('deUpdateState',7);
define('deCheckBrowseMode',8);
define('dePropertyChange',9);
define('deFieldListChange',10);
define('deFocusControl',11);
define('deParentScroll',12);
define('deConnectChange',13);
define('deReconcileError',14);
define('deDisabledStateChange',15);

define('dsInactive'    ,1);
define('dsBrowse'      ,2);
define('dsEdit'        ,3);
define('dsInsert'      ,4);
define('dsSetKey'      ,5);
define('dsCalcFields'  ,6);
define('dsFilter'      ,7);
define('dsNewValue'    ,8);
define('dsOldValue'    ,9);
define('dsCurValue'    ,10);
define('dsBlockRead'   ,11);
define('dsInternalCalc',12);
define('dsOpening'     ,13);

class EDatabaseError extends Exception { }

function DatabaseError($message, $component=null)
{
  if ((assigned($component)) && ($component->Name != ''))
  {
    throw new EDatabaseError(sprintf('%s: %s', $component->Name, $message));
  }
  else
  {
    throw new EDatabaseError($message);
  }
}

class DataSet extends Component
{
        protected $_limitstart='0';
        protected $_limitcount='10';

        //LimitStart property
        function getLimitStart() { return $this->_limitstart;   }
        function setLimitStart($value) { $this->_limitstart=$value;     }
        function defaultLimitStart() { return "0"; }

        function getLimitCount() { return $this->_limitcount;   }
        function setLimitCount($value) { $this->_limitcount=$value; }
        function defaultLimitCount() { return "10"; }

        function InternalClose() {}
        function InternalHandleException() {}
        function InternalInitFieldDefs() {}
        function InternalOpen() {}
        function IsCursorOpen() {}

        function readFields() { return array(); }
        function readFieldCount() { return 0; }

        /*
        * Buffer to hold values for searching/filtering
        */
        public $fieldbuffer=array();

        protected $_recordcount=0;
        protected $_state=dsInactive;
        protected $_modified=false;
        protected $_InternalOpenComplete=false;
        protected $_DefaultFields=false;
        protected $_DisableCount=0;

        protected $_datasetfield=null;

        function readDataSetField() { return $this->_datasetfield; }
        function writeDataSetField($value) { $this->_datasetfield=$value; }
        function defaultDataSetField() { return null; }

        function readState() { return $this->_state; }
        function writeState($value) { $this->_state=$value; }
        function defaultState() { return dsInactive; }

        protected $_mastersource=null;

        protected $_masterfields=array();

        function readMasterFields() { return $this->_masterfields; }
        function writeMasterFields($value) { $this->_masterfields=$value; }
        function defaultMasterFields() { return array(); }

        //MasterSource property
        function readMasterSource() { return $this->_mastersource;   }
        function writeMasterSource($value)
        {
                $this->_mastersource=$this->fixupProperty($value);
        }

        protected $_recno=0;

        function readRecNo() { return $this->_recno; }
        function writeRecNo($value)
        {
            if ($value!=$this->_recno)
            {
                $diff=$value-$this->_recno;
                if ($diff>0)
                {
                    $this->MoveBy($diff);
                }
                $this->_recno=$value;
            }
        }
        function defaultRecNo() { return 0; }

        protected $_reckey=array();

        function readRecKey() { return $this->_reckey; }
        function writeRecKey($value) { $this->_reckey=$value; }
        function defaultRecKey() { return ""; }



        function serialize()
        {
                parent::serialize();

                $owner = $this->readOwner();
                if ($owner != null)
                {
                        $prefix = $owner->readNamePath().".".$this->_name.".";
                        $_SESSION[$prefix."State"] = $this->_state;
//                        $_SESSION[$prefix."FieldBuffer"] = serialize($this->fieldbuffer);
//                        if (!empty($this->_regkey))
//                        {
//                            $_SESSION[$prefix."RegKey"] = serialize($this->_regkey);
//                        }
//                        $_SESSION[$prefix."RegKey"] = serialize($this->_regkey);
//                        $_SESSION[$prefix."RecNo"] = $this->_recno;
                }
        }

        function unserialize()
        {
                parent::unserialize();
                $owner = $this->readOwner();
                if ($owner != null)
                {
                        $prefix = $owner->readNamePath().".".$this->_name.".";
                        if (isset($_SESSION[$prefix."State"])) $this->_state= $_SESSION[$prefix."State"];
//                        if (isset($_SESSION[$prefix."FieldBuffer"])) $this->fieldbuffer= unserialize($_SESSION[$prefix."FieldBuffer"]);
//                        if (isset($_SESSION[$prefix."RegKey"])) $this->_regkey= unserialize($_SESSION[$prefix."RegKey"]);
//                        if (isset($_SESSION[$prefix."RecNo"]))
//                        {
//                            $this->RecNo= $_SESSION[$prefix."RecNo"];
//                        }
                }
        }

        function readModified() { return $this->_modified; }
        function writeModified($value) { $this->_modified=$value; }
        function defaultModified() { return false; }

        protected $_canmodify=true;

        function readCanModify() { return $this->_canmodify; }
        function writeCanModify($value) { $this->_canmodify=$value; }
        function defaultCanModify() { return true; }

        protected $_onbeforeopen=null;

        function readOnBeforeOpen() { return $this->_onbeforeopen; }
        function writeOnBeforeOpen($value) { $this->_onbeforeopen=$value; }
        function defaultOnBeforeOpen() { return null; }

        protected $_onafteropen=null;

        function readOnAfterOpen() { return $this->_onafteropen; }
        function writeOnAfterOpen($value) { $this->_onafteropen=$value; }
        function defaultOnAfterOpen() { return null; }

        protected $_onbeforeclose=null;

        function readOnBeforeClose() { return $this->_onbeforeclose; }
        function writeOnBeforeClose($value) { $this->_onbeforeclose=$value; }
        function defaultOnBeforeClose() { return null; }

        protected $_onafterclose=null;

        function readOnAfterClose() { return $this->_onafterclose; }
        function writeOnAfterClose($value) { $this->_onafterclose=$value; }
        function defaultOnAfterClose() { return null; }

        protected $_onbeforeinsert=null;

        function readOnBeforeInsert() { return $this->_onbeforeinsert; }
        function writeOnBeforeInsert($value) { $this->_onbeforeinsert=$value; }
        function defaultOnBeforeInsert() { return null; }

        protected $_onafterinsert=null;

        function readOnAfterInsert() { return $this->_onafterinsert; }
        function writeOnAfterInsert($value) { $this->_onafterinsert=$value; }
        function defaultOnAfterInsert() { return null; }

        protected $_onbeforeedit=null;

        function readOnBeforeEdit() { return $this->_onbeforeedit; }
        function writeOnBeforeEdit($value) { $this->_onbeforeedit=$value; }
        function defaultOnBeforeEdit() { return null; }

        protected $_onafteredit=null;

        function readOnAfterEdit() { return $this->_onafteredit; }
        function writeOnAfterEdit($value) { $this->_onafteredit=$value; }
        function defaultOnAfterEdit() { return null; }

        protected $_onbeforepost=null;

        function readOnBeforePost() { return $this->_onbeforepost; }
        function writeOnBeforePost($value) { $this->_onbeforepost=$value; }
        function defaultOnBeforePost() { return null; }

        protected $_onafterpost=null;

        function readOnAfterPost() { return $this->_onafterpost; }
        function writeOnAfterPost($value) { $this->_onafterpost=$value; }
        function defaultOnAfterPost() { return null; }

        protected $_onbeforecancel=null;

        function readOnBeforeCancel() { return $this->_onbeforecancel; }
        function writeOnBeforeCancel($value) { $this->_onbeforecancel=$value; }
        function defaultOnBeforeCancel() { return null; }

        protected $_onaftercancel=null;

        function readOnAfterCancel() { return $this->_onaftercancel; }
        function writeOnAfterCancel($value) { $this->_onaftercancel=$value; }
        function defaultOnAfterCancel() { return null; }

        protected $_onbeforedelete=null;

        function readOnBeforeDelete() { return $this->_onbeforedelete; }
        function writeOnBeforeDelete($value) { $this->_onbeforedelete=$value; }
        function defaultOnBeforeDelete() { return null; }

        protected $_onafterdelete=null;

        function readOnAfterDelete() { return $this->_onafterdelete; }
        function writeOnAfterDelete($value) { $this->_onafterdelete=$value; }
        function defaultOnAfterDelete() { return null; }

        protected $_oncalcfields=null;

        function readOnCalcFields() { return $this->_oncalcfields; }
        function writeOnCalcFields($value) { $this->_oncalcfields=$value; }
        function defaultOnCalcFields() { return null; }

        protected $_ondeleteerror=null;

        function readOnDeleteError() { return $this->_ondeleteerror; }
        function writeOnDeleteError($value) { $this->_ondeleteerror=$value; }
        function defaultOnDeleteError() { return null; }

        protected $_filter="";

        function readFilter() { return $this->_filter; }
        function writeFilter($value)
        {
            if ($value!=$this->_filter)
            {
                //$this->Close();
                $this->_filter=$value;
                //$this->Open();
            }
        }
        function defaultFilter() { return ""; }



        protected $_onfilterrecord=null;

        function readOnFilterRecord() { return $this->_onfilterrecord; }
        function writeOnFilterRecord($value) { $this->_onfilterrecord=$value; }
        function defaultOnFilterRecord() { return null; }

        protected $_onnewrecord=null;

        function readOnNewRecord() { return $this->_onnewrecord; }
        function writeOnNewRecord($value) { $this->_onnewrecord=$value; }
        function defaultOnNewRecord() { return null; }

        protected $_onposterror=null;

        function readOnPostError() { return $this->_onposterror; }
        function writeOnPostError($value) { $this->_onposterror=$value; }
        function defaultOnPostError() { return null; }


        function CheckOperation($Operation, $ErrorEvent)
        {
            $Done = false;
            do
            {
                try
                {
//                $this->UpdateCursorPos();
                  $this->$Operation();
                  $Done=true;
                }
                catch (EDatabaseError $e)
                {
                    $Action=daFail;
                    $Action=$this->callEvent($ErrorEvent, array('Exception'=>$e, 'Action'=>$Action));
                    if ($Action==daFail) throw $e;
                    if ($Action==daAbort) Abort();
                }

            }
            while(!$Done);
        }
        //***********************
        function DataEvent($event, $info)
        {
            $NotifyDataSources = !(($this->ControlsDisabled()) || ($this->State == dsBlockRead));

            switch($event)
            {
            /*
    deFieldChange:
      begin
        if TField(Info).FieldKind in [fkData, fkInternalCalc] then
          SetModified(True);
        UpdateCalcFields;
      end;
    deFieldListChange:
      FieldList.Updated := False;
    dePropertyChange:
      FieldDefs.Updated := False;
    deCheckBrowseMode:
      CheckNestedBrowseMode;
    deDataSetChange, deDataSetScroll:
      NotifyDetails;
    deLayoutChange:
      begin
        FieldList.Updated := False;
        if ControlsDisabled then
          FEnableEvent := deLayoutChange;
      end;
    deUpdateState:
      if ControlsDisabled then
      begin
        Event := deDisabledStateChange;
        Info := Integer(State <> dsInactive);
        NotifyDataSources := True;
        FEnableEvent := deLayoutChange;
      end;
      */
      }
        /*
        if ($NotifyDataSources)
        {
            for I := 0 to FDataSources.Count - 1 do
              TDataSource(FDataSources[I]).DataEvent(Event, Info);
        }
        */
        }

        function CheckActive()
        {
            if ($this->State == dsInactive) DatabaseError(_("Cannot perform this operation on a closed dataset"), $this);
        }

        function CheckCanModify()
        {
            if (!$this->CanModify) DatabaseError(_("Cannot modify a read-only dataset", Self));
        }

        function ControlsDisabled()
        {
            return($this->_DisableCount!=0);
        }

        function DisableControls()
        {
            if ($this->_DisableCount == 0)
            {
                $this->_DisableState=$this->State;
                $this->_EnableEvent=deDataSetChange;
            }
            $this->_DisableCount++;
        }

        function EnableControls()
        {
            if ($this->_DisableCount!=0)
            {
                $this->_DisableCount--;
                if ($this->_DisableCount==0)
                {
                    if ($this->_DisableState!=$this->State) $this->DataEvent(deUpdateState, 0);
                    if (($this->_DisableState!=dsInactive) && ($this->_State != dsInactive)) $this->DataEvent($this->_EnableEvent, 0);
                }
            }
        }

        function ClearBuffers()
        {
            $this->_recordcount = 0;
//            $this->_activerecord = 0;
//            $this->_currentrecord = -1;
            $this->_bof = true;
            $this->_eof = true;
            $this->fieldbuffer=array();
        }

        function BeginInsertAppend()
        {
            $this->CheckBrowseMode();
            $this->CheckCanModify();
            $this->callEvent('onbeforeinsert', array());
            $this->CheckParentState();
        }

        function EndInsertAppend()
        {
            $this->State=dsInsert;
            try
            {
                $this->callEvent('onnewrecord',array());
            }
            catch (Exception $e)
            {
                $this->UpdateCursorPos();
                $this->FreeFieldBuffers();
                $this->State=dsBrowse;
                throw $e;
            }
            $this->_modified = false;
            $this->DataEvent(deDataSetChange, 0);
            $this->callEvent('onafterinsert',array());
        }

        //***********************
        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);
        }

        function Insert()
        {
            $this->BeginInsertAppend();
            //OldCurrent := Bookmark;
            //MoveBuffer(FRecordCount, FActiveRecord);
            //Buffer := ActiveBuffer;
            //InitRecord(Buffer);
            //if FRecordCount = 0 then
            //SetBookmarkFlag(Buffer, bfBOF) else
            //SetBookmarkData(Buffer, Pointer(OldCurrent));
            //if FRecordCount < FBufferCount then Inc(FRecordCount);
            $this->InternalInsert();
            $this->EndInsertAppend();
        }

        function Append()
        {
                $this->BeginInsertAppend();
                $this->ClearBuffers();
                $this->InitRecord(Buffer);
                $this->_recordcount = 1;
                $this->_bof = False;
//                $this->GetPriorRecords();
                $this->InternalInsert();
                $this->EndInsertAppend();
        }

        function Cancel()
        {
            switch($this->State)
            {
                case dsEdit:
                case dsInsert:
                {
                    $this->DataEvent(deCheckBrowseMode, 0);
                    $this->callEvent("onbeforecancel",array());
//                    $DoScrollEvents = ($this->State == dsInsert);
//                    if ($DoScrollEvents) $this->DoBeforeScroll();
//                    $this->UpdateCursorPos();
                    $this->InternalCancel();
                    $this->fieldbuffer=array();
                    $this->State=dsBrowse;
                    //$this->Resync([]);
                    $this->callEvent("onaftercancel",array());
//                    if ($DoScrollEvents) $this->DoAfterScroll();
                    break;
                }
            }
        }

        function UpdateRecord()
        {
            if (($this->State!=dsEdit) && ($this->State!=dsInsert) && ($this->State!=dsSetKey)) DatabaseError(_("Dataset not in edit or insert mode"), $this);
            $this->DataEvent(deUpdateRecord,0);
        }

        function CheckBrowseMode()
        {
            $this->CheckActive();
            $this->DataEvent(deCheckBrowseMode, 0);
            switch($this->State)
            {
                case dsEdit:
                case dsInsert:
                {
                    $this->UpdateRecord();
                    if ($this->Modified) $this->post();
                    else $this->cancel();
                    break;
                }
                case dsSetKey:
                {
                    $this->post();
                    break;
                }
            }
        }

        function Close()
        {
            $this->Active=false;
        }

        function Delete()
        {
            $this->CheckActive();
            if (($this->State==dsInsert) || ($this->State==dsSetKey)) $this->Cancel();
            else
            {
                if ($this->Recordcount==0) DatabaseError(_("Cannot perform this operation on an empty dataset"), Self);
                $this->DataEvent(deCheckBrowseMode, 0);
                $this->callevent("onbeforedelete",array());
                $this->CheckOperation("InternalDelete", "ondeleteerror");
                $this->fieldbuffer=array();
                $this->State=dsBrowse;
                $this->callevent("onafterdelete",array());
            }
        }

        function CheckParentState()
        {
            if ($this->DataSetField != null) $this->DataSetField->DataSet->Edit();
        }

        function Edit()
        {
            if ((($this->State==dsEdit) || ($this->State==dsInsert)))
            {
            }
            else
            {
//                if ($this->_recordcount==0) $this->Insert();
//                else
//                {
                    $this->CheckBrowseMode();
                    $this->CheckCanModify();
                    $this->callevent("onbeforeedit",array());
                    $this->CheckParentState();
                    $this->CheckOperation("InternalEdit", "onediterror");
//                    $this->GetCalcFields(ActiveBuffer);
                    $this->State=dsEdit;
                    $this->DataEvent(deRecordChange, 0);
                    $this->callevent("onafteredit",array());
//                }
            }
        }

        function readRecordCount()
        {
            return $this->_recordcount;
        }
        function defaultRecordCount() { return 0; }



        function First()
        {
            $this->CheckBrowseMode();
            $FReopened = false;
            /*
            if IsUniDirectional then begin
                if not BOF then begin             // Need to Close and Reopen dataset: (Midas)
                    Active := False;
                    Active := True;
                end;
                FReopened := True
            end
            else ClearBuffers;
            */
            $this->ClearBuffers();
            try
            {
                $this->InternalFirst();
                //if not FReopened then begin
                //$this->GetNextRecord();
                //$this->GetNextRecords();
                //end;
            }
            catch (Exception $e)
            {
                $this->_bof = true;
                $this->DataEvent(deDataSetChange, 0);
                throw $e;
            }

            $this->_bof = true;
            $this->DataEvent(deDataSetChange, 0);
        }


        function DoInternalOpen()
        {
            $this->_DefaultFields = ($this->FieldCount == 0);
            $this->InternalOpen();
            $this->_InternalOpenComplete = true;
            //$this->UpdateBufferCount();
            $this->_bof = true;
        }

        function OpenCursor($InfoQuery= False)
        {
            if ($InfoQuery) $this->InternalInitFieldDefs();
            else if ($this->State!=dsOpening) $this->DoInternalOpen();
        }

        function OpenCursorComplete()
        {
            try
            {
                if ($this->State == dsOpening) $this->DoInternalOpen();
            }
            catch(Exception $e)
            {
                if ($this->_InternalOpenComplete)
                {
                    $this->State=dsBrowse;
                    $this->callEvent("onafteropen", array());
                }
                else
                {
                    $this->State=dsInactive;
                    $this->CloseCursor();
                }
                throw $e;
            }
            if ($this->_InternalOpenComplete)
            {
                if ($this->_state==dsInactive) $this->_state=dsBrowse;
                $this->callEvent("onafteropen", array());
            }
            else
            {
                $this->State=dsInactive;
                $this->CloseCursor();
            }
        }

        function CloseCursor()
        {
//            BlockReadSize := 0;
            $this->_InternalOpenComplete = false;
//            FreeFieldBuffers;
//            ClearBuffers;
//            SetBufListSize(0);
            $this->InternalClose();
//            FBufferCount := 0;
//            FDefaultFields := False;
        }

        function InternalFirst()
        {
        }

        function InternalLast()
        {
        }

        function InitRecord($Buffer)
        {
            $this->InternalInitRecord($Buffer);
//            $this->ClearCalcFields($Buffer);
//            $this->SetBookmarkFlag($Buffer, bfInserted);
        }

        function InternalInitRecord($buffer)
        {
        }

        function InternalAddRecord($buffer, $append)
        {
        }

        function InternalDelete()
        {
        }

        function InternalPost()
        {
//            $this->CheckRequiredFields();
        }

        function InternalCancel()
        {
        }

        function InternalEdit()
        {
        }

        function InternalInsert()
        {
        }

        function InternalRefresh()
        {
        }

        function Last()
        {
            //$this->CheckBiDirectional();
            $this->CheckBrowseMode();
            $this->ClearBuffers();
            try
            {
                $this->InternalLast();
//                $this->GetPriorRecord();
//                $this->GetPriorRecords();
            }
            catch (Exception $e)
            {
                $this->_eof = true;
                $this->DataEvent(deDataSetChange, 0);
                throw $e;
            }

            $this->_eof = true;
            $this->DataEvent(deDataSetChange, 0);
        }

        function Refresh()
        {
            $this->Active=false;
            $this->Active=true;
        }


        function Next()
        {
//            if ($this->BlockReadSize > 0) $this->BlockReadNext();
//            else
              $this->MoveBy(1);
              if (!$this->EOF) $this->fieldbuffer=$this->_rs->fields;
        }

        function Open()
        {
            $this->Active=true;
        }

        function Post()
        {
            $this->UpdateRecord();
            switch ($this->State)
            {
                case dsEdit:
                case dsInsert:
                {
                    $this->DataEvent(deCheckBrowseMode, 0);
                    $this->callevent("onbeforepost",array());
                    $this->CheckOperation("InternalPost", "onposterror");
                    $this->fieldbuffer=array();
                    //$this->FreeFieldBuffers();
                    $this->State=dsBrowse;
                    $this->callevent("onafterpost",array());
                    break;
                }
            }
        }

        function MoveBy($distance)
        {
            $this->_recno+=$distance;
        }

        function Prior()
        {
            $this->MoveBy(-1);
        }

        function readActive()
        {
            if (($this->State==dsInactive) || ($this->State==dsOpening) || ($this->_rs==null))
            {
                return(0);
            }
            else return(true);
        }

        protected $_fstreamedactive=false;

        function loaded()
        {
            parent::loaded();
            $this->writeMasterSource($this->_mastersource);
            if ($this->_fstreamedactive)
            {
                $this->Active=true;
            }
        }

        function writeActive($value)
        {
            if (($this->ControlState & csLoading)==csLoading)
            {
                $this->_fstreamedactive=$value;
            }
            else
            {
                if ($this->Active != $value)
                {
                    if ($value==true)
                    {
                        $this->callevent("onbeforeopen",array());
                        try
                        {
                            $this->OpenCursor();
                            if ($this->State!=dsOpening)
                            {
                                $this->OpenCursorComplete();
                            }
                        }
                        catch (Exception $e)
                        {
                            if ($this->State!=dsOpening)
                            {
                                $this->OpenCursorComplete();
                            }
                            throw $e;
                        }
                    }
                    else
                    {
                        $this->callevent("onbeforeclose",array());
                        $this->State=dsInactive;
                        $this->CloseCursor();
                        $this->callevent("onafterclose",array());
                    }
                }
            }
        }

        function defaultActive() { return "0"; }


        protected $_bof=false;
        protected $_eof=false;

        function readBOF() { return $this->_bof; }
        function defaultBOF() { return false; }

        function readEOF() { return $this->_eof; }
        function defaultEOF() { return false; }
}

/**
 * Datasource class
 *
 * A class to link controls with datasets
 */
class Datasource extends Component
{
        protected $_dataset;

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);
        }

        //Dataset property
        function getDataSet() { return $this->_dataset; }
        function setDataSet($value)
        {
                $this->_dataset=$this->fixupProperty($value);
        }

        function loaded()
        {
                parent::loaded();
                $this->setDataSet($this->_dataset);
        }
}

?>
