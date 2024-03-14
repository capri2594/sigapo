<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<script type="text/javascript" src="js/scriptaculous/prototype.js"></script>
<script type="text/javascript" src="js/scriptaculous/scriptaculous.js"></script>
<script type="text/javascript" src="js/scriptaculous/unittest.js"></script>
<script type="text/javascript" src="js/scriptaculous/lightbox.js"></script>
<script type="text/javascript" src="js/scriptaculous/effects.js"></script>
<style type="text/css">
div.autocomplete {
  position:absolute;
  width:250px;
  background-color:white;
  border:1px solid #888;
  margin:0px;
  padding:0px;
}
div.autocomplete ul {
  list-style-type:none;
  margin:0px;
  padding:0px;
}
div.autocomplete ul li.selected { background-color: #ffb;}
div.autocomplete ul li {
  list-style-type:none;
  display:block;
  margin:0;
  padding:2px;
  height:32px;
  cursor:pointer;
}
</style>
  <style type="text/css">
    div.autocomplete {
      position:absolute;
      width:250px;
      background-color:white;
      border:1px solid #888;
      margin:0px;
      padding:0px;
    }
    ul.contacts  {
      list-style-type: none;
      margin:0px;
      padding:0px;
    }
    ul.contacts li.selected { background-color: #ffb; }
    li.contact {
      list-style-type: none;
      display:block;
      margin:0;
      padding:2px;
      height:32px;
    }
    li.contact div.image {
      float:left;
      width:32px;
      height:32px;
      margin-right:8px;
    }
    li.contact div.name {
      font-weight:bold;
      font-size:12px;
      line-height:1.2em;
    }
    li.contact div.email {
      font-size:10px;
      color:#888;
    }
    #list {
      margin:0;
      margin-top:10px;
      padding:0;
      list-style-type: none;
      width:250px;
    }
    #list li {
      margin:0;
      margin-bottom:4px;
      padding:5px;
      border:1px solid #888;
      cursor:move;
    }
  </style>
</head>

<body>
<input type="text" id="autocomplete" name="autocomplete_parameter"/>
<span id="indicator1" style="display: none">
  <img src="/images/spinner.gif" alt="Working..." />Working...
</span>
<div id="autocomplete_choices" class="autocomplete" style="display:none;border:1px solid black;background-color:white;position:relative;"></div>
<p>
    <script type="text/javascript">
new Ajax.Autocompleter("autocomplete", "autocomplete_choices", "ajax/nombres_dest1.php", {
  indicator: 'indicator1'
});

    </script>
</p>
<p>To: <br/>
  <input id="message_to" name="message[to]" size="30" type="text" />
</p>
<div class="auto_complete" id="message_to_auto_complete"></div><script type="text/javascript">
//<![CDATA[
var message_to_auto_completer = new Ajax.Autocompleter('message_to', 'message_to_auto_complete', 'ajax/nombres_dest.php', {afterUpdateElement : getSelectionId});

function getSelectionId(text, li) {
    alert (li.id);
}
//]]>
</script><br/>
<input type="text" id="autocomplete1" name="autocomplete_parameter1"/>
<span id="preload" style="display: none"> <img src="/images/spinner.gif" alt="Working..." />Working... </span> 
<div id="lista_opciones" class="autocomplete" style="display:none;border:1px solid black;background-color:white;position:relative;"></div>
<br />
joaerljkojaosefgasljdisek<br />
kasjdflhjliksafoihslkefasdfas<br />
ajdslfdñikjasoiefjlwsekjflisd
<p>
    <script type="text/javascript">
new Ajax.Autocompleter("autocomplete1", "lista_opciones", "ajax/funcionarios.php", {
method: "post",
paramName: "nombre",
indicator: "preload"});

    </script>
</p>
</body>
</html>
