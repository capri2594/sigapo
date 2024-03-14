<?php
        ini_set('display_errors',1);
        error_reporting(E_ALL);

        require_once "phpunit/phpunit.php";
        require_once "vcl/vcl.inc.php";
        use_unit("system.inc.php");

        class InputFilterTest extends TestCase
        {
                function setup()
                {
                                //Nothing to do here
                }

                function test_asString1()
                {

                        //TODO: Put here more types of cross-site scripting attacks and SQL Injection (when that is ready)

                        //First, we try to put some javascript on the input
                        $_GET['trytohack']="value<script>alert('hello');</script>";

                        global $input;

                        //Get the parameter from the input stream
                        $trytohack=$input->trytohack;
                        //Must be an object
                        if (is_object($trytohack))
                        {
                                //To test the native input filtering, uncomment these lines
                                $trytohack->filter_extension=false;
                                $trytohack->createNativeFilter();


                                //Get the clean input from the user
                                $clean=$trytohack->asString();

                                //Must have been cleaned of the script content
                                $this->assertEquals($clean,"valuealert(&#39;hello&#39);");
                                echo $clean;
                        }
                        else
                        {
                                //Must return an object
                                $this->assertEquals(false, true, 'Error, $input doesn\'t return the object for the parameter');
                        }
                }

                 function test_asString2()
                 {
                        global $input;
                        //test 1 for alert(document.cookie);
                        $_GET['trytohack']="<script>alert(document.cookie);</script>";
                        $trytohack=$input->trytohack;
                        if (is_object($trytohack))
                        {
                                $clean=$trytohack->asString();
                                $this->assertEquals($clean,"alert(document.cookie);");
                                echo $clean;
                        }
                        else
                        {
                                $this->assertEquals(false, true, 'Error, $input doesn\'t return the object for the parameter');
                        }

                 }

                  function test_asString3()
                  {
                        global $input;
                        //test 2 for alert(String.fromCharCode(88,83,83))
                        $_GET['trytohack']="<SCRIPT>alert(String.fromCharCode(88,83,83))</SCRIPT>";
                        $trytohack=$input->trytohack;
                        if (is_object($trytohack))
                        {
                                $clean=$trytohack->asString();
                                $this->assertEquals($clean,"alert(String.fromCharCode(88,83,83))");
                                echo $clean;
                        }
                        else
                        {
                                $this->assertEquals(false, true, 'Error, $input doesn\'t return the object for the parameter');
                        }
                  }

                  function test_asString4()
                  {
                         global $input;
                        //test 3 for <IMG SRC="javascript:alert('XSS');">
                        $_GET['trytohack']="<IMG SRC=\"javascript:alert('XSS');\">";
                        $trytohack=$input->trytohack;
                        if (is_object($trytohack))
                        {
                                $clean=$trytohack->asString();
                                $this->assertEquals($clean,"");
                                echo "hallo1";
                                echo $clean;
                                echo "hallo2";

                        }
                        else
                        {
                                $this->assertEquals(false, true, 'Error, $input doesn\'t return the object for the parameter');
                        }
                    }

                  function test_asString5()
                  {
                        global $input;
                        //test 4 for <<SCRIPT>alert("XSS");//<</SCRIPT>
                        $_GET['trytohack']="<<SCRIPT>alert('XSS');//<</SCRIPT>";
                        $trytohack=$input->trytohack;
                        if (is_object($trytohack))
                        {
                                $clean=$trytohack->asString();
                                $this->assertEquals($clean,"");
                                echo $clean;
                        }
                        else
                        {
                                $this->assertEquals(false, true, 'Error, $input doesn\'t return the object for the parameter');
                        }
                  }


                  function test_asString6()
                  {
                        global $input;
                        //test for <IMG SRC=&#106;&#97;&#118;&#97;&#115;&#99;&#114;&#105;&#112;&#116;&#58;&#97;&#108;&#101;&#114;&#116;&#40;&#39;&#88;&#83;&#83;&#39;&#41;>
                        $_GET['trytohack']="<IMG SRC=&#106;&#97;&#118;&#97;&#115;&#99;&#114;&#105;&#112;&#116;&#58;&#97;&#108;&#101;&#114;&#116;&#40;&#39;&#88;&#83;&#83;&#39;&#41;>";
                        $trytohack=$input->trytohack;
                        if (is_object($trytohack))
                        {
                                $clean=$trytohack->asString();
                                $this->assertEquals($clean,"");
                                echo $clean;
                        }
                        else
                        {
                                $this->assertEquals(false, true, 'Error, $input doesn\'t return the object for the parameter');
                        }
                }

                function test_asString7()
                  {
                        global $input;
                        //test for <IMG SRC="jav&#x09;ascript:alert('XSS');">
                        $_GET['trytohack']="<IMG SRC=\"jav&#x09;ascript:alert('XSS');\">";
                        $trytohack=$input->trytohack;
                        if (is_object($trytohack))
                        {
                                $clean=$trytohack->asString();
                                $this->assertEquals($clean,"");
                                echo $clean;
                        }
                        else
                        {
                                $this->assertEquals(false, true, 'Error, $input doesn\'t return the object for the parameter');
                        }
                }

                 function test_asBoolean1()
                 {
                        global $input;
                        $_GET['trytohack']="<<SCRIPT>alert('XSS');//<</SCRIPT>";
                        $trytohack=$input->trytohack;
                        if (is_object($trytohack))
                        {
                                $clean=$trytohack->asBoolean();
                                $this->assertEquals($clean, null);
                                echo $clean;
                        }
                        else
                        {
                                $this->assertEquals(false, true, 'Error, $input doesn\'t return the object for the parameter');
                        }
                }

                function test_asFloat1()
                 {
                        global $input;
                        $_GET['trytohack']="value<script>alert('hello');</script>";
                        $trytohack=$input->trytohack;
                        if (is_object($trytohack))
                        {
                                $clean=$trytohack->asFloat();
                                $this->assertEquals($clean, "");
                                echo $clean;
                        }
                        else
                        {
                                $this->assertEquals(false, true, 'Error, $input doesn\'t return the object for the parameter');
                        }
                }

                function test_asURL1()
                 {
                        global $input;
                        $_GET['trytohack']="value<script>alert('hello');</script>";
                        $trytohack=$input->trytohack;
                        if (is_object($trytohack))
                        {
                                $clean=$trytohack->asURL();
                                $this->assertEquals($clean, "");
                                echo $clean;
                        }
                        else
                        {
                                $this->assertEquals(false, true, 'Error, $input doesn\'t return the object for the parameter');
                        }
                }

                function test_asEmail1()
                 {
                        global $input;
                        $_GET['trytohack']="value<script>alert('hello');</script>";
                        $trytohack=$input->trytohack;
                        if (is_object($trytohack))
                        {
                                $clean=$trytohack->asEmail();
                                $this->assertEquals($clean, "valuescriptalert'hello'/script");
                                echo $clean;
                        }
                        else
                        {
                                $this->assertEquals(false, true, 'Error, $input doesn\'t return the object for the parameter');
                        }
                }

                  function test_asIP1()
                 {
                        global $input;
                        $_GET['trytohack']="value<script>alert('hello');</script>";
                        $trytohack=$input->trytohack;
                        if (is_object($trytohack))
                        {
                                $clean=$trytohack->asIP();
                                $this->assertEquals($clean, null);
                                echo $clean;
                        }
                        else
                        {
                                $this->assertEquals(false, true, 'Error, $input doesn\'t return the object for the parameter');
                        }
                }

                function test_asStripped1()
                 {
                        global $input;
                        $_GET['trytohack']="value<script>alert('hello');</script>";
                        $trytohack=$input->trytohack;
                        if (is_object($trytohack))
                        {
                                $clean=$trytohack->asStripped();
                                $this->assertEquals($clean, "valuealert(&#39;hello&#39;);");
                                echo $clean;
                        }
                        else
                        {
                                $this->assertEquals(false, true, 'Error, $input doesn\'t return the object for the parameter');
                        }
                }

                function test_asEncoded1()
                 {
                        global $input;
                        $_GET['trytohack']="value<script>alert('hello');</script>";
                        $trytohack=$input->trytohack;
                        if (is_object($trytohack))
                        {
                                $clean=$trytohack->asEncoded();
                                $this->assertEquals($clean, "value%3Cscript%3Ealert%28%27hello%27%29%3B%3C%2Fscript%3E");
                                echo $clean;
                        }
                        else
                        {
                                $this->assertEquals(false, true, 'Error, $input doesn\'t return the object for the parameter');
                        }
                }

                 function test_asSpecialChars1()
                 {
                        global $input;
                        $_GET['trytohack']="value<script>alert('hello');</script>";
                        $trytohack=$input->trytohack;
                        if (is_object($trytohack))
                        {
                                $clean=$trytohack->asSpecialChars();
                                $this->assertEquals($clean, "value&#60;script&#62;alert(&#39;hello&#39;);&#60;/script&#62;");
                                echo $clean;
                        }
                        else
                        {
                                $this->assertEquals(false, true, 'Error, $input doesn\'t return the object for the parameter');
                        }
                }

                 function test_asUnsafeRaw1()
                 {
                        global $input;
                        $_GET['trytohack']="value<script>alert('hello');</script>";
                        $trytohack=$input->trytohack;
                        if (is_object($trytohack))
                        {
                                $clean=$trytohack->asUnsafeRaw();
                                $this->assertEquals($clean, null);
                                echo $clean;
                        }
                        else
                        {
                                $this->assertEquals(false, true, 'Error, $input doesn\'t return the object for the parameter');
                        }
                }
        }


        if ($_SERVER['PHP_SELF']!='') $script=$_SERVER['PHP_SELF'];
        else $script=$_GET['script'];

        if ($script=='/test_input_filter.inc.php')
        {
                echo "<html>";
                echo "<head>";
                echo "<title>PHP-Unit Results</title>";
                echo "<STYLE TYPE=\"text/css\">";
                include("phpunit/stylesheet.css");
                echo "</STYLE>";
                echo "</head>";
                echo "<body>";
                $suite = new TestSuite( "InputFilterTest" );
                $testRunner = new TestRunner();
                $testRunner->run( $suite );
        }


?>
