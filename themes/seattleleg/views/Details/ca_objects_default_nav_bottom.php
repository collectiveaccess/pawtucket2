<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2023 Whirl-i-Gig
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
 * ----------------------------------------------------------------------
 */
$t_object = 		$this->getVar("item");
$table = $t_object->tableName();
$access_values = 	$this->getVar("access_values");
$options = 			$this->getVar("config_options");
$comments = 		$this->getVar("comments");
$tags = 			$this->getVar("tags_array");
$comments_enabled = $this->getVar("commentsEnabled");
$pdf_enabled = 		$this->getVar("pdfEnabled");
$inquire_enabled = 	$this->getVar("inquireEnabled");
$copy_link_enabled = 	$this->getVar("copyLinkEnabled");
$id =				$t_object->get('ca_objects.object_id');
$show_nav = 		($this->getVar("previousLink") || $this->getVar("resultsLink") || $this->getVar("nextLink")) ? true : false;
$map_options = $this->getVar('mapOptions') ?? [];
switch($table){
	case "ca_entities":
		$id = $t_object->get('ca_entities.entity_id');
		$last_advanced_search = ResultContextStorage::getVar('result_last_context_ca_entities_action');		
		
	break;
	# ------------------------------------------------
	case "ca_occurrences":
		$id = $t_object->get('ca_occurrences.occurrence_id');
		$last_advanced_search = ResultContextStorage::getVar('result_last_context_ca_occurrences_action');		
		
	break;
	# ------------------------------------------------
	case "ca_objects":
		$id = $t_object->get('ca_objects.object_id');
		$last_advanced_search = ResultContextStorage::getVar('result_last_context_ca_objects_action');		
		if(!$last_advanced_search){
			$last_advanced_search = "combined";
		}
	break;
	# ------------------------------------------------
}

?>
<script>
	pawtucketUIApps['geoMapper'] = <?= json_encode($map_options); ?>;
</script>

  <div id="bottom-search-nav">
	<nav class="nav-icons mb-2 mb-md-0" aria-label="bottom search results">
		<ul class="nav">
			<li>
<?php
				print caNavLink($this->request, "<i class='bi bi-house-door-fill' aria-label='Home' title='Home'></i>", "", "", "", "");
?>
			</li>
			<li>
<?php
				print caNavLink($this->request, "<i class='bi bi-search' aria-label='search' title='Back to Search Form'></i>", "", "Search", "advanced", $last_advanced_search);
?> 			
			</li>
			<li>
				{{{resultsLink}}}
			</li>
			<li>
				{{{previousLink}}}
			</li>
			<li>
				{{{nextLink}}}
			</li>
			<li>
				<a href="#h0" aria-label="page up" title="back to Bottom"><i class="bi bi-chevron-double-up"></i></a>
			</li>
			<li>
				<a href="https://clerk.seattle.gov/search/help/" aria-label="help" title="Help"><i class="bi bi-question-lg"></i></a>
			</li>
		</ul>
	</nav>
  </div>
  <a id="hb" role="button" aria-label="anchor"></a>
