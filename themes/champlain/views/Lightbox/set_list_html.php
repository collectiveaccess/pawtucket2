<?php
/** ---------------------------------------------------------------------
 * themes/default/Lightbox/set_list_html.php :
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
	$t_set 								= new ca_sets();
	$va_write_sets 						= $this->getVar("write_sets");
	$va_read_sets 						= $this->getVar("read_sets");
	$va_set_ids 						= $this->getVar("set_ids");
	$va_access_values 					= $this->getVar("access_values");
	$va_activity_stream 				= $this->getVar("activity");
	$va_lightboxDisplayName 			= caGetLightboxDisplayName();
	$vs_lightbox_displayname 			= $va_lightboxDisplayName["singular"];
	$vs_lightbox_displayname_plural 	= $va_lightboxDisplayName["plural"];
	$vs_lightbox_section_heading		= $va_lightboxDisplayName["section_heading"];
	$o_lightbox_config 					= $this->getVar("set_config");

?>
	<h1>
		<?php print ucfirst($vs_lightbox_section_heading); ?>
		<div class="btn-group">
			<span class="glyphicon glyphicon-cog bGear" data-toggle="dropdown"></span>
			<ul class="dropdown-menu" role="menu">
				<li><a href='#' onclick='caMediaPanel.showPanel("<?php print caNavUrl($this->request, '', '*', 'setForm', array()); ?>"); return false;' ><?php print _t("New %1", ucfirst($vs_lightbox_displayname)); ?></a></li>
				<li class="divider"></li>
				<li><a href='#' onclick='caMediaPanel.showPanel("<?php print caNavUrl($this->request, '', '*', 'userGroupForm', array()); ?>"); return false;' ><?php print _t("New User Group"); ?></a></li>
<?php
				if(is_array($this->getVar("user_groups")) && sizeof($this->getVar("user_groups"))){
?>
				<li><a href='#' onclick='caMediaPanel.showPanel("<?php print caNavUrl($this->request, '', '*', 'userGroupList', array()); ?>"); return false;' ><?php print _t("Manage Your User Groups"); ?></a></li>
<?php
				}
?>
			</ul>
		</div><!-- end btn-group -->
	</h1>
	
	<div id="lbSetListErrors" style="display: none;" class='alert alert-danger'></div>
	
	<div class="row">
		<div class="<?php print ($vs_left_col_class = $o_lightbox_config->get("setListLeftColClass")) ? $vs_left_col_class : "col-sm-10 col-md-9 col-lg-7"; ?>">
<?php
	if(sizeof($va_set_ids)){
		$vn_i = 0;
		foreach($va_set_ids as $vn_set_id){
			if ($t_set->load($vn_set_id)) {
				if($vn_i == 0) { print "<div class='row lbSetListItemRow'>"; }
				$vn_i++;
			
			
				$vb_write_access = $t_set->haveAccessToSet($this->request->getUserID(), 2);
				print "<div class='col-xs-6 col-sm-6 col-md-6 lbSetListItemCol'>\n";
				print caLightboxSetListItemWithCollectionPlaceholder($this->request, $t_set, $va_access_values, array("write_access" => $vb_write_access));
				print "\n</div><!-- end col -->\n";
				if($vn_i == 2){
					$vn_i = 0;
					print "</div><!-- end row -->";
				}
			}
		}
		if($vn_i == 1){
			print "</div><!-- end row -->";
		}
	}
	print "<div class='row' id='lbSetListPlaceholder'".((sizeof($va_set_ids) > 0) ? " style='display: none;'" : '')."><div class='col-sm-6 col-md-6'>\n".$this->render("Lightbox/set_list_item_placeholder_html.php", true)."\n</div><!-- end col --></div><!-- end row -->\n";
?>
		</div><!-- end col 1-->
		<div class="<?php print ($vs_right_col_class = $o_lightbox_config->get("setListRightColClass")) ? $vs_right_col_class : "col-sm-2 col-md-3 col-lg-3 col-lg-offset-2"; ?>">
<?php
		if(is_array($va_activity_stream) && sizeof($va_activity_stream)) {
?>
			<h2><?php print _t("Activity stream"); ?></h2>
			 <div class="activitystream">
<?php
				$t_group = new ca_user_groups();
			
				foreach($va_activity_stream as $va_activity){
					print "<div><small>";
					print $va_activity["fname"]." ".$va_activity["lname"]." ";
					switch($va_activity["logged_table_num"]){
						case Datamodel::getTableNum("ca_set_items"):
							switch($va_activity["changetype"]){
								case "I":
									print _t("added an item to %1", caNavLink($this->request, $va_activity["name"], "", "", "Lightbox", "setDetail", array("set_id" => $va_activity["set_id"])));
									break;
								# ----------------------------------------
								case "U":
									print _t("changed an item in %1", caNavLink($this->request, $va_activity["name"], "", "", "Lightbox", "setDetail", array("set_id" => $va_activity["set_id"])));
									break;
								# ----------------------------------------
								case "D":
									print _t("removed and item from %1", caNavLink($this->request, $va_activity["name"], "", "", "Lightbox", "setDetail", array("set_id" => $va_activity["set_id"])));
									break;
								# ----------------------------------------
							}
							break;
						# ----------------------------------------
						case Datamodel::getTableNum("ca_sets_x_user_groups"):
							$t_group->load($va_activity["snapshot"]["group_id"]);
							switch($va_activity["changetype"]){
								case "I":
									print _t("shared %1 with %2", caNavLink($this->request, $va_activity["name"], "", "", "Lightbox", "setDetail", array("set_id" => $va_activity["set_id"])), $t_group->get("name"));
									break;
								# ----------------------------------------
								case "U":
									print _t("changed how they share %1 with %2", caNavLink($this->request, $va_activity["name"], "", "", "Lightbox", "setDetail", array("set_id" => $va_activity["set_id"])), $t_group->get("name"));
									break;
								# ----------------------------------------
								case "D":
									print _t("unshared %1 with %2", caNavLink($this->request, $va_activity["name"], "", "", "Lightbox", "setDetail", array("set_id" => $va_activity["set_id"])), $t_group->get("name"));
									break;
								# ----------------------------------------
							}
						break;
						# ----------------------------------------
						case Datamodel::getTableNum("ca_item_comments"):
							if($va_activity["table_num"] == Datamodel::getTableNum("ca_sets")){
								print _t("commented on %1", caNavLink($this->request, $va_activity["name"], "", "", "Lightbox", "setDetail", array("set_id" => $va_activity["set_id"])));
							}elseif($va_activity["table_num"] == Datamodel::getTableNum("ca_set_items")){
								print _t("commented on an item in %1", caNavLink($this->request, $va_activity["name"], "", "", "Lightbox", "setDetail", array("set_id" => $va_activity["set_id"])));
							}
							print ": <i>".((mb_strlen($va_activity["comment"]) > 38) ? mb_substr($va_activity["comment"], 0, 38)."..." : $va_activity["comment"])."</i>";
							break;
						# ----------------------------------------
						case Datamodel::getTableNum("ca_sets"):
							switch($va_activity["changetype"]){
								case "I":
									print _t("made %1", caNavLink($this->request, $va_activity["name"], "", "", "Lightbox", "setDetail", array("set_id" => $va_activity["set_id"])));
									break;
								# ----------------------------------------
								case "U":
									print _t("edited %1", caNavLink($this->request, $va_activity["name"], "", "", "Lightbox", "setDetail", array("set_id" => $va_activity["set_id"])));
									break;
								# ----------------------------------------
								case "D":
									print _t("deleted %1", caNavLink($this->request, $va_activity["name"], "", "", "Lightbox", "setDetail", array("set_id" => $va_activity["set_id"])));
									break;
								# ----------------------------------------
							}
							break;
						# ----------------------------------------
					}
					print "<br/>".date("n/j/y g:iA", $va_activity["log_datetime"])."</small>";
					print "</div><hr/>";
				}
?>
			</div><!-- end scroll -->
<?php
	}
?>
		</div><!-- end col -->
	</div><!-- end row -->
<?php
	//
	// Delete set confirm dialog
	//
?>
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="Confirm delete" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				
			</div>
			<div class="modal-footer">
				<a class="btn btn-ok btn-delete"><span class="glyphicon glyphicon-trash"></span> <?php print _t('Delete'); ?></a>
				<a class="btn" data-dismiss="modal"><?php print _t('Cancel'); ?></a>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('#confirm-delete').on('show.bs.modal', function(e) {
			var set_id = jQuery(e.relatedTarget).data('set_id');
			var set_name = jQuery(e.relatedTarget).data('set_name');
	
			var b = '<?php print addslashes(_t('Really delete <strong><em>%1</em></strong>? This action cannot be undone.', "^set_name")); ?>';
			jQuery(".modal-body").html(b.replace("^set_name", set_name));
			jQuery('#confirm-delete .btn-delete').data('set_id', set_id);
		}).find('.btn-delete').on('click', function(e) {
			var set_id = jQuery(this).data('set_id');
			jQuery.getJSON('<?php print caNavUrl($this->request, '*', '*', 'DeleteLightbox'); ?>', {'set_id': set_id, 'csrfToken': <?= json_encode(caGenerateCSRFToken($this->request)); ?> }, function(data) {
				if(data.status == 'ok') {
					jQuery("#lbSetContainer" + set_id).parent().remove();
					if (jQuery('.lbSetContainer').length == 0) { jQuery('#lbSetListPlaceholder').show(); } else { jQuery('#lbSetListPlaceholder').hide(); }
					jQuery("#lbSetListErrors").hide();
				} else {
					jQuery("#lbSetListErrors").html(data.errors.join(';')).show();
				}
				jQuery('#confirm-delete').modal('hide');
			});
		
		});
	});
</script>

<?php
	function caLightboxSetListItemWithCollectionPlaceholder($po_request, $t_set, $va_check_access = array(), $pa_options = array()) {
		$o_icons_conf = caGetIconsConfig();
		if(!($vs_default_placeholder = $o_icons_conf->get("placeholder_media_icon"))){
			$vs_default_placeholder = "<i class='fa fa-picture-o fa-2x' aria-label='placeholder image'></i>";
		}
		$vs_default_placeholder_tag = "<div class='bResultItemImgPlaceholder'>".$vs_default_placeholder."</div>";
		$va_collection_specific_icons = $o_icons_conf->getAssoc("collection_placeholders_square");

		if(!($vn_set_id = $t_set->get("set_id"))) {
			return false;
		}
		$vb_write_access = false;
		if($pa_options["write_access"]){
			$vb_write_access = true;
		}
		$va_set_items = caExtractValuesByUserLocale($t_set->getItems(array("user_id" => $po_request->user->get("user_id"), "thumbnailVersions" => array("iconlarge", "icon"), "checkAccess" => $va_check_access, "limit" => 5)));
		
		$vs_set_display = "<div class='lbSetContainer' id='lbSetContainer{$vn_set_id}'><div class='lbSet ".(($vb_write_access) ? "" : "readSet" )."'><div class='lbSetContent'>\n";
		if(!$vb_write_access){
			$vs_set_display .= "<div class='pull-right caption'>Read Only</div>";
		}
		$vs_set_display .= "<H5>".caNavLink($po_request, $t_set->getLabelForDisplay(), "", "", "Lightbox", "setDetail", array("set_id" => $vn_set_id), array('id' => "lbSetName{$vn_set_id}"))."</H5>";

        $va_lightboxDisplayName = caGetLightboxDisplayName();
		$vs_lightbox_displayname = $va_lightboxDisplayName["singular"];
		$vs_lightbox_displayname_plural = $va_lightboxDisplayName["plural"];

        if(sizeof($va_set_items)){
			$vs_primary_image_block = $vs_secondary_image_block = "";
			$vn_i = 1;
			$t_list_items = new ca_list_items();
			foreach($va_set_items as $va_set_item){
				$vn_collection_idno = "";
				$t_list_items->load($va_set_item["type_id"]);
				$t_object = new ca_objects($va_set_item["row_id"]);
				if($vs_collection_icon = collectionIcon($po_request, $t_object, "collection_placeholders_square")){
					$vs_placeholder = "<div>".$vs_collection_icon."</div>";
				}
				
				if($vn_i == 1){
					# --- is the iconlarge version available?
					$vs_large_icon = "icon";
					if($va_set_item["representation_url_iconlarge"]){
						$vs_large_icon = "iconlarge";
					}
					if($va_set_item["representation_tag_".$vs_large_icon]){
						$vs_primary_image_block .= "<div class='col-sm-6'><div class='lbSetImg'>".caNavLink($po_request, $va_set_item["representation_tag_".$vs_large_icon], "", "", "Lightbox", "setDetail", array("set_id" => $vn_set_id))."</div><!-- end lbSetImg --></div>\n";
					}else{
						$vs_primary_image_block .= "<div class='col-sm-6'><div class='lbSetImg'>".caNavLink($po_request, "<div class='lbSetImgPlaceholder' style='padding:0px;'>".$vs_placeholder."</div><!-- end lbSetImgPlaceholder -->", "", "", "Lightbox", "setDetail", array("set_id" => $vn_set_id))."</div><!-- end lbSetImg --></div>\n";
					}
				}else{
					if($va_set_item["representation_tag_icon"]){
						$vs_secondary_image_block .= "<div class='col-xs-3 col-sm-6 lbSetThumbCols'><div class='lbSetThumb'>".caNavLink($po_request, $va_set_item["representation_tag_icon"], "", "", "Lightbox", "setDetail", array("set_id" => $vn_set_id))."</div><!-- end lbSetThumb --></div>\n";
					}else{
						$vs_secondary_image_block .= "<div class='col-xs-3 col-sm-6 lbSetThumbCols'>".caNavLink($po_request, "<div class='lbSetThumbPlaceholder'>".$vs_placeholder."</div><!-- end lbSetThumbPlaceholder -->", "", "", "Lightbox", "setDetail", array("set_id" => $vn_set_id))."</div>\n";
					}
				}
				$vn_i++;
			}
			while($vn_i < 6){
				$vs_secondary_image_block .= "<div class='col-xs-3 col-sm-6 lbSetThumbCols'>".caNavLink($po_request, "<div class='lbSetThumbPlaceholder'>".caGetThemeGraphic($po_request,'spacer.png')."</div><!-- end lbSetThumbPlaceholder -->", "", "", "Lightbox", "setDetail", array("set_id" => $vn_set_id))."</div>";
				$vn_i++;
			}
		}else{
			$vs_primary_image_block .= "<div class='col-sm-6'><div class='lbSetImg'><div class='lbSetImgPlaceholder'>"._t("this %1 contains no items", $vs_lightbox_displayname)."</div><!-- end lbSetImgPlaceholder --></div><!-- end lbSetImg --></div>\n";
			$i = 1;
			while($vn_i < 4){
				$vs_secondary_image_block .= "<div class='col-xs-3 col-sm-6 lbSetThumbCols'><div class='lbSetThumbPlaceholder'>".caGetThemeGraphic($po_request,'spacer.png')."</div><!-- end lbSetThumbPlaceholder --></div>";
				$vn_i++;
			}
		}
		$vs_set_display .= "<div class='row'>".$vs_primary_image_block."<div class='col-sm-6'><div id='comment{$vn_set_id}' class='lbSetComment'><!-- load comments here --></div>\n<div class='lbSetThumbRowContainer'><div class='row lbSetThumbRow' id='lbSetThumbRow{$vn_set_id}'>".$vs_secondary_image_block."</div><!-- end row --></div><!-- end lbSetThumbRowContainer --></div><!-- end col --></div><!-- end row -->";
		$vs_set_display .= "</div><!-- end lbSetContent -->\n";
		$vs_set_display .= "<div class='lbSetExpandedInfo' id='lbExpandedInfo{$vn_set_id}'>\n<hr><div>created by: ".trim($t_set->get("ca_users.fname")." ".$t_set->get("ca_users.lname"))."</div>\n";
		$vs_set_display .= "<div>"._t("Items: %1", $t_set->getItemCount(array("user_id" => $po_request->user->get("user_id"), "checkAccess" => $va_check_access)))."</div>\n";
		if($vb_write_access){
			$vs_set_display .= "<div class='pull-right'><a href='#' data-set_id=\"".(int)$t_set->get('set_id')."\" data-set_name=\"".addslashes($t_set->get('ca_sets.preferred_labels.name'))."\" data-toggle='modal' data-target='#confirm-delete'><span class='glyphicon glyphicon-trash'></span></a></div>\n";
		}
		$vs_set_display .= "<div><a href='#' onclick='jQuery(\"#comment{$vn_set_id}\").load(\"".caNavUrl($po_request, '', 'Lightbox', 'AjaxListComments', array('type' => 'ca_sets', 'set_id' => $vn_set_id))."\", function(){jQuery(\"#lbSetThumbRow{$vn_set_id}\").hide(); jQuery(\"#comment{$vn_set_id}\").show();}); return false;' title='"._t("Comments")."'><span class='glyphicon glyphicon-comment'></span> <small>".$t_set->getNumComments()."</small></a>";
		if($vb_write_access){
			$vs_set_display .= "&nbsp;&nbsp;&nbsp;<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($po_request, '', 'Lightbox', 'setForm', array("set_id" => $vn_set_id))."\"); return false;' title='"._t("Edit Name/Description")."'><span class='glyphicon glyphicon-edit'></span></a>";
		}
		$vs_set_display .= "</div>\n";
		$vs_set_display .= "</div><!-- end lbSetExpandedInfo --></div><!-- end lbSet --></div><!-- end lbSetContainer -->\n";

        return $vs_set_display;
	}

?>