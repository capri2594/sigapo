<?php
require_once("vcl/vcl.inc.php");
use_unit("db.inc.php");
use_unit("dbtables.inc.php");
use_unit("forms.inc.php");
use_unit("extctrls.inc.php");
use_unit("stdctrls.inc.php");
require_once( 'configure.php' );

//Class definition
class DBModule extends DataModule
{
    public $Table2 = null;
    public $Datasource1=null;
    public $Table1=null;
    public $AdDatasource1=null;
    public $Query1=null;
    public $AdTable1=null;
    public $Database1=null;
}

global $application;

global $DBModule;

//Creates the form
$DBModule=new DBModule($application);

//Read from resource file
$DBModule->loadResource(__FILE__);

$DBModule->Database1->Host = $DbHost;
$DBModule->Database1->UserName = $DbUser;
$DBModule->Database1->UserPassword = $DbPass;
$DBModule->Database1->DatabaseName = $DbName;
$DBModule->Database1->Connected = true;
$DBModule->Table2->Active = true;
$DBModule->Table1->Active = true;
$DBModule->AdTable1->Active = true;

function GetDBModule()
{
    global $DBModule;

    return $DBModule;
}
?>
