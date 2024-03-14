<?php
<object class="ECommerceMain" name="ECommerceMain" baseclass="page">
  <property name="Background"></property>
  <property name="Caption">ECommerceMain</property>
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
  <property name="Name">ECommerceMain</property>
  <property name="TemplateEngine">SmartyTemplate</property>
  <property name="TemplateFilename">templates/index.tpl</property>
  <property name="Width">800</property>
  <property name="OnAfterShow"></property>
  <property name="OnAfterShowFooter"></property>
  <property name="OnBeforeShow"></property>
  <property name="OnBeforeShowHeader"></property>
  <property name="OnCreate">ECommerceMainCreate</property>
  <property name="OnShow"></property>
  <property name="OnShowHeader"></property>
  <property name="OnStartBody"></property>
  <property name="OnTemplate"></property>
  <object class="RawOutput" name="PageTitle" >
    <property name="Height">25</property>
    <property name="Left">9</property>
    <property name="Name">PageTitle</property>
    <property name="Top">7</property>
    <property name="Width">348</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
  <object class="UserLogin" name="CurrentUserLogin" >
    <property name="Database"></property>
    <property name="Height">25</property>
    <property name="Left">8</property>
    <property name="Name">CurrentUserLogin</property>
    <property name="Top">40</property>
    <property name="UserTable">users</property>
    <property name="Width">100</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
  <object class="DBRepeater" name="AdBar" >
    <property name="Caption">AdBar</property>
    <property name="DataSource">DBModule.AdDatasource1</property>
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
    <property name="Height">221</property>
    <property name="Layout">
        <property name="Cols">5</property>
        <property name="Rows">5</property>
        <property name="Type">XY_LAYOUT</property>
    </property>
    <property name="Left">8</property>
    <property name="Name">AdBar</property>
    <property name="Top">81</property>
    <property name="Width">240</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <object class="Image" name="Image1" >
      <property name="Autosize">0</property>
      <property name="Border">0</property>
      <property name="Height">180</property>
      <property name="ImageSource"></property>
      <property name="Link"></property>
      <property name="LinkTarget"></property>
      <property name="Name">Image1</property>
      <property name="Width">240</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow">Image1BeforeShow</property>
      <property name="OnCustomize"></property>
      <property name="OnShow"></property>
    </object>
    <object class="Label" name="Label1" >
      <property name="Alignment">agCenter</property>
      <property name="Caption">Label1</property>
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
      <property name="Left">7</property>
      <property name="Name">Label1</property>
      <property name="Top">186</property>
      <property name="Width">224</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow">Label1BeforeShow</property>
      <property name="OnShow"></property>
    </object>
  </object>
  <object class="RawInclude" name="PageContent" >
    <property name="Height">100</property>
    <property name="Left">6</property>
    <property name="Name">PageContent</property>
    <property name="Top">315</property>
    <property name="Width">100</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
</object>
?>
