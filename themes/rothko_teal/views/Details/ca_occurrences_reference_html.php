<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$va_access_values = caGetUserAccessValues($this->request);	
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
	</div>
<div class="row">
	<div class='col-sm-12 col-md-6'>
<?php
		if ($vs_type = $t_item->get('ca_occurrences.type_id', array('convertCodesToDisplayText' => true))) {
			print "<h6 class='leader'>".$vs_type."</h6>";
		}
		print "<h1>".$t_item->get('ca_occurrences.preferred_labels');
			if ($vs_non_preferred = $t_item->get('ca_occurrences.nonpreferred_labels')) {
				print ": ".$vs_non_preferred;
			}
		print ".</h1>"; 
		
		if ($va_authors = $t_item->get('ca_entities.entity_id', array('restrictToRelationshipTypes' => array('author'), 'returnAsArray' => true, 'checkAccess' => $va_access_values))) {
			print "<div class='unit borderless'>";
			foreach ($va_authors as $va_key => $va_author) {
				$t_author = new ca_entities($va_author);
				print caNavLink($this->request, $t_author->get('ca_entities.preferred_labels'), '', 'Search', 'references', 'search/author', ["values" => [$va_author]])."<br/>";
			}
			print "</div>";
		}
		if ($va_editors = $t_item->get('ca_entities.entity_id', array('restrictToRelationshipTypes' => array('editor'), 'returnAsArray' => true, 'checkAccess' => $va_access_values))) {
			print "<div class='unit borderless'>";
			foreach ($va_editors as $va_key => $va_editor) {
				$t_editor = new ca_entities($va_editor);
				print caNavLink($this->request, $t_editor->get('ca_entities.preferred_labels'), '', 'Search', 'references', 'search/editor', ["values" => [$va_editor]])."<br/>";
			}
			print "</div>";
		}		
		if ($va_publishers = $t_item->get('ca_entities.entity_id', array('restrictToRelationshipTypes' => array('publisher'), 'returnAsArray' => true, 'checkAccess' => $va_access_values))) {
			print "<div class='unit borderless'>";
			foreach ($va_publishers as $va_key => $va_publisher) {
				$t_publisher = new ca_entities($va_publisher);
				print caNavLink($this->request, $t_publisher->get('ca_entities.preferred_labels'), '', 'Search', 'references', 'search/publisher', ["values" => [$va_publisher]])."<br/>";
			}
			print "</div>";
		}
		if ($va_institutions = $t_item->get('ca_entities.entity_id', array('restrictToRelationshipTypes' => array('institution'), 'returnAsArray' => true, 'checkAccess' => $va_access_values))) {
			print "<div class='unit borderless'>";
			foreach ($va_institutions as $va_key => $va_institution) {
				$t_institution = new ca_entities($va_institution);
				print caNavLink($this->request, $t_institution->get('ca_entities.preferred_labels'), '', 'Search', 'references', 'search/institution', ["values" => [$va_institution]])."<br/>";
			}
			print "</div>";
		}
		if ($va_places = $t_item->get('ca_places.hierarchy.preferred_labels', array('returnWithStructure' => true, 'checkAccess' => $va_access_values))) {
			$va_place_list = array_reverse(array_pop($va_places));
			$va_place_output = array();
			foreach ($va_place_list as $va_key => $va_place_ids) {
				foreach ($va_place_ids as $va_key => $va_place_id_t) {
					foreach ($va_place_id_t as $va_key => $va_place_name) {
						$va_place_output[] = caNavLink($this->request, $va_place_name, '', 'Search', 'references', 'search/location', ["values" => [$va_place_name]]);
					}
				}
			}
		}
		if (is_array($va_place_output) && (sizeof($va_place_output) > 0)) {
			print "<div class='unit borderless'>".join(', ', $va_place_output)."</div>";
		}
		if ($va_date = $t_item->get('ca_occurrences.occurrence_dates')) {
			print "<div class='unit borderless'>".caNavLink($this->request, $va_date, '', 'Search', 'references', 'search/reference_dates', ["values" => [$va_date]])."</div>";
		}						
		if ($va_ref_type = $t_item->get('ca_occurrences.reference_type', array('returnAsArray' => true))) {
			foreach ($va_ref_type as $vn_key => $vn_ref_id) {
				print "<div class='unit borderless'>".caNavLink($this->request, caGetListItemByIDForDisplay($vn_ref_id, true), '', 'Browse', 'references', 'facet/reference_facet/id/'.$vn_ref_id)."</div>";
			}
		}
		if ($vs_remarks = $t_item->get('ca_occurrences.occurrence_notes')) {
			print "<div class='unit borderless' style='padding-top:40px;'>".$vs_remarks."</div>";
		}		

?>
	</div>
	<div class='col-sm-12 col-md-6'>
		{{{representationViewer}}}
	</div>
</div><!-- end row -->	
<div class="row " style="border-bottom: 1px solid #d6d6d6;margin:40px -10px 0px -10px;"></div>
<?php
	$vs_first = true;
	$vs_no_border = "style=border-top:0px;";
	if ($vs_exhibitions = $t_item->getWithTemplate('<unit restrictToTypes="exhibition" delimiter="<br/>" relativeTo="ca_occurrences.related"><l><i>^ca_occurrences.preferred_labels</i><unit relativeTo="ca_entities" restrictToRelationshipTypes="venue">, ^ca_entities.preferred_labels</unit><unit relativeTo="ca_places">, ^ca_places.hierarchy.preferred_labels%delimiter=,_%hierarchyDirection=desc</unit><ifdef code="ca_occurrences.occurrence_dates">, ^ca_occurrences.occurrence_dates</ifdef>. <i class="fa fa-chevron-right"></i></l></unit>')) {
		print "<div class='row'><div class='col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2'><div class='drawer' ".( $vs_first == true ? $vs_no_border : "").">";
		print "<h6><a href='#' data-toggleDiv='exhibitionDiv' class='togglertronic''>Related Exhibitions <i class='fa fa-minus drawerToggle'></i></a></h6>";
		print "<div id='exhibitionDiv'>".$vs_exhibitions."</div>";
		print "</div></div></div>";
		$vs_first = false;
	}
	if ($vs_reference = $t_item->getWithTemplate('<unit restrictToTypes="reference" delimiter="<br/>" relativeTo="ca_occurrences.related"><l>^ca_occurrences.preferred_labels<ifdef code="ca_occurrences.nonpreferred_labels">: ^ca_occurrences.nonpreferred_labels</ifdef>. <i class="fa fa-chevron-right"></i></l></unit>')) {
		print "<div class='row'><div class='col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2'><div class='drawer' ".( $vs_first == true ? $vs_no_border : "").">";
		print "<h6><a href='#' data-toggleDiv='referenceDiv' class='togglertronic'>Related References <i class='fa fa-minus drawerToggle'></i></a></h6>";
		print "<div id='referenceDiv'>".$vs_reference."</div>";
		print "</div></div></div><!-- end row -->";
		$vs_first = false;
	}
?>		

{{{<ifcount code="ca_objects" relativeTo="ca_objects" restrictToTypes="side" min="1">
	<div class="row"><div class='col-sm-12'><?php print ($vs_first==true ? "" : "<hr>"); ?><div class='container'>
	
		<div id="browseResultsContainer">
			<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
		</div><!-- end browseResultsContainer -->
	</div><!-- end col --></div><!-- end row -->
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'artworks', array('search' => 'occurrence_id:^ca_occurrences.occurrence_id', 'detailNav' => 1, 'type' => 'reference'), array('dontURLEncodeParameters' => true)); ?>", function() {
				jQuery('#browseResultsContainer').jscroll({
					autoTrigger: true,
					loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
					padding: 20,
					nextSelector: 'a.jscroll-next'
				});
			});
			
            tronicTheToggles();
		});
	</script>
</ifcount>}}}		

</div></div>


			<div class="col-xs-1"><div class='nextLink'>{{{nextLink}}}</div></div>
		</div><!-- end row -->
	</div><!-- end container -->