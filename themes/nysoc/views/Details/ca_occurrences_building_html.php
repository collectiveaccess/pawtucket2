<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	
	$va_type = $t_item->get('ca_occurrences.type_id', array('convertCodesToDisplayText' => true));
	$va_title = ((strlen($t_item->get('ca_occurrences.preferred_labels')) > 40) ? substr($t_item->get('ca_occurrences.preferred_labels'), 0, 37)."..." : $t_item->get('ca_occurrences.preferred_labels'));	
	$va_home = caNavLink($this->request, "Project Home", '', '', '', '');
	MetaTagManager::setWindowTitle($va_home." > ".$va_type." > ".$va_title);	
?>
<div class="page">
	<div class="wrapper">
		<div class="sidebar">
			<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
				{{{resultsLink}}}
			</div><!-- end detailTop -->
		</div>
		<div class="content-wrapper">
      		<div class="content-inner">
				<div class="container"><div class="row">

					<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
						<div class="container">
							<div class="row">
								<div class='col-md-12 col-lg-12'>
									<div class="detailNav">
										<div class='prevLink'>{{{previousLink}}}</div>
										<div class='nextLink'>{{{nextLink}}}</div>
									</div>								
									<H4>{{{^ca_occurrences.preferred_labels}}}</H4>
								</div><!-- end col -->
							</div><!-- end row -->
							<div class="row">			
								<div class='col-md-6 col-lg-6'>
			<?php
									if ($va_occ_dates = $t_item->get('ca_occurrences.NYSL_occupied_dates')) {
										print "<div class='unit'><h6>Occupied by NYSL</h6>".$va_occ_dates."</div>";
									}
									if ($va_range = $t_item->get('ca_occurrences.building_range')) {
										print "<div class='unit'><h6>Building Dates</h6>".$va_range."</div>";
									}
									if ($va_history = $t_item->get('ca_occurrences.building_history')) {
										print "<div class='unit'><h6>Building History</h6>".$va_history."</div>";
									}												
									if ($vs_collections = $t_item->get('ca_collections.preferred_labels', array('returnAsLink' => true, 'delimiter' => ', '))) {
										print "<div class='unit'>Related Collections: ".$vs_collections."</div>";
									}
									if ($vs_docs = $t_item->get('ca_objects.related.preferred_labels', array('returnAsLink' => true, 'delimiter' => ', ', 'sort' => 'ca_objects.preferred_labels', 'restrictToTypes' => array('document')))) {
										print "<div class='unit'>Related Institutional Documents: ".$vs_docs."</div>";
									}
									$va_people_by_rels = array();
									if ($va_related_people = $t_item->get('ca_entities', array('returnAsArray' => true))) {
										print "<div class='unit'>";
										foreach ($va_related_people as $va_key => $va_related_person) {
											$va_people_by_rels[$va_related_person['relationship_typename']][$va_related_person['entity_id']] = $va_related_person['label'];
										}
										$va_people_links = array();
										foreach ($va_people_by_rels as $va_role => $va_person) {
											print ucwords($va_role).": ";
											foreach ($va_person as $va_entity_id => $va_name) {
												$va_people_links[] = caNavLink($this->request, $va_name, '', '', 'Detail', 'entities/'.$va_entity_id)."<br/>";
											}
											print join(', ', $va_people_links);
										}
										print "</div>";
									}
									if ($vs_event = $t_item->get('ca_occurrences.related.preferred_labels', array('returnAsLink' => true, 'delimiter' => ', ', 'restrictToTypes' => array('personal', 'historic', 'membership')))) {
										print "<div class='unit'>Related Events: ".$vs_event."</div>";
									}
									if ($va_links = $t_item->get('ca_occurrences.resources_link', array('returnAsArray' => true))) {
										print "<h6>External Resources</h6><div class='unit'>";
										foreach ($va_links as $va_key => $va_link) {
											if ($va_link['resources_link_description']) {
												print "<p><a href='".$va_link['resources_link_url']."'>".$va_link['resources_link_description']."</a></p>";
											} else {
												print "<p><a href='".$va_link['resources_link_url']."'>".$va_link['resources_link_url']."</a></p>";							
											}
										}
										print "</div>";
									}																				
			?>						
								</div><!-- end col -->
								<div class='col-md-6 col-lg-6'>
									{{{representationViewer}}}
									{{{map}}}
									<div id="detailTools">
										<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
										<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
										<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
									</div><!-- end detailTools -->						
				
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
				</ifcount>}}}		</div><!-- end container -->
					</div><!-- end col -->
				</div><!-- end row --></div><!-- end container -->
			</div><!--end content-inner -->
		</div><!--end content-wrapper-->
	</div><!--end wrapper-->
</div><!--end page-->