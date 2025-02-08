<?php
$lightbox_displayname_singular 		= $this->getVar("lightbox_displayname_singular");
$lightbox_displayname_plural 		= $this->getVar("lightbox_displayname_plural");
$t_set = $this->getVar('t_set');
$set_id = $t_set->getPrimaryKey();
$addUrl = caNavUrl($this->request, '*', '*', 'AddAnonymousAccess', ['id' => $set_id]);
?>
<div class="modal fade" id="lightboxAccessModal" tabindex="-1" aria-labelledby="lightboxAccessModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<h1 class="modal-title fs-3" id="lightboxAccessModalLabel"><?= _t('Share'); ?></h1>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= _t('Close'); ?>"></button>
	  </div>
	  <div class="modal-body">

		<form id="accessForm">
			<!-- Name the URL -->
			<div class="mb-3">
				<label for="urlName" class="form-label"><?= _t('Name'); ?></label>
				<input name="urlName" type="text" class="form-control" id="urlName" placeholder="Enter a name for the URL">
			</div>

			<!-- Date Picker -->
			<div class="mb-3">
				<label for="expirationDate" class="form-label"><?= _t('Expiration Date'); ?> (<?= _t('Optional'); ?>)</label>
				<input name="expirationDate" type="text" class="form-control" id="expirationDate">
			</div>

			<!-- Add URL -->
			<button type="button" class="btn btn-primary" id="addUrl"
				hx-post="<?= $addUrl; ?>" 
				hx-target="#sharedUrls" 
				hx-swap="outerHTML"
				hx-include="#urlName, #expirationDate"
			>
				<?= _t('Add'); ?>
			</button>
        </form>

        <!-- Shared URLs List -->
        <h5 class="mt-4"><?= _t('Shared Links'); ?></h5>
		<?= $this->render('Lightbox/anonymous_access_list_html.php'); ?>

	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= _t('Close'); ?></button>
	  </div>
	</div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".copyButton").forEach(button => {
        button.addEventListener("click", function () {
            const url = this.previousElementSibling.href; // Get URL from the <a> tag
            navigator.clipboard.writeText(url).catch(err => console.error("Copy failed:", err));
        });
    });
});

</script>