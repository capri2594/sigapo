<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        use_unit("rawoutput.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");
        require_once( "common.inc.php" );

        //Class definition
        class Login extends Page
        {
            public $Url = null;
            public $OrigPage=null;
            public $LoginMsg=null;
            public $LoginBtn=null;
            public $Password=null;
            public $Username=null;

            function LoginShow($sender, $params)
            {
                $u = $this->Username->Text;
                $p = $this->Password->Text;

                if( !empty( $u ) && !empty( $p ) )
                {
                    global $ECommerceMain;

                    if( $ECommerceMain->CurrentUserLogin->LoginUser( $u, $p ) )
                    {
                        redirect_query( 'page=' . $_REQUEST[ 'orig' ] );
                    }

                    $this->LoginMsg->Value = 'Failed to login. Are you sure that the username and password are correct?';
                }
                else if( !empty( $u ) || !empty( $p ) )
                {
                    $this->LoginMsg->Value = 'Failed to login. Are you sure that the username and password are correct?';
                }

                $this->OrigPage->Value = $_REQUEST[ 'orig' ];

                $this->Username->Text = '';
                $this->Password->Text = '';
            }
}

        global $application;

        global $Login;

        //Creates the form
        $Login=new Login($application);

        //Read from resource file
        $Login->loadResource(__FILE__);

        //Shows the form
        $Login->show();

?>
