<?php
        ini_set('display_errors',1);
        error_reporting(E_ALL);

        require_once "phpunit/phpunit.php";
        require_once "../vcl.inc.php";
        require_once "test_focuscontrol.inc.php";
        use_unit("stdctrls.inc.php");
        use_unit("extctrls.inc.php");

        class QWidgetTest extends FocusControlTest
        {
                function setup()
                {
                        $this->object=new QWidget();
                }



             /*   function test_dumpCommonQWidgetJSEvents()
                {
                        ob_start();
                        $this->object->dumpCommonQWidgetJSEvents('QWidgetJSEvents', 2);
                        $this->object->show();
                        $c=ob_get_contents();
                        ob_end_clean();
                        $this->assertEquals($c,'');
                        ob_end_clean();
                }
             */
         }
      if ($_SERVER['PHP_SELF']!='') $script=$_SERVER['PHP_SELF'];
        else $script=$_GET['script'];

       if ($script=='/test_qwidget.inc.php')
        {
                echo "<html>";
                echo "<head>";
                echo "<title>PHP-Unit Results</title>";
                echo "<STYLE TYPE=\"text/css\">";
                include("phpunit/stylesheet.css");
                echo "</STYLE>";
                echo "</head>";
                echo "<body>";
                $suite = new TestSuite( "QWidgetTest" );
                $testRunner = new TestRunner();
                $testRunner->run( $suite );
        }


?>
