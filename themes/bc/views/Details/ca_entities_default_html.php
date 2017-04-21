<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
	
	$vs_link = $t_item->get('ca_entities.external_link.url_entry');
?>
<div class="container">
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
				<div class='col-sm-2 col-md-2 col-lg-2'></div>
				<div class='col-sm-6 col-md-6 col-lg-6'>
					<h2>{{{ca_entities.preferred_labels}}}</h2>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">
				<div class='col-sm-2 col-md-2 col-lg-2'>
<?php
					if ($vs_inst_image = $t_item->get('ca_entities.inst_images', array('version' => 'medium'))) {
						print "<div class='instLogo'><a href='".$vs_link."' target='_blank'>".$vs_inst_image."</a></div>";
					}
					print "<div style='text-align:center;padding-top:15px;'><a href='".$vs_link."' target='_blank'>More Information</a></div>";
?>							
				</div><!-- end col -->						
				<div class='col-sm-6 col-md-6 col-lg-6'>
<?php
					if ($vs_description = $t_item->get('ca_entities.biography')) {
						print "<div >".$vs_description."</div>";
					}									
?>					
				</div><!-- end col -->
				<div class='col-sm-4 col-md-4 col-lg-4'>
					{{{map}}}	
					<hr>
<?php
					if ($vs_brand = $t_item->get('ca_entities.brand', array('convertCodesToDisplayText' => true))) {
						print "<div class='unit'><h6>Brand Names</h6>".$vs_brand."</div>";
					}
					if ($vs_founded = $t_item->get('ca_entities.entity_founded')) {
						print "<div class='unit'><h6>Date Founded</h6>".$vs_founded."</div>";
					}
					if ($vs_inc = $t_item->get('ca_entities.entity_incorporated')) {
						print "<div class='unit'><h6>Date incorporated</h6>".$vs_inc."</div>";
					}					
					if ($vs_liq = $t_item->get('ca_entities.entity_liquidated')) {
						print "<div class='unit'><h6>Date of liquidation</h6>".$vs_liq."</div>";
					}
					
?>
					{{{<ifcount code="ca_collections" min="1" max="1"><H6>Related collection</H6></ifcount>}}}
					{{{<ifcount code="ca_collections" min="2"><H6>Related collections</H6></ifcount>}}}
					{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit>}}}
					
					{{{<ifcount code="ca_entities.related" min="1" max="1"><H6>Related person</H6></ifcount>}}}
					{{{<ifcount code="ca_entities.related" min="2"><H6>Related people</H6></ifcount>}}}
					{{{<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.related.preferred_labels.displayname</l></unit>}}}
					
					{{{<ifcount code="ca_occurrences" min="1" max="1"><H6>Related occurrence</H6></ifcount>}}}
					{{{<ifcount code="ca_occurrences" min="2"><H6>Related occurrences</H6></ifcount>}}}
					{{{<unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l></unit>}}}
					
					{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
					{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
					{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l></unit>}}}	
					
													
				</div>

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
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->
</div><!-- end container -->