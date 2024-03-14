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

var addEvent;
if (document.addEventListener) { // Non-IE
	addEvent = function(element, type, handler) {
		element.addEventListener(type, handler, null);
	};
} else if (document.attachEvent) { // IE6+
    addEvent = function(element, type, handler) {
        element.attachEvent("on" + type, handler);
    };
} else { // Older Browsers
    addEvent = function(element, type, handler) {
		var oldHandler = element['on' + type];
		if (oldHandler === null) {
			element['on' + type] = handler;
		} else {
			element['on' + type] = function(e) { oldHandler(e); handler(e); };
		}
	};
}

// Start Lace
addEvent(window, 'load', init);

var LaceObj;

function init() {
	if ($('sayForm')) {
		LaceObj = new Lace();
		LaceObj.scrollToBottom($(LaceObj.config.scroller), true);
	}
}

function $() {
	var elements = new Array();
	for (var i = 0; i < arguments.length; i++) {
		var element = arguments[i];
		if (typeof element == 'string') {
			if (document.getElementById) {
				element = document.getElementById(element);
			} else if (document.all) {
				element = document.all[element];
			}
		}
		if (arguments.length == 1) {
			return element;
		}
		elements.push(element);
	}
	return elements;
}

Array.prototype.inArrayI = function(value) {
	for (var i = 0; i < this.length; i++) {
		if (this[i].toLowerCase() == value.toLowerCase())
			return true;
	}
	return false;
};

Array.prototype.inArray = function (value) {
	for (var i=0; i < this.length; i++) {
		if (this[i] === value) {
			return true;
		}
	}
	return false;
};

String.prototype.trim = function() {
	return this.replace(/^\s+/g, '').replace(/\s+$/g, '');
};

function getCookie(name) {
    var dc = document.cookie;
    var prefix = name + "=";
    var begin = dc.indexOf("; " + prefix);
    if (begin == -1) {
        begin = dc.indexOf(prefix);
        if (begin != 0) return null;
    } else {
        begin += 2;
    }
    var end = document.cookie.indexOf(";", begin);
    if (end == -1) {
        end = dc.length;
    }
    return unescape(dc.substring(begin + prefix.length, end));
}

function deleteCookie(name, path, domain) {
    if (getCookie(name)) {
        document.cookie = name + "=" +
            ((path) ? "; path=" + path : "") +
            ((domain) ? "; domain=" + domain : "") +
            "; expires=Thu, 01-Jan-70 00:00:01 GMT";
    }
}