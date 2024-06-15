function makeAdvancedSearchFieldBundle(options) {
	for(let k in options['bundles']) {
		const bundle_def = options['bundles'][k];
		let container_id = bundle_def['id'];
		let container = document.getElementById(container_id);
		
		const firstOption = Object.keys(bundle_def['options']).shift();
		
		let select = document.getElementById(container_id + '-select');
		let input = document.getElementById(container_id + '-input');
		let addControl = document.getElementById(container_id + '-add');
		let addButton = document.getElementById(container_id + '-add-button');
		
	 	select.innerHTML += bundle_def['select'];
 		input.innerHTML += bundle_def['inputs'][firstOption];
 		addButton.onclick = function(e) {
 			cloneElement(container_id, options);
 		};
 	
		select.onchange = function(e) {
			input.innerHTML = bundle_def['inputs'][e.target.options[e.target.selectedIndex].value];
			e.preventDefault();
		}
	}
}

function cloneElement(container_id, options) {
	// Get the element to be cloned
	let container = document.getElementById(container_id);

	// Clone the element
	let clone = container.cloneNode(true);

	// Create a remove button
	let removeBtn = document.createElement('a');

	// Create icon
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
	let subParent = clone.querySelector('#' + container_id + '-add');
	let addBtn = subParent.querySelector('#' + container_id + '-add-button');
	if (addBtn) {
		subParent.removeChild(addBtn);
	}

	// Append the remove button to the subparent
	subParent.appendChild(removeBtn);

	// Append the clone to the container
	document.getElementById('filterfield').appendChild(clone);
}

export default makeAdvancedSearchFieldBundle;