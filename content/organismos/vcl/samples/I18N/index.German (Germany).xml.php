<?php
<object class="MyFirstI18n" name="myFirstI18n" baseclass="page">
  <property name="Language">German (Germany)</property>
  <object class="Label" name="lblMainTitle" >
    <property name="Caption">Trete in meine Welt ein...</property>
    <property name="Font">
        <property name="Color">#FF0000</property>
    </property>
  </object>
  <object class="Label" name="lblTitle" >
    <property name="Caption"><![CDATA[Bitte f&uuml;lle das Formular aus:]]></property>
  </object>
  <object class="Label" name="lblFirstName" >
    <property name="Caption">Vornamen:</property>
  </object>
  <object class="Edit" name="edtFirstName" >
    <property name="Font">
        <property name="Color">#FF0000</property>
    </property>
  </object>
  <object class="Label" name="lblName" >
    <property name="Caption">Namen:</property>
  </object>
  <object class="Edit" name="edtName" >
    <property name="Font">
        <property name="Color">#FF0000</property>
    </property>
  </object>
  <object class="Button" name="btnEnter" >
    <property name="Caption">Eintreten</property>
    <property name="Width">92</property>
  </object>
  <object class="Label" name="lblSelLang" >
    <property name="Caption"><![CDATA[Sprache w&auml;hlen:]]></property>
    <property name="Font">
        <property name="Color">#FF0000</property>
    </property>
  </object>
  <object class="ComboBox" name="cmbBxSelLang" >
  </object>
  <object class="Button" name="btnSelLang" >
    <property name="Caption"><![CDATA[&Auml;ndern]]></property>
  </object>
  <object class="Image" name="Image1" >
    <property name="ImageSource">images/de.gif</property>
  </object>
  <object class="Label" name="lblRes" >
    <property name="Caption"><![CDATA[Du hast mir folgende Namen &uuml;bermittelt:]]></property>
    <property name="Font">
        <property name="Color">#FF0000</property>
    </property>
    <property name="Left">20</property>
    <property name="Top">331</property>
    <property name="Width">456</property>
  </object>
  <object class="Label" name="lblResFirstname" >
    <property name="Top">375</property>
    <property name="Width">75</property>
  </object>
  <object class="Label" name="lblResName" >
    <property name="Top">402</property>
    <property name="Width">75</property>
  </object>
</object>
?>
