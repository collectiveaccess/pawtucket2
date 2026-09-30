<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Lightbox/add_lightbox_form_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2024-2026 Whirl-i-Gig
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
 * ----------------------------------------------------------------------
 */
$preserve							= $this->getVar('preserveModalValues');
$mv									= $this->getVar('modalValues');

$lightbox_conf = caGetLightboxConfig();
$lightbox_displayname_singular = $lightbox_conf->get('lightbox_displayname_singular');
$lightbox_displayname_plural = $lightbox_conf->get('lightbox_displayname_plural');

# --- when used on detail pages need row id and table to add record to new lightbox
$id = $table = null;
$t_item = $this->getVar("item");
if($t_item){
	$id = $t_item->getPrimaryKey();
	$table = $t_item->TableName();
}
$target = $this->getVar('target');
if(!$target){
	$target = "#lightboxContent";
}
?>
<div class="modal fade" id="addLightboxModal" tabindex="-1" aria-labelledby="addLightboxModalLabel" aria-hidden="true">
  <div class="modal-dialog">
	<div class="modal-content text-start">
	  <div class="modal-header">
		<h1 class="modal-title fs-3" id="addLightboxModalLabel"><?= _t('New %1', $lightbox_displayname_singular); ?></h1>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= _t('Close'); ?>"></button>
	  </div>
	  <div class="modal-body">
		<label for="lightboxName" class="col-form-label"><?= _t('Name'); ?>:</label>
		<?= caHTMLTextInput('name', ['value' => $preserve ? $mv['name'] ?? null : null, 'class' => 'form-control lightboxAddFormControl', 'id' => 'lightboxName'], ['width' => '100%']); ?>
<?php
		# --- when used on detail page include the row_id and table
		if($id){
			print caHTMLHiddenInput('row_id', ['value' => $preserve ? $mv['row_id'] ?? null : $id, 'class' => 'lightboxAddFormControl', 'id' => 'rowId']);
			print caHTMLHiddenInput('table', ['value' => $preserve ? $mv['table'] ?? null : $table, 'class' => 'lightboxAddFormControl', 'id' => 'table']);
			print caHTMLHiddenInput('ltype', ['value' => caGetLightboxTypeForTable($this->getVar('detailConfig')['table'], ['restrictToTypes' => $this->getVar('detailConfig')['restrictToTypes'] ?? null]), 'class' => 'lightboxAddFormControl', 'id' => 'ltype']);
		} else {
?>
			<label for="lightboxType" class="col-form-label"><?= _t('Type'); ?>:</label>
			<?= caLightboxTypeListAsHTML(['class' => 'form-control lightboxAddFormControl', 'id' => 'lightboxType']); ?>
<?php
		}
?>
	 </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-primary" data-bs-dismiss="modal" 
			hx-post="<?= caNavUrl($this->request, '', 'Lightbox', 'Add'); ?>" 
			hx-include=".lightboxAddFormControl"
			hx-target="<?= $target; ?>"
			hx-swap="outerHTML"
		><?= _t('Save'); ?></button>
		<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= _t('Close'); ?></button>
	  </div>
	</div>
  </div>
</div>
