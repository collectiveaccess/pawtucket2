<?php
/* ----------------------------------------------------------------------
 * views/Browse/browse_results_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2024 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */
$qr_res 			= $this->getVar('result');				// browse results (subclass of SearchResult)
$va_facets 			= $this->getVar('facets');				// array of available browse facets
$va_criteria 		= $this->getVar('criteria');			// array of browse criteria
$browse_key 		= $this->getVar('key');					// cache key for current browse
$va_access_values 	= $this->getVar('access_values');		// list of access values for this user
$hits_per_block 	= (int)$this->getVar('hits_per_block');	// number of hits to display per block
$start		 	= (int)$this->getVar('start');			// offset to seek to before outputting results
$is_advanced		= (int)$this->getVar('is_advanced');
$showLetterBar	= (int)$this->getVar('showLetterBar');	
$va_letter_bar		= $this->getVar('letterBar');	
$letter			= $this->getVar('letter');
$row_id 			= $this->request->getParameter('row_id', pInteger);

$va_views			= $this->getVar('views');
$current_view	= $this->getVar('view');
$va_view_icons		= $this->getVar('viewIcons');

$current_sort	= $this->getVar('sort');
$sort_dir		= $this->getVar('sort_direction');

$table 			= $this->getVar('table');
$t_instance			= $this->getVar('t_instance');

$is_search		= ($this->request->getController() == 'Search');

$result_size 	= $qr_res->numHits();


$va_options			= $this->getVar('options');
$extended_info_template = caGetOption('extendedInformationTemplate', $va_options, null);
$ajax			= (bool)$this->request->isAjax();
$va_browse_info = $this->getVar("browseInfo");
$o_config = $this->getVar("config");
$va_export_formats = $this->getVar('export_formats');
$va_browse_type_info = $o_config->get($va_browse_info["table"]);
$va_all_facets = $va_browse_type_info["facets"];	
$va_add_to_set_link_info = caGetAddToSetInfo($this->request);

		

if (!$ajax) {	// !ajax
?>

<div class="row" style="clear:both;">
	<div class="col-sm-12 col-md-4 col-lg-3 col-xl-3"><a href="#results" id="skipBrowse" class="visually-hidden">Skip to Results</a>
<?php
		print $this->render("Browse/browse_refine_subview_html.php");
?>			
	</div><!-- end col-2 -->
	<div class='col-sm-12 col-md-8 col-lg-9 col-xl-9'>
		<div class="row">
			<div class="col-12">
				<H1>
<?php
				switch(strToLower($this->request->getAction())){
					case "artists":
						print _t("City of San Antonio Artist Directory");
					break;
					# ----------------------
					case "artworks":
						print _t("City of San Antonio Public Art Directory");
					break;
					# ----------------------
					case "exhibitions":
						print _t("City of San Antonio Public Art Exhibitions");
					break;
					# ----------------------
				}
?>
				</H1>
			</div>
		</div>
		<div class="row">
			<div class="col-12">

<?php
				if($tmp = $this->getVar("browse_intro_".strToLower($this->request->getAction()))){
					print "<div class='fs-5 pb-4'>".$tmp."</div>";
				}
?>
			</div>
		</div>
		<div class="row">
			<div class="col-12 text-end">
				

				<ul class="list-group list-group-horizontal justify-content-lg-end small">
					<li class='list-group-item border-0 ps-0 pt-1 text-capitalize'>
<?php
					print _t('%1 %2', $result_size, ($result_size == 1) ? (($va_browse_info["labelSingular"]) ? $va_browse_info["labelSingular"] : $t_instance->getProperty('NAME_PLURAL')) : (($va_browse_info["labelPlural"]) ? $va_browse_info["labelPlural"] : $t_instance->getProperty('NAME_PLURAL')));	
?>		
					</li>
<?php
				if(is_array($va_views) && (sizeof($va_views) > 1)){
					print "<li class='list-group-item border-0 px-0 pt-0'>\n";
					print "<ul class='list-inline p-0 me-2 text-nowrap'>\n";
					foreach($va_views as $view => $va_view_info) {
						print "<li class='list-inline-item me-1'>";
						if ($current_view === $view) {
							print '<button class="btn btn-dark btn-sm disabled" aria-label="'.$view.'"  title="'.$view.'"><i class="bi '.$va_view_icons[$view]['icon'].'"></i></button>';
						} else {
							print caNavLink($this->request, '<i class="bi '.$va_view_icons[$view]['icon'].'"></i>', 'btn btn-light btn-sm', '*', '*', '*', array('view' => $view, 'key' => $browse_key), array("title" => $view, "aria-label" => $view));
						}
						print "</li>\n";
					}
					print "</ul>\n";
					print "</li>\n";
				}
				if(is_array($va_export_formats) && sizeof($va_export_formats)){
?>
					<li class='list-group-item border-0 px-0 pt-0'>
						<div class="dropdown inline w-auto">
							<button class="btn btn-light btn-sm dropdown-toggle small" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="<?php print _t("Export Results"); ?>">
								<i class="bi bi-download"></i>
							</button>
							<ul class="dropdown-menu" role='menu'>
<?php
							foreach($va_export_formats as $va_export_format){
								print "<li class='dropdown-item' role='menuitem'>".caNavLink($this->request, $va_export_format["name"], "", "*", "*", "*", array("view" => "pdf", "download" => true, "export_format" => $va_export_format["code"], "key" => $browse_key))."</li>";
							}
?>
							</ul>
						</div>
					</li>
<?php
				}

				if(is_array($va_all_facets) && sizeof($va_all_facets)){
?>
					<li class='list-group-item border-0 px-0 pt-0 d-md-none'><button class="btn btn-light btn-sm small ms-1" type="button" aria-expanded="false" aria-controls="bRefine" data-bs-toggle="collapse" data-bs-target="#bRefine" aria-label="<?php print _t("Filter Results"); ?>"><i class="bi bi-sliders"></i></button></li>
<?php
				}
?>
				</ul>
<?php
			if(($table == 'ca_objects') && caDisplayLightbox($this->request)){
?>
				<ul class="list-group list-group-horizontal justify-content-lg-end small">
<?php
				# --- include lightbox dropdown
				print $this->render('Browse/lightbox_tools_html.php');
?>
					<li class='list-group-item border-0 ps-0 pt-0 pe-0'>
						<button type='button' id='select-all-btn' class='btn btn-light btn-sm' onclick='toggleSelectAll()' data-state='select'>
							<i class='bi bi-check-circle-fill'></i> <?= _t("Select All"); ?>
						</button>
					</li>
				</ul>	
				<input type='hidden' name='row_ids' id='selection' value='' class='selectedItemInputs lightboxAddFormControl'/>
				<input type='hidden' name='omit_ids' id='omitSelection' value='' class='selectedItemInputs lightboxAddFormControl'/>
				<input type='hidden' name='all_selected' id='allSelected' value='' class='selectedItemInputs lightboxAddFormControl'/>
				<input type='hidden' name='table' id='table' value='<?= $table ?>' class='selectedItemInputs lightboxAddFormControl'/>
				<input type='hidden' name='mode' id='mode' value='addFromResults' class='selectedItemInputs lightboxAddFormControl'/>			
<?php
			}
?>
			</div>
		</div>
<?php				
		if($facet_description){
			print "<div class='py-3'>".$facet_description."</div>";
		}

		if($showLetterBar){
			print "<ul id='bLetterBar' class='list-inline p-0 mb-3'>";
			foreach(array_keys($va_letter_bar) as $l){
				if(trim($l)){
					print "<li class='text-uppercase list-inline-item p-0 m-0'>".caNavLink($this->request, $l, 'btn p-1 fw-medium'.(($letter == $l) ? ' btn-primary' : ' btn-white'), '*', '*', '*', array('key' => $browse_key, 'l' => $l))."</li>";
				}
			}
			print "<li class='list-inline-item py-0 my-0'> <span aria-hidden='true'>|</span> </li><li class='list-inline-item p-0 m-0'>".caNavLink($this->request, _t("All"), 'btn p-1 fw-medium'.((!$letter) ? ' btn-primary' : ' btn-white'), '*', '*', '*', array('key' => $browse_key, 'l' => 'all'))."</li>"; 
			print "</ul>";
		}
?>
			<div id="browseResultsContainer">
				<div class="row"><a name="results"></a>
<?php
} // !ajax

# --- check if this result page has been cached
# --- key is MD5 of browse key, sort, sort direction, view, page/start, items per page, row_id
$cache_key = md5($browse_key.$current_sort.$sort_dir.$current_view.$start.$hits_per_block.$row_id.$letter);
if(($o_config->get("cache_timeout") > 0) && ExternalCache::contains($cache_key,'browse_results')){
	print ExternalCache::fetch($cache_key, 'browse_results');
}else{
	$result_page = $this->render("Browse/browse_results_{$current_view}_html.php");
	ExternalCache::save($cache_key, $result_page, 'browse_results', $o_config->get("cache_timeout"));
	print $result_page;
}		

if (!$ajax) {	// !ajax
?>
			
			</div><!-- end row -->
		</div><!-- end browseResultsContainer -->
	</div><!-- end col-8 -->	
</div><!-- end row -->

<?php
} //!ajax
if(($table == 'ca_objects') && caDisplayLightbox($this->request)){
?>
<script>
if (typeof selectionListInput === 'undefined') {

	const selectionListInput = document.getElementById('selection');
	const omitSelectionListInput = document.getElementById('omitSelection');
	const allSelectedInput = document.getElementById('allSelected');
	
	const selectAllBtn = document.getElementById('select-all-btn');
	
	// Initialize selection list
	let selectionList = selectionListInput.value.split(/;/).filter(Boolean);
	let omitSelectionList = omitSelectionListInput.value.split(/;/).filter(Boolean);
	

		// Helper to update the selection list and UI
	function updateSelectionList() {
		selectionListInput.value = selectionList.join(';');
		omitSelectionListInput.value = omitSelectionList.join(';');
		lightboxDropdown = document.getElementById('lightboxDropdown'); // don't set as constant since is updated with ajax
		lightboxDropdown.classList.toggle('d-none', selectionList.length === 0); // Show or hide Actions dropdown
	}
	
	function toggleSelection(id) {
		const selectBtn = document.getElementById('result-select-btn-' + id);
		
		id = '' + id;	// force to string
		if(selectionList.includes(id)) {
			selectionList = selectionList.filter(function(v) { return v !== id });
			omitSelectionList.push(id);
			selectBtn.classList.remove('result-selected');
		} else {
			selectionList.push(id);
			omitSelectionList = omitSelectionList.filter(function(v) { return v !== id });
			selectBtn.classList.add('result-selected');
		}

		updateSelectionList();
	}

	function toggleSelectAll() {
		const isSelectMode = selectAllBtn.getAttribute('data-state') === 'select'; // Check if it's in "Select All" mode
		const allSelectButtons = document.querySelectorAll('.btn-select'); // Select all card buttons

		// Loop through all card buttons and toggle their selection based on the current mode
		allSelectButtons.forEach(button => {
			const id = button.id.replace('result-select-btn-', ''); // Extract the ID
			const isSelected = selectionList.includes(id);

			if (isSelectMode && !isSelected) {
				toggleSelection(id); // Select the card if not already selected
			} else if (!isSelectMode && isSelected) {
				toggleSelection(id); // Deselect the card if it is selected
			}
		});

		// Update the button state and text
		selectAllBtn.setAttribute('data-state', isSelectMode ? 'deselect' : 'select');
		allSelectedInput.value = (isSelectMode) ? 'true' : '';
		selectAllBtn.innerHTML = isSelectMode
			? '<i class="bi bi-x-circle-fill"></i> <?= _t("Deselect All"); ?>'
			: '<i class="bi bi-check-circle-fill"></i> <?= _t("Select All"); ?>';
	}
	
// 	function downloadSelected(dtype, dversion, url) {
// 		const allAreSelected = selectAllBtn.getAttribute('data-state') === 'deselect'; 
// 		const item_ids = document.getElementById('selection').value;
// 		const omit_item_ids = document.getElementById('omitSelection').value;
// 		switch(dtype) {
// 			case 'media':
// 				window.location = url + '/item_id/' + item_ids + ((allAreSelected === true) ? '/selectAll/1/omit_item_id/' + omit_item_ids : '');
// 				break;
// 			default:
// 				window.location = url + '/item_id/' + item_ids + ((allAreSelected === true) ? '/selectAll/1/omit_item_id/' + omit_item_ids : '');
// 				break;
// 		}
// 	}

	document.body.addEventListener('htmx:load', function (event) {
		// console.log('HTMX Load Event:', event);
		const parentElement = event.target || null;

		if (!parentElement) {
			console.warn('htmx:load fired, but no parent target found.');
			return;
		}

		// Find the new content within the parent container
		const newSelectButtons = parentElement.parentNode.querySelectorAll('.btn-select');

		if (newSelectButtons.length) {
			// console.log('Applying selection mode to new cards');
			const isSelectMode = selectAllBtn?.getAttribute('data-state') === 'deselect';

			if (isSelectMode) {
				newSelectButtons.forEach(button => {
					const id = button.id.replace('result-select-btn-', '');
					button.classList.add('result-selected'); // Add selected class

					if (!selectionList.includes(id)) {
						selectionList.push(id); // Add to selection
					}
				});
				updateSelectionList();
			}
		}
	});
}
</script>
<?php
}
?>