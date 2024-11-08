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
?>
<div id="lightboxContent">
	<!-- BEGIN Modals -->	
		<!-- Add lightbox modal -->
		<?= $this->render("Lightbox/add_lightbox_form_html.php"); ?>
		
		<!-- Confirm lightbox delete modal -->
		<?= $this->render("Lightbox/confirm_delete_lightbox_form_html.php"); ?>
	<!-- END Modals -->
	
	<h1>
		<?= ucfirst($lightbox_displayname_plural); ?>
	</h1>

<?php if(is_array($errors) && sizeof($errors)) { ?>
	<div id="errors" class="alert alert-warning alert-dismissible fade show" role="alert">
		<ul><?= join("\n", array_map(function($v) { return "<li>{$v}</li>\n"; }, $errors)); ?></ul>
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>
<?php } ?>

	<div class="row">
		<div class="col text-center text-md-end">
			<hr class="mb-0">
			<div class="btn-group mb-2" role="group" aria-label="<?= _t('Lightbox List Controls'); ?>">
				<button type="button" class="btn btn-sm btn-white ps-3 pe-0 fw-medium" data-bs-toggle="modal" data-bs-target="#addLightboxModal"><i class='bi bi-plus-square-fill'></i> <?= _t("New %1", $lightbox_displayname_singular); ?></button>
			</div>
		</div>
	</div>
	<div class="row">
<?php
		if(!$qr_sets) {
?>
			<div class='col-md-12 col-lg-12 d-flex'>
				<?= _t('No lightboxes available'); ?>
			</div>	
<?php
		} else {
			while($qr_sets->nextHit()) {
				$set_id = $qr_sets->get('ca_sets.set_id');
				$table = $qr_sets->get('table_num');
				$caption = $qr_sets->get('ca_sets.preferred_labels.name');
				$detail_link = caNavLink($this->request, _t('View'), '', '*', '*', "Detail/{$set_id}");
				$can_delete = $t_set->haveAccessToSet($user_id, __CA_SET_EDIT_ACCESS__, $set_id);
?>
				<div class='col-md-6 col-lg-4 d-flex'>
					<div id='row{$vn_id}' class='card flex-grow-1 width-100 rounded-0 shadow border-0 mb-4'>
					  <?= caGetLightboxPreviewImage($qr_sets->getPrimaryKey(), $qr_sets, ['checkAccess' => $access_values, 'class' => 'object-fit-cover']); ?>
						<div class='card-body'>
							<?= $caption; ?>
						</div>
						<div class='card-footer'>
							<div class="d-flex flex-row justify-content-between">
								<div class=''>
									<?= $detail_link; ?>
									<?= $qr_sets->getWithTemplate('^ca_sets._itemCount').' '.Datamodel::getTableProperty($table, 'NAME_PLURAL'); ?>
								</div>
<?php if($can_delete) { ?>
								<div><button type="button" 
									class="btn p-0" 
									data-bs-toggle="modal" 
									data-bs-target="#deleteLightboxModal"
									hx-on:click="document.getElementById('deleteLightboxId').value = '<?= $set_id;?>';"><i class="bi bi-trash3"></i></button>
								</div>
<?php } ?>
							</div>
						</div>
					 </div>	
				</div><!-- end col -->
<?php
			}
		}
?>
	</div>
</div>
