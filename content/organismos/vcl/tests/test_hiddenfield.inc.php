<?php
        ini_set('display_errors',1);
        error_reporting(E_ALL);

        require_once "phpunit/phpunit.php";
        require_once "../vcl.inc.php";
        require_once "test_control.inc.php";
        use_unit("stdctrls.inc.php");
        use_unit("extctrls.inc.php");

        class HiddenFieldTest extends ControlTest
        {
                function setup()
                {
                        $this->object=new HiddenField();
                }

                function test_Value()
                {
                        $this->assertEquals($this->object->Value, '');
                        $this->assertEquals($this->object->defaultValue(),$this->object->Value);
                        $this->object->Value= 'new hidden field';
                        $this->assertEquals($this->object->Value, 'new hidden field');
                        $this->object->Value= 2544;
                        $this->assertEquals($this->object->Value, 2544);
                }

         
         }
      if ($_SERVER['PHP_SELF']!='') $script=$_SERVER['PHP_SELF'];
        else $script=$_GET['script'];

       if ($script=='/test_hiddenfield.inc.php')
        {
                echo "<html>";
                echo "<head>";
                echo "<title>PHP-Unit Results</title>";
                echo "<STYLE TYPE=\"text/css\">";
                include("phpunit/stylesheet.css");
                echo "</STYLE>";
                echo "</head>";
                echo "<body>";
                $suite = new TestSuite( "HiddenFieldTest" );
                $testRunner = new TestRunner();
                $testRunner->run( $suite );
        }


?>
