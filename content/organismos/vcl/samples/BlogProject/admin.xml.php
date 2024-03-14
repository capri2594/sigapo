<?php
<object class="Admin" name="Admin" baseclass="page">
  <property name="Background"></property>
  <property name="Caption">Blog Admin Panel</property>
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
    <property name="Type">XY_LAYOUT</property>
  </property>
  <property name="Name">Admin</property>
  <property name="Width">800</property>
  <property name="OnAfterShow"></property>
  <property name="OnAfterShowFooter"></property>
  <property name="OnBeforeShow"></property>
  <property name="OnBeforeShowHeader"></property>
  <property name="OnCreate">AdminCreate</property>
  <property name="OnShow"></property>
  <property name="OnShowHeader"></property>
  <property name="OnStartBody"></property>
  <object class="Label" name="Label1" >
    <property name="Caption">Blog Admin Panel</property>
    <property name="Font">
        <property name="Align">taNone</property>
        <property name="Case"></property>
        <property name="Color"></property>
        <property name="Family">Verdana</property>
        <property name="LineHeight"></property>
        <property name="Size">14pt</property>
        <property name="Style"></property>
        <property name="Variant"></property>
        <property name="Weight"></property>
    </property>
    <property name="Height">27</property>
    <property name="Left">8</property>
    <property name="Name">Label1</property>
    <property name="ParentFont">0</property>
    <property name="Top">8</property>
    <property name="Width">264</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
  <object class="Label" name="Label2" >
    <property name="Caption">Blog posts:</property>
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
    <property name="Height">20</property>
    <property name="Left">8</property>
    <property name="Name">Label2</property>
    <property name="ParentFont">0</property>
    <property name="Top">52</property>
    <property name="Width">75</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
  <object class="Panel" name="Panel1" >
    <property name="BorderColor">black</property>
    <property name="BorderWidth">1</property>
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
    <property name="Height">232</property>
    <property name="Layout">
        <property name="Cols">5</property>
        <property name="Rows">5</property>
        <property name="Type">XY_LAYOUT</property>
    </property>
    <property name="Left">9</property>
    <property name="Name">Panel1</property>
    <property name="Top">72</property>
    <property name="Width">783</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <object class="DBRepeater" name="DBRepeater1" >
      <property name="Caption">DBRepeater1</property>
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
      <property name="Height">176</property>
      <property name="Layout">
            <property name="Cols">5</property>
            <property name="Rows">5</property>
            <property name="Type">XY_LAYOUT</property>
      </property>
      <property name="Left">7</property>
      <property name="Name">DBRepeater1</property>
      <property name="Top">8</property>
      <property name="Width">768</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
      <object class="Label" name="Label3" >
        <property name="Caption">Title:</property>
        <property name="Font">
                <property name="Align">taNone</property>
                <property name="Case"></property>
                <property name="Color"></property>
                <property name="Family">Verdana</property>
                <property name="LineHeight"></property>
                <property name="Size">8pt</property>
                <property name="Style"></property>
                <property name="Variant"></property>
                <property name="Weight"></property>
        </property>
        <property name="Height">13</property>
        <property name="Left">6</property>
        <property name="Name">Label3</property>
        <property name="ParentFont">0</property>
        <property name="Top">8</property>
        <property name="Width">34</property>
        <property name="OnAfterShow"></property>
        <property name="OnBeforeShow"></property>
        <property name="OnShow"></property>
      </object>
      <object class="Label" name="Label4" >
        <property name="Caption">Content:</property>
        <property name="Font">
                <property name="Align">taNone</property>
                <property name="Case"></property>
                <property name="Color"></property>
                <property name="Family">Verdana</property>
                <property name="LineHeight"></property>
                <property name="Size">8pt</property>
                <property name="Style"></property>
                <property name="Variant"></property>
                <property name="Weight"></property>
        </property>
        <property name="Height">13</property>
        <property name="Left">6</property>
        <property name="Name">Label4</property>
        <property name="ParentFont">0</property>
        <property name="Top">28</property>
        <property name="Width">58</property>
        <property name="OnAfterShow"></property>
        <property name="OnBeforeShow"></property>
        <property name="OnShow"></property>
      </object>
      <object class="Label" name="Label5" >
        <property name="Caption">Label5</property>
        <property name="DataField">Title</property>
        <property name="DataSource">BlogDB.BlogsDatasource1</property>
        <property name="Font">
                <property name="Align">taNone</property>
                <property name="Case"></property>
                <property name="Color"></property>
                <property name="Family">Verdana</property>
                <property name="LineHeight"></property>
                <property name="Size">8pt</property>
                <property name="Style"></property>
                <property name="Variant"></property>
                <property name="Weight"></property>
        </property>
        <property name="Height">13</property>
        <property name="Left">72</property>
        <property name="Name">Label5</property>
        <property name="ParentFont">0</property>
        <property name="Top">8</property>
        <property name="Width">688</property>
        <property name="OnAfterShow"></property>
        <property name="OnBeforeShow"></property>
        <property name="OnShow"></property>
      </object>
      <object class="Label" name="Label6" >
        <property name="Caption">Label6</property>
        <property name="DataField">Content</property>
        <property name="DataSource">BlogDB.BlogsDatasource1</property>
        <property name="Font">
                <property name="Align">taNone</property>
                <property name="Case"></property>
                <property name="Color"></property>
                <property name="Family">Verdana</property>
                <property name="LineHeight"></property>
                <property name="Size">8pt</property>
                <property name="Style"></property>
                <property name="Variant"></property>
                <property name="Weight"></property>
        </property>
        <property name="Height">80</property>
        <property name="Left">8</property>
        <property name="Name">Label6</property>
        <property name="ParentFont">0</property>
        <property name="Top">48</property>
        <property name="Width">752</property>
        <property name="OnAfterShow"></property>
        <property name="OnBeforeShow"></property>
        <property name="OnShow"></property>
      </object>
      <object class="Label" name="Label7" >
        <property name="Caption">Edit</property>
        <property name="Font">
                <property name="Align">taNone</property>
                <property name="Case"></property>
                <property name="Color"></property>
                <property name="Family">Verdana</property>
                <property name="LineHeight"></property>
                <property name="Size">8pt</property>
                <property name="Style"></property>
                <property name="Variant"></property>
                <property name="Weight"></property>
        </property>
        <property name="Height">13</property>
        <property name="Left">8</property>
        <property name="Name">Label7</property>
        <property name="ParentFont">0</property>
        <property name="Top">140</property>
        <property name="Width">24</property>
        <property name="OnAfterShow"></property>
        <property name="OnBeforeShow">Label7BeforeShow</property>
        <property name="OnShow"></property>
      </object>
      <object class="Label" name="Label8" >
        <property name="Caption">|</property>
        <property name="Font">
                <property name="Align">taNone</property>
                <property name="Case"></property>
                <property name="Color"></property>
                <property name="Family">Verdana</property>
                <property name="LineHeight"></property>
                <property name="Size">8pt</property>
                <property name="Style"></property>
                <property name="Variant"></property>
                <property name="Weight"></property>
        </property>
        <property name="Height">13</property>
        <property name="Left">34</property>
        <property name="Name">Label8</property>
        <property name="ParentFont">0</property>
        <property name="Top">140</property>
        <property name="Width">8</property>
        <property name="OnAfterShow"></property>
        <property name="OnBeforeShow"></property>
        <property name="OnShow"></property>
      </object>
      <object class="Label" name="Label9" >
        <property name="Caption">Delete</property>
        <property name="Font">
                <property name="Align">taNone</property>
                <property name="Case"></property>
                <property name="Color"></property>
                <property name="Family">Verdana</property>
                <property name="LineHeight"></property>
                <property name="Size">8pt</property>
                <property name="Style"></property>
                <property name="Variant"></property>
                <property name="Weight"></property>
        </property>
        <property name="Height">13</property>
        <property name="Left">45</property>
        <property name="Name">Label9</property>
        <property name="ParentFont">0</property>
        <property name="Top">140</property>
        <property name="Width">38</property>
        <property name="OnAfterShow"></property>
        <property name="OnBeforeShow">Label9BeforeShow</property>
        <property name="OnShow"></property>
      </object>
      <object class="Label" name="Label10" >
        <property name="Caption">|</property>
        <property name="Font">
                <property name="Align">taNone</property>
                <property name="Case"></property>
                <property name="Color"></property>
                <property name="Family">Verdana</property>
                <property name="LineHeight"></property>
                <property name="Size">8pt</property>
                <property name="Style"></property>
                <property name="Variant"></property>
                <property name="Weight"></property>
        </property>
        <property name="Height">13</property>
        <property name="Left">86</property>
        <property name="Name">Label10</property>
        <property name="ParentFont">0</property>
        <property name="Top">140</property>
        <property name="Width">8</property>
        <property name="OnAfterShow"></property>
        <property name="OnBeforeShow"></property>
        <property name="OnShow"></property>
      </object>
      <object class="Label" name="Label11" >
        <property name="Caption">Comments</property>
        <property name="Font">
                <property name="Align">taNone</property>
                <property name="Case"></property>
                <property name="Color"></property>
                <property name="Family">Verdana</property>
                <property name="LineHeight"></property>
                <property name="Size">8pt</property>
                <property name="Style"></property>
                <property name="Variant"></property>
                <property name="Weight"></property>
        </property>
        <property name="Height">13</property>
        <property name="Left">96</property>
        <property name="Name">Label11</property>
        <property name="ParentFont">0</property>
        <property name="Top">140</property>
        <property name="Width">64</property>
        <property name="OnAfterShow"></property>
        <property name="OnBeforeShow">Label11BeforeShow</property>
        <property name="OnShow"></property>
      </object>
    </object>
    <object class="Label" name="Label12" >
      <property name="Caption">Add New Blog Post</property>
      <property name="Font">
            <property name="Align">taNone</property>
            <property name="Case"></property>
            <property name="Color"></property>
            <property name="Family">Verdana</property>
            <property name="LineHeight"></property>
            <property name="Size">8pt</property>
            <property name="Style"></property>
            <property name="Variant"></property>
            <property name="Weight"></property>
      </property>
      <property name="Height">13</property>
      <property name="Left">7</property>
      <property name="Link">admin_edit.php</property>
      <property name="Name">Label12</property>
      <property name="ParentFont">0</property>
      <property name="Top">208</property>
      <property name="Width">112</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
    </object>
  </object>
  <object class="Query" name="Query1" >
        <property name="Left">576</property>
        <property name="Top">376</property>
    <property name="Active"></property>
    <property name="Database">BlogDB.Database1</property>
    <property name="LimitCount"></property>
    <property name="LimitStart"></property>
    <property name="Name">Query1</property>
    <property name="Params">a:0:{}</property>
    <property name="SQL">a:0:{}</property>
  </object>
</object>
?>
