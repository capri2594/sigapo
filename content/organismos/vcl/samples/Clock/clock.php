<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        use_unit("clock.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class ClockDemo extends Page
        {
               public $Label1 = null;
               public $Memo1 = null;
               public $Clock1 = null;
               function Clock1JSAlarm($sender, $params)
               {
               ?>
                        //Add your javascript code here
                        var dt = new Date();
                        document.ClockDemo.Memo1.value+='This is an alarm @' + dt+"\n";
                        dt = Date.parse(dt)+5000
                        Clock1.fld.setAlarm(dt);
               <?php
               }

        }

        global $application;

        global $ClockDemo;

        //Creates the form
        $ClockDemo=new ClockDemo($application);

        //Read from resource file
        $ClockDemo->loadResource(__FILE__);

        //Shows the form
        $ClockDemo->show();

?>
