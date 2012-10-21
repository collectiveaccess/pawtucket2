<?php
	
	JavascriptLoadManager::register('hierBrowser');
	
	$vn_object_id = $this->getVar("object_id");
	$t_object = $this->getVar("t_object");
	$va_access_values = $this->getVar("access_values");
	$va_reps = $t_object->getPrimaryRepresentation(array('small'), null, array('return_with_access' => $va_access_values));
	$vs_image = "";
	if(is_array($va_reps) && sizeof($va_reps)){
		$vs_image = $va_reps["tags"]["small"];
	}
	$va_errors = $this->getVar("errors");
	
	# --- if there were errors in the form, the form paramas are passed back to preload the form
	$vs_to_email = $this->getVar("to_email");
	$vs_from_email = $this->getVar("from_email");
	$vs_from_name = $this->getVar("from_name");
	$vs_subject = $this->getVar("subject");
	$vs_message = $this->getVar("message");
	
	# --- if params have not been passed, set some defaults
	if(!$vs_subject && !$va_errors['subject']){
		$vs_subject = $t_object->getLabelForDisplay();
	}
	if(!$vs_from_email && $this->request->isLoggedIn() && !$va_errors['from_email']){
		$vs_from_email = $this->request->user->get("email");
	}	
	if(!$vs_from_name && $this->request->isLoggedIn() && !$va_errors['from_name']){
		$vs_from_name = $this->request->user->getName();
	}
	
?>

<div id="detailBody">
		<div id="pageNav">
<?php
			if ($vn_object_id) {
				print caNavLink($this->request, "&lsaquo; "._t("Back"), '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id), array('id' => 'back'));
			}
?>
		</div><!-- end nav -->
		<H1><?php print _t("Share this record"); ?></H1>
		<div id="shareObjectInfo">
			<div class='titleBar'>
				<div class='recordTitle'><h1><?php print $t_object->getLabelForDisplay(); ?></h1></div>
			</div>
<?php
			if($vs_image){
				print "<p>".$vs_image."</p>";
			}
			if($t_object->get('idno')){
				print "<H3>"._t("Identifier")."</H3><p>".$t_object->get('idno')."</p>";
			}
			
			# --- description
			if($vs_description_text = $t_object->get("ca_objects.description")){
				print "<h3>Description</h3><div class='scrollPane' id='description'>".$vs_description_text."</div>";				
			}
?>
		</div><!-- end shareObjectInfo -->
		<div id="shareForm">
			<div><?php print _t("Use the form below to email this record to a colleague.  The title, identifier, description and a low resolution media version will be included in the email."); ?></div>
			<form method="post" action="<?php print caNavUrl($this->request, 'Share', 'Share', 'sendEmailObject', array('object_id' => $vn_object_id)); ?>" name="emailObject" enctype='multipart/form-data'>
				<div class="formLabel">
					<?php print ($va_errors["to_email"]) ? "<div class='formErrors'>".$va_errors["to_email"]."</div>" : ""; ?>
					<?php print $this->request->isLoggedIn() ? _t("To e-mail address") : _t("To e-mail address<br/>(Enter multiple addresses separated by commas)"); ?>
				</div>
				<div>
					<input type="text" name="to_email" value="<?php print $vs_to_email; ?>" id="to_email"/>
				</div>
				<div class="formLabel">
					<?php print ($va_errors["from_name"]) ? "<div class='formErrors'>".$va_errors["from_name"]."</div>" : ""; ?>
					<?php print _t("Your name"); ?>
				</div>
				<div>
					<input type="text" name="from_name" value="<?php print $vs_from_name; ?>">
				</div>
				<div class="formLabel">
					<?php print ($va_errors["from_email"]) ? "<div class='formErrors'>".$va_errors["from_email"]."</div>" : ""; ?>
					<?php print _t("Your E-mail Address"); ?>
				</div>
				<div>
					<input type="text" name="from_email" value="<?php print $vs_from_email; ?>">
				</div>
<?php
				if(!$this->request->isLoggedIn()){
						
						$vn_num1 = rand(1,10);
						$vn_num2 = rand(1,10);
						$vn_sum = $vn_num1 + $vn_num2;
?>
						<div class="formLabel">
							<?php print ($va_errors["security"]) ? "<div class='formErrors'>".$va_errors["security"]."</div>" : ""; ?>
							<?php print _t("Security Question (to prevent SPAMbots)"); ?>
						</div>
						<div>
							<?php print $vn_num1; ?> + <?php print $vn_num2; ?> = <input name="security" value="" id="security" type="text" size="3" style="width:50px;" />
						</div>
						<input type="hidden" name="sum" value="<?php print $vn_sum; ?>">
<?php
				}
?>
				<div class="formLabel">
					<?php print ($va_errors["subject"]) ? "<div class='formErrors'>".$va_errors["subject"]."</div>" : ""; ?>
					<?php print _t("Subject"); ?>
				</div>
				<div>
					<input type="text" name="subject" value="<?php print $vs_subject; ?>">
				</div>
				<div class="formLabel">
					<?php print ($va_errors["message"]) ? "<div class='formErrors'>".$va_errors["message"]."</div>" : ""; ?>
					<?php print _t("Message"); ?>
				</div>
				<div>
					<textarea name="message" rows="8"><?php print $vs_message; ?></textarea>
				</div>
				<div class='button'>
					<a href="#" onclick="document.forms.emailObject.submit(); return false;"><?php print _t("Send"); ?></a>
				</div>
			</form>
		</div><!-- end shareForm -->
		<div style="clear:both; height:80px;"><!-- empty --></div>
</div><!-- end detailBody -->
<div id='bottomBar'><!-- empty --></div>
	<script type="text/javascript">

		jQuery(document).ready(function() {
<?php
		if($this->request->isLoggedIn()){
?>
			jQuery('#to_email').tokenInput('<?php print caNavUrl($this->request, 'Share/lookup', 'User', 'Get'); ?>', {
				onResult: function (results) {
					if (results.length == 0) {
						var emailRegEx = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;
						var emailinput = jQuery('#token-input-to_email').val();
						if (emailinput.search(emailRegEx) >= 0) {
							jQuery('#to_email').tokenInput("add", {id: emailinput, name: emailinput});
						}
					}
                    return results;
            	}, preventDuplicates: true
            });
<?php
		}
?>
			jQuery('.scrollPane').jScrollPane({
				animateScroll: true,
			});
		});
		
	</script>