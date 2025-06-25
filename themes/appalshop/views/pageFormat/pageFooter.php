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
		<footer id="footer" class="pt-5 text-center mt-auto">
				<div class="container-xl">
					<div><a href="https://www.appalshop.org"><?php print caGetThemeGraphic($this->request, 'appalshopLogo.png', array("alt" => "Appalshop logo")); ?></a></div>
					<div class="pt-3">Appalshop Archive<br/>9404 HWY 805, STE B (Upstairs) Jenkins, KY 41537<br/>(606) 633-0108</div>
					<ul class="list-inline pt-4 mb-5">
						<li class="list-inline-item fs-2"><a href="https://www.facebook.com/appalarchive" class="green" aria-label="Facebook Link"><i class="bi bi-facebook"></i></a></li>
						<li class="list-inline-item fs-2"><a href="https://www.instagram.com/appalshop_archive/" class="green" aria-label="Instagram Link"><i class="bi bi-instagram"></i></a></li>
						<li class="list-inline-item fs-2"><a href="https://www.youtube.com/channel/UCP6iF9cBLAfhP5ilDk8jH8g" class="green" aria-label="YouTube Link"><i class="bi bi-youtube"></i></a></li>
					</ul>
				</div>
				<div class="bg-white py-5 px-5 g-5 shadow">
					<div class="container-xl">
						<div class="row">
							<div class="col-md-6 offset-md-3 col-lg-4 offset-lg-4 img-fluid img-fluid-larger">
								<a href="https://www.ironmountain.com" target="_blank"><?php print caGetThemeGraphic($this->request, 'IM_Logo.png', array("alt" => "Iron Mountain logo")); ?></a>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								{{{iron_mountain_sponsor_note}}}
							</div>
						</div>
					</div>
				</div>
				<div class="bg-white py-5 px-5 g-5 shadow">
					<div class="container-xl">
						<div class="row g-5 justify-content-center">
							<div class="col-md-4 col-lg-2 mb-4 img-fluid d-flex align-items-center justify-content-center">
								<a href="https://americanarchive.org/" target="_blank"><?php print caGetThemeGraphic($this->request, 'AAPB.png', array("alt" => "American Archive of Public Broadcasting")); ?></a>
							</div>
							<div class="col-md-4 col-lg-2 mb-4 img-fluid d-flex align-items-center justify-content-center">
								<a href="https://www.arts.gov/" target="_blank"><?php print caGetThemeGraphic($this->request, 'NEA.jpg', array("alt" => "National Endowment for the Arts logo")); ?></a>
							</div>
							<div class="col-md-4 col-lg-2 mb-4 img-fluid d-flex align-items-center justify-content-center">
								<a href="https://www.neh.gov/" target="_blank"><?php print caGetThemeGraphic($this->request, 'NEH.jpg', array("alt" => "National Endowment for the Humanities logo")); ?></a>
							</div>
						</div>
						<div class="row g-5 justify-content-center">
							<div class="col-md-4 col-lg-2 mb-4 img-fluid d-flex align-items-center justify-content-center">
								<a href="https://www.filmpreservation.org/" target="_blank"><?php print caGetThemeGraphic($this->request, 'National_Film_Preservation_Foundation.png', array("alt" => "National Film Preservation Foundation logo")); ?></a>
							</div>
							<div class="col-md-4 col-lg-2 mb-4 img-fluid d-flex align-items-center justify-content-center">
								<a href="https://www.nywift.org/" target="_blank"><?php print caGetThemeGraphic($this->request, 'NYWIFT.jpg', array("alt" => "NY Women in Film & Television logo")); ?></a>
							</div>
							<div class="col-md-4 col-lg-2 mb-4 img-fluid d-flex align-items-center justify-content-center">
								<a href="https://www.nps.gov" target="_blank"><?php print caGetThemeGraphic($this->request, 'Save-Americas-Treasures.png', array("alt" => "Save America's Treasures logo")); ?></a>
							</div>
							<div class="col-md-4 col-lg-2 mb-4 img-fluid d-flex align-items-center justify-content-center">
								<a href="https://www.recordingpreservation.org" target="_blank"><?php print caGetThemeGraphic($this->request, 'National_Recording_Preservation_Foundation_logo_small.jpg', array("alt" => "National Recording Preservation Foundation logo")); ?></a>
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
