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

		<footer id="footer" class="p-2 text-center mt-auto bg-secondary text-bg-light">
			<div class="container-xl">
				<H1 class="pt-3 pb-1 display-4">&copy; Metabolic Studio</H1>
				<div class="pt-0 pb-3">
					1745 N. SPRING STREET UNIT 4 LOS ANGELES, CA 90012
				</div>
				<ul class="list-inline pt-2">
  					<li class="list-inline-item fs-2 me-5"><a href="https://www.facebook.com/metabolicstudio" target="_blank" rel="noopener" aria-label="Facebook Link"><i class="bi bi-facebook"></i></a></li>
					<li class="list-inline-item fs-2 me-5"><a href="https://www.instagram.com/metabolicstudio/" target="_blank" rel="noopener" aria-label="Instagram Link"><i class="bi bi-instagram"></i></a></li>
					<li class="list-inline-item fs-2"><a href="https://twitter.com/metabolic1745" target="_blank" rel="noopener" aria-label="Twitter Link"><i class="bi bi-twitter-x"></i></a></li>
				</ul>
				<ul class="list-inline pt-2 fw-medium">
					<li class="list-inline-item">
						<?= caNavlink($this->request, _t('About The Studio'), "nav-link text-uppercase".((strToLower($this->request->getController()) == "about") ? " active" : ""), "", "About", "", "", ((strToLower($this->request->getController()) == "about") ? array("aria-current" => "page") : null)); ?>
					</li>
					<li class="list-inline-item"><a href="mailto:info@metabolicstudio.org" class="nav-link text-uppercase">Contact</a></li>
					<li class="list-inline-item">
						<?= caNavlink($this->request, _t('Terms of Service'), "nav-link text-uppercase".((strToLower($this->request->getController()) == "terms") ? " active" : ""), "", "Terms", "", "", ((strToLower($this->request->getController()) == "about") ? array("aria-current" => "page") : null)); ?>
					</li>
					<li class="list-inline-item">
						<?= caNavlink($this->request, _t('Privacy Policy'), "nav-link text-uppercase".((strToLower($this->request->getController()) == "privacy") ? " active" : ""), "", "Privacy", "", "", ((strToLower($this->request->getController()) == "about") ? array("aria-current" => "page") : null)); ?>
					</li>
				</ul>
			</div> 
		</footer>
		
		<script>
			window.initApp();
		</script>
	</body>
</html>
