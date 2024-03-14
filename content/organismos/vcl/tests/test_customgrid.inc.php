<?php
        ini_set('display_errors',1);
        error_reporting(E_ALL);

        require_once "phpunit/phpunit.php";
        require_once "../vcl.inc.php";
        require_once "test_customcontrol.inc.php";
        require_once "../grids.inc.php";
        use_unit("stdctrls.inc.php");

        class CustomGridTest extends CustomControlTest
        {
                function setup()
                {
                        $this->object=new CustomGrid();
                }

     /*           function test_jsOnRowSelect()
                {
                        $this->assertEquals($this->object->jsOnRowSelect, null);
                        $this->assertEquals($this->object->defaultjsOnRowSelect(),$this->object->jsOnRowSelect);
                        $this->object->jsOnRowSelect= 'onRowSelectEvent';
                        $this->assertEquals($this->object->jsOnRowSelect, 'onRowSelectEvent');
                }

                function test_jsOnColDisplay()
                {
                        $this->assertEquals($this->object->jsOnColDisplay, null);
                        $this->assertEquals($this->object->defaultjsOnColDisplay(),$this->object->jsOnColDisplay);
                        $this->object->jsOnColDisplay= 'onCol display Event';
                        $this->assertEquals($this->object->jsOnColDisplay, 'onCol display Event');
                }

                 function test_Sortable()
                {
                        $this->assertEquals($this->object->Sortable, 1);
                        $this->object->Sortable= 0;
                        $this->assertEquals($this->object->Sortable, 0);
                }

                function test_HighLightRows()
                {
                        $this->assertEquals($this->object->HighLightRows, 1);
                        $this->object->HighLightRows= 0;
                        $this->assertEquals($this->object->HighLightRows, 0);
                }

                function test_ShowRowNumbers()
                {
                        $this->assertEquals($this->object->ShowRowNumbers, 1);
                        $this->object->ShowRowNumbers= 0;
                        $this->assertEquals($this->object->ShowRowNumbers, 0);
                }
          */
         }
      if ($_SERVER['PHP_SELF']!='') $script=$_SERVER['PHP_SELF'];
        else $script=$_GET['script'];

       if ($script=='/test_customgrid.inc.php')
        {
                echo "<html>";
                echo "<head>";
                echo "<title>PHP-Unit Results</title>";
                echo "<STYLE TYPE=\"text/css\">";
                include("phpunit/stylesheet.css");
                echo "</STYLE>";
                echo "</head>";
                echo "<body>";
                $suite = new TestSuite( "CustomGridTest" );
                $testRunner = new TestRunner();
                $testRunner->run( $suite );
        }


?>
