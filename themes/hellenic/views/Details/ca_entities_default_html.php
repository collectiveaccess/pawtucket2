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
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-sm-6 col-md-6 col-lg-6'>
<?php
				if($vs_life_dates = $t_item->get('ca_entities.life_dates')) {
					print "<div class='unit'><h6>Life Dates</h6>".$vs_life_dates."</div>";
				}
				if($vs_founding_dates = $t_item->get('ca_entities.founding_dates')) {
					print "<div class='unit'><h6>Organization Dates</h6>".$vs_founding_dates."</div>";
				}	
				if($vs_biography = $t_item->get('ca_entities.biography')) {
					print "<div class='unit'><h6>Biography</h6>".$vs_biography."</div>";
				}
				if($vs_birthplace = $t_item->get('ca_entities.birthplace')) {
					print "<div class='unit'><h6>Birthplace</h6>".$vs_birthplace."</div>";
				}
				if($vs_entities = $t_item->get('ca_entities.related.preferred_labels', array('delimiter' => '<br/>', 'returnAsLink' => true))) {
					print "<div class='unit'><h6>Related Entities</h6>".$vs_entities."</div>";
				}
				if($vs_collections = $t_item->get('ca_collections.related.preferred_labels', array('delimiter' => '<br/>', 'returnAsLink' => true))) {
					print "<div class='unit'><h6>Related Collections</h6>".$vs_collections."</div>";
				}															
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