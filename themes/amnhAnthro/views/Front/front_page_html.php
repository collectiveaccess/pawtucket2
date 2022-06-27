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
<div class="hero hero<?php print rand(1,9); ?>">
<div class="container">	
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2 col-lg-5 col-lg-offset-1">
			
			<div class="heroSearch">
				<H1>Anthropology</H1>
				Digital Collections
				<form role="search" action="<?php print caNavUrl($this->request, '', 'Search', 'objects'); ?>">
					<div class="formOutline">
						<div class="form-group">
							<input type="text" class="form-control" id="heroSearchInput" placeholder="Search the collection" name="search" autocomplete="off" />
						</div>
						<button type="submit" class="btn-search" id="heroSearchButton"><span class="glyphicon glyphicon-search"></span></button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-sm-12 col-lg-10 col-lg-offset-1">
			 <div class="hpIntro">
				Over 250,000 ethnographic and archaeological objects representing the peoples of the Americas, Africa, Asia, Europe and the Pacific Islands have been digitally imaged and are accessible online.
				<br/><br/>Generous support for creating digital images of artifacts, archival documents, and photographs has been provided by the <a href="https://www.neh.gov/" target="_blank">National Endowment for the Humanities</a>, <a href="https://www.arts.ny.gov/" target="_blank">New York State Council on the Arts</a>, and <a href="https://mellon.org/" target="_blank">The Andrew W. Mellon Foundation</a>.
			</div>
		</div><!--end col-sm-8-->
	</div>
</div>
<div class="container hpExplore">
	<div class="row">
		<div class="col-sm-12">
			<H1>Explore by Collection Area</H1>
		</div>
	</div>
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
				<div class="row">
					<div class="col-sm-3">
<?php
					print caNavLink($this->request, caGetThemeGraphic($this->request, 'hpImages/africa.jpg', array("alt" => "Explore Africa Collection Area"))."<br/>"._t("Africa"), "hpExploreTitle", "", "Browse", "objects", array("facet" => "collection_area_facet", "id" => "172"));
?>
					</div>
					<div class="col-sm-3">
<?php
					print caNavLink($this->request, caGetThemeGraphic($this->request, 'hpImages/asia.jpg', array("alt" => "Explore Asia Collection Area"))."<br/>"._t("Asia"), "hpExploreTitle", "", "Browse", "objects", array("facet" => "collection_area_facet", "id" => "171"));
?>
					</div>
					<div class="col-sm-3">
<?php
					print caNavLink($this->request, caGetThemeGraphic($this->request, 'hpImages/centralAmerica.jpg', array("alt" => "Explore Central America Collection Area"))."<br/>"._t("Central America"), "hpExploreTitle", "", "Browse", "objects", array("facet" => "collection_area_facet", "id" => "174"));
?>
					</div>
					<div class="col-sm-3">
<?php
					print caNavLink($this->request, caGetThemeGraphic($this->request, 'hpImages/europe.jpg', array("alt" => "Explore Europe Collection Area"))."<br/>"._t("Europe"), "hpExploreTitle", "", "Browse", "objects", array("facet" => "collection_area_facet", "id" => "175"));
?>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
<?php
					print caNavLink($this->request, caGetThemeGraphic($this->request, 'hpImages/northAmerica.jpg', array("alt" => "Explore North America Collection Area"))."<br/>"._t("North America"), "hpExploreTitle", "", "Browse", "objects", array("facet" => "collection_area_facet", "id" => "173"));
?>
					</div>
					<div class="col-sm-3">
<?php
					print caNavLink($this->request, caGetThemeGraphic($this->request, 'hpImages/pacific.jpg', array("alt" => "Explore Pacific Collection Area"))."<br/>"._t("Pacific"), "hpExploreTitle", "", "Browse", "objects", array("facet" => "collection_area_facet", "id" => "176"));
?>
					</div>
					<div class="col-sm-3">
<?php
					print caNavLink($this->request, caGetThemeGraphic($this->request, 'hpImages/southAmerica.jpg', array("alt" => "Explore South America Collection Area"))."<br/>"._t("South America"), "hpExploreTitle", "", "Browse", "objects", array("facet" => "collection_area_facet", "id" => "177"));
?>
					</div>
					<div class="col-sm-3">
<?php
					print caNavLink($this->request, _t("Browse All"), "hpExploreTitle hpExploreBrowseAll", "", "Browse", "objects", array("facet" => "collection_area_facet", "id" => "177"));
?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container ">	
		<div class="row">
			<div class="col-sm-12">
	<?php
			print $this->render("Front/gallery_slideshow_html.php");
	?>
			</div> <!--end col-sm-12-->	
		</div><!-- end row -->
	</div>