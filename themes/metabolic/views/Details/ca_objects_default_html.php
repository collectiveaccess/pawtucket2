<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Details/ca_objects_default_html.php : 
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2021 Whirl-i-Gig
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
 
	$t_object = 			$this->getVar("item");
	$t_parent = new ca_objects($t_object->get('parent_id'));
	
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$vn_download_all_enabled = 		$this->getVar("downloadAllEnabled");
	$va_download_all_types = 		$this->getVar("downloadAllTypes");
	$vn_inquire_enabled = 	$this->getVar("inquireEnabled");
	$vn_id =				$t_object->get('ca_objects.object_id');
	$va_access_values = 	caGetUserAccessValues();
	$vn_representation_id = $this->getVar("representation_id");
	$va_representation_tags = $this->getVar("representation_tags");
	$va_config_options = 	$this->getVar("config_options");


	MetaTagManager::addMetaProperty("og:url", $this->request->config->get("site_host").caNavUrl("*", "*", "*"));
	MetaTagManager::addMetaProperty("og:title", ($va_config_options["og_title"]) ? $t_object->getWithTemplate($va_config_options["og_title"]) : $t_object->get("ca_objects.preferred_labels.name"));
	MetaTagManager::addMetaProperty("og:type", ($va_config_options["og_type"]) ? $va_config_options["og_type"] : "website");
	if($va_config_options["og_description"] && ($vs_tmp = $t_object->getWithTemplate($va_config_options["og_description"]))){
		MetaTagManager::addMetaProperty("og:description", htmlentities(strip_tags($vs_tmp)));
	}
	if($vs_tmp = $va_config_options["fb_app_id"]){
		MetaTagManager::addMetaProperty("fb:app_id", $vs_tmp);
	}
	if($vs_rep = $t_object->get("ca_object_representations.media.page.url", array("checkAccess" => $va_access_values))){
		MetaTagManager::addMetaProperty("og:image", $vs_rep);
		MetaTagManager::addMetaProperty("og:image:width", $t_object->get("ca_object_representations.media.page.width"));
		MetaTagManager::addMetaProperty("og:image:height", $t_object->get("ca_object_representations.media.page.height"));
	}
	if($this->request->isLoggedIn() && $this->request->user->hasRole("frontendRestricted")) {
?>

<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v6.0&appId=2210553328991338&autoLogAppEvents=1"></script>
<?php
	}
?>
<div class="row borderBottom">
	<div class='col-sm-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2 pt-5 pb-2'>
		{{{<ifdef code="ca_objects.preferred_labels.name"><H1>^ca_objects.preferred_labels.name</H1></ifdef>}}}
	</div>
</div>
<div class="row">
	<div class='col-12 navTop text-center'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='navLeftRight text-left col-sm-1 col-lg-2'>
<?php
	if($this->getVar("resultsLink") || $this->getVar("previousLink")){
?>
		<div class="detailNavBgLeft">
			{{{resultsLink}}}<br/>{{{previousLink}}}
		</div><!-- end detailNavBgLeft -->
<?php
	}
?>
	</div><!-- end col -->
	<div class='col-12 col-sm-10 col-md-10 col-lg-8'>
<?php
	if($this->request->isLoggedIn() && $this->request->user->hasRole("frontendRestricted")) {
?>
		<div id='detailShareButtons' class="mt-2">
			<div class='detailShareButton'>
				<div class="fb-share-button" data-href="<?= $this->request->config->get("site_host").caNavUrl("*", "*", "*"); ?>" data-layout="button" data-size="small"><a target="_blank" href="<?= $this->request->config->get("site_host").caNavUrl("*", "*", "*"); ?>" class="fb-xfbml-parse-ignore">Share</a></div>
			</div>
		</div>
<?php
	}
			# Comment/inquire/download pdf/lightbox
			if ($vn_pdf_enabled || $vn_inquire_enabled || $vn_download_all_enabled || caDisplayLightbox($this->requests)) {
					
				print '<div id="detailTools" class="mt-2">';
				if ($vn_pdf_enabled || $vn_download_all_enabled) {
					print "<div class='detailTool'><div class='dropdown'><a class='dropdown-toggle' role='button' id='DownloadButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><ion-icon name='download'></ion-icon> Download</a>";
					print "<div class='dropdown-menu' aria-labelledby='DropdownButton'>";
					if($vn_pdf_enabled){
						print caDetailLink("Download PDF Summary", "dropdown-item", "ca_objects",  $vn_id, array("view" => "pdf", "export_format" => "_pdf_ca_objects_summary"));
					}
					if($vn_download_all_enabled){
						if(is_array($va_download_all_types) && sizeof($va_download_all_types)){
							foreach($va_download_all_types as $vs_dl_name => $vs_dl_type){
								print caNavLink("Download ".$vs_dl_name, "dropdown-item", "", "Detail", "DownloadMedia", array("object_id" => $vn_id, "download_type" => $vs_dl_type, "download" => 1, "exclude_ancestors" => 1));
							}
						}
						#print caNavLink("Download Original", "dropdown-item", "", "Detail", "DownloadMedia", array("object_id" => $vn_id, "version" => "original", "download" => 1));
					}
					print "</div></div></div>";
				}
				if ($vn_inquire_enabled) {
					print "<div class='detailTool'>".caNavLink("<ion-icon name='ios-mail'></ion-icon> <span>Inquire</span>", "", "", "Contact", "form", array("table" => "ca_objects", "id" => $vn_id))."</div>";
				}
				if(caDisplayLightbox($this->requests) && $this->request->isLoggedIn()){
					print "<div class='detailTool'><div id='lightboxManagement'></div></div>";
				}
				$vs_email_subject = rawurlencode("Share from: aliceb.metabolicstudio.org");
				$vs_email_body = rawurlencode($t_object->getWithTemplate("<ifdef code='ca_objects.preferred_labels.name'>^ca_objects.preferred_labels.name\n</ifdef><ifdef code='ca_objects.idno'>^ca_objects.idno\n\n</ifdef>").$this->request->config->get("site_host").caNavUrl("*", "*", "*"));
				print "<div class='detailTool'><a title='Share via e-mail' href='mailto:?body=".$vs_email_body."&subject=".$vs_email_subject."'><ion-icon name='ios-mail'></ion-icon> <span>E-mail</span></a></div>";
				print "<div class='detailTool'><a title='Copy URL' href='#' onClick='copyUrl(); return false;' class='detailCopy'><ion-icon name='ios-link'></ion-icon> <span>Copy URL</span></a></div>";
				print '</div><!-- end detailTools -->';

			}				

?>
				<div id="mediaDisplay" class="detailPrimaryMedia mt-3">
					<!-- MediaViewer.js React app goes here -->
				</div>
				
				<HR></HR>
				<div class="row">
					<div class="col-12 col-md-12 text-center metapoetics">
					<?= strip_tags($t_object->get('ca_objects.metapoetics.metapoetics_text'), '<b><em><i><strong><ul><ol><li><blockquote><u><s><sup><sub>'); ?>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-md-6">
						{{{<ifdef code="ca_objects.parent_id">
							<div class="mb-3">
								<div class="label">Part of Album</div>
								<unit relativeTo="ca_objects.parent"><l>^ca_objects.preferred_labels.name</l></unit>
							</div>
						</ifdef>}}}
						{{{<ifdef code="ca_objects.date">
							<div class="mb-3">
								^ca_objects.date%delimiter=,_
							</div>
						</ifdef>}}}
						{{{<ifdef code="ca_objects.parent.date">
							<div class="mb-3">
								^ca_objects.parent.date%delimiter=,_
							</div>
						</ifdef>}}}
						{{{<ifdef code="ca_objects.description">
							<div class="mb-3">
								^ca_objects.description
							</div>
						</ifdef>}}}
						{{{<ifdef code="ca_objects.url">
							<div class="mb-3">
								<unit relativeTo="ca_objects.url" delimiter="<br/>"><a href="^ca_objects.url" target="_blank">^ca_objects.url</a> <ion-icon name="open"></ion-icon></unit>
							</div>
						</ifcount>}}}


						{{{<ifdef code="ca_objects.dimensions.dim_width|ca_objects.dimensions.dim_height|ca_objects.dimensions.dim_depth">
							<div class="mb-3">
								<div class="label">Dimensions</div>
								<unit relativeTo="ca_objects.dimensions" delimiter="; ">^dim_width x ^dim_height<ifdef code='dim_depth'> x ^dim_depth</ifdef><ifdef code='note'>(^note)</ifdef></unit>
							</div>
						</ifdef>}}}
					</div>
					<div class="col-12 col-md-6">
											
<!--						{{{<ifcount code="ca_occurrences" restrictToTypes="exhibition" min="1">
							<div class="mb-3">
								<div class="label">Exhibitions</div>
								<unit relativeTo="ca_occurrences" restrictToTypes="exhibition" delimiter="<br/><br/>">
									<l>^ca_occurrences.preferred_labels.name</l><case><ifcount code="ca_entities" restrictToTypes="org" restrictToRelationshipTypes="venue" min="1"><br/></ifcount><ifdef code="ca_occurrences.date"><br/></ifdef></case><ifcount code="ca_entities" restrictToTypes="org" restrictToRelationshipTypes="venue" min="1"><unit relativeTo="ca_entities" restrictToTypes="org" restrictToRelationshipTypes="venue" delimiter=", ">^ca_entities.preferred_labels</unit><ifdef code="ca_occurrences.date">, </ifdef></ifcount><ifdef code="ca_occurrences.date">^ca_occurrences.date</ifdef>
								</unit>
							</div>
						</ifcount>}}}-->

<!--						{{{<ifcount code="ca_collections" min="1">
							<div class="mb-3">
								<div class="label">Action<ifcount code="ca_collections" min="2">s</ifcount></div>
								<unit relativeTo="ca_collections" delimiter=", "><l>^ca_collections.preferred_labels.name</l></unit>
							</div>
						</ifcount>}}}

						{{{<ifcount code="ca_occurrences" restrictToTypes="action" min="1">
							<div class="mb-3">
								<div class="label">Event<ifcount code="ca_occurrences" restrictToTypes="action" min="2">s</ifcount></div>
								<unit relativeTo="ca_occurrences" restrictToTypes="action" delimiter=", "><l>^ca_occurrences.preferred_labels.name</l></unit>
							</div>
						</ifcount>}}}
-->
<?php
						$colls = $t_object->get("ca_collections", array("returnWithStructure" => true, "checkAccess" => $va_access_values, "sort" => "ca_collections.name"));
						
						if($t_parent->isLoaded()) { 
							$colls += $t_parent->get("ca_collections", array("returnWithStructure" => true, "checkAccess" => $va_access_values, "sort" => "ca_collection_labels.name"));
						}
						
						$coll_links = [];
						if(is_array($colls) && sizeof($colls)){
							foreach($colls as $coll){
								$coll_links[] = caDetailLink($coll['name'], '', 'ca_collections', $coll['collection_id']);
							}
						}
						if(sizeof($coll_links)) {
?>
							<div class="mb-3">
								<div class="label">Actions</div>
								<?= join($coll_links, ", "); ?>
							</div>
<?php
						}


						foreach(['action' => 'Events', 'exhibition' => 'Exhibitions', 'lecture_presentation' => 'Lectures/Presentations', 'publication' => 'Publications'] as $occ_type => $occ_typename) {
							$occs = $t_object->get("ca_occurrences", array("restrictToTypes" => [$occ_type], "returnWithStructure" => true, "checkAccess" => $va_access_values, "sort" => "ca_occurrences.name"));
						
							if($t_parent->isLoaded()) { 
								$occs += $t_parent->get("ca_occurrences", array("restrictToTypes" => [$occ_type], "returnWithStructure" => true, "checkAccess" => $va_access_values, "sort" => "ca_occurrence_labels.name"));
							}
						
							$occ_links = [];
							if(is_array($occs) && sizeof($occs)){
								foreach($occs as $occ){
									$occ_links[] = "<p>".caDetailLink($occ['name'], '', 'ca_occurrences', $occ['occurrence_id'])."</p>";
								}
							}
							if(sizeof($occ_links)) {
	?>
								<div class="mb-3">
									<div class="label"><?= $occ_typename; ?></div>
									<?= join($occ_links, ""); ?>
								</div>
	<?php
							}
						}


						# --- rel entities by role
						$va_entities = $t_object->get("ca_entities", array("returnWithStructure" => true, "checkAccess" => $va_access_values, "sort" => "ca_entity_labels.surname"));
						
						if($t_parent->isLoaded()) { 
							$va_entities += $t_parent->get("ca_entities", array("returnWithStructure" => true, "checkAccess" => $va_access_values, "sort" => "ca_entity_labels.surname"));
						}
						if(is_array($va_entities) && sizeof($va_entities)){
							$va_entities_by_role = array();
							$va_visionary = array();
							foreach($va_entities as $va_entity_info){
								if(strToLower($va_entity_info["relationship_typename"]) == "visionary"){
									$va_visionary[] = caNavLink($va_entity_info["displayname"], "", "", "Browse", "objects", array("facet" => "entity_facet", "id" => $va_entity_info["entity_id"]));
								}else{
									$va_entities_by_role[$va_entity_info["relationship_typename"]][] = caNavLink($va_entity_info["displayname"], "", "", "Browse", "objects", array("facet" => "entity_facet", "id" => $va_entity_info["entity_id"]));
								}
							}
							if(sizeof($va_visionary)){
?>
								<div class="mb-3">
									<div class="label">Visionary</div>
<?php
									print join($va_visionary, ", ");
?>
								</div>
<?php
								
							}
							ksort($va_entities_by_role);
							foreach($va_entities_by_role as $vs_role => $va_names){
?>
								<div class="mb-3">
									<div class="label"><?= $vs_role; ?></div>
<?php
									print join($va_names, ", ");
?>
								</div>
<?php
							}
						}
						
						# --- bio-regions
						$t_list_item = new ca_list_items();
						$va_bio_regions = $t_object->get("ca_objects.bio_regions", array("returnAsArray" => true, "checkAccess" => $va_access_values));
						if($t_parent->isLoaded()) { 
							$va_bio_regions += $t_parent->get("ca_objects.bio_regions", array("returnAsArray" => true, "checkAccess" => $va_access_values));
						}
						
						if(is_array($va_bio_regions) && sizeof($va_bio_regions)){
?>
							<div class="mb-3">
								<div class="label">Bio-Regions <span class="material-icons" role="button" data-toggle="collapse" data-target="#bioRegionDesc" aria-expanded="false" aria-controls="bioRegionDesc">info</span></div>
								<div class="mb-3 collapse small" id="bioRegionDesc">
								  A region defined by characteristics of the natural environment rather than man-made division.
								</div>
<?php
								$va_bio_region_links = array();
								foreach($va_bio_regions as $vn_bio_region_id){
									$t_list_item->load($vn_bio_region_id);
									$va_bio_region_links[] = caNavLink($t_list_item->get("ca_list_item_labels.name_singular"), "", "", "Browse", "objects", array("facet" => "bio_regions_facet", "id" => $vn_bio_region_id));
								}
								print join($va_bio_region_links, ", ");
?>
							</div>
<?php								
							

						}
						# --- subjects
						$t_list_item = new ca_list_items();
						$va_subjects = $t_object->get("ca_objects.subject", array("returnAsArray" => true));
						if($t_parent->isLoaded()) { 
							$va_subjects += $t_parent->get("ca_objects.subject", array("returnAsArray" => true));
						}
						if(is_array($va_subjects) && sizeof($va_subjects)){
?>
							<div class="mb-3">
								<div class="label">Themes</H1></div>
<?php
								$va_subject_links = array();
								foreach($va_subjects as $vn_subject_id){
									$t_list_item->load($vn_subject_id);
									if(in_array($t_list_item->get("ca_list_items.access"), $va_access_values)){
										$va_subject_links[] = caNavLink($t_list_item->get("ca_list_item_labels.name_singular"), "", "", "Browse", "objects", array("facet" => "subject_facet", "id" => $vn_subject_id));
									}
								}
								print join($va_subject_links, ", ");
?>
							</div>
<?php
							$related_links = array();
							$related = $t_object->getRelatedItems('ca_objects', ['returnAs' => 'ids', 'checkAccess' => $va_access_values]);
							
							if($t_parent->isLoaded()) { 
								$related += $t_parent->getRelatedItems('ca_objects', ['returnAs' => 'ids', 'checkAccess' => $va_access_values]);
							}
							
							
							if(is_array($related) && sizeof($related)) {
								$qr_rel = caMakeSearchResult('ca_objects', $related);
								if($qr_rel && $qr_rel->numHits()) {
?>
							<div class="mb-3">
								<div class="label">Related</H1></div>
<?php
								
								
								while($qr_rel->nextHit()) {
									$related_links[] =  caDetailLink($qr_rel->get('ca_objects.idno'), '', 'ca_objects', $qr_rel->getPrimaryKey()); 
								}
								
								print join($related_links, ", ");
?>
							</div>
<?php								
							}	
								}			

						}
?>

						{{{<ifdef code="ca_objects.idno">
							<div class="mb-3">
								<b>^ca_objects.idno</b>
							</div>
						</ifdef>}}}
						{{{<ifdef code="ca_objects.altID">
							<div class="mb-3">
								<b>^ca_objects.altID</b>
							</div>
						</ifdef>}}}
						
					</div>
				</div>


<!------------------------------------>

	<?php
		# Comment
		if ($vn_comments_enabled) {
?>				
			<div id='commentForm'> </div>

			<!-- <div class="detailTool mb-2"> -->
				<!-- <h2><b><?= sizeof($va_comments); ?> Comments</b></h2> -->
				<!-- <ion-icon name="chatboxes"></ion-icon> 
				<span>Comments and Tags (<?= sizeof($va_comments) + sizeof($va_tags); ?>)</span> -->
			<!-- </div> -->
			<!-- <div id='detailComments' class='px-2 py-2' style=" width: 100%; max-height: 300px; box-shadow: 2px 2px 2px 2px #D8D7CE; overflow: auto"> -->
				<!-- <?= $this->getVar("itemComments");?> -->
			<!-- </div> -->
<?php				
		}
?>

<!------------------------------------>


	</div><!-- end col -->
	<div class='navLeftRight text-right col-sm-1 col-lg-2'>
<?php
	if($this->getVar("nextLink")){
?>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
<?php
	}
?>
	</div><!-- end col -->
</div><!-- end row -->
<?php
	$vs_related_title = "";
	# --- related_items - if item is part of an album, show the other siblings otherwise show some other items from the current object's action(ca_collection)
	$va_related_item_ids = array();
	if($vn_parent_id = $t_object->get("ca_objects.parent_id")){
		$t_parent = new ca_objects($vn_parent_id);
		$va_related_item_ids = $t_parent->get("ca_objects.children.object_id", array("returnWithStructure" => true, "checkAccess" => $va_access_values));
		$vs_related_title = $t_parent->get("ca_objects.preferred_labels.name");
	}else{
		if($va_projects = $t_object->get("ca_collections.collection_id", array("returnWithStructure" => true, "checkAccess" => $va_access_values))){
			$q_projects = caMakeSearchResult("ca_collections", $va_projects);
			if($q_projects->numHits()){
				while($q_projects->nextHit()){
					$va_related_item_ids = $va_related_item_ids + $q_projects->get("ca_objects.object_id", array("returnWithStructure" => true, "checkAccess" => $va_access_values));
				}
			}
			$vs_related_title = "Other items from this action";
		}
	
	}
	# --- remove current item
	if(in_array($vn_id, $va_related_item_ids)){
		$vn_key = array_search($vn_id, $va_related_item_ids);
		unset($va_related_item_ids[$vn_key]);
	}
	$va_related_items = array();
	if(sizeof($va_related_item_ids)){
		shuffle($va_related_item_ids);
		$q_objects = caMakeSearchResult("ca_objects", $va_related_item_ids);
?>
		<div class="row mt-3">
			<div class="col-7 mt-5">
				<H1><?= $vs_related_title; ?></H1>
			</div>
			<div class="col-5 mt-5 text-right">
<?php
				if($t_object->get("ca_objects.parent_id")){
					print caDetailLink("View Album", "btn btn-primary", "ca_objects", $t_object->get("ca_objects.parent_id"));			
				}
?>
			</div>
		</div>
		<div class="row mb-5">
<?php
			$va_tmp_ids = array();
			$i = 0;
			while($q_objects->nextHit()){
				if($q_objects->get("ca_object_representations.media.widepreview")){
					print "<div class='col-sm-6 col-md-4 col-lg-4 col-xl-2 pb-4 mb-4'>";
					print $q_objects->getWithTemplate("<l>^ca_object_representations.media.widepreview</l>");
					print "<div class='pt-2'>".$q_objects->getWithTemplate("<if rule='^ca_objects.type_id =~ /Album/'>Album: </if>").substr(strip_tags($q_objects->get("ca_objects.idno")), 0, 30);
					
					if($alt_id = $q_objects->get('ca_objects.altID')) {
						print " (".substr(strip_tags($alt_id), 0, 30).")";
					}
					if($album_title = $q_objects->getWithTemplate("<if rule='^ca_objects.type_id =~ /Album/'><br/><l>^ca_objects.preferred_labels.name</l></if>")){
						print $album_title;
					}
					
					print "</div>";
					
					
					print "</div>";
					$i++;
					$va_tmp_ids[] = $q_objects->get("ca_objects.object_id");
				}
				if($i == 12){
					break;
				}
			}
		}
?>
		</div>

<?php
	if($this->request->isLoggedIn()) {
?>

<script type="text/javascript">
    pawtucketUIApps['LightboxManagement'] = {
        'selector': '#lightboxManagement',
				'key': '<?= $this->getVar('key'); ?>', 
        'data': {
          baseUrl: "<?= __CA_URL_ROOT__."/service.php"; ?>",
					lightboxes: <?= json_encode($this->getVar('lightboxes')); ?>,
					table: 'ca_objects',
					id: <?= (int)$vn_id; ?>,
        	lightboxTerminology: <?= json_encode(caGetLightboxDisplayName()); ?>
        }
    };
</script>
<?php
	}
?>

<script type="text/javascript">	
	// pawtucketUIApps['PawtucketComment'] = {

	pawtucketUIApps['Comment'] = {
			'selector': '#commentForm',
			'key': '<?= $this->getVar('key'); ?>',
			'baseUrl': 'http://metabolic3.whirl-i-gig.com:8085/service.php/UserGeneratedContent',
			'searchUrl': 'http://metabolic3.whirl-i-gig.com:8085/index.php/MultiSearch/Index/search/',
			'data': {
					item_id: <?= $vn_id; ?>,
					tablename: 'ca_objects',
					show_form: <?= ($this->request->isLoggedIn()) ? "true" : "false"; ?>,
					login_button_text: 'Login to Add Your Comment',
					comment_button_text: 'Comment',

					form_title: '<span>Add Your Comment</span>',
					list_title: '<span class="mt-5">Comments</span>',
					tag_field_title: 'Tags',
					comment_field_title: 'Comment',
					no_tags: true,
			},
  };

	pawtucketUIApps['MediaViewer'] = {
			'selector': '#mediaDisplay',
			'media': <?= caGetMediaViewerDataForRepresentations($t_object, 'detail', ['asJson' => true, 'checkAccess' => $va_access_values]); ?>,
			'width': '800px',
			'height': '500px',
			'controlHeight': '72px',
			'data': {
			
			}
	};
    
</script>

<script type="text/javascript">	
	function copyUrl() {
		if (!window.getSelection) {
			alert('Please copy the URL from the location bar.');
			return;
		}
		const dummy = document.createElement('p');
		dummy.textContent = window.location.href;
		document.body.appendChild(dummy);

		const range = document.createRange();
		range.setStartBefore(dummy);
		range.setEndAfter(dummy);

		const selection = window.getSelection();
		// First clear, in case the user already selected some other text
		selection.removeAllRanges();
		selection.addRange(range);

		document.execCommand('copy');
		document.body.removeChild(dummy);
	}
</script>
