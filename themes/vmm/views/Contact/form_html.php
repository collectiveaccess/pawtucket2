<?php
	$va_errors = $this->getVar("errors");
	$vn_num1 = rand(1,10);
	$vn_num2 = rand(1,10);
	$vn_sum = $vn_num1 + $vn_num2;
	$o_config = caGetContactConfig();

	$pn_id = $this->request->getParameter("id", pInteger);
	$ps_table = $this->request->getParameter("table", pString);
	$vs_typecode = "";
	$pn_object_id = "";
	switch($ps_table){
		case "ca_objects":
			require_once(__CA_MODELS_DIR__."/ca_objects.php");
			$t_item = new ca_objects($pn_id);
			$vs_url = $this->request->config->get("site_host").caNavUrl($this->request, "Detail", "objects", $pn_id);
			$t_list_item = new ca_list_items();
			$t_list_item->load($t_item->get("type_id"));
			$vs_typecode = $t_list_item->get("idno");
			$pn_object_id = $pn_id;
		break;
		# ---------------------------
		case "ca_collections":
			require_once(__CA_MODELS_DIR__."/ca_collections.php");
			$t_item = new ca_collections($pn_id);
			$vs_url = $this->request->config->get("site_host").caNavUrl($this->request, "Detail", "collections", $pn_id);
			
			# --- default to ask archivist
		break;
		# ---------------------------
		case "ca_occurrences":
			require_once(__CA_MODELS_DIR__."/ca_occurrences.php");
			$t_item = new ca_occurrences($pn_id);
			$vs_url = $this->request->config->get("site_host").caNavUrl($this->request, "Detail", "occurrences", $pn_id);
			
			# --- default to ask archivist
		break;
		# ---------------------------
		case "ca_sets":
			require_once(__CA_MODELS_DIR__."/ca_sets.php");
			$t_item = new ca_sets($pn_id);
			$vs_url = $this->request->config->get("site_host").caNavUrl($this->request, "Lightbox", "setDetail", $pn_id);
			$vs_admin_url = $o_config->get("admin_url")."/admin/index.php/manage/sets/SetEditor/Edit/set_id/".$pn_id;
			$vs_name = $t_item->getLabelForDisplay();
			# --- default to ask archivist
		break;
		# ---------------------------
	}
	if(!$vs_name && $t_item){
		$vs_name = $t_item->get($ps_table.".preferred_labels.name");
	}
	if($t_item && $ps_table){
		$vs_idno = $t_item->get($ps_table.".idno");
	}
?>
<div class="row"><div class="col-sm-12 col-lg-8 col-lg-offset-2">
			<H1><?php print ($vs_typecode == "collection_object") ? _t("Ask a Curator") : _t("Ask an Archivist"); ?></H1>
		<?php
			if(is_array($va_errors["display_errors"]) && sizeof($va_errors["display_errors"])){
				print "<div class='alert alert-danger'>".implode("<br/>", $va_errors["display_errors"])."</div>";
			}
		?>
			<form id="contactForm" action="<?php print caNavUrl($this->request, "", "Contact", "send"); ?>" role="form" method="post">
				<input type="hidden" name="crsfToken" value="<?php print caGenerateCSRFToken($this->request); ?>"/>
				<div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-sm-12">
							<p>{{{ask_contact_intro}}}</p>
							<br/>
<?php
						if($t_item && $ps_table){
?>
							<p><b>Title: </b><?php print $vs_name; ?>
							<br/><b>Regarding this URL: </b><a href="<?php print $vs_url; ?>" class="purpleLink"><?php print $vs_url; ?></a>
							</p>
							<input type="hidden" name="itemId" value="<?php print $vs_idno; ?>">
							<input type="hidden" name="itemTitle" value="<?php print $vs_name; ?>">
							<input type="hidden" name="itemURL" value="<?php print ($vs_admin_url) ? $vs_admin_url : $vs_url; ?>">
							<input type="hidden" name="id" value="<?php print $pn_id; ?>">
							<input type="hidden" name="table" value="<?php print $ps_table; ?>">
							<input type="hidden" name="object_id" value="<?php print $pn_object_id; ?>">
<?php
						}
?>
				<hr/><br/><br/>
				
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4">
				
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