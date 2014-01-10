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
		print "<div class='alert alert-danger'>".$this->getVar("message")."</div>";
	}
?>
			<form id="LoginForm" action="<?php print caNavUrl($this->request, "", "LoginReg", "login"); ?>" class="form-horizontal" role="form">
				<div class="form-group">
					<label for="username" class="col-sm-4 control-label"><?php print _t("Username"); ?></label>
					<div class="col-sm-7">
						<input type="text" class="form-control" id="username" name="username">
					</div><!-- end col-sm-7 -->
				</div><!-- end form-group -->
				<div class="form-group">
					<label for="password" class="col-sm-4 control-label"><?php print _t("Password"); ?></label>
					<div class="col-sm-7">
						<input type="password" name="password" class="form-control" id="password" />
					</div><!-- end col-sm-7 -->
				</div><!-- end form-group -->
				<div class="form-group">
					<div class="col-sm-offset-4 col-sm-7">
						<button type="submit" class="btn btn-default">login</button>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-4 col-sm-7">
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
				</div><!-- end form-group -->
			</form>
<?php
	if($this->request->isAjax()){
?>
		</div><!-- end caFormOverlay -->
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