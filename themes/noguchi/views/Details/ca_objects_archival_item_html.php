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
	$va_access_values = caGetUserAccessValues();
	
	$vn_previous_id = $this->getVar("previousID");
	$vn_next_id = $this->getVar("nextID");
	
	$vs_placeholder = $this->request->config->get("site_host").caGetThemeGraphicUrl("placeholder.png");
	$vs_placeholder_tag = '<img nopin="nopin"  src="'.$vs_placeholder.'" alt="Image Not Available"  />';

	$va_collection_hierarchy = array_shift($t_object->get('ca_collections.hierarchy.collection_id', array("returnWithStructure" => true)));
	$vb_photo_collection = false;
	$vb_manuscript_collection = false;
	$va_collection_path = array();
	$vs_display_collection = "";
	
	if(is_array($va_collection_hierarchy) && sizeof($va_collection_hierarchy)){
		$vn_i = 0;
		foreach($va_collection_hierarchy as $vn_collection_heirarchy_level_id){
			$t_collections = new ca_collections($vn_collection_heirarchy_level_id);
			switch(strToLower($t_collections->get("type_id", array("convertCodesToDisplayText" => true)))){
				case "series":
					switch(strToLower($t_collections->get("ca_collections.preferred_labels.name"))){
						case "photography collection":
							$vb_photo_collection = true;
						break;
						case "manuscript collection":
							$vb_manuscript_collection = true;
						break;
					}
				break;
			}
			if($vn_i > 0){
				$va_collection_path[] = caNavLink($t_collections->get("ca_collections.preferred_labels.name"), "", "", "Browse", "Archive", array("facet" => "collection_facet", "id" => $vn_collection_heirarchy_level_id));
			}
			$vn_i++;
			if($vn_i == 3){
				# only show 2 levels after top we get rid of
				break;
			}
		}
		$vs_display_collection = join(" > ", $va_collection_path);
	}
	
	$vs_display_version = $vs_download_link = "";
	$t_representation = $this->getVar("t_representation");
	if($t_representation){
		$vs_mimetype = $t_representation->getMediaInfo('media', 'original', 'MIMETYPE');
		$va_media_display_info = caGetMediaDisplayInfo('detail', $vs_mimetype);
		if($va_media_display_info && sizeof($va_media_display_info)){
			($va_media_display_info["display_version"]) ? $vs_display_version = $va_media_display_info["display_version"] : "small";
		}
		if($this->request->isLoggedIn() && ($this->request->user->hasRole("public_download") || $this->request->user->hasRole("public_download_hr"))) { 
			if(caObjectsDisplayDownloadLink($this->request, $vn_id, $t_representation)){
				# -- get version to download configured in media_display.conf
				$va_download_display_info = caGetMediaDisplayInfo('download', $t_representation->getMediaInfo('media', 'INPUT', 'MIMETYPE'));
				if($this->request->user->hasRole("public_download_hr")){
					$vs_download_version = caGetOption(['download_version_highres', 'display_version'], $va_download_display_info);
				}else{
					$vs_download_version = caGetOption(['download_version', 'display_version'], $va_download_display_info);
				}
				if($vs_download_version){
					#$vs_download_link = caNavLink("", 'download', 'Detail', 'DownloadRepresentation', '', array('context' => 'archival', 'representation_id' => $t_representation->getPrimaryKey(), "id" => $vn_id, "download" => 1, "version" => $vs_download_version), array("title" => _t("Download")));
					$vs_download_link = caNavLink("", 'download', 'Detail', 'DownloadMedia', '', array('context' => 'archival', "object_id" => $vn_id, "download" => 1, "version" => $vs_download_version), array("title" => _t("Download")));
				}
			}
		}
	}			
?>


    <main id="main" role="main" class="ca archive archive_detail nomargin">

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
?>  
            <div class="container-image-detail block">
                <div class="img-container dark">
<?php
				if($this->request->isLoggedIn()) {
?>
					<div id="lightboxManagement" class="lightbox_management"></div>
<?php
					if($vs_download_link){
						print "<div class='actions'>".$vs_download_link."</div>";
					}
				}
				# --- when more than one rep, use the CR style media viewer --- this will never have PDF's
				$va_rep_ids = $t_object->get("ca_object_representations.representation_id", array("returnAsArray" => true, "filterNonPrimaryRepresentations" => false, "sort" => "ca_objects_x_object_representations.is_primary", "checkAccess" => $va_access_values));
 				if(is_array($va_rep_ids) && sizeof($va_rep_ids)){
 					$va_rep_ids = array_reverse($va_rep_ids);
 				}
				if(is_array($va_rep_ids) && (sizeof($va_rep_ids) > 1)){
 				
?>  

					<div class="ca-object-viewer">

						<div class="module_slideshow is-finite slideshow-main no_dots" data-thumbnails="slideshow-thumbnails">
							<div class="slick-slider slider-main">
		<?php
								$va_thumbs = array();
								foreach($va_rep_ids as $vn_index => $vn_rep_id){
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
										<div class="img-container dark">
											<div class="img-wrapper contain dark"><img src="<?php print $t_rep->get("ca_object_representations.media.".$vs_display_version.".url"); ?>" alt="<?php print str_replace(array("'", "\""), array("", ""), $t_object->get("ca_objects.preferred_labels.name")).(((sizeof($va_rep_ids)) > 1) ? ", image ".($vn_index + 1) : ""); ?>"></div>
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
								print '<li><a href="#" data-index="'.$vn_i.'" '.(($vn_i == 0) ? 'class="selected"' : '').'><img src="'.$vs_thumb_url.'"  alt="Thumbnail: '.str_replace(array("'", "\""), array("", ""), $t_object->get("ca_objects.preferred_labels.name")).(((sizeof($va_thumbs)) > 1) ? ", image ".($vn_i + 1) : "").'"></a></li>';
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
							
				}else{
?>
                    
                    <div class="<?php print ($vs_mimetype != "application/pdf") ? "img-wrapper " : "img-wrapperPDF "; ?>archive_detail">
                      <?php print $this->getVar('mediaViewer'); ?>
                    </div>
<?php
				}
?>
                </div>
            </div>

            <div class="wrap text-align-center">
                <div class="wrap-max-content">

                    <div class="block-quarter">
                        <h2 class="subheadline-l">{{{^ca_objects.preferred_labels.name}}}</h2>
                    </div>
                    {{{<ifdef code="ca_objects.date.display_date">
						<div class="block-quarter">
							<div class="subheadline text-gray">^ca_objects.date.display_date%delimiter=,_</div>
						</div>
					</ifdef>}}}
                    {{{<ifnotdef code="ca_objects.date.display_date"><ifdef code="ca_objects.date.parsed_date">
						<div class="block-quarter">
							<div class="subheadline text-gray">^ca_objects.date.parsed_date%delimiter=,_</div>
						</div>
                    </ifdef></ifnotdef>}}}
<?php
					if($vb_manuscript_collection){
						$va_entities = $t_object->get("ca_entities", array("restrictToRelationshipTypes" => array("author"), "checkAccess" => $va_access_values, "returnWithStructure" => true));
						if(is_array($va_entities) && sizeof($va_entities)){
?>
								<div class="block-quarter">
									<div class="eyebrow text-gray">Author</div>

<?php

							foreach($va_entities as $va_entity){
									print "<div class='ca-data'>".caNavLink($va_entity["displayname"], "", "", "Browse", "Archive", array("facet" => "entity_facet", "id" => $va_entity["entity_id"]))."</div>";
							}
?>
								</div>
<?php

						}
					}
?>
                    {{{<ifdef code="ca_objects.idno">
						<div class="block-quarter">
							<div class="eyebrow text-gray">Identifier</div>
							<div class="ca-data">^ca_objects.idno</div>
						</div>
					</ifdef>}}}
<?php
					if($vb_photo_collection){
?>
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
<?php
					}
?>
					{{{<ifdef code="ca_objects.studyCollectionCategory">
							<div class="block-quarter">
								<div class="eyebrow text-gray">Study Collection Category</div>
								<div class="ca-data">^ca_objects.studyCollectionCategory%delimiter=,_</div>
							</div>
						</ifdef>}}}
<?php

					$va_entities = $t_object->get("ca_entities", array("restrictToRelationshipTypes" => array("photographer"), "checkAccess" => $va_access_values, "returnWithStructure" => true));
					if(is_array($va_entities) && sizeof($va_entities)){
?>
							<div class="block-quarter">
								<div class="eyebrow text-gray">Photographer</div>

<?php

						foreach($va_entities as $va_entity){
								print "<div class='ca-data'>".caNavLink($va_entity["displayname"], "", "", "Browse", "Archive", array("facet" => "entity_facet", "id" => $va_entity["entity_id"]))."</div>";
						}
?>
							</div>
<?php

					}
					if($vb_photo_collection){	
?>
						<div class="block-quarter">
							<div class="eyebrow text-gray">Collection</div>
							<div class="ca-data">Photography Collection</div>
						</div>
<?php
					}else{
						if($vs_display_collection){
?>
						<div class="block-quarter">
							<div class="eyebrow text-gray">Collection</div>
							<div class="ca-data"><?php print $vs_display_collection; ?></div>
						</div>
<?php
						}
					}
					$va_exclude_rel_types = array("photographer");
					if($vb_manuscript_collection){
						$va_exclude_rel_types[] = "author";
					}
					$va_entities = $t_object->get("ca_entities", array("excludeRelationshipTypes" => $va_exclude_rel_types, "checkAccess" => $va_access_values, "returnWithStructure" => true));
					if(is_array($va_entities) && sizeof($va_entities)){
?>
							<div class="block-quarter">
								<div class="eyebrow text-gray">Related Entities</div>

<?php

						foreach($va_entities as $va_entity){
								print "<div class='ca-data'>".caNavLink($va_entity["displayname"], "", "", "Browse", "Archive", array("facet" => "entity_facet", "id" => $va_entity["entity_id"]))."</div>";
						}
?>
							</div>
<?php

					}
?>


                </div>


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
{{{<ifcount code="ca_objects.related" min="1" restrictToTypes="artwork,cast,chronology_image,edition,element,group,reproduction,study,version">
        <section class="wrap block border">
            <div class="block text-align-center">
                <h4 class="subheadline-bold">Related Artworks</h4>
            </div>
            

            <div class="module_slideshow is-finite manual-init slideshow-related">
                <div class="slick-slider">
					<unit relativeTo="ca_objects.related" restrictToTypes="artwork,cast,chronology_image,edition,element,group,reproduction,study,version" delimiter=" " sort="ca_objects.idno_sort">
						<div class="slick-slide">
							<div class="item">

								<l>
									<div class="img-wrapper archive_thumb block-quarter">
										<ifdef code="ca_object_representations.media.medium.url"><img nopin="nopin"  src="^ca_object_representations.media.medium.url"  alt="^ca_objects.preferred_labels.name" /></ifdef>
										<ifnotdef code="ca_object_representations.media.medium.url"><?php print $vs_placeholder_tag; ?></ifnotdef>
									</div>
									<div class="text block-quarter">
										<div class="ca-identifier text-gray">^ca_objects.idno</div>
										                              
											<div class="thumb-text clamp" data-lines="2">^ca_objects.preferred_labels.name</div>
											<ifdef code="ca_objects.date.display_date"><div class="ca-identifier text-gray">^ca_objects.date.display_date%delimiter=,_</div></ifdef>
											<ifnotdef code="ca_objects.date.display_date"><ifdef code="ca_objects.date.parsed_date"><div class="ca-identifier text-gray">^ca_objects.date.parsed_date%delimiter=,_</div></ifdef></ifnotdef>
										
									</div>
								</l>
							</div>
						</div>
					</unit>
				</div>
			</div>
        </section>
</ifcount>}}}
{{{<ifcount code="ca_objects.related" min="1" restrictToTypes="archival_item,document,objects,photographs,digital,print,strip,transparency,strip_image">
        <section class="wrap block border">
            <div class="block text-align-center">
				<h4 class="subheadline-bold">Related Archival Items</h4>
			</div>
            <div class="module_slideshow is-finite manual-init slideshow-related">
                <div class="slick-slider">
					<unit relativeTo="ca_objects.related" delimiter=" " restrictToTypes="archival_item,document,objects,photographs,digital,print,strip,transparency,strip_image">
						<div class="slick-slide">
							<div class="item">

								<l>
									<div class="img-wrapper archive_thumb block-quarter">
										<ifdef code="ca_object_representations.media.medium.url"><img nopin="nopin"  src="^ca_object_representations.media.medium.url"  alt="^ca_objects.preferred_labels.name"/></ifdef>
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
	if($this->request->isLoggedIn()) {
?>

<script type="text/javascript">
    pawtucketUIApps['LightboxManagement'] = {
        'selector': '#lightboxManagement',
        'data': {
            baseUrl: "<?php print __CA_URL_ROOT__."/index.php/Lightbox"; ?>",
			lightboxes: <?php print json_encode($this->getVar('lightboxes')); ?>,
			table: 'ca_objects',
			id: <?php print (int)$vn_id; ?>
        }
    };
</script>
<?php
	}
	include("objects_metatags.php");
?>
