<?php
<object class="DBModule" name="DBModule" baseclass="datamodule">
  <property name="Height">600</property>
  <property name="Name">DBModule</property>
  <property name="Width">800</property>
  <property name="OnAfterShow"></property>
  <property name="OnBeforeShow"></property>
  <property name="OnShow"></property>
  <object class="Database" name="Database1" >
        <property name="Left">20</property>
        <property name="Top">16</property>
    <property name="Connected"></property>
    <property name="DatabaseName"></property>
    <property name="Dictionary"></property>
    <property name="DriverName">mysql</property>
    <property name="Host"></property>
    <property name="Name">Database1</property>
    <property name="UserName"></property>
    <property name="UserPassword"></property>
    <property name="OnAfterConnect"></property>
    <property name="OnAfterDisconnect"></property>
    <property name="OnBeforeConnect"></property>
    <property name="OnBeforeDisconnect"></property>
  </object>
  <object class="Table" name="AdTable1" >
        <property name="Left">599</property>
        <property name="Top">396</property>
    <property name="Database">Database1</property>
    <property name="LimitCount"></property>
    <property name="LimitStart"></property>
    <property name="MasterFields">a:0:{}</property>
    <property name="MasterSource"></property>
    <property name="Name">AdTable1</property>
    <property name="TableName">ads</property>
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
  <object class="Query" name="Query1" >
        <property name="Left">689</property>
        <property name="Top">202</property>
    <property name="Database">Database1</property>
    <property name="LimitCount">-1</property>
    <property name="LimitStart">-1</property>
    <property name="Name">Query1</property>
    <property name="Params">a:0:{}</property>
    <property name="SQL">a:0:{}</property>
  </object>
  <object class="Datasource" name="AdDatasource1" >
        <property name="Left">694</property>
        <property name="Top">390</property>
    <property name="DataSet">AdTable1</property>
    <property name="Name">AdDatasource1</property>
  </object>
  <object class="Table" name="Table1" >
        <property name="Left">540</property>
        <property name="Top">247</property>
    <property name="Database">Database1</property>
    <property name="LimitCount"></property>
    <property name="LimitStart"></property>
    <property name="MasterFields">a:0:{}</property>
    <property name="MasterSource"></property>
    <property name="Name">Table1</property>
    <property name="OrderField">ID</property>
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
  <object class="Datasource" name="Datasource1" >
        <property name="Left">607</property>
        <property name="Top">280</property>
    <property name="DataSet">Table1</property>
    <property name="Name">Datasource1</property>
  </object>
  <object class="Table" name="Table2" >
        <property name="Left">536</property>
        <property name="Top">368</property>
    <property name="Database">Database1</property>
    <property name="LimitCount"></property>
    <property name="LimitStart"></property>
    <property name="MasterFields">a:0:{}</property>
    <property name="MasterSource"></property>
    <property name="Name">Table2</property>
    <property name="OrderField">ID</property>
    <property name="TableName">orders</property>
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
</object>
?>
