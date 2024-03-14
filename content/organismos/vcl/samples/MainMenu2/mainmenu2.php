<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        use_unit("buttons.inc.php");
        use_unit("imglist.inc.php");
        use_unit("menus.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class MainMenuSample extends Page
        {
               public $btnClose = null;
               public $Label1 = null;
               public $Window1 = null;
               public $ImageList1 = null;
               public $MainMenu1 = null;
               function btnCloseJSClick($sender, $params)
               {               
               ?>
               //Add your javascript code here
                        Window1.close();
               <?php
               }

               function MainMenu1JSClick($sender, $params)
               {               
               ?>
               //Add your javascript code here
                        Window1.open();
               <?php
               }

        }

        global $application;

        global $MainMenuSample;

        //Creates the form
        $MainMenuSample=new MainMenuSample($application);

        //Read from resource file
        $MainMenuSample->loadResource(__FILE__);

        //Shows the form
        $MainMenuSample->show();

?>
