<?php
	$va_errors = $this->getVar("errors");
	$vn_num1 = rand(1,10);
	$vn_num2 = rand(1,10);
	$vn_sum = $vn_num1 + $vn_num2;

	$pn_object_id = $this->request->getParameter("object_id", pInteger);
	if($pn_object_id){
		require_once(__CA_MODELS_DIR__."/ca_objects.php");
		$t_item = new ca_objects($pn_object_id);
		$vs_url = $this->request->config->get("site_host").caNavUrl($this->request, "Detail", "objects", $t_item->get("ca_objects.object_id"));
		$vs_name = $t_item->get("ca_objects.preferred_labels.name");
		$vs_idno = $t_item->get("ca_objects.idno");
	}
?>
<div class='containerWrapper'>
	<div class="row"><div class="col-sm-12">
		
		<div class="row"><div class="col-sm-12">
			<H1><?php print _t("Ask a Curator"); ?></H1>
		<?php
			if(is_array($va_errors) && sizeof($va_errors["display_errors"])){
				print "<div class='alert alert-danger'>".implode("<br/>", $va_errors["display_errors"])."</div>";
			}
		?>
			<form id="contactForm" action="<?php print caNavUrl($this->request, "", "Contact", "send"); ?>" role="form" method="post">
				<input type="hidden" name="crsfToken" value="<?php print caGenerateCSRFToken($this->request); ?>"/>
				<div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-sm-12">
							<h2>Do you have a question about this item or wish to request an image?<br/>
							Complete this form, and MNcollections staff will follow up with you by email.</h2>
							<br/>
							<p><b>Item title: </b><?php print $vs_name; ?>
							<br/><b>Regarding this URL: </b><a href="<?php print $vs_url; ?>" class="purpleLink"><?php print $vs_url; ?></a>
							</p>
							<input type="hidden" name="itemId" value="<?php print $vs_idno; ?>">
							<input type="hidden" name="itemTitle" value="<?php print $vs_name; ?>">
							<input type="hidden" name="itemURL" value="<?php print $vs_url; ?>">
							<input type="hidden" name="object_id" value="<?php print $pn_object_id; ?>">
				<hr/><br/><br/>
				
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4">
				
							<input style='display:none;' type="text" class="" id="item"  name="item" value="<?php print $vs_request; ?>">
							<div class="form-group<?php print (($va_errors["name"]) ? " has-error" : ""); ?>">
								<label for="name">Your Name</label>
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
								</div><!--end row-->
							</div>
						</div><!-- end col -->
					</div><!-- end row -->
					</div><!-- end col -->
				</div><!-- end row -->
				<div class="row">
					<div class="col-sm-8">
						<div class="form-group<?php print (($va_errors["message"]) ? " has-error" : ""); ?>">
							<label for="message">Question</label>
							<textarea class="form-control input-sm" id="message" name="message" rows="5">{{{message}}}</textarea>
						</div>
					</div><!-- end col -->
				</div><!-- end row -->
				<div class="form-group">
					<button type="submit" class="btn btn-default">Send</button>
				</div><!-- end form-group -->
				<input type="hidden" name="sum" value="<?php print $vn_sum; ?>">
			</form>
	
		
		
	</div><!-- end col --></div><!-- end row -->
</div>
