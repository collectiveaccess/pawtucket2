<?php
	$vn_item_id = $this->getVar("item_id");
	$vs_tablename = $this->getVar("tablename");
	$vs_controller = $this->getVar("controller");
	$t_item = $this->getVar("t_item");
	$va_access_values = $this->getVar("access_values");
	$va_errors = $this->getVar("errors");
	
	# --- if there were errors in the form, the form paramas are passed back to preload the form
	$vs_to_email = $this->getVar("to_email");
	$vs_from_email = $this->getVar("from_email");
	$vs_from_name = $this->getVar("from_name");
	$vs_subject = $this->getVar("subject");
	$vs_message = $this->getVar("message");
	
	# --- if params have not been passed, set some defaults
	if(!$vs_subject && !$va_errors['subject']){
		$vs_subject = $t_item->getLabelForDisplay();
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
			if ($vn_item_id) {
				print caNavLink($this->request, "&lsaquo; "._t("Back"), '', 'Detail', $vs_controller, 'Show', array($t_item->PrimaryKey() => $vn_item_id), array('id' => 'back'));
			}
?>
		</div><!-- end nav -->
		<H1><?php print _t("Share this record"); ?></H1>
		<div id="shareObjectInfo">
			<h1><?php print $t_item->getLabelForDisplay(); ?></h1>
<?php
			if($t_item->get('idno')){
				print "<div class='unit'><b>"._t("Identifier").":</b> ".$t_item->get('idno')."</div><!-- end unit -->";
			}
?>
		</div><!-- end shareObjectInfo -->
		<div id="shareForm">
			<div><?php print _t("Use the form below to email this record to a colleague.  The item's title and identifier will be included in the email."); ?></div>
			<form method="post" action="<?php print caNavUrl($this->request, 'Share', 'Share', 'sendEmail', array('item_id' => $vn_item_id, 'tablename' => $vs_tablename)); ?>" name="emailForm" enctype='multipart/form-data'>
				<div class="formLabel">
					<?php print ($va_errors["to_email"]) ? "<div class='formErrors'>".$va_errors["to_email"]."</div>" : ""; ?>
					<?php print _t("To e-mail address (Enter multiple addresses separated by commas)"); ?><br/>
					<input type="text" name="to_email" value="<?php print $vs_to_email; ?>">
				</div>
				<div class="formLabel">
					<?php print ($va_errors["from_name"]) ? "<div class='formErrors'>".$va_errors["from_name"]."</div>" : ""; ?>
					<?php print _t("Your name"); ?><br/>
					<input type="text" name="from_name" value="<?php print $vs_from_name; ?>">
				</div>
				<div class="formLabel">
					<?php print ($va_errors["from_email"]) ? "<div class='formErrors'>".$va_errors["from_email"]."</div>" : ""; ?>
					<?php print _t("Your E-mail Address"); ?><br/>
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
							<?php print _t("Security Question (to prevent SPAMbots)"); ?><br/>
							<?php print $vn_num1; ?> + <?php print $vn_num2; ?> = <input name="security" value="" id="security" type="text" size="3" style="width:50px;" />
						</div>
						<input type="hidden" name="sum" value="<?php print $vn_sum; ?>">
<?php
				}
?>
				<div class="formLabel">
					<?php print ($va_errors["subject"]) ? "<div class='formErrors'>".$va_errors["subject"]."</div>" : ""; ?>
					<?php print _t("Subject"); ?><br/>
					<input type="text" name="subject" value="<?php print $vs_subject; ?>">
				</div>
				<div class="formLabel">
					<?php print ($va_errors["message"]) ? "<div class='formErrors'>".$va_errors["message"]."</div>" : ""; ?>
					<?php print _t("Message"); ?><br/>
					<textarea name="message" rows="8"><?php print $vs_message; ?></textarea>
				</div>
				<a href="#" onclick="document.forms.emailForm.submit(); return false;"><?php print _t("Send"); ?></a>
			</form>
		</div><!-- end shareForm -->
</div><!-- end detailBody -->