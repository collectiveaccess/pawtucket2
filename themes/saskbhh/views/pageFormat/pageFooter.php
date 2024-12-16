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
		<footer id="footer" class="p-5 text-center mt-auto bg-none position-relative text-bg-dark">
			<div class="elementor-motion-effects-container"><div class="elementor-motion-effects-layer" style="width: 100%; height: 160%; --translateY: -63.98999999999999px; transform: translateY(var(--translateY));"></div></div>
			<div class="elementor-background-overlay"></div>
			<div class="container-xl position-relative">
				<div class="fw-bold text-start lh-lg">					
					Museums Association of Saskatchewan<br>
					
					424 McDonald Street | Regina, SK | S4N 6E1<br>
					
					Phone: (306) 780-9279<br>
					
					mas@saskmuseums.org<br>
			</div>
		</footer><!-- end footer -->
		<section>
			<div class="container-xl mt-4 pt-4">
				<div class="row justify-content-center text-center">
					<div class="col-8 col-md-12">
						<div class="row justify-content-center text-center">
							<div class="col-12 col-md-4 col-lg-3 img-fluid pb-4 mb-4"><?php print caGetThemeGraphic($this->request, 'logo-sasklotteries-2021.png', array("class" => "w-50", "alt" => "Funded by SASK Lotteries")); ?></div>
							<div class="col-12 col-md-4 col-lg-3 img-fluid pb-4 mb-4"><?php print caGetThemeGraphic($this->request, 'logo-saskculture-2021.png', array("class" => "w-50", "alt" => "Supported by SASK Culture Program")); ?></div>
							<div class="col-12 col-md-4 col-lg-3 img-fluid pb-4 mb-4"><?php print caGetThemeGraphic($this->request, 'logo-canada.png', array("class" => "w-50", "alt" => "Canada")); ?></div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<script>
			window.initApp();
		</script>
	</body>
</html>
