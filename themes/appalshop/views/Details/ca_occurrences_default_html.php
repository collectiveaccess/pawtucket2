<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$va_access_values = caGetUserAccessValues($this->request);
	
	if($vs_tmp = $t_item->get('preferred_labels')){
		MetaTagManager::addMetaProperty("og:description", htmlentities(strip_tags($vs_tmp)));
		MetaTagManager::addMetaProperty("description", htmlentities(strip_tags($vs_tmp)));
	}
	if($vs_rep = $t_item->get("ca_object_representations.media.page.url", array("checkAccess" => $va_access_values))){
		MetaTagManager::addMetaProperty("og:image", $vs_rep);
		MetaTagManager::addMetaProperty("og:image:width", $t_item->get("ca_object_representations.media.page.width"));
		MetaTagManager::addMetaProperty("og:image:height", $t_item->get("ca_object_representations.media.page.height"));
	}

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
					<H4>{{{^ca_occurrences.preferred_labels.name}}}</H4>
					<H6 style="margin-top:0px;">{{{^ca_occurrences.type_id}}}</H6>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-sm-6 col-md-6 col-lg-6'>
					{{{<ifdef code="ca_occurrences.idno"><div class="unit"><h6>Identifier</h6>^ca_occurrences.idno</div></ifdef>}}}
					{{{<ifdef code="ca_occurrences.dateProduced"><div class="unit"><h6>Date of Production</h6>^ca_occurrences.dateProduced</div></ifdef>}}}
					{{{<ifdef code="ca_occurrences.color"><div class="unit"><h6>Color</h6>^ca_occurrences.color</div></ifdef>}}}
					{{{<ifdef code="ca_occurrences.duration"><div class="unit"><h6>Duration</h6>Run time: ^ca_occurrences.duration.runTime</div></ifdef>}}}
					{{{<ifdef code="ca_occurrences.abstract"><div class="unit"><h6>Summary</h6>^ca_occurrences.abstract</div></ifdef>}}}
<?php
					if($va_subjects = $t_item->get("ca_list_items.preferred_labels.name_plural", array("returnAsArray" => true, "checkAccess" => $va_access_values))){
						print "<div class='unit'><H6>Subject".((sizeof($va_subjects) > 1) ? "s" : "")."</H6>";
						$va_subject_links = array();
						foreach($va_subjects as $vs_subject){
							$va_subject_links[] = caNavLink($this->request, $vs_subject, '', '', 'MultiSearch', 'Index', array('search' => '"'.$vs_subject.'"'));	
						}
						print join(", ", $va_subject_links);
						print "</div>";
					}
?>
					{{{<ifcount code="ca_objects" min="1" max="1"><br/><br/><div class='unit'><unit relativeTo="ca_objects" delimiter=" "><l>^ca_object_representations.media.large</l><div class='caption'>Related Object: <l>^ca_objects.preferred_labels.name</l></div></unit></div></ifcount>}}}
                   	{{{<ifcount code="ca_objects" min="2"><br/><br/><div class='unit'><unit relativeTo="ca_objects" delimiter=" " restrictToRelationshipTypes="primary"><l>^ca_object_representations.media.large</l><div class='caption'>Related Object: <l>^ca_objects.preferred_labels.name</l></div></unit></div></ifcount>}}}
                   	{{{<ifdef code="ca_occurrences.externalLink"><div class="unit"><h6>External Links</h6><unit relativeTo="ca_occurrences" delimiter="<br/>"><a href="^ca_occurrences.externalLink.url_entry" target="_blank">^ca_occurrences.externalLink.url_source</a></div></ifdef>}}}
					
					
<?php
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
				<div class='col-md-6 col-lg-6'>
				  	{{{<ifcount code="ca_entities" restrictToRelationshipTypes="artist,co_producer,composer,director,illustrator,performer,photographer,producer,writer" code="ca_entities" min="1" max="1"><H6>Creator</H6></ifcount>}}}
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="artist,co_producer,composer,director,illustrator,performer,photographer,producer,writer" code="ca_entities" min="2"><H6>Creators</H6></ifcount>}}}
					{{{<unit relativeTo="ca_entities" delimiter="<br/>" restrictToRelationshipTypes="artist,co_producer,composer,director,illustrator,performer,photographer,producer,writer">^ca_entities.preferred_labels.displayname (^relationship_typename)</unit>}}}
				
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="actor,animator,audio_engineer,author,broadcast_engineer,camera_assistant,camera_operator,cinematographer,composer,contributing_artist,editor,engineer,filmmaker,interviewee,interviewer,musician,narrator,performer,recording_engineer,sound_mixer,subject,writer" min="1" max="1"><H6>Contributor</H6></ifcount>}}}
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="actor,animator,audio_engineer,author,broadcast_engineer,camera_assistant,camera_operator,cinematographer,composer,contributing_artist,editor,engineer,filmmaker,interviewee,interviewer,musician,narrator,performer,recording_engineer,sound_mixer,subject,writer" min="2"><H6>Contributors</H6></ifcount>}}}
					{{{<unit relativeTo="ca_entities" delimiter="<br/>" restrictToRelationshipTypes="actor,animator,audio_engineer,author,broadcast_engineer,camera_assistant,camera_operator,cinematographer,composer,contributing_artist,editor,engineer,filmmaker,interviewee,interviewer,musician,narrator,performer,recording_engineer,sound_mixer,subject,writer">^ca_entities.preferred_labels.displayname (^relationship_typename)</unit>}}}
					
					{{{<ifdef code="ca_occurrences.work_description_w_type.work_description"><div class="unit"><H6>Description</H6>
					<span class="trimText">^ca_occurrences.work_description_w_type.work_description</span></div></ifdef>}}}
<?php
					$va_loc_md = array("Names (Library of Congress)" => "lcsh_names", "Topics (Library of Congress)" => "lcsh_topical", "Georgaphical Areas (Library of Congress)" => "lcsh_geo", "Genre (Library of Congress)" => "lcsh_genre");
					foreach($va_loc_md as $vs_label => $vs_loc_md){
						if($va_terms = $t_item->get("ca_occurrences.".$vs_loc_md, array("returnAsArray" => true))){
							$va_tmp = array();
							print "<div class='unit'><H6>".$vs_label."</H6>";
							foreach($va_terms as $vs_term){
								if($vn_str_pos = strpos($vs_term, " [")){
									$va_tmp[] = substr($vs_term, 0, $vn_str_pos);
								}else{
									$va_tmp[] = $vs_term;
								}
							}
							print join(", ", $va_tmp);
							print "</div>";
						}
					}
?>
					
					{{{<ifcount code="ca_occurrences.related" min="1" max="1"><H6>Related Work</H6></ifcount>}}}
					{{{<ifcount code="ca_occurrences.related" min="2"><H6>Related Works</H6></ifcount>}}}
					{{{<unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.related.preferred_labels.name</l></unit>}}}
					
					{{{<ifcount code="ca_collections" min="1" max="1"><H6>Related Collection</H6></ifcount>}}}
					{{{<ifcount code="ca_collections" min="2"><H6>Related Collections</H6></ifcount>}}}
					{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit>}}}
						
					{{{<ifcount code="ca_places" min="1" max="1"><H6>Related Place</H6></ifcount>}}}
					{{{<ifcount code="ca_places" min="2"><H6>Related Places</H6></ifcount>}}}
					{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l></unit>}}}		
					{{{map}}}			
				</div><!-- end col -->
			</div><!-- end row -->
{{{<ifcount code="ca_objects" min="2">
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'occurrence_id:^ca_occurrences.occurrence_id', 'view' => 'images'), array('dontURLEncodeParameters' => true)); ?>", function() {
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

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>