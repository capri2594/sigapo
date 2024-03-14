var introwidth ="100%" ; // Width of template
var introheight = "100%"; // Height of template


embedstring = '<EMBED src=intro.swf quality=high scale="exactfit"  bgcolor=#000000 WIDTH=' + introwidth + ' HEIGHT='+introheight +' NAME="TRENDYFLASH INTRO" ALIGN="" TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer"></EMBED>'

document.write('<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"  codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" id="TRENDYFLASH INTRO" width=' + introwidth+ ' height=' + introheight + '> \n');
document.write('<PARAM NAME=movie VALUE=intro.swf> \n');
document.write('<param name="SCALE" value="exactfit">\n');
document.write('<PARAM name=quality value=high> \n');
document.write('<PARAM name=menu value="false"> \n');
document.write(embedstring + '\n');
document.write('</OBJECT> \n');
document.write('</DIV> \n');
		







