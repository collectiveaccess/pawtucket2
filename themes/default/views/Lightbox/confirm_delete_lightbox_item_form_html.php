<?php
$lightbox_displayname_singular 		= $this->getVar("lightbox_displayname_singular");
$lightbox_displayname_plural 		= $this->getVar("lightbox_displayname_plural");
$t_set 								= $this->getVar('t_set');
?>
<div class="modal fade" id="deleteLightboxItemModal" tabindex="-1" aria-labelledby="deleteLightboxItemModalLabel" aria-hidden="true">
  <div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header">
		<h1 class="modal-title fs-3" id="deleteLightboxItemModalLabel"><?= _t('Delete'); ?></h1>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= _t('Close'); ?>"></button>
	  </div>
	  <div class="modal-body">
			<span id="deleteLightboxItemModalHeader"></span>
			<input type="hidden" name="item_id" id="deleteLightboxItemId" value="">
			<input type="hidden" name="id" id="deleteLightboxItemSetId" value="<?= $t_set->getPrimaryKey(); ?>">
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-primary" data-bs-dismiss="modal" 
			hx-post="<?= caNavUrl($this->request, '*', '*', 'DeleteItems'); ?>" 
			hx-include="#deleteLightboxItemId,#deleteLightboxItemSetId"
			hx-target="#lightboxContent"
			hx-swap="outerHTML"
		><?= _t('Delete'); ?></button> 
		<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= _t('Cancel'); ?></button>
	  </div>
	</div>
  </div>
</div>

<script>
	document.getElementById('deleteLightboxItemModal').addEventListener('shown.bs.modal', function () {
		const idList = document.getElementById('deleteLightboxItemId').value.split(/;/);
		const itemCount = idList.length;
		
		document.getElementById('deleteLightboxItemModalHeader').innerHTML = (itemCount === 1) ? 
			<?= json_encode(_t('Really delete %1 item?', $lightbox_displayname_singular)); ?> 
			:
			<?= json_encode(_t('Really delete selected %1 items?', $lightbox_displayname_singular)); ?>;
	});
</script>