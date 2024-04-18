<?php
	$t_item = $this->getVar("set_item");
	$t_object = $this->getVar("object");
?>
<?php print "(".$this->getVar("set_item_num")."/".$this->getVar("set_num_items").")<br/>"; ?>
<div class="galleryTombstoneScroll">
<?php
	if($t_item->get("ca_set_items.preferred_labels") != "[BLANK]"){
		print "<H4>".$t_item->get("ca_set_items.preferred_labels")."</H4>";
	}else{
		print $t_object->getWithTemplate('<ifdef code="ca_objects.preferred_labels.name"><H4>^ca_objects.preferred_labels.name</H4></ifdef>');
	}
?>
	{{{<ifdef code="ca_objects.dc_website"><div class='unit'><a href="^ca_objects.dc_website" target="_blank">View Website <span class="glyphicon glyphicon-new-window"></span></a></div></ifdef>}}}
	
	{{{<case>
		<if rule='^ca_objects.type_id%convertCodesToDisplayText=1 =~ /Library/'>
			<ifdef code='ca_objects.displayDate'>^ca_objects.MARC_copyrightDate</ifdef>
		</if>
		<if rule='^ca_objects.type_id%convertCodesToDisplayText=1 =~ /RG10/'>
			<ifdef code='ca_objects.displayDate'>^ca_objects.displayDate</ifdef>
		</if>
		<if rule='^ca_objects.type_id%convertCodesToDisplayText=1 =~ /Archival/'>
			<ifdef code='ca_objects.displayDate'>^ca_objects.displayDate</ifdef>
		</if>
		<if rule='^ca_objects.type_id%convertCodesToDisplayText=1 =~ /Museum/'>
			<ifdef code='ca_objects.displayDate'>^ca_objects.displayDate</ifdef>
		</if>
	</case>}}}
	
	{{{<ifcount code="ca_entities" restrictToTypes="school" min="1"><div class="unit"><ifcount code="ca_entities" restrictToTypes="school" min="1" max="1"><h6>School</h6></ifcount><ifcount code="ca_entities" restrictToTypes="school" min="2"><h6>Schools</h6></ifcount><unit relativeTo="ca_entities" restrictToTypes="school" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit></div></ifcount>}}}
<?php
	$vs_set_item_description = caConvertLineBreaks($t_item->get("ca_set_items.set_item_description"));
	
	if($vs_set_item_description){
		print "<div class='unit'>".$vs_set_item_description."</div>";
	}else{
		switch(strToLower($t_object->get("ca_objects.type_id", array("convertCodesToDisplayText" => true)))){
			case "archival item":
			 	$vs_item_description = $t_object->getWithTemplate('<ifdef code="ca_objects.scope_new.scope_new_text">
						<div class="unit" data-toggle="popover" title="Source" data-content="^ca_objects.scope_new.scope_new_source">
							<div class="trimText">^ca_objects.scope_new.scope_new_text</div>
						</div>
					</ifdef>');
			break;
			# ---------------------
			case "library item":
				$vs_item_description = $t_object->getWithTemplate('<ifdef code="ca_objects.description_new.description_new_txt">
						<div class="unit" data-toggle="popover" title="Source" data-content="^ca_objects.description_new.description_new_source">
							<div class="trimText">^ca_objects.description_new.description_new_txt</div>
						</div>
					</ifdef>');			
			break;
			# ---------------------
			case "rg10 file":
				$vs_item_description = $t_object->getWithTemplate('<if rule="^ca_objects.type_id%convertCodesToDisplayText=1 =~ /RG10/">
						<ifdef code="ca_objects.record_group_id|ca_objects.file_series">^ca_objects.record_group_id: ^ca_objects.file_series</ifdef>
					</if>');
			break;
			# ---------------------
			case "museum work":
				$vs_item_description = $t_object->getWithTemplate('<ifdef code="ca_objects.curatorial_description.curatorial_desc_value">
					<div class="unit" data-toggle="popover" title="Source" data-content="^ca_objects.curatorial_description.curatorial_desc_source">
						<div class="trimText">^ca_objects.curatorial_description.curatorial_desc_value</div>
					</div>
				</ifdef>');
			break;
			# ---------------------
			case "resource":
				$vs_item_description = $t_object->getWithTemplate('<ifdef code="ca_objects.description"><div class="unit">^ca_objects.description</div></ifdef>');
			break;
			# ---------------------
		}
		
		if(trim($vs_item_description)){
			print $vs_item_description;
		}
	}
?>
	
</div>
<?php print "<div class='unit text-center'>".caDetailLink($this->request, _t("More Information"), 'btn-default', $this->getVar("table"),  $this->getVar("row_id"))."</div>"; ?>
<script type='text/javascript'>
	jQuery(document).ready(function() {
		var options = {
			placement: function () {
				if ($(window).width() > 992) {
					return "left";
				}else{
					return "auto top";
				}
			},
			trigger: "hover",
			html: "true"
		};

		$('[data-toggle="popover"]').each(function() {
  			if($(this).attr('data-content')){
  				$(this).popover(options).click(function(e) {
					$(this).popover('toggle');
				});
  			}
		});
	});
</script>