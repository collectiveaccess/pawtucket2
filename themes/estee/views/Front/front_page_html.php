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
		#print $this->render("Front/featured_set_slideshow_html.php");
?>
	
	<div class="row bgWhite">
		<div class="col-sm-12"><br/></div>
	</div>
	<div class="row">
		<div class="col-xs-offset-1 col-md-7 col-md-offset-1 col-xs-10 col-sm-10 primaryLandingBannerContent">
			<?php print caGetThemeGraphic($this->request, 'hero_spacer.png'); ?>
			<H1 class='primaryLandingBannerTitle'>Digital Archives</H1>
		</div>
	</div>
	<div class="row bgWhite">
		<div class="col-sm-12"><br/></div>
	</div>
	<div class="row bgWhite">
		<div class="col-sm-12 col-md-10 col-md-offset-1 text-center">
			<H2>{{{home_intro_text}}}</H2>
		</div><!--end col-sm-8-->		
	</div><!-- end row -->	
	<div class="row">
		<div class="col-sm-12"><H3 class="text-center">Explore the Collection</H3></div>
	</div>
	<div class="row bgWhite">
		<div class="col-sm-12"><br/><br/><br/><br/></div>
	</div>
	<div class="row bgWhite">
		<div class="col-sm-12 col-md-10 col-md-offset-1">
			<div class="row">
				<div class="col-sm-4">
					<div class="hpFeatured">
						<?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'gallery.jpg'), "", "", "Gallery", "Index"); ?>
						<?php print caNavLink($this->request, "Featured Galleries", "hpFeaturedTitle", "", "Gallery", "Index"); ?>
						<div class="hpFeaturedText">Explore curated selections from the Archive</div>
						<?php print caNavLink($this->request, "MORE", "hpFeaturedLink", "", "Gallery", "Index"); ?>				
					</div>
				</div>
				<div class="col-sm-4">
					<div class="hpFeatured">
						<?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'product2.jpg'), "", "", "Explore", "products"); ?>
						<?php print caNavLink($this->request, "Products", "hpFeaturedTitle", "", "Explore", "products"); ?>
						<div class="hpFeaturedText">Discover products by Estée Lauder's exceptional portfolio of brands</div>
						<?php print caNavLink($this->request, "MORE", "hpFeaturedLink", "", "Explore", "products"); ?>	
					</div>
				</div>
				<div class="col-sm-4">
					<div class="hpFeatured">
						<?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'archival.jpg'), "", "", "Explore", "archival"); ?>
						<?php print caNavLink($this->request, "Archival Items", "hpFeaturedTitle", "", "Explore", "archival"); ?>
						<div class="hpFeaturedText">Experience the history of Estée Lauder's iconic designs by exploring Archival Items</div>
						<?php print caNavLink($this->request, "MORE", "hpFeaturedLink", "", "Explore", "archival"); ?>	
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row bgWhite">
		<div class="col-sm-12"><br/><br/><br/><br/></div>
	</div>