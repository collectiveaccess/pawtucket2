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
		<footer id="footer" class="p-5 text-center mt-auto bg-dark text-bg-dark">
			<div class="container-xl mb-5 pb-5">
				<div class="display-4">Shingwauk Residential Schools Centre</div>
				<ul class="list-inline pt-3 fw-medium">
  					<li class="list-inline-item text-bg-dark small">&copy; 2025</li>
					<li class="list-inline-item"><a href="#" class="text-bg-dark small">Link</a></li>
					<li class="list-inline-item"><a href="#" class="text-bg-dark small">Link</a></li>
				</ul>
				<ul class="list-inline pt-3">
  					<li class="list-inline-item fs-4"><a href="#" class="text-bg-dark" aria-label="Facebook Link"><i class="bi bi-facebook"></i></a></li>
					<li class="list-inline-item fs-4"><a href="#" class="text-bg-dark" aria-label="Instagram Link"><i class="bi bi-instagram"></i></a></li>
				</ul>
			</div>
		</footer><!-- end footer -->
		<div class="position-fixed bottom-0 w-100"><div role="alert" class="alert alert-warning m-0 p-2 text-center">{{{srsc_content_warning}}}</div></div>
		
		<script>
			window.initApp();
		</script>
	</body>
</html>
