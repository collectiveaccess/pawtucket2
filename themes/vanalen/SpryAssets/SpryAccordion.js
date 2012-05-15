/* SpryAccordion.js - Revision: Spry Preview Release 1.4 */

// Copyright (c) 2006. Adobe Systems Incorporated.
// All rights reserved.
//
// Redistribution and use in source and binary forms, with or without
// modification, are permitted provided that the following conditions are met:
//
//   * Redistributions of source code must retain the above copyright notice,
//     this list of conditions and the following disclaimer.
//   * Redistributions in binary form must reproduce the above copyright notice,
//     this list of conditions and the following disclaimer in the documentation
//     and/or other materials provided with the distribution.
//   * Neither the name of Adobe Systems Incorporated nor the names of its
//     contributors may be used to endorse or promote products derived from this
//     software without specific prior written permission.
//
// THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
// AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
// IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
// ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
// LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
// CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
// SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
// INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
// CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
// ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
// POSSIBILITY OF SUCH DAMAGE.

var Spry;
if (!Spry) Spry = {};
if (!Spry.Widget) Spry.Widget = {};

Spry.Widget.Accordion = function(element, opts)
{
	this.element = this.getElement(element);
	this.defaultPanel = 0;
	this.hoverClass = "AccordionPanelTabHover";
	this.openClass = "AccordionPanelOpen";
	this.closedClass = "AccordionPanelClosed";
	this.focusedClass = "AccordionFocused";
	this.enableAnimation = true;
	this.enableKeyboardNavigation = true;
	this.currentPanel = null;
	this.animator = null;
	this.hasFocus = null;
	this.duration = 500;

	this.previousPanelKeyCode = Spry.Widget.Accordion.KEY_UP;
	this.nextPanelKeyCode = Spry.Widget.Accordion.KEY_DOWN;

	this.useFixedPanelHeights = true;
	this.fixedPanelHeight = 0;

	Spry.Widget.Accordion.setOptions(this, opts, true);

	// Unfortunately in some browsers like Safari, the Stylesheets our
	// page depends on may not have been loaded at the time we are called.
	// This means we have to defer attaching our behaviors until after the
	// onload event fires, since some of our behaviors rely on dimensions
	// specified in the CSS.

	if (Spry.Widget.Accordion.onloadDidFire)
		this.attachBehaviors();
	else
		Spry.Widget.Accordion.loadQueue.push(this);
};

Spry.Widget.Accordion.onloadDidFire = false;
Spry.Widget.Accordion.loadQueue = [];

Spry.Widget.Accordion.addLoadListener = function(handler)
{
	if (typeof window.addEventListener != 'undefined')
		window.addEventListener('load', handler, false);
	else if (typeof document.addEventListener != 'undefined')
		document.addEventListener('load', handler, false);
	else if (typeof window.attachEvent != 'undefined')
		window.attachEvent('onload', handler);
};

Spry.Widget.Accordion.processLoadQueue = function(handler)
{
	Spry.Widget.Accordion.onloadDidFire = true;
	var q = Spry.Widget.Accordion.loadQueue;
	var qlen = q.length;
	for (var i = 0; i < qlen; i++)
		q[i].attachBehaviors();
};

Spry.Widget.Accordion.addLoadListener(Spry.Widget.Accordion.processLoadQueue);

Spry.Widget.Accordion.prototype.getElement = function(ele)
{
	if (ele && typeof ele == "string")
		return document.getElementById(ele);
	return ele;
};

Spry.Widget.Accordion.prototype.addClassName = function(ele, className)
{
	if (!ele || !className || (ele.className && ele.className.search(new RegExp("\\b" + className + "\\b")) != -1))
		return;
	ele.className += (ele.className ? " " : "") + className;
};

Spry.Widget.Accordion.prototype.removeClassName = function(ele, className)
{
	if (!ele || !className || (ele.className && ele.className.search(new RegExp("\\b" + className + "\\b")) == -1))
		return;
	ele.className = ele.className.replace(new RegExp("\\s*\\b" + className + "\\b", "g"), "");
};

Spry.Widget.Accordion.setOptions = function(obj, optionsObj, ignoreUndefinedProps)
{
	if (!optionsObj)
		return;
	for (var optionName in optionsObj)
	{
		if (ignoreUndefinedProps && optionsObj[optionName] == undefined)
			continue;
		obj[optionName] = optionsObj[optionName];
	}
};

Spry.Widget.Accordion.prototype.onPanelTabMouseOver = function(panel)
{
	if (panel)
		this.addClassName(this.getPanelTab(panel), this.hoverClass);
};

Spry.Widget.Accordion.prototype.onPanelTabMouseOut = function(panel)
{
	if (panel)
		this.removeClassName(this.getPanelTab(panel), this.hoverClass);
};

Spry.Widget.Accordion.prototype.openPanel = function(panel)
{
	var panelA = this.currentPanel;
	var panelB = panel;
	
	if (!panelB || panelA == panelB)	
		return;

	var contentA; 
	if( panelA )
		contentA = this.getPanelContent(panelA);
	var contentB = this.getPanelContent(panelB);

	if (! contentB)
		return;

	if (this.useFixedPanelHeights && !this.fixedPanelHeight)
	{
		this.fixedPanelHeight = (contentA.offsetHeight) ? contentA.offsetHeight : contentA.scrollHeight;
	}

	if (this.enableAnimation)
	{
		if (this.animator)
			this.animator.stop();
		this.animator = new Spry.Widget.Accordion.PanelAnimator(this, panelB, { duration: this.duration });
		this.animator.start();
	}
	else
	{
		if(contentA)
			contentA.style.height = "0px";
		contentB.style.height = (this.useFixedPanelHeights ? this.fixedPanelHeight : contentB.scrollHeight) + "px";
	}

	if(panelA)
	{
		this.removeClassName(panelA, this.openClass);
		this.addClassName(panelA, this.closedClass);
	}

	this.removeClassName(panelB, this.closedClass);
	this.addClassName(panelB, this.openClass);

	this.currentPanel = panelB;
};

Spry.Widget.Accordion.prototype.openNextPanel = function()
{
	var panels = this.getPanels();
	var curPanelIndex = this.getCurrentPanelIndex();
	
	if( panels && curPanelIndex >= 0 && (curPanelIndex+1) < panels.length )
		this.openPanel(panels[curPanelIndex+1]);
};

Spry.Widget.Accordion.prototype.openPreviousPanel = function()
{
	var panels = this.getPanels();
	var curPanelIndex = this.getCurrentPanelIndex();
	
	if( panels && curPanelIndex > 0 && curPanelIndex < panels.length )
		this.openPanel(panels[curPanelIndex-1]);
};

Spry.Widget.Accordion.prototype.openFirstPanel = function()
{
	var panels = this.getPanels();
	if( panels )
		this.openPanel(panels[0]);
};

Spry.Widget.Accordion.prototype.openLastPanel = function()
{
	var panels = this.getPanels();
	if( panels )
		this.openPanel(panels[panels.length-1]);
};

Spry.Widget.Accordion.prototype.onPanelClick = function(panel)
{
	// if (this.enableKeyboardNavigation)
	// 	this.element.focus();
	if (panel != this.currentPanel)
		this.openPanel(panel);
	this.focus();
};

Spry.Widget.Accordion.prototype.onFocus = function(e)
{
	// this.element.focus();
	this.hasFocus = true;
	this.addClassName(this.element, this.focusedClass);
};

Spry.Widget.Accordion.prototype.onBlur = function(e)
{
	// this.element.blur();
	this.hasFocus = false;
	this.removeClassName(this.element, this.focusedClass);
};

Spry.Widget.Accordion.KEY_UP = 38;
Spry.Widget.Accordion.KEY_DOWN = 40;

Spry.Widget.Accordion.prototype.onKeyDown = function(e)
{
	var key = e.keyCode;
	if (!this.hasFocus || (key != this.previousPanelKeyCode && key != this.nextPanelKeyCode))
		return true;
	
	var panels = this.getPanels();
	if (!panels || panels.length < 1)
		return false;
	var currentPanel = this.currentPanel ? this.currentPanel : panels[0];
	var nextPanel = (key == this.nextPanelKeyCode) ? currentPanel.nextSibling : currentPanel.previousSibling;
	
	while (nextPanel)
	{
		if (nextPanel.nodeType == 1 /* Node.ELEMENT_NODE */)
			break;
		nextPanel = (key == this.nextPanelKeyCode) ? nextPanel.nextSibling : nextPanel.previousSibling;
	}
	
	if (nextPanel && currentPanel != nextPanel)
		this.openPanel(nextPanel);

	if (e.stopPropagation)
		e.stopPropagation();
	if (e.preventDefault)
		e.preventDefault();

	return false;
};

Spry.Widget.Accordion.prototype.attachPanelHandlers = function(panel)
{
	if (!panel)
		return;

	var tab = this.getPanelTab(panel);

	if (tab)
	{
		var self = this;
		Spry.Widget.Accordion.addEventListener(tab, "click", function(e) { return self.onPanelClick(panel); }, false);
		Spry.Widget.Accordion.addEventListener(tab, "mouseover", function(e) { return self.onPanelTabMouseOver(panel); }, false);
		Spry.Widget.Accordion.addEventListener(tab, "mouseout", function(e) { return self.onPanelTabMouseOut(panel); }, false);
	}
};

Spry.Widget.Accordion.addEventListener = function(element, eventType, handler, capture)
{
	try
	{
		if (element.addEventListener)
			element.addEventListener(eventType, handler, capture);
		else if (element.attachEvent)
			element.attachEvent("on" + eventType, handler);
	}
	catch (e) {}
};

Spry.Widget.Accordion.prototype.initPanel = function(panel, isDefault)
{
	var content = this.getPanelContent(panel);
	if (isDefault)
	{
		this.currentPanel = panel;
		this.removeClassName(panel, this.closedClass);
		this.addClassName(panel, this.openClass);
	}
	else
	{
		this.removeClassName(panel, this.openClass);
		this.addClassName(panel, this.closedClass);
		content.style.height = "0px";
	}
	
	this.attachPanelHandlers(panel);
};

Spry.Widget.Accordion.prototype.attachBehaviors = function()
{
	var panels = this.getPanels();
	for (var i = 0; i < panels.length; i++)
	{
		this.initPanel(panels[i], i == this.defaultPanel);
	}

	if (this.enableKeyboardNavigation)
	{
		// XXX: IE doesn't allow the setting of tabindex dynamically. This means we can't
		// rely on adding the tabindex attribute if it is missing to enable keyboard navigation
		// by default.

		var tabIndexAttr = this.element.attributes.getNamedItem("tabindex");
		// if (!tabIndexAttr) this.element.tabindex = 0;
		if (tabIndexAttr)
		{
			var self = this;
			Spry.Widget.Accordion.addEventListener(this.element, "focus", function(e) { return self.onFocus(e); }, false);
			Spry.Widget.Accordion.addEventListener(this.element, "blur", function(e) { return self.onBlur(e); }, false);
			Spry.Widget.Accordion.addEventListener(this.element, "keydown", function(e) { return self.onKeyDown(e); }, false);
		}
	}
};

Spry.Widget.Accordion.prototype.getPanels = function()
{
	return this.getElementChildren(this.element);
};

Spry.Widget.Accordion.prototype.getCurrentPanel = function()
{
	return this.currentPanel;
};

Spry.Widget.Accordion.prototype.getCurrentPanelIndex = function()
{
	var panels = this.getPanels();
	for( var i = 0 ; i < panels.length; i++ )
	{
		if( this.currentPanel == panels[i] )
			return i;
	}
	return 0;
};

Spry.Widget.Accordion.prototype.getPanelTab = function(panel)
{
	if (!panel)
		return null;
	return this.getElementChildren(panel)[0];
};

Spry.Widget.Accordion.prototype.getPanelContent = function(panel)
{
	if (!panel)
		return null;
	return this.getElementChildren(panel)[1];
};

Spry.Widget.Accordion.prototype.getElementChildren = function(element)
{
	var children = [];
	var child = element.firstChild;
	while (child)
	{
		if (child.nodeType == 1 /* Node.ELEMENT_NODE */)
			children.push(child);
		child = child.nextSibling;
	}
	return children;
};

Spry.Widget.Accordion.prototype.focus = function()
{
	if (this.element && this.element.focus)
		this.element.focus();
};

/////////////////////////////////////////////////////

Spry.Widget.Accordion.PanelAnimator = function(accordion, panel, opts)
{
	this.timer = null;
	this.interval = 0;
	this.stepCount = 0;

	this.fps = 0;
	this.steps = 10;
	this.duration = 500;
	this.onComplete = null;

	this.panel = panel;
	this.panelToOpen = accordion.getElement(panel);
	this.panelData = [];

	Spry.Widget.Accordion.setOptions(this, opts, true);


	// If caller specified speed in terms of frames per second,
	// convert them into steps.

	if (this.fps > 0)
	{
		this.interval = Math.floor(1000 / this.fps);
		this.steps = parseInt((this.duration + (this.interval - 1)) / this.interval);
	}
	else if (this.steps > 0)
		this.interval = this.duration / this.steps;

	// Set up the array of panels we want to animate.

	var panels = accordion.getPanels();
	for (var i = 0; i < panels.length; i++)
	{
		var p = panels[i];
		var c = accordion.getPanelContent(p);
		if (c)
		{
			var h = c.offsetHeight;
			if (h == undefined)
				h = 0;
			if (p == panel || h > 0)
			{
				var obj = new Object;
				obj.panel = p;
				obj.content = c;
				obj.fromHeight = h;
				obj.toHeight = (p == panel) ? (accordion.useFixedPanelHeights ? accordion.fixedPanelHeight : c.scrollHeight) : 0;
				obj.increment = (obj.toHeight - obj.fromHeight) / this.steps;
				obj.overflow = c.style.overflow;
				this.panelData.push(obj);

				c.style.overflow = "hidden";
				c.style.height = h + "px";
			}
		}
	}
};

Spry.Widget.Accordion.PanelAnimator.prototype.start = function()
{
	var self = this;
	this.timer = setTimeout(function() { self.stepAnimation(); }, this.interval);
};

Spry.Widget.Accordion.PanelAnimator.prototype.stop = function()
{
	if (this.timer)
	{
		clearTimeout(this.timer);

		// If we're killing the timer, restore the overflow
		// properties on the panels we were animating!

		if (this.stepCount < this.steps)
		{
			for (i = 0; i < this.panelData.length; i++)
			{
				obj = this.panelData[i];
				obj.content.style.overflow = obj.overflow;
			}
		}
	}

	this.timer = null;
};

Spry.Widget.Accordion.PanelAnimator.prototype.stepAnimation = function()
{
	++this.stepCount;

	this.animate();

	if (this.stepCount < this.steps)
		this.start();
	else if (this.onComplete)
		this.onComplete();
};

Spry.Widget.Accordion.PanelAnimator.prototype.animate = function()
{
	var i, obj;

	if (this.stepCount >= this.steps)
	{
		for (i = 0; i < this.panelData.length; i++)
		{
			obj = this.panelData[i];
			if (obj.panel != this.panel)
				obj.content.style.height = "0px";
			obj.content.style.overflow = obj.overflow;
			obj.content.style.height = obj.toHeight + "px";
		}
	}
	else
	{
		for (i = 0; i < this.panelData.length; i++)
		{
			obj = this.panelData[i];
			obj.fromHeight += obj.increment;
			obj.content.style.height = obj.fromHeight + "px";
		}
	}
};

