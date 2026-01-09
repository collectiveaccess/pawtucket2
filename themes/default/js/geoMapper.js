import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import SelectArea from 'leaflet-area-select';

const defaultTileServerUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
	
function makeMap(options) {
	const id = options.id ?? 'map';
	const searchUrl = options.searchUrl;
	const mapElement = document.getElementById(id);

	L.Icon.Default.mergeOptions({
	  iconRetinaUrl: options.themePath + '/assets/markers/marker-icon-2x.png',
	  iconUrl: options.themePath + '/assets/markers/marker-icon.png',
	  shadowUrl: options.themePath + '/assets/markers/marker-shadow.png'
	});

	let map = L.map(options.id ?? 'map', { 
		zoomControl: options.showZoom ?? true, 
		attributionControl: false, 
		selectArea: searchUrl ? true : false,
		minZoom: options.minZoom ?? 1, 
		maxZoom: options.maxZoom ?? 15 }
	).setView([30, -74], options.zoom ?? 3);
	
	let b = L.tileLayer(options.tileServerUrl ?? defaultTileServerUrl , {noWrap: true}).addTo(map);	
	let g = new L.featureGroup(); 
	g.addTo(map);
	
	if(searchUrl) {
		map.selectArea.setControlKey(true);
		map.selectArea.setShiftKey(true);
	}

	map.on("selectarea:selected", (e) => {
		if(!searchUrl) { return; }
   		const b = e.bounds;
   		const bb =  b.getSouth() + ',' + b.getWest() + ' .. ' + b.getNorth() + ',' + b.getEast();
   		document.location = searchUrl + '?search_refine=' + encodeURIComponent('[' + bb + ']');
	});
	
	let data = options.data;
	if(data && (data.length > 0)) {
		for(let index in data) {
			let m = null, c = data[index], opts = { };
			if(c.coordinates) {
				let pts = c.coordinates.map(c => { return [c.latitude, c.longitude]; });
				//m = L.polygon(pts).addTo(g);
			} else if(c.radius) {
				if((c.latitude === '') || (c.longitude === '')) { console.log("Invalid point", c); continue; }
				m = L.circle([parseFloat(c.latitude), parseFloat(c.longitude)], {radius: c.radius}).addTo(g);
			} else {
				if((c.latitude === '') || (c.longitude === '')) { console.log("Invalid point", c); continue; }
				m = L.marker([parseFloat(c.latitude), parseFloat(c.longitude)], opts).addTo(g);
			}
			if(c.info) { 
				if(options['ajaxContentUrl'] ?? null) {
					m.bindPopup(
							(layer)=>{
								var el = document.createElement('div');
								htmx.ajax('GET', options['ajaxContentUrl'] + '?ids=' + c.ajaxContentIDs.join(';'), el);
				
								return el;
							}, { minWidth: 400, maxWidth : 560, maxHeight: 300, keepInView: true, autoPan: true });
				} else {
					m.bindPopup(Object.values(data[index].info).join("<br>")); 
				}
			}
		}
		mapElement.style.display = 'block';
	} else {
		mapElement.style.display = 'none';
	}
	const bounds = g.getBounds();
	if (bounds.isValid()) { map.fitBounds(bounds); };
	
	// Current user location
	map.on('locationfound', function(e) {
		const radius = e.accuracy;
		L.circle(e.latlng, radius, {'color': '#cc0000'}).addTo(map);
		map.stopLocate();
		if(bounds.intersects(e.bounds)) {
			map.setView(e.latlng, 16);
		}
	});
	
	map.on('locationerror', function(e) {
		console.log("Geolocation error", e.message);
	});
	
	// Force popup into view
	map.on('popupopen', function(e) {
		const i = setInterval(function() {
			map.fitBounds(map.getBounds());
			clearInterval(i);
		}, 500);
	});
	
	map.locate({setView: false, maxZoom: 16, watch: false});
	
	if(options.zoom) { map.setZoom(options.zoom); }
	
	map.invalidateSize();
}


export default makeMap;
