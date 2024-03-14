<?php
<object class="MainMenuSample" name="MainMenuSample" baseclass="page">
  <property name="Background"></property>
  <property name="Caption">MainMenu Sample</property>
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
  <property name="Name">MainMenuSample</property>
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
  <object class="MainMenu" name="MainMenu1" >
    <property name="Caption">MainMenu1</property>
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
    <property name="Items"><![CDATA[a:1:{i:0;a:6:{s:7:&quot;Caption&quot;;s:4:&quot;File&quot;;s:10:&quot;ImageIndex&quot;;s:1:&quot;0&quot;;s:13:&quot;SelectedIndex&quot;;s:1:&quot;0&quot;;s:10:&quot;StateIndex&quot;;s:2:&quot;-1&quot;;s:3:&quot;Tag&quot;;s:1:&quot;0&quot;;s:5:&quot;Items&quot;;a:2:{i:0;a:6:{s:7:&quot;Caption&quot;;s:16:&quot;Javascript Click&quot;;s:10:&quot;ImageIndex&quot;;s:1:&quot;0&quot;;s:13:&quot;SelectedIndex&quot;;s:1:&quot;0&quot;;s:10:&quot;StateIndex&quot;;s:2:&quot;-1&quot;;s:3:&quot;Tag&quot;;s:2:&quot;10&quot;;s:5:&quot;Items&quot;;a:0:{}}i:1;a:6:{s:7:&quot;Caption&quot;;s:9:&quot;PHP Click&quot;;s:10:&quot;ImageIndex&quot;;s:1:&quot;0&quot;;s:13:&quot;SelectedIndex&quot;;s:1:&quot;0&quot;;s:10:&quot;StateIndex&quot;;s:2:&quot;-1&quot;;s:3:&quot;Tag&quot;;s:2:&quot;20&quot;;s:5:&quot;Items&quot;;a:0:{}}}}}]]></property>
    <property name="Left">4</property>
    <property name="Name">MainMenu1</property>
    <property name="Top">6</property>
    <property name="Width">372</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnClick">MainMenu1Click</property>
    <property name="OnShow"></property>
    <property name="jsOnClick">MainMenu1JSClick</property>
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
    <property name="Height">280</property>
    <property name="Left">8</property>
    <property name="Lines">a:0:{}</property>
    <property name="Name">Memo1</property>
    <property name="Top">40</property>
    <property name="Width">368</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <property name="OnSubmit"></property>
  </object>
</object>
?>
