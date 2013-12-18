<?php
	if($this->request->isAjax()){
?>
		<div id="caFormOverlay"><div class="pull-right pointer" onclick="caMediaPanel.hidePanel(); return false;"><span class="glyphicon glyphicon-remove-circle"></span></div>
<?php
	}
?>
			<H2><?php print _t("Login"); ?></H2>
<?php
	if($this->getVar("message")){
		print "<div>".$this->getVar("message")."</div>";
	}
?>
			<form id="LoginForm" action="<?php print caNavUrl($this->request, "", "LoginReg", "login"); ?>">
				<div>
					<b><?php print _t("Username"); ?></b><br/>
					<input type="text" name="username" />
				</div>
				<div>
					<b><?php print _t("Password"); ?></b><br/>
					<input type="password" name="password" />
					<input type="submit" value="login">
				</div>
			</form>
			<div>
<?php
		if($this->request->isAjax()){
?>
			<a href="#" onClick="jQuery('#caMediaPanelContentArea').load('<?php print caNavUrl($this->request, '', 'LoginReg', 'registerForm', null); ?>');"><?php print _t("Click here to register"); ?></a>
<?php
		}else{
			print caNavLink($this->request, _t("Click here to register"), "", "", "LoginReg", "registerForm", array());
		}
?>
			</div>
	</div><!-- end caFormOverlay -->
<?php
	if($this->request->isAjax()){
?>
<script type='text/javascript'>
	jQuery(document).ready(function() {
		jQuery('#LoginForm').submit(function(e){		
			jQuery('#caMediaPanelContentArea').load(
				'<?php print caNavUrl($this->request, '', 'LoginReg', 'login', null); ?>',
				jQuery('#LoginForm').serialize()
			);
			e.preventDefault();
			return false;
		});
	});
</script>
<?php
	}
?>