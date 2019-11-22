<?php
	$vn_label_col = 2;
	$vn_label_col_offset = 2;
	$vn_input_col = 4;
	if($this->request->isAjax()){
		$vn_label_col = 4;
		$vn_label_col_offset = 0;
		$vn_input_col = 7;
?>
		<div id="caFormOverlay"><div class="pull-right pointer" onclick="caMediaPanel.hidePanel(); return false;"><span class="glyphicon glyphicon-remove-circle"></span></div>
<?php
	}
?>
			<div class="row"><div class="col-sm-4 col-sm-offset-<?php print $vn_label_col + $vn_label_col_offset; ?>"><H1><?php print _t("Login"); ?></H1></div></div>
<?php
	if($this->getVar("message")){
		print "<div class='alert alert-danger'>".$this->getVar("message")."</div>";
	}
?>
			<form id="LoginForm" action="<?php print caNavUrl($this->request, "", "LoginReg", "login"); ?>" class="form-horizontal" role="form" method="POST">
				<div class="form-group">
					<label for="username" class="col-sm-<?php print $vn_label_col; ?> col-sm-offset-<?php print $vn_label_col_offset; ?> control-label"><?php print _t("Username"); ?></label>
					<div class="col-sm-<?php print $vn_input_col; ?>">
						<input type="text" class="form-control" id="username" name="username">
					</div><!-- end col-sm-5 -->
				</div><!-- end form-group -->
				<div class="form-group">
					<label for="password" class="col-sm-<?php print $vn_label_col; ?> col-sm-offset-<?php print $vn_label_col_offset; ?> control-label"><?php print _t("Password"); ?></label>
					<div class="col-sm-<?php print $vn_input_col; ?>">
						<input type="password" name="password" class="form-control" id="password" />
					</div><!-- end col-sm- -->
				</div><!-- end form-group -->
				<div class="form-group">
					<div class="col-sm-offset-<?php print $vn_label_col + $vn_label_col_offset; ?> col-sm-7">
						<button type="submit" class="btn btn-default">login</button>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-<?php print $vn_label_col + $vn_label_col_offset; ?> col-sm-7">
<?php
				if($this->request->isAjax()){
?>
					<!--<a href="#" onClick="jQuery('#caMediaPanelContentArea').load('<?php print caNavUrl($this->request, '', 'LoginReg', 'registerForm', null); ?>');"><?php print _t("Click here to register"); ?></a>-->
					<!--<a href="#" onClick="jQuery('#caMediaPanelContentArea').load('<?php print caNavUrl($this->request, '', 'LoginReg', 'resetForm', null); ?>');"><?php print _t("Forgot your password?"); ?></a>-->
<?php
				}else{
					#print caNavLink($this->request, _t("Click here to register"), "", "", "LoginReg", "registerForm", array());
					#print "<br/>".caNavLink($this->request, _t("Forgot your password?"), "", "", "LoginReg", "resetForm", array());
				}
?>
					</div>
				</div><!-- end form-group -->
			</form>

<?php
	if (!$this->request->isAjax()) {
?>
<div class="row">
<div class="col-md-4"> </div>
<!--<div class="col-md-4" style="font-size: 12px;">
<p>If you are experiencing trouble accessing art.steelcase.com please make sure to login with <strong>only your mailbox user name</strong> and not the domain name.</p>

<p>
Example: if your email address is <em>jdoe@steelcase.com</em> login with <strong>jdoe</strong>
</p>

<p>For further login assistance please send an email to <a href="mailto:art@steelcase.com">art@steelcase.com</a></p>
</div>-->
<div class="col-md-4"> </div>
</div>
<?php
	}
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
