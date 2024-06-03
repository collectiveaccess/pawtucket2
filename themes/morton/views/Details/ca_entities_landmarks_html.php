<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
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
	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>
		<div class="container">
			<div class="row">
				<div class='col-md-12 col-lg-12'>
					<H1>{{{^ca_entities.preferred_labels.displayname}}}</H1>
					<H2>{{{^ca_entities.type_id}}}{{{<ifdef code="ca_entities.idno">, ^ca_entities.idno</ifdef>}}}</H2>
					{{{<ifdef code="ca_entities.nonpreferred_labels"><div class="unit"><label>Alternate Name</label><unit delimiter="</br>">^ca_entities.nonpreferred_labels.displayname</unit></div></ifdef>}}}
					<hr/>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">
				
				<div class='col-sm-12 col-md-12 col-lg-12'>
					{{{representationViewer}}}
					{{{<ifcount code="ca_collections" min="1"><div class="unit">
						<ifcount code="ca_collections" min="1" max="1"><label>Related collection</label></ifcount>
						<ifcount code="ca_collections" min="2"><label>Related collections</label></ifcount>
						<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit>
					</div></ifdount>}}}
<?php
					if ($va_related_entities = $t_item->get('ca_entities.related.preferred_labels', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><label>Related Entities</label>".$va_related_entities."</div>";
					}					
?>
					{{{<ifcount code="ca_occurrences" min="1"><div class="unit">
						<ifcount code="ca_occurrences" min="1" max="1"><label>Related occurrence</label></ifcount>
						<ifcount code="ca_occurrences" min="2"><label>Related occurrences</label></ifcount>
						<unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l></unit>
					</div></ifdount>}}}
								
				</div><!-- end col -->
			</div>
			<div class="row">			
				<div class='col-sm-12 col-md-12 col-lg-12'>
<?php
					if ($t_item->get('ca_entities.vital_dates.vital_date_value')) {
						$vs_vital = $t_item->getWithTemplate('<unit delimiter="<br/>">^ca_entities.vital_dates.vital_date_value ^ca_entities.vital_dates.vital_date_types <ifdef code="ca_entities.vital_dates.vital_date_location">^ca_entities.vital_dates.vital_date_location</ifdef></unit>');					
						print "<div class='unit'><label>Dates</label>".$vs_vital."</unit></div>";
					}
					if ($t_item->get('ca_entities.vital_datesOrg.org.vital_date_value')) {
						$vs_vital_org = $t_item->get('ca_entities.vital_datesOrg', array('template' => '^org_vital_date_value ^org_vital_date_types <ifdef code="org_vital_date_location">^org_vital_date_location</ifdef>', 'delimiter' => '<br/>', 'convertCodesToDisplayText' => true));					
						print "<div class='unit'><label>Vital dates</label>".$vs_vital_org."</unit></div>";
					}	
					if ($vs_bio = $t_item->get('ca_entities.biography')) {
						print "<div class='unit'><label>History</label>".$vs_bio."</unit></div>";
					}	
					if ($vs_sourcebio = $t_item->get('ca_entities.biography_source')) {
						print "<div class='unit'><label>Sources</label>".$vs_sourcebio."</unit></div>";
					}
					if ($t_item->get('ca_entities.external_link.url_entry')) {
						print "<div class='unit'><label>External URL</label>";
						if ($t_item->get('ca_entities.external_link.url_entry') && $t_item->get('ca_entities.external_link.url_source')) {
							print "<a href='".$t_item->get('ca_entities.external_link.url_entry')."' target='_blank'>".$t_item->get('ca_entities.external_link.url_source')."</a>";
						} else {
							print "<a href='".$t_item->get('ca_entities.external_link.url_entry')."' target='_blank'>".$t_item->get('ca_entities.external_link.url_entry')."</a>";
						}
						print "</div>";
					}					
																																	
?>
					<div id="detailTools">
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print is_array($va_comments) ? sizeof($va_comments) : 0; ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
					</div><!-- end detailTools -->
					
				</div><!-- end col -->
			</div><!-- end row -->
{{{<ifcount code="ca_objects" min="1">
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load(
						"<?php print caNavUrl($this->request, '', 'Search', 'objects'); ?>", 
						{'search': 'ca_entity_labels.entity_id/author,2ndauthor,3rdauthor,collected,contributor,creator,depicted,engraver,client,draftsmen_surveyor,lithographer,proprietor,source,interviewee,interviewer,about,related,manufacturer,photographer,presented,previous_owner,publisher,recipient,recorded:^ca_entities.entity_id'},					
						function() {
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
		</div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->
