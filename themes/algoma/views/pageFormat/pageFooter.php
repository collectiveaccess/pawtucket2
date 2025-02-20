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
		<footer id="footer" class="pt-5 pb-3 text-center mt-auto position-relative text-dark">
			<div class="container-xl">
				<div class="row">
					<div class="col-6 offset-3 col-md-3 offset-md-0 col-lg-2  img-fluid py-5">
						<a href="https://algomau.ca" target="_blank"><?= caGetThemeGraphic($this->request, 'algoma_logo_rgb_colour.png', array("alt" => "Algoma University")); ?></a>
						
					</div>
					<div class="col-xs-12 col-md-4 offset-md-1 col-lg-8 offset-lg-0 img-fluid text-center">
						<a href="https://library.algomau.ca" target="_blank"><?= caGetThemeGraphic($this->request, 'WishartLogo.png', array("alt" => "Arthur A. Wishart Library")); ?></a>
						<div class="pt-5 fs-6">
							1520 Queen St. East<br/>
							Sault Ste. Marie,<br/>
							ON P6A 2G4
						</div>
					</div>
					
				</div>
				<div class="row pt-5">
					<div class="col-12 text-center fs-6">
						Copyright &copy; <?= date("Y"); ?> Algoma University. All Rights Reserved.
					</div>
				</div>
			</div>
		</footer><!-- end footer -->
		
		<script>
			window.initApp();
		</script>
	</body>
</html>
