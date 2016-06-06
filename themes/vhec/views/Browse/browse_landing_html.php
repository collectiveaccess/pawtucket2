<?php

$t_list = new ca_lists();
$va_list_items = $t_list->getItemsForList('resource_type', array('checkAccess' => $this->getVar('access_values')));
$va_subject_items = $t_list->getItemsForList('genre', array('checkAccess' => $this->getVar('access_values')));

?>
	<div id='browseTable'>
		<ul >
			<li>Browse By: </li>
			<li><a href="#typeTab">Resource Type</a></li>		
			<li><a href="#genreTab">Primary Sources</a></li>																				
		</ul>
		<div id='typeTab'>	
			<div class='container'>
		
<?php
			$vn_i = 0;
			print "<div class='row'>";
			foreach ($va_list_items as $va_key => $va_list_item_t) {
				foreach ($va_list_item_t as $va_key => $va_list_item) {
					$t_list_item = new ca_list_items($va_list_item['item_id']);
					if (($vs_title = $t_list_item->get('ca_list_items.preferred_labels')) != '-') {
						print "<div class='col-sm-3'><div class='browseChoice'>";
						print $t_list_item->get('ca_list_items.list_image', array('version' => 'iconlarge'));
						print "<div class='title'>".caNavLink($this->request, $vs_title, '', 'Browse', 'objects', 'facet/resource_type_facet/id/'.$va_list_item['item_id'])."</div>";
						print "</div></div><!-- end col -->"; 
						$vn_i++;
					}
				}
				if ($vn_i == 4) {
					print "</div><!-- end row".$vn_i." --><div class='row'>";
					$vn_i = 0;
				}
			}
			print "</div><!-- end row".$vn_i." -->";	
		?>
		
			</div><!-- end container -->	
		</div><!-- end typeTab -->	
		<div id='genreTab'>	
			<div class='container'>
		
<?php
			$vn_i = 0;
			print "<div class='row'>";
			foreach ($va_subject_items as $va_key => $va_subject_item_t) {
				foreach ($va_subject_item_t as $va_key => $va_subject_item) {
					$t_subject_item = new ca_list_items($va_subject_item['item_id']);
					if (($vs_title = $t_subject_item->get('ca_list_items.preferred_labels')) != '-') {
						print "<div class='col-sm-3'><div class='browseChoice'>";
						print $t_subject_item->get('ca_list_items.list_image', array('version' => 'iconlarge'));
						print "<div class='title'>".caNavLink($this->request, $vs_title, '', 'Browse', 'objects', 'facet/resource_type_facet/id/'.$va_subject_item['item_id'])."</div>";
						print "</div></div>"; 
						$vn_i++;
					}
					if ($vn_i == 4) {
						print "</div><!-- end row".$vn_i." --><div class='row'>";
						$vn_i = 0;
					}
				}
			}
			print "</div><!-- end row".$vn_i." -->";	
?>
		
			</div>
		</div>
	</div><!-- end browseTable -->
	
<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('#browseTable').tabs();
	});
</script>	

