<?php
        require_once "phpunit/phpunit.php";
        require_once "../vcl.inc.php";
        require_once "test_graphiccontrol.inc.php";
        use_unit("stdctrls.inc.php");
        use_unit("extctrls.inc.php");


        class CustomLabelTest extends GraphicControlTest
        {
                function setup()
                {
                        $this->object=new CustomLabel();
                }


                function test_Link()
                {
                        $this->assertEquals($this->object->Link,'');
                        $this->assertEquals($this->object->Link,$this->object->defaultLink());
                        $this->object->Link='hola, radiola';
                        $this->assertEquals($this->object->Link,'hola, radiola');
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

                function test_Font()
                {
                        $this->assertEquals(is_object($this->object->Font),true);
                        $font_string=$this->object->Font->FontString;
                        $this->assertEquals(trim($font_string),trim('font-family: Verdana; font-size: 10px;'));
                }


                function test_Align()
                {
                        $this->assertEquals($this->object->Align,'alNone');
                        $this->assertEquals($this->object->Align,$this->object->defaultAlign());
                        $this->object->Align=alClient;
                        $this->assertEquals($this->object->Align,'alClient');
                }

                function test_Alignment()
                {
                        $this->assertEquals($this->object->Alignment,'agNone');
                        $this->assertEquals($this->object->Alignment,$this->object->defaultAlignment());
                        $this->object->Alignment=agLeft;
                        $this->assertEquals($this->object->Alignment,'agLeft');
                }

                function test_Caption()
                {
                        $this->assertEquals($this->object->Caption,'');
                        $this->assertEquals($this->object->Caption,$this->object->defaultCaption());
                        $this->object->Caption="holaaaa";
                        $this->assertEquals($this->object->Caption,'holaaaa');

                       //TODO: Check this, properties changing other properties on the IDE
                        $this->object->Name="Label1";
                        $this->assertEquals($this->object->Caption,'holaaaa');
                }

                function test_DesignColor()
                {
                        $this->assertEquals($this->object->DesignColor,'');
                        $this->assertEquals($this->object->defaultDesignColor(),$this->object->DesignColor);
                        $this->object->DesignColor="#FF00FF";
                        $this->assertEquals($this->object->DesignColor,'#FF00FF');
                }

                function test_Color()
                {
                        $this->assertEquals($this->object->Color,'');
                        $this->assertEquals($this->object->defaultColor(),$this->object->Color);
                        $this->object->Color="#FF00FF";
                        $this->assertEquals($this->object->Color,'#FF00FF');
                }

                function test_Visible()
                {
                        $this->assertEquals($this->object->Visible,1);
                        $this->assertEquals($this->object->defaultVisible(),$this->object->Visible);
                        $this->object->Visible=0;
                        $this->assertEquals($this->object->Visible,0);
                }

                function test_dumpContents()
                {
                        ob_start();
                        $this->object->Name="Label1";
                        $this->object->show();
                        $c=ob_get_contents();
                        ob_end_clean();
                        $this->assertEquals(trim($c),trim('<div id="Label1" style=" font-family: Verdana; font-size: 10px;  height:13px;width:75px;"  ></div>'));
                }

                function test_OnClick()
                {
                        $this->assertEquals($this->object->OnClick,null);
                        $this->assertEquals($this->object->defaultOnClick(),$this->object->OnClick);
                        $this->object->OnClick= 'event';
                        $this->assertEquals($this->object->OnClick,'event');
                }

                function test_OnDblClick()
                {
                        $this->assertEquals($this->object->OnDblClick,null);
                        $this->assertEquals($this->object->defaultOnDblClick(),$this->object->OnDblClick);
                        $this->object->OnDblClick= 'event';
                        $this->assertEquals($this->object->OnDblClick,'event');
                }

                 function test_LinkTarget()
                {
                        $this->assertEquals($this->object->LinkTarget,"");
                        $this->assertEquals($this->object->defaultLinkTarget(),$this->object->LinkTarget);
                        $this->object->LinkTarget= 'Link Target, Link Target, Link Target';
                        $this->assertEquals($this->object->LinkTarget,'Link Target, Link Target, Link Target');
                }

                 function test_WordWrap()
                {
                        $this->assertEquals($this->object->WordWrap,1);
                        $this->assertEquals($this->object->defaultWordWrap(),$this->object->WordWrap);
                        $this->object->WordWrap=0;
                        $this->assertEquals($this->object->WordWrap,0);
                }
        }

                    if ($_SERVER['PHP_SELF']!='') $script=$_SERVER['PHP_SELF'];
                    else $script=$_GET['script'];

        if ($script=='/test_customlabel.inc.php')
        {
                        echo "<html>";
                        echo "<head>";
                        echo "<title>PHP-Unit Results</title>";
                        echo "<STYLE TYPE=\"text/css\">";
                        include("phpunit/stylesheet.css");
                        echo "</STYLE>";
                        echo "</head>";
                        echo "<body>";
                        $suite = new TestSuite( "CustomLabelTest" );
                        $testRunner = new TestRunner();
                        $testRunner->run( $suite );
                }


?>
