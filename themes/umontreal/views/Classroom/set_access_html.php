<?php
/** ---------------------------------------------------------------------
 * themes/default/Lightbox/set_access_html.php :
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
	$va_users = $this->getVar("users");
	$o_classroom_config 				= $this->getVar("classroom_config");
	$vs_classroom_displayname 			= $this->getVar("classroom_display_name");
	$vs_classroom_displayname_plural 	= $this->getVar("classroom_display_name_plural");
	$vs_classroom_section_heading		= $this->getVar("classroom_section_heading");
?>
<div id="caFormOverlay"><div class="pull-right pointer" onclick="caMediaPanel.hidePanel(); return false;"><span class="glyphicon glyphicon-remove-circle"></span></div>
<H1><?php print _t("%1 Access", ucfirst($vs_classroom_displayname)); ?></H1>
<?php
	if($this->getVar("message")){
		print "<div class='alert alert-info'>".$this->getVar("message")."</div>";
	}
	if($this->getVar("errors")){
		print "<div class='alert alert-danger'>".$this->getVar("errors")."</div>";
	}
	if(sizeof($va_user_groups)){
		print "<H3>"._t("Groups")."</H3>";
		print "<ul>";
		foreach($va_user_groups as $va_user_group){
			print "<li><div class='pull-right'><a href='#' onClick='jQuery(\"#caMediaPanelContentArea\").load(\"".caNavUrl($this->request, "", "Lightbox", "removeGroupAccess", array("group_id" => $va_user_group["group_id"]))."\"); return false;'><i class='fa fa-times' title='"._t("remove access")."'></i></a></div>";
			print $va_user_group["name"]."</li>";
		}
		print "</ul>";
	}
	if(sizeof($va_users)){
		print "<H3>"._t("Users")."</H3>";
		print "<ul>";
		foreach($va_users as $va_user){
			print "<li>";
			if(!$va_user["owner"]){
				print "<div class='pull-right'><a href='#' onClick='jQuery(\"#caMediaPanelContentArea\").load(\"".caNavUrl($this->request, "", "Lightbox", "removeUserAccess", array("user_id" => $va_user["user_id"]))."\"); return false;'><i class='fa fa-times' title='"._t("remove access")."'></i></a></div>";
			}
			print $va_user["name"]." (".$va_user["email"].")".(($va_user["owner"]) ? ", <b>"._t("Owner")."</b>" : "");
			print "</li>";
		}
		print "</ul>";
	}
?>
</div>