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
						<?= caNavlink($this->request, _t("<div>Milton Glaser Design Study Center and Archives</div><div class='divide border-bottom border-black my-1'></div><div>SVA Archives</div>"), "text-black fs-2 navbar-brand", "", "", ""); ?>
					</div>
					<div class="col-lg-2"></div>
					<div class="col-lg-4 text-lg-end">
						<div class="text-lg-end">
							<form name="appbundle_subscriber_footer" method="post" id="nwl_subscribe_form_footer" aria-label="Newsletter form">
							<input type="hidden" name="_method" value="PUT">
                				<div class="text-start ">
                					<label for="appbundle_subscriber_footer_email" class="form-label">Enter your email to receive our newsletter</label>
                				</div>
                				<div class="input-group">
									<input class="form-control rounded-0 border-white bg-white" type="email" id="appbundle_subscriber_footer_email" name="appbundle_subscriber_footer[email]" required="required" autocomplete="email" placeholder="name@email.com">
									<button class="btn btn-primary" aria-label="Submit">
										<i class="bi bi-arrow-right"></i>
									</button>
								</div>
							<input type="hidden" id="appbundle_subscriber_footer__token" name="appbundle_subscriber_footer[_token]" value="1daa4e09c326830.rnD2YeqEbdMwfLKqwsbCG-S9J6XJXaimNRZw61WlIo8.2wDDAJDlXbsCGv-flImKLMmJZOa8HOvwAFMIoTv1G-n-SJ8rjeg55God2Q"></form>
						</div>
						<div class="text-center">
							<ul class="list-inline pt-3 mb-0">
								<li class="list-inline-item fs-4 px-2"><?php print caNavlink($this->request, '<i class="bi bi-envelope" aria-label="contact"></i>', '', '', "Contact", 'form'); ?></li>
								<li class="list-inline-item fs-4 px-2"><a href="https://www.instagram.com/glaserarchives/" class="" aria-label="Instagram Link"><i class="bi bi-instagram"></i></a></li>
								<li class="list-inline-item fs-4 px-2"><a href="https://twitter.com/glaserarchives" class="" aria-label="X Link"><i class="bi bi-twitter-x"></i></a></li>
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
	</body>
</html>
