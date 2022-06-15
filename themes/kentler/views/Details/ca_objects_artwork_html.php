<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vb_removed = false;
	if(strtolower($t_object->get("ca_objects.removed.removal_text", array("convertCodesToDisplayText" => true))) == "yes"){
		$vb_removed = true;
	}
	if($t_object->get("ca_objects.is_deaccessioned")){
		$vb_removed = true;
	}
	if($t_object->get("ca_entities.entity_id", array("restrictToRelationshipTypes" => array("sold")))){
		$vb_removed = true;
	}
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
<?php
				if($vb_removed && $this->getVar("representation_id")){
					print "<div class='text-right'><small>No longer available</small></div>";
				}
?>
			</div><!-- end col -->
			
			<div class='col-sm-6'>
				<H1><span class="ltgrayText">Flatfile Artwork</span><br/><i>{{{^ca_objects.preferred_labels.name}}}</i></H1>
				<H4>{{{<unit relativeTo="ca_entities" delimiter=", " restrictToRelationshipTypes="artist"><l>^ca_entities.preferred_labels.displayname</l></unit>}}}</H4>
				<HR/>
<?php
				$vs_medium = "";
				if($t_object->get("medium_text")){
					$vs_medium = $t_object->get("medium_text");
				}else{
					#if($t_object->get("category")){
					#	$vs_medium = $t_object->get("category", array("delimiter" => ", ", "convertCodesToDisplayText" => true));
					#}
					#if($t_object->get("category") && $t_object->get("medium")){
					#	$vs_medium .= " > ";
					#}
					if($t_object->get("medium")){
						$vs_medium .= $t_object->get("medium", array("delimiter" => ", ", "convertCodesToDisplayText" => true));
					}
				}
				if($vs_medium){
					print "<H6>Medium</H6>".$vs_medium."<br/>";
				}
?>
				{{{<ifdef code="ca_objects.date"><H6>Date</H6>^ca_objects.date<br/></ifdev>}}}
				{{{<ifdef code="ca_objects.dimensions.dimensions_height|ca_objects.dimensions.dimensions_width|ca_objects.dimensions.dimensions_length"><H6>Dimensions</H6><ifdef code="ca_objects.dimensions.dimensions_height">^ca_objects.dimensions.dimensions_height</ifdef><ifdef code="ca_objects.dimensions.dimensions_width"> X ^ca_objects.dimensions.dimensions_width</ifdef><ifdef code="ca_objects.dimensions.dimensions_length"> X ^ca_objects.dimensions.dimensions_length</ifdef><br/></ifdef>}}}
<?php
				if($vb_removed && !$this->getVar("representation_id")){
					print "<br/>No longer available<br/>";
				}
				$vs_collections = $t_object->get("ca_collections");
				if(!(stripos($vs_collections, "Red Hook") === False)){
					print "<H6>Part of the Red Hook Archives</H6>";
				}
?>
				{{{<ifcount code="ca_occurrences" min="1" max="1"><HR/><H6>Related exhibition</H6></ifcount>}}}
				{{{<ifcount code="ca_occurrences" min="2"><HR/><H6>Related exhibitions</H6></ifcount>}}}
				{{{<unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l></unit>}}}
				
				{{{<ifcount code="ca_objects.related" restrictToTypes="audio,video" min="1"><HR/><H6>Related Audio/Video</H6></ifcount>
					<unit relativeTo="ca_objects.related" restrictToTypes="audio,video" delimiter="<br/>"><l>^ca_objects.preferred_labels.name</l></unit>}}}
<?php
				if(!$vb_removed && $t_object->get("price")){
					#print "<HR/><H6>Price</H6>".$t_object->get("price")."<br/>";
				}
?>
			</div><!-- end col -->
			<div class='navLeftRight col-sm-2'>
				<div class="detailNavBgRight">
					{{{previousLink}}}{{{resultsLink}}}<div style='clear:right;'>{{{nextLink}}}</div>
				</div><!-- end detailNavBgLeft -->
			</div><!-- end col -->
		</div><!-- end row -->
	</div><!-- end col -->
</div><!-- end row -->