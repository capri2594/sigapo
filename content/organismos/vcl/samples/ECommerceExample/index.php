<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        use_unit("rawinclude.inc.php");
        use_unit("dbctrls.inc.php");
        use_unit("userlogin.inc.php");
        use_unit("rawoutput.inc.php");
        use_unit("dbtables.inc.php");
        require_once("DbModule.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");
        require_once( 'configure.php' );

        //Class definition
        class ECommerceMain extends Page
        {
        public $PageContent=null;
        
        public $Label1=null;
        public $Image1=null;
        public $AdBar=null;
        public $CurrentUserLogin=null;
        public $PageTitle=null;
        
        function ECommerceMainCreate($sender, $params)
        {
            global $SiteName;

            $this->PageTitle->Value = $SiteName;
            $this->CurrentUserLogin->Database = GetDBModule()->Database1;
            $this->CurrentUserLogin->UserTable = 'users';

            $page = $_REQUEST[ 'page' ];

            $this->CurrentUserLogin->LoginLink = 'index.php?page=login&orig=' . $page;
            $this->CurrentUserLogin->LogoutLink = 'index.php?page=logout';

            if( $page == 'logout' )
                $this->CurrentUserLogin->LogoutUser();

            $page_map = array(
                'catalog'   => 'catalog',
                'add'       => 'cart',
                'delete'    => 'cart',
                'cart'      => 'cart',
                'update'    => 'cart',
                'checkout'  => 'checkout',
                'login'     => 'login',
                'logout'    => 'logout',
                'register'  => 'register',
                'order'     => 'order'
            );

            if( array_key_exists( $page, $page_map ) )
            {
                $page = $page_map[ $page ];
            }
            else
            {
                $page = 'home';
            }

            $this->PageContent->Include = 'inc_' . $page . '.php';
        }

        function Label2BeforeShow($sender, $params)
        {
        }

        function Label1BeforeShow($sender, $params)
        {
            GetDBModule()->Query1->close();

            GetDBModule()->Query1->SQL = "SELECT * FROM products WHERE `ID` = '" . GetDBModule()->AdTable1->Product . "'";
            GetDBModule()->Query1->open();

            $sender->Caption = GetDBModule()->Query1->Name . ' @ $' . sprintf( "%01.2f", GetDBModule()->Query1->Price );

            GetDBModule()->Query1->close();
        }

        function Image1BeforeShow($sender, $params)
        {
            GetDBModule()->Query1->close();

            GetDBModule()->Query1->SQL = "SELECT * FROM products WHERE `ID` = '" . GetDBModule()->AdTable1->Product . "'";
            GetDBModule()->Query1->open();

            $sender->ImageSource = 'images/' . GetDBModule()->Query1->Image;
            // $sender->Link = 'product.php?ID=' . GetDBModule()->Query1->ID;

            GetDBModule()->Query1->close();
        }

}

        global $application;

        global $ECommerceMain;

        //Creates the form
        $ECommerceMain=new ECommerceMain($application);

        //Read from resource file
        $ECommerceMain->loadResource(__FILE__);

        //Shows the form
        $ECommerceMain->show();

?>
