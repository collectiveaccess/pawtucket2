<?php

require_once(__CA_MODELS_DIR__."/ca_sets.php");
include_once(__CA_LIB_DIR__."/Search/OccurrenceSearch.php");
include_once(__CA_LIB_DIR__."/Search/ObjectSearch.php");
include_once(__CA_MODELS_DIR__."/ca_occurrences.php");

$va_access_values = caGetUserAccessValues($this->request);

	if($vs_set_code = $this->request->config->get("featured_art_set")){
	 	AssetLoadManager::register("carousel");
		$t_set = new ca_sets();
		$t_set->load(array('set_code' => $vs_set_code));
		# Enforce access control on set
		if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_set->get("access"), $va_access_values))){
			$va_item_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => 0))) ? $va_tmp : array());
		}
		if(is_array($va_item_ids) && sizeof($va_item_ids)){
			$t_object = new ca_objects();
			$va_item_media = $t_object->getPrimaryMediaForIDs($va_item_ids, array("slideshowsmall"), array('checkAccess' => caGetUserAccessValues($this->request)));
		}
	}
	if ($this->request->user->hasUserRole("founders_new") || $this->request->user->hasUserRole("admin") || $this->request->user->hasUserRole("curatorial_advanced") || $this->request->user->hasUserRole("curatorial_all_new") || $this->request->user->hasUserRole("curatorial_basic_new") || $this->request->user->hasUserRole("archives_new") || $this->request->user->hasUserRole("library_new")){
		$vs_style = "";
	} else {
		$vs_style = "style='display:none;'";
	}
?>
<div class="container">
	<div class="row collection">
		<div class="col-sm-6">	
			<div class="advSearch">
				<h1>Art Advanced Search</h1>
				{{{form}}}

					<div class="advancedSearchField">
						Title:<br/>
						{{{ca_objects.preferred_labels.name%width=220px}}}
					</div>
					<div class="advancedSearchField" <?php print $vs_style ?>>
						Accession number:<br/>
						{{{ca_objects.idno%width=210px}}}
					</div>
					<div class="advancedSearchField">
						Artist:<br/>
						{{{ca_entities.preferred_labels.displayname/artist%width=220px&height=1}}}
					</div>
					<div class="advancedSearchField">
						Date:<br/>
						{{{ca_objects.creation_date%width=220px}}} 
					</div>

					<div class="advancedSearchField">
						Text:<br/>
						{{{_fulltext%width=220px&height=100px}}}
					</div>

					<br style="clear: both;"/>

					<div style="float: right; margin-left: 20px; margin-top:20px;">{{{reset%label=Reset}}}</div>
					<div style="float: right; margin-top:20px;">{{{submit%label=Search}}}</div>
				{{{/form}}}
				<div class='clearfix'></div>
			</div>
		</div><!--end col-sm-8-->
		<div class="col-sm-6">
			<div class="exhibitions">
				<h1>Glenstone Exhibitions</h1>
<?php
	// $o_exhibition_search = new OccurrenceSearch();
// 	$o_exhibition_search->setTypeRestrictions(array('exhibition'));
// 	$qr_exhibitions = $o_exhibition_search->search("*", array('checkAccess' => $va_access_values, 'sort' => 'ca_occurrences.exh_dates', 'sort_direction' => 'desc'));
// 
// 	if ($qr_exhibitions->numHits()) {
// 		while($qr_exhibitions->nextHit()) {
// 			print "<div class='exhibition'>".caNavLink($this->request, $qr_exhibitions->get('ca_occurrences.preferred_labels'), '', '', 'Detail', 'occurrences/'.$qr_exhibitions->get('ca_occurrences.occurrence_id'))."</div>";
// 		}
// 	}

	if ($q_gallery = ca_occurrences::find(['exhibition_location' => 'gallery'], ['returnAs' => 'searchResult', 'checkAccess' => $va_access_values, 'sort' => 'ca_occurrences.exh_dates', 'sortDirection' => 'DESC'])) {
		if ($q_gallery->numHits() > 0) {
			print "<h3 id='galleryListHeader'><a href='#'>The Gallery</a></h3>\n";
		}
		print "<ul id='galleryList' class='exhibitionList'>\n";
		while($q_gallery->nextHit()) {
			print "<li class='exhibitionListItem'>".caDetailLink($this->request, $q_gallery->get('ca_occurrences.preferred_labels.name'), '', 'ca_occurrences', $q_gallery->get('ca_occurrences.occurrence_id'))."</li>\n";
		}
		print "</ul>\n";
	}
	
	if ($pavilion = ca_list_items::find(['idno' => 'pavilions', 'list_id' => caGetListID('exhibition_locations')], ['returnAs' => 'firstModelInstance', 'checkAccess' => $va_access_values])) {
		$pavilion_contents = $pavilion->hierarchyWithTemplate('^ca_list_items.preferred_labels.name_plural', ['checkAccess' => $va_access_values]);

		if(is_array($pavilion_contents) && sizeof($pavilion_contents)) {
			$header = array_shift($pavilion_contents);
			print "<h3 id='pavilionListHeader'><a href='#'>".$header['display']."</a></h3>\n";
	
			print "<ul id='pavilionList' class='exhibitionList'>\n";
			foreach($pavilion_contents as $p) {
				print "<li class='exhibitionListItem pavilionRoom' data-list_id='pavilionRoom{$p['id']}'><a href='#'>".$p['display']."</a></li>\n";
				if ($q_pavilion_exh = ca_occurrences::find(['exhibition_location' => $p['id'], 'type_id' => 'exhibition'], ['returnAs' => 'searchResult', 'sort' => 'ca_occurrences.exh_dates', 'sortDirection' => 'DESC', 'checkAccess' => $va_access_values])) {
					print "<ul id='pavilionRoom{$p['id']}' class='exhibitionList'>\n";
					while($q_pavilion_exh->nextHit()) {
						print "<li class='exhibitionListItem'>".caDetailLink($this->request, $q_pavilion_exh->get('ca_occurrences.preferred_labels.name'), '', 'ca_occurrences', $q_pavilion_exh->get('ca_occurrences.occurrence_id'))."</li>";
					}
					print "</ul>\n";
				}
			}
			print "</ul>\n";
		}
	}
	if ($q_outdoor = ca_occurrences::find(['exhibition_location' => 'outdoor'], ['returnAs' => 'searchResult', 'checkAccess' => $va_access_values, 'sort' => 'ca_occurrences.exh_dates', 'sortDirection' => 'DESC'])) {
		if ($q_outdoor->numHits() > 0) {
			print "<h3 id='outdoorListHeader'><a href='#'>Outdoor Sculpture</a></h3>\n";
		}
		print "<ul id='outdoorList' class='exhibitionList'>\n";
		while($q_outdoor->nextHit()) {
			print "<li class='exhibitionListItem'>".caDetailLink($this->request, $q_outdoor->get('ca_occurrences.preferred_labels.name'), '', 'ca_occurrences', $q_outdoor->get('ca_occurrences.occurrence_id'))."</li>\n";
		}
		print "</ul>\n";
	}
?>			
				<script type="text/javascript">
					jQuery(document).ready(function() {
						jQuery('#galleryListHeader').on('click', function(e) {
							jQuery('#galleryList').slideToggle(250);
						});
						jQuery('#pavilionListHeader').on('click', function(e) {
							jQuery('#pavilionList').slideToggle(250);
						});
						jQuery('#outdoorListHeader').on('click', function(e) {
							jQuery('#outdoorList').slideToggle(250);
						});
						jQuery('.pavilionRoom').on('click', function(e) {
							jQuery('#' + jQuery(this).data('list_id')).slideToggle(250);
						});
					});
				</script>
			</div>
		</div> <!--end col-sm-4-->	
	</div><!--end row-->
	<div class='row'>
		<div class="col-sm-12">
			<hr>
			<h1>Artists by Last Name</h1>  
<?php
		//$o_artist_search = new ObjectSearch();
		//$qr_artists = $o_artist_search->search("ca_entities.preferred_labels.displayname/artist:*");
		$o_db = new Db();
		$t = new Timer();
		$qr_res = $o_db->query("
			SELECT DISTINCT e.entity_id, el.surname, el.forename FROM ca_entities e
			INNER JOIN ca_entity_labels AS el ON el.entity_id = e.entity_id
			INNER JOIN ca_objects_x_entities AS oxe ON e.entity_id = oxe.entity_id
			WHERE
				oxe.type_id = 103 AND e.deleted = 0 AND el.is_preferred = 1
			ORDER BY
				el.surname, el.forename
		");
		$qr_artists = caMakeSearchResult('ca_entities', $qr_res->getAllFieldValues('entity_id'));
		
		$va_artists = array();
		while ($qr_artists->nextHit()) {
			$vb_has_artwork = false;
			if (is_array($va_artworks = $qr_artists->get('ca_objects', array('restrictToRelationshipTypes' => 'artist', 'checkAccess' => $va_access_values, 'returnAsArray' => true, 'returnWithStructure' => true))) && sizeof($va_artworks)) {
				foreach ($va_artworks as $vn_artwork_key => $va_artwork) {
					$vn_artwork_id = $va_artwork['object_id'];
					$vn_type_id = $va_artwork['item_type_id'];
					if (in_array((int)$vn_type_id, [28, 234724])){ $vb_has_artwork = true;}
				}
				if ($vb_has_artwork == true) {
					$va_first_letter = substr(ucfirst($qr_artists->get('ca_entities.preferred_labels.surname')), 0, 1);
					$va_artists[$va_first_letter][] = caNavLink($this->request, $qr_artists->get('ca_entities.preferred_labels.displayname'), '', 'Browse', 'artworks', 'facet/artists_facet/id/'.$qr_artists->get('ca_entities.entity_id'));
				}
			}
		} 

		foreach ($va_artists as $va_letter_key => $va_artist_name) { 
			print "<div class='letterMenu'><a href='#".$va_letter_key."'>".$va_letter_key."</a></div>";
		}
		foreach ($va_artists as $va_letter_key => $va_artist_name) {
			print "<div class='letterHeader'><a name='".$va_letter_key."'>".$va_letter_key."</a></div>";
			foreach ($va_artist_name as $va_artist) {
				print "<div class='artistName'>".$va_artist."</div>";
			}
		}
		
?>			
			
		</div><!--end col-->
	</div><!--end row-->
</div> <!--end container-->

