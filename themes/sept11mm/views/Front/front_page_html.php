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

	// print $this->render("Front/featured_set_slideshow_html.php");

	$va_access_values = $this->getVar("access_values");
	$vs_hero = $this->request->getParameter("hero", pString);
	if(!$vs_hero){
 		$vs_hero = rand(1, 5);
	}
?>
<div class="container-flex">
	<div class="hpHeroWrapper position-relative h-100 ">
		<div class="hpHeroSlideshow h-100 w-100 z-1">
			<div id="carouselExampleSlidesOnly" class="carousel slide carousel-fade h-100" data-bs-ride="carousel">
				<div class="carousel-inner h-100">
					<div class="carousel-item h-100">
						<div class="h-100 hpHero hpHero1 py-5"></div>
						<div class="hpHeroCaption bg-white fs-6 border-black border-top border-1">
							<?php print caDetailLink($this->request, "<i>C.2019.104.2</i> Requiem", "", "ca_objects", "120019"); ?>
						</div>					
					</div>
					<div class="carousel-item h-100">
						<div class="h-100 hpHero hpHero2 py-5"></div>
						<div class="hpHeroCaption bg-white fs-6 border-black border-top border-1">
							<?php print caDetailLink($this->request, "<i>C.2011.179.31</i> Tridents", "", "ca_objects", "6370"); ?>
						</div>					
					</div>
					<div class="carousel-item active h-100">
						<div class="h-100 hpHero hpHero3 py-5"></div>
						<div class="hpHeroCaption bg-white fs-6 border-black border-top border-1">
							<?php print caDetailLink($this->request, "<i>C.2007.33.1</i> Mural", "", "ca_objects", "4362"); ?>
						</div>					
					</div>
					<div class="carousel-item h-100">
						<div class="h-100 hpHero hpHero4 py-5"></div>
						<div class="hpHeroCaption bg-white fs-6 border-black border-top border-1">
							<?php print caDetailLink($this->request, "<i>C.2019.129.1</i> Stars of the Forest: Elegy for 9/11", "", "ca_objects", "124565"); ?>
						</div>					
					</div>
					<div class="carousel-item h-100">
						<div class="h-100 hpHero hpHero5 py-5"></div>
						<div class="hpHeroCaption bg-white fs-6 border-black border-top border-1">
							<?php print caDetailLink($this->request, "<i>C.2009.310.9</i> Last Column", "", "ca_objects", "6760"); ?>
						</div>					
					</div>
					
					
				</div>
			</div>
		</div>
		
		
		
		
		
		<div class="container py-5 position-relative z-3">
			<div class="row py-5 py-5">
				<div class="col-sm-12 col-lg-6"><div class="bg-white pt-4 pb-5 px-3 px-md-5 mb-5 mb-lg-0">
<?php
	$vs_hp_intro_title = $this->getVar("hp_intro_title");
	$vs_hp_intro = $this->getVar("hp_intro");
	if($vs_hp_intro_title || $vs_hp_intro){
		if($vs_hp_intro_title){
			print "<H1 class='display-3 lh-base border-bottom border-black pb-2 mb-2'>".$vs_hp_intro_title."</H1>";
		}
		if($vs_hp_intro){
			print "<div class='fs-4 pt-2'>".$vs_hp_intro."</div>";
		}
	}
?>
					
				</div></div>
				<div class="col-lg-1"></div>
				<div class="col-sm-12 col-lg-5">
				 	<div class="pb-3 collectionLink">
				 		<?php print caNavLink($this->request, _t("Object and Art Collection")." <i class='fs-5 bi bi-chevron-right'></i>", "py-3 py-lg-0 fs-4 btn btn-primary d-flex h-100 align-items-center justify-content-center", "", "Browse", "objects"); ?>
				 	</div>
				 	<div class="pb-3 collectionLink">
				 		<?php print caNavLink($this->request, _t("Oral History Collection")." <i class='fs-5 bi bi-chevron-right'></i>", "py-3 py-lg-0 fs-4 btn btn-primary d-flex h-100 align-items-center justify-content-center", "", "Browse", "oral_histories"); ?>
				 	</div>
				 	<div class="pb-3 collectionLink">
				 		<?php print caNavLink($this->request, _t("World Trade Center Site Memorial Competition Collection")." <i class='fs-5 bi bi-chevron-right'></i>", "py-3 py-lg-0 fs-4 lh-sm btn btn-primary d-flex h-100 align-items-center justify-content-center", "", "Browse", "boards"); ?>
					</div>
				 	<div class="collectionLink">
						<?php print caNavLink($this->request, _t("Feature Galleries")." <i class='fs-5 bi bi-chevron-right'></i>", "py-3 py-lg-0 fs-4 btn btn-primary d-flex h-100 align-items-center justify-content-center", "", "Gallery", "Index"); ?>
					</div>
				</div>
				<div class="col-1"></div>
			</div>
		</div>
	</div>
</div>