<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
	$vn_id = $t_item->get('ca_occurrences.occurrence_id');
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
					<H6>{{{^ca_occurrences.type_id}}}{{{<ifdef code="ca_occurrences.idno">, ^ca_occurrences.idno</ifdef>}}}</H6>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-sm-6 col-md-6 col-lg-6'>
<?php
					if ($vs_pub_type = $t_item->get('ca_occurrences.bib_types', array('convertCodesToDisplayText' => true))) {
						print "<div class='unit'><h6>Type of Material</h6>".$vs_pub_type."</div>";
					}
					if ($vs_title = $t_item->get('ca_occurrences.preferred_labels')) {
						print "<div class='unit'><h6>Title</h6>".$vs_title."</div>";
					}	
					if ($vs_author = $t_item->get('ca_occurrences.author', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><h6>Author</h6>".$vs_author."</div>";
					}
					if ($vs_date = $t_item->get('ca_occurrences.occurrence_dates')) {
						print "<div class='unit'><h6>Date</h6>".$vs_date."</div>";
					}
					if ($vs_venue = $t_item->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('venue'), 'returnAsLink' => true))) {
						print "<div class='unit'><h6>Venue</h6>".$vs_venue."</div>";
					}
					if ($vs_entities = $t_item->get('ca_entities.preferred_labels', array('excludeRelationshipTypes' => array('venue'), 'returnAsLink' => true, 'delimiter' => ', '))) {
						print "<div class='unit'><h6>Related People & Organizations</h6>".$vs_entities."</div>";
					}					
					if ($vs_travel = $t_item->get('ca_occurrences.traveling_yn', array('convertCodesToDisplayText' => true))) {
						print "<div class='unit'><h6>Traveling Exhibition?</h6>".$vs_travel."</div>";
					}						
					if ($vs_edition = $t_item->get('ca_occurrences.edition_bib', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><h6>Edition</h6>".$vs_edition."</div>";
					}
					if ($vs_volume = $t_item->get('ca_occurrences.volume')) {
						print "<div class='unit'><h6>Volume</h6>".$vs_volume."</div>";
					}
					if ($vs_number = $t_item->get('ca_occurrences.number')) {
						print "<div class='unit'><h6>Number</h6>".$vs_number."</div>";
					}
					if ($vs_pages = $t_item->get('ca_occurrences.pages')) {
						print "<div class='unit'><h6>Pages</h6>".$vs_pages."</div>";
					}
					if ($vs_isbn = $t_item->get('ca_occurrences.isbn')) {
						print "<div class='unit'><h6>ISBN</h6>".$vs_isbn."</div>";
					}
					if ($vs_notes = $t_item->get('ca_occurrences.notes')) {
						print "<div class='unit'><h6>Notes</h6>".$vs_notes."</div>";
					}																																								
?>	
				</div><!-- end col -->
				<div class='col-md-6 col-lg-6'>
<?php
					print "<div class='detailTool'><span class='glyphicon glyphicon-file'></span>".caDetailLink($this->request, "Download as PDF", "faDownload", "ca_occurrences",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_occurrences_summary'))."</div>";
?>				
					{{{representationViewer}}}
				</div><!-- end col -->
			</div><!-- end row -->
{{{<ifcount code="ca_objects" min="1">
			<div class="row">
				<hr>
				<h4>Related Artworks</h4>
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