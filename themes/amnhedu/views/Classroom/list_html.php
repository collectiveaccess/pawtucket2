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
	
	$o_classroom_config 				= $this->getVar("classroom_config");
	$vs_classroom_displayname 			= $this->getVar("classroom_display_name");
	$vs_classroom_displayname_plural 	= $this->getVar("classroom_display_name_plural");
	$vs_classroom_section_heading		= $this->getVar("classroom_section_heading");
	
	$va_user_groups						= $this->getvar("user_groups");
	
	$vs_user_role						= $this->getVar("user_role");
?>
	<h1>
		<?php print ucfirst($vs_classroom_section_heading); ?>
	</h1>
	
	<div id="crSetListErrors" style="display: none;" class='alert alert-danger'></div>
	
	<div class="row">
		<div class="<?php print ($vs_left_col_class = $o_classroom_config->get("setListLeftColClass")) ? $vs_left_col_class : "col-sm-10 col-md-9 col-lg-7"; ?>">
		<div class="crSetList">
<?php
	if(sizeof($va_set_ids)){
		$vn_i = 0;
		foreach($va_set_ids as $vn_set_id){
			if ($t_set->load($vn_set_id)) {
				$vb_write_access = $t_set->haveAccessToSet($this->request->getUserID(), 2);
				print "<div class='row'><div class='col-xs-12'>\n";
				print caClassroomSetListItem($this->request, $t_set, $va_access_values, array("write_access" => $vb_write_access));
				print "\n</div><!-- end col --></div><!-- end row -->\n";
			}
		}
		if($vn_i == 1){
			print "</div><!-- end row -->";
		}
	}
	if($vs_user_role == $this->getVar("educator_role")){
		# --- educator help text
?>
		<H2>How to get started</H2>
		<p>
			Use the New <?php print ucfirst($vs_classroom_displayname); ?> link above to create an <?php print $vs_classroom_displayname; ?> to share with your students.  To start, define a name and description. The description should contain instructions for the student to follow.  Once you've created the <?php print ucfirst($vs_classroom_displayname); ?>, you can use the <?php print $o_classroom_config->get("addToClassroomIcon"); ?> button near items throughout the site to add them to your <?php print $vs_classroom_displayname; ?>, creating a slideshow of items for students to interact with.
		</p>
		<p>
			You can share your <?php print $vs_classroom_displayname; ?> with individual students or groups by using the Share <?php print ucfirst($vs_classroom_displayname); ?> link.  Students can join groups by simply following the provided group Url.  The will be prompted to login or register and automatically linked to the group.
		</p>
		<p>
			How can students engage with <?php print $vs_classroom_displayname_plural; ?>? You can prompt students to interact with <?php print $vs_classroom_displayname_plural; ?> in a variety of ways.
			<ul>
				<li>
					They can answer questions or share observations by adding comments at the <?php print $vs_classroom_displayname; ?>, or item level.
				</li>
				<li>
					They can use the site's image annotation tools to label or measure images by clicking the <span class='glyphicon glyphicon-zoom-in'></span> button by <?php print $vs_classroom_displayname; ?> items.
				</li>
				<li>
					Finally, students can respond to <?php print $vs_classroom_displayname_plural; ?> by creating their own collection of items complete with name, description, image annotations and comments.
				</li>
			</ul>
		</p>
<?php
	}
	print "</div><!-- end crSetList -->";

	if($vs_user_role == $this->getVar("educator_role")){
		# --- educator help text
?>
		<div><H2>How to get started</H2>
		<p>
			Use the New <?php print ucfirst($vs_classroom_displayname); ?> link above to create an <?php print $vs_classroom_displayname; ?> to share with your students.  To start, define a name and description. The description should contain instructions for the student to follow.  Once you've created the <?php print ucfirst($vs_classroom_displayname); ?>, you can use the <?php print $o_classroom_config->get("addToClassroomIcon"); ?> button near items throughout the site to add them to your <?php print $vs_classroom_displayname; ?>, creating a slideshow of items for students to interact with.
		</p>
		<p>
			You can share your <?php print $vs_classroom_displayname; ?> with individual students or groups by using the Share <?php print ucfirst($vs_classroom_displayname); ?> link.  Students can join groups by simply following the provided group Url.  The will be prompted to login or register and automatically linked to the group.
		</p>
		<p>
			How can students engage with <?php print $vs_classroom_displayname_plural; ?>? You can prompt students to interact with <?php print $vs_classroom_displayname_plural; ?> in a variety of ways.
			<ul>
				<li>
					They can answer questions or share observations by adding comments at the <?php print $vs_classroom_displayname; ?>, or item level.
				</li>
				<li>
					They can use the site's image annotation tools to label or measure images by clicking the <span class='glyphicon glyphicon-zoom-in'></span> button by <?php print $vs_classroom_displayname; ?> items.
				</li>
				<li>
					Finally, students can respond to <?php print $vs_classroom_displayname_plural; ?> by creating their own collection of items complete with name, description, image annotations and comments.
				</li>
			</ul>
		</p></div>
<?php
	}
	print "<div class='row' id='crSetListPlaceholder'".((sizeof($va_set_ids) > 0) ? " style='display: none;'" : '')."><div class='col-sm-12'>\n";
	if($vs_user_role == $this->getVar("educator_role")){
		print _t("You have no %1.", $vs_classroom_displayname_plural);	
?>
		<a href='#' class='btn btn-default btn-lg' onclick='caMediaPanel.showPanel("<?php print caNavUrl($this->request, '', '*', 'setForm', array()); ?>"); return false;' ><?php print _t("New %1", ucfirst($vs_classroom_displayname)); ?></a>
<?php
	}else{
		print _t("You have no %1.", $vs_classroom_displayname_plural);	
	}
	print "\n</div><!-- end col --></div><!-- end row -->\n";
?>
		</div><!-- end col 1-->
		<div class="<?php print ($vs_right_col_class = $o_classroom_config->get("setListRightColClass")) ? $vs_right_col_class : "col-sm-2 col-md-3 col-lg-3 col-lg-offset-2"; ?>">
<?php
		# --- educators see links for new assignments and managing user groups/classes
		if($vs_user_role == $this->getVar("educator_role")){
?>
			<div class="text-center"><a href='#' class='btn btn-default btn-lg' onclick='caMediaPanel.showPanel("<?php print caNavUrl($this->request, '', '*', 'setForm', array()); ?>"); return false;' ><?php print _t("New %1", ucfirst($vs_classroom_displayname)); ?></a></div>
			<H2>Your Groups</H2>
			<p><small>Groups are an easy way to share your <?php print $vs_classroom_displayname_plural; ?> with your classes.  Simply make a group, and use the Share <?php print ucfirst($vs_classroom_displayname); ?> button to link your <?php print $vs_classroom_displayname_plural; ?> with groups.  Individual students can join the group by following the group's Url.</small></p>
<?php
			print "<div class='text-center'><a href='#' class='btn btn-default btn-lg' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', '*', 'userGroupForm', array())."\"); return false;' >"._t("New Group")."</a></div><HR/>";
			if(sizeof($va_user_groups)){
				foreach($va_user_groups as $va_user_group){
					print "<div class='crListUserGroup'><a href='#' onClick='$(\"#userGroup".$va_user_group["group_id"]."\").slideToggle(); return false;'><div class='pull-right'><span class='glyphicon glyphicon-expand'></span></div>".$va_user_group["name"]."</a>";
					print "<br/><small>"._t("%1 members", sizeof($va_user_group["members"]))."<br/>";
					print "</small>\n";
					
					print "<div id='userGroup".$va_user_group["group_id"]."' style='display:none; padding-left:10px;'><small>";
					print '<dl>';
					if($va_user_group["description"]){
						print "<dt>"._t("Description")."</dt><dd>".$va_user_group["description"]."</dd>";
					}
					print "<dt>"._t("Url to join group")."</dt><dd><textarea class='form-control'>".$this->request->config->get('site_hostname').caNavUrl($this->request, "", "LoginReg", "joinGroup", array("group_id" => $va_user_group["group_id"], "section" => "classroom"))."</textarea></dd>";
					print "<dt>"._t("Members")."</dt><dd>";
					if(is_array($va_user_group["members"]) && sizeof($va_user_group["members"])){
						print "<ul>";
						foreach($va_user_group["members"] as $va_group_user){
							print "<li>".trim($va_group_user["fname"]." ".$va_group_user["lname"])."<br/><a href='mailto:".$va_group_user["email"]."'>".$va_group_user["email"]."</a></li>";
						}
						print "</ul>";
					}else{
						print _t("Group has no users");
					}
					print "</dd></dl>";
					print "</small></div><!-- end userGroup --></div><!-- end crListUserGroup -->";
				}
			}
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
					jQuery("#crSetContainer" + set_id).parent().remove();
					if (jQuery('.crSetContainer').length == 0) { jQuery('#crSetListPlaceholder').show(); } else { jQuery('#crSetListPlaceholder').hide(); }
					jQuery("#crSetListErrors").hide();
				} else {
					jQuery("#crSetListErrors").html(data.errors.join(';')).show();
				}
				jQuery('#confirm-delete').modal('hide');
			});
		
		});
	});
</script>