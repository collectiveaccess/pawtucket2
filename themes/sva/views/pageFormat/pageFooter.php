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
		<footer id="footer" class="p-5 mt-auto shadow-sm">
			<div class="container-fluid">
				<div class="row align-items-center">
					<div class="col-lg-6">
<?php
						if(strToLower($this->request->getController()) == "front"){
							print "<a class='text-black fs-2 navbar-brand'>"._t("<div>Milton Glaser Design Study Center and Archives</div><div class='divide border-bottom border-black my-1'></div><div>SVA Archives</div>")."</a>";
						}else{
							print caNavlink($this->request, _t("<div>Milton Glaser Design Study Center and Archives</div><div class='divide border-bottom border-black my-1'></div><div>SVA Archives</div>"), "text-black fs-2 navbar-brand", "", "", "");
						}						
?>
					</div>
					<div class="col-lg-2"></div>
					<div class="col-lg-4 text-lg-end">
						<div class="text-center">
							<ul class="list-inline pt-3 mb-0">
								<li class="list-inline-item fs-4 px-2"><?php print caNavlink($this->request, '<i class="bi bi-envelope" aria-label="contact the archive"></i>', '', '', "Contact", 'form'); ?></li>
								<li class="list-inline-item fs-4 px-2"><a href="https://www.instagram.com/glaserarchives/" class="" aria-label="Visit the archive on Instagram"><i class="bi bi-instagram"></i></a></li>
								<li class="list-inline-item fs-4 px-2"><a href="https://twitter.com/glaserarchives" class="" aria-label="Visit the archive on X"><i class="bi bi-twitter-x"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="row mt-5">
					<div class="col-12 text-center fs-6 pt-5 border-top border-black">
						All names, logos, trademarks and/or copyrighted images are the property of their respective owners and their appearance on this site is merely intended to illustrate certain of the content available for educational purposes in the Milton Glaser Design Study Center and Archives of the Visual Arts Foundation and is not intended in any way to imply or suggest that the respective owners of these names, logos, trademarks and/or copyrighted images consent to, approve, endorse, sponsor, or intend to associate with the Visual Arts Foundation or any of its affiliates.
					</div>
				</div>
			</div>
		</footer><!-- end footer -->
		
		<script>
			window.initApp();
		</script>
	</body>
</html>
