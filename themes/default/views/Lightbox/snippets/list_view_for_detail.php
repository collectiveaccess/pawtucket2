<?php
$qr_items 	= $this->getVar('items');
$table 		= $this->getVar('table');
$t_list_item = new ca_list_items();
$access_values 	= $this->getVar('access_values');
$result_caption_template = $this->getVar('caption_template'); 

$o_lightbox_config 					= $this->getVar("set_config");
$lightbox_displayname_singular 		= $this->getVar("lightbox_displayname_singular");
$lightbox_displayname_plural 		= $this->getVar("lightbox_displayname_plural");

$t_set 								= $this->getVar('t_set');
$user_id 							= $this->request->getUserID();
$can_delete 						= $t_set->haveAccessToSet($user_id, __CA_SET_EDIT_ACCESS__);

// View modes
$configured_modes = $this->getVar('configured_modes');
$current_view_mode = $this->getVar('mode');
$current_view_mode_info = $view_modes[$current_view_mode];

$image_format = caGetOption('image_format', $current_view_mode_info, 'cover');
$image_class = "";
if($image_format == "contain"){
	$image_class = "card-img-top object-fit-contain px-3 pt-3 rounded-0";
}else{
	$image_class = "card-img-top object-fit-cover rounded-0";
}
?>
<div class="row row-cols-md-2">
<?php
	while($qr_items->nexthit()) {
		$item_is_in_users_lightbox = caItemIsInUserLightbox($qr_items, $this->request->getUserID());
		$id = $qr_items->getPrimaryKey();
		
		$detail_button_link = caDetailLink($this->request, "<i class='bi bi-arrow-right-square'></i>", 'btn btn-white', $table, $id, null, array("title" => _t("View record"), "aria-label" => _t("View record")));
		$caption 	= $qr_items->getWithTemplate($result_caption_template, array("checkAccess" => $item_is_in_users_lightbox ? null : $access_values));
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
		$rep_detail_link = caDetailLink($this->request, $image, 'lb-detail-img-link', $table, $id);			
?>
			<div class='col-xs-12 col-sm-6 mb-2'>
				<div id='lb-item-<?= $id; ?>' class='card width-100 rounded-0 shadow border-0 mb-4'>
					<div class='row g-0'>
						<div class='col-sm-3'>
							<?= $rep_detail_link; ?>
						</div>
						<div class='col-sm-9'>
							<div class='card-body' id='lb-item-caption-<?= $id; ?>'>
								<?= $caption; ?>
							</div>
						</div>
					</div>
					<div class='row g-0'>
						<div class='col-sm-12'>
							<div class='card-footer text-end bg-transparent'>
								<button type="button" 
									id='lb-select-btn-<?= $id; ?>'
									onclick='toggleSelection(<?= $id; ?>)'
									class="btn btn-white btn-select" 
									title="<?= _t("Select record"); ?>"
									aria-label="<?= _t("Select record"); ?>"><i class="bi bi-check-circle"></i></button>
								<?= $detail_button_link; ?>
<?php if($can_delete) { ?>
								<button class="btn btn-white" 
									title="<?= _t('Remove from %1', $lightbox_displayname_plural); ?>" 
									aria-label="<?= _t('Remove from %1', $lightbox_displayname_plural); ?>"
									data-bs-toggle="modal" 
									data-bs-target="#deleteLightboxItemModal"
									hx-on:click="document.getElementById('deleteLightboxItemId').value = '<?= $id;?>';"><i class='bi bi-x-square'></i></button>
<?php } ?>
							</div>
						</div>
					</div>
				 </div>
			</div>

<?php } ?>
</div>

<?= $this->render("Lightbox/snippets/lightbox_list_incremental_load_html.php"); ?>