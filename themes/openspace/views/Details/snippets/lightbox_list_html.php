<?php
/*
*	this view is re-rendered when a new lightbox is added so the list is updated
*/
if(!(caDisplayLightbox($this->request))) { return ''; }
$in_lightboxes = $this->getVar("in_lightboxes");
$errors = $this->getVar("errors");
$success = $this->getVar("success");

$lightbox_conf = caGetLightboxConfig();
$lightbox_displayname_singular = $lightbox_conf->get('lightbox_displayname_singular');
$lightbox_displayname_plural = $lightbox_conf->get('lightbox_displayname_plural');
$lightbox_icon = $lightbox_conf->get('lightbox_icon');
$not_in_lightbox_template = $lightbox_conf->get('not_in_lightbox_template');
$in_lightbox_template = $lightbox_conf->get('in_lightbox_template');

$t_item = $this->getVar("item");
$id = $t_item->getPrimaryKey();
?>
<span id="lightboxList">
	<div class="btn-group" role="group" aria-label="<?=_t("Lightbox Controls"); ?>">
		<div class="dropdown">
		  <button type="button" class="btn btn-sm btn-white ps-3 pe-0 fw-medium text-capitalize" id="lightboxList" data-bs-toggle="dropdown" aria-expanded="false"><?= $lightbox_icon." ".$lightbox_displayname_plural; ?></button>
		  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
<?php
	$lightboxes = $this->getVar('lightboxes');
	if($lightboxes) {
		$lightboxes->seek(0);
		while($lightboxes->nextHit()) {
			$set_id = $lightboxes->getPrimaryKey();
			$label = $lightboxes->get('ca_sets.preferred_labels.name');
?>
				<li id="lightbox_<?= $set_id; ?>">
					<div class="dropdown-item">
						<a href="#" class="me-2" id="lightbox_link_<?= $set_id; ?>" hx-post="<?= caNavUrl($this->request, '', 'Lightbox', 'LightboxMembership', ['id' => $id, 'set_id' => $set_id]); ?>" hx-trigger="click consume" hx-target="#lightbox_link_<?= $set_id; ?>" hx-swap="innerHTML" title="<?= $lightboxes->getWithTemplate(isset($in_lightboxes[$set_id]) ? _t("Remove") : _t("Add")); ?>" aria-label="<?= $lightboxes->getWithTemplate(isset($in_lightboxes[$set_id]) ? _t("Remove") : _t("Add")); ?>"><?= $lightboxes->getWithTemplate(isset($in_lightboxes[$set_id]) ? $in_lightbox_template : $not_in_lightbox_template); ?></a>
						<?= caNavLink($this->request, $label, '', '', 'Lightbox', "Detail/{$set_id}", [], ["title" => _t("View %1 %2", $lightbox_displayname_singular, $label), "aria-label" => _t("View %1 %2", $lightbox_displayname_singular, $label)]); ?>
					</div>
				</li>		
<?php
		}
	}
				# --- always include a link to make a new lightbox
?>
				<li><hr class="dropdown-divider"></li>
				<li class="dropdown-item">
					<button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#addLightboxModal"><i class='bi bi-plus-circle me-2'></i> <?= _t("New %1", $lightbox_displayname_singular); ?></button>
				</li>		
			</ul>
		</div>
	</div>
	<!-- Add lightbox modal -->
<?php
	$this->setVar("target", "#lightboxList");
	print $this->render("Lightbox/add_lightbox_form_html.php");
?>
	<!-- Errors adding lightbox? -->
<?php 
	if(is_array($errors) && sizeof($errors)){
?>
		<div id="errors" class="text-center alert alert-warning alert-dismissible fade show" role="alert">
			<ul class="list-unstyled"><?= join("\n", array_map(function($v) { return "<li>{$v}</li>\n"; }, $errors)); ?></ul>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
<?php
	}
	if($success){
?>
		<div id="success" class="text-center alert alert-success alert-dismissible fade show" role="alert">
			<div><?= $success; ?></div>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
<?php
	
	}
?>

</span>