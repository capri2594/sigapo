<?php
        require_once "phpunit/phpunit.php";
        require_once "../vcl.inc.php";
        require_once "test_focuscontrol.inc.php";
        use_unit("stdctrls.inc.php");
        use_unit("extctrls.inc.php");


        class CustomEditTest extends FocusControlTest
        {
                function setup()
                {
                        $this->object=new CustomEdit();
                }

               function test_BorderStyle()
                {
                        $this->assertEquals($this->object->BorderStyle, bsSingle);
                        $this->assertEquals($this->object->BorderStyle,$this->object->defaultBorderStyle());
                        $this->object->BorderStyle=bsNone;
                        $this->assertEquals($this->object->BorderStyle, bsNone);
                }

                function test_CharCase()
                {
                        $this->assertEquals($this->object->CharCase, ecNormal);
                        $this->assertEquals($this->object->CharCase,$this->object->defaultCharCase());
                        $this->object->CharCase=ecUpperCase;
                        $this->object->Text= "Text to Uppercase";
                        $my_text=$this->object->Text;
                        $this->assertEquals($my_text, "TEXT TO UPPERCASE");
                        $this->assertEquals($this->object->CharCase, ecUpperCase);
                        $this->object->CharCase=ecLowerCase;
                        $this->assertEquals($this->object->CharCase, ecLowerCase);
                }

                function test_OnClick()
                {
                        $this->assertEquals($this->object->OnClick, null);
                        $this->assertEquals($this->object->OnClick,$this->object->defaultOnClick());
                        $this->object->OnClick="event";
                        $this->assertEquals($this->object->OnClick, "event");
                }

                 function test_OnDblClick()
                {
                        $this->assertEquals($this->object->OnDblClick, null);
                        $this->assertEquals($this->object->OnDblClick,$this->object->defaultOnDblClick());
                        $this->object->OnDblClick="Dblevent";
                        $this->assertEquals($this->object->OnDblClick, "Dblevent");
                }

                 function test_OnSubmit()
                {
                        $this->assertEquals($this->object->OnSubmit, null);
                        $this->assertEquals($this->object->OnSubmit,$this->object->defaultOnSubmit());
                        $this->object->OnSubmit="Submitevent";
                        $this->assertEquals($this->object->OnSubmit, "Submitevent");
                }
          
                function test_IsPassword()
                {
                        $this->assertEquals($this->object->IsPassword,0);
                        $this->assertEquals($this->object->defaultIsPassword(),$this->object->IsPassword);
                        $this->object->IsPassword=1;
                        $this->assertEquals($this->object->IsPassword,1);
                }

                function test_ReadOnly()
                {
                        $this->assertEquals($this->object->ReadOnly,0);
                        $this->assertEquals($this->object->defaultReadOnly(),$this->object->ReadOnly);
                        $this->object->ReadOnly=1;
                        $this->assertEquals($this->object->ReadOnly,1);
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

                 function test_Text()
                {
                        $this->assertEquals($this->object->Text,'');
                        $this->assertEquals($this->object->defaultText(),$this->object->Text);
                        $this->object->Text='new text.=/@!&^hallo';
                        $this->assertEquals($this->object->Text,'new text.=/@!&^hallo');
                }

                 function test_MaxLength()
                {
                        $this->assertEquals($this->object->MaxLength,0);
                        $this->assertEquals($this->object->defaultMaxLength(),$this->object->MaxLength);
                        $this->object->MaxLength=20;
                        $this->assertEquals($this->object->MaxLength,20);
                        $this->object->MaxLength=20000;
                        $this->assertEquals($this->object->MaxLength,20000);
                }

                

                function test_DataSource()
                {
                        $obj=new Object();
                        $this->assertEquals($this->object->DataSource,null);
                        $this->assertEquals($this->object->DataSource,$this->object->defaultDataSource());
                        $this->object->DataSource=$obj;
                        $this->assertEquals($this->object->DataSource,$obj);
                }

                function test_DataField()
                {
                        $this->assertEquals($this->object->DataField,'');
                        $this->assertEquals($this->object->DataField,$this->object->defaultDataField());
                        $this->object->DataField='hola, radiola';
                        $this->assertEquals($this->object->DataField,'hola, radiola');
                }


                function test_dumpContents()
                {
                        ob_start();
                        $this->object->Name="Label1";
                        $this->object->show();
                        $c=ob_get_contents();
                        ob_end_clean();
                        $this->assertEquals(trim($c),'<div id="Label1" style=" font-family: Verdana; font-size: 10px;  height:13px;width:75px; vertical-align: top; "  ></div>');
                }



        }

                    if ($_SERVER['PHP_SELF']!='') $script=$_SERVER['PHP_SELF'];
                    else $script=$_GET['script'];

        if ($script=='/test_customedit.inc.php')
        {
                        echo "<html>";
                        echo "<head>";
                        echo "<title>PHP-Unit Results</title>";
                        echo "<STYLE TYPE=\"text/css\">";
                        include("phpunit/stylesheet.css");
                        echo "</STYLE>";
                        echo "</head>";
                        echo "<body>";
                        $suite = new TestSuite( "CustomEditTest" );
                        $testRunner = new TestRunner();
                        $testRunner->run( $suite );
                }


?>
