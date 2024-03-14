<?php
<object class="Unit201" name="Unit201" baseclass="page">
  <property name="Background"></property>
  <property name="Caption">Unit201</property>
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
  <property name="Name">Unit201</property>
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
    <property name="Height">280</property>
    <property name="Left">496</property>
    <property name="Lines">a:0:{}</property>
    <property name="Name">meLog</property>
    <property name="Top">48</property>
    <property name="Width">256</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <property name="OnSubmit"></property>
  </object>
  <object class="DBGrid" name="ddproducts1" >
    <property name="Datasource">dsproducts1</property>
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
    <property name="Height">280</property>
    <property name="Left">16</property>
    <property name="Name">ddproducts1</property>
    <property name="Top">48</property>
    <property name="Width">456</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <property name="jsOnRowChanged"></property>
    <property name="jsOnRowSaved"></property>
  </object>
  <object class="Button" name="btnOpen" >
    <property name="Caption">Open</property>
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
    <property name="Left">496</property>
    <property name="Name">btnOpen</property>
    <property name="Top">16</property>
    <property name="Width">75</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnClick">btnOpenClick</property>
    <property name="OnShow"></property>
  </object>
  <object class="Button" name="btnClose" >
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
    <property name="Left">584</property>
    <property name="Name">btnClose</property>
    <property name="Top">16</property>
    <property name="Width">75</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnClick">btnCloseClick</property>
    <property name="OnShow"></property>
  </object>
  <object class="Table" name="tbproducts1" >
        <property name="Left">439</property>
        <property name="Top">64</property>
    <property name="Active">1</property>
    <property name="Database">dboscommerce1</property>
    <property name="MasterFields">a:0:{}</property>
    <property name="MasterSource"></property>
    <property name="Name">tbproducts1</property>
    <property name="TableName">products</property>
    <property name="OnAfterCancel">tbproducts1AfterCancel</property>
    <property name="OnAfterClose">tbproducts1AfterClose</property>
    <property name="OnAfterDelete">tbproducts1AfterDelete</property>
    <property name="OnAfterEdit">tbproducts1AfterEdit</property>
    <property name="OnAfterInsert">tbproducts1AfterInsert</property>
    <property name="OnAfterOpen">tbproducts1AfterOpen</property>
    <property name="OnAfterPost">tbproducts1AfterPost</property>
    <property name="OnBeforeCancel">tbproducts1BeforeCancel</property>
    <property name="OnBeforeClose">tbproducts1BeforeClose</property>
    <property name="OnBeforeDelete">tbproducts1BeforeDelete</property>
    <property name="OnBeforeEdit">tbproducts1BeforeEdit</property>
    <property name="OnBeforeInsert">tbproducts1BeforeInsert</property>
    <property name="OnBeforeOpen">tbproducts1BeforeOpen</property>
    <property name="OnBeforePost">tbproducts1BeforePost</property>
    <property name="OnDeleteError">tbproducts1DeleteError</property>
  </object>
  <object class="Database" name="dboscommerce1" >
        <property name="Left">439</property>
        <property name="Top">160</property>
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
  <object class="Datasource" name="dsproducts1" >
        <property name="Left">439</property>
        <property name="Top">96</property>
    <property name="Dataset">tbproducts1</property>
    <property name="Name">dsproducts1</property>
  </object>
</object>
?>
