<?php
	$va_errors = $this->getVar("errors");
?>
<div id="caFormOverlay"><div class="close" onclick="caMediaPanel.hidePanel(); return false;">&nbsp;</div>
<?php
	if($va_errors["register"]){
		print "<div>".$va_errors["register"]."</div>";
	}
?>
	<form id="RegForm" action="#">
<?php
		foreach(array("fname", "lname", "email") as $vs_field){
			if($va_errors[$vs_field]){
				print "<div>".$va_errors[$vs_field]."</div>";
			}
			print $this->getVar($vs_field);
		}
		$va_profile_settings = $this->getVar("profile_settings");
		if(is_array($va_profile_settings) and sizeof($va_profile_settings)){
			foreach($va_profile_settings as $vs_field => $va_profile_element){
				if($va_errors[$vs_field]){
					print "<div>".$va_errors[$vs_field]."</div>";
				}
				print $vs_profile_element["formatted_element"];
			}
		}
		if($va_errors["security"]){
			print "<div>".$va_errors["security"]."</div>";
		}
		$vn_num1 = rand(1,10);
		$vn_num2 = rand(1,10);
		$vn_sum = $vn_num1 + $vn_num2;
?>
		<div>
			<b><?php print _t("Security Question (to prevent SPAMbots)"); ?></b><br/>
			<span id="securityText"><?php print $vn_num1; ?> + <?php print $vn_num2; ?> = </span><input name="security" value="" id="security" type="text" size="3" />
		</div>
<?php
		if($va_errors["password"]){
			print "<div>".$va_errors["password"]."</div>";
		}
		print $this->getVar("password");
?>
		<div>
			<b><?php print _t('Re-Type password'); ?></b><br/><input type="password" name="password2" size="40" />
		</div>
		<div>
			<input type="submit" value="Register">
		</div>
		<input type="hidden" name="sum" value="<?php print $vn_sum; ?>">
	</form>
</div>

<script type='text/javascript'>
	jQuery(document).ready(function() {
		jQuery('#RegForm').submit(function(e){		
			jQuery('#caMediaPanelContentArea').load(
				'<?php print caNavUrl($this->request, '', 'LoginReg', 'register', null); ?>',
				jQuery('#RegForm').serialize()
			);
			e.preventDefault();
			return false;
		});
	});
</script>