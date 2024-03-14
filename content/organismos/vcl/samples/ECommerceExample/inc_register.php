<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        require_once("DbModule.php");
        use_unit("rawoutput.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");
        require_once( "common.inc.php" );

        //Class definition
        class Register extends Page
        {
            public $Email=null;
            public $RegMsg=null;
            public $Phone=null;
            public $Postcode=null;
            public $Country=null;
            public $State=null;
            public $City=null;
            public $Address=null;
            public $Name=null;
            public $Password=null;
            public $Username=null;
            public $SubmitButton=null;

            function RegisterShow($sender, $params)
            {
                $reg_data = array(
                    'Username'      => $this->Username->Text,
                    'Password'      => $this->Password->Text,
                    'Name'          => $this->Name->Text,
                    'Email'         => $this->Email->Text,
                    'Address'       => $this->Address->Text,
                    'City'          => $this->City->Text,
                    'State'         => $this->State->Text,
                    'Country'       => $this->Country->Text,
                    'Postcode'      => $this->Postcode->Text,
                    'Phone'         => $this->Phone->Text
                );

                $msg = '';

                foreach( $reg_data as $key => $value )
                {
                    if( empty( $value ) )
                    {
                        $msg .= $key . ' field must not be blank!<br>';
                        break;
                    }
                }

                if( empty( $msg ) )
                {
                    $query = "SELECT * FROM users WHERE Username = '" . mysql_real_escape_string( $this->Username->Text ) . "' OR Email = '" . mysql_real_escape_string( $this->Email->Text ) . "'";

                    GetDBModule()->Query1->close();

                    GetDBModule()->Query1->SQL = $query;

                    GetDBModule()->Query1->open();

                    if( GetDBModule()->Query1->RecordCount == 0 )
                    {
                        GetDBModule()->Query1->close();

                        $query = 'INSERT INTO users SET LoginID="", ';
                        $first = true;

                        foreach( $reg_data as $key => $value )
                        {
                            if( $first )
                                $first = false;
                            else
                                $query .= ', ';

                            $query .= "`" . $key . "` = '" . mysql_real_escape_string( $value ) . "'";
                        }

                        GetDBModule()->Query1->LimitStart = '-1';
                        GetDBModule()->Query1->LimitCount = '-1';
                        GetDBModule()->Query1->SQL = $query;

                        GetDBModule()->Query1->open();

                        GetDBModule()->Query1->close();

                        redirect_query( 'page=checkout&registered=1' );
                        exit();
                    }
                    else
                    {
                        $msg = "This account already exists. Are you sure that you haven't registered prior to this?";
                    }
                }

                if( isset( $_REQUEST[ 'submitted' ] ) )
                    $this->RegMsg->Value = $msg;
            }
        }

        global $application;

        global $Register;

        //Creates the form
        $Register=new Register($application);

        //Read from resource file
        $Register->loadResource(__FILE__);

        //Shows the form
        $Register->show();

?>
