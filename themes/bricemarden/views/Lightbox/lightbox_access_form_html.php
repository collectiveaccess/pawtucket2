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

$add_user_url = caNavUrl($this->request, '*', '*', 'AddUserShare', ['id' => $set_id]);
$add_anonymous_url = caNavUrl($this->request, '*', '*', 'AddAnonymousAccess', ['id' => $set_id]);

$lightbox_conf = $this->getVar('lightbox_config');
$lightbox_options = $lightbox_conf->get('lightbox_options');
$downloads = $lightbox_options['ca_objects']['downloads'] ?? null;		// download types
?>
<script>
	if(!pawtucketUIApps) { pawtucketUIApps = {}; }
	pawtucketUIApps['autocomplete'] = <?= json_encode([
		[
			'id' => 'userName',
			'idtarget' => 'userId',
			'placeholder' => _t('User name or email'),
			'url' => caNavUrl($this->request, '*', '*', 'LookupUserForShare')
		]
	]); ?>;
</script>
<div class="modal fade" id="lightboxAccessModal" tabindex="-1" aria-labelledby="lightboxAccessModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<h1 class="modal-title fs-3" id="lightboxAccessModalLabel"><?= _t('Sharing'); ?></h1>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= _t('Close'); ?>"></button>
	  </div>
	  <div class="modal-body">
		<!-- Nav tabs -->
		<ul class="nav nav-tabs mb-3" id="lightboxAccessTabs" role="tablist">
			<li class="nav-item" role="presentation">
			<button class="nav-link active" id="anonymous-tab" data-bs-toggle="tab" data-bs-target="#anonymousAccess" type="button" role="tab" aria-controls="anonymousAccess" aria-selected="true">
				<?= _t('Anonymous Access'); ?>
			</button>
			</li>
			<li class="nav-item" role="presentation">
			<button class="nav-link" id="user-tab" data-bs-toggle="tab" data-bs-target="#userAccess" type="button" role="tab" aria-controls="userAccess" aria-selected="false">
				<?= _t('User Access'); ?>
			</button>
			</li>
		</ul>

		<!-- Tab panes -->
		<div class="tab-content" id="lightboxAccessTabContent">
			<!-- Anonymous Access Tab -->
			<div class="tab-pane fade show active" id="anonymousAccess" role="tabpanel" aria-labelledby="anonymous-tab">

			<form id="accessForm">
				<div class="row">
					<!-- Name Field -->
					<div class="col-md-6">
						<div class="mb-3">
							<label for="urlName" class="form-label z-3">
								<?= _t('Sharing Name'); ?>
							</label>
							<input name="urlName" type="text" class="form-control" id="urlName" placeholder="Enter a name for the URL">
							<div id="urlNameHelp" class="form-text">
								<?= _t('Enter a descriptive name for the URL. This name will be used when tracking use of the URL.'); ?>
							</div>
						</div>
					</div>

					<!-- Date Picker Field -->
					<div class="col-md-6">
						<div class="mb-3">
							<label for="expirationDate" class="form-label z-3">
								<?= _t('Date Available'); ?> (<?= _t('Optional'); ?>)
							</label>
							<input name="expirationDate" type="text" class="form-control" id="expirationDate">
							<div id="expirationDateHelp" class="form-text">
								<?= _t('Choose an optional date range for the availability of the URL.'); ?>
							</div>
						</div>
					</div>
				</div>

				<div class="mb-3">
					<label class="form-label"><?= _t('Download Options'); ?></label>
					<div class="form-check">
						<?php foreach ($downloads as $key => $option): ?>
							<input type="checkbox" class="form-check-input" id="download_<?= $key; ?>" name="downloads[]" value="<?= $key; ?>">
							<label class="form-check-label" for="download_<?= $key; ?>"><?= $option['label']; ?></label><br>
						<?php endforeach; ?>
					</div>
					<div id="downloadsHelp" class="form-text">
						<?= _t('Select which file versions will be available for download through the shared link.'); ?>
					</div>
				</div>

				<!-- Add URL -->
				<button type="button" class="btn btn-primary" id="addUrl"
					hx-post="<?= $add_anonymous_url; ?>" 
					hx-target="#sharedUrls" 
					hx-swap="outerHTML"
					hx-include="#accessForm"
				>
					<?= _t('Add '); ?><i class="bi bi-plus-lg"></i>
				</button>
			</form>

			<!-- Shared URLs List -->
			<h5 class="mt-4"><?= _t('Share Links'); ?></h5>
			<div class="form-text mb-2">
				<?= _t('Anyone with a link can view the contents of the lightbox.'); ?>
			</div>
			<?= $this->render('Lightbox/anonymous_access_list_html.php'); ?>
		</div>

	    <!-- User Access Tab -->
		<div class="tab-pane fade" id="userAccess" role="tabpanel" aria-labelledby="user-tab">
			<form id="userAccessForm">
				<div class="row">
					<!-- Name Field -->
					<div class="col-md-6">
						<div class="mb-3">
							<label for="userName" class="form-label z-3">
								<?= _t('User Name'); ?>
							</label>
							<input name="userName" type="text" class="form-control" id="userName">
							<input name="user_id" type="hidden" class="form-control" id="userId">
							<div id="userNameHelp" class="form-text">
								<?= _t('Enter the name or email address of the person you would like to share this lightbox with.'); ?>
							</div>
						</div>
					</div>

					<!-- Date Picker Field -->
					<div class="col-md-6">
						<div class="mb-3">
							<label for="expirationDate" class="form-label z-3">
								<?= _t('Date Available'); ?> (<?= _t('Optional'); ?>)
							</label>
							<input name="expirationDate" type="text" class="form-control" id="expirationDate">
							<div id="expirationDateHelp" class="form-text">
								<?= _t('Choose an optional date range for the availability of the users access of this lightbox.'); ?>
							</div>
						</div>
					</div>
				</div>

				<div class="mb-3">
					<label class="form-label"><?= _t('Download Options'); ?></label>
					<div class="form-check">
						<?php foreach ($downloads as $key => $option): ?>
							<input type="checkbox" class="form-check-input" id="download_<?= $key; ?>" name="downloads[]" value="<?= $key; ?>">
							<label class="form-check-label" for="download_<?= $key; ?>"><?= $option['label']; ?></label><br>
						<?php endforeach; ?>
					</div>
					<div id="downloadsHelp" class="form-text">
						<?= _t('Select which file versions will be available for download by the user.'); ?>
					</div>
				</div>

				<!-- TODO: Change this to adding a user -->

				<!-- Add user --> 
				<button type="button" class="btn btn-primary" id="addUser"
					hx-post="<?= $add_user_url; ?>" 
					hx-target="#userShares" 
					hx-swap="outerHTML"
					hx-include="#userAccessForm"
				>
					<?= _t('Add '); ?><i class="bi bi-plus-lg"></i>
				</button>
			</form>

			<!-- Shared URLs List -->
			<h5 class="mt-4"><?= _t('Shared Users'); ?></h5>
			<div class="form-text mb-2">
				<?= _t('Users who have access view the contents of the lightbox.'); ?>
			</div>
			<?= $this->render('Lightbox/user_access_list_html.php'); ?>
		</div>
	</div>
	  </div>

	  <div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= _t('Close'); ?></button>
	  </div>
	</div>
  </div>
</div>

<script>
document.body.addEventListener("click", (event) => {
    const button = event.target.closest(".copyButton"); // Check if a copy button was clicked
    if (!button) return;
    let url = button.closest("td")?.querySelector("a")?.href;
    if (url) {
        navigator.clipboard.writeText(url).then(() => {
            button.innerHTML = '<i class="bi bi-clipboard-check"></i>';
            setTimeout(() => button.innerHTML = '<i class="bi bi-clipboard"></i>', 1000);
        })
    }
});
</script>