<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        use_unit("auth.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class PasswordProtectedPage extends Page
        {
               public $Label1 = null;
               public $BasicAuthentication1 = null;
               function BasicAuthentication1Authenticate($sender, $params)
               {
                        //You can use the Username and Password properties to automatically check for that
                        //But if you want to search in a list/database, you can use the OnAuthenticate event
                        if (($params['username']=='delphiforphp') && ($params['password']=='rules'))
                        {
                                return(true);
                        }
                        else return(false);
               }

               function PasswordProtectedPageBeforeShow($sender, $params)
               {
                        $this->BasicAuthentication1->Execute();
               }

        }

        global $application;

        global $PasswordProtectedPage;

        //Creates the form
        $PasswordProtectedPage=new PasswordProtectedPage($application);

        //Read from resource file
        $PasswordProtectedPage->loadResource(__FILE__);

        //Shows the form
        $PasswordProtectedPage->show();

?>
