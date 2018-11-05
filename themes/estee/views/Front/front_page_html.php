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
	<div class="row primaryLandingBannerContentGradient">
		<div class="col-xs-offset-1 col-xs-10 col-md-9 col-md-offset-1 col-sm-10 primaryLandingBannerContent">
			<?php print caGetThemeGraphic($this->request, 'hero_spacer_short.png'); ?>
			<H1 class='primaryLandingBannerTitle'>Explore<br/>the Archives</H1>
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
	<div class="row bgWhite">
		<div class="col-sm-12 col-md-10 col-md-offset-1">
			<div class="row">
				<div class="col-sm-4">
					<div class="hpFeatured">
						<?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'gallery'.rand(1,2).'.jpg'), "", "", "Gallery", "Index"); ?>
						<?php print caNavLink($this->request, "Featured Galleries", "hpFeaturedTitle", "", "Gallery", "Index"); ?>
						<div class="hpFeaturedText">Explore curated selections from the Archives</div>
						<?php print caNavLink($this->request, "MORE", "hpFeaturedLink", "", "Gallery", "Index"); ?>				
					</div>
				</div>
				<div class="col-sm-4">
					<div class="hpFeatured">
						<?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'browse'.rand(1,4).'.jpg'), "", "", "Explore", "Brands"); ?>
						<?php print caNavLink($this->request, "Browse", "hpFeaturedTitle", "", "Explore", "Brands"); ?>
						<div class="hpFeaturedText">Discover products and archival items by Estée Lauder Companies' exceptional portfolio of brands</div>
						<?php print caNavLink($this->request, "MORE", "hpFeaturedLink", "", "Explore", "Brands"); ?>	
					</div>
				</div>
				<div class="col-sm-4">
					<div class="hpFeatured">
						<?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'contact.jpg'), "", "", "Contact", "form"); ?>
						<?php print caNavLink($this->request, "Contact Us", "hpFeaturedTitle", "", "Contact", "Form"); ?>
						<div class="hpFeaturedText">Inquire about heritage tours, ask a question, schedule a research appointment.</div>
						<?php print caNavLink($this->request, "MORE", "hpFeaturedLink", "", "Contact", "Form"); ?>	
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row bgWhite">
		<div class="col-sm-12"><br/><br/><br/><br/></div>
	</div>