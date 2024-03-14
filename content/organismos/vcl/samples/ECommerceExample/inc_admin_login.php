<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        use_unit("rawoutput.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");
        require_once("common.inc.php");

        //Class definition
        class AdminLogin extends Page
        {
            public $Url = null;
            public $Password = null;
            public $Username = null;
            public $LoginBtn = null;
            public $LoginMsg = null;
            
            function AdminLoginShow($sender, $params)
            {
                $u = $this->Username->Text;
                $p = $this->Password->Text;

                if( !empty( $u ) && !empty( $p ) )
                {
                    global $Admin;

                    if( $Admin->CurrentUserLogin->LoginUser( $u, $p ) )
                    {
                        redirect_query( 'page=' );
                        return;
                    }

                    $this->LoginMsg->Value = 'Failed to login. Are you sure that the username and password are correct?';
                }
                else if( !empty( $u ) || !empty( $p ) )
                {
                    $this->LoginMsg->Value = 'Failed to login. Are you sure that the username and password are correct?';
                }
            }
        }

        global $application;

        global $AdminLogin;

        //Creates the form
        $AdminLogin=new AdminLogin($application);

        //Read from resource file
        $AdminLogin->loadResource(__FILE__);

        //Shows the form
        $AdminLogin->show();

?>
