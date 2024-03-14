/* This notice must be untouched at all times.

ds_jsgraphics.js    v. 1.00

Copyright (c) 2007 DragonSoft. All rights reserved.
Created March 13, 2007 by Serguei Dosyukov (Web: http://www.dragonsoftru.com )
Last modified: March 14, 2007

Simple JS SliderBar.

LICENSE: LGPL

This library is free software; you can redistribute it and/or
modify it under the terms of the GNU Lesser General Public
License (LGPL) as published by the Free Software Foundation; either
version 2.1 of the License, or (at your option) any later version.

This library is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
Lesser General Public License for more details.

You should have received a copy of the GNU Lesser General Public
License along with this library; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA,
or see http://www.gnu.org/copyleft/lesser.html
*/

sldPosition=0                       // Store slider's position
sldLeft=0                           // Slider's head left
sldTop=0                            // Slider's head top  
sldDrag=false                       // Drag action flag
sldMouseX=0                         // Mouse cursor position relatively to the slider's head
sldMouseY=0
sldMinLeft=0                        // Slider's container left and top boundaries
sldMaxLeft=0
sldNewPos=0                         // New position of the slider while moving
backupMouseMove = null              // Store event handler if present
backupMouseUp = null
sldNameHead = ""
sldNamePosition = ""
sldOnChange = null;
sldMaxPosition = 100;
                 
function dsSliderMouseDown(e, objName, maxPosition, onChange)
{
	sldDrag=true
	if (!e) {e = window.event}

	backupMouseMove = document.onmousemove
	backupMouseUp = document.onmouseup

	sldNameHead = objName + "_Head"
	sldNamePosition = objName + "_Position"

	sldMaxPosition = maxPosition

	document.onmousemove = dsSliderMouseMove
	document.onmouseup= dsSliderMouseUp

	div1=document.getElementById(sldNameHead)
	div2=document.getElementById(objName + "_Container")
	
	sldLeft=div1.offsetLeft
	sldTop=div1.offsetTop

	sldMouseX=e.clientX-sldLeft
	sldMouseY=e.clientY-sldTop

	sldMinLeft=0
	sldMaxLeft=div2.offsetWidth-div1.offsetWidth

	sldOnChange = onChange
}

function dsSliderMouseUp(e)
{
	// Drag action stops
	sldDrag=false

	document.onmousemove = backupMouseMove
	document.onmouseup= backupMouseUp

	sldOnChange = null
	backupMouseMove = null
	backupMouseUp = null
}

function dsSliderMouseMove(e)
{
	if (sldDrag)
	{
    if (!e) {e = window.event}

		doc=document.getElementById(sldNameHead)
		sldNewPos = e.clientX - sldMouseX

		if (sldNewPos <= sldMinLeft) sldNewPos = 0
		if (sldNewPos >= sldMaxLeft) sldNewPos = sldMaxLeft
		
    doc.style.left = sldNewPos + "px"
    doc.style.top = sldTop + "px"
		
		sldPosition = Math.round((sldNewPos * sldMaxPosition) / sldMaxLeft)

		document.getElementById(sldNamePosition).value = sldPosition

		if (backupMouseMove !== null) backupMouseMove(e)
		if (sldOnChange !== null) sldOnChange(e)

		// Stop event propagation
		return false
	}
}

