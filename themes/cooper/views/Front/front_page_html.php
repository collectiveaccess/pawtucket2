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
	$qr_res = $this->getVar('featured_set_items_as_search_result');

?>
	<div class="frontTopContainer">
		<div class="frontTop">
			<div class="container">
				<div class="row">
					<div class="col-lg-5 col-md-7 col-sm-12 col-xs-12">
						<H1>The Student<br/>Work Collection</H1>
						<p>An archive of student design projects dating from the 1930’s through the present. This material documents over 4,000 student projects spanning more than eight decades of architectural pedagogy at The Cooper Union. As a whole, these records provide a comprehensive narrative of the School’s evolving, radical and influential approach to architectural education.</p>
						<div class="jcarousel-paginationHero jcarousel-pagination"><!-- Pagination items will be generated in here --></div>

					</div><!-- end col -->
					<div class="col-lg-7 col-md-5 col-sm-7 col-xs-12">
						<?php print ($qr_res->numHits() < 1) ? caGetThemeGraphic($this->request, 'frontImage.jpg') : ""; ?>
					</div><!-- end col -->
				</div><!-- end row -->
			</div><!-- end container -->
		</div>
		</div><!-- end container -->
	</div><!-- end frontTopContainer -->
	<div class="container"><div class="row"><div class="col-xs-12">
		<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>

		<div id="gallerySlideShows"><?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?></div>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery("#gallerySlideShows").load("<?php print caNavUrl($this->request, '', 'Gallery', 'Index'); ?>");
			});
		</script>

<div class="container">
	<div class="row">
		<div class="col-sm-12 frontGalleries">
			<!-- gallery sets loaded here -->
		</div><!--end col-sm-12-->
	</div><!-- end row -->
</div> <!--end container-->