<?php
        require_once "phpunit/phpunit.php";
        require_once "../vcl.inc.php";
        require_once "test_object.inc.php";
        use_unit("classes.inc.php");
        use_unit("graphics.inc.php");


        class PersistentTest extends ObjectTest
        {
                function setup()
                {
                        $this->object=new Persistent();
                }

                function test_serialize()
                {
                        $own=new Component();
                        $own->Name="Form";
                        $object=new Component($own);
                        $object->Name="Component";
                        $object->serialize();
                        //print_r($_SESSION);
                        $this->assertEquals($_SESSION['Form.Component.Tag'],0);
                        $object->Tag=10;
                        $object->serialize();
                        $object->Tag=0;
                        $object->unserialize();
                        $this->assertEquals($_SESSION['Form.Component.Tag'],10);

                }

                function test_unserialize()
                {
                        $this->test_serialize();
                }

                function test_assign()
                {
                        $f1=new Font();

                        $f2=new Font();

                        $font_string=$f1->FontString;
                        $this->assertEquals(trim($font_string),trim('font-family: Verdana; font-size: 10px;'));

                        $font_string=$f2->FontString;
                        $this->assertEquals(trim($font_string),trim('font-family: Verdana; font-size: 10px;'));

                        $f1->Family="Tahoma";

                        $font_string=$f1->FontString;
                        $this->assertEquals(trim($font_string),trim('font-family: Tahoma; font-size: 10px;'));

                        $font_string=$f2->FontString;
                        $this->assertEquals(trim($font_string),trim('font-family: Verdana; font-size: 10px;'));

                        $f2->assign($f1);

                        $font_string=$f1->FontString;
                        $this->assertEquals(trim($font_string),trim('font-family: Tahoma; font-size: 10px;'));

                        $font_string=$f2->FontString;
                        $this->assertEquals(trim($font_string),trim('font-family: Tahoma; font-size: 10px;'));


                }

                function test_assignTo()
                {
                        $f1=new Font();

                        $f2=new Font();

                        $font_string=$f1->FontString;
                        $this->assertEquals(trim($font_string),trim('font-family: Verdana; font-size: 10px;'));

                        $font_string=$f2->FontString;
                        $this->assertEquals(trim($font_string),trim('font-family: Verdana; font-size: 10px;'));

                        $f1->Family="Tahoma";

                        $font_string=$f1->FontString;
                        $this->assertEquals(trim($font_string),trim('font-family: Tahoma; font-size: 10px;'));

                        $font_string=$f2->FontString;
                        $this->assertEquals(trim($font_string),trim('font-family: Verdana; font-size: 10px;'));

                        $f1->assignto($f2);

                        $font_string=$f1->FontString;
                        $this->assertEquals(trim($font_string),trim('font-family: Tahoma; font-size: 10px;'));

                        $font_string=$f2->FontString;
                        $this->assertEquals(trim($font_string),trim('font-family: Tahoma; font-size: 10px;'));


                }

                function test_assignError()
                {
                        try
                        {
                                $this->object->assignError(null);
                                $this->assertEquals(1,0);
                        }
                        catch (Exception $e)
                        {
                                $this->assertEquals(1,1);
                        }
                }

        }
        
		    if ($_SERVER['PHP_SELF']!='') $script=$_SERVER['PHP_SELF'];
		    else $script=$_GET['script'];

        if ($script=='/test_persistent.inc.php')
        {        
                        echo "<html>";
                        echo "<head>";
                        echo "<title>PHP-Unit Results</title>";
                        echo "<STYLE TYPE=\"text/css\">";
                        include("phpunit/stylesheet.css");
                        echo "</STYLE>";
                        echo "</head>";
                        echo "<body>";
                        $suite = new TestSuite( "PersistentTest" );
                        $testRunner = new TestRunner();
                        $testRunner->run( $suite );
                }


?>
