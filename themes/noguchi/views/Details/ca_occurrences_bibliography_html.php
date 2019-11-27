<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
	
	$vn_previous_id = $this->getVar("previousID");
	$vn_next_id = $this->getVar("nextID");
	$va_access_values = caGetUserAccessValues();
	
	$vs_placeholder = $this->request->config->get("site_host").caGetThemeGraphicUrl("placeholder.png");
	$vs_placeholder_tag = '<img nopin="nopin"  src="'.$vs_placeholder.'" />';
?>
    <main class="ca bibliography bibliography_detail nomargin">

        <section class="wrap block block-top">


<?php
 			if($vs_back = ResultContext::getResultsLinkForLastFind($this->request, 'ca_occurrences', '< Back to Results', 'eyebrow', array())){
?>           
            <div class="text-gray block-quarter back">
<?php
				print $vs_back;
?>
            </div>
<?php
 			}
 			if($va_object_ids = $t_item->get("ca_objects.object_id", array("returnAsArray" => true,"restrictToTypes" => array("archival_item","document","objects","photographs","digital","print","strip","transparency","strip_image"), "checkAccess" => $va_access_values))){
 				$va_media = array();
 				$va_thumbs = array();
 				foreach($va_object_ids as $vn_object_id){
 					$t_object = new ca_objects($vn_object_id);
 					if($t_rep = $t_object->getPrimaryRepresentationInstance(array("checkAccess" => $va_access_values))){
 						if(!$t_rep_for_meta_tags){
 							$t_rep_for_meta_tags = $t_rep;
 						}
// 						print "object_id: ".$t_object->get("object_id");
// 						print " - representation_id: ".$t_rep->get("representation_id");
						if (!($vs_viewer_name = MediaViewerManager::getViewerForMimetype("detail", $vs_mimetype = $t_rep->getMediaInfo('media', 'original', 'MIMETYPE')))) {
							throw new ApplicationException(_t('Invalid viewer'));
						}
						if(!is_array($va_media_display_info = caGetMediaDisplayInfo('detail', $t_rep->getMediaInfo('media', 'original', 'MIMETYPE')))) { $va_media_display_info = []; }
						$vs_media = $vs_viewer_name::getViewerHTML(
							$this->request,
							"representation:".$t_rep->getPrimaryKey(),
							['t_instance' => $t_rep, 't_subject' => $t_object, 't_media' => $t_object, 'display' => $va_media_display_info],
							['context' => 'archival']);
						if($vs_mimetype != "application/pdf"){
							$vs_media = '<div class="img-wrapper contain">'.$vs_media.'</div>';
						}
						$va_media[] = $vs_media;
						$va_thumbs[] = $t_rep->get("ca_object_representations.media.icon.url");
					}					
 				}
 				if(sizeof($va_media)){
?>  

            <div class="ca-object-viewer">

                <div class="module_slideshow is-finite slideshow-main no_dots" data-thumbnails="slideshow-thumbnails">
                    <div class="slick-slider slider-main">
<?php
						foreach($va_media as $vs_media){
?>
							<div class="slick-slide">
								<div class="img-container">
									<?php print $vs_media; ?>
								</div>
							</div>
<?php
						}
?>
                    </div>
                </div>
<?php
					if(is_array($va_thumbs) && (sizeof($va_thumbs) > 1)){
?>
					<ul class="slideshow-thumbnails" data-as-nav="slider-main" data-is-nav="true">
<?php
						foreach($va_thumbs as $vn_i => $vs_thumb_url){
							print '<li><a href="#" data-index="'.$vn_i.'" '.(($vn_i == 0) ? 'class="selected"' : '').'><img src="'.$vs_thumb_url.'"></a></li>';
						}
?>
					</ul>
<?php
					}else{
?>
						<div class="block-half"><br/></div>
<?php
					}
?>
            </div>
<?php
				}
			}
?>
            <div class="wrap-max-content text-align-center">

                <div class="block">

                    <div class="block-quarter">
                        {{{<ifdef code="ca_occurrences.citation_format"><div class="eyebrow text-gray">^ca_occurrences.citation_format</div></ifdef>}}}
                        <h2 class="subheadline-l">{{{^ca_occurrences.preferred_labels.name}}}</h2>
                    </div>
                    {{{<ifdef code="ca_occurrences.bib_year_published">
						<div class="block-quarter">
							<div class="subheadline text-gray">^ca_occurrences.bib_year_published</div>
						</div>
					</ifdef>}}}
                    {{{<ifdef code="ca_occurrences.idno">
						<div class="block-quarter">
							<div class="eyebrow text-gray">Identifier</div>
							<div class="ca-data">^ca_occurrences.idno</div>
						</div>
					</ifdef>}}}
                    {{{<ifdef code="ca_occurrences.bib_full_citation">
						<div class="block-quarter">
							<div class="eyebrow text-gray">Citation</div>
							<div class="ca-data">^ca_occurrences.bib_full_citation</div>
						</div>
					</ifdef>}}}
                </div>
{{{<ifcount code="ca_occurrences.related" min="1">
                <div class="module_accordion">
                    <div class="items">

		<ifcount code="ca_occurrences.related" min="1" restrictToTypes="exhibition">
                        <div class="item">
                            <div class="trigger small">Related Exhibitions</div>            
                            <div class="details">
                                <div class="inner">
                                    <ul class="ca-data text-align-left related">
                                        <unit relativeTo="ca_occurrences.related" restrictToTypes="exhibition" delimiter=" " sort="ca_occurrences.date.parsed_date">
											<li>
												<l><i>^ca_occurrences.preferred_labels.name</i>, <unit relativeTo='ca_entities' restrictToRelationships='primary_venue'>^ca_entities.preferred_labels.displayname</unit>, ^ca_occurrences.date.display_date</l>
											</li>
                                        </unit>
                                    </ul>
                                </div>
                            </div>
                        </div>
		</ifcount>
		<ifcount code="ca_occurrences.related" min="1" restrictToTypes="bibliography">
                        <div class="item">
                            <div class="trigger small">Related Bibliography</div>            
                            <div class="details">
                                <div class="inner">
                                    <ul class="ca-data text-align-left related">
                                        <unit relativeTo="ca_occurrences.related" restrictToTypes="bibliography" delimiter=" " sort="ca_occurrences.bib_year_published">
											<li>
												<l>^ca_occurrences.preferred_labels.name</l>
											</li>
                                        </unit>
                                    </ul>
                                </div>
                            </div>
                        </div>
		</ifcount>

                    </div>
                </div>
</ifcount>}}}


            </div>
        </section>
<?php
	if($vn_previous_id || $vn_next_id){
?>
	<div class="wrap">
		<section class="widget-pagination block-top">
			<div class="layout-2">
				<div class="col">
<?php
					if($vn_previous_id){
						print caDetailLink('&lt; PREVIOUS', 'text-dark eyebrow previous', 'ca_objects', $vn_previous_id);
					}
?>
				</div>
				<div class="col">
<?php
			
					if($vn_next_id){
						print caDetailLink('NEXT &gt;', 'text-dark eyebrow next', 'ca_objects', $vn_next_id);
					}
?>					
				</div>
		</section>
	</div>
<?php
	}
?>
{{{<ifcount code="ca_objects" restrictToTypes="artwork,cast,chronology_image,edition,element,group,reproduction,study,version" min="1">
       <section class="wrap block border">
            <div class="block text-align-center">
                <h4 class="subheadline-bold">Artworks Cited</h4>
            </div>
            <div class="module_slideshow is-finite manual-init slideshow-related">
                <div class="slick-slider">
					<unit relativeTo="ca_objects" delimiter=" " restrictToTypes="artwork,cast,chronology_image,edition,element,group,reproduction,study,version" sort="ca_objects.idno_sort">
						<div class="slick-slide">
							<div class="item">
								<l>
									<div class="img-wrapper archive_thumb block-quarter">
										<ifdef code="ca_object_representations.media.medium.url"><img nopin="nopin"  src="^ca_object_representations.media.medium.url" /></ifdef>
										<ifnotdef code="ca_object_representations.media.medium.url"><?php print $vs_placeholder_tag; ?></ifnotdef>
									</div>
									<div class="text block-quarter">
										<div class="ca-identifier text-gray">^ca_objects.idno</div>
										<div class="more">                                
											<div class="thumb-text clamp" data-lines="2">^ca_objects.preferred_labels.name</div>
											<ifdef code="ca_objects.date.display_date"><div class="ca-identifier text-gray">^ca_objects.date.display_date%delimiter=,_</div></ifdef>
											<ifnotdef code="ca_objects.date.display_date"><ifdef code="ca_objects.date.parsed_date"><div class="ca-identifier text-gray">^ca_objects.date.parsed_date%delimiter=,_</div></ifdef></ifnotdef>
										</div>
									</div>
								</l>
							</div>
						</div>
					</unit>
				</div>
			</div>
        </section>
</ifcount>}}}

    </main>
<?php
	# --- meta tags
	MetaTagManager::addMeta("twitter:title", str_replace('"', '', $t_item->get("ca_occurrences.preferred_labels.name")));
	MetaTagManager::addMetaProperty("og:title", str_replace('"', '', $t_item->get("ca_occurrences.preferred_labels.name")));
	MetaTagManager::addMetaProperty("og:url", $this->request->config->get("site_host").caNavUrl("*", "*", "*"));
	if($t_rep_for_meta_tags){
		MetaTagManager::addMetaProperty("og:image", $t_rep_for_meta_tags->get("ca_object_representations.media.large.url"));
		MetaTagManager::addMetaProperty("og:image:secure_url", $t_rep_for_meta_tags->get("ca_object_representations.media.large.url"));
		MetaTagManager::addMeta("twitter:image", $t_rep_for_meta_tags->get("ca_object_representations.media.large.url"));
		$va_media_info = $t_rep_for_meta_tags->getMediaInfo('media', 'large');
		MetaTagManager::addMetaProperty("og:image:width", $va_media_info["WIDTH"]);
		MetaTagManager::addMetaProperty("og:image:height", $va_media_info["HEIGHT"]);
	}	
?>