<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        require_once("DbModule.php");
        use_unit("userlogin.inc.php");
        use_unit("rawinclude.inc.php");
        use_unit("rawoutput.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");
        require_once( 'configure.php' );

        //Class definition
        class Admin extends Page
        {
            public $CurrentUserLogin = null;
            public $PageContent = null;
            public $PageTitle = null;

            function AdminCreate($sender, $params)
            {
                global $SiteName;

                $this->PageTitle->Value = $SiteName;

                $this->CurrentUserLogin->Database = GetDBModule()->Database1;
                $this->CurrentUserLogin->UserTable = 'admins';

                $page = $_REQUEST[ 'page' ];

                if( $this->CurrentUserLogin->GetLoggedInUser() === false )
                    $page = 'login';

                $page_map = array(
                    'add'       => 'catalog',
                    'delete'    => 'catalog',
                    'catalog'   => 'catalog',
                    'login'     => 'login',
                    'orders'    => 'orders',
                    'view'      => 'view'
                );

                if( array_key_exists( $page, $page_map ) )
                {
                    $page = $page_map[ $page ];
                }
                else
                {
                    $page = 'home';
                }

                $this->PageContent->Include = 'inc_admin_' . $page . '.php';
            }
        }

        global $application;

        global $Admin;

        //Creates the form
        $Admin=new Admin($application);

        //Read from resource file
        $Admin->loadResource(__FILE__);

        //Shows the form
        $Admin->show();

?>
