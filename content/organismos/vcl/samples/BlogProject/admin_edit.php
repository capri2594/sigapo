<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        use_unit("rtl.inc.php");
        require_once("admin_login.php");
        use_unit("comctrls.inc.php");
        use_unit("db.inc.php");
        use_unit("dbtables.inc.php");
        require_once("blog_db.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class AdminEdit extends Page
        {
            public $id = null;
            public $Button2=null;
            public $Button1=null;
            public $Memo1=null;
            public $Label3=null;
            public $Edit1=null;
            public $Label1=null;
            public $Label2=null;

            function Button2Click($sender, $params)
            {
                // Edit post Cancel button clicked, so redirect back to the main admin page.
                redirect( "admin.php" );
                exit();
            }

            function Button1Click($sender, $params)
            {
                global $BlogDB;

                // Convert the text the user entered into valid HTML.
                $content = textToHtml( $this->Memo1->Text );

                print( "start '" . $content . "' end " );

                if( strlen( $this->id->Value ) )
                {
                    // The ID was specified, so we update the blog.

                    // Start by locating the post in the database.
                    $BlogDB->BlogsTable1->Filter = "ID = '" . mysql_real_escape_string( $this->id->Value ) . "'";
                    $BlogDB->BlogsTable1->open();
                }
                else
                {
                    // The ID wasn't specified, so we add the blog post.

                    // Start by opening the table, and switching to insert mode.
                    $BlogDB->BlogsTable1->open();
                    $BlogDB->BlogsTable1->append();

                    // Only new posts set the date.
                    $BlogDB->BlogsTable1->Posted = date( 'YmdHis' );
                }

                // Update the record information.
                $BlogDB->BlogsTable1->Title = $this->Edit1->Text;
                $BlogDB->BlogsTable1->Content = $content;

                // Post changes to the record.
                $BlogDB->BlogsTable1->post();
                $BlogDB->BlogsTable1->close();

                // Redirect to the admin page.
                redirect( "admin.php" );
            }

            function AdminEditCreate($sender, $params)
            {
                // Make sure that the user is a logged in administrator.
                GetAdminLogin()->EnsureLogin();

                // Retrieve the blog post ID.
                $this->id->Value = $_REQUEST[ 'id' ];
            }

            function AdminEditStartBody($sender, $params)
            {
                global $BlogDB;

                // Check whether a valid blog post ID was retrieved.
                if( strlen( $this->id->Value ) )
                {
                    // A valid ID was retrieved, so enter edit mode.
                    $BlogDB->BlogsTable1->Filter = "ID = '" . mysql_real_escape_string( $this->id->Value ) . "'";
                    $BlogDB->BlogsTable1->open();

                    $this->Edit1->Text = $BlogDB->BlogsTable1->Title;
                    $this->Memo1->Text = htmlToText( $BlogDB->BlogsTable1->Content );

                    $BlogDB->BlogsTable1->close();
                }
                else
                {
                    // No valid ID retrieved, so enter add mode.
                    $this->Edit1->Text = '';
                    $this->Memo1->Clear();
                }
            }
        }

        global $application;

        global $AdminEdit;

        //Creates the form
        $AdminEdit=new AdminEdit($application);

        //Read from resource file
        $AdminEdit->loadResource(__FILE__);

        //Shows the form
        $AdminEdit->show();

?>
