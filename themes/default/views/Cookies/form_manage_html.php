<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Cookies/form_manage_html.php
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
 
$cookies_by_category = $this->getVar('cookiesByCategory');
$config = $this->getVar('config');
$intro = "";
if(!($config->get("cookiesIntroGlobalValue") && $intro = $this->getVar($config->get("cookiesIntroGlobalValue")))){
	$intro = $config->get("cookiesFormIntro");
}
?>

        <h1><?= _t("Manage Cookies"); ?></h1>
        <div class="mb-4 mt-3 fs-4"><?php print $intro; ?></div>
        <form id="CookieForm" action="<?= caNavUrl($this->request, '*', '*', 'save'); ?>" class="needs-validation" novalidate method="POST">
<?php
    foreach ($cookies_by_category as $category_code => $category_info) {
?>
		<div class="bg-light p-4 mb-4">
			<div class="row">
                <div class="col-sm-12 col-md-8">
                    <div class="fw-bold fs-4"><?= caGetOption('title', $category_info, '???'); ?></div>
						<button class="btn btn-white btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#cookieDesc<?= $category_code; ?>" aria-expanded="false" aria-controls="#cookieDesc<?= $category_code; ?>"><?= caGetOption('cookieCount', $category_info, ''); ?> <i class="bi bi-arrow-right-circle-fill" aria-hidden="true"></i></button>
						<div id="cookieDesc<?= $category_code; ?>" class="collapse p-3 pb-0 bg-white mt-3">
							<div class="row fw-bold">
								<div class="col-3">
									Name
								</div>
								<div class="col-9">
									Description
								</div>
							</div>
<?php
				foreach ($category_info['cookies'] as $cookie_code => $cookie_info) {
?>
							<div class="row pb-3">
								<div class="col-3">
									<?= caGetOption('name', $cookie_info, '???'); ?>
								</div>
								<div class="col-9">
									<?= caGetOption('description', $cookie_info, '???'); ?>
								</div>
							</div>
<?php
				}
?>
						</div>
						<div class="pt-3"><?= caGetOption('description', $category_info, ''); ?></div>
					</div>
                <div class="col-sm-12 col-md-4 text-center pt-3 pt-md-0">
<?php
        if (!caGetOption('required', $category_info, false)) {
            $allow = (bool)CookieOptionsManager::allow($category_code);
?>
					<div class="btn-group rounded" role="group" aria-label="Toggle">
						<button type="button" class="btn <?= $allow ? ' btn-success' : ' btn-light bg-white'; ?>" data-value="1" data-code="<?= $category_code; ?>">
							<?= _t('ON'); ?>
						</button>
						<input type="hidden" name="<?= "cookie_options_{$category_code}"; ?>" id="<?= "cookie_options_{$category_code}"; ?>" value="<?= $allow ? 1 : 0; ?>" />
						<button type="button" class="btn <?= !$allow ? ' btn-success' : ' btn-light bg-white'; ?>" data-value="0" data-code="<?= $category_code; ?>">
							<?= _t('OFF'); ?>
						</button>
					</div>

<?php
        }
?>
                </div>
            </div>
        
		</div>
<?php
    }
?>
            <div class="text-center mb-4">
                <button type="submit" class="btn btn-light text-capitalize">
                    <?= _t('Update'); ?>
                </button>
                <button class="ms-2 btn btn-success" name="accept_all" value="1">
                    <?= _t('Accept All'); ?>
                </button>
            </div>
        </form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleButtons = document.querySelectorAll('.btn-group button');

        toggleButtons.forEach((button) => {
            button.addEventListener('click', function (event) {
                event.preventDefault(); // Prevent the form from submitting

                const parentGroup = button.closest('.btn-group');
                const code = button.dataset.code;
                const value = button.dataset.value;

                parentGroup.querySelectorAll('.btn').forEach((btn) => {
                    btn.classList.remove('btn-success', 'btn-light', 'active', 'bg-white'); // Remove all related classes
                    btn.classList.add('btn-light', 'bg-white'); // Set inactive state
                });

                // Set the clicked button as active
                button.classList.remove('btn-light', 'bg-white'); // Remove inactive state
                button.classList.add('btn-success', 'active'); // Set active state

                // Update the hidden input value
                const hiddenInput = document.querySelector(`#cookie_options_${code}`);
                if (hiddenInput) {
                    hiddenInput.value = value;
                }
            });
        });
    });

</script>
