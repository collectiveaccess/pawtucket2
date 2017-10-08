<?php
	$va_errors = $this->getVar("errors");
	$vn_num1 = rand(1,10);
	$vn_num2 = rand(1,10);
	$vn_sum = $vn_num1 + $vn_num2;
	
	$vn_object_id = $this->request->getParameter("object_id", pString);
	$t_object = new ca_objects($vn_object_id);
	$t_parent = new ca_objects($t_object->get('ca_objects.parent.object_id'));
?>
<div class='libraryRequest'>
	<a href='#' id='close' class='close'><i class='fa fa-close'></i></a>
	<H1><?php print _t("Request").": ".$t_object->get('ca_objects.preferred_labels') ?></H1>

<?php
	if(sizeof($va_errors["display_errors"])){
		print "<div class='alert alert-danger'>".implode("<br/>", $va_errors["display_errors"])."</div>";
	}
?>
	<form id="contactForm" action="<?php print caNavUrl($this->request, "", "Contact", "sendLibraryRequest"); ?>" role="form" method="post">
	<div class="container">

			<div class="row">
				<div class="col-sm-4">
<?php
					$vs_request = "";
					$vs_request.= "<div class='requestInfo'><p>".$t_object->get('ca_objects.parent.preferred_labels')."</p>";
					$vs_request.= "<p>(".$t_object->get('ca_objects.preferred_labels').")</p>";
					$vs_request.= "<p>".$t_parent->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('author', 'contributor'), 'delimiter' => ', '))."</p>";
					$vs_request.= "<p>".$t_parent->get('ca_objects.MARC_pubPlace')."</p></div>";
					print $vs_request;
?>	
					<input style='display:none;' type="text" class="" id="item"  name="item" value="<?php print $vs_request; ?>">

			
				</div>
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
				
			</div><!-- end row -->
			<div class="row">
				<div class="col-sm-4">
					<div class="form-group<?php print (($va_errors["phone"]) ? " has-error" : ""); ?>">
						<label for="phone">Phone number</label>
						<input type="text" class="form-control input-sm" id="phone" placeholder="Enter phone number" name="phone" value="{{{phone}}}">
					</div>
				</div><!-- end col -->			
				<div class="col-sm-4">
					<div class="form-group<?php print (($va_errors["school_name"]) ? " has-error" : ""); ?>">
						<label for="school_name">School Name</label>
						<input type="text" class="form-control input-sm" id="school_name" placeholder="Enter school name" name="school_name" value="{{{school_name}}}">
					</div>
				</div><!-- end col -->
				<div class="col-sm-4">
					<div class="form-group<?php print (($va_errors["needed_by"]) ? " has-error" : ""); ?>">
						<label for="needed_by">Date Needed By</label>
						<input type="text" class="form-control input-sm" id="needed_by" placeholder="Enter date needed by" name="needed_by" value="{{{needed_by}}}">
					</div>
				</div><!-- end col -->				
			</div><!-- end row -->									
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
	</div><!-- end container -->
	</form>
</div>	