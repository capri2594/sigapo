<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        use_unit("dbgrids.inc.php");
        use_unit("db.inc.php");
        use_unit("dbtables.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class Index extends Page
        {
               public $Label1 = null;
               public $Button1 = null;
               function Button1JSClick($sender, $params)
               {
                    //Dump the call using Ajax to the Button1Click event
                    echo $this->Button1->ajaxCall("Button1Click");
               ?>
                    //Return false to prevent the button submit the form
                    return(false);
               <?php
               }

               function Button1Click($sender, $params)
               {
                    $this->Button1->Caption="clicked Ajax ".date("Y-m-d H:i:s");
                    $this->Label1->Caption="Hello from Ajax!! ".date("Y-m-d H:i:s");
                    $this->Label1->Color="#".dechex(rand(0,0xFFFFFF));
               }

        }

        global $application;

        global $Index;

        //Creates the form
        $Index=new Index($application);

        //Read from resource file
        $Index->loadResource(__FILE__);

        //Shows the form
        $Index->show();

?>
