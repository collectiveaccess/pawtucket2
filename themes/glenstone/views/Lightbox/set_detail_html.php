<?php
/** ---------------------------------------------------------------------
 * themes/default/Lightbox/set_detail_html.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2015 Whirl-i-Gig
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
 * @package CollectiveAccess
 * @subpackage theme/default
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
	$o_lightbox_config 					= $this->getVar("set_config");
	$q_set_items 					= $this->getVar("result");
	$t_set 							= $this->getVar("set");
	$vb_write_access 				= $this->getVar("write_access");
	
	$va_views						= $this->getVar('views');
	$vs_current_view				= $this->getVar('view');
	$va_criteria					= $this->getVar('criteria');
	
	$vs_current_sort				= $this->getVar('sort');
	$vs_current_secondary_sort		= $this->getVar('secondarySort');
	$vs_sort_dir					= $this->getVar('sortDirection');
	$vs_sort_control_type 			= $o_lightbox_config->get("sortControlType");
	if(!$vs_sort_control_type){
		$vs_sort_control_type = "dropdown";
	}
	
	$va_export_formats 				= $this->getVar('export_formats');
	$va_lightboxDisplayName 		= caGetLightboxDisplayName();
	$vs_lightbox_displayname 		= $va_lightboxDisplayName["singular"];
	$vs_lightbox_displayname_plural = $va_lightboxDisplayName["plural"];
	$vs_browse_key 					= $this->getVar('key');
	$vn_hits_per_block 	= (int)$this->getVar('hits_per_block');	// number of hits to display per block
	$vn_start		 	= (int)$this->getVar('start');			// offset to seek to before outputting results
	$vb_ajax			= (bool)$this->request->isAjax();
if (!$vb_ajax) {	// !ajax
?>	
	<div class="row">
		<div class="col-sm-7 col-md-7 col-lg-7">			
<?php 
			if($vs_sort_control_type == 'list'){
				if(is_array($va_sorts = $this->getVar('sortBy')) && (sizeof($va_sorts) > 1)) {
					print "<H5 id='bSortByList'><ul><li><strong>"._t("Sort by:")."</strong></li>\n";
					$i = 0;
					foreach($va_sorts as $vs_sort => $vs_sort_flds) {
						$i++;
						if ($vs_current_sort === $vs_sort) {
							print "<li class='selectedSort'>{$vs_sort}</li>\n";
						} else {
							print "<li>".caNavLink($this->request, $vs_sort, '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => $vs_sort))."</li>\n";
						}
						if($i < sizeof($va_sorts)){
							print "<li class='divide'>&nbsp;</li>";
						}
					}
					print "<li>".caNavLink($this->request, '<span class="glyphicon glyphicon-sort-by-attributes'.(($vs_sort_dir == 'asc') ? '' : '-alt').'"></span>', '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'direction' => (($vs_sort_dir == 'asc') ? _t("desc") : _t("asc"))))."</li>";
					print "</ul></H5>\n";
				}
			}
?>
			<div class="setsBack"><?php print caNavLink($this->request, ($o_lightbox_config->get("backLink")) ? $o_lightbox_config->get("backLink") : "<i class='fa fa-angle-double-left'></i><div class='small'>Back</div>", "", "", "Lightbox", "Index"); ?></div><!-- end setsBack -->
			<H1>
				<?php print $t_set->getLabelForDisplay(); ?>
				<?php print "<span class='lbSetCount'>(".$q_set_items->numHits()." items)</span>"; ?>
				<div class="btn-group">
					<i class="fa fa-gear bGear" data-toggle="dropdown"></i>
					<ul class="dropdown-menu" role="menu">
<?php
						if(($vs_sort_control_type == "dropdown") && is_array($va_sorts = $this->getVar('sortBy')) && (sizeof($va_sorts) > 1)) {
							print "<li class='dropdown-header'>"._t("Sort by:")."</li>\n";
							foreach($va_sorts as $vs_sort => $vs_sort_flds) {
								if ($vs_current_sort === $vs_sort) {
									print "<li><a href='#'><strong><em>{$vs_sort}</em></strong></a></li>\n";
								} else {
									print "<li>".caNavLink($this->request, $vs_sort, '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => $vs_sort))."</li>\n";
								}
							}
							print "<li class='divider'></li>\n";
							if(is_array($va_secondary_sorts = $this->getVar('secondarySortBy')) && sizeof($va_secondary_sorts)){
								print "<li class='dropdown-header'>"._t("Refine sort by:")."</li>\n";
								foreach($va_secondary_sorts as $vs_secondary_sort => $vs_secondary_sort_flds) {
									if($vs_secondary_sort != $vs_current_sort){
										if ($vs_current_secondary_sort === $vs_secondary_sort) {
											print "<li><a href='#'><strong><em>{$vs_secondary_sort}</em></strong></a></li>\n";
										} else {
											print "<li>".caNavLink($this->request, $vs_secondary_sort, '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'secondary_sort' => $vs_secondary_sort))."</li>\n";
										}
									}
								}
								print "<li class='divider'></li>\n";
							}
							print "<li class='dropdown-header'>"._t("Sort order:")."</li>\n";
							print "<li>".caNavLink($this->request, (($vs_sort_dir == 'asc') ? '<strong><em>' : '')._t("Ascending").(($vs_sort_dir == 'asc') ? '</em></strong>' : ''), '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'direction' => 'asc'))."</li>";
							print "<li>".caNavLink($this->request, (($vs_sort_dir == 'desc') ? '<strong><em>' : '')._t("Descending").(($vs_sort_dir == 'desc') ? '</em></strong>' : ''), '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'direction' => 'desc'))."</li>";
							print "<li class='divider'></li>";
						}
					if($vb_write_access){
?>
						<li><a href='#' onclick='caMediaPanel.showPanel("<?php print caNavUrl($this->request, '', 'Lightbox', 'setForm', array("set_id" => $t_set->get("set_id"))); ?>"); return false;' ><?php print _t("Edit Name/Description"); ?></a></li>
						<li><a href='#' onclick='caMediaPanel.showPanel("<?php print caNavUrl($this->request, '', 'Lightbox', 'shareSetForm', array()); ?>"); return false;' ><?php print _t("Share %1", ucfirst($vs_lightbox_displayname)); ?></a></li>
						<li><a href='#' onclick='caMediaPanel.showPanel("<?php print caNavUrl($this->request, '', 'Lightbox', 'setAccess', array()); ?>"); return false;' ><?php print _t("Manage %1 Access", ucfirst($vs_lightbox_displayname)); ?></a></li>
<?php
					}
?>
						<li><?php print caNavLink($this->request, _t("Start presentation"), "", "", "Lightbox", "Present", array('set_id' => $t_set->getPrimaryKey())); ?></li>
<?php
						#if(is_array($va_export_formats) && sizeof($va_export_formats)){
						#	// Export as PDF links
						#	print "<li class='divider'></li>\n";
						#	print "<li class='dropdown-header'>"._t("Download PDF as:")."</li>\n";
						#	foreach($va_export_formats as $va_export_format){
						#		print "<li>".caNavLink($this->request, $va_export_format["name"], "", "", "Lightbox", "setDetail", array("view" => "pdf", "download" => true, "export_format" => $va_export_format["code"], "key" => $vs_browse_key))."</li>";
						#	}
						#}
?>		
						<li class="divider"></li>
<?php
						if(is_array($this->getVar("user_groups")) && sizeof($this->getVar("user_groups"))){
?>
						<li><a href='#' onclick='caMediaPanel.showPanel("<?php print caNavUrl($this->request, '', 'Lightbox', 'userGroupList', array()); ?>"); return false;' ><?php print _t("Manage Your User Groups"); ?></a></li>
<?php
						}
?>
					</ul>
				</div><!-- end btn-group -->
			</H1>
			<H5>
<?php
				if (sizeof($va_criteria) > 1) {
					foreach($va_criteria as $va_criterion) {
						if ($va_criterion['facet_name'] != '_search') {
							print "<strong>".$va_criterion['facet'].':</strong> ';
							print caNavLink($this->request, '<button type="button" class="btn btn-default btn-sm">'.$va_criterion['value'].' <span class="glyphicon glyphicon-remove-circle"></span></button>', 'browseRemoveFacet', '*', '*', '*', array('removeCriterion' => $va_criterion['facet_name'], 'removeID' => $va_criterion['id'], 'view' => $vs_current_view, 'key' => $vs_browse_key));
							print " ";
						}
					}
					print caNavLink($this->request, '<button type="button" class="btn btn-default btn-sm">'._t("Start Over").'</span></button>', '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'clear' => 1));
				}
?>		
			</H5>
		</div><!-- end col -->
		<div class="col-sm-5 col-md-5 col-lg-5">
			<div id="lbViewButtons">
<?php
			if(is_array($va_views) && sizeof($va_views)){
				foreach($va_views as $vs_view => $va_view_info) {
					if ($vs_current_view === $vs_view) {
						print '<a href="#" class="active"><span class="glyphicon '.$va_view_info['icon'].'"></span></a> ';
					} else {
						print caNavLink($this->request, '<span class="glyphicon '.$va_view_info['icon'].'"></span>', 'disabled', '*', '*', '*', array('view' => $vs_view, 'set_id' => $t_set->get("set_id"), 'key' => $vs_browse_key)).' ';
					}
				}
			}
			if ($this->request->user->hasUserRole("founders_new") || $this->request->user->hasUserRole("admin") || $this->request->user->hasUserRole("curatorial_all_new") || $this->request->user->hasUserRole("curatorial_basic_new") || $this->request->user->hasUserRole("archives_new") || $this->request->user->hasUserRole("library_new")){
				// Export as PDF
				print "<div class='reportTools'>";
				print caFormTag($this->request, 'view/pdf', 'caExportForm', ($this->request->getModulePath() ? $this->request->getModulePath().'/' : '').$this->request->getController().'/'.$this->request->getAction(), 'post', 'multipart/form-data', '_top', array('disableUnsavedChangesWarning' => true));
				print "<select name='export_format'>";
				foreach($va_export_formats as $va_export_format){
					print "<option value='".$va_export_format["code"]."'>".$va_export_format["name"]."</option>";
				}
				print "</select> ";
				print caHTMLHiddenInput('key', array('value' => $vs_browse_key));
				print caHTMLHiddenInput('view', array('value' => 'pdf'));
				print caHTMLHiddenInput('download', array('value' => 1));
				print caFormSubmitLink($this->request, _t('Download'), 'button', 'caExportForm')."</form>\n";
				print "</div>"; 
			}
?>
			</div>			
		</div><!-- end col -->
	</div><!-- end row -->
	<div class="row">
		<div class="<?php print ($vs_left_col_class = $o_lightbox_config->get("setDetailLeftColClass")) ? $vs_left_col_class : "col-sm-9 col-md-9 col-lg-8"; ?>">
			<div id="lbSetResultLoadContainer">
<?php
} // !ajax
		if($q_set_items->numHits()){
			if ($vn_start < $q_set_items->numHits()) {
				$q_set_items->seek($vn_start);
				print $this->render("Lightbox/set_detail_{$vs_current_view}_html.php");
				print caNavLink($this->request, _t('Next %1', $vn_hits_per_block), 'jscroll-next', '', 'Lightbox', 'setDetail', array('s' => $vn_start + $vn_hits_per_block, 'key' => $vs_browse_key, 'view' => $vs_current_view));
			}
		}else{
			print "<div class='row'><div class='col-sm-12'>"._t("There are no items in this %1", $vs_lightbox_displayname)."</div></div>";
		}
if (!$vb_ajax) {	// !ajax
?>
			</div><!-- end lbSetResultLoadContainer -->		
		</div><!-- end col -->
		<div class="<?php print ($vs_right_col_class = $o_lightbox_config->get("setDetailRightColClass")) ? $vs_right_col_class : "col-sm-3 col-md-3 col-lg-3 col-lg-offset-1"; ?>">
<?php
			if(!$vb_write_access){
				print "<div class='warning'>"._t("You may not edit this set, you have read only access.")."</div>";
			}
			if($t_set->get("description")){
				print $t_set->get("description");
				print "<HR>";
			}			
			$va_comments = array_reverse($this->getVar("comments"));
?>
			<div>
				<form action="<?php print caNavUrl($this->request, "", "Lightbox", "saveComment"); ?>" id="addComment" method="post">
<?php
				if($vs_comment_error = $this->getVar("comment_error")){
					print "<div>".$vs_comment_error."</div>";
				}
?>
					<div class="form-group">
						<textarea name="comment" placeholder="add your comment" class="form-control"></textarea>
					</div><!-- end form-group -->
					<div class="form-group text-right">
						<button type="submit" class="btn btn-default btn-xs">Save</button>
					</div><!-- end form-group -->
					<input type="hidden" name="tablename" value="ca_sets">
					<input type="hidden" name="item_id" value="<?php print $t_set->get("set_id"); ?>">
					<input type="hidden" name="key" value="<?php print $vs_browse_key; ?>">
				</form>
			</div>
<?php
			if(sizeof($va_comments)){
?>
			<div class="lbSetCommentHeader"><a href="#" onClick="jQuery('.lbComments').toggle(); jQuery('#lbFilterList').toggle(); moveFilters(); return false;"><?php print sizeof($va_comments)." ".((sizeof($va_comments) == 1) ? _t("comment") : _t("comments")); ?> <i class="fa fa-arrows-v"></i></a><HR/></div>
<?php
				if(sizeof($va_comments)){
					$t_author = new ca_users();
					print "<div class='lbComments' style='display:none;'>";
					$i = 0;
					foreach($va_comments as $va_comment){
						print "<small>";
						# --- display link to remove comment?
						if($vb_write_access || ($va_comment["user_id"] == $this->request->user->get("user_id"))){
							print "<div class='pull-right'>".caNavLink($this->request, "<i class='fa fa-times' title='"._t("remove comment")."'></i>", "", "", "Lightbox", "deleteComment", array("comment_id" => $va_comment["comment_id"], "set_id" => $t_set->get("set_id"), "reload" => "detail"))."</div>";
						}
						$t_author->load($va_comment["user_id"]);
						print $va_comment["comment"]."<br/>";
						print "<small>".trim($t_author->get("fname")." ".$t_author->get("lname"))." ".date("n/j/y g:i A", $va_comment["created_on"])."</small>";
						print "</small>";
						$i++;
						if($i < sizeof($va_comments)){
							print "<HR/>";
						}
					}
?>
					<div class="lbSetCommentHeader"><a href="#" onClick="jQuery('.lbComments').toggle(); jQuery('#lbFilterList').toggle(); moveFilters(); return false;"><?php print ((sizeof($va_comments) == 1) ? _t("Hide comment") : _t("Hide comments")); ?> <i class="fa fa-arrows-v"></i></a></div>
<?php

					print "</div>";
				}
		
			}
			print "<div id='lbFilterList'>";
			print $this->render("Browse/browse_refine_subview_html.php");
			print "</div>";
			
?>
		</div><!-- end col -->
	</div><!-- end row -->
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('#lbSetResultLoadContainer').jscroll({
			autoTrigger: true,
			loadingHtml: "<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>",
			padding: 20,
			nextSelector: 'a.jscroll-next'
		});
	});
	
	function moveFilters() {
		var offset = $("#bRefine").offset();
		var initialFilterOffset = $("#lbFilterList").offset();
		jQuery("#bRefine").offset({top: initialFilterOffset.top, left: offset.left});
	}

</script>
<?php
} //!ajax
?>