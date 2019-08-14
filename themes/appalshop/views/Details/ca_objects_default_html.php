<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2018 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */
 
	$t_object = 			$this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$vn_id =				$t_object->get('ca_objects.object_id');
?>
<div class="row">
	<div class='col-xs-6 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div>	
	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>
		<div class="container">
		  <div class="row">
			<div class='col-sm-6 col-md-5  col-lg-6'>
				{{{representationViewer}}}						
				<div id="detailAnnotations"></div>			
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
				
<?php
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled | $vn_pdf_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments and Tags (<?php print sizeof($va_comments) + sizeof($va_tags); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					if ($vn_pdf_enabled) {
						print "<div class='detailTool'><span class='glyphicon glyphicon-file'></span>".caDetailLink($this->request, "Download as PDF", "faDownload", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
					}
					print '</div><!-- end detailTools -->';
				}				

?>
				<div id="fb-root"></div>
				  <script>(function(d, s, id) {
					var js, fjs = d.getElementsByTagName(s)[0];
					if (d.getElementById(id)) return;
					js = d.createElement(s); js.id = id;
					js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
					fjs.parentNode.insertBefore(js, fjs);
				  }(document, 'script', 'facebook-jssdk'));</script>

				  <!-- Your share button code -->
				  <div class="detailFbShare"><div class="fb-share-button" 
						data-href="<?php print $this->request->config->get("site_host").caDetailUrl($this->request, "ca_objects", $t_object->get("object_id")); ?>" 
						data-layout="button">
					  </div>
				  </div>

			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-5 col-lg-6'>
				<H4>{{{ca_objects.preferred_labels.name}}}</H4>
				<H6>{{{<unit>^ca_objects.type_id</unit>}}}</H6>
				<HR>
				{{{<ifdef code="ca_objects.idno"><H6>Identifier</H6>^ca_objects.idno<br/></ifdef>}}}
				{{{<ifdef code="ca_objects.altID"><H6>Alt Identifier</H6>^ca_objects.altID<br/></ifdef>}}}
				{{{<ifdef code="ca_objects.date.dates_value"><h6>Date</h6></ifdef>}}}			
				{{{<unit relativeTo="ca_objects.date.dates_value" delimiter="<br/>">^ca_objects.date.dc_dates_types <if rule="^ca_objects.date.date_approximate2 =~ /Yes/">circa </if>^ca_objects.date.dates_value</unit>}}}

				{{{<ifdef code="ca_objects.av_date.av_dates_value"><h6>Date</h6>^ca_objects.av_date.av_dates_value<br/></ifdeg>}}}
	            {{{<ifcount restrictToRelationshipTypes="artist,co_producer,composer,director,illustrator,performer,photographer,producer,writer" code="ca_entities" min="1" max="1"><H6>Creator</H6></ifcount>}}}
				{{{<ifcount restrictToRelationshipTypes="artist,co_producer,composer,director,illustrator,performer,photographer,producer,writer" code="ca_entities" min="2"><H6>Creators</H6></ifcount>}}}
				<span class="trimText">{{{<unit relativeTo="ca_entities" delimiter="<br/>" restrictToRelationshipTypes="artist,co_producer,composer,director,illustrator,performer,photographer,producer,writer">^ca_entities.preferred_labels (^relationship_typename)</unit>}}}</span>
			    {{{<ifcount restrictToRelationshipTypes="actor,animator,audio_engineer,author,broadcast_engineer,camera_assistant,camera_operator,cinematographer,composer,contributing_artist,editor,engineer,filmmaker,interviewee,interviewer,musician,narrator,performer,recording_engineer,sound_mixer,subject,writer" code="ca_entities" min="1" max="1"><H6>Contributor</H6></ifcount>}}}
				{{{<ifcount restrictToRelationshipTypes="actor,animator,audio_engineer,author,broadcast_engineer,camera_assistant,camera_operator,cinematographer,composer,contributing_artist,editor,engineer,filmmaker,interviewee,interviewer,musician,narrator,performer,recording_engineer,sound_mixer,subject,writer" code="ca_entities" min="2"><H6>Contributors</H6></ifcount>}}}
				<span class="trimText">{{{<unit relativeTo="ca_entities.related" delimiter="<br/>" restrictToRelationshipTypes="actor,animator,audio_engineer,author,broadcast_engineer,camera_assistant,camera_operator,cinematographer,composer,contributing_artist,editor,engineer,filmmaker,interviewee,interviewer,musician,narrator,performer,recording_engineer,sound_mixer,subject,writer">^ca_entities.preferred_labels (^relationship_typename)</unit>}}}</span>
				{{{<ifdef code="ca_objects.media_type"><h6>Media Type</h6>^ca_objects.media_type<br/></ifdef>}}}
				{{{<ifdef code="ca_objects.av_format_Hierachical"><h6>Physical Format</h6>^ca_objects.av_format_Hierachical<br/></ifdef>}}}
				{{{<ifdef code="ca_objects.ph_digital_format"><h6>Digital Format</h6>^ca_objects.ph_digital_format<br/></ifdef>}}}
				{{{<ifdef code="ca_objects.photo_format"><h6>Format</h6>^ca_objects.photo_format<br/></ifdef>}}}
				{{{<ifdef code="ca_objects.paper_format"><h6>Format</h6>^ca_objects.paper_format<br/></ifdef>}}}
				{{{<ifdef code="ca_objects.erec_format"><h6>Format</h6>^ca_objects.erec_format<br/></ifdef>}}}
				{{{<ifdef code="ca_objects.generation_element"><h6>Generation:</h6>^ca_objects.generation_element<br/></ifdef>}}}
				{{{<ifdef code="ca_objects.generation_general")><h6>Generation - General</h6>^ca_objects.generation_general<br/></ifdef>}}}
				{{{<ifdef code="ca_objects.container"><H6>Container</H6>^ca_objects.container<br/></ifdef>}}}	
				{{{<ifdef code="ca_objects.georeference"><H6>Georeference</H6>^ca_objects.georeference<br/></ifdef>}}}	
				{{{<ifdef code="ca_objects.color"><H6>Color</H6>^ca_objects.color<br/></ifdef>}}}	
				{{{<ifdef code="ca_objects.av_sound"><h6>Sound</h6>^ca_objects.av_sound<br/></ifdef>}}}				
				{{{<ifdef code="ca_objects.description_w_type">
					<div class='unit'><h6>Description</h6>
						<span class="trimText">^ca_objects.description_w_type.description</span>
					</div>
				</ifdef>}}}
<?php
				$va_list_items = $t_object->get("ca_list_items", array("returnWithStructure" => true));
				if(is_array($va_list_items) && sizeof($va_list_items)){
					$va_terms = array();
					foreach($va_list_items as $va_list_item){
						$va_terms[] = caNavLink($this->request, $va_list_item["name_singular"], "", "", "Browse", "objects", array("facet" => "term_facet", "id" => $va_list_item["item_id"]));
					}
					print "<div class='unit'><H6>Subject".((sizeof($va_terms) > 1) ? "s" : "")."</H6>".join($va_terms, ", ")."</div>";	
				}
?>
				
				{{{<ifdef code="ca_objects.source"><h6>Source</h6>^ca_objects.source<br/></ifdef>}}}	
				{{{<ifdef code="ca_objects.rights"><h6>Rights Summary</h6>^ca_objects.rights<br/></ifdef>}}}
				{{{<ifdef code="ca_objects.access_restrictions"><h6>Access Restrictions</h6>^ca_objects.access_restrictions<br/></ifdef>}}}			
				{{{<ifdef code="ca_objects.user_restrictions"><h6>User Restrictions</h6>^ca_objects.user_restrictions<br/></ifdef>}}}
				{{{<ifdef code="ca_objects.externalLink"><h6>External Links</h6><unit relativeTo="ca_objects" delimiter="<br/>"><a href="^ca_objects.externalLink.url_entry" target="_blank">^ca_objects.externalLink.url_source</a></ifdef>}}}
							
					<div class="row">
						<div class="col-sm-12">	
						{{{<case>
							<ifcount code="ca_collections" min="1"><HR/></ifcount>
							<ifcount code="ca_occurrences" min="1"><HR/></ifcount>
							<ifcount code="ca_places" min="1"><HR/></ifcount>
						</case>}}}
						    {{{<ifcount code="ca_collections" unique="1"  min="1" max="1"><H6>Related Collection</H6></ifcount>}}}
							{{{<ifcount code="ca_collections" unique="1"  min="2"><H6>Related Collections</H6></ifcount>}}}
							{{{<unit relativeTo="ca_objects_x_collections" unique="1" delimiter="<br/>"><unit unique="1" relativeTo="ca_collections"><l>^ca_collections.preferred_labels.name</l></unit></unit>}}}						
							{{{<ifcount code="ca_occurrences" min="1" max="1"><H6>Related Work</H6></ifcount>}}}
							{{{<ifcount code="ca_occurrences" min="2"><H6>Related Works</H6></ifcount>}}}
							{{{<unit relativeTo="ca_objects_x_occurrences" delimiter="<br/>"><unit relativeTo="ca_occurrences"><l>^ca_occurrences.preferred_labels</l></unit> (^relationship_typename)</unit>}}}		
							{{{<ifcount code="ca_places" min="1" max="1"><H6>Related Place</H6></ifcount>}}}
							{{{<ifcount code="ca_places" min="2"><H6>Related Places</H6></ifcount>}}}
							{{{<unit relativeTo="ca_objects_x_places" delimiter="<br/>"><unit relativeTo="ca_places"><l>^ca_places.preferred_labels</l></unit></unit>}}}	
						</div><!-- end col -->	
						</div>		
						<div class="row">	
						<div class="col-sm-12 colBorderLeft">
							{{{map}}}
						</div>
					</div><!-- end row -->
						
			</div><!-- end col -->
		</div><!-- end row --></div><!-- end container -->
	</div><!-- end col -->
		<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->

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