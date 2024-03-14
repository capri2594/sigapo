<?php
<object class="TransactionsSample" name="TransactionsSample" baseclass="page">
  <property name="Background"></property>
  <property name="Caption">Transaction Sample</property>
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
  <property name="Name">TransactionsSample</property>
  <property name="Width">800</property>
  <property name="OnAfterShow"></property>
  <property name="OnAfterShowFooter"></property>
  <property name="OnBeforeShow"></property>
  <property name="OnBeforeShowHeader"></property>
  <property name="OnCreate"></property>
  <property name="OnShow"></property>
  <property name="OnShowHeader"></property>
  <property name="OnStartBody"></property>
  <property name="OnTemplate"></property>
  <object class="DBGrid" name="ddEMPLOYEE1" >
    <property name="Datasource">dsEMPLOYEE1</property>
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
    <property name="Height">200</property>
    <property name="Left">42</property>
    <property name="Name">ddEMPLOYEE1</property>
    <property name="Top">36</property>
    <property name="Width">400</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <property name="jsOnRowChanged"></property>
    <property name="jsOnRowSaved"></property>
  </object>
  <object class="Button" name="btnSuccess" >
    <property name="Caption">Successful Transaction</property>
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
    <property name="Left">568</property>
    <property name="Name">btnSuccess</property>
    <property name="Top">40</property>
    <property name="Width">144</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnClick">btnSuccessClick</property>
    <property name="OnShow"></property>
  </object>
  <object class="Button" name="btnCancel" >
    <property name="Caption">Cancel Transaction</property>
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
    <property name="Left">568</property>
    <property name="Name">btnCancel</property>
    <property name="Top">80</property>
    <property name="Width">144</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnClick">btnCancelClick</property>
    <property name="OnShow"></property>
  </object>
  <object class="Table" name="tbEMPLOYEE1" >
        <property name="Left">498</property>
        <property name="Top">164</property>
    <property name="Active">1</property>
    <property name="Database">dbEMPLOYEE1</property>
    <property name="LimitCount">-1</property>
    <property name="LimitStart">-1</property>
    <property name="MasterFields">a:0:{}</property>
    <property name="MasterSource"></property>
    <property name="Name">tbEMPLOYEE1</property>
    <property name="TableName">EMPLOYEE</property>
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
  <object class="Database" name="dbEMPLOYEE1" >
        <property name="Left">490</property>
        <property name="Top">100</property>
    <property name="Connected">1</property>
    <property name="DatabaseName">localhost:C:/Program Files/Common Files/Borland Shared/Data/EMPLOYEE.GDB</property>
    <property name="Dictionary"></property>
    <property name="DriverName">borland_ibase</property>
    <property name="Host"></property>
    <property name="Name">dbEMPLOYEE1</property>
    <property name="UserName">SYSDBA</property>
    <property name="UserPassword">masterkey</property>
    <property name="OnAfterConnect"></property>
    <property name="OnAfterDisconnect"></property>
    <property name="OnBeforeConnect"></property>
    <property name="OnBeforeDisconnect"></property>
  </object>
  <object class="Datasource" name="dsEMPLOYEE1" >
        <property name="Left">482</property>
        <property name="Top">44</property>
    <property name="Dataset">tbEMPLOYEE1</property>
    <property name="Name">dsEMPLOYEE1</property>
  </object>
</object>
?>
