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
				<div class='col-md-12 col-lg-12'>
					<H4>{{{^ca_occurrences.preferred_labels.name}}}</H4>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-md-6 col-lg-6'>
<?php
				if ($va_exhibit_date = $t_item->getWithTemplate('<unit delimiter="<br/>">^ca_occurrences.exhibit_date.start - ^ca_occurrences.exhibit_date.end (^ca_occurrences.exhibit_date.exhibit_type_NEW)</unit>')) {
					print "<div class='unit'><h6>Exhibit Date</h6>".$va_exhibit_date."</div>";
				}
				if ($va_venue_name = $t_item->getWithTemplate('<unit delimiter="<br/>">^ca_occurrences.exhibit_venue.exhibit_venue (^ca_occurrences.exhibit_venue.venue_type)</unit>')) {
					print "<div class='unit trimText'><h6>Venues</h6>".$va_venue_name."</div>";
				}
				if ($va_ex_desc = $t_item->get('ca_occurrences.event_description')) {
					print "<div class='unit'><h6>Exhibit Description</h6>".$va_ex_desc."</div>";
				}
				if ($va_exhibitions = $t_item->get('ca_occurrences.related', array('returnWithStructure' => true, 'sort' => 'ca_occurrences.preferred_labels'))) {
					print "<div class='unit trimText'><h6>Related Exhibitions</h6>";
					foreach ($va_exhibitions as $va_id => $va_exhibition) {
						print "<div>".caNavLink($this->request, $va_exhibition['label'], '', 'Detail', 'entities', $va_exhibition['occurrence_id'])." (".$va_exhibition['relationship_typename'].")</div>";
					}
					print "</div>";
				}
								
?>
					
				</div><!-- end col -->
				<div class='col-md-6 col-lg-6'>
<?php

					if ($va_collections = $t_item->getWithTemplate('<unit delimiter="<br/>" relativeTo="ca_collections"><l>^ca_collections.preferred_labels</l> (^relationship_typename)</unit>')) {
						print "<div class='unit trimText'><h6>Related collections</h6>".$va_collections."</div>";
					}
					if ($va_entities = $t_item->getWithTemplate('<unit delimiter="<br/>" relativeTo="ca_entities"><l>^ca_entities.preferred_labels</l> (^relationship_typename)</unit>')) {
						print "<div class='unit trimText'><h6>Related entities</h6>".$va_entities."</div>";
					}
															
?>					
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
</div><!-- end row -->

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 116
		});
	});
</script>