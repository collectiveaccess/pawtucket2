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

			$logo = '<svg xmlns="http://www.w3.org/2000/svg" width="100" height="54" viewBox="0 0 100 54" class="art21logo">
						<path d="M32,25.3c0-4.5-2.6-6.8-7.8-6.8c-2.5,0-4.7,0.3-6.9,1.1L17,19.7l0.8,2.8l0.4-0.1c1.3-0.4,3.4-1,6-1c3.8,0,4.4,1.8,4.5,3.1v0.2c-7.7-0.1-10.4,0.7-12,2.3c-0.9,0.9-1.4,2.4-1.4,3.9c0,3.4,2.7,5.5,7.2,5.5c3.3,0,6.5-2.5,6.5-2.5l1.1,2.3h2.6l-0.6-4V25.3zM28.8,31.8c-1.9,1.2-3.5,1.8-6.2,1.8c-2.5,0-4-1-4-2.6c0-0.9,0.2-1.5,0.8-2c1-1,3.1-1.7,9.4-1.7L28.8,31.8zM48.7,17.8v3.6l-8,2.9v12h-3.3V18.5h2.3l0.5,3.1L48.7,17.8zM65.8,33.1l0.5,2.8c0,0-2,0.5-3.4,0.5c-4.7,0-7.2-2.4-7.2-6.9v-8.2h-3.5v-2.9h3.5v-5.3h3.3v5.3h6.7v2.9h-6.7v8c0,2.8,1.3,4.1,4.1,4.1C63.9,33.4,65.8,33.1,65.8,33.1zM86.8,33.4v2.9h-16l-0.5-3.1l8.6-4.8c3-1.7,4-2.8,4-4.4c0-1.6-1.5-2.6-4.1-2.6c-1.9,0-4,0.5-6,1.6l-0.4,0.2l-1.3-2.6l0.4-0.2c2.5-1.3,4.9-1.9,7.4-1.9c4.5,0,7.2,2,7.2,5.3c0,3.1-2.1,4.9-5.8,6.8l-6,3.2L86.8,33.4zM98.9,18.5v17.8h-3.3l0-14.3l-4.5,1.5l-1-2.2l6.5-2.9H98.9z"></path>
					</svg>';

?>
	</main>
<?php
	if(strToLower($this->request->getController()) != "front"){
		print "</div> <!-- end container -->";
	}
?>
		<footer id="footer" class="p-5 text-center mt-auto bg-dark text-bg-dark">
			<div class="container-xl">
				<div><?= caNavlink($this->request, $logo, "footer-brand  img-fluid", "", "", ""); ?></div>
				<ul class="list-inline pt-3 fw-medium">
  					<li class="list-inline-item text-bg-dark small">&copy; Art21<?= date('Y'); ?></li>
  					<?= ((CookieOptionsManager::cookieManagerEnabled()) ? '<li class="list-inline-item">'.caNavLink($this->request, _t("Manage Cookies"), "text-bg-dark small", "", "Cookies", "manage")."</li>" : ""); ?>
				</ul>
			</div>
		</footer><!-- end footer -->
		
		<?= $this->render("Cookies/banner_html.php"); ?>
		
		<script>
			window.initApp();
		</script>
	</body>
</html>
