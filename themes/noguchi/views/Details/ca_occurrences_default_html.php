<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
	
	$vn_previous_id = $this->getVar("previousID");
	$vn_next_id = $this->getVar("nextID");
	$va_access_values = caGetUserAccessValues();
?>
    <main id="main" role="main" class="ca bibliography bibliography_detail nomargin">

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
 			$va_rep_ids = array_reverse($t_item->get("ca_object_representations.representation_id", array("returnAsArray" => true, "filterNonPrimaryRepresentations" => false, "sort" => "ca_objects_x_object_representations.is_primary")));
 			if(is_array($va_rep_ids) && sizeof($va_rep_ids)){
 				
?>  

            <div class="ca-object-viewer">

                <div class="module_slideshow is-finite slideshow-main no_dots" data-thumbnails="slideshow-thumbnails">
                    <div class="slick-slider slider-main">
<?php
						$va_thumbs = array();
						foreach($va_rep_ids as $vn_rep_id){
							$vs_display_version = "";
							$t_rep = new ca_object_representations($vn_rep_id);
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
?>
            <div class="wrap-max-content text-align-center">

                <div class="block">

                    <div class="block-quarter">
                        <div class="eyebrow text-gray">{{{^ca_occurrences.type_id}}}</div>
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
                    {{{<ifdef code="ca_occurrences.status">
						<div class="block-quarter">
							<div class="eyebrow text-gray">Status</div>
							<div class="ca-data">^ca_occurrences.status</div>
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

{{{<ifcount code="ca_objects.related" min="1">
        <section class="wrap block border">
            <div class="block text-align-center">
                <h4 class="subheadline-bold">Artworks Cited</h4>
            </div>
            <div class="module_slideshow is-finite manual-init slideshow-related">
                <div class="slick-slider">
					<unit relativeTo="ca_objects.related" delimiter=" " sort="ca_objects.idno_sort">
						<div class="slick-slide">
							<div class="item">
								<l>
									<div class="img-wrapper archive_thumb block-quarter">
										<div class="bg-image" style="background-image: url(^ca_object_representations.media.large.url)"></div>
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
