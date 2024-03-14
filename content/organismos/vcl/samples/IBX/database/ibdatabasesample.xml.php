<?php
<object class="Unit220" name="Unit220" baseclass="page">
  <property name="Background"></property>
  <property name="Caption">Database sample</property>
  <property name="DocType">dtNone</property>
  <property name="Font">
    <property name="Align">taNone</property>
    <property name="Case"></property>
    <property name="Color"></property>
    <property name="Family">Verdana</property>
    <property name="LineHeight"></property>
    <property name="Size">10px</property>
    <property name="Style"></property>
    <property name="Variant"></property>
    <property name="Weight"></property>
  </property>
  <property name="Height">600</property>
  <property name="IsMaster">0</property>
  <property name="Layout">
    <property name="Cols">5</property>
    <property name="Rows">5</property>
    <property name="Type">ABS_XY_LAYOUT</property>
  </property>
  <property name="Name">Unit220</property>
  <property name="Width">800</property>
  <property name="OnAfterShow"></property>
  <property name="OnAfterShowFooter"></property>
  <property name="OnBeforeShow"></property>
  <property name="OnBeforeShowHeader"></property>
  <property name="OnCreate"></property>
  <property name="OnShow"></property>
  <property name="OnShowHeader"></property>
  <property name="OnStartBody"></property>
  <property name="OnTemplate"></property>
  <object class="Memo" name="meLog" >
    <property name="Font">
        <property name="Align">taNone</property>
        <property name="Case"></property>
        <property name="Color"></property>
        <property name="Family">Verdana</property>
        <property name="LineHeight"></property>
        <property name="Size">10px</property>
        <property name="Style"></property>
        <property name="Variant"></property>
        <property name="Weight"></property>
    </property>
    <property name="Height">272</property>
    <property name="Left">16</property>
    <property name="Lines">a:0:{}</property>
    <property name="Name">meLog</property>
    <property name="Top">24</property>
    <property name="Width">440</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <property name="OnSubmit"></property>
  </object>
  <object class="Button" name="btnConnect" >
    <property name="Caption">Connect</property>
    <property name="Font">
        <property name="Align">taNone</property>
        <property name="Case"></property>
        <property name="Color"></property>
        <property name="Family">Verdana</property>
        <property name="LineHeight"></property>
        <property name="Size">10px</property>
        <property name="Style"></property>
        <property name="Variant"></property>
        <property name="Weight"></property>
    </property>
    <property name="Height">25</property>
    <property name="Left">480</property>
    <property name="Name">btnConnect</property>
    <property name="Top">24</property>
    <property name="Width">75</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnClick">btnConnectClick</property>
    <property name="OnShow"></property>
  </object>
  <object class="Button" name="btnDisconnect" >
    <property name="Caption">Disconnect</property>
    <property name="Font">
        <property name="Align">taNone</property>
        <property name="Case"></property>
        <property name="Color"></property>
        <property name="Family">Verdana</property>
        <property name="LineHeight"></property>
        <property name="Size">10px</property>
        <property name="Style"></property>
        <property name="Variant"></property>
        <property name="Weight"></property>
    </property>
    <property name="Height">25</property>
    <property name="Left">480</property>
    <property name="Name">btnDisconnect</property>
    <property name="Top">56</property>
    <property name="Width">75</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnClick">btnDisconnectClick</property>
    <property name="OnShow"></property>
  </object>
  <object class="Button" name="Button1" >
    <property name="Caption">Show Tables</property>
    <property name="Font">
        <property name="Align">taNone</property>
        <property name="Case"></property>
        <property name="Color"></property>
        <property name="Family">Verdana</property>
        <property name="LineHeight"></property>
        <property name="Size">10px</property>
        <property name="Style"></property>
        <property name="Variant"></property>
        <property name="Weight"></property>
    </property>
    <property name="Height">25</property>
    <property name="Left">480</property>
    <property name="Name">Button1</property>
    <property name="Top">88</property>
    <property name="Width">75</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnClick">Button1Click</property>
    <property name="OnShow"></property>
  </object>
  <object class="IBDatabase" name="IBDatabase1" >
        <property name="Left">607</property>
        <property name="Top">36</property>
    <property name="Connected"></property>
    <property name="DatabaseName">localhost:C:\Program Files\Common Files\Borland Shared\Data\EMPLOYEE.GDB</property>
    <property name="Dictionary"></property>
    <property name="Host"></property>
    <property name="Name">IBDatabase1</property>
    <property name="UserName">SYSDBA</property>
    <property name="UserPassword">masterkey</property>
    <property name="OnAfterConnect">IBDatabase1AfterConnect</property>
    <property name="OnAfterDisconnect">IBDatabase1AfterDisconnect</property>
    <property name="OnBeforeConnect">IBDatabase1BeforeConnect</property>
    <property name="OnBeforeDisconnect">IBDatabase1BeforeDisconnect</property>
  </object>
</object>
?>
