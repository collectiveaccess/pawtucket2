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
	<div class="col-sm-12 bgLightBlue">
		<div class="jcarousel-wrapper mainSlideShow">
			<!-- Carousel -->
			<div class="jcarousel mainSlide">
						<div class='frontSlide'>
							<div class="row">
								<div class="col-xs-12 col-sm-5 col-md-5">
									<?php print caGetThemeGraphic($this->request, 'archives.png'); ?>
								</div>
								<div class="col-xs-12 col-sm-7 col-md-7">
									<div class="slideTextRight">
										<h2 align="center">
											Explore the history of Grand Rapids
										</h2>
										<p class="text-center">Our historical digital collections feature photographs, newspapers, maps, and more.</p>
										<p class="text-center">
											<?php print caNavLink($this->request, _t("View collections"), "btn-default", "", "Browse", "Collections"); ?>
											<?php print caNavLink($this->request, _t("Browse images"), "btn-default", "", "Browse", "Objects", array("facet" => "type_facet", "id" => 33, "view" => "images")); ?>
										</p>
										<p class="text-center">
											<?php print caNavLink($this->request, _t("View map"), "btn-default", "", "Browse", "Objects", array("facet" => "type_facet", "id" => 37, "view" => "map")); ?>
											<?php print caNavLink($this->request, _t("Search newspapers and magazines"), "btn-default", "", "Search", "advanced/publications"); ?>
										</p>
									</div>
								</div>
							</div>
						</div>
			</div><!-- end jcarousel -->
		</div><!-- end jcarousel-wrapper -->
		</div>
	</div>
<?php
	$vs_tagline = $this->getVar("frontpage_tagline");
	if($vs_tagline){
?>
	<div class="row">
		<div class="col-sm-12 col-md-10 col-md-offset-1">
			<H1><?php print $vs_tagline; ?></H1>
		</div><!--end col-sm-12-->
	</div><!-- end row -->
<?php
	}else{
		print "<div class='row collectionLinksSpacer'><div class='col-sm-12'></div></div>";
	}
?>
	<div class="row">
		<div class="col-xs-12 col-sm-10 col-sm-offset-1">
			<div class="row collectionLinks">
				<div class="col-xs-12 col-sm-4">
					<?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'GRHistory-BronemasMidcenturyHomes-620x620.png', array("alt" => "Featured Collection: Bronkema's Midcentury Homes")), "", "", "Browse", "Objects", array("facet" => "collection_facet", "id" => 178, "view" => "images")); ?>
				</div>
				<div class="col-xs-12 col-sm-4">
					<?php print caNavLink($this->request, caGetThemeGraphic($this->request, '2 Blackhistory 2.png', array("alt" => "Featured Collection: Grand Rapids Black History")), "", "", "Browse", "Objects", array("facet" => "collection_facet", "id" => 176, "view" => "images")); ?>
				</div>
				<div class="col-xs-12 col-sm-4">
					<?php print caNavLink($this->request, caGetThemeGraphic($this->request, '3 NRFP.png', array("alt" => "Featured Collection: New River Free Press")), "", "", "Browse", "Objects", array("facet" => "collection_facet", "id" => 6, "view" => "images")); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="container"><div class="row">
		<div class="col-sm-12">
<?php
			print $this->render("Front/gallery_slideshow_html.php");
?>
		</div>
	</div></div>
