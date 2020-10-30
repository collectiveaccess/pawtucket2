jQuery(document).ready(function() {
	console.log( 'theme js is loaded' );
	//jnUtils.testBrowser();
	return;
	if (typeof(DV) !== 'undefined') {
		console.log( 'DV exists', DV ); 
		// override native imageURL function to add larger format images
		DV.model.Pages.prototype.imageURL = jnUtils.imageURL;
		// override native unsupportedBrowser function to correct IE detection error
		DV.Schema.helpers.unsupportedBrowser = jnUtils.unsupportedBrowser;

		// register afterload event which fires after DV is instantiated
		DV.afterLoad = jnUtils.afterLoad;

		// testing stuff
		/*
		DV.model.Pages.prototype.resize = (function() {
			var cached_function = DV.model.Pages.prototype.resize;
			return function() {
				var caller = DV.model.Pages.prototype.resize.caller;
				var cssHeightOld = this.viewer.pageSet.pages.p0.pageImageEl.css('height');
				var zl = arguments[0];
				if (zl) {
					var previousFactor  = this.zoomFactor();
					var zoomLevel      = zl || this.zoomLevel;
					var zf = zoomLevel / this.BASE_WIDTH;
					var scale           = zf / previousFactor;
					var calcW = Math.round(this.baseWidth * zf);
					var calcH = Math.round(this.height * scale);
					console.group('DV.model.Pages.prototype.resize');
					console.log( 'called by', caller);
					jnUtils.cssHeight(this);
					console.log( 'resize before >>', 'zoom:', zl, 'height:', this.height, 'prevZoom:', previousFactor, 'zoomLevel:', zoomLevel, 'zoomFactor (zl/base_w):', zf, 'scale:', scale, 'h x scale:', calcH, 'css:', cssHeightOld );
				}
				var result = cached_function.apply(this, arguments); // use .apply() to call it
				var cssHeightNew = this.viewer.pageSet.pages.p0.pageImageEl.css('height');
				if (zl) {
					console.log( 'resize after >>', 'zoom:', zl, 'height:', this.height );
					if (cssHeightOld !== cssHeightNew) {
						console.info( 'resize CHANGED from:', cssHeightOld, 'to:', cssHeightNew );
					}
					jnUtils.cssHeight(this);
					console.groupEnd();
				}
				// more of your code
				return result;
			};
		}());
		*/
		/*
		DV.model.Pages.prototype.updateHeight = (function() {
			// var height = image.height * (this.zoomLevel > this.BASE_WIDTH ? 0.7 : 1.0);
			// calls setPageHeight(pageIndex, height)
			var cached_function = DV.model.Pages.prototype.updateHeight;
			return function() {
				//console.log( 'updateHeight called', arguments );
				var caller = DV.model.Pages.prototype.updateHeight.caller;
				var cssHeightOld = this.viewer.pageSet.pages.p0.pageImageEl.css('height');
				var i = arguments[1];
				var img = arguments[0];
				var h = img.height;
				var z = this.zoomLevel > this.BASE_WIDTH ? 0.7 : 1.0;
				var calcH = h * z;
				if (i === 0) {
					console.group('DV.model.Pages.prototype.updateHeight');
					console.log( 'called by', caller);
					jnUtils.cssHeight(this);
					console.log( 'updateHeight before >>', 'actual img height:', h, 'zoom:', z, 'calc h:', calcH, 'css:', cssHeightOld );
				}
				var result = cached_function.apply(this, arguments); // use .apply() to call it
				var cssHeightNew = this.viewer.pageSet.pages.p0.pageImageEl.css('height');
				if (i === 0) {
					console.log('updateHeight after >>', 'css:', cssHeightNew);
					if (cssHeightOld !== cssHeightNew) {
						console.info( 'updateHeight CHANGED from:', cssHeightOld, 'to:', cssHeightNew );
					}
					jnUtils.cssHeight(this);
					console.groupEnd();
				}
				// more of your code
				return result;
			};
		}());
		*/
		/*
		DV.model.Pages.prototype.setPageHeight = (function() {
			// only called by updateHeight
			// assigns height to pageHeights[i]
			var cached_function = DV.model.Pages.prototype.setPageHeight;
			return function() {
				//console.log( 'setPageHeight called' );
				var caller = DV.model.Pages.prototype.setPageHeight.caller;
				var cssHeightOld = this.viewer.pageSet.pages.p0.pageImageEl.css('height');
				var i = arguments[0];
				var h = arguments[1];
				var oh = this.pageHeights[i];
				if (i === 0) {
					console.group('DV.model.Pages.prototype.setPageHeight');
					console.log( 'called by', caller);
					jnUtils.cssHeight(this);
					console.log( 'setPageHeight before >>', 'old height:', oh, 'new height:', h, 'css:', cssHeightOld );
				}
				var result = cached_function.apply(this, arguments); // use .apply() to call it
				var cssHeightNew = this.viewer.pageSet.pages.p0.pageImageEl.css('height');
				if (i === 0) {
					console.log( 'setPageHeight after >>', 'now height:', this.pageHeights[i] );
					if (cssHeightOld !== cssHeightNew) {
						console.info( 'setPageHeight CHANGED from:', cssHeightOld, 'to:', cssHeightNew );
					}
					jnUtils.cssHeight(this);
					console.groupEnd();
				}
				// more of your code
				return result;
			};
		}());
		*/
		
		DV.model.Pages.prototype.getPageHeight = (function() {
			// gets page height this.pageHeights[i] and multiplies by zoomFactor
			var cached_function = DV.model.Pages.prototype.getPageHeight;
			var computeOffsets = DV.model.Document.prototype.computeOffsets.toString();
			var sizeImage = DV.Page.prototype.sizeImage.toString();
			return function() {
				//console.log( 'getPageHeight called' );
				var caller = DV.model.Pages.prototype.getPageHeight.caller;
				var showInfo = false;
				if (caller && caller.toString() != computeOffsets) {
					showInfo = true;
				}
				var i = arguments[0];
				if (i !== 0) {
					showInfo = false;
				}
				var imgObj = jnUtils.imgIndex[i];
				var imgInfo = 'unknown';
				var zl = this.zoomLevel;
				if ( imgObj ) {
					imgInfo = imgObj.h + ' ' + imgObj.src;
				}
				var cssHeightOld = this.viewer.pageSet.pages.p0.pageImageEl.css('height');				
				var ph = this.pageHeights[i];
				var h = this.height;
				var zf = this.zoomFactor();
				var calcH = ph ? ph * zf : h;
				if (showInfo) {
					//console.group('DV.model.Pages.prototype.getPageHeight');
					//console.log( 'called by', caller);
					//jnUtils.cssHeight(this);
					//jnUtils.infoDump(this, i);
					//console.log( 'getPageHeight before >>', 'pageHeight:', ph, 'thisHeight:', h, 'zoomFactor:', zf, 'pageHeight * zf:', calcH, 'css:', cssHeightOld );
					//console.log( 'getPageHeight', i, 'realHeight:', ph, 'height:', h, 'zoom:', this.zoomFactor() );
				}
				var result = cached_function.apply(this, arguments); // use .apply() to call it
				var cssHeightNew = this.viewer.pageSet.pages.p0.pageImageEl.css('height');
				// more of your code
				// this.pageHeights[pageIndex];
				if (showInfo) {
					//console.log( 'getPageHeight after >>', 'pageHeight:', ph, 'height:', h, 'zoom:', zf, 'calcH:', calcH, 'result:', result );
					//jnUtils.imageRatioInfoOutput(this);
					if (cssHeightOld !== cssHeightNew) {
						//console.info( 'getPageHeight CHANGED from:', cssHeightOld, 'to:', cssHeightNew );
					}
					//jnUtils.cssHeight(this);
					//console.groupEnd();
					//jnUtils.infoDump(this, i);
				}
				// .imageURL(this.index);
				//if (!jnUtils.imgIndex[i]) {
					//var url = this.viewer.models.pages.imageURL(i);
					//jnUtils.addImage(i, url);
				//}
				if ( this.zoomLevel > 1000 && imgObj && caller.toString() == sizeImage) {
					console.log( 'getPageHeight Intervene!!!!!!', i, zl, result, imgObj.h );
					//return imgObj.h;
				} else {
					console.log( 'getPageHeight', i, zl, result );
				}
				return result;
			};
		}());
		
		DV.Page.prototype.sizeImage = (function() {
			// calls getPageHeight, sets css
			var cached_function = DV.Page.prototype.sizeImage;
			return function() {
				// this.pageImageEl.css('height');
				var caller = DV.Page.prototype.sizeImage.caller;
				var cssHeightOld = this.pageImageEl.css('height');
				var i = this.index;
				var width = this.model_pages.width;
				var height = this.model_pages.getPageHeight(i);
				var r = height/width;
				var src = this.pageImageEl.attr('src');
				var imgObj = {};
				if ( src ) {
					imgObj.r = jnUtils.getRatio(this.pageImageEl);
					imgObj.w = width;
					imgObj.h = Math.round(width * imgObj.r);
					imgObj.src = jnUtils.trimSrc(src);
					jnUtils.imgIndex[i] = imgObj;
				}
				console.log( 'sizeImage', i, caller, width, height, r, imgObj.r, imgObj.h, imgObj.src );
				var ph = this.viewer.models.pages.pageHeights[i];
				var h = this.viewer.models.pages.height;
				var zf = this.viewer.models.pages.zoomFactor();
				var getPageHeight = Math.round(ph ? ph * zf : h);
				if (i === 0) {
					//console.group('DV.Page.prototype.sizeImage (sets CSS)');
					//console.log( 'called by', caller);
					//jnUtils.cssHeight(this);				
					//console.log( 'sizeImage before >>', 'getPageHeight:', getPageHeight, 'width:', width, 'css:', cssHeightOld );				
				}
				var result = cached_function.apply(this, arguments); // use .apply() to call it
				var cssHeightNew = this.pageImageEl.css('height');
				if (i === 0) {
					//console.log( 'sizeImage after >>' );
					if (cssHeightOld !== cssHeightNew) {
						//console.info( 'sizeImage CHANGED from:', cssHeightOld, 'to:', cssHeightNew );
					}	
					//jnUtils.cssHeight(this);
					//console.groupEnd();
				}

				// more of your code
				return result;
			};
		}());
		
		/*
		DV.Page.prototype.drawImage = (function() {
			// calls getPageHeight(), compares value to this.pageImageEl.attr('height'), replaces img src
			// calls setPageImage(), sizeImage()
			var cached_function = DV.Page.prototype.drawImage;
			return function() {
				var caller = DV.Page.prototype.drawImage.caller;
				
				var cssHeightOld = this.pageImageEl.css('height');
				var i = this.index;
				// calls getPageHeight
				// var realHeight = this.pageHeights[pageIndex];
				var ph = this.viewer.models.pages.pageHeights[i];
				// return Math.round(realHeight ? realHeight * this.zoomFactor() : this.height);
				
				var h = this.viewer.models.pages.height; 
				var zf = this.viewer.models.pages.zoomFactor();
				var getPageHeight = Math.round(ph ? ph * zf : h);
				if (i === 0) {
					console.group('DV.Page.prototype.drawImage');
					//jnUtils.drawImageCounter++;
					console.log( 'called by', caller, ++jnUtils.drawImageCounter);
					jnUtils.cssHeight(this);
					console.log( 'drawImage before >>', 'realHeight:', ph, 'fallback height:', h, 'attrHeight', this.pageImageEl.attr('height'), 'getPageHeight:', getPageHeight );
				}
				var result = cached_function.apply(this, arguments); // use .apply() to call it
				var cssHeightNew = this.pageImageEl.css('height');
				if (i === 0) {
					console.log( 'drawImage after >>', jnUtils.drawImageCounter );
					if (cssHeightOld !== cssHeightNew) {
						console.info( 'drawImage CHANGED from:', cssHeightOld, 'to:', cssHeightNew );
					}
					jnUtils.cssHeight(this);
					console.groupEnd();
				}
				// more of your code
				return result;
			};
		}());
		*/
		/*
		DV.Page.prototype.loadImage = (function() {
			// calls getPageHeight(), compares value to this.pageImageEl.attr('height'), replaces img src
			// calls setPageImage(), sizeImage()
			var cached_function = DV.Page.prototype.loadImage;
			return function() {
				var caller = DV.Page.prototype.loadImage.caller;
				var cssHeightOld = this.pageImageEl.css('height');
				var i = this.index;
				//var ph = this.viewer.models.pages.pageHeights[i];
				//var h = this.viewer.models.pages.height; 
				//var zf = this.viewer.models.pages.zoomFactor();
				//var getPageHeight = Math.round(ph ? ph * zf : h);
				if (i === 0) {
					console.group('DV.Page.prototype.loadImage');
					console.log( 'called by', caller);
					jnUtils.cssHeight(this);
					console.log( 'loadImage before >>' );
					//console.log( 'loadImage before. pageHeight:', ph, 'height:', h, 'attrHeight', this.pageImageEl.attr('height') );
					//console.log( 'loadImage before.', 'attrHeight', this.pageImageEl.attr('height'), 'attrWidth', this.pageImageEl.naturalWidth );
				}
				var result = cached_function.apply(this, arguments); // use .apply() to call it
				//var imageURL = this.pageImageEl.attr('src');
				var cssHeightNew = this.pageImageEl.css('height');
				var _object = $(this.pageImageEl)[0];
				if (i === 0) {
					console.log( 'loadImage after >>', _object);
					//console.log( 'loadImage after.', 'natrHeight', _object.naturalHeight, 'natrWidth',  _object.naturalWidth );
					if (cssHeightOld !== cssHeightNew) {
						console.info( 'loadImage CHANGED from:', cssHeightOld, 'to:', cssHeightNew );
					}
					jnUtils.cssHeight(this);
					console.groupEnd();
				}
				// more of your code
				return result;
			};
		}());
		*/
		/*
		DV.Page.prototype.draw = (function() {
			// 
			var cached_function = DV.Page.prototype.draw;
			return function() {
				var caller = DV.Page.prototype.draw.caller;
				var cssHeightOld = this.pageImageEl.css('height');
				var i = this.index;
				//var ph = this.viewer.models.pages.pageHeights[i];
				//var h = this.viewer.models.pages.height; 
				//var zf = this.viewer.models.pages.zoomFactor();
				//var getPageHeight = Math.round(ph ? ph * zf : h);
				if (i === 0) {
					console.log( 'draw called by', caller );
					//console.log( 'drawImage before. pageHeight:', ph, 'height:', h, 'attrHeight', this.pageImageEl.attr('height') );
				}
				var result = cached_function.apply(this, arguments); // use .apply() to call it
				var cssHeightNew = this.pageImageEl.css('height');
				if (i === 0) {
					//console.log( 'drawImage after' );
					if (cssHeightOld !== cssHeightNew) {
						console.info( 'draw CHANGED from:', cssHeightOld, 'to:', cssHeightNew );
					}
				}
				// more of your code
				return result;
			};
		}());
		*/
		// this.pageImageEl.css({width: width, height: height});
		// viewer.pageSet.pages.p0.pageImageEl.css('height');
	}
	if (typeof(caUI) !== 'undefined') {
		console.log( 'caUI exists', caUI );
	} else {
		console.log( 'caUI does not exist' );	
	}
	jQuery( document ).on( 'click', '.DV-zoomLabel', function(e) {
		//console.log(' clicked!' );
		var className = $( this ).attr('class');
		console.log( className + ' clicked!' );
		console.log( 'DV.viewers[documentData]', DV.viewers['documentData'] );
		var dv = DV.viewers['documentData'];
		var max = dv.slider.slider( "option", "max" );
		dv.slider.css('border','2px solid red');
		console.log( 'DV.slider max', max );
	});
});

var jnUtils = jnUtils || {};

jnUtils.observer = function(obj){
	console.log('jnUtils.observer fired', obj);
	console.log('observer this', this);
};

jnUtils.imageURL = function(index) {
	var url  = this.viewer.schema.document.resources.page.image;
	// console.log(this.viewer.schema.document.resources.pageList[index]);
	// this.viewer.models.document.ZOOM_RANGES
	var caller = DV.model.Pages.prototype.imageURL.caller;
	if (!jnUtils.firstRun ) {
		console.log('imageURL first called, by', caller);
		if (this.LARGE_WIDTH) {
			//console.log('imageURL first called', this);
			console.log('imageURL LARGE_WIDTH', this.LARGE_WIDTH);
			//this.LARGE_WIDTH = 1000;
		} else {
			console.log('imageURL no LARGE_WIDTH');
		}
		jnUtils.firstRun = true;
	}
	//console.log('imageURL ZOOM_RANGES', this);
    var size = this.zoomLevel > this.BASE_WIDTH ? 'large' : 'normal';
	size = this.zoomLevel > this.LARGE_WIDTH ? 'original' : size;
	var report = 'zoomLevel: ' + this.zoomLevel;
	report += ', BASE_WIDTH: ' + this.BASE_WIDTH;
	report +=  ', size: ' + size;
	report +=  ', zoomFactor: ' + this.zoomFactor();
	// this.models.document.ZOOM_RANGES
	$('#jn-output-1').text(report);
	// var size = this.zoomLevel > this.BASE_WIDTH ? 'original' : 'normal';
	// var size = this.zoomLevel > this.BASE_WIDTH ? 'original' : 'large';
    var pageNumber = index + 1;
    if (this.viewer.schema.document.resources.page.zeropad) pageNumber = this.zeroPad(pageNumber, 5);
    //url = url.replace(/\{size\}/, size);
    //url = url.replace(/\{page\}/, pageNumber);
	url = this.viewer.schema.document.resources.pageList[index][size + "_url"];
	//console.log( 'DV imageURL: ' + url );
				if (!jnUtils.imgIndex[index]) {
					jnUtils.addImage(index, url);
				}
    return url;
};

jnUtils.extendZoomRanges = function(arrVals){
	console.log( 'extendZoomRanges firing this', this );
	var ranges = this.models.document.ZOOM_RANGES;
	//console.log( 'extendZoomRanges ranges before', ranges, ranges.length );
	// add extra array values to end of range array
	ranges = ranges.concat(arrVals);
	// calculate new slider max
	var newMax = ranges.length -1;
	// calculate new slider css width
	var sliderUnitWidth = 21;
	var sliderWidth = (sliderUnitWidth * newMax) + 2; // 128 or (64 * max)/3
	//console.log( 'extendZoomRanges ranges after', arrVals,  ranges.length );
	//var oldMax = this.slider.slider( 'option', 'max' );
	//console.log( 'slider max oldMax', oldMax );
	// attach new ranges
	this.models.document.ZOOM_RANGES = ranges; 
	// increase slider max
	this.slider.slider( 'option', 'max', newMax );
	// adjust slider width
	this.slider.css('width', sliderWidth);
	// what else needs to be recalculated?
	// add event listeners for testing
	var viewer = this;
	this.slider.on( "slide", function( event, ui ) {
		var n = parseInt(ui.value, 10);
		var zr = viewer.models.document.ZOOM_RANGES;
		var zm = zr[n];
		console.log('yay viewer.slider slide fired', n, zm);
		$('#jn-output-2').text('viewer.slider slide: ' + n + ' zoom: ' + zm);
		// console.log('ZOOM_RANGES', zr);
	} );
	this.slider.on( "slidechange", function( event, ui ) {
		var n = parseInt(ui.value, 10);
		var zr = viewer.models.document.ZOOM_RANGES;
		var zm = zr[n];
		console.log('yay viewer.slider change fired', n, zm);
		//console.log('ZOOM_RANGES', zr);
	} );
};	

jnUtils.extendZoomValues = [1500, 2000];

jnUtils.unsupportedBrowser = function() {
	// DV.Schema.helpers.unsupportedBrowser
	// original DV function was incorrectly failing on IE versions > 6
	// removed quotes around "6.0", seems to work correctly now
	if ( !(DV.jQuery.browser.msie && DV.jQuery.browser.version <= 6.0) ) {
		return false;
	} else {
		DV.jQuery(this.viewer.options.container).html(JST.unsupported({viewer : this.viewer}));
		return true;
	}
};
jnUtils.testBrowser = function() {
	console.log( 'DV.jQuery.browser.msie', DV.jQuery.browser.msie );
	console.log( 'DV.jQuery.browser.version', DV.jQuery.browser.version );
	var x = 40.0;
	var y = "6.0";
	console.log( 'compare', DV.jQuery.browser.version, '<=', y, x<=y );
	jnUtils.unsupportedBrowser();

	var msie = (DV.jQuery.browser.msie) ? DV.jQuery.browser.msie : 'not msie';
	var browserversion = (DV.jQuery.browser.version) ? DV.jQuery.browser.version : 'undefined';
	var msg = 'DV.jQuery.browser.msie: ' + msie + ', DV.jQuery.browser.version: ' + browserversion;
	$( 'ol.breadcrumb' ).before( '<p>' + msg + '</p>' );

	var bie = (DV.jQuery.browser.msie) ? 'true' : 'false';
	$( 'ol.breadcrumb' ).before( '<p>DV.jQuery.browser.msie : ' + bie + '</p>' );

	var bv6 = (DV.jQuery.browser.version <= "6.0") ? 'true' : 'false';
	$( 'ol.breadcrumb' ).before( '<p>DV.jQuery.browser.version <= "6.0" : ' + bv6 + '</p>' );

	var combo = (DV.jQuery.browser.msie && DV.jQuery.browser.version <= "6.0") ? 'true' : 'false';
	$( 'ol.breadcrumb' ).before( '<p>browser_msie && browser_version <= "6.0" : ' + combo + '</p>' );

	var browser_msie = true;
	var browser_version = (DV.jQuery.browser.version <= 6.0);
	//var browser_msie = DV.jQuery.browser.msie;
	//var browser_version = DV.jQuery.browser.version;

	if (!(browser_msie && browser_version)){
		msg = 'passed test: ' + browser_msie + ' ' + browser_version;
	} else {
		msg = 'failed test: ' + browser_msie + ' ' + browser_version;
	}
	$( 'ol.breadcrumb' ).before( '<p>' + msg + '</p>' );
};

jnUtils.afterLoad = function(viewer){
	console.log('jnUtils.afterLoad fired');
	console.log('viewer obj', viewer);
	var imgEl = viewer.pageSet.pages.p0.pageImageEl;
	console.log('viewer imgEl', imgEl);
	// ---------- mutations --
	/*
	var mutationHandler = function(mutationRecords) {
		console.group('mutationHandler');
		mutationRecords.forEach ( function (mutation) {
			if (mutation.type == 'attributes') {
				var css = "color: purple;";
				console.log("%c mutation! %s", css, mutation.attributeName, mutation.oldValue);
				
			}
			//console.log('mutation:', mutation.type);
		} );
		console.groupEnd();
	};
	var observer = new MutationObserver( mutationHandler );
	// Notify me of everything!
	var observerConfig = {
		attributes: true,  
		attributeOldValue: true 
	};
	observer.observe(imgEl[0], observerConfig);
	*/
	// ---------- end mutations ------
	var el = '<div style="background:#FFFFFF;"><span id="jn-output-1">some stuff</span> <span id="jn-output-2">more stuff</span></div>';
	//viewer.elements.header.append(el);
	//viewer.events.jnObserver = jnUtils.observer;
	//viewer.api.viewer.helpers.addObserver('jnObserver');
	//var zmr = [500, 700, 800, 900, 1000, 1500, 2000];
	// get initial array of zoom sizes
	var ranges = viewer.models.document.ZOOM_RANGES;
	console.log('ZOOM_RANGES', ranges);
	// get dimension of last (largest) size
	var large = _.last(ranges);
	console.log('LARGE_WIDTH', large);
	// set this constant for use in size comparison by imageURL function
	viewer.models.pages.LARGE_WIDTH = large;
	// viewer.models.pages.LARGE_WIDTH = 1000;
	// console.log('viewer.models.document', viewer.models.document);
	// defer extendZoomRanges so it fires after autoZoomPage (which resets ZOOM_RANGES)
	_.defer(_.bind(jnUtils.extendZoomRanges, viewer, jnUtils.extendZoomValues));

	//viewer.models.document.ZOOM_RANGES = [500, 700, 800, 900, 1000, 1500, 2000];
	//---------------------------------------------------------------
	return;
	//---------------------------------------------------------------
	// viewer.models.pages.BASE_WIDTH = 800;
	// viewer.models.pages.BASE_HEIGHT
	// viewer.models.pages.SCALE_FACTORS   = {'500': 0.714, '700': 1.0, '800': 0.8, '900': 0.9, '1000': 1.0};
	// viewer.models.document.ZOOM_RANGES = [555, 777, 888, 999, 1000];
	
	//---------------------------------------------------------------
};

jnUtils.imageRatioInfoOutput = function(that) {
	var url  = that.viewer.schema.document.resources.page.image;
	var el = that.viewer.pageSet.pages.p0.pageImageEl;
	var img = el[0];
	//console.log( 'image  jQuery obj', el );
	//console.log( 'image  js obj', img);
	//return;
	var cssYellow = "color: yellow; font-style: italic";
	if ( !el.attr('src') ) {
		console.log( "%cimage info unavailable", cssYellow );
		return;
	}
	//var img = el[0];
	var w = img.naturalWidth;
	var h = img.naturalHeight;
	var r = h/w;
	//
	var ew = el.attr('width');
	var eh = el.attr('height');
	var er = eh/ew;
	//
	var pages = that.viewer.models.pages;
	var zl	= pages.zoomLevel;
	var bh	= pages.BASE_HEIGHT;
	var bw	= pages.BASE_WIDTH;
	var zf	= pages.zoomFactor();
	//var zf = zl / bw;
	//var scale = zf / previousFactor;
	var zw = zl;
	var zh = Math.round(zl * r);
	var zr = (Math.round(r*1000)/1000 == Math.round(er*1000)/1000);
	var data = {};
	data.desired = {
		'width' : zw,
		'height' : zh, 
		'ratio' : zr
	};
	data.display = {
		'width' : ew,
		'height' : eh, 
		'ratio' : er
	};
	data.natural = {
		'width' : w,
		'height' : h, 
		'ratio' : r
	};
	console.group();
	console.log( 'zoomLevel', zl, 'baseHeight', bh, 'baseWidth', bw, 'zoomFactor', zf );
	//console.table(data);
	console.log( 'image natural: ', 'width', w, 'height', h, 'ratio', r );
	console.log( 'image display: ', 'width', ew, 'height', eh, 'ratio', er );
	console.log( 'image desired: ', 'width', zw, 'height', zh, 'ratio', zr );
	if ( !zr ) {
		console.log( "%c Bad Ratio!!!!!!", cssYellow );
		return;
	}
	//console.log( that );
	console.groupEnd();
};
jnUtils.cssHeight = function(that) {
	var cssH = that.viewer.pageSet.pages.p0.pageImageEl.css('height');
	var atrH = that.viewer.pageSet.pages.p0.pageImageEl.attr('height');
	var css = "color: red; font-style: italic";
	console.log( "%ccurrent Height: CSS %s, attr %s", css, cssH, atrH );
	jnUtils.imageRatioInfoOutput(that);
};

// The zoom factor is the ratio of the image width to the baseline width.
jnUtils.zoomFactor = function() {
	return this.zoomLevel / this.BASE_WIDTH;
};

jnUtils.drawImageCounter = 0;

jnUtils.infoDump = function(that, i) {
	// getPageHeight()
	//		var realHeight = this.pageHeights[pageIndex];
	//		return Math.round(realHeight ? realHeight * this.zoomFactor() : this.height);
	var el = that.viewer.pageSet.pages.p0.pageImageEl;
	var img = el[0];
	var cssYellow = "color: yellow; font-style: italic";
	var cssRed = "color: red; font-style: italic";
	var cssGreen = "color: green; font-style: italic";
	if ( !el.attr('src') ) {
		console.log( "%c Image info unavailable", cssYellow );
		return;
	}
	var imgInfo = jnUtils.imageRatioInfo(that);
	if ( img.naturalWidth > 1000 ) {
		console.log( "%c image is big!!!!", cssRed, 'desired dimensions:', imgInfo.desired.width, 'X', imgInfo.desired.height );

		return;
	} 
	if ( img.naturalWidth < 1001 ) {
		console.log( "%c image is ok", cssGreen );
		return;
	}

// getPageHeight
	var obj = {};
	// that.height
	// that.width
	// that.zoomLevel
	// that.viewer
	obj.pageHeight		= that.viewer.models.pages.pageHeights[i];
	obj.zfCalc			= that.zoomLevel / that.BASE_WIDTH;
	obj.zoomFactor		= that.viewer.models.pages.zoomFactor();
	obj.realHeight		= obj.pageHeight;
	obj.zoomLevel		= that.zoomLevel;
	obj.baseHeight		= that.BASE_HEIGHT;
	obj.baseWidth		= that.BASE_WIDTH;
	obj.height			= that.height;
	obj.width			= that.width;
	obj.imgHeight		= img.height;
	obj.scale			= '';
	obj.getPageHeight	= Math.round(obj.realHeight ? obj.realHeight * obj.zoomFactor : obj.height);
	obj.updateHeight	= obj.imgHeight * (that.zoomLevel > that.BASE_WIDTH ? 0.7 : 1.0);
	obj.resizeW			= Math.round(that.baseWidth * that.zoomFactor());
	obj.resizeH			= Math.round(that.height * obj.scale);
	//var h = img.height;
	//			var z = this.zoomLevel > this.BASE_WIDTH ? 0.7 : 1.0;
	//			var calcH = h * z;
	// 
	// that.viewer.pageSet.pages.p0.coverEl.css({width: width, height: height});
	// this.pageImageEl.css({width: width, height: height});
	// this.el.css({height: height, width: width});
	// this.pageEl.css({height: height, width: width});
	console.log( 'infoDump', that, obj );

};
jnUtils.infoObj = {

	'pageHeight' : '',
	'zoomFactor' : '',
	'realHeight' : '',
	'zoomLevel' : '',
	'baseHeight' : '',
	'baseWidth' : '',
	'height' : '',
	'width' : '',
	'imgHeight' : '',
	'scale' : '', 
	'getPageHeight' : '',
	'updateHeight' : '',
	'resizeW' : '',
	'resizeH' : ''
	//var h = img.height;
	//			var z = this.zoomLevel > this.BASE_WIDTH ? 0.7 : 1.0;
	//			var calcH = h * z;
	// 
	// that.viewer.pageSet.pages.p0.coverEl.css({width: width, height: height});
	// this.pageImageEl.css({width: width, height: height});
	// this.el.css({height: height, width: width});
	// this.pageEl.css({height: height, width: width});

};
jnUtils.imageRatioInfo = function(that) {
	var el = that.viewer.pageSet.pages.p0.pageImageEl;
	var img = el[0];

	var w = img.naturalWidth;
	var h = img.naturalHeight;
	var r = h/w;
	//
	var ew = el.attr('width');
	var eh = el.attr('height');
	var er = eh/ew;
	//
	var pages = that.viewer.models.pages;
	var zl	= pages.zoomLevel;
	var bh	= pages.BASE_HEIGHT;
	var bw	= pages.BASE_WIDTH;
	var zf	= pages.zoomFactor();
	//var zf = zl / bw;
	//var scale = zf / previousFactor;
	var zw = zl;
	var zh = Math.round(zl * r);
	var zr = (Math.round(r*1000)/1000 == Math.round(er*1000)/1000);
	var data = {};
	data.natural = {
		'width' : w,
		'height' : h, 
		'ratio' : r
	};
	data.display = {
		'width' : ew,
		'height' : eh, 
		'ratio' : er
	};
	data.desired = {
		'width' : zw,
		'height' : zh, 
		'ratio' : zr
	};
	return data;
};
jnUtils.getRatio = function(el) {
	var img = el[0];

	var w = img.naturalWidth;
	var h = img.naturalHeight;
	var r = h/w;
	return r;
};
jnUtils.getImgInfo = function(src) {
	var image = new Image();
	image.src = $(this).attr("src");
	return {
		'w' : image.naturalWidth,
		'h' : image.naturalHeight,
	};
};
jnUtils.imgIndex = [];
jnUtils.addImage = function(i, src) {
	var image = new Image();
	image.src = $(this).attr("src");
	var img = {};
	img.h = image.naturalHeight;
	img.w = image.naturalWidth;
	img.src = src;
	jnUtils.imgIndex[i] = img;
};
jnUtils.trimSrc = function(src) {
	var arr = src.split('/');
	return arr[arr.length - 1];
};

  // Resize the cover.
  // this.el.find('div.DV-cover');
 // this.coverEl.css({width: width, height: height});

  // Resize the image.
//  this.pageImageEl.css({width: width, height: height});

  // Resize the page container.
//  this.el.css({height: height, width: width});

  // Resize the page.
//  this.pageEl.css({height: height, width: width});
