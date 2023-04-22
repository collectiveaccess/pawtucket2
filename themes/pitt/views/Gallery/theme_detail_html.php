<?php
	$pa_set_items = $this->getVar("set_items");
	$pn_set_id = $this->getVar("set_id");
	$ps_label = $this->getVar("label");
	$ps_description = $this->getVar("description");
	$pn_set_item_id = $this->getVar("set_item_id");

	$t_set = new ca_sets($pn_set_id);

?>

<div class='exName'><?php print $this->getVar("label"); ?></div>
<div class='container setTheme'>
	<div class='row'>
		<div class='col-sm-12'>
			<div class='setDescription'>		
<?php
			if ($vs_credits = $t_set->get('ca_sets.credits_team')) {
				print "<div class='creditsTeam'>";
				print "<h3>Credits</h3>";
				print $vs_credits;
				print "</div>";
			}
			
?>
			<br />
			<?php print $t_set->get('ca_sets.set_description') ?>		
			</div>		
		</div>	<!-- end col -->	
	</div><!-- end row -->
	<hr>
	<div class='row'>
		<div class='col-sm-8'>
			<div class='container'><div class='row'>
<?php	
		$vn_i = 1;	
		foreach ($pa_set_items as $va_key => $pa_set_item) {
			print "<div class='col-sm-4 item'>";
			print caNavLink($this->request, $pa_set_item['representation_tag_iconlarge'], '', '', 'Gallery', $pn_set_id, array('theme_item' => true, 'set_item_id' => $pa_set_item['item_id']));
			print "<div class='setItemCaption'>".caNavLink($this->request, $pa_set_item['set_item_label'], '', '', 'Gallery', $pn_set_id, array('theme_item' => true, 'set_item_id' => $pa_set_item['item_id']))."</div>";
			print "</div>";
			if ($vn_i == 3) {
				print "</div><div class='row'>";
				$vn_i = 0;
			}
			$vn_i++;
		}
?>		
			</div></div>	
		</div><!-- end col -->
		<div class='col-sm-4'>
			<div class='themes'>
				<h3>Related themes</h3>
				<div class='row'>
<?php				
				$va_theme_list = array();
				foreach ($pa_set_items as $va_key => $pa_set_item) {
					$t_set_item = new ca_set_items($pa_set_item['item_id']);
					if ($va_themes = $t_set_item->get('ca_set_items.set_item_theme', array('returnAsArray' => true))){
						foreach ($va_themes as $va_key => $va_theme) {
							if ($va_theme != 0) {
								$va_theme_list[$va_theme] = "<div class='galleryItem'>".caNavLink($this->request, caGetListItemByIDForDisplay($va_theme), '', '', 'Gallery', $pn_set_id, array('theme_id' => $va_theme))."</div>";
							}
						}
					}
				}
				foreach ($va_theme_list as $s_key => $va_theme_list_link) {
					print "<div class='col-sm-6'>".$va_theme_list_link."</div>";
				}
?>		
				</div>
			</div>
			<div class='creators'>			
				<h3>Browse Creators</h3>
				<div class='row'>
<?php				
				$va_creators_list = array();
				foreach ($pa_set_items as $va_key => $pa_set_item) {
					$t_set_item = new ca_set_items($pa_set_item['item_id']);
					$t_object = $t_set_item->getItemInstance();
					$va_creators = $t_object->get('ca_entities.entity_id', array('returnAsArray' => true, 'restrictToRelationshipTypes' => array('creator')));
					foreach ($va_creators as $va_key => $va_creator) {
						$t_entity = new ca_entities();
						$va_entity_names = $t_entity->getPreferredDisplayLabelsForIDs(array($va_creator));
						foreach ($va_entity_names as $va_entity_id => $va_entity_name) {
							$va_creators_list[$va_entity_id] = "<div class='galleryItem'>".caNavLink($this->request, $va_entity_name, '', '', 'Gallery', $pn_set_id, array('entity_id' => $va_entity_id))."</div>";
						}
					}
				}
				foreach ($va_creators_list as $v_key => $va_creators_list_link) {
					print "<div class='col-sm-6'>".$va_creators_list_link."</div>";
				}
?>			
				</div><!-- end row -->
			</div>
		</div><!-- end col -->
	</div><!-- end row -->
</div>

