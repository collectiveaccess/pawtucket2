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
		<footer id="footer" class="p-5 mt-auto bg-secondary">
			<div class="container-xxl">
				<div class="row">
					<div class="col-sm-3">
						<div class="text-primary fw-semibold pb-2">Polonsky Shakespeare Center</div>
						<div class="fs-6">
							262 Ashland Place<br/>
							Brooklyn, NY 11217
						</div>
					</div>
					<div class="col-sm-3 fw-semibold text-uppercase">
						<div class="px-4 text-center"><a href="#" class="small link-underline-light">Link</a></div>
						<div class="px-4 text-center"><a href="#" class="small link-underline-light">Link</a></div>
					</div>
					<div class="col-sm-3 fw-semibold text-uppercase">
						<div class="px-4 text-center"><a href="#" class="small link-underline-light">Link</a></div>
						<div class="px-4 text-center"><a href="#" class="small link-underline-light">Link</a></div>
					</div>
					<div class="col-sm-3 fw-semibold text-uppercase">
						<div class="px-4 text-center"><a href="#" class="small link-underline-light">Link</a></div>
						<div class="px-4 text-center"><a href="#" class="small link-underline-light">Link</a></div>
					</div>
				</div>
			</div>
		</footer><!-- end footer -->
		<div class="container-xxl py-4">
			<div class="img-fluid footerLogo">
				<a href="https://www.tfana.org"><?php print caGetThemeGraphic($this->request, "TFANALOGO_blue.jpg", array("alt" => "Theatre for a New Audience Logo")); ?></a>
			</div>
		</div>
		
		<script>
			window.initApp();
		</script>
	</body>
</html>
