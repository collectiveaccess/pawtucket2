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
		<footer id="footer" class="p-5 text-center mt-auto bg-dark text-bg-dark">
			<div class="container-xl">
				<div class="row">
					<div class="col-md-6 text-start">
						<?= caNavLink($this->request, _t("Data Policy and Copyright"), "text-bg-dark small", "", "", "DataPolicyCopyright"); ?>
					</div>
					<div class="col-md-6 text-start text-md-end">
						<a href="https://www.canada.ca/en/heritage-information-network/corporate/contact.html" class="text-bg-dark small" target="_blank">Contact Us</a>
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
