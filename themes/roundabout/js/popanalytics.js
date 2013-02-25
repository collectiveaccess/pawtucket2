/******************************************************************************
*         This code is Copyright (C) 2006-2011 POP unless otherwise noted,   *
*      and may not be used without explicit written permission from POP      *
******************************************************************************/

/**  Config info  */

/** main trackers */


var _gaq = _gaq || [];
if (window.location.host.toString().match(/(^|\.)roundabouttheatre\.org$/)) {
    _gaq.push(
				['_setAccount', 'UA-1776579-16'],
				['_setDomainName', 'roundabouttheatre.org'],
				['_trackPageview']);
} else {
	
    _gaq.push(
				['_setAccount', 'UA-1776579-17'],
				['_trackPageview']);
}

/** DO NOT EDIT ANYTHING BELOW THIS LINE */

/**
* Extends functionality but does not override if already present in oDestination
* @param object oDestination The Object to augment
* @param object oSource The Object Literal to augment oDestination with.
*/
Object.augment = function (oDestination, oSource) {
    for (var property in oSource) {
        if (typeof oDestination[property] == "undefined") {
            oDestination[property] = oSource[property];
        }
    }
    return oDestination;
}

function getTextContent(element) {
    if (typeof element.textContent != "undefined") {
        return element.textContent;
    }
    return element.innerText;
}

Object.augment(String.prototype, {
    /**
    * Prototype.js version of this was dependent on other Prototype.js Objects.
    * Rewritten for Library independence.
    * @author Dan Dean
    * @return Object containing name/value pairs
    * @return Value of supplied "key"
    * @usage alert("firstname=dan&lastname=dean".toQueryParams()["lastname"]);
    */
    toQueryParams: function () {
        var query_array = this.substr(this.indexOf("?") + 1).split("&");
        var queryObj = {};
        var query_count = query_array.length;
        for (var i = 0; i < query_count; i++) {
            query_pair = query_array[i].split("=");
            queryObj[query_pair[0]] = query_pair[1];
        }
        return queryObj;
    },
    contains: function (re, str) {
        if (str.search(re) != -1) {
            return true;
        } else {
            return false;
        }
    },
    getHostname: function () {
        return this.toString().replace(/^\w+\:\/\//, '').split('/')[0];
    }
});

/**
* Augment the browser Array capabilities, where necessary
* For a full explanation of JS Array capabilities, see the Array documentation:
* http://developer.mozilla.org/en/docs/Core_JavaScript_1.5_Reference
*/
Object.augment(Array.prototype, {
    // FROM DECONCEPT
    // Adds one or more elements to the end of an array and returns the new length of the array.
    push: function (item) { // IE5
        this[this.length] = item;
        return this.length;
    },

    /**
    * Adds and/or removes elements from an array.
    * @param Number index	Index at which to start changing the array.
    * @param Number count	An integer indicating the number of old array elements to remove.
    * 				 		If count is 0, no elements are removed. In this case, you should specify at least one new element.
    * @return Array An array containing the removed elements.
    * FROM http://www.webreference.com/dhtml/column33/13.html
    */
    splice: function (index, count) {
        if (arguments.length == 0) return index;
        if (typeof index != "number") index = 0;
        if (index < 0) index = Math.max(0, this.length + index);
        if (index > this.length) {
            if (arguments.length > 2) index = this.length;
            else return [];
        }
        if (arguments.length < 2) count = this.length - index;
        count = (typeof count == "number") ? Math.max(0, count) : 0;
        removeArray = this.slice(index, index + count);
        endArray = this.slice(index + count);
        this.length = index;
        for (var i = 2; i < arguments.length; i++) {
            this[this.length] = arguments[i];
        }
        for (var i = 0; i < endArray.length; i++) {
            this[this.length] = endArray[i];
        }
        return removeArray;
    },

    /**
    * Returns the first (least) index of an element within the array equal to the specified value, or -1 if none is found.
    * @param Object obj Needle
    * @param Number si Index to start search. Optional.
    * FROM http://erik.eae.net
    */
    indexOf: function (obj, si) {
        if (si == null) {
            si = 0;
        } else if (si < 0) {
            si = Math.max(0, this.length + si);
        }
        for (var i = si; i < this.length; i++) {
            if (this[i] === obj) { return i; }
        }
        return -1;
    },

    // Determines the existance of the needle in the stack
    contains: function (obj) {
        return this.indexOf(obj) != -1;
    },
    // Removes the first occurence of the supplied obj.
    remove: function (obj) {
        var i = this.indexOf(obj);
        if (i != -1) {
            this.splice(i, 1);
        }
    }
});


// INITIALIZE LIBRARY NAMESPACE
if (typeof window.PopJavaScriptFramework == "undefined") {
    log("creating new PopJavaScriptFramework");
    PopJavaScriptFramework = new Object();
}
// INITIALIZE VERSION NAMESPACE
if (typeof window.PopJavaScriptFramework.v1B2 == 'undefined') {
    log("creating new v1B2");
    PopJavaScriptFramework.v1B2 = new Object();
}

/**
* DOM
* More advanced functionality will reside in an external dom.js file
* @alias $dom
*/
PopJavaScriptFramework.v1B2.dom = {
    /**
    * Create a new DOM node
    * @param {String} nodeName 	The kind of node to create (div, br, p, etc);
    * @param {Object} attributes	Optional object map of attributes and values. Example: {id: 'myEl', class: 'myClass'}
    * @param {String} content	Optional text to set as the textNode within the returned element
    * @param {Array} content		Optional array of Dom Nodes to insert as childNodes
    * @param {NodeList content	Optional NodeList of Dom Nodes to insert as childNodes
    * @return {DOMNode} DOMNode
    * NOTE: dom.create is *heavily* influence by the prototype library
    */
    create: function (nodeName /* obj attributes, str text */) {
        var node = document.createElement(nodeName);
        for (var i = 1; i < arguments.length; i++) {
            if (typeof arguments[i] == 'string') { // STRING
                node.appendChild(this._text(arguments[i]));
            } else if (typeof arguments[i] == 'object' && typeof arguments[i].nodeName != 'undefined') { // NODE
                node.appendChild(arguments[i]);
            } else if (typeof arguments[i] == 'object' && typeof arguments[i].length != 'undefined') { // ARRAY OF NODES OR NODELIST
                for (var j = 0; j < arguments[i].length; j++) {
                    node.appendChild(arguments[i][j].cloneNode(true));
                }
            } else if (typeof arguments[i] == 'object') { // ATTRIBUTES
                this._attributes(node, arguments[i]);
            }
        }
        return node;
    },
    /**
    * Cycles through the supplied attributes and applies them to the supplied element
    * @param {DOMNode} node The node to apply attributes to
    * @param {Object} attributes A JSON Object of attributes: {className:'myclass', id:'myID'}
    * @return void
    * WARNING: An attibute can NOT be named 'class', but must be 'className'
    */
    _attributes: function (node, attributes) {
        for (var attr in attributes) {
            switch (true) {
                case (attr == 'className'):
                    node.className = attributes[attr];
                    break;
                case (attr == 'htmlFor'): // must pass htmlFor, as 'for' is a keyword
                    node.htmlFor = attributes[attr];
                    break;
                default:
                    node.setAttribute(attr, attributes[attr]);
            }
        }
    },
    /**
    * Creates and returns a text node with the supplied value
    * @param {String} text
    */
    _text: function (text) {
        return document.createTextNode(text);
    },

    /**
    * Removes nodes from the DOM
    * @param {String/Object} Elements The node you want to remove passed via Node OR ID string
    * @return {Object/Array} The Element or an Array of Elements removed
    * FIXME This method currently won't accept an Array of elements or element ID's
    */
    remove: function (Elements) {
        var removed = new Array();
        for (var i = 0; i < arguments.length; i++) {
            var el = (typeof arguments[i] == 'string') ? this.getById(arguments[i]) : arguments[i];
            removed.push(el.parentNode.removeChild(el));
        }
        return (removed.length > 1) ? removed : removed[0];
    },

    /**
    * Gets the requested element(s).
    * If you pass in a single string, returns FALSE on failure or the DOMNode
    * on success. If you pass in many strings an Array of all found elements 
    * is returned, which means an Empty array on failure
    * @param {String} ElementIDs A comma-seperated list of element ID's
    * @return Boolean/Array/DOMNode
    */
    getById: function (ElementIDs) {
        var elements = new Array();
        var result;
        for (var i = 0; i < arguments.length; i++) {
            var el;
            if (el = document.getElementById(arguments[i])) {
                elements.push(el);
            }
        }
        switch (true) {
            case (arguments.length == 1 && elements.length == 1):
                result = elements[0];
                break;
            case (arguments.length > 1):
                result = elements;
                break;
            default:
                result = false;
                break;
        }
        return result;
    },

    /**
    * Returns an Array of all found elements by supplied tag name
    * @param String ElementTagNames A comma seperated list of NodeNames
    * @return Array An Array of all found elements. An empty Array on failure
    */
    getByTag: function (ElementTagNames) {
        var elements = new Array();
        for (var i = 0; i < arguments.length; i++) {
            els = document.getElementsByTagName(arguments[i]);
            for (var j = 0; j < els.length; j++) {
                elements.push(els[j]);
            }
        }
        return elements;
    },

    /**
    * Get all nodes with the given className
    * @param String classNames A list of node.className(s) to check for
    * @return An array of elements or an empty array on failure
    */
    getByClass: function (classNames) {
        var o = new Array();
        var all = (typeof document.getElementsByTagName != 'undefined') ? document.getElementsByTagName('*') : document.all;
        for (var i = 0; i < all.length; i++) {
            (this.hasClass(all[i], arguments)) ? o.push(all[i]) : true;
        }
        return o;
    },

    /**
    * Add a class to an element
    * @param Object node The element to work on
    * @param String cls The class to add to the element
    */
    addClass: function (node, cls) {
        var c = node.className.split(' ');
        (!c.contains(cls)) ? c.push(cls) : true;
        node.className = c.join(' ');
    },

    /**
    * Remove a class from an element
    * @param Object node The element to work on
    * @param String cls The class to remove from the element
    */
    removeClass: function (node, cls) {
        var c = node.className.split(' ');
        (c.contains(cls)) ? c.remove(cls) : true;
        node.className = c.join(' ');
    },

    /**
    * Swap one class with another. If the first class doesn't exist the new 
    * class is added.
    * @param Object node The element to work on
    * @param String sOldClass The class to swap out
    * @param String sNewClass The class to swap in
    */
    swapClass: function (node, sOldClass, sNewClass) {
        if (this.hasClass(node, sOldClass)) {
            this.removeClass(node, sOldClass);
        }
        this.addClass(node, sNewClass);
    },

    /**
    * Check an element for the given className(s)
    * @param {Object} node The node to check for a className
    * @param {String} classNames A list of classNames to check for
    * @return Boolean
    */
    hasClass: function (node, classNames) {
        var args = arguments;
        var start = 1;
        if (typeof arguments[1] == 'object') {
            args = arguments[1];
            start = 0;
        }
        var success = false;
        for (var i = start; i < args.length; i++) {
            if (node.className.split(' ').contains(args[i])) {
                success = true;
                break;
            }
        }
        return success;
        // return (node.className.split(' ').contains(cls));
    },

    /**
    * Gets a property from an elements computed style in a x-browser fashion
    * @param DOMNode oNode The element to work on
    * @param String sProperty The CSS property to find
    */
    getComputedStyle: function (oNode, sProperty) {
        var computedStyle = null;
        if (typeof oNode.currentStyle != 'undefined') {
            computedStyle = oNode.currentStyle;
        } else {
            computedStyle = document.defaultView.getComputedStyle(oNode, null);
        }
        return computedStyle[sProperty];
    }
}
$dom = PopJavaScriptFramework.v1B2.dom;

/**
* Add and Remove events from objects
*/
PopJavaScriptFramework.v1B2.event = {
    /**
    * Adds an event to an object
    * @param Object obj The object to attach an event to
    * @param String type [load | blur | focus | etc]
    * @param Function fn The function to call when the even fires
    */
    add: function (obj, type, fn) {
        if (obj.addEventListener) {
            log("event.add using addEventListener");
            obj.addEventListener(type, fn, false);
        } else if (obj.attachEvent) {
            log("event.add using attachEvent");
            obj["e" + type + fn] = fn;
            obj[type + fn] = function () { obj["e" + type + fn](window.event); }
            obj.attachEvent("on" + type, obj[type + fn]);
        }
    },
    /**
    * The exact same as event.add, but removing instead of adding
    */
    remove: function (obj, type, fn) {
        if (obj.removeEventListener) {
            obj.removeEventListener(type, fn, false);
        } else if (obj.detachEvent) {
            obj.detachEvent("on" + type, obj[type + fn]);
            obj[type + fn] = null;
            obj["e" + type + fn] = null;
        }
    },
    /**
    * Stop an event from firing
    * This does no work in Safari prior to 2.0.? (find webkit version)
    */
    stop: function (e) {
        if (e) { // event object
            if (e.preventDefault) {	// W3C
                e.preventDefault();
                e.stopPropagation();
            } else {				// IE
                e.returnValue = false;
                e.cancelBubble = true;
            }
        } else {
        }
        return false;
    }
}

/******************************************************************************
*         This code is Copyright (C) 2006-2009 POP unless otherwise noted,   *
*      and may not be used without explicit written permission from POP      *
******************************************************************************/

/**
* CONFIGURATION SETTINGS
*/

PopJavaScriptFramework.v1B2.config = {
    root: "http://" + location.hostname + "/_ui/js",
    rootVirtual: "/"
}

PopJavaScriptFramework.v1B2.config.analytics = {
    enabled: true,
    clickLogging: false, // Print clicklog instead of tracking?
    domains: [				// You must put all possible live domains in the domains array, including utmLinker domains
				location.hostname,
    // replace string.getHostName()
				PopJavaScriptFramework.v1B2.config.root.getHostname(),
				''
				],
    UlinkDomains: [				// You must put all possible utmLinker domains in this array
				],
    params: { // deprecated
        _ulink: "1"



    }
}

/**
* CUSTOM UTMLINKER FUNCTION
*/
function __utmLinker2(l, h) {
    alert('__utmLinker2');
    /*if (!_ulink) return;
    var p,k,a="-",b="-",c="-",x="-",z="-",v="-";
    console.log(_ubd.cookie); 
    var dc=_ubd.cookie;
		 
    if (!l || l=="") return;
    var iq = l.indexOf("?"); 
    var ih = l.indexOf("#"); 
    if (dc) {
    a=_uES(_uGC(dc,"__utma="+_udh,";"));
    b=_uES(_uGC(dc,"__utmb="+_udh,";"));
    c=_uES(_uGC(dc,"__utmc="+_udh,";"));
    x=_uES(_uGC(dc,"__utmx="+_udh,";"));
    z=_uES(_uGC(dc,"__utmz="+_udh,";"));
    v=_uES(_uGC(dc,"__utmv="+_udh,";"));
    k=(_uHash(a+b+c+x+z+v)*1)+(_udh*1);
    p="__utma="+a+"&__utmb="+b+"&__utmc="+c+"&__utmx="+x+"&__utmz="+z+"&__utmv="+v+"&__utmk="+k;
    }
    if (p) {
    if (h && ih>-1) { 
    return; 
    }
    if (h) { 
    _udl.href2=l+"#"+p; 
    }
    else {
    if (iq==-1 && ih==-1) {
    _udl.href2=l+"?"+p;
    return _udl.href2;
    }
    else if (ih==-1) {
    _udl.href2=l+"&"+p;
    return _udl.href2;
    }
    else if (iq==-1) {
    _udl.href2=l.substring(0,ih)+"?"+p+l.substring(ih);
    return _udl.href2;
    }
    else {
    _udl.href2=l.substring(0,ih-1)+"&"+p+l.substring(ih);
    return _udl.href2;
    }
    }
    } else {
    _udl.href2=l;
    return _udl.href2;
    }
    */
}


PopJavaScriptFramework.v1B2.analytics = {
    /**
    * List of file suffixes to track as downloads
    */
    dlSuffix: ["mov", "mp3", "wmv", "wav", "rm", "doc", "xls", "zip", "pdf", "sit", "sitx", "tgz"],

    /**
    * An array to hold trackable links
    */
    links: [],

    /**
    * Global alias to build() * "this" scopes to "window", not PopJavaScriptFramework.v1B2.analytics.
    */
    init: function () {
        log("init");
        PopJavaScriptFramework.v1B2.analytics.build();
    },
    /**
    * Starts all aspects of GA tracking.
    */
    build: function () {
        log("building");
        var self = this;

        this.isCmdKeyPressed = false;

        document.onkeyup = function (e) {
            if (!e) var e = window.event;
            if (e.which == 91) self.isCmdKeyPressed = false;
        };

        document.onkeydown = function (e) {
            if (!e) var e = window.event;
            if (e.which == 91) self.isCmdKeyPressed = true;
        };

        this.config = PopJavaScriptFramework.v1B2.config.analytics;
        this.links = this._collectLinks();
        for (var i = 0; i < this.links.length; i++) {
            this._attachLinkTracker(this.links[i]);
        }

        // create variables for GA tracking
        var p = PopJavaScriptFramework.v1B2.analytics.config.params;
        for (var i in p) {
            window[i] = p[i];
            //	window[i]p[i]; 
        }

        /*
        // Call GA Tracker (included as seperate script element).
        if (typeof pageTracker._trackPageview != "undefined") {
        pageTracker._trackPageview();
        }*/
    },

    /**
    * Collects all links to track on page
    * @return {Array} Array of link elements to track
    */
    _collectLinks: function () {
        // Find all A/AREA tags
        var a = $dom.getByTag('a', 'area');
        var links_to_track = [];
        for (var i = 0; i < a.length; i++) {
            if (this._isUTMlinker(a[i]) || this._isOutbound(a[i]) || this._isDownload(a[i]) || this._isEmail(a[i]) || this._isJS(a[i])) {
                links_to_track.push(a[i]);
            }
        }
        return links_to_track;
    },
    /**
    * Attaches clicktracker to each link OR returns the string that would be
    * tracked it the tracker were attached to the link
    * @param {Object} oLinkElement A link element to attach the clicktracker to
    * @param {Boolean} bList Whether or not to return a string representation instead of tracking.
    */
    _attachLinkTracker: function (oLinkElement, bList) {
        this.wasFired = false;
        if (bList === true) {
            return this._getTrackerString(oLinkElement);
        } else {
            PopJavaScriptFramework.v1B2.event.add(oLinkElement, "click", PopJavaScriptFramework.v1B2.analytics.trackClick);
        }
    },
    /**
    * Attached to each outbound link. "this" scopes to the "a" object.
    */
    trackClick: function (e) {
        log("trackClick");
        if (!this.wasFired) {
            PopJavaScriptFramework.v1B2.analytics._trackClick(this, e);
            this.wasFired = true;
        } else {
            this.wasFired = false;
        }
    },

    _trackClick: function (a, e) {
        var o = this._getTrackerString(a);

        if (this.config.clickLogging) {
            log("tracking click: " + o);
            // LOG, don't track
            try { // log in firebug
                console.info(o, a);
            } catch (err) { // alert everywhere else
                alert(o + '\n(' + a + ')');
            }
            PopJavaScriptFramework.v1B2.event.stop(e);
        } else {
            log("config.clickLogging = false");
            if (this._isUTMlinker(a)) {
                log("this event is handled by UTMlinker");
                //alert('UTM should work.');
                PopJavaScriptFramework.v1B2.event.stop(e);
            } else {
                // Track if pageTracker._trackPageview function is found
                try {
                    _gaq.push(['_trackEvent', o.category, o.action, o.magic]);

                    if (this.isCmdKeyPressed) {
                        window.open(a.href, +new Date());
                    }
                    //pageTracker._trackEvent(o.category,o.action,o.magic);
                    //pageTracker._trackPageview(o);
                } catch (err) { }
            }
        }
    },

    /**
    * Get the string to pass to GA from an A element
    * @param {Object} a An A or Area HTML Element
    * @return {String} A string for to pass to GA for custom click-tracking
    */
    _getTrackerString: function (a) {
        var o = '';
        var ga_cat = '';
        var ga_act = 'Click';
        var tracker = _gaq._getAsyncTracker();

        switch (true) {
            case this._isUTMlinker(a):
                if (this.isCmdKeyPressed) {
                    o = tracker._getLinkerUrl(a.href);
                    window.open(o, +new Date());
                } else {
                    o = a.href;
                    log("pushing link: " + o);
                    _gaq.push(['_link', o]);
                }
                break;
            case this._isOutbound(a):
                o = this._removeProtocol(a.href);
                ga_cat = 'Outbound Links';
                break;
            case this._isDownload(a):
                o = this._removeProtocol(a.href).replace(a.href.getHostname(), '').replace(/^\//, '');
                ga_cat = 'Downloads';
                break;
            case this._isEmail(a):
                o = this._removeProtocol(a.href);
                ga_cat = 'Emails';
                break;
            case this._isJS(a):
                o = this._removeProtocol(a.href).replace(a.href.getHostname(), '').replace(/^\//, '');
                ga_cat = 'Javascript';
                break;
        }
        return {
            category: ga_cat,
            action: ga_act,
            magic: o
        };
    },

    /**
    * UTILITY: Remove Protocol from link
    * @param {String} sHref
    * @return {String} String without the beginning protocol
    */
    _removeProtocol: function (sHref) {
        if (sHref.indexOf('mailto') == 0) {
            return sHref.replace(/^\w+\:/, "");
        } else {
            return sHref.replace(/^\w+\:\/\//, "");
        }
    },
    /**
    * UTILITY: Check if an a's href is an OUTBOUND URL
    * @param {Object} a Link or Area element
    * @return {Boolean}
    */
    _isOutbound: function (a) {
        // if URL domain is not in our domain list and it begins with 'http', it's external
        if ((!this.config.domains.contains(a.href.getHostname())) && (a.href.indexOf('http') == 0)) {
            return true;
        }
        return false;
    },

    /**
    * UTILITY: Check if an a's href is an UTMLINKER URL
    * @param {Object} a Link or Area element
    * @return {Boolean}
    */
    _isUTMlinker: function (a) {
        // if URL domain is not in our UTMlinker list, it's to be UTMlinker tagged
        if ((this.config.UlinkDomains.contains(a.href.getHostname()))) {
            return true;
        }
        return false;
    },

    /**
    * UTILITY: Check if an a's href is an DOWNLOAD URL
    * @param {Object} a Link or Area element
    * @return {Boolean}
    */
    _isDownload: function (a) {
        var suff = a.href.split("?")[0]; 		// remove query strings
        suff = suff.split(".");
        suff = suff[suff.length - 1]; 			// isolate the suffix
        if (this.dlSuffix.indexOf(suff) > -1) {		// find out if it's a trackable suffix
            return true;
        }
        return false;
    },
    /**
    * UTILITY: Check if an a's href is an EMAIL ADDRESS
    * @param {Object} a Link or Area element
    * @return {Boolean}
    */
    _isEmail: function (a) {
        if (a.href.indexOf('mailto:') == 0) {
            return true;
        }
        return false;
    },
    /**
    * UTILITY: Check if an a is designated as a JS LINK
    * @param {Object} a Link or Area element
    * @return {Boolean}
    */
    _isJS: function (a) {
        return $dom.hasClass(a, 'ga_jslink');
    },
    /**
    * DEBUGGING: Prints out a list of all links being tracked
    */
    printTracked: function () {
        for (var i = 0; i < this.links.length; i++) {
            //console.log(this._attachLinkTracker(this.links[i], true), this.links[i]);
        }
    }
}

try {
    if (PopJavaScriptFramework.v1B2.config.analytics.enabled == true) {
        if (document.readyState == "complete") {
            log("document has already loaded. calling init()");
            PopJavaScriptFramework.v1B2.analytics.init();
        } else {
            log("binding init to window.load event");
            PopJavaScriptFramework.v1B2.event.add(window, "load", PopJavaScriptFramework.v1B2.analytics.init);
        }
    }
} catch (e) {
    throw new Error("There is no 'analytics' section in PopJavaScriptFramework.config.");
}


//THIS IS DUPLICATED AND CANNOT BE USED UPON DEPLOYMENT
if(!window.log) {
	function log(message) {
	    if (this.console) {
	        console.log(message);
	    }
	}
}

