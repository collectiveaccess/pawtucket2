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
		<footer id="footer" class="p-5 text-center mt-auto bg-secondary text-bg-dark">
			<div class="container-xl mb-5">
				<div class="row justify-content-center">
					<div class="col-xs-12 col-md-4 col-lg-8 text-center">
					
			
						<div class="display-4">Shingwauk</div><div class="display-5">Residential Schools Centre</div>
						<div class="black small fs-6 pt-3">&copy; <?= date("Y"); ?> Shingwauk Residential Schools Centre.  All rights reserved.</div>
					</div>
				</div>
				<div class="row justify-content-center">
					<div class="col-6 col-md-3 col-lg-2 img-fluid pt-5">
						<a href="https://algomau.ca" target="_blank"><?= caGetThemeGraphic($this->request, 'algoma_logo_rgb_black.png', array("alt" => "Algoma University")); ?></a>
					</div>
				</div>
			</div>
		</footer><!-- end footer -->
		<div id="contentWarningBanner" class="position-fixed bottom-0 w-100"><div role="alert" class="bg-gradient border-top border-2 border-primary bg-light-green m-0 p-2 text-center">{{{srsc_content_warning}}}</div></div>
		
		<script>
			window.initApp();
		</script>
	</body>
</html>
