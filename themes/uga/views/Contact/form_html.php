<?php
	$va_errors = $this->getVar("errors");
	$vn_num1 = rand(1,10);
	$vn_num2 = rand(1,10);
	$vn_sum = $vn_num1 + $vn_num2;
?>
<H1><?php print _t("Contact Us"); ?></H1>
<?php
	if(sizeof($va_errors["display_errors"])){
		print "<div class='alert alert-danger'>".implode("<br/>", $va_errors["display_errors"])."</div>";
	}
?>
	<form id="contactForm" action="<?php print caNavUrl($this->request, "", "Contact", "send"); ?>" role="form" method="post">
		<div class="row">
		<div class="col-md-9">
			<div class="row">
				<div class="col-sm-4">
				<div><p>If you have questions about a collection or comments about this website, please send us a message.</p></div>
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
<h1>Media Archives Staff</h1>
<div class="text">
<p>
<table border="1" bordercolor="#CCCCCC" cellpadding="8px">
<tr style="font-weight:bold; background-color:#CCC"><td>Name</td><td>Position</td><td>Phone</td><td>Email</td></tr>
<tr><td>Abolins, Ruta</td><td>Director</td><td>706-542-4757</td><td>abolins@uga.edu</td></tr>
<tr><td>Chicoine, Taylor</td><td>Audiovisual Technician</td><td>706-542-7123</td><td>taymc01@uga.edu</td></tr>
<tr><td><a href="http://www.libs.uga.edu/staffpages/compton.html">Compton, Margie</a></td><td>Media Archives Archivist</td><td>706-542-1971</td><td>margie@uga.edu</td></tr>
<tr><td>Holmes, Callie</td><td>Digital Archivist</td><td>706-542-4391</td><td>ceholmes@uga.edu</td></tr>
<tr><td>Lott, Chris</td><td>Archival Processing and Film Digitization Assistant</td><td>706-542-2757</td><td>chrislot@uga.edu</td></tr>
<tr><td><a href="http://www.libs.uga.edu/staffpages/miller.html">Miller, Mary</a></td><td>Peabody Awards Archivist</td><td>706-542-4789</td><td>mlmiller@uga.edu</td></tr>
<tr><td>Shedenhelm, Laura</td><td>Media Archives Cataloger</td><td>706-542-5803</td><td>shedenhe@uga.edu</td></tr>
<tr><td>Woodward, Scott</td><td>Audiovisual Technician</td><td>706-542-9815</td><td>scottwoo@uga.edu</td></tr>
</table>
</p>

</div><!--end text-->
		<input type="hidden" name="sum" value="<?php print $vn_sum; ?>">
	</form>
