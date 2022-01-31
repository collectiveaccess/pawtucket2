jQuery(document).ready(function() {
	var triggerBttn = document.getElementById( 'trigger-overlay2' ),
		overlay = document.querySelector( 'div.overlay2' );
		if ($("button.overlay2-close")[0]) {
			closeBttn = overlay.querySelector( 'button.overlay2-close' );
		} else {
			closeBttn = null;
		}
		transEndEventNames = {
			'WebkitTransition': 'webkitTransitionEnd',
			'MozTransition': 'transitionend',
			'OTransition': 'oTransitionEnd',
			'msTransition': 'MSTransitionEnd',
			'transition': 'transitionend'
		},
		transEndEventName = transEndEventNames[ Modernizr.prefixed( 'transition' ) ],
		support = { transitions : Modernizr.csstransitions };

	function toggleOverlay() {
		if( classie.has( overlay, 'open' ) ) {
			classie.remove( overlay, 'open' );
			classie.add( overlay, 'close' );
			var onEndTransitionFn = function( ev ) {
				if( support.transitions ) {
					if( ev.propertyName !== 'visibility' ) return;
					this.removeEventListener( transEndEventName, onEndTransitionFn );
				}
				classie.remove( overlay, 'close' );
			};
			if( support.transitions ) {
				overlay.addEventListener( transEndEventName, onEndTransitionFn );
			}
			else {
				onEndTransitionFn();
			}
		}
		else if( !classie.has( overlay, 'close' ) ) {
			classie.add( overlay, 'open' );
		}
	};
	if (triggerBttn) {
		triggerBttn.addEventListener( 'click', toggleOverlay );
	};
	if (closeBttn) {
		closeBttn.addEventListener( 'click', toggleOverlay );
	}
});
