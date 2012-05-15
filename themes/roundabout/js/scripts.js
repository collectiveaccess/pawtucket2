POP = {};

/**
*	Run Cufon - helpful for rerunning Cufon script on ajax loads
**/
POP.runCufon = function() {
	if(typeof Cufon == 'function') {
		Cufon.replace('h1, h2, h3');
		Cufon.replace('a.block-btn');
	}
};

/**
*	Toggle between show 'more' / 'less' 
**/
POP.showMore = function (targets, options) {

    var self = this;

	self.els = $(targets);
	self.config = $.extend({
	    btnTextMore: 'Show All',
	    btnTextLess: 'Show Less',
		sizedEl: 'ul',
		startHeight: 79
	}, options || {});

    for (var i = 0, len = self.els.length; i < len; i++) {
        self.__init($(self.els[i]));
    }
};

POP.showMore.prototype = {
	__init: function(obj) {
        var self = this,
			el = obj.find(self.config.sizedEl),
			h = el.height();
		//do we actually need to hide anything?
		if(h > self.config.startHeight) {
			self.__addEventListeners(obj);
			//store original height
			obj.data('height', h);
			//set inital 'closed state
			self.hideElement(obj, true);
		}
	},
	__addEventListeners: function(obj) {
        var self = this,
			toggleBtn = obj.find('.btn-show-more');

        toggleBtn.bind('click', function (e) {
            e.preventDefault();
            self.__onToggleBtnClick(obj, toggleBtn);
        });
        toggleBtn.html(self.config.btnTextMore);
    },
 	__onToggleBtnClick: function(obj, btn) {
        var self = this,
			h, 
			btnText = btn.text();
		if(obj.hasClass('isHidden')) {
			self.showElement(obj);
	    } else { 
	        self.hideElement(obj);
	    }
        (btnText == self.config.btnTextMore) ? btn.html(self.config.btnTextLess) : btn.html(self.config.btnTextMore);
    },
	hideElement: function(obj, bool) {
		var self = this,
			el = obj.find(self.config.sizedEl);
		el.animate({
			height: self.config.startHeight
		}, (bool) ? 0 : 200);
		obj.addClass('isHidden');
	},
	showElement: function(obj) {
		var self = this,
			el = obj.find(self.config.sizedEl);
			h = obj.data('height');
		el.animate({
			height: h
		}, 200);
		obj.removeClass('isHidden');
	}
}

/**
*	Search Input - toggles the Search text
**/
POP.ToggleInputText = function (target, options) {
    var el = $(target),
		config = $.extend({
		    defaultText: 'Search Archives'
		}, options || {}),
		text = '';

    __init();

    function __init() {
        
        var i = document.createElement('input');
        if('placeholder' in i) {
            return;
        }

        text = el.val();
        if (!text) {
            text = config.defaultText;
            el.val(text);
        }
        __addEventListeners();
    }

    function __addEventListeners() {
        el.focusin(function (e) {
            el.val(' ');
        });
        el.focusout(function (e) {
            el.val(text);
        });
    }
};



$(function() {
	$('html').removeClass('no-js');
});











