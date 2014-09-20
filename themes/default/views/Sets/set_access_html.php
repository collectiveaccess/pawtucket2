<?php
	$va_user_groups = $this->getVar("user_groups");
	$va_users = $this->getVar("users");
?>
<div id="caFormOverlay"><div class="pull-right pointer" onclick="caMediaPanel.hidePanel(); return false;"><span class="glyphicon glyphicon-remove-circle"></span></div>
<H1><?php print _t("Lightbox Access"); ?></H1>
<?php
	if($this->getVar("message")){
		print "<div class='alert alert-info'>".$this->getVar("message")."</div>";
	}
	if($this->getVar("errors")){
		print "<div class='alert alert-danger'>".$this->getVar("errors")."</div>";
	}
	if(sizeof($va_user_groups)){
		print "<H3>"._t("User Groups")."</H3>";
		print "<ul>";
		foreach($va_user_groups as $va_user_group){
			print "<li><div class='pull-right'><a href='#' onclick='jQuery(\"#editGroupAccess".$va_user_group["group_id"]."\").toggle(); return false;'><span class='glyphicon glyphicon-edit' title='"._t("change access")."'></span></a>&nbsp;&nbsp;&nbsp;<a href='#' onClick='jQuery(\"#caMediaPanelContentArea\").load(\"".caNavUrl($this->request, "", "Sets", "removeGroupAccess", array("group_id" => $va_user_group["group_id"]))."\"); return false;'><i class='fa fa-times' title='"._t("remove access")."'></i></a></div>";
			print $va_user_group["name"].", ".(($va_user_group["access"] == 2) ? _t("write access") : _t("read access"));
			print "<p id='editGroupAccess".$va_user_group["group_id"]."' style='display:none;'><a href='#' onClick='jQuery(\"#caMediaPanelContentArea\").load(\"".caNavUrl($this->request, "", "Sets", "editGroupAccess", array("access" => (($va_user_group["access"] == 2) ? 1 : 2), "group_id" => $va_user_group["group_id"]))."\"); return false;'><button type='button' class='btn btn-default btn-xs'>".(($va_user_group["access"] == 2) ? _t("Change to read access") : _t("Change to write access"))."</button></a></p>";
			print "</li>";
		}
		print "</ul>";
	}
	if(sizeof($va_users)){
		print "<H3>"._t("Users")."</H3>";
		print "<ul>";
		foreach($va_users as $va_user){
			print "<li>";
			if(!$va_user["owner"]){
				print "<div class='pull-right'><a href='#' onclick='jQuery(\"#editUserAccess".$va_user["user_id"]."\").toggle(); return false;'><span class='glyphicon glyphicon-edit' title='"._t("change access")."'></span></a>&nbsp;&nbsp;&nbsp;<a href='#' onClick='jQuery(\"#caMediaPanelContentArea\").load(\"".caNavUrl($this->request, "", "Sets", "removeUserAccess", array("user_id" => $va_user["user_id"]))."\"); return false;'><i class='fa fa-times' title='"._t("remove access")."'></i></a></div>";
			}
			print $va_user["name"]." (".$va_user["email"]."), ".(($va_user["access"] == 2) ? _t("write access") : _t("read access")).(($va_user["owner"]) ? ", <b>"._t("Owner")."</b>" : "");
			print "<p id='editUserAccess".$va_user["user_id"]."' style='display:none;'><a href='#' onClick='jQuery(\"#caMediaPanelContentArea\").load(\"".caNavUrl($this->request, "", "Sets", "editUserAccess", array("access" => (($va_user["access"] == 2) ? 1 : 2), "user_id" => $va_user["user_id"]))."\"); return false;'><button type='button' class='btn btn-default btn-xs'>".(($va_user["access"] == 2) ? _t("Change to read access") : _t("Change to write access"))."</button></a></p>";
			print "</li>";
		}
		print "</ul>";
	}
?>
</div>