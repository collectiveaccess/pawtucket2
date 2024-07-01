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
</div> <!-- end container -->
		<footer id="footer" class="mt-auto bg-black text-light">
			<div class="footerBrand">
				<?= caGetThemeGraphic($this->request, 'coe-logo-white.svg', array("alt" => "The Ohio State University College of Engineering logo")); ?>
				<div>	
					275 West Woodruff Avenue<br>
					Columbus, Ohio 43210
				</div>
			</div>
			
			<nav class="footerNav" aria-label="footer navigation">
				<ul>
        			<li><a href="https://knowlton.osu.edu/siteinfo/accessibility" class="text-light">Accessibility</a></li>
                	<li><a href="https://it.osu.edu/privacy" class="text-light">Privacy Policy</a></li>
        			<li><a href="https://equity.osu.edu/sites/default/files/documents/non-discrimination-notice.pdf" class="text-light">Non-Discrimination Notice (PDF)</a></li>
        			<li><?= caNavlink($this->request, _t('About'), "text-light", "", "AboutCollection", ""); ?></li>
        			<li><?= caNavlink($this->request, _t('Contact'), "text-light", "", "ContactKnowltonArchives", ""); ?></li>
                    <li><?= ($this->request->isLoggedIn()) ? caNavlink($this->request, _t('Logout'), "text-light", "", "LoginReg", "Logout", "") : caNavlink($this->request, _t('Login'), "text-light", "", "LoginReg", "LoginForm", ""); ?></li>
                    
         		</ul>
			</nav>
			<div class="footerSocial">
				<div class="fw-bold text-body-tertiary pb-1">Follow</div>
				<ul class="social-links">
					<li><a class="text-light" href="https://www.instagram.com/knowltonosu/" class="text-light">Instagram</a></li>
					<li><a class="text-light" href="https://facebook.com/KnowltonOSU" class="text-light">Facebook</a></li>
					<li><a class="text-light" href="https://twitter.com/KnowltonOSU" class="text-light">X</a></li>
					<li><a class="text-light" href="http://www.youtube.com/knowltonosu" class="text-light">YouTube</a></li>
					<li><a class="text-light" href="https://www.linkedin.com/company/knowlton-school/" class="text-light">LinkedIn</a></li>
					<li><a class="text-light" href="https://archinect.com/KnowltonOSU" class="text-light">Archinect</a></li>
      			</ul>
			</div>
			<div class="row w-100 signup-wrapper gx-0">
				<div class="col-12 col-md-6">
					<form action="https://osu.us14.list-manage.com/subscribe/post?u=95c111f0ea3ccebb4a3ce741d&amp;id=a5954a2136" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate="">
						<div id="mc_embed_signup_scroll">
						<label for="mce-EMAIL" class="w-100 pb-2">Sign up to receive occasional emails about the Knowlton School</label>
						<input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="email address" required="">
						<!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
						<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_95c111f0ea3ccebb4a3ce741d_a5954a2136" tabindex="-1" value=""></div>
						<input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button">
						</div>
					</form>
				</div>
				<div class="col-12 col-md-3 offset-md-3"><div class="give-cta-btn"><a href="https://knowlton.osu.edu/support-knowlton">Give <span class="visually-hidden">to Knowlton</span></a></div></div>
			</div>
			<div class="row w-100">
				<div class="col-12 text-body-tertiary">©<?= date("Y"); ?> The Ohio State University</div>
			</div>
		</footer><!-- end footer -->
		
		<script>
			window.initApp();
		</script>
	</body>
</html>
