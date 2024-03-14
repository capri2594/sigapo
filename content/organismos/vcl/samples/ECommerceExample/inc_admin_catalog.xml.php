<?php
<object class="AdminCatalog" name="AdminCatalog" baseclass="page">
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
  <property name="Name">AdminCatalog</property>
  <property name="ShowFooter">0</property>
  <property name="ShowHeader">0</property>
  <property name="TemplateEngine">SmartyTemplate</property>
  <property name="TemplateFilename">templates/admin_catalog.tpl</property>
  <property name="Width">800</property>
  <property name="OnAfterShow"></property>
  <property name="OnAfterShowFooter"></property>
  <property name="OnBeforeShow"></property>
  <property name="OnBeforeShowHeader"></property>
  <property name="OnCreate"></property>
  <property name="OnShow">AdminCatalogShow</property>
  <property name="OnShowHeader"></property>
  <property name="OnStartBody"></property>
  <property name="OnTemplate"></property>
  <object class="Edit" name="AddNameInput" >
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
    <property name="Height">21</property>
    <property name="Left">6</property>
    <property name="Name">AddNameInput</property>
    <property name="ParentFont">0</property>
    <property name="Top">9</property>
    <property name="Width">312</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <property name="OnSubmit"></property>
  </object>
  <object class="Edit" name="AddCostInput" >
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
    <property name="Height">21</property>
    <property name="Left">10</property>
    <property name="Name">AddCostInput</property>
    <property name="ParentFont">0</property>
    <property name="Top">41</property>
    <property name="Width">125</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <property name="OnSubmit"></property>
  </object>
  <object class="Edit" name="AddImageInput" >
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
    <property name="Height">21</property>
    <property name="Left">8</property>
    <property name="Name">AddImageInput</property>
    <property name="ParentFont">0</property>
    <property name="Top">71</property>
    <property name="Width">309</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <property name="OnSubmit"></property>
  </object>
  <object class="Button" name="AddSubmitButton" >
    <property name="Caption">Add</property>
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
    <property name="Height">25</property>
    <property name="Left">8</property>
    <property name="Name">AddSubmitButton</property>
    <property name="ParentFont">0</property>
    <property name="Top">105</property>
    <property name="Width">102</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
  <object class="RawOutput" name="Msg" >
    <property name="Height">25</property>
    <property name="Left">9</property>
    <property name="Name">Msg</property>
    <property name="Top">144</property>
    <property name="Width">75</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
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
    <property name="Height">196</property>
    <property name="Layout">
        <property name="Cols">5</property>
        <property name="Rows">5</property>
        <property name="Type">XY_LAYOUT</property>
    </property>
    <property name="Left">1</property>
    <property name="Name">Catalog</property>
    <property name="Top">196</property>
    <property name="Width">550</property>
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
    <object class="Label" name="Label2" >
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
      <property name="Name">Label2</property>
      <property name="ParentFont">0</property>
      <property name="Top">10</property>
      <property name="Width">275</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow">Label1BeforeShow</property>
      <property name="OnShow"></property>
    </object>
    <object class="Label" name="Label1" >
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
      <property name="Name">Label1</property>
      <property name="ParentFont">0</property>
      <property name="Top">42</property>
      <property name="Width">276</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow">Label2BeforeShow</property>
      <property name="OnShow"></property>
    </object>
    <object class="Label" name="Label4" >
      <property name="Caption">Delete Product</property>
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
      <property name="Name">Label4</property>
      <property name="ParentFont">0</property>
      <property name="Top">75</property>
      <property name="Width">137</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow">Label3BeforeShow</property>
      <property name="OnShow"></property>
    </object>
  </object>
</object>
?>
