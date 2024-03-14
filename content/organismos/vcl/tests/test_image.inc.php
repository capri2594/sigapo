<?php
        ini_set('display_errors',1);
        error_reporting(E_ALL);

        require_once "phpunit/phpunit.php";
        require_once "../vcl.inc.php";
        require_once "../dbctrls.inc.php";
        require_once "test_graphiccontrol.inc.php";
        use_unit("extctrls.inc.php");

        class ImageTest extends GraphicControlTest
        {
                function setup()
                {
                        $this->object=new Image();
                }

                function test_OnClick()
                {
                        $this->assertEquals($this->object->OnClick, null);
                        $this->assertEquals($this->object->defaultOnClick(),$this->object->OnClick);
                        $this->object->OnClick= 'onclickEvent';
                        $this->assertEquals($this->object->OnClick, 'onclickEvent');
                }

                function test_OnCustomize()
                {
                        $this->assertEquals($this->object->OnCustomize, null);
                        $this->assertEquals($this->object->defaultOnCustomize(),$this->object->OnCustomize);
                        $this->object->OnCustomize= 'onCustomize';
                        $this->assertEquals($this->object->OnCustomize, 'onCustomize');
                }

                function test_Autosize()
                {
                        $this->assertEquals($this->object->Autosize, 0);
                        $this->object->Autosize= 1;
                        $this->assertEquals($this->object->Autosize, 1);
                }

                function test_Border()
                {
                        $this->assertEquals($this->object->Border, 0);
                        $this->object->Border= 1;
                        $this->assertEquals($this->object->Border, 1);
                }

                function test_BorderColor()
                {
                        $this->assertEquals($this->object->BorderColor, "");
                        $this->object->BorderColor= '#FF8000';
                        $this->assertEquals($this->object->BorderColor, '#FF8000');
                }

                 function test_Center()
                {
                        $this->assertEquals($this->object->Center, 0);
                        $this->object->Center= 1;
                        $this->assertEquals($this->object->Center, 1);
                }

                function test_DataField()
                {
                        $this->assertEquals($this->object->DataField, "");
                        $this->assertEquals($this->object->defaultDataField(),$this->object->DataField);
                        $this->object->OnCustomize= 'data field';
                        $this->assertEquals($this->object->OnCustomize, 'data field');
                }

                function test_DataSource()
                {       $myDataSrc=new DataSource();
                        $this->assertEquals($this->object->DataSource, "");

                        $this->assertEquals($this->object->defaultDataSource(),$this->object->DataSource);
                        $this->object->DataSource=$myDataSrc;
                        //$this->object->DataSource= 'data source';
                        $this->assertEquals($this->object->DataSource, $myDataSrc);
                }

                 function test_ImageSource()
                {
                        $this->assertEquals($this->object->ImageSource, "");
                        $this->object->ImageSource= 'image source';
                        $this->assertEquals($this->object->ImageSource, 'image source');
                }


                 function test_Link()
                {
                        $this->assertEquals($this->object->Link, "");
                        $this->object->Link= 'link, link';
                        $this->assertEquals($this->object->Link, 'link, link');
                }

                 function test_LinkTarget()
                {
                        $this->assertEquals($this->object->LinkTarget, "");
                        $this->object->LinkTarget= 'link target1';
                        $this->assertEquals($this->object->LinkTarget, 'link target1');
                }

                 function test_Proportional()
                {
                        $this->assertEquals($this->object->Proportional, 0);
                        $this->assertEquals($this->object->defaultProportional(),$this->object->Proportional);
                        $this->object->Proportional= 1;
                        $this->assertEquals($this->object->Proportional, 1);
                }

                 function test_PopupMenu()
                {
                        $this->assertEquals($this->object->PopupMenu, null);
                        $this->assertEquals($this->object->defaultPopupMenu(),$this->object->PopupMenu);
                        $obj = new object();
                        $this->object->PopUpMenu= $obj;
                        $this->assertEquals($this->object->PopUpMenu, $obj);
                }
         }
      if ($_SERVER['PHP_SELF']!='') $script=$_SERVER['PHP_SELF'];
        else $script=$_GET['script'];

       if ($script=='/test_image.inc.php')
        {
                echo "<html>";
                echo "<head>";
                echo "<title>PHP-Unit Results</title>";
                echo "<STYLE TYPE=\"text/css\">";
                include("phpunit/stylesheet.css");
                echo "</STYLE>";
                echo "</head>";
                echo "<body>";
                $suite = new TestSuite( "ImageTest" );
                $testRunner = new TestRunner();
                $testRunner->run( $suite );
        }


?>
