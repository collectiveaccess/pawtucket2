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
		<div class="col-xs-1"><div class='previousLink'>{{{previousLink}}}</div></div>
		<div class="col-xs-10">

<div class="container">
	<div class="row detailHead">
		<div class='col-xs-6 objNav'><!--- only shown at small screen size -->
			<div class='resultsLink'>{{{resultsLink}}}</div>
		</div>
		<div class='col-xs-5 pdfLink'>
<?php		
			#print caNavLink($this->request, caGetThemeGraphic($this->request, 'pdf.png'), 'faDownload', 'Detail', 'occurrences', $vn_id.'/view/pdf/export_format/_pdf_ca_occurrences_summary');
?>	
		</div><!-- end col --> 		
	</div>
<div class="row">
	
	<div class='col-xs-6 col-sm-6 col-md-6 col-lg-6'>
<?php
		if ($vs_type = $t_item->get('ca_occurrences.type_id', array('convertCodesToDisplayText' => true))) {
			print "<h6 class='leader'>".$vs_type."</h6>";
		}
		print "<h1>".$t_item->get('ca_occurrences.preferred_labels')."</h1>"; 
		if ($va_venue_ids = $t_item->get('ca_entities.entity_id', array('restrictToRelationshipTypes' => array('venue'), 'returnAsArray' => true, 'checkAccess' => $va_access_values))) {
			print "<div class='unit borderless'>";
			foreach ($va_venue_ids as $va_key => $va_venue_id) {
				$t_venue = new ca_entities($va_venue_id);
				print caNavLink($this->request, $t_venue->get('ca_entities.preferred_labels'), '', 'Search', 'exhibitions', 'search/exhibition', ["values" => [$t_venue->get('ca_entities.entity_id')]]);
			}
			print "</div>";
		}
		if ($va_places = $t_item->get('ca_places.hierarchy.preferred_labels', array('returnWithStructure' => true, 'checkAccess' => $va_access_values))) {
			$va_place_list = array_reverse(array_pop($va_places));
			$va_place_output = array();
			foreach ($va_place_list as $va_key => $va_place_ids) {
				foreach ($va_place_ids as $va_key => $va_place_id_t) {
					foreach ($va_place_id_t as $va_key => $va_place_name) {
						$va_place_output[] = caNavLink($this->request, $va_place_name, '', 'Search', 'exhibitions', 'search/location', ["values" => [$va_place_name]]);
					}
				}
			}
		}
		if (is_array($va_place_output) && (sizeof($va_place_output) > 0)) {
			print "<div class='unit borderless'>".join(', ', $va_place_output)."</div>";
		}
		if ($va_date = $t_item->get('ca_occurrences.occurrence_dates')) {
			$va_raw_date = $t_item->get('ca_occurrences.occurrence_dates', array('returnWithStructure' => true, 'rawDate' => true));
			if (is_array($va_raw_date) && (sizeof($va_raw_date) > 0)) {
				$va_raw_date = array_pop(array_pop($va_raw_date));
				print "<div class='unit borderless'>".caNavLink($this->request, $va_date, '', 'Search', 'exhibitions', 'search/exhibition_dates', ["values" => [(int)$va_raw_date['occurrence_dates']['start']]])."</div>";
			}
		}
/*		if ($va_related_exhibitions = $t_item->get('ca_occurrences.related', array('returnWithStructure' => true, 'checkAccess' => $va_access_values))) {
			foreach ($va_related_exhibitions as $va_key => $va_related_exhibition) {
				$t_exhi = new ca_occurrences($va_related_exhibition['occurrence_id']);
				if($t_exhi->get('ca_occurrences.exhibition_origination') == $vs_yes_value) {
					print "<div class='unit borderless'>Originating venue: ".caNavLink($this->request, $t_exhi->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('venue'))), '', 'Search', 'exhibitions', 'search/exhibition', ["values" => [$t_exhi->get('ca_entities.entity_id', array('restrictToRelationshipTypes' => array('venue')))]])."</div>";
				}
			}
		} */
		$vs_solo_type =  $t_list->getItemIDFromList('exhibition_type', 'solo');
		$vs_group_type =  $t_list->getItemIDFromList('exhibition_type', 'group');
		if ($vs_ex_type = $t_item->get('ca_occurrences.exhibition_type')) {
			if ( $vs_ex_type == $vs_solo_type ) {
				print "<div class='unit borderless'>".caNavLink($this->request, 'Solo exhibition', '', 'Browse', 'exhibitions', 'facet/group_facet/id/'.$vs_ex_type)."</div>";
			} elseif ( $vs_ex_type == $vs_group_type ) {
				print "<div class='unit borderless'>".caNavLink($this->request, 'Group exhibition', '', 'Browse', 'exhibitions', 'facet/group_facet/id/'.$vs_ex_type)."</div>"; 
			}
		}
		if ($t_item->get('ca_occurrences.exhibition_origination') == $vs_yes_value) {
			print "<div class='unit borderless'>Originating venue</div>";
		}
		if ($vs_remarks = $t_item->get('ca_occurrences.occurrence_notes')) {
			print "<div class='unit borderless' style='margin-top:20px;'>".$vs_remarks."</div>";
		}

?>
	</div>
	<div class="col-sm-6 col-md-6 col-lg-6" style="width: 580px;">{{{representationViewer}}}</div>
</div><!-- end row -->
<div class="row " style="border-bottom: 1px solid #d6d6d6;margin:40px -10px 10px -10px;"></div>	
<?php
		$vs_first = true;
		$vs_contextual_info = false;
		$vs_no_border = "style=border-top:0px;";
		if ($vs_exhibitions = $t_item->getWithTemplate('<unit restrictToTypes="exhibition" delimiter="<br/>" relativeTo="ca_occurrences.related" sort="ca_occurrences.occurrence_dates"><l><i>^ca_occurrences.preferred_labels</i><unit relativeTo="ca_entities" restrictToRelationshipTypes="venue">, ^ca_entities.preferred_labels<ifdef code="ca_entities.address.city">, ^ca_entities.address.city</ifdef><ifdef code="ca_entities.address.state">, ^ca_entities.address.state</ifdef><ifdef code="ca_entities.address.country">, ^ca_entities.address.country</ifdef></unit><ifdef code="ca_occurrences.occurrence_dates">, ^ca_occurrences.occurrence_dates</ifdef><if rule="^ca_occurrences.exhibition_origination =~ /yes/"> (originating institution)</if>. <i class="fa fa-chevron-right"></i></l></unit>')) {
			print "<div class='row'><div class='col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2'><div class='drawer' ".( $vs_first == true ? $vs_no_border : "").">";
			print "<h6><a href='#'  data-toggleDiv='exhibitionDiv' class='togglertronic'>Venues <i class='fa fa-minus drawerToggle'></i></a></h6>";
			print "<div id='exhibitionDiv'>".$vs_exhibitions."</div>";
			print "</div></div></div>";
			$vs_first = false;
			$vs_contextual_info = true;
		}
		if ($vs_reference = $t_item->getWithTemplate('<unit restrictToTypes="reference" delimiter="<br/>" relativeTo="ca_occurrences.related"><l>^ca_occurrences.preferred_labels<ifdef code="ca_occurrences.nonpreferred_labels">: ^ca_occurrences.nonpreferred_labels</ifdef>. <i class="fa fa-chevron-right"></i></l></unit>')) {
			print "<div class='row'><div class='col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2'><div class='drawer' ".( $vs_first == true ? $vs_no_border : "").">";
			print "<h6><a href='#' data-toggleDiv='referenceDiv' class='togglertronic'>Exhibition Catalog <i class='fa fa-minus drawerToggle'></i></a></h6>";
			print "<div id='referenceDiv'>".$vs_reference."</div>";
			print "</div></div></div><!-- end row -->";
			$vs_contextual_info = true;
		}
?>		

{{{<ifcount code="ca_objects" relativeTo="ca_objects" restrictToTypes="side" min="1">
<?php
	if ($vs_contextual_info == true) {
?>	
	<div class="row " style="border-bottom: 1px solid #d6d6d6;margin:10px -10px 10px -10px;"></div>
<?php
	}
?>
	<div class="row"><div class='col-sm-12'>
	
		<div id="browseResultsContainer">
			<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
		</div><!-- end browseResultsContainer -->
	</div><!-- end col --></div><!-- end row -->
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'artworks', array('search' => 'occurrence_id:^ca_occurrences.occurrence_id', 'detailNav' => 1, 'type' => 'exhibition', 'occurrence_id' => '^ca_occurrences.occurrence_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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

			</div>
			<div class="col-xs-1"><div class='nextLink'>{{{nextLink}}}</div></div>
		</div><!-- end row -->
	</div><!-- end container -->
	
<script type="text/javascript">
    jQuery(document).ready(function() {
        tronicTheToggles();
    });
</script>