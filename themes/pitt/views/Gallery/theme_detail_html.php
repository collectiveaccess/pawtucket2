<?php
	$pa_set_items = $this->getVar("set_items");
	$pn_set_id = $this->getVar("set_id");
	$ps_label = $this->getVar("label");
	$ps_description = $this->getVar("description");
	$pn_set_item_id = $this->getVar("set_item_id");

	$t_set = new ca_sets($pn_set_id);

?>

<div class='exName'><?php print $this->getVar("label")."</div>"; ?></div>
<div class='container setTheme'>
	<div class='row'>
		<div class='col-sm-7'>
			<div class='setDescription'><?php print $t_set->get('ca_sets.set_description') ?></div>
		</div><!-- end col -->
		<div class='col-sm-1'></div><!-- end col -->
		<div class='col-sm-4'>
			
<?php
			if ($vs_credits = $t_set->get('ca_sets.credits_team')) {
				print "<h3>Credits and Team</h3>";
				print $vs_credits;
			}
?>			
		</div>	<!-- end col -->	
	</div><!-- end row -->
	<div class='row'>
		<div class='col-sm-8'>
			<div class='container'><div class='row'>
<?php		
		foreach ($pa_set_items as $va_key => $pa_set_item) {
			print "<div class='col-sm-3 item'>";
			print caNavLink($this->request, $pa_set_item['representation_tag_iconlarge'], '', '', 'Gallery', $pn_set_id);
			print $pa_set_item['set_item_label'];
			print "</div>";
		}
?>		
			</div></div>	
		</div><!-- end col -->
		<div class='col-sm-4'>
			<div class='themes'>
				<h3>Related themes</h3>
<?php				
				$va_theme_list = array();
				foreach ($pa_set_items as $va_key => $pa_set_item) {
					$t_set_item = new ca_set_items($pa_set_item['item_id']);
					$va_themes = $t_set_item->get('ca_set_items.set_item_theme', array('returnAsArray' => true));
					foreach ($va_themes as $va_key => $va_theme) {
						$va_theme_list[$va_theme] = caNavLink($this->request, caGetListItemByIDForDisplay($va_theme), '', '', 'Gallery', $pn_set_id, array('theme_id' => $va_theme));
					}
				}
				print join('<br/>', $va_theme_list);
?>				
				<h3>Browse Creators</h3>
<?php				
				$va_creators_list = array();
				foreach ($pa_set_items as $va_key => $pa_set_item) {
					$t_set_item = new ca_set_items($pa_set_item['item_id']);
					#$t_object = $t_set_item->getItemInstance();
					#$va_creators = $t_object->get('ca_entities.entity_id', array('returnAsArray' => true));
					#foreach ($va_creators as $va_key => $va_creator) {
					#	$va_creators_list[] = $va_creator;
					#}
				}
				print join('<br/>', $va_creators_list);
?>			
			</div>
		</div><!-- end col -->
	</div><!-- end row -->
</div>

