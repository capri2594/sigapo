<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        require_once("admin_login.php");
        use_unit("db.inc.php");
        use_unit("dbtables.inc.php");
        use_unit("dbctrls.inc.php");
        use_unit("dbgrids.inc.php");
        require_once("blog_db.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class AdminComments extends Page
        {
            public $Label10 = null;
            public $Label9=null;
            public $Label8=null;
            public $Label7=null;
            public $Label6=null;
            public $Label5=null;
            public $Label4=null;
            public $Label3=null;
            public $DBRepeater1=null;
            public $Panel1=null;
            public $Label1=null;
            public $Label2=null;

            private $BlogID = '';

            function Label10BeforeShow($sender, $params)
            {
                // Setup the link to the edit comment form.
                $sender->link = "admin_edit_comment.php?bid=" . $this->BlogID;
            }

            function AdminCommentsCreate($sender, $params)
            {
                global $BlogDB;

                // Make sure that the user is a logged in administrator.
                GetAdminLogin()->EnsureLogin();

                // Check that a valid blog post ID was sent.
                if( !isset( $_REQUEST[ 'id' ] ) || !strlen( $_REQUEST[ 'id' ] ) )
                    throw new Exception( "ID not specified" );

                // Store the blog post id.
                $this->BlogID = $_REQUEST[ 'id' ];

                // Setup DBRepeater1's Datasource to use the comments table datasource.
                $this->DBRepeater1->DataSource = $BlogDB->CommentsDatasource1;

                // Filter the comments table, so that it only shows the comments that are associated with the requested blog id.
                $BlogDB->CommentsTable1->Filter = "BlogID = '" . mysql_real_escape_string( $this->BlogID ) . "'";

                // Sort the comments table by the ID field, so the comments appear in the order they were posted.
                $BlogDB->CommentsTable1->OrderField = 'ID';

                // Open the comments table.
                $BlogDB->CommentsTable1->open();
            }

            function Label8BeforeShow($sender, $params)
            {
                global $BlogDB;

                // Setup the delete comment link.
                $sender->link = "admin_delete_comment.php?id=" . $BlogDB->CommentsTable1->ID . "&bid=" . $this->BlogID;
            }

            function Label6BeforeShow($sender, $params)
            {
                global $BlogDB;
                
                // Setup the edit comment link.
                $sender->link = "admin_edit_comment.php?id=" . $BlogDB->CommentsTable1->ID . "&bid=" . $this->BlogID;
            }
        }

        global $application;

        global $AdminComments;

        //Creates the form
        $AdminComments=new AdminComments($application);

        //Read from resource file
        $AdminComments->loadResource(__FILE__);

        //Shows the form
        $AdminComments->show();

?>
