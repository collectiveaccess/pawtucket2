<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$va_access_values = caGetUserAccessValues($this->request);	
	
	$o_icons_conf = caGetIconsConfig();
	$va_object_type_specific_icons = $o_icons_conf->getAssoc("placeholders");
	if(!($vs_default_placeholder = $o_icons_conf->get("placeholder_media_icon"))){
		$vs_default_placeholder = "<i class='fa fa-picture-o fa-2x'></i>";
	}
	$vs_default_placeholder_tag = "<div class='bResultItemImgPlaceholder'>".$vs_default_placeholder."</div>";
	$va_add_to_set_link_info = caGetAddToSetInfo($this->request);
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
					<H1 class="chronologyTitle">{{{^ca_occurrences.preferred_labels.name}}}</H1>
					<HR/>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
<?php
				#if($vs_image = $t_item->getWithTemplate("^ca_object_representations.media.large%limit=1", array("checkAccess" => $va_access_values))){
				#	print "<div class='col-xs-12 col-sm-4 col-md-4 col-lg-4 scaleImage'>".$vs_image."</div>";
				#}
				if($vs_image = $t_item->getWithTemplate("<unit relativeTo='ca_objects' restrictToRelationshipTypes='featured_simple' length='1'><l>^ca_object_representations.media.large</l></unit>")){
					print "<div class='col-xs-12 col-sm-4 col-md-4 col-lg-4 scaleImage'>".$vs_image."</div>";
				}
?>

				<div class='col-xs-12 col-sm-8 col-md-8 col-lg-8'>
<?php
	$va_chron_entry = array_shift($t_item->get("ca_occurrences.chronology", array("returnWithStructure" => 1)));
	if(is_array($va_chron_entry)){
		$va_chron_text_grouped_by_date = array();
		foreach($va_chron_entry as $k => $va_chron_info){
			$va_chron_text_grouped_by_date[$va_chron_info["chronology_date_sort_"]][] = "<div class='unit'><H6>".(($va_chron_info["chronology_date_display"]) ? $va_chron_info["chronology_date_display"] : $va_chron_info["chronology_date"])."</H6>".$va_chron_info["chronology_text"]."</div>";
			ksort($va_chron_text_grouped_by_date);
		}
		foreach($va_chron_text_grouped_by_date as $vn_sort_date => $va_chron_text_by_date){
			print join("\n", $va_chron_text_by_date);
		}
	}
	if($vs_source = $t_item->get("ca_occurrences.source")){
		print "<div class='unit'>".$vs_source."</div>";
	}
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled) {
						
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
					print '</div><!-- end detailTools -->';
				}
?>
					
				</div><!-- end col -->
			</div><!-- end row -->
<?php				
					$o_search = caGetSearchInstance("ca_occurrences");
					$o_search->setTypeRestrictions(array("exhibition"));
					$qr_res = $o_search->search("ca_occurrences.common_date:".$t_item->get("ca_occurrences.common_date"), array("checkAccess" => $va_access_values, 'sort' => 'ca_occurrences.common_date', 'sort_direction' => 'asc'));
 					if($qr_res->numHits()){
?>
						<div class="row">
							<div class="col-sm-12">
								<br/><hr/><br/><H4><?php print "Exhibition".(($qr_res->numHits() > 1) ? "s" : ""); ?></H4>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
<?php
						
						$va_solo = array();
						$va_group = array();
						$t_occ = new ca_occurrences();
						while($qr_res->nextHit()){
							$vs_exhibition = $vs_title = $vs_date = $vs_originating_venue = "";
							
							$vs_originating_venue 	= $qr_res->getWithTemplate("<unit relativeTo='ca_entities' restrictToRelationshipTypes='originator' delimiter=', '>^ca_entities.preferred_labels</unit>", array("checkAccess" => $va_access_values));
							$vs_title = $qr_res->get("ca_occurrences.preferred_labels");
							# --- add closing & opening <i> tags to un-italicize andy brackets
							$vs_title = italicizeTitle($vs_title);
							$vs_date = $qr_res->get("ca_occurrences.exhibition_dates_display", array("delimiter" => "<br/>"));
							if(!$vs_date){
								$vs_date = $qr_res->get("ca_occurrences.common_date");
							}
							$vs_exhibition = (($vs_originating_venue) ? $vs_originating_venue.", " : "").caDetailLink($this->request, $vs_title, '', 'ca_occurrences', $qr_res->get("occurrence_id")).(($vs_date) ? ", ".$vs_date : "");
							if($qr_res->get("ca_occurrences.solo_group", array("convertCodesToDisplayText" => true)) == "solo"){
								$va_solo[] = $vs_exhibition;
							}else{
								$va_group[] = $vs_exhibition;
							}
						}
						
						if(sizeof($va_solo)){
							print "<div class='unit'><H6>Solo</H6>".join("<br/>", $va_solo)."</div>";
						}
						if(sizeof($va_group)){
							print "<div class='unit'><H6>Group</H6>".join("<br/>", $va_group)."</div>";
						}
?>
							</div>
						</div>
<?php
					}
?>						
					{{{<ifcount code="ca_places" min="1">
							<div class="row">
								<div class="col-sm-12">
									<br/><hr/><br/><H4><ifcount code="ca_places" min="1" max="1">Location</ifcount><ifcount code="ca_places" min="2">Locations</ifcount></H4>
								</div>
							</div>
							<div class="row">
								<ifcount code="ca_places" min="1" restrictToRelationshipTypes="home">
									<div class="col-sm-12 col-md-4">
										<div class="unit"><h6>Home</h6>
											<unit relativeTo="ca_places_x_occurrences" delimiter="<br/>" restrictToRelationshipTypes="home">
												<div>
													<ifdef code="ca_places.parent.preferred_labels.name">^ca_places.parent.preferred_labels.name &gt; </ifdef>^ca_places.preferred_labels.name<case><ifdef code="ca_places_x_occurrences.display_date">, ^ca_places_x_occurrences.display_date</ifdef><ifdef code="ca_places_x_occurrences.effective_date">, ^ca_places_x_occurrences.effective_date</ifdef></case><ifdef code="ca_places_x_occurrences.interstitial_notes"><div>^ca_places_x_occurrences.interstitial_notes</div></ifdef>
												</div>
											</unit>
										</div>
									</div>
								</ifcount>
								<ifcount code="ca_places" min="1" restrictToRelationshipTypes="studio">
									<div class="col-sm-12 col-md-4">
										<div class="unit"><h6>Studio</h6>
											<unit relativeTo="ca_places_x_occurrences" delimiter="<br/>" restrictToRelationshipTypes="studio">
												<div>
													<ifdef code="ca_places.parent.preferred_labels.name">^ca_places.parent.preferred_labels.name &gt; </ifdef>^ca_places.preferred_labels.name<case><ifdef code="ca_places_x_occurrences.display_date">, ^ca_places_x_occurrences.display_date</ifdef><ifdef code="ca_places_x_occurrences.effective_date">, ^ca_places_x_occurrences.effective_date</ifdef></case><ifdef code="ca_places_x_occurrences.interstitial_notes"><div>^ca_places_x_occurrences.interstitial_notes</div></ifdef>
												</div>
											</unit>
										</div>
									</div>
								</ifcount>
								<ifcount code="ca_places" min="1" restrictToRelationshipTypes="travel">
									<div class="col-sm-12 col-md-4">
										<div class="unit"><h6>Travel</h6>
											<unit relativeTo="ca_places_x_occurrences" delimiter="<br/>" restrictToRelationshipTypes="travel">
												<div>
													<ifdef code="ca_places.parent.preferred_labels.name">^ca_places.parent.preferred_labels.name &gt; </ifdef>^ca_places.preferred_labels.name<case><ifdef code="ca_places_x_occurrences.display_date">, ^ca_places_x_occurrences.display_date</ifdef><ifdef code="ca_places_x_occurrences.effective_date">, ^ca_places_x_occurrences.effective_date</ifdef></case><ifdef code="ca_places_x_occurrences.interstitial_notes"><div>^ca_places_x_occurrences.interstitial_notes</div></ifdef>
												</div>
											</unit>
										</div>
									</div>
								</ifcount>
							</div>
						</ifcount>
					}}}					
				
<?php
	$va_archival_items = $t_item->get("ca_objects.object_id", array("restrictToTypes" => array("archival"), "returnAsArray" => true, "checkAccess" => $va_access_values));
	if($va_archival_items && sizeof($va_archival_items)){
		$qr_archival_items = caMakeSearchResult('ca_objects', $va_archival_items);
?>
			<div class="row">
				<div class="col-sm-12">
					<br/><hr/><br/><H4>Related Digital Item<?php print ($qr_archival_items->numHits() > 1) ? "s" : ""; ?></H4><br/>
				</div>
			</div>
			<div class="row">
<?php
				while($qr_archival_items->nextHit()){
					$vn_id = $qr_archival_items->get("ca_objects.object_id");
					
					$vs_label_detail_link = "";
					# --- no idno link
					$vs_label_detail_link 	= caDetailLink($this->request, $qr_archival_items->get("ca_objects.preferred_labels"), '', 'ca_objects', $vn_id).(($qr_archival_items->get("ca_objects.unitdate.dacs_date_text")) ? ", ".$qr_archival_items->get("ca_objects.unitdate.dacs_date_text") : "");
					$vs_tmp = $qr_archival_items->getWithTemplate("<unit relativeTo='ca_collections' delimiter=', '><l>^ca_collections.preferred_labels</l></unit>", array("checkAccess" => $va_access_values));				
					if($vs_tmp){
						$vs_label_detail_link .= "<br/>Part of: ".$vs_tmp;
					}
						
					$vs_thumbnail = "";
					$vs_type_placeholder = "";
					if(!($vs_thumbnail = $qr_archival_items->get('ca_object_representations.media.medium', array("checkAccess" => $va_access_values)))){
						if($vs_type_placeholder = caGetPlaceholder("archival", "placeholder_media_icon")){
							$vs_thumbnail = "<div class='bResultItemImgPlaceholder'>".$vs_type_placeholder."</div>";
						}else{
							$vs_thumbnail = $vs_default_placeholder_tag;
						}
					}
					$vs_info = null;
					$vs_rep_detail_link 	= caDetailLink($this->request, $vs_thumbnail, '', 'ca_objects', $vn_id);				
				
					$vs_add_to_set_link = "";
					if(is_array($va_add_to_set_link_info) && sizeof($va_add_to_set_link_info)){
						$vs_add_to_set_link = "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', $va_add_to_set_link_info["controller"], 'addItemForm', array("object_id" => $vn_id))."\"); return false;' title='".$va_add_to_set_link_info["link_text"]."'>".$va_add_to_set_link_info["icon"]."</a>";
					}
					
					print "
		<div class='bResultItemCol col-xs-6 col-sm-6 col-md-3'>
			<div class='bResultItem' id='row{$vn_id}' onmouseover='jQuery(\"#bResultItemExpandedInfo{$vn_id}\").show();'  onmouseout='jQuery(\"#bResultItemExpandedInfo{$vn_id}\").hide();'>
				<div class='bResultItemContent'><div class='text-center bResultItemImg'>{$vs_rep_detail_link}</div>
					<div class='bResultItemText'>
						{$vs_label_detail_link}
					</div><!-- end bResultItemText -->
				</div><!-- end bResultItemContent -->
				".(($vs_add_to_set_link) ? "<div class='bResultItemExpandedInfo' id='bResultItemExpandedInfo{$vn_id}'><hr>{$vs_expanded_info}{$vs_add_to_set_link}</div><!-- bResultItemExpandedInfo -->" : "")."
			</div><!-- end bResultItem -->
		</div><!-- end col -->";
				
				
			}
?>
			</div>
<?php
	}
?>

			<div class="row">
				<div class="col-sm-12">
					<br/><hr/><br/><H4 id="relArtworkHeading" style="display:none;">Related Artworks</H4>
				</div>
			</div>
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'artworks', array('search' => 'ca_objects.common_date:'.$t_item->get('ca_occurrences.common_date').' and ca_entities.entity_id:2558', 'view' => 'images'), array('dontURLEncodeParameters' => false)); ?>", function() {
						if ($("#browseResultsContainer .bResultItemCol").text().length > 0) {
							$('#relArtworkHeading').show();
						}
						jQuery('#browseResultsContainer').jscroll({
							autoTrigger: true,
							loadingHtml: "<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>",
							padding: 20,
							nextSelector: "a.jscroll-next"
						});
					});
					
					
				});
			</script>

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