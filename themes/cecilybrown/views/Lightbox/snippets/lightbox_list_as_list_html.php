<?php
$qr_sets 							= $this->getVar('qr_sets');
$t_set 								= new ca_sets();
$user_id							= $this->request->getUserID();
$access_values 						= $this->getVar("access_values");
$incremental 						= $this->getVar('is_incremental_load');

if(!$incremental) {
?>
<div class="cols-sm-12">
	<div class="list-group my-3">
<?php
}
while($qr_sets->nextHit()) {
	$set_id = $qr_sets->get('ca_sets.set_id');
	$table = $qr_sets->get('table_num');
	$caption = $qr_sets->get('ca_sets.preferred_labels.name');
	$detail_link = caNavLink($this->request,"<i class='bi bi-arrow-right-square'></i>", 'btn btn-sm btn-white ms-3', '*', '*', "Detail/{$set_id}");
	$can_delete = $t_set->haveAccessToSet($user_id, __CA_SET_EDIT_ACCESS__, $set_id);
?>
		<div class='list-group-item border-0 border-bottom px-0'>
			<div id='row{$vn_id}' class='row row-cols-2'>
				<!-- <?= caGetLightboxPreviewImage($qr_sets->getPrimaryKey(), $qr_sets, ['checkAccess' => $access_values, 'class' => 'img-fluid w-100 object-fit-cover']); ?> -->
				
				<div class='col flex-grow-1 text-wrap fw-bold'>
					<?= $caption; ?>
				</div>
	
				<div class='col-auto ms-auto'>
					<?= $qr_sets->getWithTemplate('^ca_sets._itemCount').' '.Datamodel::getTableProperty($table, 'NAME_PLURAL'); ?>
					<?= $detail_link; ?>
<?php if($can_delete) { ?>
					<button
						class="btn btn-sm btn-white" 
						data-bs-toggle="modal" 
						data-bs-target="#deleteLightboxModal"
						hx-on:click="document.getElementById('deleteLightboxId').value = '<?= $set_id;?>';">
						<i class="bi bi-trash3"></i>
					</button>
<?php } ?>
				</div>
			 </div>	
		</div><!-- end list-group-item -->
<?php	
}
print $this->render("Lightbox/snippets/lightbox_list_incremental_load_html.php");

if(!$incremental) {
?>
	</div>
</div>
<?php
}