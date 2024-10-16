function cloneElement(key, container_id, template_id, isInit, options) {
	const k = key;
	const bundle_def = options['bundles'][k];
	
	let template = document.getElementById(template_id);
	let container = document.getElementById(container_id);
	
	let clone = template.cloneNode(true);
	clone.removeAttribute('style');
	clone.removeAttribute('id');

	// Create a remove button
	let removeBtn = document.createElement('a');

	// Create icon
	let subParent = clone.querySelector('.' + container_id + '-add');
	if(!isInit) {
		let removeIcon = document.createElement('i');
		removeIcon.classList.add("bi");
		removeIcon.classList.add("bi-dash-lg");
		
		// Append the remove icon to the remove button
		removeBtn.appendChild(removeIcon);
		
		// Function to remove entire elment on click
		removeBtn.onclick = function() {
			this.parentNode.parentNode.remove();
		};
		
		// Remove existing add button in clone
		let addBtn = subParent.querySelector('.' + container_id + '-add-button');
		if (addBtn) {
			subParent.removeChild(addBtn);
		}
	} else {
		let addButton = clone.querySelector('.' + container_id + '-add-button');
		addButton.onclick = function(e) {
 			const tid = template_id;
 			cloneElement(key, container_id, template_id, false, options);
 		};
	}
		
	let input = clone.querySelector('.' + container_id + '-input');
	const firstOption = Object.keys(bundle_def['options']).shift();
	
 	input.innerHTML = bundle_def['inputs'][firstOption];
	let selectContainer = clone.querySelector('.' + container_id + '-select');
	selectContainer.innerHTML = bundle_def['select'];
	let select = clone.querySelector('.' + container_id + '-select select');
	select.onchange = function(e) {
		input.innerHTML =  bundle_def['inputs'][e.target.options[e.target.selectedIndex].value];
		e.preventDefault();
	}

	if(!isInit) {
		// Append the remove button to the subparent
		subParent.appendChild(removeBtn);
	}

	// Append the clone to the container
	container.appendChild(clone);
}

function makeAdvancedSearchFieldBundle(options) {
	for(let k in options['bundles']) {
		const bundle_def = options['bundles'][k];
		
		let container_id = bundle_def['id'];
		let template_id = container_id + '-template';
		
		cloneElement(k, container_id, template_id, true, options);
	}
}


export default makeAdvancedSearchFieldBundle;