<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
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
				<div class='col-sm-12 col-md-6 col-md-offset-3 text-center'>
					<H1>{{{^ca_occurrences.preferred_labels.name}}}</H1>
					{{{<ifdef code="ca_occurrences.event_date"><H2>^event_date</H2></ifdef>}}}
				</div>
				<div class='col-sm-12 col-md-3 text-center'>
<?php
				print "<div class='inquireButton'>".caNavLink($this->request, "<span class='glyphicon glyphicon-envelope'></span> Inquire", "btn btn-default btn-small", "", "Contact", "Form", array("table" => "ca_occurrences", "id" => $t_item->get("occurrence_id")))."</div>";
?>
				</div>
			</div>
			<div class="row text-center">			
				<div class='col-sm-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3'>
<?php
			$vb_media_accessible = false;
			$vb_media_not_accessible = false;
			$va_related_dig_audio_no_media = array();
			$va_related_dig_movingimage_no_media = array();
			if($va_dig_audio_recording = $t_item->get("ca_objects.object_id", array("returnAsArray" => true, "restrictToTypes" => array("audio_digital"), "checkAccess" => $va_access_values))){
?>
				<div class="unit">
<?php
				foreach($va_dig_audio_recording as $vn_dig_audio_recording_id){
					$t_dig_audio = new ca_objects($vn_dig_audio_recording_id);
					if($t_dig_audio_rep = $t_dig_audio->getPrimaryRepresentationInstance(array("checkAccess" => $va_access_values))){
						$vb_media = true;
						$va_opts = array('display' => 'detail', 'object_id' => $t_dig_audio->get('object_id'), 'representation_id' => $t_dig_audio_rep->get('representation_id'), 'containerID' => 'caMediaPanelContentArea', 'access' => $va_access_values);			
						print "<div class='unit'>".caRepresentationViewer(
								$this->request, 
								$t_dig_audio, 
								$t_dig_audio,
								array_merge($va_opts, $va_media_display_info, 
									array(
										'display' => 'detail',
										'showAnnotations' => true, 
										'primaryOnly' => true, 
										'dontShowPlaceholder' => true, 
										'captionTemplate' => false
									)
								)
						)."</div>";
						if($vs_tmp = $t_dig_audio->getWithTemplate("<l>^ca_objects.preferred_labels.name</l>")){
							print "<div class='unit'>".$vs_tmp."</div>";
						}
					}else{
						# --- is there media that is not accessible to the public? If so we're going to put the rights text here
						if($t_dig_audio->get("ca_object_representations.representation_id")){
							$vb_media_not_accessible = true;
						}
						$va_related_dig_audio_no_media[] = $t_dig_audio->getWithTemplate("<l>^ca_objects.preferred_labels.name</l>");
					}
				}
?>
				</div>
<?php
			}

			if($va_dig_movingimage_recording = $t_item->get("ca_objects.object_id", array("returnAsArray" => true, "restrictToTypes" => array("movingimage_digital"), "checkAccess" => $va_access_values))){
?>
				<div class="unit">
<?php
				foreach($va_dig_movingimage_recording as $vn_dig_movingimage_recording_id){
					$t_dig_movingimage = new ca_objects($vn_dig_movingimage_recording_id);
					if($t_dig_movingimage_rep = $t_dig_movingimage->getPrimaryRepresentationInstance(array("checkAccess" => $va_access_values))){
						$vb_media = true;
						$va_opts = array('display' => 'detail', 'object_id' => $t_dig_movingimage->get('object_id'), 'representation_id' => $t_dig_movingimage_rep->get('representation_id'), 'containerID' => 'caMediaPanelContentArea', 'access' => $va_access_values);			
						print "<div class='unit'>".caRepresentationViewer(
								$this->request, 
								$t_dig_movingimage, 
								$t_dig_movingimage,
								array_merge($va_opts, $va_media_display_info, 
									array(
										'display' => 'detail',
										'showAnnotations' => true, 
										'primaryOnly' => true, 
										'dontShowPlaceholder' => true, 
										'captionTemplate' => false
									)
								)
							)."</div>";
						if($vs_tmp = $t_dig_movingimage->getWithTemplate("<l>^ca_objects.preferred_labels.name</l>")){
							print "<div class='unit'><b>".$vs_tmp."</b></div>";
						}
					}else{
						# --- is there media that is not accessible to the public? If so we're going to put the rights text here
						if($t_dig_movingimage->get("ca_object_representations.representation_id")){
							$vb_media_not_accessible = true;
						}
						$va_related_dig_movingimage_no_media[] = $t_dig_movingimage->getWithTemplate("<l>^ca_objects.preferred_labels.name</l>");
					}
				}
?>
				</div>
<?php
			}
			if(!$vb_media && ($vb_media_not_accessible)){
?>
				<div class="unit"><br/>
					<b>{{{restricted_media}}}</b>
				</div>
<?php
			}
?>	
	
				</div>
			</div>
			<div class="row bgOffWhiteLight">
				<div class='col-sm-12 col-md-4'>					
					{{{<ifdef code="ca_occurrences.broadcast_details"><div class="unit"><label>Broadcast Details</label>
						<unit relativeTo="ca_occurrences.broadcast_details" delimiter="<br/>">
							<ifdef code="ca_occurrences.broadcast_details.aapb_asset"><b>Asset Type: </b>^ca_occurrences.broadcast_details.aapb_asset<br/></ifdef>
							<ifdef code="ca_occurrences.broadcast_details.episode_name"><b>Episode Name: </b>^ca_occurrences.broadcast_details.episode_name<br/></ifdef>
							<ifdef code="ca_occurrences.broadcast_details.episode_number"><b>Episode Number: </b>^ca_occurrences.broadcast_details.episode_number<br/></ifdef>
							<ifdef code="ca_occurrences.broadcast_details.series_title"><b>Series Title: </b>^ca_occurrences.broadcast_details.series_title<br/></ifdef>
							<ifdef code="ca_occurrences.broadcast_details.date_created"><b>Date Created: </b>^ca_occurrences.broadcast_details.date_created<br/></ifdef>
							<ifdef code="ca_occurrences.broadcast_details.date_broadcast"><b>Date Broadcast: </b>^ca_occurrences.broadcast_details.date_broadcast<br/></ifdef>
							<ifdef code="ca_occurrences.broadcast_details.date_rebroadcast"><b>Date Rebroadcast: </b>^ca_occurrences.broadcast_details.date_rebroadcast<br/></ifdef>
							<ifdef code="ca_occurrences.broadcast_details.av_description_text"><b>^ca_occurrences.broadcast_details.description_type<ifnotdef code="ca_occurrences.broadcast_details.description_type">Description</ifnotdef>: </b>^ca_occurrences.broadcast_details.av_description_text<br/></ifdef>
						</unit></div></ifdef>}}}
					
					
					{{{<ifdef code="ca_occurrences.language"><div class="unit"><label>Language</label>^ca_occurrences.language%delimiter=,_</div></ifdef>}}}
				</div>
				<div class='col-sm-12 col-md-4'>
					{{{<ifdef code="ca_occurrences.event_type"><div class="unit"><label>Event Type</label>^event_type%delimiter=,_</div></ifdef>}}}
					{{{<ifcount code="ca_entities" min="1" excludeRelationshipTypes="subject"><div class="unit"><label>Creators & Contributors</label><unit relativeTo="ca_entities" delimiter="<br/>" excludeRelationshipTypes="subject"><l>^ca_entities.preferred_labels.displayname</l> (^relationship_typename)</unit></div></ifcount>}}}
					{{{<ifdef code="ca_occurrences.description"><div class="unit"><label>Description</label>^ca_occurrences.description<br/></div></ifdef>}}}

				</div>
				<div class='col-sm-12 col-md-4'>
					
<?php
					$va_LcshSubjects = $t_item->get("ca_occurrences.lcsh_terms", array("returnAsArray" => true));
					$va_LcshSubjects_processed = array();
					if(is_array($va_LcshSubjects) && sizeof($va_LcshSubjects)){
						foreach($va_LcshSubjects as $vs_LcshSubjects){
							$vs_lcsh_subject = "";
							if($vs_LcshSubjects && (strpos($vs_LcshSubjects, " [") !== false)){
								$vs_LcshSubjects = mb_substr($vs_LcshSubjects, 0, strpos($vs_LcshSubjects, " ["));
							}
							$va_LcshSubjects_processed[] = caNavLink($this->request, $vs_LcshSubjects, "", "", "Search", "events", array("search" => "ca_occurrences.lcsh_terms: ".$vs_LcshSubjects));
						
						}
						$vs_LcshSubjects = join("<br/>", $va_LcshSubjects_processed);
					}
					
					$t_list_item = new ca_list_items;
					if($va_keywords = $t_item->get("ca_occurrences.internal_keywords", array("returnAsArray" => true))){
						$va_keyword_links = array();
						foreach($va_keywords as $vn_kw_id){
							$t_list_item->load($vn_kw_id);
							$va_keyword_links[] = caNavLink($this->request, $t_list_item->get("ca_list_item_labels.name_singular"), "", "", "Browse", "events", array("facet" => "keyword_facet", "id" => $vn_kw_id));
						}
						$vs_keyword_links = join("<br/>", $va_keyword_links);
					}
					
					if($vs_LcshSubjects || $vs_keyword_links){
						print "<div class='unit'><label>Subjects/Keywords</label>".$vs_LcshSubjects.(($vs_LcshSubjects && $vs_keyword_links) ? "<br/>" : "").$vs_keyword_links."</div>";	
					}

?>					
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="subject" min="1"><div class="unit"><label>Entity Subjects</label><unit relativeTo="ca_entities" delimiter="<br/>" restrictToRelationshipTypes="subject"><l>^ca_entities.preferred_labels.displayname</l></unit></div></ifcount>}}}
										
					{{{<ifcount code="ca_collections" min="1"><div class="unit"><label>Related Collection<ifcount code="ca_collections" min="2">s</ifcount></label><unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit></div></ifcount>}}}
					
					{{{<ifcount code="ca_occurrences.related" restrictToTypes="event" min="1"><div class="unit"><label>Related Event<ifcount code="ca_occurrences.related" min="2" restrictToTypes="event">s</ifcount>/Broadcast<ifcount code="ca_occurrences.related" min="2" restrictToTypes="event">s</ifcount></label><unit relativeTo="ca_occurrences" delimiter="<br/>" restrictToTypes="event"><l>^ca_occurrences.related.preferred_labels.name</l></unit></div></ifcount>}}}
<?php				
					if(sizeof($va_related_dig_audio_no_media)){
						print "<div class='unit'><label>Digital Audio Recording".((sizeof($va_related_dig_audio_no_media) > 1) ? "s" : "")."</label>".join("<br/>", $va_related_dig_audio_no_media)."</div>";
					}
?>
					{{{<ifcount code="ca_objects" min="1" restrictToTypes="audio_physical">
						<div class="unit"><label>Analog Audio Recording<ifcount code="ca_objects" min="2" restrictToTypes="audio_physical">s</ifcount></label>
							<unit relativeTo="ca_objects" restrictToTypes="audio_physical" delimiter="<br/>"><l>^ca_objects.idno<ifdef code="ca_objects.instantiationPhysAudio">, </ifdef>^ca_objects.instantiationPhysAudio</l></unit>
						</div>
					</ifcount>}}}
<?php
					if(sizeof($va_related_dig_movingimage_no_media)){
						print "<div class='unit'><label>Digital Moving Image".((sizeof($va_related_dig_movingimage_no_media) > 1) ? "s" : "")."</label>".join("<br/>", $va_related_dig_movingimage_no_media)."</div>";
					}
?>
					{{{<ifcount code="ca_objects" min="1" restrictToTypes="movingimage_physical">
						<div class="unit"><label>Analog Moving Image Recording<ifcount code="ca_objects" min="2" restrictToTypes="movingimage_physical">s</ifcount></label><HR/>
							<unit relativeTo="ca_objects" restrictToTypes="movingimage_physical" delimiter="<br/>"><l>^ca_objects.idno<ifdef code="ca_objects.instantiationPhysMovingImages">, </ifdef^ca_objects.instantiationPhysMovingImages</l></unit>
						</div>
					</ifcount>}}}
<?php
					if($vb_media){
?>
						<div class="unit"><label>Rights and Restrictions</label>
							{{{media_rights_restrictions}}}
						</div>
<?php				
					}
?>
				</div><!-- end col -->
			</div><!-- end row -->

{{{<ifcount code="ca_objects" min="1" excludeTypes="movingimage_physical,audio_physical,audio_digital,movingimage_digital">
			<div class="row">
				<div class="col-sm-12">
					<label>Related Object<ifcount code="ca_objects" min="2">s</ifcount></label><HR/>
				</div>
			</div>
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects_non_audio_video', array('search' => 'occurrence_id:^ca_occurrences.occurrence_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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