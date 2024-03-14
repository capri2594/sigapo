<?php
<object class="Unit3" name="Unit3" baseclass="page">
  <property name="Background"></property>
  <property name="Caption">Parent properties</property>
  <property name="DocType">dtXHTML_1_0_Transitional</property>
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
  <property name="Height">480</property>
  <property name="IsMaster">0</property>
  <property name="Layout">
    <property name="Cols">5</property>
    <property name="Rows">5</property>
    <property name="Type">ABS_XY_LAYOUT</property>
  </property>
  <property name="Name">Unit3</property>
  <property name="Width">768</property>
  <property name="OnAfterShow"></property>
  <property name="OnAfterShowFooter"></property>
  <property name="OnBeforeShow"></property>
  <property name="OnBeforeShowHeader"></property>
  <property name="OnCreate"></property>
  <property name="OnShow"></property>
  <property name="OnShowHeader"></property>
  <property name="OnStartBody"></property>
  <object class="Button" name="btnChangePageColor" >
    <property name="Caption">ChangePageColor</property>
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
    <property name="Left">40</property>
    <property name="Name">btnChangePageColor</property>
    <property name="Top">48</property>
    <property name="Width">158</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnClick">btnChangePageColorClick</property>
    <property name="OnShow"></property>
  </object>
  <object class="Panel" name="Panel1" >
    <property name="BorderColor">#000000</property>
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
    <property name="Height">92</property>
    <property name="Layout">
        <property name="Cols">5</property>
        <property name="Rows">5</property>
        <property name="Type">ABS_XY_LAYOUT</property>
    </property>
    <property name="Left">40</property>
    <property name="Name">Panel1</property>
    <property name="Top">112</property>
    <property name="Width">266</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <object class="Label" name="Label1" >
      <property name="Caption">This panel gets its color, font and showhint properties from the parent.</property>
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
      <property name="Height">39</property>
      <property name="Hint">I have a hint...</property>
      <property name="Left">10</property>
      <property name="Name">Label1</property>
      <property name="Top">13</property>
      <property name="Width">224</property>
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
            <property name="Size">10px</property>
            <property name="Style"></property>
            <property name="Variant"></property>
            <property name="Weight"></property>
      </property>
      <property name="Height">21</property>
      <property name="Hint">This is my hint...</property>
      <property name="Left">9</property>
      <property name="Name">Edit2</property>
      <property name="Text">This edit has a hint if 'Show hints on page..' is checked</property>
      <property name="Top">56</property>
      <property name="Width">241</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
      <property name="OnSubmit"></property>
    </object>
  </object>
  <object class="Edit" name="edtPageColor" >
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
    <property name="Height">21</property>
    <property name="Left">40</property>
    <property name="Name">edtPageColor</property>
    <property name="Text">#F5CC00</property>
    <property name="Top">16</property>
    <property name="Width">157</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <property name="OnSubmit"></property>
  </object>
  <object class="ComboBox" name="cmbPageFont" >
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
    <property name="Height">18</property>
    <property name="Items"><![CDATA[a:4:{s:11:&quot;defaultfont&quot;;s:12:&quot;Default font&quot;;s:4:&quot;bold&quot;;s:4:&quot;Bold&quot;;s:4:&quot;size&quot;;s:10:&quot;Size: 14px&quot;;s:4:&quot;case&quot;;s:9:&quot;UpperCase&quot;;}]]></property>
    <property name="Left">248</property>
    <property name="Name">cmbPageFont</property>
    <property name="Top">16</property>
    <property name="Width">185</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <property name="OnSubmit"></property>
  </object>
  <object class="Button" name="btnChangePageFont" >
    <property name="Caption">ChangePageFont</property>
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
    <property name="Left">248</property>
    <property name="Name">btnChangePageFont</property>
    <property name="Top">48</property>
    <property name="Width">182</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnClick">btnChangePageFontClick</property>
    <property name="OnShow"></property>
  </object>
  <object class="CheckBox" name="ckbShowHint" >
    <property name="Caption">Show hints on page...</property>
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
    <property name="Height">21</property>
    <property name="Hint">Hints are shown only if checked...</property>
    <property name="Left">464</property>
    <property name="Name">ckbShowHint</property>
    <property name="Top">16</property>
    <property name="Width">176</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnClick">ckbShowHintClick</property>
    <property name="OnShow"></property>
    <property name="OnSubmit"></property>
  </object>
  <object class="Panel" name="Panel2" >
    <property name="BorderColor">#000000</property>
    <property name="BorderWidth">1</property>
    <property name="Caption">Panel2</property>
    <property name="Color">#FF8000</property>
    <property name="Dynamic"></property>
    <property name="Font">
        <property name="Align">taNone</property>
        <property name="Case"></property>
        <property name="Color"></property>
        <property name="Family">Courier</property>
        <property name="LineHeight"></property>
        <property name="Size">8px</property>
        <property name="Style"></property>
        <property name="Variant"></property>
        <property name="Weight"></property>
    </property>
    <property name="Height">179</property>
    <property name="Layout">
        <property name="Cols">5</property>
        <property name="Rows">5</property>
        <property name="Type">ABS_XY_LAYOUT</property>
    </property>
    <property name="Left">40</property>
    <property name="Name">Panel2</property>
    <property name="ParentColor">0</property>
    <property name="ParentFont">0</property>
    <property name="ParentShowHint">0</property>
    <property name="ShowHint">1</property>
    <property name="Top">232</property>
    <property name="Width">265</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <object class="Label" name="Label2" >
      <property name="Caption">This panel is independent from the page (it uses its own color, font, showhint).</property>
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
      <property name="Height">47</property>
      <property name="Left">12</property>
      <property name="Name">Label2</property>
      <property name="Top">12</property>
      <property name="Width">237</property>
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
      <property name="Height">78</property>
      <property name="Hint">This hint is always shown (controlled by the panel)</property>
      <property name="Left">16</property>
      <property name="Lines"><![CDATA[a:1:{i:0;s:86:&quot;The hint on this memo is always shown regardless if 'Show hints on page..' is checked.&quot;;}]]></property>
      <property name="Name">Memo1</property>
      <property name="Top">77</property>
      <property name="Width">233</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
      <property name="OnSubmit"></property>
    </object>
  </object>
  <object class="Panel" name="Panel3" >
    <property name="BorderColor">#000000</property>
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
    <property name="Height">245</property>
    <property name="Layout">
        <property name="Cols">5</property>
        <property name="Rows">5</property>
        <property name="Type">ABS_XY_LAYOUT</property>
    </property>
    <property name="Left">360</property>
    <property name="Name">Panel3</property>
    <property name="Top">112</property>
    <property name="Width">347</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
    <object class="Button" name="btnSetPanelColor" >
      <property name="Caption">SetPanelColor</property>
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
      <property name="Left">176</property>
      <property name="Name">btnSetPanelColor</property>
      <property name="Top">64</property>
      <property name="Width">122</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnClick">btnSetPanelColorClick</property>
      <property name="OnShow"></property>
    </object>
    <object class="Edit" name="edtPanelColor" >
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
      <property name="Height">21</property>
      <property name="Left">24</property>
      <property name="Name">edtPanelColor</property>
      <property name="Text">#3064DC</property>
      <property name="Top">64</property>
      <property name="Width">127</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
      <property name="OnSubmit"></property>
    </object>
    <object class="Label" name="Label3" >
      <property name="Caption">This panel overrides the page properties once they are set.</property>
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
      <property name="Height">38</property>
      <property name="Left">24</property>
      <property name="Name">Label3</property>
      <property name="Top">16</property>
      <property name="Width">307</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
    </object>
    <object class="CheckBox" name="ckbShowHintsOnPanel" >
      <property name="Caption">Show hints on panel</property>
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
      <property name="Height">21</property>
      <property name="Left">24</property>
      <property name="Name">ckbShowHintsOnPanel</property>
      <property name="Top">104</property>
      <property name="Width">300</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnClick">ckbShowHintsOnPanelClick</property>
      <property name="OnShow"></property>
      <property name="OnSubmit"></property>
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
      <property name="Height">53</property>
      <property name="Hint">My hint is only shown if the page hint is on or if the panel hint is overriden..</property>
      <property name="Left">24</property>
      <property name="Lines"><![CDATA[a:1:{i:0;s:23:&quot;This memo has a hint...&quot;;}]]></property>
      <property name="Name">Memo2</property>
      <property name="Top">136</property>
      <property name="Width">277</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnShow"></property>
      <property name="OnSubmit"></property>
    </object>
    <object class="Button" name="btnResetPanelProperties" >
      <property name="Caption">ResetPanelProperties</property>
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
      <property name="Left">28</property>
      <property name="Name">btnResetPanelProperties</property>
      <property name="Top">202</property>
      <property name="Width">183</property>
      <property name="OnAfterShow"></property>
      <property name="OnBeforeShow"></property>
      <property name="OnClick">btnResetPanelPropertiesClick</property>
      <property name="OnShow"></property>
    </object>
  </object>
</object>
?>
