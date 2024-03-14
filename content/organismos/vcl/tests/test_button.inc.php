<?php
        ini_set('display_errors',1);
        error_reporting(E_ALL);

        require_once "phpunit/phpunit.php";
        require_once "../vcl.inc.php";
        require_once "test_buttoncontrol.inc.php";
        use_unit("stdctrls.inc.php");
        use_unit("extctrls.inc.php");


        class ButtonTest extends ButtonControlTest
        {
                function setup()
                {
                        $this->object=new Button();
                }

                function test_ButtonType()
                {
                        $this->assertEquals($this->object->ButtonType,'btSubmit');
                        $this->assertEquals($this->object->ButtonType,$this->object->defaultButtonType());
                        $this->object->ButtonType='btCancel';
                        $this->assertEquals($this->object->ButtonType,'btCancel');
                        $this->object->ButtonType='btNone';
                        $this->assertEquals($this->object->ButtonType,'btNone');
                }

                function test_ImageSource()
                {
                        $this->assertEquals($this->object->ImageSource,'');
                        $this->object->ImageSource='new image source';
                        $this->assertEquals($this->object->ImageSource,'new image source');
                }

        }

        if ($_SERVER['PHP_SELF']!='') $script=$_SERVER['PHP_SELF'];
           else $script=$_GET['script'];

        if ($script=='/test_button.inc.php')
        {
                        echo "<html>";
                        echo "<head>";
                        echo "<title>PHP-Unit Results</title>";
                        echo "<STYLE TYPE=\"text/css\">";
                        include("phpunit/stylesheet.css");
                        echo "</STYLE>";
                        echo "</head>";
                        echo "<body>";
                        $suite = new TestSuite( "ButtonTest" );
                        $testRunner = new TestRunner();
                        $testRunner->run( $suite );
                }


?>
