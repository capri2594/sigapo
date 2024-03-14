<?php
<object class="SimpleManagement" name="SimpleManagement" baseclass="page">
  <property name="Background"></property>
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
  <property name="Height">584</property>
  <property name="IsMaster">0</property>
  <property name="Layout">
    <property name="Cols">5</property>
    <property name="Rows">5</property>
    <property name="Type">XY_LAYOUT</property>
  </property>
  <property name="Name">SimpleManagement</property>
  <property name="Width">800</property>
  <property name="OnAfterShow"></property>
  <property name="OnAfterShowFooter"></property>
  <property name="OnBeforeShow">SimpleManagementBeforeShow</property>
  <property name="OnBeforeShowHeader"></property>
  <property name="OnCreate"></property>
  <property name="OnShow"></property>
  <property name="OnShowHeader"></property>
  <property name="OnStartBody"></property>
  <property name="OnTemplate"></property>
  <object class="Panel" name="Panel1" >
    <property name="BorderColor">#008080</property>
    <property name="BorderWidth">2</property>
    <property name="Caption">Panel1</property>
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
    <property name="Height">504</property>
    <property name="Layout">
        <property name="Cols">5</property>
        <property name="Rows">5</property>
        <property name="Type">XY_LAYOUT</property>
    </property>
    <property name="Left">248</property>
    <property name="Name">Panel1</property>
    <property name="Top">48</property>
    <property name="Visible">0</property>
    <property name="Width">408</property>
    <property name="OnAfterShow">Panel1AfterShow</property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <object class="Button" name="btnPost" >
      <property name="Caption">Save</property>
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
      <property name="Left">232</property>
      <property name="Name">btnPost</property>
      <property name="Top">464</property>
      <property name="Width">99</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnClick">btnPostClick</property>
      <property name="OnShow"></property>
    </object>
    <object class="Edit" name="fdproducts11" >
      <property name="DataField">products_ordered</property>
      <property name="Datasource">dsproducts1</property>
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
      <property name="Height">21</property>
      <property name="Left">128</property>
      <property name="Name">fdproducts11</property>
      <property name="Text">products_ordered</property>
      <property name="Top">406</property>
      <property name="Width">200</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
      <property name="OnSubmit"></property>
    </object>
    <object class="Edit" name="fdproducts10" >
      <property name="DataField">manufacturers_id</property>
      <property name="Datasource">dsproducts1</property>
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
      <property name="Height">21</property>
      <property name="Left">128</property>
      <property name="Name">fdproducts10</property>
      <property name="Text">manufacturers_id</property>
      <property name="Top">373</property>
      <property name="Width">200</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
      <property name="OnSubmit"></property>
    </object>
    <object class="Edit" name="fdproducts9" >
      <property name="DataField">products_tax_class_id</property>
      <property name="Datasource">dsproducts1</property>
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
      <property name="Height">21</property>
      <property name="Left">128</property>
      <property name="Name">fdproducts9</property>
      <property name="Text">products_tax_class_id</property>
      <property name="Top">340</property>
      <property name="Width">200</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
      <property name="OnSubmit"></property>
    </object>
    <object class="Label" name="Label1" >
      <property name="Caption">products_id</property>
      <property name="DataField">products_id</property>
      <property name="Datasource">dsproducts1</property>
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
      <property name="Height">14</property>
      <property name="Left">128</property>
      <property name="Name">Label1</property>
      <property name="Top">32</property>
      <property name="Width">200</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
    </object>
    <object class="Edit" name="Edit1" >
      <property name="DataField">products_quantity</property>
      <property name="Datasource">dsproducts1</property>
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
      <property name="Height">21</property>
      <property name="Left">128</property>
      <property name="Name">Edit1</property>
      <property name="Text">products_quantity</property>
      <property name="Top">61</property>
      <property name="Width">200</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
      <property name="OnSubmit"></property>
    </object>
    <object class="Edit" name="Edit2" >
      <property name="DataField">products_model</property>
      <property name="Datasource">dsproducts1</property>
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
      <property name="Height">21</property>
      <property name="Left">128</property>
      <property name="Name">Edit2</property>
      <property name="Text">products_model</property>
      <property name="Top">134</property>
      <property name="Width">200</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
      <property name="OnSubmit"></property>
    </object>
    <object class="Edit" name="Edit3" >
      <property name="DataField">products_image</property>
      <property name="Datasource">dsproducts1</property>
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
      <property name="Height">21</property>
      <property name="Left">128</property>
      <property name="Name">Edit3</property>
      <property name="Text">products_image</property>
      <property name="Top">167</property>
      <property name="Width">200</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
      <property name="OnSubmit"></property>
    </object>
    <object class="Edit" name="Edit4" >
      <property name="DataField">products_date_added</property>
      <property name="Datasource">dsproducts1</property>
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
      <property name="Height">21</property>
      <property name="Left">128</property>
      <property name="Name">Edit4</property>
      <property name="Text">products_date_added</property>
      <property name="Top">200</property>
      <property name="Width">200</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
      <property name="OnSubmit"></property>
    </object>
    <object class="Edit" name="Edit5" >
      <property name="DataField">products_last_modified</property>
      <property name="Datasource">dsproducts1</property>
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
      <property name="Height">21</property>
      <property name="Left">128</property>
      <property name="Name">Edit5</property>
      <property name="Text">products_last_modified</property>
      <property name="Top">233</property>
      <property name="Width">200</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
      <property name="OnSubmit"></property>
    </object>
    <object class="Edit" name="Edit6" >
      <property name="DataField">products_date_available</property>
      <property name="Datasource">dsproducts1</property>
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
      <property name="Height">21</property>
      <property name="Left">128</property>
      <property name="Name">Edit6</property>
      <property name="Text">products_date_available</property>
      <property name="Top">270</property>
      <property name="Width">200</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
      <property name="OnSubmit"></property>
    </object>
    <object class="Edit" name="Edit7" >
      <property name="DataField">products_status</property>
      <property name="Datasource">dsproducts1</property>
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
      <property name="Height">21</property>
      <property name="Left">128</property>
      <property name="Name">Edit7</property>
      <property name="Text">products_status</property>
      <property name="Top">307</property>
      <property name="Width">200</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
      <property name="OnSubmit"></property>
    </object>
    <object class="Label" name="Label3" >
      <property name="Caption">ID:</property>
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
      <property name="Left">24</property>
      <property name="Name">Label3</property>
      <property name="Top">32</property>
      <property name="Width">75</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
    </object>
    <object class="Label" name="Label4" >
      <property name="Caption">Quantity:</property>
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
      <property name="Left">24</property>
      <property name="Name">Label4</property>
      <property name="Top">65</property>
      <property name="Width">75</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
    </object>
    <object class="Label" name="Label5" >
      <property name="Caption">Model:</property>
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
      <property name="Left">24</property>
      <property name="Name">Label5</property>
      <property name="Top">138</property>
      <property name="Width">75</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
    </object>
    <object class="Label" name="Label6" >
      <property name="Caption">Image:</property>
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
      <property name="Left">24</property>
      <property name="Name">Label6</property>
      <property name="Top">171</property>
      <property name="Width">75</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
    </object>
    <object class="Label" name="Label7" >
      <property name="Caption">Date Added:</property>
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
      <property name="Left">24</property>
      <property name="Name">Label7</property>
      <property name="Top">204</property>
      <property name="Width">75</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
    </object>
    <object class="Label" name="Label8" >
      <property name="Caption">Last Modified:</property>
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
      <property name="Left">24</property>
      <property name="Name">Label8</property>
      <property name="Top">237</property>
      <property name="Width">96</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
    </object>
    <object class="Label" name="Label9" >
      <property name="Caption">Date Available:</property>
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
      <property name="Left">24</property>
      <property name="Name">Label9</property>
      <property name="Top">274</property>
      <property name="Width">96</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
    </object>
    <object class="Label" name="Label10" >
      <property name="Caption">Status:</property>
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
      <property name="Left">24</property>
      <property name="Name">Label10</property>
      <property name="Top">311</property>
      <property name="Width">75</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
    </object>
    <object class="Label" name="Label11" >
      <property name="Caption">Tax Class:</property>
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
      <property name="Left">24</property>
      <property name="Name">Label11</property>
      <property name="Top">344</property>
      <property name="Width">75</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
    </object>
    <object class="Label" name="Label12" >
      <property name="Caption">Manufacturer:</property>
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
      <property name="Left">24</property>
      <property name="Name">Label12</property>
      <property name="Top">377</property>
      <property name="Width">75</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
    </object>
    <object class="Label" name="Label13" >
      <property name="Caption">Ordered:</property>
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
      <property name="Left">24</property>
      <property name="Name">Label13</property>
      <property name="Top">410</property>
      <property name="Width">75</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
    </object>
    <object class="Label" name="Label14" >
      <property name="Caption">Modify the product:</property>
      <property name="Font">
            <property name="Align">taNone</property>
            <property name="Case"></property>
            <property name="Color"></property>
            <property name="Family">Verdana</property>
            <property name="LineHeight"></property>
            <property name="Size">10px</property>
            <property name="Style"></property>
            <property name="Variant"></property>
            <property name="Weight">bold</property>
      </property>
      <property name="Height">13</property>
      <property name="Left">27</property>
      <property name="Name">Label14</property>
      <property name="ParentFont">0</property>
      <property name="Top">6</property>
      <property name="Width">229</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
    </object>
    <object class="Label" name="Label15" >
      <property name="Caption">Price:</property>
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
      <property name="Left">24</property>
      <property name="Name">Label15</property>
      <property name="Top">98</property>
      <property name="Width">75</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
    </object>
    <object class="Edit" name="Edit8" >
      <property name="DataField">products_price</property>
      <property name="Datasource">dsproducts1</property>
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
      <property name="Height">21</property>
      <property name="Left">128</property>
      <property name="Name">Edit8</property>
      <property name="Text">products_price</property>
      <property name="Top">94</property>
      <property name="Width">200</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
      <property name="OnSubmit"></property>
    </object>
    <object class="Label" name="Label16" >
      <property name="Caption">Weight:</property>
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
      <property name="Left">24</property>
      <property name="Name">Label16</property>
      <property name="Top">442</property>
      <property name="Width">75</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
    </object>
    <object class="Edit" name="Edit9" >
      <property name="DataField">products_weight</property>
      <property name="Datasource">dsproducts1</property>
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
      <property name="Height">21</property>
      <property name="Left">128</property>
      <property name="Name">Edit9</property>
      <property name="Text">products_weight</property>
      <property name="Top">438</property>
      <property name="Width">200</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
      <property name="OnSubmit"></property>
    </object>
  </object>
  <object class="DBRepeater" name="DBRepeater1" >
    <property name="Caption">dbrProductList</property>
    <property name="Color">#97CDE8</property>
    <property name="DataSource">dsRepeater</property>
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
    <property name="Height">24</property>
    <property name="Layout">
        <property name="Cols">5</property>
        <property name="Rows">5</property>
        <property name="Type">XY_LAYOUT</property>
    </property>
    <property name="Name">DBRepeater1</property>
    <property name="Top">64</property>
    <property name="Width">240</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <object class="Label" name="fdproducts1" >
      <property name="Caption">products_model</property>
      <property name="Color">#97CDE8</property>
      <property name="DataField">products_model</property>
      <property name="Datasource">dsRepeater</property>
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
      <property name="Height">14</property>
      <property name="Left">5</property>
      <property name="Name">fdproducts1</property>
      <property name="Top">6</property>
      <property name="Width">100</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow">fdproducts1BeforeShow</property>
      <property name="OnShow"></property>
    </object>
    <object class="Label" name="Label17" >
      <property name="Caption">[delete]</property>
      <property name="Color">#97CDE8</property>
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
      <property name="Left">184</property>
      <property name="Name">Label17</property>
      <property name="Top">6</property>
      <property name="Width">48</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow">Label17BeforeShow</property>
      <property name="OnShow"></property>
    </object>
  </object>
  <object class="Label" name="Label2" >
    <property name="Caption"><![CDATA[Click on the product you want to edit, click on [delete] to delete such record, or click on &quot;add new&quot; to add a new one]]></property>
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
    <property name="Height">19</property>
    <property name="Left">6</property>
    <property name="Name">Label2</property>
    <property name="Top">5</property>
    <property name="Width">706</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
  <object class="Button" name="btnAdd" >
    <property name="Caption">Add New</property>
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
    <property name="Height">19</property>
    <property name="Left">166</property>
    <property name="Name">btnAdd</property>
    <property name="Top">40</property>
    <property name="Width">75</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnClick">btnAddClick</property>
    <property name="OnShow"></property>
  </object>
  <object class="Label" name="lbMessages" >
    <property name="Caption">lbMessages</property>
    <property name="Font">
        <property name="Align">taNone</property>
        <property name="Case"></property>
        <property name="Color">#FF0000</property>
        <property name="Family">Verdana</property>
        <property name="LineHeight"></property>
        <property name="Size">10px</property>
        <property name="Style"></property>
        <property name="Variant"></property>
        <property name="Weight">bold</property>
    </property>
    <property name="Height">13</property>
    <property name="Left">252</property>
    <property name="Name">lbMessages</property>
    <property name="ParentFont">0</property>
    <property name="Top">31</property>
    <property name="Visible">0</property>
    <property name="Width">356</property>
    <property name="OnAfterShow">lbMessagesAfterShow</property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
  <object class="Table" name="tbproducts1" >
        <property name="Left">702</property>
        <property name="Top">159</property>
    <property name="Active">1</property>
    <property name="Database">dboscommerce1</property>
    <property name="MasterFields">a:0:{}</property>
    <property name="MasterSource"></property>
    <property name="Name">tbproducts1</property>
    <property name="TableName">products</property>
    <property name="OnAfterCancel"></property>
    <property name="OnAfterClose"></property>
    <property name="OnAfterDelete"></property>
    <property name="OnAfterEdit"></property>
    <property name="OnAfterInsert"></property>
    <property name="OnAfterOpen"></property>
    <property name="OnAfterPost"></property>
    <property name="OnBeforeCancel"></property>
    <property name="OnBeforeClose"></property>
    <property name="OnBeforeDelete"></property>
    <property name="OnBeforeEdit"></property>
    <property name="OnBeforeInsert"></property>
    <property name="OnBeforeOpen"></property>
    <property name="OnBeforePost"></property>
    <property name="OnDeleteError"></property>
  </object>
  <object class="Database" name="dboscommerce1" >
        <property name="Left">702</property>
        <property name="Top">119</property>
    <property name="Connected">1</property>
    <property name="DatabaseName">oscommerce</property>
    <property name="Dictionary"></property>
    <property name="DriverName">mysql</property>
    <property name="Host">localhost:3306</property>
    <property name="Name">dboscommerce1</property>
    <property name="UserName">root</property>
    <property name="UserPassword">test</property>
    <property name="OnAfterConnect"></property>
    <property name="OnAfterDisconnect"></property>
    <property name="OnBeforeConnect"></property>
    <property name="OnBeforeDisconnect"></property>
  </object>
  <object class="Datasource" name="dsproducts1" >
        <property name="Left">702</property>
        <property name="Top">71</property>
    <property name="Dataset">tbproducts1</property>
    <property name="Name">dsproducts1</property>
  </object>
  <object class="Table" name="tbRepeater" >
        <property name="Left">150</property>
        <property name="Top">127</property>
    <property name="Active">1</property>
    <property name="Database">dboscommerce1</property>
    <property name="MasterFields">a:0:{}</property>
    <property name="MasterSource"></property>
    <property name="Name">tbRepeater</property>
    <property name="TableName">products</property>
    <property name="OnAfterCancel"></property>
    <property name="OnAfterClose"></property>
    <property name="OnAfterDelete"></property>
    <property name="OnAfterEdit"></property>
    <property name="OnAfterInsert"></property>
    <property name="OnAfterOpen"></property>
    <property name="OnAfterPost"></property>
    <property name="OnBeforeCancel"></property>
    <property name="OnBeforeClose"></property>
    <property name="OnBeforeDelete"></property>
    <property name="OnBeforeEdit"></property>
    <property name="OnBeforeInsert"></property>
    <property name="OnBeforeOpen"></property>
    <property name="OnBeforePost"></property>
    <property name="OnDeleteError"></property>
  </object>
  <object class="Datasource" name="dsRepeater" >
        <property name="Left">198</property>
        <property name="Top">127</property>
    <property name="Dataset">tbRepeater</property>
    <property name="Name">dsRepeater</property>
  </object>
</object>
?>
