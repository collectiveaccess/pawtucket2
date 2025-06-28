<?php
/* ----------------------------------------------------------------------
 * views/Cookies/banner_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2020-2025 Whirl-i-Gig
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
if(CookieOptionsManager::showBanner()) {
	$config = caGetCookiesConfig();
	$text = $this->getVar($config->get("cookiesBannerGlobalValue")) ?? $config->get("cookiesBannerText");
?>
	<div id="cookieNotice" role="dialog" aria-labelledby="Cookie Window" class="fixed-bottom w-100 bg-white p-4 shadow">
		<div class="row justify-content-center">
			<div class="col-sm-12 col-md-12 col-lg-9 col-xl-6">
				<div class="fw-bold fs-4">
					<?= _t('This website uses cookies'); ?>
				</div>
				<div>
					<?= $text; ?>
				</div>
				<div class="text-center p-2">
					<?php print caNavLink($this->request, _t("Manage"), "btn", "", "Cookies", "manage").caNavLink($this->request, _t("Accept"), "btn btn-success", "", "Cookies", "manage", ['accept' => 1]); ?>
				</div>
			</div>
		</div>
	</div>
<?php
}
?>