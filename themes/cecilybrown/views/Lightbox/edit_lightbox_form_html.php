<?php
$set_id								= $this->getVar('set_id');
$lightbox_displayname_singular 		= $this->getVar("lightbox_displayname_singular");
$lightbox_displayname_plural 		= $this->getVar("lightbox_displayname_plural");
$mv									= $this->getVar('modalValues');
?>
<div class="modal fade" id="editLightboxModal" tabindex="-1" aria-labelledby="editLightboxModalLabel" aria-hidden="true">
  <div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header">
		<h1 class="modal-title fs-3" id="editLightboxModalLabel"><?= _t('Edit %1', $lightbox_displayname_singular); ?></h1>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= _t('Close'); ?>"></button>
	  </div>
	  <div class="modal-body">
		<label for="lightboxName" class="col-form-label"><?= _t('Name'); ?>:</label>
		<?= caHTMLTextInput('name', ['value' => $mv['name'] ?? null, 'class' => 'form-control lightboxEditFormControl', 'id' => 'lightboxName'], ['width' => '100%']); ?>
		
		<label for="lightboxDescription" class="col-form-label"><?= _t('Description'); ?>:</label>
		<?= caHTMLTextInput('description', ['value' => $mv['description'] ?? null, 'class' => 'form-control lightboxEditFormControl', 'id' => 'lightboxDescription'], ['width' => '100%', 'height' => 4]); ?>
	 	<?= caHTMLHiddenInput('id', ['value' => $set_id, 'class' => 'lightboxEditFormControl']); ?>
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-primary" data-bs-dismiss="modal" 
			hx-post="<?= caNavUrl($this->request, '*', '*', 'Edit'); ?>" 
			hx-include=".lightboxEditFormControl"
			hx-target="#lightboxContent"
			hx-swap="outerHTML"
		><?= _t('Save'); ?></button>
		<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= _t('Close'); ?></button>
	  </div>
	</div>
  </div>
</div>
