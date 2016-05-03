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
					<H5>{{{<ifdef code='ca_entities.nonpreferred_labels'><span>Also known as: </span>^ca_entities.nonpreferred_labels.displayname</ifdef>}}}</H5>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-sm-6'>
<?php
					if ($va_birthplace = $t_item->get('ca_places.preferred_labels', array('restrictToRelationshipTypes' => array('birthplace')))) {
						print "<div class='unit'><h8>Birthplace</h8>".$va_birthplace."</div>";
					}
					if ($va_bio = $t_item->get('ca_entities.biography')) {
						print "<div class='unit'><h8>Biography</h8>".$va_bio."</div>";
					}
					if ($va_admin_hist = $t_item->get('ca_entities.administrative_history')) {
						print "<div class='unit'><h8>Administrative History</h8>".$va_admin_hist."</div>";
					}						
					if ($va_public_notes = $t_item->get('ca_entities.public_notes')) {
						print "<div class='unit'><h8>Notes</h8>".$va_public_notes."</div>";
					}
					if ($va_website = $t_item->get('ca_entities.entity_website')) {
						print "<div class='unit'><h8>Website</h8><a href='".$va_website."' target='_blank'>".$va_website."</a></div>";
					}
?>
					
				</div><!-- end col -->
				<div class='col-sm-6'>
					{{{map}}}
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
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->