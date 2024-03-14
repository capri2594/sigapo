<?php
<object class="AdminDeleteComment" name="AdminDeleteComment" baseclass="page">
  <property name="Background"></property>
  <property name="Caption">Deleting comment</property>
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
  <property name="Name">AdminDeleteComment</property>
  <property name="Width">800</property>
  <property name="OnAfterShow"></property>
  <property name="OnAfterShowFooter"></property>
  <property name="OnBeforeShow"></property>
  <property name="OnBeforeShowHeader"></property>
  <property name="OnCreate">AdminDeleteCommentCreate</property>
  <property name="OnShow"></property>
  <property name="OnShowHeader"></property>
  <property name="OnStartBody"></property>
  <object class="Query" name="Query1" >
        <property name="Left">727</property>
        <property name="Top">547</property>
    <property name="Active"></property>
    <property name="Database">BlogDB.Database1</property>
    <property name="Filter"></property>
    <property name="GroupBy"></property>
    <property name="LimitCount">10</property>
    <property name="LimitStart">0</property>
    <property name="MasterSource"></property>
    <property name="Name">Query1</property>
    <property name="Order">asc</property>
    <property name="OrderField"></property>
    <property name="TableName"></property>
  </object>
</object>
?>
