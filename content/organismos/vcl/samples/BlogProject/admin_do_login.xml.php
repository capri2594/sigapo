<?php
<object class="AdminDoLogin" name="AdminDoLogin" baseclass="page">
  <property name="Background"></property>
  <property name="Caption">Login</property>
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
  <property name="Name">AdminDoLogin</property>
  <property name="Width">800</property>
  <property name="OnAfterShow"></property>
  <property name="OnAfterShowFooter"></property>
  <property name="OnBeforeShow"></property>
  <property name="OnBeforeShowHeader"></property>
  <property name="OnCreate"></property>
  <property name="OnShow"></property>
  <property name="OnShowHeader"></property>
  <property name="OnStartBody"></property>
  <object class="Label" name="Label2" >
    <property name="Caption">Blog Admin Panel - Login</property>
    <property name="Font">
        <property name="Align">taNone</property>
        <property name="Case"></property>
        <property name="Color"></property>
        <property name="Family">Verdana</property>
        <property name="LineHeight"></property>
        <property name="Size">14pt</property>
        <property name="Style"></property>
        <property name="Variant"></property>
        <property name="Weight"></property>
    </property>
    <property name="Height">27</property>
    <property name="Left">8</property>
    <property name="Name">Label2</property>
    <property name="ParentFont">0</property>
    <property name="Top">8</property>
    <property name="Width">264</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
  <object class="Label" name="Label1" >
    <property name="Caption">Username:</property>
    <property name="Font">
        <property name="Align">taNone</property>
        <property name="Case"></property>
        <property name="Color"></property>
        <property name="Family">Verdana</property>
        <property name="LineHeight"></property>
        <property name="Size">10pt</property>
        <property name="Style"></property>
        <property name="Variant"></property>
        <property name="Weight"></property>
    </property>
    <property name="Height">13</property>
    <property name="Left">9</property>
    <property name="Name">Label1</property>
    <property name="ParentFont">0</property>
    <property name="Top">84</property>
    <property name="Width">75</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
  <object class="Edit" name="Edit1" >
    <property name="Font">
        <property name="Align">taNone</property>
        <property name="Case"></property>
        <property name="Color"></property>
        <property name="Family">Verdana</property>
        <property name="LineHeight"></property>
        <property name="Size">8pt</property>
        <property name="Style"></property>
        <property name="Variant"></property>
        <property name="Weight"></property>
    </property>
    <property name="Height">23</property>
    <property name="Left">9</property>
    <property name="Name">Edit1</property>
    <property name="ParentFont">0</property>
    <property name="Top">104</property>
    <property name="Width">431</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <property name="OnSubmit"></property>
  </object>
  <object class="Label" name="Label3" >
    <property name="Caption">Password:</property>
    <property name="Font">
        <property name="Align">taNone</property>
        <property name="Case"></property>
        <property name="Color"></property>
        <property name="Family">Verdana</property>
        <property name="LineHeight"></property>
        <property name="Size">10pt</property>
        <property name="Style"></property>
        <property name="Variant"></property>
        <property name="Weight"></property>
    </property>
    <property name="Height">13</property>
    <property name="Left">9</property>
    <property name="Name">Label3</property>
    <property name="ParentFont">0</property>
    <property name="Top">156</property>
    <property name="Width">75</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
  <object class="Edit" name="Edit2" >
    <property name="Font">
        <property name="Align">taNone</property>
        <property name="Case"></property>
        <property name="Color"></property>
        <property name="Family">Verdana</property>
        <property name="LineHeight"></property>
        <property name="Size">8pt</property>
        <property name="Style"></property>
        <property name="Variant"></property>
        <property name="Weight"></property>
    </property>
    <property name="Height">23</property>
    <property name="IsPassword">1</property>
    <property name="Left">9</property>
    <property name="Name">Edit2</property>
    <property name="ParentFont">0</property>
    <property name="Top">176</property>
    <property name="Width">431</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <property name="OnSubmit"></property>
  </object>
  <object class="Button" name="Button1" >
    <property name="Caption">OK</property>
    <property name="Font">
        <property name="Align">taNone</property>
        <property name="Case"></property>
        <property name="Color"></property>
        <property name="Family">Verdana</property>
        <property name="LineHeight"></property>
        <property name="Size">8pt</property>
        <property name="Style"></property>
        <property name="Variant"></property>
        <property name="Weight"></property>
    </property>
    <property name="Height">25</property>
    <property name="ImageSource"></property>
    <property name="Left">9</property>
    <property name="Name">Button1</property>
    <property name="ParentFont">0</property>
    <property name="Top">225</property>
    <property name="Width">75</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnClick">Button1Click</property>
    <property name="OnShow"></property>
  </object>
  <object class="Label" name="Label4" >
    <property name="Font">
        <property name="Align">taNone</property>
        <property name="Case"></property>
        <property name="Color">red</property>
        <property name="Family">Verdana</property>
        <property name="LineHeight"></property>
        <property name="Size">10pt</property>
        <property name="Style"></property>
        <property name="Variant"></property>
        <property name="Weight"></property>
    </property>
    <property name="Height">13</property>
    <property name="Left">9</property>
    <property name="Name">Label4</property>
    <property name="ParentFont">0</property>
    <property name="Top">49</property>
    <property name="Width">430</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
</object>
?>
