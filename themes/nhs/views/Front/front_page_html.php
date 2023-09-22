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

<?php
	print $this->render("Front/featured_set_slideshow_html.php");
?>
	<div class="row">
		<div class="col-sm-12 col-md-8 col-md-offset-2">
			<H1>{{{home_intro_text}}}</H1>
		</div>
	</div>
<?php
	print $this->render("Front/gallery_slideshow_html.php");
?>
	<div class="row hpExplore">
		<div class="col-md-12 col-lg-8 col-lg-offset-2">
		<H2 class="frontSubHeading text-center">Explore The Collection</H2>

			<div class="row">
				<div class="col-md-4">
					<div class="hpExploreBox">
						<?php print caNavLink($this->request, "<div class='hpExploreBoxImage hpExploreBoxImage1'></div><div class='hpExploreBoxDetails'><div class='hpExploreBoxTitle'>Library Resources</div></div>", "", "", "Browse", "library_resources"); ?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="hpExploreBox">
						<?php print caNavLink($this->request, "<div class='hpExploreBoxImage hpExploreBoxImage2'></div><div class='hpExploreBoxDetails'><div class='hpExploreBoxTitle'>People</div></div>", "", "", "People", "Index"); ?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="hpExploreBox">
						<?php print caNavLink($this->request, "<div class='hpExploreBoxImage hpExploreBoxImage3'></div><div class='hpExploreBoxDetails'><div class='hpExploreBoxTitle'>Archives & Manuscripts</div></div>", "", "", "ArchivesManuscripts", "Index"); ?>
						
					</div>
				</div>
			</div>
		</div>
	</div>
