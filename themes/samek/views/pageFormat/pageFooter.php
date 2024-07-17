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

		<footer class="mt-5 bg-dark text-white">
			<div class="container footerTop">
				<div class="row">

					<div class="col-md-12 col-lg-4 align-items-start">	
						<div class="display-6">Samek Art Museum Locations</div>
						<div class="pe-md-3">
							<div class="footerUnit">
								<div class="fw-bold">Campus</div>
								Top floor, Elaine Langone Center on the campus of Bucknell University
								<br>
								701 Moore Avenue Lewisburg, PA 17837
							</div>
							<div class="footerUnit">
									<div class="fw-bold">Downtown&nbsp;</div>
									416 Market Street Lewisburg, PA 17837
							</div>
						</div>
					</div>

					<div class="col-md-12 col-lg-4 align-items-start">
						<div class="col2">
							<div class="display-6">Useful Links</div>
							<div class="footerUnit">
								<a class="text-white fw-bold" href="http://www.bucknell.edu" target="_blank" rel="noopener">Bucknell University&nbsp;</a>
							</div>
							<div class="footerUnit">
								<a class="text-white fw-bold" href="https://museum.bucknell.edu/contact-and-staff/" target="_blank" rel="noopener">Contact Samek</a>
							</div>
							<div class="footerUnit">
								<a class="text-white fw-bold" href="https://give.bucknell.edu/adf?des=3e20e26d-6727-4478-b3b6-62ee9ef98cf1" target="_blank" rel="noopener">Donate</a>
							</div>
							<div class="footerUnit">
								<a class="text-white fw-bold" href="https://museum.bucknell.edu/plan-a-visit/" target="_blank" rel="noopener">Hours and Directions&nbsp;</a>
							</div>
						</div>
					</div>

					<div class="col-md-12 col-lg-4 align-items-start">
						<a href="https://www.facebook.com/SamekArtMuseum" target="_blank"><i class="bi bi-facebook text-white me-2"></i></a>
						<a href="https://www.instagram.com/samekartmuseum/" target="_blank"><i class="bi bi-instagram text-white"></i></a>
					</div>

				</div>
			</div>

			<div class="container-fluid footerBottom">
				<div class="row">
					<div class="col-sm-12 text-center">
						<div class="">
							Copyright ©&nbsp;2024 · 
							<a class="text-white" href="http://my.studiopress.com/themes/modern-portfolio/">Modern Portfolio Pro Theme</a> 
							on 
							<a class="text-white" href="https://www.studiopress.com/">Genesis Framework</a>
							· 
							<a class="text-white" href="https://wordpress.org/">WordPress</a>
							· 
							<a class="text-white" href="https://museum.bucknell.edu/wp-login.php">Log in</a>
						</div>
					</div>
				</div>
			</div>

		</footer>
		
		<script>
			window.initApp();
		</script>
	</body>
</html>
