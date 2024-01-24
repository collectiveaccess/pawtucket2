<?php
	$o_config = caGetContactConfig();
	$va_errors = $this->getVar("errors");
	$vn_num1 = rand(1,10);
	$vn_num2 = rand(1,10);
	$vn_sum = $vn_num1 + $vn_num2;
	$vs_page_title = ($o_config->get("contact_page_title")) ? $o_config->get("contact_page_title") : _t("Contact");
	
	# --- if a table has been passed this is coming from the Item Inquiry/Ask An Archivist contact form on detail pages
	$pn_id = $this->request->getParameter("id", pInteger);
	$ps_table = $this->request->getParameter("table", pString);
	
	if($pn_id && $ps_table){
		$t_item = Datamodel::getInstanceByTableName($ps_table);
		if($t_item){
			$t_item->load($pn_id);
			$vs_url = $this->request->config->get("site_host").caDetailUrl($this->request, $ps_table, $pn_id);
			$vs_name = $t_item->get($ps_table.".preferred_labels");
			$vs_idno = $t_item->get($ps_table.".idno");
			$vs_page_title = ($o_config->get("item_inquiry_page_title")) ? $o_config->get("item_inquiry_page_title") : _t("Item Inquiry");
		}
	}
?>

<div class="row">
	<div class="col mb-5">

		<h1><?= $vs_page_title; ?></h1>

		<?php
			if(is_array($va_errors["display_errors"]) && sizeof($va_errors["display_errors"])){
				print "<div class='alert alert-danger'>".implode("<br/>", $va_errors["display_errors"])."</div>";
			}
		?>

		<form class="row g-3" action="<?= caNavUrl($this->request, "", "Contact", "send"); ?>" method="post">

			<input type="hidden" name="csrfToken" value="<?= caGenerateCSRFToken($this->request); ?>"/>

			<!-- What is this for? -->
			<?php
				if($pn_id && $t_item->getPrimaryKey()){
			?>
					<div class="row">
						<div class="col-sm-12">
							<p><b>Title: </b><?= $vs_name; ?>
							<br/><b>Regarding this URL: </b><a href="<?= $vs_url; ?>" class="purpleLink"><?= $vs_url; ?></a>
							</p>
							<input type="hidden" name="itemId" value="<?= $vs_idno; ?>">
							<input type="hidden" name="itemTitle" value="<?= $vs_name; ?>">
							<input type="hidden" name="itemURL" value="<?= $vs_url; ?>">
							<input type="hidden" name="id" value="<?= $pn_id; ?>">
							<input type="hidden" name="table" value="<?= $ps_table; ?>">
							<hr/><br/><br/>
				
						</div>
					</div>
			<?php
				}
			?>

			<div class="col-md-4">
				<label for="inputName" class="form-label"><?= _t("Name"); ?></label>
				<input type="text" class="form-control" id="inputName" name="name" aria-label="enter name" placeholder="Enter name" required>
			</div>
			<div class="col-md-4">
				<label for="inputEmail" class="form-label"><?= _t("Email"); ?></label>
				<input type="email" class="form-control" id="inputEmail" name="email" aria-label="enter email" placeholder="Enter email" required>
			</div>

			<div class="col-md-9">
				<label for="message" class="form-label"><?= _t("Message"); ?></label>
  				<textarea class="form-control" id="message" rows="5" name="message" aria-label="enter message" required>{{{message}}}</textarea>
			</div>

			<!-- TODO: This Is Broken -->
			<?php
				if(!$this->request->isLoggedIn() && defined("__CA_GOOGLE_RECAPTCHA_KEY__") && __CA_GOOGLE_RECAPTCHA_KEY__){
			?>
					<script type="text/javascript">
						var gCaptchaRender = function(){
							grecaptcha.render('regCaptcha', {'sitekey': '<?= __CA_GOOGLE_RECAPTCHA_KEY__; ?>'});
						};
					</script>

					<script src='https://www.google.com/recaptcha/api.js?onload=gCaptchaRender&render=explicit' async defer></script>

					<div class="col-md-9">
						<div class='form-group<?= (($va_errors["recaptcha"]) ? " has-error" : ""); ?>'>
							<div id="regCaptcha" class=""></div>
						</div>
					</div>
			<?php
				}
			?>

			<div class="col-12">
				<button type="submit" class="btn btn-primary"><?= _t("Send"); ?></button>
			</div>
		</form>

	</div><!-- end col -->
</div><!-- end row -->
