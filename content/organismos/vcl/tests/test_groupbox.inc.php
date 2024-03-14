<?php
        require_once "phpunit/phpunit.php";
        require_once "../vcl.inc.php";
        require_once "test_qwidget.inc.php";
        use_unit("stdctrls.inc.php");
        use_unit("extctrls.inc.php");


        class GroupBoxTest extends QWidgetTest
        {
                function setup()
                {
                        $this->object=new GroupBox();
                }
  
        }

                    if ($_SERVER['PHP_SELF']!='') $script=$_SERVER['PHP_SELF'];
                    else $script=$_GET['script'];

        if ($script=='/test_groupbox.inc.php')
        {
                        echo "<html>";
                        echo "<head>";
                        echo "<title>PHP-Unit Results</title>";
                        echo "<STYLE TYPE=\"text/css\">";
                        include("phpunit/stylesheet.css");
                        echo "</STYLE>";
                        echo "</head>";
                        echo "<body>";
                        $suite = new TestSuite( "GroupBoxTest" );
                        $testRunner = new TestRunner();
                        $testRunner->run( $suite );
                }


?>
