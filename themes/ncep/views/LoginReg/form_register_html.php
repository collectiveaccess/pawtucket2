<?php
	$va_errors = $this->getVar("errors");
	$t_user = $this->getVar("t_user");
	if($this->request->isAjax()){
?>
<div id="caFormOverlay" class="regOverlay"><div class="pull-right pointer" onclick="caMediaPanel.hidePanel(); return false;"><span class="glyphicon glyphicon-remove-circle"></span></div>
<?php
	}
?>
<script type="text/javascript">
	// initialize CA Utils
	caUI.initUtils();

</script>
	<form id="RegForm" action="<?php print caNavUrl($this->request, "", "LoginReg", "register"); ?>" class="form-horizontal" role="form" method="POST">
	<div class="row"><div class="col-sm-4"><H1 style="background-color:transparent;"><?php print _t("Register"); ?></H1></div></div>
<?php
	if($va_errors["register"]){
		print "<div class='alert alert-danger'>".$va_errors["register"]."</div>";
	}
?>
		<div class="row" style="background-color:#FFF;"><div class="col-sm-6">
<?php
		foreach(array("fname", "lname", "email") as $vs_field){
			if($va_errors[$vs_field]){
				print "<div class='alert alert-danger'>".$va_errors[$vs_field]."</div>";
			}	
			print $t_user->htmlFormElement($vs_field,"<div class='form-group".(($va_errors[$vs_field]) ? " has-error" : "")."'><label for='".$vs_field."' class='col-sm-4 control-label'>^LABEL</label><div class='col-sm-7'>^ELEMENT</div><!-- end col-sm-7 --></div><!-- end form-group -->\n", array("classname" => "form-control"));
		}
		if($va_errors["security"]){
			print "<div class='alert alert-danger'>".$va_errors["security"]."</div>";
		}
		$vn_num1 = rand(1,10);
		$vn_num2 = rand(1,10);
		$vn_sum = $vn_num1 + $vn_num2;
?>
		<div class='form-group<?php print (($va_errors["security"]) ? " has-error" : ""); ?>'>
			<label for='security' class='col-sm-4 control-label'><?php print _t("Security question"); ?></label>
			<div class='col-sm-7'>
				<div class='col-sm-5'>
					<p class="form-control-static"><?php print $vn_num1; ?> + <?php print $vn_num2; ?> = </p>
				</div>
				<div class='col-sm-5'>
					<input name="security" value="" id="security" type="text" class="form-control" />
				</div>
			</div><!-- end col-sm-7 -->
		</div><!-- end form-group -->
<?php
		if($va_errors["password"]){
			print "<div class='alert alert-danger'>".$va_errors["password"]."</div>";
		}
		print $t_user->htmlFormElement("password","<div class='form-group".(($va_errors["password"]) ? " has-error" : "")."'><label for='password' class='col-sm-4 control-label'>^LABEL</label><div class='col-sm-7'>^ELEMENT</div><!-- end col-sm-7 --></div><!-- end form-group -->\n", array("classname" => "form-control"));
		
?>
		<div class="form-group<?php print (($va_errors["password"]) ? " has-error" : ""); ?>">
			<label for='password2' class='col-sm-4 control-label'><?php print _t('Re-type password'); ?></label>
			<div class="col-sm-7"><input type="password" name="password2" size="40" class="form-control" /></div><!-- end col-sm-7 -->
		</div><!-- end form-group -->
	</div><!-- end col -->
	<div class="col-sm-6">
<?php
		$va_profile_settings = $this->getVar("profile_settings");
		if(is_array($va_profile_settings) and sizeof($va_profile_settings)){
			foreach($va_profile_settings as $vs_field => $va_profile_element){
				if($va_errors[$vs_field]){
					print "<div class='alert alert-danger'>".$va_errors[$vs_field]."</div>";
				}
				print "<div class='form-group".(($va_errors[$vs_field]) ? " has-error" : "")."'>";
				print $va_profile_element["bs_formatted_element"];
				print "</div><!-- end form-group -->";
			}
		}
?>
	</div><!-- end col -->
</div><!-- end row -->
		<div class="form-group text-center">
			<button type="submit" class="btn btn-default">Register</button>
		</div><!-- end form-group -->
		<input type="hidden" name="sum" value="<?php print $vn_sum; ?>">
	</form>
<?php
	if($this->request->isAjax()){
?>
</div><!-- end caFormOverlay -->
<script type='text/javascript'>
	jQuery(document).ready(function() {
		jQuery('#RegForm').submit(function(e){		
			jQuery('#caMediaPanelContentArea').load(
				'<?php print caNavUrl($this->request, '', 'LoginReg', 'register', null); ?>',
				jQuery('#RegForm').serializeObject()
			);
			e.preventDefault();
			return false;
		});
	});
</script>
<?php
	}
?>