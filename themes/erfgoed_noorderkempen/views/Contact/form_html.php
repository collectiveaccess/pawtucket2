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
			$vs_page_title = ($o_config->get("item_inquiry_page_title")) ? $o_config->get("item_inquiry_page_title") : _t("Item Inquiry");
			switch($ps_table){	
				case "ca_sets":
					$vs_url = $this->request->config->get("site_host").caNavUrl($this->request, "Lightbox", "setDetail", $pn_id);
					$vs_admin_url = $o_config->get("admin_url")."/admin/index.php/manage/sets/SetEditor/Edit/set_id/".$pn_id;
					$vs_name = $t_item->getLabelForDisplay();
					# --- default to ask archivist
				break;
				# ---------------------------
				default:
					$vs_url = $this->request->config->get("site_host").caDetailUrl($this->request, $ps_table, $pn_id);
					$vs_name = $t_item->get($ps_table.".preferred_labels.name");
					$vs_idno = $t_item->get($ps_table.".idno");
				break;
				# ---------------------------
			}			
		}
	}
?>
<div class="row"><div class="col-sm-12">
	<H1><?php print $vs_page_title; ?></H1>
<?php
	if(is_array($va_errors["display_errors"]) && sizeof($va_errors["display_errors"])){
		print "<div class='alert alert-danger'>".implode("<br/>", $va_errors["display_errors"])."</div>";
	}
?>
	<form id="contactForm" action="<?php print caNavUrl($this->request, "", "Contact", "send"); ?>" role="form" method="post">
	    <input type="hidden" name="crsfToken" value="<?php print caGenerateCSRFToken($this->request); ?>"/>
<?php
	if($pn_id && $t_item->getPrimaryKey()){
?>
		<div class="row">
			<div class="col-sm-12">
				<p>{{{inquire_form}}}</p>
				<HR/>
				<p><b><?php print _t("Title"); ?>: </b><?php print $vs_name; ?>
<?php 
					if($vs_idno){
						print "<br/><b>"._t("ID").": </b>".$vs_idno;
					}
?>
				<br/><b><?php print _t("Regarding this URL"); ?>: </b><a href="<?php print $vs_url; ?>" class="purpleLink"><?php print $vs_url; ?></a>
				</p>
				<input type="hidden" name="itemId" value="<?php print $vs_idno; ?>">
				<input type="hidden" name="itemTitle" value="<?php print $vs_name; ?>">
				<input type="hidden" name="itemURL" value="<?php print ($vs_admin_url) ? $vs_admin_url : $vs_url; ?>">
				<input type="hidden" name="id" value="<?php print $pn_id; ?>">
				<input type="hidden" name="table" value="<?php print $ps_table; ?>">
				<hr/><br/><br/>
	
			</div>
		</div>
<?php
	}
?>
		<div class="row">
			<div class="col-md-9">
				<div class="row">
					<div class="col-sm-4">
						<div class="form-group<?php print (($va_errors["name"]) ? " has-error" : ""); ?>">
							<label for="name"><?php print _t("Name"); ?></label>
							<input type="text" class="form-control input-sm" id="email" placeholder="<?php print _t("Enter name"); ?>" name="name" value="{{{name}}}">
						</div>
					</div><!-- end col -->
					<div class="col-sm-4">
						<div class="form-group<?php print (($va_errors["email"]) ? " has-error" : ""); ?>">
							<label for="email"><?php print _t("Email address"); ?></label>
							<input type="text" class="form-control input-sm" id="email" placeholder="<?php print _t("Enter email"); ?>" name="email" value="{{{email}}}">
						</div>
					</div><!-- end col -->
					<div class="col-sm-4">
						<div class="form-group<?php print (($va_errors["security"]) ? " has-error" : ""); ?>">
							<label for="security"><?php print _t("Security Question"); ?></label>
							<div class='row'>
								<div class='col-sm-6'>
									<p class="form-control-static"><?php print $vn_num1; ?> + <?php print $vn_num2; ?> = </p>
								</div>
								<div class='col-sm-6'>
									<input name="security" value="" id="security" type="text" class="form-control input-sm" />
								</div>
							</div><!--end row-->	
						</div><!-- end form-group -->
					</div><!-- end col -->
				</div><!-- end row -->
			</div><!-- end col -->
		</div><!-- end row -->
		<div class="row">
			<div class="col-md-9">
				<div class="form-group<?php print (($va_errors["message"]) ? " has-error" : ""); ?>">
					<label for="message"><?php print _t("Message"); ?></label>
					<textarea class="form-control input-sm" id="message" name="message" rows="5">{{{message}}}</textarea>
				</div>
			</div><!-- end col -->
		</div><!-- end row -->
		<div class="form-group">
			<button type="submit" class="btn btn-default"><?php print _t("Send"); ?></button>
		</div><!-- end form-group -->
		<input type="hidden" name="sum" value="<?php print $vn_sum; ?>">
	</form>
	
</div><!-- end col --></div><!-- end row -->