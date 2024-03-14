<p>
  Viewing order #{$ID}
</p>
<p>
  <p>Bill and ship to:</p>
  <table border="0">
    <tr>
      <td width="50">
        &nbsp;
      </td>
      <td>
        {$Name}<br />
        {$Address}<br />
        {$City}, {$State}, {$Country}<br />
        {$Postcode}<br />
        {$Phone}
      </td>
    </tr>
  </table>
</p>
<table border="0" width="600" cellpadding="0" cellspacing="5">
    <tr>
      <td width="400">Name</td>
      <td width="100" align="center">Quantity</td>
      <td width="100" align="center">Price</td>
    </tr>
    <tr>
      <td colspan="3" bgcolor="black" height="1"><img src="vcl/images/pixel_trans.gif" width="1" height="1" /></td>
    </tr>
    {$CartContents}
    <tr>
      <td colspan="3" bgcolor="black" height="1"><img src="vcl/images/pixel_trans.gif" width="1" height="1" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="right">Subtotal:</td>
      <td align="center">{$Subtotal}</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="right">Total:</td>
      <td align="center">{$Total}</td>
    </tr>
  </table>