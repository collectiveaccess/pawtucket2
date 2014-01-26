<?php
	$t_item = $this->getVar("t_item");
	# --- if there were errors in the form, the form params are passed back to preload the form
	$vs_to_email = $this->getVar("to_email");
	$vs_from_email = $this->getVar("from_email");
	$vs_from_name = $this->getVar("from_name");
	$vs_subject = $this->getVar("subject");
	$vs_message = $this->getVar("message");
	
	# --- if params have not been passed, set some defaults
	if(!$vs_subject && !$va_errors['subject']){
		$vs_subject = $t_item->getLabelForDisplay();
	}
	if(!$vs_from_email && $this->request->isLoggedIn() && !$va_errors['from_email']){
		$vs_from_email = $this->request->user->get("email");
	}	
	if(!$vs_from_name && $this->request->isLoggedIn() && !$va_errors['from_name']){
		$vs_from_name = $this->request->user->getName();
	}
	$va_errors = $this->getVar("errors");
?>
<div id="caFormOverlay"><div class="pull-right pointer" onclick="caMediaPanel.hidePanel(); return false;"><span class="glyphicon glyphicon-remove-circle"></span></div>
<h2><?php print _t("Share this item"); ?></h2>
<?php
	if($va_errors["general"]){
		print "<div class='alert alert-danger'>".$va_errors["general"]."</div>";
	}
?>
	<form method="post" id="shareForm" action="#" class="form-horizontal" role="form" enctype="multipart/form-data">
<?php
		if($va_errors["to_email"]){
			print "<div class='alert alert-danger'>".$va_errors["to_email"]."</div>";
		}
		print "<div class='form-group".(($va_errors["to_email"]) ? " has-error" : "")."'><label for='to_email' class='col-sm-4 control-label'>"._t("To e-mail address")."</label><div class='col-sm-7'><input type='text' name='to_email' id='to_email' value='".$vs_to_email."' class='form-control' placeholder='"._t("Enter multiple addresses separated by commas")."'></div><!-- end col-sm-7 --></div><!-- end form-group -->\n";
		if($va_errors["from_name"]){
			print "<div class='alert alert-danger'>".$va_errors["from_name"]."</div>";
		}
		print "<div class='form-group".(($va_errors["from_name"]) ? " has-error" : "")."'><label for='from_name' class='col-sm-4 control-label'>"._t("Your name")."</label><div class='col-sm-7'><input type='text' name='from_name' id='from_name' value='".$vs_from_name."' class='form-control'></div><!-- end col-sm-7 --></div><!-- end form-group -->\n";
		if($va_errors["from_email"]){
			print "<div class='alert alert-danger'>".$va_errors["from_email"]."</div>";
		}
		print "<div class='form-group".(($va_errors["from_email"]) ? " has-error" : "")."'><label for='from_email' class='col-sm-4 control-label'>"._t("Your email address")."</label><div class='col-sm-7'><input type='text' name='from_email' id='from_email' value='".$vs_from_email."' class='form-control'></div><!-- end col-sm-7 --></div><!-- end form-group -->\n";
		if(!$this->request->isLoggedIn()){				
			$vn_num1 = rand(1,10);
			$vn_num2 = rand(1,10);
			$vn_sum = $vn_num1 + $vn_num2;
			if($va_errors["security"]){
				print "<div class='alert alert-danger'>".$va_errors["security"]."</div>";
			}
?>
			<div class='form-group<?php print (($va_errors["security"]) ? " has-error" : ""); ?>'>
				<label for='security' class='col-sm-4 control-label'><?php print _t("Security Question"); ?></label>
				<div class='col-sm-7'>
					<div class='col-sm-5'>
						<p class="form-control-static"><?php print $vn_num1; ?> + <?php print $vn_num2; ?> = </p>
					</div>
					<div class='col-sm-4'>
						<input name="security" value="" id="security" type="text" class="form-control" />
					</div>
				</div><!-- end col-sm-7 -->
			</div><!-- end form-group -->
			<input type="hidden" name="sum" value="<?php print $vn_sum; ?>">
<?php
		}
		if($va_errors["subject"]){
			print "<div class='alert alert-danger'>".$va_errors["subject"]."</div>";
		}
		print "<div class='form-group".(($va_errors["subject"]) ? " has-error" : "")."'><label for='subject' class='col-sm-4 control-label'>"._t("Subject")."</label><div class='col-sm-7'><input type='text' name='subject' id='subject' value='".$vs_subject."' class='form-control'></div><!-- end col-sm-7 --></div><!-- end form-group -->\n";
		if($va_errors["message"]){
			print "<div class='alert alert-danger'>".$va_errors["message"]."</div>";
		}
		print "<div class='form-group".(($va_errors["message"]) ? " has-error" : "")."'><label for='message' class='col-sm-4 control-label'>"._t("Message")."</label><div class='col-sm-7'><textarea name='message' id='message' class='form-control' rows='3'>".$vs_message."</textarea></div><!-- end col-sm-7 --></div><!-- end form-group -->\n";
?>
		<div class="form-group">
			<div class="col-sm-offset-4 col-sm-7">
				<button type="submit" class="btn btn-default">Share</button>
			</div><!-- end col-sm-7 -->
		</div><!-- end form-group -->
		<input type="hidden" name="item_id" value="<?php print $this->getVar("item_id"); ?>">
		<input type="hidden" name="tablename" value="<?php print $this->getVar("tablename"); ?>">
	</form>
</div>

<script type='text/javascript'>
	jQuery(document).ready(function() {
		jQuery('#shareForm').submit(function(e){		
			jQuery('#caMediaPanelContentArea').load(
				'<?php print caNavUrl($this->request, '', 'Detail', 'sendShare'); ?>',
				jQuery('#shareForm').serialize()
			);
			e.preventDefault();
			return false;
		});
	});
</script>