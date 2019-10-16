<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$va_access_values = caGetUserAccessValues($this->request);	
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
					<H4><?php print $t_item->get("ca_occurrences.lit_citation"); ?></H4>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-sm-6 col-md-6 col-lg-6'>
					{{{<ifdef code="ca_occurrences.idno"><div class="unit"><H6>Identifier</H6>^ca_occurrences.idno</div></ifdef>}}}
					{{{<ifdef code="ca_occurrences.pubType"><div class="unit"><H6>Type</H6>^ca_occurrences.pubType</div></ifdef>}}}
					
<?php
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled | $vn_pdf_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					if ($vn_pdf_enabled) {
						print "<div class='detailTool'><span class='glyphicon glyphicon-file'></span>".caDetailLink($this->request, "Download Printable PDF", "faDownload", "ca_occurrences",  $t_item->get("ca_occurrences.occurrence_id"), array('view' => 'pdf', 'export_format' => '_pdf_ca_occurrences_summary'))."</div>";
					}
					print '</div><!-- end detailTools -->';
				}				
?>
				</div><!-- end col -->
				<div class='col-md-6 col-lg-6'>					
					
<?php
				if($va_exhibitions = $t_item->get("ca_occurrences.related", array("checkAccess" => $va_access_value, "returnWithStructure" => true, "restrictToTypes" => array("exhibition"), "sort" => "ca_occurrences.common_date"))){
					$t_occ = new ca_occurrences();
					print "<div class='unit moreSpace'><H6>Exhibitions Referenced</H6>";
					foreach($va_exhibitions as $va_exhibition){
						$t_occ->load($va_exhibition["occurrence_id"]);
						$vs_originating_venue 	= $t_occ->getWithTemplate("<unit relativeTo='ca_entities' restrictToRelationshipTypes='originator' delimiter=', '>^ca_entities.preferred_labels</unit>", array("checkAccess" => $va_access_values));
						if($vs_venue_location = $t_occ->get("ca_occurrences.venue_location", array("delimiter" => ", "))){
							$vs_originating_venue .= ", ".$vs_venue_location;
						}
						$vs_title = italicizeTitle($va_exhibition["name"]);
						$vs_date = $t_occ->get("ca_occurrences.exhibition_dates_display", array("delimiter" => "<br/>"));
						if(!$vs_date){
							$vs_date = $t_occ->get("ca_occurrences.common_date");
						}
						
						$vs_travel_venues = $t_occ->getWithTemplate('<ifdef code="ca_occurrences.venues.venue_name|ca_occurrences.venues.venue_address|ca_occurrences.venues.venue_dates_display">
						<div class="travelVenue"><div>Traveled To</div>
						<unit relativeTo="ca_occurrences.venues" delimiter="<br/>"><ifdef code="ca_occurrences.venues.venue_name">^ca_occurrences.venues.venue_name, </ifdef><ifdef code="ca_occurrences.venues.venue_address">^ca_occurrences.venues.venue_address<ifdef code="ca_occurrences.venues.venue_dates_display">, </ifdef></ifdef><ifdef code="ca_occurrences.venues.venue_dates_display">^ca_occurrences.venues.venue_dates_display</ifdef>.</unit>
						</div>
					</ifdef>');
						print caDetailLink($this->request, (($vs_originating_venue) ? $vs_originating_venue.", " : "").$vs_title.(($vs_date) ? ", ".$vs_date : ""), '', 'ca_occurrences', $va_exhibition["occurrence_id"]).".".$vs_travel_venues.(($vs_travel_venues) ? "" : "<br/>");
					}
					print "</div>";
				}
?>				
				</div><!-- end col -->
			</div><!-- end row -->

<?php
				$va_rel_artworks = $t_item->get("ca_objects.related.object_id", array("checkAccess" => $va_access_values, "restrictToTypes" => array("artwork", "art_HFF", "edition_HFF", "art_nonHFF", "edition_nonHFF"), "returnAsArray" => true));
				if(is_array($va_rel_artworks) && sizeof($va_rel_artworks)){
					$qr_res = caMakeSearchResult("ca_objects", $va_rel_artworks);
					$vs_default_placeholder_tag = "<div class='bResultItemImgPlaceholder'><i class='fa fa-picture-o fa-2x'></i></div>";
?>
					<div class="row">
						<div class="col-sm-12">
							<br/><hr/><br/><H5>Works Referenced</H5>
						</div>
					</div>
					<div class='row'>
<?php
					$t_objects_x_occurrences = new ca_objects_x_occurrences();
					while($qr_res->nextHit()){
						$va_relations = $qr_res->get("ca_objects_x_occurrences.relation_id", array("checkAccess" => $va_access_values, "restrictToTypes" => array("artwork", "art_HFF", "edition_HFF", "art_nonHFF", "edition_nonHFF"), "returnAsArray" => true));
						foreach($va_relations as $vn_relationship_id){
							$t_objects_x_occurrences->load($vn_relationship_id);
							if($t_objects_x_occurrences->get("occurrence_id") == $t_item->get("ca_occurrences.occurrence_id")){
								break;
							}
						}
				
						$vn_id = $qr_res->get("ca_objects.object_id");
						$vs_idno_detail_link 	= "<small>".caDetailLink($this->request, $qr_res->get("ca_objects.idno"), '', 'ca_objects', $vn_id)."</small><br/>";
						$vs_label_detail_link 	= caDetailLink($this->request, italicizeTitle($qr_res->get("ca_objects.preferred_labels")), '', 'ca_objects', $vn_id).(($qr_res->get("ca_objects.common_date")) ? ", ".$qr_res->get("ca_objects.common_date") : "");
						if(!($vs_thumbnail = $qr_res->get('ca_object_representations.media.medium', array("checkAccess" => $va_access_values)))){
							$vs_thumbnail = $vs_default_placeholder_tag;
						}
						$vs_info = null;
						$vs_rep_detail_link 	= caDetailLink($this->request, $vs_thumbnail, '', 'ca_objects', $vn_id);				

						$va_interstitial = array();
						# --- note label on backend is citation even though the field is called source
						if($vs_tmp = $t_objects_x_occurrences->get("source")){
							$va_interstitial[] = "Citation: ".$vs_tmp;
						}
						print "<div class='bResultItemCol col-xs-12 col-sm-6 col-md-3'>
			<div class='bResultItem' id='row{$vn_id}' onmouseover='jQuery(\"#bResultItemExpandedInfo{$vn_id}\").show();'  onmouseout='jQuery(\"#bResultItemExpandedInfo{$vn_id}\").hide();'>
				<div class='bSetsSelectMultiple'><input type='checkbox' name='object_ids' value='{$vn_id}'></div>
				<div class='bResultItemContent'><div class='text-center bResultItemImg'>{$vs_rep_detail_link}</div>
					<div class='bResultItemText'>
						{$vs_idno_detail_link}{$vs_label_detail_link}".((is_array($va_interstitial) && sizeof($va_interstitial)) ? "<br/>".join("<br/>", $va_interstitial) : "")."
					</div><!-- end bResultItemText -->
				</div><!-- end bResultItemContent -->
			</div><!-- end bResultItem -->
		</div><!-- end col -->";

						
					}
					print "</div><!-- end row -->";
					
				}
?>		


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