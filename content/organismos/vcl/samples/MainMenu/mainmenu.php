<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        use_unit("menus.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class MainMenuSample extends Page
        {
               public $Memo1 = null;
               public $MainMenu1 = null;
               function MainMenu1JSClick($sender, $params)
               {               
               ?>
               //Add your javascript code here
                        tag=event.getTarget().tag;
                        if (tag==10)
                        {
                                document.MainMenuSample.Memo1.value='Javascript Event';
                                return(false);
                        }
                        else return(true);
               <?php
               }


               function MainMenu1Click($sender, $params)
               {
                        if ($params['tag']==20)
                        {
                                $this->Memo1->Lines=array("PHP Event");
                        }
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
