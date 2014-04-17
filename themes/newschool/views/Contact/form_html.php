<?php
	$va_errors = $this->getVar("errors");
?>
<H1><?php print _t("Contact"); ?></H1>
<?php
	if(sizeof($va_errors["display_errors"])){
		print "<div class='alert alert-danger'>".implode("<br/>", $va_errors["display_errors"])."</div>";
	}
?>
	<form id="contactForm" action="<?php print caNavUrl($this->request, "", "Contact", "send"); ?>" role="form" method="post">
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
				<div class="form-group<?php print (($va_errors["phone"]) ? " has-error" : ""); ?>">
					<label for="phone">Phone number</label>
					<input type="text" class="form-control input-sm" id="phone" placeholder="Enter phone" name="phone" value="{{{phone}}}">
				</div>
			</div><!-- end col -->
		</div><!-- end row -->
<?php
		$vn_num1 = rand(1,10);
		$vn_num2 = rand(1,10);
		$vn_sum = $vn_num1 + $vn_num2;
?>
		<div class="row">
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
				</div>
			</div><!-- end col -->
			<div class="col-sm-4">
				<div class="form-group<?php print (($va_errors["affiliation"]) ? " has-error" : ""); ?>">
					<label for="affiliation">Affiliation</label>
					<select class="form-control input-sm" id="affiliation" name="affiliation">
						<option value="New School Staff">New School</option>
						<option value="Other">Other</option>
					</select>
				</div>
			</div><!-- end col -->
			<div class="col-sm-4">
				<div class="form-group<?php print (($va_errors["inquiry_type"]) ? " has-error" : ""); ?>">
					<label for="inquiry_type">Inquiry Type</label>
					<select class="form-control input-sm" id="inquiry_type" name="inquiry_type">
						<option value="Schedule appointment">Schedule appointments</option>
						<option value="Research request">Research request</option>
						<option value="Feedback">Feedback</option>
						<option value="Message">Message</option>
					</select>
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
		<input type="hidden" name="sum" value="<?php print $vn_sum; ?>">
	</form>