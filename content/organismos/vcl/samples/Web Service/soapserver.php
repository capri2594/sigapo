<?php
        require_once("vcl/vcl.inc.php");
        //Includes
        use_unit("webservices.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        /*
        * Returns the input
        */
        function serviceEcho($input)
        {
                return($input);
        }

        /*
        * Converts the input array, which are strings, to an array of integers
        */
        function StringArrayToIntArray($inputarray)
        {
                $result=array();
                reset($inputarray);
                while(list($key, $val)=each($inputarray))
                {
                        $result[]=(int)$val;
                }

                return($result);
        }

        //Class definition
        class SoapServer extends DataModule
        {
               public $MyWebService = null;
               function MyWebServiceAddComplexTypes($sender, $params)
               {
                //Add the complex type array of strings
                $this->MyWebService->addComplexType
                (
                        'ArrayOfstring',
                        'complexType',
                        'array',
                        '',
                        'SOAP-ENC:Array',
                        array(),
                        array(array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'string[]')),
                        'xsd:string'
                );

                //Add the complex type array of integers
                $this->MyWebService->addComplexType
                (
                        'ArrayOfinteger',
                        'complexType',
                        'array',
                        '',
                        'SOAP-ENC:Array',
                        array(),
                        array(array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'integer[]')),
                        'xsd:integer'
                );
               }

               function MyWebServiceRegisterServices($sender, $params)
               {
                        //Register the echo service
                        $this->MyWebService->register(
                        "serviceEcho",
                        array('input'=>'xsd:string'),
                        array('return'=>'xsd:string'),
                        'http://localhost/'
                        );


                        //Register the conversion service
                        $this->MyWebService->register(
                        "StringArrayToIntArray",
                        array('input'=>'tns:ArrayOfstring'),
                        array('return'=>'tns:ArrayOfinteger'),
                        'http://localhost/'
                        );

               }

        }

        global $application;

        global $SoapServer;

        //Creates the form
        $SoapServer=new SoapServer($application);

        //Read from resource file
        $SoapServer->loadResource(__FILE__);

?>
