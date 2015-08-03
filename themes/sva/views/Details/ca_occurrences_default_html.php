<?php
	$t_occurrence = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	#$o_config = caGetBrowseConfig();
 	$va_object_browse_info = caGetInfoForBrowseType("objects");
 	$va_views = $va_object_browse_info["views"];
 	$o_config = caGetBrowseConfig();
 	$va_view_icons = $o_config->getAssoc("views")
?>
<div class="row">
	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>
		<div class="container">
			<div class="row">			
				<div class='col-xs-4 col-sm-4 col-md-4 col-lg-4'>
<?php
				$va_related_objects = $t_occurrence->get('ca_objects.object_id', array('returnAsArray' => true));
				$vn_related_id = $va_related_objects[0];
				$t_object = new ca_objects($vn_related_id);
				$va_reps = $t_object->getPrimaryRepresentation(array('large'), null, array('return_with_access' => $va_access_values));
				print "<div class='detailImage'>".caNavLink($this->request, $va_reps['tags']['large'], '', '', 'Detail', 'objects/'.$vn_related_id)."</div>";
				print "<div class='caption'>".caNavLink($this->request, $t_object->get('ca_objects.preferred_labels'), '', '', 'Detail', 'objects/'.$vn_related_id)."</div>";
?>		
				</div>
				<div class='col-xs-8 col-sm-8 col-md-8 col-lg-8'>
					<H6>{{{^ca_occurrences.type_id}}}</H6>
				
					<H4>{{{^ca_occurrences.preferred_labels}}}</H4>
<?php	
				if ($va_description = $t_occurrence->get('ca_occurrences.description_public', array('delimiter' => '<br/>'))) {
					print "<p>".$va_description."</p>";
				}	
				if ($va_idno = $t_occurrence->get('ca_occurrences.idno', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><span class='detailLabel'>ID</span><span class='detailInfo'>".$va_idno."</span></div>";
				}
				if ($va_opening_dates = $t_occurrence->get('ca_occurrences.dates', array('returnWithStructure' => true))) {
					foreach ($va_opening_dates as $va_opening_key => $va_opening_t) {
						foreach ($va_opening_t as $va_key => $va_opening) {
							if (
								(
									($t_occurrence->get('ca_occurrences.type_id', ['convertCodesToIdno' => true]) !== 'exhibition')
									&&
									($va_opening['dates_type'] != "Reception dates")
								)
								||
								($va_opening['dates_type'] == "Exhibition dates")
							) {
								$va_opening_date = $va_opening['dates_value'];
							}
						}
					}
				}

				if ($va_opening_date) {
					print "<div class='unit'><span class='detailLabel'>Date</span><span class='detailInfo'>".$va_opening_date."</span></div>";				
				}
				
				/* omit reception date
				if ($va_reception_dates = $t_occurrence->get('ca_occurrences.dates', array('returnWithStructure' => true))) {
					foreach ($va_reception_dates as $va_reception_key => $va_reception_t) {
						foreach ($va_reception_t as $va_key => $va_reception) {
							if ($va_reception['dates_type'] == "Reception dates") {
								$va_reception_date = $va_reception['dates_value'];
							}
						}
					}
					if ($va_reception_date) {
						print "<div class='unit'><span class='detailLabel'>Reception</span><span class='detailInfo'>".$va_reception_date."</span></div>"; 
					}
				} 
				*/
				if ($va_place = $t_occurrence->get('ca_places.preferred_labels', array('delimiter' => '<br/>', 'checkAccess' => $va_access_values))) {
					print "<div class='unit'><span class='detailLabel'>Location</span><span class='detailInfo'>".$va_place."</span></div>";
				}	
				if ($va_curator = $t_occurrence->get('ca_entities.preferred_labels', array('delimiter' => '<br/>', 'returnAsLink' => true, 'checkAccess' => $va_access_values, 'restrictToRelationshipTypes' => array('curator')))) {
					print "<div class='unit'><span class='detailLabel'>Curator</span><span class='detailInfo'>".$va_curator."</span></div>";
				}
				if ($va_exhibitor = $t_occurrence->get('ca_entities.preferred_labels', array('delimiter' => ', ', 'returnAsLink' => true, 'checkAccess' => $va_access_values, 'restrictToRelationshipTypes' => array('exhibitor')))) {
					print "<div class='unit'><span class='detailLabel'>Exhibitors</span><span class='detailInfo'>".$va_exhibitor."</span></div>";
				}	
				if ($t_occurrence->get('ca_occurrences.external_link.url_entry')) {
					if (($t_occurrence->get('ca_occurrences.external_link.url_entry')) && ($t_occurrence->get('ca_occurrences.external_link.url_source'))) {
						print "<div class='unit'><span class='detailLabel'>Website</span><span class='detailInfo'><a href='".$t_occurrence->get('ca_occurrences.external_link.url_entry')."' target='_blank'>".$t_occurrence->get('ca_occurrences.external_link.url_source')."</a></span></div>";
					} else {
						print "<div class='unit'><span class='detailLabel'>Website</span><span class='detailInfo'><a href='".$t_occurrence->get('ca_occurrences.external_link.url_entry')."' target='_blank'>".$t_occurrence->get('ca_occurrences.external_link.url_entry')."</a></span></div>";
					}
				}																									
				if ($va_department = $t_occurrence->get('ca_entities.preferred_labels', array('delimiter' => '<br/>', 'returnAsLink' => true, 'restrictToRelationshipTypes' => array('department'), 'checkAccess' => $va_access_values))) {
					print "<h6>Department</h6>";
					print "<p>".$va_department."</p>";
				}



				print "<div style='width:500px; clear:left;height:1px;'></div>";	
				if ($va_instructor = $t_occurrence->get('ca_entities.preferred_labels', array('delimiter' => '<br/>', 'checkAccess' => $va_access_values, 'returnAsLink' => true, 'restrictToRelationshipTypes' => array('instructor')))) {
					print "<h6>Instructors</h6>";
					print "<p>".$va_instructor."</p>";
				}
				print "<div style='width:500px; clear:left;height:1px;'></div>";

				print "<div style='width:500px; clear:left;height:1px;'></div>";			
				if ($va_participants = $t_occurrence->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('participant'), 'delimiter' => '<br/>', 'returnAsLink' => true, 'checkAccess' => $va_access_values))) {
					print "<h6>Participants</h6>";
					print "<p>".$va_participants."</p>";
				}

?>					
					{{{<ifcount code="ca_collections" min="1" max="1"><H6>Related collection</H6></ifcount>}}}
					{{{<ifcount code="ca_collections" min="2"><H6>Related collections</H6></ifcount>}}}
					{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit>}}}
					
					{{{<ifcount code="ca_occurrences.related" min="1" max="1"><H6>Related occurrence</H6></ifcount>}}}
					{{{<ifcount code="ca_occurrences.related" min="2"><H6>Related occurrences</H6></ifcount>}}}
					{{{<unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.related.preferred_labels.name</l></unit>}}}
					
				
				</div><!-- end col -->
			</div><!-- end row -->
{{{<ifcount code="ca_objects" min="2">
			<div class="row">
				<div class='col-xs-4 col-sm-4 col-md-4 col-lg-4'>
				</div>
				<div class='col-xs-8 col-sm-8 col-md-8 col-lg-8' style='margin-top:20px;'>
				<h3>Related Objects</h3>
				<div id="bViewButtons">
<?php
					if(is_array($va_views) && (sizeof($va_views) > 1)){
						foreach($va_views as $vs_view => $va_view_info) {
?>
							<a href="#" onClick="loadResults('<?php print $vs_view; ?>'); return false;"><span class="glyphicon <?php print $va_view_icons[$vs_view]['icon']; ?>"></span></a>
<?php
						}
					}
?>
				</div>
				<div id="browseResultsContainer" class='row'>
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'occurrence_id:^ca_occurrences.occurrence_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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
			</div><!-- end col -->		
		</div><!-- end col -->
	</div><!-- end row -->
</div><!-- end container -->

<script type="text/javascript">
		
		function loadResults(view) {
			jQuery("#browseResultsContainer").data('jscroll', null);
			jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'occurrence_id:{{{^ca_occurrences.occurrence_id}}}'), array('dontURLEncodeParameters' => true)); ?>/view/" + view, function() {
				jQuery("#browseResultsContainer").jscroll({
					autoTrigger: true,
					loadingHtml: "<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>",
					padding: 20,
					nextSelector: "a.jscroll-next"
				});
			});
		}
</script>