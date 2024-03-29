
let baseViewer = function(viewer) {
	if(!viewer.containerDivs) {
		viewer.containerDivs = function(id, source) {
			let dc_div = document.getElementById(id + '_' + source.display_class);
			let v_div = dc_div.getElementsByClassName('mediaviewer');
			return {
				'display': dc_div,
				'viewer': v_div[0]
			};
		};
	}
}

export default baseViewer;
