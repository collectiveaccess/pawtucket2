
let baseViewer = function(viewer) {
	if(!viewer.containerDivs) {
		viewer.containerDivs = function(id, source, options={}) {
			let dc_div = document.getElementById(id + '_' + source.display_class);
			let v_div = dc_div.getElementsByClassName('mediaviewer');
			let overlay_div = document.getElementById(id + '-overlay-' + source.display_class);
			let ov_div = overlay_div.getElementsByClassName('mediaviewer');
			
			return {
				'display': dc_div,
				'viewer': v_div[0],
				'overlay': document.getElementById(options['media_overlay_id']) ?? null,
				'overlay_content': overlay_div,
				'overlay_display': ov_div[0]
			};
		};
	}
}

export default baseViewer;
