import autoComplete from "@tarekraafat/autocomplete.js";
	
function makeAutocompleter(autocompleters) {
	let elements = [];
	for(let i in autocompleters) {
		let options = autocompleters[i];
		const id = options.id ?? 'map';
		const acElem = document.getElementById(id);
		const placeholder = options.placeholder ?? '';
		const url = options.url;
		const idtarget = options.idtarget ?? null;
	
		const ac = new autoComplete({
			selector: "#" + id,
			placeHolder: placeholder,
			searchEngine: 'strict',
			debounce: 300,
			cache: false,
			data: {
				src: async function(q) {
					const response = await fetch(url + '/term/' + q, {
						headers: {
							'X-Requested-With': 'XMLHttpRequest'
						}
					});
					if (!response.ok) {
					  throw new Error(`Response status: ${response.status}`);
					}
				
					const json = await response.json();
					
					let acc = [];
					let ids = [];
					for(let i in json) {
						acc.push(json[i]['label']);
						ids.push(json[i]['id']);
					}
					ac.ids = ids;
					return acc;
				}
			},
			resultItem: {
				highlight: false,
			},
			events: {
				input: {
					selection: (event) => {
						const selection = event.detail.selection.value;
						event.target.value = selection;
						
						if(idtarget) {
							let id_elem = document.getElementById(idtarget);
							if(id_elem) {
								id_elem.value = ac.ids[event.detail.selection.index] + '';
							}
						} else {
							const id_elem_id = event.target.getAttribute('id') + '_id';
							
							let id_elem = document.getElementById(id_elem_id);
							if(!id_elem) {
								event.target.insertAdjacentHTML("afterend", "<input type='hidden' name='" + id_elem_id + "' id='" + id_elem_id + "'>");
								id_elem = document.getElementById(id_elem_id)
							}
							id_elem.value = ac.ids[event.detail.selection.index] + '';
						}
					}
				}
			}
		});
		elements.push(ac);
	}
		
	return elements;
}
export default makeAutocompleter;
