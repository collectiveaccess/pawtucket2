<?php
$lightbox_displayname_singular 		= $this->getVar("lightbox_displayname_singular");
$lightbox_displayname_plural 		= $this->getVar("lightbox_displayname_plural");
$preserve							= $this->getVar('preserveModalValues');
$mv									= $this->getVar('modalValues');
?>
<!-- Add lightbox modal -->
<div class="modal fade" id="addLightboxModal" tabindex="-1" aria-labelledby="addLightboxModalLabel" aria-hidden="true">
  <div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header">
		<h1 class="modal-title fs-5" id="addLightboxModalLabel"><?= _t('New %1', $lightbox_displayname_singular); ?></h1>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= _t('Close'); ?>"></button>
	  </div>
	  <div class="modal-body">
		<label for="lightboxName" class="col-form-label"><?= _t('Name'); ?>:</label>
		<?= caHTMLTextInput('name', ['value' => $preserve ? $mv['name'] ?? null : null, 'class' => 'form-control lightboxAddFormControl', 'id' => 'lightboxName'], ['width' => '100%']); ?>
	 </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-primary" data-bs-dismiss="modal" 
			hx-post="<?= caNavUrl($this->request, '*', '*', 'Add'); ?>" 
			hx-include=".lightboxAddFormControl"
			hx-target="#lightboxContent"
			hx-swap="outerHTML"
		><?= _t('Save'); ?></button>
		<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= _t('Close'); ?></button>
	  </div>
	</div>
  </div>
</div>
