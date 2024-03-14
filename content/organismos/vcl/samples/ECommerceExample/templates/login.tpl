<p>Enter your username and password below to login.</p>
<p>{$LoginMsg}</p>
<form action="{$Url}" method="POST">
  <input type="hidden" name="page" value="login" />
  <input type="hidden" name="orig" value="{$OrigPage}" />
  <table border="0" width="100%">
    <tr>
      <td>
        Username:
      </td>
    </tr>
    <tr>
      <td>
        {$Username}
      </td>
    </tr>
    <tr>
      <td>
        &nbsp;
      </td>
    </tr>
    <tr>
      <td>
        Password:
      </td>
    </tr>
    <tr>
      <td>
        {$Password}
      </td>
    </tr>
    <tr>
      <td>
        &nbsp;
      </td>
    </tr>
    <tr>
      <td>
        {$LoginBtn}
      </td>
    </tr>
  </table>
</form>