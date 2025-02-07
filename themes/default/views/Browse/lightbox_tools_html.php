<?php
/*
*	this view is re-rendered when a new lightbox is added so the list is updated
*	however the select/deselect and hidden form elements are only rendered on initial page load
*/
$ajax = (bool)$this->request->isAjax();
$errors = $this->getVar("errors");
$success = $this->getVar("success");
$table = $this->getVar("table");

$lightbox_conf = caGetLightboxConfig();
$lightbox_displayname_singular = $lightbox_conf->get('lightbox_displayname_singular');
$lightbox_displayname_plural = $lightbox_conf->get('lightbox_displayname_plural');
$lightbox_icon = $lightbox_conf->get('lightbox_icon');

?>
<span id="lightboxList">
	<!-- Add lightbox modal -->
<?php
	$this->setVar("target", "#lightboxList");
	print $this->render("Lightbox/add_lightbox_form_html.php");
?>
	<!-- Errors adding lightbox? -->
<?php 
	if(is_array($errors) && sizeof($errors)){
?>
		<div id="errors" class="text-center alert alert-warning alert-dismissible fade show position-absolute w-75 start-50 translate-middle" style="z-index:1000;" role="alert">
			<ul class="list-unstyled"><?= join("\n", array_map(function($v) { return "<li>{$v}</li>\n"; }, $errors)); ?></ul>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
<?php
	}
	if($success){
?>
		<div id="success" class="text-center alert alert-success alert-dismissible fade show position-absolute w-75 start-50 translate-middle" style="z-index:1000;" role="alert">
			<div><?= $success; ?></div>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
<?php
	
	}
	$lightboxes = caGetLightboxesForUser($this->request->getUserID(), null, ['tables' => [$table]]);
?>
	<li class="list-group-item border-0 px-0 pt-0 me-2<?= ($ajax) ? "" : " d-none"; ?>" id="lightboxDropdown">
		<div class="dropdown inline w-auto">
			<button class="btn btn-light btn-sm dropdown-toggle small" type="button" data-bs-toggle="dropdown" aria-expanded="false"><?= _t("Add to %1", $lightbox_displayname_singular); ?></button>
			<ul class="dropdown-menu" role='menu'>
<?php
				if(($lightboxes && ($lightboxes->numHits() > 0))){
					while($lightboxes->nextHit()){
						$set_id = $lightboxes->get("ca_sets.set_id");
						print "<li class='dropdown-item' role='menuitem'><button class='btn btn-link p-0'  id='lightbox_link_".$set_id."' hx-include='.selectedItemInputs' hx-post='".caNavUrl($this->request, '', 'Lightbox', 'addItemsToSet', ['set_id' => $set_id])."' hx-trigger='click' hx-target='#lightboxList' hx-swap='outerHTML'>".$lightboxes->get("ca_sets.preferred_labels")."</button></li>";
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
	</li>
					
</span>