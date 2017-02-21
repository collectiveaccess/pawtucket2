<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_id = $t_item->get('ca_occurrences.occurrence_id');	
	
	$t_list = new ca_lists();
	$vs_yes_value =  $t_list->getItemIDFromList('yes_no', 'yes');
?>
<div class="container">
<div class="row">
	<div class='col-xs-12 objNav'><!--- only shown at small screen size -->
		<div class='resultsLink'>{{{resultsLink}}}</div><div class='previousLink'>{{{previousLink}}}</div><div class='nextLink'>{{{nextLink}}}</div>
	</div><!-- end detailTop -->
</div>
<div class="row">
	<div class="col-sm-6 col-md-6 col-lg-6">{{{representationViewer}}}</div>
	<div class='col-xs-6 col-sm-6 col-md-6 col-lg-6'>
<?php
		if ($vs_type = $t_item->get('ca_occurrences.type_id', array('convertCodesToDisplayText' => true))) {
			print "<h6 class='leader'>".$vs_type."</h6>";
		}
		print "<h1><i>".$t_item->get('ca_occurrences.preferred_labels')."</i></h1>"; 
		if ($va_venue_ids = $t_item->get('ca_entities.entity_id', array('restrictToRelationshipTypes' => array('venue'), 'returnAsArray' => true, 'checkAccess' => $va_access_values))) {
			print "<div class='unit'>";
			foreach ($va_venue_ids as $va_key => $va_venue_id) {
				$t_venue = new ca_entities($va_venue_id);
				print caNavLink($this->request, $t_venue->get('ca_entities.preferred_labels'), '', 'Search', 'exhibitions', 'search/exhibition', ["values" => [$t_venue->get('ca_entities.entity_id')]]);
			}
			print "</div>";
		}
		if ($va_places = $t_item->get('ca_places.hierarchy.preferred_labels', array('returnWithStructure' => true, 'checkAccess' => $va_access_values))) {
			$va_place_list = array_reverse(array_pop($va_places));
			array_pop($va_place_list);
			$va_place_output = array();
			foreach ($va_place_list as $va_key => $va_place_ids) {
				foreach ($va_place_ids as $va_key => $va_place_id_t) {
					foreach ($va_place_id_t as $va_key => $va_place_name) {
						$va_place_output[] = caNavLink($this->request, $va_place_name, '', 'Search', 'exhibitions', 'search/location', ["values" => [$va_place_name]]);
					}
				}
			}
		}
		if (sizeof($va_place_output) > 0) {
			print "<div class='unit'>".join(', ', $va_place_output)."</div>";
		}
		if ($va_date = $t_item->get('ca_occurrences.occurrence_dates')) {
			$va_raw_date = $t_item->get('ca_occurrences.occurrence_dates', array('rawDate' => true, 'returnAsArray' => true));
			$vs_start_date = explode('.', $va_raw_date[0]['start']);
			print "<div class='unit'>".caNavLink($this->request, $va_date, '', 'Search', 'exhibitions', 'search/exhibition_dates', ["values" => [$vs_start_date[0]]])."</div>";
		}
		if ($va_related_exhibitions = $t_item->get('ca_occurrences.related', array('returnWithStructure' => true, 'checkAccess' => $va_access_values))) {
			foreach ($va_related_exhibitions as $va_key => $va_related_exhibition) {
				$t_exhi = new ca_occurrences($va_related_exhibition['occurrence_id']);
				if($t_exhi->get('ca_occurrences.exhibition_origination') == $vs_yes_value) {
					print "<div class='unit'>Originating venue: ".caNavLink($this->request, $t_exhi->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('venue'))), '', 'Search', 'exhibitions', 'search/exhibition', ["values" => [$t_exhi->get('ca_entities.entity_id', array('restrictToRelationshipTypes' => array('venue')))]])."</div>";
				}
			}
		}
		if ($t_item->get('ca_occurrences.exhibition_origination') == $vs_yes_value) {
			print "<div class='unit'>Originating venue</div>";
		}
		if ($vs_remarks = $t_item->get('ca_occurrences.occurrence_notes')) {
			print "<div class='unit'>".$vs_remarks."</div>";
		}
		print "<div class='unit ' style='margin-bottom:-10px;'>".caNavLink($this->request, 'PDF', 'faDownload', 'Detail', 'occurrences', $vn_id.'/view/pdf/export_format/_pdf_ca_occurrences_summary')."</div>";

?>
	</div>
</div><!-- end row -->	
<div class="row">
	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
<?php
/*
		if ($vs_remarks = $t_item->get('ca_occurrences.occurrence_notes')) {
			print "<div class='drawer'>";
			print "<h6><a href='#' onclick='$(\"#remarksDiv\").toggle(400);return false;'>Remarks <i class='fa fa-chevron-down'></i></a></h6>";
			print "<div id='remarksDiv'>".$vs_remarks."</div>";
			print "</div>";
		}
*/				
?>		
	</div>
</div>	
<div class="row">
	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
<?php
		if ($vs_exhibitions = $t_item->getWithTemplate('<unit restrictToTypes="exhibition" delimiter="<br/>" relativeTo="ca_occurrences.related"><l>^ca_occurrences.preferred_labels</l><unit relativeTo="ca_entities" restrictToRelationshipTypes="venue">, ^ca_entities.preferred_labels<ifdef code="ca_entities.address.city">, ^ca_entities.address.city</ifdef><ifdef code="ca_entities.address.state">, ^ca_entities.address.state</ifdef><ifdef code="ca_entities.address.country">, ^ca_entities.address.country</ifdef></unit><ifdef code="ca_occurrences.occurrence_dates">, ^ca_occurrences.occurrence_dates</ifdef><if rule="^ca_occurrences.exhibition_origination =~ /yes/"> (originating institution)</ifdef></unit>')) {
			print "<div class='drawer'>";
			print "<h6><a href='#' onclick='$(\"#exhibitionDiv\").toggle(400);return false;'>Venues <i class='fa fa-chevron-down'></i></a></h6>";
			print "<div id='exhibitionDiv'>".$vs_exhibitions."</div>";
			print "</div>";
		}
?>		
	</div>
</div>
<div class='row'>
	<div class='col-sm-12 col-md-12 col-lg-12'>
<?php
		if ($vs_reference = $t_item->getWithTemplate('<unit restrictToTypes="reference" delimiter="<br/>" relativeTo="ca_occurrences.related"><l>^ca_occurrences.preferred_labels<ifdef code="ca_occurrences.nonpreferred_labels">, ^ca_occurrences.nonpreferred_labels, </ifdef></l><unit relativeTo="ca_entities" restrictToRelationshipTypes="author" delimiter=", ">^ca_entities.preferred_labels</unit><ifdef code="ca_occurrences.display_date">, ^ca_occurrences.display_date</ifdef></unit>')) {
			print "<div class='drawer'>";
			print "<h6><a href='#' onclick='$(\"#referenceDiv\").toggle(400);return false;'>Exhibition Catalog <i class='fa fa-chevron-down'></i></a></h6>";
			print "<div id='referenceDiv'>".$vs_reference."</div>";
			print "</div>";
		}
?>		
	</div>
</div><!-- end row -->
{{{<ifcount code="ca_objects" relativeTo="ca_objects" restrictToTypes="side" min="1">
	<div class="row"><div class='col-sm-12'>
	
		<div id="browseResultsContainer">
			<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
		</div><!-- end browseResultsContainer -->
	</div><!-- end col --></div><!-- end row -->
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'artworks', array('search' => 'occurrence_id:^ca_occurrences.occurrence_id', 'detailNav' => 1, 'occurrence_id' => '^ca_occurrences.occurrence_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
				jQuery('#browseResultsContainer').jscroll({
					autoTrigger: true,
					loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
					padding: 20,
					nextSelector: 'a.jscroll-next'
				});
			});
			
			
		});
	</script>
</ifcount>}}}		

</div>