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
	<div class="h-100 hpHero hpHero<?php print $vs_hero; ?> py-5">
		<div class="container py-5">
			<div class="row">
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
				<div class="col-sm-12 col-lg-4">
				 	<div class="pb-3 collectionLink">
				 		<?php print caNavLink($this->request, _t("Object Collection")." <i class='fs-5 bi bi-chevron-right'></i>", "py-3 py-lg-0 fs-4 btn btn-primary d-flex h-100 align-items-center justify-content-center", "", "Browse", "objects"); ?>
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
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-10 pt-4 text-center fs-4">
			{{{hp_callout}}}
		</div>
	</div>
</div>
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8 pt-2 text-left">
			<div class="px-lg-4">
				<div class="img-fluid pb-2">
					<?php print caGetThemeGraphic($this->request, "hp_conservation.jpg", array("alt" => "Image of evidence tag, hat and badge")); ?>
				</div>
				<H2 class="pt-4">Conservation</H2>
				<div class="fs-5 pb-2">
					{{{hp_conservation}}}
				</div>
				<div class="mb-5 mt-2">
					<a href="https://911memorial.org/visit/museum/collection/conservation" class="btn btn-primary">Learn more</a>
				</div>
			</div>
		</div>
	</div>
	<div class="row justify-content-center">
		<div class="col-md-8 mt-lg-5 pt-5 text-left">
			<div class="px-lg-4">
				<div class="img-fluid pb-2">
					<?php print caGetThemeGraphic($this->request, "hp_donate.jpg", array("alt" => "Image of oral history being recorded")); ?>
				</div>
				<div class="row">
					<div class="col-sm-8 small"><div class="small pb-4 fw-bold fs-6">Collection 9/11 Memorial Museum, Gift of Anthony and Maryann Gambale, in Memory of Giovanna Gambale. <?php print caDetailLink($this->request, "Learn more about this item", "", "ca_objects", 8618); ?>.</div></div>
					<div class="col-sm-4"><div class="small pb-4 fw-bold fs-6 text-end text-uppercase">Photo by Michael Hnatov</div></div>
				</div>
				<H2 class="pt-lg-4">Give to the Collection</H2>
				<div class="fs-5 pb-2">
					{{{hp_donate}}}
				</div>
				<div class="mb-5 mt-2">
					<a href="https://911memorial.org/support/donate/contribute-collection" class="btn btn-primary">Learn more</a>
				</div>
			</div>
		</div>
	</div>	
	<div class="row justify-content-center">
		<div class="col-md-8 mt-lg-5 pt-5 text-left">
			<div class="px-lg-4">
				<div class="img-fluid pb-2">
					<?php print caGetThemeGraphic($this->request, "hp_loans.jpg", array("alt" => "Image of LMDC Board")); ?>
				</div>
				<div class="small pb-4 fw-bold fs-6">Quilts from the collection on view at the National Quilt Museum in Paducah, KY.</div>
				<H2 class="pt-lg-4">Outgoing Loans</H2>
				<div class="fs-5 pb-2">
					{{{hp_loans}}}
				</div>
				<div class="mb-5 mt-2">
					<a href="https://911memorial.org/visit/museum/outgoing-loans" class="btn btn-primary">Learn more</a>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container-flex">
	<div class="fade-out bg-black bg-opacity-25 text-bg-dark p-3 text-center shadow w-100 fixed-bottom display-4"><i class="bi bi-chevron-down"></i></div>
</div>