<?php
        ini_set('display_errors',1);
        error_reporting(E_ALL);

        require_once "phpunit/phpunit.php";
        require_once "../vcl.inc.php";
        require_once "test_component.inc.php";
        use_unit("stdctrls.inc.php");
        use_unit("actnlist.inc.php");

        class ActionTest extends ComponentTest
        {
                function setup()
                {
                        $this->object=new ActionList();
                }

                function test_OnExecute()
                {
                        $this->assertEquals($this->object->OnExecute, null);
                        $this->assertEquals($this->object->defaultOnExecute(),$this->object->OnExecute);
                        $this->object->OnExecute= 'dummy test';
                        $this->assertEquals($this->object->OnExecute, 'dummy test');
                }


         }
      if ($_SERVER['PHP_SELF']!='') $script=$_SERVER['PHP_SELF'];
        else $script=$_GET['script'];

       if ($script=='/test_action.inc.php')
        {
                echo "<html>";
                echo "<head>";
                echo "<title>PHP-Unit Results</title>";
                echo "<STYLE TYPE=\"text/css\">";
                include("phpunit/stylesheet.css");
                echo "</STYLE>";
                echo "</head>";
                echo "<body>";
                $suite = new TestSuite( "ActionTest" );
                $testRunner = new TestRunner();
                $testRunner->run( $suite );
        }


?>
