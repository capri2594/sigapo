<?php
        ini_set('display_errors',1);
        error_reporting(E_ALL);

        require_once "phpunit/phpunit.php";
        require_once "../vcl.inc.php";
        require_once "test_qwidget.inc.php";
        use_unit("stdctrls.inc.php");
        use_unit("extctrls.inc.php");

        class ScrollBarTest extends QWidgetTest
        {
                function setup()
                {
                        $this->object=new ScrollBar();
                }

                function test_Kind()
                {
                        $this->assertEquals($this->object->Kind, sbHorizontal);
                        $this->assertEquals($this->object->defaultKind(),$this->object->Kind);
                        $this->object->Kind= sbVertical;
                        $this->assertEquals($this->object->Kind, sbVertical);
                        $this->object->Kind= 'new kind';
                        $this->assertEquals($this->object->Kind, 'new kind');
                }

                function test_Min()
                {
                        $this->assertEquals($this->object->Min, 0);
                        $this->assertEquals($this->object->defaultMin(),$this->object->Min);
                        $this->object->Min= 20;
                        $this->assertEquals($this->object->Min, 20);
                }

                function test_Max()
                {
                        $this->assertEquals($this->object->Max, 500);
                        $this->assertEquals($this->object->defaultMax(),$this->object->Max);
                        $this->object->Max= 10000;
                        $this->assertEquals($this->object->Max, 10000);
                }

                function test_SmallChange()
                {
                        $this->assertEquals($this->object->SmallChange, 1);
                        $this->assertEquals($this->object->defaultSmallChange(),$this->object->SmallChange);
                        $this->object->SmallChange= 4;
                        $this->assertEquals($this->object->SmallChange, 4);
                }

                function test_LargeChange()
                {
                        $this->assertEquals($this->object->LargeChange, 1);
                        $this->assertEquals($this->object->defaultLargeChange(),$this->object->LargeChange);
                        $this->object->LargeChange= 600;
                        $this->assertEquals($this->object->LargeChange, 600);
                }

                function test_Position()
                {
                        $this->assertEquals($this->object->Position, 0);
                        $this->assertEquals($this->object->defaultPosition(),$this->object->Position);
                        $this->object->Position= 45;
                        $this->assertEquals($this->object->Position, 45);
                        $this->object->Position= 'nowhere';
                        $this->assertEquals($this->object->Position, 'nowhere');
                }

                 function test_PageSize()
                {
                        $this->assertEquals($this->object->PageSize, 0);
                        $this->assertEquals($this->object->defaultPageSize(),$this->object->PageSize);
                        $this->object->PageSize= 45;
                        $this->assertEquals($this->object->PageSize, 45);
                        $this->object->PageSize= 'nowhere';
                        $this->assertEquals($this->object->PageSize, 'nowhere');
                }
         }
      if ($_SERVER['PHP_SELF']!='') $script=$_SERVER['PHP_SELF'];
        else $script=$_GET['script'];

       if ($script=='/test_scrollbar.inc.php')
        {
                echo "<html>";
                echo "<head>";
                echo "<title>PHP-Unit Results</title>";
                echo "<STYLE TYPE=\"text/css\">";
                include("phpunit/stylesheet.css");
                echo "</STYLE>";
                echo "</head>";
                echo "<body>";
                $suite = new TestSuite( "ScrollBarTest" );
                $testRunner = new TestRunner();
                $testRunner->run( $suite );
        }


?>
