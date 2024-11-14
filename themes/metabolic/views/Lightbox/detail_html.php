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
$t_set 		= $this->getVar('t_set');
$qr_items 	= $this->getVar('items');
$table 		= $this->getVar('table');
$errors 	= $this->getVar('errors');
$set_id		= $this->getVar('set_id');

$lightbox_displayname_singular 		= $this->getVar("lightbox_displayname_singular");
$lightbox_displayname_plural 		= $this->getVar("lightbox_displayname_plural");

$t_list_item = new ca_list_items();

$access_values 	= $this->getVar('access_values');
$result_caption_template = "^ca_objects.preferred_labels (^ca_objects.idno)";

$user_id = $this->request->getUserID();
$can_delete = $t_set->haveAccessToSet($user_id, __CA_SET_EDIT_ACCESS__);

if($image_format == "contain"){
	$image_class = "object-fit-contain py-3 ps-3 rounded-0";
}else{
	$image_class = "card-img-top object-fit-cover rounded-0";
}
?>
<div id="lightboxContent">
	<!-- BEGIN Modals -->	
		<!-- Edit lightbox modal -->
		<?= $this->render("Lightbox/edit_lightbox_form_html.php"); ?>
		
		<!-- Confirm lightbox delete modal -->
		<?= $this->render("Lightbox/confirm_delete_lightbox_form_html.php"); ?>
	<!-- END Modals -->

<div class="row justify-content-center">
	<div class="col-md-10">

	<div class="row mt-n3">
		<div class="col-auto pe-0">
			<?= caNavLink($this->request, '<i class="bi bi-chevron-left"></i>', 'btn btn-large px-0 pt-2 btn-white fw-medium', '*', 'Lightbox', 'Index'); ?>
		</div>
		<div class="col-auto">
			<h1><?= $t_set->get('ca_sets.preferred_labels.name'); ?></h1>
		</div>
	</div>
	
	
	<div class="row">
		<div class="col text-center text-md-end">
			<hr class="mb-0">
			<div class="btn-group mb-2" role="group" aria-label="Detail Controls">
			
				<button type="button" class="btn btn-sm btn-white ps-3 pe-0 fw-medium" data-bs-toggle="modal" data-bs-target="#editLightboxModal"><i class="bi bi-pencil-square"></i> <?= _t("Edit %1", $lightbox_displayname_singular); ?></button>
<?php
				$sorts = $this->getVar('sorts');
				$sort_directions = $this->getVar('sort_directions');
				if(sizeof($sorts) > 0) {

					$current_sort = $this->getVar('current_sort');
					$current_sort_direction = $this->getVar('current_sort_direction');
?>

<div class="dropdown me-3">
	  <button type="button" class="btn btn-sm btn-white ps-3 pe-0 fw-medium"  id="sortList" data-bs-toggle="dropdown" aria-expanded="false">
		<?= _t('Sort by %1', $current_sort); ?>
	  </button>
	  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
<?php
		foreach($sorts as $sort => $sort_bundle) {
?>
			<li id="sort_<?= $i; ?>" hx-post="<?= caNavUrl($this->request, '*', '*', 'Detail/'.$set_id, ['sort' => $sort]); ?>" hx-trigger="click" hx-target="#lightboxContent" hx-swap="innerHTML">
				<div class="dropdown-item"><a href="#" id="sort_item_<?= $i; ?>"><?= $sort; ?></a></div>
			</li>		
<?php
		}
?>
	  </ul>
	<a href="#" class="align-middle" hx-post="<?= caNavUrl($this->request, '*', '*', 'Detail/'.$set_id, ['sort' => $current_sort, 'sortDirection' => ($current_sort_direction === 'asc') ? 'desc' : 'asc']); ?>" hx-trigger="click" hx-target="#lightboxContent" hx-swap="innerHTML">
	 <i class='bi bi-sort-alpha-<?= (($current_sort_direction == 'asc') ? "up" : "down"); ?>'></i>
	</a>
</div>
<?php
				}
				if($can_delete) {
?>
					<button type="button" 
									class="btn p-0" 
									data-bs-toggle="modal" 
									data-bs-target="#deleteLightboxModal"
									hx-on:click="document.getElementById('deleteLightboxId').value = '<?= $set_id;?>';"><i class="bi bi-trash3"></i></button>
							
<?php
				}
	?>	
			</div>
		</div>
	</div>
	
	<div class="row">
	<?php
	while($qr_items->nexthit()) {
		$id = $qr_items->getPrimaryKey();
		
		$detail_button_link = caDetailLink($this->request, "<i class='bi bi-arrow-right-square'></i>", 'link-dark mx-1', $table, $id, null, array("title" => _t("View Record"), "aria-label" => _t("View Record")));
		$caption 	= $qr_items->getWithTemplate($result_caption_template, array("checkAccess" => $access_values));
		$image = ($table === 'ca_objects') ? $qr_items->get('ca_object_representations.media.medium', ["checkAccess" => $access_values, "class" => $image_class]) : $images[$id];
			
		if(!$image){
			if ($table == 'ca_objects') {
				$t_list_item->load($qr_items->get("type_id"));
				$typecode = $t_list_item->get("idno");
				if($type_placeholder = caGetPlaceholder($typecode, "placeholder_media_icon")){
					$image = "<div class='bResultItemImgPlaceholder'>{$type_placeholder}</div>";
				}else{
					$image = $default_placeholder_tag;
				}
			}else{
				$image = $default_placeholder_tag;
			}
		}
		$rep_detail_link 	= caDetailLink($this->request, $image, '', $table, $id);			
	?>
			<div class='col-sm-6 col-lg-3 d-flex'>
				<div id='row{$id}' class='mb-4'>
					<div class='row g-0'>
						<div class='col-sm-12'>
							<?= $rep_detail_link; ?>
						</div>
					</div>
					<div class='row g-0'>
						<div class='col-sm-12'>
							<div class=''>
								<?= $caption; ?>
								<?= $detail_button_link; ?><?= $add_to_set_link; ?>
							</div>
						</div>
					</div>
				 </div>	
			</div>
	<?php
	}
	?>
	</div><!-- end col -->
</div>

	</div><!-- end col -->
</div>
