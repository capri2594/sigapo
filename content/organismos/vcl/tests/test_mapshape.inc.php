<?php
        require_once "phpunit/phpunit.php";
        require_once "../vcl.inc.php";
        require_once "test_control.inc.php";
        use_unit("stdctrls.inc.php");
        use_unit("extctrls.inc.php");


        class MapShapeTest extends ControlTest
        {
                function setup()
                {
                        $this->object=new MapShape();
                }

                function test_dumpContents()
                {
                        ob_start();
                        $this->object->Name="Mapshape1";
                        $this->object->show();
                        $c=ob_get_contents();
                        ob_end_clean();
                        $this->assertEquals(trim($c),'<area shape="rect" coords="0,0,20,20" href="#" >');
                }

        }

                    if ($_SERVER['PHP_SELF']!='') $script=$_SERVER['PHP_SELF'];
                    else $script=$_GET['script'];

        if ($script=='/test_mapshape.inc.php')
        {
                        echo "<html>";
                        echo "<head>";
                        echo "<title>PHP-Unit Results</title>";
                        echo "<STYLE TYPE=\"text/css\">";
                        include("phpunit/stylesheet.css");
                        echo "</STYLE>";
                        echo "</head>";
                        echo "<body>";
                        $suite = new TestSuite( "MapShapeTest" );
                        $testRunner = new TestRunner();
                        $testRunner->run( $suite );
                }


?>
