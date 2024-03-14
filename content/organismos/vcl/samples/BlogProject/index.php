<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        require_once("blog_db.php");
        use_unit("db.inc.php");
        use_unit("dbctrls.inc.php");
        use_unit("dbgrids.inc.php");
        use_unit("dbtables.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");
                                                                           
        //Class definition
        class Blogs extends Page
        {
            public $Label1 = null;
            public $Label2=null;
            public $Panel5=null;
            public $Panel1=null;
            public $Label4=null;
            public $Label5=null;
            public $Panel4=null;
            public $Label3=null;
            public $Panel3=null;
            public $DBRepeater1=null;
            public $Panel2=null;

            function Label5BeforeShow($sender, $params)
            {
                global $BlogDB;

                $sender->link = 'blog.php?id=' . $BlogDB->BlogsTable1->ID;
            }


            function Label3BeforeShow($sender, $params)
            {
                global $BlogDB;

                $content = $BlogDB->BlogsTable1->Content;

                // Only show first line.
                $i = strpos( $content, "<br />" );
                if( $i )
                    $content = substr( $content, 0, $i );

                $content = str_replace( '&nbsp;', ' ', $content );

                $content = trim( substr( $content, 0, 256 ) ) . "...";

                $sender->Caption = $content;
            }

            function BlogCreate($sender, $params)
            {
                global $BlogDB;

                $BlogDB->BlogsTable1->open();

                $this->DbRepeater1->DataSource = $BlogDB->BlogsDatasource1;
            }
        }

        global $application;

        global $Blogs;

        //Creates the form
        $Blogs=new Blogs($application);

        //Read from resource file
        $Blogs->loadResource(__FILE__);

        //Shows the form
        $Blogs->show();

?>
