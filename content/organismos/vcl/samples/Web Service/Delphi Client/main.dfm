object DelphiWebServiceClientSample: TDelphiWebServiceClientSample
  Left = 0
  Top = 0
  Caption = 'DelphiWebServiceClientSample'
  ClientHeight = 390
  ClientWidth = 624
  Color = clBtnFace
  Font.Charset = DEFAULT_CHARSET
  Font.Color = clWindowText
  Font.Height = -11
  Font.Name = 'Tahoma'
  Font.Style = []
  OldCreateOrder = False
  PixelsPerInch = 96
  TextHeight = 13
  object Label1: TLabel
    Left = 248
    Top = 19
    Width = 31
    Height = 13
    Caption = 'Label1'
  end
  object Button1: TButton
    Left = 32
    Top = 16
    Width = 75
    Height = 25
    Caption = 'Echo Service'
    TabOrder = 0
    OnClick = Button1Click
  end
  object Edit1: TEdit
    Left = 112
    Top = 16
    Width = 121
    Height = 21
    TabOrder = 1
    Text = 'Edit1'
  end
  object Button2: TButton
    Left = 32
    Top = 80
    Width = 161
    Height = 25
    Caption = 'StringArrayToIntArray'
    TabOrder = 2
    OnClick = Button2Click
  end
  object ListBox1: TListBox
    Left = 32
    Top = 128
    Width = 233
    Height = 201
    ItemHeight = 13
    TabOrder = 3
  end
end
