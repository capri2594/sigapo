<?php
<object class="Blog" name="Blog" baseclass="page">
  <property name="Background"></property>
  <property name="Caption">Viewing blog</property>
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
  <property name="Name">Blog</property>
  <property name="Width">800</property>
  <property name="OnAfterShow"></property>
  <property name="OnAfterShowFooter"></property>
  <property name="OnBeforeShow">BlogBeforeShow</property>
  <property name="OnBeforeShowHeader"></property>
  <property name="OnCreate"></property>
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
    <property name="Height">247</property>
    <property name="Layout">
        <property name="Cols">5</property>
        <property name="Rows">5</property>
        <property name="Type">XY_LAYOUT</property>
    </property>
    <property name="Left">1</property>
    <property name="Name">Panel2</property>
    <property name="Top">1</property>
    <property name="Width">798</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <object class="Panel" name="Panel11" >
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
      <property name="Name">Panel11</property>
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
        <object class="Label" name="Label99" >
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
          <property name="Name">Label99</property>
          <property name="ParentFont">0</property>
          <property name="Top">4</property>
          <property name="Width">301</property>
          <property name="OnAfterShow"></property>
          <property name="OnBeforeShow"></property>
          <property name="OnShow"></property>
        </object>
        <object class="Label" name="Label9" >
          <property name="Caption">Return to blogs home.</property>
          <property name="Color">#B9CDE0</property>
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
          <property name="Height">18</property>
          <property name="Left">622</property>
          <property name="Link">index.php</property>
          <property name="Name">Label9</property>
          <property name="ParentColor">0</property>
          <property name="ParentFont">0</property>
          <property name="Top">7</property>
          <property name="Width">152</property>
          <property name="OnAfterShow"></property>
          <property name="OnBeforeShow"></property>
          <property name="OnShow"></property>
        </object>
      </object>
    </object>
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
      <property name="Height">190</property>
      <property name="Layout">
            <property name="Cols">5</property>
            <property name="Rows">5</property>
            <property name="Type">XY_LAYOUT</property>
      </property>
      <property name="Left">8</property>
      <property name="Name">Panel3</property>
      <property name="Top">44</property>
      <property name="Width">783</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
      <object class="Panel" name="Panel4" >
        <property name="Caption">Panel4</property>
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
        <property name="Width">781</property>
        <property name="OnAfterShow"></property>
        <property name="OnBeforeShow"></property>
        <property name="OnShow"></property>
        <object class="Label" name="Label8" >
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
                    <property name="Size">11pt</property>
                    <property name="Style"></property>
                    <property name="Variant"></property>
                    <property name="Weight"></property>
          </property>
          <property name="Height">19</property>
          <property name="Left">8</property>
          <property name="Name">Label8</property>
          <property name="ParentFont">0</property>
          <property name="Top">5</property>
          <property name="Width">505</property>
          <property name="OnAfterShow"></property>
          <property name="OnBeforeShow"></property>
          <property name="OnShow"></property>
        </object>
      </object>
      <object class="Label" name="Label2" >
        <property name="Alignment">agLeft</property>
        <property name="Caption">Blog Content</property>
        <property name="DataField">Content</property>
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
        <property name="Height">126</property>
        <property name="Left">8</property>
        <property name="Name">Label2</property>
        <property name="ParentFont">0</property>
        <property name="Top">42</property>
        <property name="Width">766</property>
        <property name="OnAfterShow"></property>
        <property name="OnBeforeShow"></property>
        <property name="OnShow"></property>
      </object>
    </object>
  </object>
  <object class="Panel" name="Panel6" >
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
    <property name="Height">146</property>
    <property name="Layout">
        <property name="Cols">5</property>
        <property name="Rows">5</property>
        <property name="Type">XY_LAYOUT</property>
    </property>
    <property name="Left">8</property>
    <property name="Name">Panel6</property>
    <property name="Top">255</property>
    <property name="Width">783</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <object class="Panel" name="Panel7" >
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
      <property name="Height">25</property>
      <property name="Layout">
            <property name="Cols">5</property>
            <property name="Rows">5</property>
            <property name="Type">XY_LAYOUT</property>
      </property>
      <property name="Left">1</property>
      <property name="Name">Panel7</property>
      <property name="ParentColor">0</property>
      <property name="Top">1</property>
      <property name="Width">781</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
      <object class="Label" name="Label1" >
        <property name="Alignment">agLeft</property>
        <property name="Caption">Comments:</property>
        <property name="Color">#B9CDE0</property>
        <property name="Font">
                <property name="Align">taNone</property>
                <property name="Case"></property>
                <property name="Color"></property>
                <property name="Family">Verdana</property>
                <property name="LineHeight"></property>
                <property name="Size">9pt</property>
                <property name="Style"></property>
                <property name="Variant"></property>
                <property name="Weight"></property>
        </property>
        <property name="Height">13</property>
        <property name="Left">8</property>
        <property name="Name">Label1</property>
        <property name="ParentFont">0</property>
        <property name="Top">5</property>
        <property name="Width">75</property>
        <property name="OnAfterShow"></property>
        <property name="OnBeforeShow"></property>
        <property name="OnShow"></property>
      </object>
      <object class="Label" name="Label7" >
        <property name="Alignment">agRight</property>
        <property name="Caption">Add Comment</property>
        <property name="Color">#B9CDE0</property>
        <property name="Font">
                <property name="Align">taNone</property>
                <property name="Case"></property>
                <property name="Color"></property>
                <property name="Family">Verdana</property>
                <property name="LineHeight"></property>
                <property name="Size">9pt</property>
                <property name="Style"></property>
                <property name="Variant"></property>
                <property name="Weight"></property>
        </property>
        <property name="Height">13</property>
        <property name="Left">610</property>
        <property name="Name">Label7</property>
        <property name="ParentFont">0</property>
        <property name="Top">5</property>
        <property name="Width">160</property>
        <property name="OnAfterShow"></property>
        <property name="OnBeforeShow"></property>
        <property name="OnShow"></property>
      </object>
    </object>
    <object class="DBRepeater" name="DBRepeater2" >
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
      <property name="Height">108</property>
      <property name="Layout">
            <property name="Cols">5</property>
            <property name="Rows">5</property>
            <property name="Type">XY_LAYOUT</property>
      </property>
      <property name="Left">1</property>
      <property name="Name">DBRepeater2</property>
      <property name="Top">26</property>
      <property name="Width">781</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
      <object class="Panel" name="Panel1" >
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
        <property name="Height">90</property>
        <property name="Layout">
                <property name="Cols">5</property>
                <property name="Rows">5</property>
                <property name="Type">XY_LAYOUT</property>
        </property>
        <property name="Left">9</property>
        <property name="Name">Panel1</property>
        <property name="Top">4</property>
        <property name="Width">760</property>
        <property name="OnAfterShow"></property>
        <property name="OnBeforeShow"></property>
        <property name="OnShow"></property>
        <object class="Label" name="Label5" >
          <property name="Alignment">agLeft</property>
          <property name="Caption">By</property>
          <property name="DataField">Author</property>
          <property name="DataSource">BlogDB.CommentsDatasource1</property>
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
          <property name="Left">33</property>
          <property name="Name">Label5</property>
          <property name="ParentFont">0</property>
          <property name="Top">7</property>
          <property name="Width">211</property>
          <property name="OnAfterShow"></property>
          <property name="OnBeforeShow"></property>
          <property name="OnShow"></property>
        </object>
        <object class="Label" name="Label4" >
          <property name="Alignment">agLeft</property>
          <property name="Caption">Content</property>
          <property name="DataField">Content</property>
          <property name="DataSource">BlogDB.CommentsDatasource1</property>
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
          <property name="Height">48</property>
          <property name="Left">8</property>
          <property name="Name">Label4</property>
          <property name="ParentFont">0</property>
          <property name="Top">32</property>
          <property name="Width">737</property>
          <property name="OnAfterShow"></property>
          <property name="OnBeforeShow"></property>
          <property name="OnShow"></property>
        </object>
        <object class="Label" name="Label6" >
          <property name="Alignment">agRight</property>
          <property name="Caption">Posted</property>
          <property name="DataField">Posted</property>
          <property name="DataSource">BlogDB.CommentsDatasource1</property>
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
          <property name="Left">579</property>
          <property name="Name">Label6</property>
          <property name="ParentFont">0</property>
          <property name="Top">8</property>
          <property name="Width">168</property>
          <property name="OnAfterShow"></property>
          <property name="OnBeforeShow"></property>
          <property name="OnShow"></property>
        </object>
        <object class="Label" name="Label3" >
          <property name="Alignment">agLeft</property>
          <property name="Caption">By:</property>
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
          <property name="Name">Label3</property>
          <property name="ParentFont">0</property>
          <property name="Top">7</property>
          <property name="Width">21</property>
          <property name="OnAfterShow"></property>
          <property name="OnBeforeShow"></property>
          <property name="OnShow"></property>
        </object>
      </object>
      <object class="Image" name="Image1" >
        <property name="Autosize">0</property>
        <property name="Border">0</property>
        <property name="Height">1</property>
        <property name="ImageSource">bar.gif</property>
        <property name="Left">71</property>
        <property name="Link"></property>
        <property name="LinkTarget"></property>
        <property name="Name">Image1</property>
        <property name="Top">100</property>
        <property name="Width">636</property>
        <property name="OnAfterShow"></property>
        <property name="OnBeforeShow"></property>
        <property name="OnCustomize"></property>
        <property name="OnShow"></property>
      </object>
    </object>
  </object>
</object>
?>
