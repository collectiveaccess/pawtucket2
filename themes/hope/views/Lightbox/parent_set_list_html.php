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
	$va_parent_sets 					= $this->getVar("parent_sets");
	$va_set_ids 						= $this->getVar("set_ids");
	$va_access_values 					= $this->getVar("access_values");
	
	$vs_lightbox_displayname 		= $this->getVar("lightbox_displayname");
	$vs_lightbox_displayname_plural = $this->getVar("lightbox_displayname_plural");
	$vs_lightbox_section_heading		= $this->getVar("lightbox_section_heading");
	$vs_lightbox_parent_displayname 		= $this->getVar("lightbox_parent_displayname");
	$vs_lightbox_parent_displayname_plural = $this->getVar("lightbox_parent_displayname_plural");
	$vs_lightbox_parent_section_heading		= $this->getVar("lightbox_parent_section_heading");
	$o_lightbox_config 					= $this->getVar("set_config");
	$vs_description_field = $o_lightbox_config->get("lightbox_set_description_element_code");

	# --- default to having a parent set open when parent_id is passed -> used in back button on set/lightbox page
	$pn_parent_id = $this->request->getParameter("parent_id", pInteger);

	$vb_kam_curator = $this->getVar("kam_curator");
	
?>
	<div class="parentList">
	<div class="row">
		<div class='col-sm-6'>
			<h1><?php print ucfirst($vs_lightbox_parent_section_heading); ?></h1>
<?php
			if($vb_kam_curator){
?>
				<p>You are logged in as a <b>KAM curator</b>.  Your <?php print $vs_lightbox_parent_displayname_plural; ?> do not require approval to be published and will appear in the Gallery > KAM Curated section of the site.</p>
<?php
			}
?>
		</div>
		<div class='col-sm-6'>
<?php
			print "<a href='#' class='btn btn-default' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Lightbox', 'setForm', array("mode" => "parent"))."\"); return false;' >+ "._t("New %1", $vs_lightbox_displayname)."</a>";
?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div id="lbSetListErrors" style="display: none;" class='alert alert-danger'></div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class='row'><div class='col-sm-12'><hr/></div></div><!-- end row -->
<?php
	if(sizeof($va_parent_sets)){
		$vn_col = 1;
		foreach($va_set_ids as $vn_set_id){
			if ($t_set->load($vn_set_id)) {
				if($vn_col == 1){
					print "<div class='container'><div class='row'>";
				}
				$vb_creator = false;
				if($t_set->get("ca_sets.user_id") == $this->request->getUserId()){
					# --- current user is the creator of the set
					$vb_creator = true;
				}
				$vb_write_access = false;
				if($t_set->haveAccessToSet($this->request->getUserID(), __CA_SET_EDIT_ACCESS__)){
					$vb_write_access = true;
				}
				# --- only be able to edit when set to private
				if($t_set->get("ca_sets.access")){
					$vb_write_access = false;
				}
				$vs_cover_image = "";
				$va_cover_items = $t_set->getItems(array("thumbnailVersion" => "small", "checkAccess" => $va_access_values));
				if(is_array($va_cover_items) && sizeof($va_cover_items)){
					$va_first = array_shift(array_shift($va_cover_items));
					$vs_cover_image = $va_first["representation_tag"];
					#print_r($va_first);
				}
				print "<div class='col-sm-6' id='parent".$vn_set_id."'>";
				print "<div class='parentItem'>";
				
				if($vb_write_access){
?>				
					<div class="btn-group pull-right">
						<button class="btn btn-default btn-sm" data-toggle="dropdown">Options <span class="glyphicon glyphicon-cog bGear"></span></button>
						<ul class="dropdown-menu" role="menu">
							<li><a href='#' onclick='caMediaPanel.showPanel("<?php print caNavUrl($this->request, '', '*', 'setForm', array("set_id" => $t_set->get("set_id"), 'mode' => 'parent')); ?>"); return false;' ><?php print _t("Edit Name/Credit/Description"); ?></a></li>
<?php
						if($vb_creator){
?>
							<li><a href='#' onclick='caMediaPanel.showPanel("<?php print caNavUrl($this->request, '', '*', 'shareSetForm', array("set_id" => $t_set->get("set_id"))); ?>"); return false;' ><?php print _t("Share %1", ucfirst($vs_lightbox_displayname)); ?></a></li>
							<li><a href='#' onclick='caMediaPanel.showPanel("<?php print caNavUrl($this->request, '', '*', 'setAccess', array("set_id" => $t_set->get("set_id"))); ?>"); return false;' ><?php print _t("Manage %1 Access", ucfirst($vs_lightbox_displayname)); ?></a></li>
							<li><a href='#' data-set_id="<?php print $vn_set_id; ?>" data-set_name="<?php print addslashes($t_set->get("ca_sets.preferred_labels")); ?>" data-toggle='modal' data-target='#confirm-delete'>Delete <?php print ucfirst($vs_lightbox_displayname); ?></a></li>
							<li class="divider"></li>
							<li><a href='#' onclick='caMediaPanel.showPanel("<?php print caNavUrl($this->request, '', '*', 'userGroupForm', array()); ?>"); return false;' ><?php print _t("New User Group"); ?></a></li>
<?php
							if(is_array($this->getVar("user_groups")) && sizeof($this->getVar("user_groups"))){
?>
							<li><a href='#' onclick='caMediaPanel.showPanel("<?php print caNavUrl($this->request, '', 'Lightbox', 'userGroupList', array()); ?>"); return false;' ><?php print _t("Manage Your User Groups"); ?></a></li>
<?php
							}
						}
?>
						</ul>
					</div><!-- end btn-group -->				
<?php
				}else{
					# --- if it's public, show link to the public gallery
					if($t_set->get("ca_sets.access") == $o_lightbox_config->get("lightbox_public_access")){
						print caNavLink($this->request, _t("View %1", $vs_lightbox_parent_displayname), "btn btn-default btn-sm pull-right", "", "Gallery", $t_set->get("ca_sets.set_id"));
					}
				}
				print "<H2><a href='#' onClick='jQuery(\".parentInfo".$vn_set_id."\").slideToggle(); return false;'><span class='glyphicon glyphicon-chevron-down'></span> ".$t_set->get("ca_sets.preferred_labels")."</a></H2>";
?>
				<div class="container parentInfo<?php print $vn_set_id; ?>" <?php print ((sizeof($va_parent_sets) > 1) && ($pn_parent_id != $vn_set_id)) ? 'style="display:none;"' : ''; ?>>					
<?php
						print "<div class='row'><div class='col-sm-12'>";
						if(!$vb_creator){
							print "<div class='unit'><b>Created By</b><br/>";
							$t_creator = new ca_users($t_set->get("ca_sets.user_id"));
							print trim($t_creator->get("lname")." ".$t_creator->get("fname"))." (<a href='mailto:".$t_creator->get("email")."'>".$t_creator->get("email")."</a>)<br/>Only the creator can delete, share and publish.";
							print "</div>";
						}
						print "<div class='unit'><b>Publication Status</b><br/>";
						switch($t_set->get("ca_sets.access")){
							case $o_lightbox_config->get("lightbox_public_access"):
								print "<i>Publicly available</i> in the Gallery section of this site.";
								# --- only the owner can publish/unpublish
								if($vb_creator){
									print ' Unpublish to make changes or remove from the Gallery section of this site.';
									#print '<div class="unit text-center"><a href="#" class="btn btn-default btn-sm" id="unpublishButton'.$t_set->get("ca_sets.set_id").'" onClick="$(\'#unpublishButton'.$t_set->get("ca_sets.set_id").'\').hide(); $(\'#unpublish'.$t_set->get("ca_sets.set_id").'\').show(); return false;">Unpublish</a></div>';
									print "<div class='unit text-center' style='margin-top:5px;'><a href='#' class='btn btn-default btn-sm' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', '*', 'userUnpublishForm', array("set_id" => $t_set->get("set_id")))."\"); return false;' >"._t("Unpublish")."</a></div>";
								}else{
									$t_creator = new ca_users($t_set->get("ca_sets.user_id"));
									print "<br/>Contact the creator, ".trim($t_creator->get("lname")." ".$t_creator->get("fname"))." (<a href='mailto:".$t_creator->get("email")."'>".$t_creator->get("email")."</a>), to unpublish to make changes or remove from the Gallery section of this site.";
								}
							break;
							# --------------------------
							case $o_lightbox_config->get("lightbox_under_review_access"):
								print "<i>Under review.</i>  If approved, it will appear in the Gallery section of this site.";
							break;
							# --------------------------
							default:
								print "<i>Private.</i> ";
								if($t_set->get("ca_sets.user_id") == $this->request->getUserId()){
									if($vb_kam_curator){
										print "Click Publish to feature in Gallery section of this site:";
									}else{
										print "Publish to request this gallery appear in the Gallery section of this site.";
									}
									print "<div class='unit text-center' style='margin-top:5px;'>".caNavLink($this->request, "Publish", "btn btn-default btn-sm", "", "Lightbox", "publishRequest", array("set_id" => $t_set->get("ca_sets.set_id")))."</div>";
								}else{
									$t_creator = new ca_users($t_set->get("ca_sets.user_id"));
									print "<br/>Contact the creator, ".trim($t_creator->get("lname")." ".$t_creator->get("fname"))." (<a href='mailto:".$t_creator->get("email")."'>".$t_creator->get("email")."</a>), to request publication so it will appear in the Gallery section of this site.";
								}
							break;
							# --------------------------
						}
						print "</div></div></div>";
						if ($vs_tmp = $t_set->get("ca_sets.".$vs_description_field)) {
							print "<div class='row'><div class='col-sm-12'><div class='unit'><b>Description</b><div class='parentListDesc'>".$vs_tmp."</div></div></div></div><!-- end row -->";
						}
						if ($vs_tmp = $t_set->get("ca_sets.credit")) {
							print "<div class='row'><div class='col-sm-12'><div class='unit'><b>Credit</b><div class='parentListDesc'>".$vs_tmp."</div></div></div></div><!-- end row -->";
						}
						if($vs_cover_image){
							print "<div class='row'><div class='col-sm-12'><div class='unit'><b>Cover Image</b> (Featured image on gallery landing page)<div class='parentItemCoverImage'>".$vs_cover_image."</div></div></div></div>";
						}
				
?>										
					<div class="row"><div class="col-sm-12">
<?php
				$qr_children = ca_sets::find(array('parent_id' => $vn_set_id), array('returnAs' => 'searchResult', 'sort' => 'ca_sets.rank'));
				$va_child_ids = array();
				if($qr_children->numHits()){
					while($qr_children->nextHit()){
						$va_child_ids[] = $qr_children->get("ca_sets.set_id");
					}
					$qr_children->seek(0);
				}
				$va_set_first_items = $t_set->getPrimaryItemsFromSets($va_child_ids, array("version" => "iconlarge", "checkAccess" => $va_access_values));
				
				if($qr_children->numHits()){
					print "<div class='unit'><b>".$o_lightbox_config->get("lightboxSectionHeading")."</b>";
					if($vb_write_access){
						print " (Drag and drop into preferred order)";
					}
					print "</div>\n";
					print "<div class='row childIcons' id='childSets".$vn_set_id."'>";
					$vn_child_count = 0;
					while($qr_children->nextHit()){
						if($vn_child_count == 0){
							#print "<div class='row childIcons'>";
						}
						print "<div class='col-sm-6 col-md-3 text-center' id='set-".$qr_children->get("set_id")."'>";
						$va_img_info = array_pop($va_set_first_items[$qr_children->get("ca_sets.set_id")]);
						$vs_img = "";
						if(is_array($va_img_info)){
							$vs_img = $va_img_info["representation_tag"]."<br/>";
						}else{
							$vs_img = "<div class='childPlaceholder'>".caGetThemeGraphic($this->request, 'spacer.png')."<i class='fa fa-picture-o'></i></div>";
						}
						$vs_label = "<span class='childLabel'>".$qr_children->get("ca_sets.preferred_labels.name")."</span>";
						if($vb_write_access){
							print caNavLink($this->request, $vs_img.$vs_label, "", "", "Lightbox", "setDetail", array("set_id" => $qr_children->get("set_id")));
						}else{
							print $vs_img.$vs_label;
						}
						print "</div>";
						$vn_child_count++;
						if($vn_child_count == 4){
							#print "</div>";
							$vn_child_count = 0;
						}
					}
					if($vn_child_count > 0){
						#print "</div>";
					}
					print "</div>";
					if($vb_write_access){
?>
					<script type="text/javascript">
						jQuery(document).ready(function() {
							$("#childSets<?php print $vn_set_id; ?>").sortable({
								cursor: "move",
								opacity: 0.8,
								helper: 'clone',
								appendTo: 'body',
								zIndex: 10000,
								update: function( event, ui ) {
									var data = $(this).sortable('serialize');
									jQuery.ajax({
										type: 'POST',
										url: '<?php print caNavUrl($this->request, "", "Lightbox", "AjaxReorderChildSets"); ?>/set_id/<?php print $vn_set_id; ?>/set_ids/' + data
									});
								}
							});
						});
					</script>
<?php
					}
				}
				if($vb_write_access){
					print "<br/><div class='unit text-center'><a href='#' class='btn btn-default btn-sm' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Lightbox', 'setForm', array('parent_id' => $vn_set_id))."\"); return false;' >+ "._t("New ".$o_lightbox_config->get("lightboxDisplayName"))."</a></div>";
				}

?>					
					</div></div><!-- end row -->
				</div><!-- container -->
<?php

				print "</div><!-- end parentItem --></div><!-- end col -->";
				if($vn_col == 2){
					$vn_col = 0;
					print "</div><!-- end row --></div><!-- end container -->\n";
					print "<div class='row'><div class='col-sm-12'><hr/></div></div><!-- end row -->\n";
				}
				$vn_col++;
			}
		}
		if($vn_col > 1){
			print "</div><!-- end row --></div><!-- end container -->\n";
		}
	}else{
?>
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-sm-offset-3 text-center"><br/><H4>
					Click the <b>New <?php print $o_lightbox_config->get("lightboxDisplayNameParent"); ?></b> button above to enter information about a <?php print $o_lightbox_config->get("lightboxDisplayNameParent"); ?> you are working on.  Your <?php print $o_lightbox_config->get("lightboxDisplayNameParent"); ?> can have as many slideshows as you like.  Or just start browsing for items and create a <?php print $o_lightbox_config->get("lightboxDisplayNameParent"); ?> and <?php print $o_lightbox_config->get("lightboxDisplayName"); ?> by clicking the <i class="fa fa-folder"></i> by items throughout the site.
				</H4></div>
			</div>
		</div>
<?php
	}
?>
		</div><!-- end col -->
		
	</div><!-- end row -->
</div>
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
					jQuery("#parent" + set_id).remove();
					jQuery("#lbSetListErrors").hide();
				} else {
					jQuery("#lbSetListErrors").html(data.errors.join(';')).show();
				}
				jQuery('#confirm-delete').modal('hide');
			});
		
		});
	});
</script>