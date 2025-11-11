<?php
	# --- display the media item
	$pn_previous_item_id = $this->getVar("previous_item_id");
	$pn_next_item_id = $this->getVar("next_item_id");
	$pn_previous_row_id = $this->getVar("previous_row_id");
	$pn_next_row_id = $this->getVar("next_row_id");
	$pn_previous_rep_id = $this->getVar("previous_representation_id");
	$pn_next_rep_id = $this->getVar("next_representation_id");
	
	$pn_set_id = $this->getVar("set_id");
	$pn_row_id = $this->getVar("row_id");
	$ps_table = $this->getVar("table");
	$pn_rep_id = $this->getVar("representation_id");
?>
<div class="row mb-2 align-items-center">
	<div class="col-2 col-sm-1 text-center">
<?php
	if($pn_previous_item_id > 0){
		print "<button id='galleryPreviousButton' class='btn btn-sm btn-primary align-content-center' hx-target='#galleryDetailItemInfo' hx-trigger='click' hx-get='".caNavUrl($this->request, '', 'Gallery', 'getSetItemInfo', array('item_id' => $pn_previous_item_id, 'set_id' => $pn_set_id))."'><i class='bi bi-chevron-left' aria-label='previous'></i></button>";
	}else{
		print "<button id='galleryPreviousButton' class='btn btn-sm btn-primary' disabled><i class='bi bi-chevron-left' aria-label='previous'></i></button>";
	}
?>
	</div>
	<div class="col-8 col-sm-6">
<?php
	print "<div id='galleryDetailImageWrapper' class='object-fit-contain'>".caDetailLink($this->request, $this->getVar("rep"), 'text-center w-100 h-100 d-block', $ps_table,  $this->getVar("row_id"))."</div>";	
?>
	</div>
	<div class="col-2 col-sm-1 text-center">
<?php
	if($pn_next_item_id > 0){
		print "<button id='galleryNextButton' class='btn btn-sm btn-primary' hx-target='#galleryDetailItemInfo' hx-trigger='click' hx-get='".caNavUrl($this->request, '', 'Gallery', 'getSetItemInfo', array('item_id' => $pn_next_item_id, 'set_id' => $pn_set_id))."'><i class='bi bi-chevron-right' aria-label='next'></i></button>";
	}else{
		print "<button id='galleryNextButton' class='btn btn-sm btn-primary' disabled><i class='bi bi-chevron-right' aria-label='next'></i></button>";
	}
?>
	</div><!--end col-sm-1-->
	<div class="col-12 col-sm-4 small">
<?php
	# --- display the metadata fro the item
	$t_item = $this->getVar("instance");
	$t_set_item = $this->getVar("set_item");
	$config = $this->getVar("config");
	
	$views = $config->get('views');
	$views_info = $views['slideshow'][$this->getVar("table")];
	
	$vs_label = $t_item->getWithTemplate($views_info["labelTemplate"]);
	$vs_content = $t_item->getWithTemplate($views_info["contentTemplate"]);
	$vs_set_item_content = $t_set_item->getWithTemplate($views_info["setItemContentTemplate"]);
	

	print "<div class='small mb-1'>(".$this->getVar("set_item_num")."/".$this->getVar("set_num_items").")</div>";

	print "<H2>".$vs_label."</H2>";
?>
	<dl>
<?php
	print $t_item->getWithTemplate('<ifdef code="ca_objects.public_title"><dd><i>^ca_objects.public_title</i></dd></ifdef>');
	$va_list_ids = array();
	if($va_subjects = $t_item->get("ca_list_items", array("returnWithStructure" => true, "restrictToLists" => array("voc_6"), "checkAccess" => caGetUserAccessValues($this->request)))){
		if(is_array($va_subjects) && sizeof($va_subjects)){
			# --- loop through to order alphebeticaly
			$va_subjects_sorted = array();
			$t_list_item = new ca_list_items();
			foreach($va_subjects as $va_subject){
				$t_list_item->load($va_subject["item_id"]);
				$va_popover = array();
				if($t_list_item->get("ca_list_item_labels.description")){
					#$va_popover = array("data-container" => "body", "data-toggle" => "popover", "data-placement" => "auto", "data-html" => "true", "data-title" => $va_subject["name_singular"], "data-content" => $t_list_item->get("ca_list_item_labels.description"),  "data-trigger" => "hover");
					$va_popover = array("data-container" => "body", "data-toggle" => "popover", "data-placement" => "auto", "data-html" => "true", "data-content" => $t_list_item->get("ca_list_item_labels.description"),  "data-trigger" => "hover");							
				}
				$va_subjects_sorted[$va_subject["name_singular"]] = caNavLink($this->request, $va_subject["name_singular"], "", "", "Browse", "objects", array("facet" => "term_facet", "id" => $va_subject["item_id"]), $va_popover);
				$va_list_ids[] = $va_subject["item_id"];
			}
			ksort($va_subjects_sorted);
			print "<dt class='pt-3'>";
			print "Keyword".((sizeof($va_subjects) > 1) ? "s" : "")."</dt>";
			print "<dd>".join(", ", $va_subjects_sorted)."</dd>";
		}
	}
	print $t_item->getWithTemplate('<ifdef code="ca_objects.public_description"><dt class="pt-3">Description</dt><dd>^ca_objects.public_description</dd></ifdef>');
	if($va_sources = $t_item->get("ca_entities", array("returnWithStructure" => true, "restrictToRelationshipTypes" => array("donor"), "checkAccess" => caGetUserAccessValues($this->request)))){
		if(is_array($va_sources) && sizeof($va_sources)){
			print "<dt class='pt-3 d-inline'>Source".((sizeof($va_sources) > 1) ? "s" : "").": </dt>";
			$va_source_display = array();
			foreach($va_sources as $va_source){
				$va_source_display[] = "<dd class='d-inline'>".caNavLink($this->request, $va_source["displayname"], "", "", "Browse", "objects", array("facet" => "entity_facet", "id" => $va_source["entity_id"]))."</dd>";
			}
			print implode("", $va_source_display);
		}

	}
	$vs_credit_line = "";
	if($t_item->get("ca_objects.credit_line")){
		$vs_credit_line = $t_item->get("ca_objects.credit_line");
	}elseif($t_item->get("ca_object_lots.credit_line")){
		$vs_credit_line = $t_item->get("ca_object_lots.credit_line");
	}
	if($vs_credit_line){
		print "<dt class='pt-3 d-inline'><br/>Credit Line: </dt><dd class='d-inline'><i>".$vs_credit_line."</i></dd>";
	}

	print $t_item->getWithTemplate('<ifdef code="ca_objects.idno"><dt class="pt-3 d-inline"><br/>Accession Number: </dt><dd class="d-inline">^ca_objects.idno</dd></ifdef>');

	print "<div class='text-center py-2 text-capitalize'>".caDetailLink($this->request, _t("View Full Record")." <i class='bi bi-arrow-right'></i>", 'btn btn-primary', $this->getVar("table"), $this->getVar("row_id"))."</div>";
	
?>	
	</div>
</div><!-- end row -->