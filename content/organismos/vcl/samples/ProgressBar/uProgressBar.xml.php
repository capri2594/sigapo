<?php
<object class="UProgressBar" name="uProgressBar" baseclass="page">
  <property name="Background"></property>
  <property name="Caption">ProgressBar Demo</property>
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
  <property name="Name">uProgressBar</property>
  <property name="Width">600</property>
  <property name="OnAfterShow"></property>
  <property name="OnAfterShowFooter"></property>
  <property name="OnBeforeShow"></property>
  <property name="OnBeforeShowHeader"></property>
  <property name="OnCreate"></property>
  <property name="OnShow"></property>
  <property name="OnShowHeader"></property>
  <property name="OnStartBody"></property>
  <property name="OnTemplate"></property>
  <object class="Button" name="Button1" >
    <property name="Caption">Set Position to 50</property>
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
    <property name="Left">360</property>
    <property name="Name">Button1</property>
    <property name="Top">16</property>
    <property name="Width">176</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnClick">Button1Click</property>
    <property name="OnShow"></property>
  </object>
  <object class="ProgressBar" name="ProgressBar1" >
    <property name="Height">17</property>
    <property name="Left">20</property>
    <property name="Max">100</property>
    <property name="Min">0</property>
    <property name="Name">ProgressBar1</property>
    <property name="Orientation">pbHorizontal</property>
    <property name="Position">10</property>
    <property name="Step">10</property>
    <property name="Top">20</property>
    <property name="Width">200</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
  <object class="Button" name="Button2" >
    <property name="Caption">Change Orientation</property>
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
    <property name="Left">360</property>
    <property name="Name">Button2</property>
    <property name="Top">48</property>
    <property name="Width">176</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnClick">Button2Click</property>
    <property name="OnShow"></property>
  </object>
  <object class="Button" name="Button3" >
    <property name="Caption">Set Min/Max to (0, 200)</property>
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
    <property name="Left">360</property>
    <property name="Name">Button3</property>
    <property name="Top">80</property>
    <property name="Width">176</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnClick">Button3Click</property>
    <property name="OnShow"></property>
  </object>
  <object class="Button" name="Button4" >
    <property name="Caption">Step by 20</property>
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
    <property name="Left">360</property>
    <property name="Name">Button4</property>
    <property name="Top">112</property>
    <property name="Width">176</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnClick">Button4Click</property>
    <property name="OnShow"></property>
  </object>
  <object class="Label" name="Label1" >
    <property name="Caption">10</property>
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
    <property name="Left">240</property>
    <property name="Name">Label1</property>
    <property name="Top">24</property>
    <property name="Width">75</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
  <object class="Button" name="Button5" >
    <property name="Caption">Step It (10)</property>
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
    <property name="Left">360</property>
    <property name="Name">Button5</property>
    <property name="Top">144</property>
    <property name="Width">176</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnClick">Button5Click</property>
    <property name="OnShow"></property>
  </object>
</object>
?>
