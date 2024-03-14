<?php
        ini_set('display_errors',1);
        error_reporting(E_ALL);

        require_once "phpunit/phpunit.php";
        require_once "../vcl.inc.php";
        require_once "test_focuscontrol.inc.php";
        use_unit("stdctrls.inc.php");
        use_unit("extctrls.inc.php");

        class ButtonControlTest extends FocusControlTest
        {
                function setup()
                {
                        $this->object=new ButtonControl();
                }

               function test_OnClick()
                {
                        $this->assertEquals($this->object->OnClick,null);
                        $this->assertEquals($this->object->OnClick,$this->object->defaultOnClick());
                        $this->object->OnClick='onClickEvent';
                        $this->assertEquals($this->object->OnClick,'onClickEvent');
                }

               function test_jsOnSelect()
               {
                        $this->assertEquals($this->object->jsOnSelect,null);
                        $this->assertEquals($this->object->jsOnSelect,$this->object->defaultjsOnSelect());
                        $this->object->jsOnSelect='dummyEvent';
                        $this->assertEquals($this->object->jsOnSelect,'dummyEvent');
               }

               function test_Checked()
               {
                        $this->assertEquals($this->object->Checked,0);
                        $this->assertEquals($this->object->Checked,$this->object->defaultChecked());
                        $this->object->Checked=1;
                        $this->assertEquals($this->object->Checked,1);
               }

                function test_DataSource()

               {        $myObj=new Object();
                        $this->assertEquals($this->object->DataSource,null);
                        $this->assertEquals($this->object->DataSource,$this->object->defaultDataSource());
                        $this->object->DataSource=$myObj;
                        $this->assertEquals($this->object->DataSource, $myObj);
               }

                function test_DataField()
               {
                        $this->assertEquals($this->object->DataField,"");
                        $this->assertEquals($this->object->DataField,$this->object->defaultDataField());
                        $this->object->DataField="myDataField";
                        $this->assertEquals($this->object->DataField,"myDataField");
               }

               function test_TabOrder()
                {
                        $this->assertEquals($this->object->TabOrder,0);
                        $this->assertEquals($this->object->defaultTabOrder(),$this->object->TabOrder);
                        $this->object->TabOrder=1;
                        $this->assertEquals($this->object->TabOrder,1);
                }

                 function test_TabStop()
                {
                        $this->assertEquals($this->object->TabStop,1);
                        $this->assertEquals($this->object->defaultTabStop(),$this->object->TabStop);
                        $this->object->TabStop=0;
                        $this->assertEquals($this->object->TabStop,0);
                }

         }
         
      if ($_SERVER['PHP_SELF']!='') $script=$_SERVER['PHP_SELF'];
        else $script=$_GET['script'];

       if ($script=='/test_buttoncontrol.inc.php')
        {
                echo "<html>";
                echo "<head>";
                echo "<title>PHP-Unit Results</title>";
                echo "<STYLE TYPE=\"text/css\">";
                include("phpunit/stylesheet.css");
                echo "</STYLE>";
                echo "</head>";
                echo "<body>";
                $suite = new TestSuite( "ButtonControlTest" );
                $testRunner = new TestRunner();
                $testRunner->run( $suite );
        }


?>
