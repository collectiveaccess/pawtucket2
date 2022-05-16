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
	$vn_id =				$t_item->get('ca_entities.entity_id');
	$va_access_values = 	$this->getVar("access_values");
	
	# --- get collections configuration
	$o_collections_config = caGetCollectionsConfig();
	$vb_show_hierarchy_viewer = true;
	if($o_collections_config->get("do_not_display_collection_browser")){
		$vb_show_hierarchy_viewer = false;	
	}
	# --- get the collection hierarchy parent to use for exportin finding aid
	$vn_top_level_collection_id = array_shift($t_item->get('ca_collections.hierarchy.collection_id', array("returnWithStructure" => true, "checkAccess" => $va_access_values)));

?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
</div>
			<div class="row">
<?php
				$vs_representationViewer = trim($this->getVar("representationViewer"));
				if($vs_representationViewer){
?>
				<div class='col-sm-12 col-md-5'>
					<?php print $vs_representationViewer; ?>
				
				
					<div id="detailAnnotations"></div>
<?php				
					print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_item, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-2 col-md-2 col-xs-3", "version" => "iconlarge"));
?>

				</div><!-- end col -->
<?php
				}
?>
				<div class='col-sm-12 col-md-<?php print ($vs_representationViewer) ? "5" : "7"; ?>'>
					<div class="stoneBg">	
<?php
						$vs_source = $t_item->getWithTemplate('<unit relativeTo="ca_entities.related" restrictToRelationshipTypes="source" delimiter=", ">^ca_entities.preferred_labels.displayname</unit>', array("checkAccess" => $va_access_values));						
						$vs_source_link = $t_item->get("ca_collections.link");
						if($vs_source_link){
							$vs_source_link = '<br/><a href="'.$vs_source_link.'" class="redLink" target="_blank">'.(($vs_source) ? $vs_source : 'Source Record').' <span class="glyphicon glyphicon-new-window"></span></a>';
						}						

						$vs_title_hover = $t_item->getWithTemplate("<ifdef code='ca_collections.ISADG_titleNote'>^ca_collections.ISADG_titleNote%delimiter=<br/><br/></ifdef>");
						$vs_title = $t_object->get("ca_objects.preferred_labels.name");
						
						print "<H4>";
						if($vs_title_hover){
							print '<span data-toggle="popover" title="Note" data-content="'.$vs_title_hover.'">'.$vs_title.'</span>';
						}else{
							print $vs_title;
						}
						print $vs_source_link."</H4>";
?>
						<H6>{{{^ca_collections.type_id}}}</H6>
						
						{{{<ifdef code="ca_collections.displayDate">
							<ifdef code="ca_collections.ISADG_dateNote"><div class="unit" data-toggle="popover" title="Note" data-content="^ca_collections.ISADG_dateNote">
								^ca_collections.displayDate
							</div></ifdef>
							<ifnotdef code="ca_collections.ISADG_dateNote">
								<div class="unit">^ca_collections.displayDate</div>
							</ifnotdef>
						</ifdef>}}}
						{{{<ifdef code="ca_collections.parent_id"><H6>Part of: <unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.preferred_labels.name</l></unit></H6></ifdef>}}}
						
<?php
						$vs_creators_entities = $t_item->getWithTemplate('<unit relativeTo="ca_entities.related" restrictToRelationshipTypes="contributor,creator" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit>', array("checkAccess" => $va_access_values));
						$vs_creators_text = $t_item->get('ca_collections.creator_contributor');
						if($vs_creators_entities || $vs_creators_text){
							print '<div class="unit"><H6>Creators and Contributors</H6><div class="trimTextShort">'.$vs_creators_entities.(($vs_creators_entities && $vs_creators_text) ? ", " : "").$vs_creators_text.'</div></div>';
						}
?>						
						{{{<ifcount code="ca_entities" restrictToRelationshipTypes="creator,contributor" min="1"><div class="unit"><H6>Creators and Contributors</H6><div class="trimTextShort"><unit relativeTo="ca_entities" restrictToRelationshipTypes="creator,contributor" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit></div></div></ifcount>}}}
						{{{<ifdef code="ca_collections.RAD_admin_hist">
							<div class="unit"><h6>Administrative/Biographical History</h6>
								<div class="trimText">^ca_collections.RAD_admin_hist</div>
							</div>
						</ifdef>}}}
						{{{<ifdef code="ca_collections.scope_new.scope_new_text">
							<ifdef code="ca_collections.scope_new.scope_new_source">
								<div class="unit" data-toggle="popover" title="Source" data-content="^ca_collections.scope_new.scope_new_source"><h6>Scope and Content</h6>
									<div class="trimText">^ca_collections.scope_new.scope_new_text</div>
								</div>
							</ifdef>
							<ifnotdef code="ca_collections.scope_new.scope_new_source">
								<div class="unit"><h6>Scope and Content</h6>
									<div class="trimText">^ca_collections.scope_new.scope_new_text</div>
								</div>
							</ifnotdef>
						</ifdef>}}}
						{{{<ifdef code="ca_collections.language">
							<ifdef code="ca_collections.language_note">
								<div class="unit" data-toggle="popover" title="Note" data-content="^ca_collections.language_note"><h6>Language</h6>^ca_collections.language</div>
							</ifdef>
							<ifnotdef code="ca_collections.language_note">
								<div class="unit"><h6>Language</h6>^ca_collections.language</div>
							</ifnotdef>
						</ifdef>}}}
								
						
					</div><!-- end stoneBg -->
						
					{{{<ifdef code="ca_collections.nonpreferred_labels|ca_collections.RAD_extent|ca_collections.RAD_custodial|ca_collections.source_identifer|ca_collections.ISADG_archNote|ca_collections.ISADG_rules">
						<div class="collapseBlock">
							<h3>More Information <i class="fa fa-toggle-down" aria-hidden="true"></i></H3>
							<div class="collapseContent">
								<ifdef code="ca_collections.nonpreferred_labels"><div class="unit"><H6>Alternate Title(s)</H6>^ca_collections.nonpreferred_labels%delimiter=<br/></div></ifdef>
								<ifdef code="ca_collections.RAD_extent"><div class="unit"><H6>Extent and Medium</H6>^ca_collections.RAD_extent%delimiter=<br/></div></ifdef>
								<ifdef code="ca_collections.RAD_custodial"><div class="unit"><h6>Archival History</h6>^ca_collections.RAD_custodial</div></ifdef>
								<ifdef code="ca_collections.RAD_accruals"><div class="unit"><h6>Accruals</h6>^ca_collections.RAD_accruals</div></ifdef>
								<ifdef code="ca_collections.RAD_arrangement"><div class="unit"><h6>System of Arrangement</h6>^ca_collections.RAD_arrangement</div></ifdef>
								<ifcount code="ca_entities" restrictToRelationshipTypes="repository" min="1"><div class="unit"><h6>Holding Repository</h6><unit relativeTo="ca_entities" restrictToRelationshipTypes="repository" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit></div></ifcount>
								<ifdef code="ca_collections.source_identifer"><div class='unit'><h6>Holding Repository Identifier</h6>^ca_collections.source_identifer</div></ifdef>
								<ifdef code="ca_collections.ISADG_archNote"><div class='unit'><h6>Archivist Notes</h6>^ca_collections.ISADG_archNote</div></ifdef>
								<ifdef code="ca_collections.ISADG_rules"><div class='unit'><h6>Rules or Conventions</h6>^ca_collections.ISADG_rules</div></ifdef>
							</div>
						</div>
					</ifdef>}}}
				</div>
				<div class='col-sm-12 col-md-<?php print ($vs_representationViewer) ? "2" : "5"; ?>'>
	<?php
					# Comment and Share Tools
						
					print '<div id="detailTools">';
					if ($this->getVar("resultsLink")) {
						print '<div class="detailTool detailToolInline detailNavFull">'.$this->getVar("resultsLink").'</div><!-- end detailTool -->';
					}
					if ($this->getVar("previousLink")) {
						print '<div class="detailTool detailToolInline detailNavFull">'.$this->getVar("previousLink").'</div><!-- end detailTool -->';
					}
					if ($this->getVar("nextLink")) {
						print '<div class="detailTool detailToolInline detailNavFull">'.$this->getVar("nextLink").'</div><!-- end detailTool -->';
					}

					print "<div class='detailTool'><span class='glyphicon glyphicon-envelope'></span>".caNavLink($this->request, "Ask a Question", "", "", "Contact", "Form", array("contactType" => "askArchivist", "collection_id" => $t_item->get("collection_id")))."</div>";
					print '</div><!-- end detailTools -->';			

					if ($vn_comments_enabled) {
						$vn_num_comments = sizeof($va_comments) + sizeof($va_tags);
?>				
						<div class="collapseBlock last discussion">
							<h3>Discussion</H3>
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
					if($vs_map = $this->getVar("map")){
						if($t_item->get("ca_places.georeference", array("checkAccess" => $va_access_values))){
							include("map_html.php");
						}
					}
?>
				</div>
			</div>
			<div class="row">
				<div class='col-sm-12'>
<?php
			if ($vb_show_hierarchy_viewer) {	
?>
				<div id="collectionHierarchy"><?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?></div>
				<script>
					$(document).ready(function(){
						$('#collectionHierarchy').load("<?php print caNavUrl($this->request, '', 'Collections', 'collectionHierarchy', array('collection_id' => $t_item->get('collection_id'))); ?>"); 
					})
				</script>
<?php				
			}									
?>				
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row" style="margin-top:30px;">
				<div class="col-sm-12">		
<?php
		include("related_tabbed_html.php");
?>
					{{{<ifcount code="ca_objects" min="1">
								<div class="relatedBlock">
								<h3>Records</H3>
									<div class="row">
										<div id="browseResultsContainer">
											<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
										</div><!-- end browseResultsContainer -->
									</div><!-- end row -->
									<script type="text/javascript">
										jQuery(document).ready(function() {
											jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Browse', 'objects', array('facet' => 'detail_collection', 'id' => '^ca_collections.collection_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
												jQuery('#browseResultsContainer').jscroll({
													autoTrigger: true,
													loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
													padding: 20,
													nextSelector: 'a.jscroll-next'
												});
											});
					
					
										});
									</script>
								</div>
					</ifcount>}}}
<?php
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

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 100
		});
		$('.trimTextShort').readmore({
		  speed: 75,
		  maxHeight: 18
		});
		$('.trimTextSubjects').readmore({
		  speed: 75,
		  maxHeight: 80,
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
  			block.find('.fa').toggleClass("fa-toggle-down");
  			block.find('.fa').toggleClass("fa-toggle-up");
  			
		});
	});
</script>