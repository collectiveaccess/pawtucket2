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
	$va_project_sets 					= $this->getVar("project_sets");
	$va_set_ids 						= $this->getVar("set_ids");
	$va_access_values 					= $this->getVar("access_values");
	$va_lightboxDisplayName 			= caGetLightboxDisplayNameProject();
	$vs_lightbox_displayname 			= $va_lightboxDisplayName["singular"];
	$vs_lightbox_displayname_plural 	= $va_lightboxDisplayName["plural"];
	$vs_lightbox_section_heading		= $va_lightboxDisplayName["section_heading"];
	$o_lightbox_config 					= $this->getVar("set_config");

	# --- default to having a project open when project_id is passed -> used in back button on set/palette page
	$pn_project_id = $this->request->getParameter("project_id", pInteger);

?>
	<div class="projectList">
	<div class="row">
		<div class='col-sm-6'>
			<h1><?php print ucfirst($vs_lightbox_section_heading); ?></h1>
		<!--<div class="btn-group">
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
		</div>--><!-- end btn-group -->

		</div>
		<div class='col-sm-6'>
<?php
			print "<a href='#' class='btn btn-default' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Lightbox', 'setForm', array("mode" => "project"))."\"); return false;' >+ "._t("New %1", $vs_lightbox_displayname)."</a>";
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
	if(sizeof($va_project_sets)){
		$vn_col = 1;
		foreach($va_set_ids as $vn_set_id){
			if ($t_set->load($vn_set_id)) {
				if($vn_col == 1){
					print "<div class='container'><div class='row'>";
				}
				print "<div class='col-sm-6' id='project".$vn_set_id."'><div class='projectItem'><H2><a href='#' onClick='jQuery(\".projectInfo".$vn_set_id."\").slideToggle(); return false;'><span class='glyphicon glyphicon-chevron-down'></span> ".$t_set->get("ca_sets.preferred_labels")."</a></H2>";	
?>
				<div class="container projectInfo<?php print $vn_set_id; ?>" <?php print ((sizeof($va_project_sets) > 1) && ($pn_project_id != $vn_set_id)) ? 'style="display:none;"' : ''; ?>>
					<div class="row">
					
<?php
						if ($vs_client = $t_set->get("ca_sets.client")) {
							print "<div class='col-sm-4'><div class='unit'><b>Client</b><br/>".$vs_client."</div></div>";
						}
						if ($t_set->get("ca_sets.location.address1") || $t_set->get("ca_sets.location.city") || $t_set->get("ca_sets.location.stateprovince") || $t_set->get("ca_sets.location.postalcode") || $t_set->get("ca_sets.location.country")) {
							print "<div class='col-sm-4'><div class='unit'><b>Location</b><br/>";
							if($vs_tmp = $t_set->get("ca_sets.location.address1")){
								print $vs_tmp."<br/>";
							}
							$va_parts = array();
							if($vs_tmp = $t_set->get("ca_sets.location.city")){
								$va_parts[] = $vs_tmp;
							}
							if($vs_tmp = $t_set->get("ca_sets.location.stateprovince")){
								$va_parts[] = $vs_tmp;
							}
							if(sizeof($va_parts)){
								print join(", ", $va_parts)." ";
							}
							if($vs_tmp = $t_set->get("ca_sets.location.postalcode")){
								print $vs_tmp." ";
							}
							if($vs_tmp = $t_set->get("ca_sets.location.country")){
								print $vs_tmp;
							}
							print "</div></div>";
						}
						
						if ($vs_tmp = $t_set->get("ca_sets.description")) {
							print "<div class='col-sm-4'><div class='unit'><b>Description</b><br/>".$vs_tmp."</div></div>";
						}
?>					
					</div><!-- end row -->
					<div class="row"><div class="col-sm-12">
<?php
				$qr_palettes = ca_sets::find(array('parent_id' => $vn_set_id), array('returnAs' => 'searchResult', 'sort' => 'ca_sets.preferred_labels.name', 'checkAccess' => $va_access_values));
				$va_palette_ids = array();
				if($qr_palettes->numHits()){
					while($qr_palettes->nextHit()){
						$va_palette_ids[] = $qr_palettes->get("ca_sets.set_id");
					}
					$qr_palettes->seek(0);
				}
				$va_set_first_items = $t_set->getPrimaryItemsFromSets($va_palette_ids, array("version" => "iconlarge", "checkAccess" => $va_access_values));
				
				if($qr_palettes->numHits()){
					print "<b>Palettes</b>";
					$vn_palette_count = 0;
					while($qr_palettes->nextHit()){
						if($vn_palette_count == 0){
							print "<div class='row paletteIcons'>";
						}
						print "<div class='col-sm-6 col-md-3 text-center'>";
						$va_img_info = array_pop($va_set_first_items[$qr_palettes->get("ca_sets.set_id")]);
						$vs_img = "";
						if(is_array($va_img_info)){
							$vs_img = $va_img_info["representation_tag"]."<br/>";
						}else{
							$vs_img = "<div class='palettePlaceholder'><i class='fa fa-leaf'></i></div><br/>";
						}
						print caNavLink($this->request, $vs_img.$qr_palettes->get("ca_sets.preferred_labels.name"), "", "", "Lightbox", "setDetail", array("set_id" => $qr_palettes->get("set_id")));
						print "</div>";
						$vn_palette_count++;
						if($vn_palette_count == 4){
							print "</div>";
							$vn_palette_count = 0;
						}
					}
					if($vn_palette_count > 0){
						print "</div>";
					}
					
				}
				
				print "<br/><div class='unit text-center'>";
				print "<div class='pull-right'><a href='#' class='btn btn-default btn-small' data-set_id=\"".$vn_set_id."\" data-set_name=\"".addslashes($t_set->get("ca_sets.preferred_labels"))."\" data-toggle='modal' data-target='#confirm-delete'><span class='glyphicon glyphicon-trash' style='color:#FFF'></span> Delete Project</a></div>\n";
				print caNavLink($this->request, 'Browse Project Plants', 'btn btn-default btn-small', '', 'Search', 'Plants', array('search' => 'set_id:'.join($va_palette_ids, " or ")));
				print "<a href='#' class='btn btn-default btn-small' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Lightbox', 'setForm', array('set_id' => $vn_set_id, 'mode' => 'project'))."\"); return false;' >"._t("Edit Project")."</a>";
				print "<a href='#' class='btn btn-default btn-small' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Lightbox', 'setForm', array('parent_id' => $vn_set_id))."\"); return false;' >+ "._t("New Palette")."</a>";
				
				
				print "</div>";


?>					
					</div></div><!-- end row -->
				</div><!-- container -->
<?php

				print "</div><!-- end projectItem --></div><!-- end col -->";
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
					<b>Are you new to Bramble?</b><br/><br/>Click the <b>New Project</b> button above to enter information about a project you are working on.  Your project can have as many plant palettes as you like.  Or just start browsing for plants and create a project and palette by clicking the <i class="fa fa-folder"></i> by plants throughout the site.
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
					jQuery("#project" + set_id).remove();
					jQuery("#lbSetListErrors").hide();
				} else {
					jQuery("#lbSetListErrors").html(data.errors.join(';')).show();
				}
				jQuery('#confirm-delete').modal('hide');
			});
		
		});
	});
</script>