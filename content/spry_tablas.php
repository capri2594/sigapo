<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:spry="http://ns.adobe.com/spry">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<script src="../SpryAssets/xpath.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryData.js" type="text/javascript"></script>
<script type="text/javascript">
<!--
var ds1 = new Spry.Data.XMLDataSet("vistasTablas/recibidos.php", "datos/sorttable/rowset/row",{distinctOnLoad:true});
//-->
</script>
<link href="vistasTablas/grid-examples.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div spry:region="ds1">
  <table>
    <tr>
      <th>Hruta</th>
      <th>Fecha_ing</th>
      <th>Proc</th>
      <th>Cite_fecha</th>
      <th>Hojas</th>
      <th>Hojas/@type</th>
      <th>Ref</th>
      <th>Recibido</th>
    </tr>
    <tr spry:repeat="ds1">
      <td>{hruta}</td>
      <td>{fecha_ing}</td>
      <td>{proc}</td>
      <td>{cite_fecha}</td>
      <td>{hojas}</td>
      <td>{hojas/@type}</td>
      <td>{ref}</td>
      <td>{recibido}</td>
    </tr>
  </table>
</div>
</body>
</html>
