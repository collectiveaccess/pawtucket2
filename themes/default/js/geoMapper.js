import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

const defaultTileServerUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
	
function makeMap(options) {
	let id = options.id ?? 'map';
	let mapElement = document.getElementById(id);

	L.Icon.Default.mergeOptions({
	  iconRetinaUrl: options.themePath + '/assets/markers/marker-icon-2x.png',
	  iconUrl: options.themePath + '/assets/markers/marker-icon.png',
	  shadowUrl: options.themePath + '/assets/markers/marker-shadow.png'
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
	if(data && (data.length > 0)) {
		for(let index in data) {
			let m = null, c = data[index], opts = { };
			if(c.coordinates) {
				let pts = c.coordinates.map(c => { return [c.latitude, c.longitude]; });
				m = L.polygon(pts).addTo(g);
			} else if(c.radius) {
				m = L.circle([parseFloat(c.latitude), parseFloat(c.longitude)], {radius: c.radius}).addTo(g);
			} else {
				m = L.marker([parseFloat(c.latitude), parseFloat(c.longitude)], opts).addTo(g);
			}
			if(c.info) { m.bindPopup(Object.values(data[index].info).join("<br>")); }
		}
		mapElement.style.display = 'block';
	} else {
		mapElement.style.display = 'none';
	}
	let bounds = g.getBounds();
	if (bounds.isValid()) { map.fitBounds(bounds); };
	if(options.zoom) { map.setZoom(options.zoom); }
}


export default makeMap;
