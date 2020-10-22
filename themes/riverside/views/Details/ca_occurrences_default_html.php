<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$va_access_values = $this->getVar("access_values");
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
					<H1>{{{^ca_occurrences.preferred_labels.name}}}</H1>
					{{{<ifdef code="ca_occurrences.event_date"><H2>^ca_occurrences.event_date</H2></ifdef>}}}
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-sm-6'>
<?php
			if($va_dig_audio_recording = $t_item->get("ca_objects.object_id", array("returnAsArray" => true, "restrictToTypes" => "audio_digital", "checkAccess" => $va_access_values))){
?>
				<div class="unit">
<?php
				foreach($va_dig_audio_recording as $vn_dig_audio_recording_id){
					$t_dig_audio = new ca_objects($vn_dig_audio_recording_id);
					if($t_dig_audio_rep = $t_dig_audio->getPrimaryRepresentationInstance(array("checkAccess" => $va_access_values))){
						$va_opts = array('display' => 'related_object_overlay', 'object_id' => $t_dig_audio->get('object_id'), 'representation_id' => $t_dig_audio_rep->get('representation_id'), 'containerID' => 'caMediaPanelContentArea', 'access' => $va_access_values);			
						print caRepresentationViewer(
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
							);
					}
					if($vs_tmp = $t_dig_audio->get("ca_objects.preferred_labels.name")){
						print "<div class='unit'><b>".$vs_tmp."</b></div>";
					}
				}
?>
				</div>
<?php
			}

			if($va_analog_audio_recording = $t_item->get("ca_objects.object_id", array("returnAsArray" => true, "restrictToTypes" => "audio_physical", "checkAccess" => $va_access_values))){
?>
				<div class="unit"><label>Analog Audio Recording</label>
<?php
				foreach($va_analog_audio_recording as $va_analog_audio_recording_id){
				$t_analog_audio = new ca_objects($va_analog_audio_recording_id);
					if($t_analog_audio_rep = $t_analog_audio->getPrimaryRepresentationInstance(array("checkAccess" => $va_access_values))){
						$va_opts = array('display' => 'related_object_overlay', 'object_id' => $t_analog_audio->get('object_id'), 'representation_id' => $t_analog_audio_rep->get('representation_id'), 'containerID' => 'caMediaPanelContentArea', 'access' => $va_access_values);			
						print caRepresentationViewer(
								$this->request, 
								$t_analog_audio, 
								$t_analog_audio,
								array_merge($va_opts, $va_media_display_info, 
									array(
										'display' => 'detail',
										'showAnnotations' => true, 
										'primaryOnly' => true, 
										'dontShowPlaceholder' => true, 
										'captionTemplate' => false
									)
								)
							);
					}
					if($vs_tmp = $t_dig_audio->get("ca_objects.preferred_labels.name")){
						print "<div class='unit'><b>".$vs_tmp."</b></div>";
					}
				}
?>
				</div>
<?php
			}
			if($va_dig_movingimage_recording = $t_item->get("ca_objects.object_id", array("returnAsArray" => true, "restrictToTypes" => "movingimage_digital", "checkAccess" => $va_access_values))){
?>
				<div class="unit"><br/>
<?php
				foreach($va_dig_movingimage_recording as $vn_dig_movingimage_recording_id){
					$t_dig_movingimage = new ca_objects($vn_dig_movingimage_recording_id);
					if($t_dig_movingimage_rep = $t_dig_movingimage->getPrimaryRepresentationInstance(array("checkAccess" => $va_access_values))){
						$va_opts = array('display' => 'related_object_overlay', 'object_id' => $t_dig_movingimage->get('object_id'), 'representation_id' => $t_dig_movingimage_rep->get('representation_id'), 'containerID' => 'caMediaPanelContentArea', 'access' => $va_access_values);			
						print caRepresentationViewer(
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
							);
					}
					if($vs_tmp = $t_dig_movingimage->get("ca_objects.preferred_labels.name")){
						print "<div class='unit'><b>".$vs_tmp."</b></div>";
					}
				}
?>
				</div>
<?php
			}

			if($va_analog_movingimage_recording = $t_item->get("ca_objects.object_id", array("returnAsArray" => true, "restrictToTypes" => "movingimage_physical", "checkAccess" => $va_access_values))){
?>
				<div class="unit"><label>Analog Moving Image Recording</label>
<?php
				foreach($va_analog_movingimage_recording as $va_analog_movingimage_recording_id){
				$t_analog_movingimage = new ca_objects($va_analog_movingimage_recording_id);
					if($t_analog_movingimage_rep = $t_analog_movingimage->getPrimaryRepresentationInstance(array("checkAccess" => $va_access_values))){
						$va_opts = array('display' => 'related_object_overlay', 'object_id' => $t_analog_movingimage->get('object_id'), 'representation_id' => $t_analog_movingimage_rep->get('representation_id'), 'containerID' => 'caMediaPanelContentArea', 'access' => $va_access_values);			
						print caRepresentationViewer(
								$this->request, 
								$t_analog_movingimage, 
								$t_analog_movingimage,
								array_merge($va_opts, $va_media_display_info, 
									array(
										'display' => 'detail',
										'showAnnotations' => true, 
										'primaryOnly' => true, 
										'dontShowPlaceholder' => true, 
										'captionTemplate' => false
									)
								)
							);
					}
					if($vs_tmp = $t_dig_movingimage->get("ca_objects.preferred_labels.name")){
						print "<div class='unit'><b>".$vs_tmp."</b></div>";
					}
				}
?>
				</div>
<?php
			}			
?>	
	
				</div>
				<div class='col-sm-6'>
					{{{<ifdef code="ca_occurrences.event_type"><div class="unit"><label>Event Type</label>^event_type%delimiter=,_</div></ifdef>}}}
					{{{<ifcount code="ca_entities" min="1" excludeRelationshipTypes="subject"><div class="unit"><label>Creators & Contributors</label><unit relativeTo="ca_entities" delimiter="<br/>" excludeRelationshipTypes="subject"><l>^ca_entities.preferred_labels.displayname</l> (^relationship_typename)</unit></div></ifcount>}}}
					
					{{{<ifdef code="ca_occurrences.description"><div class="unit"><label>Description</label>^ca_occurrences.description<br/></div></ifdef>}}}
					
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
					{{{<ifdef code="ca_occurrences.lcsh_terms"><div class="unit"><label>LOC Subject Headings</label>^ca_occurrences.lcsh_terms%delimiter=<br/></div></ifdef>}}}
					{{{<ifdef code="ca_occurrences.internal_keywords"><div class="unit"><label>Keywords</label>^ca_occurrences.internal_keywords%delimiter=<br/></div></ifdef>}}}
					{{{<ifdef code="ca_occurrences.lc_names"><div class="unit"><label>LOC Name Authority File</label>^ca_occurrences.lc_names%delimiter=<br/></div></ifdef>}}}
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="subject" min="1"><div class="unit"><label>Entity Subjects</label><unit relativeTo="ca_entities" delimiter="<br/>" restrictToRelationshipTypes="subject"><l>^ca_entities.preferred_labels.displayname</l></unit></div></ifcount>}}}
										
					{{{<ifcount code="ca_collections" min="1"><div class="unit"><label>Related Collection<ifcount code="ca_collections" min="2">s</ifcount></label><unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit></div></ifcount>}}}
					
					{{{<ifcount code="ca_occurrences.related" restrictToTypes="event" min="1"><div class="unit"><label>Related Event<ifcount code="ca_occurrences.related" min="2" restrictToTypes="event">s</ifcount></label><unit relativeTo="ca_occurrences" delimiter="<br/>" restrictToTypes="event"><l>^ca_occurrences.related.preferred_labels.name</l></unit></div></ifcount>}}}
<?php
					# Comment and Share Tools
					if ($vn_comments_enabled | $vn_share_enabled) {
						
						print '<div id="detailTools">';
						if ($vn_comments_enabled) {
?>				
							<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment" aria-label="<?php print _t("Comments and tags"); ?>"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
							<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
						}
						if ($vn_share_enabled) {
							print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt" aria-label="'._t("Share").'"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
						}
						print '</div><!-- end detailTools -->';
					}				
?>
					
				</div><!-- end col -->
			</div><!-- end row -->
{{{<ifcount code="ca_objects" min="1">
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'occurrence_id:^ca_occurrences.occurrence_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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