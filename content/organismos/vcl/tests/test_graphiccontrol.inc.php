<?php
        require_once "phpunit/phpunit.php";
        require_once "../vcl.inc.php";
        require_once "test_customcontrol.inc.php";
        use_unit("controls.inc.php");


        class GraphicControlTest extends CustomControlTest
        {
                function setup()
                {
                        $this->object=new GraphicControl();
                }


        }

		    if ($_SERVER['PHP_SELF']!='') $script=$_SERVER['PHP_SELF'];
		    else $script=$_GET['script'];

        if ($script=='/test_graphiccontrol.inc.php')
        {
                        echo "<html>";
                        echo "<head>";
                        echo "<title>PHP-Unit Results</title>";
                        echo "<STYLE TYPE=\"text/css\">";
                        include("phpunit/stylesheet.css");
                        echo "</STYLE>";
                        echo "</head>";
                        echo "<body>";
                        $suite = new TestSuite( "GraphicControlTest" );
                        $testRunner = new TestRunner();
                        $testRunner->run( $suite );
                }


?>
