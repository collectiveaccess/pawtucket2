<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
	
	$vn_previous_id = $this->getVar("previousID");
	$vn_next_id = $this->getVar("nextID");
	
	$vs_status = $t_item->get("ca_occurrences.status", array("convertCodesToDisplayText" => true));
	$va_access_values = caGetUserAccessValues();
	
	$vs_placeholder = $this->request->config->get("site_host").caGetThemeGraphicUrl("placeholder.png");
	$vs_placeholder_tag = '<img nopin="nopin"  src="'.$vs_placeholder.'" />';

?>
    <main class="ca bibliography bibliography_detail nomargin">

        <section class="wrap block block-top">


<?php
 			# --- not sure what the back nav would be here since there is no exhibitions browse
 			if($x && $vs_back = ResultContext::getResultsLinkForLastFind($this->request, 'ca_occurrences', '< Back to Results', 'eyebrow', array())){
?>           
            <div class="text-gray block-quarter back">
<?php
				print $vs_back;
?>
            </div>
<?php
 			}
 			if($vs_reps = $t_item->getWithTemplate("<unit relativeTo='ca_objects' restrictToRelationshipTypes='describes,depicts'>^ca_object_representations.representation_id</unit>", array("checkAccess" => $va_access_values))){
 				$va_rep_ids = explode(";", $vs_reps);
 				if(is_array($va_rep_ids) && sizeof($va_rep_ids)){
?>  

            <div class="ca-object-viewer">

                <div class="module_slideshow slideshow-main no_dots" data-thumbnails="slideshow-thumbnails">
                    <div class="slick-slider slider-main">
<?php
						$va_thumbs = array();
						foreach($va_rep_ids as $vn_rep_id){
							$vs_display_version = "";
							$t_rep = new ca_object_representations();
							$t_rep->load($vn_rep_id);
							#$va_media_display_info = caGetMediaDisplayInfo('detail', $t_rep->getMediaInfo('media', 'original', 'MIMETYPE'));
							#if($va_media_display_info && sizeof($va_media_display_info)){
							#	($va_media_display_info["display_version"]) ? $vs_display_version = $va_media_display_info["display_version"] : "small";
							#}
							$vs_display_version = "page";
							
							$va_thumbs[] = $t_rep->get("ca_object_representations.media.icon.url");
							
?>
							<div class="slick-slide">
								<div class="img-container">
									<div class="img-wrapper contain"><img src="<?php print $t_rep->get("ca_object_representations.media.".$vs_display_version.".url"); ?>"></div>
								</div>
							</div>
<?php
						}
?>
                    </div>
                </div>
<?php
					if(is_array($va_thumbs) && sizeof($va_thumbs)){
?>
					<ul class="slideshow-thumbnails" data-as-nav="slider-main" data-is-nav="true">
<?php
						foreach($va_thumbs as $vn_i => $vs_thumb_url){
							print '<li><a href="#" data-index="'.$vn_i.'" '.(($vn_i == 0) ? 'class="selected"' : '').'><img src="'.$vs_thumb_url.'"></a></li>';
						}
?>
					</ul>
<?php
					}
?>
            </div>
<?php
				}
			}
?>
            <div class="pagination">
<?php
				if($vn_previous_id){
					print caDetailLink('', 'previous', 'ca_occurrences', $vn_previous_id);
				}
				if($vn_next_id){
					print caDetailLink('', 'next', 'ca_occurrences', $vn_next_id);
				}
?>            </div>


            <div class="wrap-max-content text-align-center">

                <div class="block">
<?php
		switch(strToLower($vs_status)){
			case "published":
			case "research suspended":
?>
            <div class="wrap-max-content text-align-center">

                <div class="block">

                   <div class="block-quarter">
                        <h2 class="subheadline-l">{{{^ca_occurrences.preferred_labels.name}}}</h2>
                    </div>
                    {{{<ifdef code="ca_occurrences.date.display_date">
						<div class="block-quarter">
							<div class="subheadline text-gray">^ca_occurrences.date.display_date</div>
						</div>
					</ifdef>}}}
                    {{{<ifnotdef code="ca_occurrences.date.display_date"><ifdef code="ca_objects.date.parsed_date">
						<div class="block-quarter">
							<div class="subheadline text-gray">^ca_occurrences.date.parsed_date</div>
						</div>
                    </ifdef></ifnotdef>}}}
                    {{{<ifcount min="1" code="ca_entities" restrictToRelationshipTypes="primary_venue">
						<div class="block-quarter">
							<div class="eyebrow text-gray">Primary Venue</div>
							<div class="ca-data"><unit relativeTo="ca_entities" restrictToRelationshipTypes="primary_venue" delimeter="<br/>">^ca_entities.preferred_labels.displayname</unit></div>
						</div>
					</ifcount>}}}
					{{{<ifdef code="ca_occurrences.idno">
						<div class="block-quarter">
							<div class="eyebrow text-gray">Identifier</div>
							<div class="ca-data">^ca_occurrences.idno</div>
						</div>
					</ifdef>}}}
					{{{<ifdef code="ca_occurrences.exhibition_comments">
						<div class="block-quarter">
							<div class="eyebrow text-gray">Comments</div>
							<div class="ca-data">^ca_occurrences.exhibition_comments</div>
						</div>
					</ifdef>}}}
					{{{<ifdef code="ca_occurrences.published_on">
						<div class="block-quarter">
							<div class="eyebrow text-gray">Published On</div>
							<div class="ca-data">^ca_occurrences.published_on</div>
						</div>
                    </ifdef>}}}
                    {{{<ifdef code="ca_occurrences.suspended">
						<div class="block-quarter">
							<div class="eyebrow text-gray">Research Suspended On</div>
							<div class="ca-data">^ca_occurrences.suspended</div>
						</div>
                    </ifdef>}}}
                    {{{<ifdef code="ca_occurrences.last_updated_on">
						<div class="block-quarter">
							<div class="eyebrow text-gray">Last Updated On</div>
							<div class="ca-data">^ca_occurrences.last_updated_on</div>
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
                                    <ul class="list-sidebar ca-data text-align-left related">
                                        <unit relativeTo="ca_occurrences.related" restrictToTypes="exhibition" delimiter=" ">
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
                                    <ul class="list-sidebar ca-data text-align-left related">
                                        <unit relativeTo="ca_occurrences.related" restrictToTypes="bibliography" delimiter=" ">
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
{{{<ifcount code="ca_objects" restrictToRelationshipTypes="part" restrictToTypes="artwork,cast,chronology_image,edition,element,group,reproduction,study,version" min="1">
        <section class="block border">
            <div class="wrap">
                <div class="block-half text-align-center">
                    <h4 class="subheadline-bold">Checklist of Artworks</h4>
                </div>
            </div>
            <div class="module_carousel archive_related" data-prevnext="false">
				<div class="carousel-main">
					<unit relativeTo="ca_objects" restrictToRelationshipTypes="part" restrictToTypes="artwork,cast,chronology_image,edition,element,group,reproduction,study,version" delimiter=" ">
						<div class="carousel-cell">

							<l>
								<div class="img-wrapper archive_thumb block-quarter">
									<ifdef code="ca_object_representations.media.medium.url"><img nopin="nopin"  src="^ca_object_representations.media.medium.url" /></ifdef>
									<ifnotdef code="ca_object_representations.media.medium.url"><?php print $vs_placeholder_tag; ?></ifnotdef>
								</div>
								<div class="text block-quarter">
									<div class="ca-identifier text-gray">^ca_objects.idno</div>
									<div class="more">                                
										<div class="thumb-text clamp" data-lines="2">^ca_objects.preferred_labels.name</div>
										<ifdef code="ca_objects.date.display_date"><div class="ca-identifier text-gray">^ca_objects.date.display_date</div></ifdef>
										<ifnotdef code="ca_objects.date.display_date"><ifdef code="ca_objects.date.parsed_date"><div class="ca-identifier text-gray">^ca_objects.date.parsed_date</div></ifdef></ifnotdef>
									</div>
								</div>
							</l>
						</div>
					</unit>
				</div>
			</div>
        </section>
</ifcount>}}}
<?php

			break;
			# ----------------------------------------------------
			case "research pending":
?>
            <div class="wrap-max-content text-align-center">

                <div class="block">

                   <div class="block-quarter">
                        <h2 class="subheadline-l">{{{^ca_occurrences.preferred_labels.name}}}</h2>
                    </div>
                    {{{<ifdef code="ca_occurrences.date.display_date">
						<div class="block-quarter">
							<div class="subheadline text-gray">^ca_occurrences.date.display_date</div>
						</div>
					</ifdef>}}}
                    {{{<ifnotdef code="ca_occurrences.date.display_date"><ifdef code="ca_objects.date.parsed_date">
						<div class="block-quarter">
							<div class="subheadline text-gray">^ca_occurrences.date.parsed_date</div>
						</div>
                    </ifdef></ifnotdef>}}}
                    {{{<ifcount min="1" code="ca_entities" restrictToRelationshipTypes="primary_venue">
						<div class="block-quarter">
							<div class="eyebrow text-gray">Primary Venue</div>
							<div class="ca-data"><unit relativeTo="ca_entities" restrictToRelationshipTypes="primary_venue" delimeter="<br/>">^ca_entities.preferred_labels.displayname</unit></div>
						</div>
					</ifcount>}}}
					{{{<ifdef code="ca_occurrences.idno">
						<div class="block-quarter">
							<div class="eyebrow text-gray">Identifier</div>
							<div class="ca-data">^ca_occurrences.idno</div>
						</div>
					</ifdef>}}}
                    {{{<ifdef code="ca_occurrences.status">
						<div class="block-quarter">
							<div class="eyebrow text-gray">Status</div>
							<div class="ca-data">^ca_occurrences.status</div>
						</div>
					</ifdef>}}}
				</div>
			</div>
		</section>
<?php
			break;
			# ----------------------------------------------------
		}
?>
 
                


    </main>
