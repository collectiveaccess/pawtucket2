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
 	AssetLoadManager::register("maps");
 	$va_access_values = caGetUserAccessValues($this->request);
 	require_once(__CA_LIB_DIR__.'/Search/EntitySearch.php');
?>
	<div class="row">
		<div class="col-sm-12">
			<h1>Amutat - Things to Pull</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			{{{hp_callout}}}
		</div>
	</div><!-- end row -->
	<div class="row hpIntroTop flex bg_gray">
		<div class="col-sm-12 col-md-6 col-lg-7 fullWidthImg">
			<?php print caGetThemeGraphic($this->request, 'Finland1.jpg', array("alt" => "Skin sewers study an Alutiiq caribou skin parka at the National Museum of Finland, Helsinki.")); ?>
			<div class="text-center hpCaption">{{{hp_intro_caption}}}</div>
		</div>
		<div class="col-sm-12 col-md-6 col-lg-5">
			
			<div class="hpIntroTopDesc"><div class="hpIntroTopDescTitle">{{{hp_intro_title}}}</div>{{{hp_intro}}}</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4 col-sm-offset-1">
			<?php print caNavLink($this->request, "<div class='hpFindBox'>"._t("Find<br/>Institutions")."</div>", "", "", "browse", "institutions"); ?>
		</div>
		<div class="col-sm-4 col-sm-offset-2">
			<?php print caNavLink($this->request, "<div class='hpFindBox'>"._t("Find<br/>Objects")."</div>", "", "", "browse", "amutatObjects"); ?>
		</div>		
	</div>
	<div class="row">
		<div class="col-sm-12 text-center">
			<h2>Alutiiq Collections Around the World</h2>
<?php
			$t_list_item = new ca_list_items();
			$t_list_item->load(array("idno" => "institution"));
			$o_search = new EntitySearch();
 		 	if(is_array($va_access_values) && sizeof($va_access_values)){
 		 		$o_search->addResultFilter("ca_entities.access", "IN", join(',', $va_access_values));
			}
			$qr_res = $o_search->search("ca_entities.type_id:".$t_list_item->get("item_id"), array("sort" => "ca_entity_labels.name_sort"));
	
 			$o_map = new GeographicMap('100%', 500, 'map');
			$va_map_stats = $o_map->mapFrom($qr_res, "ca_entities.georeference", array("labelTemplate" => "<l>^ca_entities.preferred_labels.displayname%delimiter=;</l>", "request" => $this->request, "checkAccess" => $va_access_values));
			print $o_map->render('HTML', array('delimiter' => "<br/>"));
?>			
		</div>
	</div>
	<div class="row hpImages bg_gray">
		<div class="col-sm-4">
			<?php print caGetThemeGraphic($this->request, 'France2.jpg', array("alt" => "Carver Perry Eaton studies Alutiiq masks at the Musée Boulogne-Sur-Mer, France.")); ?>
			<div class="text-center hpCaption">Carver Perry Eaton studies Alutiiq masks at the Musée Boulogne-Sur-Mer, France.</div>
		</div>
		<div class="col-sm-4">
			<?php print caGetThemeGraphic($this->request, 'France3.jpg', array("alt" => "Alutiiq artists studied beaded garments at the Musée Boulogne-Sur-Mer, France.")); ?>
			<div class="text-center hpCaption">Alutiiq artists studied beaded garments at the Musée Boulogne-Sur-Mer, France.</div>
		</div>
		<div class="col-sm-4">
			<?php print caGetThemeGraphic($this->request, 'RME1.jpg', array("alt" => "Weavers study grass basketry at the Russian Museum of Ethnography, St. Petersburg, Russia.")); ?>
			<div class="text-center hpCaption">Weavers study grass basketry at the Russian Museum of Ethnography, St. Petersburg, Russia.</div>
		</div>
	</div><!-- end row -->
	<div class="row">
		<div class="col-md-6 col-md-offset-3 text-center hpCallOut">
			<h3>Contact Us</h3>
			{{{hp_contact}}}
		</div>
	</div>
	<hr/>
	<div class="row">
		<div class="col-sm-12 text-center">
			<b>{{{hp_funder}}}</b><br/><br/>
			<div class="row">
				<div class="col-sm-2 col-sm-offset-4">
					<?php print caGetThemeGraphic($this->request, 'Sunaq-Logo-12-2015.jpg', array("alt" => "Logo of Sun’aq Tribe of Kodiak")); ?>
				</div>
				<div class="col-sm-2">
					<?php print caGetThemeGraphic($this->request, 'Seal_of_the_United_States_Bureau_of_Indian_Affairs.png', array("alt" => "Seal of the US Bureau of Indian Affairs")); ?>
				</div>
			</div>
		</div>
	</div>
	<hr/>

	
	