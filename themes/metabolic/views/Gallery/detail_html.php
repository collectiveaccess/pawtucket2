<?php
	$pa_set_items = $this->getVar("set_items");
	$pn_set_id = $this->getVar("set_id");
	$t_set = $this->getVar("set");
	$ps_label = $this->getVar("label");
	$ps_description = $this->getVar("description");
	$pn_set_item_id = $this->getVar("set_item_id");
	$o_config = $this->getVar("config");
	$va_access_values = caGetUserAccessValues();
?>
<div id="galleryDetailReactComponent"></div>
<script type="text/javascript">	
	pawtucketUIApps['gallery'] = {
        'selector': '#galleryDetailReactComponent',
        'data': {
            'sectionName': '<?php print $this->getVar("section_name"); ?>:',
            'setLabel': '<?php print $this->getVar("label"); ?>',
            'setDescription': '<?php print $this->getVar("description"); ?>',
            'set_id': '<?php print $t_set->get("ca_sets.set_id"); ?>',
            'setContents': <?php print $t_set->setContentsAsJSON($t_set->get("set_code"), array("versions" => array("large", "iconlarge"), "template" => $o_config->get("item_caption_template"), "templateDescription" => $o_config->get("item_info_template"), "checkAccess" => $va_access_values)); ?>
            
        }
    };
</script>