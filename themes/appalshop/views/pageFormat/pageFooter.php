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
		<footer id="footer" class="p-5 text-center mt-auto">
			<div class="container-xl">
				<div><?php print caGetThemeGraphic($this->request, 'appalshopLogo.png', array("alt" => "Appalshop logo")); ?></div>
				<div class="pt-3">Appalshop - 91 Madison Ave.- Whitesburg, KY 41858 - 606-633-0108 - 606-633-1009 (fax)</div>
				<ul class="list-inline pt-4">
					<li class="list-inline-item fs-2"><a href="https://www.facebook.com/appalarchive" class="green" aria-label="Facebook Link"><i class="bi bi-facebook"></i></a></li>
					<li class="list-inline-item fs-2"><a href="https://www.instagram.com/appalshop_archive/" class="green" aria-label="Instagram Link"><i class="bi bi-instagram"></i></a></li>
					<li class="list-inline-item fs-2"><a href="https://www.youtube.com/channel/UCP6iF9cBLAfhP5ilDk8jH8g" class="green" aria-label="YouTube Link"><i class="bi bi-youtube"></i></a></li>
				</ul>
			</div>
		</footer><!-- end footer -->
		
		<?= $this->render("Cookies/banner_html.php"); ?>
		
		<script>
			window.initApp();
		</script>
	</body>
</html>
