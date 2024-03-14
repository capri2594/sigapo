<?php
<object class="AdminEditComment" name="AdminEditComment" baseclass="page">
  <property name="Background"></property>
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
  <property name="Height">600</property>
  <property name="Name">AdminEditComment</property>
  <property name="Width">800</property>
  <property name="OnAfterShow"></property>
  <property name="OnAfterShowFooter"></property>
  <property name="OnBeforeShow"></property>
  <property name="OnBeforeShowHeader"></property>
  <property name="OnCreate">AdminEditCommentCreate</property>
  <property name="OnShow"></property>
  <property name="OnShowHeader"></property>
  <property name="OnStartBody">AdminEditCommentStartBody</property>
  <object class="Label" name="Label1" >
    <property name="Caption">Blog Admin Panel - Edit Comment</property>
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
    <property name="Width">333</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
  <object class="Label" name="Label2" >
    <property name="Caption">By:</property>
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
    <property name="Height">17</property>
    <property name="Left">27</property>
    <property name="Name">Label2</property>
    <property name="ParentFont">0</property>
    <property name="Top">64</property>
    <property name="Width">37</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
  <object class="Edit" name="Edit2" >
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
    <property name="Left">27</property>
    <property name="Name">Edit2</property>
    <property name="ParentFont">0</property>
    <property name="Top">84</property>
    <property name="Width">675</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <property name="OnSubmit"></property>
  </object>
  <object class="Label" name="Label4" >
    <property name="Caption">Content:</property>
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
    <property name="Left">27</property>
    <property name="Name">Label4</property>
    <property name="ParentFont">0</property>
    <property name="Top">135</property>
    <property name="Width">75</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
  <object class="Memo" name="Memo2" >
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
    <property name="Height">243</property>
    <property name="Left">27</property>
    <property name="Name">Memo2</property>
    <property name="ParentFont">0</property>
    <property name="Text"></property>
    <property name="Top">157</property>
    <property name="Width">675</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
  <object class="Button" name="Button2" >
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
    <property name="Height">25</property>
    <property name="ImageSource"></property>
    <property name="Left">27</property>
    <property name="Name">Button2</property>
    <property name="ParentFont">0</property>
    <property name="Top">412</property>
    <property name="Width">85</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnClick">Button1Click</property>
    <property name="OnShow"></property>
  </object>
  <object class="Button" name="Button1" >
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
    <property name="Height">25</property>
    <property name="ImageSource"></property>
    <property name="Left">122</property>
    <property name="Name">Button1</property>
    <property name="ParentFont">0</property>
    <property name="Top">412</property>
    <property name="Width">85</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnClick">Button2Click</property>
    <property name="OnShow"></property>
  </object>
  <object class="HiddenField" name="id" >
    <property name="Height">18</property>
    <property name="Left">682</property>
    <property name="Name">id</property>
    <property name="Top">490</property>
    <property name="Width">118</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
  <object class="HiddenField" name="bid" >
    <property name="Height">18</property>
    <property name="Left">678</property>
    <property name="Name">bid</property>
    <property name="Top">519</property>
    <property name="Width">122</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
</object>
?>
