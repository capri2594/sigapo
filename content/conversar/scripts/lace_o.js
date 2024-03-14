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
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

function Lace() {
	this.init();
}

Lace.prototype.init = function() {
	this.config = LaceConfig;

	this.interval   = 0;
	this.defaultInterval = this.config.interval * 1000; // Default interval if IntervalManager is not present
	this.url        = 'lace.php';
	this.nameObj    = $('name');
	this.textObj    = $('text');
	this.laceDomRef = $('chatContainer');

	// Javascript has scope issues with using 'this'
	// inside of an anonymous function, so we use a
	// copy of 'this' (thisObj)
	var thisObj = this;

	//Inititalize Interval Manager if present
	if (window.IntervalManager) {
		this.intManObj = new IntervalManager();
	}

	this.textObj.setAttribute('autocomplete', 'off');
	this.textObj.focus();

	// Used for detecting updates
	this.chatHash = 'default hash';
	this.userHash = 'default hash';
	this.userList = [];

	// Setup the internal name change monitor
	this.name = encodeURIComponent(this.nameObj.value);
	this.nameObj.onblur = function() { thisObj.validateName(); };


	// Lace state and timer properties
	this.isActive = false;
	this.interval = false;

	this.httpSendObj = this.httpObject();
	this.httpGetObj  = this.httpObject();

	this.currentCmd = false;
	this.commands = [];
	this.commands['nick'] = this.cmdNick;

	// Start Lace if XMLHttpRequest is present.  Also, we need
	// to use encodeURIComponent.  Sorry IE5.0...
	if (this.httpSendObj && window.encodeURIComponent) {
		$('sayForm').onsubmit = function() {thisObj.send(); return false;};
		this.statusDisplay();
		this.start();
	}
};

Lace.prototype.scrollToBottom = function(el, force) {
	var bottom = el.scrollHeight - el.clientHeight;

	if (el.scrollTop == arguments.callee.scrollAtBottom || force === true) {
		el.scrollTop = bottom + 100;
		arguments.callee.scrollAtBottom = bottom;
	}
}

Lace.prototype.validateName = function() {
 	name = this.nameObj.value;
	// ARGH!  Could not get Regex working in Safari...
 	if ( name.indexOf('!') !== -1
 		|| name.indexOf('#') !== -1
 		|| name.indexOf('%') !== -1
 		|| name.indexOf('&') !== -1
 		|| name.indexOf('*') !== -1
 		|| name.indexOf('+') !== -1
 		|| name.indexOf('|') !== -1
 		|| name.indexOf('<') !== -1
 		|| name.indexOf('>') !== -1
 	) {
		var error = 'Sorry, your name contains one or more of the following'+
			' illegal characters:\n\n! # % & * + | < > \n\n' +
			'Please remove them and try again.';
		alert(error);
		this.nameObj.value = decodeURIComponent(this.name);
		return false;
  }

	name = encodeURIComponent(name);
	if (name == this.name)
		return true;

	var searchName = this.nameObj.value.trim();
	var nameExists = this.userList.inArrayI(searchName);
	if (nameExists) {
 		alert('Sorry, another user has that name.\n\nPlease choose a different name.');
 		this.nameObj.value = decodeURIComponent(this.name);
 		return false;
 	}
};

Lace.prototype.disableInputs = function() {
	this.textObj.disabled = true;
	this.nameObj.disabled = true;
	$('say').disabled = true;
};

Lace.prototype.enableInputs = function() {
	this.textObj.disabled = false;
	this.nameObj.disabled = false;
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
	this.textObj.value = 'Flood Protection: Your message will be sent in ' + s + ' seconds.';
	var thisObj = this;
	setTimeout(function() {thisObj.floodCountdown(--s); }, 1000);
};

Lace.prototype.cmdNick = function(text) {
	var newName = text.substring(0,10);
	this.nameObj.value = newName;
	return this.validateName();
}

Lace.prototype.parseCommand = function() {
	var tokens = this.textObj.value.split(' ');
	var cmd = tokens[0].substring(1);
	if (tokens[0].indexOf('/') === 0 &&	this.commands[cmd]) {
		tokens.shift();
		return [this.commands[cmd], tokens.join(' ')];
	}
	return false;
}

Lace.prototype.send = function() {
	var thisObj = this;

	var cmd = this.parseCommand();
	if (cmd) {
		cmd[0].call(this, cmd[1]);
		this.resetInputs();
		return;
	}

	if (this.textObj.value.indexOf("undefined") === 0 ||
	  this.textObj.value.indexOf("Flood Protection: Your message will be sent in") === 0) {
			resetInputs();
			return;
	}

	var name = encodeURIComponent(this.nameObj.value);
	var text = encodeURIComponent(this.textObj.value);

	// No flooding
	var floodCookie = getCookie(this.config.floodCookie);
	if (floodCookie !== null && floodCookie >= this.config.floodCount) {
		this.floodText = this.textObj.value;
		this.resetInputs();
		this.floodCountdown(10);
		return;
	}

	if (name !== '' && text !== '') {
		if (this.httpSendObj === null)
			this.start();

		if (this.httpSendObj.readyState === 4 || this.httpSendObj.readyState === 0) {
			this.name = name;
			this.resetInputs();

			var param = 'name=' + name + '&text=' + text;
			param += '&chatHash=' + encodeURIComponent(this.chatHash);
			param += '&userHash=' + encodeURIComponent(this.userHash);
			this.httpSendObj.open('POST', this.url, true);
			this.httpSendObj.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=UTF-8');
			this.httpSendObj.onreadystatechange = function() { thisObj.handleSend(); };
			this.httpSendObj.send(param);
		}else {
			setTimeout(function() { thisObj.send(); }, 250);
		}
	}
};

Lace.prototype.handleSend = function() {
	if (this.isActive && this.httpSendObj !== null && this.httpSendObj.readyState === 4) {
		this.timerReset();
		var response = this.httpSendObj.responseText;
		this.handleResponse(response);
		this.scrollToBottom($(this.config.scroller), true);
	}
};

Lace.prototype.get = function(system) {
	var thisObj = this;

	if (this.httpGetObj !== null && (this.httpGetObj.readyState === 4 || this.httpGetObj.readyState === 0)) {
		var param = 'chatHash=' + encodeURIComponent(this.chatHash);
		param += '&userHash=' + encodeURIComponent(this.userHash);
		this.httpGetObj.open('POST', this.url, true);
		this.httpGetObj.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=UTF-8');
		this.httpGetObj.onreadystatechange = function() { thisObj.handleGet(system); };
		this.httpGetObj.send(param);
	} else {
		setTimeout(function() { thisObj.get(); }, 500);
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
	if (response !== null && typeof(response) != "undefined" && response !== '') {
		var json = eval( '('+response+')' );
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
	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
	    try {
	    	xmlhttp = new XMLHttpRequest();
	    } catch (e) {
	    	xmlhttp = false;
	    }
	}
	return xmlhttp;
};

Lace.prototype.setActive = function(active) {
	var img  = $('statusimage');
	var text = $('statustext');
	var main = $(this.config.scroller);
	var userList = $('userList');

	if (active) {
		img.setAttribute('src', this.config.url + '/themes/' + this.config.theme + '/images/pause.gif');
		img.setAttribute('alt', 'Stop');
		img.setAttribute('title', 'Click to stop');

		this.isActive  = true;
		text.innerHTML     = 'Active';
		main.className     = 'active';
		userList.className = 'active';

		this.httpGetObj  = this.httpObject();
		this.httpSendObj = this.httpObject();

		this.get();
	} else if (!active) {
		img.setAttribute('src', this.config.url + '/themes/' + this.config.theme + '/images/play.gif');
		img.setAttribute('alt', 'Start');
		img.setAttribute('title', 'Click to start');

		this.httpGetObj  = null;
		this.httpSendObj = null;

		this.isActive = false;
		text.innerHTML     = 'Stopped';
		main.className     = 'inactive';
		userList.className = 'inactive';
		clearInterval(this.timerID);
	}
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