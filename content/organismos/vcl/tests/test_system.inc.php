<?php

        require_once "phpunit/phpunit.php";
        require_once "../system.inc.php";
        
        
        class DerivedObject extends Object
        {
                public $property;

                function method()
                {
                }

                function setProperty($value)
                {
                        $this->property=$value;
                }
        }

        class SystemTest extends TestCase
        {
                public $object;
                
                function setup()
                {
                        $this->object=new DerivedObject();      
                }
                
                function test_ClassName()
                {
                        $this->assertEquals($this->object->ClassName(),'DerivedObject');
                }
                
                function test_ClassNameIs()
                {
                        $this->assertEquals($this->object->ClassNameIs('DerivedObject'),true);
                }               
                
                function test_methodExists()
                {
                        $this->assertEquals($this->object->methodExists('method'),true);        
                }
        
                function test_classParent()
                {
                        $this->assertEquals($this->object->classParent(),'Object');                     
                }
        
                function test_inheritsFrom()
                {
                        $this->assertEquals($this->object->inheritsFrom('Object'),true);
                }

                function test_readProperty()
                {
                        $_POST['value']='test_value';
                        $this->object->readProperty('property','value');

                        $this->assertEquals($this->object->property,'test_value');
                }

        
        }
        
                echo "<html>";
                echo "<head>";
                echo "<title>PHP-Unit Results</title>";
                echo "<STYLE TYPE=\"text/css\">";
                include("phpunit/stylesheet.css");
                echo "</STYLE>";
                echo "</head>";
                echo "<body>";  
        $suite = new TestSuite( "SystemTest" );
        $testRunner = new TestRunner();
        $testRunner->run( $suite );     

    
?>
