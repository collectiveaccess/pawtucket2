<?php
$qr_sets 							= $this->getVar('qr_sets');
$t_set 								= new ca_sets();
$user_id							= $this->request->getUserID();
$access_values 						= $this->getVar("access_values");

while($qr_sets->nextHit()) {
	$set_id = $qr_sets->get('ca_sets.set_id');
	$table = $qr_sets->get('table_num');
	$caption = $qr_sets->get('ca_sets.preferred_labels.name');
	$detail_link = caNavLink($this->request, "<i class='bi bi-arrow-right-square'></i>", '', '*', '*', "Detail/{$set_id}");
	$can_delete = $t_set->haveAccessToSet($user_id, __CA_SET_EDIT_ACCESS__, $set_id);
?>
	<div class='col-sm-6 col-md-4 col-lg-3 d-flex mb-4'>
		<div class='w-100 d-flex flex-column justify-content-between'>
			<?= caGetLightboxPreviewImage($qr_sets->getPrimaryKey(), $qr_sets, ['checkAccess' => $access_values, 'class' => 'img-fluid w-100 object-fit-cover']); ?>
			
			<div class='lb-caption text-break mt-auto'>
				<?= $caption; ?>
			</div>

			<div class='lb-controls'>
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

print $this->render("Lightbox/snippets/lightbox_list_incremental_load_html.php");