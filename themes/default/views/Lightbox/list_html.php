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

$start = $this->getVar('start');
$limit = $this->getVar('limit');
$total = $this->getVar('total');
$incremental = $this->getVar('is_incremental_load');

$configured_modes = $this->getVar('configured_modes');
$current_view_mode = $this->getVar('mode');

$sorts = $this->getVar('sorts');
$sort_directions = $this->getVar('sort_directions');
$current_sort = $this->getVar('current_sort');
$current_sort_direction = $this->getVar('current_sort_direction');

$search = $this->getVar('search');

if(!$incremental) { ?>
<div id="lightboxContent">
	<!-- BEGIN Modals -->	
		<!-- Add lightbox modal -->
		<?= $this->render("Lightbox/add_lightbox_form_html.php"); ?>
		
		<!-- Confirm lightbox delete modal -->
		<?= $this->render("Lightbox/confirm_delete_lightbox_form_html.php"); ?>
	<!-- END Modals -->
	
		<div class="row">
			<div class="col">
				<H1 class="text-capitalize mb-0">My <?= ucfirst($lightbox_displayname_plural); ?></h1>
			</div>
			<div class="col text-end">
				<div class="btn-group" role="group" aria-label="<?= _t('%1 List Controls', $lightbox_displayname_singular); ?>">
					<button type="button" class="btn btn-white pe-0" data-bs-toggle="modal" data-bs-target="#addLightboxModal"><i class='bi bi-plus-square-fill'></i> <?= _t("New %1", $lightbox_displayname_singular); ?></button>
				</div>
			</div>
		</div>
		<div class="row pt-2 pb-3">
			<div class="col"><hr class="my-0"></div>
		</div>
<?php if(is_array($errors) && sizeof($errors)) { ?>
		<div id="errors" class="alert alert-warning alert-dismissible fade show" role="alert">
			<ul><?= join("\n", array_map(function($v) { return "<li>{$v}</li>\n"; }, $errors)); ?></ul>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
<?php } ?>

		<div class="row">
			<div class="col-md-12 col-lg-5 d-flex">
				<form role="search" id="searchWithin" hx-post="<?= caNavUrl($this->request, '', '*', 'Search', ['t' => 'ca_sets']); ?>" hx-target="#lightboxContent" hx-swap="innerHTML">
					<div class="input-group">
						<label for="search-within" class="form-label visually-hidden"><?= _t('Search within'); ?></label>
						<input name="search" id="search-within" type="text" class="form-control rounded-0 border-end-0" placeholder="<?= _t('Search within...'); ?>" aria-label="<?= _t('Search within'); ?>" value="<?= $this->getVar('search'); ?>">
						<button type="submit" class="btn rounded-0 border border-start-0" aria-label="<?= _t('Search submit'); ?>"><i class="bi bi-search"></i></button>
						
					</div>
				</form>
<?php if($search){ ?>
				<div id="clearSearch" class="ps-1 display-inline"><button 
						hx-post="<?= caNavUrl($this->request, '', '*', 'Search', ['t' => 'ca_sets', 'search' => '']); ?>" 
						hx-target="#lightboxContent" 
						hx-trigger="click" 
						hx-swap="innerHTML"
						class="btn btn-light" 
						type="button">
						<?php print _t("%1 %2 for <i>%3</i>", $total, (($total == 1) ? _t("result") : _t("results")), $search); ?> <i class="ms-1 bi bi-x-circle" aria-label="remove"></i>
				</button></div>
<?php } ?>
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
									hx-post="<?= caNavUrl($this->request, '*', '*', 'Index', ['sort' => $sort]); ?>" 
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
								 hx-post="<?= caNavUrl($this->request, '*', '*', 'Index', ['sort' => $current_sort, 'sortDirection' => ($current_sort_direction === 'asc') ? 'desc' : 'asc']); ?>" 
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
								 hx-post="<?= caNavUrl($this->request, '*', '*', 'Index', ['mode' => $view_mode]); ?>" 
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
			</ul>
		</div>
	</div>

	<div class="row mt-2">
<?php
	} 
	if(!$qr_sets) {
?>
		<div class='col-md-12 col-lg-12 d-flex'>
			<?= _t('No lightboxes available'); ?>
		</div>	
<?php
	} else {
		if(!($view = $configured_modes[$current_view_mode]["view"])){
			$view = "Lightbox/snippets/lightbox_list_as_images_html.php";
		}
		print $this->render($configured_modes[$current_view_mode]["view"]);
	}
?>
	</div>
<?php
	if(!$incremental) {
?>
</div><!-- end lightboxContent -->
<?php
	}
?>