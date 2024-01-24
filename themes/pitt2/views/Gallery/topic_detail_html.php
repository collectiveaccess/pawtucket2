<?php
	$pa_set_items = $this->getVar("set_items");
	$pn_set_id = $this->getVar("set_id");
	$ps_label = $this->getVar("label");
	$ps_description = $this->getVar("description");

	$t_set = new ca_sets($pn_set_id);
	
	$pn_theme_id = $this->getVar("theme_id");
	$t_list_item = new ca_list_items($pn_theme_id);

?>
<div class='exName'><?php print caNavLink($this->request, $t_set->get('ca_sets.preferred_labels'), '', '', 'Gallery', $t_set->get('ca_sets.set_id'), array('theme' => 1)).": ".$t_list_item->get('ca_list_items.preferred_labels'); ?></div>
<div class='container setTheme'>
	<div class='row'>
		<div class='col-sm-5'>
			<div class='setItemDescription background'><?php print "<h3>".$t_list_item->get('ca_list_items.preferred_labels')."</h3>".$t_list_item->get('ca_list_items.description') ?></div>
		</div><!-- end col -->
		<div class='col-sm-7'>	
			<h3>Related Objects</h3>
			<div class='container'><div class='row'>		
<?php		
				$vn_i = 1;
				foreach ($pa_set_items as $va_key => $pa_set_item) {
					$t_set_item = new ca_set_items($pa_set_item['item_id']);
					$va_set_item_themes = $t_set_item->get('ca_set_items.set_item_theme', array('returnAsArray' => true));
					$vs_dont_print = true;
					foreach($va_set_item_themes as $va_key => $va_set_item_theme) {
						if ($va_set_item_theme == $pn_theme_id) { $vs_dont_print = false;}
					}
					if ($vs_dont_print == false) {
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
				}
?>	
			</div><!-- end row --></div><!-- end container -->		
		</div>	<!-- end col -->	
	</div><!-- end row -->
	<hr>
	<div class='row'>
		<div class='col-sm-6'>
			<div class='row themes'>
			<h3>Explore More Themes</h3>
<?php
				$va_theme_list = array();
				foreach ($pa_set_items as $va_key => $pa_set_item) {
					$t_set_item = new ca_set_items($pa_set_item['item_id']);
					$va_themes = $t_set_item->get('ca_set_items.set_item_theme', array('returnAsArray' => true));
					foreach ($va_themes as $va_key => $va_theme) {
						if ($va_theme != $pn_theme_id) {
							if ($va_theme != 0) {
								$va_theme_list[$va_theme] = "<div class='col-sm-4'><div class='galleryItem'>".caNavLink($this->request, caGetListItemByIDForDisplay($va_theme), '', '', 'Gallery', $pn_set_id, array('theme_id' => $va_theme))."</div></div>";
							}
						}
					}
				}
				foreach ($va_theme_list as $v_key => $va_theme_list_link) {
					print $va_theme_list_link;
				}			
?>	
			</div><!-- end row -->	
		</div><!-- end col -->
		<div class='col-sm-6'>
		</div><!-- end col -->
	</div><!-- end row -->
</div>

