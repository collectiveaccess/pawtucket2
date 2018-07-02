<?php
/** ---------------------------------------------------------------------
 * themes/default/Front/front_page_html : Front page of site 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013 Whirl-i-Gig
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
 * @package CollectiveAccess
 * @subpackage Core
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
?>
 	<div class="row">
		<div class="col-sm-12 col-md-10 col-md-offset-1">
<?php
		print $this->render("Front/gallery_slideshow_html.php");
?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12 yellowBg">
			<div class="container">
				<div class="row">
					<div class="col-sm-12 col-md-10 col-md-offset-1">
						<H1>{{{home_page_text}}}</H1>
					</div>
				</div>
			</div>
		</div><!--end col-sm-12-->
	</div>
	<div class="row">
		<div class="col-sm-12 col-md-10 col-md-offset-1 hpSlideshowCol">
			<H3>From the Collection</H3>
<?php
		print $this->render("Front/featured_set_grid_html.php");
?>
		</div><!-- end row -->
	</div>
	<script type='text/javascript'>
		jQuery(document).ready(function() {
			var offset = (($(document).width() - $(".yellowBg").width()) / 2) - 15;
			$(".yellowBg").attr("style", "left: -" + offset + "px !important; width: " + $(document).width() + "px !important;");
			$( window ).resize(function() {
				var offset = (($("body").width() - $(".yellowBg").parent().width()) / 2);
				$(".yellowBg").attr("style", "left: -" + offset + "px !important; width: " + $("body").width() + "px !important;");
			});
		});
	</script>