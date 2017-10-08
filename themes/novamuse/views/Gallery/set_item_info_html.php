<?php
	$va_set_item = $this->getVar("set_item");
	$pn_item_id = $this->request->getParameter('item_id', pInteger);
 	$t_set_item = new ca_set_items($pn_item_id);
 	$va_set_item_comments = $t_set_item->getComments();
 	
 	$t_object = $this->getVar("object");
	$va_member_inst = $t_object->get("ca_entities", array("restrictToRelationshipTypes" => array("repository"), "returnAsArray" => 1, "checkAccess" => $va_access_values));
	$vs_member_inst_link = "";
	if (is_array($va_member_inst)) {
		foreach($va_member_inst as $vn_relation_id => $va_member_inst_info){
			$vs_member_inst_link = caNavLink($this->request, $va_member_inst_info["displayname"], "titletextcaps", "", "Detail", "entities/".$va_member_inst_info["entity_id"]);
		}
	}
?>
<?php print "(".$this->getVar("set_item_num")."/".$this->getVar("set_num_items").")<br/>"; ?>
{{{<ifdef code="ca_objects.preferred_labels.name"><H4>^ca_objects.preferred_labels.name</H4></ifdef>}}}

{{{<ifdef code="ca_objects.idno"><H6>Accession number</H6>^ca_objects.idno<br/></ifdef>}}}
<H6>Collection:</H6> <?php print $vs_member_inst_link; ?><br/>
<?php
	# --- category
	if($t_object->get('ns_category')){
		print "<H6>"._t("Category")."</H6>".caNavLink($this->request, $t_object->get('ns_category', array('convertCodesToDisplayText' => true)), "", "", "Browse/objects", "facet/category_facet/id/".$t_object->get('ns_category'))."<br/>";
	}
?>
{{{<ifdef code="ca_objects.narrative"><H6>Narrative</H6><div style="max-height:150px; overflow-y:auto;">^ca_objects.narrative</div></ifdef>}}}


<br/><b><?php print caDetailLink($this->request, _t("VIEW FULL RECORD"), 'btn btn-default btn-blue', 'ca_objects',  $this->getVar("object_id")); ?></b>
<?php
	if(is_array($va_set_item_comments) && sizeof($va_set_item_comments)){
		print "<H6>Comments</H6><div style='max-height:200px; overflow-y:auto;'>";
		foreach($va_set_item_comments as $va_set_item_comment){
			print "<p>".$va_set_item_comment["comment"]."</p>";
		}
		print "</div>";
	}
?>