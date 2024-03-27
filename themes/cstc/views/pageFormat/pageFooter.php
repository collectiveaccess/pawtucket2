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
		<footer id="footer" class="py-5 px-xl-5 text-center mt-auto bg-dark text-bg-dark">
			<div class="container-fluid">
				<div class="row align-items-center">
					<div class="col-md-5 col-lg-4 text-center text-md-start">
						<div class="float-md-start me-md-3 mb-2 mb-md-0"><?= caGetThemeGraphic($this->request, 'CSTC-LOGO-GRAPHIC.png', array("alt" => "Carrier Sekani Tribal Council Logo")); ?></div>
						<div class="fs-5">1460 6th Avenue<br>
						Suite 200<br>
						Prince George, BC<br>
						V2L 3N2
						</div>
					</div>
					<div class="col-md-5 col-lg-4 text-center">
						<ul class="list-inline pt-3">
  							<li class="list-inline-item fs-5 fw-bold px-2"><a href="https://carriersekani.ca/" class="text-white">CSTC Home</a></li>
							<li class="list-inline-item fs-5 fw-bold px-2"><?= caNavlink($this->request, _t('Contact'), "text-white", "", "About", "Contact", ""); ?></li>
							<li class="list-inline-item fs-5 fw-bold px-2"><?= caNavlink($this->request, _t('Terms of Use'), "text-white", "", "About", "Terms", ""); ?></li>
						</ul>
					</div>
					<div class="col-md-2 col-lg-4 text-center text-md-end footerSocial">
						<a href="https://www.facebook.com/CarrierSekaniTribalCouncil/" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" alt="facebook"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#feffff" d="M80 299.3V512H196V299.3h86.5l18-97.8H196V166.9c0-51.7 20.3-71.5 72.7-71.5c16.3 0 29.4 .4 37 1.2V7.9C291.4 4 256.4 0 236.2 0C129.3 0 80 50.5 80 159.4v42.1H14v97.8H80z"/></svg></a>
					</div>
				</div>
			</div>
		</footer><!-- end footer -->
		
		<script>
			window.initApp();
		</script>
	</body>
</html>
