<?php 
	$t_object = $this->getVar("object");
?>
	<H2>{{{ca_objects.preferred_labels.name}}}</H2>
	{{{<ifdef code="ca_objects.public_title"><div class="unit"><i>^ca_objects.public_title</i></unit></ifdef>}}}
				
<?php
	$va_list_ids = array();
	if($va_subjects = $t_object->get("ca_list_items", array("returnWithStructure" => true, "restrictToLists" => array("voc_6"), "checkAccess" => caGetUserAccessValues($this->request)))){
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
			print "<div class='unit'>";
			print "<b>Keyword".((sizeof($va_subjects) > 1) ? "s" : "")."</b><br/>";
			print join($va_subjects_sorted, "<br/>");
			print "</div>";
		}
	}
?>
	{{{<ifdef code="ca_objects.public_description"><div class="unit unitExternalLinks"><b>Description</b><br/>^ca_objects.public_description</unit></ifdef>}}}
<?php
	$vs_credit_line = "";
	if($t_object->get("ca_objects.credit_line")){
		$vs_credit_line = $t_object->get("ca_objects.credit_line");
	}elseif($t_object->get("ca_object_lots.credit_line")){
		$vs_credit_line = $t_object->get("ca_object_lots.credit_line");
	}
	if(strpos(strtolower($vs_credit_line), "anonymous") === false){
		if($va_sources = $t_object->get("ca_entities", array("returnWithStructure" => true, "restrictToRelationshipTypes" => array("donor"), "checkAccess" => caGetUserAccessValues($this->request)))){
			if(is_array($va_sources) && sizeof($va_sources)){
				print "<div class='unit'>";
				print "<b>Source".((sizeof($va_sources) > 1) ? "s" : "").": </b>";
				$va_source_display = array();
				foreach($va_sources as $va_source){
					$va_source_display[] = caNavLink($this->request, $va_source["displayname"], "", "", "Browse", "objects", array("facet" => "entity_facet", "id" => $va_source["entity_id"]));
				}
				print implode(", ", $va_source_display)."</div>";
			}

		}
	}
	if($vs_credit_line){
		print "<div class='unit unitExternalLinks'><b>Credit Line:</b> <i>".$vs_credit_line."</i></div>";
	}

?>
	{{{<ifdef code="ca_objects.idno"><div class="unit"><b>Accession Number:</b> ^ca_objects.idno</unit></ifdef>}}}
	
<?php print caDetailLink($this->request, _t("VIEW FULL RECORD"), 'btn btn-default', 'ca_objects',  $this->getVar("object_id")); ?>

<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('.unitExternalLinks a').attr('target','_blank');
	});
	$(function () {
	  $('[data-toggle="popover"]').popover()
	});
</script>