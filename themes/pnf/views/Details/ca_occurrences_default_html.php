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
					<H4>{{{^ca_occurrences.preferred_labels.name}}}</H4>
					<H6>{{{^ca_occurrences.type_id}}}</H6>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-sm-12 '>
<?php
					if ($vs_idno = $t_item->get('ca_occurrences.idno')) {
						print "<div class='unit'><h6>"._t("Identifier")."</h6>".$vs_idno."</div>";
					}
					if ($vs_author = $t_item->get('ca_occurrences.author')) {
						print "<div class='unit'><h6>"._t("Author")."</h6>".$vs_author."</div>";
					}
					if ($vs_title = $t_item->get('ca_occurrences.preferred_labels')) {
						print "<div class='unit'><h6>"._t("Title")."</h6>".$vs_title."</div>";
					}					
					if ($vs_info = $t_item->get('ca_occurrences.publication_info')) {
						print "<div class='unit'><h6>"._t("Publication Information")."</h6>".$vs_info."</div>";
					}
					if ($vs_notes = $t_item->get('ca_occurrences.internal_notes')) {
						print "<div class='unit'><h6>"._t("Notes")."</h6>".$vs_notes."</div>";
					}
					if ($vs_link = $t_item->get('ca_occurrences.occurrence_link')) {
						print "<div class='unit'><h6>"._t("Link")."</h6><a href='".$vs_link."' target='_blank'>".$vs_link."</a></div>";
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
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'occurrence_id:^ca_occurrences.occurrence_id', 'view' => 'list'), array('dontURLEncodeParameters' => true)); ?>", function() {
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
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->