<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        use_unit("dbctrls.inc.php");
        require_once("DbModule.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class CatalogForm extends Page
        {
        public $Label3=null;
        public $Label2=null;
        public $Label1=null;
        public $Image1=null;
        public $Catalog=null;
        
        protected $UniqueAddId = '';

        function CatalogFormCreate($sender, $params)
        {
            $this->Catalog->DataSource = GetDBModule()->Datasource1;

            $this->UniqueAddId = time();
        }

        function Label3BeforeShow($sender, $params)
        {
            $sender->Link = 'index.php?page=add&id=' . GetDBModule()->Table1->ID . '&uid=' . $this->UniqueAddId;
        }

        function Label2BeforeShow($sender, $params)
        {
            $sender->Caption = '$' . sprintf( "%01.2f", GetDBModule()->Table1->Price );
        }

        function Label1BeforeShow($sender, $params)
        {
            $sender->Caption = GetDBModule()->Table1->Name;
        }

        function Image1BeforeShow($sender, $params)
        {
            $sender->ImageSource = 'images/' . GetDBModule()->Table1->Image;
        }

}

        global $application;

        global $CatalogForm;

        //Creates the form
        $CatalogForm=new CatalogForm($application);

        //Read from resource file
        $CatalogForm->loadResource(__FILE__);

        //Shows the form
        $CatalogForm->show();

?>
