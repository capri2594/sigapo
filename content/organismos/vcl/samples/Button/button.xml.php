<?php
<object class="ButtonSample" name="ButtonSample" baseclass="page">
  <property name="Background"></property>
  <property name="Caption">This is a button sample</property>
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
  <property name="Name">ButtonSample</property>
  <property name="Width">800</property>
  <property name="OnAfterShow"></property>
  <property name="OnAfterShowFooter"></property>
  <property name="OnBeforeShow"></property>
  <property name="OnBeforeShowHeader"></property>
  <property name="OnCreate"></property>
  <property name="OnShow"></property>
  <property name="OnShowHeader"></property>
  <property name="OnStartBody"></property>
  <object class="Button" name="Button1" >
    <property name="ButtonType">submit</property>
    <property name="Caption">Click Here!</property>
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
    <property name="Left">48</property>
    <property name="Name">Button1</property>
    <property name="TabOrder">1</property>
    <property name="Top">16</property>
    <property name="Width">183</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnClick">Button1Click</property>
    <property name="OnShow"></property>
  </object>
  <object class="Button" name="Button2" >
    <property name="ButtonType">submit</property>
    <property name="Caption">Click to change the color</property>
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
    <property name="Height">66</property>
    <property name="Left">48</property>
    <property name="Name">Button2</property>
    <property name="TabOrder">2</property>
    <property name="Top">48</property>
    <property name="Width">183</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnClick">Button2Click</property>
    <property name="OnShow"></property>
  </object>
  <object class="Button" name="Button3" >
    <property name="Caption">Button with hint</property>
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
    <property name="Hint">Hey I have a hint!</property>
    <property name="Left">288</property>
    <property name="Name">Button3</property>
    <property name="ShowHint">1</property>
    <property name="TabOrder">3</property>
    <property name="Top">16</property>
    <property name="Width">180</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
  <object class="Button" name="Button4" >
    <property name="Caption">Button4</property>
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
    <property name="Height">30</property>
    <property name="Hint">This is a image button</property>
    <property name="ImageSource">http://www.codegear.com/Portals/0/images/product_btn_free_trial.gif</property>
    <property name="Left">289</property>
    <property name="Name">Button4</property>
    <property name="ShowHint">1</property>
    <property name="TabOrder">4</property>
    <property name="Top">54</property>
    <property name="Width">90</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <property name="jsOnClick">Button4JSClick</property>
  </object>
  <object class="Button" name="Button5" >
    <property name="ButtonType">btNormal</property>
    <property name="Caption">This button does not submit the page</property>
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
    <property name="Height">43</property>
    <property name="Hint">See ButtonType = btNormal</property>
    <property name="Left">48</property>
    <property name="Name">Button5</property>
    <property name="Top">328</property>
    <property name="Width">368</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <property name="jsOnClick">Button5JSClick</property>
  </object>
  <object class="Button" name="Button6" >
    <property name="ButtonType">btReset</property>
    <property name="Caption">Reset</property>
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
    <property name="Left">48</property>
    <property name="Name">Button6</property>
    <property name="Top">296</property>
    <property name="Width">75</property>
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
        <property name="Size">10px</property>
        <property name="Style"></property>
        <property name="Variant"></property>
        <property name="Weight"></property>
    </property>
    <property name="Height">89</property>
    <property name="Left">48</property>
    <property name="Lines"><![CDATA[a:2:{i:0;s:49:&quot;Change this text and click on the &quot;Reset&quot; button.&quot;;i:1;s:93:&quot;The ButtonType btReset is used to reset all input elements on a form to their initial values.&quot;;}]]></property>
    <property name="Name">Memo1</property>
    <property name="Top">200</property>
    <property name="Width">368</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <property name="OnSubmit"></property>
  </object>
  <object class="Button" name="Button7" >
    <property name="Caption">Other Font set</property>
    <property name="Font">
        <property name="Align">taRight</property>
        <property name="Case"></property>
        <property name="Color">#004080</property>
        <property name="Family">Verdana</property>
        <property name="LineHeight"></property>
        <property name="Size">14px</property>
        <property name="Style"></property>
        <property name="Variant"></property>
        <property name="Weight">bold</property>
    </property>
    <property name="Height">25</property>
    <property name="Left">48</property>
    <property name="Name">Button7</property>
    <property name="ParentFont">0</property>
    <property name="Top">120</property>
    <property name="Width">184</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnClick">Button7Click</property>
    <property name="OnShow"></property>
  </object>
  <object class="Button" name="Button8" >
    <property name="Caption">Disabled</property>
    <property name="Enabled">0</property>
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
    <property name="Left">288</property>
    <property name="Name">Button8</property>
    <property name="Top">120</property>
    <property name="Width">169</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnClick">Button8Click</property>
    <property name="OnShow"></property>
  </object>
  <object class="Button" name="Button9" >
    <property name="Caption">Button9</property>
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
    <property name="Left">48</property>
    <property name="Name">Button9</property>
    <property name="Top">456</property>
    <property name="Width">75</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnClick">Button9Click</property>
    <property name="OnShow"></property>
  </object>
  <object class="Button" name="Button10" >
    <property name="Caption">Button10</property>
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
    <property name="Left">48</property>
    <property name="Name">Button10</property>
    <property name="Top">488</property>
    <property name="Width">75</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnClick">Button9Click</property>
    <property name="OnShow"></property>
  </object>
  <object class="Button" name="Button11" >
    <property name="Caption">Button11</property>
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
    <property name="Left">48</property>
    <property name="Name">Button11</property>
    <property name="Top">520</property>
    <property name="Width">75</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnClick">Button9Click</property>
    <property name="OnShow"></property>
  </object>
  <object class="Label" name="Label1" >
    <property name="Caption"><![CDATA[&lt;P&gt;Sender example: &lt;BR&gt;Those 3 buttons have all the same OnClick event handler assigned.&lt;/P&gt;]]></property>
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
    <property name="Height">40</property>
    <property name="Left">49</property>
    <property name="Name">Label1</property>
    <property name="Top">400</property>
    <property name="Width">215</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
  <object class="Label" name="Label2" >
    <property name="Caption">Clicked button: ?</property>
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
    <property name="Left">48</property>
    <property name="Name">Label2</property>
    <property name="Top">552</property>
    <property name="Width">240</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
</object>
?>
