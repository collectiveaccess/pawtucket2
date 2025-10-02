<?php
/* ----------------------------------------------------------------------
 * views/pageFormat/pageFooter.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2015-2024 Whirl-i-Gig
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
?>
	</main>
<?php
	if(strToLower($this->request->getController()) != "front"){
		print "</div> <!-- end container -->";
	}
?>
		<footer id="footer" class="py-4 mb-1 px-3 mt-auto border-black border-top border-1">
			<div class="container-fluid pb-3">
				<div class="row">
					<div class="col">
						<ul class="ps-1 list-inline pt-3 fw-medium">
							<?= ((CookieOptionsManager::cookieManagerEnabled()) ? '<li class="list-inline-item">'.caNavLink($this->request, _t("Manage Cookies"), "text-bg-dark small", "", "Cookies", "manage")."</li>" : ""); ?>
							<li class="list-inline-item"><a href="https://911memorial.org/financial-legal-information">Financial &amp; Legal Information</a></li>
							<li class="list-inline-item"><a href="https://911memorial.org/terms-useprivacy-policy">Terms of Use/Privacy Policy</a></li>
							<li class="list-inline-item"><a href="https://911memorial.org/accessibility-details">Accessibility Details</a></li>
						</ul>
						<div class="ps-1 mt-4 fs-6">
							&copy; <?= date('Y'); ?> National September 11 Memorial & Museum 9/11 MEMORIAL is a registered trademark of the National September 11 Memorial & Museum
						</div>
					</div>
				</div>
			</div>
		</footer><!-- end footer -->
		
		<?= $this->render("Cookies/banner_html.php"); ?>
		
		<script>
			window.initApp();
		</script>
	</body>
</html>
