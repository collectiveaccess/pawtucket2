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
#	print $this->render("Front/featured_set_slideshow_html.php");
	
	$va_featured_ids = array();
	if($vs_set_code = $this->request->config->get("front_page_set_code")){
		$t_set = new ca_sets();
		$t_set->load(array('set_code' => $vs_set_code));
		# Enforce access control on set
		if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_set->get("access"), $va_access_values))){
			$vs_set_id = $t_set->get("set_id");
			$va_featured_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => 1))) ? $va_tmp : array());
			$featured_set_items_as_search_result = caMakeSearchResult('ca_occurrences', $va_featured_ids);
		}
	}	
?>
<div class="container">
	<div class="row">
		<div class="col-sm-8">
		<h2>Selected exhibitions</h2>
<?php		
			if ($featured_set_items_as_search_result) {
				while ($featured_set_items_as_search_result->nextHit()) {
					$va_occurrence_id = $featured_set_items_as_search_result->get('ca_occurrences.occurrence_id');
					$va_related_objects = $featured_set_items_as_search_result->get('ca_objects.object_id', array('returnAsArray' => true));
					$vn_object_id = $va_related_objects[0];
					$t_object = new ca_objects($vn_object_id);
					$va_reps = $t_object->getPrimaryRepresentation(array('widepreview'), null, array('return_with_access' => $va_access_values));
					if ($va_opening_dates = $featured_set_items_as_search_result->get('ca_occurrences.exhibition_dates', array('returnAsArray' => true))) {
						#205
						foreach ($va_opening_dates as $va_opening_key => $va_opening) {
							if ($va_opening['ex_dates_type'] == 205) {
								$va_opening_date = $va_opening['ex_dates_value'];
							}
						}
					}
					if ($va_closing_dates = $featured_set_items_as_search_result->get('ca_occurrences.exhibition_dates', array('returnAsArray' => true))) {
						#207
						foreach ($va_closing_dates as $va_closing_key => $va_closing) {
							if ($va_closing['ex_dates_type'] == 207) {
								$va_closing_date = $va_closing['ex_dates_value'];
							}
						}
					}
					print "<div class='exGrid'>";
					print "<div class='splashImage'>".$va_reps['tags']['widepreview']."</div>";
					print "<div>".caNavLink($this->request, $featured_set_items_as_search_result->get('ca_occurrences.preferred_labels'), '', '', 'Detail', 'occurrences/'.$va_occurrence_id)."</div>";
					print "<div>".$va_opening_date." - ".$va_closing_date."</div>";
					print "</div>";
				}
			}
			print "<div class='fullListing'>".caNavLink($this->request, "Full Listing >>", '', '', 'Browse', 'occurrences')."</div>";
?>
		</div><!--end col-sm-8-->
		<div class="col-sm-4">
			<h2>&nbsp;</h2>
			<div>The digital archive contains a selection (though not all) of all the materials on exhibitions held at the School of Visual Arts, documented at the SVA Archives.</div>
			<div>You can also browse our digital archive by <a href='#'>object</a> types, related <a href='#'>people</a>, academic <a href='#'>departments</a>, and exhibition <a href='#'>locations.</a></div>
			<div>More information about the SVA Archives can be found <a href='#'>here</a></div>
		</div> <!--end col-sm-4-->	
	</div><!-- end row -->
</div> <!--end container-->