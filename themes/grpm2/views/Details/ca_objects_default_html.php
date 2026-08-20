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
	$vs_page_url = $this->request->config->get("site_host").caNavUrl($this->request, '', 'Detail', 'objects/'.$t_object->get("object_id"));
	if($vs_img_url = $t_object->get("ca_object_representations.media.medium.url")){
		MetaTagManager::addMetaProperty("og:image", $vs_img_url);
	}else{
		MetaTagManager::addMetaProperty("og:image", caGetThemeGraphicUrl($this->request, 'GRPM_blue_sq.png'));
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
<?php if($t_object->get('is_deaccessioned')) { ?>
				<div class="deaccessionBannerContainer">
					<div class="container">
						<div class="row deaccessionBannerRow">
							<div class="col-sm-12 deaccessionBanner">
								<h1><?= _t('This object has been deaccessioned and is no longer in the GRPM\'s collection'); ?></h1>
							</div>
						</div>
					</div>
				</div>
<?php
	}
?>
			<div class="row">
			<div class='col-sm-6 col-md-6'>
<?php
				if($vs_rep_viewer = trim($this->getVar("representationViewer"))){
					print $vs_rep_viewer;
				}else{
?>
					<div class="detailMediaPlaceholder"><i class="fa fa-picture-o fa-5x"></i></div>
<?php
				}
?>				
				
				<div id="detailAnnotations"></div>
				
				<div class="">
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "basic", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
				</div>
<?php
				$vb_restricted = false;
				if($vn_cc_list_item_id = $t_object->get("ca_objects.creative_commons")){
					$t_list_item = new ca_list_items($vn_cc_list_item_id);
					if($t_list_item->get("ca_list_items.idno") == "cc_restricted"){
						print "<a href='".$t_list_item->get("ca_list_item_labels.description")."' target='_blank'>".$t_object->get("ca_objects.creative_commons", array("convertCodesToDisplayText" => true))."</a>";
						$vb_restricted = true;
					}else{
						print "<div class='detailCC'><a href='".$t_list_item->get("ca_list_item_labels.description")."' target='_blank'>".$t_list_item->get("ca_list_items.icon.original")."<br/>".$t_object->get("ca_objects.creative_commons", array("convertCodesToDisplayText" => true))."</a></div>";
					}
				}
				# --- if download_version not set, fall back to creative_commons to determine download version: high-res downloads for CC0 and no downloads for restricted
				if($vn_dl_version_item_id = $t_object->get("ca_objects.download_version")){
					$t_list_item = new ca_list_items($vn_dl_version_item_id);
					switch($t_list_item->get("ca_list_items.idno")){
						case "high_res":
							print "<div class='text-left'><br/>".caNavLink($this->request, "<span class='glyphicon glyphicon-download' aria-label='"._t("Download Media")."'></span> "._t("Download Media"), "btn btn-default", "", "Detail",  "DownloadMedia", array('context' => 'objects', 'object_id' => $vn_id, 'version' => 'original', 'download' => 1))."</div>";
						break;
						# -----------
						case "low_res":
							print "<div class='text-left'><br/>".caNavLink($this->request, "<span class='glyphicon glyphicon-download' aria-label='"._t("Download Media")."'></span> "._t("Download Media"), "btn btn-default", "", "Detail",  "DownloadMedia", array('context' => 'objects', 'object_id' => $vn_id, 'version' => 'large', 'download' => 1))."</div>";
						break;
						# -----------
					}
				}else{
					if(!$vb_restricted){
						print "<div class='text-left'><br/>".caNavLink($this->request, "<span class='glyphicon glyphicon-download' aria-label='"._t("Download Media")."'></span> "._t("Download Media"), "btn btn-default", "", "Detail",  "DownloadMedia", array('context' => 'objects', 'object_id' => $vn_id, 'version' => 'original', 'download' => 1))."</div>";
					}
				}
				
				
?>
				<br/><hr/><H2>Comments and Tags</H2>
<?php
				if((sizeof($va_comments) + sizeof($va_tags)) == 0){
					print "<p>Be the first to comment on this item!</p>";
				}else{
?>
				<div id='detailComments'><?php print $this->getVar("itemComments");?></div>
<?php
				}
				if($this->request->isLoggedIn()){
				
?>
				<div class="detailCommentForm">
					<form method="post" id="CommentForm" action="<?php print caNavUrl($this->request, '', 'Detail', 'saveCommentTagging'); ?>" class="form-horizontal" role="form" enctype="multipart/form-data">
						<H5>Add Your Comment & Tags</H5>
<?php
						print "<div class='form-group'><label for='tags' class='col-sm-12 control-label'>"._t("Tags")."</label><div class='col-sm-12'><input type='text' name='tags' value='' class='form-control' placeholder='"._t("tags separated by commas")."'></div><!-- end col-sm-12 --></div><!-- end form-group -->\n";
						print "<div class='form-group'><label for='comment' class='col-sm-12 control-label'>"._t("Comment")."</label><div class='col-sm-12'><textarea name='comment' class='form-control' rows='3'></textarea></div><!-- end col-sm-12 --></div><!-- end form-group -->\n";
?>
						<div class="form-group">
							<div class="col-sm-12">
								<button type="submit" class="btn btn-default">Save</button>
							</div><!-- end col-sm-7 -->
						</div><!-- end form-group -->
						<input type="hidden" name="item_id" value="<?php print $t_object->get("object_id"); ?>">
						<input type="hidden" name="tablename" value="ca_objects">
						<input type="hidden" name="inline" value="1">
						<?= caHTMLHiddenInput('csrfToken', array('value' => caGenerateCSRFToken($this->request))); ?>
		
					</form>
				</div>
<?php
				}else{
?>
					<button type="button" class="btn btn-default" onclick="caMediaPanel.showPanel('<?php print caNavUrl($this->request, '', 'LoginReg', 'LoginForm'); ?>'); return false;">Login/register to comment</button>
					<br/><br/>
<?php
				}
?>
				<hr/>
			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6'>		
				<H4>{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit><ifcount min="1" code="ca_collections"> ➔ </ifcount>}}}{{{ca_objects.preferred_labels.name}}}</H4>

				{{{<ifdef code="ca_objects.taxonomy"><H6>Taxonomy:</H6>^ca_objects.taxonomy<br/></ifdef>}}}
																				
				{{{<ifdef code="ca_objects.idno"><H6>Identifier:</H6>^ca_objects.idno<br/></ifdef>}}}
				{{{<ifdef code="ca_objects.containerID"><H6>Box/series:</H6>ca_objects.containerID<br/></ifdef>}}}						
				

				{{{<ifdef code="ca_objects.description">
					<H6>Description:</h6>
					<span class="trimText">^ca_objects.description</span>
				</ifdef>}}}
				
				{{{<ifdef code="ca_objects.Date"><H6>Date:</H6>^ca_objects.Date</ifdef>}}}
				
				
				{{{<ifdef code="ca_objects.Format"><H6>Materials:</H6>^ca_objects.Format%delimiter=,_</ifdef>}}}
				{{{<ifdef code="ca_objects.Dimensions_Container.Height"><H6>Dimensions:</H6><unit relativeTo="ca_objects.Dimensions_Container"><ifdef code="ca_objects.Dimensions_Container.Height">^ca_objects.Dimensions_Container.Height" h </ifdef><ifdef code="ca_objects.Dimensions_Container.Width">^Width" w </ifdef><ifdef code="ca_objects.Dimensions_Container.Depth">^Depth" d</ifdef></unit></ifdef>}}}
                {{{<ifdef code="ca_objects.current_location_fld"><H6>Current Location Status:</H6>^ca_objects.current_location_fld</ifdef>}}}
				{{{<ifdef code="ca_objects.tier"><H6>Collection Tier:</H6>^ca_objects.tier</ifdef>}}}
								
				{{{<ifdef code="ca_objects.Source"><H6>Source:</H6>^ca_objects.Source</ifdef>}}}

				{{{<ifdef code="ca_objects.Current_Location"><H6>Currently:</H6>^ca_objects.Current_Location</ifdef>}}}

				{{{<ifdef code="ca_objects.Links"><H6>Links:</H6><unit delimiter="<br/>" relativeTo="ca_objects.Links"><a href="^ca_objects.Links" target="_new">^ca_objects.Links</a></unit></ifdef>}}}

				<hr></hr>	
				{{{<ifcount code="ca_occurrences" min="1" max="1"><H6>Exhibit/Program:</H6></ifcount>}}}
				{{{<ifcount code="ca_occurrences" min="2"><H6>Exhibits/Programs:</H6></ifcount>}}}
				{{{<unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.preferred_labels</l> (^ca_occurrences.date)<ifdef code="ca_occurrences.description"><br><span class="trimText">^ca_occurrences.description</span></ifdef><br/></unit>}}}


				{{{<ifcount code="ca_entities" min="1" max="1"><H6>Related Entity:</H6></ifcount>}}}
				{{{<ifcount code="ca_entities" min="2"><H6>Related Entities:</H6></ifcount>}}}
				{{{<unit relativeTo="ca_entities" delimiter=" "><l>^ca_entities.preferred_labels.displayname</l> (^relationship_typename)<ifdef code="ca_entities.nonpreferred_labels.displayname"><br/>Alternate names: <span class="trimText"><unit delimiter=", ">^ca_entities.nonpreferred_labels.displayname</unit></span></ifdef><ifdef code="ca_entities.biography"><br/><span class="trimText">^ca_entities.biography</span></ifdef></unit><br/>}}}
				
				
				{{{<ifcount code="ca_list_items" min="1" max="1"><H6>Related Term:</H6></ifcount>}}}
				{{{<ifcount code="ca_list_items" min="2"><H6>Related Terms:</H6></ifcount>}}}
				{{{<unit relativeTo="ca_list_items" delimiter="<br/>">^ca_list_items.preferred_labels.name_plural</unit>}}}
				
				{{{<ifcount code="ca_objects.LcshNames" min="1"><H6>LC Terms:</H6></ifcount>}}}
				{{{<unit delimiter="<br/>"><l>^ca_objects.LcshNames</l></unit>}}}
				
				{{{<ifcount code="ca_objects.related" min="1" max="1"><H6>Related Object:</H6></ifcount>}}}
				{{{<ifcount code="ca_objects.related" min="2"><H6>Related Objects:</H6></ifcount>}}}
				{{{<div class="row relatedObjects"><unit relativeTo="ca_objects.related" delimiter=" "><div class="col-xs-12 col-md-4"><l>^ca_object_representations.media.small<div class="relatedObjectsTitle">^ca_objects.preferred_labels</div></l></div></unit></div>}}}

				{{{<ifcount code="ca_places" min="1" max="1"><H6>Related Place:</H6></ifcount>}}}
				{{{<ifcount code="ca_places" min="2"><H6>Related Places:</H6></ifcount>}}}
				{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l></unit>}}}
				

				
				<?php ($this->getVar("map")) ? "<hr>" : ""; ?>
				{{{map}}}
						
			</div><!-- end col -->
		</div><!-- end row --></div><!-- end container -->
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
		  maxHeight: 127
		});
	});
</script>
