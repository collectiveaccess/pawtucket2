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
 require_once(__CA_APP_DIR__."/helpers/browseHelpers.php");
 $va_access_values = $this->getVar("access_values");
?>

<div class="parallax hero<?php print rand(1, 3); ?>">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-6 col-md-offset-3">
				
				<div class="heroSearch">
					<H1>
						<div class="line1">Welkom bij</div>
						<div class="line2">Erfgoedbank Meetjesland</div>
					</H1>
					<form role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
						<div class="formOutline">
							<div class="form-group">
								<input type="text" class="form-control" id="heroSearchInput" placeholder="Search" name="search" autocomplete="off" aria-label="Search" />
							</div>
							<button type="submit" class="btn-search" id="heroSearchButton"><span class="glyphicon glyphicon-search" aria-label="<?php print _t("Submit Search"); ?>"></span></button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container hpIntro">
	<div class="row">
		<div class="col-md-12 col-lg-8 col-lg-offset-2">
			<p class="callout">{{{hometext}}}</p>
		</div>
	</div>
</div>
<div class="row"><div class="col-sm-12 colNoPadding">

<?php
		print $this->render("Front/featured_set_slideshow_html.php");
?>
</div></div>
<div class="row"><div class="col-sm-12 col-md-12 col-lg-8 col-lg-offset-2 frontPlaces">
	<h2>Bladeren per stad</h2>
<?php
	$o_browse = caGetBrowseInstance("ca_objects");
	$va_cities = $o_browse->getFacet("city_facet", array('checkAccess' => $this->opa_access_values, 'request' => $this->request));
	$i = 0;
	if(is_array($va_cities) && sizeof($va_cities)){
		foreach($va_cities as $va_city){
			if($i == 0){
				print "<div class='row'>";
			}
			print "<div class='col-sm-12 col-md-4'>".caNavLink($this->request, $va_city["label"], "frontPlaceLink", "", "Browse", "objects", array("facet" => "city_facet", "id" => $va_city["id"]))."</div>";
			$i++;
			if($i == 3){
				print "</div><!-- end row -->";
				$i = 0;
			}
		}
		if($i > 0){
			print "</div><!-- end row -->";
		}
	}
	
?>
</div></div>
<div class="row" id="hpScrollBar"><div class="col-sm-12"><i class="fa fa-chevron-down" aria-hidden="true" title="Scroll down for more"></i></div></div>
