<?php
if(!$this->request->isLoggedIn()){
	print "do redirect";
}else{

	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
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
					<H2 class="uk-h1">{{{^ca_occurrences.preferred_labels.name}}}</H2>
					<hr/>
				
					{{{<ifdef code="ca_occurrences.idno"><div class="unit"><label>Identifier</label>^ca_occurrences.idno</div></ifdef>}}}
					{{{<ifdef code="ca_occurrences.repatriation_status"><div class="unit"><label>Status</label>^ca_occurrences.repatriation_status</div></ifdef>}}}
					{{{<ifdef code="ca_occurrences.repat_type"><div class="unit"><label>Repatriation Type</label>^ca_occurrences.repat_type</div></ifdef>}}}
					{{{<ifdef code="ca_occurrences.min_number"><div class="unit"><label>Minimum Number of Individuals</label>^ca_occurrences.min_number</div></ifdef>}}}
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="repatriating_entity" min="1">
						<div class="unit"><label>Holding Institution</label>
						<unit relativeTo="ca_entities" restrictToRelationshipTypes="repatriating_entity" delimiter="<br>">
							^ca_entities.preferred_labels.displayname
						</unit>
						</div>
					</ifcount>}}}
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="potential_claimant" min="1">
						<div class="unit"><label>Potential Claimant<ifcount code="ca_entities" restrictToRelationshipTypes="potential_claimant" min="2">s</ifcount></label>
						<unit relativeTo="ca_entities" restrictToRelationshipTypes="potential_claimant" delimiter="<br>">
							^ca_entities.preferred_labels.displayname
						</unit>
						</div>
					</ifcount>}}}
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="claimant" min="1">
						<div class="unit"><label>Final Claimant</label>
						<unit relativeTo="ca_entities" restrictToRelationshipTypes="claimant" delimiter="<br>">
							^ca_entities.preferred_labels.displayname
						</unit>
						</div>
					</ifcount>}}}
					{{{<ifdef code="ca_occurrences.repat_notes"><div class="unit"><label>Notes</label>^ca_occurrences.repat_notes</div></ifdef>}}}
					
<?php
				# Download or Inquire		
				print '<div id="detailTools">';
				if ($vn_pdf_enabled) {
					print "<div class='detailTool'><span class='glyphicon glyphicon-file' aria-label='"._t("Download")."'></span>".caDetailLink($this->request, "Download as PDF", "faDownload", "ca_occurrences",  $t_item->get("ca_occurrences.occurrence_id"), array('view' => 'pdf', 'export_format' => '_pdf_ca_occurrences_summary'))."</div>";
				}
				print "<div class='detailTool'>".caNavLink($this->request, "<span class='glyphicon glyphicon-envelope'></span> Ask a Question", "", "", "Contact", "Form", array("inquire_type" => "item_inquiry", "table" => "ca_occurrences", "id" => $t_item->get("ca_occurrences.occurrence_id")))."</div>";
				
				print '</div><!-- end detailTools -->';				
?>
					
				</div><!-- end col -->
			</div><!-- end row -->
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
<?php
	}
?>