<?php
	$va_errors = $this->getVar("errors");
	$vn_num1 = rand(1,10);
	$vn_num2 = rand(1,10);
	$vn_sum = $vn_num1 + $vn_num2;
?>
<div class="row">
	<div class="col-lg-3"></div>
	<div class="col-lg-6">
		<h1><?php print _t("Contact the Museum"); ?></h1>
	</div>
	<div class="col-lg-3"></div>
</div><!-- end row -->
<?php
	if(sizeof($va_errors["display_errors"])){
		print "<div class='alert alert-danger'>".implode("<br/>", $va_errors["display_errors"])."</div>";
	}
?>
<form id="contactForm" action="<?php print caNavUrl($this->request, "", "Contact", "send"); ?>" role="form" method="post">
	<div class="row">
		<div class="col-lg-3"></div>
		<div class="col-lg-6">
			<div class="row">
				<div class="col-sm-4">
					<div class="form-group<?php print (($va_errors["name"]) ? " has-error" : ""); ?>">
						<label for="name">Name</label>
						<input type="text" class="form-control input-sm" id="email" placeholder="Enter name" name="name" value="{{{name}}}">
					</div>
				</div><!-- end col -->
				<div class="col-sm-4">
					<div class="form-group<?php print (($va_errors["email"]) ? " has-error" : ""); ?>">
						<label for="email">Email address</label>
						<input type="text" class="form-control input-sm" id="email" placeholder="Enter email" name="email" value="{{{email}}}">
					</div>
				</div><!-- end col -->
				<div class="col-sm-4">
					<div class="form-group<?php print (($va_errors["security"]) ? " has-error" : ""); ?>">
						<label for="security">Security Question</label>
						<div class='row'>
							<div class='col-sm-4'>
								<p class="form-control-static"><?php print $vn_num1; ?> + <?php print $vn_num2; ?> = </p>
							</div>
							<div class='col-sm-4'>
								<input name="security" value="" id="security" type="text" class="form-control input-sm" />
							</div>
						</div><!-- end row -->
					</div><!-- end form-group -->
				</div><!-- end col-sm-4 -->
			</div><!-- end row -->
		</div><!-- end col-lg-6 -->
		<div class="col-lg-3"></div>
	</div><!-- end row -->
	<div class="row">
		<div class="col-lg-3"></div>
		<div class="col-lg-6">
			<div class="form-group<?php print (($va_errors["message"]) ? " has-error" : ""); ?>">
				<label for="message">Message</label>
				<textarea class="form-control input-sm" id="message" name="message" rows="8">{{{message}}}</textarea>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-default">Send</button>
			</div><!-- end form-group -->
		</div><!-- end col -->
		<div class="col-lg-3"></div>
	</div><!-- end row -->

	<input type="hidden" name="sum" value="<?php print $vn_sum; ?>">
</form>