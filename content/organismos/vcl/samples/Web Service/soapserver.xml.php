<?php
<object class="SoapServer" name="SoapServer" baseclass="datamodule">
  <property name="Height">600</property>
  <property name="Name">SoapServer</property>
  <property name="Width">800</property>
  <property name="OnAfterShow"></property>
  <property name="OnBeforeShow"></property>
  <property name="OnShow"></property>
  <object class="Service" name="MyWebService" >
        <property name="Left">244</property>
        <property name="Top">95</property>
    <property name="Active">1</property>
    <property name="Name">MyWebService</property>
    <property name="NameSpace">http://localhost</property>
    <property name="SchemaTargetNamespace">http://localhost/xsd</property>
    <property name="ServiceName">VCLWebService</property>
    <property name="OnAddComplexTypes">MyWebServiceAddComplexTypes</property>
    <property name="OnRegisterServices">MyWebServiceRegisterServices</property>
  </object>
</object>
?>
