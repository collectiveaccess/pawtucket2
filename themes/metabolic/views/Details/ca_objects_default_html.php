<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Details/ca_objects_default_html.php : 
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2019 Whirl-i-Gig
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
#	foreach($va_representation_tags as $vs_representation_tag){
#		print $vs_representation_tag;
#	}
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
?>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v6.0&appId=2210553328991338&autoLogAppEvents=1"></script>
<div class="row borderBottom">
	<div class='col-sm-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2 pt-5 pb-2'>
		<H1>{{{^ca_objects.idno}}}</H1>
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
		<div id='detailShareButtons' class="mt-2">
			<div class='detailShareButton'>
				<div class="fb-share-button" data-href="<?php print $this->request->config->get("site_host").caNavUrl("*", "*", "*"); ?>" data-layout="button" data-size="small"><a target="_blank" href="<?php print $this->request->config->get("site_host").caNavUrl("*", "*", "*"); ?>" class="fb-xfbml-parse-ignore">Share</a></div>
			</div>
		</div>
<?php
				# Comment/inquire/download pdf/lightbox
				if ($vn_comments_enabled || $vn_pdf_enabled || $vn_inquire_enabled || $vn_download_all_enabled || caDisplayLightbox($this->requests)) {
						
					print '<div id="detailTools" class="mt-2">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><ion-icon name="chatboxes"></ion-icon> <span>Comments and Tags (<?php print sizeof($va_comments) + sizeof($va_tags); ?>)</span></a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_pdf_enabled || $vn_download_all_enabled) {
						print "<div class='detailTool'><div class='dropdown'><a class='dropdown-toggle' role='button' id='DownloadButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><ion-icon name='download'></ion-icon> Download</a>";
						print "<div class='dropdown-menu' aria-labelledby='DropdownButton'>";
						if($vn_pdf_enabled){
							print caDetailLink("Download as PDF", "dropdown-item", "ca_objects",  $vn_id, array("view" => "pdf", "export_format" => "_pdf_ca_objects_summary"));
						}
						if($vn_download_all_enabled){
							if(is_array($va_download_all_types) && sizeof($va_download_all_types)){
								foreach($va_download_all_types as $vs_dl_name => $vs_dl_type){
									print caNavLink("Download ".$vs_dl_name, "dropdown-item", "", "Detail", "DownloadMedia", array("object_id" => $vn_id, "download_type" => $vs_dl_type, "download" => 1));
								}
							}
							#print caNavLink("Download Original", "dropdown-item", "", "Detail", "DownloadMedia", array("object_id" => $vn_id, "version" => "original", "download" => 1));
						}
						print "</div></div></div>";
					}
					if ($vn_inquire_enabled) {
						print "<div class='detailTool'>".caNavLink("<ion-icon name='ios-mail'></ion-icon> <span>Inquire</span>", "", "", "Contact", "form", array("table" => "ca_objects", "id" => $vn_id))."</div>";
					}
					if($this->request->isLoggedIn()){
						print "<div class='detailTool'><div id='lightboxManagement'></div></div>";
					}
					print '</div><!-- end detailTools -->';
				}				

?>
				<div class="detailPrimaryMedia mt-3">
					{{{^ca_object_representations.media.page}}}
				</div>
<?php 
				$va_representations = $t_object->getRepresentations(array("iconlarge", "large"), null, array("checkAccess" => $va_access_values));
				if(is_array($va_representations) && sizeof($va_representations) > 1){
					print "<div class='detailAllMediaThumbs pt-2'><a data-toggle='collapse' href='#detailMediaAll' role='button' aria-expanded='false' aria-controls='Show all media'>";
					print $t_object->getWithTemplate("<unit relativeTo='ca_object_representations' filterNonPrimaryRepresentations='0' delimiter=' ' length='6'>^ca_object_representations.media.icon</unit>");
					print " <ion-icon name='apps'></ion-icon> <small>"._t("View All %1", sizeof($va_representations))."</small></a>";
					//print "<span class='viewAll' data-text='View all!' data-target='#detailMediaAll'/>";
					print "</div>";
					print "<div id='detailMediaAll' class='collapse detailMediaAll py-4'>";
					$i = 0;
					foreach($va_representations as $vn_rep_id => $va_representation){
						if($vn_rep_id != $vn_representation_id){
							if($i == 0){
								print "<div class='row'>";
							}
						
							print "<div class='col-sm-12 col-md-6 py-4 align-middle detailMediaAllItem'>".$va_representation["tags"]["large"]."</div>";					
							$i++;
							if($i == 2){
								print "</div>";
								$i = 0;
							}
						}
					}
					if($i > 0){
						print "</div>";
					}
					print "</div>";
				}
?>
				
				<HR></HR>
				<div class="row">
					<div class="col-12 col-md-12 text-center metapoetics">
					<?= strip_tags($t_object->get('ca_objects.metapoetics.metapoetics_text'), '<b><em><i><strong><ul><ol><li><blockquote><u><s><sup><sub>'); ?>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-md-6">
<?php
						$vs_title = $t_object->get("ca_objects.preferred_labels.name");
						if($vs_title && (strToLower($vs_title) != "[no title]") && (strToLower($vs_title) != "[blank]")){
?>
							<div class="mb-3">
								<div class="label">Title</div><?php print $vs_title; ?>
							</div>
<?php							
						}
?>
						{{{<ifdef code="ca_objects.altID">
							<div class="mb-3">
								<div class="label">Alternate Identifier</div>
								^ca_objects.altID
							</div>
						</ifdef>}}}
						{{{<ifdef code="ca_objects.date">
							<div class="mb-3">
								<div class="label">Date</div>
								^ca_objects.date%delimiter=,_
							</div>
						</ifdef>}}}
						{{{<ifdef code="ca_objects.dim_width|ca_objects.dim_height|ca_objects.dim_depth|ca_objects.note">
							<div class="mb-3">
								<div class="label">Dimensions</div>
								<unit relativeTo="ca_objects.dimensions" delimiter="; ">^dim_width x ^dim_height<ifdef code='dim_depth'> x ^dim_depth</ifdef><ifdef code='note'>(^note)</ifdef></unit>
							</div>
						</ifdef>}}}
						{{{<ifcount code="ca_collections" min="1">
							<div class="mb-3">
								<div class="label">Project<ifcount code="ca_collections" min="2">s</ifcount></div>
								<unit relativeTo="ca_collections" delimiter=", "><l>^ca_collections.preferred_labels.name</l></unit>
							</div>
						</ifcount>}}}
					</div>
					<div class="col-12 col-md-6">
						
						
						{{{<ifcount code="ca_occurrences" restrictToTypes="exhibition" min="1">
							<div class="mb-3">
								<div class="label">Exhibitions</div>
								<unit relativeTo="ca_occurrences" restrictToTypes="exhibition" delimiter=", ">
									<l>^ca_occurrences.preferred_labels.name</l><case><ifcount code="ca_entities" restrictToTypes="org" restrictToRelationshipTypes="venue" min="1"><br/></ifcount><ifdef code="ca_occurrences.date"><br/></ifdef></case><ifcount code="ca_entities" restrictToTypes="org" restrictToRelationshipTypes="venue" min="1"><unit relativeTo="ca_entities" restrictToTypes="org" restrictToRelationshipTypes="venue" delimiter=", ">^ca_entities.preferred_labels</unit><ifdef code="ca_occurrences.date">, </ifdef></ifcount><ifdef code="ca_occurrences.date">^ca_occurrences.date</ifdef>
								</unit>
							</div>
						</ifcount>}}}
						{{{<ifcount code="ca_occurrences" restrictToTypes="action" min="1">
							<div class="mb-3">
								<div class="label">Actions</div>
								<unit relativeTo="ca_occurrences" restrictToTypes="action" delimiter=", "><l>^ca_occurrences.preferred_labels.name</l></unit>
							</div>
						</ifcount>}}}
						{{{<ifcount code="ca_entities" min="1">
							<div class="mb-3">
								<div class="label">People/Organizations</div>
								<unit relativeTo="ca_entities" delimiter=", ">^ca_entities.preferred_labels</unit>
							</div>
						</ifcount>}}}
<?php
						$va_tags = $t_object->getTags();
						if(is_array($va_tags) && sizeof($va_tags)){
							$va_tags_processed = array();
							foreach($va_tags as $va_tag){
								$va_tags_processed[$va_tag["tag_id"]] = $va_tag["tag"];
							}
?>
							<div class="mb-3">
								<div class="label">Tags</div>
								<unit relativeTo="ca_item_tags" delimiter=", ">
<?php
									print join(", ", $va_tags_processed);
?>
								</unit>
							</div>
<?php
						}				
?>
						{{{map}}}	
					</div>
				</div>
				<div class="row">
					<div class="col-12"><HR></HR></div>
				</div>
						
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
<div class="row">
	<div class="col-sm-12">
<?php
	# --- related_items
	$va_related_items = array();
	$va_related_item_ids = $t_object->get("ca_objects.related.object_id", array("returnAsArray" => true, "checkAccess" => $va_access_values));
	if($va_projects = $t_object->get("ca_collections.collection_id", array("returnAsArray" => true, "checkAccess" => $va_access_values))){
		$q_projects = caMakeSearchResult("ca_collections", $va_projects);
		if($q_projects->numHits()){
			while($q_projects->nextHit()){
				$va_related_item_ids = $va_related_item_ids + $q_projects->get("ca_objects.object_id", array("returnAsArray" => true, "checkAccess" => $va_access_values));
				shuffle($va_related_item_ids);
			}
			# --- remove current item
			if(in_array($vn_id, $va_related_item_ids)){
				$vn_key = array_search($vn_id, $va_related_item_ids);
				unset($va_related_item_ids[$vn_key]);
			}
		}
	}
	if(sizeof($va_related_item_ids)){
		$q_objects = caMakeSearchResult("ca_objects", $va_related_item_ids);
?>
		<div class="row mt-3">
			<div class="col-sm-12 mt-5">
				<H1>Related Items</H1>
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
					print "<div class='pt-2'>".substr(strip_tags($q_objects->get("ca_objects.idno")), 0, 30);
					
					if($alt_id = $q_objects->get('ca_objects.altID')) {
						print " (".substr(strip_tags($alt_id), 0, 30).")";
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
?>
		</div>

<?php		
		$o_context = new ResultContext($this->request, 'ca_objects', 'detailRelated');
		//$o_context->setAsLastFind();
		$o_context->setResultList($va_tmp_ids);
		$o_context->saveContext();
	}
?>
	
		<div class="row mt-3">
			<div class="col-sm-12 mt-5 col-md-6 offset-md-3">
				<div id="commentForm" class="mb-5"></div>
			</div>
		</div>
	</div>
</div>
<?php
	if($this->request->isLoggedIn()) {
?>

<script type="text/javascript">
    pawtucketUIApps['LightboxManagement'] = {
        'selector': '#lightboxManagement',
        'data': {
            baseUrl: "<?php print __CA_URL_ROOT__."/index.php/Lightbox"; ?>",
			lightboxes: <?php print json_encode($this->getVar('lightboxes')); ?>,
			table: 'ca_objects',
			id: <?php print (int)$vn_id; ?>,
        	lightboxTerminology: <?php print json_encode(caGetLightboxDisplayName()); ?>
        }
    };
</script>
<?php
	}
?>
<script type="text/javascript">	
	pawtucketUIApps['PawtucketComment'] = {
        'selector': '#commentForm',
        'data': {
            item_id: <?php print $vn_id; ?>,
            tablename: 'ca_objects',
            form_title: '<h1>Add Your Comments and Tags</h1>',
            list_title: '<h1 class="mt-5">Comments and Tags</h1>',
            tag_field_title: 'Tags',
            comment_field_title: 'Comment',
            login_button_text: 'Login to Add Your Comments and Tags',
            comment_button_text: 'Send',
            no_tags: false,
            show_form: <?php print ($this->request->isLoggedIn()) ? "true" : "false"; ?>
        }
    };
</script>
