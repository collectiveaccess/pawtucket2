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
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-sm-6 col-md-6 col-lg-6'>
					<H6>{{{^ca_entities.type_id}}}{{{<ifdef code="ca_entities.idno">, ^ca_entities.idno</ifdef>}}}</H6>
				
					{{{<ifdef code="ca_entities.year_founded"><H6>Year Founded</H6>^ca_entities.year_founded<br/></ifdef>}}}
					{{{<ifdef code="ca_entities.notes"><H6>About</H6>^ca_entities.notes<br/></ifdef>}}}
					{{{<ifdef code="ca_entities.lifetime"><H6>Lifetime</H6>^ca_entities.lifetime<br/></ifdef>}}}
					{{{<ifcount min="1" code="ca_entities.website"><H6>Website:</H6><unit delimiter="<br/>"><a href='^ca_entities.website' target='_blank'>^ca_entities.website</a></unit></ifdef>}}}			
					{{{<ifdef code="ca_entities.bio"><H6>Biography</H6>^ca_entities.bio<br/></ifdef>}}}
<?php
					if ($t_item->get('ca_entities.address.city') || $t_item->get('ca_entities.address.stateprovince') || $t_item->get('ca_entities.address.country')) {
						print "<h6>Location</h6>";
						$va_city = $t_item->get('ca_entities.address.city');
						$va_state = $t_item->get('ca_entities.address.stateprovince');
						$va_country = $t_item->get('ca_entities.address.country');
						print $va_city.($va_city && $va_state ? ", " : "").$va_state.($va_state && $va_country ? ", " : "").$va_country;
					}
?>										
					
				</div><!-- end col -->
				<div class='col-sm-6 col-md-6 col-lg-6'>
<?php
					if ($va_media_rep = $t_item->get('ca_object_representations.media.preview')) {
						print "<div style='width:100%; text-align:center;'>".$va_media_rep."</div>";
					}
?>				
					{{{<ifcount code="ca_entities.related" min="1" max="1"><H6>Related person</H6></ifcount>}}}
					{{{<ifcount code="ca_entities.related" min="2"><H6>Related people</H6></ifcount>}}}
					{{{<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.related.preferred_labels.displayname</l></unit>}}}	

					{{{<ifcount code="ca_list_items" min="1"><H6>Tags</H6></ifcount>}}}
					{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_list_items.preferred_labels.name</l></unit>}}}				
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">
				<div class='col-sm-12 col-md-12 col-lg-12'>
<?php
					if ($va_description = $t_item->get('ca_entities.description')) {
						print "<h6>Description</h6>".$va_description;
					}
?>
					<div id="detailTools">
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
						<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
					</div><!-- end detailTools -->				
				</div>
			</div>
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