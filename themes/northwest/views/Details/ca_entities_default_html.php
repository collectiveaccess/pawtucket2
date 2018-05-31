<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
	
	$t_list = new ca_lists();
	$vn_type_id = $t_item->get('ca_entities.type_id');
	$vn_ind_type_id = $t_list->getItemIDFromList("entity_types", "ind");
	$vn_org_type_id = $t_list->getItemIDFromList("entity_types", "org");
?>
<div class="row">
	<div class='col-xs-12 navButtons'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='col-xs-12 '>
		<div class="container">
			<div class="row">
				<div class='col-md-12 col-lg-12'>
					<H4 style='padding-bottom:0px;'>{{{^ca_entities.preferred_labels.displayname}}}</H4>
<?php
					if ($vn_type_id == $vn_ind_type_id) {
						print "<h6 style='padding-bottom:30px;margin-top:5px;'>Person</h6>";
					} else {
						print "<h6 style='padding-bottom:30px;margin-top:5px;'>Organization</h6>";
					}
?>					
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-sm-6 col-md-6 col-lg-6'>
<?php
				if ($vn_type_id == $vn_ind_type_id) { // Metadata for individuals
					if ($vs_lifetime = $t_item->get('ca_entities.lifespan')) {
						print "<div class='unit'><h6>Dates</h6>".$vs_lifetime."</div>";
					}
					if ($vs_biography = $t_item->get('ca_entities.biography')) {
						print "<div class='unit'><h6>Biographical Note</h6>".$vs_biography."</div>";
					}	
				} else {  // Metadata for organizations
					if ($vs_lifetime = $t_item->get('ca_entities.org_lifetime', array('delimiter' => ', '))) {
						print "<div class='unit'><h6>Dates</h6>".$vs_lifetime."</div>";
					}
					if ($vs_biography = $t_item->get('ca_entities.biography')) {
						print "<div class='unit'><h6>Historical note</h6>".$vs_biography."</div>";
					}				
				}				
?>
					
				</div><!-- end col -->
				<div class='col-sm-5 col-sm-offset-1'>
					
					{{{<ifcount code="ca_collections" min="1" ><H6>Related Holdings</H6></ifcount>}}}
					{{{<unit relativeTo="ca_entities_x_collections" delimiter=" "><unit relativeTo="ca_collections"><div class='relTitle'><l>^ca_collections.preferred_labels.name</l></div></unit></unit>}}}

<!--					
					{{{<ifcount code="ca_entities.related" min="1" max="1"><H2>Related person</H2></ifcount>}}}
					{{{<ifcount code="ca_entities.related" min="2"><H2>Related people</H2></ifcount>}}}
					{{{<unit relativeTo="ca_entities.related" delimiter="<br/>"><unit relativeTo="ca_entities" delimiter="<br/>"><div class='relTitle'><l>^ca_entities.related.preferred_labels</l></div></unit> </unit>}}}
					
					{{{<ifcount code="ca_occurrences" min="1" max="1"><H2>Related occurrence</H2></ifcount>}}}
					{{{<ifcount code="ca_occurrences" min="2"><H2>Related occurrences</H2></ifcount>}}}
					{{{<unit relativeTo="ca_entities_x_occurrences" delimiter="<br/>"><unit relativeTo="ca_occurrences" delimiter="<br/>"><div class='relTitle'><l>^ca_occurrences.preferred_labels.name</l></div></unit> </unit>}}}
-->					
				
				</div><!-- end col -->
			</div><!-- end row -->
			
{{{<ifcount code="ca_objects" min="1">
			<hr/>
			<h4>Related Items</h4>
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
<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>