<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
?>
<div class="row">
	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
		<div class="container">

			<div class="row">			
				<div class='col-md-6 col-lg-6'>
					<H4>{{{^ca_entities.preferred_labels.displayname}}}</H4>
<?php
					if ($vs_gender = $t_item->get('ca_entities.gender', array('convertCodesToDisplayText' => true))) {
						print "<div class='unit'><h6>Gender</h6>".$vs_gender."</div>";
					}
					if ($vs_nationality = $t_item->get('ca_entities.nationality_culture_type', array('convertCodesToDisplayText' => true))) {
						print "<div class='unit'><h6>Nationality</h6>".$vs_nationality."</div>";
					}
					$va_life_dates = array();
					if ($vs_birth_date = $t_item->get('ca_entities.birth_date')) {
						$va_life_dates[] = $vs_birth_date;
					}
					if ($vs_death_date = $t_item->get('ca_entities.death_date')) {
						$va_life_dates[] = $vs_death_date;
					}	
					if (sizeof($va_life_dates) > 0) {
						print "<div class='unit'><h6>Life Dates</h6>".join(' - ', $va_life_dates)."</div>";
					}
					if ($vs_bio = $t_item->get('ca_entities.history_bio')) {
						print "<div class='unit'><h6>Biography</h6>".$vs_bio."</div>";
					}														
?>					
				</div><!-- end col -->
				<div class='col-md-6 col-lg-6'>
					{{{<ifcount code="ca_collections" min="1" max="1"><H6>Related collection</H6></ifcount>}}}
					{{{<ifcount code="ca_collections" min="2"><H6>Related collections</H6></ifcount>}}}
					{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l> (^relationship_typename)</unit>}}}

<?php
					if ($va_entities = $t_item->get('ca_entities.related', array('returnWithStructure' => true))) {
						print "<div class='unit'><h6>Related Entities</h6>";
						foreach ($va_entities as $va_id => $va_entity) {
							print "<div>".caNavLink($this->request, $va_entity['displayname'], '', 'Detail', 'entities', $va_entity['entity_id'])." (".$va_entity['relationship_typename'].")</div>";
						}
						print "</div>";
					}
?>
					{{{<ifcount code="ca_occurrences" min="1" max="1"><H6>Related exhibitions</H6></ifcount>}}}
					{{{<ifcount code="ca_occurrences" min="2"><H6>Related exhibitions</H6></ifcount>}}}
					{{{<unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l> (^relationship_typename)</unit>}}}
					
					{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
					{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
					{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l> (^relationship_typename)</unit>}}}				
				</div><!-- end col -->
			</div><!-- end row -->
{{{<ifcount code="ca_objects" min="2">
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
</div><!-- end row -->