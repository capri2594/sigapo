<?php
<object class="StoredProcSample" name="StoredProcSample" baseclass="page">
  <property name="Background"></property>
  <property name="Caption">Stored Proc Sample</property>
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
  <property name="Name">StoredProcSample</property>
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
    <property name="Height">296</property>
    <property name="Left">32</property>
    <property name="Name">DBGrid1</property>
    <property name="Top">48</property>
    <property name="Width">472</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <property name="jsOnRowChanged"></property>
    <property name="jsOnRowSaved"></property>
  </object>
  <object class="Button" name="Button1" >
    <property name="Caption">Call Stored Proc</property>
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
    <property name="Left">32</property>
    <property name="Name">Button1</property>
    <property name="Top">16</property>
    <property name="Width">104</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnClick">Button1Click</property>
    <property name="OnShow"></property>
  </object>
  <object class="ComboBox" name="cbCustomers" >
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
    <property name="Height">18</property>
    <property name="Items">a:0:{}</property>
    <property name="Left">144</property>
    <property name="Name">cbCustomers</property>
    <property name="Top">16</property>
    <property name="Width">360</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow">cbCustomersBeforeShow</property>
    <property name="OnShow"></property>
    <property name="OnSubmit"></property>
  </object>
  <object class="DBGrid" name="DBGrid2" >
    <property name="DataSource">Datasource2</property>
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
    <property name="Height">176</property>
    <property name="Left">32</property>
    <property name="Name">DBGrid2</property>
    <property name="Top">408</property>
    <property name="Width">472</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <property name="jsOnRowChanged"></property>
    <property name="jsOnRowSaved"></property>
  </object>
  <object class="Label" name="Label1" >
    <property name="Caption">This is a sample on how to call a Stored Proc, no params, and get results</property>
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
    <property name="Left">32</property>
    <property name="Name">Label1</property>
    <property name="Top">384</property>
    <property name="Width">472</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
  <object class="Database" name="dbemployee" >
        <property name="Left">549</property>
        <property name="Top">229</property>
    <property name="Connected">1</property>
    <property name="DatabaseName">localhost:C:\Program Files\Common Files\Borland Shared\Data\employee.gdb</property>
    <property name="Dictionary"></property>
    <property name="DriverName">borland_ibase</property>
    <property name="Host"></property>
    <property name="Name">dbemployee</property>
    <property name="UserName">SYSDBA</property>
    <property name="UserPassword">masterkey</property>
    <property name="OnAfterConnect"></property>
    <property name="OnAfterDisconnect"></property>
    <property name="OnBeforeConnect"></property>
    <property name="OnBeforeDisconnect"></property>
  </object>
  <object class="Query" name="Query1" >
        <property name="Left">539</property>
        <property name="Top">102</property>
    <property name="Active">1</property>
    <property name="Database">dbemployee</property>
    <property name="LimitCount">-1</property>
    <property name="LimitStart">-1</property>
    <property name="Name">Query1</property>
    <property name="Params">a:0:{}</property>
    <property name="SQL"><![CDATA[a:1:{i:0;s:22:&quot;select * from employee&quot;;}]]></property>
    <property name="TableName">employee</property>
  </object>
  <object class="Datasource" name="Datasource1" >
        <property name="Left">544</property>
        <property name="Top">48</property>
    <property name="DataSet">StoredProc1</property>
    <property name="Name">Datasource1</property>
  </object>
  <object class="StoredProc" name="StoredProc1" >
        <property name="Left">548</property>
        <property name="Top">164</property>
    <property name="Active">1</property>
    <property name="Database">dbemployee</property>
    <property name="LimitCount">-1</property>
    <property name="LimitStart">-1</property>
    <property name="Name">StoredProc1</property>
    <property name="Params"><![CDATA[a:1:{i:0;s:4:&quot;1001&quot;;}]]></property>
    <property name="StoredProcName">MAIL_LABEL</property>
  </object>
  <object class="Table" name="tbcustomers" >
        <property name="Left">550</property>
        <property name="Top">292</property>
    <property name="Active">1</property>
    <property name="Database">dbemployee</property>
    <property name="LimitCount">-1</property>
    <property name="LimitStart">-1</property>
    <property name="MasterFields">a:0:{}</property>
    <property name="MasterSource"></property>
    <property name="Name">tbcustomers</property>
    <property name="TableName">CUSTOMER</property>
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
  <object class="StoredProc" name="StoredProc2" >
        <property name="Left">552</property>
        <property name="Top">424</property>
    <property name="Active">1</property>
    <property name="Database">dbemployee</property>
    <property name="LimitCount">-1</property>
    <property name="LimitStart">-1</property>
    <property name="Name">StoredProc2</property>
    <property name="Params">a:0:{}</property>
    <property name="StoredProcName">ALL_LANGS</property>
  </object>
  <object class="Datasource" name="Datasource2" >
        <property name="Left">552</property>
        <property name="Top">368</property>
    <property name="DataSet">StoredProc2</property>
    <property name="Name">Datasource2</property>
  </object>
</object>
?>
