<?php
<object class="Checkout" name="Checkout" baseclass="page">
  <property name="Background"></property>
  <property name="Caption">Noname1</property>
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
  <property name="Name">Checkout</property>
  <property name="ShowFooter">0</property>
  <property name="ShowHeader">0</property>
  <property name="TemplateEngine">SmartyTemplate</property>
  <property name="Width">800</property>
  <property name="OnAfterShow"></property>
  <property name="OnAfterShowFooter"></property>
  <property name="OnBeforeShow">CheckoutBeforeShow</property>
  <property name="OnBeforeShowHeader"></property>
  <property name="OnCreate">CheckoutCreate</property>
  <property name="OnShow"></property>
  <property name="OnShowHeader"></property>
  <property name="OnStartBody"></property>
  <property name="OnTemplate"></property>
  <object class="RawOutput" name="Msg" >
    <property name="Height">25</property>
    <property name="Left">7</property>
    <property name="Name">Msg</property>
    <property name="Top">10</property>
    <property name="Width">75</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
  <object class="RawOutput" name="CartContents" >
    <property name="Height">25</property>
    <property name="Left">7</property>
    <property name="Name">CartContents</property>
    <property name="Top">49</property>
    <property name="Width">75</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
  <object class="RawOutput" name="Subtotal" >
    <property name="Height">25</property>
    <property name="Left">9</property>
    <property name="Name">Subtotal</property>
    <property name="Top">90</property>
    <property name="Width">75</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
  <object class="RawOutput" name="Total" >
    <property name="Height">25</property>
    <property name="Left">5</property>
    <property name="Name">Total</property>
    <property name="Top">129</property>
    <property name="Width">75</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
  <object class="RawOutput" name="Name" >
    <property name="Height">25</property>
    <property name="Left">4</property>
    <property name="Name">Name</property>
    <property name="Top">163</property>
    <property name="Width">75</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
  <object class="RawOutput" name="Address" >
    <property name="Height">25</property>
    <property name="Left">6</property>
    <property name="Name">Address</property>
    <property name="Top">200</property>
    <property name="Width">75</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
  <object class="RawOutput" name="City" >
    <property name="Height">25</property>
    <property name="Left">7</property>
    <property name="Name">City</property>
    <property name="Top">237</property>
    <property name="Width">75</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
  <object class="RawOutput" name="State" >
    <property name="Height">25</property>
    <property name="Left">5</property>
    <property name="Name">State</property>
    <property name="Top">269</property>
    <property name="Width">75</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
  <object class="RawOutput" name="Country" >
    <property name="Height">25</property>
    <property name="Left">7</property>
    <property name="Name">Country</property>
    <property name="Top">306</property>
    <property name="Width">75</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
  <object class="RawOutput" name="Postcode" >
    <property name="Height">25</property>
    <property name="Left">6</property>
    <property name="Name">Postcode</property>
    <property name="Top">341</property>
    <property name="Width">75</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
  <object class="RawOutput" name="Phone" >
    <property name="Height">25</property>
    <property name="Left">8</property>
    <property name="Name">Phone</property>
    <property name="Top">375</property>
    <property name="Width">75</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
  <object class="Button" name="SubmitButton" >
    <property name="Caption">Submit</property>
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
    <property name="Left">7</property>
    <property name="Name">SubmitButton</property>
    <property name="ParentFont">0</property>
    <property name="Top">417</property>
    <property name="Width">98</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
</object>
?>
