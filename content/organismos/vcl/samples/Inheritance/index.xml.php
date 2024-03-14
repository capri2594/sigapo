<?php
<object class="Index" name="Index" baseclass="page">
  <property name="Background"></property>
  <property name="Caption">Inheritance Sample</property>
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
  <property name="Name">Index</property>
  <property name="Width">800</property>
  <property name="OnAfterShow"></property>
  <property name="OnAfterShowFooter"></property>
  <property name="OnBeforeShow"></property>
  <property name="OnBeforeShowHeader"></property>
  <property name="OnCreate"></property>
  <property name="OnShow"></property>
  <property name="OnShowHeader"></property>
  <property name="OnStartBody"></property>
  <object class="Panel" name="pnIndex" >
    <property name="Caption">Put here the contents of your pages</property>
    <property name="Dynamic"></property>
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
    <property name="Height">272</property>
    <property name="Layout">
        <property name="Cols">5</property>
        <property name="Rows">5</property>
        <property name="Type">ABS_XY_LAYOUT</property>
    </property>
    <property name="Left">80</property>
    <property name="Name">pnIndex</property>
    <property name="Top">72</property>
    <property name="Visible">0</property>
    <property name="Width">552</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <object class="Button" name="Button1" >
      <property name="Caption">Button1</property>
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
      <property name="Left">59</property>
      <property name="Name">Button1</property>
      <property name="Top">35</property>
      <property name="Width">75</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
    </object>
    <object class="Memo" name="Memo1" >
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
      <property name="Height">72</property>
      <property name="Left">160</property>
      <property name="Lines">a:0:{}</property>
      <property name="Name">Memo1</property>
      <property name="Top">24</property>
      <property name="Width">344</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
      <property name="OnSubmit"></property>
    </object>
    <object class="Label" name="Label1" >
      <property name="Caption">Click here to go to page 2</property>
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
      <property name="Left">75</property>
      <property name="Link">page2.php</property>
      <property name="Name">Label1</property>
      <property name="Top">184</property>
      <property name="Width">445</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
    </object>
  </object>
</object>
?>
