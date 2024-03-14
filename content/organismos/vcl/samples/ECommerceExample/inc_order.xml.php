<?php
<object class="Order" name="Order" baseclass="page">
  <property name="Background"></property>
  <property name="Caption">Noname1</property>
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
  <property name="Name">Order</property>
  <property name="TemplateEngine">SmartyTemplate</property>
  <property name="TemplateFilename">templates/order.tpl</property>
  <property name="Width">800</property>
  <property name="OnAfterShow"></property>
  <property name="OnAfterShowFooter"></property>
  <property name="OnBeforeShow"></property>
  <property name="OnBeforeShowHeader"></property>
  <property name="OnCreate">OrderCreate</property>
  <property name="OnShow"></property>
  <property name="OnShowHeader"></property>
  <property name="OnStartBody"></property>
  <object class="RawOutput" name="Msg" >
    <property name="Height">25</property>
    <property name="Left">10</property>
    <property name="Name">Msg</property>
    <property name="Top">9</property>
    <property name="Width">75</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
</object>
?>
