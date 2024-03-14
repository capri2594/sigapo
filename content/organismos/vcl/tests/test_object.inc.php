<?php

        require_once "phpunit/phpunit.php";
        require_once "../system.inc.php";


        class DerivedObject extends Object
        {
                private $_property;

                function method()
                {
                }

                function setProperty($value)
                {
                        $this->_property=$value;
                }

                function getProperty()
                {
                        return($this->_property);
                }
        }

        class ObjectTest extends TestCase
        {
                public $object;

                function setup()
                {
                        $this->object=new DerivedObject();
                }

                function test___construct()
                {
                }

                function test_className()
                {
                        $object=new DerivedObject();
                        $this->assertEquals($object->ClassName(),'DerivedObject');
                }

                function test_classNameIs()
                {
                        $object=new DerivedObject();
                        $this->assertEquals($object->ClassNameIs('DerivedObject'),true);
                }

                function test_methodExists()
                {
                        $this->assertEquals($this->object->methodExists('methodExists'),true);
                }

                function test_classParent()
                {
                        $object=new DerivedObject();
                        $this->assertEquals($object->classParent(),'Object');
                }
        
                function test_inheritsFrom()
                {
                        $this->assertEquals($this->object->inheritsFrom('Object'),true);
                }

                function test_readProperty()
                {
                        if ($this->object->className()!='Persistent')
                        {
                                $_POST['value']='test_value';
                                $this->object->readProperty('Tag','value');

                                $this->assertEquals($this->object->Tag,'test_value');
                        }
                }

                function test___get()
                {
                        $object=new DerivedObject();

                        $object->Property="hola";
                        $this->assertEquals($object->Property,'hola');
                }

                function test___set()
                {
                        $object=new DerivedObject();

                        $object->Property="hola";
                        $this->assertEquals($object->Property,'hola');
                }

                function test_dump_properties_and_methods_not_tested()
                {
                        $methods=get_class_methods($this->object->className());
                        $testmethods=get_class_methods(get_class($this));
                        reset($methods);
                        $nottested=0;
                        echo "<pre>";
                        echo "Properties and Methods not tested\n";
                        echo "---------------------------------\n";
                        while (list($k,$v)=each($methods))
                        {
                                $mname=$v;
                                $fst=substr($v,0,3);
                                $fr=substr($v,0,4);
                                $fw=substr($v,0,5);
                                $fd=substr($v,0,7);

                                if ($fd=='default') continue;
                                if (($fst=='set') || ($fst=='get')) $mname=substr($v,3);
                                if ($fr=='read') $mname=substr($v,4);
                                if ($fw=='write') $mname=substr($v,5);

                                $keys=array_keys($testmethods,"test_".$mname);
                                if (count($keys)==0)
                                {
                                        $keys=array_keys($testmethods,"test_".$v);
                                        if (count($keys)==0)
                                        {
                                                $nottested++;
                                                echo $this->object->className()."::".$v."\n";
                                        }

                                }
                        }
                        echo "</pre>";
                        $this->assertEquals($nottested,0);
                }

        
        }
        
		    if ($_SERVER['PHP_SELF']!='') $script=$_SERVER['PHP_SELF'];
		    else $script=$_GET['script'];

        if ($script=='/test_object.inc.php')
        {        
                echo "<html>";
                echo "<head>";
                echo "<title>PHP-Unit Results</title>";
                echo "<STYLE TYPE=\"text/css\">";
                include("phpunit/stylesheet.css");
                echo "</STYLE>";
                echo "</head>";
                echo "<body>";
        $suite = new TestSuite( "ObjectTest" );
        $testRunner = new TestRunner();
        $testRunner->run( $suite );
        }


?>
