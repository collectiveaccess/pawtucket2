<?php
	$va_errors = $this->getVar("errors");
	$t_user = $this->getVar("t_user");
	if($this->request->isAjax()){
?>
<div id="caFormOverlay"><div class="pull-right pointer" onclick="caMediaPanel.hidePanel(); return false;"><span class="glyphicon glyphicon-remove-circle"></span></div>
<?php
	}
?>
<script type="text/javascript">
	// initialize CA Utils
	caUI.initUtils();

</script>
<div class="row"><div class="col-sm-4"><H1<?php print (!$this->request->isAjax()) ? ' class="text-right"' : ''; ?>><?php print _t("Profile"); ?></H1></div></div>

<?php
	if($va_errors["general"]){
		print "<div class='alert alert-danger'>".$va_errors["general"]."</div>";
	}
?>
	<form id="ProfileForm" action="<?php print caNavUrl($this->request, "", "LoginReg", "profileSave"); ?>" class="form-horizontal" role="form" method="POST">
<?php
		if($t_user->getPreference("user_profile_classroom_role") == "STUDENT"){
			print "<div class='row'><div class='col-sm-8 col-sm-offset-4'><b>You are registered as a student.</b>  You will not be able to download some materials geared towards educators.  If you are an educator please contact <a href='mailto:ncep@amnh.org'>ncep@amnh.org</a> to have your account status changed.<br/><br/></div></div>";
		}else{
			print "<div class='row'><div class='col-sm-8 col-sm-offset-4'><b>You are registered as an educator.</b>  As such you have full access to download all materials on this site.<br/><br/></div></div>";
		}
		foreach(array("fname", "lname", "email") as $vs_field){
			if($va_errors[$vs_field]){
				print "<div class='alert alert-danger'>".$va_errors[$vs_field]."</div>";
			}	
			print $t_user->htmlFormElement($vs_field,"<div class='form-group".(($va_errors[$vs_field]) ? " has-error" : "")."'><label for='".$vs_field."' class='col-sm-4 control-label'>^LABEL</label><div class='col-sm-7'>^ELEMENT</div><!-- end col-sm-7 --></div><!-- end form-group -->\n", array("classname" => "form-control"));
		}
		$va_profile_settings = $this->getVar("profile_settings");
		if(is_array($va_profile_settings) and sizeof($va_profile_settings)){
			foreach($va_profile_settings as $vs_field => $va_profile_element){
				if($vs_field == "user_profile_classroom_role"){
					print "<input type='hidden' name='pref_user_profile_classroom_role' value='".$t_user->getPreference("user_profile_classroom_role")."'>";
				}else{
					if($va_errors[$vs_field]){
						print "<div class='alert alert-danger'>".$va_errors[$vs_field]."</div>";
					}
					print "<div class='form-group".(($va_errors[$vs_field]) ? " has-error" : "")."'>";
					print $va_profile_element["bs_formatted_element"];
					print "</div><!-- end form-group -->";
				}
			}
		}
?>
		<div class="form-group<?php print (($va_errors["password"]) ? " has-error" : ""); ?>">
			<label for='password' class='col-sm-4 control-label'><?php print _t('Reset Password'); ?></label>
			<div class="col-sm-7"><p class="help-block"><?php print _t("Only enter if you would like to change your current password"); ?></p><input type="password" name="password" size="40" class="form-control" /></div><!-- end col-sm-7 -->
		</div><!-- end form-group -->
		<div class="form-group<?php print (($va_errors["password"]) ? " has-error" : ""); ?>">
			<label for='password2' class='col-sm-4 control-label'><?php print _t('Re-Type password'); ?></label>
			<div class="col-sm-7"><input type="password" name="password2" size="40" class="form-control" /></div><!-- end col-sm-7 -->
		</div><!-- end form-group -->
		<div class="form-group">
			<div class="col-sm-offset-4 col-sm-7">
				<button type="submit" class="btn btn-default">Save</button>
			</div><!-- end col-sm-7 -->
		</div><!-- end form-group -->
		<input type="hidden" name="sum" value="<?php print $vn_sum; ?>">
	</form>
<?php
	if($this->request->isAjax()){
?>
</div><!-- end caFormOverlay -->
<script type='text/javascript'>
	jQuery(document).ready(function() {
		jQuery('#ProfileForm').submit(function(e){		
			jQuery('#caMediaPanelContentArea').load(
				'<?php print caNavUrl($this->request, '', 'LoginReg', 'profileSave', null); ?>',
				jQuery('#ProfileForm').serialize()
			);
			e.preventDefault();
			return false;
		});
	});
</script>
<?php
	}
?>