<?php
	$t_object = 			$this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$vn_id =				$t_object->get('ca_objects.object_id');

?>
		<div class="row">
			<div class='col-xs-12 navTop'>
				{{{previousLink}}}{{{nextLink}}}<br/>{{{resultsLink}}}
			</div><!-- end detailTop -->
		</div>
		<div class="row">
			<div class='col-sm-6 col-md-6'>
				{{{representationViewer}}}
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
<?php
				if ($va_credit_line = $t_object->get('ca_objects.credit_line')) {
					print "<div class='creditLine'>".$va_credit_line."</div>";
				}	
?>
<?php
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled | $vn_pdf_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment" aria-label="<?php print _t("Comments and tags"); ?>"></span>Comments and Tags (<?php print sizeof($va_comments) + sizeof($va_tags); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt" aria-label="'._t("Share").'"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					if ($vn_pdf_enabled) {
						print "<div class='detailTool'><span class='glyphicon glyphicon-file' aria-label='"._t("Download")."'></span>".caDetailLink($this->request, "Download as PDF", "faDownload", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
					}
					print '</div><!-- end detailTools -->';
				}				

?>			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6'>
				<div class="unit">{{{<ifdef code="ca_objects.idno">^ca_objects.idno</ifdef>}}}</div>
				
				<H1>{{{ca_objects.preferred_labels.name}}}</H1>
				<div class="unit large">
				{{{<ifcount code="ca_entities.preferred_labels" relativeTo="ca_entities" restrictToRelationshipTypes="creator" min="1"><div><unit relativeTo="ca_entities" restrictToRelationshipTypes="creator" delimiter="<br />"><l>^ca_entities.preferred_labels</l></unit></div></ifcount>}}}		
				{{{<ifcount code="ca_entities.preferred_labels" relativeTo="ca_entities" restrictToRelationshipTypes="after" min="1"><div><unit relativeTo="ca_entities" restrictToRelationshipTypes="after" delimiter="<br />"><l>after ^ca_entities.preferred_labels</l></unit></div></ifcount>}}}					
				
				{{{<ifdef code="ca_objects.date.date_value"><div><unit relativeTo='ca_objects.date' delimiter="<br/>">^ca_objects.date.date_value (^ca_objects.date.date_types)</unit></div></ifdef>}}}
				
				</div>
				<HR>
				{{{<ifdef code="ca_objects.medium"><div class="unit"><label>Medium</label>^ca_objects.medium%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.technique"><div class="unit"><label>Technique</label> ^ca_objects.technique</div></ifdef>}}}
				{{{<ifdef code="ca_objects.type"><div class="unit"><label>Type</label>^ca_objects.type</div></ifdef>}}}
				
				{{{<ifcount min="1" code="ca_objects.dimensions">
				<div class="unit"><label>Dimensions</label>
				<unit relativeTo="ca_objects.dimensions" delimiter="<br/>">
					<ifdef code="ca_objects.dimensions.dimensions_length">^ca_objects.dimensions.dimensions_length L</ifdef>
					<ifdef code="ca_objects.dimensions.dimensions_length,ca_objects.dimensions.dimensions_width"> x </ifdef>
					<ifdef code="ca_objects.dimensions.dimensions_width">^ca_objects.dimensions.dimensions_width W</ifdef>
					<ifdef code="ca_objects.dimensions.dimensions_width,ca_objects.dimensions.dimensions_height"> x </ifdef>
					<ifdef code="ca_objects.dimensions.dimensions_height">^ca_objects.dimensions.dimensions_height H</ifdef>
					<ifdef code="ca_objects.dimensions.dimensions_height,ca_objects.dimensions.dimensions_depth"> x </ifdef>
					<ifdef code="ca_objects.dimensions.dimensions_depth">^ca_objects.dimensions.dimensions_depth D</ifdef>
					<ifdef code="ca_objects.dimensions.measurement_type">(^ca_objects.dimensions.measurement_type%useSingular=1</ifdef><ifdef code="ca_objects.dimensions.measurement_type">)</ifdef> 	 				
					<ifdef code="ca_objects.dimensions.measurement_notes"><br/>Notes: ^ca_objects.dimensions.measurement_notes</ifdef>
				</unit>
				</div></ifcount>}}}
				
				{{{<ifdef code="ca_objects.culture"><div class="unit"><label>Culture</label>^ca_objects.culture</div></ifdef>}}}
								
				{{{<ifdef code="ca_objects.description">
					<div class="unit"><label>Description</label><span class="trimText">^ca_objects.description</span></div>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.exhibition_label">
					<div class="unit"><label>Exhibition Label</label><unit relativeTo="ca_objects.exhibition_label" delimiter="<br/><br/>"><span class="trimText">^ca_objects.exhibition_label</span></unit></div>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.object_status"><div class="unit"><label>Status</label>^ca_objects.object_status</div></ifdef>}}}
				{{{<ifdef code="ca_objects.provenance"><div class="unit"><label>Provenance</label>^ca_objects.provenance</div></ifdef>}}}
				{{{<ifdef code="ca_objects.publication_notes"><div class="unit"><label>Bibliography</label>^ca_objects.publication_notes</div></ifdef>}}}
				
				<div style='margin-top:15px;'><i>Please note that cataloging is ongoing and that some information may not be complete.</i></div>				
				<hr></hr>	
				<!-- {{{<ifcount relativeTo="ca_entities" code="ca_entities.preferred_labels" min="1"><H6>Related people</label><unit relativeTo="ca_objects_x_entities" delimiter="<br/>">^ca_entities.preferred_labels.displayname (^relationship_typename)</unit></ifcount>}}}-->
				
				{{{<ifcount code="ca_places" min="1"><div class="unit"><label><ifcount code="ca_places" min="1" max="1">Related place</ifcount><ifcount code="ca_places" min="2">s</ifcount></label>
					<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l></unit></div></ifcount>}}}
				
				{{{<ifcount code="ca_list_items"><div class="unit"><label><ifcount code="ca_list_items" min="1" max="1">Related Term</ifcount><ifcount code="ca_list_items" min="2">s</ifcount></label>
					<unit relativeTo="ca_list_items" delimiter="<br/>">^ca_list_items.preferred_labels.name_plural</unit></div></ifcount>}}}
				
				{{{<ifcount code="ca_objects.LcshNames" min="1"><div class="unit"><label>LC Terms</label><unit delimiter="<br/>"><l>^ca_objects.LcshNames</l></unit></div></ifcount>}}}
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