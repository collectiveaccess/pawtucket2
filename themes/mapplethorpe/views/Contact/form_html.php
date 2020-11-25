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
			switch($ps_table){
				case "ca_sets":
				
					$vs_url = $this->request->config->get("site_host").caNavUrl($this->request, "Lightbox", "setDetail", $pn_id);
					$vs_admin_url = $o_config->get("admin_url")."/index.php/manage/sets/SetEditor/Edit/set_id/".$pn_id;
					$vs_name = $t_item->getLabelForDisplay();
					$vs_page_title = "Inquiry";
				break;
				# -------------------------------
				default:
					$vs_url = $this->request->config->get("site_host").caDetailUrl($this->request, $ps_table, $pn_id);
					$vs_name = $t_item->get($ps_table.".preferred_labels.name");
					$vs_idno = $t_item->get($ps_table.".idno");
					$vs_page_title = ($o_config->get("item_inquiry_page_title")) ? $o_config->get("item_inquiry_page_title") : _t("Item Inquiry");
				break;
				# -------------------------------
			}
		}
	}
?>
<div class="row"><div class="col-sm-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3"><div class="whiteBg">
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
			<div class="col-sm-12 ">
<?php
				if($ps_table == "ca_objects"){
					print '<div class="text-center">';
					if($vs_img = $t_item->get("ca_object_representations.media.small")){
						print $vs_img."<br/><br/>";
					}
					print $t_item->getWithTemplate("<ifdef code='ca_objects.preferred_labels|ca_objects.date'><ifdef code='ca_objects.preferred_labels'><i>^ca_objects.preferred_labels</i>, </ifdef>^ca_objects.date<br/></ifdef><div><ifdef code='ca_objects.idno'>MAP # ^ca_objects.idno<br/></ifdef><ifdef code='ca_objects.dimensions'>^ca_objects.dimensions<br/></ifdef><ifdef code='ca_objects.medium'>^ca_objects.medium</ifdef></div>");
					print '</div>';
				}else{
					if($vs_name){
						print "<b>Name: </b>".$vs_name;
					}
				}
?>
				
				<br/><b>URL: </b><a href="<?php print $vs_url; ?>" class="purpleLink"><?php print $vs_url; ?></a>
				
				<input type="hidden" name="itemId" value="<?php print $vs_idno; ?>">
				<input type="hidden" name="itemTitle" value="<?php print $vs_name; ?>">
				<input type="hidden" name="itemURL" value="<?php print $vs_url; ?>">
				<input type="hidden" name="adminURL" value="<?php print $vs_admin_url; ?>">
				<input type="hidden" name="id" value="<?php print $pn_id; ?>">
				<input type="hidden" name="table" value="<?php print $ps_table; ?>">
				<hr/>
	
			</div>
		</div>
<?php
	}else{
?>
		<div class="row">
			<div class="col-sm-12"><p>{{{contact_page_intro}}}</p></div>
		</div>
<?php
	}
?>
		<div class="row">
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-4">
						<div class="form-group<?php print (($va_errors["name"]) ? " has-error" : ""); ?>">
							<label for="name">Your Name</label>
							<input type="text" class="form-control input-sm" aria-label="enter name" placeholder="Enter name" name="name" value="<?php print ($this->getVar("name")) ? $this->getVar("name") : trim($this->request->user->get("fname")." ".$this->request->user->get("lname")); ?>">
						</div>
					</div><!-- end col -->
					<div class="col-sm-4">
						<div class="form-group<?php print (($va_errors["email"]) ? " has-error" : ""); ?>">
							<label for="email">Your Email address</label>
							<input type="text" class="form-control input-sm" id="email" placeholder="Enter email" name="email" value="<?php print ($this->getVar("email")) ? $this->getVar("email") : $this->request->user->get("email"); ?>">
						</div>
					</div><!-- end col -->
					<div class="col-sm-4">
						<div class="form-group<?php print (($va_errors["sendTo"]) ? " has-error" : ""); ?>">
							<label for="sendTo">Send To</label>
							<select class="form-control input-sm" id="sendTo" name="sendTo">
								<option value="">Choose one</option>
								<option value="joree@mapplethorpe.org" <?php print ($this->getVar("sendTo") == "joree@mapplethorpe.org") ? "selected" : ""; ?>>Joree Adilman</option>
								<option value="kelly@mapplethorpe.org" <?php print ($this->getVar("sendTo") == "kelly@mapplethorpe.org") ? "selected" : ""; ?>>Kelly Jones</option>
							</select>
						</div>
					</div><!-- end col -->
				</div><!-- end row -->
			</div><!-- end col -->
		</div><!-- end row -->
		<div class="row">
			<div class="col-md-12">
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
	
</div></div><!-- end col --></div><!-- end row -->
