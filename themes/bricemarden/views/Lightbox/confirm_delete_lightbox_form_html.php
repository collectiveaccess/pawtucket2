<?php
$lightbox_displayname_singular 		= $this->getVar("lightbox_displayname_singular");
$lightbox_displayname_plural 		= $this->getVar("lightbox_displayname_plural");
?>
<div class="modal fade" id="deleteLightboxModal" tabindex="-1" aria-labelledby="deleteLightboxModalLabel" aria-hidden="true">
  <div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header">
		<h1 class="modal-title fs-3" id="deleteLightboxModalLabel"><?= _t('Delete'); ?></h1>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= _t('Close'); ?>"></button>
	  </div>
	  <div class="modal-body">
			<?= _t('Really delete %1?', $lightbox_displayname_singular); ?>
			<input type="hidden" name="id" id="deleteLightboxId" value="">
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-primary" data-bs-dismiss="modal" 
			hx-post="<?= caNavUrl($this->request, '*', '*', 'Delete'); ?>" 
			hx-include="#deleteLightboxId"
			hx-target="#lightboxContent"
			hx-swap="outerHTML"
		><?= _t('Delete'); ?></button>
		<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= _t('Cancel'); ?></button>
	  </div>
	</div>
  </div>
</div>
