<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        use_unit("rtl.inc.php");
        use_unit("comctrls.inc.php");
        use_unit("dbtables.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");
        require_once("blog_db.php");

        //Class definition
        class AddComment extends Page
        {
            public $id = null;
            public $Panel11=null;
            public $Button2=null;
            public $Button1=null;
            public $Memo1=null;
            public $Label3=null;
            public $Edit1=null;
            public $Label2=null;

            function Button2Click($sender, $params)
            {
                // Redirect back to the blog post page.
                redirect( 'blog.php?id=' . $this->id->Value );
            }


            function AddCommentCreate($sender, $params)
            {
                // Read the blog post ID off the HTTP request.
                $this->id->Value = $_REQUEST[ 'id' ];
            }

            function Button1Click($sender, $params)
            {
                global $BlogDB;

                // Check to see that the user has entered valid data.
                if( strlen( $this->Edit1->Text ) && strlen( $this->Memo1->Text ) )
                {
                    // Convert the text that the user entered into valid HTML.
                    $content = textToHtml( $this->Memo1->Text );

                    // Append a new record to the comments database, associating this comment with the blog post ID.
                    $BlogDB->CommentsTable1->open();
                    $BlogDB->CommentsTable1->append();
                    $BlogDB->CommentsTable1->BlogID = $this->id->Value;
                    $BlogDB->CommentsTable1->Author = $this->Edit1->Text;
                    $BlogDB->CommentsTable1->Posted = date( 'YmdHis' );
                    $BlogDB->CommentsTable1->Content = $content;
                    $BlogDB->CommentsTable1->post();
                    $BlogDB->CommentsTable1->close();

                    // Clear the fields so that if the user adds another comments, the fields will start empty.
                    $this->Edit1->Text = '';
                    $this->Memo1->Text = '';

                    // Redirect back to the blog post page.
                    redirect( 'blog.php?id=' . $this->id->Value );
                }
            }
        }

        global $application;

        global $AddComment;

        //Creates the form
        $AddComment=new AddComment($application);

        //Read from resource file
        $AddComment->loadResource(__FILE__);

        //Shows the form
        $AddComment->show();

?>
