program DelphiClientSample;

uses
  Forms,
  main in 'main.pas' {DelphiWebServiceClientSample},
  soapserver in 'soapserver.pas';

{$R *.res}

begin
  Application.Initialize;
  Application.CreateForm(TDelphiWebServiceClientSample, DelphiWebServiceClientSample);
  Application.Run;
end.
