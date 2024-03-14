<?php
<object class="CatalogForm" name="CatalogForm" baseclass="page">
  <property name="Background"></property>
  <property name="Caption">Noname1</property>
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
  <property name="Name">CatalogForm</property>
  <property name="ShowFooter">0</property>
  <property name="ShowHeader">0</property>
  <property name="TemplateEngine">SmartyTemplate</property>
  <property name="TemplateFilename">templates/catalog.tpl</property>
  <property name="Width">800</property>
  <property name="OnAfterShow"></property>
  <property name="OnAfterShowFooter"></property>
  <property name="OnBeforeShow"></property>
  <property name="OnBeforeShowHeader"></property>
  <property name="OnCreate">CatalogFormCreate</property>
  <property name="OnShow"></property>
  <property name="OnShowHeader"></property>
  <property name="OnStartBody"></property>
  <object class="DBRepeater" name="Catalog" >
    <property name="Caption">Catalog</property>
    <property name="DataSource"></property>
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
    <property name="Height">190</property>
    <property name="Left">8</property>
    <property name="Name">Catalog</property>
    <property name="Top">8</property>
    <property name="Width">553</property>
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
      <property name="Caption">Label1</property>
      <property name="Font">
            <property name="Align">taNone</property>
            <property name="Case"></property>
            <property name="Color"></property>
            <property name="Family">Verdana</property>
            <property name="LineHeight"></property>
            <property name="Size">12pt</property>
            <property name="Style"></property>
            <property name="Variant"></property>
            <property name="Weight"></property>
      </property>
      <property name="Height">23</property>
      <property name="Left">249</property>
      <property name="Name">Label1</property>
      <property name="ParentFont">0</property>
      <property name="Top">10</property>
      <property name="Width">275</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow">Label1BeforeShow</property>
      <property name="OnShow"></property>
    </object>
    <object class="Label" name="Label2" >
      <property name="Caption">Label2</property>
      <property name="Font">
            <property name="Align">taNone</property>
            <property name="Case"></property>
            <property name="Color"></property>
            <property name="Family">Verdana</property>
            <property name="LineHeight"></property>
            <property name="Size">12pt</property>
            <property name="Style"></property>
            <property name="Variant"></property>
            <property name="Weight"></property>
      </property>
      <property name="Height">20</property>
      <property name="Left">248</property>
      <property name="Name">Label2</property>
      <property name="ParentFont">0</property>
      <property name="Top">42</property>
      <property name="Width">276</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow">Label2BeforeShow</property>
      <property name="OnShow"></property>
    </object>
    <object class="Label" name="Label3" >
      <property name="Caption">Add To Cart</property>
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
      <property name="Left">249</property>
      <property name="Name">Label3</property>
      <property name="ParentFont">0</property>
      <property name="Top">75</property>
      <property name="Width">90</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow">Label3BeforeShow</property>
      <property name="OnShow"></property>
    </object>
  </object>
</object>
?>
