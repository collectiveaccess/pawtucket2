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

		<footer class="pt-5 mt-5" style="background-color: #303335; color: #ffffff;">
			<div class="container-xl">
				<div class="row pb-5 pt-3">
					<div class="col-sm-12 col-md-4 px-5">
						<section>	
							<h4 class="text-white" style="font-size: 20px; margin-bottom: 16px;">Samek Art Museum Locations</h4>
							<div style="font-size: 18px; line-height: 30px;">
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
	
					<div class="col-sm-12 col-md-4 px-5">
						<section>
							<h4 class="text-white" style="font-size: 20px; margin-bottom: 16px;">Useful Links</h4>
							<div style="font-size: 18px; line-height: 30px;">
								<p><strong><a class="text-white" href="http://www.bucknell.edu" target="_blank" rel="noopener">Bucknell University&nbsp;</a></strong></p>
								<p><strong><a class="text-white" href="https://museum.bucknell.edu/contact-and-staff/" target="_blank" rel="noopener">Contact Samek</a></strong></p>
								<p><strong><a class="text-white" href="https://give.bucknell.edu/adf?des=3e20e26d-6727-4478-b3b6-62ee9ef98cf1" target="_blank" rel="noopener">Donate</a></strong></p>
								<p><strong><a class="text-white" href="https://museum.bucknell.edu/plan-a-visit/" target="_blank" rel="noopener">Hours and Directions&nbsp;</a></strong></p>
							</div>
						</section>
					</div>
	
					<div class="col-sm-12 col-md-4 px-5">
						<section>
							<form action="https://museum.bucknell.edu/" role="search">
								<div class="input-group mt-4">
									<input type="text" name="search" class="form-control rounded-0 border-black" id="nav-search-input" placeholder="Search this website …" aria-label="Search">
									<!-- <button type="submit" class="btn rounded-0" id="nav-search-btn"><i class="bi bi-search text-white"></i></button> -->
								</div>
							</form>
						</section>
					</div>
				</div>
	
				<div class="row py-5 justify-content-center" style="border-top: 1px solid #222; font-size: 18px;">
					<div class="col-sm-10 text-center">
						<p>
							Copyright ©&nbsp;2024 · 
							<a class="text-white" href="http://my.studiopress.com/themes/modern-portfolio/">Modern Portfolio Pro Theme</a> 
							on 
							<a class="text-white" href="https://www.studiopress.com/">Genesis Framework</a>
							· 
							<a class="text-white" href="https://wordpress.org/">WordPress</a>
							· 
							<a class="text-white" href="https://museum.bucknell.edu/wp-login.php">Log in</a>
						</p>
					</div>
				</div>
			</div>
		</footer>


		<!-- <footer id="footer" class="mt-3 p-5 text-center bg-dark text-bg-dark">
			<div class="container-xl">
				<div class="display-4">
					<?= caNavlink($this->request, caGetThemeGraphic($this->request, 'samek_logo.png', array("alt" => "Logo", "role" => "banner")), "navbar-brand", "", "", ""); ?>
				</div>
				<br>
				<address>
					<div class="row justify-content-center">
						<div class="col-sm-6 col-md-3">
							<strong>Campus Location</strong><br>
							Top floor, Elaine Langone Center, Bucknell University<br>
							701 Moore Avenue<br>
							Lewisburg, PA 17837<br><br>
						</div>
						<div class="col-sm-6 col-md-3">
							<strong>Downtown Location</strong><br>
							416 Market Street<br>
							Lewisburg, PA 17837
						</div>
					</div>
				</address>
				<ul class="list-inline pt-3 fw-medium">
					<li class="list-inline-item text-bg-dark"><a class="text-white" href="https://museum.bucknell.edu/" target="_blank">museum.bucknell.edu</a></li>
				</ul>
				<ul class="list-inline pt-3 fw-medium">
					<li class="list-inline-item small">
						<?= caNavlink($this->request, _t('Contact'), "nav-link".((strToLower($this->request->getController()) == "contact") ? " active" : ""), "", "Contact", "Form", "", ((strToLower($this->request->getController()) == "contact") ? array("aria-current" => "page") : null)); ?>
					</li>
					<li class="list-inline-item text-bg-dark small">&copy; 2024</li>
				</ul>
			</div>
		</footer> -->
		<!-- end footer -->
		
		<script>
			window.initApp();
		</script>
	</body>
</html>
