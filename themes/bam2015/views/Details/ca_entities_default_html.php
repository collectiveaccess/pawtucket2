<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
		<div class="container">
			<div class="row">
				<div class='col-sm-1 col-md-1 col-lg-1'>
					<div class="detailNavBgLeft">
						{{{previousLink}}}{{{resultsLink}}}
					</div><!-- end detailNavBgLeft -->				
				</div><!-- end col -->
				<div class='col-sm-10 col-md-10 col-lg-10'>
					<div class="detailHead">
<?php
					print "<div class='leader'>".$t_item->get('ca_entities.type_id', array('convertCodesToDisplayText' => true))."</div>";
					print "<h2>".$t_item->get('ca_entities.preferred_labels')."</h2>";
					if ($va_life_date = $t_item->get('ca_entities.lifespan.ind_dates_value')) {
						print "<h3>".$va_life_date."</h3>";
					}
					if ($va_org_date = $t_item->get('ca_entities.orgDate.org_dates_value')) {
						print "<h3>".$va_org_date."</h3>";
					}					
?>
					</div><!-- end detailHead -->
				</div><!-- end col -->
				<div class='col-sm-1 col-md-1 col-lg-1'>
					<div class="detailNavBgRight">
						{{{nextLink}}}
					</div><!-- end detailNavBgLeft -->				
				</div><!-- end col -->				
			</div><!-- end row -->
			<div class="row">
				<div class='col-sm-12 col-md-12 col-lg-12 detailSnippet'>
					
<?php
					if ($va_related_events = $t_item->get('ca_occurrences', array('restrictToTypes' => array('special_event, production'), 'returnWithStructure' => true))) {
						$va_event_list = array();
						print "<hr class='divide'/>";
						foreach ($va_related_events as $va_related_event) {
							$va_event_list[$va_related_event['relationship_typename']][] = caNavLink($this->request, $va_related_event['name'], '', '', 'Detail', 'occurrences/'.$va_related_event['occurrence_id']);
						}
						foreach ($va_event_list as $va_event_role => $va_event_link) {
							print "<span class='links'><span class='label'>".ucfirst($va_event_role)."</span>";
							print join(', ', $va_event_link)."</span>";
						}
					}					
?>				
				</div><!-- end col -->					
			</div><!-- end row -->			
			<div class="row">
				<div class='col-sm-6 col-md-6 col-lg-6'>
					<div class="entityRep">
<?php
						if ($va_objects = $t_item->get('ca_objects.object_id', array('restrictToRelationshipTypes' => array('primary_rep'), 'returnWithStructure' => true))) {
							$t_object = new ca_objects($va_objects[0]);
							if ($va_entity_rep = $t_object->get('ca_object_representations.media.large')) {
								$va_rep_id = $t_object->get('ca_object_representations.representation_id');
								print "<a href='#' onclick='caMediaPanel.showPanel(\"/index.php/Detail/GetRepresentationInfo/object_id/".$va_objects[0]."/representation_id/".$va_rep_id."/overlay/1\"); return false;'>".$va_entity_rep."</a>";
							}
						}
?>
					</div><!-- end entityRep -->				
				</div><!-- end col -->			
				<div class='col-sm-6 col-md-6 col-lg-6'>
<?php
					if ($va_affiliation = $t_item->get('ca_entities.bamAffiliation.affiliation_text')) {
						print "<div class='unit'><span class='label'>Biography: </span>".$va_affiliation."</div>";
					}
					if ($va_affiliation_source = $t_item->get('ca_entities.bamAffiliation.affiliation_source')) {
						print "<div class='unit'><span class='label'>Source: </span>".$va_affiliation_source."</div>";
					}					
?>				
				<!--
					<div id="detailTools">
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div>
						<div id='detailComments'>{{{itemComments}}}</div>
						<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div>
					</div> -->
					
				</div><!-- end col -->

			</div><!-- end row -->
{{{<ifcount code="ca_objects" min="1">
			<hr class="divide" style="margin-bottom:0px;"/>
			<div class="container"><div class="row">
				
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row --></div><!-- end container -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('detailNav' => '1', 'search' => 'entity_id:^ca_entities.entity_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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