<?php
/** ---------------------------------------------------------------------
 * themes/default/Lightbox/user_group_list_html.php :
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
	$va_user_groups = $this->getVar("user_groups");
	$t_user_group = new ca_user_groups();
?>
<div id="caFormOverlay"><div class="pull-right pointer" onclick="caMediaPanel.hidePanel(); return false;"><span class="glyphicon glyphicon-remove-circle"></span></div>
<H1><?php print _t("Your User Groups"); ?></H1>
<?php
	if(sizeof($va_user_groups)){
		foreach($va_user_groups as $va_user_group){
			$t_user_group->load($va_user_group["group_id"]);
			print "<div><a href='#' onClick='$(\"#userGroup".$va_user_group["group_id"]."\").slideToggle();'><div class='pull-right'><span class='glyphicon glyphicon-expand'></span></div>".$va_user_group["name"]."</a></div>";
			print "<div id='userGroup".$va_user_group["group_id"]."' style='display:none; padding-left:20px;'>";
			print '<dl>';
			if($va_user_group["description"]){
				print "<dt>"._t("Description")."</dt><dd>".$va_user_group["description"]."</dd>";
			}
			print "<dt>"._t("Url to join group")."</dt><dd>".$this->request->config->get('site_hostname').caNavUrl($this->request, "", "LoginReg", "joinGroup", array("group_id" => $va_user_group["group_id"]))."</dd>";
			$va_group_users = $t_user_group->getGroupUsers();
			print "<dt>"._t("Users")."</dt><dd>";
			if(is_array($va_group_users) && sizeof($va_group_users)){
				foreach($va_group_users as $va_group_user){
					print trim($va_group_user["fname"]." ".$va_group_user["lname"]).", <a href='mailto:".$va_group_user["email"]."'>".$va_group_user["email"]."</a><br/>";
				}
			}else{
				print _t("Group has no users");
			}
			print "</dd></dl>";
			print "</div><!-- end userGroup -->";
		}
	}else{
		print _t("You have made no user groups");
	}
?>