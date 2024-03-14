<?php
        require_once "phpunit/phpunit.php";
        require_once "../vcl.inc.php";
        require_once "test_custompanel.inc.php";
        use_unit("stdctrls.inc.php");
        use_unit("extctrls.inc.php");


        class PanelTest extends CustomPanelTest
        {
                function setup()
                {
                        $this->object=new Panel();
                }


             function test_dumpContents()
                {
                        ob_start();
                        $this->object->Name="Panel1";
                        $this->object->show();
                        $c=ob_get_contents();
                        ob_end_clean();
                        $this->assertEquals(trim($c),trim('<table border="0" cellpadding="0" cellspacing="0" style=" border: 0px solid ; " > <tr> <td align="center"><span style=" font-family: Verdana; font-size: 10px; "></span> </td> </tr> </table>'));
                }

        }

                    if ($_SERVER['PHP_SELF']!='') $script=$_SERVER['PHP_SELF'];
                    else $script=$_GET['script'];

        if ($script=='/test_panel.inc.php')
        {
                        echo "<html>";
                        echo "<head>";
                        echo "<title>PHP-Unit Results</title>";
                        echo "<STYLE TYPE=\"text/css\">";
                        include("phpunit/stylesheet.css");
                        echo "</STYLE>";
                        echo "</head>";
                        echo "<body>";
                        $suite = new TestSuite( "PanelTest" );
                        $testRunner = new TestRunner();
                        $testRunner->run( $suite );
                }


?>
