<p>The following items are in your cart:</p>
<p>
  {$Message}
</p>
<p>
  <form action="index.php" method="POST">
    <input type="hidden" name="page" value="update" />
    <table border="0" width="100%" cellpadding="0" cellspacing="5">
      <tr>
        <td>Name</td>
        <td width="100">Quantity</td>
        <td width="100">Price</td>
        <td width="100">&nbsp;</td>
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
        <td>{$Subtotal}</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td align="right">Total:</td>
        <td>{$Total}</td>
        <td>&nbsp;</td>
      </tr>
    </table>
    <p>
      <input type="submit" value="Update" />
    </p>
  </form>
</p>