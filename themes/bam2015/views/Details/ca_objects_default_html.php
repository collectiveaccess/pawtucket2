<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
		<div class="container"><div class="row">
			<div class='col-sm-1 col-md-1 col-lg-1'>	
				<div class="detailNavBgLeft">
					{{{previousLink}}}{{{resultsLink}}}
				</div><!-- end detailNavBgLeft -->
			</div><!-- end col -->		
			<div class='col-sm-10 col-md-10 col-lg-10'>
				<div class="detailHead">
<?php
					print "<div class='leader'>".$t_object->get('ca_objects.type_id', array('convertCodesToDisplayText' => true))."</div>";
					print "<h2>".$t_object->get('ca_objects.preferred_labels')."</h2>";
					if ($va_source_date = $t_object->get('ca_objects.sourceDate')) {
						print "<h3>".$va_source_date."</h3>";
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
				<hr class="divide"/>
<?php
				if ($va_related_entities = $t_object->get('ca_entities', array('excludeRelationshipTypes' => array('rights_holder'), 'returnWithStructure' => true))) {
					$va_entity_list = array();
					foreach ($va_related_entities as $va_related_entity) {
						$va_entity_list[$va_related_entity['relationship_typename']][] = caNavLink($this->request, $va_related_entity['displayname'], '', '', 'Detail', 'entities/'.$va_related_entity['entity_id']);
					}
					foreach ($va_entity_list as $va_entity_role => $va_entity_link) {
						print "<span class='links'><span class='label'>".ucfirst($va_entity_role)."</span>";
						print join(', ', $va_entity_link)."</span>";
					}
				}
				if ($vs_season = $t_object->get('ca_occurrences.preferred_labels', array('restrictToTypes' => array('season'), 'delimiter' => ', '))) {
					print "<span class='links'><span class='label'>Season</span>".caNavLink($this->request, $vs_season, '', '', '', 'Search/objects/search/"'.$vs_season.'"')."</span>";
				}					
?>				
			</div><!-- end col -->
		</div><!-- end row -->
		<div class="row">
			<div class='col-sm-6 col-md-6 col-lg-6'>
				{{{representationViewer}}}
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>			
			</div>
			<div class='col-sm-6 col-md-6 col-lg-6'>
<?php
				if ($va_idno = $t_object->get('ca_objects.idno')) {
					print "<div class='unit'><span class='label'>Identifier: </span>".$va_idno."</div>";
				}
				if ($va_source_description = $t_object->get('ca_objects.sourceDescription')) {
					print "<div class='unit'><span class='label'>Description: </span>".$va_source_description."</div>";
				}
				if ($va_rights_statement = $t_object->get('ca_objects.rightsStatement.rightsStatement_text', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><span class='label'>Rights Statement: </span>".$va_rights_statement."</div>";
				}
				if ($va_ordering_info = $t_object->get('ca_objects.orderingInfo')) {
					print "<div class='unit'><span class='label'>Ordering Info: </span>".$va_ordering_info."</div>";
				}	
				if ($va_rights_holder = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('rights_holder'), 'returnAsLink' => true, 'delimiter' => ', '))) {
					print "<div class='unit'><span class='label'>Rights Holder: </span>".$va_rights_holder."</div>";
				}					
				if ($va_related_production = $t_object->get('ca_occurrences.preferred_labels', array('restrictToTypes' => array('production', 'special_event'), 'returnAsLink' => true, 'delimiter' => ', '))) {
					print "<div class='unit'><span class='label'>Related Production: </span>".$va_related_production."</div>";
				}
				if ($va_event_series = $t_object->get('ca_occurrences.preferred_labels', array('restrictToTypes' => array('event_series'), 'returnAsLink' => true, 'delimiter' => ', '))) {
					print "<div class='unit'><span class='label'>Related Event Series: </span>".$va_event_series."</div>";
				}


?>			
			</div>			
		</div><!-- end row -->
		<div class="row">
			<div class='col-sm-12 col-md-12 col-lg-12'>
				
				<!--<div id="detailTools">
					<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div>
					<div id='detailComments'>{{{itemComments}}}</div>
					<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div>
				</div>-->
			</div><!-- end col -->		
		</div><!-- end row --></div><!-- end container -->
	</div><!-- end col -->
</div><!-- end row -->



<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>