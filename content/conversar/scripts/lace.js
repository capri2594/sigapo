/*
 * This program is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation; either version 2 of the License, or (at your
 * option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General
 * Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,.....
 * 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

function Lace() {
	this.init();
}

Lace.prototype.init = function() {
	this.config = LaceConfig;

	// Default interval if IntervalManager is not present
	this.defaultInterval = this.config.interval * 1000;
	this.interval   = 0;
	this.url        = 'lace.php';
	this.textObj    = $('text');
	this.laceDomRef = $('chatContainer');

	// Javascript has scope issues with using 'this' inside of an anonymous
	// function, so we use a copy of 'this' (thisObj)
	var thisObj = this;

	//Inititalize Interval Manager if present
	if (window.IntervalManager) {
		this.intManObj = new IntervalManager(thisObj);
	}

	this.textObj.setAttribute('autocomplete', 'off');
	this.textObj.focus();

	// Used for detecting updates
	this.chatHash = 'default hash';
	this.userHash = 'default hash';
	this.userList = [];

	// Lace state and timer properties
	this.isActive = false;
	this.interval = false;

	this.httpSendObj = this.httpObject();
	this.httpGetObj  = this.httpObject();

	// Start Lace if XMLHttpRequest is present.  Also, we need
	// to use encodeURIComponent.  Sorry IE5.0...
	if (this.httpSendObj && window.encodeURIComponent) {
		$('sayForm').onsubmit = function() {thisObj.send(); return false;};
		this.statusDisplay();
		this.start();
	}
};

Lace.prototype.insertMessage = function(message) {
	this.laceDomRef.innerHTML += message;
	this.scrollToBottom($(this.config.scroller), true);
}

Lace.prototype.scrollToBottom = function(el, force) {
	var bottom = el.scrollHeight - el.clientHeight;

	if (el.scrollTop == arguments.callee.scrollAtBottom || force === true) {
		el.scrollTop = bottom + 100;
		arguments.callee.scrollAtBottom = bottom;
	}
}

Lace.prototype.disableInputs = function() {
	this.textObj.disabled = true;
	$('say').disabled = true;
};

Lace.prototype.enableInputs = function() {
	this.textObj.disabled = false;
	$('say').disabled = false;
	this.resetInputs();
};

Lace.prototype.resetInputs = function() {
	// Clear field value - even in Safari
	this.textObj.blur();
	this.textObj.value='';
	this.textObj.focus();
};

Lace.prototype.floodCountdown = function(s) {
	if (s == 0) {
		deleteCookie(this.config.floodCookie, this.config.url);
		this.enableInputs();
		this.textObj.value = this.floodText;
		delete this.floodText;
		if (this.isActive)
			this.send();
		return;
	}

	this.disableInputs();
	this.textObj.value = LaceLocale.flooding + s + LaceLocale.floodingSeconds;
	var thisObj = this;
	setTimeout(function() {thisObj.floodCountdown(--s); }, 1000);
};

Lace.prototype.send = function() {
	var thisObj = this;
	var sayValue = this.textObj.value;

	var isUndefined = (0 === sayValue.indexOf('undefined'));
	var isFloodMessage = (0 === sayValue.indexOf(LaceLocale.flooding));

	if ( isUndefined || isFloodMessage ) {
		resetInputs();
		return;
	}

	var text = encodeURIComponent(this.textObj.value);

	// No flooding
	var floodCookie = getCookie(this.config.floodCookie);
	if (floodCookie !== null && floodCookie >= this.config.floodCount) {
		this.floodText = this.textObj.value;
		this.resetInputs();
		this.floodCountdown(10);
		return;
	}

	if (text !== '') {
		if (this.httpSendObj === null)
			this.start();

		if (this.httpSendObj.readyState === 4
			|| this.httpSendObj.readyState === 0) {
			this.resetInputs();

			var param = 'text=' + text;
			param += '&chatHash=' + encodeURIComponent(this.chatHash);
			param += '&userHash=' + encodeURIComponent(this.userHash);
			this.httpSendObj.open('POST', this.url, true);
			this.httpSendObj.setRequestHeader('Content-Type',
				'application/x-www-form-urlencoded; charset=UTF-8');
			this.httpSendObj.onreadystatechange = function() {
				thisObj.handleSend(); };
			this.httpSendObj.send(param);
		}else {
			setTimeout(function() { thisObj.send(); }, 20);
		}
	}
};

Lace.prototype.handleSend = function() {
	if (this.isActive && this.httpSendObj !== null
		&& this.httpSendObj.readyState === 4) {
		this.timerReset();
		var response = this.httpSendObj.responseText;
		this.handleResponse(response);
		this.scrollToBottom($(this.config.scroller), true);
	}
};

Lace.prototype.get = function(system) {
	var thisObj = this;

	if (this.httpGetObj !== null && (this.httpGetObj.readyState === 4
		|| this.httpGetObj.readyState === 0)) {
		var param = 'chatHash=' + encodeURIComponent(this.chatHash);
		param += '&userHash=' + encodeURIComponent(this.userHash);
		this.httpGetObj.open('POST', this.url, true);
		this.httpGetObj.setRequestHeader('Content-Type',
			'application/x-www-form-urlencoded; charset=UTF-8');
		this.httpGetObj.onreadystatechange = function() {
			thisObj.handleGet(system); };
		this.httpGetObj.send(param);
	} else {
		setTimeout(function() { thisObj.get(); }, 20);
	}
};

Lace.prototype.handleGet = function(system) {
	if (this.httpGetObj !== null && this.httpGetObj.readyState === 4) {
		var response = this.httpGetObj.responseText;
		this.handleResponse(response);
		this.scrollToBottom($(this.config.scroller));
		this.timerStep(system);
	}
};

Lace.prototype.handleResponse = function(response) {
	// Very useful for debugging
	//alert(response);
	if (response !== null && typeof(response) != "undefined"
		&& response !== '') {
		// Sometimes browsers threw errors without the parens,
		// adding them in seems to satisfy browsers.
		//var json = eval( response );
		var json = eval( '('+response+')' );

		// Testing the possibility of sending JSON 'commands.'
		// This is not fully implemented.
		//json();

		this.insertResults(json.response);
	}
};

Lace.prototype.insertResults = function(json) {
	if (json.chat.hash) {
		this.chatHash = json.chat.hash;
		this.laceDomRef.innerHTML = json.chat.data;
	}

	if (json.user.hash) {
		this.userHash = json.user.hash;
		this.userList = json.user.data;

		var ul = $('userList');

		while (ul.hasChildNodes()) ul.removeChild(ul.firstChild);

		for (var i=0; i<json.user.data.length; i++)
		{
			var name = json.user.data[i];
			if (name !== null && typeof(name) != "undefined") {
				var li = document.createElement('li');
		  	li.appendChild(document.createTextNode(name));
		  	ul.appendChild(li);
			}
		}
	}
};

Lace.prototype.start = function() {
	this.setActive(true);
	this.timerStart();
};

Lace.prototype.stop = function() {
	if (this.timerStop()) {
		this.setActive(false);
	}
};

Lace.prototype.toggle = function() {
	if (!this.isActive) {
		this.start();
	} else {
		this.stop();
	}
};


/* Lace's timer functions.
 * These functions should be better
 * abstracted into the IntervalManager.
 */
Lace.prototype.timerStart = function() {
	if (!this.isActive) {
		return false;
	}

	if (this.intManObj) {
		var interval = this.intManObj.reset();
		this.timerSet(interval);
		return true;
	} else {
		this.timerSet(this.defaultInterval);
	}

	return false;
};

Lace.prototype.timerStop = function() {
	if (!this.isActive) {
		return true;
	}

	if (this.intManObj) {
		clearInterval(this.timerID);
		this.interval = false;
	}

	return true;
};

Lace.prototype.timerSet = function(interval) {
	if (!this.isActive) {
		return false;
	}

	this.interval = interval;
	var thisObj = this;
	clearInterval(this.timerID);
	this.timerID = setInterval(function() { thisObj.get(true); }, interval);

	return true;
};

Lace.prototype.timerReset = function() {
	if (!this.isActive) {
		return false;
	}
	if (this.intManObj) {
		var interval = this.intManObj.reset();
		return this.timerSet(interval);
	}

	this.timerStart();
	return false;
};

Lace.prototype.timerStep = function(system) {
	if (!this.isActive) {
		if (!system) {
			return this.start();
		}
		return false;
	}

	if (this.intManObj) {
		var interval = this.intManObj.step();
		if (interval) {
			return this.timerSet(interval);
		}
		return this.stop();
	}
	return false;
};

Lace.prototype.httpObject = function() {
	var xmlhttp = false;
	/*@cc_on
	@if (@_jscript_version >= 5)
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false;
		}
	}
	@else
	xmlhttp = false;
	@end @*/
	if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
	    try {
	    		xmlhttp = new XMLHttpRequest();
	    } catch (e) {
	    		xmlhttp = false;
	    }
	}
	return xmlhttp;
};

Lace.prototype.setActive = function(active) {
	var text = $('statustext');
	var main = $(this.config.scroller);
	var userList = $('userList');

	if (active) {
		this.setStatusImage('pause.gif', LaceLocale.stop);

		this.isActive  = true;
		text.innerHTML     = LaceLocale.active;
		main.className     = 'active';
		userList.className = 'active';

		this.httpGetObj  = this.httpObject();
		this.httpSendObj = this.httpObject();

		this.get();
	} else if (!active) {
		this.setStatusImage('play.gif', LaceLocale.start);

		this.httpGetObj  = null;
		this.httpSendObj = null;

		this.isActive = false;
		text.innerHTML     = LaceLocale.stopped;
		main.className     = 'inactive';
		userList.className = 'inactive';
		clearInterval(this.timerID);
	}
};

Lace.prototype.setStatusImage = function(image, text) {
	var img  = $('statusimage');
	img.setAttribute('src', this.config.url + '/themes/' +
		this.config.theme + '/images/' + image);
	img.setAttribute('alt', text);
	img.setAttribute('title', 'Click to ' + text);
};

Lace.prototype.statusDisplay = function() {
	var outer = document.createElement('div');
	outer.setAttribute('id', 'status');

	var div = document.createElement('div');
	div.setAttribute('id', 'statuswrap');

	var txt = document.createElement('span');
	txt.setAttribute('id', 'statustext');

	var img = document.createElement('img');
	img.setAttribute('width', '13');
	img.setAttribute('height', '13');
	img.setAttribute('id', 'statusimage');

	var thisObj = this;
	img.onclick = function() {
		if (thisObj.isActive) {
			thisObj.stop();
		} else {
			thisObj.start();
		}
	};

	div.appendChild(txt);
	div.appendChild(img);
	outer.appendChild(div);

	var parent = $('sidebar');
	parent.appendChild(outer);
};