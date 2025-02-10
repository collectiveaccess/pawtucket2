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
 
 	//MetaTagManager::setWindowTitle("");

?>

	<div class="row">
		<div class="col-sm-12 frontSlideshow">
<?php
		print $this->render("Front/featured_set_slideshow_html.php");
?>		
		</div>
	</div>
	<div class="row">
		<div class="col-sm-8">
			<h2>Welcome to the Digital Collections!</h2>
			<!---JB Edit: Added reference and link to harmful language statement--->
			<p>Some content may contain outdated and offensive terminology. See: <a href="http://www.archives.nysed.gov/research/statement-on-language-in-description" target="_blank">New York State Archives Statement on Harmful Language in Descriptive Resources</p>
		</div><!--end col-sm-8-->
		<div class="col-sm-4">
			
<?php
	$o_collection_config = caGetCollectionsConfig();
	$va_access_values = caGetUserAccessValues($this->request);

	$t_list = new ca_lists();
	$vn_collection_type_id = $t_list->getItemIDFromList("collection_types", ($o_collection_config->get("landing_page_collection_type")) ? $o_collection_config->get("landing_page_collection_type") : "topic_collection");
	$vs_sort = ($o_collection_config->get("landing_page_sort")) ? $o_collection_config->get("landing_page_sort") : "ca_collections.preferred_labels.name";
	$qr_collections = ca_collections::find(array('type_id' => $vn_collection_type_id, 'preferred_labels' => ['is_preferred' => 1]), array('returnAs' => 'searchResult', 'checkAccess' => $va_access_values, 'sort' => $vs_sort));
	
	$vn_i = 0;
	if($qr_collections && $qr_collections->numHits()) {
?>
		<H2>Featured Topics</H2>
		<ul class="nav nav-pills nav-stacked">
<?php
		while($qr_collections->nextHit()) {

			print "<li>".caDetailLink($this->request, $qr_collections->get("ca_collections.preferred_labels"), "", "ca_collections",  $qr_collections->get("ca_collections.collection_id"))."</li>";
			$vn_i++;
			if($vn_i == 5){
				break;
			}
		}
?>
		</ul>
<?php
	}
?>
		</div> <!--end col-sm-4-->	
	</div><!-- end row -->