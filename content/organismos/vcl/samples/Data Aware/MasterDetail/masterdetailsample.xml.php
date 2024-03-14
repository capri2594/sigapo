<?php
<object class="MasterDetail" name="MasterDetail" baseclass="page">
  <property name="Background"></property>
  <property name="Caption">MasterDetail</property>
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
  <property name="Name">MasterDetail</property>
  <property name="UseAjax">1</property>
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
    <property name="Height">200</property>
    <property name="Left">38</property>
    <property name="Name">ddproducts1</property>
    <property name="Top">42</property>
    <property name="Width">706</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <property name="jsOnRowChanged">ddproducts1JSRowChanged</property>
    <property name="jsOnRowSaved"></property>
  </object>
  <object class="DBGrid" name="ddproducts_description1" >
    <property name="Datasource">dsproducts_description1</property>
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
    <property name="Left">33</property>
    <property name="Name">ddproducts_description1</property>
    <property name="Top">254</property>
    <property name="Width">703</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <property name="jsOnRowChanged"></property>
    <property name="jsOnRowSaved"></property>
  </object>
  <object class="Table" name="tbproducts1" >
        <property name="Left">214</property>
        <property name="Top">138</property>
    <property name="Active">1</property>
    <property name="Database">dboscommerce1</property>
    <property name="LimitCount">-1</property>
    <property name="LimitStart">-1</property>
    <property name="MasterFields">a:0:{}</property>
    <property name="MasterSource"></property>
    <property name="Name">tbproducts1</property>
    <property name="TableName">products</property>
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
        <property name="Left">326</property>
        <property name="Top">226</property>
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
        <property name="Left">510</property>
        <property name="Top">122</property>
    <property name="Dataset">tbproducts1</property>
    <property name="Name">dsproducts1</property>
  </object>
  <object class="Table" name="tbproducts_description1" >
        <property name="Left">217</property>
        <property name="Top">310</property>
    <property name="Active">1</property>
    <property name="Database">dboscommerce1</property>
    <property name="LimitCount">-1</property>
    <property name="LimitStart">-1</property>
    <property name="MasterFields"><![CDATA[a:1:{s:11:&quot;products_id&quot;;s:11:&quot;products_id&quot;;}]]></property>
    <property name="MasterSource">dsproducts1</property>
    <property name="Name">tbproducts_description1</property>
    <property name="TableName">products_description</property>
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
  <object class="Datasource" name="dsproducts_description1" >
        <property name="Left">505</property>
        <property name="Top">318</property>
    <property name="Dataset">tbproducts_description1</property>
    <property name="Name">dsproducts_description1</property>
  </object>
</object>
?>
