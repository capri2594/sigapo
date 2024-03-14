<?php
<object class="Unit112" name="Unit112" baseclass="page">
  <property name="Background"></property>
  <property name="Caption">RowChanged</property>
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
  <property name="Name">Unit112</property>
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
  <object class="DBGrid" name="ddPROJECT1" >
    <property name="Datasource">dsPROJECT1</property>
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
    <property name="Height">200</property>
    <property name="Left">139</property>
    <property name="Name">ddPROJECT1</property>
    <property name="Top">70</property>
    <property name="Width">437</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <property name="jsOnRowChanged">ddPROJECT1JSRowChanged</property>
    <property name="jsOnRowSaved"></property>
  </object>
  <object class="Memo" name="Memo1" >
    <property name="DataField">PROJ_DESC</property>
    <property name="DataSource">dsPROJECT1</property>
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
    <property name="Height">208</property>
    <property name="Left">136</property>
    <property name="Lines">a:0:{}</property>
    <property name="Name">Memo1</property>
    <property name="Top">304</property>
    <property name="Width">440</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <property name="OnSubmit"></property>
  </object>
  <object class="Table" name="tbPROJECT1" >
        <property name="Left">51</property>
        <property name="Top">38</property>
    <property name="Active">1</property>
    <property name="Database">dbEMPLOYEE1</property>
    <property name="LimitCount">-1</property>
    <property name="LimitStart">-1</property>
    <property name="MasterFields">a:0:{}</property>
    <property name="MasterSource"></property>
    <property name="Name">tbPROJECT1</property>
    <property name="TableName">PROJECT</property>
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
        <property name="Left">43</property>
        <property name="Top">102</property>
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
  <object class="Datasource" name="dsPROJECT1" >
        <property name="Left">59</property>
        <property name="Top">174</property>
    <property name="Dataset">tbPROJECT1</property>
    <property name="Name">dsPROJECT1</property>
  </object>
</object>
?>
