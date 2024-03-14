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
$lightboxDisplayName = caGetLightboxDisplayName();
$lightbox_sectionHeading = ucFirst($lightboxDisplayName["section_heading"]);

# Collect the user links
$user_links = "";
if($this->request->isLoggedIn()){
	$user_links .= '<div class="fw-medium text-uppercase pb-2"><i class="bi bi-person-circle" aria-label="'._t('User Options').'"></i> '.trim($this->request->user->get("fname")." ".$this->request->user->get("lname")).'</div>';
	if(caDisplayLightbox($this->request)){
		$user_links .= "<div>".caNavLink($this->request, $lightbox_sectionHeading, 'dropdown-item', '', 'Lightbox', 'Index', array())."</div>";
	}
	$user_links .= "<div>".caNavLink($this->request, _t('User Profile'), 'dropdown-item', '', 'LoginReg', 'profileForm', array())."</div>";
	
	$user_links .= "<div>".caNavLink($this->request, _t('Logout'), 'dropdown-item', '', 'LoginReg', 'Logout', array())."</div>";
} else {	
	if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) || $this->request->config->get('pawtucket_requires_login')) { $user_links = "<div class='fw-medium text-uppercase pb-2'>".caNavlink($this->request, _t('Login'), "text-light text-decoration-none", "", "LoginReg", "LoginForm")."</div>"; }
}

?>
	</main>
<?php
	if(strToLower($this->request->getController()) != "front"){
		print "</div> <!-- end container -->";
	}
?>
		<footer id="footer" class="p-5 text-center mt-auto bg-dark text-bg-dark">
			<div class="container-xl pt-4 pb-4">
				<div class="row">
					<div class="col-sm-12 col-md-6 text-md-start">
						<a href="www.brooklynnavyyard.org" target="_blank"><?= caGetThemeGraphic($this->request, 'BNY-logo-White.png', array("alt" => "Brooklyn Navy Yard Logo")); ?></a>
						<div class="pt-5"><a href="www.brooklynnavyyard.org" target="_blank" class="text-light text-decoration-none">brooklynnavyyard.org <i class="bi bi-box-arrow-up-right"></i></a></div>
					</div>
<?php
					if($user_links){
						print "<div class='col-sm-12 col-md-2 text-start'>".$user_links."</div>";
					}
?>
					<div class="col-sm-12 col-md-2 text-md-start">
						<div class="fw-medium text-uppercase pb-2"><?php print caNavlink($this->request, _t('Contact'), "text-light text-decoration-none", "", "Contact", "form"); ?></div>
						<div class="fs-6">
							Building 77
							<br/>141 Flushing Avenue, Suite 801
							<br/>Brooklyn, NY 11205
							<br><br><a href="mailto:info@bnydc.org" class="text-secondary">info@bnydc.org</a><br>
							718-907-5900 (phone)<br>
							718-643-9296 (fax)</p>
						</div>
					</div>
					<div class="col-sm-12 col-md-2 text-start">
						<div class="fw-medium text-uppercase pb-2">Connect</div>
						<div class="fs-6"><a href="https://www.instagram.com/bklynnavyyard/" target="_blank" aria-label="Visit us on Instagram" class="text-light text-decoration-none"><i class="bi bi-instagram text-secondary fs-5 me-1 align-middle"></i> <span class="align-middle">@bklynnavyyard</span></a></div>
						<div class="fs-6"><a href="https://twitter.com/bklynnavyyard" target="_blank" aria-label="Visit us on Twitter" class="text-light text-decoration-none"><i class="bi bi-twitter text-secondary fs-5 me-1 align-middle"></i> <span class="align-middle">@bklynnavyyard</span></a></div>
						<div class="fs-6"><a href="https://www.facebook.com/brooklynnavyyard/" target="_blank" aria-label="Visit us on Facebook" class="text-light text-decoration-none"><i class="bi bi-facebook text-secondary fs-5 me-1 align-middle"></i> <span class="align-middle">/brooklynnavyyard</span></a></div>
						<div class="fs-6"><a href="https://www.linkedin.com/company/brooklyn-navy-yard-development-corporation" target="_blank" aria-label="Visit us on LinkedIn" class="text-light text-decoration-none"><i class="bi bi-linkedin text-secondary fs-5 me-1 align-middle"></i> <span class="align-middle">Brooklyn Navy Yard</span></a></div>
						
					</div>
					
				</div>
			</div>
		</footer><!-- end footer -->
		
		<script>
			window.initApp();
		</script>
	</body>
</html>
