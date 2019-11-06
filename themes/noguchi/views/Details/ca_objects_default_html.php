<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
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
	
	$vn_previous_id = $this->getVar("previousID");
	$vn_next_id = $this->getVar("nextID");			
	
	$vs_status = $t_object->get("ca_objects.status", array("convertCodesToDisplayText" => true));
	$va_access_values = caGetUserAccessValues();
	$vs_placeholder = $this->request->config->get("site_host").caGetThemeGraphicUrl("placeholder.png");
	$vs_placeholder_tag = '<img nopin="nopin"  src="'.$vs_placeholder.'" />';
	
	MetaTagManager::setWindowTitle("The Isamu Noguchi Catalogue Raisonné: Artwork: ".$t_object->get("ca_objects.preferred_labels.name").": [".$t_object->get("ca_objects.idno")."]");
?>
    <main class="ca cr cr_detail nomargin">
<?php
		print $this->render("pageFormat/cr_nav.php");
?>       
        <section class="wrap block block-top">

<?php
 			if($vs_back = ResultContext::getResultsLinkForLastFind($this->request, 'ca_objects', '< Back to Results', 'eyebrow', array())){
?>           
            <div class="text-gray block-quarter back">
<?php
				print $vs_back;
?>
            </div>
<?php
 			}
 			
 			if(strtoLower($t_object->get("ca_objects.status", array("convertCodesToDisplayText" => true))) == "research pending"){
 				$va_rep_ids = $t_object->get("ca_object_representations.representation_id", array("returnAsArray" => true, "filterNonPrimaryRepresentations" => true, "checkAccess" => $va_access_values));
 			
 			}else{
 				$va_rep_ids = $t_object->get("ca_object_representations.representation_id", array("returnAsArray" => true, "filterNonPrimaryRepresentations" => false, "sort" => "ca_objects_x_object_representations.is_primary", "checkAccess" => $va_access_values));
 				if(is_array($va_rep_ids) && sizeof($va_rep_ids)){
 					$va_rep_ids = array_reverse($va_rep_ids);
 				}
 			}
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
							$va_media_display_info = caGetMediaDisplayInfo('detail', $t_rep->getMediaInfo('media', 'original', 'MIMETYPE'));
							if($va_media_display_info && sizeof($va_media_display_info)){
								($va_media_display_info["display_version"]) ? $vs_display_version = $va_media_display_info["display_version"] : "small";
							}
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
?>
            <div class="pagination">
<?php
				if($vn_previous_id){
					print caDetailLink('', 'previous', 'ca_objects', $vn_previous_id);
				}
				if($vn_next_id){
					print caDetailLink('', 'next', 'ca_objects', $vn_next_id);
				}
?>
            </div>


            <div class="wrap-text text-align-center">

                

<?php
		switch(strToLower($vs_status)){
			case "published":
			case "research suspended":
?>
                <div class="block">
                    <div class="block-quarter">
						<div class="eyebrow text-gray">{{{^ca_objects.idno}}}</div>
					</div>
                    <div class="block-quarter">
                        <h2 class="subheadline-l">{{{^ca_objects.preferred_labels.name}}}</h2>
                    </div>
                    {{{<ifdef code="ca_objects.nonpreferred_labels.name" restrictToTypes="secondary|tertiary">
						<div class="block-quarter">
							<div class="ca-data"><unit relativeTo="ca_objects.nonpreferred_labels" delimiter="<br/>" restrictToTypes="secondary">^ca_objects.nonpreferred_labels.name</unit></div>
							<div class="ca-data"><unit relativeTo="ca_objects.nonpreferred_labels" delimiter="<br/>" restrictToTypes="tertiary">^ca_objects.nonpreferred_labels.name</unit></div>
						</div>
					</ifdef>}}}
                    {{{<ifdef code="ca_objects.date.display_date">
						<div class="block-quarter">
							<div class="subheadline text-gray">^ca_objects.date.display_date</div>
						</div>
					</ifdef>}}}
                    {{{<ifnotdef code="ca_objects.date.display_date"><ifdef code="ca_objects.date.parsed_date">
						<div class="block-quarter">
							<div class="subheadline text-gray">^ca_objects.date.parsed_date</div>
						</div>
                    </ifdef></ifnotdef>}}}
                    {{{<ifdef code="ca_objects.technique">
						<div class="block-quarter">
							<div class="ca-data"><ifdef code="ca_objects.technique">^ca_objects.technique%delimiter=,_ </ifdef></div>
						</div>
					</ifdef>}}}
<?php
				if($t_object->get("ca_objects.display_dimensions") || $t_object->get("ca_objects.base") || $t_object->get("ca_objects.num_of_elements") || $t_object->get("ca_objects.inscriptions") || $t_object->get("ca_objects.edition")){
					print '<div class="block-quarter">';
				}
?>
							{{{<ifdef code="ca_objects.display_dimensions"><div class="ca-data"><unit relativeTo="ca_objects.display_dimensions" delimiter="<br/>">^ca_objects.display_dimensions</unit></div></ifdef>}}}
							{{{<ifdef code="ca_objects.base"><div class="ca-data">^ca_objects.base</div></ifdef>}}}
							{{{<ifdef code="ca_objects.num_of_elements"><div class="ca-data">^ca_objects.num_of_elements</div></ifdef>}}}
<?php
							if($vs_inscription = $t_object->get("ca_objects.inscriptions")){
								// replace symbol codes with graphics
								$vs_circle = caGetThemeGraphic("bisected_circle_24_gray.png");
								$vs_hiragana_no = caGetThemeGraphic("hiragana_no_24_gray.png");
								$vs_inscription = preg_replace('!\[c\]!i', $vs_circle, $vs_inscription);
								$vs_inscription = preg_replace('!\[circle/line\]!i', $vs_circle, $vs_inscription);
								$vs_inscription = preg_replace('!\[no\]!i', $vs_hiragana_no, $vs_inscription);
								$vs_inscription = preg_replace('!\[Hiragana no\]!i', $vs_hiragana_no, $vs_inscription);
					
								print '<div class="ca-data">'.$vs_inscription."</div>";
							}
?>						
							{{{<ifdef code="ca_objects.edition"><div class="ca-data">^ca_objects.edition</div></ifdef>}}}

<?php
				if($t_object->get("ca_objects.display_dimensions") || $t_object->get("ca_objects.base") || $t_object->get("ca_objects.num_of_elements") || $t_object->get("ca_objects.inscriptions") || $t_object->get("ca_objects.edition")){
					print '</div> <!-- end block-quarter-->';
				}
?>
                  	{{{<ifcount code="ca_entities" excludeRelationshipTypes="sitter,collection" min="1">
						<div class="block-quarter">
							<div class="ca-data"><unit relativeTo="ca_objects_x_entities" excludeRelationshipTypes="sitter,collection" delimiter=" "><div class="capitalizeFirst">^relationship_typename ^ca_entities.preferred_labels.displayname</div></unit></div>
						</div>
                    </ifcount>}}}
					{{{<ifdef code="ca_objects.current_collection">
						<div class="block-quarter">
							<div class="eyebrow text-gray">Current Collection</div>
							<div class="ca-data">^ca_objects.current_collection</div>
						</div>
					</ifdef>}}}
					<?php
						if($vs_provenance = $t_object->get("ca_objects.provenance")){
							print '<div class="block-quarter">
										<div class="eyebrow text-gray">Provenance</div>
										<div class="ca-data">'.caConvertLineBreaks($vs_provenance).'</div>
									</div>';
						}
					?>
  
					{{{<ifdef code="ca_objects.published_on">
						<div class="block-quarter">
							<div class="eyebrow text-gray">Published On</div>
							<div class="ca-data">^ca_objects.published_on</div>
						</div>
                    </ifdef>}}}
                    {{{<ifdef code="ca_objects.suspended">
						<div class="block-quarter">
							<div class="eyebrow text-gray">Research Suspended On</div>
							<div class="ca-data">^ca_objects.suspended</div>
						</div>
                    </ifdef>}}}
                    {{{<ifdef code="ca_objects.last_updated_on">
						<div class="block-quarter">
							<div class="eyebrow text-gray">Last Updated On</div>
							<div class="ca-data">^ca_objects.last_updated_on</div>
						</div>
                    </ifdef>}}}
                    {{{<ifdef code="ca_objects.status">
						<div class="block-quarter">
							<div class="eyebrow text-gray">Status</div>
							<div class="ca-data capitalize">^ca_objects.status</div>
						</div>
					</ifdef>}}}
					<div class="block-quarter">
						<div class="eyebrow text-gray">{{{crCopyrightBoilerplate}}}</div>
					</div>
				</div><!-- end block -->
	{{{<ifcount code="ca_occurrences" min="1">               
                <div class="module_accordion">
                    <div class="items">
	<ifcount code="ca_occurrences" min="1" restrictToTypes="exhibition">
                        <div class="item">
                            <div class="trigger small">Related Exhibitions</div>            
                            <div class="details">
                                <div class="inner">
                                    <ul class="ca-data text-align-left related">
                                        <unit relativeTo="ca_occurrences" restrictToTypes="exhibition" delimiter=" " sort="ca_occurrences.date.parsed_date">
											<li>
												<l><i>^ca_occurrences.preferred_labels.name</i>, <unit relativeTo='ca_entities' restrictToRelationships='primary_venue'>^ca_entities.preferred_labels.displayname</unit>, ^ca_occurrences.date.display_date</l>
											</li>
                                        </unit>
                                    </ul>
                                </div>
                            </div>
                        </div>
	</ifcount>
	<ifcount code="ca_occurrences" min="1" restrictToTypes="bibliography">
                        <div class="item">
                            <div class="trigger small">Related Bibliography</div>            
                            <div class="details">
                                <div class="inner">
                                    <ul class="ca-data text-align-left related">
                                        <unit relativeTo="ca_occurrences" restrictToTypes="bibliography" delimiter=" " sort="ca_occurrences.bib_year_published">
											<li>
												<l>^ca_occurrences.bib_full_citation</l>
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
<?php
			break;
			# ----------------------------------------------
			case "research pending":
?>
                <div class="block">
                    <div class="block-quarter">
						<div class="eyebrow text-gray">{{{^ca_objects.idno}}}</div>
					</div>
                    <div class="block-quarter">
                        <h2 class="subheadline-l">{{{^ca_objects.preferred_labels.name}}}</h2>
                    </div>
                    {{{<ifdef code="ca_objects.nonpreferred_labels.name" restrictToTypes="secondary|tertiary">
						<div class="block-quarter">
							<div class="ca-data"><unit relativeTo="ca_objects.nonpreferred_labels" delimiter="<br/>" restrictToTypes="secondary">^ca_objects.nonpreferred_labels.name</unit></div>
							<div class="ca-data"><unit relativeTo="ca_objects.nonpreferred_labels" delimiter="<br/>" restrictToTypes="tertiary">^ca_objects.nonpreferred_labels.name</unit></div>
						</div>
					</ifdef>}}}
                    {{{<ifdef code="ca_objects.date.display_date">
						<div class="block-quarter">
							<div class="subheadline text-gray">^ca_objects.date.display_date</div>
						</div>
					</ifdef>}}}
                    {{{<ifnotdef code="ca_objects.date.display_date"><ifdef code="ca_objects.date.parsed_date">
						<div class="block-quarter">
							<div class="subheadline text-gray">^ca_objects.date.parsed_date</div>
						</div>
                    </ifdef></ifnotdef>}}}
                    {{{<ifdef code="ca_objects.technique">
						<div class="block-quarter">
							<div class="ca-data"><ifdef code="ca_objects.technique">^ca_objects.technique%delimiter=,_ </ifdef></div>
						</div>
					</ifdef>}}}
						
					{{{<ifdef code="ca_objects.status">
						<div class="block-quarter">
							<div class="eyebrow text-gray">Status</div>
							<div class="ca-data capitalize">^ca_objects.status</div>
						</div>
					</ifdef>}}}
					<div class="block-quarter">
						<div class="eyebrow text-gray">{{{crCopyrightBoilerplate}}}</div>
					</div>
					
				</div><!-- end block>
<?php		
			break;
			# ----------------------------------------------
}
?>
            </div> <!-- wrap-text -->
        </section>

{{{<ifcount code="ca_objects.related" excludeRelationshipTypes="related,related_edition,related_version,related_element" restrictToTypes="artwork,cast,edition,element,group,reproduction,study,version" min="1">
        <section class="wrap block border">
            <div class="block text-align-center">
                <h4 class="subheadline-bold">Associated Artworks</h4>
            </div>
            

            <div class="module_slideshow manual-init slideshow-related">
                <div class="slick-slider">
					<unit relativeTo="ca_objects_x_objects" excludeRelationshipTypes="related,related_edition,related_version,related_element" restrictToTypes="artwork,cast,edition,element,group,reproduction,study,version" delimiter=" ">
						<div class="slick-slide">
							<div class="item">
								<unit relativeTo="ca_objects">
									<l>
										<div class="block-quarter">
											<ifdef code="ca_object_representations.media"><img nopin="nopin"  src="^ca_object_representations.media.medium.url" /></ifdef>
											<ifnotdef code="ca_object_representations.media.medium.url"><?php print $vs_placeholder_tag; ?></ifnotdef>
										</div>
										<div class="text block-quarter">
											<div class="ca-identifier text-gray">^ca_objects.idno<if rule='^ca_objects.status =~ /pending/'>*</if></div>
											<div class="thumb-text clamp" data-lines="4">^ca_objects.preferred_labels.name</div>
											<ifdef code="ca_objects.date.display_date"><div class="ca-identifier text-gray">^ca_objects.date.display_date</div></ifdef>
											<ifnotdef code="ca_objects.date.display_date"><ifdef code="ca_objects.date.parsed_date"><div class="ca-identifier text-gray">^ca_objects.date.parsed_date</div></ifdef></ifnotdef>
											<ifdef code="ca_objects.technique"><div class="ca-identifier text-gray">^ca_objects.technique</div></ifdef>
											
										</div>
									</l>
								</unit>
								<unit relativeTo="ca_objects_x_objects"><div class="ca-identifier text-gray">^relationship_typename</div></unit>
							</div>
						</div>
                    </unit>
                </div>
            </div>

        </section>
</ifcount>}}}
{{{<ifcount code="ca_objects.related" restrictToRelationshipTypes="related,related_edition,related_version,related_element" restrictToTypes="artwork,cast,edition,element,group,reproduction,study,version" min="1">
        <section class="wrap block border">
            <div class="block text-align-center">
                <h4 class="subheadline-bold">Related Artworks</h4>
            </div>
            

            <div class="module_slideshow manual-init slideshow-related">
                <div class="slick-slider">
					<unit relativeTo="ca_objects.related" restrictToRelationshipTypes="related,related_edition,related_version,related_element" restrictToTypes="artwork,cast,edition,element,group,reproduction,study,version" delimiter=" ">
						<div class="slick-slide">
							<div class="item">
								<l>
									<div class="block-quarter">
										<ifdef code="ca_object_representations.media.medium.url"><img nopin="nopin"  src="^ca_object_representations.media.medium.url" /></ifdef>
										<ifnotdef code="ca_object_representations.media.medium.url"><?php print $vs_placeholder_tag; ?></ifnotdef>
									</div>
									<div class="text block-quarter">
										<div class="ca-identifier text-gray">^ca_objects.idno<if rule='^ca_objects.status =~ /pending/'>*</if></div>
										<div class="thumb-text clamp" data-lines="4">^ca_objects.preferred_labels.name</div>
										<ifdef code="ca_objects.date.display_date"><div class="ca-identifier text-gray">^ca_objects.date.display_date</div></ifdef>
										<ifnotdef code="ca_objects.date.display_date"><ifdef code="ca_objects.date.parsed_date"><div class="ca-identifier text-gray">^ca_objects.date.parsed_date</div></ifdef></ifnotdef>
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