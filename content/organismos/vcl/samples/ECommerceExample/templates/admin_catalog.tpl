<p>
  The following item are currently in your catalog.
</p>
<p>
  {$Msg}
</p>
<p>
  {$Catalog}
</p>
<form action="admin.php" method="POST">
  <input type="hidden" name="page" value="add" />
  <table border="0">
    <tr>
      <td colspan="2" style="font-size: 12pt;">
        Add new item:
      </td>
    </tr>
    <tr>
      <td colspan="2">
        &nbsp;
      </td>
    </tr>
    <tr>
      <td>
        Product Name:
      </td>
      <td>
        {$AddNameInput}
      </td>
    </tr>
    <tr>
      <td>
        Product Cost:
      </td>
      <td>
        ${$AddCostInput}
      </td>
    </tr>
    <tr>
      <td>
        Product Image:
      </td>
      <td>
        {$AddImageInput}
      </td>
    </tr>
    <tr>
      <td colspan="2">
        {$AddSubmitButton}
      </td>
    </tr>
  </table>
</form>