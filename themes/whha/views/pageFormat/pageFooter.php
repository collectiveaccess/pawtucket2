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
		<footer id="footer" class="pt-5 text-center mt-auto">
			<div class="container-xl">
				<div class="row justify-content-center pb-5">
					<div class="col-md-3 img-fluid">
						<a href="https://www.whitehousehistory.org"><?= caGetThemeGraphic($this->request, 'WHHA_Logo_1Color_Small.png', array("alt" => "Site logo")); ?></a>
						<div class="pt-3 text-gray fst-italic lh-sm small">The White House Historical Association<br/>is a 501(c)(3) not-for-profit organization.</div>
					</div>
				</div>
			</div>
			<div class="bg-dark text-bg-dark px-0 py-3">
				<div class="container-lg">
					<div class="row">
						<div class="col-md-5 offset-md-1 text-sm-start"><a href="https://www.whitehousehistory.org/about/terms-of-use-privacy-policy" class="text-bg-dark"><?= _t("Terms of Use and Privacy Policy"); ?></a></div>
						<div class="col-md-5 text-sm-end">The White House Historical Association &copy; <?= date("Y"); ?></div>
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
