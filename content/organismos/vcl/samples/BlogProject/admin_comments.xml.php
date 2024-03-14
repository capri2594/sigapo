<?php
<object class="AdminComments" name="AdminComments" baseclass="page">
  <property name="Background"></property>
  <property name="Caption">Edit/Delete Comments</property>
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
  <property name="Name">AdminComments</property>
  <property name="Width">800</property>
  <property name="OnAfterShow"></property>
  <property name="OnAfterShowFooter"></property>
  <property name="OnBeforeShow"></property>
  <property name="OnBeforeShowHeader"></property>
  <property name="OnCreate">AdminCommentsCreate</property>
  <property name="OnShow"></property>
  <property name="OnShowHeader"></property>
  <property name="OnStartBody"></property>
  <property name="OnTemplate"></property>
  <object class="Label" name="Label2" >
    <property name="Caption">Blog Admin Panel - Edit/Delete Comments</property>
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
    <property name="Name">Label2</property>
    <property name="ParentFont">0</property>
    <property name="Top">8</property>
    <property name="Width">414</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
  <object class="Label" name="Label1" >
    <property name="Caption">Comments:</property>
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
    <property name="Name">Label1</property>
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
    <property name="Height">256</property>
    <property name="Layout">
        <property name="Cols">5</property>
        <property name="Rows">5</property>
        <property name="Type">XY_LAYOUT</property>
    </property>
    <property name="Left">9</property>
    <property name="Name">Panel1</property>
    <property name="Top">72</property>
    <property name="Width">775</property>
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
      <property name="Height">168</property>
      <property name="Layout">
            <property name="Cols">5</property>
            <property name="Rows">5</property>
            <property name="Type">XY_LAYOUT</property>
      </property>
      <property name="Left">7</property>
      <property name="Name">DBRepeater1</property>
      <property name="Top">8</property>
      <property name="Width">760</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
      <object class="Label" name="Label3" >
        <property name="Caption">By:</property>
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
        <property name="Left">9</property>
        <property name="Name">Label3</property>
        <property name="Top">6</property>
        <property name="Width">23</property>
        <property name="OnAfterShow"></property>
        <property name="OnBeforeShow"></property>
        <property name="OnShow"></property>
      </object>
      <object class="Label" name="Label4" >
        <property name="Caption">Label4</property>
        <property name="DataField">Author</property>
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
        <property name="Height">13</property>
        <property name="Left">32</property>
        <property name="Name">Label4</property>
        <property name="Top">6</property>
        <property name="Width">720</property>
        <property name="OnAfterShow"></property>
        <property name="OnBeforeShow"></property>
        <property name="OnShow"></property>
      </object>
      <object class="Label" name="Label5" >
        <property name="Caption">Label5</property>
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
        <property name="Height">86</property>
        <property name="Left">9</property>
        <property name="Name">Label5</property>
        <property name="Top">26</property>
        <property name="Width">743</property>
        <property name="OnAfterShow"></property>
        <property name="OnBeforeShow"></property>
        <property name="OnShow"></property>
      </object>
      <object class="Label" name="Label6" >
        <property name="Caption">Edit Comment</property>
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
        <property name="Left">8</property>
        <property name="Name">Label6</property>
        <property name="Top">128</property>
        <property name="Width">80</property>
        <property name="OnAfterShow"></property>
        <property name="OnBeforeShow">Label6BeforeShow</property>
        <property name="OnShow"></property>
      </object>
      <object class="Label" name="Label7" >
        <property name="Caption">|</property>
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
        <property name="Left">93</property>
        <property name="Name">Label7</property>
        <property name="Top">128</property>
        <property name="Width">5</property>
        <property name="OnAfterShow"></property>
        <property name="OnBeforeShow"></property>
        <property name="OnShow"></property>
      </object>
      <object class="Label" name="Label8" >
        <property name="Caption">Delete Comment</property>
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
        <property name="Left">104</property>
        <property name="Name">Label8</property>
        <property name="Top">128</property>
        <property name="Width">112</property>
        <property name="OnAfterShow"></property>
        <property name="OnBeforeShow">Label8BeforeShow</property>
        <property name="OnShow"></property>
      </object>
    </object>
    <object class="Label" name="Label10" >
      <property name="Caption">Add Comment</property>
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
      <property name="Left">15</property>
      <property name="Name">Label10</property>
      <property name="Top">232</property>
      <property name="Width">104</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow">Label10BeforeShow</property>
      <property name="OnShow"></property>
    </object>
  </object>
  <object class="Label" name="Label9" >
    <property name="Caption">Return to main admin page.</property>
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
    <property name="Link">admin.php</property>
    <property name="Name">Label9</property>
    <property name="Top">339</property>
    <property name="Width">190</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
</object>
?>
