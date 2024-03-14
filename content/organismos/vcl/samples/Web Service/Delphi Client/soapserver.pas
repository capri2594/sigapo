// ************************************************************************ //
// The types declared in this file were generated from data read from the
// WSDL File described below:
// WSDL     : http://localhost:3569/soapserver.php?wsdl
//  >Import : http://localhost:3569/soapserver.php?wsdl:0
// Encoding : ISO-8859-1
// Version  : 1.0
// (26/02/2007 12:29:57 - * $Rev: 3108 $)
// ************************************************************************ //

unit soapserver;

interface

uses InvokeRegistry, SOAPHTTPClient, Types, XSBuiltIns;

const
  AS_UNBOUNDED = false;

type

  // ************************************************************************ //
  // The following types, referred to in the WSDL document are not being represented
  // in this file. They are either aliases[@] of other types represented or were referred
  // to but never[!] declared in the document. The types from the latter category
  // typically map to predefined/known XML or Borland types; however, they could also 
  // indicate incorrect WSDL documents that failed to declare or import a schema type.
  // ************************************************************************ //
  // !:string          - "http://www.w3.org/2001/XMLSchema"
  // !:integer         - "http://www.w3.org/2001/XMLSchema"

  ArrayOfstring = array of WideString;          { "http://localhost"[GblCplx] }
  ArrayOfinteger = array of integer;            { "http://localhost"[GblCplx] }

  // ************************************************************************ //
  // Namespace : http://localhost/
  // soapAction: http://localhost/soapserver.php/%operationName%
  // transport : http://schemas.xmlsoap.org/soap/http
  // style     : rpc
  // binding   : VCLWebServiceBinding
  // service   : VCLWebService
  // port      : VCLWebServicePort
  // URL       : http://localhost:3569/soapserver.php
  // ************************************************************************ //
  VCLWebServicePortType = interface(IInvokable)
  ['{2E51F07C-1564-1B1B-A2D8-45B42189790A}']
    function  serviceEcho(const input: WideString): WideString; stdcall;
    function  StringArrayToIntArray(const input: ArrayOfstring): ArrayOfinteger; stdcall;
  end;

function GetVCLWebServicePortType(UseWSDL: Boolean=System.False; Addr: string=''; HTTPRIO: THTTPRIO = nil): VCLWebServicePortType;


implementation
  uses SysUtils;

function GetVCLWebServicePortType(UseWSDL: Boolean; Addr: string; HTTPRIO: THTTPRIO): VCLWebServicePortType;
const
  defWSDL = 'http://localhost:3569/soapserver.php?wsdl';
  defURL  = 'http://localhost:3569/soapserver.php';
  defSvc  = 'VCLWebService';
  defPrt  = 'VCLWebServicePort';
var
  RIO: THTTPRIO;
begin
  Result := nil;
  if (Addr = '') then
  begin
    if UseWSDL then
      Addr := defWSDL
    else
      Addr := defURL;
  end;
  if HTTPRIO = nil then
    RIO := THTTPRIO.Create(nil)
  else
    RIO := HTTPRIO;
  try
    Result := (RIO as VCLWebServicePortType);
    if UseWSDL then
    begin
      RIO.WSDLLocation := Addr;
      RIO.Service := defSvc;
      RIO.Port := defPrt;
    end else
      RIO.URL := Addr;
  finally
    if (Result = nil) and (HTTPRIO = nil) then
      RIO.Free;
  end;
end;


initialization
  InvRegistry.RegisterInterface(TypeInfo(VCLWebServicePortType), 'http://localhost/', 'ISO-8859-1');
  InvRegistry.RegisterDefaultSOAPAction(TypeInfo(VCLWebServicePortType), 'http://localhost/soapserver.php/%operationName%');
  RemClassRegistry.RegisterXSInfo(TypeInfo(ArrayOfstring), 'http://localhost', 'ArrayOfstring');
  RemClassRegistry.RegisterXSInfo(TypeInfo(ArrayOfinteger), 'http://localhost', 'ArrayOfinteger');

end.