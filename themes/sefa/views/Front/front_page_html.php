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
	$va_access_values = $this->getVar("access_values");
	$o_config = caGetFrontConfig();
	
	# --- announcement global values?
	$announcement_title = $this->getVar("home_page_announcement_title");
	$announcement = $this->getVar("home_page_announcement");
	if($announcement_title || $announcement){
?>
		<div class="hp_announcement">
			<?php print ($announcement_title) ? "<div class='announcementTitle'>".$announcement_title."</div>" : ""; ?>
			<?php print $announcement; ?>
		</div>
<?php
	}
	
	# --- grab the set that has the featured 
	$t_set = new ca_sets();
	$t_set->load(array('set_code' => $o_config->get("front_page_exhibit_set_code")));
	$t_exhibition = new ca_occurrences();
	if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_set->get("access"), $va_access_values))){
		$va_exhibition_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $va_access_values))) ? $va_tmp : array());
	}
	if(is_array($va_exhibition_ids) && sizeof($va_exhibition_ids)){
		$i = 0;
		foreach($va_exhibition_ids as $va_exhibition_id){
			$i++;
			print "<div class='row'>";
			$t_exhibition->load($va_exhibition_id);
			# --- use the featured image from the show
			$va_objects = $t_exhibition->get('ca_objects', array("checkAccess" => $va_access_values, "restrictToRelationshipTypes" => array("used_website"), "returnWithStructure" => true));
			if(is_array($va_objects) && sizeof($va_objects)){
				$va_object = array_pop($va_objects);
				$t_object = new ca_objects($va_object["object_id"]);
				print "<div class='col-sm-12'><div class='frontSlide'>".caDetailLink($this->request, $t_object->get("ca_object_representations.media.front", array("checkAccess" => $va_access_values)), '', 'ca_occurrences', $t_exhibition->get("occurrence_id"), null, null, array("type_id" => $t_exhibition->get("ca_occurrences.type_id")))."</div></div>";
			}
			print "<div class='col-sm-12'>";
			print "<h1><i>".caDetailLink($this->request, $t_exhibition->get("ca_occurrences.preferred_labels.name"), '', 'ca_occurrences', $t_exhibition->get("ca_occurrences.occurrence_id"), null, null, array("type_id" => $t_exhibition->get("ca_occurrences.type_id")))."</i></h1>";
			if($t_exhibition->get("ca_occurrences.exhibition_subtitle")){
				print "<h2>".caDetailLink($this->request, $t_exhibition->get("ca_occurrences.exhibition_subtitle"), '', 'ca_occurrences', $t_exhibition->get("ca_occurrences.occurrence_id"), null, null, array("type_id" => $t_exhibition->get("ca_occurrences.type_id")))."</h2>";
			}
			print "<div class='date'>".$t_exhibition->get("ca_occurrences.opening_closing").(($t_exhibition->get("ca_occurrences.opening_reception")) ? " | Opening Reception: ".$t_exhibition->get("ca_occurrences.opening_reception") : "");
			if($t_exhibition->get("ca_occurrences.location")){
				print "<br/>".$t_exhibition->get("ca_occurrences.location", array("convertCodesToDisplayText" => true));
			}elseif($t_exhibition->get("ca_occurrences.outside_location")){
				print "<br/>".$t_exhibition->get("ca_occurrences.outside_location", array("convertCodesToDisplayText" => true));
			}else{
				print "<br/>NYC";
			}
			print "</div>";
			if($i < sizeof($va_exhibition_ids)){
				print "<div class='hpSpace'></div>";
			}
			print "</div><!--end col-sm-12--></div><!-- end row -->";
		}
	}
		
	$vb_featured_event = false;
	# --- check if there are events to show
	$o_occ_search = caGetSearchInstance("ca_occurrences");
	$qr_events = $o_occ_search->search("ca_occurrences.featured_event:yes", array("restrictToTypes" => array("event"), "checkAccess" => $va_access_values, "sort" => "ca_occurrences.event_date", "sortDirection" => "desc"));
	if($qr_events->numHits()){
		print "<div class='row hpEvent'>";
		while($qr_events->nextHit()){
			$vs_event_title = $qr_events->get("ca_occurrences.preferred_labels.name");
			$vs_description = $qr_events->get("ca_occurrences.description");
			$vs_date = $qr_events->get("ca_occurrences.event_date");
			$vs_image = $qr_events->get("ca_object_representations.media.large", array("checkAccess" => $va_access_values));
			if($vs_image){
				print "<div class='col-xs-12 col-sm-6'>";
			}else{
				print "<div class='col-xs-12'>";
			}
			if($vs_event_title){
				print "<H1>".$vs_event_title."</H1>";
			}
			if($vs_date){
				print "<div class='date'>".$vs_date."</div>";
			}
			if($vs_description){
				print "<p>".$vs_description."</p>";
			}
			print "</div>";
			if($vs_image){
				print "<div class='col-xs-12 col-sm-6'>".$vs_image."</div>";
			}
		}
		print "</div><!- end row -->";
		$vb_featured_event = true;
	}
?>
<?php
	# --- check if there are featured Fairs to show
	$o_occ_search = caGetSearchInstance("ca_occurrences");
	$qr_fairs = $o_occ_search->search("ca_occurrences.featured_fair:yes", array("restrictToTypes" => array("art_fair"), "checkAccess" => $va_access_values, "sort" => "ca_occurrences.opening_closing", "sortDirection" => "desc"));
	if($qr_fairs->numHits()){
		print "<div class='row hpEvent'".(($vb_featured_event) ? " style='border-top:0px;'" : "").">";
		while($qr_fairs->nextHit()){
			$vs_fair_title = $qr_fairs->get("ca_occurrences.preferred_labels.name");
			if($qr_fairs->get("ca_occurrences.art_fair_location")){
				$vs_location = caConvertLineBreaks($qr_fairs->get("ca_occurrences.art_fair_location"));
			}
			$vs_date = $qr_fairs->get("ca_occurrences.opening_closing");
			$vs_image = $qr_fairs->get("ca_object_representations.media.large", array("checkAccess" => $va_access_values, "restrictToRelationshipTypes" => array("logo")));
			if($vs_image){
				print "<div class='col-xs-12 col-sm-3 col-sm-offset-3'>".$vs_image."</div>";
			}
			if($vs_image){
				print "<div class='col-xs-12 col-sm-6'>";
			}else{
				print "<div class='col-xs-12'>";
			}
			if($vs_fair_title){
				print "<H1>".caDetailLink($this->request, $vs_fair_title, '', 'ca_occurrences', $qr_fairs->get("occurrence_id"), null, null)."</H1>";
			}
			if($vs_date){
				print "<div class='date'>".$vs_date."</div>";
			}
			if($vs_location){
				print "<p>".$vs_location."</p>";
			}
			print "<p>".caDetailLink($this->request, _t("More Information"), '', 'ca_occurrences', $qr_fairs->get("occurrence_id"), null, null)."</p>";
			print "</div>";
		}
		print "</div><!- end row -->";
	}
?>