<?php
$preserve							= $this->getVar('preserveModalValues');
$mv									= $this->getVar('modalValues');

$lightbox_conf 						= caGetLightboxConfig();
$lightbox_displayname_singular 		= $lightbox_conf->get('lightbox_displayname_singular');
$lightbox_displayname_plural 		= $lightbox_conf->get('lightbox_displayname_plural');

# When used on detail pages need row id and table to add record to new lightbox
$id = $table = null;
if($t_item = $this->getVar("item")){
	$id = $t_item->getPrimaryKey();
	$table = $t_item->tableName();
}
$target 							= $this->getVar('target') ?: "#lightboxContent";

$allowed_content 					= $this->getVar('lightbox_allowed_content');
?>
<div class="modal fade" id="addLightboxModal" tabindex="-1" aria-labelledby="addLightboxModalLabel" aria-hidden="true">
  <div class="modal-dialog">
	<div class="modal-content text-start">
	  <div class="modal-header">
<?php
			$content_select = null;
			if(sizeof($allowed_content ?? []) > 1) {
				$opts = [];
				foreach($allowed_content as $t => $ti) {
					$opts[$ti['content_name_plural']] = $t;
				}
				$content_select = caHTMLSelect('table', $opts, ['class' => 'lightboxAddFormControl']);
			}
?>
		<h1 class="modal-title fs-3" id="addLightboxModalLabel">
			<?= is_null($content_select) ? _t('New %1', $lightbox_displayname_singular) : _t('New %1 for %2', $lightbox_displayname_singular, $content_select); ?>
		</h1>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= _t('Close'); ?>"></button>
	  </div>
	  <div class="modal-body">
		<label for="lightboxName" class="col-form-label"><?= _t('Name'); ?>:</label>
		<?= caHTMLTextInput('name', ['value' => $preserve ? $mv['name'] ?? null : null, 'class' => 'form-control lightboxAddFormControl', 'id' => 'lightboxName'], ['width' => '100%']); ?>
<?php
		# --- when used on detail page include the row_id and table
		if($id){
			print caHTMLHiddenInput('row_id', ['value' => $preserve ? $mv['row_id'] ?? null : $id, 'class' => 'lightboxAddFormControl', 'id' => 'rowId']);
		}
		if(sizeof($allowed_content ?? []) <= 1) {
			print caHTMLHiddenInput('table', ['value' => end(array_keys($allowed_content)), 'class' => 'lightboxAddFormControl', 'id' => 'table']);
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
