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
	$va_access_values = caGetUserAccessValues($this->request);
	$o_front_config = caGetFrontConfig($this->request);
?>
	
	<div class="row bgWhite">
		<div class="col-sm-12"><br/></div>
	</div>
<?php
	$vs_hero_with_text = "<div class='row primaryLandingBannerContentGradient'>
			<div class='col-xs-offset-1 col-xs-10 col-sm-offset-1 col-sm-7 col-md-6 col-md-offset-1 primaryLandingBannerContent'>
				".caGetThemeGraphic($this->request, 'hero_spacer_short.png')."<H1 class='primaryLandingBannerTitle'>Explore the<br/>Archives</H1>
			</div>
		</div>";
	$vs_hero_without_text = "<div class='row'>
			<div class='col-xs-offset-1 col-xs-10 col-sm-offset-1 col-sm-7 col-md-6 col-md-offset-1 primaryLandingBannerContent'>
				".caGetThemeGraphic($this->request, 'hero_spacer_short.png')."
			</div>
		</div>";
	print caNavLink($this->request, $vs_hero_without_text, "", "", "Collections", "Index");
?>
	<div class="row bgWhite">
		<div class="col-sm-12"><br/></div>
	</div>
	<div class="row bgWhite">
		<div class="col-sm-12 col-md-10 col-md-offset-1 text-center">
			<H2>{{{home_intro_text}}}</H2>
		</div>
	</div>
	<div class="row bgWhite">
		<div class="col-sm-12 text-center frontIntroText">
			{{{home_intro_text_block}}}
			<hr/>
		</div>
	</div>
	<div class="row bgWhite">
		<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 text-center">
			<h3>{{{home_browse_tagline}}}</h3>
		</div>
	</div>
	<div class="row bgWhite">
		<div class="col-xs-12 col-sm-4 col-sm-offset-4 text-center">
			<?php print caNavLink($this->request, "Browse", "btn btn-default btn-large", "", "Browse", "objects"); ?>
			
		</div><!--end col-sm-8-->		
	</div><!-- end row -->
	<div class="row bgWhite">
		<div class="col-sm-12">
			<hr/>
		</div>
	</div>
<?php
	$t_set = new ca_sets();
	$vs_default_image = caGetThemeGraphic($this->request, 'contact.jpg');
	$vs_image_version = "widepreview";
	$va_front_page_sets = array(
								"front_galleries" => array("controller" => "Gallery", "action" => "Index"),
								"front_collections" => array("controller" => "Collections", "action" => "Index"),
								"front_contact" => array("controller" => "Contact", "action" => "Form"),
								"front_about" => array("controller" => "About", "action" => "")
							);

?>
	<div class="row bgWhite">
		<div class="col-sm-12 col-md-10 col-md-offset-1">
			<div class="row">
<?php
			foreach($va_front_page_sets as $vs_set_code => $va_front_page_set){
?>				
				<div class="col-sm-3">
					<div class="hpFeatured">
<?php
						$vs_image = "";
						$t_set = new ca_sets();
						$t_set->load(array('set_code' => $vs_set_code));
						# Enforce access control on set
						if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_set->get("access"), $va_access_values))){
							$va_set_item_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => true))) ? $va_tmp : array());
							$vs_set_table = Datamodel::getTableName($t_set->get("table_num"));
							$r_set_items = caMakeSearchResult($vs_set_table, $va_set_item_ids);
							if($r_set_items->numHits()){
								$va_tmp = array();
								$r_set_items->nextHit();
								$vs_image = $r_set_items->getWithTemplate("<unit relativeTo='ca_objects' length='1'>^ca_object_representations.media.".$vs_image_version."</unit>");
							}
							print caNavLink($this->request, $t_set->get("ca_sets.preferred_labels.name"), "hpFeaturedTitle", "", $va_front_page_set["controller"], $va_front_page_set["action"]);
							print caNavLink($this->request, ($vs_image) ? $vs_image : $vs_default_image, "", "", $va_front_page_set["controller"], $va_front_page_set["action"]);
							print "<div class='hpFeaturedText'>".$t_set->get("ca_sets.set_description")."</div>";
						}
						
?>			
					</div>
				</div>
<?php
			}
?>
			</div>
		</div>
	</div>
	<div class="row bgWhite">
		<div class="col-sm-12"><hr/><br/><br/><br/><br/></div>
	</div>