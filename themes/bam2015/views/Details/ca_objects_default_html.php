<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$t_list = new ca_lists();
	$pn_photo_object_type_id = $t_list->getItemIDFromList("object_types", "photograph");
	$pn_digi_photo_object_type_id = $t_list->getItemIDFromList("object_types", "born_digital_photograph");
	$va_access_values = caGetUserAccessValues($this->request);
	
	$va_rep = $t_object->getPrimaryRepresentation(array('bamlarge'), null, array('return_with_access' => $va_access_values));
	$va_rep_width = $va_rep['info']['bamlarge']['WIDTH'];
	$va_rep_height = $va_rep['info']['bamlarge']['HEIGHT'];
	$va_rep_type = $va_rep['mimetype'];
	$t_list_item = new ca_list_items();
	$t_list_item->load($t_object->get("type_id"));
	$vs_typecode = $t_list_item->get("idno");
	
	if($this->request->isAjax()){
		$o_icons_conf = caGetIconsConfig();
		$vs_type_placeholder = caGetPlaceholder($vs_typecode, "placeholder_media_icon");
		
		$t_rep = $this->getVar("t_representation");
		#if($va_rep_type == 'audio/mpeg'){
		#	$vs_detail_link = caDetailLink($this->request, "<div class='detailOverlayItemImgPlaceholder'>".$vs_type_placeholder."</div>", "", "ca_objects", $t_object->get("ca_objects.object_id"));
		#}else{
		if($t_rep){
			if(!is_array($va_media_display_info = caGetMediaDisplayInfo('related_object_overlay', $t_rep->getMediaInfo('media', 'original', 'MIMETYPE')))) { $va_media_display_info = []; }
			$va_opts = array('display' => 'related_object_overlay', 'object_id' => $t_object->get('object_id'), 'representation_id' => $t_rep->get('representation_id'), 'containerID' => 'caMediaPanelContentArea', 'access' => caGetUserAccessValues($this->request));
			
			
			
			$vs_rep = caRepresentationViewer(
						$this->request, 
						$t_object, 
						$t_object,
						array_merge($va_opts, $va_media_display_info, 
							array(
								'display' => 'related_object_overlay',
								'showAnnotations' => true, 
								'primaryOnly' => true, 
								'dontShowPlaceholder' => true, 
								'captionTemplate' => false
							)
						)
					);
			
			
			
			if($t_rep && (!in_array($va_rep_type, array('video/mp4', 'video/x-flv', 'video/mpeg', 'audio/x-realaudio', 'video/quicktime', 'video/x-ms-asf', 'video/x-ms-wmv', 'application/x-shockwave-flash', 'video/x-matroska')))){
				#$vs_detail_link = caDetailLink($this->request, $t_rep->getRepresentationViewerHTMLBundle($this->request, $va_opts), "", "ca_objects", $t_object->get("ca_objects.object_id"));
				$vs_detail_link = caDetailLink($this->request, $vs_rep, "", "ca_objects", $t_object->get("ca_objects.object_id"));
			}else{
				# --- don't make video a link
				#$vs_detail_link = $t_rep->getRepresentationViewerHTMLBundle($this->request, $va_opts);
				$vs_detail_link = $vs_rep;
			}
		}else{
			$vs_detail_link = caDetailLink($this->request, "<div class='detailOverlayItemImgPlaceholder' title='Copyright restricted, please contact archive'>".$vs_type_placeholder."</div>", "", "ca_objects", $t_object->get("ca_objects.object_id"));
		}
		#}
?>
		<div class="container">
			<div class="row">
				<div class="col-xs-12 detailOverlayClose">
					<div class="pointer" onclick="caMediaPanel.hidePanel(); return false;"><span class="icon-cross"></span></div>
				</div>
			</div><!-- end row -->
			<div class="row">
				<div class="col-xs-2 detailOverlayNav text-right">
<?php
					if($this->getVar("previousID")){
?>
					<a href='#' onclick='caMediaPanel.showPanel("<?php print caNavUrl($this->request, 'Detail', 'objects', $this->getVar("previousID"), array('overlay' => 1)); ?>"); return false;'><span class="icon-chevron-left"></span></a>
<?php
					}
?>
				</div>
				<div class="col-xs-8 detailOverlayImg text-center">
<?php
				if(($va_rep_width > $va_rep_height) || !$t_rep){
?>
					<span>
						<span class="detailOverlayImgOverlayContainer">
<?php	
							print $vs_detail_link;
?>
						
							<div class='detailOverlayImgCaption'>
								<div class="row">
									<div class="col-sm-9">
<?php
										print caDetailLink($this->request, "<span class='typeLabel'>".$t_object->get('ca_objects.type_id', array('convertCodesToDisplayText' => true))."</span> ".$t_object->get('ca_objects.preferred_labels'), "", "ca_objects", $t_object->get("ca_objects.object_id"));
?>							
									</div>
									<div class="col-sm-3 text-right">
<?php
										print caDetailLink($this->request, "Full Details&nbsp;&nbsp;<span class='icon-arrow-up-right'></span>", "full", "ca_objects", $t_object->get("ca_objects.object_id"));
?>							
									</div>
								</div><!-- end row -->
							</div><!-- end detailOverlayImgCaption -->
						</span>
					</span>
<?php
				}else{
?>
					<div class="row">
						<div class="col-sm-8 text-right">
<?php	
							print $vs_detail_link;
?>						
						</div>
						<div class="col-sm-4 text-left detailOverlayImgCaptionVert">
							<div class='detailOverlayImgCaption'>
<?php
										$vs_type = "";
										if($vs_typecode == "promotional"){
											$vs_type = $t_object->get("ca_objects.promotionalSubtypes", array('convertCodesToDisplayText' => true));
										}
										if(!$vs_type){
											$vs_type = $t_object->get('ca_objects.type_id', array('convertCodesToDisplayText' => true));
										}
										print caDetailLink($this->request, "<span class='typeLabel'>".$vs_type."</span> ".$t_object->get('ca_objects.preferred_labels'), "", "ca_objects", $t_object->get("ca_objects.object_id"));
?>							
									<div class="text-right">
<?php
										print caDetailLink($this->request, "Full Details&nbsp;&nbsp;<span class='icon-arrow-up-right'></span>", "full", "ca_objects", $t_object->get("ca_objects.object_id"));
?>							
									</div>
							</div><!-- end detailOverlayImgCaption -->
						
						</div>
					</div>
<?php				
				}
?>
				</div>
				<div class="col-xs-2 detailOverlayNav text-left">
<?php
					if($this->getVar("nextID")){
?>
					<a href='#' onclick='caMediaPanel.showPanel("<?php print caNavUrl($this->request, 'Detail', 'objects', $this->getVar("nextID"), array('overlay' => 1)); ?>"); return false;'><span class="icon-chevron-right"></span></a>
<?php
					}
?>
				</div>
			</div><!-- end row -->
		</div><!-- end container -->
<?php		
	}else{
?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
</div>
<div class="row">
	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
		<div class="row">
			<div class='col-sm-1 navLeftRight'>
				<div class="detailNavBgLeft">
					{{{previousLink}}}{{{resultsLink}}}
				</div><!-- end detailNavBgLeft -->
			</div><!-- end col -->		
			<div class='col-xs-12 col-sm-10'>
				<div class="detailHead">
<?php
				$vn_show_label_as_title = false;
				$vs_page_title = "";
				$vs_type = "";
				if($vs_typecode == "promotional"){
					$vs_type = $t_object->get("ca_objects.promotionalSubtypes", array('convertCodesToDisplayText' => true));
				}
				if(!$vs_type){
					$vs_type = $t_object->get('ca_objects.type_id', array('convertCodesToDisplayText' => true));
				}
				print "<div class='leader'>".$vs_type."</div>";
				if(($pn_photo_object_type_id == $t_object->get('ca_objects.type_id')) | ($pn_digi_photo_object_type_id == $t_object->get('ca_objects.type_id'))){
					if ($va_production_title = $t_object->get('ca_occurrences.preferred_labels', array('restrictToTypes' => array('production'), 'delimiter' => ', ', 'checkAccess' => $va_access_values))) {
						$vs_page_title = "<h2>".$va_production_title."</h2>";
						$vn_show_label_as_title = true;
					} elseif ($va_entity_title = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('depicts'), 'delimiter' => ', ', 'checkAccess' => $va_access_values))) {
						$vs_page_title = "<h2>".$va_entity_title."</h2>";
						$vn_show_label_as_title = true;
					} else {
						$vs_page_title = "<h2>".$t_object->get('ca_objects.preferred_labels')."</h2>";	
					}
				}else{
					$vs_page_title = "<h2>".$t_object->get('ca_objects.preferred_labels')."</h2>";				
				}
				if($vn_show_label_as_title){
					print $vs_page_title;					
					if ($va_source_date = str_replace(" - ", "&mdash;", $t_object->get('ca_objects.sourceDate'))) {
						print "<h3>".$va_source_date."</h3>";
					}
				}else{
					print $vs_page_title;
				}
				#Load Metadata
				$vs_buf = "";
				$vs_buf_second = "";
				if($vn_show_label_as_title){
					if ($va_object_title = $t_object->get('ca_objects.preferred_labels')) {
						$vs_buf.= "<div class='unit'><span class='label'>Title</span>".$va_object_title."</div>";
					}
				}
				if(!$vn_show_label_as_title){
					if ($va_source_date = str_replace(" - ", "&mdash;", $t_object->get('ca_objects.sourceDate'))) {
						$vs_buf.= "<div class='unit'><span class='label'>Date</span>".$va_source_date."</div>";
					}
				}
				if ($va_related_entities = $t_object->get('ca_entities', array('excludeRelationshipTypes' => array('rights_holder'), 'returnWithStructure' => true, 'checkAccess' => $va_access_values))) {
					$va_entity_list = array();
					foreach ($va_related_entities as $va_related_entity) {
						$va_entity_list[$va_related_entity['relationship_typename']][] = caNavLink($this->request, $va_related_entity['displayname'], '', '', 'Detail', 'entities/'.$va_related_entity['entity_id']);
					}
					foreach ($va_entity_list as $va_entity_role => $va_entity_link) {
						$vs_buf.= "<div class='unit'><span class='label'>".ucfirst($va_entity_role)."</span>";
						$vs_buf.= join(', ', $va_entity_link)."</div>";
					}
				}
				if ($vs_season = $t_object->get('ca_occurrences.preferred_labels', array('restrictToTypes' => array('season'), 'delimiter' => ', ', 'checkAccess' => $va_access_values))) {
					$vs_buf.= "<div class='unit'><span class='label'>Season</span>".caNavLink($this->request, $vs_season, '', '', '', 'Search/objects/search/"'.$vs_season.'"')."</div>";
				}
				if ($va_idno = $t_object->get('ca_objects.idno')) {
					$vs_buf_second.= "<div class='unit'><span class='label'>Identifier </span>".$va_idno."</div>";
				}
				if ($va_source_description = $t_object->get('ca_objects.description.description_text')) {
					$vs_buf .= "<div class='unit'><span class='label'>Description: </span>".$va_source_description."</div>";
				}
				#if ($va_rights_statement = $t_object->get('ca_objects.rightsStatement.rightsStatement_text', array('delimiter' => '<br/>'))) {
				#	$vs_buf_second.= "<div class='unit'><span class='label'>Rights Statement </span>".$va_rights_statement."</div>";
				#}
				$vs_buf_second.= "<div class='unit'><span class='label'>Rights Statement </span>Many of the digital objects on this site are protected by copyright or other legal rights.  Those objects may not be reproduced, published or distributed without the express permission of the rights holder.  <a href='mailto:bamarchive@bam.org'>Contact the BAM Hamm Archives</a> for further information.</div>"; 
				#if ($va_ordering_info = $t_object->get('ca_objects.orderingInfo')) {
				#	$vs_buf.= "<div class='unit'><span class='label'>Ordering Info </span>".$va_ordering_info."</div>";
				#}	
				if ($va_rights_holder = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('rights_holder'), 'returnAsLink' => true, 'delimiter' => ', '))) {
					$vs_buf_second.= "<div class='unit'><span class='label'>Rights Holder </span>".$va_rights_holder."</div>";
				}					
				if ($va_related_production = $t_object->get('ca_occurrences.preferred_labels', array('restrictToTypes' => array('production', 'special_event'), 'returnAsLink' => true, 'delimiter' => ', ', 'checkAccess' => $va_access_values))) {
					$vs_buf.= "<div class='unit'><span class='label'>Related Production </span>".$va_related_production."</div>";
				}
				if ($va_event_series = $t_object->get('ca_occurrences.preferred_labels', array('restrictToTypes' => array('event_series'), 'returnAsLink' => true, 'delimiter' => ', ', 'checkAccess' => $va_access_values))) {
					$vs_buf.= "<div class='unit'><span class='label'>Related Event Series </span>".$va_event_series."</div>";
				}
				if ($va_artist_residency = $t_object->get('ca_occurrences.preferred_labels', array('restrictToTypes' => array('artist_residency'), 'returnAsLink' => true, 'delimiter' => ', ', 'checkAccess' => $va_access_values))) {
					$vs_buf.= "<div class='unit'><span class='label'>Related Artist Residency </span>".$va_artist_residency."</div>";
				}
				if ($va_installation = $t_object->get('ca_occurrences.preferred_labels', array('restrictToTypes' => array('installation'), 'returnAsLink' => true, 'delimiter' => ', ', 'checkAccess' => $va_access_values))) {
					$vs_buf.= "<div class='unit'><span class='label'>Related Installation </span>".$va_installation."</div>";
				}
				if ($va_movie = $t_object->get('ca_occurrences.preferred_labels', array('restrictToTypes' => array('movie'), 'returnAsLink' => true, 'delimiter' => ', ', 'checkAccess' => $va_access_values))) {
					$vs_buf.= "<div class='unit'><span class='label'>Related Movie </span>".$va_movie."</div>";
				}
				$o_gallery_config = caGetGalleryConfig();
				$vs_gallery_set_type = $o_gallery_config->get('gallery_set_type');
				$vs_gallery_from_bam_set_type = $o_gallery_config->get('gallery_from_bam_with_love_set_type');
 		
				$t_set = new ca_sets();
				$va_sets = $t_set->getSetsForItem("ca_objects", $t_object->get("ca_objects.object_id"), array("setType" => $vs_gallery_set_type, "checkAccess" => $va_access_values));
				$va_sets_from_bam = $t_set->getSetsForItem("ca_objects", $t_object->get("ca_objects.object_id"), array("setType" => $vs_gallery_from_bam_set_type, "checkAccess" => $va_access_values));
				if((is_array($va_sets) && sizeof($va_sets)) || (is_array($va_sets_from_bam) && sizeof($va_sets_from_bam))){
					$vs_buf .= "<div class='unit'><span class='label'>Part Of</span>";
					$va_tmp = array();
					if(is_array($va_sets) && sizeof($va_sets)){
						foreach($va_sets as $va_set){
							$va_set = array_pop($va_set);
							$va_tmp[] = caNavLink($this->request, $va_set["name"], "", "", "Front", "Index", array("featured_set_id" => $va_set["set_id"]));
						}
					}
					if(is_array($va_sets_from_bam) && sizeof($va_sets_from_bam)){
						foreach($va_sets_from_bam as $va_set){
							$va_set = array_pop($va_set);
							$va_tmp[] = caNavLink($this->request, $va_set["name"], "", "", "Front", "Index", array("featured_set_id" => $va_set["set_id"]));
						}
					}
					$vs_buf .= join(", ", $va_tmp);
					$vs_buf .= "</div>";
				}

?>
				
				</div><!-- end detailHead -->
			</div><!-- end col -->
			<div class='col-sm-1 navLeftRight'>	
				<div class="detailNavBgRight">
					{{{nextLink}}}
				</div><!-- end detailNavBgLeft -->
			</div><!-- end col -->			
		</div><!-- end row -->
		<div class="row">
			<div class="col-sm-12">
				<hr class="divide"/>
			</div>
		</div><!-- end row -->
		
<?php			
		if(!sizeof($va_rep)){
			print "<p class='grayText'>Copyright restricted, please <a href='mailto:bamarchive@bam.org'>contact the archive</a> to view</p>";
		}
		if (($va_rep_width > $va_rep_height) && ($va_rep_type != 'audio/mpeg')) {
?>			
		<div class="row" style='margin-bottom:30px;'>
			<div class='col-sm-12 col-md-8 col-md-offset-2'>
				<div class="landscapeRepContainer" style="max-width:<?php print $va_rep_width; ?>px;">
				<?php print $this->getVar("representationViewer");?>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>			
				</div>
			</div><!-- end col -->
		</div><!-- end row -->
		<div class='row'>	
<?php
			if($vs_buf){
?>
			<div class='col-sm-6'>	
<?php
				print $vs_buf;
?>						
			</div><!-- end col -->
<?php
			}
?>
			<div class='<?php print ($vs_buf) ? 'col-sm-6' : 'col-sm-12'; ?>'>	
<?php
				print $vs_buf_second;
?>						
			</div><!-- end col -->				
		</div><!-- end row -->	
				
<?php				
		} else {

?>				
		<div class="row" style='margin-bottom:30px;'>
			<div class='col-sm-6 col-md-5 col-md-offset-1'>
				<div class="portraitRepContainer" style="max-width:<?php print $va_rep_width; ?>px;">
<?php
					print $this->getVar("representationViewer");
				
					print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); 
?>			
				</div>
			</div><!-- end col -->
			<div class='col-sm-6 col-md-5'>
<?php
				print $vs_buf.$vs_buf_second;
?>			
			</div><!-- end col -->
		</div><!-- end row -->		
<?php
		}



?>			
		<div class="row">
			<div class='col-sm-12 col-md-12 col-lg-12'>
				
				<!--<div id="detailTools">
					<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div>
					<div id='detailComments'>{{{itemComments}}}</div>
					<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div>
				</div>-->
			</div><!-- end col -->		
		</div><!-- end row -->
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