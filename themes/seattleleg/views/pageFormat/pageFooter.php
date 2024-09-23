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

		<footer id="sgFooter">
			<div class="cosLogo sealth__black"></div>  
			<ul>
				<li><a href="//www.seattle.gov/about-our-digital-properties" target="_blank">About Our Digital Properties</a></li>
				<li><a href="//www.seattle.gov/tech/data-privacy/privacy-statement" target="_blank">Privacy Policy</a></li>
				<li><a href="//www.seattle.gov/americans-with-disabilities-act" target="_blank">ADA Notice</a></li>
			</ul>
		</footer>

		<link rel="stylesheet" href="https://www.seattle.gov/prebuilt/js/seaBrand/nojs/seaBrand.css" />

		<script>
			window.initApp();
		</script>
	</body>
</html>
