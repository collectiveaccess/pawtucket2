<?php
/** ---------------------------------------------------------------------
 * themes/default/Lightbox/detail_html.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2024 Whirl-i-Gig
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
 * @package CollectiveAccess
 * @subpackage theme/default
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
$t_set 								= $this->getVar('t_set');
$errors 							= $this->getVar('errors');
$set_id								= $this->getVar('set_id');
$incremental 						= $this->getVar('is_incremental_load');
$lightbox_displayname_singular 		= $this->getVar("lightbox_displayname_singular");
$lightbox_displayname_plural 		= $this->getVar("lightbox_displayname_plural");
$access_values 						= $this->getVar('access_values');
$downloads							= $this->getVar('downloads');
$exports							= $this->getVar('exports');

// View modes
$configured_modes = $this->getVar('configured_modes');
$current_view_mode = $this->getVar('mode');

// Sorts
$sorts = $this->getVar('sorts');
$sort_directions = $this->getVar('sort_directions');
$current_sort = $this->getVar('current_sort');
$current_sort_direction = $this->getVar('current_sort_direction');

$t_list_item = new ca_list_items();
$user_id = $this->request->getUserID();
$can_delete = $t_set->haveAccessToSet($user_id, __CA_SET_EDIT_ACCESS__);

$search = $this->getVar('search');
$total = $this->getVar('total');

if(!$incremental) { 
?>
<div id="lightboxContent">
	<!-- BEGIN Modals -->	
		<!-- Edit lightbox modal -->
		<?= $this->render("Lightbox/edit_lightbox_form_html.php"); ?>
		<!-- Lightbox access modal -->
		<?= $this->render("Lightbox/lightbox_access_form_html.php"); ?>
		
		<!-- Confirm lightbox delete modal -->
		<?= $this->render("Lightbox/confirm_delete_lightbox_form_html.php"); ?>
		
		<!-- Confirm lightbox item(s) delete modal -->
		<?= $this->render("Lightbox/confirm_delete_lightbox_item_form_html.php"); ?>
	<!-- END Modals -->

	
		<div class="row">
			<div class="col-md-12 col-lg-5">
				<div class="float-start me-3"><?= caNavLink($this->request, '<i class="bi bi-chevron-left"></i>', 'btn btn-secondary btn-sm', '*', 'Lightbox', 'Index', null, array("aria-label" => _t("Back"), "title" => _t("Back"))); ?></div>
			
				<H1 class="text-capitalize mb-0 fs-3"><?= $t_set->get('ca_sets.preferred_labels.name'); ?></H1>
			</div>
			<div class="col-md-12 col-lg-7 text-lg-end pt-2 mt-lg-0">

				<div class="btn-group" role="group" aria-label="<?= _t('%1 Controls', $lightbox_displayname_singular); ?>">

					<div id="actionsDropdown" class="btn-group d-none" role="group">
						<button id="btnGroupActions" type="button" class="btn btn-white" data-bs-toggle="dropdown" aria-expanded="false">
							<?= _t("Actions"); ?> <i class="bi bi-caret-down-fill"></i> 
						</button>
						<ul class="dropdown-menu" aria-labelledby="btnGroupActions">
<?php if($can_delete) { ?>
						  <li>
						  	<button class="dropdown-item" 
									title="<?= _t('Remove from %1', $lightbox_displayname_plural); ?>" 
									aria-label="<?= _t('Remove from %1', $lightbox_displayname_plural); ?>"
									data-bs-toggle="modal" 
									data-bs-target="#deleteLightboxItemModal"
									onclick="document.getElementById('deleteLightboxItemId').value = document.getElementById('selection').value;"><i class='bi bi-x-square'></i> <?= _t("Delete selected"); ?></button></li>
<?php } ?>
						</ul>
					</div>

					<button type="button" id="select-all-btn" class="btn btn-white" onclick="toggleSelectAll()" data-state="select">
						<i class="bi bi-check-circle-fill"></i> <?= _t("Select All"); ?>
					</button>

					<button type="button" class="btn btn-white" data-bs-toggle="modal" data-bs-target="#editLightboxModal"><i class="bi bi-pencil-square"></i> <?= _t("Edit"); ?></button>
					<button type="button" class="btn btn-white" data-bs-toggle="modal" data-bs-target="#lightboxAccessModal"><i class="bi bi-people-fill"></i> <?= _t("Access"); ?></button>
					<div class="btn-group" role="group">
						<button id="btnGroupDownload" type="button" class="btn btn-white" data-bs-toggle="dropdown" aria-expanded="false">
						  <i class="bi bi-download"></i> <?= _t("Download"); ?>
						</button>
						<ul class="dropdown-menu" aria-labelledby="btnGroupDownload">
<?php foreach(array_merge($downloads, $exports) as $d) { ?>
									<li><button 
										onclick="downloadSelected('<?= $d['type'] ?>', '<?= $d['version']; ?>', '<?= $d['url']; ?>');"
										class="dropdown-item"><?= $d['label']; ?></button></li>
<?php } ?>
						</ul>
					</div>

<?php
					if($can_delete) {
?>
						<button 
							class="btn btn-white pe-0" 
							data-bs-toggle="modal" 
							data-bs-target="#deleteLightboxModal"
							hx-on:click="document.getElementById('deleteLightboxId').value = '<?= $set_id;?>';"
						>
							<i class="bi bi-trash3"></i> <?= _t("Delete"); ?>
						</button>
<?php
					}
?>		
</div><!-- end btn group -->
			</div>
		</div>
		<div class="row pt-2 pb-3">
			<div class="col"><hr class="my-0"></div>
		</div>
	
		<div class="row">
			<div class="col-md-12 col-lg-5 d-flex">
				<form role="search" id="searchWithin" hx-post="<?= caNavUrl($this->request, '', '*', 'Search', ['t' => 'ca_objects', 'id' => (int)$set_id]); ?>" hx-target="#lightboxContent" hx-swap="innerHTML">
					<div class="input-group">
						<label for="search-within" class="form-label visually-hidden"><?= _t('Search within'); ?></label>
						<input name="search" id="search-within" type="text" class="form-control rounded-0 border-end-0" placeholder="<?= _t('Search within...'); ?>" value="<?= $this->getVar('search'); ?>">
						<button type="submit" class="btn rounded-0 border border-start-0" aria-label="<?= _t('Search submit'); ?>"><i class="bi bi-search"></i></button>
					</div>
				</form>
<?php if($search){ ?>
				<div id="clearSearch" class="ps-1 display-inline"><button 
						hx-post="<?= caNavUrl($this->request, '', 'Lightbox', 'Detail/'.(int)$set_id); ?>" 
						hx-target="#lightboxContent" 
						hx-trigger="click" 
						hx-swap="innerHTML"
						class="btn btn-light" 
						type="button">
						<?php print _t("%1 %2 for <i>%3</i>", $total, (($total == 1) ? _t("result") : _t("results")), $search); ?> <i class="ms-1 bi bi-x-circle" aria-label="remove"></i>
				</button></div>
<?php } ?>

				<input type="hidden" name="selection" id="selection" value=""/>
				<input type="hidden" name="omitSelection" id="omitSelection" value=""/>
			</div>
			<div class="col-md-12 col-lg-7 text-lg-end pt-2 mt-lg-0">
				<ul class="list-group list-group-horizontal justify-content-lg-end small">


<?php 
				if(sizeof($sorts) > 0) { ?>
					<li class='list-group-item border-0 px-0 pt-1'>
						<ul class='list-inline p-0 ms-lg-3'>
							<li class='list-inline-item fw-medium text-uppercase me-1'><?= _t("Sort by:"); ?></li>
<?php 
					$i = 0;
					foreach($sorts as $sort => $sort_bundle) {
						$i++;
						if($sort == $current_sort){
?>
							<li class='list-inline-item me-1'><?= $sort; ?></li>
<?php						
						}else{
?>
							<li class='list-inline-item me-1'>
								<a href="#" 
									id="sort_<?= $i; ?>" 
									hx-post="<?= caNavUrl($this->request, '*', '*', 'Detail/'.$set_id, ['sort' => $sort]); ?>" 
									hx-trigger="click" 
									hx-target="#lightboxContent" 
									hx-swap="innerHTML">
										<?= $sort; ?>
								</a>
							</li>		
<?php				
						}
						if($i < sizeof($sorts)){
							print "<li class='list-inline-item me-1'>|</li>";
						}
					}
?>
							<li class='list-inline-item'>
								<a href="#" class="align-middle"
								 hx-post="<?= caNavUrl($this->request, '*', '*', 'Detail/'.$set_id, ['sort' => $current_sort, 'sortDirection' => ($current_sort_direction === 'asc') ? 'desc' : 'asc']); ?>" 
								 hx-trigger="click" 
								 hx-target="#lightboxContent" 
								 hx-swap="innerHTML" 
								 title="<?= _t("Sort direction"); ?>" 
								 aria-label="<?= _t("Sort direction"); ?>">
									<i class='bi bi-sort-alpha-<?= (($current_sort_direction == 'asc') ? "up" : "down"); ?>'></i>
								</a>
							</li>
						</ul>
					</li>
<?php
		}
		if(sizeof($configured_modes) > 0){
?>			
			<li class='list-group-item border-0 px-0 pt-0'>
				<ul class='list-inline p-0 ms-lg-3'>
<?php
				foreach($configured_modes as $view_mode => $view_mode_info) {
					print "<li class='list-inline-item me-1'>";
					if ($view_mode === $current_view_mode) {
						print '<button class="btn btn-dark btn-sm disabled" aria-label="'.$view_mode_info['display_name'].'"  title="'.$view_mode_info['display_name'].'">'.$view_mode_info['display_icon'].'</button>';
					} else {
?>
						<a href="#" class="btn btn-light btn-sm"
								 hx-post="<?= caNavUrl($this->request, '*', '*', 'Detail/'.$set_id, ['mode' => $view_mode]); ?>" 
								 hx-trigger="click" 
								 hx-target="#lightboxContent" 
								 hx-swap="innerHTML" 
								 title="<?= $view_mode_info['display_name']; ?>" 
								 aria-label="<?= $view_mode_info['display_name']; ?>">
									<?= $view_mode_info['display_icon']; ?>
								</a>
<?php

					}
					print "</li>\n";
				}
?>						
				</ul>
			</li>
<?php
	}
?>	

					</ul><!-- end list group -->
				</div><!-- end col -->
			</div><!-- end row -->
			
			<div class="row mt-2">
<?php } ?> <!-- end if incremental -->
<?= $this->render($configured_modes[$current_view_mode]['view']);   ?>
<?php if(!$incremental) { ?>
	</div>
</div><!-- end lightboxContent -->
<?php } ?> <!-- end if incremental -->

<script>
if (typeof selectionListInput === 'undefined') {

	const selectionListInput = document.getElementById('selection');
	const omitSelectionListInput = document.getElementById('omitSelection');
	const selectAllBtn = document.getElementById('select-all-btn');
	const actionsDropdown = document.getElementById('actionsDropdown');

	// Initialize selection list
	let selectionList = selectionListInput.value.split(/;/).filter(Boolean);
	let omitSelectionList = omitSelectionListInput.value.split(/;/).filter(Boolean);

		// Helper to update the selection list and UI
	function updateSelectionList() {
		selectionListInput.value = selectionList.join(';');
		omitSelectionListInput.value = omitSelectionList.join(';');
		actionsDropdown.classList.toggle('d-none', selectionList.length === 0); // Show or hide Actions dropdown
	}
	
	function toggleSelection(id) {
		const selectBtn = document.getElementById('lb-select-btn-' + id);
		
		id = '' + id;	// force to string
		if(selectionList.includes(id)) {
			selectionList = selectionList.filter(function(v) { return v !== id });
			omitSelectionList.push(id);
			selectBtn.classList.remove('lb-selected');
		} else {
			selectionList.push(id);
			omitSelectionList = omitSelectionList.filter(function(v) { return v !== id });
			selectBtn.classList.add('lb-selected');
		}

		updateSelectionList();
	}

	function toggleSelectAll() {
		const isSelectMode = selectAllBtn.getAttribute('data-state') === 'select'; // Check if it's in "Select All" mode
		const allSelectButtons = document.querySelectorAll('.btn-select'); // Select all card buttons

		// Loop through all card buttons and toggle their selection based on the current mode
		allSelectButtons.forEach(button => {
			const id = button.id.replace('lb-select-btn-', ''); // Extract the ID
			const isSelected = selectionList.includes(id);

			if (isSelectMode && !isSelected) {
				toggleSelection(id); // Select the card if not already selected
			} else if (!isSelectMode && isSelected) {
				toggleSelection(id); // Deselect the card if it is selected
			}
		});

		// Update the button state and text
		selectAllBtn.setAttribute('data-state', isSelectMode ? 'deselect' : 'select');
		selectAllBtn.innerHTML = isSelectMode
			? '<i class="bi bi-x-circle-fill"></i> <?= _t("Deselect All"); ?>'
			: '<i class="bi bi-check-circle-fill"></i> <?= _t("Select All"); ?>';
	}
	
	function downloadSelected(dtype, dversion, url) {
		const allAreSelected = selectAllBtn.getAttribute('data-state') === 'deselect'; 
		const item_ids = document.getElementById('selection').value;
		const omit_item_ids = document.getElementById('omitSelection').value;
		switch(dtype) {
			case 'media':
				window.location = url + '/item_id/' + item_ids + ((allAreSelected === true) ? '/selectAll/1/omit_item_id/' + omit_item_ids : '');
				break;
			default:
				window.location = url + '/item_id/' + item_ids + ((allAreSelected === true) ? '/selectAll/1/omit_item_id/' + omit_item_ids : '');
				break;
		}
	}

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
					const id = button.id.replace('lb-select-btn-', '');
					button.classList.add('lb-selected'); // Add selected class

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