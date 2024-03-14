<?php
<object class="AjaxDatabase" name="AjaxDatabase" baseclass="page">
  <property name="Background"></property>
  <property name="Caption">Ajax Database Sample</property>
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
  <property name="Name">AjaxDatabase</property>
  <property name="UseAjax">1</property>
  <property name="Width">800</property>
  <property name="OnAfterShow"></property>
  <property name="OnAfterShowFooter"></property>
  <property name="OnBeforeShow">AjaxDatabaseBeforeShow</property>
  <property name="OnBeforeShowHeader"></property>
  <property name="OnCreate"></property>
  <property name="OnShow"></property>
  <property name="OnShowHeader"></property>
  <property name="OnStartBody"></property>
  <property name="OnTemplate"></property>
  <object class="DBGrid" name="ddaddress_book1" >
    <property name="Datasource">dsaddress_book1</property>
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
    <property name="Height">336</property>
    <property name="Left">208</property>
    <property name="Name">ddaddress_book1</property>
    <property name="Top">40</property>
    <property name="Width">568</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <property name="jsOnRowChanged"></property>
    <property name="jsOnRowSaved"></property>
  </object>
  <object class="ListBox" name="ListBox1" >
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
    <property name="Height">360</property>
    <property name="Items">a:0:{}</property>
    <property name="Left">8</property>
    <property name="Name">ListBox1</property>
    <property name="Top">16</property>
    <property name="Width">184</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <property name="OnSubmit"></property>
    <property name="jsOnChange">ListBox1JSChange</property>
  </object>
  <object class="Label" name="lbCurrently" >
    <property name="Caption">Currently browsing...</property>
    <property name="Font">
        <property name="Align">taNone</property>
        <property name="Case"></property>
        <property name="Color"></property>
        <property name="Family">Verdana</property>
        <property name="LineHeight"></property>
        <property name="Size">10px</property>
        <property name="Style"></property>
        <property name="Variant"></property>
        <property name="Weight">bold</property>
    </property>
    <property name="Height">13</property>
    <property name="Left">208</property>
    <property name="Name">lbCurrently</property>
    <property name="ParentFont">0</property>
    <property name="Top">16</property>
    <property name="Width">560</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
  <object class="Table" name="tbaddress_book1" >
        <property name="Left">629</property>
        <property name="Top">391</property>
    <property name="Active">1</property>
    <property name="Database">dboscommerce1</property>
    <property name="LimitCount">-1</property>
    <property name="LimitStart">-1</property>
    <property name="MasterFields">a:0:{}</property>
    <property name="MasterSource"></property>
    <property name="Name">tbaddress_book1</property>
    <property name="TableName">address_book</property>
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
  <object class="Database" name="dboscommerce1" >
        <property name="Left">677</property>
        <property name="Top">391</property>
    <property name="Connected">1</property>
    <property name="DatabaseName">oscommerce</property>
    <property name="Dictionary"></property>
    <property name="DriverName">mysql</property>
    <property name="Host">localhost:3306</property>
    <property name="Name">dboscommerce1</property>
    <property name="UserName">root</property>
    <property name="UserPassword">test</property>
    <property name="OnAfterConnect"></property>
    <property name="OnAfterDisconnect"></property>
    <property name="OnBeforeConnect"></property>
    <property name="OnBeforeDisconnect"></property>
  </object>
  <object class="Datasource" name="dsaddress_book1" >
        <property name="Left">725</property>
        <property name="Top">391</property>
    <property name="Dataset">tbaddress_book1</property>
    <property name="Name">dsaddress_book1</property>
  </object>
</object>
?>
