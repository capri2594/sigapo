<?php
        require_once "phpunit/phpunit.php";
        require_once "../vcl.inc.php";
        require_once "test_persistent.inc.php";
        require_once "test_object.inc.php";
        use_unit("classes.inc.php");
        use_unit("stdctrls.inc.php");
        use_unit("forms.inc.php");
        use_unit("controls.inc.php");
        use_unit("extctrls.inc.php");

        class ComponentTest extends PersistentTest
        {
                function setup()
                {
                        $this->object=new Component();
                }

                function test_Tag()
                {
                        $this->assertEquals($this->object->Tag,0);
                        $this->assertEquals($this->object->Tag,$this->object->defaultTag());
                        $this->object->Tag=10;
                        $this->assertEquals($this->object->Tag,10);
                }

                function test_ControlState()
                {
                        $this->assertEquals($this->object->ControlState,0);
                        $this->object->ControlState=csLoading;
                        $this->assertEquals($this->object->ControlState,csLoading);
                }

                function test_Name()
                {
                        $this->assertEquals($this->object->Name,'');
                        $this->assertEquals($this->object->Name,$this->object->defaultName());
                        $this->object->Name="component1";
                        $this->assertEquals($this->object->Name,"component1");

                        $own=new Component();
                        $obj=new Component($own);
                        $obj->Name="c1";
                        $aobj=new Component($own);
                        try
                        {
                                $aobj->Name="c1";

                                //This must not be executed
                                $this->assertEquals(0,1);
                        }
                        catch(Exception $e)
                        {
                                //Must be here
                                $this->assertEquals(1,1);
                        }
                }

                function test_Owner()
                {
                        $this->assertEquals($this->object->Owner,null);

                        $own=new Component();
                        $obj=new Component($own);
                        $obj->Name="c1";

                        $this->assertEquals(($obj->Owner!=null),true);
                }

                function test_NamePath()
                {
                        $own=new Component();
                        $own->Name="owner";
                        $obj=new Component($own);
                        $obj->Name="owned";
                        $this->assertEquals($obj->NamePath,"owned");
                }

                function test_ComponentCount()
                {
                        $own=new Component();
                        $own->Name="owner";
                        $obj=new Component($own);
                        $obj->Name="owned";
                        $this->assertEquals($own->ComponentCount,1);
                }

                function test_Components()
                {
                        $own=new Component();
                        $own->Name="owner";
                        $obj=new Component($own);
                        $obj->Name="owned";
                        $this->assertEquals($own->Components->count(),1);
                }

                function test_removeComponent()
                {
                        $own=new Component();
                        $own->Name="owner";
                        $obj=new Component($own);
                        $obj->Name="owned";
                        $own->removeComponent($obj);
                        $this->assertEquals($own->Components->count(),0);
                }

                function test_insertComponent()
                {
                        $own=new Component();
                        $own->Name="owner";
                        $obj=new Component($own);
                        $obj->Name="owned";

                        $obj2=new Component();
                        $obj2->Name="owned2";
                        $own->insertComponent($obj2);
                        $this->assertEquals($own->Components->count(),2);
                }

                function test_callEvent()
                {
                        //TODO: Check here how to test events
                }

                function test_init()
                {
                        //Nothing to test
                }

                function test_loaded()
                {
                        //Nothing to test
                }

                function test_loadedChildren()
                {
                        //Nothing to test
                }


                function test_serializeChildren()
                {
                        $own=new Component();
                        $own->Name="Form";
                        $object=new Component($own);
                        $object->Name="Component";
                        $object->serialize();
                        //print_r($_SESSION);
                        $this->assertEquals($_SESSION['Form.Component.Tag'],0);
                        $object->Tag=10;
                        $own->serializeChildren();
                        $object->Tag=0;
                        $object->unserializeChildren();
                        $this->assertEquals($_SESSION['Form.Component.Tag'],10);

                }

                function test_unserializeChildren()
                {
                        $this->test_serializeChildren();
                }

                function test_generateAjaxEvent()
                {
                        $own=new Component();
                        $own->Name="pepe";
                        $this->object->owner=$own;
                        $this->assertEquals(trim($this->object->generateAjaxEvent("onclick", "button1_click")),'onclick="xajax_ajaxProcess(\'pepe\',\'\',null,\'button1_click\',xajax.getFormValues(\'pepe\'))"');
                }

                function test_dumpHeaderCode() {}
                function test_dumpChildrenJavascript() {}
                function test_dumpChildrenHeaderCode() {}

                function test_readFromResource()
                {
                        $c=new Component();
                        $this->assertEquals($c->Tag,0);
                        $c->readFromResource("test.xml.php");
                        $this->assertEquals($c->Tag,'10');
                }

                function test_loadResource()
                {
                        $c=new Component();
                        $this->assertEquals($c->Tag,0);
                        $c->loadResource("test.php");
                        $this->assertEquals($c->Tag,'10');
                }

          /*    function test_updateDataField()
                {
                        $c=new Edit();
                        $t=new Table();
                        $this->assertEquals($c->DataField,'');
                        $c->DataSource->DataSet=$t->TableName;

                }
            */
                function test_fixupProperty()
                {
                        $my_edit=new Edit();
                        $obj=new Object();
                        $my_edit->DataSource=$obj;
                        $my_edit->DataSource=$this->object->fixupProperty($obj);
                        $this->assertEquals($my_edit->DataSource,$obj);
                }
        }

                    if ($_SERVER['PHP_SELF']!='') $script=$_SERVER['PHP_SELF'];
                    else $script=$_GET['script'];

        if ($script=='/test_component.inc.php')
        {
                        echo "<html>";
                        echo "<head>";
                        echo "<title>PHP-Unit Results</title>";
                        echo "<STYLE TYPE=\"text/css\">";
                        include("phpunit/stylesheet.css");
                        echo "</STYLE>";
                        echo "</head>";
                        echo "<body>";
                        $suite = new TestSuite( "ComponentTest" );
                        $testRunner = new TestRunner();
                        $testRunner->run( $suite );
                }


?>
