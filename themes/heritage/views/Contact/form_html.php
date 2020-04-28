<?php
	$va_errors = $this->getVar("errors");
	$vn_num1 = rand(1,10);
	$vn_num2 = rand(1,10);
	$vn_sum = $vn_num1 + $vn_num2;
?>
<div class="row"><div class="col-sm-10 col-sm-offset-1">
<H1><?php print _t("Contact the Archives"); ?></H1>
<p>We would love to hear from you.  Use this form to contact the archives about research requests, share information, or ask general questions.</p>
<p>For warranty information, or to purchase replacement parts/keys, please contact a <a href='https://www.steelcase.com/find-us/where-to-buy/dealers/location/40.7127837/-74.00594130000002/us/all/distance/New%20York%20City,%20NY/' target='_blank'>local authorized dealer</a>.</p>
<?php
	if(is_array($va_errors["display_errors"]) && sizeof($va_errors["display_errors"])){
		print "<div class='alert alert-danger'>".implode("<br/>", $va_errors["display_errors"])."</div>";
	}
?>
	<form id="contactForm" action="<?php print caNavUrl($this->request, "", "Contact", "send"); ?>" role="form" method="post">
	    <input type="hidden" name="crsfToken" value="<?php print caGenerateCSRFToken($this->request); ?>"/>
		<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-sm-4">
					<div class="form-group<?php print (($va_errors["firstname"]) ? " has-error" : ""); ?>">
						<label for="name">First Name</label>
						<input type="text" class="form-control input-sm" id="firstname" placeholder="Enter first name" name="firstname" value="{{{firstname}}}">
					</div>
				</div><!-- end col -->
				<div class="col-sm-4">
					<div class="form-group<?php print (($va_errors["lastname"]) ? " has-error" : ""); ?>">
						<label for="name">Last Name</label>
						<input type="text" class="form-control input-sm" id="email" placeholder="Enter last name" name="lastname" value="{{{lastname}}}">
					</div>
				</div><!-- end col -->
			</div>
			<div class="row">					
				<div class="col-sm-4">
					<div class="form-group<?php print (($va_errors["email"]) ? " has-error" : ""); ?>">
						<label for="email">Email address</label>
						<input type="text" class="form-control input-sm" id="email" placeholder="Enter email" name="email" value="{{{email}}}">
					</div>
				</div><!-- end col -->
				<div class="col-sm-4">
					<div class="form-group<?php print (($va_errors["phone"]) ? " has-error" : ""); ?>">
						<label for="email">Phone</label>
						<input type="text" class="form-control input-sm" id="phone" placeholder="Enter phone" name="phone" value="{{{phone}}}">
					</div>
				</div><!-- end col -->
			</div>
			<div class="row">
				<div class="col-sm-8">
					<div class="form-group<?php print (($va_errors["company"]) ? " has-error" : ""); ?>">
						<label for="email">Company</label>
						<input type="text" class="form-control input-sm" id="company" placeholder="Enter company name" name="company" value="{{{company}}}">
					</div>
				</div><!-- end col -->
			</div>
			<div class="row">					
				<div class="col-sm-4">
					<div class="form-group<?php print (($va_errors["country"]) ? " has-error" : ""); ?>">
						<label for="email">Country</label>
						<input type="text" class="form-control input-sm" id="email" placeholder="Enter country name" name="country" value="{{{country}}}">
					</div>
				</div><!-- end col -->
				<div class="col-sm-4">
					<div class="form-group<?php print (($va_errors["city"]) ? " has-error" : ""); ?>">
						<label for="email">City</label>
						<input type="text" class="form-control input-sm" id="city" placeholder="Enter city name" name="city" value="{{{city}}}">
					</div>
				</div><!-- end col -->
			</div>				
			<div class="row">			
				<div class="col-sm-12">
					<div class="form-group<?php print (($va_errors["security"]) ? " has-error" : ""); ?>">
						<label for="security">Security Question</label>
						<div class='row'>
							<div class='col-sm-4'>
								<p class="form-control-static"><?php print $vn_num1; ?> + <?php print $vn_num2; ?> = </p>
							</div>
							<div class='col-sm-4'>
								<input name="security" value="" id="security" type="text" class="form-control input-sm" />
							</div>
						</div><!--end col-sm-8-->	
						</div><!-- end row -->
					</div>
				</div><!-- end row -->
			</div><!-- end col -->
		</div><!-- end row -->
		<div class="row">
			<div class="col-sm-8">
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
		
		<div style="height:220px"></div>
	</form>
	
</div><!-- end col --></div><!-- end row -->