<?php
require_once(__CA_MODELS_DIR__."/ca_objects.php");
$va_errors = $this->getVar("errors");
$vn_num1 = rand(1,10);
$vn_num2 = rand(1,10);
$vn_sum = $vn_num1 + $vn_num2;

$vn_object_id = $this->request->getParameter("object_id", pString);
$t_object = new ca_objects($vn_object_id);
$vs_url = $this->request->config->get("site_host").caNavUrl($this->request, "Detail", "objects", $t_object->get("ca_objects.object_id"));

?>
<div id="askACurator"><div class='inside'>
<div class="row"><div class="col-sm-12">
	<a href='#' id='close' class='close'><i class='fa fa-close'></i></a>
	<H1><?php print _t("Ask a Curator"); ?></H1>
<?php
	if(is_array($va_errors) && is_array($va_errors["display_errors"]) && sizeof($va_errors["display_errors"])){
		print "<div class='alert alert-danger'>".implode("<br/>", $va_errors["display_errors"])."</div>";
	}
?>
	<form id="contactForm" action="<?php print caNavUrl($this->request, "", "Contact", "send"); ?>" role="form" method="post">
		<input type="hidden" name="csrfToken" value="<?php print caGenerateCSRFToken($this->request); ?>"/>
		<input type="hidden" name="itemId" value="<?php print $t_object->get("ca_objects.idno"); ?>">
		<input type="hidden" name="itemTitle" value="<?php print $t_object->get("ca_objects.preferred_labels.name"); ?>">
		<input type="hidden" name="itemURL" value="<?php print $vs_url; ?>">
		<input type="hidden" name="object_id" value="<?php print $vn_object_id; ?>">
		<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-sm-12">
<?php
					$vs_request = "";
					$vs_request.= $t_object->get('ca_objects.preferred_labels');
					if ($vn_idno = $t_object->get('ca_objects.idno')) {
						$vs_request.= ", ".$vn_idno;
					}
					if ($va_inst = $t_object->get('ca_entities.preferred_labels', array('restrictToTypes' => array('member_inst')))) {
						$vs_request.= "<p>".$va_inst."</p>";
					}
					print $vs_request."<hr>";
?>				
				</div>
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
					</div>
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
		<?php
	if(!$this->request->isLoggedIn() && defined("__CA_GOOGLE_RECAPTCHA_KEY__") && __CA_GOOGLE_RECAPTCHA_KEY__){
?>
		<script type="text/javascript">
			var gCaptchaRender = function(){
                grecaptcha.render('regCaptcha', {'sitekey': '<?= __CA_GOOGLE_RECAPTCHA_KEY__; ?>'});
        	};
		</script>
		<script src='https://www.google.com/recaptcha/api.js?onload=gCaptchaRender&render=explicit' async defer></script>
			<div class="row">
				<div class="col-sm-12 col-md-offset-1 col-md-10">
					<div class='form-group<?= (($va_errors["recaptcha"]) ? " has-error" : ""); ?>'>
						<div id="regCaptcha" class="col-sm-8 col-sm-offset-4"></div>
					</div>
				</div>
			</div><!-- end row -->
<?php
	}
?>
		<div class="form-group">
			<button type="submit" class="btn btn-default">Send</button>
		</div><!-- end form-group -->
		<input type="hidden" name="sum" value="<?php print $vn_sum; ?>">
	</form>
	
</div><!-- end col --></div><!-- end row -->
</div></div><!-- end askacurator -->