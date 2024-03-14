<?php
<object class="Blogs" name="Blogs" baseclass="page">
  <property name="Background"></property>
  <property name="Caption">Blogs</property>
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
  <property name="Name">Blogs</property>
  <property name="Width">800</property>
  <property name="OnAfterShow"></property>
  <property name="OnAfterShowFooter"></property>
  <property name="OnBeforeShow"></property>
  <property name="OnBeforeShowHeader"></property>
  <property name="OnCreate">BlogCreate</property>
  <property name="OnShow"></property>
  <property name="OnShowHeader"></property>
  <property name="OnStartBody"></property>
  <property name="OnTemplate"></property>
  <object class="Panel" name="Panel2" >
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
    <property name="Height">31</property>
    <property name="Layout">
        <property name="Cols">5</property>
        <property name="Rows">5</property>
        <property name="Type">XY_LAYOUT</property>
    </property>
    <property name="Left">1</property>
    <property name="Name">Panel2</property>
    <property name="Top">568</property>
    <property name="Width">798</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
  <object class="DBRepeater" name="DBRepeater1" >
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
    <property name="Height">119</property>
    <property name="Layout">
        <property name="Cols">5</property>
        <property name="Rows">5</property>
        <property name="Type">XY_LAYOUT</property>
    </property>
    <property name="Left">8</property>
    <property name="Name">DBRepeater1</property>
    <property name="Top">57</property>
    <property name="Width">784</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <object class="Panel" name="Panel3" >
      <property name="BorderColor">#B9CDE0</property>
      <property name="BorderWidth">1</property>
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
      <property name="Height">95</property>
      <property name="Layout">
            <property name="Cols">5</property>
            <property name="Rows">5</property>
            <property name="Type">XY_LAYOUT</property>
      </property>
      <property name="Name">Panel3</property>
      <property name="Width">784</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
      <object class="Label" name="Label3" >
        <property name="Alignment">agLeft</property>
        <property name="Caption">Blog content</property>
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
        <property name="Height">40</property>
        <property name="Left">9</property>
        <property name="Name">Label3</property>
        <property name="ParentFont">0</property>
        <property name="Top">41</property>
        <property name="Width">767</property>
        <property name="OnAfterShow"></property>
        <property name="OnBeforeShow">Label3BeforeShow</property>
        <property name="OnShow"></property>
      </object>
      <object class="Panel" name="Panel4" >
        <property name="Color">#B9CDE0</property>
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
        <property name="Height">31</property>
        <property name="Layout">
                <property name="Cols">5</property>
                <property name="Rows">5</property>
                <property name="Type">XY_LAYOUT</property>
        </property>
        <property name="Left">1</property>
        <property name="Name">Panel4</property>
        <property name="ParentColor">0</property>
        <property name="Top">1</property>
        <property name="Width">782</property>
        <property name="OnAfterShow"></property>
        <property name="OnBeforeShow"></property>
        <property name="OnShow"></property>
        <object class="Label" name="Label5" >
          <property name="Alignment">agLeft</property>
          <property name="Caption">Blog Title</property>
          <property name="Color">#B9CDE0</property>
          <property name="DataField">Title</property>
          <property name="DataSource">BlogDB.BlogsDatasource1</property>
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
          <property name="Name">Label5</property>
          <property name="ParentFont">0</property>
          <property name="Top">6</property>
          <property name="Width">463</property>
          <property name="OnAfterShow"></property>
          <property name="OnBeforeShow">Label5BeforeShow</property>
          <property name="OnShow"></property>
        </object>
        <object class="Label" name="Label4" >
          <property name="Alignment">agRight</property>
          <property name="Caption">Posted</property>
          <property name="Color">#B9CDE0</property>
          <property name="DataField">Posted</property>
          <property name="DataSource">BlogDB.BlogsDatasource1</property>
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
          <property name="Left">503</property>
          <property name="Name">Label4</property>
          <property name="ParentFont">0</property>
          <property name="Top">6</property>
          <property name="Width">272</property>
          <property name="OnAfterShow"></property>
          <property name="OnBeforeShow"></property>
          <property name="OnShow"></property>
        </object>
      </object>
    </object>
  </object>
  <object class="Panel" name="Panel1" >
    <property name="BorderColor">#B9CDE0</property>
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
    <property name="Height">33</property>
    <property name="Layout">
        <property name="Cols">5</property>
        <property name="Rows">5</property>
        <property name="Type">XY_LAYOUT</property>
    </property>
    <property name="Left">8</property>
    <property name="Name">Panel1</property>
    <property name="Top">4</property>
    <property name="Width">783</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <object class="Panel" name="Panel5" >
      <property name="Color">#B9CDE0</property>
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
      <property name="Height">31</property>
      <property name="Layout">
            <property name="Cols">5</property>
            <property name="Rows">5</property>
            <property name="Type">XY_LAYOUT</property>
      </property>
      <property name="Left">1</property>
      <property name="Name">Panel5</property>
      <property name="ParentColor">0</property>
      <property name="Top">1</property>
      <property name="Width">781</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
      <object class="Label" name="Label2" >
        <property name="Alignment">agLeft</property>
        <property name="Caption">Example Blog</property>
        <property name="Color">#B9CDE0</property>
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
        <property name="Height">24</property>
        <property name="Left">8</property>
        <property name="Name">Label2</property>
        <property name="ParentFont">0</property>
        <property name="Top">4</property>
        <property name="Width">301</property>
        <property name="OnAfterShow"></property>
        <property name="OnBeforeShow"></property>
        <property name="OnShow"></property>
      </object>
      <object class="Label" name="Label1" >
        <property name="Alignment">agLeft</property>
        <property name="Caption">Admin</property>
        <property name="Color">#B9CDE0</property>
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
        <property name="Left">727</property>
        <property name="Link">admin.php</property>
        <property name="Name">Label1</property>
        <property name="ParentColor">0</property>
        <property name="Top">9</property>
        <property name="Width">40</property>
        <property name="OnAfterShow"></property>
        <property name="OnBeforeShow"></property>
        <property name="OnShow"></property>
      </object>
    </object>
  </object>
</object>
?>
