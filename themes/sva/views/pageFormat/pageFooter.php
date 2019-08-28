<?php
/* ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2015-2019 Whirl-i-Gig
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
		<div style="clear:both; height:1px;"><!-- empty --></div>
		</div><!-- end pageArea -->
		<footer id="footer">
			<div class="container-fluid">
				<div class="row footer-row no-gutters">
					<div class="col-sm align-self-center">School of Visual Arts Archives</div>
					<div class="col-sm">
					<ul>
						<li><a href="#">About
						<span class="pull-right--arrow">
						<?php print caGetThemeGraphic('icon-arrow-right.svg', array("alt" => "Go")); ?>
						</span>
						</a></li>
						<li><a href="#">Blog
						<span class="pull-right--arrow">
						<?php print caGetThemeGraphic('icon-arrow-right.svg', array("alt" => "Go")); ?>
						</span>
						</a></li>
						<li><a href="#">Glaser Archives</a></li>
						<li><a href="#">SVA Archives</a></li>
					</ul>
					</div>
					<div class="col-sm">
					<ul>
						<li><a href="https://www.instagram.com/glaserarchives">Instagram
						<span class="pull-right--icon">
						<?php print caGetThemeGraphic('icon-instagram.svg', array("alt" => "Go")); ?>
						</span>
						</a></li>
						<li><a href="https://twitter.com/glaserarchives">Twitter
						<span class="pull-right--icon">
						<?php print caGetThemeGraphic('icon-twitter.svg', array("alt" => "Go")); ?>
						</span>
						</a></li>
						<li><a href="mailto:archives@visualartsfoundation.org">Email Us
						<span class="pull-right--icon">
						<?php print caGetThemeGraphic('icon-other.svg', array("alt" => "Go")); ?>
						</span>
						</a></li>
					</ul>
					</div>
				</div>
				<div class="row justify-content-center footer-row--bottom">
					<div class="col-md-10 text-center notice">
						<small>{{{footerlegal}}}</small>
					</div>
				</div>
			</div>
		</footer><!-- end footer -->
		<script src="<?php print $this->request->getThemeUrlPath(); ?>/assets/main.js"></script>
	
		<script type="text/javascript">	
			$(document).ready(function() {
				$('.search-wrapper-close').on('click', function(e) { $('.search-wrapper').removeClass('active'); });
				$('body').on('click', '#search-button', function(e) { $('.search-wrapper').addClass('active'); });
			});
		</script>
	</body>
</html>
