<?php
<object class="Cart" name="Cart" baseclass="page">
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
  <property name="Name">Cart</property>
  <property name="ShowFooter">0</property>
  <property name="ShowHeader">0</property>
  <property name="TemplateEngine">SmartyTemplate</property>
  <property name="TemplateFilename">templates/cart.tpl</property>
  <property name="Width">800</property>
  <property name="OnAfterShow"></property>
  <property name="OnAfterShowFooter"></property>
  <property name="OnBeforeShow">CartBeforeShow</property>
  <property name="OnBeforeShowHeader"></property>
  <property name="OnCreate">CartCreate</property>
  <property name="OnShow"></property>
  <property name="OnShowHeader"></property>
  <property name="OnStartBody"></property>
  <object class="RawOutput" name="CartContents" >
    <property name="Height">25</property>
    <property name="Left">5</property>
    <property name="Name">CartContents</property>
    <property name="Top">6</property>
    <property name="Width">75</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
  <object class="RawOutput" name="Message" >
    <property name="Height">25</property>
    <property name="Left">8</property>
    <property name="Name">Message</property>
    <property name="Top">42</property>
    <property name="Width">75</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
  <object class="RawOutput" name="Subtotal" >
    <property name="Height">25</property>
    <property name="Left">6</property>
    <property name="Name">Subtotal</property>
    <property name="Top">82</property>
    <property name="Width">75</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
  <object class="RawOutput" name="Total" >
    <property name="Height">25</property>
    <property name="Left">7</property>
    <property name="Name">Total</property>
    <property name="Top">118</property>
    <property name="Width">75</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
</object>
?>
