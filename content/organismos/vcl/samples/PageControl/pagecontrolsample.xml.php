<?php
<object class="Unit246" name="Unit246" baseclass="page">
  <property name="Background"></property>
  <property name="Caption">Page Control Sample</property>
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
  <property name="Name">Unit246</property>
  <property name="Width">976</property>
  <property name="OnAfterShow"></property>
  <property name="OnAfterShowFooter"></property>
  <property name="OnBeforeShow"></property>
  <property name="OnBeforeShowHeader"></property>
  <property name="OnCreate"></property>
  <property name="OnShow"></property>
  <property name="OnShowHeader"></property>
  <property name="OnStartBody"></property>
  <property name="OnTemplate"></property>
  <object class="Window" name="Window1" >
    <property name="Caption">Desktop properties</property>
    <property name="Height">455</property>
    <property name="Left">24</property>
    <property name="Name">Window1</property>
    <property name="ShowIcon">0</property>
    <property name="ShowMaximize">0</property>
    <property name="ShowMinimize">0</property>
    <property name="Top">24</property>
    <property name="Width">404</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <object class="PageControl" name="PageControl2" >
      <property name="ActiveLayer">Themes</property>
      <property name="Height">378</property>
      <property name="Left">8</property>
      <property name="Name">PageControl2</property>
      <property name="TabIndex">0</property>
      <property name="Tabs"><![CDATA[a:5:{i:0;s:6:&quot;Themes&quot;;i:1;s:7:&quot;Desktop&quot;;i:2;s:11:&quot;ScreenSaver&quot;;i:3;s:4:&quot;Look&quot;;i:4;s:5:&quot;Setup&quot;;}]]></property>
      <property name="Top">29</property>
      <property name="Width">385</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
      <object class="ComboBox" name="ComboBox2" >
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
        <property name="Height">18</property>
        <property name="Items">a:0:{}</property>
        <property name="Layer">Themes</property>
        <property name="Left">14</property>
        <property name="Name">ComboBox2</property>
        <property name="Top">81</property>
        <property name="Width">185</property>
        <property name="OnAfterShow"></property>
        <property name="OnBeforeShow"></property>
        <property name="OnShow"></property>
        <property name="OnSubmit"></property>
      </object>
      <object class="Button" name="Button4" >
        <property name="Caption">Save as...</property>
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
        <property name="Layer">Themes</property>
        <property name="Left">208</property>
        <property name="Name">Button4</property>
        <property name="Top">79</property>
        <property name="Width">75</property>
        <property name="OnAfterShow"></property>
        <property name="OnBeforeShow"></property>
        <property name="OnShow"></property>
      </object>
      <object class="Button" name="Button5" >
        <property name="Caption">Delete</property>
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
        <property name="Layer">Themes</property>
        <property name="Left">288</property>
        <property name="Name">Button5</property>
        <property name="Top">79</property>
        <property name="Width">75</property>
        <property name="OnAfterShow"></property>
        <property name="OnBeforeShow"></property>
        <property name="OnShow"></property>
      </object>
      <object class="Label" name="Label3" >
        <property name="Caption"><![CDATA[&lt;P&gt;Just think what you can do with Delphi for PHP.... ;-)&lt;/P&gt;]]></property>
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
        <property name="Height">32</property>
        <property name="Layer">Themes</property>
        <property name="Left">16</property>
        <property name="Name">Label3</property>
        <property name="Top">40</property>
        <property name="Width">352</property>
        <property name="OnAfterShow"></property>
        <property name="OnBeforeShow"></property>
        <property name="OnShow"></property>
      </object>
      <object class="Image" name="Image3" >
        <property name="Autosize">1</property>
        <property name="Border">0</property>
        <property name="Height">222</property>
        <property name="ImageSource">theme.gif</property>
        <property name="Layer">Themes</property>
        <property name="Left">13</property>
        <property name="Link"></property>
        <property name="LinkTarget"></property>
        <property name="Name">Image3</property>
        <property name="Top">112</property>
        <property name="Width">351</property>
        <property name="OnAfterShow"></property>
        <property name="OnBeforeShow"></property>
        <property name="OnCustomize"></property>
        <property name="OnShow"></property>
      </object>
      <object class="Image" name="Image4" >
        <property name="Autosize">1</property>
        <property name="Border">0</property>
        <property name="Height">159</property>
        <property name="ImageSource">monitor.gif</property>
        <property name="Layer">Desktop</property>
        <property name="Left">91</property>
        <property name="Link"></property>
        <property name="LinkTarget"></property>
        <property name="Name">Image4</property>
        <property name="Top">46</property>
        <property name="Width">177</property>
        <property name="OnAfterShow"></property>
        <property name="OnBeforeShow"></property>
        <property name="OnCustomize"></property>
        <property name="OnShow"></property>
      </object>
      <object class="ListBox" name="ListBox2" >
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
        <property name="Height">104</property>
        <property name="Items"><![CDATA[a:3:{s:1:&quot;1&quot;;s:5:&quot;Test1&quot;;s:1:&quot;2&quot;;s:5:&quot;Test2&quot;;s:1:&quot;3&quot;;s:5:&quot;Test3&quot;;}]]></property>
        <property name="Layer">Desktop</property>
        <property name="Left">16</property>
        <property name="Name">ListBox2</property>
        <property name="Top">248</property>
        <property name="Width">256</property>
        <property name="OnAfterShow"></property>
        <property name="OnBeforeShow"></property>
        <property name="OnShow"></property>
        <property name="OnSubmit"></property>
      </object>
      <object class="Label" name="Label4" >
        <property name="Caption">Background:</property>
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
        <property name="Layer">Desktop</property>
        <property name="Left">16</property>
        <property name="Name">Label4</property>
        <property name="Top">232</property>
        <property name="Width">75</property>
        <property name="OnAfterShow"></property>
        <property name="OnBeforeShow"></property>
        <property name="OnShow"></property>
      </object>
      <object class="Button" name="Button6" >
        <property name="Caption">Browse...</property>
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
        <property name="Layer">Desktop</property>
        <property name="Left">280</property>
        <property name="Name">Button6</property>
        <property name="Top">248</property>
        <property name="Width">75</property>
        <property name="OnAfterShow"></property>
        <property name="OnBeforeShow"></property>
        <property name="OnShow"></property>
      </object>
    </object>
    <object class="Button" name="Button7" >
      <property name="Caption">Apply</property>
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
      <property name="Left">320</property>
      <property name="Name">Button7</property>
      <property name="Top">416</property>
      <property name="Width">75</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
    </object>
    <object class="Button" name="Button8" >
      <property name="Caption">Cancel</property>
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
      <property name="Left">240</property>
      <property name="Name">Button8</property>
      <property name="Top">416</property>
      <property name="Width">75</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
    </object>
    <object class="Button" name="Button9" >
      <property name="Caption">OK</property>
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
      <property name="Left">160</property>
      <property name="Name">Button9</property>
      <property name="Top">416</property>
      <property name="Width">75</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
    </object>
  </object>
</object>
?>
