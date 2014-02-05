<?php
	$va_user_groups = $this->getVar("user_groups");
	$va_errors = $this->getVar("errors");
?>
<div id="caFormOverlay"><div class="pull-right pointer" onclick="caMediaPanel.hidePanel(); return false;"><span class="glyphicon glyphicon-remove-circle"></span></div>
<h2><?php print _t("Share Set"); ?></h2>
<?php
	if($va_errors["general"]){
		print "<div class='alert alert-danger'>".$va_errors["general"]."</div>";
	}
?>
	<form id="ShareSetForm" action="#" class="form-horizontal" role="form">
<?php
		if(is_array($va_user_groups) && sizeof($va_user_groups)){
			if($va_errors["group_id"]){
				print "<div class='alert alert-danger'>".$va_errors["group_id"]."</div>\n";
			}
			print "<div class='form-group".(($va_errors["group_id"]) ? " has-error" : "")."'><label for='group_id' class='col-sm-4 control-label'>"._t("Group")."</label><div class='col-sm-7'><select name='group_id' class='form-control'>\n";
			print "<option value='0'>"._t("Select a user group")."</option>\n";
			foreach($va_user_groups as $va_user_group){
				print "<option value='".$va_user_group["group_id"]."'>".$va_user_group["name"]."</option>\n";
			}
			print "</select>\n";
			print "</div><!-- end col-sm-7 --></div><!-- end form-group -->\n";
		}
		if($va_errors["user"]){
			print "<div class='alert alert-danger'>".$va_errors["user"]."</div>\n";
		}
		print "<div class='form-group".(($va_errors["user"]) ? " has-error" : "")."'><label for='user' class='col-sm-4 control-label'>"._t("User")."</label><div class='col-sm-7'><input type='text' name='user' class='form-control' placeholder=\"enter user's email address\"></div><!-- end col-sm-7 --></div><!-- end form-group -->\n";
		if($va_errors["access"]){
			print "<div class='alert alert-danger'>".$va_errors["access"]."</div>\n";
		}
		print "<div class='form-group".(($va_errors["access"]) ? " has-error" : "")."'><label for='access' class='col-sm-4 control-label'>"._t("Access")."</label><div class='col-sm-7'><select name='access' class='form-control'>\n";
		print "<option value='1'>"._t("Can read")."</option>\n";
		print "<option value='2'>"._t("Can edit")."</option>\n";
		print "</select>\n";
		print "</div><!-- end col-sm-7 --></div><!-- end form-group -->\n";
?>
		<div class="form-group">
			<div class="col-sm-offset-4 col-sm-7">
				<button type="submit" class="btn btn-default">Save</button>
			</div><!-- end col-sm-7 -->
		</div><!-- end form-group -->
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