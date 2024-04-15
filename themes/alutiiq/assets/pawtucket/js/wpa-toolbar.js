(function () {
	var a11y_toolbar = document.createElement( 'div' );
	var insert_a11y_toolbar = '';

	insert_a11y_toolbar += '<ul class="a11y-toolbar-list">';
	if ( wpatb.enable_contrast == 'true' ) {
		insert_a11y_toolbar += '<li class="a11y-toolbar-list-item"><button type="button" class="a11y-toggle a11y-toggle-contrast toggle-contrast" id="is_normal_contrast" aria-pressed="false"><span class=\"offscreen\">' + wpatb.contrast + '</span><span class="aticon aticon-adjust" aria-hidden="true"></span></button></li>';
	}
	if ( wpatb.enable_grayscale == 'true' ) {
		insert_a11y_toolbar += '<li class="a11y-toolbar-list-item"><button type="button" class="a11y-toggle a11y-toggle-grayscale toggle-grayscale" id="is_normal_color" aria-pressed="false"><span class="offscreen">' + wpatb.grayscale + '</span><span class="aticon aticon-tint" aria-hidden="true"></span></button></li>';
	}
	if ( wpatb.enable_fontsize == 'true' ) {
		insert_a11y_toolbar += '<li class="a11y-toolbar-list-item"><button type="button" class="a11y-toggle a11y-toggle-fontsize toggle-fontsize" id="is_normal_fontsize" aria-pressed="false"><span class="offscreen">' + wpatb.fontsize + '</span><span class="aticon aticon-font" aria-hidden="true"></span></button></li>';
	}
	insert_a11y_toolbar += '</ul>';
	a11y_toolbar.classList.add( wpatb.responsive, 'a11y-toolbar', wpatb.is_rtl, wpatb.is_right );
	a11y_toolbar.innerHTML = insert_a11y_toolbar;

	var insertionPoint = document.querySelector( wpatb.location );
	if ( null !== insertionPoint ) {
		insertionPoint.insertAdjacentElement( 'afterbegin', a11y_toolbar );
	} else {
		console.log( 'WP Accessibility Toolbar insertion point not valid.' );
	}
})();