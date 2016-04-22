<?php
	$pa_set_items = $this->getVar("set_items");
	$pn_set_id = $this->getVar("set_id");
	$ps_label = $this->getVar("label");
	$ps_description = $this->getVar("description");

	$t_set = new ca_sets($pn_set_id);
	
	$pn_entity_id = $this->getVar("entity_id");
	$t_entity = new ca_entities($pn_entity_id);

?>
<div class='exName'><?php print caNavLink($this->request, $t_set->get('ca_sets.preferred_labels'), '', '', 'Gallery', $t_set->get('ca_sets.set_id'), array('theme' => 1)); ?></div>
<div class='container setTheme'>
	<div class='row'>
		<div class='col-sm-5'>
			<div class='setItemDescription background'>
			<h3><?php print $t_entity->get('ca_entities.preferred_labels'); ?></h3>
<?php
			if ($va_life_dates = $t_entity->get('ca_entities.life_dates')) {
				print "<div class='unit'>".$va_life_dates."</div>";
			}			
			if ($va_nationality = $t_entity->get('ca_entities.nationalityCreator', array('delimiter' => ', '))) {
				print "<div class='unit'><h6>Nationality</h6>".$va_nationality."</div>";
			}
			if ($va_bio = $t_entity->get('ca_entities.biography')) {
				print "<div class='unit'><h6>Biography</h6>".$va_bio."</div>";
			}			
?>		
			</div>	
		</div><!-- end col -->
		<div class='col-sm-7'>	
			<h3>Related Objects</h3>
			<div class='container'><div class='row'>		
<?php		
				foreach ($pa_set_items as $va_key => $pa_set_item) {
					$t_set_item = new ca_set_items($pa_set_item['item_id']);
					$t_object = $t_set_item->getItemInstance();
					$va_set_item_entities = $t_object->get('ca_entities.entity_id', array('returnAsArray' => true));
					$vs_dont_print = true;
					foreach($va_set_item_entities as $va_key => $va_set_item_entity) {
						if ($va_set_item_entity == $pn_entity_id) { $vs_dont_print = false;}
					}
					if ($vs_dont_print == false) {
						print "<div class='col-sm-3 item'>";
						print caNavLink($this->request, $pa_set_item['representation_tag_iconlarge'], '', '', 'Gallery', $pn_set_id, array('theme_item' => true, 'set_item_id' => $pa_set_item['item_id']));
						print caNavLink($this->request, "<div class='setItemCaption'>".$pa_set_item['set_item_label']."</div>", '', '', 'Gallery', $pn_set_id, array('theme_item' => true, 'set_item_id' => $pa_set_item['item_id']));
						print "</div>";
					}
				}
?>	
			</div><!-- end row --></div><!-- end container -->		
		</div>	<!-- end col -->	
	</div><!-- end row -->
</div>

