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
	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10 marginTop' >
		<div class="container">
			<div class="row">
				<div class='col-md-12 col-lg-12'>
					<H4>{{{^ca_entities.preferred_labels.displayname}}}
<?php
						if ($va_entity_dates = $t_item->get('ca_entities.entity_date', array('returnWithStructure' => true, 'convertCodesToDisplayText' => true))) {
							foreach ($va_entity_dates as $va_key => $va_entity_date_t) {
								foreach ($va_entity_date_t as $va_key => $va_entity_date) {
									if ($va_entity_date['entity_date_supress'] == "No") { 
										if ($va_entity_date['entity_date_value']) {
											print " (".$va_entity_date['entity_date_value'].")";
										}
									}
								}
							}
						}	
?>										
					</H4>
					<H5>{{{<ifcount min="1" code='ca_entities.nonpreferred_labels'><span>Also known as: </span><unit delimiter=', '>^ca_entities.nonpreferred_labels.displayname</unit></ifcount>}}}</H5>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-sm-6'>
<?php
					if ($va_birthplace = $t_item->get('ca_places.preferred_labels', array('restrictToRelationshipTypes' => array('birthplace')))) {
						print "<div class='unit'><h8>Birthplace</h8>".$va_birthplace."</div>";
					}
					if ($va_bio = $t_item->get('ca_entities.biography')) {
						if ($t_item->get('ca_entities.type_id', array('convertCodesToDisplayText' => true)) == "Individual") {
							print "<div class='unit trimText'><h8>Biography</h8>".$va_bio."</div>";
						} else {
							print "<div class='unit trimText'><h8>Administrative History</h8>".$va_bio."</div>";
						}
					}
					#if ($va_admin_hist = $t_item->get('ca_entities.administrative_history')) {
					#	print "<div class='unit trimText'><h8>Administrative History</h8>".$va_admin_hist."</div>";
					#}						
					if ($va_public_notes = $t_item->get('ca_entities.public_notes')) {
						print "<div class='unit'><h8>Notes</h8>".$va_public_notes."</div>";
					}
					if ($va_website = $t_item->get('ca_entities.entity_website')) {
						print "<div class='unit'><h8>Website</h8><a href='".$va_website."' target='_blank'>".$va_website."</a></div>";
					}
?>
					
				</div><!-- end col -->
				<div class='col-sm-6'>
					{{{map}}}
				</div><!-- end col -->
			</div><!-- end row -->
			
<?php

			#Archives Objects etc
			/*$vs_related_holdings = "";			
			if ($va_related_holdings_objects = $t_item->get('ca_objects.related.object_id', array('returnWithStructure' => true, 'restrictToTypes' => array('archival', 'library', 'survivor', 'work'), 'checkAccess' => $va_access_values, 'sort' => 'ca_objects.type_id'))) {
				$va_my_type = array();
				$va_other_type = array();
				foreach ($va_related_holdings_objects as $va_key => $va_related_holdings_object_id) {				
					$t_holding = new ca_objects($va_related_holdings_object_id);
					if ($t_holding->get('ca_objects.type_id', array('convertCodesToDisplayText' => true)) == $t_item->get('ca_objects.type_id', array('convertCodesToDisplayText' => true))) {
						$va_my_type[] = "<div class='col-sm-3'><div class='relatedThumb'>".caNavLink($this->request, $t_holding->get('ca_object_representations.media.widepreview'), '', '', 'Detail', 'objects/'.$va_related_holdings_object_id)."<div>".caNavLink($this->request, $t_holding->get('ca_objects.preferred_labels'), '', '', 'Detail', 'objects/'.$va_related_holdings_object_id)."</div></div></div>";	
					} else {
						$va_other_type[] = "<div class='col-sm-3'><div class='relatedThumb'>".caNavLink($this->request, $t_holding->get('ca_object_representations.media.widepreview'), '', '', 'Detail', 'objects/'.$va_related_holdings_object_id)."<div>".caNavLink($this->request, $t_holding->get('ca_objects.preferred_labels'), '', '', 'Detail', 'objects/'.$va_related_holdings_object_id)."</div></div></div>";	
					}
				}
				foreach ($va_my_type as $va_key => $va_my_type_object_link) {
					$vs_related_holdings.= $va_my_type_object_link;
				}
				foreach ($va_other_type as $va_key => $va_other_type_object_link) {
					$vs_related_holdings.= $va_other_type_object_link;
				}				
				
			}*/
			$vs_related_holdings = "";
			$va_holdings_by_rel_type = array();
			if ($va_related_holdings_objects = $t_item->get('ca_objects', array('checkAccess' => $va_access_values, 'returnWithStructure' => true, 'excludeRelationshipTypes' => array('donor')))) {
				foreach ($va_related_holdings_objects as $va_key => $va_related_holding) {
					$t_object = new ca_objects($va_related_holding['object_id']);
					$va_holdings_by_rel_type[$va_related_holding['relationship_typename']][$va_related_holding['object_id']] = "<div class='col-sm-3'><div class='relatedThumb'><p>".caNavLink($this->request, $t_object->get('ca_object_representations.media.widepreview', array('checkAccess' => $va_access_values))."<br/>".(strlen($va_related_holding['label']) >  70 ? substr($va_related_holding['label'], 0, 67)."... ": $va_related_holding['label']), '', '', 'Detail', 'objects/'.$va_related_holding['object_id'])."</p></div></div>";
				}
				foreach ($va_holdings_by_rel_type as $vs_holding_rel_type => $va_holding) {
					$vs_related_holdings.= "<h8>".$vs_holding_rel_type."</h8>";
					$vs_related_holdings.= "<div class='row'>";
					foreach ($va_holding as $va_key => $va_holding_name) {
						$vs_related_holdings.= $va_holding_name;
					}
					$vs_related_holdings.= "</div>";
				}
			}			
			if ($va_related_collections = $t_item->get('ca_collections.collection_id', array('returnWithStructure' => true, 'checkAccess' => $va_access_values, 'restrictToTypes' => array('fonds', 'series', 'sub_series', 'file')))) {
				$vs_related_holdings.= "<h8>Related Archival Collections</h8>";
				$vs_related_holdings.= "<div class='row'>";
				foreach ($va_related_collections as $va_key => $va_related_collection_id) {					
					
					$t_collection = new ca_collections($va_related_collection_id);
					$vs_related_holdings.= "<div class='col-sm-3'>";
					$vs_related_holdings.= "<div class='relatedThumb'>";
					$vs_related_holdings.= "<p>".caNavLink($this->request, $t_collection->get('ca_collections.preferred_labels'), '', '', 'Detail', 'collections/'.$va_related_collection_id)."</p></div><!-- end relatedThumb -->";
					$vs_related_holdings.= "</div><!-- end col -->";					
				}
				$vs_related_holdings.= "</div><!-- end row -->";
			}					
			#Entities
			$vs_related_entities = "";
			$va_ents_by_type = array();
			if ($va_related_entities = $t_item->get('ca_entities.related', array('checkAccess' => $va_access_values, 'returnWithStructure' => true))) {
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
			if ($va_related_events = $t_item->get('ca_occurrences', array('returnWithStructure' => true, 'checkAccess' => $va_access_values))) {
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
		  maxHeight: 97
		});	
		$('#relationshipTable').tabs();
	});
</script>