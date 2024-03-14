<?php
        ini_set('display_errors',1);
        error_reporting(E_ALL);

        require_once "phpunit/phpunit.php";
        require_once "../vcl.inc.php";
        require_once "../buttons.inc.php";
        require_once "test_bitbtn.inc.php";
        use_unit("stdctrls.inc.php");

        class SpeedButtonTest extends BitBtnTest
        {
                function setup()
                {
                        $this->object=new SpeedButton();
                }

         }
      if ($_SERVER['PHP_SELF']!='') $script=$_SERVER['PHP_SELF'];
        else $script=$_GET['script'];

       if ($script=='/test_speedbutton.inc.php')
        {
                echo "<html>";
                echo "<head>";
                echo "<title>PHP-Unit Results</title>";
                echo "<STYLE TYPE=\"text/css\">";
                include("phpunit/stylesheet.css");
                echo "</STYLE>";
                echo "</head>";
                echo "<body>";
                $suite = new TestSuite( "SpeedButtonTest" );
                $testRunner = new TestRunner();
                $testRunner->run( $suite );
        }


?>
