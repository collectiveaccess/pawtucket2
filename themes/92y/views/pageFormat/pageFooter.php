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
		<footer id="footer" class="p-5 mt-auto bg-dark text-bg-dark">
			<div class="container-xl">
				
				<div class="border-bottom border-white pb-5 img-fluid">
					<a href="https://www.92ny.org"><?php print caGetThemeGraphic($this->request, '92ny-logo-w_1.svg', array("alt" => "92NY")); ?></a>
				</div>
				<div class="row pt-4">
					<div class="col-12 col-md-6 small">
						&copy; <?= date("Y"); ?> The Young Men's and Young Women's Hebrew Association<br/>
						All Rights Reserved.
					</div>
					<div class="col-12 col-md-6 text-md-end">
						
						<a href="https://www.92ny.org/about-92ny/policies">Privacy Policy</a> | <?php print caNavLink($this->request, "Rights", "", "", "Rights", ""); ?>
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
