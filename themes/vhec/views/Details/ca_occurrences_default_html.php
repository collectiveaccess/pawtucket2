<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$va_access_values = 	$this->getVar('access_values');	
?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10 marginTop'>
		<div class="container">
			<div class="row">
				<div class='col-sm-6'>
				
				{{{representationViewer}}}
				
<?php
				$vs_access_point = "";				
				#Local Subject
				$va_local_subjects = $t_item->get('ca_occurrences.local_subject', array('returnAsArray' => true, 'convertCodesToDisplayText' => true));
				if (sizeof($va_local_subjects) >= 1) {
					$vn_subject = 1;
					#$vs_access_point.= "<h9>Local Access Points </h9>";
					foreach ($va_local_subjects as $va_key => $va_local_subject) {
						if ($va_local_subject == '-') { continue; }
						if ($vn_subject > 3) {
							$vs_subject_style = "class='subjectHidden'";
						}
						$vs_access_point.= "<div {$vs_subject_style}>".caNavLink($this->request, $va_local_subject, '', '', 'Search', 'objects', array('search' => "ca_objects.local_subject:'".$va_local_subject."'"))."</div>";
						
						if (($vn_subject == 3) && (sizeof($va_local_subjects) > 3)) {
							$vs_access_point.= "<a class='seeMore' href='#' onclick='$(\".seeMore\").hide();$(\".subjectHidden\").slideDown(300);return false;'>more...</a>";
						}
						$vn_subject++;
					}
				}
				if ($vs_access_point != "") {
					print "<div class='subjectBlock'>";
					print "<h8 style='margin-bottom:10px;'>Access Points</h8>";
					print $vs_access_point;
					print "</div>";
				}
?>	
				<div class='map'>{{{map}}}</div>				
				</div><!-- end col -->
				<div class='col-sm-6'>
				<H4>{{{^ca_occurrences.preferred_labels.name}}}</H4>
				<hr>
<?php
				if ($va_originating_institution = $t_item->get('ca_entities.preferred_labels', array('returnAsLink' => true, 'restrictToRelationshipTypes' => array('institution'), 'delimiter' => ', '))) {
					print "<div class='unit'><h8>Originating Institution</h8>".$va_originating_institution."</div>";
				}
				if ($va_exh_type = $t_item->get('ca_occurrences.exhibition_type')) {
					print "<div class='unit'><h8>Exhibition Type</h8>".$va_exh_type."</div>";
				}
				if ($va_curator = $t_item->get('ca_entities.preferred_labels', array('returnAsLink' => true, 'restrictToRelationshipTypes' => array('curator'), 'delimiter' => ', '))) {
					print "<div class='unit'><h8>Curator</h8>".$va_curator."</div>";
				}								
				if ($va_event = $t_item->get('ca_occurrences.occurrence_dates')) {
					print "<div class='unit'><h8>Event Date</h8>".$va_event."</div>";
				}
				if ($va_venue = $t_item->getWithTemplate('<unit delimiter="<br/>">^ca_occurrences.venue.venue_institution</unit>')) {
					print "<div class='unit'><h8>Venue</h8>".$va_venue."</div>";
				}	
				if ($va_description = $t_item->get('ca_occurrences.occurrence_description')) {
					print "<div class='unit trimText'><h8>Description</h8>".$va_description."</div>";
				}
				if ($va_venue_description = $t_item->get('ca_occurrences.venue_description')) {
					print "<div class='unit trimText'><h8>Description</h8>".$va_venue_description."</div>";
				}				
				#if ($va_catalogue = $t_item->get('ca_objects.preferred_labels', array('delimiter' => '<br/>', 'returnAsLink' => true, 'restrictToTypes' => array('library')))) {
				#	print "<div class='unit'><h8>Catalogue</h8>".$va_catalogue."</div>";
				#}
				if ($va_online = $t_item->get('ca_occurrences.online_exhibition')) {
					print "<div class='unit'><h8>Online Exhibition</h8><a href='".$va_online."' target='_blank'>".$va_online."</a></div>";
				}
				#if ($va_entities = $t_item->getWithTemplate('<unit delimiter="<br/>" relativeTo="ca_entities"><l>^ca_entities.preferred_labels</l> (^relationship_typename)</unit>')) {
				#	print "<div class='unit'><h8>Related Entities</h8>".$va_entities."</div>";
				#}
				#if ($va_places = $t_item->getWithTemplate('<unit delimiter="<br/>" relativeTo="ca_places"><l>^ca_places.preferred_labels</l> (^relationship_typename)</unit>')) {
				#	print "<div class='unit'><h8>Related Places</h8>".$va_places."</div>";
				#}
				#if ($va_collections = $t_item->getWithTemplate('<unit delimiter="<br/>" relativeTo="ca_collections"><l>^ca_collections.preferred_labels</l> (^relationship_typename)</unit>')) {
				#	print "<div class='unit'><h8>Related Collections</h8>".$va_collections."</div>";
				#}
				#if ($va_events = $t_item->getWithTemplate('<unit delimiter="<br/>" relativeTo="ca_occurrences.related"><l>^ca_occurrences.preferred_labels</l></unit>')) {
				#	print "<div class='unit'><h8>Related Events</h8>".$va_events."</div>";
				#}																			
?>					
				</div>
			</div><!-- end row -->
			
<?php

			#Archives Objects etc
			$vs_related_holdings = "";			
			if ($va_related_holdings_objects = $t_item->get('ca_objects.related.object_id', array('returnWithStructure' => true, 'restrictToTypes' => array('archival', 'library', 'survivor', 'work'), 'checkAccess' => $va_access_values, 'sort' => 'ca_objects.type_id'))) {
				$va_my_type = array();
				$va_other_type = array();
				foreach ($va_related_holdings_objects as $va_key => $va_related_holdings_object_id) {				
					$t_holding = new ca_objects($va_related_holdings_object_id);
					if ($t_holding->get('ca_objects.type_id', array('convertCodesToDisplayText' => true)) == $t_item->get('ca_objects.type_id', array('convertCodesToDisplayText' => true))) {
						$va_my_type[] = "<div class='col-sm-3'><div class='relatedThumb'>".caNavLink($this->request, $t_holding->get('ca_object_representations.media.widepreview'), '', '', 'Detail', 'objects/'.$va_related_holdings_object_id)."<div>".caNavLink($this->request, (strlen($t_holding->get('ca_objects.preferred_labels')) > 70 ? substr($t_holding->get('ca_objects.preferred_labels'), 0, 67)."..." : $t_holding->get('ca_objects.preferred_labels')), '', '', 'Detail', 'objects/'.$va_related_holdings_object_id)."</div></div></div>";	
					} else {
						$va_other_type[] = "<div class='col-sm-3'><div class='relatedThumb'>".caNavLink($this->request, $t_holding->get('ca_object_representations.media.widepreview'), '', '', 'Detail', 'objects/'.$va_related_holdings_object_id)."<div>".caNavLink($this->request, (strlen($t_holding->get('ca_objects.preferred_labels')) > 70 ? substr($t_holding->get('ca_objects.preferred_labels'), 0, 67)."..." : $t_holding->get('ca_objects.preferred_labels')), '', '', 'Detail', 'objects/'.$va_related_holdings_object_id)."</div></div></div>";	
					}
				}
				foreach ($va_my_type as $va_key => $va_my_type_object_link) {
					$vs_related_holdings.= $va_my_type_object_link;
				}
				foreach ($va_other_type as $va_key => $va_other_type_object_link) {
					$vs_related_holdings.= $va_other_type_object_link;
				}				
				
			}
			if ($va_related_collections = $t_item->get('ca_collections.collection_id', array('returnWithStructure' => true, 'checkAccess' => $va_access_values, 'restrictToTypes' => array('fonds', 'series', 'sub_series', 'file')))) {
				foreach ($va_related_collections as $va_key => $va_related_collection_id) {				
					$t_collection = new ca_collections($va_related_collection_id);
					$vs_related_holdings.= "<div class='col-sm-3'>";
					$vs_related_holdings.= "<div class='relatedThumb'>";
					$vs_related_holdings.= "<p>".caNavLink($this->request, $t_collection->get('ca_collections.preferred_labels'), '', '', 'Detail', 'collections/'.$va_related_collection_id)."</p></div>";
					$vs_related_holdings.= "</div>";					
				}
			}					
			#Entities
			$vs_related_entities = "";
			$va_ents_by_type = array();
			if ($va_related_entities = $t_item->get('ca_entities', array('checkAccess' => $va_access_values, 'returnWithStructure' => true, 'excludeRelationshipTypes' => array('curator')))) {
				foreach ($va_related_entities as $va_key => $va_related_entity) {
					$va_ents_by_type[$va_related_entity['item_type_id']][$va_related_entity['entity_id']] = "<div class='col-sm-4'><div class='entityThumb'><p>".caNavLink($this->request, $va_related_entity['label'], '', '', 'Detail', 'entities/'.$va_related_entity['entity_id'])." (".$va_related_entity['relationship_typename'].")</p></div></div>";
				}
				foreach ($va_ents_by_type as $vs_entity_type => $va_entity) {
					if (($va_type_name = caGetListItemByIDForDisplay($vs_entity_type, true)) == "Individuals" ) {
						$vs_related_entities.= "<h8>People</h8>";
					} else {
						$vs_related_entities.= "<h8>".$va_type_name."</h8>";
					}
					$vs_related_entities.= "<div class='row'>";
					foreach ($va_entity as $va_key => $va_entity_name) {
						$vs_related_entities.= $va_entity_name;
					}
					$vs_related_entities.= "</div>";
				}
				#$vs_related_entities.= $t_item->getWithTemplate('<unit relativeTo="ca_entities" delimiter=" "><div class="col-sm-3"><div class="entityThumb"><p><l>^ca_entities.preferred_labels</l> (^relationship_typename)</p></div></div></unit>');					
			}
			#Places
			$vs_related_places = "";
			if ($va_related_places = $t_item->get('ca_places.place_id', array('returnWithStructure' => true, 'checkAccess' => $va_access_values))) {
				foreach ($va_related_places as $va_key => $va_related_place_id) {				
					$t_place = new ca_places($va_related_place_id);
					$vs_place_name = $t_place->get('ca_places.preferred_labels');
					$vs_related_places.= "<div class='col-sm-3'>";
					$vs_related_places.= "<div class='entityThumb'>";
					$vs_related_places.= "<p>".caNavLink($this->request, $vs_place_name, '', '', 'Detail', 'places/'.$va_related_place_id)."</p></div>";
					$vs_related_places.= "</div>";					
				}
			}
			#Collections
			$vs_related_collections = "";
			if ($va_related_collections = $t_item->get('ca_collections.collection_id', array('returnWithStructure' => true, 'checkAccess' => $va_access_values, 'restrictToTypes' => array('collection')))) {
				foreach ($va_related_collections as $va_key => $va_related_collection_id) {				
					$t_collection = new ca_collections($va_related_collection_id);
					$vs_related_collections.= "<div class='col-sm-3'>";
					$vs_related_collections.= "<div class='entityThumb'>";
					$vs_related_collections.= "<p>".$t_collection->get('ca_collections.preferred_labels', array('returnAsLink' => true))."</p></div>";
					$vs_related_collections.= "</div>";					
				}
			}
			#Events
			$vs_related_events = "";
			if ($va_related_events = $t_item->get('ca_occurrences.related', array('returnWithStructure' => true, 'checkAccess' => $va_access_values))) {
				foreach ($va_related_events as $va_key => $va_related_event) {
					$va_events_by_type[$va_related_event['item_type_id']][$va_related_event['occurrence_id']] = "<div class='col-sm-4'><div class='entityThumb'><p>".caNavLink($this->request, $va_related_event['label'], '', '', 'Detail', 'occurrences/'.$va_related_event['occurrence_id'])." (".$va_related_event['relationship_typename'].")</p></div></div>";
				}
				foreach ($va_events_by_type as $vs_event_type => $va_event) {
					$vs_related_events.= "<h8>".caGetListItemByIDForDisplay($vs_event_type)."</h8>";
					$vs_related_events.= "<div class='row'>";
					foreach ($va_event as $va_key => $va_event_name) {
						$vs_related_events.= $va_event_name;
					}
					$vs_related_events.= "</div>";
				}
			}
			if ($vs_related_holdings | $vs_related_entities | $vs_related_places | $vs_related_collections | $vs_related_events) {															
?>		
			<hr>	
			<div class='row'>
				<div class='col-sm-12'>
					<h4 style='font-size:16px;'>Related</h4>
					<div class='container' id='relationshipTable'>
						<ul class='row'>
<?php						
							if ($vs_related_holdings) { print '<li><a href="#objectsTab">Holdings</a></li>'; }
							if ($vs_related_entities) { print '<li><a href="#entityTab">People & Organizations</a></li>'; }
							if ($vs_related_places) { print '<li><a href="#placeTab">Places</a></li>'; }
							if ($vs_related_events) { print '<li><a href="#eventTab">Events & Exhibitions</a></li>'; }
							if ($vs_related_collections) { print '<li><a href="#collectionTab">Collections</a></li>'; }																																			
?>																					
						</ul>						
						<div id='objectsTab' class='row' >
							<?php print $vs_related_holdings; ?>
						</div>
						<div id='entityTab' class='row'>
							<?php print $vs_related_entities; ?>
						</div>
						<div id='placeTab' class='row'>
							<?php print $vs_related_places; ?>
						</div>
						<div id='eventTab' class='row'>
							<?php print $vs_related_events; ?>
						</div>																					
						<div id='collectionTab' class='row'>
							<?php print $vs_related_collections; ?>
						</div>
					
					</div>	

			
				</div><!-- end col -->
			</div><!-- end row -->
<?php
			}
?>						
				
			

		</div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->
<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 102
		});
		$('#relationshipTable').tabs();
	});
</script>	