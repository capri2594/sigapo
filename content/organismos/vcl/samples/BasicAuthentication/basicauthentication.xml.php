<?php
<object class="PasswordProtectedPage" name="PasswordProtectedPage" baseclass="page">
  <property name="Background"></property>
  <property name="Caption">Unit156</property>
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
  <property name="Name">PasswordProtectedPage</property>
  <property name="Width">800</property>
  <property name="OnAfterShow"></property>
  <property name="OnAfterShowFooter"></property>
  <property name="OnBeforeShow">PasswordProtectedPageBeforeShow</property>
  <property name="OnBeforeShowHeader"></property>
  <property name="OnCreate"></property>
  <property name="OnShow"></property>
  <property name="OnShowHeader"></property>
  <property name="OnStartBody"></property>
  <object class="Label" name="Label1" >
    <property name="Caption"><![CDATA[&lt;P&gt;This component is useful to easily protect webpages using http authentication, if you run this project, you won't see this text unless you enter the right user and password. &lt;/P&gt;
&lt;P&gt;&lt;STRONG&gt;User: delphiforphp&lt;/STRONG&gt;&lt;/P&gt;
&lt;P&gt;&lt;STRONG&gt;Password: rules&lt;/STRONG&gt;&lt;/P&gt;]]></property>
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
    <property name="Height">200</property>
    <property name="Left">24</property>
    <property name="Name">Label1</property>
    <property name="Top">16</property>
    <property name="Width">384</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
  <object class="BasicAuthentication" name="BasicAuthentication1" >
        <property name="Left">515</property>
        <property name="Top">99</property>
    <property name="ErrorMessage">You can put here any message when authorization is not granted</property>
    <property name="Name">BasicAuthentication1</property>
    <property name="Title">Login (you can change this)</property>
    <property name="OnAuthenticate">BasicAuthentication1Authenticate</property>
  </object>
</object>
?>
