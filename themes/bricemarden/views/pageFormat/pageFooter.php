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
	#$user_links .= "<li class='nav-item dropdown'><a class='nav-link".(($this->request->getController() == 'LoginReg') ? ' active' : '')."' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'><i class='bi bi-person-circle' aria-label='"._t('User Options')."'></i></a>
	#					<ul class='dropdown-menu'>";
	
	#$user_links .= '<li><div class="dropdown-header fw-medium">'.trim($this->request->user->get("fname")." ".$this->request->user->get("lname")).'<br>'.$this->request->user->get("email").'</div></li>';
	#$user_links .= "<li><hr class='dropdown-divider'></li>";
	#if(caDisplayLightbox($this->request)){
	#	$user_links .= "<li>".caNavLink($this->request, $lightbox_sectionHeading, 'dropdown-item', '', 'Lightbox', 'Index', array())."</li>";
	#}
	#$user_links .= "<li>".caNavLink($this->request, _t('User Profile'), 'dropdown-item', '', 'LoginReg', 'profileForm', array())."</li>";
	
	#if ($this->request->config->get('use_submission_interface')) {
	#	$user_links .= "<li>".caNavLink($this->request, _t('Submit content'), 'dropdown-item', '', 'Contribute', 'List', array())."</li>";
	#}
	$user_links .= "<li class='list-inline-item'>".caNavLink($this->request, _t('Logout'), '', '', 'LoginReg', 'Logout', array())."</li>";
	#$user_links .= "</ul></li>";
} else {	
	if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) || $this->request->config->get('pawtucket_requires_login')) { $user_links = "<li class='list-inline-item'>".caNavlink($this->request, _t('Login'), "", "", "LoginReg", "LoginForm", "")."</li>"; }
}
		if(in_array(strToLower($this->request->getController()), array("about", "references"))){
?>
				</div>
			</div>
<?php
		}
?>

		</main>
	</div> <!-- end container -->
		<footer id="footer" class="pt-5 pb-3 text-start mt-auto">
			<div class="container-fluid">
				<div class="row">
					<div class="col-12 text-end">
						<ul class="list-inline">
							<li class="list-inline-item">&copy; <?= date('Y'); ?></li>
<?php
					if($user_links){
						print $user_links;
					}
?>

							<?= ((CookieOptionsManager::cookieManagerEnabled()) ? '<li class="list-inline-item">'.caNavLink($this->request, _t("Manage Cookies"), "text-bg-dark small", "", "Cookies", "manage")."</li>" : ""); ?>
						</ul>
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
