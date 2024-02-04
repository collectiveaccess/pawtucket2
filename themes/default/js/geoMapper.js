import L from 'Leaflet';
import 'leaflet/dist/leaflet.css';

function makeMap(options) {
	let id = options.id ?? 'map';
	let mapElement = document.getElementById(id);
	let defaultTileServerUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';

	L.Icon.Default.mergeOptions({
	  iconRetinaUrl: options.themePath + '/node_modules/leaflet/dist/images/marker-icon-2x.png',
	  iconUrl: options.themePath + '/node_modules/leaflet/dist/images/marker-icon.png',
	  shadowUrl: options.themePath + '/node_modules/leaflet/dist/images/marker-shadow.png'
	});

	let map = L.map(options.id ?? 'map', { 
		zoomControl: options.showZoom ?? true, 
		attributionControl: false, 
		minZoom: options.minZoom ?? 1, 
		maxZoom: options.maxZoom ?? 15 }
	).setView([30, -74], options.zoom ?? 3);
	
	let b = L.tileLayer(options.tileServerUrl ?? defaultTileServerUrl , {noWrap: true}).addTo(map);	
	let g = new L.featureGroup(); 
	g.addTo(map);
	
	let data = options.data;
	if(data && ((data['points'] && (data['points'].length > 0)) || (data['paths'] && (data['paths'].length > 0)))) {
		for(let index in data['points']) {
			let point = data['points'][index];
			let opts = {  };
			let m = L.marker([parseFloat(point.latitude), parseFloat(point.longitude)], opts).addTo(g);
		}
		mapElement.style.display = 'block';
	} else {
		mapElement.style.display = 'none';
	}
	let bounds = g.getBounds();
	if (bounds.isValid()) { map.fitBounds(bounds); };
}


export default makeMap;
