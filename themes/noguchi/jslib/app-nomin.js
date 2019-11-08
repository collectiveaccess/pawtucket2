// @codekit-append 	"../../../assets/js/app.js";


// @codekit-append 	"_pajax.js";
// @codekit-append 	"_effex.js";
// @codekit-append 	"_widgets.js";
// @codekit-append 	"_main.js";

var PAJX;

(function( $ ) {

	// global vars helpers
	var $html, $body, $window, baseURL, M;

	var defaults = {
		fade_out: 0.2,
		fade_in: 0.4
	};

	PAJX = {

		init: function( main, options ){
			//console.log( 'PAJX.init' );
			this.options = $.extend({}, defaults, options);

			$window = $(window);
			$html = $('html');
			$body = $('body');
			baseURL = window.location.origin;

			M = main; // main controller

			this.state = '';
			this.view = {
				isView: false,
				$a: '',
				$view: ''
			};

			// Personalize the Barba Link Prevent check!
			Barba.Pjax.originalPreventCheck = Barba.Pjax.preventCheck;
			Barba.Pjax.preventCheck = function(evt, element) {
                if (!Barba.Pjax.originalPreventCheck(evt, element)) {
                    return false;
                }
                // Don't cache CollectiveAccess Lighbox links
				if ( $(element).attr( 'href' ).indexOf( 'Lightbox' ) >= 0 ){
					return false;
				}
                // Don't cache CollectiveAccess links
                if ((window.location.hostname == 'noguchi.whirl-i-gig.com') || (window.location.hostname == 'archive.noguchi.org') || (window.location.hostname == 'noguchi')){
                    return false;
                }
                // Don't cache PDF links
                if (/.pdf/.test(element.href.toLowerCase())) {
                    return false;
                }
                // Add no-barba for links inside an iframe (Presentation)
                // if ( PAJX._inIframe() ) {
                //     if ( $(element).attr( 'href' ).indexOf( '?is_iframe' ) === -1 ){
                //         $(element).attr( 'href' , $(element).attr( 'href' ) + '?is_iframe' );
                //     } 
                //     return false;
                // }
                return true;
			};


			// BARBA EVENTS
			Barba.Dispatcher.on( 'linkClicked', function( el, e ){
				if ( $(el).hasClass( 'barba-view' ) ){
					PAJX.view = {
						isView: true,
						$a: $(el),
						viewClass: $(el).attr( 'data-view' )
					}
				}
				else{
					PAJX.view.isView = false;
				}
				$window.trigger( 'pajax:linkClicked' );
			});
			Barba.Dispatcher.on('initStateChange', function(currentStatus, oldStatus, container){
				// if it's not the first load ...
				if ( !$.isEmptyObject(oldStatus) ){
					PAJX.updateGA();
					$window.trigger( 'pajax:initStateChange' );
				}
				
			});
			Barba.Dispatcher.on('newPageReady', function(currentStatus, oldStatus, container) {
				// if it's not the first load ...
				if ( !$.isEmptyObject(oldStatus) ){
					//PAJX.parseResponse();
					$window.trigger( 'pajax:newPageReady' );
				}
				
			});
			Barba.Dispatcher.on('transitionCompleted', function(currentStatus, oldStatus) {
				// if it's not the first load ...
				if ( !$.isEmptyObject(oldStatus) ){
					$window.trigger( 'pajax:transitionCompleted' );
				}				
			});

			// define transitions before init
			this.setTransitions();

			// BARBA INIT
			Barba.Pjax.start();
			Barba.Prefetch.init();

            // Added for CA
            // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
            $window.trigger( 'pajax:init' );

		    setTimeout( function(){
		    	PAJX._cleanAdminURL();
		    }, 2000 );
		},

	    _inIframe : function() {
	        try {
	            return window.self !== window.top;
	        } catch (e) {
	            return true;
	        }
	    },

		_cleanAdminURL: function(){
			// clean all the WP admin url if user logged in!!!
			var $a, $adminbar = $('#wpadminbar');
			if ( $adminbar.length > 0 ){
				$adminbar.find('a').addClass( 'no-barba' );
			}
		},

		parseResponse: function(){
			var html, parser, doc, bodyClass;

		    html = Barba.Pjax.Dom.currentHTML;
			parser = new DOMParser();
		    doc = parser.parseFromString( html, "text/html");
		    bodyClass = doc.body.getAttribute('class');

		    this.changeBodyClass( bodyClass );
		    this._cleanAdminURL();
            // Update the nav state
            // $('ASIDE').html(($(html).find('ASIDE')));
		    // Garbage collection, you don't need this anymore.
		    html = parser = doc = null;
		    $window.trigger( 'pajax:parsedResponse' );
		},

		// set body class
		changeBodyClass: function( bodyClass ){
			$body.attr( 'class', bodyClass );
		},

		setTransitions: function(){
			var FadeTransition = Barba.BaseTransition.extend({
			  start: function() {
			    /*
			     * This function is automatically called as soon the Transition starts
			     * this.newContainerLoading is a Promise for the loading of the new container
			     * (Barba.js also comes with an handy Promise polyfill!)
			    */
			    // As soon the loading is finished and the old page is faded out, let's fade the new page
			    Promise
			      .all([this.newContainerLoading, this.fadeOut()])
			      .then(this.fadeIn.bind(this));
			  },
			  fadeOut: function() {
			    /**
			     * this.oldContainer is the HTMLElement of the old Container (or the view)
			     */
				var deferred = Barba.Utils.deferred();
				var $container = PAJX.view.isView ? $( '.' + PAJX.view.viewClass ) : $(this.oldContainer);
				TweenMax.to( $container , PAJX.options.fade_out , { opacity: 0, 
					ease: 'Expo.easeOut',
					onComplete: function(){
						deferred.resolve();
						$window.trigger( 'pajax:EndfadeOut' );
					} 
				} );
				return deferred.promise;
  			  },
			  fadeIn: function() {
			    /**
			     * this.newContainer is the HTMLElement of the new Container (or the view)
			     * At this stage newContainer is on the DOM (inside our #barba-container and with visibility: hidden)
			     * Please note, newContainer is available just after newContainerLoading is resolved!
			     */
			    var _this = this;
			    var $el = $(this.newContainer);
			    if ( PAJX.view.isView ){
			    	$( '.' + PAJX.view.viewClass ).css({
			    		opacity: 0
			    	});
			    }
			    $el.css({
			      visibility : 'visible',
			      opacity : PAJX.view.isView ? 1 : 0
			    });
			    $(this.oldContainer).hide();
			    _this.done();

			    $window.trigger( 'pajax:EndfadeIn' );
			    /*
				TweenMax.to( $el, 1.4, { opacity: 1,
					ease: 'Expo.easeOut',
					onComplete: function(){
						_this.done();
						TweenMax.set( $el, { clearProps: 'all' });
						$window.trigger( 'pajax:EndfadeIn' );
				} } );
				*/
			  }
			});
			/*
			 * Next step, you have to tell Barba to use the new Transition
			 */
			Barba.Pjax.getTransition = function() {
			  /*
			   * Here you can use your own logic!
			   * For example you can use different Transition based on the current page or link...
			   */
			  return FadeTransition;
			};		
		},

		fadeInFromExt: function(){
			//console.log( 'PJAX.fadeInFromExt' );
			var $el = $( '.' + Barba.Pjax.Dom.containerClass );
			if ( PAJX.view.isView ){
				$el = $( '.' + PAJX.view.viewClass );
			}
			TweenMax.to( $el, PAJX.options.fade_in, { opacity: 1,
				ease: 'Expo.easeOut',
				onComplete: function(){
					TweenMax.set( $el, { clearProps: 'all' });
					$window.trigger( 'pajax:EndfadeInFromExt' );
			} } );
		},

		updateGA: function(){
			var ga = window.ga,
			currentURL = Barba.Pjax.getCurrentUrl(),
			relativeUrl = window.location.pathname; //currentURL.replace( baseURL, '');
			//console.log( 'PAJX.updateGA, page = ' + relativeUrl );
			// Inform Google Analytics of the change
			if ( typeof ga !== 'undefined' ){				
				ga('set',  'page', relativeUrl );
				ga('send', 'pageview');
			}			
		},

		getCurrentHTML: function(){
			return Barba.Pjax.Dom.currentHTML;
		},

		triggerView: function( url, viewClass ){
			PAJX.view = {
				isView: true,
				$a: undefined,
				viewClass: viewClass
			}
			Barba.Pjax.goTo( url );
		},

		triggerURL: function( url ){
			PAJX.view = {
				isView: false,
				$a: undefined,
				viewClass: ''
			}
			Barba.Pjax.goTo( url );
		}
	};

})( jQuery );


//var console = window.console;
var ScrollMagic = window.ScrollMagic ; 
var TweenMax = window.TweenMax;


var EFFX;

(function(window,undefined){	
	// Prepare our Variables
	var $ = window.jQuery, 
		$win = $(window),
		$doc = $(document),
		$html = $('html'),
		$body = $('body'),
		$bgHeader = $('#bg-header'), $bgSubmenu = $('#bg-submenu'),
		scenes = [],
		pageController,
		s, 
		$el,
		$els,
		$v,
		parallaxs, 
		tween, 
		maxScroll;

	EFFX = {

		init: function( options ){			

			var defaults = {
			};
			this.options = $.extend({}, defaults, options);

			this.destroy();

			// init controller
			pageController = new ScrollMagic.Controller({
				// addIndicators: true
			});
			scenes = [];
			this.addEvents( true );

			// generals
            this.initStickyNavHeader();
            this.initPageNav();
			this.initTriggerInView();
            this.initFixedPins();

            if ( $body.hasClass( 'home' ) ){
            	EFFX.initHomePage();
            }

            //--------- ALL BIOGRAPHY PAGE -----------------------------//.
            if ( $body.hasClass( 'parent-pageid-12' ) ){

            	//----------- give some delay, poor ie11! -------------//
            	if ( $html.hasClass( 'ie11' ) ){
	            	// biography
	            	setTimeout( function(){
	            		EFFX.initLayoutTwoColumnsFixedLeft();
	            	}, 2000 );

            	}
            	else{
	            	EFFX.initLayoutTwoColumnsFixedLeft();            		
            	}
            }

            // browse pages
       		/*
            if ( $('main').hasClass( 'cr_browse' ) || $('main').hasClass( 'archive_landing' ) ){
            	this.initStickyNav()
            }
			*/
		},

		addEvents: function( b ){
			if ( b ){
				this.r = _.debounce( EFFX.onResize, 200 );
				$win.on( 'resize', this.r );
			}
			else{
				if ( this.r ){
					this.r.cancel();
					$win.off( 'resize', this.r );
				}
			}
		},

		onResize: function(){

			//console.log( "EFFX.onResize" ); 
			// re-init effect on resize (so all the effects get refresh with new browser size)
			if ( $body.hasClass( 'home' ) ){
				// TweenMax.to( $win, 0, {scrollTo:0} );
			}
			
			EFFX.init();

			/*
			EFFX.destroy();
			setTimeout( function(){
				// we add a timeout to re-calculate after destroy 
				EFFX.init();
			}, 171 );
			*/
		},

		getMaxScroll: function(){
			maxScroll = $doc.height() - $win.height();
			return maxScroll;
		},


	  	//----------------------------------- GENERAL OVERALL -----------------------------------------//

        //----------------------------------- PAGE SPEFICIC ------------------------------------------//
        initHomePage: function(){

			if ( $win.height() < EFFX.getMinHeight() ){
				$html.addClass( 'min-height' )
			}
			else{
				$html.removeClass( 'min-height' )
			}

        	var $col, $scroll, $frame, dir, offset, img_height;

			// add scene
			$col = 		$( '#to-be-fixed' );
			$scroll = 	$( '#to-be-scroll' );
			$frame 	=	$col.find( '.frame' );

			//console.log( $frame.height() );

			//d = 		$scroll.height() - ($win.height() - ($win.width() <= 1024 ? $('#header-mobile').outerHeight():$('#main-header').height()) ); //$col.height();
			img_height 	= 	Math.max( parseInt( $frame.css( 'min-height' ) ), $frame.height() ); // min height is 900
			d 			=   $scroll.height() - img_height;
			offset 		= 	img_height - $win.height();

			//console.log( $scroll.height() + ',' + img_height );
			//console.log( offset );

			s = new ScrollMagic.Scene({
				triggerElement: $col,
				triggerHook: 'onLeave',
				duration: d + 'px',
				offset: offset
				//offset: - ($win.width() <= 1024 ? $('#header-mobile').outerHeight() : $('#main-header').height())
			});
			s.on("end", function (e) {
				dir = e.target.controller().info("scrollDirection");
				if ( dir === 'FORWARD' ){
					// activate hide nav on scrolling
					$( 'html' ).addClass( 'interactive-nav' );
				}
				if ( dir === 'REVERSE' ){
					// activate hide nav on scrolling
					$( 'html' ).removeClass( 'interactive-nav' );
				}
			});
			s.setPin( $col.find( '.home-main-promo' ) );
			//s.addIndicators();
			s.addTo( pageController );
			/*
			$('#logo').on( 'mouseover', function(){
				if ( $( 'html' ).hasClass( 'interactive-nav' ) ){
					$( 'html' ).removeClass( 'menu-hide' );
				}
			} );
			*/

			//------------------------ home bg parallax -----------------------------//
			$el = $('section.background .img-wrapper');
			s = new ScrollMagic.Scene({
				triggerElement: $('#trigger-bg-parallax'),
				triggerHook: 'onEnter',
				duration: parseInt($( '.page-promos' ).css('margin-bottom')) + $('.shop-promos').height() + $('#footer').height()  //'110%'
			});
			s.setTween( TweenMax.fromTo( $el, 1, {y:$win.height()/5},{y:0} ) );
			//s.addIndicators();
			s.addTo( pageController );


			 $('section.background').css({
			 	'visibility': 'visible'
			 })
        },

        getMinHeight: function(){
        	return 900;
        },

        initStickyNavHeader: function(){

        	var sticky_nav_secondary = $('.module_page_section_nav.page-nav-fixed').length > 0;

        	if ( !sticky_nav_secondary ){

        		//if ( $win.height() > 900 ){

					// main header
					$el = $('#main-header');
					s = new ScrollMagic.Scene({
						triggerElement: $el,
						triggerHook: 'onLeave',
						offset: 1
						//offset: $body.hasClass( 'home' ) ? 0 : $el.height()
					});
					s.on("update", function (e) {
						var $this = $( e.currentTarget.triggerElement() ), $spacer = $this.parent();
						// update top
						if ( $spacer.hasClass( 'scrollmagic-pin-spacer' ) ){
							$this.css({
							    width: '100%'
							});
						}
						dir = e.target.controller().info("scrollDirection");

						if ( e.scrollPos >= EFFX.getMaxScroll() ){
						}
						if ( $( 'html' ).hasClass( 'interactive-nav' ) ){
							if ( dir === 'FORWARD' ){
								$( 'html' ).addClass( 'menu-hide' );
							}
							else{
								$( 'html' ).removeClass( 'menu-hide' );
							}
						}
					});
					s.on("start", function (e) {
						if ( $body.hasClass( 'home' ) ){
							if ( $win.height() > EFFX.getMinHeight() ){
								return;
							}
						}
						else{
							$('#main-header').css({
								//top: 110
							})
						}
						dir = e.target.controller().info("scrollDirection");
						if ( dir === 'FORWARD' ){
							// activate hide nav on scrolling
							$( 'html' ).addClass( 'interactive-nav' );
						}
						if ( dir === 'REVERSE' ){
							// activate hide nav on scrolling
							$( 'html' ).removeClass( 'interactive-nav' );
						}
					});
					s.on("end", function (e) {
						//console.log( 'end' );
						//console.log( dir );
					});
					s.setPin( $el );
					s.addTo( pageController );

				//}
			}

			// header mobile
			$el = $('#header-mobile');
			s = new ScrollMagic.Scene({
				triggerElement: $el,
				triggerHook: 'onLeave'
			});
            s.on("update", function (e) {
              var $this = $( e.currentTarget.triggerElement() ), $spacer = $this.parent();
              // update top
              if ( $spacer.hasClass( 'scrollmagic-pin-spacer' ) ){
                $this.css({
                    width: '100%'
                });
              }
            });
			s.setPin( $el );
			s.addTo( pageController );
        },

        initPageNav: function(){
        	$el = $('.module_page_section_nav');
            if ( $el.length > 0 ){
            	if ( $el.hasClass( 'page-nav-fixed' ) ){
	                s = new ScrollMagic.Scene({
	                  triggerHook: "onLeave",
	                  triggerElement: $el,
	                });
	                s.on("update", function (e) {
	                  var $this = $( e.currentTarget.triggerElement() ), $spacer = $this.parent();
	                  // update top
	                  if ( $spacer.hasClass( 'scrollmagic-pin-spacer' ) ){
	                    $this.css({
	                        width: '100%'
	                    });
	                    $spacer.css({
	                    	'z-index' : 17
	                    })
	                  }
	                });
	                s.setPin( $el );
	                s.addTo( pageController );  
            	}
            }             
        },

        initStickyNav: function(){
        	$el = $('.ca_nav');
            if ( $el.length > 0 ){
                s = new ScrollMagic.Scene({
                  triggerHook: "onLeave",
                  triggerElement: $el,
                });
                s.on("update", function (e) {
                  var $this = $( e.currentTarget.triggerElement() ), $spacer = $this.parent();
                  // update top
                  if ( $spacer.hasClass( 'scrollmagic-pin-spacer' ) ){
                    $this.css({
                        width: '100%'
                    });
                  }
                });
                s.setPin( $el );
                s.addTo( pageController );  
            }        
        },

        initLayoutTwoColumnsFixedLeft: function(){
        	$el = $( '.layout-two-cols-fixed-left' );
            if ( $el.length > 0 ){

	        	var $imgs = $el.find( '.col-images' ), $t, $img, $text = $el.find( '.col-text' ), $img_sizer = $imgs.find( '.img-sizer' ), h_imgs, h, h_text, h_nav, $years_nav;

            	// we have to alculate it before the main pin!
            	h_imgs 	= $imgs.height();
            	h 		= $img_sizer.outerHeight();
            	h_text 	= $text.outerHeight();
            	h_nav	= $('.module_page_section_nav').outerHeight();

            	// pin col images
            	var args ={
                  triggerHook: "onLeave",
                  triggerElement: $imgs,
                  offset: - h_nav
            	}
            	if ( $el.hasClass( 'image-fade-on-scroll' ) ){
            		args.duration = $doc.height()  - ( $win.height() + $('#footer').height() + $('.module_page_section_nav').offset().top );
            	}
                s = new ScrollMagic.Scene( args );
                s.on("update", function (e) {
                  var $this = $( e.currentTarget.triggerElement() ), $spacer = $this.parent();
                  // update top
                  if ( $spacer.hasClass( 'scrollmagic-pin-spacer' ) ){
                    $this.css({
                        width: '100%'
                    });
                    $spacer.height(  $this.height() );
                  }
                });
                s.setPin( $imgs );
                //s.addIndicators();
                s.addTo( pageController );

                //--------------- BIOGRAPHY PAGE --------------------//
                if ( $el.hasClass( 'image-fade-on-scroll' ) ){

	                $el.find( '.text-section' ).each(function(i){
	                	if ( i > 0 ){
	                		$t = $(this);
	                		$img = $imgs.find( '.img-sizer .img-wrapper:eq(' + i +')' );
			                s = new ScrollMagic.Scene({
			                  triggerHook: "onEnter",
			                  triggerElement: $t,
			                  duration: '15%',
			                  offset: -  h_nav
			                });
			                s.setTween( TweenMax.to( $img, 1, {opacity:1} ) );
                            //s.addIndicators();
			                s.addTo( pageController );
	                	}
	                });                	
                }

                //--------------- CHRONOLOGY PAGE --------------------//
                if ( $el.hasClass( 'col-scroll-different-speed' ) ){
        
                	//console.log( h_imgs + ',' + h + ',' + h_text );
                	//console.log( h_text );

                	/*
	                s = new ScrollMagic.Scene({
	                  triggerHook: "onLeave",
	                  triggerElement: $imgs,
	                  offset: - $('.module_page_section_nav').outerHeight(), // 55px
	                  duration: h_text + $('.module_page_section_nav').outerHeight() + 240
	                });
	                s.setTween( TweenMax.to( $img_sizer, 1, { y: -h } ) );
	                s.addIndicators();
	                s.addTo( pageController );
					*/
					

	                s = new ScrollMagic.Scene({
	                  triggerHook: "onLeave",
	                  duration: ( $text.offset().top + h_text + $('#footer').height() - $win.height() )
	                });
	                s.setTween( TweenMax.to( $img_sizer, 1, {y:  - h + h_imgs - $('#footer').height(), ease: 'Linear.easeNone' } ) );
	                //s.addIndicators();
	                s.addTo( pageController );

	                //------------------ pin the nav if any -------------------------//
	                $years_nav = $('#aside');
	                if ( $years_nav.length > 0 ){
                		
                		s = new ScrollMagic.Scene( {
		                  triggerHook: "onLeave",
		                  triggerElement: $years_nav,
		                  offset: - h_nav
		            	} );
		                s.setPin( $years_nav );
		                s.addTo( pageController );

		                // ----------------- nav ------------------------------------//
		                $years_nav.find( 'a' ).on( 'click', function(e){
		                	e.preventDefault();
		                	var i = $(this).attr( 'data-index' ), $years;
		                	$years = $('.text-section .years[data-index="' + i + '"]');
		                	if ( $years.length > 0 ){
		                		TweenMax.to( $win, 0.6, {scrollTo: i === '0' ? 0 : $years.offset().top - 160, ease:'Sine.easeOut'});
		                	}
		                } );

	                }
                }
            }           	
        },


        initFixedPins: function() {
            $el = $('.pin-fixed'); var o;
            if ( $el.length > 0 ){

            	o = {
                  triggerHook: "onLeave",
                  triggerElement: $el,
                  offset: $el.attr('data-offset') ? - parseInt( $el.attr('data-offset') ) : 0
                };

                // for the digital feature drawer we unpin when the footer is visible (So it doesn't overlap)
	            if ( $el.attr('id') === 'digital-features-drawer' ){
	            	o.duration = $doc.height() - ( $win.height() + $('#footer').height() + $el.offset().top );
	            }

                s = new ScrollMagic.Scene(o);
                s.on("update", function (e) {
                  var $this = $( e.currentTarget.triggerElement() ), $spacer = $this.parent();
                  // update top
                  /*
                  if ( $spacer.hasClass( 'scrollmagic-pin-spacer' ) ){
                    $this.css({
                        width: '100%'
                    });
                  }
                  */

                });
                s.setPin( $el );
                s.addTo( pageController );  
            }

        },

		//----------------------------------- UTILS -----------------------------------------//
		initTriggerInView: function(){
	      $els = $('.trigger-in-view');
	      if ( $els.length > 0 ){
            //console.log('initTriggerInView');
	        $els.each( function(i){
	          
              $el = $( this );
	          s = new ScrollMagic.Scene({
	            triggerHook: "onEnter",
	            triggerElement: $el,
	            duration: EFFX.calculateDurationScene( $el )
	          });

              s.on("enter", function(e){
                //console.log('enter');
                var $this = $( e.currentTarget.triggerElement() );
                $this.addClass( 'in-view' );
                $this.trigger( 'event-in-view' );
                var $videos = $this.find( '.video-ctrl' );
                if ( $videos.length > 0 ){
                  $videos.video_ctrl( 'triggerEvent', e );
                }
              });
	          
              s.on("leave", function(e){
                // check if there is a video and send messages
                var $this = $( e.currentTarget.triggerElement() );
                $this.removeClass( 'in-view' );
                $this.trigger( 'event-off-view' );
                var $videos = $this.find( '.video-ctrl' );
                if ( $videos.length > 0 ){
                  $videos.video_ctrl( 'triggerEvent', e );
                }
              });

              
              if ( $el.hasClass( 'trigger-once' ) ){
	          	s.on("enter", function(e){
	          		var $this = $( e.currentTarget.triggerElement() );
	          		$this.addClass( 'in-view' );
	          	});
	          }
	          else{
		          s.setClassToggle( $el, 'in-view' );
		          s.on("enter leave", function(e){
		            var $this = $( e.currentTarget.triggerElement() );
		            if( e.type === 'enter' ){
		              $this.removeClass( 'transition-reverse' );
		              if ( e.scrollDirection !== 'REVERSE' ){                
		              }
		              else{
		              }
		            }
		            else{
		              // LEAVE !!!!!!!!!
		              if ( e.scrollDirection === 'FORWARD' ){
		                $this.addClass( 'transition-reverse' );
		              }              
		            }
		            // check if there is a video and send messages
		            var $videos = $this.find( '.video-ctrl' );
		            if ( $videos.length > 0 ){
		              $videos.video_ctrl( 'triggerEvent', e );
		            }
		          });
	          }
              

	          s.addTo( pageController );
	          scenes[i] = {
	            $it: $el,
	            scene: s,
	            type: 'trigger-in-view'
	          };

	        });

	        $els.imagesLoaded(function(){
	        	EFFX.refreshScenes();
	        });
			$doc.on('lazybeforeunveil', function(e){
	        	EFFX.refreshScenes();
			});

	      }
		},
	    calculateDurationScene: function( $it ){
	      var h = $win.height();
          // return $it.height() - 200;
          return h + $it.height();
	    },
	    refreshScenes: function(){
	      if ( scenes ){
	        var i = scenes.length, s;
	        while( i-- ){
	          s = scenes[i];
	          if ( s.type === 'trigger-in-view' ){
		          s.scene.duration( this.calculateDurationScene( s.$it ) );
	          }
	        }
	      }
	    },

		destroy: function(){
	      if ( pageController ){
	        pageController = pageController.destroy( true ); // return null for the garbage collection
	        if ( scenes ){
	          scenes = [];
	        }
	      }
	      this.addEvents( false );
	      $html.removeClass( 'interactive-nav' ).removeClass( 'menu-hide' );
		}
		
	}; // EFFX

})(window); // end closure

// http://paulirish.com/2011/requestanimationframe-for-smart-animating/
// http://my.opera.com/emoller/blog/2011/12/20/requestanimationframe-for-smart-er-animating

// requestAnimationFrame polyfill by Erik Möller. fixes from Paul Irish and Tino Zijdel

// MIT license

(function() {
    var lastTime = 0;
    var vendors = ['ms', 'moz', 'webkit', 'o'];
    for(var x = 0; x < vendors.length && !window.requestAnimationFrame; ++x) {
        window.requestAnimationFrame = window[vendors[x]+'RequestAnimationFrame'];
        window.cancelAnimationFrame = window[vendors[x]+'CancelAnimationFrame'] 
                                   || window[vendors[x]+'CancelRequestAnimationFrame'];
    }
 
    if (!window.requestAnimationFrame)
        window.requestAnimationFrame = function(callback, element) {
            var currTime = new Date().getTime();
            var timeToCall = Math.max(0, 16 - (currTime - lastTime));
            var id = window.setTimeout(function() { callback(currTime + timeToCall); }, 
              timeToCall);
            lastTime = currTime + timeToCall;
            return id;
        };
 
    if (!window.cancelAnimationFrame)
        window.cancelAnimationFrame = function(id) {
            clearTimeout(id);
        };
}());


// //****************** LINE CLAMP *****************************************************************
;(function ($, window, document, undefined) {
    'use strict';

    var pluginName = "line_clamp";
    var defaults = {
        lines: 2
    };

    function Plugin(element, options) {
        this._name = pluginName;
        this.options = $.extend({}, defaults, options);
        this.element = element;
        this._init();
    }
    Plugin.prototype = {

        // private methods //////////////////////////////////////////////////////////////////////////
        _init: function (){
            
            var _this   = this;
            var _lines  = $(_this.element).data('lines') || _this.options.lines;

            $clamp(_this.element, {clamp: _lines});

        },

        // public methods //////////////////////////////////////////////////////////////////////////

        destroy: function(){
            $.data(this, 'plugin_' + pluginName, null);
        }

    };

    $.fn[pluginName] = function ( options ) {
      var args = arguments;
      if (options === undefined || typeof options === 'object') {
          return this.each(function () {
              if (!$.data(this, 'plugin_' + pluginName)) {
                  $.data(this, 'plugin_' + pluginName, new Plugin( this, options ));
              }
          });
      } else if (typeof options === 'string' && options[0] !== '_' && options !== 'init') {
          var returns;
          this.each(function () {
              var instance = $.data(this, 'plugin_' + pluginName);
              if (instance instanceof Plugin && typeof instance[options] === 'function') {
                  returns = instance[options].apply( instance, Array.prototype.slice.call( args, 1 ) );
              }
              if (options === 'destroy') {
                $.data(this, 'plugin_' + pluginName, null);
              }
          });
          return returns !== undefined ? returns : this;
      }
    };

})(jQuery, window, document);



//****************** OPTIONS FILTER *****************************************************************//
;(function ($, window, document, undefined) {
    'use strict';

    var pluginName = "options_filter";
    var defaults = {
    };

    function Plugin(element, options) {
        this._name = pluginName;
        this.options = $.extend({}, defaults, options);
        this.element = element;
        
        this._init();
    }
    Plugin.prototype = {

        // private methods //////////////////////////////////////////////////////////////////////////
        _init: function (){
            var _this = this, $a, $o;

            this.$el = $(this.element);
            this.$win = $(window);

            this.$options = this.$el.find( '.option_values' );
            this.$options.css('display','block');
            this.$arrow = this.$el.find( '.arrow' );
            this.height_open = this.$options.height() - this.$arrow.height();
            this.filters = [];
            this.index = -1;
            
            // init elements
            this.$el.find( '.options a' ).each( function(i){
                $a = $(this);

                // btns
                $a.data( 'open', false );
                $a.data('data-index', i );

                // options
                $o = _this.$options.find( '.ul-options[data-values="' + $a.attr( 'data-option' ) + '"]' );
                // vertically center if the height of the options is ledd then the height of open
                if ( $o.height() < _this.height_open - 40 ){ // minus padding-top and bottom
                    $o.css({
                        'padding-top' : (_this.height_open - 40 - $o.height() )/2
                    })
                }
                $o.css({
                    display: 'none',
                    opacity: 0
                });

                // store elements
                _this.filters[i] = {
                    $btn: $a,
                    $options: $o
                };
            });

            // set closed
            this.$options.slideUp(0);
            this.open = false;

            this._addEvents(true);
        },

        _addEvents:function(b){
            var _this = this, i, f;

            // click btns
            for( i=0; i<this.filters.length; i++){
                f = this.filters[i];
                if ( b ){
                    f.$btn.on( 'click', function(e){
                        e.preventDefault();
                        _this._toggleFilter( $(this).data( 'data-index' ) );
                    });
                }
                else{
                    f.$btn.off( 'click' );
                }
            }

            // click outside to close
            if ( b ){
                // Add a clickout listener
                this.$el.find('.options a, .option_values').on('clickout', function (e) {
                    _this._close()
                })
            }
            else{
                this.$el.find('.options a, .option_values').off('clickout');
            }

            this._debounceResize(b);
        },

        _debounceResize: function(b){
          var _this = this;
          if ( b ){
            // debounce resize
            this._debResize = _.debounce( function(){
              _this._onResize();
            }, 117 );
            this.$win.on( 'resize', this._debResize );
          }
          else{
            if ( this._debResize ){
              this._debResize.cancel();
              this.$win.off( 'resize', this._debResize );
            }        
          }
        },

        _onResize: function(){

            var _this = this, f, x;

            // calculate position of arrow reltive of filter selected
            if ( this.open ){

                if ( this.index !== - 1 ){
                    f = this.filters[this.index];
                    x = f.$btn.offset().left + f.$btn.width()/2 - this.$arrow.width()/2  + parseInt( this.$el.find( '.wrap' ).css('margin-left') )/2;
                    this.$arrow.css({
                        left: x
                    })                    
                }

            }
        },

        _toggleFilter: function( i ){
            //console.log( '_toggleFilter, i = ' + i );
            var _this = this, i, j, f, x;
            
            for ( j = 0; j<this.filters.length; j++ ){
                f = this.filters[j];
                if ( j === i ){
                    f.$options.css({
                        display: 'block'
                    });
                    TweenMax.to( f.$options, 0.3, {opacity:1, ease:'sine.easeOut'} );
                }
                else{
                    f.$options.css({
                        display: 'none',
                        opacity: 0
                    });
                    f.$btn.data( 'open', false );
                    f.$btn.removeClass( 'is-open' );
                }
            }

            f = this.filters[i];

            if ( f.$btn.data( 'open' ) ){
                this._openFilters( false );
                this.index = -1;
                f.$btn.removeClass( 'is-open' );
            }
            else{
                this._openFilters( true );
                this.index = i;
                f.$btn.addClass( 'is-open' );                

                // position the arrow
                this._onResize();

            }
            f.$btn.data( 'open', !f.$btn.data( 'open' ) );         
        },

        _openFilters: function(b){
            if ( b ){
                this.$options.slideDown(233);
            }
            else{
                this.$options.slideUp(133);
            }
            this.open = b
        },

        _close: function(){
            if ( this.open && this.index !== - 1 ){
                this.filters[this.index].$btn.click();
            }
        },

        // public methods //////////////////////////////////////////////////////////////////////////
        destroy: function(){
            this.$el.removeData();
            this._addEvents( false );
            $.data(this, 'plugin_' + pluginName, null);
        }

    };

    $.fn[pluginName] = function ( options ) {
      var args = arguments;
      if (options === undefined || typeof options === 'object') {
          return this.each(function () {
              if (!$.data(this, 'plugin_' + pluginName)) {
                  $.data(this, 'plugin_' + pluginName, new Plugin( this, options ));
              }
          });
      } else if (typeof options === 'string' && options[0] !== '_' && options !== 'init') {
          var returns;
          this.each(function () {
              var instance = $.data(this, 'plugin_' + pluginName);
              if (instance instanceof Plugin && typeof instance[options] === 'function') {
                  returns = instance[options].apply( instance, Array.prototype.slice.call( args, 1 ) );
              }
              if (options === 'destroy') {
                $.data(this, 'plugin_' + pluginName, null);
              }
          });
          return returns !== undefined ? returns : this;
      }
    };

})(jQuery, window, document);

//****************** SLIDESHOW CTRL *****************************************************************//
;(function ($, window, document, undefined) {
  'use strict';

  var pluginName = "slideshow_ctrl";

  var defaults = {
    arrows: false,
    autoplay: false,
    dots: true,
    autosize: false,
    slidesToShow: 1,
    slidesToScroll: 1,
    fade: true,
    cssEase: 'ease',
    pauseOnHover: false,
    autoplaySpeed: 3000,
    speed: 700,
    defaultResponsive : true,
    customArgs: false,
    responsive: true,
    delayAutoplay: false,
    unslickMobile: false,
    adaptiveHeight: false,

    infinite: true,
    asNavFor: false,
    centerMode: false,
  };
  function Plugin(element, options) {
      this.element = element;
      this.options = $.extend({}, defaults, options);
      this._defaults = defaults;
      this._name = pluginName;
      // init!!!!
      this._init();
  }
  Plugin.prototype = {
    // private methods //////////////////////////////////////////////////////////////////////////
    _init: function (){
      // vars
      this.$el = $(this.element);
      this.$win = $(window);
      this.$doc = $(document);
      this.$html = $('html');
      this.$body = $( 'body' );
      this.touch = !$('html').hasClass('no-touch');
      this.slides = [];

      this.$slick = this.$el.find( '> .slick-slider' );

      if ( this.$el.hasClass( 'autosize-available-viewport' ) ){
        this._onResize();
      }

      this._initSlider( true );
      this._addEvents( true );
    },
    _initSlider: function( b ){
      var $s = this.$slick, _this = this;

      if ( !$s ){
        return;
      }

      if ( b ){
        if ( ! $s.hasClass( 'slick-initialized' ) ){

          if ( this.options.autosize ){
            this._sizeImages();
          }

          $s.on( 'init', function(){

            if ( _this.$el.find( '.arrow' ).length > 0 ){
                _this.$el.find( '.arrow' ).css({
                  'visibility': 'visible'
                })
            }
            _this.$el.addClass( 'slideshow-ctrl-init' );

            /*
            if ( _this.$el.hasClass( 'autosize-available-viewport' ) ){
              _this._onResize();
            }
            */

          });

          // defaults to fade
          var args = this.options;
          if ( this.options.arrows ){
            args.prevArrow = this.$el.find(  '.arrow-left' );
            args.nextArrow = this.$el.find(  '.arrow-right' );
          }
          if ( this.options.responsive ){
              args.responsive = [
                {
                  breakpoint: 767,
                  settings: {
                    fade: false,
                    speed: (this.options.speed / 3),
                  }
                }
              ]
          }

          if ( this.options.unslickMobile ){
            args.responsive = [
              {
                breakpoint: 767,
                settings: "unslick"
              }
            ]
           }

          
          if ( this.options.customArgs && this.options.args ){
            args = this.options.args
          }
                    
          this._initSLIDES(b);

          $s.slick( args );

          if ( _this.options.delayAutoplay && this.options.autoplay ){
            $s.slick( 'slickPause' );
            setTimeout( function(){
              $s.slick( 'slickPlay' );
            }, _this.options.delayAutoplay );
          }

        }
      }
      else{
        if ( $s.hasClass( 'slick-initialized' ) ){
          $s.slick('unslick');
        }
      }
      this._attachEventsSlick( b );
      this._addFadeCaptions( b );
    },
    _addEvents: function( b ){
      var _this = this;
      if ( b ){
        //this.$win.on( 'resize', {_this:this}, this._onResize );
        if ( this.$slick.hasClass( 'click-to-advance' ) ){
          this.$el.find( 'img' ).on( 'click', function(e){
            _this._nextSlide( e.offsetX > $(this).width()/2 );
          });
        }
      }
      else{
        //this.$win.off( 'resize', this._onResize );
        if ( this.$slick.hasClass( 'click-to-advance' ) ){
          this.$el.find( 'img' ).off( 'click' );
        }
      }
      this._debounceResize(b);
    },
    _debounceResize: function(b){
      var _this = this;
      if ( b ){
        // debounce resize
        this._debResize = _.debounce( function(){
          _this._onResize();
        }, 117 );
        this.$win.on( 'resize', this._debResize );
      }
      else{
        if ( this._debResize ){
          this._debResize.cancel();
          this.$win.off( 'resize', this._debResize );
        }        
      }
    },
    _onResize: function(e){
      var _this = e ? e.data._this : this, w = _this.$win.width(), h = _this.$win.height(), availableHeight, p, $s = _this.getSlider(), max, ww;
      //console.log( 'Resize' );
      // resize goes here
      if ( _this.$el.hasClass( 'autosize-available-viewport' ) ){

        // if there is a max width
        if ( !_this.$el.data('max-width') ){
          max = parseInt( _this.$el.css( 'max-width' ) );
          if ( max ){
            _this.$el.data('max-width', max  )
          }
        }

        availableHeight = h - _this.$el.offset().top - 120; //h - $( 'main header' ).outerHeight( true ) - 120;

        p = 1/_this._getImagesProportion();
        if ( p ){

          // max (check if there is a max-width)
          ww = Math.floor( availableHeight*p );


          if ( _this.$el.data('max-width') ){
            ww = Math.min( ww, _this.$el.data('max-width') );
          }


          // min (don't go below too much ... )
          if ( w >=768 ){
            ww = Math.max( ww, 680 );
          }

          _this.$el.css({
            'max-width': ww
          });
          // force refresh, but slick give errors!!!!
          if ( $s.hasClass( 'slick-initialized' ) ){
            //console.log( $s.slick );
            //$s.slick( 'resize' )
          }
        }
      }
    },
    _nextSlide: function( b ){
      if ( b ){
        this.$slick.slick( 'slickNext' );
      }
      else{
        this.$slick.slick( 'slickPrev' );
      }
    },
    _attachEventsSlick: function( b ){
      var _this = this, $slick = this.$slick;
      this._attachEventsKeyBoard(b);
      if ( b ){

        $slick.on('beforeChange', function(event, slick, currentSlide, nextSlide){
          _this._onSlideBeforeChange( currentSlide, nextSlide );
        });
        $slick.on('afterChange', function(event, slick, currentSlide){
          _this._onSlideAfterChange( currentSlide );
        });

      }
      else{
        $slick.off('beforeChange');
        $slick.off('afterChange');
      }
    },
    _attachEventsKeyBoard: function( b ){
      var _this = this;
      if ( b ){      
        this.$el.on( 'keydown' , function(e){
          if( e.which === 39 || e.which === 40 ){
            // right arrow or dn
            _this.$slick.slick( 'slickNext' );
          }
          else if ( e.which === 37 || e.which === 38 ){
            // left arrow or up
           _this.$slick.slick( 'slickPrev' );
          }
        });
      }
      else{
        this.$el.off( 'keydown' );
      }
    },
    _getImagesProportion: function(){
      var $slide = this.$el.find( '.slick-slide:eq(0)' ), $wrapper, p;
      $wrapper = $slide.find( '.img-wrapper' );
      if ( $wrapper.length > 0 ){
        p = parseInt( $wrapper.attr('data-height') )/parseInt( $wrapper.attr('data-width') )
        return p;
      }
      return false;
    },
    _sizeImages: function(){
      var p = this._getImagesProportion();
      if ( p ){
        var $r = this.$el.find('.img-wrapper');
        if ( $r.length > 0 ){
          $r.css({
            'padding-bottom' : (p*100) + '%'
          })
        }
      }
    },
    _initSLIDES: function(b){
      var $m, $v, mode, _this = this, i, s;
      if ( b ){
        this.$el.find( '.slick-slide' ).each( function(i){
          $m = $(this);
          mode = 'image';
          $v = $m.find( '.video-ctrl' );
          if (  $v.length > 0 ){
            mode = 'video';
            $v.video_ctrl({ 
              autoplay: $v.hasClass('autoplay-off') ? false : true
            });
          }
          _this.slides[i] = {
            $el : $m,
            mode : mode,
            $v : $v
          }
        });
      }
      else{
        i = this.slides.length;
        while( i-- ){
          s = this.slides[i];
          if ( s.mode === 'video' ){
            $v = s.$v;
            $v.video_ctrl( 'destroy' );
          }
        }
      }
    },
    _onSlideBeforeChange: function( current, next ){
        var s = this.slides[ current ], $v;
        // pause current video
        if ( s.mode === 'video' ){
          $v = s.$v;
          $v.video_ctrl( 'play', false );
        }
    },  
    _onSlideAfterChange: function( current ){
        var s = this.slides[ current ], $v;
        // play current video
        if ( s.mode === 'video' ){
          $v = s.$v;
          $v.video_ctrl( 'play', true );
        }
    },

    _addFadeCaptions: function(b){

      if ( !this.$el.hasClass( 'fade-captions' ) ){
        return;
      }

      var $li, _this = this, $slick = this.$slick;
      this.$captions = this.$el.find( 'ul.captions' );
      if ( this.$captions.length > 0 ){
          if (b){

              // set first default --------------------//
              this.$captions.find('li:first-child').addClass( 'current' );

              $slick.on('beforeChange', function(event, slick, currentSlide, nextSlide){
                  _this.$captions.find( 'li' ).removeClass( 'current' );
                  $li = _this.$captions.find('li:eq(' + nextSlide + ')');
                  if ( $li.length > 0 ){
                      $li.addClass( 'current' );
                      TweenMax.fromTo( $li, 0.8, {opacity:0},{opacity:1,ease:'Sine.easeOut'} );
                  }               
              });
          }
          else{
              $slick.on('beforeChange');
          }
      }
    },  

    // public methods //////////////////////////////////////////////////////////////////////////
    destroy: function(){
      this._initSLIDES( false );
      this._initSlider( false );
      this._addEvents( false );
      this.$el.removeData();
      this.$el.removeClass( 'slideshow-ctrl-init' );
      $.data(this, 'plugin_' + pluginName, null);
    },

    play: function(b){
      if ( b ){
        //this.$slick.slick( 'slickNext' );
        this.$slick.slick( 'slickSetOption', 'autoplay', true );
        this.$slick.slick( 'slickSetOption', 'pauseOnHover', false );
        this.$slick.slick( 'slickPlay' );
      }
      else{
        this.$slick.slick( 'slickPause' ); 
      }
    },

    setAutoplay: function( s ){
      this.$slick.slick( 'slickSetOption', 'autoplaySpeed', s );
      this.play(true);
    },


    getSlider: function(){
      return this.$slick;
    }



  };

  $.fn[pluginName] = function ( options ) {
      var args = arguments;
      if (options === undefined || typeof options === 'object') {
          return this.each(function () {
              if (!$.data(this, 'plugin_' + pluginName)) {
                  $.data(this, 'plugin_' + pluginName, new Plugin( this, options ));
              }
          });
      } else if (typeof options === 'string' && options[0] !== '_' && options !== 'init') {
          var returns;
          this.each(function () {
              var instance = $.data(this, 'plugin_' + pluginName);
              if (instance instanceof Plugin && typeof instance[options] === 'function') {
                  returns = instance[options].apply( instance, Array.prototype.slice.call( args, 1 ) );
              }
              if (options === 'destroy') {
                $.data(this, 'plugin_' + pluginName, null);
              }
          });
          return returns !== undefined ? returns : this;
      }
  };
})(jQuery, window, document);


//****************** CAROUSEL *****************************************************************
;(function ($, window, document, undefined) {
    'use strict';
    var pluginName = "module_carousel";
    var defaults = {
        pageDots: true,
        prevNextButtons: true,
        wrapAround: true,
        autoPlay: false,
        //contain: true,
        // fade: true,
        selectedAttraction: 0.02,
        draggable: true,
        groupCells: true,
        arrowShape: { 
            x0: 10,
            x1: 60, y1: 50,
            x2: 60, y2: 20,
            x3: 60
        },
    };

    function Plugin(element, options) {
        this.element = element;
        this.options = $.extend({}, defaults, options);
        this._defaults = defaults;
        this._name = pluginName;
        // init!!!!
        this._init();
    }
    Plugin.prototype = {

        // private methods //////////////////////////////////////////////////////////////////////////
        _init: function (){

            this.$el            = $(this.element);
            this.$carousel      = this.$el.find('.carousel-main');
            this.$elements      = this.$el.find('.carousel-cell');

            // Check to see if there are enough elements for a carousel.
            var elements_width  = 0;
            this.$elements.each(function() { elements_width += $(this).outerWidth(); }); 
            if (elements_width < $(window).width()) {
                return this._displayNonCarousel(elements_width);
            }

            // this.$win = $(window);
            // this.$doc = $(document);
            // this.$body = $( 'body' );

            // Options
            if ( this.$el.attr( 'data-pagedots' ) !== undefined ){
                this.options.pageDots = this.$el.attr( 'data-pagedots' ) !== "false";
            }
            if ( this.$el.attr( 'data-fade' ) !== undefined ){
                this.options.fade = this.$el.attr( 'data-fade' ) !== "false";
            }
            if ( this.$el.attr( 'data-draggable' ) !== undefined ){
                this.options.draggable = this.$el.attr( 'data-draggable' ) !== "false";
            }
            if ( this.$el.attr( 'data-prevnext' ) !== undefined ){
                this.options.prevNextButtons = this.$el.attr( 'data-prevnext' ) !== "false";
            }

            if ( this.$el.hasClass( 'fade-captions') ){
                this._addFadeCaptions(true);
            }

            this.$carousel.flickity(this.options);
          
        },


        _displayNonCarousel: function(elements_width){

            var offset = ($(window).width() - elements_width) / 2;

            this.$elements.css({
                float     : 'left',
                display   : 'block',
            });

            this.$elements.eq( 0 ).css('margin-left', offset+'px');
            this.$elements.eq( this.$elements.length-1 ).css('margin-right','0');


        },

        _addFadeCaptions: function(b){

            var $li, _this = this;
            this.$captions = this.$el.find( 'ul.captions' );
            if ( this.$captions.length > 0 ){
                if (b){

                    // set first default --------------------//
                    this.$captions.find('li:first-child').addClass( 'current' );

                    //---------- bind on change --------------//
                    this.$carousel.on( 'change.flickity', function( event, index ) {
                        
                        _this.$captions.find( 'li' ).removeClass( 'current' );

                        $li = _this.$captions.find('li:eq(' + index + ')');
                        if ( $li.length > 0 ){
                            $li.addClass( 'current' );
                            TweenMax.fromTo( $li, 0.8, {opacity:0},{opacity:1,ease:'Sine.easeOut'} );
                        } 
                    });                    
                }
                else{
                    this.$carousel.off( 'change.flickity' );
                }
            }
        },


        // public methods //////////////////////////////////////////////////////////////////////////
        destroy: function(){

            if ( this.$el.hasClass( 'fade-captions') ){
                this._addFadeCaptions(false);
            }

            this.$carousel.flickity('destroy');

            $.data(this, 'plugin_' + pluginName, null);
        
        }
    
    };

    $.fn[pluginName] = function ( options ) {
      var args = arguments;
      if (options === undefined || typeof options === 'object') {
          return this.each(function () {
              if (!$.data(this, 'plugin_' + pluginName)) {
                  $.data(this, 'plugin_' + pluginName, new Plugin( this, options ));
              }
          });
      } else if (typeof options === 'string' && options[0] !== '_' && options !== 'init') {
          var returns;
          this.each(function () {
              var instance = $.data(this, 'plugin_' + pluginName);
              if (instance instanceof Plugin && typeof instance[options] === 'function') {
                  returns = instance[options].apply( instance, Array.prototype.slice.call( args, 1 ) );
              }
              if (options === 'destroy') {
                $.data(this, 'plugin_' + pluginName, null);
              }
          });
          return returns !== undefined ? returns : this;
      }
    };

})(jQuery, window, document);



//------------------------------------------------------- Overlay Window ---------------------------------------------------------//
;(function ($, window, document, undefined) {
  'use strict';

  var pluginName = "overlay_window";

  var defaults = {  
    open: true
  };

  function Plugin(element, options) {
      this.$el          = $(element);
      this.options      = $.extend({}, defaults, options);
      this._defaults    = defaults;
      this._name        = pluginName;
      this.$body        = $('body');
      this.$win         = $(window);
      this.$trigger     = false;
    
      // init!!!!
      this._init();
  }
  Plugin.prototype = {
    // private methods //////////////////////////////////////////////////////////////////////////
    // init function
    _init: function (){

        //------------- OVERLAY ------------------//

        if ( parent.$("body").length > 0 ){
            parent.$("body").append( this.$el );         
        } else {
            this.$body.append( this.$el );        
        }

        this.$overlay = this.$el;     

        // Custom options
        if (this.$el.attr('data-trigger')) {
            this.$trigger = $(this.$el.data('trigger'));
        }
        if (this.$el.attr('data-open')) {
            this.options.open = this.$el.data('open');
        }

        this._addEvents( true );

        // Auto-open?
        if ( this.options.open ){
            this._open( true );
        } 

    },

    _addEvents: function(b){
      var _this = this;
      this._addDebounceResize(b, true);
      if ( b ){
        this.$overlay.find( '.close' ).on( 'click', function(){
            _this._open( false );
            return false;
        } );
        if (this.$trigger) {
            this.$trigger.on('click', function() {
                _this._open( true );
                return false;
            });
        }
        // Don't close modal when clicking on the background by default, this is for the CA terms modal. Add 'close' class to bg element if you want it to close 
        // this.$overlay.find( '.bg' ).on( 'click', function(){
        //   _this._open( false );
        // } );
      }
      else{
        this.$overlay.find( '.close' ).off( 'click' );
        this.$overlay.find( '.bg' ).off( 'click' );
        if (this.$trigger) {
            this.$trigger.off('click');
        }
      }
    },

    _addDebounceResize: function(b, resize){
      if ( b ){
        var _this = this;
        this.r_debounce = _.debounce( function(){ _this._onResize() }, 200 );
        this.$win.on( 'resize', this.r_debounce );
        if ( resize ){
          this._onResize();
        }
      }
      else{
        if ( this.r_debounce ){
          this.r_debounce.cancel();
          this.$win.off( 'resize', this.r_debounce );
        }
      }
    },

    _onResize: function(){
    },

    _open: function(b){
      var $o = this.$overlay, _this = this, targetElement = this.$el.find( '.content-scroll' )[0];
      if ( b ){
        $o.css({
          'opacity': 0,
          'visibility': 'visible',
          'pointer-events' : 'auto'
        });
        $( 'html' ).addClass( 'prevent-scroll' );

        bodyScrollLock.disableBodyScroll( targetElement )
      }
      else{

        bodyScrollLock.enableBodyScroll( targetElement )
      }
      TweenMax.to( $o, 0.8, {opacity:b?1:0, ease:'Expo.easeOut',onComplete: function(){
        if ( !b ){
          $o.css({
            'opacity': 0,
            'visibility': 'hidden',
            'pointer-events' : 'none'
          });
          $( 'html' ).removeClass( 'prevent-scroll' );
        }
        else{
        }
      }});
        return false;
    },

    // public methods **********************************************/
    destroy: function(){

      this._addEvents( false );
      this.$overlay.remove();

      this.$el.removeData();
      $.data(this, 'plugin_' + pluginName, null);
      this.$el.remove();
    }
  };

  $.fn[pluginName] = function ( options ) {
      var args = arguments;
      if (options === undefined || typeof options === 'object') {
          return this.each(function () {
              if (!$.data(this, 'plugin_' + pluginName)) {
                  $.data(this, 'plugin_' + pluginName, new Plugin( this, options ));
              }
          });
      } else if (typeof options === 'string' && options[0] !== '_' && options !== 'init') {
          var returns;
          this.each(function () {
              var instance = $.data(this, 'plugin_' + pluginName);
              if (instance instanceof Plugin && typeof instance[options] === 'function') {
                  returns = instance[options].apply( instance, Array.prototype.slice.call( args, 1 ) );
              }
              if (options === 'destroy') {
                $.data(this, 'plugin_' + pluginName, null);
              }
          });
          return returns !== undefined ? returns : this;
      }
  };

})(jQuery, window, document);


// //****************** DIGITAL FEATURES *****************************************************************
;(function ($, window, document, undefined) {
    'use strict';

    var pluginName = "digital_features";
    var defaults = {
    };

    function Plugin(element, options) {
      this.$el     = $(element);
      this.options      = $.extend({}, defaults, options);
      this._defaults    = defaults;
      this._name        = pluginName;

      this.$body        = $('body');
      this.$win         = $(window);

      this._init();
    }
    Plugin.prototype = {

      // private methods //////////////////////////////////////////////////////////////////////////
      _init: function (){

        //console.log( 'digital_featured' );

        this.$panel = this.$el.find( '#digital-features-drawer' );

        this.$slide = this.$panel.find( '.bottom' );

        this.$inner = this.$panel.find( '.inner' );

        this.$content_scroll = this.$panel.find( '.content-scroll' );

        this._addEvents( true, true );
      },

      _addEvents: function(b){
        var _this = this;
        this._addDebounceResize(b, true);
        if ( b ){
          
          this.$panel.find( '.arrow' ).on( 'click', function(){
            _this.$panel.toggleClass( 'close' );
          });

          this.$win.on( 'scroll', function(){
            _this._onResize()
          } );
          /*
          this.$panel.find( 'a' ).on('click', function(e){
            e.preventDefault();
            _this._scrollTo( $(this).attr('data-index') );
          })
          */

          this.$panel.on( 'mouseenter', function(){
            _this._openPanel( true );
          });
          this.$panel.on( 'mouseleave', function(){
            _this._openPanel( false );
          });
        }
        else{
          this.$panel.find( '.arrow' ).off( 'click' );
          this.$win.off( 'scroll' );
          //this.$panel.find( 'a' ).off('click');
          this.$panel.off( 'mouseenter' ).off( 'mouseleave' );
        }
      },
      _addDebounceResize: function(b, resize){
        if ( b ){
          var _this = this;
          this.r_debounce = _.debounce( function(){ _this._onResize() }, 200 );
          this.$win.on( 'resize', this.r_debounce );
          if ( resize ){
            setTimeout( function(){
              _this._onResize();
            }, 1500 );
          }
        }
        else{
          if ( this.r_debounce ){
            this.r_debounce.cancel();
            this.$win.off( 'resize', this.r_debounce );
          }
        }
      },

      _onResize: function(){
        var h = this.$win.height(), t = this.$win.scrollTop(), p = this.$el.offset().top;

        if ( t >= p){
          this.$inner.height( h );
        }
        else{
          this.$inner.height( h - (p-t) );
        }

      },

      _openPanel: function(b){
        if ( b ){
          this.$panel.removeClass( 'close' );
        }
        else{
          this.$panel.addClass( 'close' );
        }
      },

      _scrollTo: function( index ){
        var $el, y, $img, w = this.$win.width();
        //console.log( index );
        this._openPanel(false);

        // get the offset of the index Digital Feature
        $el = this.$el.find( '.table-col[data-index="' + index + '"]' );
        if ( $el.length > 0 ){
          y = $el.offset().top;
          $img = $el.find( '.img' );
          if ( $img.length > 0 ){
            y = $img.offset().top;
          }

          // rest the header height ...
          y -= w < 768 ? $('#header-mobile').height() : $('#main-header').height();

          TweenMax.to( this.$win, 0.4, {scrollTo:  y , ease:'Sine.easeOut'});

          $img.find('.overlay').removeClass('reveal');
          setTimeout(function(){
            $img.find('.overlay').addClass( 'reveal' );
          }, 17 );

        }
      },


      // public methods //////////////////////////////////////////////////////////////////////////
      destroy: function(){
        this._addEvents( false );
        this.$el.removeData();
        $.data(this, 'plugin_' + pluginName, null);
      }

    };

    $.fn[pluginName] = function ( options ) {
      var args = arguments;
      if (options === undefined || typeof options === 'object') {
          return this.each(function () {
              if (!$.data(this, 'plugin_' + pluginName)) {
                  $.data(this, 'plugin_' + pluginName, new Plugin( this, options ));
              }
          });
      } else if (typeof options === 'string' && options[0] !== '_' && options !== 'init') {
          var returns;
          this.each(function () {
              var instance = $.data(this, 'plugin_' + pluginName);
              if (instance instanceof Plugin && typeof instance[options] === 'function') {
                  returns = instance[options].apply( instance, Array.prototype.slice.call( args, 1 ) );
              }
              if (options === 'destroy') {
                $.data(this, 'plugin_' + pluginName, null);
              }
          });
          return returns !== undefined ? returns : this;
      }
    };

})(jQuery, window, document);



//****************** FILTER BAR *****************************************************************

;(function ($, window, document, undefined) {
    'use strict';
    var pluginName = "filter_action";
    // var defaults = {
    // };

    function Plugin(element, options) {
        this.element = element;
        this.$target;
        this.$el;
        this.$items;
        this.$filters;
        this.$filter_reset;
        this.$noresults;
        this.mode = 'list';
        // this.options = $.extend({}, defaults, options);
        // this._defaults = defaults;
        this._name = pluginName;
        // init!!!!
        this._init();
    }
    Plugin.prototype = {

        // private methods //////////////////////////////////////////////////////////////////////////
        _init: function (){

            //console.log('filter_action/_init');

            this.$el            = $(this.element);
            this.$target        = (this.$el.data('target')) ? $('#' + this.$el.data('target')) : false;

            if (!this.$target) return false;

            this.$items             = this.$target.find('> *').not('.gutter-sizer');
            this.$filter_dropdown   = this.$el.find('SELECT');
            this.$filter_other      = this.$el.find('INPUT[type=checkbox], INPUT[type=radio]');

            this.$filter_reset  = this.$el.find('.reset');
            this.$noresults     = this.$el.find('.no_results');

            if (this.$target.data('packery')) {
                this.mode = 'packery';
            }

            this._addEvents(true);
          
        },

        _addEvents: function( b ){
            var _this = this;
            if ( b ){
                if (_this.$filter_reset) _this.$filter_reset.on('click', {_this:_this}, _this._doReset);
                _this.$filter_dropdown.on('change', {_this:this}, _this._doFilterChange);
                _this.$filter_other.on('change ifChecked', {_this:this}, _this._doFilterChange);
                // if (filter_link) filter_link.on('click', {_this:this}, doFilterLink)
            } else {
                _this.$filter_dropdown.off('change');
                _this.$filter_other.off('change ifChecked');
                if (_this.$filter_reset) _this.$filter_reset.off('click');
                // if (filter_link) filter_link.off('click');
            }
        },


        _doReset: function(e){
            var _this = e ? e.data._this : this;
            if (_this.$noresults) _this.$noresults.hide();   
            if (_this.$filter_reset) _this.$filter_reset.removeClass('show');
            _this.$items.removeClass('stamp').show();
            _this.$filter_dropdown.val('').trigger('blur');
            _this.$filter_other.each(function() {
                if ($(this).val() == -1) $(this).prop('checked', true);
            }).iCheck('update').trigger('blur');
            if (_this.mode == 'packery') _this.$target.packery('layout');
            return false;
        },

        _doFilter: function(match){

console.log('_doFilter: ');
console.log(match);
console.log('Results: ' + match.length);

            if (!match.length) return this._doReset();

            if (this.$noresults) this.$noresults.hide();   
            if (this.$filter_reset) this.$filter_reset.addClass('show');   

            var _this           = this;
            var _visible        = 0;
            var _match_string   = '';

            if ($.isArray(match)) {
                match.forEach(function(m) {
                    _match_string += '[data-attributes*="|'+ m +'|"]';
                });
            } else {
                _match_string = match;
            }

            // Remember the filter for hitting back button
            // Cookies.set('filter' , _match_string, { expires: 1, path: '' });

            this.$items.each(function() {

                var $item = $(this);

                if ( $item.is(_match_string)){
                    _visible ++;
                    // Item is a match.
                    if (_this.mode == 'packery' && $item.hasClass('stamp')) {
                        _this.$target.packery('unstamp', $item);
                        $item.removeClass('stamp');
                    }
                    $item.show();
                } else{
                    // Item is not a match.
                    if (_this.mode == 'packery' && !$item.hasClass('stamp')) {
                        _this.$target.packery('stamp', $item);
                        $item.addClass('stamp');                    
                    }
                    $item.hide();
                }

            });

            if (_visible == 0) {
                if (_this.$noresults) _this.$noresults.fadeIn();
            }

            if (_this.mode == 'packery') _this.$target.packery('layout');
            TweenMax.fromTo( _this.$target, 0.4, {opacity:0.2,y:10}, {opacity:1,y:0,ease:"Power.easeOut"});

        },

        _doFilterChange: function(e){

            var _match      = [];
            var _this       = e ? e.data._this : this;

            _this.$filter_dropdown.each(function() {
                if ( $(this).val() > 0 ) _match.push($(this).val());
            });

            _this.$filter_other.each(function() {
                if ( $(this).is(':checked') && $(this).val() != -1)  _match.push($(this).val());
            });

            return _this._doFilter(_match);

        },

        // _doFilterLink: function(){

        //     var _id     = $(this).attr('data-value');
        //     var _type   = $(this).attr('data-name');

        //     filter_dropdown.filter('[name="'+ _type +'"]').val( _id ).trigger('change');

        //     return false;

        // },

        // public methods //////////////////////////////////////////////////////////////////////////
        destroy: function(){
            this._addEvents(false);
            $.data(this, 'plugin_' + pluginName, null);
        
        }
    
    };

    $.fn[pluginName] = function ( options ) {
      var args = arguments;
      if (options === undefined || typeof options === 'object') {
          return this.each(function () {
              if (!$.data(this, 'plugin_' + pluginName)) {
                  $.data(this, 'plugin_' + pluginName, new Plugin( this, options ));
              }
          });
      } else if (typeof options === 'string' && options[0] !== '_' && options !== 'init') {
          var returns;
          this.each(function () {
              var instance = $.data(this, 'plugin_' + pluginName);
              if (instance instanceof Plugin && typeof instance[options] === 'function') {
                  returns = instance[options].apply( instance, Array.prototype.slice.call( args, 1 ) );
              }
              if (options === 'destroy') {
                $.data(this, 'plugin_' + pluginName, null);
              }
          });
          return returns !== undefined ? returns : this;
      }
    };

})(jQuery, window, document);



//****************** FILTER QUERY *****************************************************************

;(function ($, window, document, undefined) {
    'use strict';
    var pluginName = "filter_query";
    // var defaults = {
    // };

    function Plugin(element, options) {
        this.element = element;
        this.$target;
        this.$el;
        // this.$items;
        this.$filter_dropdown;
        this.$filter_other;
        this.$filter_reset;
        this.$results;
        this.$noresults;
        this.$loading;
        this.mode = 'list';
        // this.options = $.extend({}, defaults, options);
        // this._defaults = defaults;
        this._name = pluginName;
        // init!!!!
        this._init();
    }
    Plugin.prototype = {

        // private methods //////////////////////////////////////////////////////////////////////////
        _init: function (){

            //console.log('filter_query/_init');

            this.$el            = $(this.element);
            this.$target        = (this.$el.data('target')) ? $('#' + this.$el.data('target')) : false;

            if (!this.$target) return false;

            // this.$items             = this.$target.find('> *').not('.gutter-sizer');

            this.$filter_dropdown   = this.$el.find('SELECT');
            this.$filter_other      = this.$el.find('INPUT[type=checkbox], INPUT[type=radio]');

            this.$filter_reset      = this.$el.find('.reset');

            this.$results           = this.$target.find('.results');
            this.$noresults         = this.$target.find('.no_results');
            this.$loading           = this.$target.find('.loading');

            this._addEvents(true);

            // Check for previous filter cookie.
            var cookie_filter = Cookies.getJSON('collection_filter');
            if (cookie_filter) {
                this._doSavedFilter(cookie_filter);
            } else {
                MAIN.initGridPackery(true, this.$results);
            }
          
        },

        _addEvents: function( b ){
            var _this = this;
            if ( b ){
                if (_this.$filter_reset) _this.$filter_reset.on('click', {_this:this}, _this._doReset);
                _this.$filter_dropdown.on('change', {_this:this}, _this._doFilterChange);
                _this.$filter_other.on('change ifChecked', {_this:this}, _this._doFilterChange);
                _this.$target.on('click', '.load_more A', {_this:this}, _this._doLoadMore);
            } else {
                if (_this.$filter_reset) _this.$filter_reset.off('click');
                _this.$filter_dropdown.off('change');
                _this.$filter_other.off('change ifChecked');
                _this.$target.off('click', '.load_more A');
            }
        },


        _doReset: function(e){

            var _this = e ? e.data._this : this;

            // Hide loading and reset the 'no results found' message.
            _this.$loading.hide(); 
            _this.$noresults.hide();
            // Hide reset trigger.
            if (_this.$filter_reset) _this.$filter_reset.removeClass('show');   

            // Reset form.
            _this.$filter_dropdown.val('').trigger('blur');
            _this.$filter_other.each(function() {
                if ($(this).val() == -1) $(this).prop('checked', true);
            }).iCheck('update').trigger('blur');

            // Remove the saved query cookie.
            Cookies.remove('collection_filter', { path: '' });

            // Show default items.
            _this._doFilterChange(false, true);

            return false;
        },



/*

filter
- hide results
- show loading (results)
- searlize form
- send to server
- get results
- replace results with data
- do show animation


load more
- show loading (button)
- searilize form
- get button url
- send to server
- get results
- replace button with data
- do show animation

*/





        _doLoadMore: function(e){

            var _this       = e ? e.data._this : this;
            var form        = _this.$el.find('FORM');
            var form_data   = form.serialize();

            var button      = $(this);
            var button_wrap = button.closest('DIV');

            button.hide();
            button_wrap.find('.loading').fadeIn(400);

            $.post(button.attr('href'), form_data, function(response) {  

                var results =  $($.parseHTML(response)).find("#collection_list_results > .item-grid"); 
            
                button_wrap.replaceWith( results );

                _this.$results.packery( 'appended', results ).packery()

            },'html'); 

            return false;

        },

        _doSavedFilter: function(filter_data) {

            var _this = this;

            $.each(filter_data, function(index, filter) {

                if (filter.value.length && filter.value.length > 0) {
                    // Update field if this is a dropdown.
                    _this.$el.find('SELECT[name="'+ filter.name +'"]').val(filter.value);
                    // Reset other fields if this is a radio/checkbox.
                    _this.$el.find('INPUT[name="'+ filter.name +'"][value!="'+ filter.value +'"]').prop('checked', false).iCheck('update');
                    // Update field if this is a radio/checkbox.
                    _this.$el.find('INPUT[name="'+ filter.name +'"][value="'+ filter.value +'"]').prop('checked', true).iCheck('update');
                }

            });

            _this._doFilterChangeAction(filter_data);

        },

        _doFilterChange: function(e, is_reset){

            var _this       = e ? e.data._this : this;
            var form        = _this.$el.find('FORM');
            var form_data   = form.serializeArray();

            _this._doFilterChangeAction(form_data, is_reset);           

        },

        _doFilterChangeAction: function(form_data, is_reset){

            var _this = this;

            // Fade out the current items.
            _this.$results.removeClass('packed');

            // Show loading and reset the 'no results found' message.
            _this.$loading.fadeIn(400); 
            _this.$noresults.hide();

            $.post(document.location.href, form_data, function(response) {  

                var results =  $($.parseHTML(response)).find("#collection_list_results > .item-grid");

                if (!results.length) {
                    _this.$loading.fadeOut(400);
                    _this.$noresults.fadeIn(200);
                    return;
                }

                // Hide loading indicator.
                _this.$loading.fadeOut(400);

                // Remove the current items from page.
                MAIN.initGridPackery(false, _this.$results);
                _this.$results.html('');

                // Add new items to the grid.
                _this.$results.html('<div class="gutter-sizer"></div>');
                _this.$results.append(results);

                // Initialize Packary on the new results grid.
                MAIN.initGridPackery(true, _this.$results);

                // Show the trigger for resetting query.
                if (!is_reset && _this.$filter_reset) _this.$filter_reset.addClass('show');

                // Store query cookie.
                if (!is_reset) Cookies.set('collection_filter', form_data, { expires: 1, path: '' });

            },'html'); 

        },


        // public methods //////////////////////////////////////////////////////////////////////////
        destroy: function(){
            this._addEvents(false);
            $.data(this, 'plugin_' + pluginName, null);
        
        }
    
    };

    $.fn[pluginName] = function ( options ) {
      var args = arguments;
      if (options === undefined || typeof options === 'object') {
          return this.each(function () {
              if (!$.data(this, 'plugin_' + pluginName)) {
                  $.data(this, 'plugin_' + pluginName, new Plugin( this, options ));
              }
          });
      } else if (typeof options === 'string' && options[0] !== '_' && options !== 'init') {
          var returns;
          this.each(function () {
              var instance = $.data(this, 'plugin_' + pluginName);
              if (instance instanceof Plugin && typeof instance[options] === 'function') {
                  returns = instance[options].apply( instance, Array.prototype.slice.call( args, 1 ) );
              }
              if (options === 'destroy') {
                $.data(this, 'plugin_' + pluginName, null);
              }
          });
          return returns !== undefined ? returns : this;
      }
    };

})(jQuery, window, document);


//****************** GOOGLE TRANSLATE WIDGET *****************************************************************

;(function ($, window, document, undefined) {
    'use strict';
    var pluginName = "language_select";

    function Plugin(element, options) {
        this.element = element;
        this._name = pluginName;
        this.$body = $( 'body' );
        this.timer;
        this._init();
    }
    Plugin.prototype = {

        // private methods //////////////////////////////////////////////////////////////////////////
        _init: function (){

            this.$el            = $(this.element);
            this.$window        = this.$el.find('.window');
            this.detect         = this.$el.find('.detect');
            this.detect_value   = this.detect.text();

            var _this           = this;

            window.googleTranslateElementInit = function() {
                //console.log('googleTranslateElementInit');
                new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE, autoDisplay: false}, 'google_translate_element');
            };

            $.getScript('//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit', function() {     
                _this._addEvents(true);
            });
          
        },

        _addEvents: function( b ){
            var _this = this;
            if ( b ){
                _this.$body.on('click', '[rel="language:toggle"]', {_this:_this}, _this.toggleDropdown);
                _this.$body.on('click', 'A[rel="language:select"]', {_this:_this}, _this.changeLang);
                _this.$body.on('change', 'SELECT[rel="language:select"]', {_this:_this}, _this.changeLang);
                _this.timer = setInterval(function() {
                    if (_this.detect.text() != _this.detect_value) {
                        _this.detect_value = _this.detect.text();
                        _this.setDisplayLang();
                    }
                }, 2000);
            } else {
                _this.$body.off('click', '[rel="language:toggle"]');
                _this.$body.off('click', 'A[rel="language:select"]');
                _this.$body.off('change', 'SELECT[rel="language:select"]');
                if (_this.timer) clearInterval(_this.timer);
            }
        },


        toggleDropdown: function(e){
            var _this = e ? e.data._this : this;
            _this.$window.toggle();
            return false;
        },

        changeLang: function(e){
            var _this = e ? e.data._this : this;

            var lang    = (e.currentTarget.nodeName == 'SELECT') ? $(this).val() : $(this).data('lang');
            var $frame  = $('.goog-te-menu-frame:first');

            _this.$window.hide();

            if ( lang === 'English' ) { 
                // $frame.find('.goog-te-menu2-item span.text:contains('+lang+')').get(0).click();
                document.location = document.location.href;
                return false;
            }

            if (!$frame.length) {
                //console.log('language_select ERROR No Google Translate frame found.');
                return false;
            }            

            var span = $('.goog-te-menu-frame:first').contents().find('SPAN.text').filter(function() { return ($(this).text() === lang) });

            span.get(0).click();

            if ( lang === 'English' ) { 
                document.location = document.location.href;
                return false;
            }

            _this.setDisplayLang();

            return false;


        },

        setDisplayLang: function(){

            // if (google.translate.TranslateElement().c != 'af') {
            //     $('.language_display').html(google.translate.TranslateElement().c);
            // } else {
            //     $('.language_display').html('EN');
            // }

        },

        // public methods //////////////////////////////////////////////////////////////////////////
        destroy: function(){
            this._addEvents(false);
            $.data(this, 'plugin_' + pluginName, null);
        
        }
    
    };

    $.fn[pluginName] = function ( options ) {
      var args = arguments;
      if (options === undefined || typeof options === 'object') {
          return this.each(function () {
              if (!$.data(this, 'plugin_' + pluginName)) {
                  $.data(this, 'plugin_' + pluginName, new Plugin( this, options ));
              }
          });
      } else if (typeof options === 'string' && options[0] !== '_' && options !== 'init') {
          var returns;
          this.each(function () {
              var instance = $.data(this, 'plugin_' + pluginName);
              if (instance instanceof Plugin && typeof instance[options] === 'function') {
                  returns = instance[options].apply( instance, Array.prototype.slice.call( args, 1 ) );
              }
              if (options === 'destroy') {
                $.data(this, 'plugin_' + pluginName, null);
              }
          });
          return returns !== undefined ? returns : this;
      }
    };

})(jQuery, window, document);




//****************** GOOGLE MAP WIDGET *****************************************************************

//------------------------------------------------------- GOOGLE MAP ---------------------------------------------------------//
// https://www.advancedcustomfields.com/resources/google-map/

;(function ($, window, document, undefined) {
  'use strict';

  var pluginName = "map_embed";

  var defaults = { };

  function Plugin(element, options) {
      this.$win         = $(window);
      this.$element     = $(element);
      this.options      = $.extend({}, defaults, options);
      this._defaults    = defaults;
      this._name        = pluginName;
      this.$body        = $('body');
      this.map_url      = 'http://maps.google.com/maps?';
      this.map_key      = this.$element.data('key');
      this.map;
      // init!!!!
      this._init();
  }
  Plugin.prototype = {

    // private methods //////////////////////////////////////////////////////////////////////////

    _init: function (){
        var _this   = this;
        $.getScript('https://maps.googleapis.com/maps/api/js?key=' + this.map_key, function() { _this._initInfobox(); });
    },

    _initInfobox: function(script, textStatus) {
        var _this   = this;
        $.getScript(this.$body.data('theme-url') + '/assets/js/libs/google.infobox.js', function() { _this._initDisplay(); });
    },

    _initDisplay: function(script, textStatus) {

        // Store class instance for nested function calls.
        var _this   = this;

        // Make sure google library is loaded.
        if (typeof google == 'undefined') {
            //console.log('module_map_embed: error, google library not present');
            return false;
        }

        // Create a new StyledMapType object, passing it an array of styles, sand the name to be displayed on the map type control.
        var map_styled = new google.maps.StyledMapType([
  {
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#f5f5f5"
      }
    ]
  },
  {
    "elementType": "labels.icon",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#616161"
      }
    ]
  },
  {
    "elementType": "labels.text.stroke",
    "stylers": [
      {
        "color": "#f5f5f5"
      }
    ]
  },
  {
    "featureType": "administrative.land_parcel",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#bdbdbd"
      }
    ]
  },
  {
    "featureType": "poi",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#eeeeee"
      }
    ]
  },
  {
    "featureType": "poi",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#757575"
      }
    ]
  },
  {
    "featureType": "poi.park",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#e5e5e5"
      }
    ]
  },
  {
    "featureType": "poi.park",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#9e9e9e"
      }
    ]
  },
  {
    "featureType": "road",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#ffffff"
      }
    ]
  },
  {
    "featureType": "road.arterial",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#757575"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#dadada"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#616161"
      }
    ]
  },
  {
    "featureType": "road.local",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#9e9e9e"
      }
    ]
  },
  {
    "featureType": "transit.line",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#e5e5e5"
      }
    ]
  },
  {
    "featureType": "transit.station",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#eeeeee"
      }
    ]
  },
  {
    "featureType": "transit.station.rail",
    "stylers": [
      {
        "saturation": -100
      },
      {
        "visibility": "on"
      }
    ]
  },
  {
    "featureType": "water",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#c9c9c9"
      }
    ]
  },
  {
    "featureType": "water",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#9e9e9e"
      }
    ]
  }
]);

        // Create blank map.
        this.map = new google.maps.Map(this.$element.find('.map')[0], {
            zoom                : 15,
            center              : new google.maps.LatLng(0, 0), // new google.maps.LatLng(40.766813, -73.9380539),
            mapTypeId           : google.maps.MapTypeId.ROADMAP,
            streetViewControl   : false,
            mapTypeControl      : false,
            fullscreenControl   : false,
            zoomControl         : true,
        });

        //Associate the styled map with the MapTypeId and set it to display.
        this.map.mapTypes.set('styled_map', map_styled);
        this.map.setMapTypeId('styled_map');
        
        // Add a markers reference.
        this.map.markers = [];
        
        // Add markers.
        this.$element.find('.marker').each(function(){            
            _this._addMarker( $(this), _this.map );
        });
        
        // Center map on markers.
        this._centerMap( _this.map );

        // Change marker icon size on zoom
        google.maps.event.addListener(_this.map, 'zoom_changed', function() {

            var zoom    = _this.map.getZoom();
            var ratio   = (zoom < 17) ? 0.7 : 1;

            _this.map.markers.forEach(function(marker) {

                var type    = marker.custom_type;
                var stats   = _this._getMarkerIconSize(type, ratio);

                var icon_w  = stats[0];
                var icon_h  = stats[1];
                var anchor  = stats[2];

                marker.setIcon({
                    url: marker.getIcon().url,
                    scaledSize: new google.maps.Size(icon_w, icon_h),
                    origin: new google.maps.Point(0, 0),
                    anchor: anchor,
                });

            });

        });



    },

    _getMarkerIconSize: function(type, ratio) {
        
        ratio = ratio || 1;

        if (type == 'main') {

            var icon_w  = 120 * ratio;
            var icon_h  = 32 * ratio;
            var anchor  = new google.maps.Point(5, 10);

        } else {

            var icon_w  = 20 * ratio;
            var icon_h  = 20 * ratio;
            var anchor  = new google.maps.Point(icon_w/2, icon_h/2);

        }

        return [icon_w, icon_h, anchor];

    },

    _addMarker: function($marker, map ) {

        var _this  = this;

        var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );

        var type        = $marker.attr('data-type');
        var stats       = _this._getMarkerIconSize(type, 'default');

        var label_text  = $marker.attr('data-label') || '';
        var info_box    = false;

        var icon_w      = stats[0];
        var icon_h      = stats[1];
        var anchor      = stats[2];

        var url         = $marker.attr('data-url') || _this.map_url+'q='+latlng.lat()+','+latlng.lng();

        var icon    = {
            url: this.$body.data('theme-url') + '/assets/img/'+ $marker.attr('data-icon') +'.svg',
            scaledSize: new google.maps.Size(icon_w, icon_h),
            origin: new google.maps.Point(0, 0),
            anchor: anchor,
        };

        if (label_text.length) {

            var info_box = new InfoBox({
                // https://htmlpreview.github.io/?https://raw.githubusercontent.com/googlemaps/v3-utility-library/master/infobox/docs/examples.html
                content: '<div class="map_label '+type+'">'+ label_text +'</div>',
                disableAutoPan: true,
                maxWidth: 600,
                pixelOffset: new google.maps.Size(13, -8),
                zIndex: 20,
                boxStyle: {  padding: '0' },
                closeBoxURL: '',
                infoBoxClearance: new google.maps.Size(1, 1),
                isHidden: false,
                pane: "floatPane",
                enableEventPropagation: true,
            });

        }

        var marker = new google.maps.Marker({
            position : latlng,
            map: map,
            draggable: false,
            clickable: true,
            icon: icon,
            info: info_box,
            custom_type: type,
            custom_url: url,
        });

        // add to array
        map.markers.push( marker );

        // Go to URL when clicked.
        google.maps.event.addListener(marker, 'click', function() {
            window.open(marker.custom_url);
        });            

        if (label_text.length) {

            // Show marker label when hovering over.
            google.maps.event.addListener(marker, 'mouseover', function() {
                marker.info.open(_this.map, marker);
            });
            google.maps.event.addListener(marker, 'mouseout', function() {
                marker.info.close(_this.map, marker);
            });

        }

    },


    _centerMap: function( map ) {

        // vars
        var bounds = new google.maps.LatLngBounds();

        // loop through all markers and create bounds
        $.each( map.markers, function( i, marker ){
            var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );
            bounds.extend( latlng );
        });

        // only 1 marker?
        if( map.markers.length == 1 ) {
            // set center of map
            map.setCenter( bounds.getCenter() );
            // map.setZoom( 20 );
        } else {
            // fit to bounds
            map.fitBounds( bounds );
        }

    }

  };

  $.fn[pluginName] = function ( options ) {
      var args = arguments;
      if (options === undefined || typeof options === 'object') {
          return this.each(function () {
              if (!$.data(this, 'plugin_' + pluginName)) {
                  $.data(this, 'plugin_' + pluginName, new Plugin( this, options ));
              }
          });
      } else if (typeof options === 'string' && options[0] !== '_' && options !== 'init') {
          var returns;
          this.each(function () {
              var instance = $.data(this, 'plugin_' + pluginName);
              if (instance instanceof Plugin && typeof instance[options] === 'function') {
                  returns = instance[options].apply( instance, Array.prototype.slice.call( args, 1 ) );
              }
              if (options === 'destroy') {
                $.data(this, 'plugin_' + pluginName, null);
              }
          });
          return returns !== undefined ? returns : this;
      }
  };

})(jQuery, window, document);


//****************** VIDEO CTRL EMBED *****************************************************************//
;(function ($, window, document, undefined) {
  'use strict';
  
  var pluginName = "video_ctrl_embed"; 
  
  var defaults = {
    autoplay: true,
  },
  timeout;

  function Plugin(element, options) {
      this.element = element;
      this.options = $.extend({}, defaults, options);
      this._defaults = defaults;
      this._name = pluginName;
      // init!!!!
      this._init();
  }
  Plugin.prototype = {
    // private methods //////////////////////////////////////////////////////////////////////////
    _init: function (){
      // vars
      this.$el = $(this.element); // video wrapper
      this.$win = $(window);
      this.$doc = $(document);
      this.$html = $('html');
      this.$body = $( 'body' );
      this.touch = !$('html').hasClass('no-touch');

      this.$placeholder = this.$el.find( '.bg-overlay-video' );
      if ( this.$placeholder.length > 0 ){
        //this._writeVideo();
      }
      else{
        //this._writeVideo();
      }
      this._addEvents( true );
      this._onResize();
    },
    _addEvents: function( b ){
      var _this = this;
      if ( b ){
        this.$win.on( 'resize', {_this:this}, this._onResize );
        this.$placeholder.on( 'click', function(){
          _this.$placeholder.off( 'click' );
          _this._writeVideo();
          _this._fadePlaceholder()
        });
      }
      else{
        this.$win.off( 'resize', this._onResize );
      }
    },
    _writeVideo: function(){
      var _this = this, $e = this.$el.find( '.video-embed-code' );

      //console.log( $e );

      if ( $e.length > 0 ){
        this.$el.find( '.embed-content' ).html( $e.html() );
      }
    },
    _fadePlaceholder: function(){
      var _this = this;
      TweenMax.to( this.$placeholder, 1, { opacity: 0, onComplete: function(){
        _this.$placeholder.remove();
      }});
    },
    _onResize: function( e ){
      var _this = e ? e.data._this : this;
      clearTimeout( _this.timeout );
      _this.timeout = setTimeout( function(){
        _this._resizeVideo();
      }, 120 );
      //_this._resizeVideo();
    },
    _resizeVideo: function(){
      var $iframe = this.$el.find( 'iframe' );
      
      // autosize container
      if ( $iframe.length > 0 ){
        this.$el.css({
          'padding-bottom' : parseInt($iframe.attr('height'))/parseInt($iframe.attr('width'))*100 + '%'
        })
      }
    },
    // public methods //////////////////////////////////////////////////////////////////////////
    destroy: function(){
      this._addEvents( false );
      this.$el.removeData();
      $.data(this, 'plugin_' + pluginName, null);
    }
  };

  $.fn[pluginName] = function ( options ) {
      var args = arguments;
      if (options === undefined || typeof options === 'object') {
          return this.each(function () {
              if (!$.data(this, 'plugin_' + pluginName)) {
                  $.data(this, 'plugin_' + pluginName, new Plugin( this, options ));
              }
          });
      } else if (typeof options === 'string' && options[0] !== '_' && options !== 'init') {
          var returns;
          this.each(function () {
              var instance = $.data(this, 'plugin_' + pluginName);
              if (instance instanceof Plugin && typeof instance[options] === 'function') {
                  returns = instance[options].apply( instance, Array.prototype.slice.call( args, 1 ) );
              }
              if (options === 'destroy') {
                $.data(this, 'plugin_' + pluginName, null);
              }
          });
          return returns !== undefined ? returns : this;
      }
  };
})(jQuery, window, document);



//------------------------------------------------------- Image Enlarge Window ---------------------------------------------------------//
;(function ($, window, document, undefined) {
  'use strict';

  var pluginName = "image_enlarge_window";

  var defaults = {  };

  function Plugin(element, options) {
      this.$el     = $(element);
      this.options      = $.extend({}, defaults, options);
      this._defaults    = defaults;
      this._name        = pluginName;


      this.$body        = $('body');
      this.$win         = $(window);
    
      // init!!!!
      this._init();
  }
  Plugin.prototype = {
    // private methods //////////////////////////////////////////////////////////////////////////
    // init function
    _init: function (){

        //------------- OVERLAY ------------------//

        if ( parent.$("body").length > 0 ){
            parent.$("body").append( this.$el );         
        } else {
            this.$body.append( this.$el );        
        }
        this.images = [];
        this.$overlay = this.$el;
        this._createSlideshow(true);
        this._addEvents( true );

    },

    _createSlideshow: function(b){
      var $img, skip, j, images, _this = this, $slider_container = this.$el.find( '.slider-container' ), $p, $content = this.$el.find( '.content' ), $cp;
      if( b ){

        //-------------------- THIS IS THE MAGIC --------------------//
        images = [];
        this.options.$imgs.each(function(){
          $img = $(this);
          if ( !$img.parents('.slick-slide').hasClass( 'slick-cloned' ) ){

            
            $p = $img.parents( '.slider-container' );
            if ( $p.hasClass( 'slideshow-carousel' ) ){
              $cp = $img.parents('.enlarge-gallery-wrap').find( '.data-caption' );
              if ( $cp.length > 0 ){
                if ( $cp.text() === '' ||  $cp.text() === ' ' ){
                  //console.log( $p.find('.caption').html() );
                  $cp.html( $p.find('.caption').html() );
                }
              }
            }
            

            skip = false;
            j = images.length;
            while(j--){
              //if ( images[j].attr('srcset') === $img.attr('srcset') ){
              if ( images[j].attr('data-srcset') === $img.attr('data-srcset') ){
                skip = true;
              }
            }
            if ( !skip ){
              j = images.length;
              images[j] = $img;
            }
          }
        });
        this.images = images;
        //-------------------- THIS IS THE MAGIC --------------------//

        if ( this.images.length <= 0 ){
          return;
        }


        // empty content
        $slider_container.empty().append( this.$el.find('template').html() );

        // attach slides and captions
        for( j=0; j<images.length; j++ ){
          $img = images[j];
          this.$el.find( '.slick-slider' ).append( '<div class="slick-slide"><div class="img-wrapper contain">'  +  $img.prop('outerHTML') + '</div></div>' );
          $cp = $img.parents('.enlarge-gallery-wrap').find( '.data-caption' );
          this.$el.find( '.captions' ).append( '<li>' +  ($cp.length > 0?$cp.html():'') + '</li>' );
        }

        // event to open the enlarge widget
        this.options.$imgs.on( 'click', function(e){
          _this._openOnIndex( $(this) );
        });

        // set numebr slide
        this.$el.find( '.slick-slider' ).on('beforeChange', function(event, slick, currentSlide, nextSlide){
          _this._setNumber( nextSlide );
        });

        // init slider 
        $slider_container.slideshow_ctrl({
        //$content.slideshow_ctrl({
          fade : true,
          autoplay: false,
          dots: false,
          arrows: true,
          prevArrow: this.$el.find('.left'),
          nextArrow: this.$el.find('.right'),
        });    
      
      }
      else{

        if ( this.images.length <= 0 ){
          return;
        }

        // reset all
        this.options.$imgs.off( 'click' );
        this.$el.find( '.slick-slider' ).off('beforeChange');
        $slider_container.slideshow_ctrl('destroy');
        //$content.slideshow_ctrl('destroy');
        $slider_container.empty().append( this.$el.find('template').html() );

      }
    },

    _openOnIndex: function( $img ){
      var index = 0, j = this.images.length;
      while(j--){
        if ( this.images[j].attr('srcset') === $img.attr('srcset') ){
          index = j;
        }
      }      
      this._setNumber( index );

      var $slick = this.$el.find( '.slider-container' ).slideshow_ctrl( 'getSlider' );

      /*
      if ( $('html').hasClass( 'ie11' ) ){
        console.log( this.$el.find( '.slick-slider' ).slick )

      }
      else{
        this.$el.find( '.slick-slider' ).slick( 'slickGoTo', index, true );
      }
      */

      if ( $slick ){
        $slick.slick( 'slickGoTo', index, true );
      }


      this._open( true );
    },

    _setNumber: function( n ){
      this.$el.find( '.number' ).html( (n+1) + '/' + this.images.length );
    },

    _addEvents: function(b){
      var _this = this;
      this._addDebounceResize(b, true);
      if ( b ){
        this.$overlay.find( '.close' ).on( 'click', function(){
          _this._open( false );
        } );
        // Don't close modal when clicking on the background by default, this is for the CA terms modal. Add 'close' class to bg element if you want it to close 
        // this.$overlay.find( '.bg' ).on( 'click', function(){
        //   _this._open( false );
        // } );
      }
      else{
        this.$overlay.find( '.close' ).off( 'click' );
        this.$overlay.find( '.bg' ).off( 'click' );
      }
      this._attachEventsKeyBoard(b)
    },

    _attachEventsKeyBoard: function( b ){
      var _this = this, $slick = this.$el.find( '.slider-container' ).slideshow_ctrl( 'getSlider' );
      if ( b ){      
        $(document).on( 'keydown' , function(e){
          if( e.which === 39 || e.which === 40 ){
            // right arrow or dn
            $slick.slick( 'slickNext' );
          }
          else if ( e.which === 37 || e.which === 38 ){
            // left arrow or up
           $slick.slick( 'slickPrev' );
          }
        });
      }
      else{
        this.$el.off( 'keydown' );
      }
    },

    _addDebounceResize: function(b, resize){
      if ( b ){
        var _this = this;
        this.r_debounce = _.debounce( function(){ _this._onResize() }, 200 );
        this.$win.on( 'resize', this.r_debounce );
        if ( resize ){
          this._onResize();
        }
      }
      else{
        if ( this.r_debounce ){
          this.r_debounce.cancel();
          this.$win.off( 'resize', this.r_debounce );
        }
      }
    },

    _onResize: function(){
    },

    _open: function(b){
      var $o = this.$overlay, _this = this, targetElement = this.$el.find( '.content-scroll' )[0];
      if ( b ){
        $o.css({
          'opacity': 0,
          'visibility': 'visible',
          'pointer-events' : 'auto'
        });
        $( 'html' ).addClass( 'prevent-scroll' );

        bodyScrollLock.disableBodyScroll( targetElement )
      }
      else{

        bodyScrollLock.enableBodyScroll( targetElement )
      }
      TweenMax.to( $o, 0.8, {opacity:b?1:0, ease:'Expo.easeOut',onComplete: function(){
        if ( !b ){
          $o.css({
            'opacity': 0,
            'visibility': 'hidden',
            'pointer-events' : 'none'
          });
          $( 'html' ).removeClass( 'prevent-scroll' );
        }
        else{
        }
      }})
    },

    // public methods **********************************************/
    destroy: function(){
      this._addEvents( false );
      this._createSlideshow( false );
      this.$el.removeData();
      $.data(this, 'plugin_' + pluginName, null);
    }
  };

  $.fn[pluginName] = function ( options ) {
      var args = arguments;
      if (options === undefined || typeof options === 'object') {
          return this.each(function () {
              if (!$.data(this, 'plugin_' + pluginName)) {
                  $.data(this, 'plugin_' + pluginName, new Plugin( this, options ));
              }
          });
      } else if (typeof options === 'string' && options[0] !== '_' && options !== 'init') {
          var returns;
          this.each(function () {
              var instance = $.data(this, 'plugin_' + pluginName);
              if (instance instanceof Plugin && typeof instance[options] === 'function') {
                  returns = instance[options].apply( instance, Array.prototype.slice.call( args, 1 ) );
              }
              if (options === 'destroy') {
                $.data(this, 'plugin_' + pluginName, null);
              }
          });
          return returns !== undefined ? returns : this;
      }
  };

})(jQuery, window, document);


//------------------------------------------------------- MAILCHIMP FORM ---------------------------------------------------------//
;(function ($, window, document, undefined) {
  'use strict';
  var pluginName = "mailchimp_form";
  var defaults = {
    $a_open: ''
  };

  function Plugin(element, options) {
      this.element = element;
      this.options = $.extend({}, defaults, options);
      this._defaults = defaults;
      this._name = pluginName;
      // init!!!!
      this._init();
  }
  Plugin.prototype = {

    // private methods //////////////////////////////////////////////////////////////////////////
    _init: function (){
      //console.log( '>>>>> mailchimp_form ' );
      // vars
      this.$el = $(this.element);
      this.$win = $(window);
      this.$doc = $(document);
      this.$body = $( 'body' );
      this.touch = !$('html').hasClass('no-touch');

      this.$respnse = this.$el.find( '.response' );

      //this.$btn = this.options.$a_open;
      this.open = false;
      this._addEvents( true );
    },
    _addEvents: function( b ){
      var _this = this;
      if ( b ){
        this.$win.on( 'resize', {_this:this}, this._onResize );
        this.$el.find( '.close' ).on( 'click', function(){
          _this._openNewsletterWindow( false );
        } );
      }
      else{
        this.$win.off( 'resize', this._onResize );
        this.$el.find( '.close' ).off( 'click' );
      }
      this._ajaxifyForm( b );
    },
    _onResize: function( e ){
       var _this = e ? e.data._this : this;
    },
    _openNewsletterWindow : function(b){
      var _this = this, $response = this.$el.find( '.response' );
      if ( b ){
        $response.css({opacity:0}).addClass( 'active' );
      }
      TweenMax.to( $response, 0.4, { y:b?-10:0, opacity:b?1:0, onComplete: function(){
        if ( !b ){
          $response.removeClass( 'active' );
          _this._cleanForm();
        }
      }});
      this.$el.trigger( b ? 'newsletter:open' : 'newsletter:close' );
    },
    _cleanForm: function(){
      // clean response
      var $r = this.$el.find( '.response' );
      $r.find( '.message' ).html( '' );
      this.$el.find( 'input[ type="email" ]' ).val( '' );
    },
    _onClickOutside: function(e){
      var _this = e ? e.data._this : this;
      if ( _this.open ){            
        var $container = _this.$el;
        // if the target of the click isn't the container... && ... nor a descendant of the container
        if (!$container.is(e.target)  &&  $container.has(e.target).length === 0) {
            _this._openNewsletterWindow( false );
        }
      }
    },
    _ajaxifyForm: function(b){
      var $form = this.$el.find( 'form' );
      if ( $form.length <= 0 ){
        return;
      }
      var _this = this;
      if ( b ){

        // get the form id (Sometimes there are more forms on the page)
        this.form_ID = $form.attr( 'id' );

        $form.on('submit', function(e) {

            // Prevent form submission
            e.preventDefault();
            _this._setLoading(true);

            // serialize the correct way
            //var data = $form.serializeArray();
            var data = '', $i, j = 0;
            $(this).find( 'input' ).each( function(){
              $i = $(this);
              if ( $i.attr('type') === 'email' || $i.attr('type') === 'hidden' || $i.attr('type') === 'text' ){
                if ( j > 0 ){
                  data += '&';
                }
                data += $i.attr( 'name' ) + '=' + $i.val();
                j++;
              }
            });
            //console.log( data );
            // Use Ajax to submit form data
            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: data,
                success: function(result) {
          
                  // ... Process the result ...
                  setTimeout( function(){
                    // if there are more mailchimp form on the same page ...
                    var $r = $(result);
                    var $f = $r.find( '#' + _this.form_ID );
                    var $response = $f.find( '.mc4wp-response' );

                    if ( $response.length > 0 ){
                      _this._setResponse( $response.html() );
                      _this._setState( $r );
                    }

                  }, 177 );
                  

                }
            });
        });
      }
      else{
        $form.off('submit');
      }
    },

    _setLoading: function( b ){
      TweenMax.to( this.$el.find( 'form' ) , 0.3, {opacity:b?0.4:1} );
    },

    _setResponse: function( response ){
      
      var $r = this.$el.find( '.response' );
      $r.find( '.message' ).html( response );
      this._openNewsletterWindow( true );
      this._setLoading( false );
    },

    _setState: function( $result ){

      var $f = $result.find( '.mc4wp-form' );
      if ( $f.hasClass( 'mc4wp-form-success' ) ){
        this.state = 'SUBSCRIBED';
        // ok, subscribed. You get an email to confirm
        // response:: Thank you. Please check your email to confirm your subscription.
        this.$el.trigger( 'newsletter:subscribed' );
      }
      else if ( $f.hasClass( 'mc4wp-form-error' ) ){
        this.state = 'ERROR';
        // Given email address is already subscribed, thank you!
        // Please provide a valid email address.
        this.$el.trigger( 'newsletter:error' );
      }
      this.$el.trigger( 'newsletter:always' );
    },


    // public methods //////////////////////////////////////////////////////////////////////////
    getState: function(){
      return this.state;
    },
    destroy: function(){
      this._addEvents( false );
      this.$el.removeData();
      $.data(this, 'plugin_' + pluginName, null);
    }

  };

  $.fn[pluginName] = function ( options ) {
      var args = arguments;
      if (options === undefined || typeof options === 'object') {
          return this.each(function () {
              if (!$.data(this, 'plugin_' + pluginName)) {
                  $.data(this, 'plugin_' + pluginName, new Plugin( this, options ));
              }
          });
      } else if (typeof options === 'string' && options[0] !== '_' && options !== 'init') {
          var returns;
          this.each(function () {
              var instance = $.data(this, 'plugin_' + pluginName);
              if (instance instanceof Plugin && typeof instance[options] === 'function') {
                  returns = instance[options].apply( instance, Array.prototype.slice.call( args, 1 ) );
              }
              if (options === 'destroy') {
                $.data(this, 'plugin_' + pluginName, null);
              }
          });
          return returns !== undefined ? returns : this;
      }
  };
})(jQuery, window, document);



//****************** AJAX_SEARCH *****************************************************************
;(function ($, window, document, undefined) {
    'use strict';   

    var pluginName = "search_page";
    var defaults = {
    };

    var thread = null, _result = '';

    function Plugin(element, options) {
        this.element = element;
        this.options = $.extend({}, defaults, options);
        this._defaults = defaults;
        this._name = pluginName;
        this._init();
    }
    Plugin.prototype = {

    // private methods //////////////////////////////////////////////////////////////////////////
    _init: function (){
        
        var _this = this;

        // vars
        this.$el                = $(this.element);
        this.$win               = $(window);
        this.$doc               = $(document);
        this.$body              = $( 'body' );
        this.touch              = !$('html').hasClass('no-touch');

        this.is_open            = false;
        this._enabled           = this.options.open_typing;

        this.$search_input      = this.$el.find( 'INPUT[type="text"]' );
        this.$spinner           = this.$el.find( '.spinner' );
        this.$search_content    = this.$el.find( '#search-content' );
        this.$form              = this.$search_input.closest('FORM');

        this._addEvents( true );

        window.ss360Config = { 
            siteId: 'noguchimuseum.wpengine.com', 
            suggestions: { show: false },
            style: { defaultCss: false },
            tracking: { providers: ['GA'] },
            results: { searchQueryParamName: 'search' },
            searchBox: { selector: '#search-input' },
            callbacks: {
                preSearch: function(query) { _this._doLoading(_this, true); return query; },
                searchResult: function(query) { return _this._doResults(_this, query); },
                searchCallback: function(query) { /* It looks like according to the docs that this must return true for GA tracking to work. */ return true; },
            },
        };

        // $.getScript('https://cdn.sitesearch360.com/sitesearch360-v12.min.js', function() { _this._initSS360(); });
        $.getScript('https://cdn.sitesearch360.com/sitesearch360-v12.min.js');
    
    },

    _addEvents: function( b ){
        if ( b ){
            this.$form.on('submit', {_this:this}, this._doSubmit);
            // this.$icon_open.on( 'click', {_this:this}, this._open );
            // //this.$icon_close.on( 'click',  {_this:this}, this._close );
            // //this.$search_input.on( 'keyup', {_this:this}, this._onKeyUp );
            // if (this.options.open_typing) {
            //     this.$doc.on( 'keydown', {_this:this}, this._docOnKeyDown );
            //     this.$doc.on( 'keyup', {_this:this}, this._docOnKeyUp );
            // }
            // this.$win.on( 'resize', {_this:this}, this._onResize );
            // this.$el.on( 'click',  {_this:this}, this._closeOutside );
            // this.$win.on( 'pajax:transitionCompleted', {_this:this}, this._transitionCompleted );
        } else {
            this.$form.off('submit', this._doSubmit);
            // this.$icon_open.off( 'click', this._open );
            // // this.$icon_close.off( 'click', this._close );
            // // this.$search_input.off( 'keyup', this._onKeyUp );
            // if (this.options.open_typing) {
            //     this.$doc.off( 'keydown', this._docOnKeyDown );
            //     this.$doc.off( 'keyup', this._docOnKeyUp );
            // }
            // this.$win.off( 'resize', this._onResize );
            // this.$el.off( 'click', this._closeOutside );
            // this.$win.off( 'pajax:transitionCompleted', this._transitionCompleted );
        }
    },
    _clearInput: function(){
        this.$search_input.val( '' );
        this.$search_input.focus();
        this._output( '' );
        _result = '';
    },
    _doLoading: function(_this, status) {

        // c('_doLoading');

        // if ( _this.is_open ){
        //   MAIN.setLoading( status );  
        // }
        // _this.$spinner.toggle(status);
    },

    _doSubmit: function() {
        c('_doSubmit');
        return false;
    },

    _doResults: function(_this, query) {

        // Redirect query to specific url.
        if (query.redirect != undefined) {
            document.location.href = query.redirect;
            return;
        }

        if (query.totalResults < 1) {

            _this._output( '<div class="no-results body-text-l text-align-center">No results found ...</div>' );

        } else {

            // Format search results display.

            var append = '';

            // "Term" returned x results.
            append += _this._template('search-template__top', { 'term' : query.query, 'count' : query.totalResults, });
    
            // Open Column Wrapper.
            append += '<div class="columns"><div class="col half">';

            for (let name in query.suggests) {

                var _results        = '';
                var _limit          = (name  == 'News') ? 10 : 99;

                // Loop over all the rows and built this group's results.
                for (let i in query.suggests[name]) {

                    if (i < _limit) {

                        var _row        = query.suggests[name][i];
                        var _subtitle   = _this._rowSubTitle(_row);

                        // Row Template
                        _results += _this._template(_this._templateName(name)[1], {
                            'link' : _row.link,
                            'image': _this._rowImage(_row.image),
                            'title': _this._rowFormatTitle(_row.name),
                            'subtitle': _this._rowSubTitle(_row),
                            'text': _this._rowContent(_row)
                        });

                    }

                }

                // "Other Results" group is always in the second column.
                if (name == '_') {
                    append += '</div><div class="col half">';                }


                // Group Template
                append += _this._template(_this._templateName(name)[0], {
                    'class' : _this._templateName(name)[2] + ' ' + _.hypen( ((name == '_') ? 'Other Results' : name) ) , // add class name to each block
                    'headline' : ((name == '_') ? 'Other Results' : name),
                    'results' : _results,
                });

            };

            // Close Column Wrapper.
            append += '</div></div>';

            _this._output(append);

        }

    },
    _output: function( html, replace ){

        TweenMax.killTweensOf( this.$search_content );

        this._doLoading(this, false);

        this.$search_content.css({opacity:0}).html( '<div class="wrapper-gutter-sizer"> </div>' + html );
        TweenMax.to( this.$search_content, 0.4, {opacity:1, ease: 'Circle.easeOut' });

        // add see more to clamp the blocks
        // this._addSeeMore();

        // special pre-arrange function for layouts
        // this._reorderLayoutBlocks();

        // container grid
        // MAIN.initGridPackery( false, this.$search_content );
        // MAIN.initGridPackery( true, this.$search_content, { itemSelector: '.wrapper-item-grid', gutter: '.wrapper-gutter-sizer' }, false );
        // gird block contained
        // this.$search_content.find( '.grid-packery' ).each( function(){
        //   MAIN.initGridPackery( false, $(this), false , false );
        //   MAIN.initGridPackery( true, $(this), false , false );
        // });

    },

    // _reorderLayoutBlocks: function(){
    //     /*
    //     We might want manually change the order of the layout (items ) before init Grid packery.
    //     e.g : For desktop we cue the project grid so we let the grid fill with the other items and stack the 2 large items
    //     */

    //     // move second large at the end ...
    //     /*
    //     if ( this.$search_content.find( '.large' ).length > 1 && this.$win.width() > 1024 ){
    //         var $item = this.$search_content.find( '.large:eq(1)' );
    //         if ( $item.length > 0 ){
    //           this.$search_content.append( $item );
    //         }
    //     }
    //     */

    //     // if we have project stories and projects, append projects to project stories so they stay in the same column ...
    //     var $s = this.$search_content.find( '.large.project-stories' ), $p = this.$search_content.find( '.large.projects' );
    //     if ( $s.length > 0  && $p.length > 0 ){
    //         $p.removeClass( 'wrapper-item-grid large' ).addClass( 'block-half' ).css({
    //             'margin-top': this.$search_content.find('.wrapper-gutter-sizer').width()
    //         });
    //         $s.find( '.results' ).append( $p );
    //     }
    //     // add hover effects
    //     MAIN.addImgDarkHover( true, this.$search_content );
    // },

    _addSeeMore: function(){
      var _this = this, $it, n, max, max_default = 5, $el, id, $els;
      this.$search_content.find( '.wrapper-item-grid' ).each(function(){
        $it = $(this);
        if ( $it.hasClass( 'news' ) || $it.hasClass( 'market--discipline' ) || $it.hasClass( 'studios' )  || $it.hasClass( 'people' ) || $it.hasClass( 'other-results' )  ){
          
          n = $it.find('.block-half').length;
          max = max_default;
          if ( $it.hasClass( 'people' ) ){
            max = 3;
          }

          if ( n > max ){
            // add read more
            $el = $it.find('.block-half:eq(' + max + ')');
            // generate an unique id
            id = _.uniqueId( 'more_' );
            // elements to wrap
            $els = $el.nextAll().addBack();
            // wrap
            $els.wrapAll( '<div id="' + id + '" class="wrap-more-wrapper"></div>' );
            // add seee more
            $it.find('#'+id).after( '<a href="#" class="see-more text-align-right wrap-more" data-id="' + id + '" data-text="see less -">see more +</a>' );
            // init widget
            MAIN.initWrapMore( true, $it.find('.wrap-more') );

            // check on toggle for refresh the grid when blocks slideToggle
            $it.find('.wrap-more').on( 'wrap-more::change', function(e){
              if ( $(this).data('interval') ){
                clearInterval( $(this).data('interval') );
              }
              var interval = setInterval( function(){
                 _this._refreshMainLayout();
              }, 60 );
              $(this).data('interval', interval );
            });

            $it.find('.wrap-more').on( 'wrap-more::complete', function(e){
              clearInterval( $(this).data('interval') );
              $(this).data('interval', undefined );
              _this._refreshMainLayout();
            });

          }
        }
      })
    },

    _refreshMainLayout: function(){
        //this.$search_content.packery();
    },


    // helper methods //////////////////////////////////////////////////////////////////////////

    _templateName: function(group) {
        var fallback    = ['search-template__group-list', 'search-template__item-other', ''];
        var map         = {
            'Digital Features'              : ['search-template__group-list', 'search-template__item-grid', ''],
            'Exhibitions'                   : ['search-template__group-list', 'search-template__item-grid', ''],
            'Archive & Catalogue Raisonné'  : ['search-template__group-grid', 'search-template__item-ca', ''],
        };
        return ((map[group] != undefined) ? map[group] : fallback);
    },

    _template: function(name, data) {
        var html = $('#'+name).text();
        for (let key in data) {
            var regex = new RegExp("{{" + key + "}}", "g");
            html = html.replace(regex, data[key]);
        }        
        return html;
    },
    _rowFormatTitle : function(string) {
        string = string.replace(' - The Noguchi Museum', '');
        return string;
    },
    _rowSubTitle: function(item) {
        if (item.dataPoints.length) {
            for (let i in item.dataPoints) {
                if (item.dataPoints[i]['key'] == 'subtitle') {
                    return item.dataPoints[i]['value'];
                }
            }
        }
        return '';
    },
    _rowContent : function(item) {
        if (item.dataPoints.length) {
            for (let i in item.dataPoints) {
                if (item.dataPoints[i]['key'] == 'description') {
                    return item.dataPoints[i]['value'];
                }
            }
        }
        return item.content;
    },
    _rowImage: function(image) {
        if (image == null) return '';
        image = image.replace("http:", "https:");
        return '<img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="'+ image +'" class="lazyload" data-pin-nopin="true" />';
    },

    // public methods //////////////////////////////////////////////////////////////////////////

    destroy: function(){
        this._addEvents( false );
        this.$el.removeData();
        $.data(this, 'plugin_' + pluginName, null);
    }

  };

  $.fn[pluginName] = function ( options ) {
      var args = arguments;
      if (options === undefined || typeof options === 'object') {
          return this.each(function () {
              if (!$.data(this, 'plugin_' + pluginName)) {
                  $.data(this, 'plugin_' + pluginName, new Plugin( this, options ));
              }
          });
      } else if (typeof options === 'string' && options[0] !== '_' && options !== 'init') {
          var returns;
          this.each(function () {
              var instance = $.data(this, 'plugin_' + pluginName);
              if (instance instanceof Plugin && typeof instance[options] === 'function') {
                  returns = instance[options].apply( instance, Array.prototype.slice.call( args, 1 ) );
              }
              if (options === 'destroy') {
                $.data(this, 'plugin_' + pluginName, null);
              }
          });
          return returns !== undefined ? returns : this;
      }
  };

})(jQuery, window, document);


var MAIN, PAJX = window.PAJX, DV = window.DV, c = console.log;

(function( $ ) {

	// global vars helpers
	var $html, $body, $window, $doc, baseURL, is_ajax, index_open, index_open_2;

	// --- set this up for ajax load via PAJAX --//
	is_ajax = true;	
	//

	MAIN = {
		init: function(){

			$window = $(window);
			$doc = $(document);
			$html = $('html');
			$body = $('body');
			baseURL = window.location.origin;

            // No Barba for Collective Access pages.
            // if ( $body.hasClass('collective-access') ){
            //     is_ajax = false;
            // }

			if ( $html.hasClass('ie11') ){
				//is_ajax = false;
			}

			this.index = -1;

			this._logFOUO( 'For Office Use Only' );
			this._extendUnderscore();
			this._Polyfills();

			this._initAjax();
			this._initMAIN();
			this._initSearch();


			this._initImages(); // for lazyimages
			this._initGDPR(); // GDPR Bar with link to privacy (cookie controlled)

			var r = _.debounce( function(){
				MAIN._onResize()
			}, 200 );
			$window.on( 'resize', r );

			this._onResize();
		},

		_onResize: function(){
			if ( $body.hasClass( 'home' ) ){
				var $ul, $li_img, $li_txt;

				// mobile and desktop
				$( '.home-main-promo' ).each( function(){

					// vertical layout set height of column text and img col what remain
					$(this).find('.vert-layout' ).each(function(){

						$ul = $(this);

						$li_img = $ul.find('> li:eq(0)');
						$li_txt = $ul.find('> li:eq(1)');

						$li_txt.css({'height':'auto'});

						$li_txt.height( $li_txt.find('.text-int').outerHeight() );
						$li_img.height( $ul.height() - $li_txt.height() );

					});

				});
			}

			// this class is used for layouts that need to be resized before revealed. For example .home-main-promo (opacity=0 and resized opacity 1)
			$body.addClass( 'resized' );
		},

		_initAjax: function(){
			if ( is_ajax ){
				$window.on( 'pajax:initStateChange', function(){

					if ( $html.hasClass('ie11') && $body.hasClass( 'home' ) ){
						$('section.background').css({'visibility':'hidden'});
					}


					MAIN._openMainMenu( false );
					MAIN.setLoading( true );
					PAJX.state = 'init';
				});
				$window.on( 'pajax:newPageReady', function(){
					if ( PAJX.state === 'fadeout' ){
						MAIN.initPageSpecific( false );
						TweenMax.to( $window, 0, {scrollTo:0, ease:'Sine.easeOut'});
						PAJX.parseResponse();
					}
					else{
						PAJX.state = 'ready';
					}
				});
				$window.on( 'pajax:EndfadeOut', function(){
					if ( PAJX.state === 'ready' ){
						MAIN.initPageSpecific( false );
						TweenMax.to( $window, 0, {scrollTo:0, ease:'Sine.easeOut'});
						PAJX.parseResponse();
					}
					else{
						PAJX.state = 'fadeout';
					}
				});
				$window.on( 'pajax:parsedResponse', function(){
					PAJX.state = 'parsed';
					_.delay( function(){
						MAIN.initPageSpecific( true );
						PAJX.fadeInFromExt();
						MAIN.setLoading( false);
                        MAIN.initAddToCalendar(true);
					}, 77 );
				});
				$window.on( 'pajax:EndfadeIn', function(){
					//console.log('pajax:EndFadeIn');
				});
				$window.on( 'pajax:EndfadeInFromExt', function(){
					//console.log('pajax:EndfadeInFromExt');
				});
				$window.on( 'pajax:transitionCompleted', function(){
					//console.log('pajax:transitionCompleted');
					//MAIN.setLoading( false);
				});
				PAJX.init( this, {
					fade_out: $html.hasClass('ie11') ? 0 : 0.2,
					fade_in: 0.6
				} );
			}
		},

		_Polyfills: function(){
			// polyfill for ie on images
			// IMPORTANT : THIS HAS TO BE USE ONLY WITHOUT LAZYSIZES (Eg. Collective Access)
			// objectFitImages();
		},

		//--------------- LAZY IMAGES ----------------//
		_initImages: function(){
			lazySizesConfig = window.lazySizesConfig;
			if ( lazySizesConfig ){
				// https://github.com/aFarkas/lazysizes
				// default to 2 (load also near elements)

				// load only visible elements
				lazySizesConfig.loadMode = 1; // default to 2
				lazySizesConfig.expFactor = 1; //1.1; // default 1.5	
				lazySizesConfig.expand = 90; //100; // 370-500

				// init lazySizes
				lazySizes.init();
			}
		},

		setLoading: function(b){
			if ( b ){
				NProgress.start();
			}
			else{
				NProgress.done();
			}
		},

		//---------------------------------------------------- MENU  -----------------------------------------//
		_initMenu: function(){
			var $m = $('#menu-main-menu'), $li, $sub, $a, $lis = $m.find( '> li' );
			
			//---------- toggle --------------------------------------//
			$m.find( '> li' ).each(function(i){
				$li = $(this);
				
				$sub = $li.find( '.sub-menu' );
				$li.data('sub', $sub );

				$a = $li.find( '> a' );
				$a.data( 'index', i );
				$a.addClass( 'no-barba' );
				$a.on( 'click', function(e){
					e.preventDefault();

					if ( $html.hasClass( 'menu-open' ) ){
						return;
					}
					
					$a = $(this);
					$li = $a.parents( 'li' );
					
					MAIN._cleanSubMenus();
					MAIN._cleanSelection( $m.find( '> li' ) );
					MAIN._cleanSelection( $m.find( '.sub-menu li' ) );

					if ( MAIN.index === $a.data('index') ){
						MAIN._toggleMainMenu();
					}
					else{
						MAIN._openMainMenu( true );
					}
					// set selection
					/*
					if ( $html.hasClass( 'menu-open' ) ){
						$li.addClass( 'selected' );
					}
					*/					
					MAIN.index = $a.data('index');
				});
				$a.on( 'hover', function(){
					//MAIN._cleanSubMenus();
					//MAIN._cleanSelection( $m.find( '> li' ) );				
				});
			});

			//---------- close ------------------------------------//
			$m.find( 'li' ).on( 'clickout', function(){
				if ( $window.width() >= 768 ){
					MAIN._openMainMenu( false );
				}				
			});

		},
		_cleanSubMenus: function(){
			var $m = $('#menu-main-menu'), $lis = $m.find( '> li' );
			$lis.removeClass( 'selected' );
		},
		_openMainMenu: function(b){
			if ( b ){
				$html.addClass( 'menu-open' );
			}
			else{
				MAIN.index = -1;
				$html.removeClass( 'menu-open' );
				this._cleanSubMenus();
				this._paintMenu();
			}
		},
		_toggleMainMenu: function(){
			this._openMainMenu( ! $html.hasClass( 'menu-open' ) );
		},
		_paintMenu: function(){
			var $li, i, j, _class, $menu, 
			// paint menu (where to check the current selection)
			$p = $('#menu-main-menu-1'), 			
			// menus to update
			menus = [ 

				// main menus desktop and mobile
				$('#menu-main-menu'), 
				$('#menu-mobile-menu'),  

				// footer menus
				$('#menu-footer-menu'),
				$('#menu-footer-menu-1'),
				$('#menu-privacy-terms'),
				$('#menu-privacy-terms-1')

			],
			// classes to search
			needle = [ 'current-page-ancestor', 'current-menu-item' ];

			// clean --------------------------//
			for( j=0; j<menus.length; j++ ){
				$menu = menus[j];
				this._cleanSelection( $menu.find( 'li' ) );
			}
			
			// set!! --------------------------//
			for( i=0; i<needle.length; i++ ){
				_class = needle[i];
				if ( $p.find( '.' + _class ).length > 0 ){
					$p.find( '.' + _class ).each( function(){
						u = $(this).find( ' > a').attr('href');
						for( j=0; j<menus.length; j++ ){
							$menu = menus[j];
							$li = $menu.find( 'a[href="' + u + '"]' ).parents('li');
							if ( $li.length > 0 ) {					
								$li.addClass( _class );
							}							
						}
					});
				}
			}

			//--------------- single custom post type -----------------------//
			$menu = menus[0];
			_class = needle[0];
			if ( $body.hasClass( 'single-feature' ) ){
				$menu.find( ' > li:eq(0)' ).addClass( _class ); //	Isamu Noguchi
			}
			if ( $body.hasClass( 'single-collection' ) || $body.hasClass( 'single-public_work' ) ){
				$menu.find( ' > li:eq(1)' ).addClass( _class ); //	Artworks
			}
			if ( $body.hasClass( 'single-exhibition' ) || $body.hasClass( 'single-event' ) ){
				$menu.find( ' > li:eq(2)' ).addClass( _class ); //	Museum
			}

			//---------------- if there is no menu item selected ALL BLACKS!!!!!!!
			if ( !$menu.find('li').hasClass( 'current-page-ancestor' ) && !$menu.find('li').hasClass( 'current-menu-item' ) ) {
				$menu.find('li').addClass( 'state-all-unselected' );
			}

		},
		_cleanSelection: function( $li ){
			$li.removeClass( 'current-page-ancestor' ).removeClass( 'current-menu-item' ).removeClass( 'state-all-unselected' );
		},


		//----------------------- MOBILE -----------------------------------------//
		_initMenuMobile: function(){
			var $m = $('#menu-mobile-menu'), $li, $sub, $a, $l;

			// attach 'open today'
			$m.find( '> li:eq(0)' ).append( $('#panel-mobile .visit') );

			//----------- accordeon --------------------------------//
			$m.find( '> li.menu-item-has-children' ).each(function(){
				$li = $(this);
				
				$sub = $li.find( '> .sub-menu' );
				$sub.css({
					'max-height' : $sub.outerHeight()
				})
				$sub.slideUp(0);
				$li.data('sub', $sub );

				$a = $li.find( '> a' );
				$a.addClass( 'no-barba' );


				$a.on( 'click', function(e){
					e.preventDefault();

					$l = $(this).parent( 'li' );
					if ( $l.hasClass( 'open' ) ){
						$l.data('sub').slideUp(300);
						$l.removeClass( 'open' );
						return;
					}
					else{
						// close if some is open
						$m.find( '> li.menu-item-has-children' ).each(function(){
							$li = $(this);
							if ( $li.hasClass( 'open' ) ){
								$li.data('sub').slideUp(300);
								$li.removeClass( 'open' );
							}
						})
						$l.data('sub').slideDown(300);
						$l.addClass( 'open' );
					}
				})
			});

			$('#panel-mobile').removeClass( 'let-calculate' );
			
			//----------- open/close --------------------------------//
			$('.burger a').on( 'click', function(e){
				e.preventDefault();
				MAIN._openPanelMobile(true);
			} )
			$('.close-menu-mobile a').on( 'click', function(e){
				e.preventDefault();
				MAIN._openPanelMobile(false);
			} )
		},
		_openPanelMobile: function(b){
			if ( b ){
				$html.addClass( 'menu-open' );
				$body.addClass( 'menu-open' );
			}
			else{
				$html.removeClass( 'menu-open' );
				$body.removeClass( 'menu-open' );
			}
			//console.log( '_openPanelMobile, b ' + b + ', nenu-open = ' + $html.hasClass( 'menu-open' ) );
		},


		//------------------------------------------- MAILCHIMP --------------------------------------------------//
		_initMailChimp: function(b){
	    	var $win = $('.mailchimp-newsletter-form');
	    	if ( $win.length <= 0 ){
	    		return;    		
	    	}
	    	if ( b ){
		        $win.mailchimp_form();

		        // close the form if success
		        $win.on( 'newsletter:subscribed', function(e){
					MAIN.setGAEventByName( 'Newsletter' )
		        });

		        $win.on( 'newsletter:always', function(e){
		        	//console.log( e )
		        });

		        $win.on( 'newsletter:close', function(e){
		        	//console.log( e )
		          // set cookie
		          //Cookies.set( cookie , 'active', { expires: 1 }); // cookie will expire in one day
		        });
	    	}
	    	else{
	    		$win.mailchimp_form( 'destroy' );
	    	}
		},

		//--------------------------------------------------- MAIN -----------------------------------------------//
		_initMAIN: function(){
			//console.log( '>>>> _initMAIN' );
			//1) general overall functions
			this._initMenu();
			this._initMenuMobile();
			this._initMailChimp(true);

			//2) page specific
			this.initPageSpecific(true, true);
		},

		//-------------------------------------------- SEARCH ----------------------------------------------------//
		_initSearch: function(){
            // $( '#search-layer' ).search_layer({
            //     $icon_open: $('.search, .search-mobile a'),
            // });            
			$('HEADER .search, HEADER .search-mobile a').on( 'click', function(e){
				e.preventDefault();
				MAIN._toggleSearch();
			} );

			$('#search-layer .close-search').on( 'click', function(e){
				e.preventDefault();
				MAIN._openSearch( false );
			} );

            $('#search-layer FORM').on( 'submit', function(e){
                $('#search-layer .spinner').show();
            } );

		},
		_toggleSearch: function(){
			this._openSearch( ! $html.hasClass( 'search-open' )  );
		},
		_openSearch: function(b){
			// console.log( '_openSearch, b = ' + b );
			if ( b ){
				$html.addClass( 'search-open' );
                $('#search-layer INPUT[type="text"]').focus();
			}
			else{
				$html.removeClass( 'search-open' );
			}
		},

		// -------------------- PAGE FUNCTIONS -------------------------------------------------- //
		initPageSpecific: function(b, firstTime){
			if( b ){
				EFFX.init();
				//if ( !firstTime ){
					this._paintMenu();
				//}
				this._setViews();
			}
			else{
				EFFX.destroy();
			}
			this.initWidgets(b, firstTime);

            if ( $body.hasClass( 'page-template-page-museum-visit-gallery' ) ){
                this.initGalleryPage(b);
            }

            if ( $body.hasClass( 'single-collection' ) ){
                this.initCollectionDetail(b);
            }

            if ( !firstTime ){
            	setTimeout( function(){
            		$window.trigger( 'resize' );
            	}, 17 );
            }
		},

		_setViews: function(){

			// Named differently only to keep trak of what is in View ...
			var _classes = ['biography-barba-view', 'visit-barba-view', 'exhibitions-barba-view', 'education-barba-view', 'support-barba-view', 'press-barba-view'], 
			$view, i;

			for( i=0; i<_classes.length; i++ ){
				$view = $( '.' + _classes[ i ] );
				if ( $view.length > 0 ){
					$('.module_page_section_nav a').addClass( 'barba-view' ).attr( 'data-view', _classes[ i ] );
				}
			}

		},

        initGalleryPage: function(b) {

            var navs        = $('A[rel="Gallery:Show"]');
            var sections    = $('.desktop_view SECTION.gallery');

            if (b) {

                sections.hide().css('visibility', 'visible');
                sections.eq(0).fadeIn();

                navs.click(function() {

                    sections.hide();
                    sections.eq( $(this).data('index') ).show();

                    navs.removeClass('current');
                    $(this).addClass('current');

                    sections.eq( $(this).data('index') ).find('.manual-init').removeClass('manual-init');

                    MAIN.initSlideShows(true);

                    return false;

                });

                navs.eq(0).trigger('click');

            } else {
                navs.off('click');
            }

        },

        initCollectionDetail: function(b) {

return;

            var offset          = 410;
            var sizer           = $('.img-sizer');
            var sizer_height    = sizer.outerHeight();

            var resize  = function(){

                var win_width   = $window.width();
                var win_height  = $window.height();

                if (win_width <= 768) {
                    // Don't do any resizing on tablet and mobile
                    sizer.width('auto').css({'margin-right':'auto'});
                } else if (sizer_height + offset > win_height) {
                    // Resize image so it's entirely visbible.
                    sizer.width( win_height - offset ).css({'margin-right':'0'});
                } else {
                    sizer.width('auto').css({'margin-right':'auto'});
                }

            };

            if (b) {
                $window.on( 'resize.CollectionDetail', _.debounce( resize, 200));
                resize();
            } else {
                $window.off( 'resize.CollectionDetail' );                
            }

        },

        //----------------------------------- WIDGETS ---------------------------------------------------//
	    initWidgets: function(b, firstTime){

//c('initWidgets');

            this.initGridPackery(b, $('.grid-packery').not('.manual-init'), false, false);

            this.initForms(b);

            this.initSlideShows(b);

            this.initModals(b);

          	this.initFilters(b);

            this.initAccordian(b);

            this.initSelects(b);

            this.initVideos(b);

            this.initImageEnlargeGallery(b);

            this.initDisableSaveAs(b);

            this.initPagination(b);

            // Google Analytics Events
            this.initEventTracking(b, firstTime);

            // Google Translate Widget (Visit Page)
            if (( $el = $('.module_language_select') )) {
                if ( b ){
                    $el.each(function(){
                        $(this).language_select();
                    });
                } else {
                    $el.language_select('destroy');
                }
            }

            // Google Map Widget (Visit Page)
            if (( $el = $('.module_map_embed') )) {
                if ( b ){
                    $el.each(function(){
                        $(this).map_embed();
                    });
                } else {
                    $el.map_embed('destroy');
                }
            }
            
            // skin select mobile (just to look beautiful on desktop )
            if ( b ){
            	if ( $( '.sumo-select-skinned' ).length > 0 ){
            		$('.sumo-select-skinned').SumoSelect();
            	}
            }

            // digital features
            if (( $el = $('main.digital_features') )) {
                if ( b ){
                    $el.digital_features();
                } else {
                    $el.digital_features('destroy');
                }
            }

            // Search Results Page
            if (( $el = $('main.search_results') )) {
                if ( b ){
                    $el.search_page();
                } else {
                    $el.search_page('destroy');
                }
            }

            if (( $el = $('.toggle-shuffle') )){
            	if ( b ){
            		$el.on( 'change', function(){
            			var $grid = $('.' + $(this).attr( 'data-grid' ));
            			$grid.toggleClass( 'grid-shuffle' );
            			if ( $grid.hasClass( 'grid-packery' ) ){
            				$grid.packery();
            			}
            		})
            	}
            }
                
            // Line clamping
            this.initClamps(b);


	    },



        //------------------------------------ GOOGLE ANALYTICS EVENTS -------------------------------------------------//
        initEventTracking: function(b, firstTime){
            // Only add when first setting up the page.
            //if (!b || firstTime == undefined) return false;

			// NEON
			// * Membership Signup
			// * Support Donation (for each type: Spring Benefit, Give a Gift, etc)
			// * Calendar Event & Education Signup

			// COLLECTIVE ACCESS
			// * Account Registration

			// Events to be hook only one time ( HEADER/FOOTER )
			if ( firstTime ){
				
				if ( b ){

					this.initGAGlobalEvents();
				
				}

			}

			// Page Events (first time and every page load via ajax)
			this.initGAPageEvents(b);
        },

	    //-------------------- START GA EVENTS FOR GOALS ---------------------------------------------------------------------------//

	    // call once, the first time
	    initGAGlobalEvents: function(){

			// Contact from Footer-------------------------------------//
			$('#menu-item-280 a').on( 'click', function(e){
				MAIN.setGAEventByName( 'Contact' );
			} );

			// Socials (Footer)-------------------------------------//
			$('ul.socials a').on( 'click', function(e){
				MAIN.setGAEventByName( 'Social', $(this).attr( 'href' ) );
			} );

			// Shop from Main Nav-------------------------------------//
			$('#menu-item-247 a').on('click', function(e){
				// akari light sculpture
				MAIN.setGAEventByName( 'Shop From Nav', $(this).attr('href') );
			});
			$('#menu-item-248 a').on('click', function(e){
				// noguchi shop
				MAIN.setGAEventByName( 'Shop From Nav', $(this).attr('href') );
			});
			//------- MOBILE -------------------------------------//
			$('#menu-item-269 a').on('click', function(e){
				// akari light sculpture
				MAIN.setGAEventByName( 'Shop From Nav', $(this).attr('href') );
			});
			$('#menu-item-270 a').on('click', function(e){
				// noguchi shop
				MAIN.setGAEventByName( 'Shop From Nav', $(this).attr('href') );
			});

			// -------------------------------------//
			$('#main-header .visit a').on('click', function(e){
				// desktop
				MAIN.setGAEventByName( 'Visit From Top Header' );
			});
			$('#menu-item-701 a').on('click', function(e){
				// mobile
				MAIN.setGAEventByName( 'Visit From Mobile Menu' );
			});

	    },

	    // call after load new page
	    initGAPageEvents: function(b){
	    	var $a, label;
	   
    		// home page -----------------------------//
    		if ( $body.hasClass( 'home' ) ){
    			$a = $('section.shop-promos').find( 'a' );
    			if ( $a.length > 0 ){
    				if ( b ){
	    				$a.on( 'click', function(){
	    					if ( $(this).hasClass( 'button' ) ){
	    						MAIN.setGAEventByName( 'Shop Home Promo Button' );
	    					}
	    					else{
	    						MAIN.setGAEventByName( 'Shop Home Promo Image' );
	    					}	    					
	    				});
    			 	}
    			 	else{
    			 		$a.off( 'click' );
    			 	}
    			}

    			// visit from mobile homepage
    			$a = $('.open-today .visit').find( 'a' );
    			if ( $a.length > 0 ){
    				if ( b ){
	    				$a.on( 'click', function(){
	    					MAIN.setGAEventByName( 'Visit From Mobile Homepage' );					
	    				});
    			 	}
    			 	else{
    			 		$a.off( 'click' );
    			 	}
    			}
    		}

    		// visit page Map
    		if ( $body.hasClass( 'page-template-page-museum-visit-main' ) ){
				$a = $('.eyebrow.directions').find( 'a' );
				if ( b ){
    				$a.on( 'click', function(e){
    					MAIN.setGAEventByName( 'Visit Map', $(this).text() );
    				});
    			}
    			else{
    				$a.off( 'click' );
    			}

    			// visit directions
				$a = $('.wysiwyg').find( 'a' );
				if ( b ){
    				$a.on( 'click', function(e){
    					MAIN.setGAEventByName( 'Visit Directions', $(this).text() );
    				});
    			}
    			else{
    				$a.off( 'click' );
    			}
    		}

    		// videos --------------------------------//
    		$a = $('.video-embed');
    		if ( $a.length > 0 ){
    			if ( b ){
    				$a.on( 'click', function(e){
    					MAIN.setGAEventByName( 'Video Play', $(this).find( 'iframe' ).attr( 'href' ) );
    				});
    			}
    			else{
    				$a.off( 'click' );
    			}
    		}

    		// digital feature next DF
    		$a = $('a.next-digital');
    		if ( $a.length > 0 ){
    			if ( b ){
    				$a.on( 'click', function(e){
    					MAIN.setGAEventByName( 'Next Digital Feature', $(this).find( 'h1.headline-l' ).text() ); // we pass the title of next exhibition
    				});
    			}
    			else{
    				$a.off( 'click' );
    			}
    		}
	 
    		// download exhibition page --> pdf
    		if ( $body.hasClass( 'single-exhibition' ) ){
	    		$a = $('ul.downloads a');
	    		if ( $a.length > 0 ){
	    			if ( b ){
	    				$a.on( 'click', function(e){
	    					// MAIN.setGAEventByName( 'PDF Download', $(this).attr( 'href' ) );
	    					// here the label is the href of the pdf, if we want the title just pass $('h1.headline-l').text()
	    					MAIN.setGAEventByName( 'PDF Download', $('h1.headline-l').text() );
	    				});
	    			}
	    			else{
	    				$a.off( 'click' );
	    			}
	    		}
    		}

	    },

	    setGAEventByName: function( name, label ){

			// WEBSITE
			// * Contact page click (from footer)
			//    onclick="ga('send', 'event', 'Click To', 'Contact', 'From Footer');" 
			// * Contact form submit
			// * Newsletter signups
			// * Social media clicks (for each platform)
			// * Shop promo module clicks
			//    onclick="ga('send', 'event', 'Click To', 'Shop', 'From Home Promo');" 
			// * Shop clicks from Main nav
			//    onclick="ga('send', 'event', 'Click To', 'Shop', 'From Main Nav');" 
			// * Visit page clicks from top header hours
			//    onclick="ga('send', 'event', 'Click To', 'Visit', 'From Desktop Header');" 
			// * Visit clicks from Mobile Main Nav
			//    onclick="ga('send', 'event', 'Click To', 'Visit', 'From Mobile Header');" 
			// * Google Maps clicks on Visit page
			//    ga('send', 'event', 'Visit', 'Map', 'Bus');
			//    ga('send', 'event', 'Visit', 'Directions List', 'Bus');
			//    ga('send', 'event', 'Visit', 'Directions Text', 'Bus');
			// * Video play clicks
			// * Digital Feature: next Feature click
			//    onclick="ga('send', 'event', 'Click To', 'Digital Feature Next');" 
			// * Exhibition pdf downloads
			//    onclick="ga('send', 'event', 'Download', 'Exhibition PDF', 'EXHIBITION_NAME');" 

	    	switch ( name ){
	    		case 'Contact':
	    			this.setGAEvent( 'Click To', 'Contact', 'From Footer', false );
	    		break;
	    		case 'Newsletter':
	    			this.setGAEvent( 'Signup', 'Newsletter', 'From Footer', false );
	    		break;
	    		case 'Social':
	    			this.setGAEvent( 'Social', 'Outbound Link', label, true );
	    		break;
	    		case 'Shop Home Promo Image':
	    			this.setGAEvent( 'Click To', 'Shop', 'From Image', true );
	    		break;
	    		case 'Shop Home Promo Button':
	    			this.setGAEvent( 'Click To', 'Shop', 'From Button', true );
	    		break;
	    		case 'Shop From Nav':
	    			this.setGAEvent( 'Click To', 'Shop', label, true );
	    		break;
	    		case 'Visit From Top Header':
	    			this.setGAEvent( 'Click To', 'Visit', 'From Desktop Header', false );
	    		break;
	    		case 'Visit From Mobile Menu':
	    			this.setGAEvent( 'Click To', 'Visit', 'From Mobile Header', false );
	    		break;
	    		case 'Visit From Mobile Homepage':
	    			this.setGAEvent( 'Click To', 'Visit', 'From Mobile Homepage', false );
	    		break;
	    		case 'Visit Map':
	    			this.setGAEvent( 'Visit', 'Map', label, true );
	    		break;
	    		case 'Visit Directions':
	    			this.setGAEvent( 'Visit', 'Directions', label, true );
	    		break;
	    		case 'Video Play':
	    			this.setGAEvent( 'Videos', 'Play', label?label:'Embed Click', false );
	    		break;
	    		case 'Next Digital Feature':
	    			this.setGAEvent( 'Click To', 'Digital Feature Next', label, false );
	    		break;
	    		case 'PDF Download':
	    			this.setGAEvent( 'Download', 'Exhibition PDF', label, true );
	    		break;
                case 'CA Account Registration':
                    this.setGAEvent( 'CA Account Registration', 'Registration', 'Registration', false );
                break;
	    	}
	    },

	    setGAEvent: function( category, action, label, transport ){
	    	var ga = window.ga, send = true;
	    	if ( ga ){
	    		if ( transport ){
					ga('send', 'event', {
					    eventCategory: category,
					    eventAction: action,
					    eventLabel: label,

					    // useful for Outbound Links ...
					    transport: 'beacon' 
				  	});
	    		}
	    		else{
	    			ga('send', 'event', category, action, label );
	    		}
	    	}
	    	else{
	    		send = false;
	    	}
	      	console.log( 'GA.goal send ' + send + ', category: ' + category + ', action ' + action + ', label = ' + label );
	    },

	    //-------------------- END GA EVENTS FOR GOALS ---------------------------------------------------------------------------//


        //------------------------------------ ADD TO CALENAR -------------------------------------------------//
        initAddToCalendar: function(b){

            // This should only be called on Pjax requests, the script automatically triggers on initial page view (weird).
            if (( $el = $('.add-to-calendar') )) {
                $el.each(function(){
                    createCalendar(this);
                });
            }

        },

        //------------------------------------ SLIDESHOWS -------------------------------------------------//
        initDisableSaveAs: function(b, $context){
        
            if (b) {
                $body.on('contextmenu', 'img', function(){
                    // var c = confirm('© The Isamu Noguchi Foundation and Garden Museum');
                    // if (c) document.location.href = "/about/contact";
                    // alert('© The Isamu Noguchi Foundation and Garden Museum');
                    return false;
                });
            } else {
                $body.off('contextmenu');
            }

        },


	    //------------------------------------ SLIDESHOWS -------------------------------------------------//
	    initSlideShows: function(b, $context){
	    	var $el, $s, $p;

            //---------- Slideshow ------------//
            $el = $context ? $context.find( '.module_slideshow' ) : $('.module_slideshow');
            if ( $el.length > 0 ){
                if ( b ){
                    $el.each(function(i){
                    	$s = $(this);
                    	   
                        // Make sure this has not already been init.
                        // if ( $s.hasClass('slideshow-ctrl-init') ) return;

                        if ( ! $s.hasClass( 'manual-init' ) ){
	                    	var o = {
		                    	fade : $s.hasClass( 'option-slide' ) ? false :  true,
		                    	autoplay: $s.hasClass( 'autoplay' ),
		                        dots: !$s.hasClass( 'no_dots' ),
		                        arrows: $s.hasClass( 'arrows' ),
		                        responsive: !$s.hasClass( 'no-responsive' ),
		                        adaptiveHeight: $s.hasClass( 'adaptive-height' ),
		                        delayAutoplay: i*777
		                    };

		                    // if specify autoplay speed (see home )
		                    if ( $s.attr( 'data-time-autoplay' ) ){
		                    	o.autoplaySpeed = parseInt( $s.attr( 'data-time-autoplay' ) ) * 1000;
		                    }

		                    if ( $s.attr( 'data-as-nav' ) ){
		                    	o.asNavFor = '.' + $s.attr( 'data-as-nav' );
		                    }

		                    if ( $s.attr( 'data-is-nav' ) ){
		                    	o.centerMode = false;
		                    	o.slidesToShow = $s.find( '.slick-slide' ).length;
		                    	o.infinite = false;
		                    	o.focusOnSelect = true;
		                    }

		                    if ( $s.hasClass( 'is-finite' ) ){
		                    	o.infinite = false;
		                    }

		                    $s.slideshow_ctrl( o );

		                    //-------------- object viewer : Sync Slideshow and Thumbnails ----------------//
		                    $s = $( '.slideshow-thumbnails' );
		                    if ( $s.length > 0 && $s.attr( 'data-is-nav' ) ){

		                    	// change the slide when clicked thumbnail
		                    	$s.find( 'a' ).on( 'click', function(e){
		                    		e.preventDefault();
		                    		$s = $(this).parents( '.slideshow-thumbnails' );
		                    		$p =  $( '.' + $s.attr( 'data-as-nav' ) );	                    			
		                    		$p.slick( 'slickGoTo', parseInt( $(this).attr( 'data-index' ) )  ); 
		                    	});

		                    	// set thumbnail selected when changed slide ...
		                    	$s = $( '.' + $s.attr( 'data-as-nav' ) );
		                    	$s.on( 'beforeChange', function(e,slick,currentSlide, nextSlide){
		                    		$p = $( '.' + $(this).parent().attr( 'data-thumbnails' ) );
		                    		$p.find('a').removeClass( 'selected' );
		                    		$p.find('li:eq(' + nextSlide + ') a').addClass( 'selected' );
		                    	});
		                    }
	                    }


                    	// ------------------------ MANUAL INIT :: SPECIAL CASES ---------------------------//
	                    if ( $s.hasClass( 'slideshow-related' ) ){
	                    	var args = {
								dots: true,
								infinite: !$s.hasClass( 'is-finite' ),
								slidesToShow: 9,
								slidesToScroll: 1,
								//centerMode: true,
								adaptiveHeight: true,
								arrows: false,
								responsive: [
									{
									  breakpoint: 1790,
									  settings: {
									    slidesToShow: 7,
									  }
									},
									{
									  breakpoint: 1279,
									  settings: {
									    slidesToShow: 5,
									  }
									},
									{
									  breakpoint: 1023,
									  settings: {
									    slidesToShow: 4,
									  }
									},
									{
									  breakpoint: 767,
									  settings: {
									    slidesToShow: 3,
									  }
									},
									{
									  breakpoint: 640,
									  settings: {
									    slidesToShow: 2,
									  }
									},
									{
									  breakpoint: 480,
									  settings: {
									    slidesToShow: 1,
									  }
									}
								]                    		
							}
	                    	$s.slideshow_ctrl({
	                    		customArgs: true,
	                    		args: args
	                    	});
	                    }

	                    if ( $s.hasClass('slideshow-upcoming-off-site-exhibitions') ){
	                    	var args = {
								dots: false,
								infinite: true,
								slidesToShow: 3,
								slidesToScroll: 1,
								//centerMode: true,
								//adaptiveHeight: true,
								arrows: true,
								prevArrow: $s.find('.left'),
								nextArrow: $s.find('.right'),

								responsive: [
									{
									  breakpoint: 1023,
									  settings: {
									    slidesToShow: 2,
									    dots: true
									  }
									},
								]                    		
							}
	                    	$s.slideshow_ctrl({
	                    		customArgs: true,
	                    		args: args
	                    	});
	                    }

	                    if ( $s.hasClass('slideshow-carousel') ){
	                    	var args = {
								dots: true,
								arrows: false,
								infinite: true,
								slidesToScroll: 1,
	  							centerMode: true,
	  							variableWidth: true,

								responsive: [
									{
									  breakpoint: 767,
									  settings: {
									    centerMode: true,
									  }
									},
								]                    		

	  						};

	  						if ( $s.hasClass( 'arrows' ) ){
	  							args.arrows = true;
								args.prevArrow = $s.find('.left');
								args.nextArrow = $s.find('.right');
	  						}


	  						$s.find('.slick-slider').on('init', function( e, slick ){
	  							setTimeout(function(){
	  								$window.trigger('resize');
	  							}, 200 );
	  						})                   	
	                    	$s.slideshow_ctrl({
	                    		customArgs: true,
	                    		args: args
	                    	});
	                    }

                    });
                }
                else{
                	$el.slideshow_ctrl('destroy');
                }
            }

            //---------- Carousel ------------//
            $el = $('.module_carousel');
            if ( $el.length > 0 ){
                if ( b ){
                    $el.each(function(i){
                        $s = $(this);
                        $s.module_carousel();
                    })
                }
                else{
                    $el.module_carousel('destroy');
                }
            }	    
        },

        initImageEnlargeGallery: function(b){
        	var $imgs = $('#barba-wrapper').find('img.enlarge-gallery'), images, $img, j, skip;
        	if ( $imgs.length <= 0 ){
        		return;
        	}
        	if (b){
        		$('#image-enlarge-window').image_enlarge_window({
        			$imgs: $imgs 
        		});
        	}
        	else{
        		$('#image-enlarge-window').image_enlarge_window('destroy');
        	}
        },

	    //------------------------------------ VIDEOS --------------------------------------------------//
	    initVideos: function(b, $context ){

	    	//---------------------------- SEAMLESS VIDEOS (VIMEO STREAM) ---------------------------------//
			var $s = $context ? $context.find( '.video-ctrl') : $('.video-ctrl');
			if ( $s.length > 0 ){
			  if ( b ){
			    $s.each( function(){
			      if ( ! $(this).hasClass('interstitial') && ! $(this).hasClass('slideshow-contained') ){
			         $(this).video_ctrl({ 
			         	autoplay: $(this).hasClass('autoplay-off') ? false : true
			         });
			      }
			    });
			  }
			  else{
			    $s.each( function(){
			      if ( ! $(this).hasClass('interstitial') && ! $(this).hasClass('slideshow-contained') ){
			         $(this).video_ctrl('destroy');
			      }
			    });
			  }
			}

			//---------------------------- EMBED VIDEOS ---------------------------------//
			$s = $context ? $context.find( '.video-ctrl-embed') : $('.video-ctrl-embed');
			if ( $s.length <= 0 ){
				return;
			}

			if ( b ){
				$s.each( function(){
				    $(this).video_ctrl_embed();
				});
			}
			else{
				$s.each( function(){
				    $(this).video_ctrl_embed('destroy');
				});
			}
	    },

        //------------------------------------ MODALS -----------------------------------------------------//
        initModals: function(b){
        	var $el, $s, $p;
            //---------- Modal Window ------------//
            // Being used for CA terms confirmation
           	$el = $('.overlay-window');
           	if ( $el.length > 0 ){
           		if ( b ){
	   				// // contact overlay
					$el.overlay_window();
           		}
           		else{
           			$el.overlay_window( 'destroy' );
           		}
			}
        },

        //------------------------------------ CLAMPS -----------------------------------------------------//
        initClamps: function(b){
        	var $el, $s, $p;
            //---------- Line Clamp ------------//
            $el = $('.clamp');
            if ( $el.length > 0 ){
                if ( b ){
                    $el.each(function(i){
                        $s = $(this);
                        $s.line_clamp();
                    })
                }
                else{
                    $el.line_clamp('destroy');
                }
            }
        },

        //------------------------------------ FORMS -----------------------------------------------------//
        initForms: function(b){
            if ( b ){
                $('INPUT[type="radio"],INPUT[type="checkbox"]').iCheck({
                    cursor: true,
                });
            } else {
                $('INPUT[type="radio"],INPUT[type="checkbox"]').iCheck('destroy');
            }
        },


        //------------------------------------ ACCORDIAN --------------------------------------------------//
        initAccordian: function( b ){
                        
            var accordians = $('.module_accordion');
            
            if (accordians.length > 0){
                if ( b ){

                    accordians.each(function() {
                        $(this).find('.item').accordion({
                            autoClose: 'true',
                            groupElement: '.items',
                            controlElement: '.trigger',
                            contentElement: '.details',
                            transitionSpeed: 500,
                        });
                        if ($(this).find('.item[open="yes"]')) {
                            $(this).find('.item[open="yes"] .trigger').click();
                        }
                    });

                } else {

                    // Nothing?

                }
            }
        },


        //------------------------------------ PAGINATION --------------------------------------------------//
        initPagination: function( b ){
                        
            var widget = $('.widget-pagination');
            
            if (widget.length > 0){
                if ( b ){

                    $(document).keydown(function(e) {

                        if (e.ctrlKey || e.altKey || event.s || e.metaKey) {
                            return true;
                        }
                        if (e.keyCode == 37) {
                            PAJX.triggerURL( widget.find('.previous').attr('href') );
                        } else if (e.keyCode == 39) {
                            PAJX.triggerURL( widget.find('.next').attr('href') );
                        }

                    });

                } else {

                    $(document).off('keydown');

                }
            }
        },        

        //---------------------------- SELECTS -------------------------------------------------//
        initSelects: function(b){
            var $s, $o, url, view;

            // 1) url change select (menu like)
            $s = $('.url-select');
            if ( $s.length > 0 ){
                if ( b ){
                    $s.on( 'change', function(e){
                        $o = $(this); url = $o.val(), view = $o.attr( 'data-view' );
                        if ( $o.hasClass( 'barba-view' ) && view ){
                            // trigger BARBA view
                            PAJX.triggerView(  url, view );
                        }
                        else{
                            // trigger BARBA normal view (all)
                            PAJX.triggerURL(  url );
                        }
                        // hey! this would be the static approach:
                        // document.location = $o.val();
                    });
                }
                else{
                    $s.off( 'change' );
                }
            }

        },

        //----------------------------------- FILTERS ----------------------------------------------------//
        initFilters: function(b){
        	var $el, $s, $p;

			//---------- Collective Access Fitlers ------------------//
			$el = $('.options-filter-widget');
           	if ( $el.length > 0 ){
           		if ( b ){
					$el.options_filter();
           		}
           		else{
           			$el.options_filter( 'destroy' );
           		}
			}

            //---------- Filter Bar (All results on the page) ------------------//
            if (( $el = $('.filter_action') )) {
                if ( b ){
                    $el.each(function(){
                        $(this).filter_action();
                    });
                } else {
                    $el.filter_action('destroy');
                }
            }

            //---------- Filter Query (Hit database to get results) ------------------//
            if (( $el = $('.filter_query') )) {
                if ( b ){
                    $el.each(function(){
                        $(this).filter_query();
                    });
                } else {
                    $el.filter_query('destroy');
                }
            }



        },


	   //----------------------------------- GRID PACKERY ------------------------------------------------//
	    initGridPackery: function(b,$p,_args, shuffle){
	      if ( $p.length > 0 ){

            //console.log( 'initGridPackery', b );

	        // grid stamp
	        if ( $p.hasClass( 'grid-stamp' ) ){
	          if ( b ){
	            $p.grid_stamp({});
	          }
	          else{
	            $p.grid_stamp('destroy');
	          }
	          return;
	        }

	        // if it's only one element just center!
	        /*
	        if ( $p.find( '.item-grid' ).length === 1 ){
	          if ( b ){
	            $p.find( '.item-grid' ).addClass( 'item-centered' );
	          }
	          return;
	        }
	        */
	        // otherwise go for the grid
	        if ( b ){
	          if ( !$p.data('is-init') ){
	            var args = {
	              itemSelector: '.item-grid',
	              percentPosition: true,
	              // use outer width of grid-sizer for columnWidth
	              //columnWidth: '.gutter-sizer',
	              gutter: '.gutter-sizer',
	              transitionDuration: '0' //'0.4s'           
	            };
	            if ( _args ){
	              args = _args;
	              args.transitionDuration = '0';
	            }
	            $p.packery( args );
	            $p.data('is-init', true );
                $p.addClass('packed' );

	            $p.imagesLoaded().progress(function(){
	              if ( $p.data('is-init') ){
	                setTimeout(function(){
	                  $p.packery();
	                  MAIN.adjustLayoutGridPackery( $p );
	                }, 177 );
	              }
	            });
	            if ( shuffle ){
	              $p.data('shuffle', true );
	              this.shuffleGridPackery( $p );
	            }
	            // layout when images are loaded
	            document.addEventListener('lazybeforeunveil', function(e){
	              $p.packery();
	              MAIN.adjustLayoutGridPackery( $p );
	            });
	            $window.on( 'resize', { $g: $p}, this.onResizeForGrid );

	          }
	        }
	        else{
	          if ( $p.data('is-init') ){
            //console.log( 'destroy' );
	            $p.packery( 'destroy' );
	            $p.data('is-init', false );
                $p.removeClass('packed' );
	          }
	          document.removeEventListener('lazybeforeunveil', function(e){
	              $p.packery();
	          });
	          $window.off( 'resize', this.onResizeForGrid );
	        }
	        
	      }	
	    },
	    onResizeForGrid: function(e){
	      // trottle resize
	      //waitForFinalEvent( function() {
	        // code here
	        MAIN.adjustLayoutGridPackery( e.data.$g );
	        MAIN.shuffleGridPackery( e.data.$g );
	      
	      //}, 77, "grid-packery-resize");
	    },
	    adjustLayoutGridPackery: function($g){
	    },
	    shuffleGridPackery: function($g){
	    },

	    //-------------------------- GDPR ------------------------------------------------------//
	    _initGDPR: function(){
	      	var $el = $( '#gdpr-bar' );
	        if ( $el.length > 0 ){
				var cookie = 'gdpr-noguchi';
				if ( !Cookies ) {
					return;
				}
				// console.log( Cookies.get( cookie ) );
				// Check cookie 
				if ( Cookies.get( cookie ) !== "active" ) {
					// show bar
					$el.addClass( 'active' );
					//Assign cookie on click
					$el.find('.close-icon, a').on('click',function(){
						Cookies.set( cookie , 'active', { expires: 90 }); // cookie will expire in 90 day
						// hide bar
						TweenMax.to( $el, 0.4, { opacity:0, bottom:0, ease: 'Linear.easeOut', onComplete: function(){
							$el.remove()
						}})
					});
				}
				else{
					$el.remove();
				}
			}       
	    },

	    //-------------------- UNDERSCORE MIXIN FUNCTIONS ---------------------------------//
	    _extendUnderscore: function(){
			_.mixin({
			  hypen: function(str) {
			    return str.replace( /\s/g, '-' ).replace( '/', '' ).toLowerCase();
			  }
			});	    	
	    },


		// -------------------- FOUO SIGN ----------------------------------------------------- //
	    _logFOUO: function( str ){
	        console.log( '' );
	        console.log('%c' + str, 'color: white; background-color: black; font-size: 14px; line-height: 28px; padding: 10px 15px 8px 15px; font-family: NeuzeitGro-Lig;' );
	        console.log( '' );  
	    }

	};


	MAIN.init();

})( jQuery );
