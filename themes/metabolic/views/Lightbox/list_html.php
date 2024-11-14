<?php
/** ---------------------------------------------------------------------
 * themes/default/Lightbox/set_list_html.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2015-2024 Whirl-i-Gig
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
$qr_sets 							= $this->getVar('qr_sets');
$write_sets 						= $this->getVar("write_sets");
$read_sets 							= $this->getVar("read_sets");
$set_ids 							= $this->getVar("set_ids");
$access_values 						= $this->getVar("access_values");
$lightbox_displayname_singular 		= $this->getVar("lightbox_displayname_singular");
$lightbox_displayname_plural 		= $this->getVar("lightbox_displayname_plural");
$o_lightbox_config 					= $this->getVar("set_config");
$current_sort 						= $this->getVar('sort');
$current_sort_dir 					= $this->getVar('direction');
$errors								= $this->getVar('errors');

$preserve							= $this->getVar('preserveModalValues');
$mv									= $this->getVar('modalValues');

$t_set 								= new ca_sets();
$user_id							= $this->request->getUserID();

$mode = $this->getVar('mode');
$start = $this->getVar('start');
$limit = $this->getVar('limit');
$total = $this->getVar('total');
$incremental = $this->getVar('is_incremental_load');

$sorts = $this->getVar('sorts');
$sort_directions = $this->getVar('sort_directions');
$current_sort = $this->getVar('current_sort');
$current_sort_direction = $this->getVar('current_sort_direction');

if(!$incremental) { ?>
<div id="lightboxContent">
	<!-- BEGIN Modals -->	
		<!-- Add lightbox modal -->
		<?= $this->render("Lightbox/add_lightbox_form_html.php"); ?>
		
		<!-- Confirm lightbox delete modal -->
		<?= $this->render("Lightbox/confirm_delete_lightbox_form_html.php"); ?>
	<!-- END Modals -->
	
	<div class="row justify-content-center">
		<div class="col-sm-12 col-md-10">
	
		<div class="row mb-3">
			<div class="col">
				<h1>My <?= ucfirst($lightbox_displayname_plural); ?></h1>
			</div>
			<div class="col text-end">
				<div class="btn-group" role="group" aria-label="<?= _t('Lightbox List Controls'); ?>">
					<button type="button" class="btn btn-sm btn-white ps-3 pe-0 pt-2 fw-medium" data-bs-toggle="modal" data-bs-target="#addLightboxModal"><i class='bi bi-plus-square-fill'></i> <?= _t("New %1", $lightbox_displayname_singular); ?></button>
				</div>
			</div>
			<hr class="mb-0">
		</div>
<?php if(is_array($errors) && sizeof($errors)) { ?>
		<div id="errors" class="alert alert-warning alert-dismissible fade show" role="alert">
			<ul><?= join("\n", array_map(function($v) { return "<li>{$v}</li>\n"; }, $errors)); ?></ul>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
<?php } ?>

		<div class="row">
			<div class="col-auto d-flex">
				<form role="search" id="searchWithin" hx-post="<?= caNavUrl($this->request, '', '*', 'Search', ['t' => 'ca_sets']); ?>" hx-target="#lightboxContent" hx-swap="innerHTML">
					<div class="input-group">
						<label for="search-within" class="form-label visually-hidden"><?= _t('Search within'); ?></label>
						<input name="search" id="search-within" type="text" class="form-control rounded-0 border-end-0" placeholder="<?= _t('Search within...'); ?>" aria-label="<?= _t('Search within'); ?>" value="<?= $this->getVar('search'); ?>">
						<button type="submit" class="btn rounded-0 border border-start-0" aria-label="<?= _t('Search submit'); ?>"><i class="bi bi-search"></i></button>
						
					</div>
				</form>
				<button id="clearSearch" 
						hx-post="<?= caNavUrl($this->request, '', '*', 'Search', ['t' => 'ca_sets', 'search' => '']); ?>" 
						hx-target="#lightboxContent" 
						hx-trigger="click" 
						hx-swap="innerHTML"
						class="btn btn-sm" 
						type="button" 
						onclick="toggleClearButton(); return false;" 
						style="display: <?= !empty($this->getVar('search')) ? 'inline-block' : 'none'; ?>;">
					<i class="bi bi-x-circle"></i>
				</button>
			</div>
			<script>
				function toggleClearButton() {
					const searchInput = document.getElementById('search-within');
					const clearButton = document.getElementById('clearSearch');
					clearButton.style.display = searchInput.value ? 'inline-block' : 'none';
					searchInput.value = '';
				}
			</script>
			
			<div class="col-auto d-flex ms-auto">
<?php if(sizeof($sorts) > 0) { ?>
			<div class="dropdown me-3">
				<button type="button" class="btn btn-sm btn-white ps-3 pe-0 fw-medium"  id="sortList" data-bs-toggle="dropdown" aria-expanded="false">
					<?= _t('Sort by %1', $current_sort); ?>
				</button>
				<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
				<?php foreach($sorts as $sort => $sort_bundle) { ?>
					<li 
						id="sort_<?= $i; ?>" 
						hx-post="<?= caNavUrl($this->request, '*', '*', 'Index', ['sort' => $sort]); ?>" 
						hx-trigger="click" 
						hx-target="#lightboxContent" 
						hx-swap="innerHTML">

						<div class="dropdown-item">
							<a href="#" id="sort_item_<?= $i; ?>">
								<?= $sort; ?>
							</a>
						</div>
					</li>		
				<?php } ?>
				</ul>
				<a href="#" class="align-middle"
				 hx-post="<?= caNavUrl($this->request, '*', '*', 'Index', ['sort' => $current_sort, 'sortDirection' => ($current_sort_direction === 'asc') ? 'desc' : 'asc']); ?>" 
				 hx-trigger="click" 
				 hx-target="#lightboxContent" 
				 hx-swap="innerHTML">
					<i class='bi bi-sort-alpha-<?= (($current_sort_direction == 'asc') ? "up" : "down"); ?>'></i>
				</a>
			</div>
<?php } ?>
			<div class="button-group">
				<button class="btn btn-sm btn-secondary">
					<a href='<?= caNavUrl($this->request, '', 'Lightbox', 'Index/mode/list'); ?>'>
						<i class="bi bi-list-task"></i>
					</a>
				</button>
				<button class="btn btn-sm btn-secondary">
					<a href='<?= caNavUrl($this->request, '', 'Lightbox', 'Index/mode/images'); ?>'>
						<i class="bi bi-grid-fill"></i>
					</a>
				</button>
			</div>
		</div>
	</div>

	<div class="row mt-2">
<?php } ?>
<?php if(!$qr_sets) { ?>
		<div class='col-md-12 col-lg-12 d-flex'>
			<?= _t('No lightboxes available'); ?>
		</div>	
<?php
	} else {
		switch($mode) {
			case 'images':
				print $this->render("Lightbox/snippets/lightbox_list_as_images_html.php");
				break;
			case 'list':
			default:
				print $this->render("Lightbox/snippets/lightbox_list_as_list_html.php");
				break;
		}
	}
	if(!$incremental) {
?>
	</div>
</div>
<?php
}