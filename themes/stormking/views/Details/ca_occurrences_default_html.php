<?php
	$t_item = $this->getVar("item");
	$vn_item_id = $t_item->get('ca_occurrences.occurrence_id');
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$va_access_values = caGetUserAccessValues($this->request);	
?>
<div class="row">
	<div class='col-xs-12 '>
		<div class="container"><div class="row">
			<div class='col-sm-12'>
				<div class='detailNav'>{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 ">
				<H4>{{{ca_occurrences.preferred_labels.name}}}</H4>
<?php				
				if ($vs_ex_dates = $t_item->get('ca_occurrences.exhibition_dates', array('delimiter' => '<br/>', 'sort' => 'ca_occurrences.exhibition_dates', 'sortDirection' => 'DESC'))) {
					print "<div>".$vs_ex_dates."</div>";
				}
?>								
			</div>		
		</div>
		<hr style='padding-bottom:5px;'>
		
<?php
#Related Installation Views
		if ($va_related_install = $t_item->get('ca_objects.related.object_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'restrictToRelationshipTypes' => array('install_photo', 'install_photo_primary'), 'sort' => 'ca_object_labels.name'))) {
			$vs_install_count = 0;
			print '<div class="row ">';

			print '	<div class="col-sm-12 exhibitionInstallationSlideshow">';
			print '<div class="jcarousel-wrapper"><div class="jcarousel"><ul>';

			$vn_output = 0;
			foreach ($va_related_install as $va_id => $va_related_install_id) {
				$t_rel_install = new ca_objects($va_related_install_id);
				$vs_install_image = $t_rel_install->get('ca_object_representations.media.page', array('checkAccess' => $va_access_values));
				if($vs_install_image){
					if ($vs_photo_credit = $t_rel_install->getWithTemplate('<unit relativeTo="ca_object_representations"><unit relativeTo="ca_entities" restrictToRelationshipTypes="photographer">^ca_entities.preferred_labels</unit></unit>')) {
						$vs_photo_credit = "<br/><span class='exhibitionRepPhotoCredit'>Photo by ".$vs_photo_credit."</span>";
					}
					print "<li>";
					print "<div class='exhibitionRep'><span>".caDetailLink($this->request, ($vs_install_image ? $vs_install_image : "<div class='bSimplePlaceholder'>".caGetThemeGraphic($this->request, 'spacer.png')."</div>"), '', 'ca_objects', $t_rel_install->get('ca_objects.object_id')).$vs_photo_credit."</span></div>"; 
					print "</li>";
					$vn_output++;
				}
				
			}
			
			print "</ul></div><!-- end jcarousel -->";
			if($vn_output > 1){
?>
				<!-- Prev/next controls -->
				<a href="#" class="jcarousel-control-prev"><i class="fa fa-angle-left"></i></a>
				<a href="#" class="jcarousel-control-next"><i class="fa fa-angle-right"></i></a>
<?php
			}					
			print "</div><!-- end jcarousel wrapper -->";
?>
					<script type='text/javascript'>
						jQuery(document).ready(function() {		
							/* width of li */
							$('.jcarousel li').width($('.jcarousel').width());
							$( window ).resize(function() { $('.jcarousel li').width($('.jcarousel').width()); });
							/*
							Carousel initialization
							*/
							$('.jcarousel')
								.jcarousel({
									// Options go here
									wrap:'circular'
								});
					
							/*
							 Prev control initialization
							 */
							$('.jcarousel-control-prev')
								.on('jcarouselcontrol:active', function() {
									$(this).removeClass('inactive');
								})
								.on('jcarouselcontrol:inactive', function() {
									$(this).addClass('inactive');
								})
								.jcarouselControl({
									// Options go here
									target: '-=1'
								});
					
							/*
							 Next control initialization
							 */
							$('.jcarousel-control-next')
								.on('jcarouselcontrol:active', function() {
									$(this).removeClass('inactive');
								})
								.on('jcarouselcontrol:inactive', function() {
									$(this).addClass('inactive');
								})
								.jcarouselControl({
									// Options go here
									target: '+=1'
								});
								
							
						});
					</script>
<?php
			
			print "<hr style='padding-bottom:5px; margin-top:15px;'>";		
			print "</div><!-- end col --></div><!-- end row -->";	
		}







/*	
		if ($vs_related_rep = $t_item->get('ca_objects.object_id', array('restrictToRelationshipTypes' => array('primary_rep'), 'returnAsArray' => true, 'checkAccess' => $va_access_values))) {
			$vn_rep_obj_id = $vs_related_rep[0];
			$t_ex_rep = new ca_objects($vn_rep_obj_id);
			print '<div class="row"><div class="col-sm-12">';
			$vs_ex_rep_info = $t_ex_rep->getPrimaryRepresentation(array('version' => 'page'), null, array('return_with_access' => $va_access_values));
			print "<div class='exhibitionRep'>".$vs_ex_rep_info['tags']['page']."</div>";
			print "<hr style='padding-bottom:5px; margin-top:15px;'>";						
			print '</div></div>';
		}
*/
?>				
		<div class="row exhibitionInfoRow">			
			<div class='col-sm-12 col-md-6 col-lg-6 exhibitionInfoCol colBorder'>
<?php
				if ($vs_description = $t_item->get('ca_occurrences.description')) {
					print "<div class='unit trimText'>".$vs_description."</div>";
				}
				if ($va_rel_programs = $t_item->get('ca_occurrences.related.preferred_labels', array('restrictToTypes' => array('exhibition', 'public_program'), 'returnAsLink' => true, 'delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Related Programs</h6>".$va_rel_programs."</div>";
				}
				if ($va_related_or_history = array_unique($t_item->get('ca_objects.object_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'restrictToTypes' => array('oral_history'))))) {
					print '<h6>Related Oral Histories</h6>';
					foreach ($va_related_or_history as $va_id => $va_related_or_history_id) {
						$t_rel_or = new ca_objects($va_related_or_history_id);
						print "<div class='detailLine'>";
						print "<p>".caNavLink($this->request, $t_rel_or->get('ca_objects.preferred_labels'), '', 'Detail', 'oralhistory', $t_rel_or->get('ca_objects.object_id'))."</p>";
						print "</div>";
					}
				}				
								
?>
			</div><!-- end col -->
			<div class='col-sm-12 col-md-6 col-lg-6 exhibitionInfoCol'><div class="videoCol">
<?php
				$va_vimeos = $t_item->get('ca_occurrences.vimeo', array('returnWithStructure' => true, 'convertCodesToDisplayText' => true));
				if(is_array($va_vimeos) && sizeof($va_vimeos)){
					$va_vimeos = array_pop($va_vimeos);
					foreach($va_vimeos as $va_vimeo){
						if(($va_vimeo["vimeo_publish"] == "yes") && ($va_vimeo["vimeo_id_exhibition"])){
							print '<iframe src="https://player.vimeo.com/video/'.$va_vimeo["vimeo_id_exhibition"].'?color=ffffff&title=0&byline=0&portrait=0" class="exhibitionIframe" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
				 			if($va_vimeo["vimeo_caption"]){
				 				print "<div class='small exhibitionVimeoCaption'>".$va_vimeo["vimeo_caption"]."</div>";
				 			}
						}	
					}
				}
				$va_related_catalogue = $t_item->get('ca_objects.related.object_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'restrictToRelationshipTypes' => array('catalogue'), 'sort' => 'ca_object_labels.name'));
				$va_remarks_images_url = $t_item->get('ca_occurrences.bibliography.url', array('returnAsArray' => true, 'version' => 'original'));
				$va_checklist_images_url = $t_item->get('ca_occurrences.checklist.url', array('returnAsArray' => true, 'version' => 'original'));
				$va_statement_images_url = $t_item->get('ca_occurrences.statement.url', array('returnAsArray' => true, 'version' => 'original'));
				$vs_website = $t_item->get('ca_occurrences.exhibition_website');
		?>
				<div class="row">
<?php
					if($va_related_catalogue || $va_remarks_images_url || $va_checklist_images_url || $va_statement_images_url || $vs_website){
?>
					<div class="col-lg-6 col-md-12">
		<?php
						if($va_related_catalogue){
							foreach ($va_related_catalogue as $vn_i => $vn_related_catalogue_id) {
								$t_rel_catalogue = new ca_objects($vn_related_catalogue_id);
								if($va_pdfs = $t_rel_catalogue->representationsWithMimeType(array('application/pdf'), array('versions' => array('original'), 'return_with_access' => $va_access_values))){
									foreach($va_pdfs as $vn_rep_id => $va_pdf_info){
										print "<h6><i class='fa fa-file'></i> <a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaOverlay', array('context' => 'archival', 'id' => $vn_related_catalogue_id, 'representation_id' => $vn_rep_id, 'overlay' => 1))."\"); return false;'>View Catalogue/Brochure </a></h6>";
									}
								}
							}
						}
						if ($va_remarks_images_url) {
							foreach ($va_remarks_images_url as $va_key => $va_remarks_images_url_path) {
								print "<h6><i class='fa fa-file'></i> <a href='".$va_remarks_images_url_path."'>View Bibliography </a></h6>";
							}
						}				
						if ($va_checklist_images_url) {
							foreach ($va_checklist_images_url as $va_key => $va_checklist_images_url_path) {
								print "<h6><i class='fa fa-file'></i> <a href='".$va_checklist_images_url_path."'>View Checklist </a></h6>";
							}
						}				
						if ($va_statement_images_url) {
							foreach ($va_statement_images_url as $va_key => $va_statement_images_url_path) {
								print "<h6><i class='fa fa-file'></i> <a href='".$va_statement_images_url_path."'>View PDF </a></h6>";
							}
						}
				

						if ($vs_website) {
							print "<div class='unit zoomIcon'><h6><i class='fa fa-external-link-square'></i> <a href='".$vs_website."' target='_blank'>View Exhibition Website</a></h6></div>";
						}			
?>
					</div>
<?php
				}
?>
					<div class="col-lg-6 col-md-12">
<?php
	
						#if ($vs_ext_link = $t_item->getWithTemplate('<ifcount min="1" code="ca_occurrences.external_link.url_entry"><unit relativeTo="ca_occurrences.external_link" delimiter=" "><ifdef code="ca_occurrences.external_link.url_entry"><div class="unit zoomIcon"><h6><i class="fa fa-external-link-square"></i> <a href="^ca_occurrences.external_link.url_entry">^ca_occurrences.external_link.url_source</a></h6></div></ifdef></unit></ifcount>')) {
						#	print $vs_ext_link;
						#}
						$va_event_links = $t_item->get("ca_occurrences.event_calendar_link", array("returnWithStructure" => true, "sort" => "ca_occurrences.event_calendar_link.event_link"));
						if(is_array($va_event_links) && sizeof($va_event_links)){
							$va_event_links = array_pop($va_event_links);
							$va_future_events = array();
							$va_past_events = array();
							$vn_now = date("Y.md");
							foreach($va_event_links as $va_event_info){
								if($va_event_info["event_link"]){
									$vs_tmp = "<h6><i class='fa fa-external-link-square'></i> <a href='".$va_event_info["event_link"]."' target='_blank'>".(($va_event_info["event_name"]) ? $va_event_info["event_name"] : $va_event_info["event_link"])."</a>";
									if($va_event_info["event_date"]){
										$vs_tmp .= "<div class='eventLinkDate'>".$va_event_info["event_date"]."</div>";
									}
									$vs_tmp .= "</h6>";
									if($va_event_info["event_date_sort_"] > $vn_now){
										$va_future_events[] = $vs_tmp;
									}else{
										$va_past_events[] = $vs_tmp;
									}
								}
							}
							if(is_array($va_future_events) && sizeof($va_future_events)){
								print "<div class='unit'><H6>Upcoming Event".((sizeof($va_future_events) > 1) ? "s" : "")."</H6>".join($va_future_events, " ")."</div>";
							}
							if(is_array($va_past_events) && sizeof($va_past_events)){
								$va_past_events = array_reverse($va_past_events);
								print "<div class='unit'><H6>Past Event".((sizeof($va_past_events) > 1) ? "s" : "")."</H6>".join($va_past_events, " ")."</div>";
							}
						}
?>
					</div>
				</div><!-- end row --></div><!-- end videoCol -->					
			</div><!-- end col -->
		</div><!-- end row -->
<?php	
		#Related Artworks	
		if ($va_related_artworks = $t_item->get('ca_objects.object_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'restrictToTypes' => array('loaned_artwork', 'sk_artwork'), 'excludeRelationshipTypes' => array('install_photo', 'install_photo_not_accessible', 'install_photo_primary'), 'sort' => 'ca_object_labels.name'))) {
			$vs_art_count = 0;
			print '<div class="row objInfo">';
			print '	<div class="col-sm-12"><hr><h6 class="header">Artworks</h6></div>';
			foreach ($va_related_artworks as $va_id => $va_related_artwork_id) {
				$t_rel_obj = new ca_objects($va_related_artwork_id);
				print "<div class='col-sm-3'>";
				print "<div class='relatedArtwork'>";
				if ($t_rel_obj->get('ca_object_representations.media.widepreview', array('checkAccess' => $va_access_values))) {
					$vs_art_image = caDetailLink($this->request, $t_rel_obj->get('ca_object_representations.media.widepreview', array('checkAccess' => $va_access_values)), '', 'ca_objects', $t_rel_obj->get('ca_objects.object_id'));
				} else {
					$vs_art_image = null;
				}
				print "<div class='relImg'>".($vs_art_image ? $vs_art_image : "<div class='bSimplePlaceholder'>".caGetThemeGraphic($this->request, 'spacer.png')."</div>")."</div>";
				print "<div class='relArtTitle'><p>".$t_rel_obj->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('artist'), 'checkAccess' => $va_access_values, 'delimiter' => ', '))."</p>";
				print "<p>".caDetailLink($this->request, ( $t_rel_obj->get('ca_objects.preferred_labels') == "Untitled" ? $t_rel_obj->get('ca_objects.preferred_labels') : "<i>".$t_rel_obj->get('ca_objects.preferred_labels')."</i>"), '', 'ca_objects', $t_rel_obj->get('ca_objects.object_id'));
				if ($vs_art_date = $t_rel_obj->get('ca_objects.display_date')) {
					print ", ".$vs_art_date;
				}
				print "</p></div></div>";
				print "</div><!-- end col -->";
				$vs_art_count++;
				if ($vs_art_count == 4) {
					break;
				}

			}
			if ($vs_art_count == 4) {
				print "<div class='viewAll'>".caNavLink($this->request, "View all <i class='fa fa-angle-right'></i>", '', '', 'Browse', 'allworks', array('facet' => 'occurrence_facet', 'id' => $vn_item_id))."</div>";
			}
			print "</div><!-- end row -->";			
		}
		
		#Related Archival Items
		if ($va_related_archival = $t_item->get('ca_objects.related.object_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'restrictToRelationshipTypes' => array('archival_item')))) {
			$vs_archival_count = 0;
			print '<div class="row objInfo">';

			print '	<div class="col-sm-12"><hr><h6 class="header">Archival Items</h6></div>';
			foreach ($va_related_archival as $va_id => $va_related_archival_id) {
				$t_rel_archival = new ca_objects($va_related_archival_id);
				print "<div class='col-sm-3'>";
				print "<div class='relatedArtwork'>";
				if ($t_rel_archival->get('ca_object_representations.media.widepreview', array('checkAccess' => $va_access_values))) {
					$vs_archival_image = caDetailLink($this->request, $t_rel_archival->get('ca_object_representations.media.widepreview', array('checkAccess' => $va_access_values)), '', 'ca_objects', $t_rel_archival->get('ca_objects.object_id'));
				} else {
					$vs_archival_image = null;
				}				
				print "<div class='relImg'>".caDetailLink($this->request, ($vs_archival_image ? $vs_archival_image : "<div class='bSimplePlaceholder'>".caGetThemeGraphic($this->request, 'spacer.png')."</div>"), '', 'ca_objects', $t_rel_archival->get('ca_objects.object_id'))."</div>";
				print "<p>".$t_rel_archival->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('artist'), 'checkAccess' => $va_access_values, 'delimiter' => ', '))."</p>";
				print "<p>".caDetailLink($this->request, $t_rel_archival->get('ca_objects.preferred_labels'), '', 'ca_objects', $t_rel_archival->get('ca_objects.object_id'));
				print "</p></div>";
				print "</div><!-- end col -->";
				$vs_archival_count++;
				if ($vs_archival_count == 4) {
					break;
				}				
			}
			if ($vs_archival_count == 4) {
				print "<div class='viewAll'>".caNavLink($this->request, "View all <i class='fa fa-angle-right'></i>", '', '', 'Browse', 'install', array('facet' => 'archive_item_facet', 'id' => $vn_item_id))."</div>";
			}	
			print "</div><!-- end row -->";			
		}	
		#Related Media

		if ($va_related_media = $t_item->get('ca_objects.related.object_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'restrictToRelationshipTypes' => array('media'), 'sort' => 'ca_object_labels.name'))) {
			$vs_media_count = 0;
			print '<div class="row objInfo">';

			print '	<div class="col-sm-12"><hr><h6 class="header">Media</h6></div>';
			foreach ($va_related_media as $va_id => $va_related_media_id) {
				$t_rel_media = new ca_objects($va_related_media_id);
				print "<div class='col-sm-3'>";
				print "<div class='relatedArtwork'>";
				if ($t_rel_media->get('ca_object_representations.media.widepreview', array('checkAccess' => $va_access_values))) {
					$vs_media_image = caDetailLink($this->request, $t_rel_media->get('ca_object_representations.media.widepreview', array('checkAccess' => $va_access_values)), '', 'ca_objects', $t_rel_media->get('ca_objects.object_id'));
				} else {
					$vs_media_image = null;
				}					
				print "<div class='relImg'>".caDetailLink($this->request, ($vs_media_image ? $vs_media_image : "<div class='bSimplePlaceholder'>".caGetThemeGraphic($this->request, 'spacer.png')."</div>"), '', 'ca_objects', $t_rel_media->get('ca_objects.object_id'))."</div>";
				print "<p>".$t_rel_media->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('artist'), 'checkAccess' => $va_access_values, 'delimiter' => ', '))."</p>";
				print "<p>".caDetailLink($this->request, $t_rel_media->get('ca_objects.preferred_labels'), '', 'ca_objects', $t_rel_media->get('ca_objects.object_id'));
				print "</p></div>";
				print "</div><!-- end col -->";
				$vs_media_count++;
				if ($vs_media_count == 4) {
					break;
				}
			}
			if ($vs_media_count == 4) {
				print "<div class='viewAll'>".caNavLink($this->request, "View all <i class='fa fa-angle-right'></i>", '', '', 'Browse', 'install', array('facet' => 'media_facet', 'id' => $vn_item_id))."</div>";
			}			
			print "</div><!-- end row -->";			
		}
		
		
		#Related Catalogue
/*		if ($va_related_catalogue = $t_item->get('ca_objects.related.object_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'restrictToRelationshipTypes' => array('catalogue'), 'sort' => 'ca_object_labels.name'))) {
			print '<div class="row objInfo">';

			print '	<div class="col-sm-12"><hr><h6 class="header">Catalogue</h6></div>';
			foreach ($va_related_catalogue as $va_id => $va_related_catalogue_id) {
				$t_rel_catalogue = new ca_objects($va_related_catalogue_id);
				print "<div class='col-sm-3'>";
				print "<div class='relatedArtwork'>";
				print "<div class='relImg'>".caDetailLink($this->request, $t_rel_catalogue->get('ca_object_representations.media.widepreview', array('checkAccess' => $va_access_values)), '', 'ca_objects', $t_rel_catalogue->get('ca_objects.object_id'))."</div>";
				print "<p>".$t_rel_catalogue->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('artist'), 'checkAccess' => $va_access_values, 'delimiter' => ', '))."</p>";
				print "<p>".caDetailLink($this->request, $t_rel_catalogue->get('ca_objects.preferred_labels'), '', 'ca_objects', $t_rel_catalogue->get('ca_objects.object_id'));
				print "</p></div>";
				print "</div><!-- end col -->";
			}
			print "</div><!-- end row -->";			
		}	
*/								
?>				
		
		</div><!-- end container -->
	</div><!-- end col -->
</div><!-- end row -->
<script type='text/javascript'>
	jQuery(document).ready(function() {
		trimMaxHeight = 200;
		if($('.videoCol').height() > trimMaxHeight){
			trimMaxHeight = $('.videoCol').height() - 40;
		}
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: trimMaxHeight,
		  linkText: 'Continue Reading'
		});
		
		$(window).on('resize', function (event) {
			resizer();
		});
		resizer();
	});
	function resizer() {
		if($(window).width() > 992){
			$('.exhibitionInfoCol').css('min-height', 'auto');
			$('.exhibitionInfoCol').css('min-height', $('.exhibitionInfoRow').height() + 'px');
		}else{
			$('.exhibitionInfoCol').css('min-height', 'auto');
		}
	}
</script>