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
	$vn_inquire_enabled = 	$this->getVar("inquireEnabled");
	$vn_id =				$t_object->get('ca_objects.object_id');
	$va_access_values = 	caGetUserAccessValues();
	$vn_representation_id = $this->getVar("representation_id");
?>
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
<?php
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_pdf_enabled) {
						
					print '<div id="detailTools" class="mt-2">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><ion-icon name="chatboxes"></ion-icon> <span>Comments and Tags (<?php print sizeof($va_comments) + sizeof($va_tags); ?>)</span></a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_pdf_enabled) {
						print "<div class='detailTool'>".caDetailLink("<ion-icon name='document'></ion-icon> <span>Download as PDF</span>", "", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
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
					<div class="col-12 col-md-6">
						<div class="mb-3">
							<div class="label">Title</div>
							{{{^ca_objects.preferred_labels.name}}}
						</div>
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
						{{{<ifdef code="ca_objects.item_subtype">
							<div class="mb-3">
								<div class="label">Type</div>
								^ca_objects.item_subtype
							</div>
						</ifdef>}}}
						{{{<ifcount code="ca_collections" min="1">
							<div class="mb-3">
								<div class="label">Project<ifcount code="ca_collections" min="2">s</ifcount></div>
								<unit relativeTo="ca_collections" delimiter=", "><l>^ca_collections.preferred_labels.name</l></unit>
							</div>
						</ifcount>}}}
						{{{<ifdef code="ca_objects.phase">
							<div class="mb-3">
								<div class="label">Phase</div>
								^ca_objects.phase%delimiter=,_
							</div>
						</ifdef>}}}
					</div>
					<div class="col-12 col-md-6">
						
						
						{{{<ifcount code="ca_occurrences" restrictToTypes="exhibition" min="1">
							<div class="mb-3">
								<div class="label">Exhibitions</div>
								<unit relativeTo="ca_occurrences" restrictToTypes="exhibition" delimiter=", "><l>^ca_occurrences.preferred_labels.name</l></unit>
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
				print "<div class='pt-2'>".substr(strip_tags($q_objects->get("ca_objects.idno")), 0, 30)."</div>";
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
		$o_context->setAsLastFind();
		$o_context->setResultList($va_tmp_ids);
		$o_context->saveContext();
	}
?>

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
			id: <?php print (int)$vn_id; ?>
        }
    };
</script>
<?php
	}
?>