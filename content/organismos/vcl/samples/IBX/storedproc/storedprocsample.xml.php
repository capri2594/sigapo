<?php
<object class="Unit224" name="Unit224" baseclass="page">
  <property name="Background"></property>
  <property name="Caption">StoredProc Sample</property>
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
  <property name="Name">Unit224</property>
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
  <object class="DBGrid" name="DBGrid1" >
    <property name="DataSource">Datasource1</property>
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
    <property name="Height">256</property>
    <property name="Left">40</property>
    <property name="Name">DBGrid1</property>
    <property name="Top">32</property>
    <property name="Width">712</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <property name="jsOnRowChanged"></property>
    <property name="jsOnRowSaved"></property>
  </object>
  <object class="IBDatabase" name="IBDatabase1" >
        <property name="Left">138</property>
        <property name="Top">98</property>
    <property name="Connected">1</property>
    <property name="DatabaseName">localhost:C:\Program Files\Common Files\Borland Shared\Data\EMPLOYEE.GDB</property>
    <property name="Dictionary"></property>
    <property name="Host"></property>
    <property name="Name">IBDatabase1</property>
    <property name="UserName">SYSDBA</property>
    <property name="UserPassword">masterkey</property>
    <property name="OnAfterConnect"></property>
    <property name="OnAfterDisconnect"></property>
    <property name="OnBeforeConnect"></property>
    <property name="OnBeforeDisconnect"></property>
  </object>
  <object class="Datasource" name="Datasource1" >
        <property name="Left">272</property>
        <property name="Top">96</property>
    <property name="DataSet">IBStoredProc1</property>
    <property name="Name">Datasource1</property>
  </object>
  <object class="IBStoredProc" name="IBStoredProc1" >
        <property name="Left">424</property>
        <property name="Top">104</property>
    <property name="Active">1</property>
    <property name="Database">IBDatabase1</property>
    <property name="LimitCount">-1</property>
    <property name="LimitStart">-1</property>
    <property name="Name">IBStoredProc1</property>
    <property name="Params"><![CDATA[a:1:{i:0;s:4:&quot;1001&quot;;}]]></property>
    <property name="StoredProcName">MAIL_LABEL</property>
  </object>
</object>
?>
