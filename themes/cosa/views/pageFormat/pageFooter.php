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
		<footer id="footer" class="py-3 px-4 text-center mt-auto bg-dark text-bg-dark">
			<div class="container-xl pt-2 pb-2">
				<div class="text-center pb-2"><a href="https://sa.gov/"><?php print caGetThemeGraphic($this->request, 'sa-footer-logo.png', array("alt" => "Logo with text City of San Antonio Texas")); ?></a></div>
				<div class="text-center pt-1">Copyright &copy; <?= date('Y'); ?> City of San Antonio</div>
				<ul class="list-inline pt-3 pb-1">
  					<li class="list-inline-item me-1"><a class="text-bg-dark" href="https://www.sanantonio.gov/dao">ADA Compliance </a></li>
					<li class="list-inline-item me-1">|</li>
					<li class="list-inline-item me-1"><a class="text-bg-dark" href="https://www.sa.gov/Disclaimer">Privacy Policy &amp; Disclaimer </a></li>
					<li class="list-inline-item me-1">|</li>
					<li class="list-inline-item"><a class="text-bg-dark" href="https://www.sa.gov/Site-Footer/Contact-Us">Contact Us </a></li>
				</ul>
			</div>
		</footer><!-- end footer -->
		<div id="scrollTop" class="fixed-bottom text-end"><a href="#pageTop" class="btn"><i class="bi bi-chevron-up" aria-label="Scroll to top"></i> </a></div>
		
		<?= $this->render("Cookies/banner_html.php"); ?>
		
		<script>
			window.initApp();
		</script>
	</body>
</html>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const scrollTop = document.getElementById('scrollTop');
  const scrollThreshold = 200; // Adjust this value (in pixels) as needed

  function checkScroll() {
    if (window.pageYOffset > scrollThreshold) {
      scrollTop.classList.add('scrollTopVisible');
    } else {
      scrollTop.classList.remove('scrollTopVisible');
    }
  }

  // Add the scroll event listener
  window.addEventListener('scroll', checkScroll);

  // Initial check in case the page is already scrolled on load
  checkScroll();
});
</script>
