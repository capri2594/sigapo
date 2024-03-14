<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class Index extends Page
        {
               public $Label2 = null;
               public $Button2 = null;
               public $Button1 = null;
               public $Label1 = null;
               public $Edit1 = null;
               function Button2Click($sender, $params)
               {
                    $this->Label2->Caption=_("This is english text");
               }

               function Button1Click($sender, $params)
               {
                    if ($this->Language=="(default)")
                    {
                        $this->Language="Spanish (Traditional Sort)";
                    }
                    else
                    {
                        $this->Language="(default)";
                    }

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
