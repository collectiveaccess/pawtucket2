<?php
	$va_errors = $this->getVar("errors");
	$vn_num1 = rand(1,10);
	$vn_num2 = rand(1,10);
	$vn_sum = $vn_num1 + $vn_num2;
	
	$config = caGetContactConfig();
	
	# --- if a table has been passed this is coming from the Item Inquiry/Ask An Archivist contact form on detail pages
	$pn_id = $this->request->getParameter("id", pInteger);
	$ps_table = $this->request->getParameter("table", pString);
	
	if($pn_id && $ps_table){
		$t_item = Datamodel::getInstanceByTableName($ps_table);
		if($t_item){
			$t_item->load($pn_id);
			$vs_name = sefaFormatCaption($this->request, $t_item);
			$vs_page_title = ($config->get("item_inquiry_page_title")) ? $config->get("item_inquiry_page_title") : _t("Item Inquiry");
		}
	}

?>
<div class="row contentbody_sub aboutPages">
	<div class="col-sm-8">
		<h1><?php print $vs_page_title; ?></h1>
		<form id="contactForm" action="<?php print caNavUrl($this->request, "", "Contact", "send"); ?>" role="form" method="post">
<?php
	if($pn_id && $t_item->getPrimaryKey()){
?>
		{{{inquire_text}}}<br/><br/>
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-8 col-lg-offset-2 text-center">
				<?php print $t_item->get("ca_object_representations.media.small"); ?>
				<p class="caption text-center"><?php print $vs_name; ?></p>
				<input type="hidden" name="itemTitle" value="<?php print $vs_name; ?>">
				<input type="hidden" name="id" value="<?php print $pn_id; ?>">
				<input type="hidden" name="table" value="<?php print $ps_table; ?>">
			</div>
		</div>
<?php
	}else{
?>
		{{{contact_text}}}		
<?php	
	}
?>
	<br/><br/>
<?php
	if(is_array($va_errors) && is_array($va_errors["display_errors"]) && sizeof($va_errors["display_errors"])){
		print "<div class='alert alert-danger'>".implode("<br/>", $va_errors["display_errors"])."</div>";
	}
?>
		
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group<?php print (($va_errors["name"]) ? " has-error" : ""); ?>">
						<label for="name">Name</label>
						<input type="text" class="form-control input-sm" id="name" placeholder="Enter name" name="name" value="{{{name}}}">
					</div>
				</div><!-- end col -->
				<div class="col-sm-6">
					<div class="form-group<?php print (($va_errors["email"]) ? " has-error" : ""); ?>">
						<label for="email">Email address</label>
						<input type="text" class="form-control input-sm" id="email" placeholder="Enter email" name="email" value="{{{email}}}">
					</div>
				</div><!-- end col -->
			</div><!-- end row -->
<?php
	if($config->get("check_security")){
?>
			<div class="row">
				<div class="col-sm-4">
					<div class="form-group<?php print (($va_errors["security"]) ? " has-error" : ""); ?>">
						<label for="security">Security Question</label>
						<div class='row'>
							<div class='col-sm-6'>
								<p class="form-control-static"><?php print $vn_num1; ?> + <?php print $vn_num2; ?> = </p>
							</div>
							<div class='col-sm-4'>
								<input name="security" value="" id="security" type="text" class="form-control input-sm" />
							</div>
						</div><!-- end row -->
					</div>
				</div>
			</div><!-- end row -->
<?php
	}
?>
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group<?php print (($va_errors["message"]) ? " has-error" : ""); ?>">
						<label for="message">Message</label>
						<textarea class="form-control input-sm" id="message" name="message" rows="5">{{{message}}}</textarea>
					</div>
				</div><!-- end col -->
			</div><!-- end row -->
<?php
        if(!$this->request->isLoggedIn() && defined("__CA_GOOGLE_RECAPTCHA_KEY__") && __CA_GOOGLE_RECAPTCHA_KEY__){
?>
                <script type="text/javascript">
                        var gCaptchaRender = function(){
                grecaptcha.render('regCaptcha', {'sitekey': '<?php print __CA_GOOGLE_RECAPTCHA_KEY__; ?>'});
                };
                </script>
                <script src='https://www.google.com/recaptcha/api.js?onload=gCaptchaRender&render=explicit' async defer></script>


                        <div class="row">
                                <div class="col-sm-12">
                                        <div class='form-group<?php print (($va_errors["recaptcha"]) ? " has-error" : ""); ?>'>
                                                <div id="regCaptcha"></div>
                                        </div>
                                </div>
                        </div><!-- end row -->
<?php
        }
?>

			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<button type="submit" class="btn btn-default">Send</button>
					</div><!-- end form-group -->
					<input type="hidden" name="sum" value="<?php print $vn_sum; ?>">
				</div>
			</div>
		</form>
	</div>	
	<div class="col-sm-4 col-md-3 col-md-offset-1">
	 	<div class="thumbnail">
	 		<?php print caGetThemeGraphic($this->request, 'SEFA-StorefrontNYC-sm.jpg', array('alt' => 'Exterior of Susan Eley Fine Art, NYC')); ?>
	 		<small>NYC</small>
	 	</div>
	 	<div class="thumbnail">
	 		<?php print caGetThemeGraphic($this->request, 'SEFA-HUDSON-vert.jpg', array('alt' => 'Exterior of Susan Eley Fine Art Hudson NY')); ?>
	 		<small>Hudson, NY</small>
	 	</div>
	</div>
</div>
