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
	$vn_id =				$t_object->get('ca_objects.object_id');
	$va_access_values = 	caGetUserAccessValues();
	$vn_representation_id = $this->getVar("representation_id");
?>

<div class="row borderBottom">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1 pt-2'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}<br>{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-sm-10 col-md-10 col-lg-10 col-xl-10pt-4 pt-2 pb-2'>
		<H1 class= "text-center">{{{^ca_objects.preferred_labels.name}}}</H1>		
	</div>
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1 pt-2'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->
<div class="row">
<div class="col-sm-12 text-right">
<?php
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_pdf_enabled) {
						
					print '<div id="detailTools" class="mt-2 mb-3">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><ion-icon name="chatboxes"></ion-icon> <span>Comments and Tags (<?php print sizeof($va_comments) + sizeof($va_tags); ?>)</span></a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_pdf_enabled) {
						print "<div class='detailTool'>".caDetailLink("<ion-icon name='document'></ion-icon> <span>Download as PDF</span>", "", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
					}
					print "<div class='detailTool'>".caNavLink("<ion-icon name='ios-mail'></ion-icon> <span>Inquire</span>", "", "", "Contact", "form", array("table" => "ca_objects", "id" => $vn_id))."</div>";
					
					print '</div><!-- end detailTools -->';
				}				

?> 
</div></div>
<div class="row">
	{{{<ifdef code="ca_object_representations">
	<div class="col-sm-12 col-md-6">
		<div class="col-md-10 mx-auto">
			^ca_object_representations.media.large
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
	</div> </ifdef>}}}
	<div class="col-sm-12 col-md-6">
			{{{<h2 class="capitalize">^ca_objects.type_id ^ca_objects.idno</h2>}}}
						
			{{{<ifdef code="ca_objects.description"><h3>Description</h3>^ca_objects.description}}}
						
			{{{<ifdef code="ca_objects.creation_date" delimiter=","><h3>Date</h3>^ca_objects.creation_date}}}
						
			{{{<ifdef code="ca_objects.rights_restrictions" delimiter=","><h3 class="pt-3">Rights and Restrictions</h3>^ca_objects.rights_restrictions}}}
							
			{{{<ifcount code="ca_entities" min="1"><h3 class="pt-3">People</h3>
					<div class="bright"><unit relativeTo="ca_entities" delimiter=", "><span class="capitalize">^relationship_typename </span><l>^ca_entities.preferred_labels</l></unit></div></ifcount>}}}
		
			{{{<ifcount code="ca_occurrences" min="1"><h3 class="pt-3">Stage Productions</h3>
					<unit relativeTo="ca_occurrences" restrictToTypes="productions" delimiter="<br>"><div class="bright"><l>^ca_occurrences.preferred_labels</l></div></unit></ifcount>}}}
	</div>
</div>

						
	</div><!-- end col -->
</div>
<div class="row">
	<div class="col-sm-12">
<?php
	# --- related_items
	$va_related_items = array();
	$va_related_item_ids = $t_object->get("ca_objects.object_id", array("returnAsArray" => true, "checkAccess" => $va_access_values));
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
<!-- {{{<ifdef code="ca_objects" min="2"> -->
	<div class="row mt-3">
		<div class="col-sm-12">
			<H2>Related Items</H2>
				<div class="row">	
<?php
		$i = 0;
		while($q_objects->nextHit()){
			if($q_objects->get("ca_object_representations.media.large")){
				print "<div class='col-sm-6 col-md-4 col-lg-4 col-xl-3 pb-4 mb-4'>";
				print $q_objects->getWithTemplate("<l>^ca_object_representations.media.large</l>");
				print "<div class='pt-2'>".substr(strip_tags($q_objects->get("ca_objects.preferred_labels.name")), 0, 100)."</div>";
				print "</div>";
				$i++;
			}
			if($i == 12){
				break;
			}
		}
?>
			</div>
		</div>

<?php		
	}
?>

</div>
<!-- </ifdef>}}} -->

<script type="text/javascript">	
	// pawtucketUIApps['expandandscroll'] = {
//         'selector': '.viewAll'
//     };
</script>