<?php
	$va_errors = $this->getVar("errors");
	$vn_num1 = rand(1,10);
	$vn_num2 = rand(1,10);
	$vn_sum = $vn_num1 + $vn_num2;
?>
<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-10">
	
<H1><?php print _t("Contact Us"); ?></H1>


		<h2>Jacob’s Pillow Preservation Staff</h2><br/>
		
		<p>Norton Owen, Director of Preservation </p>
		<p><a href='mailto:nowen@jacobspillow.org'>nowen@jacobspillow.org</a></p>		
		<p>413.243.9919 ext. 150</p>
		<br>	
		
		<p>Brittany Austin, Librarian/Archives Specialist</p>
		<p><a href='mailto:baustin@jacobspillow.org'>baustin@jacobspillow.org</a></p>		
		<p>413.243.9919 ext. 154</p>
		<br>	
		
		<p>Nel Shelby, Videographer (summer only)</p>
		<p><a href='mailto:nshelby@jacobspillow.org'>nshelby@jacobspillow.org</a></p>		
		<br>	
		
		<h2>Ask an Archivist</h2>
		<p>Do you have a research question or general inquiry about our collection? We’d love to hear from you! Please fill out the following form, and we will get back with you as soon as possible.</p>
		<p>Your question or research request:</p>	


<?php
	if(sizeof($va_errors["display_errors"])){
		print "<div class='alert alert-danger'>".implode("<br/>", $va_errors["display_errors"])."</div>";
	}
?>
	<form id="contactForm" action="<?php print caNavUrl($this->request, "", "Contact", "send"); ?>" role="form" method="post">
		<div class="row">
		<div class="col-md-9">
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group<?php print (($va_errors["name"]) ? " has-error" : ""); ?>">
						<label for="name">Name</label>
						<input type="text" class="form-control input-sm" id="email" placeholder="Enter name" name="name" value="{{{name}}}">
					</div>
				</div><!-- end col -->
				<div class="col-sm-6">
					<div class="form-group<?php print (($va_errors["email"]) ? " has-error" : ""); ?>">
						<label for="email">Email address</label>
						<input type="text" class="form-control input-sm" id="email" placeholder="Enter email" name="email" value="{{{email}}}">
					</div>
				</div><!-- end col -->
				<div class="col-sm-6">
					<div class="form-group<?php print (($va_errors["phone"]) ? " has-error" : ""); ?>">
						<label for="email">Phone Number</label>
						<input type="text" class="form-control input-sm" id="email" placeholder="Enter phone number" name="phone" value="{{{phone}}}">
					</div>
				</div><!-- end col -->				
				<div class="col-sm-6">
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
	</form>
	
	
	</div>
	<div class="col-sm-1"></div>
</div>	