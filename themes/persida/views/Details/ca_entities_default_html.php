<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
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
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-sm-6 col-md-6 col-lg-6'>
<?php
					if ($va_lifespan = $t_item->get('ca_entities.lifespan')) {
						print "<div class='unit'>".$va_lifespan."</div>";
					}
					if ($va_entity_notes = $t_item->get('ca_entities.entity_notes', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><h6>Entity Notes</h6>".$va_entity_notes."</div>";
					}
					if ($va_entities = $t_item->get('ca_entities.related.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>'))) {
						print "<div class='unit'><h6>Related People & Organizations</h6>".$va_entities."</div>";
					}	
					if ($va_exhibitions = $t_item->get('ca_occurrences.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>', 'restrictToTypes' => array('exhibition')))) {
						print "<div class='unit'><h6>Related Exhibitions</h6>".$va_exhibitions."</div>";
					}													
?>
					
				</div><!-- end col -->
				<div class='col-sm-6 col-md-6 col-lg-6'>
<?php

?>				
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
<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>