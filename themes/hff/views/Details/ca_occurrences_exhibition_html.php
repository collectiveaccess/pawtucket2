<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$vn_id =				$t_item->get('ca_occurrences.occurrence_id');
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
					<H4><?php print italicizeTitle($t_item->get("ca_occurrences.preferred_labels.name")); ?></H4>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-sm-6 col-md-6 col-lg-6'>
					{{{<ifdef code="ca_occurrences.solo_group"><div class="unit"><H6>Exhibition Type</H6>^ca_occurrences.solo_group</div></ifdef>}}}
					{{{<ifdef code="ca_occurrences.exhibition_dates_display"><div class="unit"><H6>Dates</H6><unit relativeTo="ca_occurrences" delimiter="<br/>">^ca_occurrences.exhibition_dates_display</unit></div></ifdef>}}}
					{{{<ifnotdef code="ca_occurrences.exhibition_dates_display"><ifdef code="ca_occurrences.common_date"><div class="unit"><H6>Dates</H6>^ca_occurrences.common_date</div></ifdef></ifnotdef>}}}
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="originator" min="1"><div class="unit"><H6>Organizing Venue</H6><unit relativeTo="ca_entities" restrictToRelationshipTypes="originator" delimiter="<br/>">^ca_entities.preferred_labels.displayname</unit></div></ifcount>}}}
					{{{<ifdef code="ca_occurrences.venues.venue_name|ca_occurrences.venues.venue_address|ca_occurrences.venues.venue_dates_display">
						<div class="unit"><H6>Traveled To</H6>
						<unit relativeTo="ca_occurrences.venues" delimiter="<br/>">
							<ifdef code="ca_occurrences.venues.venue_name">^ca_occurrences.venues.venue_name, </ifdef>
							<ifdef code="ca_occurrences.venues.venue_address">^ca_occurrences.venues.venue_address, </ifdef>
							<ifdef code="ca_occurrences.venues.venue_dates_display">^ca_occurrences.venues.venue_dates_display </ifdef>
						</unit>
						</div>
					</ifdef>}}}
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
						print "<div class='detailTool'><span class='glyphicon glyphicon-file'></span>".caDetailLink($this->request, "Download Printable PDF", "faDownload", "ca_occurrences",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_occurrences_summary'))."</div>";
					}
					print '</div><!-- end detailTools -->';
				}				
?>
					
				</div><!-- end col -->
				<div class='col-md-6 col-lg-6'>					
					
					{{{<ifcount code="ca_occurrences.related" restrictToTypes="chronology" min="1"><H6>Chronology Links</H6></ifcount>}}}
					{{{<unit relativeTo="ca_occurrences.related" delimiter="<br/>" restrictToTypes="chronology"><l>^ca_occurrences.preferred_labels.name</l></unit>}}}

					{{{<ifcount code="ca_occurrences.related" min="1" restrictToTypes="literature"><div class='unit'><H6>Literature References</H6><unit relativeTo="ca_occurrences.related" restrictToTypes="literature" delimiter="<br/>"><ifdef code="ca_occurrences.lit_citation"><l>^ca_occurrences.lit_citation</l></ifdef><ifnotdef code="ca_occurrences.lit_citation">^ca_occurrences.preferred_labels</ifnotdef></unit></div></ifcount>}}}
					
					{{{<ifcount code="ca_objects" min="1" restrictToTypes="archival"><div class='unit'><H6>Related Digital Items</H6><unit relativeTo="ca_objects" restrictToTypes="archival" delimiter="<br/>"><l>^ca_objects.preferred_labels<ifdef code="ca_objects.unitdate.dacs_date_text">, ^ca_objects.unitdate.dacs_date_text</ifdef></l></unit></div></ifcount>}}}
					
					{{{<ifcount code="ca_objects" min="1" restrictToTypes="library">
						<div class='unit'><H6>Related Library Items</H6>
							<unit relativeTo="ca_objects" restrictToTypes="library" delimiter="<br/>">
								<l>^ca_objects.preferred_labels</l>
								
							</unit>
						</div>
					</ifcount>}}}
				
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
							<br/><hr/><br/><H5>Works Exhibited</H5>
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
						if($vs_tmp = $t_objects_x_occurrences->get("checklist_number")){
							$va_interstitial[] = "Checklist number: ".$vs_tmp;
						}
						if($vs_tmp = $t_objects_x_occurrences->get("exhibition_title")){
							$va_interstitial[] = "Exhibition title: ".$vs_tmp;
						}
						if($vs_tmp = $t_objects_x_occurrences->get("citation")){
							$va_interstitial[] = "Citation: ".$vs_tmp;
						}
						if($vs_tmp = $t_objects_x_occurrences->get("exh_remarks")){
							$va_interstitial[] = "Remarks: ".$vs_tmp;
						}
						#if($vs_tmp = $t_objects_x_occurrences->get("source")){
						#	$va_interstitial[] = "Source: ".$vs_tmp;
						#}
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