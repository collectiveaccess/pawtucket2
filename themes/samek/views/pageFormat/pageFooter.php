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

		<footer class="mt-5">
			<div class="footer-inner">
				<div class="row">
					<div class="col-sm-10 col-md-4 align-items-start ps-0 pe-5">
						<section>	
							<h4 class="text-white">Samek Art Museum Locations</h4>
							<div>
								<p>
									<strong>Campus&nbsp;</strong>
									<br>
									Top floor, Elaine Langone Center on the campus of Bucknell University
									<br>
									701 Moore Avenue Lewisburg, PA 17837
								</p>
								<p>
									<strong>Downtown&nbsp;</strong>
									<br>
									416 Market Street Lewisburg, PA 17837
								</p>
							</div>
						</section>
					</div>

					<div class="col-sm-12 col-md-4 align-items-start">
						<section>
							<h4 class="text-white">Useful Links</h4>
							<div>
								<p><strong><a class="text-white" href="http://www.bucknell.edu" target="_blank" rel="noopener">Bucknell University&nbsp;</a></strong></p>
								<p><strong><a class="text-white" href="https://museum.bucknell.edu/contact-and-staff/" target="_blank" rel="noopener">Contact Samek</a></strong></p>
								<p><strong><a class="text-white" href="https://give.bucknell.edu/adf?des=3e20e26d-6727-4478-b3b6-62ee9ef98cf1" target="_blank" rel="noopener">Donate</a></strong></p>
								<p><strong><a class="text-white" href="https://museum.bucknell.edu/plan-a-visit/" target="_blank" rel="noopener">Hours and Directions&nbsp;</a></strong></p>
							</div>
						</section>
					</div>
				</div>
			</div>
		</footer>

		<footer>
			<div class="row justify-content-center align-items-center me-2" style="border-top: 1px solid #222; font-size: 18px; min-height: 127px;">
				<div class="col-sm-12 text-center">
					<p class="mb-0">
						Copyright ©&nbsp;2024 · 
						<a class="text-white" style="text-decoration-thickness: 1.5px; text-underline-offset: 1px;" href="http://my.studiopress.com/themes/modern-portfolio/">Modern Portfolio Pro Theme</a> 
						on 
						<a class="text-white" style="text-decoration-thickness: 1.5px; text-underline-offset: 1px;" href="https://www.studiopress.com/">Genesis Framework</a>
						· 
						<a class="text-white" style="text-decoration-thickness: 1.5px; text-underline-offset: 1px;" href="https://wordpress.org/">WordPress</a>
						· 
						<a class="text-white" style="text-decoration-thickness: 1.5px; text-underline-offset: 1px;" href="https://museum.bucknell.edu/wp-login.php">Log in</a>
					</p>
				</div>
			</div>
		</footer>
		
		<script>
			window.initApp();
		</script>
	</body>
</html>
