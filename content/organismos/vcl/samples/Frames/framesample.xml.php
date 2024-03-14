<?php
<object class="FrameSample" name="FrameSample" baseclass="page">
  <property name="Background"></property>
  <property name="Caption">FrameSample</property>
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
  <property name="Name">FrameSample</property>
  <property name="Width">800</property>
  <property name="OnAfterShow"></property>
  <property name="OnAfterShowFooter"></property>
  <property name="OnBeforeShow"></property>
  <property name="OnBeforeShowHeader"></property>
  <property name="OnCreate"></property>
  <property name="OnShow"></property>
  <property name="OnShowHeader"></property>
  <property name="OnStartBody"></property>
  <object class="Frame" name="Frame1" >
    <property name="Height">598</property>
    <property name="Left">1</property>
    <property name="Name">Frame1</property>
    <property name="Source">leftpane.php</property>
    <property name="Top">1</property>
    <property name="Width">192</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
  <object class="Frameset" name="Frameset1" >
    <property name="FrameBorder">no</property>
    <property name="Height">598</property>
    <property name="Left">193</property>
    <property name="Name">Frameset1</property>
    <property name="Top">1</property>
    <property name="Width">606</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <object class="Frame" name="Frame2" >
      <property name="Align">alTop</property>
      <property name="Height">110</property>
      <property name="Left">1</property>
      <property name="Name">Frame2</property>
      <property name="Source">http://www.codegear.com</property>
      <property name="Top">1</property>
      <property name="Width">604</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
    </object>
    <object class="Frame" name="Frame3" >
      <property name="Align">alClient</property>
      <property name="Height">486</property>
      <property name="Left">1</property>
      <property name="Name">Frame3</property>
      <property name="Top">111</property>
      <property name="Width">604</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
    </object>
  </object>
</object>
?>
