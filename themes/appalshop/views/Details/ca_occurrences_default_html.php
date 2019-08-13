<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
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
					<H6>{{{^ca_occurrences.type_id}}}{{{<ifdef code="ca_occurrences.idno">, ^ca_occurrences.idno</ifdef>}}}</H6>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-sm-6 col-md-6 col-lg-6'>
					{{{<ifdef code="ca_occurrences.dateProduced"><h6>Date of Production</h6>^ca_occurrences.dateProduced<br/></ifdef>}}}
					{{{<ifdef code="ca_occurrences.work_description_w_type.work_description"><H6>Description</H6>
					<span class="trimText">^ca_occurrences.work_description_w_type.work_description</span><br/></ifdef>}}}
					{{{<ifdef code="ca_occurrences.duration"><h6>Duration</h6>Run time: ^ca_occurrences.duration.runTime<br/></ifdef>}}}
					{{{<ifdef code="ca_occurrences.externalLink"><h6>External Links</h6><unit relativeTo="ca_occurrences" delimiter="<br/>"><a href="^ca_occurrences.externalLink.url_entry" target="_blank">^ca_occurrences.externalLink.url_source</a><br/></ifdef>}}}
					<br/>
					{{{<ifcount code="ca_objects" min="1" max="1"><div class='unit'><unit relativeTo="ca_objects" delimiter=" "><l>^ca_object_representations.media.large</l><div class='caption'>Related Object: <l>^ca_objects.preferred_labels.name</l></div></unit></div></ifcount>}}}
                   
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
				
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="sponsor," min="1" max="1"><H6>Sponsor</H6></ifcount>}}}
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="sponsor," min="2"><H6>Sponsors</H6></ifcount>}}}
					{{{<unit relativeTo="ca_entities" delimiter="<br/>" restrictToRelationshipTypes="sponsor,">^ca_entities.preferred_labels.displayname</unit>}}}
					
					{{{<ifcount code="ca_list_items" min="1" max="1"><H6>Subject</H6></ifcount>}}}
					{{{<ifcount code="ca_list_items" min="2"><H6>Subjects</H6></ifcount>}}}
					{{{<unit relativeTo="ca_occurrences_x_vocabulary_terms" delimiter="<br/>" >^ca_list_items.preferred_labels.name_plural</unit>}}}
				    
					{{{<ifdef code="ca_occurrences.lcsh_genre"><h6>Genre</h6>^ca_occurrences.lcsh_genre<br/></ifdef>}}}

					{{{<case>
						<ifcount code="ca_collections" min="1"><HR/></ifcount>
						<ifcount code="ca_occurrences" min="1"><HR/></ifcount>
						<ifcount code="ca_places" min="1"><HR/></ifcount>
					</case>}}}
				
					{{{<ifcount code="ca_collections" min="1" max="1"><H6>Related collection</H6></ifcount>}}}
					{{{<ifcount code="ca_collections" min="2"><H6>Related collections</H6></ifcount>}}}
					{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit>}}}
						
					{{{<ifcount code="ca_occurrences.related" min="1" max="1"><H6>Related occurrence</H6></ifcount>}}}
					{{{<ifcount code="ca_occurrences.related" min="2"><H6>Related occurrences</H6></ifcount>}}}
					{{{<unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.related.preferred_labels.name</l></unit>}}}
					
					{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
					{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
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