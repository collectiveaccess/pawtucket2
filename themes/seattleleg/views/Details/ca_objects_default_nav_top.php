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

$last_modified = $t_object->get("ca_objects.lastmodified");
$created = $t_object->get("ca_objects.created");

$email_subject = $t_object->get("type_id", ['convertCodesToDisplayText' => true]);
$email_body;

?>
<script>
	pawtucketUIApps['geoMapper'] = <?= json_encode($map_options); ?>;
</script>

	<a id="h0"></a>
  <h3>City of Seattle Combined Legislative Records Search</h3>
  <em>Information modified on <?= $last_modified; ?></em> <em><?= $created; ?></em>
  <hr>

  <div id="top-search-nav" class="d-md-flex d-md-inline-block justify-content-between">

		<div class="nav-icons mb-2 mb-md-0">
			<a href="/" aria-label="home">
				<i class="bi bi-house-door-fill"></i>
			</a>
			<a href="/index.php/Search/advanced/combined" aria-label="search">
				<i class="bi bi-search"></i>
			</a>
			
			<a href="" aria-label="results">{{{resultsLink}}}</a>
			<a href="" aria-label="prev">{{{previousLink}}}</a>
			<a href="" aria-label="next">{{{nextLink}}}</a>
			
			<a href="#hb" aria-label="page down">
				<i class="bi bi-chevron-double-down"></i>
			</a>
			
			<a href="https://clerk.seattle.gov/search/help/" aria-label="help">
				<i class="bi bi-question-lg"></i>
			</a>
		</div>

		<div id="link-controls">
			<div class="dropdown">
				<button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
					<i class="bi bi-link-45deg"></i> LINK <span class="caret"></span>
				</button>
				<ul class="dropdown-menu">
					<li><a class="dropdown-item" href="#" onclick="Copy();">Copy Link</a></li>
					<li>
						<a class="dropdown-item" id="emailLink" href='#'>Email Link</a>
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