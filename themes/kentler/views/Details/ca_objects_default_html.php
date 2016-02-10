<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='col-xs-12 col-sm-12'>
		<div class="row">
			<div class='col-sm-4'>
				{{{representationViewer}}}
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
				<div id="detailTools">
					<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
				</div><!-- end detailTools -->
			</div><!-- end col -->
			
			<div class='col-sm-6'>
				<H1><span class="ltgrayText">Flatfile Artwork</span><br/>{{{ca_objects.preferred_labels.name}}}</H1>
				<H4>{{{<unit relativeTo="ca_entities" delimiter=", " restrictToRelationshipTypes="artist"><l>^ca_entities.preferred_labels.displayname</l></unit>}}}</H4>
				<HR/>
<?php
				$vs_medium = "";
				if($t_object->get("medium_text")){
					$vs_medium = $t_object->get("medium_text");
				}else{
					if($t_object->get("category")){
						$vs_medium = $t_object->get("category");
					}
					if($t_object->get("category") && $t_object->get("medium")){
						$vs_medium .= " > ";
					}
					if($t_object->get("medium")){
						$vs_medium .= $t_object->get("medium");
					}
				}
				if($vs_medium){
					print "<H6>Medium</H6>".$vs_medium."<br/>";
				}
?>
				{{{<ifdef code="ca_objects.date"><H6>Date</H6>^ca_objects.date<br/></ifdev>}}}
				{{{<ifdef code="ca_objects.dimensions.dimensions_height|ca_objects.dimensions.dimensions_width"><H6>Dimensions</H6></ifdef><ifdef code="ca_objects.dimensions.dimensions_height">^ca_objects.dimensions.dimensions_height X </ifdef><ifdef code="ca_objects.dimensions.dimensions_width">^ca_objects.dimensions.dimensions_width<br/></ifdef>}}}
				{{{<ifdef code="ca_objects.artwork_tags"><HR/><H6>Tags</H6><unit delimiter=", ">^ca_objects.artwork_tags</unit><br/></ifdef>}}}
		
				{{{<ifcount code="ca_occurrences" min="1" max="1"><HR/><H6>Related exhibition</H6></ifcount>}}}
				{{{<ifcount code="ca_occurrences" min="2"><HR/><H6>Related exhibitions</H6></ifcount>}}}
				{{{<unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l></unit>}}}
			</div><!-- end col -->
			<div class='navLeftRight col-sm-2'>
				<div class="detailNavBgRight">
					{{{resultsLink}}}{{{previousLink}}}{{{nextLink}}}
				</div><!-- end detailNavBgLeft -->
			</div><!-- end col -->
		</div><!-- end row -->
	</div><!-- end col -->
</div><!-- end row -->