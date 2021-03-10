<?php
	$t_set_item = $this->getVar("set_item");
	$t_object = $this->getVar("object");
	
	$vs_medium 	= $t_object->get("ca_objects.medium_container.display_medium_support");
	$vs_entity 	= $t_object->get("ca_entities.preferred_labels.displayname", array('restrictToRelationshipTypes' => array('artist', 'painter', 'school', 'attributed'), 'delimiter' => ', '));
	$vs_date = $t_object->get('ca_objects.creation_date_display');
	$va_caption = array();
	if($vs_entity){
		$va_caption[] = $vs_entity;
	}
	if($vs_date){
		$va_caption[] = $vs_date;
	}
	if($vs_medium){
		$va_caption[] = $vs_medium;
	}
?>
<div class="galleryDetailObjectInfoContainer">
<?php
	
	print "<div class='unit text-center'>(".$this->getVar("set_item_num")."/".$this->getVar("set_num_items").")</div>";
	print "<div class='tombstone'>".caDetailLink($this->request, "<H2>".$this->getVar("label")."</H2>".join(", ", $va_caption), '', $this->getVar("table"),  $this->getVar("row_id"));
	if ($vs_credit = $t_object->get('ca_objects.credit_line.credit_text', array('delimiter' => '<br/>'))) {
		print "<br/>".$vs_credit;
	}
	print "</div>";
				
	if($vs_tmp = $t_set_item->get("ca_set_items.caption", array("convertLineBreaks" => true))){
		print "<div class='setItemCaption trimTextItemInfo'>".$vs_tmp."</div>";
	}
?>
<div>
<script type='text/javascript'>
		jQuery(document).ready(function() {		
			$('.trimTextItemInfo').readmore({
			  speed: 75,
			  maxHeight: 280,
			  moreLink: '<a href="#">Read More <i class="fa fa-angle-down"></i></a>',
			  lessLink: '<a href="#">Read Less <i class="fa fa-angle-up"></i></a>'
			});
		});
</script>