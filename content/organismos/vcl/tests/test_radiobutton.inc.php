<?php
        ini_set('display_errors',1);
        error_reporting(E_ALL);

        require_once "phpunit/phpunit.php";
        require_once "../vcl.inc.php";
        require_once "test_buttoncontrol.inc.php";
        use_unit("stdctrls.inc.php");
        use_unit("extctrls.inc.php");

        class RadioButtonTest extends ButtonControlTest
        {
                function setup()
                {
                        $this->object=new RadioButton();
                }

                function test_Group()
                {
                        $this->assertEquals($this->object->Group, '');
                        $this->assertEquals($this->object->defaultGroup(),$this->object->Group);
                        $this->object->Group= 'new Group';
                        $this->assertEquals($this->object->Group, 'new Group');
                }
         }
      if ($_SERVER['PHP_SELF']!='') $script=$_SERVER['PHP_SELF'];
        else $script=$_GET['script'];

       if ($script=='/test_radiobutton.inc.php')
        {
                echo "<html>";
                echo "<head>";
                echo "<title>PHP-Unit Results</title>";
                echo "<STYLE TYPE=\"text/css\">";
                include("phpunit/stylesheet.css");
                echo "</STYLE>";
                echo "</head>";
                echo "<body>";
                $suite = new TestSuite( "RadioButtonTest" );
                $testRunner = new TestRunner();
                $testRunner->run( $suite );
        }


?>
