<?php
        ini_set('display_errors',1);
        error_reporting(E_ALL);

        require_once "phpunit/phpunit.php";
        require_once "../vcl.inc.php";
        require_once "test_buttoncontrol.inc.php";
        use_unit("stdctrls.inc.php");
        use_unit("extctrls.inc.php");

        class CustomCheckboxTest extends ButtonControlTest
        {
                function setup()
                {
                        $this->object=new CustomCheckbox();
                }


                function test_dumpContents()
                {
                        ob_start();
                        $this->object->show();
                        $c=ob_get_contents();
                        ob_end_clean();
                        $this->assertEquals(trim($c),'<table cellpadding="0" style=" font-family: Verdana; font-size: 10px; height:20px;width:121px;" cellspacing="0"><tr><td width="20"> <input type="checkbox" name="CustomCheckBox1" value="" style=" font-family: Verdana; font-size: 10px; " tabindex=0 > </td><td > <span onclick="var c = document.forms..CustomCheckBox1; c.checked = !c.checked; return (typeof(c.onclick) == \'function\') ? c.onclick() : false;" ></span> </td></tr></table>');


                }
         }
         
      if ($_SERVER['PHP_SELF']!='') $script=$_SERVER['PHP_SELF'];
        else $script=$_GET['script'];

       if ($script=='/test_customcheckbox.inc.php')
        {
                echo "<html>";
                echo "<head>";
                echo "<title>PHP-Unit Results</title>";
                echo "<STYLE TYPE=\"text/css\">";
                include("phpunit/stylesheet.css");
                echo "</STYLE>";
                echo "</head>";
                echo "<body>";
                $suite = new TestSuite( "CustomCheckboxTest" );
                $testRunner = new TestRunner();
                $testRunner->run( $suite );
        }


?>
