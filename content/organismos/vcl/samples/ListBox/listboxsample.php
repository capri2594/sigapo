<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class ListBoxSample extends Page
        {
               public $Button1 = null;
               public $Edit1 = null;
               public $ListBox1 = null;
               function Button1Click($sender, $params)
               {               
                $this->ListBox1->AddItem($this->Edit1->Text);
               }

        }

        global $application;

        global $ListBoxSample;

        //Creates the form
        $ListBoxSample=new ListBoxSample($application);

        //Read from resource file
        $ListBoxSample->loadResource(__FILE__);

        //Shows the form
        $ListBoxSample->show();

?>
