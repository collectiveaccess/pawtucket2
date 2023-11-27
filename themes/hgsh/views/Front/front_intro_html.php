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
 
 $img = '';
 if($t_obj = ca_objects::find(['idno' => 'WHATSNEW'], ['returnAs' => 'firstModelInstance'])) {
        $hp_image = $t_obj->getPrimaryRepresentation(['homepage']);
        $img = $hp_image['tags']['homepage'];
 }
?>

	<div class="row">
		<div class="col-xs-12 col-sm-6">
			<div class="row">
			<div class="col-xs-6">
				<div class="hpBrowseImage">
					<?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'hp_images/history.jpg')."<div class='hpBrowseTitle'>History of the Suburb</div>", "", "", "Detail", "collections/64"); ?>
				</div>
			</div>			
			<div class="col-xs-6">
				<div class="hpBrowseImage">
					<?php print caNavLink($this->request, $img."<div class='hpBrowseTitle'>What's New</div>", "", "", "Detail", "objects/WHATSNEW"); ?>
				</div>
			</div>
		</div>
		</div>
		<div class="col-xs-12 col-sm-6">
			<div class="row">
			<div class="col-xs-12">
				<div class="hpBrowseImage hpBrowseImageSpacer">
					<?php print caGetThemeGraphic($this->request, 'spacer.png'); ?>
				</div>
				<div class="hpText">
					Hampstead Garden Suburb, near London’s Hampstead Heath, is a vibrant community set within a unique mix of open spaces, planned street scene, and internationally recognised architecture. Welcome to our Virtual Museum.<br/><?php print caNavLink($this->request, 'See Guide', '', '', 'About', 'museum_guide'); ?>
				</div>
			</div><!--end col-sm-8-->
			</div>
		</div>
	</div>
	<div class="row">
	    <div class="col-xs-6 col-sm-3">
            <div class="hpBrowseImage">
                <?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'hp_images/organisations.jpg')."<div class='hpBrowseTitle'>Organisations</div>", "", "", "Browse", "organisations"); ?>
            </div>
        </div>
		<div class="col-xs-6 col-sm-3">
			<div class="hpBrowseImage">
				<?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'hp_images/people.jpg')."<div class='hpBrowseTitle'>People</div>", "", "", "Browse", "people_collections"); ?>
			</div>
		</div>	
		<div class="col-xs-6 col-sm-3">
			<div class="hpBrowseImage">
				<?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'hp_images/places.jpg')."<div class='hpBrowseTitle'>Places</div>", "", "", "Browse", "places"); ?>
			</div>
		</div>
<!--	
		<div class="col-xs-6 col-sm-3">
			<div class="hpBrowseImage">
				<?php #print caNavLink($this->request, caGetThemeGraphic($this->request, 'hp_images/objects.jpg')."<div class='hpBrowseTitle'>Objects</div>", "", "", "Browse", "objects"); ?>
			</div>
		</div>
-->		
		<div class="col-xs-6 col-sm-3">
			<div class="hpBrowseImage">
				<?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'hp_images/suburb_news.png')."<div class='hpBrowseTitle'>Suburb News</div>", "", "", "News", "Index"); ?>
			</div>
		</div>
		<div class="col-xs-6 col-sm-3">
			<div class="hpBrowseImage">
				<?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'hp_images/collections.jpg')."<div class='hpBrowseTitle'>Collections</div>", "", "", "Browse", "collections"); ?>
			</div>
		</div>
		<div class="col-xs-6 col-sm-3">
			<div class="hpBrowseImage">
				<?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'hp_images/events.jpg')."<div class='hpBrowseTitle'>Events</div>", "", "", "Browse", "events"); ?>
			</div>
		</div>
	</div><!-- end row -->
