<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class Unit203 extends Page
        {
               public $pnRowLayout = null;
               public $Button10 = null;
               public $Button9 = null;
               public $Button8 = null;
               public $Button7 = null;
               public $Button6 = null;
               public $Button5 = null;
               public $Button4 = null;
               public $Button3 = null;
               public $Button2 = null;
               public $Button1 = null;
               public $Panel1 = null;
               function Button10Click($sender, $params)
               {
                $this->pnRowLayout->Height-=10;
               }

               function Button9Click($sender, $params)
               {
                $this->pnRowLayout->Height-=50;
               }

               function Button8Click($sender, $params)
               {
                $this->pnRowLayout->Height=150;
               }

               function Button7Click($sender, $params)
               {
                $this->pnRowLayout->Height+=50;
               }

               function Button6Click($sender, $params)
               {
                $this->pnRowLayout->Height+=10;
               }

        }

        global $application;

        global $Unit203;

        //Creates the form
        $Unit203=new Unit203($application);

        //Read from resource file
        $Unit203->loadResource(__FILE__);

        //Shows the form
        $Unit203->show();

?>
