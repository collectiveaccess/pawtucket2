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
		<footer id="footer" class="text-center mt-auto bg-dark text-bg-dark">
			<div class="container-xl py-4">
				<div class="row justify-content-center align-items-center">
					<div class="col-3 img-fluid text-center text-md-end">
						<a href="https://myjdl.com"><?= caGetThemeGraphic($this->request, 'JDL_logo_footer.png', array("alt" => "Jackson District Library logo", "role" => "banner")); ?></a>
					</div>
					<div class="col-12 col-lg-10 col-xl-8 text-center text-lg-end py-4">
						<ul class="list-inline pt-2 mb-0 pb-0">
							<li class="list-inline-item ps-2"><i class="bi bi-house pe-1"></i> <a href="https://myjdl.com" class="text-white">Jackson District Library Home</a></li>
							<li class="list-inline-item ps-2"><i class="bi bi-envelope pe-1"></i> <a href="mailto:history@myjdl.com" class="text-white">Contact US</a></li>
							<li class="list-inline-item ps-2 pe-4"><i class="bi bi-telephone-fill pe-1"></i> 517-788-4087</li>
							<li class="list-inline-item fs-4"><a href="https://www.facebook.com/jacksondistrictlibrary" class="text-primary" aria-label="Facebook Link"><i class="bi bi-facebook"></i></a></li>
							<li class="list-inline-item fs-4"><a href="https://www.youtube.com/channel/UCi-x1yLVyPBA21otE7x6fvA" class="text-primary" aria-label="YouTube Link"><i class="bi bi-youtube"></i></a></li>
							<li class="list-inline-item fs-4"><a href="https://www.instagram.com/jacksondistrictlibrary/" class="text-primary" aria-label="Instagram Link"><i class="bi bi-instagram"></i></a></li>
						</ul>
					</div>
				</div>
				<div class="row">
				</div>
			</div>
		</footer><!-- end footer -->
		
		<?= $this->render("Cookies/banner_html.php"); ?>
		
		<script>
			window.initApp();
		</script>
	</body>
</html>
