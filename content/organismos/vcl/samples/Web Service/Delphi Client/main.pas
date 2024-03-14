unit main;

interface

uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, StdCtrls;

type
  TDelphiWebServiceClientSample = class(TForm)
    Button1: TButton;
    Label1: TLabel;
    Edit1: TEdit;
    Button2: TButton;
    ListBox1: TListBox;
    procedure Button1Click(Sender: TObject);
    procedure Button2Click(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

var
  DelphiWebServiceClientSample: TDelphiWebServiceClientSample;

implementation

uses soapserver;

{$R *.dfm}

procedure TDelphiWebServiceClientSample.Button1Click(Sender: TObject);
begin
    //Set the label caption with the result of calling the "echo" service
    label1.caption:=GetVCLWebServicePortType.serviceEcho(edit1.text);
end;

procedure TDelphiWebServiceClientSample.Button2Click(Sender: TObject);
var
  input: ArrayOfstring;
  i: integer;
  result: ArrayOfinteger;
begin
  setlength(input,10);
  for i := 0 to 9 do begin
      input[i]:=inttostr(i);
  end;

  //Fills the listbox with the integers returned from the service
  result:=GetVCLWebServicePortType.StringArrayToIntArray(input);

    listbox1.clear;
  for i := 0 to high(result) do begin
    listbox1.items.add(inttostr(result[i]));
  end;

end;

end.
