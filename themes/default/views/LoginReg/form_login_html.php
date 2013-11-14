<div id="caFormOverlay"><div class="close">&nbsp;</div>
<?php
	if($this->getVar("message")){
		print "<div>".$this->getVar("message")."</div>";
	}
?>
	<form id="LoginForm" action="#">
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
</div>

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