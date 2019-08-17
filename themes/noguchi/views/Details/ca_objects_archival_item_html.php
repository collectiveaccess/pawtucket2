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
	
	$vs_display_version = $vs_media = $vs_media_url = $vs_download_link = "";
	$t_representation = $this->getVar("t_representation");
	if($t_representation){
		$va_media_display_info = caGetMediaDisplayInfo('detail', $t_representation->getMediaInfo('media', 'original', 'MIMETYPE'));
		if($va_media_display_info && sizeof($va_media_display_info)){
			($va_media_display_info["display_version"]) ? $vs_display_version = $va_media_display_info["display_version"] : "small";
			$vs_media = $t_object->get("ca_object_representations.media.".$vs_display_version);
			$vs_media_url = $t_object->get("ca_object_representations.media.".$vs_display_version.".url");
		}
		if(caObjectsDisplayDownloadLink($this->request, $vn_id, $t_representation)){
			# -- get version to download configured in media_display.conf
			$va_download_display_info = caGetMediaDisplayInfo('download', $t_representation->getMediaInfo('media', 'INPUT', 'MIMETYPE'));
			$vs_download_version = caGetOption(['download_version', 'display_version'], $va_download_display_info);
			if($vs_download_version){
				$vs_download_link = caNavLink("", 'download', 'Detail', 'DownloadRepresentation', '', array('context' => 'archival', 'representation_id' => $t_representation->getPrimaryKey(), "id" => $vn_id, "download" => 1, "version" => $vs_download_version), array("title" => _t("Download")));
			}
		}
	}			
?>


    <main class="ca archive archive_detail nomargin">

<?php
		print $this->render("pageFormat/archive_nav.php");
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
 			if($vs_media_url){
?>  
            <div class="container-image-detail block">
                <div class="img-container dark">

                    <div class="actions">
                        <a href="#" class="zoom"></a>
                        <a href="#" class="collection"></a>
<?php
						if($vs_download_link){
                        	print $vs_download_link;
                    	}
?>
                    </div>
                    
                    <div class="img-wrapper archive_detail">
                        <img nopin="nopin" src="<?php print $vs_media_url; ?>" />
                    </div>

                </div>
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


            <div class="wrap text-align-center">
                <div class="wrap-max-content">

                    <div class="block-quarter">
                        <h2 class="subheadline-l">{{{^ca_objects.preferred_labels.name}}}</h2>
                    </div>
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
                    {{{<ifdef code="ca_objects.idno">
						<div class="block-quarter">
							<div class="eyebrow text-gray">Identifier</div>
							<div class="ca-data">^ca_objects.idno</div>
						</div>
					</ifdef>}}}
                    <div class="block-quarter">
                        <div class="eyebrow text-gray">Object Type</div>
                        <div class="ca-data">{{{^ca_objects.type_id}}}</div>
                    </div>
                    {{{<ifdef code="ca_objects.archive_category">
						<div class="block-quarter">
							<div class="eyebrow text-gray">Archive Category</div>
							<div class="ca-data">^ca_objects.archive_category%delimiter=,_</div>
						</div>
					</ifdef>}}}
					{{{<ifdef code="ca_objects.description">
						<div class="block-quarter">
							<div class="eyebrow text-gray">Description</div>
							<div class="ca-data">^description</div>
						</div>
					</ifdef>}}}
					{{{<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="photographer">
						<div class="block-quarter">
							<div class="eyebrow text-gray">Photographer</div>
							<div class="ca-data"><unit relativeTo="ca_entities" restrictToRelationshipTypes="photographer" delimiter=", ">^ca_entities.preferred_labels.displayname</unit></div>
						</div>
                    </ifcount>}}}
                    {{{<ifcount code="ca_collections" min="1" >
						<div class="block-quarter">
							<div class="eyebrow text-gray">PART OF COLLECTION</div>
							<div class="ca-data"><unit relativeTo="ca_collections" delimiter="<br/>">^ca_collections.hierarchy.preferred_labels.name%delimiter=_>_</unit></div>
						</div>
                    </ifcount>}}}

                </div>


            </div>
        </section>
{{{<ifcount code="ca_objects.related" min="1">
        <section class="block border">
            <div class="wrap">
                <div class="block-half text-align-center">
                    <h4 class="subheadline-bold">Related Archival Items</h4>
                </div>
            </div>
            <div class="module_carousel archive_related" data-prevnext="false">
				<div class="carousel-main">
					<unit relativeTo="ca_objects.related" delimiter=" ">
						<div class="carousel-cell">

							<l>
								<div class="img-wrapper archive_thumb block-quarter">
									<div class="bg-image" style="background-image: url(^ca_object_representations.media.medium.url)"></div>
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

    </main>
