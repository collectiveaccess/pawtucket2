<?php
$qr_sets 							= $this->getVar('qr_sets');
$t_set 								= new ca_sets();
$user_id							= $this->request->getUserID();
$access_values 						= $this->getVar("access_values");
$o_lightbox_config 					= $this->getVar("set_config");
$lightbox_displayname_singular 		= $this->getVar("lightbox_displayname_singular");
$lightbox_displayname_plural 		= $this->getVar("lightbox_displayname_plural");
$configured_modes = $this->getVar('configured_modes');
$current_view_mode = $this->getVar('mode');
$current_view_mode_info = $configured_modes[$current_view_mode];

$image_format = caGetOption('image_format', $current_view_mode_info, 'cover');
$image_class = "";
if($image_format == "contain"){
	$image_class = "card-img-top object-fit-contain px-3 pt-3 rounded-0";
}else{
	$image_class = "card-img-top object-fit-cover rounded-0";
}

while($qr_sets->nextHit()) {
	$set_id = $qr_sets->get('ca_sets.set_id');
	$table = $qr_sets->get('table_num');
	$caption = $qr_sets->get('ca_sets.preferred_labels.name');
	$detail_link = caNavLink($this->request, "<i class='bi bi-arrow-right-square'></i>", 'btn btn-white px-2', '*', '*', "Detail/{$set_id}", null, array("title" => _t("View %1", $lightbox_displayname_singular), "aria-label" => _t("View %1", $lightbox_displayname_singular)));
	$can_delete = $t_set->haveAccessToSet($user_id, __CA_SET_EDIT_ACCESS__, $set_id);
?>
	<div class='col-md-6 col-lg-4 d-flex'>
		<div id='lb-<?= $set_id; ?>' class='card flex-grow-1 width-100 rounded-0 shadow border-0 mb-4'>
		  <?= caGetLightboxPreviewImage($qr_sets->getPrimaryKey(), $qr_sets, ['checkAccess' => $access_values, 'class' => $image_class]); ?>
			<div class='card-body'>
				<div class='card-title'>
					<div class='fw-medium lh-sm fs-5'><?= caNavLink($this->request, $caption, '', '*', '*', "Detail/{$set_id}"); ?></div>
					<small class='text-body-secondary'><?= $qr_sets->getWithTemplate('^ca_sets._itemCount').' '.Datamodel::getTableProperty($table, 'NAME_PLURAL'); ?></small>
				</div>
			</div>
			<div class='card-footer text-end bg-transparent'>
				<?= $detail_link; ?>
<?php if($can_delete) { ?>
				<button type="button" 
						class="btn btn-white px-2" 
						data-bs-toggle="modal" 
						data-bs-target="#deleteLightboxModal"
						hx-on:click="document.getElementById('deleteLightboxId').value = '<?= $set_id;?>';"
						title="<?= _t("Delete %1", $lightbox_displayname_singular); ?>"
						aria-label="<?= _t("View %1", $lightbox_displayname_singular); ?>"><i class="bi bi-trash3"></i></button>
<?php } ?>
			</div>
		 </div>	
	</div><!-- end col -->
<?php	
}

print $this->render("Lightbox/snippets/lightbox_list_incremental_load_html.php");