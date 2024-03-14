<?php
<object class="WindowSample" name="WindowSample" baseclass="page">
  <property name="Background"></property>
  <property name="Caption">Window Sample</property>
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
  <property name="Name">WindowSample</property>
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
  <object class="Window" name="wm1" >
    <property name="Caption">My First Window</property>
    <property name="Height">336</property>
    <property name="Left">26</property>
    <property name="MoveMethod">mmTranslucent</property>
    <property name="Name">wm1</property>
    <property name="ResizeMethod">rmTranslucent</property>
    <property name="Top">24</property>
    <property name="Width">406</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <object class="DBGrid" name="ddEMPLOYEE1" >
      <property name="Datasource">dsEMPLOYEE1</property>
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
      <property name="Height">192</property>
      <property name="Left">14</property>
      <property name="Name">ddEMPLOYEE1</property>
      <property name="Top">80</property>
      <property name="Width">376</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
      <property name="jsOnRowChanged"></property>
      <property name="jsOnRowSaved"></property>
    </object>
    <object class="Label" name="Label1" >
      <property name="Caption">Label1</property>
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
      <property name="Height">13</property>
      <property name="Left">14</property>
      <property name="Name">Label1</property>
      <property name="Top">56</property>
      <property name="Width">75</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
    </object>
    <object class="Edit" name="Edit1" >
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
      <property name="Height">24</property>
      <property name="Left">94</property>
      <property name="Name">Edit1</property>
      <property name="Top">48</property>
      <property name="Width">208</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
      <property name="OnSubmit"></property>
    </object>
    <object class="Button" name="Button1" >
      <property name="Caption">Modal</property>
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
      <property name="Left">310</property>
      <property name="Name">Button1</property>
      <property name="Top">48</property>
      <property name="Width">75</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
      <property name="jsOnClick">Button1JSClick</property>
    </object>
  </object>
  <object class="Window" name="wm2" >
    <property name="Caption">Modal Dialog</property>
    <property name="Height">168</property>
    <property name="Left">456</property>
    <property name="Modal">1</property>
    <property name="MoveMethod">mmTranslucent</property>
    <property name="Name">wm2</property>
    <property name="ResizeMethod">rmTranslucent</property>
    <property name="Resizeable">0</property>
    <property name="ShowMaximize">0</property>
    <property name="ShowMinimize">0</property>
    <property name="Top">352</property>
    <property name="Width">248</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <object class="Button" name="Button2" >
      <property name="Caption">Close</property>
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
      <property name="Left">79</property>
      <property name="Name">Button2</property>
      <property name="Top">62</property>
      <property name="Width">75</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
      <property name="jsOnClick">Button2JSClick</property>
    </object>
  </object>
  <object class="Table" name="tbEMPLOYEE1" >
        <property name="Left">493</property>
        <property name="Top">208</property>
    <property name="Active">1</property>
    <property name="Database">dbEMPLOYEE1</property>
    <property name="LimitCount"></property>
    <property name="LimitStart"></property>
    <property name="MasterFields">a:0:{}</property>
    <property name="MasterSource"></property>
    <property name="Name">tbEMPLOYEE1</property>
    <property name="TableName">EMPLOYEE</property>
    <property name="OnAfterCancel"></property>
    <property name="OnAfterClose"></property>
    <property name="OnAfterDelete"></property>
    <property name="OnAfterEdit"></property>
    <property name="OnAfterInsert"></property>
    <property name="OnAfterOpen"></property>
    <property name="OnAfterPost"></property>
    <property name="OnBeforeCancel"></property>
    <property name="OnBeforeClose"></property>
    <property name="OnBeforeDelete"></property>
    <property name="OnBeforeEdit"></property>
    <property name="OnBeforeInsert"></property>
    <property name="OnBeforeOpen"></property>
    <property name="OnBeforePost"></property>
    <property name="OnDeleteError"></property>
  </object>
  <object class="Database" name="dbEMPLOYEE1" >
        <property name="Left">477</property>
        <property name="Top">120</property>
    <property name="Connected">1</property>
    <property name="DatabaseName">localhost:C:/Program Files/Common Files/Borland Shared/Data/EMPLOYEE.GDB</property>
    <property name="Dictionary"></property>
    <property name="DriverName">borland_ibase</property>
    <property name="Host"></property>
    <property name="Name">dbEMPLOYEE1</property>
    <property name="UserName">SYSDBA</property>
    <property name="UserPassword">masterkey</property>
    <property name="OnAfterConnect"></property>
    <property name="OnAfterDisconnect"></property>
    <property name="OnBeforeConnect"></property>
    <property name="OnBeforeDisconnect"></property>
  </object>
  <object class="Datasource" name="dsEMPLOYEE1" >
        <property name="Left">477</property>
        <property name="Top">56</property>
    <property name="Dataset">tbEMPLOYEE1</property>
    <property name="Name">dsEMPLOYEE1</property>
  </object>
</object>
?>
