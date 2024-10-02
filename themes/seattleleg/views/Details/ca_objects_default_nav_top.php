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
$show_nav = 		($this->getVar("previousLink") || $this->getVar("resultsLink") || $this->getVar("nextLink")) ? true : false;
$map_options = $this->getVar('mapOptions') ?? [];

$last_modified = $t_object->get($table.".lastmodified");
$created = $t_object->get($table.".created");

$email_subject = $t_object->get("type_id", ['convertCodesToDisplayText' => true]);
$email_body;

$action = $this->request->getAction();

		
// print_r($action);
?>
<script>
	pawtucketUIApps['geoMapper'] = <?= json_encode($map_options); ?>;
</script>

	<a id="h0"></a>

<?php
	# committees - ca_entities
	if($table == "ca_entities"){
		$heading_text = "City Council Committee History Database";
	}elseif($table == "ca_occurrences"){
		$heading_text = "City Council Meeting History";
	}else{
		switch($last_advanced_search){
			case "combined":
			default:
				$heading_text = "City of Seattle Combined Legislative Records Search";
			break;	
			# -----------
			case "bills":
				$heading_text = "Seattle City Council Bills and Ordinances";			
			break;	
			# -----------
			case "resolutions":
				$heading_text = "Seattle City Council Resolutions";			
			break;	
			# -----------
			case "clerk":
				$heading_text = "Seattle Comptroller/Clerk Files Index Search";			
			break;	
			# -----------
			case "agenda":
				$heading_text = "Seattle City Council Committee Agendas";			
			break;	
			# -----------
			case "minutes":
				$heading_text = "Seattle City Council Minutes";			
			break;	
			# -----------
		}
	}
?>
  
  <H2 class="fs-3"><?php print $heading_text; ?></H2>
  <em>Information modified on <?= $last_modified; ?></em> <em><?= $created; ?></em>
  <hr>

  <div id="top-search-nav" class="d-md-flex justify-content-between">

		<nav class="nav-icons mb-2 mb-md-0" aria-label="top search results">
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
					<a href="#hb" aria-label="page down" title="Jump to Bottom"><i class="bi bi-chevron-double-down"></i></a>
				</li>
				<li>
					<a href="https://clerk.seattle.gov/search/help/" aria-label="help" title="Help"><i class="bi bi-question-lg"></i></a>
				</li>
			</ul>
		</nav>

		<div id="link-controls">
			<div class="dropdown">
				<button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
					<i class="bi bi-link-45deg"></i> LINK <span class="caret"></span>
				</button>
				<ul class="dropdown-menu">
					<li><a class="dropdown-item" style="font-size: 18px;" href="#" onclick="Copy();">Copy Link</a></li>
					<li>
						<a class="dropdown-item" style="font-size: 18px;" id="emailLink" href='#'>Email Link</a>
					</li>
				</ul>
			</div>
		</div>

  </div>

	<hr>

<script>

	var url = window.location.href;
	const linkElement = document.getElementById('emailLink');
	var newHref = `mailto:?subject=Your%20Subject&body=${url}`;
  linkElement.href = newHref;


	function Copy() {
		var getUrl = document.createElement('input'),
		text = window.location.href;
		document.body.appendChild(getUrl);
		getUrl.value = text;
		getUrl.select();
		document.execCommand('copy');
		document.body.removeChild(getUrl);
		$.jGrowl("Link Copied!", { life: 2000 });
	}
	
</script>