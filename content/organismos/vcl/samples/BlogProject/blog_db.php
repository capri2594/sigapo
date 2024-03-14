<?php
        require_once("vcl/vcl.inc.php");
        require_once("configure.php");
        use_unit("db.inc.php");
        use_unit("dbtables.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class BlogDB extends DataModule
        {
            public $Query1 = null;
            public $CommentsDatasource1 = null;
            public $BlogsDatasource1 = null;
            public $CommentsTable1 = null;
            public $BlogsTable1 = null;
            public $Database1=null;
        }

        global $application;

        global $BlogDB;

        //Creates the form
        $BlogDB=new BlogDB($application);

        //Read from resource file
        $BlogDB->loadResource(__FILE__);

        $BlogDB->Database1->DatabaseName = $DbName;
        $BlogDB->Database1->Host = $DbHost;
        $BlogDB->Database1->UserName = $DbUser;
        $BlogDB->Database1->UserPassword = $DbPass;
        $BlogDB->Database1->Connected = true;

        $BlogDB->BlogsTable1->Filter = '';
        $BlogDB->CommentsTable1->Filter = '';

        $BlogDB->BlogsTable1->close();
        $BlogDB->CommentsTable1->close();

?>
