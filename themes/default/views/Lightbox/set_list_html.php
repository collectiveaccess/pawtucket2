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
				print caLightboxSetListItem($this->request, $t_set, $va_access_values, array("write_access" => $vb_write_access));
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
			jQuery.getJSON('<?php print caNavUrl($this->request, '*', '*', 'DeleteLightbox'); ?>', {'set_id': set_id }, function(data) {
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