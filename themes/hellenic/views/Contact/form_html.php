 <?php
	$o_config = caGetContactConfig();
	$va_errors = $this->getVar("errors");
	$vn_num1 = rand(1,10);
	$vn_num2 = rand(1,10);
	$vn_sum = $vn_num1 + $vn_num2;
	$vs_page_title = ($o_config->get("contact_page_title")) ? $o_config->get("contact_page_title") : _t("Contact");
	
	$ps_mode = $this->request->getParameter("mode", pString);
	
	# --- if a table has been passed this is coming from the Item Inquiry/Ask An Archivist contact form on detail pages
	$pn_id = $this->request->getParameter("id", pInteger);
	$ps_table = $this->request->getParameter("table", pString);
	
	if($pn_id && $ps_table){
		$t_item = Datamodel::getInstanceByTableName($ps_table);
		if($t_item){
			$t_item->load($pn_id);
			$vs_url = $this->request->config->get("site_host").caDetailUrl($this->request, $ps_table, $pn_id);
			$vs_name = $t_item->get($ps_table.".preferred_labels.name");
			$vs_idno = $t_item->get($ps_table.".idno");
			$vs_page_title = ($o_config->get("item_inquiry_page_title")) ? $o_config->get("item_inquiry_page_title") : _t("Item Inquiry");
		}
	}
	if($ps_mode == "research"){
		$vs_page_title = "Schedule a Research Visit";
	}

?>
<div class="container">
	<div class="row">
		<div id="sidebar" class="col-xs-12 col-md-4">
			<div class="menu-exhibitions-sidebar-container">
				<ul id="menu-exhibitions-sidebar" class="menu">
					<li class="menu-item current-menu-item "><?php print caNavLink($this->request, _t("About the Collection"), "", "", "About", "collection"); ?></li>
					<li class="menu-item"><?php print caNavLink($this->request, _t("Schedule a Research Visit"), "", "", "Contact", "form", array("mode" => "research")); ?></li>
					<li class="menu-item"><?php print caNavLink($this->request, _t("Contact"), "", "", "Contact", "form"); ?></li>
					<li class="menu-item"><?php print caNavLink($this->request, _t("Helpful Links"), "", "", "About", "links"); ?></li>
				</ul>
			</div>
		</div>
		<div class="col-md-8 col-xs-12">
		
			<H1><?php print $vs_page_title; ?></H1>
<?php
	if(is_array($va_errors["display_errors"]) && sizeof($va_errors["display_errors"])){
		print "<div class='alert alert-danger'>".implode("<br/>", $va_errors["display_errors"])."</div>";
	}
	if(($ps_mode == "research") && ($vs_tmp = $this->getVar("researchvisitintro"))){
		print $vs_tmp."<br/><br/>";
	}
?>
	<form id="contactForm" action="<?php print caNavUrl($this->request, "", "Contact", "send"); ?>" role="form" method="post">
	    <input type="hidden" name="crsfToken" value="<?php print caGenerateCSRFToken($this->request); ?>"/>
<?php
	if($pn_id && $t_item->getPrimaryKey()){
?>
		<div class="row">
			<div class="col-sm-12">
				<p><b>Title: </b><?php print $vs_name; ?>
				<br/><b>Regarding this URL: </b><a href="<?php print $vs_url; ?>" class="purpleLink"><?php print $vs_url; ?></a>
				</p>
				<input type="hidden" name="itemId" value="<?php print $vs_idno; ?>">
				<input type="hidden" name="itemTitle" value="<?php print $vs_name; ?>">
				<input type="hidden" name="itemURL" value="<?php print $vs_url; ?>">
				<input type="hidden" name="id" value="<?php print $pn_id; ?>">
				<input type="hidden" name="table" value="<?php print $ps_table; ?>">
				<hr/><br/><br/>
	
			</div>
		</div>
<?php
	}
?>
		<div class="row">
			<div class="col-md-12">
				<div class="row">
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
					<div class="col-sm-4">
						<div class="form-group<?php print (($va_errors["security"]) ? " has-error" : ""); ?>">
							<label for="security">Security Question</label>
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
			<div class="col-md-12">
				<div class="form-group<?php print (($va_errors["message"]) ? " has-error" : ""); ?>">
					<label for="message">Message</label>
					<textarea class="form-control input-sm" id="message" name="message" rows="5">{{{message}}}</textarea>
				</div>
			</div><!-- end col -->
		</div><!-- end row -->
<?php
	if($ps_mode == "research"){
?>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group<?php print (($va_errors["research"]) ? " has-error" : ""); ?>">
					<label for="research">Research Area</label>
					<input type="text" class="form-control input-sm" id="researchArea" placeholder="Enter your research area" name="researchArea" value="{{{research}}}">
				</div>
			</div><!-- end col -->
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group<?php print (($va_errors["requestedCollections"]) ? " has-error" : ""); ?>">
					<label for="requestedCollections">Requested collections</label>
					<input type="text" class="form-control input-sm" id="requestedCollections" placeholder="Enter your requested collections" name="requestedCollections" value="{{{requestedCollections}}}">
				</div>
			</div><!-- end col -->
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group<?php print (($va_errors["date"]) ? " has-error" : ""); ?>">
					<label for="requestedCollections">Proposed date of visit</label>
					<input type="text" class="form-control input-sm" id="requestedCollections" placeholder="Enter your proposed date" name="date" value="{{{date}}}">
				</div>
			</div><!-- end col -->
		</div><!-- end row -->
<?php
	}
?>
		
		<div class="form-group">
			<button type="submit" class="btn btn-default">Send</button>
		</div><!-- end form-group -->
		<input type="hidden" name="sum" value="<?php print $vn_sum; ?>">
		<input type="hidden" name="mode" value="<?php print $ps_mode; ?>">
		<input type="hidden" name="contactType" value="<?php print $vs_page_title; ?>">
	</form>
	
</div><!-- end col --></div><!-- end row --></div><!-- end container -->