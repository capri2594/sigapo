<?php
/**
*  This file is part of the VCL for PHP project
*
*  Copyright (c) 2004-2007 qadram software <support@qadram.com>
*
*  Checkout AUTHORS file for more information on the developers
*
*  This library is free software; you can redistribute it and/or
*  modify it under the terms of the GNU Lesser General Public
*  License as published by the Free Software Foundation; either
*  version 2.1 of the License, or (at your option) any later version.
*
*  This library is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
*  Lesser General Public License for more details.
*
*  You should have received a copy of the GNU Lesser General Public
*  License along with this library; if not, write to the Free Software
*  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
*  USA
*
*/

require_once("vcl/vcl.inc.php");
use_unit("classes.inc.php");
use_unit("nusoap/nusoap.php");

class Service extends Component
{
        private $_server = null;

        protected $_active = false;

        /**
        * Specifies if the webservice is active or not, if it's true, the component will fire the events
        * to get the functions to register and any complex type required and will publish the WSDL and process
        * service requests
        */
        function getActive() { return $this->_active; }
        function setActive($value) { $this->_active = $value; }
        function defaultActive() { return false; }

        protected $_servicename = "VCL";

        /**
        * Specifies the Name of the service you want to create
        */
        function getServiceName() { return $this->_servicename; }
        function setServiceName($value) { $this->_servicename = $value; }
        function defaultServiceName() { return "VCL"; }

        protected $_namespace = "http://localhost";

        /**
        * Specifies the Name Space for the WSDL
        */
        function getNameSpace() { return $this->_namespace; }
        function setNameSpace($value) { $this->_namespace = $value; }
        function defaultNameSpace() { return false; }

        protected $_schematargetnamespace = "http://localhost/xsd";

        /**
        * Specifies the Target Name Space for the WSDL
        */
        function getSchemaTargetNamespace() { return $this->_schematargetnamespace; }
        function setSchemaTargetNamespace($value) { $this->_schematargetnamespace = $value; }
        function defaultSchemaTargetNamespace() { return ""; }


        protected $_onregisterservices = null;

        /**
        * Fired when the service needs to register the functions to be published by the service, see also register method
        */
        function getOnRegisterServices() { return $this->_onregisterservices; }
        function setOnRegisterServices($value) { $this->_onregisterservices = $value; }
        function defaultOnRegisterServices() { return null; }

        protected $_onaddcomplextypes = null;

        /**
        * Fired when the service needs to register complex types, see also addComplexType
        */
        function getOnAddComplexTypes() { return $this->_onaddcomplextypes; }
        function setOnAddComplexTypes($value) { $this->_onaddcomplextypes = $value; }
        function defaultOnAddComplexTypes() { return null; }

        function init()
        {
                if (($this->ControlState & csDesigning) != csDesigning)
                {
                        if ($this->_active)
                        {
                                //If the webservice is active, create the nusoap object
                                $this->_server = new soap_server();
                                $this->_server->configureWSDL($this->_servicename, $this->_namespace);
                                $this->_server->wsdl->schemaTargetNamespace = $this->_schematargetnamespace;

                                //Call events
                                $this->callEvent('onaddcomplextypes', array());
                                $this->callEvent('onregisterservices', array());

                                global $HTTP_RAW_POST_DATA;

                                $HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA: '';

                                $this->_server->service($HTTP_RAW_POST_DATA);

                                global $log;

                                if(isset($log) and $log != '')
                                {
                                        harness('nusoap_r2_base_server', $this->_server->headers['User-Agent'], $this->_server->methodname, $this->_server->request, $this->_server->response, $this->_server->result);
                                }
                        }
                }
        }

        function __construct($aowner = null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);
        }

        /**
        * register a service function with the server
        *
        * @param    string $name the name of the PHP function, class.method or class..method
        * @param    array $in assoc array of input values: key = param name, value = param type
        * @param    array $out assoc array of output values: key = param name, value = param type
        * @param        mixed $namespace the element namespace for the method or false
        * @param        mixed $soapaction the soapaction for the method or false
        * @param        mixed $style optional (rpc|document) or false Note: when 'document' is specified, parameter and return wrappers are created for you automatically
        * @param        mixed $use optional (encoded|literal) or false
        * @param        string $documentation optional Description to include in WSDL
        * @param        string $encodingStyle optional (usually 'http://schemas.xmlsoap.org/soap/encoding/' for encoded)
        * @access   public
        */
        function register($name,$in=array(),$out=array(),$namespace=false,$soapaction=false,$style=false,$use=false,$documentation='',$encodingStyle='')
        {
                if ($namespace==false) $namespace=$this->_namespace;

                $this->_server->register($name,$in,$out,$namespace,$soapaction,$style,$use,$documentation,$encodingStyle);
        }

        /**
        * adds a complex type to the schema
        *
        * example: array
        *
        * addType(
        *       'ArrayOfstring',
        *       'complexType',
        *       'array',
        *       '',
        *       'SOAP-ENC:Array',
        *       array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'string[]'),
        *       'xsd:string'
        * );
        *
        * example: PHP associative array ( SOAP Struct )
        *
        * addType(
        *       'SOAPStruct',
        *       'complexType',
        *       'struct',
        *       'all',
        *       array('myVar'=> array('name'=>'myVar','type'=>'string')
        * );
        *
        * @param name
        * @param typeClass (complexType|simpleType|attribute)
        * @param phpType: currently supported are array and struct (php assoc array)
        * @param compositor (all|sequence|choice)
        * @param restrictionBase namespace:name (http://schemas.xmlsoap.org/soap/encoding/:Array)
        * @param elements = array ( name = array(name=>'',type=>'') )
        * @param attrs = array(
        *       array(
        *               'ref' => "http://schemas.xmlsoap.org/soap/encoding/:arrayType",
        *               "http://schemas.xmlsoap.org/wsdl/:arrayType" => "string[]"
        *       )
        * )
        * @param arrayType: namespace:name (http://www.w3.org/2001/XMLSchema:string)
        * @access public
        * @see getTypeDef
        */
        function addComplexType($name,$typeClass='complexType',$phpType='array',$compositor='',$restrictionBase='',$elements=array(),$attrs=array(),$arrayType='')
        {
                $this->_server->wsdl->addComplexType($name,$typeClass, $phpType,$compositor,$restrictionBase,$elements,$attrs,$arrayType);
        }

}

?>
