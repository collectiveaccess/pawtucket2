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
					<H4>{{{^ca_entities.preferred_labels.displayname}}}</H4>
					<H6>{{{^ca_entities.type_id}}}{{{<ifdef code="ca_entities.idno">, ^ca_entities.idno</ifdef>}}}</H6>
					{{{<ifdef code="ca_entities.nonpreferred_labels"><h6>Alternate Name</h6><unit delimiter="</br>">^ca_entities.nonpreferred_labels.displayname</unit></ifdef>}}}
					
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-sm-6 col-md-6 col-lg-6'>
<?php
					if ($vs_nationality = $t_item->get('ca_entities.nationalityCreator', array('delimiter' => ', '))) {
						print "<div class='unit'><h6>Nationality</h6>".$vs_nationality."</unit></div>";
					}
					if ($t_item->get('ca_entities.vital_dates.vital_date_value')) {
						$vs_vital = $t_item->getWithTemplate('<unit delimiter="<br/>">^ca_entities.vital_dates.vital_date_value ^ca_entities.vital_dates.vital_date_types <ifdef code="ca_entities.vital_dates.vital_date_location">^ca_entities.vital_dates.vital_date_location</ifdef></unit>');					
						print "<div class='unit'><h6>Vital dates</h6>".$vs_vital."</unit></div>";
					}
					if ($t_item->get('ca_entities.vital_datesOrg.org.vital_date_value')) {
						$vs_vital_org = $t_item->get('ca_entities.vital_datesOrg', array('template' => '^org_vital_date_value ^org_vital_date_types <ifdef code="org_vital_date_location">^org_vital_date_location</ifdef>', 'delimiter' => '<br/>', 'convertCodesToDisplayText' => true));					
						print "<div class='unit'><h6>Vital dates</h6>".$vs_vital_org."</unit></div>";
					}
					if ($vs_gender = $t_item->get('ca_entities.genderCreator', array('delimiter' => ', '))) {
						print "<div class='unit'><h6>Gender</h6>".$vs_gender."</unit></div>";
					}
					if ($vs_role = $t_item->get('ca_entities.roleCreator', array('delimiter' => ', '))) {
						print "<div class='unit'><h6>Role</h6>".$vs_role."</unit></div>";
					}	
					if ($vs_bio = $t_item->get('ca_entities.biography')) {
						print "<div class='unit'><h6>Biography</h6>".$vs_bio."</unit></div>";
					}	
					if ($vs_sourcebio = $t_item->get('ca_entities.biography_source')) {
						print "<div class='unit'><h6>Source of Biography</h6>".$vs_sourcebio."</unit></div>";
					}
					if ($t_item->get('ca_entities.external_link.url_entry')) {
						print "<div class='unit'><h6>External URL</H6>";
						if ($t_item->get('ca_entities.external_link.url_entry') && $t_item->get('ca_entities.external_link.url_source')) {
							print "<a href='".$t_item->get('ca_entities.external_link.url_entry')."' target='_blank'>".$t_item->get('ca_entities.external_link.url_source')."</a>";
						} else {
							print "<a href='".$t_item->get('ca_entities.external_link.url_entry')."' target='_blank'>".$t_item->get('ca_entities.external_link.url_entry')."</a>";
						}
						print "</div>";
					}					
																																	
?>
					<div id="detailTools">
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
						<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
					</div><!-- end detailTools -->
					
				</div><!-- end col -->
				<div class='col-sm-6 col-md-6 col-lg-6'>
					{{{representationViewer}}}
					{{{<ifcount code="ca_collections" min="1" max="1"><H6>Related collection</H6></ifcount>}}}
					{{{<ifcount code="ca_collections" min="2"><H6>Related collections</H6></ifcount>}}}
					{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit>}}}
<?php
					if ($va_related_entities = $t_item->get('ca_entities.related.preferred_labels', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><h6>Related Entities</h6>".$va_related_entities."</div>";
					}					
?>
					{{{<ifcount code="ca_occurrences" min="1" max="1"><H6>Related occurrence</H6></ifcount>}}}
					{{{<ifcount code="ca_occurrences" min="2"><H6>Related occurrences</H6></ifcount>}}}
					{{{<unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l></unit>}}}
								
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
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'entity_id:^ca_entities.entity_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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