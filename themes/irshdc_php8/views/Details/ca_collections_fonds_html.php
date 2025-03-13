<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_collections_default_html.php : 
 * 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2015 Whirl-i-Gig
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
 
	$t_item = 				$this->getVar("item");
	$va_comments =			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
	$va_access_values = 	$this->getVar("access_values");
	
	# --- get collections configuration
	$o_collections_config = caGetCollectionsConfig();
	$vb_show_hierarchy_viewer = false;
	if($t_item->get('ca_collections.parent.collection_id') || $t_item->get('ca_collections.children.collection_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values)) || $t_item->get('ca_objects.object_id', array('restrictToTypes' => array('archival_file'), "restrictToRelationshipTypes" => array('archival_part'), 'returnAsArray' => true, 'checkAccess' => $va_access_values))){
		$vb_show_hierarchy_viewer = true;	
	}
	# --- get the collection hierarchy parent to use for exporting finding aid
	$vn_top_level_collection_id = array_shift($t_item->get('ca_collections.hierarchy.collection_id', array("returnWithStructure" => true, "checkAccess" => $va_access_values)));

	include("restricted_access_warning.php");
?>
	<div class="detailArchivalCollections">
			<div class="row ">
<?php
				$vs_representationViewer = trim($this->getVar("representationViewer"));
				
?>
				<div class='col-sm-12 col-md-5'>	
					<?php print $vs_representationViewer; ?>
				
				
					<div id="detailAnnotations"></div>
<?php				
					print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_item, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-2 col-md-2 col-xs-3", "version" => "iconlarge"));
?>
					
					<hr/>
					<H2>Ways to Engage</H2>
						{{{<ifdef code="ca_collections.engage">
							<div class="unit waysToEngage"><ifdef code="ca_collections.engage.engage_description"><p>^ca_collections.engage.engage_description</p></ifdef>
								<ifdef code="ca_collections.engage.engage_url"><a href="^ca_collections.engage.engage_url" class="btn btn-default">^ca_collections.engage.engage_button_text<ifnotdef code="ca_collections.engage.engage_button_text">Engage</ifnotdef></a></ifdef>
							</div>
						</ifdef>}}}
						
	<?php
						if ($vn_comments_enabled) {
							$vn_num_comments = sizeof($va_comments) + sizeof($va_tags);
	?>				
								<h2>Contribute</H2>
								<div class="collapseBlock last discussion" style="border:0px;">
									<div class="collapseContent open">
										<div id='detailDiscussion'>
											Do you have a story or comment to contribute?<br/>
		<?php
											
											if($this->request->isLoggedIn()){
												print "<button type='button' class='btn btn-default' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'CommentForm', array("tablename" => "ca_collections", "item_id" => $t_item->getPrimaryKey()))."\"); return false;' >"._t("Add your comment")."</button>";
											}else{
												print "<button type='button' class='btn btn-default' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login/register to comment")."</button>";
											}
											if($vn_num_comments){
												print "<br/><br/><a href='#comments'>Read All Comments <i class='fa fa-angle-right' aria-hidden='true'></i></a>";
											}
		?>
										</div><!-- end itemComments -->
									</div>
								</div>
	<?php				
						}
?>

				</div><!-- end col -->
				<div class='col-sm-12 col-md-7'>
					<div class="row">
						<div class="col-sm-7">
<?php
							$vs_source = $t_item->getWithTemplate('<unit relativeTo="ca_entities.related" restrictToRelationshipTypes="source" delimiter=", ">^ca_entities.preferred_labels.displayname</unit>', array("checkAccess" => $va_access_values));						
							$vs_source_link = $t_item->get("ca_collections.link");
							if($vs_source_link){
								$vs_source_link = '<div><a href="'.$vs_source_link.'" class="redLink" target="_blank">'.(($vs_source) ? $vs_source : 'Source Record').' <span class="glyphicon glyphicon-new-window"></span></a></div>';
							}						
	
							$vs_title_hover = $t_item->getWithTemplate("<ifdef code='ca_collections.ISADG_titleNote'>^ca_collections.ISADG_titleNote%delimiter=;_</ifdef>");
							$vs_title = $t_item->get("ca_collections.preferred_labels.name");
							
							print "<H1>";
							if($vs_title_hover){
								print '<span data-toggle="popover" title="Note" data-content="'.$vs_title_hover.'">'.$vs_title.'</span>';
							}else{
								print $vs_title;
							}
							print $vs_source_link;
							print "</H1>";
							$type = $t_item->get("ca_collections.type_id", array("convertCodesToDisplayText" => true));
							if($type == "Archival Collection"){
								$type = "Collection";
							}
?>
							<div class="unit">
								<div class="uppercase"><?= $type; ?></div>
							</div>
							{{{<ifdef code="ca_collections.displayDate">
								<ifdef code="ca_collections.ISADG_dateNote"><div class="unit" data-toggle="popover" title="Note" data-content="^ca_collections.ISADG_dateNote">
									^ca_collections.displayDate
								</div></ifdef>
								<ifnotdef code="ca_collections.ISADG_dateNote">
									<div class="unit">^ca_collections.displayDate</div>
								</ifnotdef>
							</ifdef>}}}
						</div>
						<div class="col-sm-5">
<?php
							# Comment and Share Tools
							
							print '<div id="detailTools" class="archival">';
						
							print "<div class='detailTool'><span class='glyphicon glyphicon-envelope'></span>".caNavLink($this->request, "Ask a Question", "", "", "Contact", "Form", array("contactType" => "askArchivist", "collection_id" => $t_item->get("collection_id")))."</div>";
							if(strpos(strtolower($t_item->getWithTemplate("^ca_collections.type_id")), "archival collection") !== false){
								print "<div class='detailTool'><span class='glyphicon glyphicon-file'></span>".caDetailLink($this->request, "Finding Aid PDF", "faDownload", "ca_collections",  $t_item->get("ca_collections.collection_id"), array('view' => 'pdf', 'export_format' => '_pdf_ca_collections_summary'))."</div>";
					
							}
							print '</div><!-- end detailTools -->';			
?>
						</div>
					</div>
						
						
						
						{{{<ifdef code="ca_collections.resource_type"><if rule='^ca_collections.resource_type !~ /-/'><div class="unit"><H6><ifdef code="ca_collections.resource_type">^ca_collections.resource_type%useSingular=1<ifdef code="ca_collections.genre"> > </ifdef></ifdef><ifdef code="ca_collections.genre">^ca_collections.genre%delimiter=,_</unit></ifdef></H6></div></if></ifdef>}}}
						{{{<ifdef code="ca_collections.parent_id"><div class="unit"><H6>Location in Collection</H6><unit relativeTo="ca_collections.parent"><unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.preferred_labels.name</l></unit></unit></div></ifdef>}}}
						
						{{{<ifcount code="ca_entities.related" restrictToTypes="school" min="1"><div class="unit"><H6>Related School<ifcount code="ca_entities.related" restrictToTypes="school" min="2">s</ifcount></H6><unit relativeTo="ca_entities" restrictToTypes="school" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit></div></ifcount>}}}
						
<?php
						$vs_creators_entities = $t_item->getWithTemplate('<unit relativeTo="ca_entities.related" restrictToRelationshipTypes="contributor,creator" delimiter="; "><l>^ca_entities.preferred_labels.displayname</l></unit>', array("checkAccess" => $va_access_values));
						$vs_creators_text = $t_item->get('ca_collections.creator_contributor');
						if($vs_creators_entities || $vs_creators_text){
							print '<div class="unit"><H6>Creators and Contributors</H6><div class="trimTextShort">'.$vs_creators_entities.(($vs_creators_entities && $vs_creators_text) ? "; " : "").$vs_creators_text.'</div></div>';
						}
?>						
						{{{<ifdef code="ca_collections.RAD_admin_hist">
							<div class="unit"><h6>Administrative/Biographical History</h6>
								<div class="trimText">^ca_collections.RAD_admin_hist</div>
							</div>
						</ifdef>}}}
						{{{<ifdef code="ca_collections.scope_new.scope_new_text">
							<ifdef code="ca_collections.scope_new.scope_new_source">
								<div class="unit" data-toggle="popover" title="Source" data-content="^ca_collections.scope_new.scope_new_source"><h6>Description</h6>
									<div>^ca_collections.scope_new.scope_new_text</div>
								</div>
							</ifdef>
							<ifnotdef code="ca_collections.scope_new.scope_new_source">
								<div class="unit"><h6>Description</h6>
									<div>^ca_collections.scope_new.scope_new_text</div>
								</div>
							</ifnotdef>
						</ifdef>}}}
						{{{<ifdef code="ca_collections.curators_comments.comments">
							<div class="unit" data-toggle="popover" title="Source" data-content="^ca_collections.curators_comments.comment_reference"><h6>Curatorial Comment</h6>
								<div class="trimText">^ca_collections.curators_comments.comments</div>
							</div>
						</ifdef>}}}
						{{{<ifdef code="ca_collections.content_notice.content_notice_value">
							<div class='unit' data-toggle="popover" title="Source" data-content="^ca_collections.content_notice.content_notice_source"><h6>Content Notice</h6>
								<div class="trimText">^ca_collections.content_notice.content_notice_value</div>
							</div>
						</ifdef>}}}
						{{{<ifdef code="ca_collections.about_school_photographs.about_school_photos_text">
							<div class='unit' data-toggle="popover" title="Source" data-content="^ca_collections.about_school_photographs.about_school_photos_source"><h6>About Residential School Photographs</h6>
								<div class="trimText">^ca_collections.about_school_photographs.about_school_photos_text</div>
							</div>
						</ifdef>}}}
						{{{<ifdef code="ca_collections.community_input_objects.comments_objects">
							<div class='unit' data-toggle="popover" title="Source" data-content="^ca_collections.community_input_objects.comment_reference_objects"><h6>Dialogue</h6>
								<div class="trimText">^ca_collections.community_input_objects.comments_objects</div>
							</div>
						</ifdef>}}}
						{{{<ifdef code="ca_collections.language">
							<ifdef code="ca_collections.language_note">
								<div class="unit" data-toggle="popover" title="Note" data-content="^ca_collections.language_note%delimiter=;_"><h6>Language</h6>^ca_collections.language%delimiter=,_</div>
							</ifdef>
							<ifnotdef code="ca_collections.language_note">
								<div class="unit"><h6>Language</h6>^ca_collections.language%delimiter=,_</div>
							</ifnotdef>
						</ifdef>}}}
						{{{<ifdef code="ca_collections.RAD_generalNote">
							<div class='unit'><h6>Notes</h6><unit relativeTo="ca_collections.RAD_generalNote" delimiter="<br/>">^ca_collections.RAD_generalNote</unit></div>
						</ifdef>}}}
								
					<div class="collapseBlock">
							<h3>More Information <span class="glyphicon glyphicon-collapse-down" aria-hidden="true"></span></H3>
							<div class="collapseContent">
							{{{
								<ifdef code="ca_collections.nonpreferred_labels"><div class="unit"><H6>Alternate Title(s)</H6><unit relativeTo="ca_collections.nonpreferred_labels" delimiter="<br/>">^ca_collection_labels.name</unit></div></ifdef>
								<ifcount code="ca_entities" restrictToRelationshipTypes="repository" min="1"><div class="unit"><h6>Holding Repository</h6><unit relativeTo="ca_entities" restrictToRelationshipTypes="repository" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit></div></ifcount>
								<ifdef code="ca_collections.source_identifer"><div class='unit'><h6>Holding Repository Identifier</h6>^ca_collections.source_identifer</div></ifdef>
								<ifdef code="ca_collections.citation"><div class='unit'><h6>Cite this Record</h6>^ca_collections.citation</div></ifdef>
								<ifdef code="ca_collections.RAD_extent"><div class="unit"><H6>Extent and Medium</H6><unit relativeTo="ca_collections.RAD_extent" delimiter="<br/>">^ca_collections.RAD_extent</unit></div></ifdef>
								<ifdef code="ca_collections.RAD_custodial"><div class="unit"><h6>Archival History</h6>^ca_collections.RAD_custodial</div></ifdef>
								<ifdef code="ca_collections.ISADG_archNote"><div class='unit'><h6>Archivist Notes</h6>^ca_collections.ISADG_archNote</div></ifdef>
								<ifdef code="ca_collections.govAccess"><div class='unit'><h6>Conditions Governing Access</h6>^ca_collections.govAccess</div></ifdef>
								<ifdef code="ca_collections.RAD_usePub"><div class='unit'><h6>Terms Governing Reproduction</h6>^ca_collections.RAD_usePub</div></ifdef>
								<ifdef code="ca_collections.RAD_local_rights"><div class='unit'><h6>Notes: Rights and Access</h6>^ca_collections.RAD_local_rights</div></ifdef>
								<ifdef code="ca_collections.RAD_arrangement"><div class="unit"><h6>System of Arrangement</h6>^ca_collections.RAD_arrangement</div></ifdef>
								<ifdef code="ca_collections.ISADG_rules"><div class='unit'><h6>Rules or Conventions</h6>^ca_collections.ISADG_rules</div></ifdef>
								<ifdef code="ca_collections.RAD_accruals"><div class="unit"><h6>Accruals</h6>^ca_collections.RAD_accruals</div></ifdef>
							}}}
<?php
							print "<div class='unit'><H6>Permalink</H6><textarea name='permalink' id='permalink' class='form-control input-sm'>".$this->request->config->get("site_host").caNavUrl($this->request, '', 'Detail', 'collections/'.$t_item->get("collection_id"))."</textarea></div>";					
?>
								
							</div>
						</div>

				</div>
			</div>
<?php
	# --- get sub collections that are collection records
	if($va_collection_children = $t_item->get('ca_collections.children.collection_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'sort' => 'ca_collections.idno_sort'))){
		$vb_has_children = true;
		$qr_collection_children = caMakeSearchResult("ca_collections", $va_collection_children);
		if($qr_collection_children->numHits()){
			while($qr_collection_children->nextHit()){
				$va_collection_contents[] = array("table" => "ca_collections", "id" => $qr_collection_children->get("ca_collections.collection_id"), "name" => $qr_collection_children->get("ca_collections.preferred_labels.name"), "type" => $qr_collection_children->get("ca_collections.type_id", array("convertCodesToDisplayText" => true)), "media" => $qr_collection_children->get("ca_object_representations.media.large"));
				
			}
		}
	}
	# --- get sub collections that are object records (archival files) as well as archival items
	if($va_collection_children = $t_item->get('ca_objects.object_id', array('restrictToTypes' => array('archival_file', 'archival'), "restrictToRelationshipTypes" => array('archival_part'), 'returnAsArray' => true, 'checkAccess' => $va_access_values, 'sort' => 'ca_objects.idno_sort'))){
		$vb_has_children = true;
		$qr_collection_children = caMakeSearchResult("ca_objects", $va_collection_children);
		if($qr_collection_children->numHits()){
			while($qr_collection_children->nextHit()){
				$va_collection_contents[] = array("table" => "ca_objects", "id" => $qr_collection_children->get("ca_objects.object_id"), "name" => $qr_collection_children->get("ca_objects.preferred_labels.name"), "type" => $qr_collection_children->get("ca_objects.type_id", array("convertCodesToDisplayText" => true)), "media" => $qr_collection_children->get("ca_object_representations.media.large"));
				
			}
		}
	}
	if($vb_has_children || ($vn_top_level_collection_id != $t_item->get('ca_collections.collection_id'))){
		if(is_array($va_collection_contents) && sizeof($va_collection_contents)){
			# --- grid of collection and archival file records with thumbnails
?>
			<div class="row" style="margin-top:30px;">
				<div class="col-sm-12"><hr/></div>
			</div>
			<div class="row">
				<div class="col-sm-12"><H2>Collection Contents</H2><div class="unit">Click the images below to see more records.</div></div>
			</div>					
<?php					
				$i = 0;
				foreach($va_collection_contents as $va_collection_content) {
					if($i == 0){
						print '<div class="row collectionContentsGrid">';
					}
?>
					<div class="col-sm-6 col-md-3 collectionContentsGridItem">	
<?php
						if($va_collection_content["media"]){
							$vs_img = $va_collection_content["media"];
						}else{
							$vs_img = "<div class='placeholder'></div>";
						}
						
						
						
						print caDetailLink($this->request, $vs_img.$va_collection_content["name"], '', $va_collection_content["table"],  $va_collection_content["id"]);
?>
					</div>
<?php						
					$i++;
					if($i == 4){
						$i = 0;
						print "</div>";
					}
				}
				if($i > 0){
					print "</div>";
				}
		}
		if ($vb_show_hierarchy_viewer) {	
?>
			<div class="row" style="margin-top:30px;">
				<div class="col-sm-12"><hr/></div>
			</div>
			<div class="row">
				<div class="col-sm-12 col-md-6"><H2>Overview of the Collection</H2><div class="unit">Click the links below to see more records.</div></div>
				<div class="col-sm-12 col-md-6"><div class='text-right'><a href='#' onclick='$("#collectionHierarchy").toggle(300);return false;' class='showHide'>Show/Hide Collection Overview</a></div></div>
			</div>
			<div class="row">
				<div class='col-sm-12'>

					<div id="collectionHierarchy"><?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?></div>
					<script>
						$(document).ready(function(){
							$('#collectionHierarchy').load("<?php print caNavUrl($this->request, '', 'Collections', 'collectionHierarchyArchivalViewer', array('collection_id' => $vn_top_level_collection_id, 'current_collection_id' => $t_item->get('ca_collections.collection_id'))); ?>"); 
						})
					</script>
				</div><!-- end col -->
			</div><!-- end row -->

<?php				
		}									
	
	
	}
?>
			<div class="row" style="margin-top:30px;">
				<div class="col-sm-12">		
<?php
		include("related_tabbed_html.php");

# ----- the related objects shown here are only those linked with the relationship type "related" so they are not part of the archival hierarchy
	$t_object = $this->getVar("item");
	$va_access_values = $this->getVar("access_values");
	$va_related_objects = $t_object->get("ca_objects.object_id", array("returnAsArray" => true, "checkAccess" => $va_access_values, "restrictToRelationshipTypes" => array("related"), "restrictToTypes" => array("archival", "library", "work", "resource", "file", "survivor")));
	if(is_array($va_related_objects) && sizeof($va_related_objects)){
		$qr_res = caMakeSearchResult("ca_objects", $va_related_objects, array('checkAccess' => $this->opa_access_values));
		if($qr_res->numHits()){
			$t_list_item = new ca_list_items();
			$o_icons_conf = caGetIconsConfig();
			$va_object_type_specific_icons = $o_icons_conf->getAssoc("placeholders");
			if(!($vs_default_placeholder = $o_icons_conf->get("placeholder_media_icon"))){
				$vs_default_placeholder = "<i class='fa fa-picture-o fa-4x'></i>";
			}
			$vs_default_placeholder_tag = "<div class='bResultItemImgPlaceholder'>".$vs_default_placeholder."</div>";
			
?>
			<div class="relatedBlock">
				<h3>Records</H3>
				<div class="row" id="browseResultsContainer">
<?php
			while($qr_res->nextHit()){
				if(!($vs_thumbnail = $qr_res->get('ca_object_representations.media.medium', array("checkAccess" => $va_access_values)))){
					$t_list_item->load($qr_res->get("resource_type"));
					$vs_typecode = $t_list_item->get("idno");
					if($vs_type_placeholder = caGetPlaceholder($vs_typecode, "placeholder_media_icon")){
						$vs_thumbnail = "<div class='bResultItemImgPlaceholder'>".$vs_type_placeholder."</div>";
					}else{
						$vs_thumbnail = $vs_default_placeholder_tag;
					}
				}
				$vs_rep_detail_link 	= caDetailLink($this->request, $vs_thumbnail, '', 'ca_objects', $qr_res->get("ca_objects.object_id"));
?>
				<div class="bResultItemCol col-xs-12 col-sm-6 col-md-3">
					<div class="bResultItem">
						<div class="bResultItemContent"><div class="text-center bResultItemImg"><?php print $vs_rep_detail_link; ?></div>
							<div class="bResultItemText">
								<small><?php print caDetailLink($this->request, $qr_res->get("ca_objects.preferred_labels"), '', 'ca_objects', $qr_res->get("ca_objects.object_id")); ?></small>
							</div><!-- end bResultItemText -->
						</div><!-- end bResultItemContent -->
					</div><!-- end bResultItem -->
				</div>
<?php
			}
?>
				</div>
			</div>
<?php
		}
	}
					if($vn_num_comments){
?>
						<a name="comments"></a><div class="block">
							<h3>Discussion</H3>
							<div class="blockContent">
								<div id="detailComments">
<?php
								if(sizeof($va_comments)){
									print "<H2>Comments</H2>";
								}
								print $this->getVar("itemComments");
?>
								</div>
							</div>
						</div>
<?php
					}
?>				
					
				</div>
			</div>
	</div>
<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 110
		});
		$('.trimTextShort').readmore({
		  speed: 75,
		  maxHeight: 22
		});
		$('.trimTextSubjects').readmore({
		  speed: 75,
		  maxHeight: 85,
		  moreLink: '<a href="#" class="moreLess">More</a>',
		  lessLink: '<a href="#" class="moreLess">Less</a>'
		});
		
		var options = {
			placement: function () {
				return "auto top";
			},
			trigger: "hover",
			html: "true"
		};
		$('[data-toggle="popover"]').each(function() {
  			if($(this).attr('data-content')){
  				$(this).popover(options).click(function(e) {
					$(this).popover('toggle');
				});
  			}
		});
		
		$('.collapseBlock h3').click(function() {
  			block = $(this).parent();
  			block.find('.collapseContent').toggle();
  			block.find('.glyphicon').toggleClass("glyphicon-collapse-down");
  			block.find('.glyphicon').toggleClass("glyphicon-collapse-up");
  			
		});
	});
</script>