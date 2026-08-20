<?php
	$va_errors = $this->getVar("errors");
	$vn_num1 = rand(1,10);
	$vn_num2 = rand(1,10);
	$vn_sum = $vn_num1 + $vn_num2;
	$vs_name = $this->getVar("name");
	if(!$vs_name){
		$vs_name = trim($this->request->user->get("fname")." ".$this->request->user->get("lname"));
	}
	$vs_email = $this->getVar("email");
	if(!$vs_email){
		$vs_email = $this->request->user->get("email");
	}
	
	$vn_col = 4;
	if($this->request->isAjax()){
		$vn_col = 12;
?>
		<div id="caFormOverlay"><div class="pull-right pointer" onclick="caMediaPanel.hidePanel(); return false;"><span class="glyphicon glyphicon-remove-circle"></span></div>
<?php
	}
?>
<H1><?php print _t("Contact"); ?></H1>
<?php
	if(sizeof($va_errors["display_errors"])){
		print "<div class='alert alert-danger'>".implode("<br/>", $va_errors["display_errors"])."</div>";
	}
?>
	<form id="contactForm" action="<?php print caNavUrl($this->request, "", "Contact", "send"); ?>" role="form" method="post">

			<div class="row">
				<div class="col-sm-<?php print $vn_col; ?>">
					<div class="form-group<?php print (($va_errors["name"]) ? " has-error" : ""); ?>">
						<label for="name">Name</label>
						<input type="text" class="form-control input-sm" id="email" placeholder="Enter name" name="name" value="<?php print $vs_name; ?>">
					</div>
				</div><!-- end col -->
				<div class="col-sm-<?php print $vn_col; ?>">
					<div class="form-group<?php print (($va_errors["email"]) ? " has-error" : ""); ?>">
						<label for="email">Email address</label>
						<input type="text" class="form-control input-sm" id="email" placeholder="Enter email" name="email" value="<?php print $vs_email; ?>">
					</div>
				</div><!-- end col -->
				<div class="col-sm-<?php print $vn_col; ?>">
					<div class="form-group<?php print (($va_errors["email"]) ? " has-error" : ""); ?>">
						<label for="email">Inquiry type</label>
						<input type="text" class="form-control input-sm" id="type" placeholder="Artwork Request, Feedback, Other" name="type" value="{{{type}}}">
					</div>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group<?php print (($va_errors["message"]) ? " has-error" : ""); ?>">
						<label for="message">Message</label>
						<textarea class="form-control input-sm" id="message" name="message" rows="5">{{{message}}}</textarea>
					</div>
				</div><!-- end col -->
			</div><!-- end row -->
		<div class="form-group">
			<button type="submit" class="btn btn-default">Send</button>
		</div><!-- end form-group -->
	</form>
	
<?php
	if($this->request->isAjax()){
?>
		</div><!-- end caFormOverlay -->
<script type='text/javascript'>
	jQuery(document).ready(function() {
		jQuery('#contactForm').submit(function(e){		
			jQuery('#caMediaPanelContentArea').load(
				'<?php print caNavUrl($this->request, '', 'Contact', 'send', null); ?>',
				jQuery('#contactForm').serialize()
			);
			e.preventDefault();
			return false;
		});
	});
</script>
<?php
	}
?>