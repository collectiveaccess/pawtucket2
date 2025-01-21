<?php
$lightbox_displayname_singular 		= $this->getVar("lightbox_displayname_singular");
$lightbox_displayname_plural 		= $this->getVar("lightbox_displayname_plural");
?>
<div class="modal fade" id="lightboxAccessModal" tabindex="-1" aria-labelledby="lightboxAccessModalLabel" aria-hidden="true">
  <div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header">
		<h1 class="modal-title fs-3" id="lightboxAccessModalLabel"><?= _t('Access'); ?></h1>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= _t('Close'); ?>"></button>
	  </div>
	  <div class="modal-body">

		<div class="form-check mb-3">
			<input type="checkbox" class="form-check-input" id="directDownload">
			<label class="form-check-label" for="directDownload"><?= _t('Direct download'); ?></label>
		</div>

		<div class="mb-3">
			<label for="mediaVersion" class="form-label"><?= _t('Downloadable version'); ?></label>
			<select id="mediaVersion" class="form-select">
				<option selected>Select media version</option>
				<option value="1">Version 1</option>
				<option value="2">Version 2</option>
				<option value="3">Version 3</option>
			</select>
		</div>

		<div class="input-group mt-4">
			<input type="text" class="form-control" value="" id="lightboxLink" readonly>
			<button class="btn btn-secondary" type="button" id="copyButton" aria-label="Copy link">
				<i class="bi bi-scissors"></i>
			</button>
		</div>

		<!-- <label for="lightboxName" class="col-form-label"><?= _t('Name'); ?>:</label>
		<?= caHTMLTextInput('name', ['value' => $mv['name'] ?? null, 'class' => 'form-control lightboxEditFormControl', 'id' => 'lightboxName'], ['width' => '100%']); ?>
		
		<label for="lightboxDescription" class="col-form-label"><?= _t('Description'); ?>:</label>
		<?= caHTMLTextInput('description', ['value' => $mv['description'] ?? null, 'class' => 'form-control lightboxEditFormControl', 'id' => 'lightboxDescription'], ['width' => '100%', 'height' => 4]); ?>
	 	<?= caHTMLHiddenInput('id', ['value' => $set_id, 'class' => 'lightboxEditFormControl']); ?> -->

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
