<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Lightbox/lightbox_access_form_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2025 Whirl-i-Gig
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
		<h1 class="modal-title fs-3" id="lightboxAccessModalLabel"><?= _t('Sharing'); ?></h1>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= _t('Close'); ?>"></button>
	  </div>
	  <div class="modal-body">

		<form id="accessForm">
			<!-- Name the URL -->
			<div class="mb-3">
				<label for="urlName" class="form-label z-3">
					<?= _t('Sharing Name'); ?>
				</label>
				<input name="urlName" type="text" class="form-control" id="urlName" placeholder="Enter a name for the URL">
				<div id="urlNameHelp" class="form-text">
					<?= _t('Enter a descriptive name for the URL. This name will be used when tracking use of the URL.'); ?>
				</div>
			</div>

			<!-- Date Picker -->
			<div class="mb-3">
				<label for="c" class="form-label z-3">
					<?= _t('Date Available'); ?> (<?= _t('Optional'); ?>)
				</label>
				<input name="expirationDate" type="text" class="form-control" id="expirationDate">
				<div id="expirationDateHelp" class="form-text">
					<?= _t('Choose an optional date range for the availability of URL.'); ?>
				</div>
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
		<h5 class="mt-4"><?= _t('Share Links'); ?></h5>
		<div class="form-text mb-2">
			<?= _t('Anyone with a link can view the contents of the lightbox.'); ?>
		</div>
		<?= $this->render('Lightbox/anonymous_access_list_html.php'); ?>

	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= _t('Close'); ?></button>
	  </div>
	</div>
  </div>
</div>

<script>
document.body.addEventListener("htmx:afterSwap", () => {
    document.querySelectorAll(".copyButton").forEach(button => {
        button.onclick = () => {
            let url = button.closest("td").querySelector("a")?.href;
            if (url) {
                navigator.clipboard.writeText(url).then(() => {
                    button.innerHTML = '<i class="bi bi-clipboard-check"></i>';
                    setTimeout(() => button.innerHTML = '<i class="bi bi-clipboard"></i>', 2000);
                });
            }
        };
    });
});
</script>