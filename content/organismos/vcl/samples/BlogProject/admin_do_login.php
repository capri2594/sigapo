<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        require_once("admin_login.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");
        use_unit("rtl.inc.php");

        //Class definition
        class AdminDoLogin extends Page
        {
            public $Label4 = null;
            public $Button1=null;
            public $Edit2=null;
            public $Label3=null;
            public $Edit1=null;
            public $Label1=null;
            public $Label2=null;

            function Button1Click($sender, $params)
            {
                global $AdminLogin;

                // Try to login using the specified username and password.
                if( $AdminLogin->TryLogin( $this->Edit1->Text, $this->Edit2->Text ) )
                {
                    $this->Label4->Caption = '';

                    // Login succeeded, so redirect back to the main admin page.
                    redirect( "admin.php" );
                }
                else
                {
                    // Login failed, so update the message.
                    $this->Label4->Caption = 'Failed to login. Please check that you are using the correct username and password.';
                }
            }
        }

        global $application;

        global $AdminDoLogin;

        //Creates the form
        $AdminDoLogin=new AdminDoLogin($application);

        //Read from resource file
        $AdminDoLogin->loadResource(__FILE__);

        //Shows the form
        $AdminDoLogin->show();

?>
