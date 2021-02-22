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
					<H1>Erfgoedbank Waasland</H1>
					<p>Blader door de rijke collecties met foto’s, kranten, documenten, kaarten of filmpjes van musea, heemkringen, archieven en privécollecties uit het Waasland.</p>
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

<?php
	$va_access_values = $this->getVar("access_values");
	$o_config = caGetGalleryConfig();
	
	# --- which type of set is configured for display in gallery section
 	$t_list = new ca_lists();
 	$vn_gallery_set_type_id = $t_list->getItemIDFromList('set_types', $o_config->get('gallery_set_type')); 			
 	$t_set = new ca_sets();
	$va_sets = array();
	if($vn_gallery_set_type_id){
		$va_tmp = array('checkAccess' => $va_access_values, 'setType' => $vn_gallery_set_type_id, 'table' => "ca_objects");
		$va_sets = caExtractValuesByUserLocale($t_set->getSets($va_tmp));
		$va_set_first_items = $t_set->getPrimaryItemsFromSets(array_keys($va_sets), array("version" => "iconlarge", "checkAccess" => $va_access_values));
		
		$o_front_config = caGetFrontConfig();
		$vs_front_page_set = $o_front_config->get('front_page_set_code');
		$vb_omit_front_page_set = (bool)$o_config->get('omit_front_page_set_from_gallery');
		foreach($va_sets as $vn_set_id => $va_set) {
			if ($vb_omit_front_page_set && $va_set['set_code'] == $vs_front_page_set) { 
				unset($va_sets[$vn_set_id]); 
			}
			$va_first_item = $va_set_first_items[$vn_set_id];
			$va_first_item = array_shift($va_first_item);
			$vn_item_id = $va_first_item["item_id"];
		}
	}


	if(is_array($va_sets) && sizeof($va_sets)){
?>

<div class="row bgGray"><div class="col-sm-12 col-md-12 col-lg-8 col-lg-offset-2 frontThemes">
	<h2>Expo's</h2>

		
<?php
					$i = 0;
					foreach($va_sets as $vn_set_id => $va_set){
						if($i == 0){
							print "<div class='row'>";
						}
						$va_first_item = array_shift($va_set_first_items[$vn_set_id]);
						print "<div class='col-sm-6 col-md-3'>";
						print caNavLink($this->request, $va_first_item["representation_tag"], "", "", "Gallery", $vn_set_id);
						if($va_set["name"]){
							print caNavLink($this->request, $va_set["name"], "frontThemesLink", "", "Gallery", $vn_set_id); 
						}
						print "</div>";
						$i++;
						if($i == 4){
							print "</div><!-- end row -->";
							$i = 0;
						}
					}
					if($i > 0){
						print "</div><!-- end row -->";
					}
?>
</div></div>
<?php
	}
?>
<div class="row" id="hpScrollBar"><div class="col-sm-12"><i class="fa fa-chevron-down" aria-hidden="true" title="Scroll down for more"></i></div></div>
