<html>
<head>
<meta name="DC.Relation" content="http://www.open-xchange.org">
<meta name="DC.Creator" content="Netline Internet Service GmbH">
<!--
<rdf:RDF xmlns="http://web.resource.org/cc/"
    xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#">
<Work rdf:about="">
<license rdf:resource="http://creativecommons.org/licenses/by-nc-sa/2.5/" />
</Work>
<License rdf:about="http://creativecommons.org/licenses/by-nc-sa/2.5/">
   <requires rdf:resource="http://web.resource.org/cc/Attribution" />
   <permits rdf:resource="http://web.resource.org/cc/Reproduction" />
   <permits rdf:resource="http://web.resource.org/cc/Distribution" />
   <permits rdf:resource="http://web.resource.org/cc/DerivativeWorks" />
   <requires rdf:resource="http://web.resource.org/cc/ShareAlike" />
   <prohibits rdf:resource="http://web.resource.org/cc/CommercialUse" />
   <requires rdf:resource="http://web.resource.org/cc/Notice" />
</License>
</rdf:RDF>
-->
<link rel="shortcut icon" href="/cfintranet/webmail/images/favicon.ico" type="image/x-icon">
<meta http-equiv="expires" content="0">
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="DC.Title" content="WebMail - OPEN-XCHANGE 0.8.2">
<title>WebMail - Prefectura de Oruro</title>
<link rel=stylesheet type="text/css" href="css/main.css">
<script LANGUAGE="JavaScript" src="/cfintranet/webmail/javascript//richtext.js" type="text/javascript"></script>
<script LANGUAGE="JavaScript" src="/cfintranet/webmail/javascript//address.js" type="text/javascript"></script>

<script LANGUAGE="JavaScript" src="/cfintranet/webmail/javascript//wscript.js" type="text/javascript"></script>
<script language="javascript" src="/cfintranet/webmail/javascript//actb.js" type="text/javascript"></script>
<script language="javascript">
var nts = true;
function loadAddressBook() {
 openExtWindow(670,400,"ox_mail_address_book","addresses_main");
}
function loadSpellCheck(form) {
  if (document.newMail.spell_language.value == "") {
    alert("You must select a language first.");  
  } else {
    openExtWindow(640,480,"ox_mail_spell","nmail_spell_load");
  }
}
function closeForm() {
  if (confirm("Estas seguro que quieres cerrar esta ventana?\nSe perderan todos los datos!")) {
    nts = false;
    parent.window.close()
  }
}
function saveDraft() {
 try {
  if (nts == true) {
   if (confirm("Quieres guardar este mensaje como BORRADOR?\nEn otro caso se perderan!")) {
    document.newMail.button.name="savedraft";
    submitForm('true');
   }
  }
 } catch (e) { 
   alert("Your browser doesn't support 'unLoad' events!");
 }
}
var ac_enabled = true;
</script>
<script language="JavaScript">
var customarray=new Array();
try {
 customarray=new Array();
} catch (e) { }
</script>
</head>   
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<form action="/servlet/webmail?sessionID=be4148ff09efd87810a16e2ba8ec43f9" method="POST" enctype="multipart/form-data" name="newMail" onSubmit="return false;" autocomplete="off">
<INPUT TYPE="HIDDEN" NAME="NAS_ID" VALUE="be4148ff09efd87810a16e2ba8ec43f9">
<INPUT TYPE="HIDDEN" NAME="SITE" VALUE="nmail_main">
<INPUT TYPE="HIDDEN" NAME="mid" VALUE="">
<INPUT TYPE="HIDDEN" NAME="fid" VALUE="">
<INPUT TYPE="HIDDEN" NAME="npauth" VALUE="">

<INPUT TYPE="HIDDEN" NAME="sessionID" value="be4148ff09efd87810a16e2ba8ec43f9">
<INPUT TYPE="HIDDEN" NAME="button" value="true">
<input type="HIDDEN" name="sendformat" value="text">
<input type="HIDDEN" name="SPO_supportHtmlCompose" value="">
<input type="hidden" name="composeUID" value="1221829488731">
<input type="hidden" NAME="mCount" value="">
<input type="hidden" name="act" value="">
 <tr>
  <td align="center" class="td-border-style-4" style="border:0px; padding:5px;">
   <table border="0" width="100%">
    <tr>
     <td class="td-border-style-10">

      <table border="0" width="100%">
       <tr>
        <td width="99%" class="text-style-1" nowrap>Escribir correo</td>
        <td align="right" class="text-style-2" style="padding-right:10px;"><input type="button" name="sendmsg" value="Enviar" onClick="this.form.button.name='sendmsg';submitForm('true');" class="button-style-1"></td>
        <td align="right" class="text-style-2" style="padding-right:10px;"><input type="button" name="savedraft" value="Guardar como borrador" onClick="this.form.button.name='savedraft';submitForm('true')" class="button-style-1"></td>
        <td align="right" class="text-style-2" style="padding-right:10px;"><input type="button" name="cancle" value="Cancelar" onClick="closeForm();" class="button-style-1"></td>
        <td align="right" class="text-style-2"><img src="/cfintranet/webmail/images//hox.png"></td>
       </tr>

      </table>
     </td>
    </tr>
    <tr>
     <td class="text-error" style="margin:5px;"></td>
    </tr>
    <tr>
     <td class="td-border-style-1" style="padding:5px;"><span class="text-style-1">Mensaje</span></td>

    </tr>
    <tr>
     <td class="td-border-style-7">
      <table border="0" width="100%">
       <tr>
        <td valign="top">
	 <table border="0" width="100%">
	  <tr>
	   <td><input type="button" name="oto" value="Para" onClick="loadAddressBook();" class="button-style-1" style="width:50px;"></td>

	   <td align="left"><input type="text" name="to" id="to" value="cortiz@preforuro.gov.bo,jcflores@preforuro.gov.bo,jose@preforuro.gov.bo,julio@preforuro.gov.bo,lcerruto@preforuro.gov.bo,mpinaya@preforuro.gov.bo,oramirez@preforuro.gov.bo,prefecto@preforuro.gov.bo" class="input-text-style-1" style="width:350px;" onFocus="if (ac_enabled) actb(this,event,customarray);" tabindex="1"></td>	 
	  </tr>
	  <tr>
	   <td><input type="button" name="occ" value="Cc" onClick="loadAddressBook();" class="button-style-1" style="width:50px;"></td>
	   <td align="left"><input type="text" name="cc" id="cc" value="" class="input-text-style-1" style="width:350px;" onFocus="if (ac_enabled) actb(this,event,customarray);" tabindex="2"></td>
	  </tr>
	  <tr>
	   <td><input type="button" name="obcc" value="Bcc" onClick="loadAddressBook();" class="button-style-1" style="width:50px;"></td>
	   <td align="left"><input type="text" name="bcc" id="bcc" value="" class="input-text-style-1" style="width:350px;" onFocus="if (ac_enabled) actb(this,event,customarray);" tabindex="3"></td>

	  </tr>
	  <tr>
	   <td nowrap>Asunto:</td>
	   <td align="left"><input type="text" name="subject" value="" class="input-text-style-1" style="width:350px;" tabindex="4"></td>
	  </tr>
	 </table>
	</td>
	<td valign="top">

	 <table border="0" width="100%">
	  <tr>
	   <td align="right">Remitente:</td>
	   <td align="left">
	    <select name="sender_address">
	     <option value="jose@preforuro.gov.bo" selected>jose@preforuro.gov.bo</option>
	    </select>
	   </td>

	  </tr>
	  <tr>
	   <td align="right">Prioridad:</td>
	   <td> 
	    <select name="priority" size="1" class="sel_1">
	     <option value="5 (lowest)"> 5 Mas Bajo</b>)</option>
<option value="4 (low)"> 4 (Baja</b>)</option>

<option value="3 (normal)" selected> 3 (Normal</b>)</option>
<option value="2 (high)"> 2 (Alta</b>)</option>
<option value="1 (highest)"> 1 (Mas Alta</b>)</option>

	    </select>      
	   </td>
	  </tr>

	  <input type="hidden" name="blank" value="blank">
	  <tr>
	   <td>&nbsp;</td>
	   <td align="left"><input type="checkbox" name="vcard" value="true" >&nbsp;Añadir vCard</td>
	  </tr>
	  <tr>
	   <td>&nbsp;</td>
	   <td align="left"><input type="checkbox" name="disposition_notif" >&nbsp;Solicitar confirmación de lectura</td>

	  </tr>
	 </table>
	</td>
       </tr>
       <tr>
        <td colspan="2" style="padding:5px;">
        <textarea name="supermailtext" id="supermailtext" style="visibility:hidden;display:none">

Atte.

&nbsp;Jose&nbsp;Luis&nbsp;Aranibar&nbsp;Araviri
&nbsp;&nbsp;&nbsp;&nbsp;Profesional&nbsp;I
&nbsp;&nbsp;&nbsp;Unidad&nbsp;de&nbsp;SISTEMAS</textarea>
<script language="javascript">
<!--
initRTE("/cfintranet/webmail/images//", "/cfintranet/webmail/javascript//", "/cfintranet/webmail/css//main.css");
if (isRichText == true) {
  document.newMail.SPO_supportHtmlCompose.value = "true";
  isRichText = false;
} else {
  document.newMail.SPO_supportHtmlCompose.value = "";
}
var mtext = document.getElementById("supermailtext").value;
if (isRichText == false) {
 mtext = mtext.replace(/<br>/g,"\n");
} else {
 mtext = mtext.replace(/\n/g,"<br>");
}
writeRichText("mailtext", mtext, 670, 250, true, false, new Array("Cabecera","Direcciones","Formateado","Fuente","Tamaño","HTML y Texto Plano","Sólo Texto Plano","Sólo HTML","Negrita","Cursiva","Subrayar","Alinear Izquierda","Centrado","Alinear Derecha","Justificación Completa","Lista Ordenada","Lista No Ordenada","Sangría Derecha","Sangría Izquieerda","Color Texto","Color de Fonfo","Inserta Enlace","Añadir Enlace a Imagen","Revisión Ortográfica (externa)","Cortar","Copiar","Pegar","Deshacer","Rehacer","Ver Fuente"));
function getText() {  
  if (isRichText) {
    return getContent('mailtext');
  } else {
    return document.getElementById('mailtext').value;
  }
}
function setText(mtext) {
  if (isRichText) {
    updateRTEs();
    setContent('mailtext', mtext);
  } else { 
    mtext = mtext.replace(/<br>/g,"\n");
    document.getElementById('mailtext').value = mtext;
  }
}
function submitForm(submit) {
  if (isRichText) {  
    updateRTEs(); 
    if (submit == "true") setText(getText());
  } 
  if (submit == "true") {
    nts = false;
    document.newMail.submit();
  }
}
if (document.newMail.to.value.length == 0) document.newMail.to.focus(); // set focus on to
//-->
</script>

        </td>
       </tr>
      </table>
     </td>
    </tr>
    <tr>
     <td class="td-border-style-7" style="padding:0px;">
      <table border="0" width="100%" cellspacing="0" cellpadding="0">
       <tr>

        <td style="padding:5px"><select NAME="signature" onChange="submitForm('true');">
<OPTION VALUE="" >Elegir una firma: </option>
<OPTION VALUE="633" >firma casual </option>
<OPTION VALUE="670" >para uso interno </option>
<OPTION VALUE="908" >saludo de amigos </option>
</select>
</td> 
        <td width="100%">&nbsp;</td> 
        <td style="padding:5px; padding-right:15px" nowrap>
         
        </td>
       </tr>

      </table>
     </td>
    </tr>
    <tr>
     <td style="margin:5px;"></td>
    </tr>
    <tr>
     <td class="td-border-style-2">
      <table border="0" width="100%">

       <tr>
        <td width="99%" class="text-style-2">&nbsp;</td>
        <td align="right" class="text-style-2" style="padding-right:10px;"><input type="button" name="sendmsg" value="Enviar" onClick="this.form.button.name='sendmsg';submitForm('true');" class="button-style-1"></td>
        <td align="right" class="text-style-2" style="padding-right:10px;"><input type="button" name="savedraft" value="Guardar como borrador" onClick="this.form.button.name='savedraft';submitForm('true')" class="button-style-1"></td>
        <td align="right" class="text-style-2" style="padding-right:10px;"><input type="button" name="cancle" value="Cancelar" onClick="closeForm();" class="button-style-1"></td>
       </tr>
      </table>
     </td>
    </tr>

    <tr>
     <td style="margin:5px;"></td>
    </tr>
    <tr>
     <td class="td-border-style-1" style="padding:5px;"><span class="text-style-1">Adjuntar Archivos</span></td>
    </tr>
    <tr>
     <td class="td-border-style-7">

      <table border="0" width="100%">
       <tr>
        <td align="left"><input type="FILE" name="NAS_FILE" size="30">&nbsp;&nbsp;<input type="button" name="iattach" value="Insertar" onClick="this.form.button.name='iattach';submitForm('true');" class="button-style-1"></td>
       </tr>
       
      </table>
     </td>
    </tr>
    <tr>
	 <td style="margin:5px;"></td>

	</tr>
	
   </table>
  </td>
 </tr>
</form>
</table>
</body>
</html>
