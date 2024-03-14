<?php
<object class="Admin" name="Admin" baseclass="page">
  <property name="Background"></property>
  <property name="Caption">Noname1</property>
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
  <property name="Name">Admin</property>
  <property name="TemplateEngine">SmartyTemplate</property>
  <property name="TemplateFilename">templates/admin.tpl</property>
  <property name="Width">800</property>
  <property name="OnAfterShow"></property>
  <property name="OnAfterShowFooter"></property>
  <property name="OnBeforeShow"></property>
  <property name="OnBeforeShowHeader"></property>
  <property name="OnCreate">AdminCreate</property>
  <property name="OnShow"></property>
  <property name="OnShowHeader"></property>
  <property name="OnStartBody"></property>
  <property name="OnTemplate"></property>
  <object class="RawOutput" name="PageTitle" >
    <property name="Height">25</property>
    <property name="Left">6</property>
    <property name="Name">PageTitle</property>
    <property name="Top">5</property>
    <property name="Width">75</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
  <object class="RawInclude" name="PageContent" >
    <property name="Height">100</property>
    <property name="Left">8</property>
    <property name="Name">PageContent</property>
    <property name="Top">47</property>
    <property name="Width">100</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
  <object class="UserLogin" name="CurrentUserLogin" >
    <property name="CookieName">adminloginid</property>
    <property name="Database"></property>
    <property name="Height">25</property>
    <property name="Left">9</property>
    <property name="Name">CurrentUserLogin</property>
    <property name="Top">161</property>
    <property name="UserTable">admins</property>
    <property name="Width">215</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
</object>
?>
