<?php
	$va_user_groups = $this->getVar("user_groups");
	$va_errors = $this->getVar("errors");
?>
<div id="caFormOverlay"><div class="pull-right pointer" onclick="caMediaPanel.hidePanel(); return false;"><span class="glyphicon glyphicon-remove-circle"></span></div>
<h2><?php print _t("Share Set"); ?></h2>
<?php
	if($va_errors["general"]){
		print "<div>".$va_errors["general"]."</div>";
	}
?>
	<form id="ShareSetForm" action="#">
<?php
		if(is_array($va_user_groups) && sizeof($va_user_groups)){
			if($va_errors["group_id"]){
				print "<div>".$va_errors["group_id"]."</div>\n";
			}
			print "<div><b>"._t("Group")."</b><br/><select name='group_id'>\n";
			print "<option value='0'>"._t("Select a user group")."</option>\n";
			foreach($va_user_groups as $va_user_group){
				print "<option value='".$va_user_group["group_id"]."'>".$va_user_group["name"]."</option>\n";
			}
			print "</select>\n";
		}
		if($va_errors["user"]){
			print "<div>".$va_errors["user"]."</div>\n";
		}
		print "<div><b>"._t("User (enter individual's email address)")."</b><br/><input type='text' name='user'></div>";
		if($va_errors["access"]){
			print "<div>".$va_errors["access"]."</div>\n";
		}
		print "<div><b>"._t("Access")."</b><br/><select name='access'>\n";
		print "<option value='1'>"._t("Can read")."</option>\n";
		print "<option value='2'>"._t("Can edit")."</option>\n";
		print "</select>\n";
?>
		<div>
			<input type="submit" value="Save">
		</div>
	</form>
</div>

<script type='text/javascript'>
	jQuery(document).ready(function() {
		jQuery('#ShareSetForm').submit(function(e){		
			jQuery('#caMediaPanelContentArea').load(
				'<?php print caNavUrl($this->request, '', 'Sets', 'saveShareSet', null); ?>',
				jQuery('#ShareSetForm').serialize()
			);
			e.preventDefault();
			return false;
		});
	});
</script>