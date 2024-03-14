<?php
<object class="BlogDB" name="BlogDB" baseclass="datamodule">
  <property name="Height">600</property>
  <property name="Name">BlogDB</property>
  <property name="Width">800</property>
  <property name="OnAfterShow"></property>
  <property name="OnBeforeShow"></property>
  <property name="OnShow"></property>
  <object class="Table" name="BlogsTable1" >
        <property name="Left">105</property>
        <property name="Top">35</property>
    <property name="Active">0</property>
    <property name="Database">Database1</property>
    <property name="Filter"></property>
    <property name="GroupBy"></property>
    <property name="LimitCount"></property>
    <property name="LimitStart"></property>
    <property name="MasterSource"></property>
    <property name="Name">BlogsTable1</property>
    <property name="Order">asc</property>
    <property name="OrderField"></property>
    <property name="TableName">blogs</property>
  </object>
  <object class="Datasource" name="BlogsDatasource1" >
        <property name="Left">211</property>
        <property name="Top">44</property>
    <property name="DataSet">BlogsTable1</property>
    <property name="Name">BlogsDatasource1</property>
  </object>
  <object class="Database" name="Database1" >
        <property name="Left">28</property>
        <property name="Top">46</property>
    <property name="Connected">0</property>
    <property name="DatabaseName"></property>
    <property name="Dictionary"></property>
    <property name="DriverName">mysql</property>
    <property name="Host"></property>
    <property name="Name">Database1</property>
    <property name="Password"></property>
    <property name="User"></property>
  </object>
  <object class="Table" name="CommentsTable1" >
        <property name="Left">104</property>
        <property name="Top">116</property>
    <property name="Active">0</property>
    <property name="Database">Database1</property>
    <property name="Filter"></property>
    <property name="GroupBy"></property>
    <property name="LimitCount"></property>
    <property name="LimitStart"></property>
    <property name="MasterSource"></property>
    <property name="Name">CommentsTable1</property>
    <property name="Order">asc</property>
    <property name="OrderField"></property>
    <property name="TableName">comments</property>
  </object>
  <object class="Datasource" name="CommentsDatasource1" >
        <property name="Left">208</property>
        <property name="Top">108</property>
    <property name="DataSet">CommentsTable1</property>
    <property name="Name">CommentsDatasource1</property>
  </object>
  <object class="Query" name="Query1" >
        <property name="Left">32</property>
        <property name="Top">180</property>
    <property name="Active"></property>
    <property name="Database">Database1</property>
    <property name="Filter"></property>
    <property name="GroupBy"></property>
    <property name="LimitCount"></property>
    <property name="LimitStart"></property>
    <property name="MasterSource"></property>
    <property name="Name">Query1</property>
    <property name="Order">asc</property>
    <property name="OrderField"></property>
    <property name="TableName"></property>
  </object>
</object>
?>
