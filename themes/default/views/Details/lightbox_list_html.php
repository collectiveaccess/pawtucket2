<?php
if(!($lightboxes = $this->getVar('lightboxes'))) { return ''; }
$lightboxes->seek(0);
$in_lightboxes = $this->getVar('inLightboxes');

$t_item = $this->getVar("item");
$id = $t_item->getPrimaryKey();

$not_in_lightbox_template = $this->getVar('lighboxListNotInLightboxTemplate');
$in_lightbox_template = $this->getVar('lighboxListInLightboxTemplate');
if($lightboxes) {
?>
	<div class="dropdown">
	  <button type="button" class="btn btn-sm btn-white ps-3 pe-0 fw-medium"  id="lightboxList" data-bs-toggle="dropdown" aria-expanded="false">
		<?= _t('Lightboxes'); ?>
	  </button>
	  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
<?php
	while($lightboxes->nextHit()) {
		$set_id = $lightboxes->getPrimaryKey();
?>
			<li id="lightbox_<?= $set_id; ?>" hx-post="<?= caNavUrl($this->request, '*', '*', 'LightboxMembership', ['id' => $id, 'set_id' => $set_id]); ?>" hx-trigger="click" hx-target="#lightbox_link_<?= $set_id; ?>" hx-swap="innerHTML">
				<div class="dropdown-item"><a href="#" id="lightbox_link_<?= $set_id; ?>"><?= $lightboxes->getWithTemplate(isset($in_lightboxes[$set_id]) ? $in_lightbox_template : $not_in_lightbox_template); ?></a>
				<?= caNavLink($this->request, '<i class="bi bi-folder-symlink"></i>', 'float-end', '', 'Lightbox', "Detail/{$set_id}"); ?></div>
			</li>		
<?php
		}
?>
	  </ul>
	</div>
<?php
}
