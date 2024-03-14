<?php
        ini_set('display_errors',1);
        error_reporting(E_ALL);

        require_once "phpunit/phpunit.php";
        require_once "../vcl.inc.php";
        require_once "test_customedit.inc.php";
        use_unit("stdctrls.inc.php");
        use_unit("extctrls.inc.php");

        class CustomMemoTest extends CustomEditTest
        {
                function setup()
                {
                        $this->object=new Memo();
                }

                function test_Lines()
                {
                        $this->assertEquals($this->object->Lines, array());
                        $this->assertEquals($this->object->Lines,$this->object->defaultLines());
                        $this->object->Lines='a:2:{i:0;s:5:"test1";i:1;s:5:"test2";}';
                        $this->assertEquals($this->object->Lines,'a:2:{i:0;s:5:"test1";i:1;s:5:"test2";}');
                }

                 function test_WordWrap()
                {
                        $this->assertEquals($this->object->WordWrap,1);
                        $this->assertEquals($this->object->WordWrap,$this->object->defaultWordWrap());
                        $this->object->WordWrap=false;
                        $this->assertEquals($this->object->WordWrap,false);
                }

                function test_dumpContents()
                {
                        ob_start();
                        $this->object->show();
                        $c=ob_get_contents();
                        $this->assertEquals(trim($c),trim('<textarea id="Memo1" name="Memo1" style=" font-family: Verdana; font-size: 10px;  height:88px;width:185px;"    tabindex="0"    wrap="virtual"></textarea>'));
                        ob_end_clean(); 


                }

        }

        if ($_SERVER['PHP_SELF']!='') $script=$_SERVER['PHP_SELF'];
                    else $script=$_GET['script'];

        if ($_SERVER['PHP_SELF']=='/test_custommemo.inc.php')
        {
                echo "<html>";
                echo "<head>";
                echo "<title>PHP-Unit Results</title>";
                echo "<STYLE TYPE=\"text/css\">";
                include("phpunit/stylesheet.css");
                echo "</STYLE>";
                echo "</head>";
                echo "<body>";
                $suite = new TestSuite( "CustomMemoTest" );
                $testRunner = new TestRunner();
                $testRunner->run( $suite );
        }


?>
