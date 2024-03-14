<?php
<object class="Index" name="Index" baseclass="page">
  <property name="Background"></property>
  <property name="Caption">Template Sample</property>
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
  <property name="TemplateEngine">SmartyTemplate</property>
  <property name="TemplateFilename">index.html</property>
  <property name="Width">800</property>
  <property name="OnAfterShow"></property>
  <property name="OnAfterShowFooter"></property>
  <property name="OnBeforeShow"></property>
  <property name="OnBeforeShowHeader"></property>
  <property name="OnCreate"></property>
  <property name="OnShow"></property>
  <property name="OnShowHeader"></property>
  <property name="OnStartBody"></property>
  <object class="RichEdit" name="RichEdit1" >
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
    <property name="Left">32</property>
    <property name="Lines"><![CDATA[a:3:{i:0;s:45:&quot;Write some text here and push the button!&lt;br&gt;&quot;;i:1;s:66:&quot;Open the index.html file with your browser to see the template&lt;br&gt;&quot;;i:2;s:83:&quot;And open it with the code editor and search for { }, those are the placeholders&lt;br&gt;&quot;;}]]></property>
    <property name="Name">RichEdit1</property>
    <property name="Top">48</property>
    <property name="Width">400</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <property name="OnSubmit"></property>
  </object>
  <object class="Button" name="btnSendContents" >
    <property name="Caption">Send Contents</property>
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
    <property name="Left">480</property>
    <property name="Name">btnSendContents</property>
    <property name="Top">48</property>
    <property name="Width">128</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnClick">btnSendContentsClick</property>
    <property name="OnShow"></property>
  </object>
  <object class="Label" name="lbMessage" >
    <property name="Caption">lbMessage</property>
    <property name="Font">
        <property name="Align">taNone</property>
        <property name="Case"></property>
        <property name="Color">#FF0000</property>
        <property name="Family">Verdana</property>
        <property name="LineHeight"></property>
        <property name="Size">14px</property>
        <property name="Style"></property>
        <property name="Variant"></property>
        <property name="Weight">bold</property>
    </property>
    <property name="Height">80</property>
    <property name="Left">40</property>
    <property name="Name">lbMessage</property>
    <property name="ParentFont">0</property>
    <property name="Top">336</property>
    <property name="Visible">0</property>
    <property name="Width">376</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
</object>
?>
