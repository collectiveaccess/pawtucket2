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
		<footer id="footer" class="mt-auto bg-secondary">
			<div class="p-5 ">
				<div class="container-xxl">
					<div class="row">
						<div class="col-sm-6  text-center text-sm-start">
							<div class="text-primary fw-semibold pb-2">Polonsky Shakespeare Center</div>
							<div class="fs-6">
								262 Ashland Place<br/>
								Brooklyn, NY 11217
							</div>
						</div>
						<div class="col-sm-6 fw-semibold text-center text-sm-end">
							<ul class="list-inline pt-3">
								<li class="list-inline-item fs-4 px-2"><a href="https://www.instagram.com/theatreforanewa/?hl=en" aria-label="Instagram Link" target="_blank"><i class="bi bi-instagram"></i></a></li>
								<li class="list-inline-item fs-4 px-2"><a href="https://www.facebook.com/TheatreforaNewAudience" aria-label="Facebook Link" target="_blank"><i class="bi bi-facebook"></i></a></li>
								<li class="list-inline-item fs-4 px-2"><a href="https://www.youtube.com/user/TheatreNewAudience#p/a" aria-label="YouTube Link" target="_blank"><i class="bi bi-youtube"></i></a></li>
								<li class="list-inline-item fs-4 px-2"><a href="https://twitter.com/TheatreforaNewA" aria-label="X Link" target="_blank"><i class="bi bi-twitter-x"></i></a></li>
							</ul>
							<?= caNavlink($this->request, _t('Terms of Use'), "small", "", "Terms", "", ""); ?>
						</div>
					</div>
				</div>
			</div>
			<div class="bg-white">
				<div class="container-xxl py-4">
					<div class="img-fluid footerLogo text-center">
						<a href="https://www.tfana.org"><?php print caGetThemeGraphic($this->request, "TFANALOGO_blue.jpg", array("alt" => "Theatre for a New Audience Logo")); ?></a>
					</div>
				</div>
			</div>
		</footer><!-- end footer -->
		
		<script>
			document.addEventListener('DOMContentLoaded', function() {
				document.addEventListener('contextmenu', event => {
					event.preventDefault();
				});
			});
			window.initApp();
		</script>
	</body>
</html>
