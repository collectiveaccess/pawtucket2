import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import SelectArea from 'leaflet-area-select';

const defaultTileServerUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
	
function makeMap(options) {
	const id = options.id ?? 'map';
	const searchUrl = options.searchUrl;
	const mapElement = document.getElementById(id);
	const liveUpdateConf = options.liveUpdate;
	const currentLocation = options.currentLocation;

	const iconPath = options.themePath + '/assets/markers/';
	L.Icon.Default.mergeOptions({
	  iconUrl: iconPath + 'marker-icon.png',
	  iconRetinaUrl: iconPath + 'marker-icon-2x.png',
	  shadowUrl: iconPath + 'marker-shadow.png',
	  shadowRetinaUrl: iconPath + 'marker-shadow.png'
	});

	let map = L.map(id ?? 'map', { 
		zoomControl: options.showZoom ?? true, 
		attributionControl: false, 
		selectArea: searchUrl ? true : false,
		minZoom: options.minZoom ?? 1, 
		maxZoom: options.maxZoom ?? 15 }
	).setView([30, -74], options.zoom ?? 3);
	
	const mapDiv = document.getElementById(id);
	mapDiv.map = map;
	
	let b = L.tileLayer(options.tileServerUrl ?? defaultTileServerUrl , {noWrap: true}).addTo(map);	
	
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
		const bundles = data.reduce((acc, item) => {
			if(acc.indexOf(item.bundle) === -1) {
				acc.push(item.bundle);
			}
			return acc;
		}, []);
		
		let layers = {};
		for(let index in bundles) {
			layers[bundles[index]] = new L.featureGroup();
			layers[bundles[index]].addTo(map);
		}
		
		map.layerList = layers;
		
		for(let index in data) {
			let m = null, c = data[index], opts = { };
			if(c.coordinates) {
				let pts = c.coordinates.map(c => { return [c.latitude, c.longitude]; });
				m = L.polygon(pts).addTo(layers[c.bundle]);
			} else if(c.radius) {
				if((c.latitude === '') || (c.longitude === '')) { console.log("Invalid point", c); continue; }
				m = L.circle([parseFloat(c.latitude), parseFloat(c.longitude)], {radius: c.radius}).addTo(layers[c.bundle]);
			} else {
				if((c.latitude === '') || (c.longitude === '')) { console.log("Invalid point", c); continue; }
				
				if(data[index]['icon']) {
					var ci = L.icon({
						iconUrl: iconPath + data[index]['icon']['icon'],
						iconRetinaUrl: iconPath + data[index]['icon']['icon-2x'],
						shadowUrl: iconPath + data[index]['icon']['shadow'],
						shadowRetinaUrl: iconPath + data[index]['icon']['shadow-2x'],
						iconSize: [parseInt(data[index]['icon']['iconSize'][0]), parseInt(data[index]['icon']['iconSize'][1])],
						iconAnchor: [parseInt(data[index]['icon']['iconSize'][0]), parseInt(data[index]['icon']['iconSize'][1])], 
						popupAnchor: [parseInt(data[index]['icon']['popupAnchor'][0]), parseInt(data[index]['icon']['popupAnchor'][1])]
					});
					opts['icon'] = ci;
				}
				
				m = L.marker([parseFloat(c.latitude), parseFloat(c.longitude)], opts).addTo(layers[c.bundle]);
			}
			if(c.info) { 
				if(options['ajaxContentUrl'] ?? null) {
					m.bindPopup(
							(layer)=>{
								var el = document.createElement('div');
								htmx.ajax('GET', options['ajaxContentUrl'] + '?bundle=' + (c.bundle ?? '') + '&ids=' + c.ajaxContentIDs.join(';'), el);
				
								return el;
							}, { minWidth: 400, maxWidth : 560, maxHeight: 300, keepInView: true, autoPan: true });
				} else {
					m.bindPopup((typeof data[index].info === "string") ?  data[index].info : Object.values(data[index].info).join("<br>")); 
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
	if(currentLocation) { 
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
	}
	
	// Force popup into view
	map.on('popupopen', function(e) {
		const i = setInterval(function() {
			map.fitBounds(map.getBounds());
			clearInterval(i);
		}, 500);
	});
	
	const updateHandler = function(e) {
		if(liveUpdateConf) {
			const b = map.getBounds();
   			const bb =  b.getSouth() + ',' + b.getWest() + ' .. ' + b.getNorth() + ',' + b.getEast();
			const u = liveUpdateConf['url'] + '?search_refine_prefix=' + liveUpdateConf['searchPrefix'] + '&search_refine=' + encodeURIComponent('[' + bb + ']');
		
   			htmx.ajax('GET', u, {target:'#' + liveUpdateConf['id'], swap:'innerHTML'});

		}
	};
	
	map.on('zoomend', updateHandler);
	map.on('dragend', updateHandler);
	
	map.locate({setView: false, maxZoom: 16, watch: false});
	
	if(options.zoom) { map.setZoom(options.zoom); }
	
	map.invalidateSize();
}


export default makeMap;
