<?php
        ini_set('display_errors',1);
        error_reporting(E_ALL);

        require_once "phpunit/phpunit.php";
        require_once "../vcl.inc.php";
        require_once "../buttons.inc.php";
        require_once "test_qwidget.inc.php";
        use_unit("stdctrls.inc.php");

        class BitBtnTest extends QWidgetTest
        {
                function setup()
                {
                        $this->object=new BitBtn();
                }

                function test_OnClick()
                {
                        $this->assertEquals($this->object->OnClick, null);
                        $this->assertEquals($this->object->defaultOnClick(),$this->object->OnClick);
                        $this->object->OnClick= 'onclickEvent';
                        $this->assertEquals($this->object->OnClick, 'onclickEvent');
                }

                 function test_ImageSource()
                {
                        $this->assertEquals($this->object->ImageSource, "");
                        $this->assertEquals($this->object->defaultImageSource(),$this->object->ImageSource);
                        $this->object->ImageSource= '../relativePath/image1.jpg';
                        $this->assertEquals($this->object->ImageSource, '../relativePath/image1.jpg');
                        $this->object->ImageSource= 'C:\absolutPath\image1.jpg';
                        $this->assertEquals($this->object->ImageSource, 'C:\absolutPath\image1.jpg');
                }

                 function test_ButtonLayout()
                {
                        $this->assertEquals($this->object->ButtonLayout, blImageLeft);
                        $this->assertEquals($this->object->defaultButtonLayout(),$this->object->ButtonLayout);
                        $this->object->ButtonLayout= blImageBottom;
                        $this->assertEquals($this->object->ButtonLayout, blImageBottom);
                        $this->object->ButtonLayout= blImageRight;
                        $this->assertEquals($this->object->ButtonLayout, blImageRight);
                        $this->object->ButtonLayout= blImageTop;
                        $this->assertEquals($this->object->ButtonLayout, blImageTop);
                }

         }
      if ($_SERVER['PHP_SELF']!='') $script=$_SERVER['PHP_SELF'];
        else $script=$_GET['script'];

       if ($script=='/test_bitbtn.inc.php')
        {
                echo "<html>";
                echo "<head>";
                echo "<title>PHP-Unit Results</title>";
                echo "<STYLE TYPE=\"text/css\">";
                include("phpunit/stylesheet.css");
                echo "</STYLE>";
                echo "</head>";
                echo "<body>";
                $suite = new TestSuite( "BitBtnTest" );
                $testRunner = new TestRunner();
                $testRunner->run( $suite );
        }


?>
