<?php
<object class="AddComment" name="AddComment" baseclass="page">
  <property name="Background"></property>
  <property name="Caption">Add Comment</property>
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
  <property name="Name">AddComment</property>
  <property name="Width">900</property>
  <property name="OnAfterShow"></property>
  <property name="OnAfterShowFooter"></property>
  <property name="OnBeforeShow"></property>
  <property name="OnBeforeShowHeader"></property>
  <property name="OnCreate">AddCommentCreate</property>
  <property name="OnShow"></property>
  <property name="OnShowHeader"></property>
  <property name="OnStartBody"></property>
  <property name="OnTemplate"></property>
  <object class="Label" name="Label2" >
    <property name="Caption">Name:</property>
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
    <property name="Height">16</property>
    <property name="Left">8</property>
    <property name="Name">Label2</property>
    <property name="ParentFont">0</property>
    <property name="Top">48</property>
    <property name="Width">48</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
  <object class="Edit" name="Edit1" >
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
    <property name="Height">21</property>
    <property name="Left">9</property>
    <property name="Name">Edit1</property>
    <property name="ParentFont">0</property>
    <property name="Top">66</property>
    <property name="Width">415</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <property name="OnSubmit"></property>
  </object>
  <object class="Label" name="Label3" >
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
    <property name="Height">16</property>
    <property name="Left">8</property>
    <property name="Name">Label3</property>
    <property name="ParentFont">0</property>
    <property name="Top">104</property>
    <property name="Width">80</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
  <object class="Memo" name="Memo1" >
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
    <property name="Height">133</property>
    <property name="Left">9</property>
    <property name="Lines">a:0:{}</property>
    <property name="Name">Memo1</property>
    <property name="ParentFont">0</property>
    <property name="Top">123</property>
    <property name="Width">519</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <property name="OnSubmit"></property>
  </object>
  <object class="Button" name="Button1" >
    <property name="Caption">OK</property>
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
    <property name="Height">23</property>
    <property name="Left">9</property>
    <property name="Name">Button1</property>
    <property name="ParentFont">0</property>
    <property name="Top">272</property>
    <property name="Width">84</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnClick">Button1Click</property>
    <property name="OnShow"></property>
  </object>
  <object class="Button" name="Button2" >
    <property name="Caption">Cancel</property>
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
    <property name="Height">23</property>
    <property name="Left">99</property>
    <property name="Name">Button2</property>
    <property name="ParentFont">0</property>
    <property name="Top">272</property>
    <property name="Width">84</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnClick">Button2Click</property>
    <property name="OnShow"></property>
  </object>
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
        <property name="Type">ABS_XY_LAYOUT</property>
    </property>
    <property name="Left">8</property>
    <property name="Name">Panel11</property>
    <property name="Top">4</property>
    <property name="Width">782</property>
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
            <property name="Type">ABS_XY_LAYOUT</property>
      </property>
      <property name="Left">1</property>
      <property name="Name">Panel5</property>
      <property name="Top">1</property>
      <property name="Width">780</property>
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
    </object>
  </object>
  <object class="HiddenField" name="id" >
    <property name="Height">18</property>
    <property name="Left">512</property>
    <property name="Name">id</property>
    <property name="Top">408</property>
    <property name="Width">200</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <property name="OnSubmit"></property>
  </object>
</object>
?>
