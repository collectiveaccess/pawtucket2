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
<div class="container frontContainer">
	<div class="row">
		<div class="col-sm-12">
			<?php print $this->render("Front/featured_set_slideshow_html.php"); ?>
		</div><!--end col-sm-12-->
	</div><!-- end row -->
	<div class="row frontLower">
		<div class="col-sm-4 frontThird">
			<h2>Tweets <small>by <a href="https://twitter.com/sternbergmuseum" target="blank">@sternbergmuseum</a></small></h2>
            <a class="twitter-timeline" data-height="320" data-dnt="true" data-link-color="#f5c135" href="https://twitter.com/sternbergmuseum" data-chrome="noheader nofooter">Tweets by sternbergmuseum</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
		</div><!--end col-sm-4-->
		<div class="col-sm-4 frontThird">
			<h2>{{{homepage_head}}}</h2>
			{{{homepage_text}}}
			
		</div> <!--end col-sm-4-->
		<div class="col-sm-4 frontThirdRight">
			<?php
					print $this->render("Front/gallery_set_links_html.php");
			?>

		</div> <!--end col-sm-4-->
	</div><!-- end row -->
</div> <!--end container-->
