<?php
        require_once "phpunit/phpunit.php";
        require_once "../vcl.inc.php";
        require_once "test_image.inc.php";
        use_unit("stdctrls.inc.php");
        use_unit("extctrls.inc.php");


        class ImageFadeTest extends ImageTest
        {
                function setup()
                {
                        $this->object=new ImageFade();
                }


                function test_Delay()
                {
                        $this->assertEquals($this->object->Delay, 3000);
                        $this->assertEquals($this->object->Delay,$this->object->defaultDelay());
                        $this->object->Delay=10000;
                        $this->assertEquals($this->object->Delay,10000);
                }

                 function test_FadeDegree()
                {
                        $this->assertEquals($this->object->FadeDegree, 10);
                        $this->assertEquals($this->object->FadeDegree,$this->object->defaultFadeDegree());
                        $this->object->FadeDegree=20;
                        $this->assertEquals($this->object->FadeDegree,20);
                }

                 function test_Images()
                {
                        $this->assertEquals($this->object->Images, null);
                        $this->assertEquals($this->object->Images, $this->object->defaultImages());
                        $obj=new Object();
                        $this->object->Images=$obj;
                        $this->assertEquals($this->object->Images, $obj);
                }

           
        }

                    if ($_SERVER['PHP_SELF']!='') $script=$_SERVER['PHP_SELF'];
                    else $script=$_GET['script'];

        if ($script=='/test_imagefade.inc.php')
        {
                        echo "<html>";
                        echo "<head>";
                        echo "<title>PHP-Unit Results</title>";
                        echo "<STYLE TYPE=\"text/css\">";
                        include("phpunit/stylesheet.css");
                        echo "</STYLE>";
                        echo "</head>";
                        echo "<body>";
                        $suite = new TestSuite( "ImageFadeTest" );
                        $testRunner = new TestRunner();
                        $testRunner->run( $suite );
                }


?>
