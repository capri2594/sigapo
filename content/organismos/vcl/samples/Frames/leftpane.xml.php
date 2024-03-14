<?php
<object class="LeftPane" name="LeftPane" baseclass="page">
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
  <property name="Name">LeftPane</property>
  <property name="Width">192</property>
  <property name="OnAfterShow"></property>
  <property name="OnAfterShowFooter"></property>
  <property name="OnBeforeShow"></property>
  <property name="OnBeforeShowHeader"></property>
  <property name="OnCreate"></property>
  <property name="OnShow"></property>
  <property name="OnShowHeader"></property>
  <property name="OnStartBody"></property>
  <object class="DBRepeater" name="ddlinks1" >
    <property name="Caption">ddlinks1</property>
    <property name="Datasource">dslinks1</property>
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
    <property name="Height">25</property>
    <property name="Layout">
        <property name="Cols">5</property>
        <property name="Rows">5</property>
        <property name="Type">XY_LAYOUT</property>
    </property>
    <property name="Name">ddlinks1</property>
    <property name="Width">192</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <object class="Label" name="fdlinks1" >
      <property name="Caption">link_caption</property>
      <property name="DataField">link_caption</property>
      <property name="Datasource">dslinks1</property>
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
      <property name="LinkTarget">Frame3</property>
      <property name="Name">fdlinks1</property>
      <property name="Top">6</property>
      <property name="Width">177</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow">fdlinks1BeforeShow</property>
      <property name="OnShow"></property>
    </object>
  </object>
  <object class="Table" name="tblinks1" >
        <property name="Left">118</property>
        <property name="Top">44</property>
    <property name="Active">1</property>
    <property name="Database">dblinks1</property>
    <property name="Name">tblinks1</property>
    <property name="TableName">links</property>
  </object>
  <object class="Database" name="dblinks1" >
        <property name="Left">70</property>
        <property name="Top">44</property>
    <property name="Connected">1</property>
    <property name="DatabaseName">links</property>
    <property name="Dictionary"></property>
    <property name="DriverName">mysql</property>
    <property name="Host">localhost:3306</property>
    <property name="Name">dblinks1</property>
    <property name="UserName">root</property>
    <property name="UserPassword">test</property>
  </object>
  <object class="Datasource" name="dslinks1" >
        <property name="Left">14</property>
        <property name="Top">44</property>
    <property name="Dataset">tblinks1</property>
    <property name="Name">dslinks1</property>
  </object>
</object>
?>
