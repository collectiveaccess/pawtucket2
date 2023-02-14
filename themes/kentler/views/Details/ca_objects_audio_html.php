<?php
	# --- detail for audio records
	
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$va_access_values = caGetUserAccessValues($this->request);

?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='col-xs-12 col-sm-12'>
		<div class="row">
			<div class='col-sm-10'>
				
				<div class="row">
<?php			
					$va_object_ids = $t_object->get("ca_objects.related.object_id", array("returnAsArray" => true, "checkAccess" => $va_access_values, "sort" => "ca_entities.preferred_labels.surname"));
					$q_artworks = caMakeSearchResult("ca_objects", $va_object_ids);
					if($q_artworks->numHits()){
						print "<div class='col-sm-7 col-sm-offset-5'>";
					}else{
						print "<div class='col-sm-12'>";
					}
?>
					{{{representationViewer}}}
				
					<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
					</div>
				</div>
				<div class="row">
<?php			
				if($q_artworks->numHits()){
					print "<div class='col-sm-5'>";
					while($q_artworks->nextHit()){
						$vs_image = "";
						$vs_image = $q_artworks->get('ca_object_representations.media.large', array("checkAccess" => $va_access_values));
						$vb_no_rep = false;
						if(!$vs_image){
							$vs_image = "<div class='dontScale detailPlaceholder'>".caGetThemeGraphic($this->request, 'KentlerLogoWhiteBG.jpg')."</div>";
							$vb_no_rep = true;
						}
						$vs_caption = "";
						if($vs_artist = $q_artworks->get('ca_entities.preferred_labels.displayname', array("restrictToRelationshipTypes" => array("artist"), 'checkAccess' => $va_access_values))){
							$vs_caption = $vs_artist.", ";
						}
						$vs_caption .= "<i>".$q_artworks->get("ca_objects.preferred_labels.name")."</i>, ";
						
						if($q_artworks->get("ca_objects.date")){
							$vs_caption .= $q_artworks->get("ca_objects.date").", ";
						}
						$vs_medium = "";
						if($q_artworks->get("medium_text")){
							$vs_medium = $q_artworks->get("medium_text");
						}else{
							if($q_artworks->get("medium")){
								$vs_medium .= $q_artworks->get("medium", array("delimiter" => ", ", "convertCodesToDisplayText" => true));
							}
						}
						if($vs_medium){
							$vs_caption .= $vs_medium.", ";
						}					
						if($q_artworks->get("ca_objects.dimensions")){
							$vs_caption .= $q_artworks->get("ca_objects.dimensions.dimensions_height")." X ".$q_artworks->get("ca_objects.dimensions.dimensions_width").(($q_artworks->get("ca_objects.dimensions.dimensions_length") ? " X ".$q_artworks->get("ca_objects.dimensions.dimensions_length") : "")).". ";
						}
						$vs_label_detail_link 	= caDetailLink($this->request, $vs_caption, '', 'ca_objects', $q_artworks->get("ca_objects.object_id"));
						$tmp = array("image" => $vs_image, "label" => $vs_label_detail_link, "image_link" => ($vb_no_rep) ? $vs_image : "<a href='' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaOverlay', array('context' => 'objects', 'id' => $q_artworks->get("ca_objects.object_id"), 'representation_id' => $q_artworks->get("ca_object_representations.representation_id", array("checkAccess" => $va_access_values)), 'overlay' => 1))."\"); return false;' >".$vs_image."</a>");
					
						print '<div class="fullWidthImg">'.$tmp["image_link"];
						#if($tmp["label"]){
						#	print "<br/><small>".$tmp["label"]."</small>";
						#}
						print "</div></div><!-- end col --><div class='col-sm-7'>";
					}
				}else{
					print "<div class='col-sm-12'>";
				}
?>					
				
			
			
			
						<!--<H1>{{{<unit relativeTo="ca_entities" delimiter=", " restrictToRelationshipTypes="creator">^ca_entities.preferred_labels.displayname</unit>}}}</H1>
						<H4>{{{^ca_objects.preferred_labels.name}}}</H4>
						<HR/>-->

						{{{<ifdef code="ca_objects.date"><H6>Date</H6>^ca_objects.date<br/></ifdev>}}}
				
						{{{<ifdef code="ca_objects.description">^ca_objects.description<br/></ifdev>}}}
				
				
						{{{<ifcount code="ca_entities" min="1" max="1"><HR/><H6>Related person</H6></ifcount>
							<ifcount code="ca_entities" min="2"><HR/><H6>Related people</H6></ifcount>
							<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit>}}}
				
						{{{<ifcount code="ca_occurrences" min="1" max="1"><HR/><H6>Related exhibition</H6></ifcount>}}}
						{{{<ifcount code="ca_occurrences" min="2"><HR/><H6>Related exhibitions</H6></ifcount>}}}
						{{{<unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l></unit>}}}
			
					</div>
				</div>
			
			
			</div><!-- end col -->
			<div class='navLeftRight col-sm-2'>
				<div class="detailNavBgRight">
					{{{previousLink}}}{{{resultsLink}}}<div style='clear:right;'>{{{nextLink}}}</div>
				</div><!-- end detailNavBgLeft -->
			</div><!-- end col -->
		</div><!-- end row -->
	</div><!-- end col -->
</div><!-- end row -->